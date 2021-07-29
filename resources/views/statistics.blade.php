@extends('layouts.app')

@section('content')

<div class="row mt-4 text-center">
    <div class="col">
        <table class="table table-hover table-bordered table-striped ">
            <thead>
                <tr>
                    <th colspan="9">
                        <p class="h4 text-danger">
                            المشتركين الحاليين الذين تبقى لديهم {{ $days_left }} يوم أو أقل لانتهاء الاشتراك</p>
                    </th>
                </tr>
                <tr class="text-success">
                    <th>#</th>
                    <th>اسم المشترك</th>
                    <th>نوع الاشتراك</th>
                    <th>تاريخ البداية</th>
                    <th>الوقت المتبقى لانتهاء الاشتراك</th>
                    <th>رقم الموبايل 1</th>
                    <th>رقم الموبايل 2</th>
                    <th>رقم الأرضي</th>
                    <th>تفاصيل المشترك</th>
                </tr>
            </thead>
            <tbody>
                @if($end_subscriptions->count() > 0)
                    <?php $i=1; ?>
                    @foreach($end_subscriptions as $subscription)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $subscription->user->name }}</td>
                            <td>{{ $subscription->type->name }}</td>
                            <td>{{ $subscription->getDate($subscription->start_date) }}</td>
                            <td>{{ $subscription->remainingDuration() }}</td>
                            <td>{{ $subscription->user->mobile_1==null?'لايوجد':$subscription->user->mobile_1 }}
                            </td>
                            <td>{{ $subscription->user->mobile_2==null?'لايوجد':$subscription->user->mobile_2 }}
                            </td>
                            <td>{{ $subscription->user->phone_num==null?'لايوجد':$subscription->user->phone_num }}
                            </td>
                            <td>
                                <a href="{{ route('users.show',['user'=>$subscription->user->id]) }}"
                                    class="btn btn-info">تفاصيل</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9">
                            <p class="fw-bold">لايوجد حالياً</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $end_subscriptions->links() }}
        </div>
    </div>
</div>
<hr>
<div class="row mt-4">
    <div class="col">
        <div class="card text-center h-100">
            <div class="card-header text-primary">
                <p class="h4">الاشتراكات</p>
            </div>
            <div class="card-body fw-bold">
                <div class="row">
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد الاشتراكات الداخلية الكلية</p>
                            </div>
                            <div class="card-body">
                                {{ $internal_subscriptions_count }}
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد الاشتراكات الخارجية الكلية</p>
                            </div>
                            <div class="card-body">
                                {{ $external_subscriptions_count }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد اشتراكات مقهى الوظائف الكلية</p>
                            </div>
                            <div class="card-body">
                                {{ $homework_subscriptions_count }}
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد اشتراكات نشاطات المكتبة الكلية</p>
                            </div>
                            <div class="card-body">
                                {{ $library_activities_subscriptions_count }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-center h-100">
            <div class="card-header text-primary">
                <p class="h4">الاشتراكات</p>
            </div>
            <div class="card-body fw-bold">
                <div class="row">
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد الاشتراكات الداخلية لهذا الشهر</p>
                            </div>
                            <div class="card-body">
                                {{ $this_month_internal_subscriptions_count }}
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد الاشتراكات الخارجية لهذا الشهر</p>
                            </div>
                            <div class="card-body">
                                {{ $this_month_external_subscriptions_count }}
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد اشتراكات مقهى الوظائف لهذا الشهر</p>
                            </div>
                            <div class="card-body">
                                {{ $this_month_homework_subscriptions_count }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد اشتراكات نشاطات المكتبة لهذا الشهر</p>
                            </div>
                            <div class="card-body">
                                {{ $this_month_library_activities_subscriptions_count }}
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 bg-light">
                            <div class="card-header text-success">
                                <p>إيرادات اشتراكات هذا الشهر</p>
                            </div>
                            <div class="card-body">
                                {{ $montly_total_fee_subscriptions }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col">
        <div class="card text-center">
            <div class="card-header text-primary">
                <p class="h4">الكتب</p>
            </div>
            <div class="card-body fw-bold">
                <div class="row">
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد الأصناف الكلي</p>
                            </div>
                            <div class="card-body">
                                {{ $categories_num }}
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد الكتب المختلفة الكلي</p>
                            </div>
                            <div class="card-body">
                                {{ $books_num }}
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد الكتب مع نسخها</p>
                            </div>
                            <div class="card-body">
                                {{ $books_num_with_copies }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد الكتب المستعارة خارجياً غير المرجعة</p>
                            </div>
                            <div class="card-body">
                                <p>{{ $external_borrowers_count }}</p>
                                <a href="{{ route('borrows.index.external') }}"
                                    class="btn btn-info">التفاصيل</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد الكتب المستعارة داخلياً غير المرجعة</p>
                            </div>
                            <div class="card-body">
                                <p>{{ $internal_borrowers_count }}</p>
                                <a href="{{ route('borrows.index.internal') }}"
                                    class="btn btn-info">التفاصيل</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-center h-100">
            <div class="card-header text-primary">
                <p class="h4">الرهونات</p>
            </div>
            <div class="card-body fw-bold">
                <div class="row">
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>المبالغ الكلية المرهونة</p>
                            </div>
                            <div class="card-body">
                                {{ $total_mortgage_amount }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div class="card bg-light">
                            <div class="card-header text-success">
                                <p>عدد الهويات المرهونة</p>
                            </div>
                            <div class="card-body">
                                {{ $total_identity_mortgage }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4 text-center">
    <div class="col">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th colspan="5">
                        <p class="h4 text-primary">أشهر الكتب</p>
                    </th>
                </tr>
                <tr class="text-success">
                    <td>#</td>
                    <th>اسم الكتاب</th>
                    <th>اسم المؤلف</th>
                    <th>عدد مرات الاستعارة</th>
                    <th>تفاصيل الكتاب</th>
                </tr>
            </thead>
            <tbody>
                @if($famous_books->count() > 0)
                    <?php $i=1; ?>
                    @foreach($famous_books as $book)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $book->book->title }}</td>
                            <td>{{ $book->book->author }}</td>
                            <td>{{ $book->borrows_count }}</td>
                            <td>
                                <a href="{{ route('books.show',['book'=>$book->book->id]) }}"
                                    class="btn btn-info">تفاصيل</a>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="text-center">
                        <td colspan="5">
                            <a href="{{ route('books.famous') }}" class="btn btn-info">المزيد ...</a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="5">
                            <p class="fw-bold">لايوجد كتب مستعارة بعد</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
