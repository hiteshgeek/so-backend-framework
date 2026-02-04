<?php
/**
 * SixOrbit UI Demo - Grid
 */
$pageTitle = 'Grid';
$pageDescription = '12-column responsive grid system';

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
            <h1 class="so-page-title">Grid</h1>
            <p class="so-page-subtitle">12-column responsive grid system</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <!-- Grid Overview -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">How It Works</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">SixOrbit UI's grid system uses a series of containers, rows, and columns to layout and align content. It's built with flexbox and is fully responsive.</p>

            <div class="so-alert so-alert-info so-mb-4">
                <span class="material-icons">lightbulb</span>
                <div>
                    <strong>Key Concepts:</strong>
                    <ul class="so-mb-0 so-mt-2">
                        <li>Use <code>.so-container</code> or <code>.so-container-fluid</code> for a responsive fixed-width container or full-width container</li>
                        <li>Rows are wrappers for columns. Use <code>.so-row</code></li>
                        <li>Content should be placed within columns, and only columns may be immediate children of rows</li>
                        <li>Grid columns without a specified width will automatically layout as equal width columns</li>
                        <li>Column classes indicate the number of columns out of 12 you'd like to use</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Basic Example -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Basic Example</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Here's a basic grid layout with three equal-width columns across all devices and viewports.</p>

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

            <div class="so-container-fluid so-mb-4">
                <div class="so-row">
                    <div class="so-col">
                        <div class="demo-col">Column</div>
                    </div>
                    <div class="so-col">
                        <div class="demo-col">Column</div>
                    </div>
                    <div class="so-col">
                        <div class="demo-col">Column</div>
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
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-container"&gt;
  &lt;div class="so-row"&gt;
    &lt;div class="so-col"&gt;Column&lt;/div&gt;
    &lt;div class="so-col"&gt;Column&lt;/div&gt;
    &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- 12-Column Grid -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">12-Column Grid</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">The grid is divided into 12 columns. Use column classes to specify how many columns your content should span.</p>

            <div class="so-container-fluid so-mb-4">
                <div class="so-row so-gy-2">
                    <div class="so-col-12"><div class="demo-col">so-col-12</div></div>
                </div>
                <div class="so-row so-gy-2 so-mt-2">
                    <div class="so-col-6"><div class="demo-col">so-col-6</div></div>
                    <div class="so-col-6"><div class="demo-col-alt">so-col-6</div></div>
                </div>
                <div class="so-row so-gy-2 so-mt-2">
                    <div class="so-col-4"><div class="demo-col">so-col-4</div></div>
                    <div class="so-col-4"><div class="demo-col-alt">so-col-4</div></div>
                    <div class="so-col-4"><div class="demo-col">so-col-4</div></div>
                </div>
                <div class="so-row so-gy-2 so-mt-2">
                    <div class="so-col-3"><div class="demo-col">so-col-3</div></div>
                    <div class="so-col-3"><div class="demo-col-alt">so-col-3</div></div>
                    <div class="so-col-3"><div class="demo-col">so-col-3</div></div>
                    <div class="so-col-3"><div class="demo-col-alt">so-col-3</div></div>
                </div>
                <div class="so-row so-gy-2 so-mt-2">
                    <div class="so-col-2"><div class="demo-col">2</div></div>
                    <div class="so-col-2"><div class="demo-col-alt">2</div></div>
                    <div class="so-col-2"><div class="demo-col">2</div></div>
                    <div class="so-col-2"><div class="demo-col-alt">2</div></div>
                    <div class="so-col-2"><div class="demo-col">2</div></div>
                    <div class="so-col-2"><div class="demo-col-alt">2</div></div>
                </div>
                <div class="so-row so-gy-2 so-mt-2">
                    <div class="so-col-1"><div class="demo-col">1</div></div>
                    <div class="so-col-1"><div class="demo-col-alt">1</div></div>
                    <div class="so-col-1"><div class="demo-col">1</div></div>
                    <div class="so-col-1"><div class="demo-col-alt">1</div></div>
                    <div class="so-col-1"><div class="demo-col">1</div></div>
                    <div class="so-col-1"><div class="demo-col-alt">1</div></div>
                    <div class="so-col-1"><div class="demo-col">1</div></div>
                    <div class="so-col-1"><div class="demo-col-alt">1</div></div>
                    <div class="so-col-1"><div class="demo-col">1</div></div>
                    <div class="so-col-1"><div class="demo-col-alt">1</div></div>
                    <div class="so-col-1"><div class="demo-col">1</div></div>
                    <div class="so-col-1"><div class="demo-col-alt">1</div></div>
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
  &lt;div class="so-col-12"&gt;12 columns&lt;/div&gt;
&lt;/div&gt;
&lt;div class="so-row"&gt;
  &lt;div class="so-col-6"&gt;6 columns&lt;/div&gt;
  &lt;div class="so-col-6"&gt;6 columns&lt;/div&gt;
&lt;/div&gt;
&lt;div class="so-row"&gt;
  &lt;div class="so-col-4"&gt;4 columns&lt;/div&gt;
  &lt;div class="so-col-4"&gt;4 columns&lt;/div&gt;
  &lt;div class="so-col-4"&gt;4 columns&lt;/div&gt;
&lt;/div&gt;
&lt;div class="so-row"&gt;
  &lt;div class="so-col-3"&gt;3 columns&lt;/div&gt;
  &lt;div class="so-col-3"&gt;3 columns&lt;/div&gt;
  &lt;div class="so-col-3"&gt;3 columns&lt;/div&gt;
  &lt;div class="so-col-3"&gt;3 columns&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Mixed Column Widths -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Mixed Column Widths</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Columns can be combined in different widths. Just make sure they add up to 12 (or less).</p>

            <div class="so-container-fluid so-mb-4">
                <div class="so-row so-mb-2">
                    <div class="so-col-8"><div class="demo-col">so-col-8</div></div>
                    <div class="so-col-4"><div class="demo-col-alt">so-col-4</div></div>
                </div>
                <div class="so-row so-mb-2">
                    <div class="so-col-3"><div class="demo-col">so-col-3</div></div>
                    <div class="so-col-6"><div class="demo-col-alt">so-col-6</div></div>
                    <div class="so-col-3"><div class="demo-col">so-col-3</div></div>
                </div>
                <div class="so-row so-mb-2">
                    <div class="so-col-2"><div class="demo-col">2</div></div>
                    <div class="so-col-7"><div class="demo-col-alt">so-col-7</div></div>
                    <div class="so-col-3"><div class="demo-col">3</div></div>
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
  &lt;div class="so-col-8"&gt;8 columns&lt;/div&gt;
  &lt;div class="so-col-4"&gt;4 columns&lt;/div&gt;
&lt;/div&gt;
&lt;div class="so-row"&gt;
  &lt;div class="so-col-3"&gt;3 columns&lt;/div&gt;
  &lt;div class="so-col-6"&gt;6 columns&lt;/div&gt;
  &lt;div class="so-col-3"&gt;3 columns&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Row Columns -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Row Columns</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-row-cols-*</code> classes to quickly set the number of columns that best render your content and layout.</p>

            <div class="so-container-fluid so-mb-4">
                <div class="so-row so-row-cols-2 so-g-3 so-mb-3">
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                </div>
                <p class="so-text-muted so-mb-3"><code>.so-row-cols-2</code> - 2 columns per row</p>

                <div class="so-row so-row-cols-3 so-g-3 so-mb-3">
                    <div class="so-col"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col"><div class="demo-col-alt">Column</div></div>
                </div>
                <p class="so-text-muted so-mb-3"><code>.so-row-cols-3</code> - 3 columns per row</p>

                <div class="so-row so-row-cols-4 so-g-3">
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                </div>
                <p class="so-text-muted"><code>.so-row-cols-4</code> - 4 columns per row</p>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- 2 columns per row --&gt;
&lt;div class="so-row so-row-cols-2"&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
&lt;/div&gt;

&lt;!-- 4 columns per row --&gt;
&lt;div class="so-row so-row-cols-4"&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
  &lt;div class="so-col"&gt;Column&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Nesting -->
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Nesting</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">To nest your content with the default grid, add a new <code>.so-row</code> and set of <code>.so-col-*</code> columns within an existing column.</p>

            <div class="so-container-fluid so-mb-4">
                <div class="so-row">
                    <div class="so-col-8">
                        <div class="demo-col so-mb-2">Level 1: so-col-8</div>
                        <div class="so-row">
                            <div class="so-col-6"><div class="demo-col-alt">Level 2: so-col-6</div></div>
                            <div class="so-col-6"><div class="demo-col-alt">Level 2: so-col-6</div></div>
                        </div>
                    </div>
                    <div class="so-col-4">
                        <div class="demo-col">Level 1: so-col-4</div>
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
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-row"&gt;
  &lt;div class="so-col-8"&gt;
    Level 1: so-col-8
    &lt;div class="so-row"&gt;
      &lt;div class="so-col-6"&gt;Level 2: so-col-6&lt;/div&gt;
      &lt;div class="so-col-6"&gt;Level 2: so-col-6&lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class="so-col-4"&gt;Level 1: so-col-4&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
