<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionType;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Borrow;
use Session;
use Config;
use Carbon\Carbon;
use App\Http\Traits\Validator;

class SubscriptionsController extends Controller
{
    use Validator;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $current_subscriptions = Subscription::with('type')->where('user_id',$user_id)
                                    ->where(function($query){
                                        $query->whereDate('end_date','>',Carbon::today())
                                        ->orWhere("end_date",null);
                                    })->orderBy('start_date','desc')->orderBy('id','desc')->paginate(Config::get('pagination_num'));
        return view('users.subscriptions.index')->with('user',User::findOrFail($user_id))
                                                ->with('subscriptions',$current_subscriptions)
                                                ->with('all_or_current','الاشتراكات الحالية');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        return view("users.subscriptions.create")
                ->with("subscription_types",SubscriptionType::where('name','!=','مدرس')->get())
                ->with("user",User::findOrFail($user_id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'start_date'=>"required",
            'duration' => "required",
            'fee'=>'required',
            'type_id'=>'required',
            'user_id' => 'required'
        ]);
        $error_message = $this->check_errors($request);
        if(isset($error_message)){
            Session::flash("failed",$error_message);
            $request->flash();
            return redirect()->back();
        }
        $s1 = $request->start_date;
        $e1 = Carbon::parse($request->start_date)->addDays($request->duration);
        $overlap_subscriptions = Subscription::where('type_id',$request->type_id)
        ->where('user_id',$request->user_id)
        ->where(function($query) use ($s1,$e1){
            $query->where(function($query) use ($s1){$query->where('start_date','<=',$s1)->where('end_date','>',$s1);})
            ->orWhere(function($query) use ($e1){$query->where('start_date','<',$e1)->where('end_date','>=',$e1);})
            ->orWhere(function($query) use ($s1,$e1){$query->where('start_date','>=',$s1)->where('end_date','<=',$e1);});
        })->get();
        if($overlap_subscriptions->count() > 0){
            Session::flash('failed','يوجد تداخل بين تواريخ بداية ونهاية هذا الاشتراك واشتراك آخر من نفس النوع');
            return redirect()->back();
        }
        Subscription::create([
            'start_date' => $s1,
            'end_date' => $e1,
            'fee' => $request->fee,
            'type_id' => $request->type_id,
            'user_id' => $request->user_id
        ]);
        Session::flash("success","تم إضافة الاشتراك بنجاح");
        return redirect()->route('subscriptions.index',['user_id'=>$request->user_id]);
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
        $subscription = Subscription::findOrFail($id);
        if(Borrow::where('subscription_id',$id)->where('return_date',null)->get()->count() > 0){
            Session::flash('failed','يجب إرجاع جميع الكتب التي تمت عن طريق هذا الاشتراك أولاً');
        }
        else{
            $subscription->delete();
            Session::flash("success","تم حذف الاشتراك بنجاح");
        }
        return redirect()->back();
    }
    public function all($user_id){
        $subscriptions = Subscription::with('type')->where("user_id",$user_id)
                                        ->orderBy('start_date','desc')
                                        ->orderBy('id','desc')
                                        ->paginate(Config::get('pagination_num'));
        return view('users.subscriptions.index')->with('user',User::findOrFail($user_id))
                                                ->with('subscriptions',$subscriptions)
                                                ->with('all_or_current','كل الاشتراكات');
    }

    public function check_errors($request){
        if(!$this->checkIfDate($request->start_date)){
            return "الرجاء إدخال تاريخ صحيح";
        }
        if($request->fee > config("values.max_unsigned_int")){
            return "الرسوم تجاوزت الحد الأعلى يرجى اختيار رسوم أقل";
        }
        if(Carbon::parse($request->start_date)->addDays($request->duration)->year > 9999){
            return "الرجاء اختيار مدة أقصر";
        }
        if($request->type_id == -1){
            return "يرجى اختيار نوع اشتراك";
        }
        return null;
    }
    
}
