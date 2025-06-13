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
});
