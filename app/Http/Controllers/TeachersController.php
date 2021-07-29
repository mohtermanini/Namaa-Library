<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\User;
use App\Http\Traits\Validator;
use Config;
use Session;

class TeachersController extends Controller
{
    use Validator;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscription_type = $this->getTeacherSubscriptionType()->id;
        $teachers = User::whereHas('subscriptions',function($query) use ($subscription_type){
            $query->where("type_id",$subscription_type)->where('end_date',null);
        })->orderBy('name');
        if(request()->teacher_name_search){
            if(request()->teacher_id != -1){
            $teachers = $teachers->where('id',request()->teacher_id);
            }else{
            $teachers = $teachers->where('name','like','%'.request()->teacher_name_search.'%');
            }
        }
        $teachers = $teachers->paginate(Config::get('pagination_num'));
        return view('teachers.index')->with("teachers",$teachers)->with("search_url",route('teachers.search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = $this->getTeacherSubscriptionType()->name;
        return view('teachers.create')->with('type',$type)->with("search_url",route('users.search'));
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
            "start_date"=>"required"
        ]);
        if($request->user_id == -1 || $request->user_id == null){
            Session::flash("failed","الرجاء اختيار مستخدم من القائمة في حقل اسم المدرس");
            return redirect()->back();
        }
        if(!$this->checkIfDate($request->start_date)){
            Session::flash("failed","الرجاء إدخال تاريخ صحيح");
            return redirect()->back();
        }
        $type_id = $this->getTeacherSubscriptionType()->id;
        if(Subscription::where('user_id',$request->user_id)
        ->where('type_id',$type_id)->where("end_date",null)->first() != null){
            Session::flash('failed','المستخدم هو مدرس حالياً');
            return redirect()->back();
        }
        Subscription::create([
            'start_date'=>$request->start_date,
            'user_id' => $request->user_id,
            'type_id' => $type_id
        ]);
        Session::flash("success","تم إضافة المدرس بنجاح");
        return redirect()->route('teachers.index');
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
        $user = User::findOrFail($id);
        if($user->sessions()->count() > 0){
            Session::flash("failed","الرجاء حذف جميع الجلسات المرتبطة بهذا المدرس أولاً");
            return redirect()->back();
        }
        $subscription_type = $this->getTeacherSubscriptionType()->id;
        $subscription = Subscription::where("user_id",$id)->where("type_id",$subscription_type)
                ->where("end_date",null)->first();
        $subscription->end_date = today()->toDateString();
        $subscription->save();
        Session::flash("success","تم حذف المدرس بنجاح");
        return redirect()->back();
    }
    public function teachers_search(Request $request){
        $subscription_type = $this->getTeacherSubscriptionType()->id;
        return User::whereHas('subscriptions',function($query) use ($subscription_type){
            $query->where("type_id",$subscription_type)->where('end_date',null);
        })->where('name','like',"%{$request->name}%")->limit(Config::get("max_search_items"))
        ->get(['name as label','id as value']);
    }

    public function sessions($user_id){
        $sessions = \App\Models\Session::with(['course','users'=>function($query) use ($user_id){
            $query->where('users.id',$user_id);
        }])->whereHas('users',function($query) use ($user_id){
            $query->where('users.id',$user_id);
        })->orderBy("date","desc")->paginate(Config::get("pagination_num"));
        return view('teachers.sessions')->with('teacher',User::findOrFail($user_id))
                    ->with("sessions",$sessions);
    }
    public function getTeacherSubscriptionType(){
        return SubscriptionType::where('name','مدرس')->first();
    }
}
