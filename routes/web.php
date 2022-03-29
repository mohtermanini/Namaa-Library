<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('users','App\Http\Controllers\UsersController');
Route::post('users/search',[
    'uses' => 'App\Http\Controllers\UsersController@users_search',
    'as' => 'users.search'
]);
Route::resource('teachers','App\Http\Controllers\TeachersController');
Route::post('teachers/search',[
    'uses' => 'App\Http\Controllers\TeachersController@teachers_search',
    'as' => 'teachers.search'
]);
Route::get('teachers/sessions/{teacher}',[
    'uses' => 'App\Http\Controllers\TeachersController@sessions',
    'as' => 'teachers.sessions'
]);

Route::resource('books','App\Http\Controllers\BooksController');
Route::post('books/search',[
    'uses' => 'App\Http\Controllers\BooksController@books_search',
    'as' => 'books.search'
]);
Route::post('author/books/search',[
    'uses' => 'App\Http\Controllers\BooksController@author_books_search',
    'as' => 'author.books.search'
]);

Route::resource('categories','App\Http\Controllers\CategoriesController');
Route::get('category/{id}/books',[
    'uses' => 'App\Http\Controllers\CategoriesController@books',
    'as' => 'category.books'
]);
Route::post('categories/search',[
    'uses' => 'App\Http\Controllers\CategoriesController@categories_search',
    'as' => 'categories.search'
]);

Route::resource('subscriptions','App\Http\Controllers\SubscriptionsController')->except(['index','create']);
Route::get('subscriptions/index/{user_id}',[
    'uses' => 'App\Http\Controllers\SubscriptionsController@index',
    'as' => 'subscriptions.index'
]);
Route::get('subscriptions/create/{id}',[
    'uses' => 'App\Http\Controllers\SubscriptionsController@create',
    'as' => 'subscriptions.create'
]);
Route::get('subscriptions/all/{user_id}',[
    'uses' => 'App\Http\Controllers\SubscriptionsController@all',
    'as' => 'subscriptions.all'
]);

Route::get('borrows/index/{user_id}',[
    'uses' => 'App\Http\Controllers\BorrowsController@index',
    'as' => 'borrows.index'
]);
Route::get('borrows/create/internal/{user_id}',[
    'uses' => 'App\Http\Controllers\BorrowsController@create_internal',
    'as' => 'borrows.create.internal'
]);
Route::get('borrows/create/external/{user_id}',[
    'uses' => 'App\Http\Controllers\BorrowsController@create_external',
    'as' => 'borrows.create.external'
]);
Route::post('borrows/store/internal',[
    'uses' => 'App\Http\Controllers\BorrowsController@store_internal',
    'as' => 'borrows.store.internal'
]);
Route::post('borrows/store/external',[
    'uses' => 'App\Http\Controllers\BorrowsController@store_external',
    'as' => 'borrows.store.external'
]);
Route::get('borrows/book/return/{borrow_id}',[
    'uses' => 'App\Http\Controllers\BorrowsController@book_return',
    'as' => 'borrows.book.return'
]);
Route::get('borrows/identity_mortgage/return/{borrow_id}',[
    'uses' => 'App\Http\Controllers\BorrowsController@identity_mortgage_return',
    'as' => 'borrows.identity_mortgage.return'
]);
Route::get('borrows/mortgage_amount/return/{borrow_id}',[
    'uses' => 'App\Http\Controllers\BorrowsController@mortgage_amount_return',
    'as' => 'borrows.mortgage_amount.return'
]);


Route::get('statistics',[
    'uses' => 'App\Http\Controllers\StatisticsController@index',
    'as' => 'statistics'
]);
Route::get('statistics/borrows/index/internal',[
    'uses' => 'App\Http\Controllers\StatisticsController@internal_borrowers_index',
    'as' => 'borrows.index.internal'
]);
Route::get('statistics/borrows/index/external',[
    'uses' => 'App\Http\Controllers\StatisticsController@external_borrowers_index',
    'as' => 'borrows.index.external'
]);
Route::get('statistics/books/famous',[
    'uses' => 'App\Http\Controllers\StatisticsController@famous_books',
    'as' => 'books.famous'
]);

Route::resource('courses','App\Http\Controllers\CoursesController');
Route::get('courses/{id}/sessions',[
    'uses' => 'App\Http\Controllers\CoursesController@sessions',
    'as' => 'courses.sessions'
]);

Route::resource('sessions','App\Http\Controllers\SessionsController')->except(['destroy']);
Route::delete('sessions/{sid}/{uid}',[
    'uses' => 'App\Http\Controllers\SessionsController@destroy',
    'as' => 'sessions.destroy'
]);

Route::get('activities/index/{title}',[
    'uses' => 'App\Http\Controllers\ActivitiesController@index',
    'as' => 'activities.index'
]);
Route::post('activities/search',[
    'uses' => 'App\Http\Controllers\ActivitiesController@users_search',
    'as' => 'activities.search'
]);

Route::get('developer/contact', function(){
    return view('contact');
})->name('contact');

Route::get('/', function () {
    return redirect()->route('statistics');
});

/*
Route::get('dbbackup',function(){
    try{
        $conn = new mysqli('localhost', 'root', '', 'basic');
        if ($conn->connect_error) {
            Session::flash('failed','لايمكن الاتصال مع قاعدة البيانات');
        }else{
            $dump = new MySQLDump($conn);
            $dump->save('D:\مكتبة نماء نسخ احتياطي.sql');
            $conn->close();
            Session::flash('success','تم نسخ البيانات بنجاح');
        }
    }catch(Exception $e){
        Session::flash('failed','لايمكن الوصول لقاعدة البيانات');
    }
    return redirect()->back();
})->name('dbbackup');

*/
