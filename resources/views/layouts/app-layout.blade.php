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
    {{-- Libs --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    @stack('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="page">
        <!-- Sidebar -->
        <x-sidebar />
        <!-- Navbar -->
        <x-navbar />
        {{ $slot }}
        <x-footer />
    </div>
    <!-- Libs JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        function showToast(message, messageType) {
            const backgroundColors = {
                success: 'rgb(47, 179, 68)',
                error: 'rgb(217, 83, 79)',
                default: 'rgb(49, 117, 183)'
            };

            const backgroundColor = backgroundColors[messageType] || backgroundColors.default;

            Toastify({
                text: message,
                duration: 3000,
                close: false,
                gravity: "top",
                position: "right",
                style: {
                    background: backgroundColor,
                },
            }).showToast();
        }

        $(document).ready(function() {
            let currentTheme = localStorage.getItem('theme') || 'dark';
            $('body').attr('data-bs-theme', currentTheme);

            function toggleTheme() {
                if (currentTheme === 'dark') {
                    currentTheme = 'light';
                } else {
                    currentTheme = 'dark';
                }

                localStorage.setItem('theme', currentTheme);
                $('body').attr('data-bs-theme', currentTheme);
            }

            $('.toggleTheme').on('click', function() {
                toggleTheme();
            });
        });
    </script>
    @stack('scripts')
    <!-- Tabler Core -->
    <script src="{{ asset('assets/vendor/tabler/js/tabler.min.js') }}" defer></script>
</body>

</html>
