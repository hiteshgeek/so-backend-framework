<?php
/**
 * SixOrbit UI Demo - Profit & Loss Statement
 */
require_once 'includes/config.php';
$pageTitle = 'Profit & Loss - ' . DEMO_COMPANY_NAME;
$currentPage = 'profit-loss';
$reportTitle = 'Profit & Loss Statement';
$reportSubtitle = 'Income & Expense Analysis';
$reportIcon = 'trending_up';
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/navbar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="so-main-content">
        <div class="report-content" style="padding: 16px;">
            <?php include 'includes/report-header.php'; ?>

            <!-- Report Content -->
            <div class="so-report-table-wrapper">
                <table class="so-report-table">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Particulars</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Revenue Section -->
                        <tr class="so-report-section-header">
                            <td colspan="2">
                                <span class="material-icons">expand_more</span>
                                Revenue
                            </td>
                        </tr>
                        <tr class="so-report-group">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="material-icons" style="font-size: 14px; color: var(--so-text-muted);">chevron_right</span>
                                Sales Revenue
                            </td>
                            <td class="so-amount positive">12,45,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Product Sales
                            </td>
                            <td class="so-amount">10,25,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Service Revenue
                            </td>
                            <td class="so-amount">2,20,000.00</td>
                        </tr>
                        <tr class="so-report-group">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="material-icons" style="font-size: 14px; color: var(--so-text-muted);">chevron_right</span>
                                Other Income
                            </td>
                            <td class="so-amount positive">45,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Interest Received
                            </td>
                            <td class="so-amount">25,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Discount Received
                            </td>
                            <td class="so-amount">20,000.00</td>
                        </tr>
                        <tr class="so-report-total">
                            <td><strong>Total Revenue</strong></td>
                            <td class="so-amount positive"><strong>12,90,000.00</strong></td>
                        </tr>

                        <!-- Expenses Section -->
                        <tr class="so-report-section-header">
                            <td colspan="2">
                                <span class="material-icons">expand_more</span>
                                Expenses
                            </td>
                        </tr>
                        <tr class="so-report-group">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="material-icons" style="font-size: 14px; color: var(--so-text-muted);">chevron_right</span>
                                Cost of Goods Sold
                            </td>
                            <td class="so-amount negative">6,80,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Purchase of Materials
                            </td>
                            <td class="so-amount">5,50,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Direct Labour
                            </td>
                            <td class="so-amount">1,30,000.00</td>
                        </tr>
                        <tr class="so-report-group">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="material-icons" style="font-size: 14px; color: var(--so-text-muted);">chevron_right</span>
                                Operating Expenses
                            </td>
                            <td class="so-amount negative">3,25,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Salaries & Wages
                            </td>
                            <td class="so-amount">1,80,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Rent
                            </td>
                            <td class="so-amount">60,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Utilities
                            </td>
                            <td class="so-amount">35,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Marketing & Advertising
                            </td>
                            <td class="so-amount">50,000.00</td>
                        </tr>
                        <tr class="so-report-total">
                            <td><strong>Total Expenses</strong></td>
                            <td class="so-amount negative"><strong>10,05,000.00</strong></td>
                        </tr>

                        <!-- Net Profit -->
                        <tr class="so-report-grand-total">
                            <td><strong>Net Profit</strong></td>
                            <td class="so-amount positive"><strong>2,85,000.00</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            </div><!-- .so-panel-body -->
        </div><!-- .so-panel -->
        </div><!-- .report-content -->
    </main>

<?php include 'includes/footer.php'; ?>
