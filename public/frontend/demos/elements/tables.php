<?php
/**
 * SixOrbit UI Demo - Tables
 */
$pageTitle = 'Tables';
$pageDescription = 'Table components and data display';

require_once '../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/navbar.php';
?>

<!-- Main Content -->
<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Tables</h1>
            <p class="so-page-subtitle">Table components and data display</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Basic Table -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Basic Table</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">A simple table with the base <code>.so-table</code> class.</p>

                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Smith</td>
                                    <td>john@example.com</td>
                                    <td>Admin</td>
                                    <td><span class="so-badge so-badge-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Doe</td>
                                    <td>jane@example.com</td>
                                    <td>Editor</td>
                                    <td><span class="so-badge so-badge-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Bob Johnson</td>
                                    <td>bob@example.com</td>
                                    <td>User</td>
                                    <td><span class="so-badge so-badge-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Alice Brown</td>
                                    <td>alice@example.com</td>
                                    <td>User</td>
                                    <td><span class="so-badge so-badge-danger">Inactive</span></td>
                                </tr>
                            </tbody>
                        </table>

<?= so_code_block('<table class="so-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>John Smith</td>
            <td>john@example.com</td>
        </tr>
    </tbody>
</table>', 'html') ?>
                    </div>
                </div>

                <!-- Striped & Hover -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Striped & Hover Tables</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Add <code>.so-table-striped</code> for zebra-striping and <code>.so-table-hover</code> for row hover effect.</p>

                        <div class="so-row so-g-4">
                            <div class="so-col-md-6">
                                <h4 class="so-text-sm so-font-semibold so-mb-3">Striped</h4>
                                <table class="so-table so-table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Laptop Pro</td><td>$1,299</td><td>45</td></tr>
                                        <tr><td>Wireless Mouse</td><td>$49</td><td>120</td></tr>
                                        <tr><td>USB-C Hub</td><td>$89</td><td>78</td></tr>
                                        <tr><td>Keyboard</td><td>$159</td><td>32</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="so-col-md-6">
                                <h4 class="so-text-sm so-font-semibold so-mb-3">Hover</h4>
                                <table class="so-table so-table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Jan 15</td><td>Office Supplies</td><td>$125</td></tr>
                                        <tr><td>Jan 14</td><td>Client Payment</td><td>$2,500</td></tr>
                                        <tr><td>Jan 12</td><td>Software License</td><td>$99</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

<?= so_code_block('<table class="so-table so-table-striped">...</table>
<table class="so-table so-table-hover">...</table>
<table class="so-table so-table-striped so-table-hover">...</table>', 'html') ?>
                    </div>
                </div>

                <!-- Bordered & Borderless -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Bordered & Borderless</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Use <code>.so-table-bordered</code> or <code>.so-table-borderless</code> for border variants.</p>

                        <div class="so-row so-g-4">
                            <div class="so-col-md-6">
                                <h4 class="so-text-sm so-font-semibold so-mb-3">Bordered</h4>
                                <table class="so-table so-table-bordered">
                                    <thead>
                                        <tr><th>Name</th><th>Score</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Team A</td><td>85</td></tr>
                                        <tr><td>Team B</td><td>92</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="so-col-md-6">
                                <h4 class="so-text-sm so-font-semibold so-mb-3">Borderless</h4>
                                <table class="so-table so-table-borderless">
                                    <thead>
                                        <tr><th>Name</th><th>Score</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Team A</td><td>85</td></tr>
                                        <tr><td>Team B</td><td>92</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

<?= so_code_block('<table class="so-table so-table-bordered">...</table>
<table class="so-table so-table-borderless">...</table>', 'html') ?>
                    </div>
                </div>

                <!-- Size Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Size Variants</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Use <code>.so-table-sm</code> for compact tables or <code>.so-table-lg</code> for larger padding.</p>

                        <div class="so-row so-g-4">
                            <div class="so-col-md-6">
                                <h4 class="so-text-sm so-font-semibold so-mb-3">Small Table</h4>
                                <table class="so-table so-table-sm so-table-bordered">
                                    <thead>
                                        <tr><th>ID</th><th>Item</th><th>Qty</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>001</td><td>Widget A</td><td>5</td></tr>
                                        <tr><td>002</td><td>Widget B</td><td>12</td></tr>
                                        <tr><td>003</td><td>Widget C</td><td>8</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="so-col-md-6">
                                <h4 class="so-text-sm so-font-semibold so-mb-3">Large Table</h4>
                                <table class="so-table so-table-lg so-table-bordered">
                                    <thead>
                                        <tr><th>ID</th><th>Item</th><th>Qty</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>001</td><td>Widget A</td><td>5</td></tr>
                                        <tr><td>002</td><td>Widget B</td><td>12</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

<?= so_code_block('<table class="so-table so-table-sm">...</table>
<table class="so-table so-table-lg">...</table>', 'html') ?>
                    </div>
                </div>

                <!-- Header Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Header Variants</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Use <code>.so-thead-light</code> or <code>.so-thead-dark</code> on the thead element.</p>

                        <div class="so-row so-g-4">
                            <div class="so-col-md-6">
                                <h4 class="so-text-sm so-font-semibold so-mb-3">Light Header</h4>
                                <table class="so-table">
                                    <thead class="so-thead-light">
                                        <tr><th>Name</th><th>Position</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>John</td><td>Developer</td></tr>
                                        <tr><td>Jane</td><td>Designer</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="so-col-md-6">
                                <h4 class="so-text-sm so-font-semibold so-mb-3">Dark Header</h4>
                                <table class="so-table">
                                    <thead class="so-thead-dark">
                                        <tr><th>Name</th><th>Position</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>John</td><td>Developer</td></tr>
                                        <tr><td>Jane</td><td>Designer</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

<?= so_code_block('<table class="so-table">
    <thead class="so-thead-light">...</thead>
</table>
<table class="so-table">
    <thead class="so-thead-dark">...</thead>
</table>', 'html') ?>
                    </div>
                </div>

                <!-- Contextual Colors -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Contextual Colors</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Apply contextual colors to rows or cells using <code>.so-table-{color}</code>.</p>

                        <table class="so-table so-table-bordered">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="so-table-primary">
                                    <td>Primary</td>
                                    <td>Highlighted</td>
                                    <td>Important information</td>
                                </tr>
                                <tr class="so-table-success">
                                    <td>Success</td>
                                    <td>Completed</td>
                                    <td>Task finished</td>
                                </tr>
                                <tr class="so-table-warning">
                                    <td>Warning</td>
                                    <td>Pending</td>
                                    <td>Needs attention</td>
                                </tr>
                                <tr class="so-table-danger">
                                    <td>Danger</td>
                                    <td>Failed</td>
                                    <td>Action required</td>
                                </tr>
                                <tr class="so-table-info">
                                    <td>Info</td>
                                    <td>In Progress</td>
                                    <td>Processing</td>
                                </tr>
                                <tr>
                                    <td>Cell colors</td>
                                    <td class="so-table-success">Success cell</td>
                                    <td class="so-table-danger">Danger cell</td>
                                </tr>
                            </tbody>
                        </table>

<?= so_code_block('<tr class="so-table-primary">...</tr>
<tr class="so-table-success">...</tr>
<tr class="so-table-warning">...</tr>
<tr class="so-table-danger">...</tr>
<tr class="so-table-info">...</tr>
<td class="so-table-success">Cell</td>', 'html') ?>
                    </div>
                </div>

                <!-- Responsive Table -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Responsive Table</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Wrap table in <code>.so-table-responsive</code> for horizontal scrolling on small screens.</p>

                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Zip</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>John</td>
                                        <td>Smith</td>
                                        <td>john.smith@example.com</td>
                                        <td>(555) 123-4567</td>
                                        <td>123 Main Street</td>
                                        <td>New York</td>
                                        <td>NY</td>
                                        <td>10001</td>
                                        <td><button class="so-btn so-btn-sm so-btn-primary">Edit</button></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Jane</td>
                                        <td>Doe</td>
                                        <td>jane.doe@example.com</td>
                                        <td>(555) 987-6543</td>
                                        <td>456 Oak Avenue</td>
                                        <td>Los Angeles</td>
                                        <td>CA</td>
                                        <td>90001</td>
                                        <td><button class="so-btn so-btn-sm so-btn-primary">Edit</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

<?= so_code_block('<div class="so-table-responsive">
    <table class="so-table">...</table>
</div>

<!-- Breakpoint-specific -->
<div class="so-table-responsive-md">...</div>
<div class="so-table-responsive-lg">...</div>', 'html') ?>
                    </div>
                </div>

                <!-- Sortable Table -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Sortable Table</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Add <code>data-so-table</code> and <code>data-so-sortable="true"</code> for interactive sorting. Click column headers to sort.</p>

                        <table class="so-table so-table-hover" data-so-table data-so-sortable="true">
                            <thead>
                                <tr>
                                    <th data-sort="name">
                                        <span class="so-table-sort">
                                            <span>Employee</span>
                                            <span class="so-table-sort-icon"><span class="material-icons">unfold_more</span></span>
                                        </span>
                                    </th>
                                    <th data-sort="department">
                                        <span class="so-table-sort">
                                            <span>Department</span>
                                            <span class="so-table-sort-icon"><span class="material-icons">unfold_more</span></span>
                                        </span>
                                    </th>
                                    <th data-sort="salary">
                                        <span class="so-table-sort">
                                            <span>Salary</span>
                                            <span class="so-table-sort-icon"><span class="material-icons">unfold_more</span></span>
                                        </span>
                                    </th>
                                    <th data-sort="joined">
                                        <span class="so-table-sort">
                                            <span>Joined</span>
                                            <span class="so-table-sort-icon"><span class="material-icons">unfold_more</span></span>
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Alice Johnson</td>
                                    <td>Engineering</td>
                                    <td>$95,000</td>
                                    <td>2021-03-15</td>
                                </tr>
                                <tr>
                                    <td>Bob Williams</td>
                                    <td>Marketing</td>
                                    <td>$72,000</td>
                                    <td>2020-07-22</td>
                                </tr>
                                <tr>
                                    <td>Carol Davis</td>
                                    <td>Engineering</td>
                                    <td>$105,000</td>
                                    <td>2019-01-10</td>
                                </tr>
                                <tr>
                                    <td>David Brown</td>
                                    <td>Sales</td>
                                    <td>$68,000</td>
                                    <td>2022-06-01</td>
                                </tr>
                                <tr>
                                    <td>Eve Miller</td>
                                    <td>HR</td>
                                    <td>$62,000</td>
                                    <td>2023-02-14</td>
                                </tr>
                            </tbody>
                        </table>

<?= so_code_block('<table class="so-table" data-so-table data-so-sortable="true">
    <thead>
        <tr>
            <th data-sort="name">
                <span class="so-table-sort">
                    <span>Name</span>
                    <span class="so-table-sort-icon">
                        <span class="material-icons">unfold_more</span>
                    </span>
                </span>
            </th>
        </tr>
    </thead>
</table>', 'html') ?>
                    </div>
                </div>

                <!-- Selectable Table -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Selectable Table</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Add <code>data-so-selectable="true"</code> for row selection with checkboxes.</p>

                        <table class="so-table so-table-hover" id="demo-selectable-table" data-so-table data-so-selectable="true">
                            <thead>
                                <tr>
                                    <th class="so-table-check so-table-check-all">
                                        <label class="so-checkbox">
                                            <input type="checkbox">
                                            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                        </label>
                                    </th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="so-table-check">
                                        <label class="so-checkbox">
                                            <input type="checkbox">
                                            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                        </label>
                                    </td>
                                    <td>#ORD-001</td>
                                    <td>John Smith</td>
                                    <td>$299.00</td>
                                    <td><span class="so-badge so-badge-success">Shipped</span></td>
                                </tr>
                                <tr>
                                    <td class="so-table-check">
                                        <label class="so-checkbox">
                                            <input type="checkbox">
                                            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                        </label>
                                    </td>
                                    <td>#ORD-002</td>
                                    <td>Jane Doe</td>
                                    <td>$159.00</td>
                                    <td><span class="so-badge so-badge-warning">Processing</span></td>
                                </tr>
                                <tr>
                                    <td class="so-table-check">
                                        <label class="so-checkbox">
                                            <input type="checkbox">
                                            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                        </label>
                                    </td>
                                    <td>#ORD-003</td>
                                    <td>Bob Johnson</td>
                                    <td>$499.00</td>
                                    <td><span class="so-badge so-badge-info">Pending</span></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="so-mt-3">
                            <button class="so-btn so-btn-sm so-btn-outline-primary" onclick="demoSelectAll()">Select All</button>
                            <button class="so-btn so-btn-sm so-btn-outline-secondary" onclick="demoDeselectAll()">Deselect All</button>
                            <button class="so-btn so-btn-sm so-btn-outline-info" onclick="demoGetSelected()">Get Selected</button>
                        </div>

<?= so_code_block('<table class="so-table" data-so-table data-so-selectable="true">
    <thead>
        <tr>
            <th class="so-table-check so-table-check-all">
                <label class="so-checkbox">
                    <input type="checkbox">
                    <span class="so-checkbox-box">...</span>
                </label>
            </th>
            <th>Column</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="so-table-check">
                <label class="so-checkbox">...</label>
            </td>
            <td>Data</td>
        </tr>
    </tbody>
</table>', 'html') ?>
                    </div>
                </div>

                <!-- Table with Toolbar -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Table with Toolbar & Footer</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Use <code>.so-table-toolbar</code> and <code>.so-table-footer</code> for additional controls.</p>

                        <div class="so-table-toolbar">
                            <h4 class="so-table-title">Recent Orders</h4>
                            <div class="so-table-actions">
                                <button class="so-btn so-btn-sm so-btn-outline-secondary">
                                    <span class="material-icons">filter_list</span> Filter
                                </button>
                                <button class="so-btn so-btn-sm so-btn-primary">
                                    <span class="material-icons">add</span> Add Order
                                </button>
                            </div>
                        </div>

                        <div class="so-table-responsive">
                            <table class="so-table so-table-hover so-mb-0">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#12345</td>
                                        <td>Jan 20, 2024</td>
                                        <td>John Doe</td>
                                        <td>$349.00</td>
                                        <td><span class="so-badge so-badge-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>#12346</td>
                                        <td>Jan 19, 2024</td>
                                        <td>Jane Smith</td>
                                        <td>$129.00</td>
                                        <td><span class="so-badge so-badge-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>#12347</td>
                                        <td>Jan 18, 2024</td>
                                        <td>Bob Johnson</td>
                                        <td>$599.00</td>
                                        <td><span class="so-badge so-badge-info">Processing</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="so-table-footer">
                            <span class="so-text-secondary so-text-sm">Showing 1-3 of 100 orders</span>
                            <nav class="so-pagination so-pagination-sm">
                                <ul class="so-pagination-nav">
                                    <li class="so-page-item so-disabled">
                                        <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
                                    </li>
                                    <li class="so-page-item so-active"><a class="so-page-link" href="#">1</a></li>
                                    <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                    <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                    <li class="so-page-item">
                                        <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

<?= so_code_block('<div class="so-table-toolbar">
    <h4 class="so-table-title">Title</h4>
    <div class="so-table-actions">...</div>
</div>

<table class="so-table">...</table>

<div class="so-table-footer">
    <span>Page info</span>
    <nav class="so-pagination">...</nav>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Combined Example -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Combined Features</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Combine multiple features: striped + hover + bordered + dark header.</p>

                        <table class="so-table so-table-striped so-table-hover so-table-bordered">
                            <thead class="so-thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Laptop Pro 15"</td>
                                    <td>Electronics</td>
                                    <td>$1,299.00</td>
                                    <td><span class="so-badge so-badge-success">In Stock</span></td>
                                    <td>
                                        <button class="so-btn so-btn-xs so-btn-outline-primary">Edit</button>
                                        <button class="so-btn so-btn-xs so-btn-outline-danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Wireless Earbuds</td>
                                    <td>Audio</td>
                                    <td>$149.00</td>
                                    <td><span class="so-badge so-badge-warning">Low Stock</span></td>
                                    <td>
                                        <button class="so-btn so-btn-xs so-btn-outline-primary">Edit</button>
                                        <button class="so-btn so-btn-xs so-btn-outline-danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Smart Watch</td>
                                    <td>Wearables</td>
                                    <td>$299.00</td>
                                    <td><span class="so-badge so-badge-danger">Out of Stock</span></td>
                                    <td>
                                        <button class="so-btn so-btn-xs so-btn-outline-primary">Edit</button>
                                        <button class="so-btn so-btn-xs so-btn-outline-danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Bluetooth Speaker</td>
                                    <td>Audio</td>
                                    <td>$79.00</td>
                                    <td><span class="so-badge so-badge-success">In Stock</span></td>
                                    <td>
                                        <button class="so-btn so-btn-xs so-btn-outline-primary">Edit</button>
                                        <button class="so-btn so-btn-xs so-btn-outline-danger">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total Products</th>
                                    <th colspan="3">4 items</th>
                                </tr>
                            </tfoot>
                        </table>

<?= so_code_block('<table class="so-table so-table-striped so-table-hover so-table-bordered">
    <thead class="so-thead-dark">...</thead>
    <tbody>...</tbody>
    <tfoot>...</tfoot>
</table>', 'html') ?>
                    </div>
                </div>

<script>
function demoSelectAll() {
    const table = SOTable.getInstance(document.querySelector('#demo-selectable-table'));
    if (table) table.selectAll();
}

function demoDeselectAll() {
    const table = SOTable.getInstance(document.querySelector('#demo-selectable-table'));
    if (table) table.deselectAll();
}

function demoGetSelected() {
    const table = SOTable.getInstance(document.querySelector('#demo-selectable-table'));
    if (table) {
        const selected = table.getSelectedRows();
        alert('Selected rows: ' + selected.length);
    }
}
</script>

    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
