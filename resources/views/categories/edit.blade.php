@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center"><h4>تعديل الصنف</h4></div>
    <div class="card-body">
        <form action="{{ route('categories.update',['category'=>$category->id]) }}" method="post">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <div class="form-group">
                <label for="name">اسم الصنف</label>
                <input type="text" class="form-control mt-2" 
                    autocomplete="off" name="name" value="{{$category->name}}" required>
            </div>
            <div class="form-group mt-3 text-center">
                <a href="{{route('categories.index')}}" class="btn btn-success ms-4">رجوع</a>
                <button class="btn btn-success" type="submit">تعديل</button>
            </div>
        </form>
    </div>
</div>
@endsection
