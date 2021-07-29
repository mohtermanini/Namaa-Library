@extends('layouts.app')

@section('content')
<a href="{{ route('subscriptions.index',['user_id'=>$user->id]) }}"
    class="btn btn-success ms-4">الاشتراكات</a>
<div class="row mt-1 text-center">
    <div class="col">
        <a href="{{ route('borrows.create.internal',['user_id'=>$user->id]) }}"
            class="btn btn-primary ms-3">إضافة استعارة داخلية</a>
        <a href="{{ route('borrows.create.external',['user_id'=>$user->id]) }}"
            class="btn btn-primary">إضافة استعارة خارجية</a>
    </div>
</div>
<table class="table table-bordered table-hover text-center mt-2 ">
    <thead>
        <tr>
            <th colspan="7">
                <p class="h4">{{ $user->name }}</p>
            </th>
        </tr>
        <tr>
            <th>نوع الاستعارة</th>
            <th>اسم الكتاب</th>
            <th>تاريخ الاستعارة</th>
            <th>تاريخ التسليم</th>
            <th>المبلغ المرهون</th>
            <th>رهن الهوية</th>
            <th>رقم الهوية</th>
        </tr>
    </thead>
    <tbody>
        @if($borrows->count() > 0)
            @foreach($borrows as $borrow)
                <tr>
                    <td>{{ $borrow->subscription->type->name }}</td>
                    <td>{{ $borrow->book->title }}</td>
                    <td>{{ $borrow->borrow_date }}</td>
                    <td>
                        @if($borrow->return_date == null)
                            <p class="text-danger">لم يتم التسليم</p>
                        @else
                            {{ $borrow->return_date }}
                        @endif
                    </td>
                    <td>
                        {{ $borrow->mortgage_amount }} ل.س.
                    </td>
                    @if($borrow->identity_national_num == null)
                        <td>
                            <p>لايوجد</p>
                        </td>
                        <td>
                            <p>لايوجد</p>
                        </td>
                    @else
                        <td>
                            <p class="text-warning">مرهونة</p>
                        </td>
                        <td>
                            <p>{{$borrow->identity_national_num}}</p>
                        </td>
                    @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">
                    <p class="fw-bold">المستخدم لم يقم بالاستعارة بعد</p>
                </td>
            </tr>
        @endif
    </tbody>
</table>
<div class="d-flex justify-content-center mt-4">
    {{ $borrows->links() }}
</div>
@endsection
