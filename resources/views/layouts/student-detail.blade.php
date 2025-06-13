<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>{{ $title ?? 'Detail Kartu Ujian' }} - CBT Erudify</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Computer Based Test System" name="description">
        <meta content="Erudify" name="author">

        @include('includes.styles')
    </head>

    <body data-mode="light" data-sidebar-size="lg" class="flex flex-col min-h-screen bg-white dark:bg-zinc-600">
        <div class="flex flex-col flex-grow dark:bg-zinc-700">
            <div class="flex items-center justify-center flex-grow page-content">
                {{ $slot }}
            </div>
        </div>

        <!-- Fixed bottom controls -->
        <div class="fixed bottom-4 left-4">
            <!-- Dark/Light Mode Toggle -->
            <button id="dark-mode-toggle" class="p-2 text-sm font-medium text-gray-700 rounded-md bg-none hover:text-gray-500 dark:text-gray-200 dark:hover:bg-zinc-600">
                <i class="bx bx-moon dark:hidden"></i>
                <i class="hidden bx bx-sun dark:inline-block"></i>
            </button>
        </div>

        @include('includes.scripts')
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
    </body>
</html>
