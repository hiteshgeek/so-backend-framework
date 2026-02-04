<?php
/**
 * SixOrbit UI Demo - Containers
 */
$pageTitle = 'Containers';
$pageDescription = 'Container classes for fixed and fluid layouts';

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
            <h1 class="so-page-title">Containers</h1>
            <p class="so-page-subtitle">Container classes for fixed and fluid layouts</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <!-- Containers Overview -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Containers</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Containers are the most basic layout element in SixOrbit UI and are required when using our grid system. Containers are used to contain, pad, and center the content within them.</p>

            <div class="so-table-responsive so-mb-4">
                <table class="so-table so-table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Extra small<br><small>&lt;576px</small></th>
                            <th>Small<br><small>&ge;576px</small></th>
                            <th>Medium<br><small>&ge;768px</small></th>
                            <th>Large<br><small>&ge;992px</small></th>
                            <th>X-Large<br><small>&ge;1200px</small></th>
                            <th>XX-Large<br><small>&ge;1400px</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>.so-container</code></td>
                            <td>100%</td>
                            <td>540px</td>
                            <td>720px</td>
                            <td>960px</td>
                            <td>1140px</td>
                            <td>1320px</td>
                        </tr>
                        <tr>
                            <td><code>.so-container-sm</code></td>
                            <td>100%</td>
                            <td>540px</td>
                            <td>720px</td>
                            <td>960px</td>
                            <td>1140px</td>
                            <td>1320px</td>
                        </tr>
                        <tr>
                            <td><code>.so-container-md</code></td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>720px</td>
                            <td>960px</td>
                            <td>1140px</td>
                            <td>1320px</td>
                        </tr>
                        <tr>
                            <td><code>.so-container-lg</code></td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>960px</td>
                            <td>1140px</td>
                            <td>1320px</td>
                        </tr>
                        <tr>
                            <td><code>.so-container-xl</code></td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>1140px</td>
                            <td>1320px</td>
                        </tr>
                        <tr>
                            <td><code>.so-container-xxl</code></td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>1320px</td>
                        </tr>
                        <tr>
                            <td><code>.so-container-fluid</code></td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>100%</td>
                            <td>100%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Default Container -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Default Container</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">The default <code>.so-container</code> class is a responsive, fixed-width container, meaning its max-width changes at each breakpoint.</p>

            <div class="so-p-3 so-mb-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-container" style="background: var(--so-accent-primary); color: white; padding: 1rem; border-radius: var(--so-radius-md);">
                    <code>.so-container</code> - Resize browser to see max-width changes
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
  &lt;!-- Content here --&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Fluid Container -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Fluid Container</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-container-fluid</code> for a full-width container that spans the entire width of the viewport.</p>

            <div class="so-p-3 so-mb-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-container-fluid" style="background: var(--so-accent-success); color: white; padding: 1rem; border-radius: var(--so-radius-md);">
                    <code>.so-container-fluid</code> - Always 100% width
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-container-fluid"&gt;
  &lt;!-- Content here --&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Responsive Containers -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Responsive Containers</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Responsive containers allow you to specify a class that is 100% wide until the specified breakpoint is reached, after which we apply max-widths for each of the higher breakpoints.</p>

            <div class="so-p-3 so-mb-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-container-sm so-mb-2" style="background: var(--so-accent-info); color: white; padding: 0.75rem; border-radius: var(--so-radius-md);">
                    <code>.so-container-sm</code> - 100% wide until sm breakpoint
                </div>
                <div class="so-container-md so-mb-2" style="background: var(--so-accent-warning); color: white; padding: 0.75rem; border-radius: var(--so-radius-md);">
                    <code>.so-container-md</code> - 100% wide until md breakpoint
                </div>
                <div class="so-container-lg so-mb-2" style="background: var(--so-accent-danger); color: white; padding: 0.75rem; border-radius: var(--so-radius-md);">
                    <code>.so-container-lg</code> - 100% wide until lg breakpoint
                </div>
                <div class="so-container-xl so-mb-2" style="background: var(--so-accent-primary-light); color: white; padding: 0.75rem; border-radius: var(--so-radius-md);">
                    <code>.so-container-xl</code> - 100% wide until xl breakpoint
                </div>
                <div class="so-container-xxl" style="background: var(--so-text-secondary); color: white; padding: 0.75rem; border-radius: var(--so-radius-md);">
                    <code>.so-container-xxl</code> - 100% wide until xxl breakpoint
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-container-sm"&gt;100% wide until small breakpoint&lt;/div&gt;
&lt;div class="so-container-md"&gt;100% wide until medium breakpoint&lt;/div&gt;
&lt;div class="so-container-lg"&gt;100% wide until large breakpoint&lt;/div&gt;
&lt;div class="so-container-xl"&gt;100% wide until extra large breakpoint&lt;/div&gt;
&lt;div class="so-container-xxl"&gt;100% wide until extra extra large breakpoint&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
