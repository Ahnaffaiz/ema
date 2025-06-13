<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('./assets/images/favicon.ico') }}">

<!-- CSS -->
<link rel="stylesheet" href="{{ asset('./assets/css/swiper-bundle.css') }}">

<!-- Vite Assets - includes all SCSS and CSS files for hot reloading -->
@vite([
    'resources/css/app.css',
    'resources/js/app.js',
    'public/assets/scss/icons.scss',
    'public/assets/scss/tailwind.scss'
])

@livewireStyles
@stack('styles')

<!-- Tailwind custom dropdown transitions -->
<style>
    /* Only using Tailwind utilities for dropdown animations */
    .dropdown-menu,
    .submenu,
    .sidebar-dropdown {
        @apply transition-all duration-300 ease-out transform origin-top opacity-0 scale-95 invisible;
    }

    .dropdown-menu.show,
    .submenu.show,
    .sidebar-dropdown.show {
        @apply opacity-100 scale-100 visible;
    }

    .sidebar .dropdown-toggle::after,
    .sidebar .nav-link[data-bs-toggle="collapse"]::after {
        @apply transition-transform duration-200;
    }

    .sidebar .dropdown-toggle[aria-expanded="true"]::after,
    .sidebar .nav-link[data-bs-toggle="collapse"][aria-expanded="true"]::after {
        @apply transform rotate-180;
    }

    /* Custom checkbox styles - indigo color */
    input[type="checkbox"] {
        @apply w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 focus:ring-offset-0;
    }

    input[type="checkbox"]:checked {
        background-color: #4f46e5 !important; /* indigo-600 */
        border-color: #4f46e5 !important;
    }

    input[type="checkbox"]:focus {
        --tw-ring-color: #818cf8 !important; /* indigo-400 */
        --tw-ring-opacity: 0.5 !important;
    }    /* Dark mode checkbox styles */
    .dark input[type="checkbox"] {
        @apply border-zinc-600 bg-zinc-700;
    }

    .dark input[type="checkbox"]:checked {
        background-color: #4f46e5 !important; /* indigo-600 */
        border-color: #4f46e5 !important;
    }

    /* ===== THEME SYSTEM ===== */

    /* Root variables for theme consistency */
    :root {
        --transition-theme: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Apply smooth transitions to all elements during theme changes */
    *,
    *::before,
    *::after {
        transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
    }

    /* Ensure Alpine.js components work properly */
    [x-cloak] {
        display: none !important;
    }

    /* Theme toggle button animations */
    .theme-toggle-btn {
        position: relative;
        overflow: hidden;
    }

    .theme-toggle-btn i {
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    /* Dark mode specific overrides for better visibility */
    .dark {
        color-scheme: dark;
    }

    .dark body {
        background-color: rgb(24 24 27);
        color: rgb(244 244 245);
    }

    /* Navbar specific dark mode styling */
    .dark nav {
        border-color: rgba(255, 255, 255, 0.1);
    }

    /* Enhanced navbar background for glassmorphism effect */
    .navbar-glass {
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        box-shadow:
            0 8px 32px rgba(0, 0, 0, 0.06),
            0 1px 0 rgba(255, 255, 255, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.1);
    }

    .dark .navbar-glass {
        background: rgba(24, 24, 27, 0.2) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        box-shadow:
            0 8px 32px rgba(0, 0, 0, 0.3),
            0 1px 0 rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.05);
    }

    /* Force consistent transparent navbar background */
    .dark nav .navbar-glass {
        background: rgba(24, 24, 27, 0.2) !important;
    }

    /* Override Alpine.js dynamic classes for glassmorphism */
    .dark nav > div[class*="bg-zinc-900"] {
        background-color: rgba(24, 24, 27, 0.2) !important;
    }

    nav > div[class*="bg-white"] {
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    /* Mobile menu glassmorphism */
    .mobile-menu-bg {
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        background: rgba(255, 255, 255, 0.15) !important;
        box-shadow:
            0 8px 32px rgba(0, 0, 0, 0.06),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .dark .mobile-menu-bg {
        background: rgba(24, 24, 27, 0.25) !important;
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        box-shadow:
            0 8px 32px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.05);
    }

    /* Dropdown glassmorphism */
    .dropdown-glass {
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        background: rgba(255, 255, 255, 0.15) !important;
        box-shadow:
            0 8px 32px rgba(0, 0, 0, 0.06),
            0 1px 0 rgba(255, 255, 255, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .dark .dropdown-glass {
        background: rgba(24, 24, 27, 0.25) !important;
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        box-shadow:
            0 8px 32px rgba(0, 0, 0, 0.3),
            0 1px 0 rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Enhanced dropdown glassmorphism */
    .dropdown-glass-enhanced {
        backdrop-filter: blur(32px);
        -webkit-backdrop-filter: blur(32px);
        background: rgba(255, 255, 255, 0.08) !important;
        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.1),
            0 4px 8px rgba(0, 0, 0, 0.06),
            0 1px 0 rgba(255, 255, 255, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .dark .dropdown-glass-enhanced {
        background: rgba(24, 24, 27, 0.15) !important;
        backdrop-filter: blur(32px);
        -webkit-backdrop-filter: blur(32px);
        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.4),
            0 4px 8px rgba(0, 0, 0, 0.2),
            0 1px 0 rgba(255, 255, 255, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Solid dropdown glassmorphism - reduced transparency */
    .dropdown-glass-solid {
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.80) !important;
        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.12),
            0 4px 8px rgba(0, 0, 0, 0.08),
            0 1px 0 rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .dark .dropdown-glass-solid {
        background: rgba(24, 24, 27, 0.80) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.5),
            0 4px 8px rgba(0, 0, 0, 0.3),
            0 1px 0 rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.12);
    }

    /* Navbar glassmorphism enhancement */
    nav > div {
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dark nav > div {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    /* Navbar text contrast improvements */
    .dark nav .text-gray-700 {
        color: rgb(209 213 219) !important;
    }

    .dark nav .text-gray-900 {
        color: rgb(255 255 255) !important;
    }

    /* Improve contrast for dark mode text */
    .dark .text-gray-700 {
        color: rgb(156 163 175);
    }

    .dark .text-gray-900 {
        color: rgb(244 244 245);
    }

    /* Enhanced glassmorphism for dark mode */
    .dark .backdrop-blur-md {
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
    }

    /* Enhanced navbar text contrast for dark mode */
    .dark nav .text-gray-700 {
        color: rgb(229 231 235) !important; /* gray-200 */
    }

    .dark nav .text-gray-900 {
        color: rgb(249 250 251) !important; /* gray-50 */
    }

    .dark nav .text-gray-600 {
        color: rgb(209 213 219) !important; /* gray-300 */
    }

    /* Better text shadows for dark mode readability */
    .dark nav a,
    .dark nav button,
    .dark nav span {
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }

    /* Icon visibility in dark mode */
    .dark nav i {
        filter: drop-shadow(0 1px 1px rgba(0, 0, 0, 0.3));
    }

    /* Mobile menu text enhancement */
    .dark .mobile-menu-bg ~ * a {
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
    }
</style>
