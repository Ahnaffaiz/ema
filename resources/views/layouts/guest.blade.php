<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Computer Based Test System" name="description">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- Icon libraries -->
        <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- Tailwind CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/tailwind.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body data-mode="light" data-sidebar-size="lg" class="flex flex-col min-h-screen bg-white dark:bg-zinc-800">
        <div class="flex flex-col flex-grow dark:bg-zinc-700">
            <div class="flex items-center justify-center flex-grow page-content">
                <div class="w-full max-w-xl mx-auto card dark:bg-zinc-800 dark:border-zinc-600">
                    <div class="p-6 border-b card-header border-gray-50 dark:border-zinc-600">
                        <div class="flex justify-center">
                            <a href="{{ url('/') }}" class="flex items-center">
                                <img src="{{ asset('assets/images/logo-sm.svg') }}" alt="" class="h-8">
                                <span class="ml-2 text-xl font-medium text-gray-700 dark:text-white">{{ config('app.name', 'Laravel') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Fixed bottom controls -->
        <div class="fixed flex items-center space-x-4 bottom-4 left-4">
            <!-- Dark/Light Mode Toggle -->
            <button id="dark-mode-toggle" class="p-2 text-sm font-medium text-gray-700 rounded-md bg-none hover:text-gray-500 dark:text-gray-200 dark:hover:bg-zinc-600">
                <i class="bx bx-moon dark:hidden"></i>
                <i class="hidden bx bx-sun dark:inline-block"></i>
            </button>
        </div>

        <!-- JS -->
        <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenujs/metismenujs.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>

        <script>
            // Initialize theme based on stored preference
            document.addEventListener('DOMContentLoaded', function() {
                // Check if theme is stored in localStorage
                const theme = localStorage.getItem('theme');

                // Apply the theme if it exists
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                    document.body.setAttribute('data-mode', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    document.body.setAttribute('data-mode', 'light');
                }
            });

            // Handle dark mode toggle click
            document.getElementById('dark-mode-toggle').addEventListener('click', function() {
                // Toggle dark class on html element
                document.documentElement.classList.toggle('dark');

                // Set data-mode attribute on body to match (for component compatibility)
                if (document.documentElement.classList.contains('dark')) {
                    localStorage.setItem('theme', 'dark');
                    document.body.setAttribute('data-mode', 'dark');
                } else {
                    localStorage.setItem('theme', 'light');
                    document.body.setAttribute('data-mode', 'light');
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>
