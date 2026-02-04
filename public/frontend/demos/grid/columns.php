<?php
/**
 * SixOrbit UI Demo - Columns
 */
$pageTitle = 'Columns';
$pageDescription = 'Column sizing, ordering, and alignment';

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
            <h1 class="so-page-title">Columns</h1>
            <p class="so-page-subtitle">Column sizing, ordering, and alignment</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <style>
        .demo-col {
            padding: 0.75rem;
            background: var(--so-accent-primary);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
        }
        .demo-col-alt {
            padding: 0.75rem;
            background: var(--so-accent-info);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
        }
        .demo-col-success {
            padding: 0.75rem;
            background: var(--so-accent-success);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
        }
    </style>

    <!-- Responsive Columns -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Responsive Columns</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use responsive column classes to create layouts that change based on viewport width. Classes are named using the format <code>.so-col-{breakpoint}-{columns}</code>.</p>

            <div class="so-container-fluid so-mb-4">
                <div class="so-row so-g-3">
                    <div class="so-col-12 so-col-md-6 so-col-lg-4">
                        <div class="demo-col">12 on xs, 6 on md, 4 on lg</div>
                    </div>
                    <div class="so-col-12 so-col-md-6 so-col-lg-4">
                        <div class="demo-col">12 on xs, 6 on md, 4 on lg</div>
                    </div>
                    <div class="so-col-12 so-col-md-12 so-col-lg-4">
                        <div class="demo-col">12 on xs, 12 on md, 4 on lg</div>
                    </div>
                </div>
            </div>

            <div class="so-alert so-alert-info so-mb-4">
                <span class="material-icons">info</span>
                <div>Resize your browser to see the columns change at different breakpoints.</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-row"&gt;
  &lt;div class="so-col-12 so-col-md-6 so-col-lg-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-12 so-col-md-6 so-col-lg-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-12 so-col-md-12 so-col-lg-4"&gt;Column&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Stacked to Horizontal -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Stacked to Horizontal</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Create a basic grid that starts stacked on mobile and becomes horizontal at the medium breakpoint.</p>

            <div class="so-container-fluid so-mb-4">
                <div class="so-row so-g-3">
                    <div class="so-col-md-8">
                        <div class="demo-col">so-col-md-8</div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="demo-col-alt">so-col-md-4</div>
                    </div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Stack the columns on mobile, side by side on md and up --&gt;
&lt;div class="so-row"&gt;
  &lt;div class="so-col-md-8"&gt;.so-col-md-8&lt;/div&gt;
  &lt;div class="so-col-md-4"&gt;.so-col-md-4&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Offsets -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Offsets</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Move columns to the right using <code>.so-offset-*</code> classes. These classes increase the left margin of a column by * columns.</p>

            <div class="so-container-fluid so-mb-4">
                <div class="so-row so-mb-2">
                    <div class="so-col-4"><div class="demo-col">so-col-4</div></div>
                    <div class="so-col-4 so-offset-4"><div class="demo-col-alt">so-col-4 so-offset-4</div></div>
                </div>
                <div class="so-row so-mb-2">
                    <div class="so-col-3 so-offset-3"><div class="demo-col">so-col-3 so-offset-3</div></div>
                    <div class="so-col-3 so-offset-3"><div class="demo-col-alt">so-col-3 so-offset-3</div></div>
                </div>
                <div class="so-row">
                    <div class="so-col-6 so-offset-3"><div class="demo-col-success">so-col-6 so-offset-3</div></div>
                </div>
            </div>

            <h6 class="so-mt-4 so-mb-3">Responsive Offsets</h6>
            <div class="so-container-fluid so-mb-4">
                <div class="so-row">
                    <div class="so-col-sm-5 so-col-md-6"><div class="demo-col">so-col-sm-5 so-col-md-6</div></div>
                    <div class="so-col-sm-5 so-offset-sm-2 so-col-md-6 so-offset-md-0"><div class="demo-col-alt">so-col-sm-5 so-offset-sm-2 so-col-md-6 so-offset-md-0</div></div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Basic offset --&gt;
&lt;div class="so-row"&gt;
  &lt;div class="so-col-4"&gt;.so-col-4&lt;/div&gt;
  &lt;div class="so-col-4 so-offset-4"&gt;.so-col-4 .so-offset-4&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Centered column --&gt;
&lt;div class="so-row"&gt;
  &lt;div class="so-col-6 so-offset-3"&gt;Centered column&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Responsive offsets --&gt;
&lt;div class="so-row"&gt;
  &lt;div class="so-col-sm-5 so-col-md-6"&gt;...&lt;/div&gt;
  &lt;div class="so-col-sm-5 so-offset-sm-2 so-col-md-6 so-offset-md-0"&gt;...&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Auto-width Columns -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Auto-width Columns</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-col-auto</code> to size columns based on the natural width of their content.</p>

            <div class="so-container-fluid so-mb-4">
                <div class="so-row so-g-3">
                    <div class="so-col"><div class="demo-col">so-col (equal)</div></div>
                    <div class="so-col-auto"><div class="demo-col-alt">so-col-auto (content width)</div></div>
                    <div class="so-col"><div class="demo-col">so-col (equal)</div></div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-row"&gt;
  &lt;div class="so-col"&gt;Equal width&lt;/div&gt;
  &lt;div class="so-col-auto"&gt;Content width&lt;/div&gt;
  &lt;div class="so-col"&gt;Equal width&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Responsive Row Columns -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Responsive Row Columns</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use responsive <code>.so-row-cols-*</code> classes to quickly set the number of columns that best render your content at different breakpoints.</p>

            <div class="so-container-fluid so-mb-4">
                <div class="so-row so-row-cols-1 so-row-cols-sm-2 so-row-cols-md-3 so-row-cols-lg-4 so-g-3">
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                </div>
            </div>

            <p class="so-text-muted so-mb-4">1 column on xs, 2 on sm, 3 on md, 4 on lg</p>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-row so-row-cols-1 so-row-cols-sm-2 so-row-cols-md-3 so-row-cols-lg-4 so-g-3"&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Column Classes Reference -->
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Column Classes Reference</h3>
        </div>
        <div class="so-card-body">
            <div class="so-table-responsive">
                <table class="so-table so-table-bordered">
                    <thead>
                        <tr>
                            <th>Class Pattern</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>.so-col</code></td>
                            <td>Equal-width column (flex: 1 0 0%)</td>
                        </tr>
                        <tr>
                            <td><code>.so-col-auto</code></td>
                            <td>Size based on content width</td>
                        </tr>
                        <tr>
                            <td><code>.so-col-{1-12}</code></td>
                            <td>Fixed width column (spans n/12 columns)</td>
                        </tr>
                        <tr>
                            <td><code>.so-col-{sm|md|lg|xl|xxl}-{1-12}</code></td>
                            <td>Responsive column width at breakpoint</td>
                        </tr>
                        <tr>
                            <td><code>.so-offset-{1-11}</code></td>
                            <td>Offset column by n columns</td>
                        </tr>
                        <tr>
                            <td><code>.so-offset-{sm|md|lg|xl|xxl}-{0-11}</code></td>
                            <td>Responsive offset at breakpoint</td>
                        </tr>
                        <tr>
                            <td><code>.so-row-cols-{1-6}</code></td>
                            <td>Set n equal-width columns per row</td>
                        </tr>
                        <tr>
                            <td><code>.so-row-cols-{sm|md|lg|xl|xxl}-{1-6}</code></td>
                            <td>Responsive row columns at breakpoint</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
