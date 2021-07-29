@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center"><h4>تعديل الكتاب</h4></div>
    <div class="card-body">
        <form action="{{ route('books.update',['book'=>$book->id]) }}" method="post">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <div class="form-group">
                <label for="title">اسم الكتاب</label>
                <input type="text" class="form-control mt-2" 
                 autocomplete="off" name="title" value="{{$book->title}}" required>
            </div>
            <div class="form-group mt-3">
                <label for="author">اسم الكاتب</label>
                <input type="text" class="form-control mt-2" 
                autocomplete="off" name="author" value="{{$book->author}}" required>
            </div>
            <div class="form-group  mt-3">
                <label for="count">عدد النسخ</label>
                <input type="number" class="form-control mt-2" 
                autocomplete="off" name="count" value="{{$book->count}}" min="1" required>
            </div>
            <div class="form-group  mt-3">
                <label for="available_count">عدد النسخ المتوفرة</label>
                <input type="number" class="form-control mt-2" name="available_count" value="{{ $book->available_count }}" readonly>
            </div>
            <div class="form-group  mt-3">
                <label for="category_id">الصنف</label>
                <select name="category_id" id="category_id" class="form-control mt-2">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}"
                            @if($category->id == $book->category_id)
                                selected
                            @endif
                            >{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mt-3 text-center">
                <a href="{{ route('books.show',['book'=>$book->id]) }}" class="btn btn-success ms-4">رجوع</a>
                <button class="btn btn-success" type="submit">تعديل</button>
            </div>
        </form>
    </div>
</div>
@endsection
