@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center">
        <h4>إضافة جلسة</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('sessions.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="borrow_date">تاريخ الجلسة</label>
                <input type="date" class="form-control mt-2" name="date" value="{{ today()->toDateString() }}">
            </div>
            <div class="form-group mt-3">
                <label for="course_id">اسم المادة</label>
                <select name="course_id" id="course_id" class="form-control mt-2">
                    <option value="-1">اختيار مادة...</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}"
                            @if($course->id == old('course_id'))
                                selected
                            @endif
                            >{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <?php $name = ['الأول','الثاني','الثالث']; ?>
            @for($i = 0; $i < 3; $i++)
                <div class="row form-group mt-3">
                    <div class="col">
                        <label for="books">اسم المدرس {{ $name[$i] }}</label>
                        <input type="text" class="form-control mt-2" id="searchBox[{{ $i }}]"
                            placeholder="اسم المدرس..." autocomplete="off">
                        <input type="hidden" value="-1" id="search_value[{{ $i }}]" name="users[{{ $i }}]">
                    </div>
                    <div class="col">
                        <label for="paid">المبلغ المعطى</label>
                        <input type="number" class="form-control mt-2" name="paid[{{ $i }}]" value="0" min="0">
                    </div>
                </div>
            @endfor
            <div class="form-group mt-3 text-center">
                <a href="{{ route('teachers.index') }}" class="btn btn-success ms-4">رجوع</a>
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
