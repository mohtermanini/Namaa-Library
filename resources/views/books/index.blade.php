@extends('layouts.app')

@section('content')

<a href="{{ route('books.create') }}" class="btn btn-success">إضافة كتاب</a>

<div class="row mt-3">
    <div class="col-4">
        <form action="{{ route('books.index') }}" method="GET">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" id="searchBox" placeholder="اسم الكتاب..."
                        autocomplete="off" name="book_name_search" required>
                    <input type="hidden" value="-1" id="search_value" name="book_id">
                </div>
                <div class="col-2">
                    <button class="btn btn-success">بحث</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col me-2">
        <a href="{{ route('books.index') }}" class="btn btn-success">كل الكتب</a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-4">
        <form action="{{ route('books.index') }}" method="GET">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" id="authorSearchBox" placeholder="اسم المؤلف..."
                        autocomplete="off" name="author_name_search" required>
                    <input type="hidden" value="-1" id="author_search_value" name="author">
                </div>
                <div class="col-2">
                    <button class="btn btn-success">بحث</button>
                </div>
            </div>
        </form>
    </div>
</div>

<table class="table table-bordered table-hover text-center mt-3">
    <thead>
        <tr>
            <th>
                <a class="text-decoration-none text-dark" href=" {{ route('books.index',
                    array_merge(request()->query(), 
                    ['order_col' => 'title', 'order_type' => $order_col === 'title' ? $order_type : 'asc'])
                ) }}">
                    اسم الكتاب
                    @include("includes.icons.sorting_icon",
                     ['current_col' => 'title', 'order_type' => $order_col === 'title' ? $order_type : 'asc'])
                </a>
            </th>
            <th>
                <a class="text-decoration-none text-dark" href=" {{ route('books.index',
                array_merge(request()->query(), 
                ['order_col' => 'author', 'order_type' => $order_col === 'author' ? $order_type : 'asc'])
            ) }}">
                اسم المؤلف
                @include("includes.icons.sorting_icon", 
                ["current_col" => "author", 'order_type' => $order_col === 'author' ? $order_type : 'asc'])
            </a>
            </th>
            <th>عدد النسخ الكلية</th>
            <th>عدد النسخ المتوفرة</th>
            <th>اسم الصنف</th>
            <th>تفاصيل</th>
            <th>حذف</th>
        </tr>
    </thead>
    <tbody>
        @if($sorted_books->count() > 0)
            @foreach($sorted_books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->count }}</td>
                    <td>{{ $book->available_count }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td><a href="{{ route('books.show',['book'=>$book->id]) }}"
                            class="btn btn-info">عرض</a></td>
                    <td>
                        <a delete_link="{{ route('books.destroy',['book'=>$book->id]) }}"
                            class="btn btn-danger modalToggle">حذف</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">
                    <p class="fw-bold">لايوجد كتب بعد</p>
                </td>
            </tr>
        @endif
    </tbody>
</table>
<div class="d-flex justify-content-center mt-4">
    {{ $books->links() }}
</div>
@include('includes.modal')
@endsection

@section('scripts')
@include('includes.search')
<script>
    const field2 = document.getElementById('authorSearchBox');
    var xhr = null;
    const ac2 = new Autocomplete(field2, {
        data: [],
        maximumItems: {{Config::get("max_search_items")}},
        treshold: 1,
        onInput: function () {
            var options = {};
            options.url = "{{ $author_search_url }}";
            options.type = "POST";
            options.data = {
                "name": $("#authorSearchBox").val(),
                "_token": "{{ csrf_token() }}"
            };
            options.dataType = "json";
            options.success = function (data) {
                ac2.setData(data);
                ac2.renderIfNeeded()
            };
            if(xhr !== null){
                xhr.abort();
            }
            xhr = $.ajax(options);
        },
        onSelectItem: ({
            label,
            value
        }) => {
            $("#author_search_value").val(value)
        }
    });

</script>
@include('includes.modal_script')
@endsection
