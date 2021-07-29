@extends('layouts.app')

@section('content')
<a href="{{ route('categories.index') }}" class="btn btn-success ms-4">رجوع</a>
<a href="{{ route('books.create') }}" class="btn btn-success">إضافة كتاب</a>
<table class="table table-bordered table-hover text-center mt-2">
    <thead>
        <tr>
            <th colspan="5">
                <div class="d-flex justify-content-between align-items-center">
                    <div  class="text-start">
                        <p class="invisible h6">عدد الكتب المختلفة : {{$category->books()->count()}}</p>
                        <p class="invisible h6">عدد الكتب الكلية : {{$books_count}}</p>
                    </div>
                    <p class="h4">{{ $category->name }}</p>
                    <div class="text-start">
                        <p class="h6">عدد الكتب المختلفة : {{$category->books()->count()}}</p>
                        <p class="h6">عدد الكتب الكلية : {{$books_count}}</p>
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th>اسم الكتاب</th>
            <th>اسم المؤلف</th>
            <th>عدد النسخ الكلية</th>
            <th>عدد النسخ المتوفرة</th>
            <th>تفاصيل</th>
        </tr>
    </thead>
    <tbody>
        @if($books->count() > 0)
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->count }}</td>
                    <td>{{ $book->available_count }}</td>
                    <td><a href="{{ route('books.show',['book'=>$book->id]) }}"
                            class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg></a></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">
                    <p class="fw-bold">لايوجد كتب لهذا الصنف بعد</p>
                </td>
            </tr>
        @endif
    </tbody>
</table>
<div class="d-flex justify-content-center mt-4">
    {{ $books->links() }}
</div>
@endsection
