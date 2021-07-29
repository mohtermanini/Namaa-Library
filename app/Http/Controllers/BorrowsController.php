<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\Book;
use Session;
use Ds\Map;
use App\Models\Borrow;
use Config;

class BorrowsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::findOrFail($user_id);
        $borrows = Borrow::with('subscription.type','book')->
                        whereHas('subscription',function($query) use ($user_id){$query->where('user_id',$user_id);})
                        ->orderByRaw('case 
                        when return_date is not null then 1
                        else 0 end')
                        ->orderBy('borrow_date','desc')->paginate(Config::get("pagination_num"));
        return view('users.borrows.index')->with('user',$user)
                                            ->with('borrows',$borrows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_internal($user_id)
    {   
        $subscription = $this->getUserCurrentSubscriptions($user_id,'داخلي');
        if($subscription->count() == 0){
            Session::flash('failed','المستخدم غير مشترك داخلياً');
            return redirect()->back();
        }
        return view('users.borrows.internal.create')->with('subscription',$subscription[0])
                                                ->with('books',Book::orderBy('title')->get())
                                                ->with('user_id',$user_id)
                                                ->with("search_url",route('books.search'));
    }

    public function create_external($user_id)
    {   
        $subscription = $this->getUserCurrentSubscriptions($user_id,'خارجي');
        if($subscription->count() == 0){
            Session::flash('failed','المستخدم غير مشترك خارجياً');
            return redirect()->back();
        }
        return view('users.borrows.external.create')->with('subscription',$subscription[0])
                                                ->with('books',Book::orderBy('title')->get())
                                                ->with('user_id',$user_id)
                                                ->with("search_url",route('books.search'));
    }

    public function getUserCurrentSubscriptions($user_id,$type_name){
        User::findOrFail($user_id);
        $subscription_type = SubscriptionType::where('name',$type_name)->first()->id;
        $subscription = Subscription::where('user_id',$user_id)
                                    ->where('type_id',$subscription_type)
                                    ->where('start_date','<=',today()->toDateString())
                                    ->where('end_date','>',today()->toDateString())->get();
        return $subscription;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store_internal(Request $request)
    {
        $this->validate($request,[
            'subscription_id'=>"required",
            'borrow_date' => "required",
        ]);
        $flag = false;
        $map = new Map();
        foreach($request->books as $book_id){
            if($book_id != -1 && $book_id != "undefined"){
                $map->put($book_id,$map->get($book_id,0) + 1);
                $flag = true;
            }
        }
        if(!$flag){
            Session::flash('failed','الرجاء اختيار كتاب واحد على الأقل');
            return redirect()->back();
        }
        if(!$this->check_books_available($map)){
            return redirect()->back();
        }
       $this->decrease_books_available_count($map);
        foreach($request->books as $book_id){
            if($book_id != -1 && $book_id != "undefined"){
                Borrow::create([
                    'subscription_id' => $request->subscription_id,
                    'borrow_date' => $request->borrow_date,
                    'book_id'=> $book_id
                ]);
            }
        }
        Session::flash('success','تم إضافة الاستعارة بنجاح');
        return redirect()->route('borrows.index',['user_id'=>$request->user_id]);
        
    }

    public function store_external(Request $request)
    {
        $this->validate($request,[
            'subscription_id'=>"required",
            'borrow_date' => "required",
        ]);
        $error_message = $this->check_errors_external($request);
        if(isset($error_message)){
            Session::flash("failed",$error_message);
            $request->flash();
            return redirect()->back();
        }
        $books_filtered = array();
        $map = new Map();
        foreach($request->books as $index => $book_id){
            if($book_id != -1 && $book_id != "undefined"){
                $map->put($book_id,$map->get($book_id,0) + 1);
                $books_filtered[$index] = $book_id;
            }
        }
        if(empty($books_filtered)){
            Session::flash('failed','الرجاء اختيار كتاب واحد على الأقل');
            return redirect()->back();
        }
        if(!$this->check_books_available($map)){
            return redirect()->back();
        }
       $this->decrease_books_available_count($map);
        foreach($books_filtered as $index => $book_id){
            Borrow::create([
                'subscription_id' => $request->subscription_id,
                'borrow_date' => $request->borrow_date,
                'book_id'=> $book_id,
                'identity_national_num' => $request->identity_national_num[$index],
                'mortgage_amount' => $request->mortgage_amount[$index]
            ]);
        }
        Session::flash('success','تم إضافة الاستعارة بنجاح');
        return redirect()->route('borrows.index',['user_id'=>$request->user_id]);
    }

    public function check_books_available(Map $map){
        foreach($map as $key=>$value){
            $book = Book::find($key);
            if($book->available_count < $value){
                Session::flash('failed','لايتوافر هذا العدد من النسخ للكتاب '.$book->title);
                return false;
            }
        }
        return true;
    }
    public function decrease_books_available_count(Map $map){
        foreach($map as $key=>$value){
            $book = Book::find($key);
            $book->available_count -= $value;
            $book->save();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function book_return($borrow_id){
        $book_borrowed = Borrow::with('book')->find($borrow_id);
        if($book_borrowed->identity_national_num != null){
            Session::flash('failed','يجب تسليم الهوية أولاً');
            return redirect()->back();
        }

        if($book_borrowed->mortgage_amount > 0){
            Session::flash('failed','يجب إرجاع المبلغ المرهون أولاً');
            return redirect()->back();
        }
        $book_borrowed->return_date = today()->toDateString();
        $book_borrowed->book->available_count++;
        $book_borrowed->save();
        $book_borrowed->book->save();
        Session::flash('success','تم إرجاع الكتاب بنجاح');
        return redirect()->back();
    }
    public function identity_mortgage_return($borrow_id){
        $book_borrowed = Borrow::with('book')->find($borrow_id);
        $book_borrowed->identity_national_num = null;
        $book_borrowed->save();
        Session::flash('success','تم إرجاع الهوية بنجاح');
        return redirect()->back();
    }
    public function mortgage_amount_return($borrow_id){
        $book_borrowed = Borrow::with('book')->find($borrow_id);
        $book_borrowed->mortgage_amount = 0;
        $book_borrowed->save();
        Session::flash('success','تم إرجاع المبلغ بنجاح');
        return redirect()->back();
    }

    public function check_errors_external($request){
        foreach($request->mortgage_amount as $amount){
            if($amount > config("values.max_unsigned_int")){
                return "المبلغ المرهون تجاوز الحد الأعلى يرجى اختيار مبلغ أقل";
            }
        }
        foreach($request->identity_national_num as $num){
            if(mb_strlen($num) > config("values.max_string_len")){
                return "يرجى التأكد من طول الرقم الوطني";
            }
        }
        return null;
    }

}
