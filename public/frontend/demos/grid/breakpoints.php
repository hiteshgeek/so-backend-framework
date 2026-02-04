<?php
/**
 * SixOrbit UI Demo - Breakpoints
 */
$pageTitle = 'Breakpoints';
$pageDescription = 'Responsive breakpoints for different screen sizes';

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
            <h1 class="so-page-title">Breakpoints</h1>
            <p class="so-page-subtitle">Responsive breakpoints for different screen sizes</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <!-- Breakpoints Overview -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Available Breakpoints</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">SixOrbit UI includes six default breakpoints, sometimes referred to as <em>grid tiers</em>, for building responsively. These breakpoints can be customized if you're using our source Sass files.</p>

            <div class="so-table-responsive">
                <table class="so-table so-table-bordered">
                    <thead>
                        <tr>
                            <th>Breakpoint</th>
                            <th>Class infix</th>
                            <th>Dimensions</th>
                            <th>Container max-width</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Extra small</td>
                            <td><code>None</code></td>
                            <td>&lt;576px</td>
                            <td>100%</td>
                        </tr>
                        <tr>
                            <td>Small</td>
                            <td><code>sm</code></td>
                            <td>&ge;576px</td>
                            <td>540px</td>
                        </tr>
                        <tr>
                            <td>Medium</td>
                            <td><code>md</code></td>
                            <td>&ge;768px</td>
                            <td>720px</td>
                        </tr>
                        <tr>
                            <td>Large</td>
                            <td><code>lg</code></td>
                            <td>&ge;992px</td>
                            <td>960px</td>
                        </tr>
                        <tr>
                            <td>Extra large</td>
                            <td><code>xl</code></td>
                            <td>&ge;1200px</td>
                            <td>1140px</td>
                        </tr>
                        <tr>
                            <td>Extra extra large</td>
                            <td><code>xxl</code></td>
                            <td>&ge;1400px</td>
                            <td>1320px</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="so-alert so-alert-info so-mt-4">
                <span class="material-icons">info</span>
                <div>
                    <strong>Mobile-first approach:</strong> The grid system uses a mobile-first approach. Classes without a breakpoint infix (like <code>.so-col-6</code>) apply to all screen sizes, while classes with an infix (like <code>.so-col-md-6</code>) only apply at that breakpoint and up.
                </div>
            </div>
        </div>
    </div>

    <!-- Media Query Reference -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Media Query Reference</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Since we write our source CSS in Sass, all our media queries are available via Sass mixins:</p>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> SCSS</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-scss">// No media query necessary for xs breakpoint (base styles)
// Applies to all screen sizes

// Small devices (landscape phones, 576px and up)
@media (min-width: 576px) { ... }

// Medium devices (tablets, 768px and up)
@media (min-width: 768px) { ... }

// Large devices (desktops, 992px and up)
@media (min-width: 992px) { ... }

// X-Large devices (large desktops, 1200px and up)
@media (min-width: 1200px) { ... }

// XX-Large devices (larger desktops, 1400px and up)
@media (min-width: 1400px) { ... }</code></pre>
            </div>

            <h6 class="so-mt-4 so-mb-3">SCSS Variables</h6>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> SCSS</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-scss">$grid-breakpoints: (
  xs: 0,
  sm: 576px,
  md: 768px,
  lg: 992px,
  xl: 1200px,
  xxl: 1400px
);

$container-max-widths: (
  sm: 540px,
  md: 720px,
  lg: 960px,
  xl: 1140px,
  xxl: 1320px
);</code></pre>
            </div>
        </div>
    </div>

    <!-- Current Breakpoint Indicator -->
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Current Breakpoint</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Resize your browser to see which breakpoint is currently active:</p>

            <div class="so-d-flex so-gap-2 so-flex-wrap">
                <span class="so-badge so-badge-lg so-badge-primary so-d-inline-block so-d-sm-none">XS (&lt;576px)</span>
                <span class="so-badge so-badge-lg so-badge-secondary so-d-none so-d-sm-inline-block so-d-md-none">SM (&ge;576px)</span>
                <span class="so-badge so-badge-lg so-badge-success so-d-none so-d-md-inline-block so-d-lg-none">MD (&ge;768px)</span>
                <span class="so-badge so-badge-lg so-badge-info so-d-none so-d-lg-inline-block so-d-xl-none">LG (&ge;992px)</span>
                <span class="so-badge so-badge-lg so-badge-warning so-d-none so-d-xl-inline-block so-d-xxl-none">XL (&ge;1200px)</span>
                <span class="so-badge so-badge-lg so-badge-danger so-d-none so-d-xxl-inline-block">XXL (&ge;1400px)</span>
            </div>
        </div>
    </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
