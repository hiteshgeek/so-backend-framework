<?php
/**
 * SixOrbit UI Demo - Print Styles
 */
$pageTitle = 'Print Styles';
$pageDescription = 'Utilities for controlling how content appears when printed.';

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
            <h1 class="so-page-title"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="so-page-subtitle"><?= htmlspecialchars($pageDescription) ?></p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

<!-- Print Preview -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Print Preview</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Click the button to open the browser's print dialog and see how this page renders for printing.</p>

                <button class="so-btn so-btn-primary" onclick="window.print()">
                    <span class="material-icons">print</span>
                    Print This Page
                </button>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;button class="so-btn so-btn-primary" onclick="window.print()"&gt;
    &lt;span class="material-icons"&gt;print&lt;/span&gt;
    Print This Page
&lt;/button&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Print Visibility -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Print Visibility</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Control which elements appear when printing.</p>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Hidden when printing --&gt;
&lt;div class="so-print-hide"&gt;This will NOT appear on printed pages&lt;/div&gt;

&lt;!-- Visible only when printing --&gt;
&lt;div class="so-print-only"&gt;This will ONLY appear on printed pages&lt;/div&gt;

&lt;!-- Page break controls --&gt;
&lt;div class="so-print-break-before"&gt;Start on new page&lt;/div&gt;
&lt;div class="so-print-break-after"&gt;Force page break after&lt;/div&gt;
&lt;div class="so-print-break-avoid"&gt;Avoid breaking within&lt;/div&gt;</code></pre>
            </div>

        <div class="so-row so-g-4">
            <div class="so-col-md-6">
                <div class="so-card so-card-bordered">
                    <div class="so-card-header">
                        <h6 class="so-card-title"><code>.so-print-hide</code></h6>
                    </div>
                    <div class="so-card-body">
                        <p>This content is visible on screen but <span class="so-text-danger">hidden when printing</span>.</p>
                        <div class="so-alert so-alert-info so-print-hide">
                            <span class="material-icons">info</span>
                            <div>This alert will NOT appear on printed pages.</div>
                        </div>
                        <p class="so-text-muted so-text-sm">The alert above has <code>.so-print-hide</code> class.</p>
                    </div>
                </div>
            </div>
            <div class="so-col-md-6">
                <div class="so-card so-card-bordered">
                    <div class="so-card-header">
                        <h6 class="so-card-title"><code>.so-print-only</code></h6>
                    </div>
                    <div class="so-card-body">
                        <p>This content has a hidden element that only appears when printing.</p>
                        <div class="so-alert so-alert-success so-print-only">
                            <span class="material-icons">check_circle</span>
                            <div>This alert ONLY appears on printed pages.</div>
                        </div>
                        <p class="so-text-muted so-text-sm">There's a hidden alert with <code>.so-print-only</code> that shows when you print.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page Breaks -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Page Breaks</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Control where page breaks occur when printing.</p>

                <div class="so-d-flex so-flex-column so-gap-4">
                    <div class="so-card so-card-bordered">
                        <div class="so-card-header">
                            <h6 class="so-card-title"><code>.so-print-break-before</code></h6>
                        </div>
                        <div class="so-card-body">
                            <p>This element will start on a new page when printing. Useful for chapters or major sections.</p>
                        </div>
                    </div>

                    <div class="so-card so-card-bordered so-print-break-before">
                        <div class="so-card-header">
                            <h6 class="so-card-title"><code>.so-print-break-after</code></h6>
                        </div>
                        <div class="so-card-body">
                            <p>Content after this element will start on a new page. Good for section endings.</p>
                        </div>
                    </div>

                    <div class="so-card so-card-bordered so-print-break-avoid">
                        <div class="so-card-header">
                            <h6 class="so-card-title"><code>.so-print-break-avoid</code></h6>
                        </div>
                        <div class="so-card-body">
                            <p>This element will try to avoid page breaks inside it, keeping the content together.</p>
                            <ul>
                                <li>Item 1 - Will stay with the content</li>
                                <li>Item 2 - All items stay together</li>
                                <li>Item 3 - No page break in the middle</li>
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Start on a new page --&gt;
&lt;div class="so-print-break-before"&gt;
    New chapter content...
&lt;/div&gt;

&lt;!-- Force page break after --&gt;
&lt;div class="so-print-break-after"&gt;
    Section ending...
&lt;/div&gt;

&lt;!-- Keep content together (avoid breaks inside) --&gt;
&lt;div class="so-print-break-avoid"&gt;
    &lt;table&gt;...&lt;/table&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- What Gets Hidden When Printing -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Auto-Hidden Elements</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">These interactive elements are automatically hidden when printing.</p>

        <div class="so-row so-g-4">
            <div class="so-col-md-6">
                <h6 class="so-mb-3">Hidden by Default</h6>
                <ul class="so-list-group">
                    <li class="so-list-group-item so-d-flex so-align-items-center">
                        <span class="material-icons so-me-2">menu</span>
                        Sidebar Navigation
                    </li>
                    <li class="so-list-group-item so-d-flex so-align-items-center">
                        <span class="material-icons so-me-2">smart_button</span>
                        Buttons (non-essential)
                    </li>
                    <li class="so-list-group-item so-d-flex so-align-items-center">
                        <span class="material-icons so-me-2">edit</span>
                        Form Controls
                    </li>
                    <li class="so-list-group-item so-d-flex so-align-items-center">
                        <span class="material-icons so-me-2">arrow_drop_down</span>
                        Dropdown Menus
                    </li>
                    <li class="so-list-group-item so-d-flex so-align-items-center">
                        <span class="material-icons so-me-2">filter_list</span>
                        Filters & Sorting
                    </li>
                </ul>
            </div>
            <div class="so-col-md-6">
                <h6 class="so-mb-3">Visible on Print</h6>
                <ul class="so-list-group">
                    <li class="so-list-group-item so-d-flex so-align-items-center">
                        <span class="material-icons so-me-2">article</span>
                        Main Content
                    </li>
                    <li class="so-list-group-item so-d-flex so-align-items-center">
                        <span class="material-icons so-me-2">table_chart</span>
                        Tables
                    </li>
                    <li class="so-list-group-item so-d-flex so-align-items-center">
                        <span class="material-icons so-me-2">image</span>
                        Images
                    </li>
                    <li class="so-list-group-item so-d-flex so-align-items-center">
                        <span class="material-icons so-me-2">title</span>
                        Headings & Text
                    </li>
                    <li class="so-list-group-item so-d-flex so-align-items-center">
                        <span class="material-icons so-me-2">link</span>
                        Links (with URLs)
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Print-Optimized Content -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Print-Optimized Content</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Sample content that demonstrates print optimization.</p>

                <div class="so-print-break-avoid">
                    <h4>Company Report - Q4 2024</h4>
                    <p>This section demonstrates how content looks when printed. Shadows are removed, backgrounds are simplified, and colors are optimized for black and white printing.</p>

                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Q3 2024</th>
                                <th>Q4 2024</th>
                                <th>Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Revenue</td>
                                <td>$1.2M</td>
                                <td>$1.5M</td>
                                <td class="so-text-success">+25%</td>
                            </tr>
                            <tr>
                                <td>Users</td>
                                <td>10,000</td>
                                <td>15,000</td>
                                <td class="so-text-success">+50%</td>
                            </tr>
                            <tr>
                                <td>Retention</td>
                                <td>85%</td>
                                <td>88%</td>
                                <td class="so-text-success">+3%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-print-break-avoid"&gt;
    &lt;h4&gt;Report Title&lt;/h4&gt;
    &lt;p&gt;Report description...&lt;/p&gt;

    &lt;table class="so-table so-table-bordered"&gt;
        &lt;thead&gt;
            &lt;tr&gt;
                &lt;th&gt;Metric&lt;/th&gt;
                &lt;th&gt;Value&lt;/th&gt;
            &lt;/tr&gt;
        &lt;/thead&gt;
        &lt;tbody&gt;
            &lt;tr&gt;
                &lt;td&gt;Revenue&lt;/td&gt;
                &lt;td&gt;$1.5M&lt;/td&gt;
            &lt;/tr&gt;
        &lt;/tbody&gt;
    &lt;/table&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Link URLs in Print -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Link URLs in Print</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Links automatically show their URLs when printed for reference.</p>

                <p>Visit our website at <a href="https://example.com">Example.com</a> for more information.</p>
                <p>Check out the <a href="https://github.com/example/project">GitHub repository</a> for source code.</p>
                <p>Contact us at <a href="mailto:hello@example.com">hello@example.com</a> for support.</p>

                <div class="so-alert so-alert-info so-mt-3">
                    <span class="material-icons">info</span>
                    <div>When you print this page, the full URLs will appear after each link text.</div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Links will show URLs in print automatically --&gt;
&lt;p&gt;Visit &lt;a href="https://example.com"&gt;Example.com&lt;/a&gt;&lt;/p&gt;

&lt;!-- CSS for showing URLs (in print styles): --&gt;
&lt;!-- @media print { a[href]:after { content: " (" attr(href) ")"; } } --&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Print Utility Classes Reference -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Available Print Classes</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Quick reference for print utility classes.</p>

        <div class="so-table-responsive">
            <table class="so-table">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Description</th>
                        <th>Use Case</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>.so-print-hide</code></td>
                        <td>Hidden when printing</td>
                        <td>Navigation, buttons, interactive elements</td>
                    </tr>
                    <tr>
                        <td><code>.so-print-only</code></td>
                        <td>Visible only when printing</td>
                        <td>Print-specific headers, footers, notes</td>
                    </tr>
                    <tr>
                        <td><code>.so-print-break-before</code></td>
                        <td>Page break before element</td>
                        <td>Chapters, major sections</td>
                    </tr>
                    <tr>
                        <td><code>.so-print-break-after</code></td>
                        <td>Page break after element</td>
                        <td>Section endings, separators</td>
                    </tr>
                    <tr>
                        <td><code>.so-print-break-avoid</code></td>
                        <td>Avoid page break inside</td>
                        <td>Tables, cards, grouped content</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Print Tips -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Print Best Practices</h3>
    </div>
    <div class="so-card-body">
        <div class="so-row so-g-4">
            <div class="so-col-md-6">
                <h6 class="so-mb-3"><span class="material-icons so-text-success so-me-2">check_circle</span>Do</h6>
                <ul class="so-list-group">
                    <li class="so-list-group-item">Use <code>.so-print-break-avoid</code> on tables and cards</li>
                    <li class="so-list-group-item">Hide navigation and interactive elements</li>
                    <li class="so-list-group-item">Ensure sufficient contrast for text</li>
                    <li class="so-list-group-item">Test printing during development</li>
                    <li class="so-list-group-item">Include print-only information if needed</li>
                </ul>
            </div>
            <div class="so-col-md-6">
                <h6 class="so-mb-3"><span class="material-icons so-text-danger so-me-2">cancel</span>Don't</h6>
                <ul class="so-list-group">
                    <li class="so-list-group-item">Rely on color alone for meaning</li>
                    <li class="so-list-group-item">Use very light text colors</li>
                    <li class="so-list-group-item">Leave interactive-only content visible</li>
                    <li class="so-list-group-item">Forget to hide background images</li>
                    <li class="so-list-group-item">Print unnecessary decorative elements</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Sample Print Document -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Sample Print Document</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">A sample document optimized for printing.</p>

                <div class="so-card so-card-bordered so-p-4">
                    <!-- Print-only header -->
                    <div class="so-print-only so-text-center so-mb-4">
                        <h2>Official Document</h2>
                        <p class="so-text-muted">Printed on: <script>document.write(new Date().toLocaleDateString())</script></p>
                    </div>

                    <h3>Invoice #INV-2024-001</h3>

                    <div class="so-row so-mt-4">
                        <div class="so-col-6">
                            <strong>From:</strong><br>
                            Acme Corporation<br>
                            123 Business Street<br>
                            City, State 12345
                        </div>
                        <div class="so-col-6 so-text-end">
                            <strong>To:</strong><br>
                            John Smith<br>
                            456 Customer Avenue<br>
                            Town, State 67890
                        </div>
                    </div>

                    <table class="so-table so-table-bordered so-mt-4 so-print-break-avoid">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Web Development Services</td>
                                <td>40 hours</td>
                                <td>$100/hr</td>
                                <td>$4,000</td>
                            </tr>
                            <tr>
                                <td>UI/UX Design</td>
                                <td>20 hours</td>
                                <td>$80/hr</td>
                                <td>$1,600</td>
                            </tr>
                            <tr>
                                <td>Project Management</td>
                                <td>10 hours</td>
                                <td>$60/hr</td>
                                <td>$600</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="so-text-end">Subtotal:</th>
                                <td>$6,200</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="so-text-end">Tax (10%):</th>
                                <td>$620</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="so-text-end">Total:</th>
                                <td><strong>$6,820</strong></td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Print-only footer -->
                    <div class="so-print-only so-mt-4 so-pt-4 so-border-top so-text-center so-text-muted">
                        <p>Thank you for your business!</p>
                        <p class="so-text-sm">This document was generated automatically. For questions, contact billing@example.com</p>
                    </div>

                    <!-- Screen-only actions -->
                    <div class="so-print-hide so-mt-4 so-d-flex so-gap-2">
                        <button class="so-btn so-btn-primary" onclick="window.print()">
                            <span class="material-icons">print</span>
                            Print Invoice
                        </button>
                        <button class="so-btn so-btn-outline">
                            <span class="material-icons">download</span>
                            Download PDF
                        </button>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-card so-p-4"&gt;
    &lt;!-- Header visible only when printing --&gt;
    &lt;div class="so-print-only so-text-center so-mb-4"&gt;
        &lt;h2&gt;Official Document&lt;/h2&gt;
        &lt;p&gt;Printed on: [date]&lt;/p&gt;
    &lt;/div&gt;

    &lt;!-- Document content --&gt;
    &lt;h3&gt;Invoice #INV-2024-001&lt;/h3&gt;

    &lt;table class="so-table so-table-bordered so-print-break-avoid"&gt;
        &lt;!-- Table content --&gt;
    &lt;/table&gt;

    &lt;!-- Footer visible only when printing --&gt;
    &lt;div class="so-print-only so-mt-4 so-text-center"&gt;
        &lt;p&gt;Thank you for your business!&lt;/p&gt;
    &lt;/div&gt;

    &lt;!-- Actions hidden when printing --&gt;
    &lt;div class="so-print-hide so-mt-4"&gt;
        &lt;button onclick="window.print()"&gt;Print&lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

    </div>
</main>

<script>
function copyCode(button) {
    const codeBlock = button.closest('.so-code-block');
    const code = codeBlock.querySelector('.so-code-content code').textContent;
    navigator.clipboard.writeText(code).then(() => {
        button.innerHTML = '<span class="material-icons">check</span>';
        setTimeout(() => {
            button.innerHTML = '<span class="material-icons">content_copy</span>';
        }, 2000);
    });
}
</script>

<?php require_once '../includes/footer.php'; ?>
