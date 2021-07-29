@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center"><h4>تعديل المشترك</h4></div>
    <div class="card-body">
        <form action="{{ route('users.update',['user'=>$user->id]) }}" method="post">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <div class="form-group">
                <label for="name">اسم المستخدم</label>
                <input type="text" class="form-control mt-2" autocomplete="off"
                         name="name" value="{{$user->name}}" required>
            </div>
            <div class="form-group mt-3">
                <label for="birthdate">المواليد</label>
                <input type="date" class="form-control mt-2"
                    autocomplete="off" name="birthdate" value="{{$user->birthdate}}" required>
            </div>
            <div class="form-group  mt-3">
                <label for="study">الدراسة</label>
                <input type="text" class="form-control mt-2" 
                autocomplete="off" name="study" value="{{$user->study}}" required>
            </div>
            <div class="form-group  mt-3">
                <label for="address">العنوان</label>
                <input type="text" class="form-control mt-2"
                autocomplete="off" name="address" value="{{$user->address}}">
            </div>
            <div class="form-group  mt-3">
                <label for="mobile_1">رقم الموبايل 1</label>
                <input type="text" class="form-control mt-2" 
                autocomplete="off" name="mobile_1" value="{{$user->mobile_1}}">
            </div>
            <div class="form-group  mt-3">
                <label for="mobile_2">رقم الموبايل 2</label>
                <input type="text" class="form-control mt-2" 
                    autocomplete="off" name="mobile_2" value="{{$user->mobile_2}}">
            </div>
            <div class="form-group  mt-3">
                <label for="phone_num">رقم الأرضي</label>
                <input type="text" class="form-control mt-2" 
                autocomplete="off" name="phone_num" value="{{$user->phone_num}}">
            </div>
            <div class="form-group mt-3 text-center">
                <a href="{{route('users.show',['user'=>$user->id])}}" class="btn btn-success ms-4">رجوع</a>
                <button class="btn btn-success" type="submit">تعديل</button>
            </div>
        </form>
    </div>
</div>
@endsection
