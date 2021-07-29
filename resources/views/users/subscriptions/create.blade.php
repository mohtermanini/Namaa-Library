@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center">
        <h4>إضافة اشتراك</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('subscriptions.store') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="form-group  mt-3">
                <label  for="name">اسم المشترك</label>
                <input type="text" class="form-control mt-2" name="name" value="{{ $user->name }}" readonly>
            </div>
            <div class="form-group mt-3">
                <label for="type_id">نوع الاشتراك</label>
                <select name="type_id" id="type_id" class="form-control mt-2">
                    <option value="-1">اختر نوع الاشتراك...</option>
                    @foreach($subscription_types as $subscription_type)
                        <option value="{{ $subscription_type->id }}"
                            @if($subscription_type->id == old('type_id'))
                                selected
                            @endif
                    >{{ $subscription_type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group  mt-3">
                        <label for="start_date">بداية الاشتراك</label>
                        <input type="date" class="form-control mt-2" name="start_date"
                            value="{{ today()->todateString() }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mt-3">
                        <label for="duration">المدة</label>
                        <input type="number" id="duration" class="form-control mt-2" name="duration"
                            value="" min="0" required>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3">
                <label for="fee">الرسوم</label>
                <input type="number" id="fee" class="form-control mt-2" name="fee" value=""
                    min="0" required>
            </div>
            <div class="form-group mt-3 text-center">
                <a href="{{ route('subscriptions.index',['user_id'=>$user->id]) }}" 
                    class="btn btn-success ms-4">رجوع</a>
                <button class="btn btn-success" type="submit">إضافة</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var duration = [];
        var fee = [];
        fee["-1"]=""
        duration["-1"]=""
        @foreach($subscription_types as $subscription_type)
            duration["{{$subscription_type->id}}"] = {{$subscription_type->days}};
        @endforeach
        @foreach($subscription_types as $subscription_type)
            fee["{{$subscription_type->id}}"] = {{$subscription_type->fee}};
        @endforeach
        $("#type_id").on("input",function(){
            $("#duration").val(duration[$(this).val()])
            $("#fee").val(fee[$(this).val()])
        })
    </script>
@endsection
