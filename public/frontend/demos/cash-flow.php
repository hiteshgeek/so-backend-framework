<?php
/**
 * SixOrbit UI Demo - Cash Flow Statement
 */
require_once 'includes/config.php';
$pageTitle = 'Cash Flow - ' . DEMO_COMPANY_NAME;
$currentPage = 'cash-flow';
$reportTitle = 'Cash Flow Statement';
$reportSubtitle = 'Operating, Investing & Financing Activities';
$reportIcon = 'payments';
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
                        <!-- Operating Activities -->
                        <tr class="so-report-section-header">
                            <td colspan="2">
                                <span class="material-icons">expand_more</span>
                                Cash Flow from Operating Activities
                            </td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Net Profit
                            </td>
                            <td class="so-amount positive">2,85,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Add: Depreciation
                            </td>
                            <td class="so-amount">45,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Decrease in Accounts Receivable
                            </td>
                            <td class="so-amount positive">1,20,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Increase in Inventory
                            </td>
                            <td class="so-amount negative">(80,000.00)</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Increase in Accounts Payable
                            </td>
                            <td class="so-amount positive">65,000.00</td>
                        </tr>
                        <tr class="so-report-total">
                            <td><strong>Net Cash from Operating Activities</strong></td>
                            <td class="so-amount positive"><strong>4,35,000.00</strong></td>
                        </tr>

                        <!-- Investing Activities -->
                        <tr class="so-report-section-header">
                            <td colspan="2">
                                <span class="material-icons">expand_more</span>
                                Cash Flow from Investing Activities
                            </td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Purchase of Equipment
                            </td>
                            <td class="so-amount negative">(1,50,000.00)</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Sale of Old Machinery
                            </td>
                            <td class="so-amount positive">25,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Investment in Securities
                            </td>
                            <td class="so-amount negative">(50,000.00)</td>
                        </tr>
                        <tr class="so-report-total">
                            <td><strong>Net Cash from Investing Activities</strong></td>
                            <td class="so-amount negative"><strong>(1,75,000.00)</strong></td>
                        </tr>

                        <!-- Financing Activities -->
                        <tr class="so-report-section-header">
                            <td colspan="2">
                                <span class="material-icons">expand_more</span>
                                Cash Flow from Financing Activities
                            </td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Loan Repayment
                            </td>
                            <td class="so-amount negative">(1,00,000.00)</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Dividend Paid
                            </td>
                            <td class="so-amount negative">(50,000.00)</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Interest Paid
                            </td>
                            <td class="so-amount negative">(30,000.00)</td>
                        </tr>
                        <tr class="so-report-total">
                            <td><strong>Net Cash from Financing Activities</strong></td>
                            <td class="so-amount negative"><strong>(1,80,000.00)</strong></td>
                        </tr>

                        <!-- Net Change in Cash -->
                        <tr class="so-report-grand-total">
                            <td><strong>Net Increase in Cash</strong></td>
                            <td class="so-amount positive"><strong>80,000.00</strong></td>
                        </tr>

                        <!-- Opening & Closing Balance -->
                        <tr class="so-report-item" style="background: var(--so-card-hover-bg);">
                            <td>
                                <span class="so-report-indent"></span>
                                Opening Cash Balance
                            </td>
                            <td class="so-amount">3,70,000.00</td>
                        </tr>
                        <tr class="so-report-grand-total">
                            <td><strong>Closing Cash Balance</strong></td>
                            <td class="so-amount positive"><strong>4,50,000.00</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            </div><!-- .so-panel-body -->
        </div><!-- .so-panel -->
        </div><!-- .report-content -->
    </main>

<?php include 'includes/footer.php'; ?>
