<?php
/**
 * SixOrbit UI Demo - Balance Sheet
 */
require_once 'includes/config.php';
$pageTitle = 'Balance Sheet - ' . DEMO_COMPANY_NAME;
$currentPage = 'balance-sheet';
$reportTitle = 'Balance Sheet';
$reportSubtitle = 'Assets, Liabilities & Equity';
$reportIcon = 'account_balance_wallet';
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
                        <!-- Assets Section -->
                        <tr class="so-report-section-header">
                            <td colspan="2">
                                <span class="material-icons">expand_more</span>
                                Assets
                            </td>
                        </tr>

                        <!-- Current Assets -->
                        <tr class="so-report-group">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="material-icons" style="font-size: 14px; color: var(--so-text-muted);">chevron_right</span>
                                Current Assets
                            </td>
                            <td class="so-amount">15,80,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Cash & Bank
                            </td>
                            <td class="so-amount">4,50,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Accounts Receivable
                            </td>
                            <td class="so-amount">6,30,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Inventory
                            </td>
                            <td class="so-amount">5,00,000.00</td>
                        </tr>

                        <!-- Fixed Assets -->
                        <tr class="so-report-group">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="material-icons" style="font-size: 14px; color: var(--so-text-muted);">chevron_right</span>
                                Fixed Assets
                            </td>
                            <td class="so-amount">12,50,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Land & Building
                            </td>
                            <td class="so-amount">8,00,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Plant & Machinery
                            </td>
                            <td class="so-amount">3,50,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Furniture & Fixtures
                            </td>
                            <td class="so-amount">1,00,000.00</td>
                        </tr>
                        <tr class="so-report-total">
                            <td><strong>Total Assets</strong></td>
                            <td class="so-amount positive"><strong>28,30,000.00</strong></td>
                        </tr>

                        <!-- Liabilities Section -->
                        <tr class="so-report-section-header">
                            <td colspan="2">
                                <span class="material-icons">expand_more</span>
                                Liabilities
                            </td>
                        </tr>

                        <!-- Current Liabilities -->
                        <tr class="so-report-group">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="material-icons" style="font-size: 14px; color: var(--so-text-muted);">chevron_right</span>
                                Current Liabilities
                            </td>
                            <td class="so-amount">8,45,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Accounts Payable
                            </td>
                            <td class="so-amount">4,20,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Short-term Loans
                            </td>
                            <td class="so-amount">3,00,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Taxes Payable
                            </td>
                            <td class="so-amount">1,25,000.00</td>
                        </tr>

                        <!-- Long-term Liabilities -->
                        <tr class="so-report-group">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="material-icons" style="font-size: 14px; color: var(--so-text-muted);">chevron_right</span>
                                Long-term Liabilities
                            </td>
                            <td class="so-amount">5,00,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                <span class="so-report-indent"></span>
                                Bank Loan
                            </td>
                            <td class="so-amount">5,00,000.00</td>
                        </tr>
                        <tr class="so-report-total">
                            <td><strong>Total Liabilities</strong></td>
                            <td class="so-amount negative"><strong>13,45,000.00</strong></td>
                        </tr>

                        <!-- Equity Section -->
                        <tr class="so-report-section-header">
                            <td colspan="2">
                                <span class="material-icons">expand_more</span>
                                Equity
                            </td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Share Capital
                            </td>
                            <td class="so-amount">10,00,000.00</td>
                        </tr>
                        <tr class="so-report-item">
                            <td>
                                <span class="so-report-indent"></span>
                                Retained Earnings
                            </td>
                            <td class="so-amount">4,85,000.00</td>
                        </tr>
                        <tr class="so-report-total">
                            <td><strong>Total Equity</strong></td>
                            <td class="so-amount positive"><strong>14,85,000.00</strong></td>
                        </tr>

                        <!-- Total Liabilities & Equity -->
                        <tr class="so-report-grand-total">
                            <td><strong>Total Liabilities & Equity</strong></td>
                            <td class="so-amount"><strong>28,30,000.00</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            </div><!-- .so-panel-body -->
        </div><!-- .so-panel -->
        </div><!-- .report-content -->
    </main>

<?php include 'includes/footer.php'; ?>
