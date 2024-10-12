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
    <link rel="stylesheet" id="css-main" href="{{ asset('css/codebase.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/bootstrap.css') }}">

    {{-- Additional CSS --}}
    <link rel="stylesheet" href="{{ asset('libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/toastr/build/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/pace-progress/themes/silver/pace-theme-flat-top.css') }}">

    @yield('css')
</head>
<body>
    <div id="auth">
        <div class="container">
            @yield('content')
        </div>
    </div>

    {{-- General Scripts --}}
    <script src="{{ asset('js/codebase.core.min.js') }}"></script>
    <script src="{{ asset('js/codebase.app.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/pages/op_auth_signin.min.js') }}"></script>

    <script src="{{ asset('admin_assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/app.js') }}"></script>
    <script src="{{ asset('admin_assets/js/main.js') }}"></script>

    {{-- JS Plugins --}}
    <script src="{{ asset('libs/pace-progress/pace.min.js') }}"></script>
    <script src="{{ asset('libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-rowgroup/js/dataTables.rowGroup.min.js') }}"></script>

    {{-- Support JS --}}
    {{-- <script src="{{ asset('js/support/loader.js') }}"></script> --}}
    <script src="{{ asset('js/support/support.js') }}"></script>

    <script>
        $(document).ready(function() {
            let initialRole = $('select[name="role"]').val();
            toggleInputs(initialRole);

            $('select[name="role"]').on('change', function() {
                let role = $(this).val();
                toggleInputs(role);
            });

            function toggleInputs(role) {
                const inputs = {
                    admin: {
                        show: ['#container-username', '#container-password'],
                        hide: ['#container-telp', '#container-date'],
                        enable: ['#username', '#password'],
                        disable: ['#telp', '#birthdate']
                    },
                    user: {
                        show: ['#container-telp', '#container-date'],
                        hide: ['#container-username', '#container-password'],
                        enable: ['#telp', '#birthdate'],
                        disable: ['#username', '#password']
                    }
                };

                inputs[role].show.forEach(selector => $(selector).show());
                inputs[role].hide.forEach(selector => $(selector).hide());

                inputs[role].enable.forEach(selector => $(selector).prop('disabled', false));
                inputs[role].disable.forEach(selector => $(selector).prop('disabled', true));
            }
        });

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
