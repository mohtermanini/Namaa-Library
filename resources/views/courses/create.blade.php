@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center"><h4>إضافة مادة</h4></div>
    <div class="card-body">
        <form action="{{ route('courses.store') }}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="name">اسم المادة</label>
                <input type="text" class="form-control mt-2" 
                autocomplete="off" name="name" value="{{old('name')}}" required>
            </div>
            <div class="form-group mt-3 text-center">
                <a href="{{route('courses.index')}}" class="btn btn-success ms-4">رجوع</a>
                <button class="btn btn-success" type="submit">إضافة</button>
            </div>
        </form>
    </div>
</div>
@endsection
