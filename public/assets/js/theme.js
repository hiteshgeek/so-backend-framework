/**
 * Theme Toggle — Dark / Light Mode
 *
 * Creates a fixed toggle button (bottom-left corner),
 * persists the preference in localStorage, and respects prefers-color-scheme.
 * Also manages the Highlight.js syntax theme (github / github-dark).
 */
(function () {
    var iconEl = null;
    var btnEl = null;
    var hljsLinkEl = null;

    var HLJS_LIGHT = 'https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/github.min.css';
    var HLJS_DARK = 'https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/github-dark.min.css';

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
        if (hljsLinkEl) {
            hljsLinkEl.href = theme === 'dark' ? HLJS_DARK : HLJS_LIGHT;
        }
    }

    // Inject Highlight.js theme <link> into <head> immediately
    var theme = getTheme();
    hljsLinkEl = document.createElement('link');
    hljsLinkEl.rel = 'stylesheet';
    hljsLinkEl.id = 'hljs-theme';
    hljsLinkEl.href = theme === 'dark' ? HLJS_DARK : HLJS_LIGHT;
    document.head.appendChild(hljsLinkEl);

    document.addEventListener('DOMContentLoaded', function () {
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
