@extends('layouts.app')

@section('content')
    <a href="{{ route('teachers.index') }}" class="btn btn-success ms-4">رجوع</a>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center mt-2">
            <thead>
                <tr>
                    <th colspan="4">
                        <p class="h4">{{ $teacher->name }}</p>
                    </th>
                </tr>
                <tr>
                    <th>تاريخ الجلسة</th>
                    <th>اسم المادة</th>
                    <th>المبلغ المعطى</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                @if ($sessions->count() > 0)
                    @foreach ($sessions as $session)
                        <tr>
                            <td>{{ $session->date }}</td>
                            <td>{{ $session->course->name }}</td>
                            <td>{{ $session->users[0]->pivot->paid }}</td>
                            <td>
                                <a delete_link="{{ route('sessions.destroy', ['sid' => $session->id, 'uid' => $teacher->id]) }}"
                                    class="btn btn-danger modalToggle">حذف</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">
                            <p class="fw-bold">لايوجد جلسات لهذا المدرس بعد</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $sessions->links() }}
    </div>
    @include('includes.modal')
@endsection

@section('scripts')
    @include('includes.modal_script')
@endsection
