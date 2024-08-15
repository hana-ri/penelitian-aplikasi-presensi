<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title ?? 'default title' }} - {{ env('APP_NAME') }}</title>
    <!-- CSS files -->
    <link href="{{ asset('assets/vendor/tabler/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/tabler/css/tabler-vendors.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/tabler-icon/tabler-icons.min.css') }}" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" d-flex flex-column bg-white">
    <div class="row g-0 flex-fill">
        <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
            <div class="container container-tight my-5 px-lg-5">
                <div class="text-center mb-4">
                    <a href="{{ route('login') }}" class="h1 m-0">
                        <img src="{{ asset('assets/images/logo_upi.png') }}" width="165" height="48"
                            alt="Tabler" class="navbar-brand-image">
                        <img src="{{ asset('assets/images/logo_tekkom.png') }}" width="165" height="48"
                            alt="Tabler" class="navbar-brand-image">
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
            <!-- Photo -->
            <div class="bg-cover h-100 min-vh-100"
                style="background-image: url({{ asset('assets/images/lab_upi.png') }})">
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('assets/vendor/tabler/js/tabler.min.js') }}" defer></script>

</body>

</html>
