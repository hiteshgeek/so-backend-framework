<?php
/**
 * SixOrbit UI Demo - Customer Wallet (Ledger)
 * Replicates the original first_draft wallet page with full panel component
 */
require_once 'includes/config.php';
$pageTitle = 'Customer Wallet - ' . DEMO_COMPANY_NAME;
$currentPage = 'wallet';
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/navbar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="so-main-content">
        <!-- Breadcrumb Bar -->
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

        <div class="demo-content" style="padding: 16px;">
            <!-- Customer Profile Header -->
            <div class="so-profile-header">
                <div class="so-profile-header-left">
                    <div class="so-profile-avatar">
                        <span class="so-profile-avatar-text">LM</span>
                    </div>
                    <div class="so-profile-info">
                        <h1 class="so-profile-name">Latha Mohan</h1>
                    </div>
                </div>
                <div class="so-profile-header-right">
                    <div class="so-options-dropdown">
                        <button type="button" class="so-btn so-btn-outline so-options-trigger">
                            <span class="material-icons">bolt</span>
                            Actions
                            <span class="material-icons">expand_more</span>
                        </button>
                        <div class="so-options-menu">
                            <div class="so-options-item" data-action="edit">
                                <span class="material-icons">edit</span>
                                <span>Edit Customer</span>
                            </div>
                            <div class="so-options-item" data-action="statement">
                                <span class="material-icons">description</span>
                                <span>Account Statement</span>
                            </div>
                            <div class="so-options-item" data-action="invoice">
                                <span class="material-icons">receipt</span>
                                <span>Create Invoice</span>
                            </div>
                            <div class="so-options-divider"></div>
                            <div class="so-options-item danger" data-action="delete">
                                <span class="material-icons">delete</span>
                                <span>Delete Customer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row -->
            <div class="so-stats-row">
                <div class="so-stat-card">
                    <div class="so-stat-content">
                        <div class="so-stat-label">TOTAL SALES</div>
                        <div class="so-stat-value">&#8377;12,45,890</div>
                        <div class="so-stat-change positive">
                            <span class="material-icons">trending_up</span>
                            12.5% from last month
                        </div>
                    </div>
                    <div class="so-stat-icon" style="background: linear-gradient(135deg, #1a73e8, #4285f4);">
                        <span class="material-icons">trending_up</span>
                    </div>
                </div>

                <div class="so-stat-card">
                    <div class="so-stat-content">
                        <div class="so-stat-label">TOTAL PURCHASE</div>
                        <div class="so-stat-value">&#8377;8,34,560</div>
                        <div class="so-stat-change negative">
                            <span class="material-icons">trending_down</span>
                            3.2% from last month
                        </div>
                    </div>
                    <div class="so-stat-icon" style="background: linear-gradient(135deg, #ea4335, #ff6b6b);">
                        <span class="material-icons">shopping_cart</span>
                    </div>
                </div>

                <div class="so-stat-card">
                    <div class="so-stat-content">
                        <div class="so-stat-label">PENDING ORDERS</div>
                        <div class="so-stat-value">47</div>
                        <div class="so-stat-change positive">
                            <span class="material-icons">trending_up</span>
                            8 new today
                        </div>
                    </div>
                    <div class="so-stat-icon" style="background: linear-gradient(135deg, #f9ab00, #ffca28);">
                        <span class="material-icons">pending_actions</span>
                    </div>
                </div>

                <div class="so-stat-card">
                    <div class="so-stat-content">
                        <div class="so-stat-label">ACTIVE CUSTOMERS</div>
                        <div class="so-stat-value">1,284</div>
                        <div class="so-stat-change positive">
                            <span class="material-icons">trending_up</span>
                            24 new this week
                        </div>
                    </div>
                    <div class="so-stat-icon" style="background: linear-gradient(135deg, #34a853, #4caf50);">
                        <span class="material-icons">groups</span>
                    </div>
                </div>
            </div>

            <!-- Transaction Panel -->
            <div class="so-panel">
                <!-- Panel Header -->
                <div class="so-panel-header">
                    <div class="so-panel-header-left">
                        <div class="so-panel-icon">
                            <span class="material-icons">account_balance_wallet</span>
                        </div>
                        <div class="so-panel-title-group">
                            <h3 class="so-panel-title">Customer Wallet History</h3>
                            <p class="so-panel-subtitle">LATHA MOHAN's Transaction History</p>
                        </div>
                    </div>
                    <div class="so-panel-header-right">
                        <!-- Options Dropdown -->
                        <div class="so-panel-options">
                            <button class="so-panel-options-btn">
                                <span class="material-icons">more_vert</span>
                                Options
                                <span class="material-icons so-panel-options-arrow">expand_more</span>
                            </button>
                            <div class="so-panel-options-dropdown">
                                <div class="so-panel-options-header">Quick Actions</div>
                                <div class="so-panel-options-list">
                                    <a href="#" class="so-panel-options-item">
                                        <span class="material-icons">compare_arrows</span>
                                        Compare Ledger
                                    </a>
                                    <a href="#" class="so-panel-options-item">
                                        <span class="material-icons">receipt_long</span>
                                        Pending Invoice
                                    </a>
                                    <a href="#" class="so-panel-options-item">
                                        <span class="material-icons">account_balance</span>
                                        Bank Statement
                                    </a>
                                    <div class="so-panel-options-divider"></div>
                                    <a href="#" class="so-panel-options-item">
                                        <span class="material-icons">print</span>
                                        Print Ledger
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Button -->
                        <div class="so-panel-filter">
                            <button class="so-panel-filter-btn so-active">
                                <span class="material-icons">filter_list</span>
                                Filter
                                <span class="so-panel-filter-badge">1</span>
                            </button>
                            <div class="so-panel-filter-dropdown">
                                <div class="so-panel-filter-header">
                                    <span class="so-panel-filter-title">Filters</span>
                                    <button class="so-panel-filter-clear">Clear All</button>
                                </div>
                                <div class="so-panel-filter-body">
                                    <div class="so-panel-filter-group">
                                        <label class="so-panel-filter-group-label">Voucher Type</label>
                                        <select class="so-panel-filter-select">
                                            <option value="">All Types</option>
                                            <option value="sales" selected>Sales</option>
                                            <option value="receipt">Receipt</option>
                                            <option value="credit-note">Credit Note</option>
                                            <option value="debit-note">Debit Note</option>
                                        </select>
                                    </div>
                                    <div class="so-panel-filter-group">
                                        <label class="so-panel-filter-group-label">Outlet</label>
                                        <select class="so-panel-filter-select">
                                            <option value="">All Outlets</option>
                                            <option value="vps">VPS Branch</option>
                                            <option value="head">Head Office</option>
                                            <option value="basava">Basavanagudi</option>
                                        </select>
                                    </div>
                                    <div class="so-panel-filter-group">
                                        <label class="so-panel-filter-group-label">Amount Range</label>
                                        <div style="display: flex; gap: 8px;">
                                            <input type="number" class="so-panel-filter-input" placeholder="Min">
                                            <input type="number" class="so-panel-filter-input" placeholder="Max">
                                        </div>
                                    </div>
                                </div>
                                <div class="so-panel-filter-footer">
                                    <button class="so-panel-btn">Cancel</button>
                                    <button class="so-panel-btn so-panel-btn-primary">Apply Filters</button>
                                </div>
                            </div>
                        </div>

                        <!-- Date Range Picker -->
                        <div class="so-panel-date-range">
                            <span class="material-icons">calendar_today</span>
                            <span class="so-panel-date-range-text">Apr 1, 2025 - Jan 19, 2026</span>
                            <span class="material-icons so-panel-date-range-arrow">expand_more</span>
                            <div class="so-panel-date-dropdown">
                                <div class="so-panel-date-presets">
                                    <div class="so-panel-date-preset">
                                        <span class="material-icons">today</span>
                                        Today
                                    </div>
                                    <div class="so-panel-date-preset">
                                        <span class="material-icons">date_range</span>
                                        This Week
                                    </div>
                                    <div class="so-panel-date-preset">
                                        <span class="material-icons">calendar_month</span>
                                        This Month
                                    </div>
                                    <div class="so-panel-date-preset so-active">
                                        <span class="material-icons">event_note</span>
                                        This Financial Year
                                    </div>
                                    <div class="so-panel-date-preset">
                                        <span class="material-icons">history</span>
                                        Last Financial Year
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

                <!-- Panel Info Row -->
                <div class="so-panel-info">
                    <div class="so-panel-info-item">
                        <span class="so-panel-info-label">Account Group:</span>
                        <span class="so-panel-info-value highlight">Sundry Debtors</span>
                    </div>
                    <div class="so-panel-info-divider"></div>
                    <div class="so-panel-info-item">
                        <span class="so-panel-info-label">Opening Balance:</span>
                        <span class="so-panel-info-value positive">&#8377;1,25,450.00 Dr</span>
                    </div>
                    <div class="so-panel-info-divider"></div>
                    <div class="so-panel-info-item">
                        <span class="so-panel-info-label">Ledger Opening:</span>
                        <span class="so-panel-info-value">&#8377;0.00</span>
                    </div>
                    <div class="so-panel-info-divider"></div>
                    <div class="so-panel-info-item">
                        <span class="so-panel-info-label">Credit Limit:</span>
                        <span class="so-panel-info-value">&#8377;5,00,000.00</span>
                    </div>
                </div>

                <!-- Active Filter Chips -->
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

                <!-- Panel Toolbar -->
                <div class="so-panel-toolbar">
                    <div class="so-panel-toolbar-left">
                        <div class="so-panel-search">
                            <span class="material-icons">search</span>
                            <input type="text" class="so-panel-search-input" placeholder="Search...">
                        </div>
                        <div class="so-panel-entries">
                            <span>Page Size:</span>
                            <select class="so-panel-entries-select">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="so-panel-toolbar-right">
                        <!-- Columns Toggle -->
                        <div class="so-panel-columns">
                            <button class="so-panel-btn so-panel-btn-icon" title="Columns">
                                <span class="material-icons">view_column</span>
                                Columns
                                <span class="so-badge so-badge-soft-primary so-badge-sm">9</span>
                            </button>
                            <div class="so-panel-columns-dropdown">
                                <div class="so-panel-columns-header">Toggle Columns</div>
                                <div class="so-panel-columns-list">
                                    <label class="so-panel-columns-item">
                                        <input type="checkbox" checked>
                                        S.N.
                                    </label>
                                    <label class="so-panel-columns-item">
                                        <input type="checkbox" checked>
                                        Date
                                    </label>
                                    <label class="so-panel-columns-item">
                                        <input type="checkbox" checked>
                                        Doc No.
                                    </label>
                                    <label class="so-panel-columns-item">
                                        <input type="checkbox" checked>
                                        Ref No.
                                    </label>
                                    <label class="so-panel-columns-item">
                                        <input type="checkbox" checked>
                                        Voucher
                                    </label>
                                    <label class="so-panel-columns-item">
                                        <input type="checkbox" checked>
                                        Voucher Type
                                    </label>
                                    <label class="so-panel-columns-item">
                                        <input type="checkbox" checked>
                                        Particulars
                                    </label>
                                    <label class="so-panel-columns-item">
                                        <input type="checkbox" checked>
                                        Debit
                                    </label>
                                    <label class="so-panel-columns-item">
                                        <input type="checkbox" checked>
                                        Credit
                                    </label>
                                    <label class="so-panel-columns-item">
                                        <input type="checkbox" checked>
                                        Outlet
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Group By -->
                        <button class="so-panel-btn">
                            <span class="material-icons">workspaces</span>
                            Group By
                        </button>

                        <!-- Export -->
                        <div class="so-panel-export">
                            <button class="so-panel-export-btn" title="Export">
                                <span class="material-icons">download</span>
                                Export
                            </button>
                        </div>

                        <!-- Refresh -->
                        <button class="so-panel-btn so-panel-btn-icon" title="Refresh">
                            <span class="material-icons">refresh</span>
                        </button>

                        <!-- Fullscreen -->
                        <button class="so-panel-btn so-panel-btn-icon" title="Fullscreen">
                            <span class="material-icons">fullscreen</span>
                        </button>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="so-panel-body" style="padding: 0;">
                    <div class="so-data-table-wrapper">
                        <table class="so-data-table">
                            <thead>
                                <tr>
                                    <th style="width: 40px;"><input type="checkbox" class="so-checkbox-input"></th>
                                    <th style="width: 50px;">S.N.</th>
                                    <th>DATE</th>
                                    <th>DOC NO.</th>
                                    <th>REF NO.</th>
                                    <th>VOUCHER</th>
                                    <th>VOUCHER TYPE</th>
                                    <th>PARTICULARS</th>
                                    <th style="text-align: right;">DEBIT</th>
                                    <th style="text-align: right;">CREDIT</th>
                                    <th>OUTLET</th>
                                    <th style="width: 40px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="so-checkbox-input"></td>
                                    <td>1</td>
                                    <td>2026-01-15</td>
                                    <td class="so-link">SL-2026-0042</td>
                                    <td>INV-0042</td>
                                    <td>Sales</td>
                                    <td><span class="so-badge so-badge-soft-primary">Tax Invoice</span></td>
                                    <td>Sales - Cash</td>
                                    <td style="text-align: right;">&#8377;15,600</td>
                                    <td style="text-align: right;">&#8377;0</td>
                                    <td>VPS Branch</td>
                                    <td>
                                        <div class="so-options-dropdown">
                                            <button type="button" class="so-options-trigger so-btn-icon-sm">
                                                <span class="material-icons">more_vert</span>
                                            </button>
                                            <div class="so-options-menu">
                                                <div class="so-options-item"><span class="material-icons">visibility</span>View</div>
                                                <div class="so-options-item"><span class="material-icons">edit</span>Edit</div>
                                                <div class="so-options-item"><span class="material-icons">print</span>Print</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="so-checkbox-input"></td>
                                    <td>2</td>
                                    <td>2026-01-14</td>
                                    <td class="so-link">RC-2026-0018</td>
                                    <td>REC-0018</td>
                                    <td>Receipt</td>
                                    <td><span class="so-badge so-badge-soft-success">Cash Receipt</span></td>
                                    <td>Payment Received</td>
                                    <td style="text-align: right;">&#8377;0</td>
                                    <td style="text-align: right;">&#8377;25,000</td>
                                    <td>VPS Branch</td>
                                    <td>
                                        <div class="so-options-dropdown">
                                            <button type="button" class="so-options-trigger so-btn-icon-sm">
                                                <span class="material-icons">more_vert</span>
                                            </button>
                                            <div class="so-options-menu">
                                                <div class="so-options-item"><span class="material-icons">visibility</span>View</div>
                                                <div class="so-options-item"><span class="material-icons">edit</span>Edit</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="so-checkbox-input"></td>
                                    <td>3</td>
                                    <td>2026-01-12</td>
                                    <td class="so-link">SL-2026-0038</td>
                                    <td>INV-0038</td>
                                    <td>Sales</td>
                                    <td><span class="so-badge so-badge-soft-primary">Tax Invoice</span></td>
                                    <td>Sales - Credit</td>
                                    <td style="text-align: right;">&#8377;45,200</td>
                                    <td style="text-align: right;">&#8377;0</td>
                                    <td>Head Office</td>
                                    <td>
                                        <div class="so-options-dropdown">
                                            <button type="button" class="so-options-trigger so-btn-icon-sm">
                                                <span class="material-icons">more_vert</span>
                                            </button>
                                            <div class="so-options-menu">
                                                <div class="so-options-item"><span class="material-icons">visibility</span>View</div>
                                                <div class="so-options-item"><span class="material-icons">edit</span>Edit</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="so-checkbox-input"></td>
                                    <td>4</td>
                                    <td>2026-01-10</td>
                                    <td class="so-link">CN-2026-0005</td>
                                    <td>CN-0005</td>
                                    <td>Credit Note</td>
                                    <td><span class="so-badge so-badge-soft-warning">Sales Return</span></td>
                                    <td>Return - Damaged</td>
                                    <td style="text-align: right;">&#8377;0</td>
                                    <td style="text-align: right;">&#8377;3,500</td>
                                    <td>VPS Branch</td>
                                    <td>
                                        <div class="so-options-dropdown">
                                            <button type="button" class="so-options-trigger so-btn-icon-sm">
                                                <span class="material-icons">more_vert</span>
                                            </button>
                                            <div class="so-options-menu">
                                                <div class="so-options-item"><span class="material-icons">visibility</span>View</div>
                                                <div class="so-options-item"><span class="material-icons">edit</span>Edit</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="so-checkbox-input"></td>
                                    <td>5</td>
                                    <td>2026-01-08</td>
                                    <td class="so-link">SL-2026-0035</td>
                                    <td>INV-0035</td>
                                    <td>Sales</td>
                                    <td><span class="so-badge so-badge-soft-primary">Tax Invoice</span></td>
                                    <td>Sales - Cash</td>
                                    <td style="text-align: right;">&#8377;28,900</td>
                                    <td style="text-align: right;">&#8377;0</td>
                                    <td>Basavanagudi</td>
                                    <td>
                                        <div class="so-options-dropdown">
                                            <button type="button" class="so-options-trigger so-btn-icon-sm">
                                                <span class="material-icons">more_vert</span>
                                            </button>
                                            <div class="so-options-menu">
                                                <div class="so-options-item"><span class="material-icons">visibility</span>View</div>
                                                <div class="so-options-item"><span class="material-icons">edit</span>Edit</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="so-checkbox-input"></td>
                                    <td>6</td>
                                    <td>2026-01-05</td>
                                    <td class="so-link">RC-2026-0015</td>
                                    <td>REC-0015</td>
                                    <td>Receipt</td>
                                    <td><span class="so-badge so-badge-soft-info">Bank Transfer</span></td>
                                    <td>Payment Received</td>
                                    <td style="text-align: right;">&#8377;0</td>
                                    <td style="text-align: right;">&#8377;50,000</td>
                                    <td>Head Office</td>
                                    <td>
                                        <div class="so-options-dropdown">
                                            <button type="button" class="so-options-trigger so-btn-icon-sm">
                                                <span class="material-icons">more_vert</span>
                                            </button>
                                            <div class="so-options-menu">
                                                <div class="so-options-item"><span class="material-icons">visibility</span>View</div>
                                                <div class="so-options-item"><span class="material-icons">edit</span>Edit</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="so-checkbox-input"></td>
                                    <td>7</td>
                                    <td>2026-01-03</td>
                                    <td class="so-link">SL-2026-0031</td>
                                    <td>INV-0031</td>
                                    <td>Sales</td>
                                    <td><span class="so-badge so-badge-soft-primary">Tax Invoice</span></td>
                                    <td>Sales - Credit</td>
                                    <td style="text-align: right;">&#8377;67,800</td>
                                    <td style="text-align: right;">&#8377;0</td>
                                    <td>VPS Branch</td>
                                    <td>
                                        <div class="so-options-dropdown">
                                            <button type="button" class="so-options-trigger so-btn-icon-sm">
                                                <span class="material-icons">more_vert</span>
                                            </button>
                                            <div class="so-options-menu">
                                                <div class="so-options-item"><span class="material-icons">visibility</span>View</div>
                                                <div class="so-options-item"><span class="material-icons">edit</span>Edit</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Panel Footer -->
                <div class="so-panel-footer">
                    <div class="so-panel-footer-left">
                        <span>Showing 1 to 7 of 156 entries</span>
                    </div>
                    <div class="so-panel-footer-right">
                        <div class="so-panel-footer-stat">
                            <span class="so-panel-footer-stat-label">Total Debit:</span>
                            <span class="so-panel-footer-stat-value">&#8377;1,57,500.00</span>
                        </div>
                        <div class="so-panel-divider"></div>
                        <div class="so-panel-footer-stat">
                            <span class="so-panel-footer-stat-label">Total Credit:</span>
                            <span class="so-panel-footer-stat-value">&#8377;78,500.00</span>
                        </div>
                        <div class="so-panel-divider"></div>
                        <div class="so-panel-footer-stat">
                            <span class="so-panel-footer-stat-label">Balance:</span>
                            <span class="so-panel-footer-stat-value" style="color: var(--so-accent-success);">&#8377;79,000.00 Dr</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include 'includes/footer.php'; ?>

<script>
// Panel dropdown interactions
document.querySelectorAll('.so-panel-date-range').forEach(el => {
    el.addEventListener('click', function(e) {
        e.stopPropagation();
        this.classList.toggle('open');
    });
});

document.querySelectorAll('.so-panel-filter').forEach(el => {
    el.querySelector('.so-panel-filter-btn').addEventListener('click', function(e) {
        e.stopPropagation();
        el.classList.toggle('open');
    });
});

document.querySelectorAll('.so-panel-options').forEach(el => {
    el.querySelector('.so-panel-options-btn').addEventListener('click', function(e) {
        e.stopPropagation();
        el.classList.toggle('open');
    });
});

document.querySelectorAll('.so-panel-columns').forEach(el => {
    el.querySelector('.so-panel-btn').addEventListener('click', function(e) {
        e.stopPropagation();
        el.classList.toggle('open');
    });
});

// Close dropdowns on outside click
document.addEventListener('click', function() {
    document.querySelectorAll('.so-panel-date-range.open, .so-panel-filter.open, .so-panel-options.open, .so-panel-columns.open').forEach(el => {
        el.classList.remove('open');
    });
});

// Prevent closing when clicking inside dropdown
document.querySelectorAll('.so-panel-date-dropdown, .so-panel-filter-dropdown, .so-panel-options-dropdown, .so-panel-columns-dropdown').forEach(el => {
    el.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});
</script>
