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
                <th>
                    <a class="text-decoration-none text-dark" href="{{ route('users.index', 
                        array_merge(request()->query(), 
                        ["order_col" => "name", "order_type" => $order_type])
                    )}}">
                        اسم المستخدم
                        @if ($order_col === "name")
                            @if ($order_type === "desc")
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
                                    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
                                    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zm-8.46-.5a.5.5 0 0 1-1 0V3.707L2.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L4.5 3.707V13.5z"/>
                                </svg>
                            @endif
                        @endif
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
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
    @include('includes.modal')
@endsection
@section('scripts')
    @include('includes.search')
    @include('includes.modal_script')
@endsection
