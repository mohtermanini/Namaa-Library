<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Session;
use Config;


class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->book_name_search){
            if(request()->book_id != -1){
            $books = Book::where('id',request()->book_id)
            ->orderBy('title')->paginate(Config::get('pagination_num'));
            }else{
                $books = Book::where('title','like','%'.request()->book_name_search.'%')
                ->orderBy('title')->paginate(Config::get('pagination_num'));
            }
        }
        elseif(request()->author_name_search){
            if(request()->author != -1){
                $books = Book::where('author',request()->author)
                ->orderBy('author')->paginate(Config::get('pagination_num'));
            }else{
                $books = Book::where('author','like','%'.request()->author_name_search.'%')
                ->orderBy('author')->paginate(Config::get('pagination_num'));
            }
        }else{
            $books = Book::with('category')->orderBy('title')
                            ->paginate(Config::get('pagination_num'));
        }
        return view('books.index')->with("books",$books)
                                ->with("search_url",route('books.search'))
                                ->with("author_search_url",route('author.books.search'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create')->with("categories",Category::all());
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
            'title'=>"required",
            'author' => "required",
            'count'=>'required|numeric|min:1',
            'category_id'=>'required'
        ]);
        $error_message = $this->check_errors($request);
        if(isset($error_message)){
            Session::flash("failed",$error_message);
            $request->flash();
            return redirect()->back();
        }
        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'count' => $request->count,
            'available_count'=>$request->count,
            'category_id' => $request->category_id
        ]);
        Session::flash("success","تم إنشاء الكتاب بنجاح");
        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('books.show')->with("book",Book::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('books.edit')->with("book",Book::findOrFail($id))->with("categories",Category::all());
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
            'title'=>"required",
            'author' => "required",
            'count'=>'required|numeric|min:1',
            'category_id'=>'required'
        ]);
        $error_message = $this->check_errors($request);
        if(isset($error_message)){
            Session::flash("failed",$error_message);
            $request->flash();
            return redirect()->back();
        }
        $book = Book::findOrFail($id);
        $count_difference = $request->count - $book->count;
        $new_available_count = $book->available_count + $count_difference;
        if($new_available_count < 0){
            Session::flash('failed','يجب إرجاع '. -$new_available_count. " نسخة من هذا الكتاب قبل إنقاص عدد النسخ بهذه الكمية");
            return redirect()->back();
        }
        $book->title = $request->title;
        $book->author = $request->author;
        $book->count = $request->count;
        $book->available_count = $new_available_count;
        $book->category_id = $request->category_id;
        $book->save();
        Session::flash("success","تم تعديل الكتاب بنجاح");
        return view('books.show')->with("book",$book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if($book->available_count < $book->count){
            Session::flash("failed","يجب إرجاع كل نسخ الكتاب أولاً");
            return redirect()->back();
        }
        $book->delete();
        Session::flash("success","تم حذف الكتاب بنجاح");
        return redirect()->route('books.index');
    }
    
    public function books_search(Request $request){
        $data = Book::where('title','like',"%{$request->name}%")->limit(Config::get("max_search_items"))
        ->selectRaw("id as value, CONCAT(title,' (',author,')') as label")
        ->get();
        return $data;
    }
    public function author_books_search(Request $request){
        $data = Book::where('author','like',"%{$request->name}%")->distinct()
        ->limit(Config::get("max_search_items"))
        ->get(['author as label','author as value']);
        return $data;
    }


    public function check_errors($request){
        if(mb_strlen($request->title) > config('values.max_string_len')){
            return "الرجاء اختيار اسم كتاب أقصر";
        }
        if(mb_strlen($request->author) > config('values.max_string_len')){
            return "الرجاء اختيار اسم كاتب أقصر";
        }
        if($request->count > config('values.max_unsigned_int')){
            return "تجاوز عدد النسخ الحد الأعلى يرجى اختيار عدد أقل";
        }
        if($request->category_id==-1){
            return "الرجاء اختيار صنف";
        }
        return null;
    }
}
