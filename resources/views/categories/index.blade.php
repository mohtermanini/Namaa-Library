@extends('layouts.app')

@section('content')
<a href="{{ route('categories.create') }}" class="btn btn-success">إضافة صنف</a>

<div class="row mt-3">
    <div class="col-4">
        <form action="{{ route('categories.index') }}" method="GET">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" id="searchBox" placeholder="اسم الصنف..."
                        autocomplete="off" name="category_name_search" required>
                    <input type="hidden" value="-1" id="search_value" name="category_id">
                </div>
                <div class="col-2">
                    <button class="btn btn-success">بحث</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col me-2">
        <a href="{{ route('categories.index') }}" class="btn btn-success">كل الأصناف</a>
    </div>
</div>

<table class="table table-bordered table-hover text-center mt-2">
    <thead>
        <tr>
            <th>اسم الصنف</th>
            <th>تعديل</th>
            <th>حذف</th>
            <th>الكتب</th>
        </tr>
    </thead>
    <tbody>
        @if($categories->count() > 0)
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td><a href="{{ route('categories.edit',['category'=>$category->id]) }}"
                            class="btn btn-info ">تعديل</a></td>
                    <td>
                        <button delete_link="{{ route('categories.destroy',['category'=>$category->id]) }}"
                            class="btn btn-danger modalToggle">حذف</button>
                    </td>
                    <td>
                        <a href="{{ route('category.books',['id'=>$category->id]) }}"
                            class="btn btn-primary">إظهار</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4">
                    <p class="fw-bold">لايوجد أصناف بعد</p>
                </td>
            </tr>
        @endif
    </tbody>
</table>
<div class="d-flex justify-content-center mt-4">
    {{ $categories->links() }}
</div>

@include('includes.modal')
@endsection

@section('scripts')
    @include('includes.search')
    @include('includes.modal_script')
@endsection