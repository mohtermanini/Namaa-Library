@extends('layouts.app')

@section('content')
    <a href="{{ route('users.create') }}" class="btn btn-success">إضافة مستخدم</a>

    <div class="row mt-3">
        <div class="d-flex col flex-wrap gap-3 align-items-start">
            <form action="{{ route('users.index') }}" method="GET" class="d-flex gap-3 flex-wrap">
                <input type="text" class="form-control w-auto" id="searchBox" placeholder="اسم المستخدم..."
                    autocomplete="off" name="user_name_search" required>
                <input type="hidden" value="-1" id="search_value" name="user_id">
                <button class="btn btn-success">بحث</button>
            </form>
            <a href="{{ route('users.index') }}" class="btn btn-success">كل المستخدمين</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center mt-3">
            <thead>
                <tr>
                    <th>
                        <a class="text-decoration-none text-dark" href="{{ route('users.index', 
                            array_merge(request()->query(), 
                            ["order_col" => "name", "order_type" => $order_type])
                        )}}">
                            اسم المستخدم
                            @include("includes.icons.sorting_icon", ["current_col" => "name"])
                        </a>
                    </th>
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
                @if ($sorted_users->count() > 0)
                    @foreach ($sorted_users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->mobile_1 == null ? 'لايوجد' : $user->mobile_1 }}</td>
                            <td>{{ $user->mobile_2 == null ? 'لايوجد' : $user->mobile_2 }}</td>
                            <td>{{ $user->phone_num == null ? 'لايوجد' : $user->phone_num }}</td>
                            <td>
                                <a href="{{ route('subscriptions.index', ['user_id' => $user->id]) }}"
                                    class="btn btn-info">الاشتراكات</a>
                            </td>
                            <td>
                                <a href="{{ route('borrows.index', ['user_id' => $user->id]) }}"
                                    class="btn btn-warning">استعارة</a>
                            </td>
                            <td><a href="{{ route('users.show', ['user' => $user->id]) }}" class="btn btn-info">تعديل</a></td>
                            <td>
                                <a delete_link="{{ route('users.destroy', ['user' => $user->id]) }}"
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
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
    @include('includes.modal')
@endsection
@section('scripts')
    @include('includes.search')
    @include('includes.modal_script')
@endsection
