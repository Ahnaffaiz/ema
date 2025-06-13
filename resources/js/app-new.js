import './bootstrap';
import Alpine from 'alpinejs';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Theme JavaScript Integration
document.addEventListener('DOMContentLoaded', () => {
    // Initialize feather icons if available
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    // Initialize metismenu if available
    const metisMenuElement = document.querySelector('#side-menu');
    if (typeof MetisMenu !== 'undefined' && metisMenuElement) {
        new MetisMenu('#side-menu');
    }

    // Initialize simplebar if available
    document.querySelectorAll('[data-simplebar]').forEach(element => {
        if (typeof SimpleBar !== 'undefined') {
            new SimpleBar(element);
        }
    });

    // Handle theme mode toggling
    const themeToggleButtons = document.querySelectorAll('[data-toggle-theme]');
    themeToggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const body = document.body;
            const currentMode = body.getAttribute('data-mode');
            const newMode = currentMode === 'light' ? 'dark' : 'light';
            body.setAttribute('data-mode', newMode);
            localStorage.setItem('theme-mode', newMode);
        });
    });

    // Initialize theme based on local storage preference
    const savedTheme = localStorage.getItem('theme-mode');
    if (savedTheme) {
        document.body.setAttribute('data-mode', savedTheme);
    }
});
