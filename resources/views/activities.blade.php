@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-4">
        <form
            action="{{ route('activities.index',['title'=>$title]) }}"
            method="GET">
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
        <a href="{{ route('activities.index',['title'=>$title]) }}"
            class="btn btn-success">كل المستخدمين</a>
    </div>
</div>

<table class="table table-bordered table-hover text-center mt-3">
    <thead>
        <tr>
           <th colspan="8">{{$title}}</th> 
        </tr>
        <tr>
            <th>اسم المستخدم</th>
            <th>رقم الموبايل 1</th>
            <th>رقم الموبايل 2</th>
            <th>رقم الأرضي</th>
            <th>بداية الاشتراك</th>
            <th>لغاية</th>
            <th>المبلغ المدفوع</th>
            <th>تفاصيل المشترك</th>
        </tr>
    </thead>
    <tbody>
        @if($subscriptions->count() > 0)
            @foreach($subscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->user->name }}</td>
                    <td>{{ $subscription->user->mobile_1==null?'لايوجد':$subscription->user->mobile_1 }}
                    </td>
                    <td>{{ $subscription->user->mobile_2==null?'لايوجد':$subscription->user->mobile_2 }}
                    </td>
                    <td>{{ $subscription->user->phone_num==null?'لايوجد':$subscription->user->phone_num }}
                    </td>
                    <td>
                        {{ $subscription->start_date }}
                    </td>
                    <td>
                        @if($subscription->remainingDuration() > 0)
                            <p class="text-warning">{{ $subscription->remainingDuration() }} يوم</p>
                        @else
                            {{ $subscription->getDate($subscription->end_date) }}
                        @endif
                    </td>
                    <td>
                        {{ $subscription->fee }}
                    </td>
                    <td>
                        <a href="{{ route('users.show',['user'=>$subscription->user->id]) }}"
                            class="btn btn-info">تفاصيل</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8">
                    <p class="fw-bold">لايوجد مستخدمين في {{ $title }} بعد</p>
                </td>
            </tr>
        @endif
    </tbody>
</table>
<div class="d-flex justify-content-center mt-4">
    {{ $subscriptions->links() }}
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    const field = document.getElementById('searchBox');
    var xhr = null;
    const ac = new Autocomplete(field, {
        data: [],
        maximumItems: {{Config::get("max_search_items")}},
        treshold: 1,
        onInput: function () {
            document.getElementById('search_value').value = -1
            var options = {};
            options.url = "{{ $search_url }}";
            options.type = "POST";
            options.data = {
                "name": $("#searchBox").val(),
                "title": "{{ $title }}",
                "_token": "{{ csrf_token() }}"
            };
            options.dataType = "json";
            options.success = function (data) {
                ac.setData(data);
                ac.renderIfNeeded()
            };
            if (xhr !== null) {
                xhr.abort();
            }
            xhr = $.ajax(options);
        },
        onSelectItem: ({
            label,
            value
        }) => {
            $("#search_value").val(value);
        }
    });

</script>
@endsection
