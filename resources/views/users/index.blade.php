@extends('layouts.app')

@section('content')
<a href="{{ route('users.create') }}" class="btn btn-success">إضافة مستخدم</a>

<div class="row mt-3">
    <div class="col-4">
        <form action="{{ route('users.index') }}" method="GET">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" id="searchBox" placeholder="اسم المستخدم..."
                        autocomplete="off" name="user_name_search" required>
                    <input type="hidden" value="-1" id="search_value" name="user_id">
                </div>
                <div class="col-2">
                    <button class="btn btn-success">بحث</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col me-2">
        <a href="{{ route('users.index') }}" class="btn btn-success">كل المستخدمين</a>
    </div>
</div>

<table class="table table-bordered table-hover text-center mt-3">
    <thead>
        <tr>
            <th>اسم المستخدم</th>
            <th>رقم الموبايل 1</th>
            <th>رقم الموبايل 2</th>
            <th>رقم الأرضي</th>
            <th>الاشتراكات</th>
            <th>استعارة</th>
            <th>تعديل</th>
            <th>حذف</th>
        </tr>
    </thead>
    <tbody>
        @if($users->count() > 0)
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->mobile_1==null?'لايوجد':$user->mobile_1 }}</td>
                    <td>{{ $user->mobile_2==null?'لايوجد':$user->mobile_2 }}</td>
                    <td>{{ $user->phone_num==null?'لايوجد':$user->phone_num }}</td>
                    <td>
                        <a href="{{ route('subscriptions.index',['user_id'=>$user->id]) }}"
                            class="btn btn-info">الاشتراكات</a>
                    </td>
                    <td>
                        <a href="{{ route('borrows.index',['user_id'=>$user->id]) }}"
                            class="btn btn-warning">استعارة</a>
                    </td>
                    <td><a href="{{ route('users.show',['user'=>$user->id]) }}"
                            class="btn btn-info">تعديل</a></td>
                    <td>
                        <a delete_link="{{ route('users.destroy',['user'=>$user->id]) }}"
                            class="btn btn-danger modalToggle">حذف</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8">
                    <p class="fw-bold">لايوجد مستخدمين بعد</p>
                </td>
            </tr>
        @endif
    </tbody>
</table>
<div class="d-flex justify-content-center mt-4">
    {{ $users->links() }}
</div>
@include('includes.modal')
@endsection
@section('scripts')
    @include('includes.search')
    @include('includes.modal_script')
@endsection
