<?php
/**
 * SixOrbit UI Demo - CSS Grid
 */
$pageTitle = 'CSS Grid';
$pageDescription = 'Native CSS Grid layout utilities';

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
            <h1 class="so-page-title">CSS Grid</h1>
            <p class="so-page-subtitle">Native CSS Grid layout utilities</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <style>
        .demo-grid-item {
            padding: 1rem;
            background: var(--so-accent-primary);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
            font-size: 0.875rem;
        }
        .demo-grid-item-alt {
            padding: 1rem;
            background: var(--so-accent-info);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
            font-size: 0.875rem;
        }
        .demo-grid-item-success {
            padding: 1rem;
            background: var(--so-accent-success);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
            font-size: 0.875rem;
        }
        .demo-grid-item-warning {
            padding: 1rem;
            background: var(--so-accent-warning);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
            font-size: 0.875rem;
        }
    </style>

    <!-- CSS Grid Overview -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">CSS Grid System</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">In addition to the flexbox-based grid, SixOrbit UI provides a modern CSS Grid alternative. CSS Grid offers more powerful layout capabilities with simpler markup.</p>

            <div class="so-alert so-alert-info so-mb-4">
                <span class="material-icons">lightbulb</span>
                <div>
                    <strong>When to use CSS Grid:</strong>
                    <ul class="so-mb-0 so-mt-2">
                        <li>Two-dimensional layouts (rows AND columns)</li>
                        <li>Complex dashboard layouts</li>
                        <li>When you need items to span multiple rows/columns</li>
                        <li>Auto-fit/auto-fill responsive layouts without breakpoints</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Basic CSS Grid -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Basic CSS Grid</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-grid</code> for a 12-column CSS Grid. Items automatically flow into the grid.</p>

            <div class="so-grid so-grid-cols-3 so-grid-gap-3 so-mb-4">
                <div class="demo-grid-item">Item 1</div>
                <div class="demo-grid-item-alt">Item 2</div>
                <div class="demo-grid-item">Item 3</div>
                <div class="demo-grid-item-alt">Item 4</div>
                <div class="demo-grid-item">Item 5</div>
                <div class="demo-grid-item-alt">Item 6</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-grid so-grid-cols-3 so-grid-gap-3"&gt;
  &lt;div&gt;Item 1&lt;/div&gt;
  &lt;div&gt;Item 2&lt;/div&gt;
  &lt;div&gt;Item 3&lt;/div&gt;
  &lt;div&gt;Item 4&lt;/div&gt;
  &lt;div&gt;Item 5&lt;/div&gt;
  &lt;div&gt;Item 6&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Grid Template Columns -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Grid Template Columns</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-grid-cols-{1-12}</code> to specify the number of columns.</p>

            <h6 class="so-mb-2">2 Columns (.so-grid-cols-2)</h6>
            <div class="so-grid so-grid-cols-2 so-grid-gap-3 so-mb-4">
                <div class="demo-grid-item">1</div>
                <div class="demo-grid-item-alt">2</div>
                <div class="demo-grid-item">3</div>
                <div class="demo-grid-item-alt">4</div>
            </div>

            <h6 class="so-mb-2">4 Columns (.so-grid-cols-4)</h6>
            <div class="so-grid so-grid-cols-4 so-grid-gap-3 so-mb-4">
                <div class="demo-grid-item">1</div>
                <div class="demo-grid-item-alt">2</div>
                <div class="demo-grid-item">3</div>
                <div class="demo-grid-item-alt">4</div>
            </div>

            <h6 class="so-mb-2">6 Columns (.so-grid-cols-6)</h6>
            <div class="so-grid so-grid-cols-6 so-grid-gap-3 so-mb-4">
                <div class="demo-grid-item">1</div>
                <div class="demo-grid-item-alt">2</div>
                <div class="demo-grid-item">3</div>
                <div class="demo-grid-item-alt">4</div>
                <div class="demo-grid-item">5</div>
                <div class="demo-grid-item-alt">6</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-grid so-grid-cols-2"&gt;...&lt;/div&gt;
&lt;div class="so-grid so-grid-cols-4"&gt;...&lt;/div&gt;
&lt;div class="so-grid so-grid-cols-6"&gt;...&lt;/div&gt;

&lt;!-- Responsive grid columns --&gt;
&lt;div class="so-grid so-grid-cols-1 so-grid-cols-md-2 so-grid-cols-lg-4"&gt;
  ...
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Column Spanning -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Column Spanning</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-col-span-{1-12}</code> to make items span multiple columns.</p>

            <div class="so-grid so-grid-cols-4 so-grid-gap-3 so-mb-4">
                <div class="so-col-span-2 demo-grid-item">Span 2</div>
                <div class="demo-grid-item-alt">1</div>
                <div class="demo-grid-item">1</div>
                <div class="demo-grid-item-alt">1</div>
                <div class="so-col-span-3 demo-grid-item-success">Span 3</div>
            </div>

            <h6 class="so-mt-4 so-mb-2">Full Width (.so-col-span-full)</h6>
            <div class="so-grid so-grid-cols-4 so-grid-gap-3 so-mb-4">
                <div class="so-col-span-full demo-grid-item-warning">Full Width (span all columns)</div>
                <div class="demo-grid-item">1</div>
                <div class="demo-grid-item-alt">2</div>
                <div class="demo-grid-item">3</div>
                <div class="demo-grid-item-alt">4</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-grid so-grid-cols-4 so-grid-gap-3"&gt;
  &lt;div class="so-col-span-2"&gt;Span 2 columns&lt;/div&gt;
  &lt;div&gt;1 column&lt;/div&gt;
  &lt;div&gt;1 column&lt;/div&gt;
  &lt;div class="so-col-span-full"&gt;Full width&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Responsive spanning --&gt;
&lt;div class="so-col-span-full so-col-span-md-6 so-col-span-lg-4"&gt;
  Full on mobile, half on md, third on lg
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Row Spanning -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Row Spanning</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-row-span-{1-6}</code> to make items span multiple rows.</p>

            <div class="so-grid so-grid-cols-3 so-grid-gap-3 so-mb-4">
                <div class="so-row-span-2 demo-grid-item" style="display: flex; align-items: center; justify-content: center;">Span 2 Rows</div>
                <div class="demo-grid-item-alt">1</div>
                <div class="demo-grid-item">1</div>
                <div class="demo-grid-item-alt">1</div>
                <div class="demo-grid-item">1</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-grid so-grid-cols-3 so-grid-gap-3"&gt;
  &lt;div class="so-row-span-2"&gt;Spans 2 rows&lt;/div&gt;
  &lt;div&gt;Item&lt;/div&gt;
  &lt;div&gt;Item&lt;/div&gt;
  &lt;div&gt;Item&lt;/div&gt;
  &lt;div&gt;Item&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Auto-fit and Auto-fill -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Auto-fit and Auto-fill</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Create responsive grids without breakpoints using <code>.so-grid-auto-fit</code> or <code>.so-grid-auto-fill</code>. Set the minimum column width with the <code>--so-grid-min-col</code> CSS variable.</p>

            <h6 class="so-mb-2">Auto-fit (columns shrink to fit)</h6>
            <div class="so-grid-auto-fit so-grid-gap-3 so-mb-4" style="--so-grid-min-col: 200px;">
                <div class="demo-grid-item">Auto Item 1</div>
                <div class="demo-grid-item-alt">Auto Item 2</div>
                <div class="demo-grid-item">Auto Item 3</div>
                <div class="demo-grid-item-alt">Auto Item 4</div>
            </div>

            <h6 class="so-mb-2">Auto-fill (maintains column size)</h6>
            <div class="so-grid-auto-fill so-grid-gap-3 so-mb-4" style="--so-grid-min-col: 200px;">
                <div class="demo-grid-item-success">Auto Item 1</div>
                <div class="demo-grid-item-warning">Auto Item 2</div>
            </div>

            <div class="so-alert so-alert-info so-mb-4">
                <span class="material-icons">info</span>
                <div>Resize the browser to see how auto-fit and auto-fill differ. Auto-fit collapses empty tracks, while auto-fill maintains them.</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Auto-fit: columns shrink to fit content --&gt;
&lt;div class="so-grid-auto-fit" style="--so-grid-min-col: 250px;"&gt;
  &lt;div&gt;Item 1&lt;/div&gt;
  &lt;div&gt;Item 2&lt;/div&gt;
  &lt;div&gt;Item 3&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Auto-fill: maintains column size, may have empty space --&gt;
&lt;div class="so-grid-auto-fill" style="--so-grid-min-col: 300px;"&gt;
  &lt;div&gt;Item 1&lt;/div&gt;
  &lt;div&gt;Item 2&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Grid Presets -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Grid Presets</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">SixOrbit UI includes common grid layout presets for quick implementation.</p>

            <h6 class="so-mb-2">Dashboard Grid (.so-grid-dashboard)</h6>
            <div class="so-grid-dashboard so-mb-4">
                <div class="demo-grid-item">Card 1</div>
                <div class="demo-grid-item-alt">Card 2</div>
                <div class="demo-grid-item">Card 3</div>
                <div class="demo-grid-item-alt">Card 4</div>
            </div>

            <h6 class="so-mb-2">Sidebar Grid (.so-grid-sidebar)</h6>
            <div class="so-grid-sidebar so-mb-4">
                <div class="demo-grid-item-success">Sidebar (250px)</div>
                <div class="demo-grid-item">Main Content (1fr)</div>
            </div>

            <h6 class="so-mb-2">Sidebar Right Grid (.so-grid-sidebar-right)</h6>
            <div class="so-grid-sidebar-right so-mb-4">
                <div class="demo-grid-item">Main Content (1fr)</div>
                <div class="demo-grid-item-warning">Sidebar (250px)</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Dashboard layout --&gt;
&lt;div class="so-grid-dashboard"&gt;
  &lt;div class="so-card"&gt;Card 1&lt;/div&gt;
  &lt;div class="so-card"&gt;Card 2&lt;/div&gt;
  &lt;div class="so-card"&gt;Card 3&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Sidebar layout --&gt;
&lt;div class="so-grid-sidebar"&gt;
  &lt;aside&gt;Sidebar&lt;/aside&gt;
  &lt;main&gt;Main content&lt;/main&gt;
&lt;/div&gt;

&lt;!-- Sidebar right layout --&gt;
&lt;div class="so-grid-sidebar-right"&gt;
  &lt;main&gt;Main content&lt;/main&gt;
  &lt;aside&gt;Sidebar&lt;/aside&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- CSS Grid Classes Reference -->
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">CSS Grid Classes Reference</h3>
        </div>
        <div class="so-card-body">
            <div class="so-table-responsive">
                <table class="so-table so-table-bordered">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2"><strong>Grid Container</strong></td>
                        </tr>
                        <tr>
                            <td><code>.so-grid</code></td>
                            <td>12-column CSS Grid container</td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-auto-fit</code></td>
                            <td>Auto-fit responsive grid</td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-auto-fill</code></td>
                            <td>Auto-fill responsive grid</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Grid Template</strong></td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-cols-{1-12}</code></td>
                            <td>Set number of columns</td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-rows-{1-6}</code></td>
                            <td>Set number of rows</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Spanning</strong></td>
                        </tr>
                        <tr>
                            <td><code>.so-col-span-{1-12}</code></td>
                            <td>Span columns</td>
                        </tr>
                        <tr>
                            <td><code>.so-col-span-full</code></td>
                            <td>Span all columns</td>
                        </tr>
                        <tr>
                            <td><code>.so-row-span-{1-6}</code></td>
                            <td>Span rows</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Gap</strong></td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-gap-{0-6}</code></td>
                            <td>Grid gap (both directions)</td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-gap-x-{0-6}</code></td>
                            <td>Column gap only</td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-gap-y-{0-6}</code></td>
                            <td>Row gap only</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Flow</strong></td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-flow-row</code></td>
                            <td>Row flow (default)</td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-flow-col</code></td>
                            <td>Column flow</td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-flow-dense</code></td>
                            <td>Dense packing algorithm</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Presets</strong></td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-dashboard</code></td>
                            <td>Auto-fit card grid (min 300px)</td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-sidebar</code></td>
                            <td>Sidebar left layout</td>
                        </tr>
                        <tr>
                            <td><code>.so-grid-sidebar-right</code></td>
                            <td>Sidebar right layout</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
