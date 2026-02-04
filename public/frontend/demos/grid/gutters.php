<?php
/**
 * SixOrbit UI Demo - Gutters
 */
$pageTitle = 'Gutters';
$pageDescription = 'Spacing between grid columns';

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
            <h1 class="so-page-title">Gutters</h1>
            <p class="so-page-subtitle">Spacing between grid columns</p>
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
    </style>

    <!-- Gutters Overview -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Gutters</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Gutters are the gaps between column content, created by horizontal padding. We set <code>padding-right</code> and <code>padding-left</code> on each column, and use negative margin to offset that at the start and end of each row.</p>

            <div class="so-table-responsive so-mb-4">
                <table class="so-table so-table-bordered">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Size</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>.so-g-0</code></td>
                            <td>0</td>
                            <td>No gutter</td>
                        </tr>
                        <tr>
                            <td><code>.so-g-1</code></td>
                            <td>0.25rem (4px)</td>
                            <td>Extra small gutter</td>
                        </tr>
                        <tr>
                            <td><code>.so-g-2</code></td>
                            <td>0.5rem (8px)</td>
                            <td>Small gutter</td>
                        </tr>
                        <tr>
                            <td><code>.so-g-3</code></td>
                            <td>1rem (16px)</td>
                            <td>Medium gutter</td>
                        </tr>
                        <tr>
                            <td><code>.so-g-4</code></td>
                            <td>1.5rem (24px)</td>
                            <td>Default gutter</td>
                        </tr>
                        <tr>
                            <td><code>.so-g-5</code></td>
                            <td>3rem (48px)</td>
                            <td>Large gutter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Horizontal Gutters -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Horizontal Gutters</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-gx-*</code> classes to control the horizontal gutter widths.</p>

            <h6 class="so-mb-2">No horizontal gutter (.so-gx-0)</h6>
            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-gx-0">
                    <div class="so-col-4"><div class="demo-col">Column</div></div>
                    <div class="so-col-4"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-4"><div class="demo-col">Column</div></div>
                </div>
            </div>

            <h6 class="so-mb-2">Small horizontal gutter (.so-gx-2)</h6>
            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-gx-2">
                    <div class="so-col-4"><div class="demo-col">Column</div></div>
                    <div class="so-col-4"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-4"><div class="demo-col">Column</div></div>
                </div>
            </div>

            <h6 class="so-mb-2">Large horizontal gutter (.so-gx-5)</h6>
            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-gx-5">
                    <div class="so-col-4"><div class="demo-col">Column</div></div>
                    <div class="so-col-4"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-4"><div class="demo-col">Column</div></div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-row so-gx-5"&gt;
  &lt;div class="so-col-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-4"&gt;Column&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Vertical Gutters -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Vertical Gutters</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-gy-*</code> classes to control the vertical gutter widths.</p>

            <h6 class="so-mb-2">Vertical gutter (.so-gy-4)</h6>
            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-gy-4">
                    <div class="so-col-6"><div class="demo-col">Column</div></div>
                    <div class="so-col-6"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-6"><div class="demo-col">Column</div></div>
                    <div class="so-col-6"><div class="demo-col-alt">Column</div></div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-row so-gy-4"&gt;
  &lt;div class="so-col-6"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6"&gt;Column&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Combined Gutters -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Combined Gutters</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-g-*</code> classes to set both horizontal and vertical gutters at the same time.</p>

            <h6 class="so-mb-2">Combined gutter (.so-g-3)</h6>
            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-g-3">
                    <div class="so-col-6"><div class="demo-col">Column</div></div>
                    <div class="so-col-6"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-6"><div class="demo-col">Column</div></div>
                    <div class="so-col-6"><div class="demo-col-alt">Column</div></div>
                </div>
            </div>

            <h6 class="so-mb-2">Large combined gutter (.so-g-5)</h6>
            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-g-5">
                    <div class="so-col-6"><div class="demo-col">Column</div></div>
                    <div class="so-col-6"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-6"><div class="demo-col">Column</div></div>
                    <div class="so-col-6"><div class="demo-col-alt">Column</div></div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Same gutter for both directions --&gt;
&lt;div class="so-row so-g-3"&gt;
  &lt;div class="so-col-6"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6"&gt;Column&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Responsive Gutters -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Responsive Gutters</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Gutter classes can also be responsive. Use the format <code>.so-g-{breakpoint}-{size}</code> to change gutters at different breakpoints.</p>

            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-g-2 so-g-md-4 so-g-lg-5">
                    <div class="so-col-6 so-col-md-4"><div class="demo-col">Column</div></div>
                    <div class="so-col-6 so-col-md-4"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-6 so-col-md-4"><div class="demo-col">Column</div></div>
                    <div class="so-col-6 so-col-md-4"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-6 so-col-md-4"><div class="demo-col">Column</div></div>
                    <div class="so-col-6 so-col-md-4"><div class="demo-col-alt">Column</div></div>
                </div>
            </div>
            <p class="so-text-muted so-mb-4">Gutter: g-2 on xs, g-4 on md, g-5 on lg</p>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-row so-g-2 so-g-md-4 so-g-lg-5"&gt;
  &lt;div class="so-col-6 so-col-md-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6 so-col-md-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6 so-col-md-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6 so-col-md-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6 so-col-md-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6 so-col-md-4"&gt;Column&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- No Gutters -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">No Gutters</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-g-0</code> or <code>.so-no-gutters</code> to remove gutters entirely.</p>

            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-g-0">
                    <div class="so-col-4"><div class="demo-col" style="border-radius: var(--so-radius-md) 0 0 var(--so-radius-md);">Column</div></div>
                    <div class="so-col-4"><div class="demo-col-alt" style="border-radius: 0;">Column</div></div>
                    <div class="so-col-4"><div class="demo-col" style="border-radius: 0 var(--so-radius-md) var(--so-radius-md) 0;">Column</div></div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- No gutters --&gt;
&lt;div class="so-row so-g-0"&gt;
  &lt;div class="so-col-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-4"&gt;Column&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Alternative syntax --&gt;
&lt;div class="so-row so-no-gutters"&gt;
  ...
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Responsive Gutter Scaling -->
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Responsive Gutter Scaling</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-row-responsive-gap</code> to automatically scale gutters based on viewport size. This is a Material Design enhancement that provides optimal spacing at each breakpoint.</p>

            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-row-responsive-gap">
                    <div class="so-col-6 so-col-md-4"><div class="demo-col">Column</div></div>
                    <div class="so-col-6 so-col-md-4"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-6 so-col-md-4"><div class="demo-col">Column</div></div>
                    <div class="so-col-6 so-col-md-4"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-6 so-col-md-4"><div class="demo-col">Column</div></div>
                    <div class="so-col-6 so-col-md-4"><div class="demo-col-alt">Column</div></div>
                </div>
            </div>

            <div class="so-alert so-alert-info so-mb-4">
                <span class="material-icons">info</span>
                <div>
                    <strong>Responsive gap values:</strong>
                    <ul class="so-mb-0 so-mt-2">
                        <li>XS: 0.75rem (12px)</li>
                        <li>SM: 1rem (16px)</li>
                        <li>MD: 1.25rem (20px)</li>
                        <li>LG: 1.5rem (24px)</li>
                        <li>XL: 2rem (32px)</li>
                    </ul>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Auto-scaling gutters based on viewport --&gt;
&lt;div class="so-row so-row-responsive-gap"&gt;
  &lt;div class="so-col-6 so-col-md-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6 so-col-md-4"&gt;Column&lt;/div&gt;
  &lt;div class="so-col-6 so-col-md-4"&gt;Column&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
