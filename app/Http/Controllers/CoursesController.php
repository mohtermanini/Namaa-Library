<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Session;
use Config;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('courses.index')->with('courses',Course::orderBy('name')
         ->paginate(Config::get('pagination_num')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
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
            'name'=>"required"
        ]);
        $error_message = $this->check_errors($request);
        if(isset($error_message)){
            Session::flash("failed",$error_message);
            $request->flash();
            return redirect()->back();
        }
        Course::create([
            'name' => $request->name
        ]);
        Session::flash("success","تم إنشاء المادة بنجاح");
        return redirect()->route('courses.index');
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
        return view('courses.edit')->with("course",Course::findOrFail($id));
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
            'name'=>"required"
        ]);
        $error_message = $this->check_errors($request);
        if(isset($error_message)){
            Session::flash("failed",$error_message);
            $request->flash();
            return redirect()->back();
        }
        $course = Course::findOrFail($id);
        $course->name = $request->name;
        $course->save();
        Session::flash("success","تم تعديل المادة بنجاح");
        return redirect()->route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if($course->sessions()->count() > 0){
            Session::flash("failed","لايمكن حذف المادة بسبب وجود جلسات مرتبطة بها");
        }
        else{
            $course->delete();
            Session::flash("success","تم حذف المادة بنجاح");
        }
        return redirect()->route('courses.index');
    }

    public function sessions($id){
        $course = Course::with(['sessions' =>function($query){
            $query->orderBy("date",'desc');
        }])->findOrFail($id) ;
        return view('courses.sessions')->with("course",$course);
    }

    public function check_errors($request){
        if(mb_strlen($request->name) > config("values.max_string_len")){
            return "الرجاء اختيار اسم أقصر";
        }
        return null;
    }
}
