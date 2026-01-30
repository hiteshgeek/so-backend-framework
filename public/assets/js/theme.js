/**
 * Theme Toggle — Dark / Light Mode
 *
 * Creates a fixed toggle button (bottom-left corner),
 * persists the preference in localStorage, and respects prefers-color-scheme.
 */
(function () {
    var iconEl = null;
    var btnEl = null;

    function getTheme() {
        return localStorage.getItem('theme') ||
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    }

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        if (iconEl) {
            iconEl.className = theme === 'dark'
                ? 'mdi mdi-white-balance-sunny'
                : 'mdi mdi-weather-night';
        }
        if (btnEl) {
            btnEl.title = theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        var theme = getTheme();

        // Create toggle button
        btnEl = document.createElement('button');
        btnEl.className = 'theme-toggle';
        btnEl.setAttribute('aria-label', 'Toggle theme');
        btnEl.title = theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';

        iconEl = document.createElement('span');
        iconEl.className = theme === 'dark'
            ? 'mdi mdi-white-balance-sunny'
            : 'mdi mdi-weather-night';
        btnEl.appendChild(iconEl);

        // Fixed position — bottom-left on all pages
        document.body.appendChild(btnEl);

        // Toggle click handler
        btnEl.addEventListener('click', function () {
            var current = document.documentElement.getAttribute('data-theme') || 'light';
            applyTheme(current === 'dark' ? 'light' : 'dark');
        });
    });
})();
