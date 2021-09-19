<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مكتبة نماء</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

</head>

<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark p-3 ps-5">
        <a href="{{ route('statistics') }}" class="navbar-brand me-4">مكتبة نماء</a>
        <div class="d-flex w-100 justify-content-between">
            <ul class="navbar-nav w-100 flex-wrap">
                <li class="nav-item">
                    <a href="{{ route('statistics') }}" class="nav-link">إحصائيات</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">المستخدمين</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('books.index') }}" class="nav-link">الكتب</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link">الأصناف</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('courses.index') }}" class="nav-link">المواد</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teachers.index') }}" class="nav-link">المدرسين</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('activities.index', ['title' => 'مقهى الوظائف']) }}" class="nav-link">مقهى
                        الوظائف</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('activities.index', ['title' => 'نشاطات المكتبة']) }}"
                        class="nav-link">نشاطات المكتبة</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        إرجاع
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('borrows.index.internal') }}">الكتب
                                المستعارة داخلياً</a></li>
                        <li><a class="dropdown-item" href="{{ route('borrows.index.external') }}">الكتب
                                المستعارة خارجياً</a></li>
                    </ul>
                </li>
                <!--
                    <li class="nav-item">
                        <a href="{ { route('dbbackup') }}" class="nav-link">نسخ احتياطي</a>
                    </li>
                     -->
                <li class="nav-item me-lg-auto">
                    <a href="{{ route('contact') }}" class="nav-link">عن المبرمجين</a>
                </li>
            </ul>
        </div>
    </nav>
    @yield("top-content")
    <div class="container mt-4">
        @include('includes.errors')
        @yield("content")
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js') }}"></script>

    <script>
        toastr.options.positionClass = "toast-top-left";
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @elseif(Session::has('failed'))
            toastr.info("{{ Session::get('failed') }}");
        @endif
    </script>
    @yield('scripts')
</body>

</html>
