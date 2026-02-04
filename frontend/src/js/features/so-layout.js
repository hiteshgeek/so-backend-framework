/**
 * SixOrbit UI - Layout Controller
 * Handles sidebar and navbar interactions
 * Platform-agnostic, no jQuery dependency
 */

(function(global) {
    'use strict';

    // Use prefix from SixOrbit config (fallback to 'so' if not available)
    const PREFIX = (global.SixOrbit && global.SixOrbit.PREFIX) || 'so';
    const cls = (...parts) => `${PREFIX}-${parts.join('-')}`;

    // ============================================
    // SIDEBAR MENU GENERATOR CLASS
    // ============================================
    class SixOrbitSidebarMenu {
        /**
         * Create a sidebar menu from JSON data
         * @param {Object} options - Configuration options
         * @param {string} options.containerSelector - Selector for the menu container (ul.so-sidebar-nav)
         * @param {Array} options.menuData - Array of menu items
         * @param {string} options.currentPath - Current page path/id to mark as active
         * @param {Function} options.onItemClick - Callback when menu item is clicked
         */
        constructor(options = {}) {
            this.options = {
                containerSelector: '.so-sidebar-nav',
                menuData: [],
                currentPath: null,
                onItemClick: null,
                ...options
            };

            this.container = null;
            this.menuData = this.options.menuData;
            this.currentPath = this.options.currentPath;

            if (this.menuData.length > 0) {
                this.init();
            }
        }

        init() {
            this.container = document.querySelector(this.options.containerSelector);
            if (!this.container) {
                console.warn('SixOrbitSidebarMenu: Container not found:', this.options.containerSelector);
                return;
            }

            // Clear existing content
            this.container.innerHTML = '';

            // Generate menu HTML
            this.renderMenu(this.menuData, this.container, 1);
        }

        /**
         * Render menu items recursively
         * @param {Array} items - Array of menu items
         * @param {HTMLElement} parent - Parent element to append items to
         * @param {number} level - Current nesting level (1 = top level)
         */
        renderMenu(items, parent, level) {
            items.forEach(item => {
                const li = this.createMenuItem(item, level);
                parent.appendChild(li);
            });
        }

        /**
         * Create a single menu item element
         * @param {Object} item - Menu item data
         * @param {number} level - Current nesting level
         * @returns {HTMLElement} The li element
         */
        createMenuItem(item, level) {
            const li = document.createElement('li');
            li.className = 'so-sidebar-item';

            // Check if this item or any child is current
            const isCurrent = this.isCurrentItem(item);
            const hasCurrentChild = this.hasCurrentChild(item);

            if (isCurrent) {
                li.classList.add('current');
            }

            if (hasCurrentChild || (item.children && item.children.length > 0 && item.open)) {
                li.classList.add('so-open');
            }

            // Create the link
            const link = this.createLink(item, level);
            li.appendChild(link);

            // Create submenu if has children
            if (item.children && item.children.length > 0) {
                li.classList.add('has-children');
                const submenu = document.createElement('ul');
                submenu.className = 'so-sidebar-submenu';
                this.renderMenu(item.children, submenu, level + 1);
                li.appendChild(submenu);
            }

            return li;
        }

        /**
         * Create a link element for a menu item
         * @param {Object} item - Menu item data
         * @param {number} level - Current nesting level
         * @returns {HTMLElement} The anchor element
         */
        createLink(item, level) {
            const link = document.createElement('a');
            link.className = 'so-sidebar-link';

            // Set href based on item type
            if (item.children && item.children.length > 0) {
                link.href = 'javascript:void(0)';
            } else if (item.href) {
                link.href = item.href;
            } else if (item.callback) {
                link.href = 'javascript:void(0)';
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (typeof item.callback === 'function') {
                        item.callback(item, e);
                    } else if (typeof this.options.onItemClick === 'function') {
                        this.options.onItemClick(item, e);
                    }
                });
            } else {
                link.href = '#';
            }

            // Add data-title for tooltip in collapsed mode
            if (item.title) {
                link.setAttribute('data-title', item.title);
            }

            // Add icon (only for level 1 and level 2)
            if (item.icon && level <= 2) {
                const iconSpan = document.createElement('span');
                iconSpan.className = 'so-sidebar-icon';
                iconSpan.innerHTML = `<span class="material-icons">${item.icon}</span>`;
                link.appendChild(iconSpan);
            }

            // Add text
            const textSpan = document.createElement('span');
            textSpan.className = 'so-sidebar-text';
            textSpan.textContent = item.title;
            link.appendChild(textSpan);

            // Add badge if present
            if (item.badge) {
                const badgeSpan = document.createElement('span');
                badgeSpan.className = 'so-sidebar-badge';
                if (item.badgeType) {
                    badgeSpan.classList.add(item.badgeType);
                }
                badgeSpan.textContent = item.badge;
                link.appendChild(badgeSpan);
            }

            // Add arrow for items with children (level 1 only, others get auto-added)
            if (item.children && item.children.length > 0 && level === 1) {
                const arrowSpan = document.createElement('span');
                arrowSpan.className = 'so-sidebar-arrow';
                arrowSpan.innerHTML = '<span class="material-icons">chevron_right</span>';
                link.appendChild(arrowSpan);
            }

            return link;
        }

        /**
         * Check if an item is the current page
         * @param {Object} item - Menu item data
         * @returns {boolean}
         */
        isCurrentItem(item) {
            if (!this.currentPath) return false;
            return item.id === this.currentPath || item.href === this.currentPath;
        }

        /**
         * Check if any child of an item is current
         * @param {Object} item - Menu item data
         * @returns {boolean}
         */
        hasCurrentChild(item) {
            if (!item.children || !this.currentPath) return false;

            for (const child of item.children) {
                if (this.isCurrentItem(child)) return true;
                if (this.hasCurrentChild(child)) return true;
            }
            return false;
        }

        /**
         * Update the current path and refresh highlighting
         * @param {string} path - New current path
         */
        setCurrentPath(path) {
            this.currentPath = path;
            this.init(); // Re-render the menu
        }

        /**
         * Update menu data and re-render
         * @param {Array} menuData - New menu data
         */
        setMenuData(menuData) {
            this.menuData = menuData;
            this.init();
        }

        /**
         * Get menu data
         * @returns {Array} Current menu data
         */
        getMenuData() {
            return this.menuData;
        }
    }

    // ============================================
    // SIXORBIT LAYOUT CLASS
    // ============================================
    class SixOrbitLayout {
        constructor(options = {}) {
            this.options = {
                sidebarSelector: '.so-sidebar',
                navbarSelector: '.so-navbar',
                mainContentSelector: '.so-main-content',
                overlaySelector: '.so-sidebar-overlay',
                toggleSelector: '.so-sidebar-toggle',
                storageKey: 'so-sidebar-state',
                breakpoint: 768,
                menuData: null, // Optional: pass menu data to auto-generate sidebar
                currentPath: null, // Optional: current page path for highlighting
                onMenuItemClick: null, // Optional: callback for menu item clicks
                ...options
            };

            this.sidebar = null;
            this.navbar = null;
            this.mainContent = null;
            this.overlay = null;
            this.toggle = null;
            this.isMobile = false;
            this.isCollapsed = true; // Default to collapsed (mini) mode
            this.sidebarMenu = null; // Reference to menu generator

            this.init();
        }

        // Initialize the layout
        init() {
            this.sidebar = document.querySelector(this.options.sidebarSelector);
            this.navbar = document.querySelector(this.options.navbarSelector);
            this.mainContent = document.querySelector(this.options.mainContentSelector);
            this.overlay = document.querySelector(this.options.overlaySelector);
            this.toggle = document.querySelector(this.options.toggleSelector);

            if (!this.sidebar) return;

            // Disable transitions on initial load to prevent animation flash
            this.sidebar.classList.add('no-transition');

            // Generate menu from JSON data if provided
            if (this.options.menuData) {
                this.sidebarMenu = new SixOrbitSidebarMenu({
                    containerSelector: `${this.options.sidebarSelector} .so-sidebar-nav`,
                    menuData: this.options.menuData,
                    currentPath: this.options.currentPath,
                    onItemClick: this.options.onMenuItemClick
                });
            }

            this.checkMobile();
            this.restoreSidebarState();
            this.bindEvents();
            this.initSubmenuArrows();
            this.initSubmenuState();
            this.updateBodyClass();

            // Re-enable transitions after initial render
            // Use requestAnimationFrame to ensure DOM has painted first
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    this.sidebar.classList.remove('no-transition');
                    // Remove html initial state classes - sidebar now handles its own state
                    document.documentElement.classList.remove('sidebar-collapsed', 'sidebar-pinned');
                    // Mark sidebar as ready
                    document.documentElement.classList.add('sidebar-ready');
                });
            });
        }

        /**
         * Load menu from JSON data
         * @param {Array} menuData - Array of menu items
         * @param {string} currentPath - Current page path for highlighting
         */
        loadMenu(menuData, currentPath = null) {
            if (!this.sidebar) return;

            // Suppress transitions during initial menu render to prevent blink
            this.sidebar.classList.add('no-transition');

            this.sidebarMenu = new SixOrbitSidebarMenu({
                containerSelector: `${this.options.sidebarSelector} .so-sidebar-nav`,
                menuData: menuData,
                currentPath: currentPath,
                onItemClick: this.options.onMenuItemClick
            });

            // Re-init arrows and state after menu load
            this.initSubmenuArrows();
            this.initSubmenuState();

            // Re-enable transitions after render completes
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    this.sidebar.classList.remove('no-transition');
                });
            });
        }

        /**
         * Set the current path and update menu highlighting
         * @param {string} path - Current page path
         */
        setCurrentPath(path) {
            if (this.sidebarMenu) {
                this.sidebarMenu.setCurrentPath(path);
                this.initSubmenuArrows();
                this.initSubmenuState();
            }
        }

        // Check if we're on mobile
        checkMobile() {
            this.isMobile = window.innerWidth <= this.options.breakpoint;
        }

        // Update body class based on sidebar state
        updateBodyClass() {
            if (this.isCollapsed && !this.isMobile) {
                document.body.classList.add('sidebar-collapsed');
            } else {
                document.body.classList.remove('sidebar-collapsed');
            }
        }

        // Bind all event listeners
        bindEvents() {
            // Window resize
            window.addEventListener('resize', this.debounce(() => {
                this.checkMobile();
                if (this.isMobile) {
                    this.closeMobileSidebar();
                }
                this.updateBodyClass();
            }, 150));

            // Sidebar toggle button (pin/unpin)
            if (this.toggle) {
                this.toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.togglePinned();
                });
            }

            // Mobile menu toggle buttons
            const mobileToggleBtns = document.querySelectorAll('[data-toggle="sidebar"]');
            mobileToggleBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (this.isMobile) {
                        this.toggleMobileSidebar();
                    } else {
                        this.togglePinned();
                    }
                });
            });

            // Overlay click (close mobile sidebar)
            if (this.overlay) {
                this.overlay.addEventListener('click', () => {
                    this.closeMobileSidebar();
                });
            }

            // Submenu toggle
            this.sidebar.addEventListener('click', (e) => {
                const link = e.target.closest('.so-sidebar-link');
                if (!link) return;

                const item = link.parentElement;
                const submenu = item.querySelector('.so-sidebar-submenu');

                if (submenu) {
                    e.preventDefault();
                    this.toggleSubmenu(item);
                }
            });

            // Escape key to close mobile sidebar
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isMobile && this.sidebar.classList.contains('so-open')) {
                    this.closeMobileSidebar();
                }
            });
        }

        // Toggle pinned state (collapsed/expanded)
        togglePinned() {
            this.isCollapsed = !this.isCollapsed;

            if (this.isCollapsed) {
                this.sidebar.classList.add('so-collapsed');
                this.sidebar.classList.remove('pinned');
            } else {
                this.sidebar.classList.remove('so-collapsed');
                this.sidebar.classList.add('pinned');
            }

            this.updateBodyClass();
            this.saveSidebarState(this.isCollapsed ? 'collapsed' : 'pinned');

            // Update toggle icon
            this.updateToggleIcon();
        }

        // Update the toggle button state (CSS handles the visual)
        updateToggleIcon() {
            // Toggle state is now handled by CSS via .pinned class
            // No icon update needed - the circular checkbox visual is CSS-based
        }

        // Toggle mobile sidebar
        toggleMobileSidebar() {
            const isOpen = this.sidebar.classList.contains('so-open');

            if (isOpen) {
                this.closeMobileSidebar();
            } else {
                this.openMobileSidebar();
            }
        }

        // Open mobile sidebar
        openMobileSidebar() {
            this.sidebar.classList.add('so-open');
            if (this.overlay) {
                this.overlay.classList.add('so-active');
            }
            document.body.classList.add('sidebar-open');
            document.body.style.overflow = 'hidden';
        }

        // Close mobile sidebar
        closeMobileSidebar() {
            this.sidebar.classList.remove('so-open');
            if (this.overlay) {
                this.overlay.classList.remove('so-active');
            }
            document.body.classList.remove('sidebar-open');
            document.body.style.overflow = '';
        }

        // Toggle submenu
        toggleSubmenu(item) {
            const isOpen = item.classList.contains('so-open');
            const parent = item.parentElement;
            const siblings = parent.querySelectorAll(':scope > .so-sidebar-item.so-open');

            // Batch all DOM changes together in a single operation
            // This ensures both close and open animations start simultaneously
            requestAnimationFrame(() => {
                // Close siblings and toggle current in the same frame
                siblings.forEach(sibling => {
                    if (sibling !== item) {
                        sibling.classList.remove('so-open');
                    }
                });
                item.classList.toggle('so-open', !isOpen);
            });
        }

        // Initialize arrows for submenu items with children
        initSubmenuArrows() {
            // Find all submenu items that have nested submenus
            const itemsWithChildren = this.sidebar.querySelectorAll('.so-sidebar-submenu .so-sidebar-item');
            itemsWithChildren.forEach(item => {
                const nestedSubmenu = item.querySelector(':scope > .so-sidebar-submenu');
                if (nestedSubmenu) {
                    item.classList.add('has-children');
                    // Add arrow if not present
                    const link = item.querySelector(':scope > .so-sidebar-link');
                    if (link && !link.querySelector('.so-sidebar-arrow')) {
                        const arrow = document.createElement('span');
                        arrow.className = 'so-sidebar-arrow';
                        arrow.innerHTML = '<span class="material-icons">chevron_right</span>';
                        link.appendChild(arrow);
                    }
                }
            });
        }

        // Initialize submenu state based on active items
        initSubmenuState() {
            // Open parent submenus of active items
            const activeItems = this.sidebar.querySelectorAll('.so-sidebar-item.current, .so-sidebar-item.active');
            activeItems.forEach(item => {
                let parent = item.parentElement.closest('.so-sidebar-item');
                while (parent) {
                    parent.classList.add('so-open');
                    parent = parent.parentElement.closest('.so-sidebar-item');
                }
            });
        }

        // Save sidebar state to localStorage
        saveSidebarState(state) {
            try {
                localStorage.setItem(this.options.storageKey, state);
            } catch (e) {
                // localStorage not available
            }
        }

        // Restore sidebar state from localStorage
        restoreSidebarState() {
            if (this.isMobile) return;

            try {
                const state = localStorage.getItem(this.options.storageKey);
                if (state === 'pinned') {
                    this.isCollapsed = false;
                    this.sidebar.classList.remove('so-collapsed');
                    this.sidebar.classList.add('pinned');
                } else {
                    // Default to collapsed
                    this.isCollapsed = true;
                    this.sidebar.classList.add('so-collapsed');
                }
                this.updateToggleIcon();
            } catch (e) {
                // localStorage not available - default to collapsed
                this.sidebar.classList.add('so-collapsed');
            }
        }

        // Utility: Debounce function
        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    }

    // ============================================
    // NAVBAR CONTROLLER CLASS
    // ============================================
    class SixOrbitNavbar {
        constructor(options = {}) {
            this.options = {
                navbarSelector: '.so-navbar',
                searchInputSelector: '.so-navbar-search-input',
                searchResultsSelector: '.so-navbar-search-results',
                userBtnSelector: '.so-navbar-user-btn',
                userDropdownSelector: '.so-navbar-user-dropdown',
                outletBtnSelector: '.so-navbar-outlet-btn',
                outletDropdownSelector: '.so-navbar-outlet-dropdown',
                appsBtnSelector: '.so-navbar-apps-btn',
                appsDropdownSelector: '.so-navbar-apps-dropdown',
                appsContainerSelector: '.so-navbar-apps',
                ...options
            };

            this.navbar = null;
            this.activeDropdown = null;

            this.init();
        }

        init() {
            this.navbar = document.querySelector(this.options.navbarSelector);
            if (!this.navbar) return;

            this.bindEvents();
        }

        bindEvents() {
            // Search input - open overlay on focus
            const searchInput = this.navbar.querySelector(this.options.searchInputSelector);
            if (searchInput) {
                searchInput.addEventListener('focus', () => {
                    // Open search overlay instead of inline results
                    if (global.globalSearch) {
                        global.globalSearch.open();
                    }
                });
            }

            // Search clear button
            const searchClear = this.navbar.querySelector('.so-navbar-search-clear');
            if (searchClear && searchInput) {
                searchClear.addEventListener('click', () => {
                    searchInput.value = '';
                    searchInput.focus();
                });
            }

            // User dropdown
            const userBtn = this.navbar.querySelector(this.options.userBtnSelector);
            const userDropdown = this.navbar.querySelector(this.options.userDropdownSelector);
            if (userBtn && userDropdown) {
                userBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleDropdown(userBtn, userDropdown);
                });
            }

            // Outlet selector dropdown
            const outletBtn = this.navbar.querySelector(this.options.outletBtnSelector);
            const outletDropdown = this.navbar.querySelector(this.options.outletDropdownSelector);
            if (outletBtn && outletDropdown) {
                outletBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleDropdown(outletBtn, outletDropdown);
                });

                // Prevent dropdown from closing when clicking inside it
                outletDropdown.addEventListener('click', (e) => {
                    e.stopPropagation();
                });

                // Outlet item selection
                const outletItems = outletDropdown.querySelectorAll('.so-navbar-outlet-item');
                outletItems.forEach(item => {
                    item.addEventListener('click', () => {
                        this.selectOutlet(item, outletBtn, outletDropdown);
                    });
                });

                // Outlet search
                const outletSearch = outletDropdown.querySelector('.so-navbar-outlet-search input');
                if (outletSearch) {
                    outletSearch.addEventListener('input', () => {
                        this.filterOutlets(outletSearch.value, outletItems);
                    });
                }
            }

            // Apps menu dropdown
            const appsContainer = this.navbar.querySelector(this.options.appsContainerSelector);
            const appsBtn = this.navbar.querySelector(this.options.appsBtnSelector);
            if (appsContainer && appsBtn) {
                appsBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    appsContainer.classList.toggle('so-open');
                });
            }

            // Close dropdowns on outside click
            document.addEventListener('click', (e) => {
                this.closeAllDropdowns();
            });

            // Close dropdowns on escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.closeAllDropdowns();
                }
            });

            // Listen for global dropdown close event
            document.addEventListener('closeAllDropdowns', () => {
                this.closeAllDropdowns();
            });
        }

        toggleDropdown(btn, dropdown) {
            const isActive = dropdown.classList.contains('so-active');

            // Emit global event to close all dropdowns across all controllers
            document.dispatchEvent(new CustomEvent('closeAllDropdowns'));

            // Close all other dropdowns first
            this.closeAllDropdowns();

            if (!isActive) {
                btn.classList.add('so-active');
                dropdown.classList.add('so-active');
                this.activeDropdown = { btn, dropdown };
            }
        }

        closeAllDropdowns() {
            const dropdowns = this.navbar.querySelectorAll('.so-navbar-user-dropdown, .so-navbar-outlet-dropdown, .so-navbar-search-results');
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('so-active');
            });

            const btns = this.navbar.querySelectorAll('.so-navbar-user-btn, .so-navbar-outlet-btn');
            btns.forEach(btn => {
                btn.classList.remove('so-active');
            });

            // Close apps menu
            const appsContainer = this.navbar.querySelector(this.options.appsContainerSelector);
            if (appsContainer) {
                appsContainer.classList.remove('so-open');
            }

            this.activeDropdown = null;
        }

        selectOutlet(item, btn, dropdown) {
            // Update selected state
            const items = dropdown.querySelectorAll('.so-navbar-outlet-item');
            items.forEach(i => i.classList.remove('so-selected'));
            item.classList.add('so-selected');

            // Update button text
            const outletText = btn.querySelector('.outlet-text');
            if (outletText) {
                outletText.textContent = item.textContent.trim();
            }

            // Close dropdown
            this.closeAllDropdowns();

            // Emit custom event
            const event = new CustomEvent('outletChanged', {
                detail: {
                    value: item.dataset.value,
                    text: item.textContent.trim()
                }
            });
            this.navbar.dispatchEvent(event);
        }

        filterOutlets(query, items) {
            const lowerQuery = query.toLowerCase();
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(lowerQuery) ? '' : 'none';
            });
        }

        triggerSearch(query) {
            // Emit custom event for search
            const event = new CustomEvent('navbarSearch', {
                detail: { query }
            });
            this.navbar.dispatchEvent(event);
        }
    }

    // ============================================
    // THEME CONTROLLER CLASS
    // ============================================
    class SixOrbitTheme {
        constructor(options = {}) {
            this.options = {
                themeSelector: '.so-navbar-theme',
                themeBtnSelector: '.so-navbar-theme-btn',
                themeDropdownSelector: '.so-navbar-theme-dropdown',
                themeOptionSelector: '.so-navbar-theme-option',
                storageKey: 'so-theme-preference',
                ...options
            };

            this.currentTheme = 'sidebar-dark'; // Default to dark sidebar for new browsers
            this.currentFontSize = 'default'; // Default font size
            this.themeContainer = null;
            this.themeBtn = null;
            this.themeDropdown = null;

            this.init();
        }

        init() {
            this.themeContainer = document.querySelector(this.options.themeSelector);
            if (!this.themeContainer) return;

            this.themeBtn = this.themeContainer.querySelector(this.options.themeBtnSelector);
            this.themeDropdown = this.themeContainer.querySelector(this.options.themeDropdownSelector);

            this.restoreTheme();
            this.restoreFontSize();
            this.bindEvents();
            this.applyTheme();
            this.applyFontSize();
        }

        bindEvents() {
            // Toggle dropdown
            if (this.themeBtn) {
                this.themeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleDropdown();
                });
            }

            // Theme option clicks
            const options = this.themeContainer.querySelectorAll(this.options.themeOptionSelector);
            options.forEach(option => {
                option.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const theme = option.dataset.theme;
                    const fontsize = option.dataset.fontsize;

                    if (theme) {
                        this.setTheme(theme);
                    } else if (fontsize) {
                        this.setFontSize(fontsize);
                    }
                    this.closeDropdown();
                });
            });

            // Close on outside click
            document.addEventListener('click', () => {
                this.closeDropdown();
            });

            // Close on escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.closeDropdown();
                }
            });

            // Listen for system theme changes
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                    if (this.currentTheme === 'system') {
                        this.applyTheme();
                    }
                });
            }

            // Listen for global dropdown close event
            document.addEventListener('closeAllDropdowns', () => {
                this.closeDropdown();
            });
        }

        toggleDropdown() {
            const isOpen = this.themeContainer.classList.contains(cls('open'));

            // Emit global event to close all other dropdowns across all controllers
            if (!isOpen) {
                document.dispatchEvent(new CustomEvent('closeAllDropdowns'));
            }

            this.themeContainer.classList.toggle(cls('open'));
        }

        closeDropdown() {
            if (this.themeContainer) {
                this.themeContainer.classList.remove(cls('open'));
            }
        }

        setTheme(theme) {
            this.currentTheme = theme;
            this.saveTheme();
            this.applyTheme();
            this.updateActiveOption();
        }

        applyTheme() {
            let effectiveTheme = this.currentTheme;
            const sidebar = document.querySelector('.so-sidebar');

            // Handle sidebar-dark theme (dark sidebar with light content)
            if (this.currentTheme === 'sidebar-dark') {
                effectiveTheme = 'light';
                if (sidebar) sidebar.classList.add('sidebar-dark');
            } else {
                // Remove sidebar-dark class for other themes
                if (sidebar) sidebar.classList.remove('sidebar-dark');

                // Resolve system theme
                if (this.currentTheme === 'system') {
                    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        effectiveTheme = 'dark';
                    } else {
                        effectiveTheme = 'light';
                    }
                }
            }

            // Apply theme to document
            document.documentElement.setAttribute('data-theme', effectiveTheme);

            // Update icon
            this.updateIcon(effectiveTheme);
        }

        updateIcon(effectiveTheme) {
            const icon = this.themeBtn?.querySelector('.theme-icon');
            if (!icon) return;

            if (this.currentTheme === 'sidebar-dark') {
                icon.textContent = 'contrast';
            } else if (this.currentTheme === 'system') {
                icon.textContent = 'computer';
            } else if (effectiveTheme === 'dark') {
                icon.textContent = 'dark_mode';
            } else {
                icon.textContent = 'light_mode';
            }
        }

        updateActiveOption() {
            const options = this.themeContainer.querySelectorAll(this.options.themeOptionSelector);
            options.forEach(option => {
                if (option.dataset.theme === this.currentTheme) {
                    option.classList.add(cls('active'));
                } else {
                    option.classList.remove(cls('active'));
                }
            });
        }

        saveTheme() {
            try {
                localStorage.setItem(this.options.storageKey, this.currentTheme);
            } catch (e) {
                // localStorage not available
            }
        }

        restoreTheme() {
            try {
                const saved = localStorage.getItem(this.options.storageKey);
                if (saved && ['light', 'dark', 'system', 'sidebar-dark'].includes(saved)) {
                    this.currentTheme = saved;
                }
            } catch (e) {
                // localStorage not available
            }
            this.updateActiveOption();
        }

        // Font Size Methods
        setFontSize(size) {
            this.currentFontSize = size;
            this.saveFontSize();
            this.applyFontSize();
            this.updateActiveFontSizeOption();
        }

        applyFontSize() {
            // Remove any existing font size attribute if default
            if (this.currentFontSize === 'default') {
                document.documentElement.removeAttribute('data-fontsize');
            } else {
                document.documentElement.setAttribute('data-fontsize', this.currentFontSize);
            }
        }

        updateActiveFontSizeOption() {
            const options = this.themeContainer.querySelectorAll(this.options.themeOptionSelector);
            options.forEach(option => {
                if (option.dataset.fontsize) {
                    if (option.dataset.fontsize === this.currentFontSize) {
                        option.classList.add(cls('active'));
                    } else {
                        option.classList.remove(cls('active'));
                    }
                }
            });
        }

        saveFontSize() {
            try {
                localStorage.setItem('so-fontsize-preference', this.currentFontSize);
            } catch (e) {
                // localStorage not available
            }
        }

        restoreFontSize() {
            try {
                const saved = localStorage.getItem('so-fontsize-preference');
                if (saved && ['small', 'default', 'large'].includes(saved)) {
                    this.currentFontSize = saved;
                }
            } catch (e) {
                // localStorage not available
            }
            this.updateActiveFontSizeOption();
        }

        // Public API
        getTheme() {
            return this.currentTheme;
        }

        getEffectiveTheme() {
            if (this.currentTheme === 'system') {
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    return 'dark';
                }
                return 'light';
            }
            return this.currentTheme;
        }
    }

    // ============================================
    // SIDEBAR FOOTER CONTROLLER CLASS
    // ============================================
    class SixOrbitSidebarFooter {
        constructor(options = {}) {
            this.options = {
                footerSelector: '.so-sidebar-footer',
                infoBtnSelector: '#sidebarInfoBtn',
                fullscreenBtnSelector: '#sidebarFullscreenBtn',
                switchCompanyBtnSelector: '#sidebarSwitchCompanyBtn',
                logoutBtnSelector: '#sidebarLogoutBtn',
                infoPopupSelector: '#sidebarInfoPopup',
                infoTextSelector: '.so-sidebar-footer-info-text',
                // Callbacks
                onSwitchCompany: null,
                onLogout: null,
                ...options
            };

            this.footer = null;
            this.infoPopup = null;
            this.isFullscreen = false;

            this.init();
        }

        init() {
            this.footer = document.querySelector(this.options.footerSelector);
            if (!this.footer) return;

            this.infoPopup = this.footer.querySelector(this.options.infoPopupSelector);

            this.bindEvents();
            this.syncInfoData();
        }

        bindEvents() {
            // Info button - toggle popup
            const infoBtn = this.footer.querySelector(this.options.infoBtnSelector);
            if (infoBtn) {
                infoBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleInfoPopup();
                });
            }

            // Fullscreen button (sidebar)
            const fullscreenBtn = this.footer.querySelector(this.options.fullscreenBtnSelector);
            if (fullscreenBtn) {
                fullscreenBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleFullscreen();
                });
            }

            // Fullscreen button (navbar profile dropdown)
            const navbarFullscreenBtn = document.getElementById('navbarFullscreenBtn');
            if (navbarFullscreenBtn) {
                navbarFullscreenBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleFullscreen();
                });
            }

            // Switch Company button
            const switchCompanyBtn = this.footer.querySelector(this.options.switchCompanyBtnSelector);
            if (switchCompanyBtn) {
                switchCompanyBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.handleSwitchCompany();
                });
            }

            // Logout button
            const logoutBtn = this.footer.querySelector(this.options.logoutBtnSelector);
            if (logoutBtn) {
                logoutBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.handleLogout();
                });
            }

            // Close popup on outside click
            document.addEventListener('click', (e) => {
                if (this.infoPopup && !this.infoPopup.contains(e.target)) {
                    this.closeInfoPopup();
                }
            });

            // Close popup on escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.closeInfoPopup();
                }
            });

            // Listen for fullscreen change (cross-browser)
            document.addEventListener('fullscreenchange', () => {
                this.updateFullscreenIcon();
            });
            document.addEventListener('webkitfullscreenchange', () => {
                this.updateFullscreenIcon();
            });
            document.addEventListener('mozfullscreenchange', () => {
                this.updateFullscreenIcon();
            });
            document.addEventListener('MSFullscreenChange', () => {
                this.updateFullscreenIcon();
            });
        }

        /**
         * Sync info data from HTML data attributes to popup
         * Data attributes are on the footer element itself
         */
        syncInfoData() {
            if (!this.footer) return;

            const serverIp = this.footer.dataset.serverIp;
            const version = this.footer.dataset.version;
            const companyId = this.footer.dataset.companyId;
            const licenceId = this.footer.dataset.licenceId;

            // Update popup values
            const popupServerIp = document.getElementById('popupServerIp');
            const popupVersion = document.getElementById('popupVersion');
            const popupCompanyId = document.getElementById('popupCompanyId');
            const popupLicenceId = document.getElementById('popupLicenceId');

            if (popupServerIp) popupServerIp.textContent = serverIp || '-';
            if (popupVersion) popupVersion.textContent = version || '-';
            if (popupCompanyId) popupCompanyId.textContent = companyId || '-';
            if (popupLicenceId) popupLicenceId.textContent = licenceId || '-';
        }

        /**
         * Set connection info programmatically
         * @param {Object} info - Connection info object
         * @param {string} info.serverIp - Server IP address
         * @param {string} info.version - Software version
         * @param {string} info.companyId - Company ID
         * @param {string} info.licenceId - Licence ID
         */
        setConnectionInfo(info = {}) {
            if (!this.footer) return;

            if (info.serverIp) this.footer.dataset.serverIp = info.serverIp;
            if (info.version) this.footer.dataset.version = info.version;
            if (info.companyId) this.footer.dataset.companyId = info.companyId;
            if (info.licenceId) this.footer.dataset.licenceId = info.licenceId;

            // Sync to popup
            this.syncInfoData();
        }

        toggleInfoPopup() {
            if (this.infoPopup) {
                this.infoPopup.classList.toggle(cls('active'));
            }
        }

        closeInfoPopup() {
            if (this.infoPopup) {
                this.infoPopup.classList.remove(cls('active'));
            }
        }

        toggleFullscreen() {
            const elem = document.documentElement;
            const isFullscreen = document.fullscreenElement ||
                                 document.webkitFullscreenElement ||
                                 document.mozFullScreenElement ||
                                 document.msFullscreenElement;

            if (!isFullscreen) {
                // Enter fullscreen
                if (elem.requestFullscreen) {
                    elem.requestFullscreen().catch(err => {
                        console.warn('Error attempting fullscreen:', err);
                    });
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen(); // Safari
                } else if (elem.mozRequestFullScreen) {
                    elem.mozRequestFullScreen(); // Firefox
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen(); // IE/Edge
                }
            } else {
                // Exit fullscreen
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen(); // Safari
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen(); // Firefox
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen(); // IE/Edge
                }
            }
        }

        updateFullscreenIcon() {
            const isFullscreen = document.fullscreenElement ||
                                 document.webkitFullscreenElement ||
                                 document.mozFullScreenElement ||
                                 document.msFullscreenElement;

            const iconText = isFullscreen ? 'fullscreen_exit' : 'fullscreen';

            // Update sidebar fullscreen button
            const fullscreenBtn = this.footer.querySelector(this.options.fullscreenBtnSelector);
            if (fullscreenBtn) {
                const icon = fullscreenBtn.querySelector('.material-icons');
                if (icon) {
                    icon.textContent = iconText;
                }
            }

            // Update navbar fullscreen button
            const navbarFullscreenBtn = document.getElementById('navbarFullscreenBtn');
            if (navbarFullscreenBtn) {
                const navbarIcon = navbarFullscreenBtn.querySelector('.material-icons');
                if (navbarIcon) {
                    navbarIcon.textContent = iconText;
                }
            }
        }

        handleSwitchCompany() {
            // Close info popup if open
            this.closeInfoPopup();

            // Call callback if provided
            if (this.options.onSwitchCompany) {
                this.options.onSwitchCompany();
            }

            // Emit custom event
            const event = new CustomEvent('sidebarSwitchCompany', {
                detail: { companyId: this.getCompanyId() }
            });
            document.dispatchEvent(event);
        }

        handleLogout() {
            // Close info popup if open
            this.closeInfoPopup();

            // Call callback if provided
            if (this.options.onLogout) {
                this.options.onLogout();
            }

            // Emit custom event
            const event = new CustomEvent('sidebarLogout');
            document.dispatchEvent(event);
        }

        // Getters for connection info
        getServerIp() {
            return this.footer?.dataset.serverIp || null;
        }

        getVersion() {
            return this.footer?.dataset.version || null;
        }

        getCompanyId() {
            return this.footer?.dataset.companyId || null;
        }

        getLicenceId() {
            return this.footer?.dataset.licenceId || null;
        }
    }

    // ============================================
    // AUTO-INITIALIZE
    // ============================================
    function initSixOrbitLayout() {
        // Initialize layout components
        const layout = new SixOrbitLayout();
        const navbar = new SixOrbitNavbar();
        const theme = new SixOrbitTheme();
        const sidebarFooter = new SixOrbitSidebarFooter();

        // Expose to global scope
        global.SixOrbitLayout = SixOrbitLayout;
        global.SixOrbitNavbar = SixOrbitNavbar;
        global.SixOrbitTheme = SixOrbitTheme;
        global.SixOrbitSidebarMenu = SixOrbitSidebarMenu;
        global.SixOrbitSidebarFooter = SixOrbitSidebarFooter;
        global.soLayout = layout;
        global.soNavbar = navbar;
        global.soTheme = theme;
        global.soSidebarFooter = sidebarFooter;
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSixOrbitLayout);
    } else {
        initSixOrbitLayout();
    }

})(typeof window !== 'undefined' ? window : this);
