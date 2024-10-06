<!doctype html>
<html lang="en" class="no-focus">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ config('app.name') }} | PT. ARITA PRIMA INDONESIA Tbk</title>

    <meta name="description" content="PT. ARITA PRIMA INDONESIA Tbk">
    <meta property="og:title" content="PT. ARITA PRIMA INDONESIA Tbk">
    <meta property="og:description" content="PT. ARITA PRIMA INDONESIA Tbk">
    <meta property="og:type" content="website">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('media/logo/logo_arita.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('media/logo/logo_arita.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/logo/logo_arita.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">

    {{-- Additional CSS --}}
    <link rel="stylesheet" href="{{ asset('libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/toastr/build/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/pace-progress/themes/blue/pace-theme-minimal.css') }}">

    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">

    <style>
        .sidebar-menu a {
            text-decoration: none;
        }
    </style>

    @yield('css')
</head>
<body>
    <div id="app">
        @include('partials.admin.sidebar')
        <div id="main">
            @include('partials.admin.header')
            <x-preloader/>
            @yield('content')
        </div>
    </div>

    {{-- General Scripts --}}
    <script src="{{ asset('js/core/jquery.min.js') }}"></script>

    <script src="{{ asset('admin_assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/app.js') }}"></script>
    <script src="{{ asset('admin_assets/js/main.js') }}"></script>
    <script src="https://kit.fontawesome.com/024c1ae29f.js" crossorigin="anonymous"></script>

    {{-- JS Plugins --}}
    <script src="{{ asset('libs/pace-progress/pace.min.js') }}"></script>
    <script src="{{ asset('libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-rowgroup/js/dataTables.rowGroup.min.js') }}"></script>
    <script src="{{ asset('libs/momentjs/moment.js') }}"></script>

    {{-- Support JS --}}
    <script src="{{ asset('js/support/loader.js') }}"></script>
    <script src="{{ asset('js/support/support.js') }}"></script>

    <script>
        paceOptions = {
            elements: true
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });

    </script>

    @yield('js')
</body>
</html>
