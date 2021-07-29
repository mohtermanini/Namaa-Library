<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Http\Traits\Validator;
use Session;
use Config;


class UsersController extends Controller
{
    use Validator;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->user_name_search){
            if(request()->user_id != -1){
            $users = User::where('id',request()->user_id)
            ->orderBy('name')->paginate(Config::get('pagination_num'));
            }else{
                $users = User::where('name','like','%'.request()->user_name_search.'%')
                ->orderBy('name')->paginate(Config::get('pagination_num'));
            }
        }else{
            $users = User::orderBy('name')->paginate(Config::get('pagination_num'));
        }
        return view('users.index')->with("users",$users)->with("search_url",route('users.search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'name'=>"required",
            'birthdate' => "required",
            'study'=>'required'
        ]);
        $error_message = $this->check_errors($request);
        if(isset($error_message)){
            Session::flash("failed",$error_message);
            $request->flash();
            return redirect()->back();
        }
        User::create([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'study' => $request->study,
            'address' => $request->address,
            'mobile_1' => $request->mobile_1,
            'mobile_2' => $request->mobile_2,
            'phone_num' => $request->phone_num
        ]);
        Session::flash("success","تم إضافة المشترك بنجاح");
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('users.show')->with("user",User::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users.edit')->with("user",User::findOrFail($id));
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
        $this->validate($request,[
            'name'=>"required",
            'birthdate' => "required",
            'study'=>'required'
        ]);
        $error_message = $this->check_errors($request);
        if(isset($error_message)){
            Session::flash("failed",$error_message);
            $request->flash();
            return redirect()->back();
        }
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->birthdate = $request->birthdate;
        $user->study = $request->study;
        $user->address = $request->address;
        $user->mobile_1 = $request->mobile_1;
        $user->mobile_2 = $request->mobile_2;
        $user->phone_num = $request->phone_num;

        $user->save();
        Session::flash("success","تم تعديل المشترك بنجاح");
        return redirect()->route('users.show',['user'=>$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscriptions = Subscription::where("user_id",$id)->whereHas("books",function($query){
            $query->where("return_date",null);
        })->get();
        if($subscriptions->count() > 0){
            Session::flash('failed','يجب إرجاع كل الكتب المستعارة من هذا المستخدم أولاً');
            return redirect()->back();
        }
        $user = User::findOrFail($id);
        $user->subscriptions()->delete();
        $user->delete();
        Session::flash("success","تم حذف المشترك بنجاح");
        return redirect()->route('users.index');
    }

    public function users_search(Request $request){
        return User::where('name','like',"%{$request->name}%")->limit(Config::get("max_search_items"))
        ->get(['name as label','id as value']);
    }

    public function check_errors($request){
        if(mb_strlen($request->name) > config("values.max_string_len")){
            return "الرجاء اختيار اسم مشترك أقصر";
        }
        if(!$this->checkIfDate($request->birthdate)){
            return "الرجاء إدخال تاريخ ميلاد صحيح";
        }
        if(isset($request->study) && mb_strlen($request->study) > config("values.max_string_len")){
            return "الرجاء اختيار اسم دراسة أقصر";
        }
        if(isset($request->address) && mb_strlen($request->address) > config("values.max_string_len")){
            return "الرجاء اختيار عنوان أقصر";
        }
        if(isset($request->mobile_1) && (mb_strlen($request->mobile_1) > config("values.max_string_len")) ){
            return "الرجاء اختيار رقم موبايل أقصر";
        }
        if(isset($request->mobile_2) && (mb_strlen($request->mobile_2) > config("values.max_string_len")) ){
            return "الرجاء اختيار رقم موبايل أقصر";
        }
        if(isset($request->phone_num) && (mb_strlen($request->phone_num) > config("values.max_string_len")) ){
            return "الرجاء اختيار رقم أرضي أقصر";
        }
    }
    
}
