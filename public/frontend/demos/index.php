<?php

/**
 * SixOrbit UI Demo - Dashboard (Wallet Page)
 * Matches the original first_draft/sixorbit-ui/index.html exactly
 */
$pageTitle = 'Dashboard';
$currentPage = 'dashboard';

// DataTable CSS
$additionalCss = [
    '../general_plugins/datatable/libs/tabulator.min.css',
    '../general_plugins/datatable/datatable.css'
];

require_once 'includes/config.php';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
require_once 'includes/navbar.php';
?>

<!-- Main Content -->
<main class="so-main-content">
    <!-- Breadcrumb Bar (inside main content) -->
    <div class="so-breadcrumb-bar">
        <a href="index.php" class="so-breadcrumb-bar-home" title="Dashboard">
            <span class="material-icons">home</span>
        </a>
        <span class="so-breadcrumb-bar-separator">
            <span class="material-icons">chevron_right</span>
        </span>
        <a href="#" class="so-breadcrumb-bar-item">Customer</a>
        <span class="so-breadcrumb-bar-separator">
            <span class="material-icons">chevron_right</span>
        </span>
        <a href="#" class="so-breadcrumb-bar-item">Latha Mohan</a>
        <span class="so-breadcrumb-bar-separator">
            <span class="material-icons">chevron_right</span>
        </span>
        <span class="so-breadcrumb-bar-item so-active">Wallet</span>
    </div>

    <div class="demo-content so-p-3">
        <!-- Page Header Card -->
        <div class="so-card so-card-padded so-page-header-card so-shadow">
            <nav class="so-breadcrumb-bar" style="background: transparent; border: none; padding: 0; margin-bottom: 12px;">
                <a href="#" class="so-breadcrumb-bar-item">Customer</a>
                <span class="so-breadcrumb-bar-separator"><span class="material-icons">chevron_right</span></span>
                <a href="#" class="so-breadcrumb-bar-item">Latha Mohan</a>
                <span class="so-breadcrumb-bar-separator"><span class="material-icons">chevron_right</span></span>
                <span class="so-breadcrumb-bar-item active">Wallet</span>
            </nav>
            <div class="so-page-header-row">
                <h1 class="so-page-title">
                    <span class="so-page-title-icon">
                        <span class="material-icons">person</span>
                    </span>
                    Latha Mohan
                </h1>
                <div class="so-page-actions">
                    <div class="so-dropdown so-dropdown-nowrap so-dropdown-no-scroll dropdown-right">
                        <button class="so-btn so-btn-default so-btn-sm so-dropdown-trigger">
                            <span class="material-icons">bolt</span>
                            Actions
                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                        </button>
                        <div class="so-dropdown-menu">
                            <a href="#" class="so-dropdown-item">
                                <span class="material-icons">location_on</span>
                                Address Management
                            </a>
                            <a href="#" class="so-dropdown-item">
                                <span class="material-icons">event_note</span>
                                Followups
                            </a>
                            <div class="so-dropdown-divider"></div>
                            <a href="#" class="so-dropdown-item">
                                <span class="material-icons">receipt_long</span>
                                Pending Invoices
                            </a>
                            <a href="#" class="so-dropdown-item">
                                <span class="material-icons">shopping_cart</span>
                                Sales Orders
                            </a>
                            <a href="#" class="so-dropdown-item">
                                <span class="material-icons">request_quote</span>
                                Quotations
                            </a>
                            <div class="so-dropdown-divider"></div>
                            <a href="#" class="so-dropdown-item">
                                <span class="material-icons">calendar_month</span>
                                Month Wise Wallet
                            </a>
                            <a href="#" class="so-dropdown-item">
                                <span class="material-icons">pending_actions</span>
                                Pending Items
                            </a>
                            <a href="#" class="so-dropdown-item">
                                <span class="material-icons">insights</span>
                                Customer Performance
                            </a>
                            <div class="so-dropdown-divider"></div>
                            <a href="#" class="so-dropdown-item">
                                <span class="material-icons">sell</span>
                                Default Price
                            </a>
                            <a href="#" class="so-dropdown-item">
                                <span class="material-icons">discount</span>
                                Brand/Category Discount
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="so-grid so-grid-cols-4 so-grid-cols-lg-2 so-grid-cols-sm-1 so-gap-3 so-mb-4">
            <div class="so-card so-card-padded">
                <div class="so-d-flex so-justify-content-between so-align-items-center so-mb-2">
                    <span class="so-text-muted so-fs-xs so-text-uppercase so-fw-medium">Total Sales</span>
                    <span class="so-d-flex so-align-items-center so-justify-content-center so-rounded-full so-bg-info-subtle so-w-8 so-h-8">
                        <span class="material-icons so-text-info so-fs-lg">trending_up</span>
                    </span>
                </div>
                <div class="so-fs-2xl so-fw-medium so-mb-1">₹12,45,890</div>
                <div class="so-d-flex so-align-items-center so-gap-1">
                    <span class="material-icons so-text-success so-fs-base">arrow_upward</span>
                    <span class="so-text-success so-fs-xs so-fw-medium">12.5% from last month</span>
                </div>
            </div>

            <div class="so-card so-card-padded">
                <div class="so-d-flex so-justify-content-between so-align-items-center so-mb-2">
                    <span class="so-text-muted so-fs-xs so-text-uppercase so-fw-medium">Total Purchase</span>
                    <span class="so-d-flex so-align-items-center so-justify-content-center so-rounded-full so-bg-danger-subtle so-w-8 so-h-8">
                        <span class="material-icons so-text-danger so-fs-lg">shopping_cart</span>
                    </span>
                </div>
                <div class="so-fs-2xl so-fw-medium so-mb-1">₹8,34,560</div>
                <div class="so-d-flex so-align-items-center so-gap-1">
                    <span class="material-icons so-text-danger so-fs-base">arrow_downward</span>
                    <span class="so-text-danger so-fs-xs so-fw-medium">3.2% from last month</span>
                </div>
            </div>

            <div class="so-card so-card-padded">
                <div class="so-d-flex so-justify-content-between so-align-items-center so-mb-2">
                    <span class="so-text-muted so-fs-xs so-text-uppercase so-fw-medium">Pending Orders</span>
                    <span class="so-d-flex so-align-items-center so-justify-content-center so-rounded-full so-bg-warning-subtle so-w-8 so-h-8">
                        <span class="material-icons so-text-warning so-fs-lg">pending_actions</span>
                    </span>
                </div>
                <div class="so-fs-2xl so-fw-medium so-mb-1">47</div>
                <div class="so-d-flex so-align-items-center so-gap-1">
                    <span class="material-icons so-text-success so-fs-base">arrow_upward</span>
                    <span class="so-text-success so-fs-xs so-fw-medium">8 new today</span>
                </div>
            </div>

            <div class="so-card so-card-padded so-shadow">
                <div class="so-d-flex so-justify-content-between so-align-items-center so-mb-2">
                    <span class="so-text-muted so-fs-xs so-text-uppercase so-fw-medium">Active Customers</span>
                    <span class="so-d-flex so-align-items-center so-justify-content-center so-rounded-full so-bg-success-subtle so-w-8 so-h-8">
                        <span class="material-icons so-text-success so-fs-lg">people</span>
                    </span>
                </div>
                <div class="so-fs-2xl so-fw-medium so-mb-1">1,284</div>
                <div class="so-d-flex so-align-items-center so-gap-1">
                    <span class="material-icons so-text-success so-fs-base">arrow_upward</span>
                    <span class="so-text-success so-fs-xs so-fw-medium">24 new this week</span>
                </div>
            </div>
        </div>

        <!-- Panel Component Demo -->
        <div class="so-panel" style="margin-bottom: 24px;">
            <!-- Panel Header - Title, Icon, Subtitle + Actions (Options, Filter, Date Range) -->
            <div class="so-panel-header">
                <div class="so-panel-header-left">
                    <div class="so-panel-icon">
                        <span class="material-icons">account_balance_wallet</span>
                    </div>
                    <div>
                        <h3 class="so-panel-title">Customer Wallet History</h3>
                        <p class="so-panel-subtitle">LATHA MOHAN's Transaction History</p>
                    </div>
                </div>
                <div class="so-panel-header-right">
                    <!-- Options Dropdown (leftmost in right section) -->
                    <div class="so-dropdown so-dropdown-no-scroll" data-so-dropdown>
                        <button class="so-btn so-btn-default so-btn-sm so-dropdown-trigger">
                            <span class="material-icons">more_vert</span>
                            Options
                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                        </button>
                        <div class="so-dropdown-menu so-dropdown-menu-end">
                            <div class="so-dropdown-header">Report Actions</div>
                            <a href="#" class="so-dropdown-item" onclick="alert('Compare Ledger clicked')">
                                <span class="material-icons">compare_arrows</span>
                                Compare Ledger
                            </a>
                            <a href="#" class="so-dropdown-item" onclick="alert('Pending Invoice clicked')">
                                <span class="material-icons">pending_actions</span>
                                Pending Invoice
                            </a>
                            <a href="#" class="so-dropdown-item" onclick="alert('Month Wise Report clicked')">
                                <span class="material-icons">calendar_view_month</span>
                                Month Wise Report
                            </a>
                            <div class="so-dropdown-divider"></div>
                            <a href="#" class="so-dropdown-item" onclick="alert('Outstanding Analysis clicked')">
                                <span class="material-icons">analytics</span>
                                Outstanding Analysis
                            </a>
                            <a href="#" class="so-dropdown-item" onclick="alert('Payment History clicked')">
                                <span class="material-icons">history</span>
                                Payment History
                            </a>
                        </div>
                    </div>

                    <!-- Filter Button -->
                    <div class="so-dropdown so-dropdown-no-scroll" data-so-dropdown data-so-auto-close="outside">
                        <button class="so-btn so-btn-default so-btn-sm so-dropdown-trigger">
                            <span class="material-icons">filter_list</span>
                            Filter
                            <span class="so-badge so-badge-primary so-badge-sm" style="margin-left: 4px;">1</span>
                        </button>
                        <div class="so-dropdown-menu so-dropdown-menu-end" style="min-width: 280px; padding: 0;">
                            <div class="so-dropdown-header" style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Filters</span>
                                <button class="so-btn so-btn-link so-btn-sm" style="padding: 0; height: auto;">Clear all</button>
                            </div>
                            <div style="padding: 12px 16px;">
                                <div class="so-form-group so-mb-3">
                                    <label class="so-form-label">Voucher Type</label>
                                    <select class="so-form-control so-form-control-sm">
                                        <option value="">All Types</option>
                                        <option value="sales" selected>Sales</option>
                                        <option value="purchase">Purchase</option>
                                        <option value="receipt">Receipt</option>
                                        <option value="payment">Payment</option>
                                    </select>
                                </div>
                                <div class="so-form-group">
                                    <label class="so-form-label">Outlet</label>
                                    <select class="so-form-control so-form-control-sm">
                                        <option value="">All Outlets</option>
                                        <option value="head-office">TROVE Head Office</option>
                                        <option value="branch-1">VPS Branch (Flagship Store)</option>
                                        <option value="branch-2">TROVE Basavanagudi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="so-dropdown-divider" style="margin: 0;"></div>
                            <div style="padding: 12px 16px; display: flex; gap: 8px; justify-content: flex-end;">
                                <button class="so-btn so-btn-light so-btn-sm" onclick="SODropdown.getInstance(this.closest('.so-dropdown')).close()">Cancel</button>
                                <button class="so-btn so-btn-primary so-btn-sm">Apply Filters</button>
                            </div>
                        </div>
                    </div>

                    <!-- Date Range Picker (rightmost) -->
                    <div class="so-panel-date-range" style="position: relative;" onclick="this.classList.toggle('open')">
                        <span class="material-icons">calendar_today</span>
                        <span class="so-panel-date-range-text">Apr 1, 2025 - Jan 19, 2026</span>
                        <span class="material-icons so-panel-date-range-arrow">expand_more</span>

                        <!-- Date Dropdown -->
                        <div class="so-panel-date-dropdown" onclick="event.stopPropagation()">
                            <div class="so-panel-date-presets">
                                <div class="so-panel-date-preset">
                                    <span class="material-icons">today</span>
                                    Today
                                </div>
                                <div class="so-panel-date-preset">
                                    <span class="material-icons">date_range</span>
                                    Yesterday
                                </div>
                                <div class="so-panel-date-preset">
                                    <span class="material-icons">calendar_view_week</span>
                                    Last 7 Days
                                </div>
                                <div class="so-panel-date-preset">
                                    <span class="material-icons">calendar_month</span>
                                    Last 30 Days
                                </div>
                                <div class="so-panel-date-preset">
                                    <span class="material-icons">calendar_view_month</span>
                                    This Month
                                </div>
                                <div class="so-panel-date-preset so-active">
                                    <span class="material-icons">event</span>
                                    This Financial Year
                                </div>
                            </div>
                            <div class="so-panel-date-custom">
                                <div class="so-panel-date-custom-label">Custom Range</div>
                                <div class="so-panel-date-inputs">
                                    <input type="date" class="so-panel-date-input" value="2025-04-01">
                                    <span>to</span>
                                    <input type="date" class="so-panel-date-input" value="2026-01-19">
                                </div>
                                <button class="so-panel-date-apply">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Info Section - Additional Data (Account Group, Opening Values, etc.) -->
            <div class="so-panel-info">
                <div class="so-panel-info-item">
                    <span class="so-panel-info-label">Account Group:</span>
                    <span class="so-panel-info-value highlight">Sundry Debtors</span>
                </div>
                <div class="so-panel-info-divider"></div>
                <div class="so-panel-info-item">
                    <span class="so-panel-info-label">Opening Balance:</span>
                    <span class="so-panel-info-value negative">₹1,25,450.00 Dr</span>
                </div>
                <div class="so-panel-info-divider"></div>
                <div class="so-panel-info-item">
                    <span class="so-panel-info-label">Ledger Opening:</span>
                    <span class="so-panel-info-value">₹0.00</span>
                </div>
                <div class="so-panel-info-divider"></div>
                <div class="so-panel-info-item">
                    <span class="so-panel-info-label">Credit Limit:</span>
                    <span class="so-panel-info-value">₹5,00,000.00</span>
                </div>
            </div>

            <!-- Active Filters Chips (optional - shows applied filters) -->
            <div class="so-panel-chips">
                <div class="so-panel-chip">
                    <span class="so-panel-chip-label">Type:</span>
                    Sales
                    <button class="so-panel-chip-remove">
                        <span class="material-icons">close</span>
                    </button>
                </div>
                <button class="so-panel-chips-clear">Clear all</button>
            </div>

            <!-- Panel Body - Contains the DataTable -->
            <div class="so-panel-body" style="padding: 0;">
                <div id="wallet-datatable-container" style="height: 500px;"></div>
            </div>
        </div>
    </div>
</main>

<!-- Mobile Floating Bottom Bar -->
<div class="so-mobile-bottom-bar">
    <!-- Search Button -->
    <button class="so-mobile-bottom-item" id="mobileSearchBtn">
        <span class="material-icons">search</span>
        <span class="so-mobile-bottom-item-label">Search</span>
    </button>

    <!-- Outlet Selector -->
    <div class="so-mobile-outlet-dropdown">
        <button class="so-mobile-bottom-item" id="mobileOutletBtn">
            <span class="material-icons">storefront</span>
            <span class="so-mobile-bottom-item-label">Outlet</span>
        </button>
        <div class="so-mobile-outlet-menu">
            <div class="so-mobile-outlet-header">Select Outlet</div>
            <div class="so-mobile-outlet-list">
                <div class="so-mobile-outlet-item so-selected" data-value="all">
                    <span>All Outlets</span>
                    <span class="material-icons check-icon">check</span>
                </div>
                <div class="so-mobile-outlet-item" data-value="head-office">
                    <span>TROVE Head Office</span>
                    <span class="material-icons check-icon">check</span>
                </div>
                <div class="so-mobile-outlet-item" data-value="basavanagudi">
                    <span>TROVE Basavanagudi</span>
                    <span class="material-icons check-icon">check</span>
                </div>
                <div class="so-mobile-outlet-item" data-value="jayanagar">
                    <span>TROVE Jayanagar</span>
                    <span class="material-icons check-icon">check</span>
                </div>
                <div class="so-mobile-outlet-item" data-value="indiranagar">
                    <span>TROVE Indiranagar</span>
                    <span class="material-icons check-icon">check</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page Overlay Styles -->
<style>
    /* Lock Screen Overlay */
    .so-lock-screen {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;
        background: linear-gradient(135deg, #1a1c2e 0%, #0d0e17 100%);
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .so-lock-screen.active {
        display: flex;
        opacity: 1;
        visibility: visible;
    }

    .so-lock-screen-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        color: #fff;
    }

    .so-lock-screen-time {
        font-size: 72px;
        font-weight: 200;
        color: #fff;
        margin-bottom: 8px;
    }

    .so-lock-screen-date {
        font-size: 18px;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 48px;
    }

    .so-lock-screen-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 500;
        color: #fff;
        margin-bottom: 16px;
    }

    .so-lock-screen-avatar[data-color="teal"] {
        background: linear-gradient(135deg, #00897b, #26a69a);
    }

    .so-lock-screen-name {
        font-size: 24px;
        font-weight: 500;
        color: #fff;
        margin-bottom: 8px;
    }

    .so-lock-screen-status {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 32px;
    }

    .so-lock-screen-status .material-icons {
        font-size: 18px;
    }

    .so-lock-screen-form {
        margin-bottom: 16px;
    }

    .so-lock-screen-input-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .so-lock-screen-input {
        width: 280px;
        padding: 12px 16px;
        font-size: 16px;
        font-family: inherit;
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        outline: none;
        transition: border-color 0.2s ease, background 0.2s ease;
    }

    .so-lock-screen-input:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .so-lock-screen-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .so-lock-screen-submit {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        color: #fff;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .so-lock-screen-submit:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .so-lock-screen-hint {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.4);
    }

    .so-lock-screen-branding {
        position: absolute;
        bottom: 24px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.4);
    }

    .so-lock-screen-branding svg {
        width: 24px;
        height: 24px;
    }

    /* Logout Confirmation Overlay */
    .so-confirm-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9997;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }

    .so-confirm-overlay.active {
        display: flex;
        opacity: 1;
        visibility: visible;
    }

    .so-confirm-popup {
        width: 100%;
        max-width: 400px;
        padding: 32px;
        background: var(--so-card-bg, #fff);
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        text-align: center;
        transform: scale(0.95);
        transition: transform 0.2s ease;
    }

    .so-confirm-overlay.active .so-confirm-popup {
        transform: scale(1);
    }

    .so-confirm-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(234, 84, 85, 0.1);
        border-radius: 50%;
    }

    .so-confirm-icon .material-icons {
        font-size: 32px;
        color: #ea5455;
    }

    .so-confirm-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--so-text-heading, #1e293b);
        margin: 0 0 8px 0;
    }

    .so-confirm-message {
        font-size: 14px;
        color: var(--so-text-secondary, #64748b);
        margin: 0 0 24px 0;
        line-height: 1.5;
    }

    .so-confirm-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    /* Dark mode adjustments */
    [data-theme="dark"] .so-confirm-popup {
        background: var(--so-card-bg, #1e293b);
    }

    /* Mobile Bottom Bar */
    .so-mobile-bottom-bar {
        display: none;
    }

    @media (max-width: 768px) {
        .so-mobile-bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 8px 16px 12px;
            background: var(--so-card-bg, #fff);
            border-top: 1px solid var(--so-border-color, #e2e8f0);
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
    }

    .so-mobile-bottom-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        padding: 8px 16px;
        background: transparent;
        border: none;
        color: var(--so-text-secondary, #64748b);
        cursor: pointer;
        transition: color 0.15s ease;
    }

    .so-mobile-bottom-item:hover {
        color: var(--so-accent-primary, #7367f0);
    }

    .so-mobile-bottom-item .material-icons {
        font-size: 24px;
    }

    .so-mobile-bottom-item-label {
        font-size: 11px;
        font-weight: 500;
    }

    .so-mobile-outlet-dropdown {
        position: relative;
    }

    .so-mobile-outlet-menu {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 8px;
        width: 220px;
        background: var(--so-card-bg, #fff);
        border-radius: 12px;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
        display: none;
        overflow: hidden;
    }

    .so-mobile-outlet-dropdown.open .so-mobile-outlet-menu {
        display: block;
    }

    .so-mobile-outlet-header {
        padding: 12px 16px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--so-text-muted, #94a3b8);
        border-bottom: 1px solid var(--so-border-color, #e2e8f0);
    }

    .so-mobile-outlet-list {
        padding: 8px 0;
    }

    .so-mobile-outlet-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 16px;
        font-size: 14px;
        color: var(--so-text-primary, #334155);
        cursor: pointer;
        transition: background 0.15s ease;
    }

    .so-mobile-outlet-item:hover {
        background: var(--so-grey-50, #f8fafc);
    }

    .so-mobile-outlet-item .check-icon {
        display: none;
        font-size: 18px;
        color: var(--so-accent-primary, #7367f0);
    }

    .so-mobile-outlet-item.so-selected .check-icon {
        display: inline-flex;
    }
</style>

<!-- Lock Screen Overlay -->
<div class="so-lock-screen" id="lockScreen">
    <div class="so-lock-screen-container">
        <div class="so-lock-screen-time" id="lockScreenTime">12:00</div>
        <div class="so-lock-screen-date" id="lockScreenDate">Saturday, January 25</div>

        <div class="so-lock-screen-avatar" data-color="teal">R</div>
        <div class="so-lock-screen-name"><?= DEMO_USER_NAME ?></div>
        <div class="so-lock-screen-status">
            <span class="material-icons">lock</span>
            Screen Locked
        </div>

        <form class="so-lock-screen-form" id="lockScreenForm">
            <div class="so-lock-screen-input-wrapper">
                <input type="password"
                    class="so-lock-screen-input"
                    id="lockScreenPassword"
                    placeholder="Enter password to unlock"
                    autocomplete="off">
                <button type="submit" class="so-lock-screen-submit" title="Unlock">
                    <span class="material-icons">arrow_forward</span>
                </button>
            </div>
        </form>

        <div class="so-lock-screen-hint">
            Press Enter or click arrow to unlock
        </div>
    </div>

    <div class="so-lock-screen-branding">
        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="24" cy="24" rx="22" ry="10" stroke="currentColor" stroke-width="2" fill="none" transform="rotate(-20 24 24)" opacity="0.6" />
            <path d="M24 6L38.7 15V33L24 42L9.3 33V15L24 6Z" stroke="currentColor" stroke-width="2.5" fill="none" />
            <circle cx="24" cy="24" r="4" fill="currentColor" />
        </svg>
        SixOrbit ERP
    </div>
</div>

<!-- Logout Confirmation Popup -->
<div class="so-confirm-overlay" id="logoutConfirmOverlay">
    <div class="so-confirm-popup">
        <div class="so-confirm-icon">
            <span class="material-icons">logout</span>
        </div>
        <h2 class="so-confirm-title">Confirm Logout</h2>
        <p class="so-confirm-message">Are you sure you want to logout? Any unsaved changes will be lost.</p>
        <div class="so-confirm-actions">
            <button class="so-btn so-btn-outline" id="logoutCancelBtn">
                Cancel
            </button>
            <button class="so-btn so-btn-danger" id="logoutConfirmBtn">
                <span class="material-icons">logout</span>
                Logout
            </button>
        </div>
    </div>
</div>

<!-- Tabulator JS for DataTable -->
<script src="../general_plugins/datatable/libs/tabulator.min.js"></script>
<script src="../general_plugins/datatable/libs/xlsx.full.min.js"></script>
<script src="../general_plugins/datatable/datatable.js"></script>

<script>
    // Sample Wallet Transaction Data (for panel demo)
    const walletData = [{
            id: 1,
            date: "2026-01-15",
            docNo: "SL-2026-0042",
            refNo: "INV-0042",
            voucher: "Sales",
            voucherType: "Tax Invoice",
            particulars: "Sales - Cash",
            debit: 15600,
            credit: 0,
            outlet: "VPS Branch"
        },
        {
            id: 2,
            date: "2026-01-14",
            docNo: "RC-2026-0018",
            refNo: "REC-0018",
            voucher: "Receipt",
            voucherType: "Cash Receipt",
            particulars: "Payment Received",
            debit: 0,
            credit: 25000,
            outlet: "VPS Branch"
        },
        {
            id: 3,
            date: "2026-01-12",
            docNo: "SL-2026-0038",
            refNo: "INV-0038",
            voucher: "Sales",
            voucherType: "Tax Invoice",
            particulars: "Sales - Credit",
            debit: 45200,
            credit: 0,
            outlet: "Head Office"
        },
        {
            id: 4,
            date: "2026-01-10",
            docNo: "CN-2026-0005",
            refNo: "CN-0005",
            voucher: "Credit Note",
            voucherType: "Sales Return",
            particulars: "Return - Damaged",
            debit: 0,
            credit: 3500,
            outlet: "VPS Branch"
        },
        {
            id: 5,
            date: "2026-01-08",
            docNo: "SL-2026-0035",
            refNo: "INV-0035",
            voucher: "Sales",
            voucherType: "Tax Invoice",
            particulars: "Sales - Cash",
            debit: 28900,
            credit: 0,
            outlet: "Basavanagudi"
        },
        {
            id: 6,
            date: "2026-01-05",
            docNo: "RC-2026-0015",
            refNo: "REC-0015",
            voucher: "Receipt",
            voucherType: "Bank Transfer",
            particulars: "Payment Received",
            debit: 0,
            credit: 50000,
            outlet: "Head Office"
        },
        {
            id: 7,
            date: "2026-01-03",
            docNo: "SL-2026-0031",
            refNo: "INV-0031",
            voucher: "Sales",
            voucherType: "Tax Invoice",
            particulars: "Sales - Credit",
            debit: 67800,
            credit: 0,
            outlet: "VPS Branch"
        },
        {
            id: 8,
            date: "2025-12-28",
            docNo: "SL-2026-0028",
            refNo: "INV-0028",
            voucher: "Sales",
            voucherType: "Tax Invoice",
            particulars: "Sales - Cash",
            debit: 12450,
            credit: 0,
            outlet: "Basavanagudi"
        },
        {
            id: 9,
            date: "2025-12-25",
            docNo: "RC-2026-0012",
            refNo: "REC-0012",
            voucher: "Receipt",
            voucherType: "Cheque",
            particulars: "Payment Received",
            debit: 0,
            credit: 35000,
            outlet: "VPS Branch"
        },
        {
            id: 10,
            date: "2025-12-20",
            docNo: "SL-2026-0025",
            refNo: "INV-0025",
            voucher: "Sales",
            voucherType: "Tax Invoice",
            particulars: "Sales - Credit",
            debit: 89500,
            credit: 0,
            outlet: "Head Office"
        }
    ];

    // Wallet Columns
    const walletColumns = [{
            title: "Date",
            field: "date",
            minWidth: 100
        },
        {
            title: "Doc No.",
            field: "docNo",
            minWidth: 120
        },
        {
            title: "Ref No.",
            field: "refNo",
            minWidth: 100
        },
        {
            title: "Voucher",
            field: "voucher",
            minWidth: 100
        },
        {
            title: "Voucher Type",
            field: "voucherType",
            minWidth: 120
        },
        {
            title: "Particulars",
            field: "particulars",
            minWidth: 140
        },
        {
            title: "Debit",
            field: "debit",
            formatter: "money",
            formatterParams: {
                symbol: "₹",
                precision: 0
            },
            minWidth: 100
        },
        {
            title: "Credit",
            field: "credit",
            formatter: "money",
            formatterParams: {
                symbol: "₹",
                precision: 0
            },
            minWidth: 100
        },
        {
            title: "Outlet",
            field: "outlet",
            minWidth: 120
        }
    ];

    // Initialize Wallet DataTable (inside panel)
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof DataTable !== 'undefined') {
            const walletDataTable = new DataTable('wallet-datatable-container', {
                columns: walletColumns,
                data: walletData,
                pagination: true,
                paginationSize: 10,
                paginationSizeSelector: [10, 25, 50],
                enableColumnSelection: true,
                enableSearch: true,
                showFooter: true,
                calcFooterTotals: true,
                cellSpacing: 'compact',
                enableCellSelection: true,
                enableRowSelection: true,
                showSerialNumber: true,
                exportFilename: 'wallet_history',
                layout: 'fitColumns',
                actions: [{
                        id: 'view',
                        label: 'View Details',
                        icon: 'visibility',
                        onClick: function(rowData) {
                            alert('View Transaction: ' + rowData.docNo + '\nVoucher: ' + rowData.voucher);
                        }
                    },
                    {
                        id: 'print',
                        label: 'Print Voucher',
                        icon: 'print',
                        onClick: function(rowData) {
                            alert('Printing voucher: ' + rowData.docNo);
                        }
                    }
                ],
                onRowClick: function(rowData) {
                    console.log('Transaction clicked:', rowData);
                }
            });
        }
    });

    // Panel dropdowns - close on outside click
    document.addEventListener('click', function(e) {
        // Close date range dropdown
        const dateRanges = document.querySelectorAll('.so-panel-date-range.open');
        dateRanges.forEach(function(el) {
            if (!el.contains(e.target)) {
                el.classList.remove('open');
            }
        });

        // Close filter dropdown
        const filters = document.querySelectorAll('.so-panel-filter.open');
        filters.forEach(function(el) {
            if (!el.contains(e.target)) {
                el.classList.remove('open');
            }
        });

        // Close column dropdown
        const columns = document.querySelectorAll('.so-panel-columns.open');
        columns.forEach(function(el) {
            if (!el.contains(e.target)) {
                el.classList.remove('open');
            }
        });

        // Close options dropdown
        const options = document.querySelectorAll('.so-panel-options.open');
        options.forEach(function(el) {
            if (!el.contains(e.target)) {
                el.classList.remove('open');
            }
        });
    });

    // Panel chip remove
    document.querySelectorAll('.so-panel-chip-remove').forEach(function(btn) {
        btn.addEventListener('click', function() {
            this.closest('.so-panel-chip').remove();
        });
    });

    // Clear all chips
    document.querySelectorAll('.so-panel-chips-clear').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const container = this.closest('.so-panel-chips');
            container.querySelectorAll('.so-panel-chip').forEach(function(chip) {
                chip.remove();
            });
        });
    });

    // Mobile Search Button - opens search overlay
    const mobileSearchBtn = document.getElementById('mobileSearchBtn');
    if (mobileSearchBtn) {
        mobileSearchBtn.addEventListener('click', function() {
            if (window.soSearchOverlay) {
                window.soSearchOverlay.open();
            }
        });
    }

    // Mobile Outlet Dropdown
    const mobileOutletBtn = document.getElementById('mobileOutletBtn');
    const mobileOutletDropdown = document.querySelector('.so-mobile-outlet-dropdown');

    if (mobileOutletBtn && mobileOutletDropdown) {
        mobileOutletBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileOutletDropdown.classList.toggle('open');
        });

        // Handle outlet item click
        mobileOutletDropdown.querySelectorAll('.so-mobile-outlet-item').forEach(function(item) {
            item.addEventListener('click', function() {
                mobileOutletDropdown.querySelectorAll('.so-mobile-outlet-item').forEach(function(i) {
                    i.classList.remove('selected');
                });
                this.classList.add('selected');

                const value = this.dataset.value;
                const navbarOutletItems = document.querySelectorAll('.so-navbar-outlet-item');
                navbarOutletItems.forEach(function(navItem) {
                    navItem.classList.remove('selected');
                    if (navItem.dataset.value === value) {
                        navItem.classList.add('selected');
                    }
                });

                mobileOutletDropdown.classList.remove('open');
            });
        });
    }

    // Close mobile outlet dropdown on outside click
    document.addEventListener('click', function(e) {
        if (mobileOutletDropdown && !mobileOutletDropdown.contains(e.target)) {
            mobileOutletDropdown.classList.remove('open');
        }
    });

    // Logout Confirmation
    const sidebarLogoutBtn = document.getElementById('sidebarLogoutBtn');
    const navbarLogoutBtn = document.getElementById('navbarLogoutBtn');
    const logoutConfirmOverlay = document.getElementById('logoutConfirmOverlay');
    const logoutCancelBtn = document.getElementById('logoutCancelBtn');
    const logoutConfirmBtn = document.getElementById('logoutConfirmBtn');

    function showLogoutConfirmation() {
        if (logoutConfirmOverlay) {
            logoutConfirmOverlay.classList.add('active');
        }
    }

    function hideLogoutConfirmation() {
        if (logoutConfirmOverlay) {
            logoutConfirmOverlay.classList.remove('active');
        }
    }

    function handleLogout() {
        localStorage.removeItem('so-user-session');
        localStorage.removeItem('so-screen-locked');
        sessionStorage.clear();
        window.location.href = 'login.php';
    }

    if (sidebarLogoutBtn) {
        sidebarLogoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            showLogoutConfirmation();
        });
    }

    if (navbarLogoutBtn) {
        navbarLogoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            showLogoutConfirmation();
        });
    }

    if (logoutCancelBtn) {
        logoutCancelBtn.addEventListener('click', hideLogoutConfirmation);
    }

    if (logoutConfirmBtn) {
        logoutConfirmBtn.addEventListener('click', handleLogout);
    }

    if (logoutConfirmOverlay) {
        logoutConfirmOverlay.addEventListener('click', function(e) {
            if (e.target === logoutConfirmOverlay) {
                hideLogoutConfirmation();
            }
        });
    }

    // Lock Screen Functionality
    const lockScreen = document.getElementById('lockScreen');
    const lockScreenBtn = document.getElementById('lockScreenBtn');
    const lockScreenForm = document.getElementById('lockScreenForm');
    const lockScreenPassword = document.getElementById('lockScreenPassword');
    const lockScreenTime = document.getElementById('lockScreenTime');
    const lockScreenDate = document.getElementById('lockScreenDate');

    function updateLockScreenTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        if (lockScreenTime) {
            lockScreenTime.textContent = `${hours}:${minutes}`;
        }

        const options = {
            weekday: 'long',
            month: 'long',
            day: 'numeric'
        };
        if (lockScreenDate) {
            lockScreenDate.textContent = now.toLocaleDateString('en-US', options);
        }
    }

    function lockScreenAction() {
        if (lockScreen) {
            lockScreen.classList.add('active');
            document.body.classList.add('screen-locked');
            updateLockScreenTime();
            if (lockScreenPassword) {
                lockScreenPassword.value = '';
                lockScreenPassword.focus();
            }
            localStorage.setItem('so-screen-locked', 'true');
            localStorage.setItem('so-lock-timestamp', Date.now().toString());
        }
    }

    function unlockScreenAction() {
        if (lockScreen) {
            lockScreen.classList.remove('active');
            document.body.classList.remove('screen-locked');
            if (lockScreenPassword) {
                lockScreenPassword.value = '';
            }
            localStorage.removeItem('so-screen-locked');
            localStorage.removeItem('so-lock-timestamp');
        }
    }

    function checkLockState() {
        const isLocked = localStorage.getItem('so-screen-locked') === 'true';
        if (isLocked && lockScreen) {
            lockScreen.classList.add('active');
            document.body.classList.add('screen-locked');
            updateLockScreenTime();
            if (lockScreenPassword) {
                lockScreenPassword.focus();
            }
        }
    }

    if (lockScreenBtn) {
        lockScreenBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            lockScreenAction();
        });
    }

    if (lockScreenForm) {
        lockScreenForm.addEventListener('submit', function(e) {
            e.preventDefault();
            unlockScreenAction();
        });
    }

    window.addEventListener('storage', function(e) {
        if (e.key === 'so-screen-locked') {
            if (e.newValue === 'true') {
                if (lockScreen && !lockScreen.classList.contains('active')) {
                    lockScreen.classList.add('active');
                    document.body.classList.add('screen-locked');
                    updateLockScreenTime();
                }
            } else if (e.newValue === null) {
                if (lockScreen && lockScreen.classList.contains('active')) {
                    lockScreen.classList.remove('active');
                    document.body.classList.remove('screen-locked');
                    if (lockScreenPassword) {
                        lockScreenPassword.value = '';
                    }
                }
            }
        }
    });

    setInterval(updateLockScreenTime, 60000);
    checkLockState();

    // Global Keyboard Shortcuts
    document.addEventListener('keydown', function(e) {
        const isInputFocused = document.activeElement.tagName === 'INPUT' ||
            document.activeElement.tagName === 'TEXTAREA' ||
            document.activeElement.isContentEditable;

        if (e.key === 'Escape') {
            if (logoutConfirmOverlay && logoutConfirmOverlay.classList.contains('active')) {
                hideLogoutConfirmation();
                return;
            }
        }

        if (isInputFocused && e.key !== 'Escape') return;

        if (lockScreen && lockScreen.classList.contains('active')) return;

        // Note: '?' key for keyboard shortcuts is handled by navbar.php

        if ((e.ctrlKey || e.metaKey) && e.key === 'l' && !e.shiftKey) {
            e.preventDefault();
            lockScreenAction();
            return;
        }

        if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'L') {
            e.preventDefault();
            showLogoutConfirmation();
            return;
        }

        if ((e.ctrlKey || e.metaKey) && e.key === 'b' && !e.shiftKey) {
            e.preventDefault();
            const sidebarToggle = document.querySelector('.so-sidebar-toggle');
            if (sidebarToggle) sidebarToggle.click();
            return;
        }

        if ((e.ctrlKey || e.metaKey) && e.key === 'h' && !e.shiftKey) {
            e.preventDefault();
            window.location.href = 'index.php';
            return;
        }
    });
</script>

<?php
require_once 'includes/footer.php';
?>