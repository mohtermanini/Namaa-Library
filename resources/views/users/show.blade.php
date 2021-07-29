@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center">
        <h4>تعديل المشترك</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="name">اسم المستخدم</label>
            <input type="text" class="form-control mt-2" name="name" value="{{ $user->name }}" readonly>
        </div>
        <div class="form-group mt-3">
            <label for="birthdate">المواليد</label>
            <input type="date" class="form-control mt-2" name="birthdate" value="{{ $user->birthdate }}" readonly>
        </div>
        <div class="form-group  mt-3">
            <label for="study">الدراسة</label>
            <input type="text" class="form-control mt-2" name="study" value="{{ $user->study }}" readonly>
        </div>
        <div class="form-group  mt-3">
            <label for="address">العنوان</label>
            <input type="text" class="form-control mt-2" name="address" value="{{ $user->address }}" readonly>
        </div>
        <div class="form-group  mt-3">
            <label for="mobile_1">رقم الموبايل 1</label>
            <input type="text" class="form-control mt-2" name="mobile_1" value="{{ $user->mobile_1 }}" readonly>
        </div>
        <div class="form-group  mt-3">
            <label for="mobile_2">رقم الموبايل 2</label>
            <input type="text" class="form-control mt-2" name="mobile_2" value="{{ $user->mobile_2 }}" readonly>
        </div>
        <div class="form-group  mt-3">
            <label for="phone_num">رقم الأرضي</label>
            <input type="text" class="form-control mt-2" name="phone_num" value="{{ $user->phone_num }}" readonly>
        </div>
        <div class="form-group mt-3 text-center">
            <a href="{{ route('subscriptions.index',['user_id'=>$user->id]) }}"
                class="btn btn-success ms-4">الاشتراكات</a>
            <a href="{{ route('borrows.index',['user_id'=>$user->id]) }}"
                class="btn btn-warning ms-4">الاستعارات</a>
            <a href="{{ route('users.edit',['user'=>$user->id]) }}"
                class="btn btn-info ms-4">تعديل البيانات</a>
            <div style="display: inline-block;">
                <form
                    action="{{ route('users.destroy',['user'=>$user->id]) }}"
                    method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger">حذف المشترك</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
