<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <!-- Background gradient that adapts to theme -->
        <div class="absolute inset-0 bg-gradient-to-br from-black/20 via-transparent to-purple-900/20"></div>

        <!-- Hero Content -->
        <div class="relative px-6 py-20 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                    Welcome to
                    <span class="bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 bg-clip-text text-transparent">
                        {{ ENV('APP_NAME') }}
                    </span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-200">
                    Experience our beautiful, modern design with glassmorphism effects and perfect dark mode integration.
                    Try the theme toggle button in the navbar above!
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <button onclick="toggleTheme()" class="btn-accent rounded-md px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:transform hover:scale-105">
                        <i class="fas fa-palette mr-2"></i>
                        Toggle Theme
                    </button>
                    <a href="{{ route('events.create') }}" class="text-sm font-semibold leading-6 text-gray-200 hover:text-blue-400 transition-colors duration-300">
                        Create Event <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Demo Section -->
    <div class="py-24 sm:py-32 bg-white/5 dark:bg-black/10 backdrop-blur-sm">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-base font-semibold leading-7 text-blue-400 dark:text-blue-300">Modern Design</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-white dark:text-white sm:text-4xl">
                    Elegant Blue Theme Integration
                </p>
                <p class="mt-6 text-lg leading-8 text-gray-200 dark:text-gray-200">
                    Our application features beautiful blue gradients with elegant abstract smoke effects and premium glassmorphism design.
                </p>
            </div>

            <!-- Theme Demo Cards -->
            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="glass-card group relative p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:transform hover:scale-105 accent-glow">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-moon text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Blue Theme</h3>
                    </div>
                    <p class="text-gray-200">
                        Beautiful blue-themed design with elegant smoke effects and glassmorphism for optimal readability and eye comfort.
                    </p>
                </div>

                <div class="glass-card group relative p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:transform hover:scale-105 accent-glow">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center shadow-lg">
                            <i class="fas fa-sun text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Light Mode</h3>
                    </div>
                    <p class="text-gray-200">
                        Clean and bright light theme with glass effects perfect for daytime use with excellent contrast ratios.
                    </p>
                </div>

                <div class="glass-card group relative p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:transform hover:scale-105 accent-glow">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-emerald-400 to-blue-500 flex items-center justify-center shadow-lg">
                            <i class="fas fa-magic text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Elegant Effects</h3>
                    </div>
                    <p class="text-gray-200">
                        Sophisticated abstract smoke patterns and wisp animations that create depth and visual interest.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:max-w-none">
                <div class="text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Quick Stats
                    </h2>
                    <p class="mt-4 text-lg leading-8 text-gray-600 dark:text-gray-300">
                        Here's how your application is performing
                    </p>
                </div>
                <dl class="mt-16 grid grid-cols-1 gap-0.5 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-4">
                    <div class="flex flex-col bg-white dark:bg-zinc-800 p-8">
                        <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">Total Events</dt>
                        <dd class="order-first text-3xl font-bold tracking-tight text-gray-900 dark:text-white">0</dd>
                    </div>
                    <div class="flex flex-col bg-white dark:bg-zinc-800 p-8">
                        <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">Active Users</dt>
                        <dd class="order-first text-3xl font-bold tracking-tight text-gray-900 dark:text-white">1</dd>
                    </div>
                    <div class="flex flex-col bg-white dark:bg-zinc-800 p-8">
                        <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">Events This Month</dt>
                        <dd class="order-first text-3xl font-bold tracking-tight text-gray-900 dark:text-white">0</dd>
                    </div>
                    <div class="flex flex-col bg-white dark:bg-zinc-800 p-8">
                        <dt class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-400">Success Rate</dt>
                        <dd class="order-first text-3xl font-bold tracking-tight text-gray-900 dark:text-white">100%</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
