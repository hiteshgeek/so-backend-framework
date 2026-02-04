<?php
/**
 * SixOrbit UI Demo - Trial Balance
 */
require_once 'includes/config.php';
$pageTitle = 'Trial Balance - ' . DEMO_COMPANY_NAME;
$currentPage = 'trial-balance';
$reportTitle = 'Trial Balance';
$reportSubtitle = 'Debit & Credit Verification';
$reportIcon = 'receipt_long';
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
                            <th style="width: 40%;">Account Name</th>
                            <th style="text-align: right; width: 30%;">Debit</th>
                            <th style="text-align: right; width: 30%;">Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Assets -->
                        <tr class="so-report-section-header">
                            <td colspan="3">
                                <span class="material-icons">expand_more</span>
                                Assets
                            </td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Cash in Hand
                            </td>
                            <td class="so-amount">1,25,000.00</td>
                            <td class="so-amount">-</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Bank Account
                            </td>
                            <td class="so-amount">3,25,000.00</td>
                            <td class="so-amount">-</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Accounts Receivable
                            </td>
                            <td class="so-amount">6,30,000.00</td>
                            <td class="so-amount">-</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Inventory
                            </td>
                            <td class="so-amount">5,00,000.00</td>
                            <td class="so-amount">-</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Land & Building
                            </td>
                            <td class="so-amount">8,00,000.00</td>
                            <td class="so-amount">-</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Plant & Machinery
                            </td>
                            <td class="so-amount">3,50,000.00</td>
                            <td class="so-amount">-</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Furniture & Fixtures
                            </td>
                            <td class="so-amount">1,00,000.00</td>
                            <td class="so-amount">-</td>
                        </tr>

                        <!-- Liabilities -->
                        <tr class="so-report-section-header">
                            <td colspan="3">
                                <span class="material-icons">expand_more</span>
                                Liabilities
                            </td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Accounts Payable
                            </td>
                            <td class="so-amount">-</td>
                            <td class="so-amount">4,20,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Short-term Loans
                            </td>
                            <td class="so-amount">-</td>
                            <td class="so-amount">3,00,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Taxes Payable
                            </td>
                            <td class="so-amount">-</td>
                            <td class="so-amount">1,25,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Bank Loan
                            </td>
                            <td class="so-amount">-</td>
                            <td class="so-amount">5,00,000.00</td>
                        </tr>

                        <!-- Equity -->
                        <tr class="so-report-section-header">
                            <td colspan="3">
                                <span class="material-icons">expand_more</span>
                                Equity
                            </td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Share Capital
                            </td>
                            <td class="so-amount">-</td>
                            <td class="so-amount">10,00,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Retained Earnings
                            </td>
                            <td class="so-amount">-</td>
                            <td class="so-amount">4,85,000.00</td>
                        </tr>

                        <!-- Totals -->
                        <tr class="so-report-grand-total">
                            <td><strong>Total</strong></td>
                            <td class="so-amount"><strong>28,30,000.00</strong></td>
                            <td class="so-amount"><strong>28,30,000.00</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Balance Check -->
            <div style="padding: 16px; text-align: center;">
                <span class="so-badge so-badge-soft-success" style="font-size: 14px; padding: 8px 16px;">
                    <span class="material-icons" style="font-size: 18px; vertical-align: middle; margin-right: 4px;">check_circle</span>
                    Trial Balance is Balanced
                </span>
            </div>

            </div><!-- .so-panel-body -->
        </div><!-- .so-panel -->
        </div><!-- .report-content -->
    </main>

<?php include 'includes/footer.php'; ?>
