<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Course;
use App\Models\User;
use App\Http\Traits\Validator;
use Ds\Set;

class SessionsController extends Controller
{
    use Validator;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sessions.create')->with("courses",Course::orderBy('name')->get())
                                    ->with("search_url",route('teachers.search'));
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
            'date'=>"required",
            'course_id'=>'required'
        ]);
        $error_message = $this->check_errors($request);
        if(isset($error_message)){
            Session::flash("failed",$error_message);
            $request->flash();
            return redirect()->back();
        }
        $set = new Set();
        foreach($request->users as $index=>$user_id){
            if($set->contains($user_id)){
                Session::flash('failed','يوجد تكرار في اختيار أحد المدرسين');
                return redirect()->back();
            }
            if($request->paid[$index] == null){
                Session::flash('failed','الرجاء تحديد المبلغ المدفوع لكل مدرس تم اختياره');
                return redirect()->back();
            }
            if($request->paid[$index] > config('values.max_unsigned_int')){
                Session::flash('failed','المبلغ المعطى تجاوز الحد الأعلى يرجى اختيار مبلغ أقل');
                return redirect()->back();
            }
            if($user_id != -1 && $user_id != "undefined"){
                $set->add($user_id);
            }
         }
         if($set->isEmpty()){
            Session::flash('failed','الرجاء اختيار مدرس واحد على الأقل');
            return redirect()->back();
         }
        $session = \App\Models\Session::create([
            'course_id'=>$request->course_id,
            'date' => $request->date
        ]);
        foreach($request->users as $index=>$user_id){
            if($user_id != -1 && $user_id != "undefined"){
                $session->users()->attach($user_id,['paid'=>$request->paid[$index]]);
            }
        }
        Session::flash("success","تم إنشاء الجلسة بنجاح");
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
    public function destroy($sid,$uid)
    {
        $user = User::findOrFail($uid);
        $user->sessions()->detach($sid);
        $session = \App\Models\Session::find($sid);
        if($session->users()->count() == 0){
            $session->delete();
        }
        Session::flash("success","تم حذف الجلسة بنجاح");
        return redirect()->back();
    }


    public function check_errors($request){
        if($request->course_id==-1){
            return "الرجاء اختيار مادة";
        }
        if(!$this->checkIfDate($request->date)){
            return "الرجاء إدخال تاريخ صحيح";
        }
        return null;
    }
}
