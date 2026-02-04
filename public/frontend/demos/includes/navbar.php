<?php

/**
 * SixOrbit UI Demo - Navbar Component
 * Matches original first_draft/sixorbit-ui/index.html navbar exactly
 */
?>
<!-- Navbar -->
<nav class="so-navbar">
    <div class="so-navbar-container">
        <!-- Left Section (Mobile toggle only) -->
        <div class="so-navbar-left">
            <button class="so-navbar-toggle" data-toggle="sidebar" title="Toggle Menu">
                <span class="material-icons">menu</span>
            </button>
        </div>

        <!-- Center Section - Search -->
        <div class="so-navbar-center">
            <div class="so-navbar-search">
                <div class="so-navbar-search-wrapper">
                    <span class="material-icons so-navbar-search-icon">search</span>
                    <input type="text" class="so-navbar-search-input" placeholder="Search what you want to do.. [CTRL + K]" autocomplete="off" name="so_nav_search_q" data-lpignore="true" data-form-type="other" readonly onfocus="this.removeAttribute('readonly')">
                    <button class="so-navbar-search-clear">
                        <span class="material-icons">close</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="so-navbar-right">
            <!-- Outlet Selector -->
            <div class="so-dropdown so-dropdown-searchable so-dropdown-fixed dropdown-right" id="outletSelector"
                 data-so-multiple="true"
                 data-so-multiple-style="check"
                 data-so-min-selections="1"
                 data-so-show-actions="true"
                 data-so-select-none-text=""
                 data-so-all-selected-text="All Outlets"
                 data-so-multiple-selected-text="{count} Outlets">
                <button class="so-btn so-btn-default so-dropdown-trigger" type="button" title="Select Outlet">
                    <span class="material-icons">storefront</span>
                    <span class="so-dropdown-selected">All Outlets</span>
                    <span class="material-icons so-dropdown-arrow">expand_more</span>
                </button>
                <div class="so-dropdown-menu">
                    <div class="so-dropdown-search">
                        <input type="text" class="so-dropdown-search-input" placeholder="Search outlets...">
                    </div>
                    <div class="so-dropdown-items">
                        <a href="#" class="so-dropdown-item so-active" data-value="head-office">
                            <span>TROVE Head Office</span>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item so-active" data-value="basavanagudi">
                            <span>TROVE Basavanagudi</span>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item so-active" data-value="jayanagar">
                            <span>TROVE Jayanagar</span>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item so-active" data-value="indiranagar">
                            <span>TROVE Indiranagar</span>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="so-navbar-divider"></div>

            <!-- User Status Selector -->
            <div class="so-dropdown dropdown-right so-dropdown-no-scroll so-dropdown-nowrap" id="userStatusSelector">
                <button class="so-btn so-btn-default so-dropdown-trigger" type="button" title="Set your status">
                    <span class="status-indicator available" id="statusIndicator"></span>
                    <span class="so-dropdown-text" id="statusText">Available</span>
                    <span class="material-icons so-dropdown-arrow">expand_more</span>
                </button>
                <div class="so-dropdown-menu">
                    <div class="so-dropdown-header">
                        <span class="material-icons">schedule</span>
                        Set Your Status
                    </div>
                    <div class="so-dropdown-items">
                        <a href="#" class="so-dropdown-item so-active" data-status="available">
                            <span class="status-indicator available"></span>
                            <div class="status-option-content">
                                <span class="status-option-title">Available</span>
                                <span class="status-option-desc">Ready for new assignments</span>
                            </div>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item" data-status="with-customer">
                            <span class="status-indicator with-customer"></span>
                            <div class="status-option-content">
                                <span class="status-option-title">With Customer</span>
                                <span class="status-option-desc">Attending a walk-in customer</span>
                            </div>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item" data-status="in-meeting">
                            <span class="status-indicator in-meeting"></span>
                            <div class="status-option-content">
                                <span class="status-option-title">In Meeting</span>
                                <span class="status-option-desc">In a scheduled meeting</span>
                            </div>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item" data-status="on-call">
                            <span class="status-indicator on-call"></span>
                            <div class="status-option-content">
                                <span class="status-option-title">On Call</span>
                                <span class="status-option-desc">On a phone/video call</span>
                            </div>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item" data-status="on-leave">
                            <span class="status-indicator on-leave"></span>
                            <div class="status-option-content">
                                <span class="status-option-title">On Leave</span>
                                <span class="status-option-desc">Not available today</span>
                            </div>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item" data-status="away">
                            <span class="status-indicator away"></span>
                            <div class="status-option-content">
                                <span class="status-option-title">Away</span>
                                <span class="status-option-desc">Temporarily away from desk</span>
                            </div>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="so-navbar-divider"></div>

            <!-- Keyboard Shortcuts -->
            <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost" id="keyboardShortcutsBtn" title="Keyboard Shortcuts">
                <span class="material-icons">keyboard</span>
            </button>

            <!-- Settings Icon -->
            <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost" title="Settings">
                <span class="material-icons">settings</span>
            </button>

            <!-- Theme Switcher -->
            <div class="so-dropdown dropdown-right" id="themeSwitcher">
                <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost so-dropdown-trigger" type="button" title="Theme">
                    <span class="material-icons theme-icon">light_mode</span>
                </button>
                <div class="so-dropdown-menu">
                    <div class="so-dropdown-header">
                        <span class="material-icons">palette</span>
                        Appearance
                    </div>
                    <div class="so-dropdown-items" data-group="theme">
                        <a href="#" class="so-dropdown-item so-active" data-theme="light">
                            <span class="material-icons">light_mode</span>
                            <span>Light</span>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item" data-theme="dark">
                            <span class="material-icons">dark_mode</span>
                            <span>Dark</span>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item" data-theme="system">
                            <span class="material-icons">computer</span>
                            <span>System</span>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item" data-theme="sidebar-dark">
                            <span class="material-icons">contrast</span>
                            <span>Dark Sidebar</span>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                    </div>
                    <div class="so-dropdown-divider"></div>
                    <div class="so-dropdown-header">
                        <span class="material-icons">format_size</span>
                        Font Size
                    </div>
                    <div class="so-dropdown-items" data-group="fontsize">
                        <a href="#" class="so-dropdown-item" data-fontsize="small">
                            <span class="material-icons">text_decrease</span>
                            <span>Small</span>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item so-active" data-fontsize="default">
                            <span class="material-icons">format_size</span>
                            <span>Default</span>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                        <a href="#" class="so-dropdown-item" data-fontsize="large">
                            <span class="material-icons">text_increase</span>
                            <span>Large</span>
                            <span class="material-icons so-dropdown-check">check</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Apps Menu (Google-like) -->
            <div class="so-navbar-apps">
                <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost so-navbar-apps-btn" title="Apps">
                    <span class="material-icons">apps</span>
                </button>
                <div class="so-navbar-apps-dropdown">
                    <div class="so-navbar-apps-header">Quick Access</div>
                    <div class="so-navbar-apps-grid">
                        <a href="video-tutorial.php" class="so-navbar-apps-item">
                            <div class="so-navbar-apps-icon" style="background: #ea4335;">
                                <span class="material-icons">play_circle</span>
                            </div>
                            <span class="so-navbar-apps-label">Video Tutorial</span>
                        </a>
                        <a href="#" class="so-navbar-apps-item">
                            <div class="so-navbar-apps-icon" style="background: #4285f4;">
                                <span class="material-icons">auto_fix_high</span>
                            </div>
                            <span class="so-navbar-apps-label">System Wizard</span>
                        </a>
                        <a href="#" class="so-navbar-apps-item">
                            <div class="so-navbar-apps-icon" style="background: #34a853;">
                                <span class="material-icons">help_outline</span>
                            </div>
                            <span class="so-navbar-apps-label">Help Center</span>
                        </a>
                        <a href="#" class="so-navbar-apps-item">
                            <div class="so-navbar-apps-icon" style="background: #fbbc04;">
                                <span class="material-icons">support_agent</span>
                            </div>
                            <span class="so-navbar-apps-label">Support</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="so-navbar-divider"></div>

            <!-- User Menu -->
            <div class="so-navbar-user">
                <button class="so-btn so-btn-avatar so-btn-info so-navbar-user-btn"><?= substr(DEMO_USER_NAME, 0, 1) ?></button>
                <div class="so-navbar-user-dropdown">
                    <div class="so-navbar-user-header">
                        <div class="so-navbar-user-header-avatar" data-color="teal"><?= substr(DEMO_USER_NAME, 0, 1) ?></div>
                        <div class="so-navbar-user-header-name"><?= DEMO_USER_NAME ?></div>
                        <div class="so-navbar-user-header-email"><?= DEMO_USER_EMAIL ?></div>
                    </div>
                    <div class="so-navbar-user-menu">
                        <a href="#" class="so-navbar-user-menu-item">
                            <span class="material-icons">person</span>
                            <span>My Profile</span>
                        </a>
                        <a href="#" class="so-navbar-user-menu-item">
                            <span class="material-icons">settings</span>
                            <span>Account Settings</span>
                        </a>
                    </div>
                    <div class="so-navbar-user-footer">
                        <button class="so-navbar-user-footer-btn" id="navbarFullscreenBtn" title="Fullscreen">
                            <span class="material-icons">fullscreen</span>
                        </button>
                        <button class="so-navbar-user-footer-btn" id="lockScreenBtn" title="Lock Screen">
                            <span class="material-icons">lock</span>
                        </button>
                        <button class="so-navbar-user-footer-btn" id="navbarLogoutBtn" title="Logout">
                            <span class="material-icons">power_settings_new</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Search Overlay -->
<div class="so-search-overlay">
    <div class="so-search-overlay-backdrop"></div>
    <div class="so-search-overlay-content">
        <!-- Search Header -->
        <div class="so-search-overlay-header">
            <div class="so-search-overlay-input-wrapper">
                <span class="material-icons so-search-overlay-icon">search</span>
                <input type="text" class="so-search-overlay-input" placeholder="Search products, menus, actions... (Type isv: for item search)" autofocus autocomplete="off" name="so_search_overlay_q" data-lpignore="true" data-form-type="other">
                <div class="so-search-overlay-shortcut">
                    <kbd>ESC</kbd>
                </div>
                <button class="so-search-overlay-close" type="button" title="Close search">
                    <span class="material-icons">close</span>
                </button>
            </div>
        </div>

        <!-- Filter Bar (visible for ISV search) -->
        <div class="so-search-filter-bar">
            <!-- Stock Filter -->
            <div class="so-search-filter-dropdown" data-filter="stock">
                <button class="so-search-filter-btn">
                    <span class="material-icons">inventory</span>
                    <span class="filter-label">Stock</span>
                    <span class="material-icons">expand_more</span>
                </button>
                <div class="so-search-filter-menu">
                    <div class="so-search-filter-option so-selected" data-value="all">All Stock</div>
                    <div class="so-search-filter-option" data-value="in-stock">In Stock</div>
                    <div class="so-search-filter-option" data-value="low-stock">Low Stock</div>
                    <div class="so-search-filter-option" data-value="out-of-stock">Out of Stock</div>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="so-search-filter-dropdown" data-filter="status">
                <button class="so-search-filter-btn">
                    <span class="material-icons">toggle_on</span>
                    <span class="filter-label">Status</span>
                    <span class="material-icons">expand_more</span>
                </button>
                <div class="so-search-filter-menu">
                    <div class="so-search-filter-option so-selected" data-value="all">All Status</div>
                    <div class="so-search-filter-option" data-value="active">Active</div>
                    <div class="so-search-filter-option" data-value="liquidation">Liquidation</div>
                </div>
            </div>

            <!-- View Toggle -->
            <div class="so-search-view-toggle">
                <button class="so-search-view-btn so-active" data-view="grid" title="Grid View">
                    <span class="material-icons">grid_view</span>
                </button>
                <button class="so-search-view-btn" data-view="list" title="List View">
                    <span class="material-icons">view_list</span>
                </button>
            </div>
        </div>

        <!-- Category Tabs (visible for normal search - not ISV) -->
        <div class="so-search-category-tabs">
            <button class="so-search-category-tab so-active" data-category="all">
                All<span class="so-search-category-count">0</span>
            </button>
            <button class="so-search-category-tab" data-category="menus">
                Menus<span class="so-search-category-count">0</span>
            </button>
            <button class="so-search-category-tab" data-category="customers">
                Customers<span class="so-search-category-count">0</span>
            </button>
            <button class="so-search-category-tab" data-category="vendors">
                Vendors<span class="so-search-category-count">0</span>
            </button>
            <button class="so-search-category-tab" data-category="ledgers">
                Ledgers<span class="so-search-category-count">0</span>
            </button>
        </div>

        <!-- Search Body -->
        <div class="so-search-overlay-body">
            <!-- Quick Links (visible when search is empty) -->
            <div class="so-search-quick-links">
                <div class="so-search-quick-links-title">Quick Links</div>
                <div class="so-search-quick-links-grid">
                    <a href="#" class="so-search-quick-link" data-action="new-order">
                        <div class="so-search-quick-link-icon blue">
                            <span class="material-icons">add_shopping_cart</span>
                        </div>
                        <span class="so-search-quick-link-text">New Order</span>
                    </a>
                    <a href="#" class="so-search-quick-link" data-action="new-customer">
                        <div class="so-search-quick-link-icon green">
                            <span class="material-icons">person_add</span>
                        </div>
                        <span class="so-search-quick-link-text">New Customer</span>
                    </a>
                    <a href="#" class="so-search-quick-link" data-action="new-invoice">
                        <div class="so-search-quick-link-icon orange">
                            <span class="material-icons">receipt_long</span>
                        </div>
                        <span class="so-search-quick-link-text">New Invoice</span>
                    </a>
                    <a href="#" class="so-search-quick-link" data-action="new-purchase">
                        <div class="so-search-quick-link-icon red">
                            <span class="material-icons">shopping_cart</span>
                        </div>
                        <span class="so-search-quick-link-text">New Purchase</span>
                    </a>
                    <a href="#" class="so-search-quick-link" data-action="stock-report">
                        <div class="so-search-quick-link-icon blue">
                            <span class="material-icons">inventory_2</span>
                        </div>
                        <span class="so-search-quick-link-text">Stock Report</span>
                    </a>
                    <a href="#" class="so-search-quick-link" data-action="sales-report">
                        <div class="so-search-quick-link-icon green">
                            <span class="material-icons">bar_chart</span>
                        </div>
                        <span class="so-search-quick-link-text">Sales Report</span>
                    </a>
                </div>
            </div>

            <!-- Results Container -->
            <div class="so-search-results-container">
                <!-- Grid View -->
                <div class="so-search-results-grid">
                    <!-- Item cards will be rendered here by JavaScript -->
                </div>

                <!-- List View -->
                <div class="so-search-results-list">
                    <!-- List Header -->
                    <div class="so-search-list-header">
                        <span>Item</span>
                        <span>SKU</span>
                        <span>Stock</span>
                        <span>Price</span>
                        <span>Status</span>
                    </div>
                    <!-- Item rows will be rendered here by JavaScript -->
                </div>
            </div>

            <!-- Empty State -->
            <div class="so-search-empty">
                <span class="material-icons so-search-empty-icon">search</span>
                <div class="so-search-empty-title">Start typing to search</div>
                <div class="so-search-empty-text">Search for menus, customers, vendors, ledgers or type "isv:" for item search</div>
            </div>

            <!-- Loading State -->
            <div class="so-search-loading">
                <div class="so-search-loading-spinner"></div>
            </div>
        </div>

        <!-- Search Footer -->
        <div class="so-search-overlay-footer">
            <div class="so-search-overlay-footer-hint">
                <kbd>↑</kbd><kbd>↓</kbd> to navigate
                <kbd>↵</kbd> to select
                <kbd>ESC</kbd> to close
                <span style="margin-left: 16px;">Tip: Type <kbd>isv:</kbd> for item search with filters</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Searches Section (shown below search) -->
<div class="so-search-overlay-section" id="recentSearches" style="display: none;">
    <div class="so-search-overlay-section-title">Recent Searches</div>
    <div class="so-search-overlay-results">
        <a href="#" class="so-search-overlay-item">
            <div class="so-search-overlay-item-icon blue">
                <span class="material-icons">history</span>
            </div>
            <div class="so-search-overlay-item-content">
                <div class="so-search-overlay-item-title">Ajay Kumar - Customer Ledger</div>
            </div>
        </a>
        <a href="#" class="so-search-overlay-item">
            <div class="so-search-overlay-item-icon blue">
                <span class="material-icons">history</span>
            </div>
            <div class="so-search-overlay-item-content">
                <div class="so-search-overlay-item-title">Sales Report March 2024</div>
            </div>
        </a>
        <a href="#" class="so-search-overlay-item">
            <div class="so-search-overlay-item-icon blue">
                <span class="material-icons">history</span>
            </div>
            <div class="so-search-overlay-item-content">
                <div class="so-search-overlay-item-title">INV-2024-001256</div>
            </div>
        </a>
    </div>
</div>

<!-- Keyboard Shortcuts Modal -->
<div class="so-modal so-modal-keyboard-shortcuts" id="keyboardShortcutsModal" tabindex="-1">
    <div class="so-modal-dialog">
        <div class="so-modal-content">
            <div class="so-modal-header">
                <div class="so-keyboard-shortcuts-title">
                    <span class="material-icons">keyboard</span>
                    <h5 class="so-modal-title">Keyboard Shortcuts</h5>
                </div>
                <button type="button" class="so-modal-close" data-dismiss="modal">
                    <span class="material-icons">close</span>
                </button>
            </div>
            <div class="so-modal-body so-p-0">
                <!-- Navigation Section -->
                <div class="so-keyboard-section">
                    <div class="so-keyboard-section-title">NAVIGATION</div>
                    <div class="so-keyboard-shortcut">
                        <span class="so-keyboard-label">Global Search</span>
                        <div class="so-keyboard-keys">
                            <kbd>Ctrl</kbd>
                            <span class="so-keyboard-plus">+</span>
                            <kbd>K</kbd>
                        </div>
                    </div>
                    <div class="so-keyboard-shortcut">
                        <span class="so-keyboard-label">Toggle Sidebar</span>
                        <div class="so-keyboard-keys">
                            <kbd>Ctrl</kbd>
                            <span class="so-keyboard-plus">+</span>
                            <kbd>B</kbd>
                        </div>
                    </div>
                    <div class="so-keyboard-shortcut">
                        <span class="so-keyboard-label">Go to Dashboard</span>
                        <div class="so-keyboard-keys">
                            <kbd>Ctrl</kbd>
                            <span class="so-keyboard-plus">+</span>
                            <kbd>H</kbd>
                        </div>
                    </div>
                </div>

                <!-- Actions Section -->
                <div class="so-keyboard-section">
                    <div class="so-keyboard-section-title">ACTIONS</div>
                    <div class="so-keyboard-shortcut">
                        <span class="so-keyboard-label">Lock Screen</span>
                        <div class="so-keyboard-keys">
                            <kbd>Ctrl</kbd>
                            <span class="so-keyboard-plus">+</span>
                            <kbd>L</kbd>
                        </div>
                    </div>
                    <div class="so-keyboard-shortcut">
                        <span class="so-keyboard-label">Logout</span>
                        <div class="so-keyboard-keys">
                            <kbd>Ctrl</kbd>
                            <span class="so-keyboard-plus">+</span>
                            <kbd>Shift</kbd>
                            <span class="so-keyboard-plus">+</span>
                            <kbd>L</kbd>
                        </div>
                    </div>
                    <div class="so-keyboard-shortcut">
                        <span class="so-keyboard-label">Toggle Fullscreen</span>
                        <div class="so-keyboard-keys">
                            <kbd>F11</kbd>
                        </div>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="so-keyboard-section">
                    <div class="so-keyboard-section-title">HELP</div>
                    <div class="so-keyboard-shortcut">
                        <span class="so-keyboard-label">Show Shortcuts</span>
                        <div class="so-keyboard-keys">
                            <kbd>?</kbd>
                        </div>
                    </div>
                    <div class="so-keyboard-shortcut">
                        <span class="so-keyboard-label">Close Popup</span>
                        <div class="so-keyboard-keys">
                            <kbd>Esc</kbd>
                        </div>
                    </div>
                </div>
            </div>
            <div class="so-modal-footer so-keyboard-footer">
                <span class="material-icons">info</span>
                <span>Press</span>
                <kbd>?</kbd>
                <span class="so-text-hint">anytime to view shortcuts</span>
            </div>
        </div>
    </div>
</div>

<style>
    /* Keyboard Shortcuts Modal Styles */
    .so-modal-keyboard-shortcuts .so-modal-dialog {
        max-width: 520px;
    }

    .so-modal-keyboard-shortcuts .so-modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    .so-modal-keyboard-shortcuts .so-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #f0f0f0;
    }

    .so-keyboard-shortcuts-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .so-keyboard-shortcuts-title .material-icons {
        font-size: 24px;
        color: var(--so-accent-primary);
    }

    .so-keyboard-shortcuts-title .so-modal-title {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: var(--so-text-primary);
    }

    .so-modal-keyboard-shortcuts .so-modal-close {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        color: var(--so-text-secondary);
        cursor: pointer;
        border-radius: 6px;
        transition: background 0.15s ease;
    }

    .so-modal-keyboard-shortcuts .so-modal-close:hover {
        background: var(--so-grey-100);
    }

    .so-modal-keyboard-shortcuts .so-modal-close .material-icons {
        font-size: 20px;
    }

    .so-modal-keyboard-shortcuts .so-modal-body {
        padding: 0;
        max-height: 450px;
        overflow-y: auto;
    }

    .so-keyboard-section {
        padding: 16px 24px;
        border-bottom: 1px solid #f0f0f0;
    }

    .so-keyboard-section:last-child {
        border-bottom: none;
    }

    .so-keyboard-section-title {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
        color: #9e9e9e;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .so-keyboard-shortcut {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
    }

    .so-keyboard-shortcut:last-child {
        padding-bottom: 0;
    }

    .so-keyboard-label {
        font-size: 14px;
        color: var(--so-text-primary);
        font-weight: 400;
    }

    .so-keyboard-keys {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .so-keyboard-keys kbd {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 28px;
        padding: 0 10px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 12px;
        font-weight: 500;
        color: var(--so-text-secondary);
        background: #f5f5f5;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .so-keyboard-plus {
        font-size: 13px;
        color: var(--so-text-muted);
        font-weight: 400;
    }

    .so-keyboard-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 16px 24px;
        font-size: 14px;
        color: var(--so-text-secondary);
        background: #fafafa;
        border-top: 1px solid var(--so-border-light, #f0f0f0);
    }

    .so-keyboard-footer .material-icons {
        font-size: 18px;
        color: var(--so-accent-primary);
    }

    .so-keyboard-footer kbd {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        height: 24px;
        padding: 0 8px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 12px;
        font-weight: 500;
        color: var(--so-text-secondary);
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
    }

    .so-keyboard-footer .so-text-hint {
        color: #9e9e9e;
    }

    /* Dark mode adjustments */
    [data-theme="dark"] .so-modal-keyboard-shortcuts .so-modal-close:hover {
        background: var(--so-grey-800);
    }

    [data-theme="dark"] .so-keyboard-keys kbd {
        background: var(--so-grey-800);
        border-color: var(--so-grey-700);
    }

    [data-theme="dark"] .so-keyboard-footer {
        background: var(--so-grey-900);
        border-color: var(--so-grey-800);
    }

    [data-theme="dark"] .so-keyboard-footer kbd {
        background: var(--so-grey-800);
        border-color: var(--so-grey-700);
    }

    [data-theme="dark"] .so-keyboard-shortcut {
        border-color: var(--so-grey-800);
    }

    [data-theme="dark"] .so-keyboard-section {
        border-color: var(--so-grey-800);
    }

    [data-theme="dark"] .so-modal-keyboard-shortcuts .so-modal-header {
        border-color: var(--so-grey-800);
    }
</style>

<script>
    // Keyboard Shortcuts Modal Handler
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('keyboardShortcutsModal');

        if (modal && typeof SOModal !== 'undefined') {
            // Initialize modal instance
            const modalInstance = SOModal.getInstance(modal) || new SOModal(modal);

            // Expose globally so so-layout.js can use it instead of showing alert
            window.soKeyboardShortcuts = modalInstance;

            // Open modal on '?' key press
            document.addEventListener('keydown', function(e) {
                // Check if '?' is pressed (Shift + /)
                if (e.key === '?' && !e.ctrlKey && !e.altKey && !e.metaKey) {
                    // Don't trigger if user is typing in an input
                    const activeEl = document.activeElement;
                    const isInputFocused = activeEl && (
                        activeEl.tagName === 'INPUT' ||
                        activeEl.tagName === 'TEXTAREA' ||
                        activeEl.isContentEditable
                    );

                    if (!isInputFocused) {
                        e.preventDefault();
                        modalInstance.show();
                    }
                }
            });
        }

        // User Status Selector - Single selection
        const userStatusSelector = document.getElementById('userStatusSelector');
        if (userStatusSelector) {
            const statusIndicator = document.getElementById('statusIndicator');
            const statusText = document.getElementById('statusText');
            const statusItems = userStatusSelector.querySelectorAll('.so-dropdown-item');

            statusItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const status = this.getAttribute('data-status');
                    const title = this.querySelector('.status-option-title').textContent;

                    // Update active state
                    statusItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    // Update trigger indicator and text
                    if (statusIndicator) {
                        statusIndicator.className = 'status-indicator ' + status;
                    }
                    if (statusText) {
                        statusText.textContent = title;
                    }

                    // Close dropdown
                    userStatusSelector.classList.remove('open');
                });
            });
        }

        // Theme Switcher - Independent Group Selection
        const themeSwitcher = document.getElementById('themeSwitcher');
        if (themeSwitcher) {
            const themeIcon = themeSwitcher.querySelector('.theme-icon');

            // Theme icon mapping
            const themeIcons = {
                'light': 'light_mode',
                'dark': 'dark_mode',
                'system': 'computer',
                'sidebar-dark': 'contrast'
            };

            // Storage keys
            const THEME_KEY = 'theme-preference';
            const FONTSIZE_KEY = 'fontsize-preference';

            // Helper to apply theme
            function applyTheme(theme) {
                const sidebar = document.querySelector('.so-sidebar');

                // Remove sidebar-dark class first
                if (sidebar) sidebar.classList.remove('sidebar-dark');

                if (theme === 'dark') {
                    document.documentElement.setAttribute('data-theme', 'dark');
                } else if (theme === 'light') {
                    document.documentElement.setAttribute('data-theme', 'light');
                } else if (theme === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    document.documentElement.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
                } else if (theme === 'sidebar-dark') {
                    document.documentElement.setAttribute('data-theme', 'light');
                    if (sidebar) sidebar.classList.add('sidebar-dark');
                }

                // Save preference
                localStorage.setItem(THEME_KEY, theme);
            }

            // Helper to apply font size
            function applyFontSize(size) {
                if (size === 'default') {
                    document.documentElement.removeAttribute('data-fontsize');
                } else {
                    document.documentElement.setAttribute('data-fontsize', size);
                }

                // Save preference
                localStorage.setItem(FONTSIZE_KEY, size);
            }

            // Restore saved preferences on load
            const savedTheme = localStorage.getItem(THEME_KEY);
            const savedFontSize = localStorage.getItem(FONTSIZE_KEY);

            if (savedTheme) {
                applyTheme(savedTheme);
                // Update active state in dropdown
                themeSwitcher.querySelectorAll('[data-group="theme"] .so-dropdown-item').forEach(i => {
                    i.classList.toggle('active', i.getAttribute('data-theme') === savedTheme);
                });
                // Update icon
                if (themeIcon && themeIcons[savedTheme]) {
                    themeIcon.textContent = themeIcons[savedTheme];
                }
            }

            if (savedFontSize) {
                applyFontSize(savedFontSize);
                // Update active state in dropdown
                themeSwitcher.querySelectorAll('[data-group="fontsize"] .so-dropdown-item').forEach(i => {
                    i.classList.toggle('active', i.getAttribute('data-fontsize') === savedFontSize);
                });
            }

            // Handle clicks on theme items
            themeSwitcher.querySelectorAll('[data-group="theme"] .so-dropdown-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const theme = this.getAttribute('data-theme');

                    // Update active state only within theme group
                    themeSwitcher.querySelectorAll('[data-group="theme"] .so-dropdown-item').forEach(i => {
                        i.classList.remove('active');
                    });
                    this.classList.add('active');

                    // Update theme icon
                    if (themeIcon && themeIcons[theme]) {
                        themeIcon.textContent = themeIcons[theme];
                    }

                    // Apply theme
                    applyTheme(theme);
                });
            });

            // Handle clicks on font size items
            themeSwitcher.querySelectorAll('[data-group="fontsize"] .so-dropdown-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const fontSize = this.getAttribute('data-fontsize');

                    // Update active state only within fontsize group
                    themeSwitcher.querySelectorAll('[data-group="fontsize"] .so-dropdown-item').forEach(i => {
                        i.classList.remove('active');
                    });
                    this.classList.add('active');

                    // Apply font size
                    applyFontSize(fontSize);
                });
            });

            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
                const currentTheme = localStorage.getItem(THEME_KEY);
                if (currentTheme === 'system') {
                    applyTheme('system');
                }
            });
        }
    });
</script>