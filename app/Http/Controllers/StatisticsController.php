<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionType;
use App\Models\Subscription;
use App\Models\Borrow;
use App\Models\Book;
use App\Models\Category;
use Config;

class StatisticsController extends Controller
{
    public function index(){
        $days_left = 3;
        return view('statistics')->with([
            'internal_subscriptions_count'=>$this->all_subscriptions('داخلي')->count(),
            'external_subscriptions_count'=>$this->all_subscriptions('خارجي')->count(),
            'homework_subscriptions_count'=>$this->all_subscriptions('مقهى الوظائف')->count(),
            'library_activities_subscriptions_count'=>$this->all_subscriptions('نشاطات المكتبة')->count(),
            'this_month_internal_subscriptions_count'=>$this->monthly_subscriptions('داخلي',today()->month)->count(),
            'this_month_external_subscriptions_count'=>$this->monthly_subscriptions('خارجي',today()->month)->count(),
            'this_month_homework_subscriptions_count'=>$this->monthly_subscriptions('مقهى الوظائف',today()->month)->count(),
            'this_month_library_activities_subscriptions_count'=>$this->monthly_subscriptions('نشاطات المكتبة',today()->month)->count(),
            'montly_total_fee_subscriptions'=>$this->montly_total_fee_subscriptions(['داخلي','خارجي','مقهى الوظائف','نشاطات المكتبة'],today()->month),
            'books_num'=>Book::count(),
            'books_num_with_copies'=>Book::sum('count'),
            'categories_num'=>Category::count(),
            'internal_borrowers_count' => count($this->borrowed_books('داخلي')),
            'external_borrowers_count' => count($this->borrowed_books('خارجي')),
            'famous_books' => $this->sorted_books_by_borrows_count(3),
            'days_left' => $days_left,
            'end_subscriptions' => $this->end_subscriptions($days_left),
            'total_mortgage_amount' => Borrow::sum('mortgage_amount'),
            'total_identity_mortgage' => Borrow::count('identity_national_num')
        ]);
    }
    public function sorted_books_by_borrows_count($limit){
        return Borrow::with('book')->selectRaw('book_id, count(book_id) as borrows_count')
                        ->groupBy('book_id')->orderBy('borrows_count','desc')->limit($limit)->get();
    }
    public function end_subscriptions($days_left){
        $subscriptions = Subscription::with('user')
                            ->where('start_date','<=',today()->toDateString())
                            ->where('end_date','>',today()->toDateString())
                            ->where('end_date','<=',today()->addDays($days_left)->toDateString())
                            ->orderBy('end_date')
                            ->paginate(Config::get('pagination_num'));
        return $subscriptions;
    }

    public function montly_total_fee_subscriptions($type_name_array,$month){
        $total = 0;
        foreach($type_name_array as $type){
            $type_id = $this->get_subscription_type_id($type);
            $total += $this->monthly_subscriptions($type,$month)->sum('fee');
        }
        return $total;
    }
    public function all_subscriptions($type_name){
        $internal_id = $this->get_subscription_type_id($type_name);
        $subscriptions = Subscription::where('type_id',$internal_id)->get();
        return $subscriptions;
    }
    public function monthly_subscriptions($type_name,$month){
        $internal_id = $this->get_subscription_type_id($type_name);
        $subscriptions = Subscription::where('type_id',$internal_id)
                            ->whereYear('start_date',today()->year)
                            ->whereMonth('start_date',$month)->get();
        return $subscriptions;
    }

    public function borrowed_books($type_name){
        $type_id =$this->get_subscription_type_id($type_name);
        $borrowed_books = Borrow::with('book','subscription.user')->where('return_date',null)
        ->whereHas('subscription',function($query) use ($type_id){
            $query->where('type_id',$type_id);
        })->orderBy('borrow_date')->paginate(Config::get('pagination_num'));
        return $borrowed_books;
    }

    public function get_subscription_type_id($type_name){
        return SubscriptionType::where('name',$type_name)->first()->id;
    }

    public function external_borrowers_index(){
        $borrowed_books = $this->borrowed_books('خارجي');
        return view('borrows.external.index')->with('borrowed_books',$borrowed_books);
    }
    public function internal_borrowers_index(){
        $borrowed_books = $this->borrowed_books('داخلي');
        return view('borrows.internal.index')->with('borrowed_books',$borrowed_books);
    }
    public function famous_books(){
        $books = $this->sorted_books_by_borrows_count(null);
        return view('books.famous')->with('famous_books',$books);
    }
    
}
