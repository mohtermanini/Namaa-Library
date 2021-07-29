@extends('layouts.app')

@section('top-content')
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <p class="text-start mb-0">This is a demo website, play with it as you like</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@stop
@section('content')

<div class="d-flex justify-content-center">
    <div class="card w-50">
        <div class="card-body">
            <div class="form-group">
                <label for="name">الاسم</label>
                <input type="text" class="form-control mt-2" name="name" value="محمد ترمانيني" readonly>
            </div>
            <div class="form-group mt-3">
                <label for="mobile">رقم الموبايل</label>
                <input type="text" class="form-control mt-2" name="mobile" value="0991947234" readonly>
            </div>
            <div class="form-group">
                <label for="name">الاسم</label>
                <input type="text" class="form-control mt-2" name="name" value="حسن جدوع" readonly>
            </div>
            <div class="form-group mt-3">
                <label for="mobile">رقم الموبايل</label>
                <input type="text" class="form-control mt-2" name="mobile" value="0991080728" readonly>
            </div>
        </div>
    </div>
</div>
@stop
