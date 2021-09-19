@extends('layouts.app')

@section('content')
<a href="{{ route('statistics') }}" class="btn btn-success ms-4">رجوع</a>
<div class="table-responsive">
    <table class="table table-bordered table-hover text-center mt-2">
        <thead>
            <tr>
                <td colspan="6">
                    <p class="h4">تفاصيل الاستعارات الداخلية الحالية</p>
                </td>
            </tr>
            <tr>
                <th>اسم الكتاب</th>
                <th>اسم المؤلف</th>
                <th>اسم المشترك</th>
                <th>تاريخ الاستعارة</th>
                <th>تفاصيل المشترك</th>
                <th>إرجاع الكتاب</th>
            </tr>
        </thead>
        <tbody>
            @if(count($borrowed_books) > 0)
                @foreach($borrowed_books as $borrow)
                    <tr>
                        <td>{{ $borrow->book->title }}</td>
                        <td>{{ $borrow->book->author }}</td>
                        <td>{{ $borrow->subscription->user->name }}</td>
                        <td>{{ $borrow->borrow_date }}</td>
                        <td>
                            <a href="{{ route('users.show',['user'=>$borrow->subscription->user->id]) }}"
                                class="btn btn-success">تفاصيل</a>
                        </td>
                        <td>
                            <button return_link="{{route('borrows.book.return',
                                ['book_id'=>$borrow->book->id,'borrow_id'=>$borrow->id])}}"
                                class="btn btn-warning modalToggle">إرجاع</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">
                        <p class="fw-bold">لايوجد استعارات داخلية حالية</p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $borrowed_books->links() }}
</div>
@include('includes.return_modal')
@endsection

@section('scripts')
@include('includes.return_modal_script')
@endsection
