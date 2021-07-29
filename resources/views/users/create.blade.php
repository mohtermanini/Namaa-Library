@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center"><h4>إضافة مشترك</h4></div>
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="name">اسم المشترك</label>
                <input type="text"  autocomplete="off"
                    class="form-control mt-2" name="name" value="{{old('name')}}" required>
            </div>
            <div class="form-group mt-3">
                <label for="birthdate">المواليد</label>
                <input type="date" class="form-control mt-2" autocomplete="off"
                    name="birthdate" value="{{old('birthdate')}}" required>
            </div>
            <div class="form-group  mt-3">
                <label for="study">الدراسة</label>
                <input type="text" class="form-control mt-2" 
                    autocomplete="off" name="study" value="{{old('study')}}" required>
            </div>
            <div class="form-group  mt-3">
                <label for="address">العنوان</label>
                <input type="text" class="form-control mt-2" 
                        autocomplete="off" name="address" value="{{old('address')}}">
            </div>
            <div class="form-group  mt-3">
                <label for="mobile_1">رقم الموبايل 1</label>
                <input type="text" class="form-control mt-2" autocomplete="off"
                         name="mobile_1" value="{{old('mobile_1')}}">
            </div>
            <div class="form-group  mt-3">
                <label for="mobile_2">رقم الموبايل 2</label>
                <input type="text" class="form-control mt-2"  autocomplete="off"
                        name="mobile_2" value="{{old('mobile_2')}}">
            </div>
            <div class="form-group  mt-3">
                <label for="phone_num">رقم الأرضي</label>
                <input type="text" class="form-control mt-2"  autocomplete="off"
                         name="phone_num" value="{{old('phone_num')}}">
            </div>
            <div class="form-group mt-3 text-center">
                <button class="btn btn-success" type="submit">إضافة</button>
            </div>
        </form>
    </div>
</div>
@endsection
