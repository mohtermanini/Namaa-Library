@extends('layouts.app')

@section('content')
<a href="{{ route('teachers.create') }}" class="btn btn-success ms-3">إضافة مدرس</a>
<a href="{{ route('sessions.create') }}" class="btn btn-success">إضافة جلسة</a>

<div class="row mt-3">
    <div class="col-4">
        <form action="{{ route('teachers.index') }}" method="GET">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" id="searchBox" placeholder="اسم المدرس..."
                        autocomplete="off"name="teacher_name_search" required>
                    <input type="hidden" value="-1" id="search_value" name="teacher_id">
                </div>
                <div class="col-2">
                    <button class="btn btn-success">بحث</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col me-2">
        <a href="{{ route('teachers.index') }}" class="btn btn-success">كل المدرسين</a>
    </div>
</div>

<table class="table table-bordered table-hover text-center mt-3">
    <thead>
        <tr>
            <th>اسم المدرس</th>
            <th>رقم الموبايل 1</th>
            <th>رقم الموبايل 2</th>
            <th>رقم الأرضي</th>
            <th>الجلسات</th>
            <th>حذف</th>
        </tr>
    </thead>
    <tbody>
        @if($teachers->count() > 0)
            @foreach($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->name }}</td>
                    <td>{{ $teacher->mobile_1==null?'لايوجد':$teacher->mobile_1 }}
                    </td>
                    <td>{{ $teacher->mobile_2==null?'لايوجد':$teacher->mobile_2 }}
                    </td>
                    <td>{{ $teacher->phone_num==null?'لايوجد':$teacher->phone_num }}
                    </td>
                    <td><a href="{{ route('teachers.sessions',['teacher'=>$teacher->id]) }}"
                            class="btn btn-info">عرض</a></td>
                    <td>
                        <a delete_link="{{ route('teachers.destroy',['teacher'=>$teacher->id]) }}"
                            class="btn btn-danger modalToggle">حذف</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6">
                    <p class="fw-bold">لايوجد مدرسين بعد</p>
                </td>
            </tr>
        @endif
    </tbody>
</table>
<div class="d-flex justify-content-center mt-4">
    {{ $teachers->links() }}
</div>
@include('includes.modal')

@endsection
@section('scripts')
@include('includes.search')
@include('includes.modal_script')
@endsection
