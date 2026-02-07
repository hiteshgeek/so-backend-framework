/**
 * SixOrbit Theme Toggle
 * Supports Light, Dark, and System modes with live OS theme detection
 */
(function() {
    const THEME_KEY = 'theme-preference';
    const THEME_ICONS = {
        'light': 'light_mode',
        'dark': 'dark_mode',
        'system': 'computer'
    };

    /**
     * Get resolved theme (actual light/dark) based on preference
     * @param {string} preference - 'light', 'dark', or 'system'
     * @returns {string} - 'light' or 'dark'
     */
    function getResolvedTheme(preference) {
        if (preference === 'system') {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        return preference;
    }

    /**
     * Apply theme to document
     * @param {string} preference - 'light', 'dark', or 'system'
     */
    function applyTheme(preference) {
        const resolved = getResolvedTheme(preference);
        document.documentElement.setAttribute('data-theme', resolved);
        localStorage.setItem(THEME_KEY, preference);
        updateUI(preference);
    }

    /**
     * Update theme icon and dropdown active state
     * @param {string} preference - Current preference
     */
    function updateUI(preference) {
        // Update theme icon (both .theme-icon class and #themeToggle button)
        const icons = document.querySelectorAll('.theme-icon, #themeToggle .material-icons');
        icons.forEach(icon => {
            icon.textContent = THEME_ICONS[preference] || THEME_ICONS.light;
        });

        // Update dropdown active states
        document.querySelectorAll('[data-theme]').forEach(item => {
            const isActive = item.getAttribute('data-theme') === preference;
            item.classList.toggle('so-active', isActive);
        });
    }

    /**
     * Initialize theme on page load
     */
    function initTheme() {
        const saved = localStorage.getItem(THEME_KEY) || 'light';
        applyTheme(saved);
    }

    // Initialize immediately (before DOMContentLoaded to prevent flash)
    initTheme();

    // Set up event listeners after DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Handle dropdown item clicks
        document.querySelectorAll('[data-theme]').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const theme = this.getAttribute('data-theme');
                applyTheme(theme);

                // Close dropdown if using framework dropdown
                const dropdown = this.closest('.so-dropdown');
                if (dropdown) {
                    dropdown.classList.remove('so-open', 'open');
                }
            });
        });

        // Handle simple toggle button (cycles through light -> dark -> system)
        const toggleBtn = document.getElementById('themeToggle');
        if (toggleBtn && !toggleBtn.closest('.so-dropdown')) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const current = localStorage.getItem(THEME_KEY) || 'light';
                const cycle = { 'light': 'dark', 'dark': 'system', 'system': 'light' };
                applyTheme(cycle[current] || 'light');
            });
        }

        // Update UI after DOM ready (in case elements were added dynamically)
        updateUI(localStorage.getItem(THEME_KEY) || 'light');
    });

    /**
     * Listen for system theme changes
     * When user is in "system" mode, automatically update when OS theme changes
     */
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        const currentPreference = localStorage.getItem(THEME_KEY);
        if (currentPreference === 'system') {
            // Re-apply system theme to update to new OS preference
            applyTheme('system');
        }
    });

    // Expose for external use if needed
    window.SOTheme = {
        apply: applyTheme,
        get: () => localStorage.getItem(THEME_KEY) || 'light',
        getResolved: () => getResolvedTheme(localStorage.getItem(THEME_KEY) || 'light'),
        ICONS: THEME_ICONS
    };
})();
