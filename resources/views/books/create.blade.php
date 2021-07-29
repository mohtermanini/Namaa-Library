@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center">
        <h4>إضافة كتاب</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('books.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title">اسم الكتاب</label>
                <input type="text" class="form-control mt-2" name="title" value="{{ old('title') }}"
                autocomplete="off" required>
            </div>
            <div class="form-group mt-3">
                <label for="author">اسم الكاتب</label>
                <input type="text" class="form-control mt-2" name="author" value="{{ old('author') }}"
                    autocomplete="off" required>
            </div>
            <div class="form-group  mt-3">
                <label for="count">عدد النسخ</label>
                <input type="number" class="form-control mt-2" name="count" value="{{ old('count') }}"
                    autocomplete="off" min="1" required>
            </div>
            <div class="form-group  mt-3">
                <label for="category_id">الصنف</label>
                <select name="category_id" id="category_id" class="form-control mt-2" required>
                    <option value="-1">اختيار صنف...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                        @if($category->id == old('category_id'))
                        selected
                        @endif
                    >{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mt-3 text-center">
                <a href="{{ route('books.index') }}" class="btn btn-success ms-4">رجوع</a>
                <button class="btn btn-success" type="submit">إضافة</button>
            </div>
        </form>
    </div>

 

</div>
@endsection
