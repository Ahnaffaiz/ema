<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>@yield('code') - @yield('title') | {{ ENV('APP_NAME') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Tailwind Admin & Dashboard Template" name="description">
        <meta content="Ahnaffaiz" name="author">

        <!-- Include the same styles as the main app -->
        @include('includes.styles')
    </head>

    <body data-mode="light" data-sidebar-size="lg" class="flex flex-col min-h-screen group">
        <div class="flex flex-col">
            <div class="dark:bg-zinc-700">
                <div class="container-fluid">
                    <div class="flex items-center justify-center h-screen text-center bg-gray-50/20 dark:bg-zinc-800">
                        <div class="pt-12">
                            <img src="{{ asset('assets/images/error-img.png') }}" alt="" class="img-fluid">
                            <div class="text-center">
                                <h1 class="mb-3 text-gray-600 dark:text-gray-100 text-8xl">@yield('code_display')</h1>
                                <h4 class="uppercase mb-2 text-gray-600 text-[21px] dark:text-gray-100">@yield('message')</h4>
                            </div>
                            <div class="mt-10 text-center">
                                <a class="px-4 py-2 text-white border-transparent btn bg-violet-500 hover:bg-violet-600 focus:ring focus:ring-violet-50" href="{{ url('/') }}">Back to Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Include the same scripts as the main app -->
        @include('includes.scripts')
    </body>
</html>
