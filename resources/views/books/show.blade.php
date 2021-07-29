@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center">
        <h4>تعديل الكتاب</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="title">اسم الكتاب</label>
            <input type="text" class="form-control mt-2" name="title" value="{{ $book->title }}" readonly>
        </div>
        <div class="form-group mt-3">
            <label for="author">اسم الكاتب</label>
            <input type="text" class="form-control mt-2" name="author" value="{{ $book->author }}" readonly>
        </div>
        <div class="form-group  mt-3">
            <label for="count">عدد النسخ</label>
            <input type="number" class="form-control mt-2" name="count" value="{{ $book->count }}" readonly>
        </div>
        <div class="form-group  mt-3">
            <label for="count">عدد النسخ المتوفرة</label>
            <input type="number" class="form-control mt-2" name="count" value="{{ $book->available_count }}" readonly>
        </div>
        <div class="form-group  mt-3">
            <label for="category_id">الصنف</label>
            <input type="text" class="form-control mt-2" name="category_id" value="{{ $book->category->name }}"
                readonly>
        </div>
        <div class="form-group mt-3 text-center">
            <a href="{{ route('books.index') }}" class="btn btn-success ms-4">جميع الكتب</a>
            <a href="{{ route('books.edit',['book'=>$book->id]) }}"
                class="btn btn-info ms-4">تعديل البيانات</a>
            <div style="display: inline-block;">
                <form
                    action="{{ route('books.destroy',['book'=>$book->id]) }}"
                    method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger">حذف الكتاب</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
