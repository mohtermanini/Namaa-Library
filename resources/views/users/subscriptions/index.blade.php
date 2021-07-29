@extends('layouts.app')

@section('content')
<a href="{{ route('subscriptions.create',['id'=>$user->id]) }}"
    class="btn btn-success  ms-4">إضافة اشتراك</a>
<a href="{{ route('subscriptions.index',['user_id'=>$user->id]) }}"
    class="btn btn-success ms-4">الاشتراكات الحالية</a>
<a href="{{ route('subscriptions.all',['user_id'=>$user->id]) }}"
    class="btn btn-success ms-4">كل الاشتراكات</a>
<a href="{{ route('borrows.index',['user_id'=>$user->id]) }}"
    class="btn btn-success">الاستعارات</a>
<table class="table table-bordered table-hover text-center mt-2">
    <thead>
        <tr>
            <th colspan="5">
                <p class="h4">{{ $user->name }} ({{ $all_or_current }})</p>
            </th>
        </tr>
        <tr>
            <th>نوع الاشتراك</th>
            <th>تاريخ البداية</th>
            <th>لغاية</th>
            <th>المبلغ المدفوع</th>
            <th>حذف</th>
        </tr>
    </thead>
    <tbody>
        @if($subscriptions->count() > 0)
            @foreach($subscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->type->name }}</td>
                    <td>{{ $subscription->getDate($subscription->start_date) }}</td>
                    <td>
                        @if($subscription->remainingDuration() > 0)
                            <p>{{ $subscription->remainingDuration() }} يوم</p>
                        @elseif($subscription->end_date != null)
                            {{ $subscription->getDate($subscription->end_date) }}
                        @endif
                    </td>
                    <td>
                        {{ $subscription->fee }}
                    </td>
                    <td>
                        <a delete_link="{{ route('subscriptions.destroy',['subscription'=>$subscription->id]) }}"
                            class="btn btn-danger modalToggle {{$subscription->type->name=='مدرس'?'disabled':''}}"
                            >حذف</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">
                    <p class="fw-bold">المستخدم ليس لديه اشتراكات حالية</p>
                </td>
            </tr>
        @endif
    </tbody>
</table>

<div class="d-flex justify-content-center mt-4">
    {{$subscriptions->links()}}
</div>

@include('includes.modal')
@endsection

@section('scripts')
    @include('includes.modal_script')
@endsection