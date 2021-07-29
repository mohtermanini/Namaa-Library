@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center">
        <h4>إضافة استعارة خارجية</h4>
    </div>
    @if($subscription->remainingDuration() <= 2)
        <div class="card-body p-0">
            <div class="alert alert-danger">
                المشترك تبقى لديه {{ $subscription->remainingDuration() }} يوم فقط لنهاية اشتراكه
            </div>
        </div>
    @endif
    <div class="card-body">
        <form action="{{ route('borrows.store.external') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            <div class="form-group">
                <label for="name">اسم المشترك</label>
                <input type="text" class="form-control mt-2" name="name" value="{{ $subscription->user->name }}"
                    readonly>
            </div>
            <div class="form-group mt-3">
                <label for="borrow_date">تاريخ الاستعارة</label>
                <input type="datetime-local" class="form-control mt-2"
                 name="borrow_date" value="{{now()->toDateTimeLocalString()}}" readonly>
            </div>
            <?php $name = ['الأول','الثاني','الثالث']; ?>
            @for($i=0; $i<3; $i++)
                <div class="row  mt-3">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="books">اسم الكتاب {{ $name[$i] }}</label>
                            <input type="text" class="form-control mt-2" id="searchBox[{{ $i }}]" placeholder="اسم الكتاب..."
                                autocomplete="off">
                            <input type="hidden" value="-1" id="search_value[{{ $i }}]" name="books[{{ $i }}]">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="mortgage_amount">المبلغ المرهون</label>
                            <input type="number" name="mortgage_amount[{{$i}}]" class="form-control mt-2" value="0" min="0"
                                required>
                        </div>
                    </div>
                    <div class="col-2 text-center">
                        <div class="form-group pt-3">
                            <br>
                            <input type="checkbox" name="identity_mortgage[{{$i}}]" id="identity_mortgage"
                                class="form-check-input">
                            <label for="identity_mortgage" class="form-check-label">رهن الهوية</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="identity_national_num">الرقم الوطني</label>
                            <input type="text" class="form-control mt-2" name="identity_national_num[{{$i}}]" autocomplete="off">
                        </div>
                    </div>
                </div>
            @endfor
            <div class="form-group mt-3 text-center">
                <a href="{{ route('borrows.index',['user_id'=>$subscription->user->id]) }}"
                    class="btn btn-success ms-4">رجوع</a>
                <button class="btn btn-success" type="submit">إضافة</button>
            </div>
        </form>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
    var ac = new Array();
</script>

@for($i=0; $i<3; $i++)
    @include('includes.multiple_search')
@endfor
@endsection