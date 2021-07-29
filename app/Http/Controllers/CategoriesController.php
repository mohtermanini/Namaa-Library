<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;
use Session;
use Config;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->category_name_search){
            if(request()->category_id != -1){
                $categories = Category::where('id',request()->category_id)
                            ->orderBy("name")->paginate(Config::get('pagination_num'));
            }else{
                $categories = Category::where('name','like','%'.request()->category_name_search.'%')
                ->orderBy("name")->paginate(Config::get('pagination_num'));
            }
        }else{
            $categories = Category::orderBy('name')->paginate(Config::get('pagination_num'));
        }
        return view('categories.index')->with('categories',$categories)
                                        ->with("search_url",route('categories.search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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

        Category::create([
            'name' => $request->name
        ]);
        Session::flash("success","تم إنشاء الصنف بنجاح");
        return redirect()->route('categories.index');
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
        return view('categories.edit')->with("category",Category::findOrFail($id));
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
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        Session::flash("success","تم تعديل الصنف بنجاح");
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if($category->books()->count() > 0){
            Session::flash("failed","يجب حذف كل الكتب المرتبطة بهذا الصنف أولاً");
        }
        else{
            $category->delete();
            Session::flash("success","تم حذف الصنف بنجاح");
        }
        return redirect()->route('categories.index');
    }

    public function books($id){
        $books = Book::where('category_id',$id)->paginate(Config::get('pagination_num'));
        $books_count = 0;
        foreach($books as $book){
            $books_count += $book->count;
        }
        return view('categories.books')->with("category",Category::findOrFail($id))
                                        ->with("books",$books)
                                        ->with("books_count",$books_count);
    }
    public function categories_search(Request $request){
        return Category::where('name','like',"%{$request->name}%")
            ->limit(Config::get("max_search_items"))
            ->get(['name as label','id as value']);
    }

    public function check_errors($request){
        if(mb_strlen($request->name) > config('values.max_string_len')){
            return "الرجاء اختيار اسم صنف أقصر";
        }
        return null;
    }

}
