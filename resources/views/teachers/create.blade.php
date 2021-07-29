@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center">
        <h4>إضافة مدرس</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('teachers.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group  mt-3">
                <label for="name">اسم المدرس</label>
                <input type="text" class="form-control mt-2" id="searchBox" autocomplete="off" required>
                <input type="hidden" id="search_value" value="-1" name="user_id">
            </div>
            <div class="form-group mt-3">
                <label for="type">نوع الاشتراك</label>
                <input type="text" class="form-control mt-2" value="{{$type}}" readonly>
            </div>

            <div class="form-group  mt-3">
                <label for="start_date">بداية الاشتراك</label>
                <input type="date" class="form-control mt-2" name="start_date" value="{{ today()->todateString() }}"
                  autocomplete="off" required>
            </div>
            <div class="form-group mt-3 text-center">
                <a href="{{ route('teachers.index') }}"
                    class="btn btn-success ms-4">رجوع</a>
                <button class="btn btn-success" type="submit">إضافة</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
    @include('includes.search')
@endsection