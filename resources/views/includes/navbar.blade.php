<nav x-data="{
        scrolled: false,
        mobileMenuOpen: false,
        userDropdownOpen: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.pageYOffset > 10;
            });
        }
    }"
    class="sticky top-0 z-50 flex flex-col items-center justify-center px-2 pt-px sm:px-4"
    aria-label="Main Navigation">

    <div :class="{
            'ring-gray-200/60 dark:ring-gray-700/40 bg-white/40 dark:bg-zinc-900/40 translate-y-3': scrolled,
            'ring-gray-200/20 dark:ring-gray-700/20 bg-white/20 dark:bg-zinc-900/20': !scrolled,
        }"
        class="flex items-center justify-between w-full gap-3 px-3 py-3 mx-auto transition duration-200 ease-out max-w-7xl sm:px-4 rounded-2xl ring-1 backdrop-blur-xl navbar-glass">

        <!-- Brand -->
        <div class="flex items-center gap-3">
            <a href="{{ url('/') }}" aria-label="Homepage" class="flex items-center gap-2">
                <div class="flex items-center justify-center w-6 h-6 rounded-lg sm:w-8 sm:h-8 bg-gradient-to-br from-indigo-600 to-purple-600">
                    <span class="text-sm font-bold text-white sm:text-base">{{ substr(ENV('APP_NAME'), 0, 1) }}</span>
                </div>
                <span class="text-sm font-semibold text-gray-900 dark:text-gray-50 sm:text-base">{{ ENV('APP_NAME') }}</span>
            </a>
        </div>

        <!-- Navigation Menu -->
        <div class="flex items-center gap-4 text-sm" aria-label="Primary navigation">
            <!-- Home (Dashboard) Link -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 font-medium text-gray-900 transition-colors duration-200 rounded-xl dark:text-gray-50 hover:text-blue-600 dark:hover:text-blue-400">
                <i class="w-4 h-4 transition-colors duration-200 fas fa-home"></i>
                <span class="hidden lg:block">Home</span>
            </a>

            <!-- Events Link -->
            <a href="{{ route('events.list') }}" class="flex items-center gap-2 px-4 py-2.5 text-gray-700 transition-colors duration-200 rounded-xl dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                <i class="w-4 h-4 transition-colors duration-200 fas fa-calendar-alt"></i>
                <span class="hidden lg:block">Events</span>
            </a>

            <!-- Users Link (Admin only) -->
            <a href="{{ route('users') }}" class="items-center hidden gap-2 px-3 py-2 text-gray-700 transition-colors duration-200 rounded-lg xl:flex dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                <i class="w-4 h-4 transition-colors duration-200 fas fa-users"></i>
                <span>Users</span>
            </a>

            <!-- Create Event Button -->
            <a href="{{ route('events.create') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition duration-200 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="w-4 h-4 fas fa-plus"></i>
                <span class="hidden sm:block">Create Event</span>
            </a>

            <!-- User Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center gap-2 p-2 transition-all duration-300 rounded-lg opacity-60 group">
                    <div class="flex items-center justify-center w-6 h-6 transition-all duration-300 rounded-full bg-gradient-to-br from-blue-500 to-blue-600">
                        <span class="text-xs font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <span class="hidden text-sm font-medium text-gray-700 transition-all duration-300 opacity-100 sm:block hover:opacity-100 dark:text-gray-200 dark:hover:text-gray-50">{{ Auth::user()->name }}</span>
                    <i class="w-3 h-3 text-gray-600 transition-all duration-300 opacity-100 fas fa-chevron-down hover:opacity-100 dark:text-gray-200 dark:hover:text-gray-50" :class="{ 'rotate-180': open }"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                    @click.away="open = false"
                    class="absolute right-0 z-50 w-64 mt-3 shadow-2xl rounded-2xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl ring-1 ring-white/30 dark:ring-gray-700/30 dropdown-glass-solid">

                    <div class="p-5 border-b border-gray-200/30 dark:border-gray-700/30">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-12 h-12 rounded-full shadow-lg bg-gradient-to-br from-blue-500 to-blue-600">
                                <span class="text-lg font-semibold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-gray-50">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 transition duration-200 rounded-xl dark:text-gray-200 opacity-60 hover:opacity-100 hover:bg-gray-100/50 dark:hover:bg-gray-700/50">
                            <i class="w-4 h-4 fas fa-user"></i>
                            Profile
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 transition duration-200 rounded-xl dark:text-gray-200 opacity-60 hover:opacity-100 hover:bg-gray-100/50 dark:hover:bg-gray-700/50">
                            <i class="w-4 h-4 fas fa-cog"></i>
                            Settings
                        </a>
                        <div class="my-3 border-t border-gray-200/30 dark:border-gray-700/30"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center w-full gap-3 px-4 py-3 text-sm font-medium text-left text-red-600 transition duration-200 rounded-xl dark:text-red-400 opacity-60 hover:opacity-100 hover:bg-red-50/50 dark:hover:bg-red-900/20">
                                <i class="w-4 h-4 fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen"
            type="button"
            class="p-1 text-gray-500 rounded-md lg:hidden focus:outline-none dark:text-gray-400">
            <span class="sr-only">Open main menu</span>
            <!-- Menu icon -->
            <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <!-- Close icon -->
            <svg x-show="mobileMenuOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 w-full h-full overflow-y-auto lg:hidden"
        style="display: none;">

        <!-- Glassy background -->
        <div class="absolute inset-0 bg-white/20 dark:bg-zinc-900/20 backdrop-blur-xl ring-1 ring-gray-200/30 dark:ring-gray-700/30 mobile-menu-bg"></div>

        <!-- Content container -->
        <div class="relative flex flex-col items-center justify-center h-full p-6">
            <div class="w-full mx-auto space-y-6 max-w-7xl">
                <!-- Close button at the top right -->
                <div class="flex justify-end">
                    <button @click="mobileMenuOpen = false"
                        class="p-2 text-gray-500 rounded-full hover:bg-gray-100/50 dark:hover:bg-gray-800/50 dark:text-gray-400 focus:outline-none">
                        <span class="sr-only">Close menu</span>
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation links -->
                <div class="space-y-4 text-center">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center justify-center gap-3 px-6 py-4 text-lg font-medium text-gray-900 transition-colors duration-200 rounded-2xl dark:text-gray-500 hover:text-blue-600 dark:hover:text-blue-400">
                        <i class="w-5 h-5 transition-colors duration-200 fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('events.list') }}"
                        class="flex items-center justify-center gap-3 px-6 py-4 text-lg font-medium text-gray-700 transition-colors duration-200 rounded-2xl dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400">
                        <i class="w-5 h-5 transition-colors duration-200 fas fa-calendar-alt"></i>
                        <span>Events</span>
                    </a>

                    <!-- Mobile Search -->
                    <div class="px-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="w-4 h-4 text-gray-400 fas fa-search dark:text-gray-500"></i>
                            </div>
                            <input type="text"
                                   placeholder="Search events..."
                                   class="w-full py-3 pl-10 pr-4 text-lg text-gray-900 placeholder-gray-500 border rounded-lg bg-white/10 border-white/20 backdrop-blur-sm dark:bg-gray-800/30 dark:border-gray-600/30 focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-gray-100 dark:placeholder-gray-400"
                                   @keydown.enter="performSearch()">
                        </div>
                    </div>

                    <a href="{{ route('users') }}"
                        class="flex items-center justify-center gap-3 py-3 text-lg font-medium text-gray-700 transition-colors duration-200 rounded-lg dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400">
                        <i class="w-5 h-5 transition-colors duration-200 fas fa-users"></i>
                        Users
                    </a>
                    <a href="{{ route('events.create') }}"
                        class="flex items-center justify-center gap-3 py-3 text-lg font-medium text-white transition duration-200 rounded-lg shadow-lg bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700">
                        <i class="w-5 h-5 fas fa-plus"></i>
                        Create Event
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
// Initialize theme - Default to dark mode
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');

    // If no saved theme, default to dark mode
    if (!savedTheme) {
        localStorage.setItem('theme', 'dark');
        document.documentElement.classList.add('dark');
    } else if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});

// Search functionality
let searchTimeout;

function debounceSearch(query) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        if (query.length >= 2) {
            searchEvents(query);
        } else {
            hideSearchResults();
        }
    }, 300);
}

function searchEvents(query) {
    // You can implement AJAX search here
    console.log('Searching for:', query);

    // Example implementation (you'll need to create the route)
    // fetch(`/search/events?q=${encodeURIComponent(query)}`)
    //     .then(response => response.json())
    //     .then(data => displaySearchResults(data))
    //     .catch(error => console.error('Search error:', error));
}

function performSearch() {
    const searchInput = document.querySelector('input[placeholder="Search events..."]');
    const query = searchInput.value.trim();

    if (query) {
        // Redirect to events page with search parameter
        window.location.href = `{{ route('events.list') }}?search=${encodeURIComponent(query)}`;
    }
}

function hideSearchResults() {
    const resultsContainer = document.getElementById('search-results');
    if (resultsContainer) {
        resultsContainer.style.display = 'none';
    }
}

function displaySearchResults(results) {
    // You can implement search results display here
    console.log('Search results:', results);
}
</script>
