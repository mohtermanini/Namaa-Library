@extends('layouts.app')

@section('content')
<a href="{{ route('courses.create') }}" class="btn btn-success">إضافة مادة</a>
<table class="table table-bordered table-hover text-center mt-2">
    <thead>
        <tr>
            <th>اسم المادة</th>
            <th>تعديل</th>
            <th>حذف</th>
            <th>الجلسات</th>
        </tr>
    </thead>
    <tbody>
        @if($courses->count() > 0)
        @foreach($courses as $course)
            <tr>
                <td>{{ $course->name }}</td>
                <td><a href="{{ route('courses.edit',['course'=>$course->id]) }}"
                        class="btn btn-info ">تعديل</a></td>
                <td>
                    <a delete_link="{{ route('courses.destroy',['course'=>$course->id]) }}"
                        class="btn btn-danger modalToggle">حذف</a>
                </td>
                <td>
                    <a href="{{ route('courses.sessions',['id'=>$course->id]) }}"
                        class="btn btn-primary">إظهار</a>
                </td>
            </tr>
        @endforeach
        @else
        <tr>
            <td colspan="4">
                <p class="fw-bold">لايوجد مواد بعد</p>
            </td>
        </tr>
        @endif
    </tbody>
</table>
<div class="d-flex justify-content-center mt-4">
    {{$courses->links()}}
</div>
@include('includes.modal')
@endsection

@section('scripts')
    @include('includes.modal_script')
@endsection
