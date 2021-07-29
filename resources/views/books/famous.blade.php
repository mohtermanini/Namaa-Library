@extends('layouts.app')

@section('content')

<a href="{{ route('statistics') }}" class="btn btn-success">رجوع</a>
<table class="table table-hover table-bordered text-center mt-4">
    <thead>
        <tr>
            <th colspan="4">
                <p class="h4 text-primary">أشهر الكتب</p>
            </th>
        </tr>
        <tr class="text-success">
            <th>اسم الكتاب</th>
            <th>اسم المؤلف</th>
            <th>عدد مرات الاستعارة</th>
            <th>تفاصيل الكتاب</th>
        </tr>
    </thead>
    <tbody>
        @if($famous_books->count() > 0)
            @foreach($famous_books as $book)
                <tr>
                    <td>{{ $book->book->title }}</td>
                    <td>{{ $book->book->author }}</td>
                    <td>{{ $book->borrows_count }}</td>
                    <td>
                        <a href="{{ route('books.show',['book'=>$book->book->id]) }}"
                            class="btn btn-info">تفاصيل</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4">
                    <p class="fw-bold">لايوجد كتب مستعارة بعد</p>
                </td>
            </tr>
        @endif
    </tbody>
</table>
@endsection
