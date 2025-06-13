<!DOCTYPE html>
<html lang="en" dir="ltr" class="dark">
    <head>
        <meta charset="utf-8">
        <title>{{ $title }} - EMA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Tailwind Admin & Dashboard Template" name="description">
        <meta content="Themesbrand" name="author">

        @include('includes.styles')
    </head>

    <body class="min-h-screen dark:bg-zinc-900">

        <!-- Top Navbar -->
        @include('includes.navbar')
        <!-- End Top Navbar -->

        <div class="min-h-screen main-content dark:bg-zinc-900">
            <div class="container">
                <div class="content">
                    {{ $slot }}
                </div>
            </div>
            <!-- Footer Start -->
            <footer class="px-5 py-5 mt-auto border-t bg-white/5 dark:bg-black/20 border-white/10 dark:border-white/5 footer backdrop-blur-xl">
                <div class="container">
                    <div class="grid grid-cols-2 text-gray-300 dark:text-zinc-100">
                        <div class="grow">
                            &copy; {{ date('Y') }} {{ ENV('APP_NAME') }}
                        </div>
                        <div class="hidden md:inline-block text-end">Design & Develop by <a href="" class="underline transition-colors text-blue-400 hover:text-blue-300">Ahnaffaiz</a></div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>

        @include('includes.scripts')
    </body>
</html>
