<?php
/**
 * SixOrbit UI Demo - Utilities
 */
$pageTitle = 'Utilities';
$pageDescription = 'Utility classes and helpers';

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
            <h1 class="so-page-title">Utilities</h1>
            <p class="so-page-subtitle">Utility classes and helpers</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Introduction -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Utility Classes</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted">Utility classes provide quick, single-purpose styling options. Most utilities support responsive breakpoints: <code>sm</code>, <code>md</code>, <code>lg</code>, <code>xl</code>, <code>xxl</code>.</p>
        </div>
    </div>

    <!-- ============================================
         SPACING UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Spacing</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Margin and padding utilities using the format: <code>.so-{m|p}{side?}-{size}</code></p>

            <!-- Margin Demo -->
            <h5 class="so-fw-semibold so-mb-3">Margin</h5>
            <div class="so-bg-body-secondary so-p-3 so-rounded so-mb-4">
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-3">
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded so-m-0">m-0</div>
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded so-m-1">m-1</div>
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded so-m-2">m-2</div>
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded so-m-3">m-3</div>
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded so-m-4">m-4</div>
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded so-m-5">m-5</div>
                </div>
                <p class="so-text-muted so-fs-sm so-mb-0">Sides: <code>t</code> (top), <code>b</code> (bottom), <code>s</code> (start), <code>e</code> (end), <code>x</code> (horizontal), <code>y</code> (vertical)</p>
            </div>

            <div class="so-code-block so-mb-4">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-m-3"&gt;Margin all sides&lt;/div&gt;
&lt;div class="so-mt-2"&gt;Margin top&lt;/div&gt;
&lt;div class="so-mx-auto"&gt;Margin auto horizontal (centering)&lt;/div&gt;
&lt;div class="so-ms-4"&gt;Margin start (left in LTR)&lt;/div&gt;
&lt;div class="so-me-4"&gt;Margin end (right in LTR)&lt;/div&gt;</code></pre>
            </div>

            <!-- Padding Demo -->
            <h5 class="so-fw-semibold so-mb-3">Padding</h5>
            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <div class="so-bg-success so-text-white so-rounded so-p-0">p-0</div>
                <div class="so-bg-success so-text-white so-rounded so-p-1">p-1</div>
                <div class="so-bg-success so-text-white so-rounded so-p-2">p-2</div>
                <div class="so-bg-success so-text-white so-rounded so-p-3">p-3</div>
                <div class="so-bg-success so-text-white so-rounded so-p-4">p-4</div>
                <div class="so-bg-success so-text-white so-rounded so-p-5">p-5</div>
            </div>

            <div class="so-code-block so-mb-4">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-p-3"&gt;Padding all sides&lt;/div&gt;
&lt;div class="so-py-4"&gt;Padding vertical&lt;/div&gt;
&lt;div class="so-px-5"&gt;Padding horizontal&lt;/div&gt;
&lt;div class="so-pt-2 so-pb-4"&gt;Different top/bottom&lt;/div&gt;</code></pre>
            </div>

            <!-- Gap Demo -->
            <h5 class="so-fw-semibold so-mb-3">Gap (for Flex/Grid)</h5>
            <div class="so-bg-body-secondary so-p-3 so-rounded so-mb-3">
                <p class="so-text-muted so-fs-sm so-mb-2">gap-1</p>
                <div class="so-d-flex so-gap-1 so-mb-3">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">1</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">2</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">3</div>
                </div>
                <p class="so-text-muted so-fs-sm so-mb-2">gap-3</p>
                <div class="so-d-flex so-gap-3 so-mb-3">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">1</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">2</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">3</div>
                </div>
                <p class="so-text-muted so-fs-sm so-mb-2">gap-5</p>
                <div class="so-d-flex so-gap-5">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">1</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">2</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">3</div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-d-flex so-gap-3"&gt;...&lt;/div&gt;
&lt;div class="so-d-flex so-row-gap-2 so-column-gap-4"&gt;...&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         POSITION UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Position</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Position, z-index, and inset utilities.</p>

            <!-- Position Types -->
            <h5 class="so-fw-semibold so-mb-3">Position Types</h5>
            <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                <span class="so-badge so-badge-secondary">.so-static</span>
                <span class="so-badge so-badge-secondary">.so-relative</span>
                <span class="so-badge so-badge-secondary">.so-absolute</span>
                <span class="so-badge so-badge-secondary">.so-fixed</span>
                <span class="so-badge so-badge-secondary">.so-sticky</span>
            </div>

            <!-- Inset Demo -->
            <h5 class="so-fw-semibold so-mb-3">Inset / Positioning</h5>
            <div class="so-position-relative so-bg-body-secondary so-rounded so-mb-4" style="height: 150px;">
                <div class="so-position-absolute so-top-0 so-start-0 so-bg-primary so-text-white so-p-2 so-rounded-sm so-fs-sm">top-0 start-0</div>
                <div class="so-position-absolute so-top-0 so-end-0 so-bg-success so-text-white so-p-2 so-rounded-sm so-fs-sm">top-0 end-0</div>
                <div class="so-position-absolute so-bottom-0 so-start-0 so-bg-warning so-text-dark so-p-2 so-rounded-sm so-fs-sm">bottom-0 start-0</div>
                <div class="so-position-absolute so-bottom-0 so-end-0 so-bg-danger so-text-white so-p-2 so-rounded-sm so-fs-sm">bottom-0 end-0</div>
                <div class="so-position-absolute so-top-50 so-start-50 so-translate-middle so-bg-info so-text-white so-p-2 so-rounded-sm so-fs-sm">centered</div>
            </div>

            <div class="so-code-block so-mb-4">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-position-relative"&gt;
  &lt;div class="so-position-absolute so-top-0 so-start-0"&gt;Top Left&lt;/div&gt;
  &lt;div class="so-position-absolute so-top-50 so-start-50 so-translate-middle"&gt;Centered&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>

            <!-- Z-Index -->
            <h5 class="so-fw-semibold so-mb-3">Z-Index</h5>
            <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-3">
                <span class="so-badge so-badge-light so-text-dark">.so-z-0</span>
                <span class="so-badge so-badge-light so-text-dark">.so-z-10</span>
                <span class="so-badge so-badge-light so-text-dark">.so-z-20</span>
                <span class="so-badge so-badge-light so-text-dark">.so-z-30</span>
                <span class="so-badge so-badge-light so-text-dark">.so-z-40</span>
                <span class="so-badge so-badge-light so-text-dark">.so-z-50</span>
            </div>
            <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                <span class="so-badge so-badge-secondary">.so-z-dropdown</span>
                <span class="so-badge so-badge-secondary">.so-z-sticky</span>
                <span class="so-badge so-badge-secondary">.so-z-fixed</span>
                <span class="so-badge so-badge-secondary">.so-z-modal-backdrop</span>
                <span class="so-badge so-badge-secondary">.so-z-modal</span>
                <span class="so-badge so-badge-secondary">.so-z-tooltip</span>
            </div>

            <!-- Float -->
            <h5 class="so-fw-semibold so-mb-3">Float</h5>
            <div class="so-bg-body-secondary so-p-3 so-rounded so-clearfix so-mb-3">
                <div class="so-float-start so-bg-primary so-text-white so-p-2 so-rounded so-me-3">.so-float-start</div>
                <div class="so-float-end so-bg-success so-text-white so-p-2 so-rounded so-ms-3">.so-float-end</div>
                <p class="so-mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-float-start"&gt;Float left&lt;/div&gt;
&lt;div class="so-float-end"&gt;Float right&lt;/div&gt;
&lt;div class="so-clearfix"&gt;Container with clearfix&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         DISPLAY UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Display</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Control element display and visibility.</p>

            <!-- Display Types -->
            <h5 class="so-fw-semibold so-mb-3">Display Types</h5>
            <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                <span class="so-badge so-badge-primary">.so-d-none</span>
                <span class="so-badge so-badge-primary">.so-d-inline</span>
                <span class="so-badge so-badge-primary">.so-d-inline-block</span>
                <span class="so-badge so-badge-primary">.so-d-block</span>
                <span class="so-badge so-badge-primary">.so-d-flex</span>
                <span class="so-badge so-badge-primary">.so-d-inline-flex</span>
                <span class="so-badge so-badge-primary">.so-d-grid</span>
                <span class="so-badge so-badge-primary">.so-d-table</span>
            </div>

            <div class="so-bg-body-secondary so-p-3 so-rounded so-mb-4">
                <span class="so-d-inline so-bg-success so-text-white so-p-2 so-rounded so-me-2">inline</span>
                <span class="so-d-inline so-bg-success so-text-white so-p-2 so-rounded">inline</span>
                <div class="so-d-block so-bg-info so-text-white so-p-2 so-rounded so-mt-2">block</div>
                <div class="so-d-inline-block so-bg-warning so-text-dark so-p-2 so-rounded so-mt-2">inline-block</div>
            </div>

            <div class="so-code-block so-mb-4">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-d-none"&gt;Hidden&lt;/div&gt;
&lt;div class="so-d-block"&gt;Block&lt;/div&gt;
&lt;div class="so-d-md-none so-d-lg-block"&gt;Responsive display&lt;/div&gt;</code></pre>
            </div>

            <!-- Visibility -->
            <h5 class="so-fw-semibold so-mb-3">Visibility</h5>
            <div class="so-d-flex so-gap-3 so-mb-3">
                <div class="so-visible so-bg-primary so-text-white so-p-2 so-rounded">.so-visible</div>
                <div class="so-invisible so-bg-primary so-text-white so-p-2 so-rounded">.so-invisible (takes space)</div>
                <div class="so-bg-success so-text-white so-p-2 so-rounded">Next item</div>
            </div>
            <p class="so-text-muted so-fs-sm so-mb-3"><code>.so-invisible</code> hides visually but preserves layout space. Use <code>.so-visually-hidden</code> or <code>.so-sr-only</code> for screen reader only content.</p>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-visible"&gt;Visible&lt;/div&gt;
&lt;div class="so-invisible"&gt;Invisible (still takes space)&lt;/div&gt;
&lt;span class="so-visually-hidden"&gt;Screen reader only&lt;/span&gt;
&lt;span class="so-sr-only"&gt;Also screen reader only&lt;/span&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         FLEX UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Flexbox</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Flexbox layout utilities for alignment, direction, and distribution.</p>

            <!-- Direction -->
            <h5 class="so-fw-semibold so-mb-3">Direction</h5>
            <div class="so-row so-mb-4">
                <div class="so-col-md-6 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-flex-row</p>
                    <div class="so-d-flex so-flex-row so-gap-2 so-bg-body-secondary so-p-2 so-rounded">
                        <div class="so-bg-primary so-text-white so-p-2 so-rounded">1</div>
                        <div class="so-bg-primary so-text-white so-p-2 so-rounded">2</div>
                        <div class="so-bg-primary so-text-white so-p-2 so-rounded">3</div>
                    </div>
                </div>
                <div class="so-col-md-6 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-flex-column</p>
                    <div class="so-d-flex so-flex-column so-gap-2 so-bg-body-secondary so-p-2 so-rounded">
                        <div class="so-bg-success so-text-white so-p-2 so-rounded">1</div>
                        <div class="so-bg-success so-text-white so-p-2 so-rounded">2</div>
                        <div class="so-bg-success so-text-white so-p-2 so-rounded">3</div>
                    </div>
                </div>
            </div>

            <!-- Justify Content -->
            <h5 class="so-fw-semibold so-mb-3">Justify Content</h5>
            <div class="so-mb-4">
                <p class="so-fs-sm so-text-muted so-mb-2">.so-justify-content-start</p>
                <div class="so-d-flex so-justify-content-start so-gap-2 so-bg-body-secondary so-p-2 so-rounded so-mb-2">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">1</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">2</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">3</div>
                </div>
                <p class="so-fs-sm so-text-muted so-mb-2">.so-justify-content-center</p>
                <div class="so-d-flex so-justify-content-center so-gap-2 so-bg-body-secondary so-p-2 so-rounded so-mb-2">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">1</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">2</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">3</div>
                </div>
                <p class="so-fs-sm so-text-muted so-mb-2">.so-justify-content-end</p>
                <div class="so-d-flex so-justify-content-end so-gap-2 so-bg-body-secondary so-p-2 so-rounded so-mb-2">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">1</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">2</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">3</div>
                </div>
                <p class="so-fs-sm so-text-muted so-mb-2">.so-justify-content-between</p>
                <div class="so-d-flex so-justify-content-between so-bg-body-secondary so-p-2 so-rounded so-mb-2">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">1</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">2</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">3</div>
                </div>
                <p class="so-fs-sm so-text-muted so-mb-2">.so-justify-content-around</p>
                <div class="so-d-flex so-justify-content-around so-bg-body-secondary so-p-2 so-rounded so-mb-2">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">1</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">2</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">3</div>
                </div>
                <p class="so-fs-sm so-text-muted so-mb-2">.so-justify-content-evenly</p>
                <div class="so-d-flex so-justify-content-evenly so-bg-body-secondary so-p-2 so-rounded">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">1</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">2</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">3</div>
                </div>
            </div>

            <!-- Align Items -->
            <h5 class="so-fw-semibold so-mb-3">Align Items</h5>
            <div class="so-row so-mb-4">
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-align-items-start</p>
                    <div class="so-d-flex so-align-items-start so-gap-2 so-bg-body-secondary so-p-2 so-rounded" style="height: 100px;">
                        <div class="so-bg-warning so-text-dark so-p-2 so-rounded">1</div>
                        <div class="so-bg-warning so-text-dark so-p-3 so-rounded">2</div>
                        <div class="so-bg-warning so-text-dark so-p-2 so-rounded">3</div>
                    </div>
                </div>
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-align-items-center</p>
                    <div class="so-d-flex so-align-items-center so-gap-2 so-bg-body-secondary so-p-2 so-rounded" style="height: 100px;">
                        <div class="so-bg-warning so-text-dark so-p-2 so-rounded">1</div>
                        <div class="so-bg-warning so-text-dark so-p-3 so-rounded">2</div>
                        <div class="so-bg-warning so-text-dark so-p-2 so-rounded">3</div>
                    </div>
                </div>
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-align-items-end</p>
                    <div class="so-d-flex so-align-items-end so-gap-2 so-bg-body-secondary so-p-2 so-rounded" style="height: 100px;">
                        <div class="so-bg-warning so-text-dark so-p-2 so-rounded">1</div>
                        <div class="so-bg-warning so-text-dark so-p-3 so-rounded">2</div>
                        <div class="so-bg-warning so-text-dark so-p-2 so-rounded">3</div>
                    </div>
                </div>
            </div>

            <!-- Flex Wrap -->
            <h5 class="so-fw-semibold so-mb-3">Flex Wrap</h5>
            <div class="so-mb-4">
                <p class="so-fs-sm so-text-muted so-mb-2">.so-flex-wrap</p>
                <div class="so-d-flex so-flex-wrap so-gap-2 so-bg-body-secondary so-p-2 so-rounded" style="max-width: 300px;">
                    <div class="so-bg-danger so-text-white so-p-2 so-rounded">Item 1</div>
                    <div class="so-bg-danger so-text-white so-p-2 so-rounded">Item 2</div>
                    <div class="so-bg-danger so-text-white so-p-2 so-rounded">Item 3</div>
                    <div class="so-bg-danger so-text-white so-p-2 so-rounded">Item 4</div>
                    <div class="so-bg-danger so-text-white so-p-2 so-rounded">Item 5</div>
                </div>
            </div>

            <!-- Flex Grow/Shrink -->
            <h5 class="so-fw-semibold so-mb-3">Flex Grow & Shrink</h5>
            <div class="so-d-flex so-gap-2 so-bg-body-secondary so-p-2 so-rounded so-mb-3">
                <div class="so-flex-grow-1 so-bg-secondary so-text-white so-p-2 so-rounded">.so-flex-grow-1</div>
                <div class="so-bg-secondary so-text-white so-p-2 so-rounded">Normal</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-d-flex so-justify-content-between so-align-items-center"&gt;
  &lt;div class="so-flex-grow-1"&gt;Grows to fill&lt;/div&gt;
  &lt;div class="so-flex-shrink-0"&gt;Won't shrink&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         SIZING UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Sizing</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Width, height, and aspect ratio utilities.</p>

            <!-- Width -->
            <h5 class="so-fw-semibold so-mb-3">Width</h5>
            <div class="so-bg-body-secondary so-p-3 so-rounded so-mb-4">
                <div class="so-w-25 so-bg-primary so-text-white so-p-2 so-rounded so-mb-2">.so-w-25</div>
                <div class="so-w-50 so-bg-primary so-text-white so-p-2 so-rounded so-mb-2">.so-w-50</div>
                <div class="so-w-75 so-bg-primary so-text-white so-p-2 so-rounded so-mb-2">.so-w-75</div>
                <div class="so-w-100 so-bg-primary so-text-white so-p-2 so-rounded">.so-w-100</div>
            </div>

            <div class="so-code-block so-mb-4">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-w-25"&gt;25% width&lt;/div&gt;
&lt;div class="so-w-50"&gt;50% width&lt;/div&gt;
&lt;div class="so-w-auto"&gt;Auto width&lt;/div&gt;
&lt;div class="so-max-w-100"&gt;Max 100% width&lt;/div&gt;
&lt;div class="so-min-w-0"&gt;Min 0 width (for flex truncation)&lt;/div&gt;</code></pre>
            </div>

            <!-- Height -->
            <h5 class="so-fw-semibold so-mb-3">Height</h5>
            <div class="so-d-flex so-gap-2 so-align-items-end so-bg-body-secondary so-p-3 so-rounded so-mb-4" style="height: 150px;">
                <div class="so-h-25 so-bg-success so-text-white so-p-2 so-rounded">.so-h-25</div>
                <div class="so-h-50 so-bg-success so-text-white so-p-2 so-rounded">.so-h-50</div>
                <div class="so-h-75 so-bg-success so-text-white so-p-2 so-rounded">.so-h-75</div>
                <div class="so-h-100 so-bg-success so-text-white so-p-2 so-rounded">.so-h-100</div>
            </div>

            <div class="so-code-block so-mb-4">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-h-100"&gt;100% height&lt;/div&gt;
&lt;div class="so-vh-100"&gt;100vh (viewport height)&lt;/div&gt;
&lt;div class="so-min-vh-100"&gt;Min 100vh&lt;/div&gt;</code></pre>
            </div>

            <!-- Aspect Ratio -->
            <h5 class="so-fw-semibold so-mb-3">Aspect Ratio</h5>
            <div class="so-row so-mb-3">
                <div class="so-col-md-3 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-aspect-square</p>
                    <div class="so-aspect-square so-bg-info so-rounded so-d-flex so-align-items-center so-justify-content-center so-text-white">1:1</div>
                </div>
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-aspect-video</p>
                    <div class="so-aspect-video so-bg-warning so-rounded so-d-flex so-align-items-center so-justify-content-center so-text-dark">16:9</div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-aspect-square"&gt;1:1 ratio&lt;/div&gt;
&lt;div class="so-aspect-video"&gt;16:9 ratio&lt;/div&gt;
&lt;img class="so-object-cover so-w-100 so-h-100" src="..." /&gt;
&lt;img class="so-object-contain" src="..." /&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         TEXT UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Text / Typography</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Text alignment, transform, decoration, weight, and size utilities.</p>

            <!-- Text Alignment -->
            <h5 class="so-fw-semibold so-mb-3">Text Alignment</h5>
            <div class="so-bg-body-secondary so-p-3 so-rounded so-mb-4">
                <p class="so-text-start so-bg-white so-p-2 so-rounded so-mb-2">.so-text-start - Left aligned</p>
                <p class="so-text-center so-bg-white so-p-2 so-rounded so-mb-2">.so-text-center - Center aligned</p>
                <p class="so-text-end so-bg-white so-p-2 so-rounded so-mb-2">.so-text-end - Right aligned</p>
                <p class="so-text-justify so-bg-white so-p-2 so-rounded so-mb-0">.so-text-justify - Justified text for longer paragraphs that need even spacing on both sides.</p>
            </div>

            <!-- Text Transform -->
            <h5 class="so-fw-semibold so-mb-3">Text Transform</h5>
            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <span class="so-text-uppercase so-bg-body-secondary so-p-2 so-rounded">.so-text-uppercase</span>
                <span class="so-text-lowercase so-bg-body-secondary so-p-2 so-rounded">.so-text-lowercase</span>
                <span class="so-text-capitalize so-bg-body-secondary so-p-2 so-rounded">.so-text-capitalize</span>
            </div>

            <!-- Text Decoration -->
            <h5 class="so-fw-semibold so-mb-3">Text Decoration</h5>
            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <span class="so-text-decoration-none">.so-text-decoration-none</span>
                <span class="so-text-decoration-underline">.so-text-decoration-underline</span>
                <span class="so-text-decoration-line-through">.so-text-decoration-line-through</span>
            </div>

            <!-- Font Weight -->
            <h5 class="so-fw-semibold so-mb-3">Font Weight</h5>
            <div class="so-mb-4">
                <p class="so-fw-light so-mb-2">.so-fw-light (300)</p>
                <p class="so-fw-normal so-mb-2">.so-fw-normal (400)</p>
                <p class="so-fw-medium so-mb-2">.so-fw-medium (500)</p>
                <p class="so-fw-semibold so-mb-2">.so-fw-semibold (600)</p>
                <p class="so-fw-bold so-mb-0">.so-fw-bold (700)</p>
            </div>

            <!-- Font Size -->
            <h5 class="so-fw-semibold so-mb-3">Font Size</h5>
            <div class="so-mb-4">
                <p class="so-fs-xs so-mb-2">.so-fs-xs - Extra small</p>
                <p class="so-fs-sm so-mb-2">.so-fs-sm - Small</p>
                <p class="so-fs-base so-mb-2">.so-fs-base - Base</p>
                <p class="so-fs-lg so-mb-2">.so-fs-lg - Large</p>
                <p class="so-fs-xl so-mb-2">.so-fs-xl - Extra large</p>
                <p class="so-fs-2xl so-mb-0">.so-fs-2xl - 2X large</p>
            </div>
            <div class="so-mb-4">
                <span class="so-fs-1">.so-fs-1</span>
                <span class="so-fs-2 so-ms-3">.so-fs-2</span>
                <span class="so-fs-3 so-ms-3">.so-fs-3</span>
                <span class="so-fs-4 so-ms-3">.so-fs-4</span>
                <span class="so-fs-5 so-ms-3">.so-fs-5</span>
                <span class="so-fs-6 so-ms-3">.so-fs-6</span>
            </div>

            <!-- Line Height -->
            <h5 class="so-fw-semibold so-mb-3">Line Height</h5>
            <div class="so-row so-mb-4">
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-1">.so-lh-1 / .so-lh-none (1)</p>
                    <p class="so-lh-1 so-bg-body-secondary so-p-2 so-rounded so-fs-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-1">.so-lh-tight (1.25)</p>
                    <p class="so-lh-tight so-bg-body-secondary so-p-2 so-rounded so-fs-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-1">.so-lh-snug (1.375)</p>
                    <p class="so-lh-snug so-bg-body-secondary so-p-2 so-rounded so-fs-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
            </div>
            <div class="so-row so-mb-4">
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-1">.so-lh-normal / .so-lh-base (1.5)</p>
                    <p class="so-lh-normal so-bg-body-secondary so-p-2 so-rounded so-fs-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-1">.so-lh-relaxed (1.625)</p>
                    <p class="so-lh-relaxed so-bg-body-secondary so-p-2 so-rounded so-fs-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-1">.so-lh-loose (2)</p>
                    <p class="so-lh-loose so-bg-body-secondary so-p-2 so-rounded so-fs-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
            </div>

            <!-- Text Truncation -->
            <h5 class="so-fw-semibold so-mb-3">Text Truncation</h5>
            <div class="so-mb-4">
                <p class="so-fs-sm so-text-muted so-mb-2">.so-text-truncate</p>
                <div class="so-text-truncate so-bg-body-secondary so-p-2 so-rounded so-mb-3" style="max-width: 300px;">
                    This is a very long text that will be truncated with an ellipsis when it exceeds the container width.
                </div>
                <p class="so-fs-sm so-text-muted so-mb-2">.so-line-clamp-2</p>
                <div class="so-line-clamp-2 so-bg-body-secondary so-p-2 so-rounded" style="max-width: 300px;">
                    This text will be clamped to 2 lines maximum. Any additional text beyond the second line will be hidden with an ellipsis. This is useful for card descriptions or previews.
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;p class="so-text-truncate"&gt;Long text...&lt;/p&gt;
&lt;p class="so-line-clamp-2"&gt;Multi-line clamp...&lt;/p&gt;
&lt;p class="so-line-clamp-3"&gt;Three lines max...&lt;/p&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         LIST UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Lists</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">List styles and utility classes for ordered and unordered lists.</p>

            <!-- Default Lists -->
            <h5 class="so-fw-semibold so-mb-3">Default Lists</h5>
            <div class="so-row so-mb-4">
                <div class="so-col-md-6 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">Unordered List (ul)</p>
                    <ul>
                        <li>First item</li>
                        <li>Second item</li>
                        <li>Third item with nested list
                            <ul>
                                <li>Nested item one</li>
                                <li>Nested item two
                                    <ul>
                                        <li>Deep nested item</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>Fourth item</li>
                    </ul>
                </div>
                <div class="so-col-md-6 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">Ordered List (ol)</p>
                    <ol>
                        <li>First step</li>
                        <li>Second step</li>
                        <li>Third step with sub-steps
                            <ol>
                                <li>Sub-step one</li>
                                <li>Sub-step two
                                    <ol>
                                        <li>Deep sub-step</li>
                                    </ol>
                                </li>
                            </ol>
                        </li>
                        <li>Fourth step</li>
                    </ol>
                </div>
            </div>

            <!-- Unstyled List -->
            <h5 class="so-fw-semibold so-mb-3">Unstyled List</h5>
            <p class="so-fs-sm so-text-muted so-mb-2">.so-list-unstyled - Removes bullets/numbers and padding</p>
            <ul class="so-list-unstyled so-bg-body-secondary so-p-3 so-rounded so-mb-4">
                <li>Item without bullet</li>
                <li>Another item</li>
                <li>Third item</li>
            </ul>

            <!-- Inline List -->
            <h5 class="so-fw-semibold so-mb-3">Inline List</h5>
            <p class="so-fs-sm so-text-muted so-mb-2">.so-list-inline - Horizontal list using flexbox</p>
            <ul class="so-list-inline so-bg-body-secondary so-p-3 so-rounded so-mb-4">
                <li>Home</li>
                <li>About</li>
                <li>Services</li>
                <li>Contact</li>
            </ul>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Default unordered list --&gt;
&lt;ul&gt;
    &lt;li&gt;Item one&lt;/li&gt;
    &lt;li&gt;Item two&lt;/li&gt;
&lt;/ul&gt;

&lt;!-- Default ordered list --&gt;
&lt;ol&gt;
    &lt;li&gt;Step one&lt;/li&gt;
    &lt;li&gt;Step two&lt;/li&gt;
&lt;/ol&gt;

&lt;!-- Unstyled list --&gt;
&lt;ul class="so-list-unstyled"&gt;
    &lt;li&gt;No bullets&lt;/li&gt;
    &lt;li&gt;No padding&lt;/li&gt;
&lt;/ul&gt;

&lt;!-- Inline list --&gt;
&lt;ul class="so-list-inline"&gt;
    &lt;li&gt;Home&lt;/li&gt;
    &lt;li&gt;About&lt;/li&gt;
    &lt;li&gt;Contact&lt;/li&gt;
&lt;/ul&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         BORDER UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Borders</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Border, border-radius, and divider utilities.</p>

            <!-- Border -->
            <h5 class="so-fw-semibold so-mb-3">Border</h5>
            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <div class="so-border so-p-3 so-bg-white">.so-border</div>
                <div class="so-border-top so-p-3 so-bg-white">.so-border-top</div>
                <div class="so-border-end so-p-3 so-bg-white">.so-border-end</div>
                <div class="so-border-bottom so-p-3 so-bg-white">.so-border-bottom</div>
                <div class="so-border-start so-p-3 so-bg-white">.so-border-start</div>
            </div>

            <!-- Border Width -->
            <h5 class="so-fw-semibold so-mb-3">Border Width</h5>
            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <div class="so-border so-border-1 so-p-3 so-bg-white">.so-border-1</div>
                <div class="so-border so-border-2 so-p-3 so-bg-white">.so-border-2</div>
                <div class="so-border so-border-3 so-p-3 so-bg-white">.so-border-3</div>
                <div class="so-border so-border-4 so-p-3 so-bg-white">.so-border-4</div>
                <div class="so-border so-border-5 so-p-3 so-bg-white">.so-border-5</div>
            </div>

            <!-- Border Color -->
            <h5 class="so-fw-semibold so-mb-3">Border Color</h5>
            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <div class="so-border so-border-2 so-border-primary so-p-3 so-bg-white">.so-border-primary</div>
                <div class="so-border so-border-2 so-border-success so-p-3 so-bg-white">.so-border-success</div>
                <div class="so-border so-border-2 so-border-warning so-p-3 so-bg-white">.so-border-warning</div>
                <div class="so-border so-border-2 so-border-info so-p-3 so-bg-white">.so-border-info</div>
                <div class="so-border so-border-2 so-border-danger so-p-3 so-bg-white">.so-border-danger</div>
                <div class="so-border so-border-2 so-border-secondary so-p-3 so-bg-white">.so-border-secondary</div>
                <div class="so-border so-border-2 so-border-dark so-p-3 so-bg-white">.so-border-dark</div>
                <div class="so-border so-border-2 so-border-light so-p-3 so-bg-body-secondary">.so-border-light</div>
            </div>

            <!-- Border Radius -->
            <h5 class="so-fw-semibold so-mb-3">Border Radius</h5>
            <div class="so-d-flex so-gap-3 so-flex-wrap so-align-items-center so-mb-4">
                <div class="so-rounded-0 so-bg-primary so-text-white so-p-3">.so-rounded-0</div>
                <div class="so-rounded-sm so-bg-primary so-text-white so-p-3">.so-rounded-sm</div>
                <div class="so-rounded so-bg-primary so-text-white so-p-3">.so-rounded</div>
                <div class="so-rounded-md so-bg-primary so-text-white so-p-3">.so-rounded-md</div>
                <div class="so-rounded-lg so-bg-primary so-text-white so-p-3">.so-rounded-lg</div>
                <div class="so-rounded-xl so-bg-primary so-text-white so-p-3">.so-rounded-xl</div>
                <div class="so-rounded-full so-bg-success so-text-white so-p-3">.so-rounded-full</div>
                <div class="so-rounded-circle so-bg-info so-text-white so-d-flex so-align-items-center so-justify-content-center" style="width: 60px; height: 60px;">.so-rounded-circle</div>
                <div class="so-rounded-pill so-bg-warning so-text-dark so-px-4 so-py-2">.so-rounded-pill</div>
            </div>

            <!-- Directional Radius -->
            <h5 class="so-fw-semibold so-mb-3">Directional Radius</h5>
            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <div class="so-rounded-top so-bg-secondary so-text-white so-p-3">.so-rounded-top</div>
                <div class="so-rounded-end so-bg-secondary so-text-white so-p-3">.so-rounded-end</div>
                <div class="so-rounded-bottom so-bg-secondary so-text-white so-p-3">.so-rounded-bottom</div>
                <div class="so-rounded-start so-bg-secondary so-text-white so-p-3">.so-rounded-start</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-border so-border-2 so-border-primary so-rounded-lg"&gt;...&lt;/div&gt;
&lt;div class="so-rounded-circle"&gt;Circle&lt;/div&gt;
&lt;div class="so-rounded-pill"&gt;Pill shape&lt;/div&gt;
&lt;div class="so-border-0"&gt;No border&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         SEPARATOR UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Separator</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Horizontal and vertical line separators for dividing content sections.</p>

            <!-- Basic Horizontal Separator -->
            <h5 class="so-fw-semibold so-mb-3">Horizontal Separator</h5>
            <div class="so-bg-body-secondary so-p-4 so-rounded so-mb-4">
                <div class="so-bg-white so-p-3 so-rounded">Section 1</div>
                <div class="so-separator"></div>
                <div class="so-bg-white so-p-3 so-rounded">Section 2</div>
                <div class="so-separator"></div>
                <div class="so-bg-white so-p-3 so-rounded">Section 3</div>
            </div>

            <!-- Separator Sizes -->
            <h5 class="so-fw-semibold so-mb-3">Separator Spacing Sizes</h5>
            <div class="so-bg-body-secondary so-p-4 so-rounded so-mb-4">
                <p class="so-text-muted so-fs-sm so-mb-2">.so-separator-flush (no margin)</p>
                <div class="so-separator so-separator-flush"></div>
                <p class="so-text-muted so-fs-sm so-mt-3 so-mb-2">.so-separator-sm</p>
                <div class="so-separator so-separator-sm"></div>
                <p class="so-text-muted so-fs-sm so-mb-2">.so-separator (default)</p>
                <div class="so-separator"></div>
                <p class="so-text-muted so-fs-sm so-mb-2">.so-separator-lg</p>
                <div class="so-separator so-separator-lg"></div>
                <p class="so-text-muted so-fs-sm so-mb-2">.so-separator-xl</p>
                <div class="so-separator so-separator-xl"></div>
            </div>

            <!-- Separator Thickness -->
            <h5 class="so-fw-semibold so-mb-3">Separator Thickness</h5>
            <div class="so-bg-body-secondary so-p-4 so-rounded so-mb-4">
                <p class="so-text-muted so-fs-sm so-mb-2">.so-separator (1px default)</p>
                <div class="so-separator"></div>
                <p class="so-text-muted so-fs-sm so-mb-2">.so-separator-2</p>
                <div class="so-separator so-separator-2"></div>
                <p class="so-text-muted so-fs-sm so-mb-2">.so-separator-3</p>
                <div class="so-separator so-separator-3"></div>
                <p class="so-text-muted so-fs-sm so-mb-2">.so-separator-4</p>
                <div class="so-separator so-separator-4"></div>
            </div>

            <!-- Separator Styles -->
            <h5 class="so-fw-semibold so-mb-3">Separator Styles</h5>
            <div class="so-bg-body-secondary so-p-4 so-rounded so-mb-4">
                <p class="so-text-muted so-fs-sm so-mb-2">.so-separator (solid)</p>
                <div class="so-separator"></div>
                <p class="so-text-muted so-fs-sm so-mb-2">.so-separator-dashed</p>
                <div class="so-separator so-separator-dashed"></div>
                <p class="so-text-muted so-fs-sm so-mb-2">.so-separator-dotted</p>
                <div class="so-separator so-separator-dotted"></div>
            </div>

            <!-- Separator Colors -->
            <h5 class="so-fw-semibold so-mb-3">Separator Colors</h5>
            <div class="so-bg-body-secondary so-p-4 so-rounded so-mb-4">
                <div class="so-d-flex so-flex-column so-gap-3">
                    <div>
                        <span class="so-text-muted so-fs-sm">.so-separator-primary</span>
                        <div class="so-separator so-separator-primary so-separator-2"></div>
                    </div>
                    <div>
                        <span class="so-text-muted so-fs-sm">.so-separator-success</span>
                        <div class="so-separator so-separator-success so-separator-2"></div>
                    </div>
                    <div>
                        <span class="so-text-muted so-fs-sm">.so-separator-danger</span>
                        <div class="so-separator so-separator-danger so-separator-2"></div>
                    </div>
                    <div>
                        <span class="so-text-muted so-fs-sm">.so-separator-warning</span>
                        <div class="so-separator so-separator-warning so-separator-2"></div>
                    </div>
                    <div>
                        <span class="so-text-muted so-fs-sm">.so-separator-info</span>
                        <div class="so-separator so-separator-info so-separator-2"></div>
                    </div>
                    <div>
                        <span class="so-text-muted so-fs-sm">.so-separator-subtle</span>
                        <div class="so-separator so-separator-subtle"></div>
                    </div>
                </div>
            </div>

            <!-- Vertical Separator -->
            <h5 class="so-fw-semibold so-mb-3">Vertical Separator</h5>
            <div class="so-bg-body-secondary so-p-4 so-rounded so-mb-4">
                <div class="so-d-flex so-align-items-center so-gap-0">
                    <div class="so-bg-white so-p-3 so-rounded">Left</div>
                    <div class="so-separator-vertical" style="height: 40px;"></div>
                    <div class="so-bg-white so-p-3 so-rounded">Center</div>
                    <div class="so-separator-vertical" style="height: 40px;"></div>
                    <div class="so-bg-white so-p-3 so-rounded">Right</div>
                </div>
            </div>

            <!-- Vertical Separator Colors -->
            <h5 class="so-fw-semibold so-mb-3">Vertical Separator Colors</h5>
            <div class="so-bg-body-secondary so-p-4 so-rounded so-mb-4">
                <div class="so-d-flex so-align-items-center so-flex-wrap so-gap-4">
                    <div class="so-d-flex so-align-items-center so-gap-0">
                        <span class="so-fs-sm">Primary</span>
                        <div class="so-separator-vertical so-separator-primary so-separator-2" style="height: 30px;"></div>
                        <span class="so-fs-sm">Text</span>
                    </div>
                    <div class="so-d-flex so-align-items-center so-gap-0">
                        <span class="so-fs-sm">Success</span>
                        <div class="so-separator-vertical so-separator-success so-separator-2" style="height: 30px;"></div>
                        <span class="so-fs-sm">Text</span>
                    </div>
                    <div class="so-d-flex so-align-items-center so-gap-0">
                        <span class="so-fs-sm">Danger</span>
                        <div class="so-separator-vertical so-separator-danger so-separator-2" style="height: 30px;"></div>
                        <span class="so-fs-sm">Text</span>
                    </div>
                    <div class="so-d-flex so-align-items-center so-gap-0">
                        <span class="so-fs-sm">Warning</span>
                        <div class="so-separator-vertical so-separator-warning so-separator-2" style="height: 30px;"></div>
                        <span class="so-fs-sm">Text</span>
                    </div>
                    <div class="so-d-flex so-align-items-center so-gap-0">
                        <span class="so-fs-sm">Info</span>
                        <div class="so-separator-vertical so-separator-info so-separator-2" style="height: 30px;"></div>
                        <span class="so-fs-sm">Text</span>
                    </div>
                </div>
            </div>

            <!-- Separator with Text -->
            <h5 class="so-fw-semibold so-mb-3">Separator with Text</h5>
            <div class="so-bg-body-secondary so-p-4 so-rounded so-mb-4">
                <p class="so-text-muted so-fs-sm so-mb-2">Horizontal</p>
                <div class="so-separator so-separator-text so-text-muted so-fs-sm">OR</div>
                <div class="so-mt-4">
                    <div class="so-separator so-separator-text so-text-muted so-fs-sm">Continue with</div>
                </div>

                <p class="so-text-muted so-fs-sm so-mb-2 so-mt-4">Vertical</p>
                <div class="so-d-flex so-align-items-stretch so-gap-4" style="height: 120px;">
                    <div class="so-bg-white so-p-3 so-rounded so-d-flex so-align-items-center">Left Content</div>
                    <div class="so-separator-vertical so-separator-text so-text-muted so-fs-sm">OR</div>
                    <div class="so-bg-white so-p-3 so-rounded so-d-flex so-align-items-center">Right Content</div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Basic horizontal separator --&gt;
&lt;div class="so-separator"&gt;&lt;/div&gt;

&lt;!-- With spacing sizes --&gt;
&lt;div class="so-separator so-separator-sm"&gt;&lt;/div&gt;
&lt;div class="so-separator so-separator-lg"&gt;&lt;/div&gt;

&lt;!-- With thickness --&gt;
&lt;div class="so-separator so-separator-2"&gt;&lt;/div&gt;

&lt;!-- With styles --&gt;
&lt;div class="so-separator so-separator-dashed"&gt;&lt;/div&gt;
&lt;div class="so-separator so-separator-dotted"&gt;&lt;/div&gt;

&lt;!-- With colors --&gt;
&lt;div class="so-separator so-separator-primary"&gt;&lt;/div&gt;
&lt;div class="so-separator so-separator-subtle"&gt;&lt;/div&gt;

&lt;!-- Vertical separator --&gt;
&lt;div class="so-d-flex so-align-items-center"&gt;
  &lt;span&gt;Left&lt;/span&gt;
  &lt;div class="so-separator-vertical" style="height: 20px;"&gt;&lt;/div&gt;
  &lt;span&gt;Right&lt;/span&gt;
&lt;/div&gt;

&lt;!-- Vertical separator with colors --&gt;
&lt;div class="so-d-flex so-align-items-center"&gt;
  &lt;span&gt;Left&lt;/span&gt;
  &lt;div class="so-separator-vertical so-separator-primary so-separator-2" style="height: 20px;"&gt;&lt;/div&gt;
  &lt;span&gt;Right&lt;/span&gt;
&lt;/div&gt;

&lt;!-- Separator with text (horizontal) --&gt;
&lt;div class="so-separator so-separator-text"&gt;OR&lt;/div&gt;

&lt;!-- Separator with text (vertical) --&gt;
&lt;div class="so-d-flex so-align-items-stretch" style="height: 100px;"&gt;
  &lt;div&gt;Left&lt;/div&gt;
  &lt;div class="so-separator-vertical so-separator-text"&gt;OR&lt;/div&gt;
  &lt;div&gt;Right&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         SHADOWS UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Shadows</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Box shadow utilities for depth and elevation.</p>

            <div class="so-d-flex so-gap-4 so-flex-wrap so-mb-4">
                <div class="so-shadow-none so-bg-white so-p-4 so-rounded">.so-shadow-none</div>
                <div class="so-shadow-sm so-bg-white so-p-4 so-rounded">.so-shadow-sm</div>
                <div class="so-shadow so-bg-white so-p-4 so-rounded">.so-shadow</div>
                <div class="so-shadow-md so-bg-white so-p-4 so-rounded">.so-shadow-md</div>
                <div class="so-shadow-lg so-bg-white so-p-4 so-rounded">.so-shadow-lg</div>
                <div class="so-shadow-xl so-bg-white so-p-4 so-rounded">.so-shadow-xl</div>
                <div class="so-shadow-2xl so-bg-white so-p-4 so-rounded">.so-shadow-2xl</div>
            </div>
            <div class="so-mb-4">
                <div class="so-shadow-inner so-bg-body-secondary so-p-4 so-rounded" style="max-width: 200px;">.so-shadow-inner</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-shadow"&gt;Default shadow&lt;/div&gt;
&lt;div class="so-shadow-lg"&gt;Large shadow&lt;/div&gt;
&lt;div class="so-shadow-inner"&gt;Inset shadow&lt;/div&gt;
&lt;div class="so-shadow-none"&gt;No shadow&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         OPACITY UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Opacity</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Control element opacity.</p>

            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <div class="so-opacity-100 so-bg-primary so-text-white so-p-3 so-rounded">.so-opacity-100</div>
                <div class="so-opacity-75 so-bg-primary so-text-white so-p-3 so-rounded">.so-opacity-75</div>
                <div class="so-opacity-50 so-bg-primary so-text-white so-p-3 so-rounded">.so-opacity-50</div>
                <div class="so-opacity-25 so-bg-primary so-text-white so-p-3 so-rounded">.so-opacity-25</div>
                <div class="so-opacity-10 so-bg-primary so-text-white so-p-3 so-rounded">.so-opacity-10</div>
                <div class="so-opacity-0 so-bg-primary so-text-white so-p-3 so-rounded">.so-opacity-0</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-opacity-50"&gt;50% opacity&lt;/div&gt;
&lt;div class="so-opacity-75"&gt;75% opacity&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         OVERFLOW UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Overflow</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Control how content overflows its container.</p>

            <div class="so-row so-mb-4">
                <div class="so-col-md-3 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-overflow-auto</p>
                    <div class="so-overflow-auto so-bg-body-secondary so-p-2 so-rounded" style="height: 100px; width: 150px;">
                        <div style="width: 200px;">This content is wider than the container and will scroll horizontally. Also has vertical scrolling content here.</div>
                    </div>
                </div>
                <div class="so-col-md-3 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-overflow-hidden</p>
                    <div class="so-overflow-hidden so-bg-body-secondary so-p-2 so-rounded" style="height: 100px; width: 150px;">
                        <div style="width: 200px;">This content is wider than the container but overflow is hidden so it won't scroll.</div>
                    </div>
                </div>
                <div class="so-col-md-3 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-overflow-scroll</p>
                    <div class="so-overflow-scroll so-bg-body-secondary so-p-2 so-rounded" style="height: 100px; width: 150px;">
                        Short content but always shows scrollbars.
                    </div>
                </div>
                <div class="so-col-md-3 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-overflow-visible</p>
                    <div class="so-overflow-visible so-bg-body-secondary so-p-2 so-rounded so-position-relative" style="height: 60px; width: 150px;">
                        <div class="so-position-absolute so-bg-warning so-p-2 so-rounded" style="top: 40px;">Overflows visibly</div>
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
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-overflow-auto"&gt;Scrollable when needed&lt;/div&gt;
&lt;div class="so-overflow-hidden"&gt;Clip overflow&lt;/div&gt;
&lt;div class="so-overflow-x-auto so-overflow-y-hidden"&gt;Scroll horizontal only&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         CURSOR UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Cursor</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Change the cursor on hover.</p>

            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <div class="so-cursor-pointer so-bg-body-secondary so-p-3 so-rounded">.so-cursor-pointer</div>
                <div class="so-cursor-default so-bg-body-secondary so-p-3 so-rounded">.so-cursor-default</div>
                <div class="so-cursor-not-allowed so-bg-body-secondary so-p-3 so-rounded">.so-cursor-not-allowed</div>
                <div class="so-cursor-wait so-bg-body-secondary so-p-3 so-rounded">.so-cursor-wait</div>
                <div class="so-cursor-text so-bg-body-secondary so-p-3 so-rounded">.so-cursor-text</div>
                <div class="so-cursor-move so-bg-body-secondary so-p-3 so-rounded">.so-cursor-move</div>
                <div class="so-cursor-grab so-bg-body-secondary so-p-3 so-rounded">.so-cursor-grab</div>
                <div class="so-cursor-help so-bg-body-secondary so-p-3 so-rounded">.so-cursor-help</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;button class="so-cursor-not-allowed" disabled&gt;Disabled&lt;/button&gt;
&lt;div class="so-cursor-pointer"&gt;Clickable area&lt;/div&gt;
&lt;div class="so-cursor-grab"&gt;Draggable&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         TRANSITION UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Transitions</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">CSS transition utilities for smooth animations. Hover over elements to see effects.</p>

            <h5 class="so-fw-semibold so-mb-3">Transition Types</h5>
            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <div class="so-transition so-bg-primary so-text-white so-p-3 so-rounded" style="--hover-bg: var(--so-success);" onmouseover="this.style.backgroundColor='var(--so-success)'" onmouseout="this.style.backgroundColor=''">.so-transition</div>
                <div class="so-transition-all so-bg-success so-text-white so-p-3 so-rounded" onmouseover="this.style.transform='scale(1.1)';this.style.backgroundColor='var(--so-primary)'" onmouseout="this.style.transform='';this.style.backgroundColor=''">.so-transition-all</div>
                <div class="so-transition-colors so-bg-info so-text-white so-p-3 so-rounded" onmouseover="this.style.backgroundColor='var(--so-danger)'" onmouseout="this.style.backgroundColor=''">.so-transition-colors</div>
                <div class="so-transition-opacity so-bg-warning so-text-dark so-p-3 so-rounded" onmouseover="this.style.opacity='0.5'" onmouseout="this.style.opacity=''">.so-transition-opacity</div>
                <div class="so-transition-transform so-bg-danger so-text-white so-p-3 so-rounded" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">.so-transition-transform</div>
            </div>

            <h5 class="so-fw-semibold so-mb-3">Duration</h5>
            <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                <span class="so-badge so-badge-secondary">.so-duration-75</span>
                <span class="so-badge so-badge-secondary">.so-duration-100</span>
                <span class="so-badge so-badge-secondary">.so-duration-150</span>
                <span class="so-badge so-badge-secondary">.so-duration-200</span>
                <span class="so-badge so-badge-secondary">.so-duration-300</span>
                <span class="so-badge so-badge-secondary">.so-duration-500</span>
                <span class="so-badge so-badge-secondary">.so-duration-700</span>
                <span class="so-badge so-badge-secondary">.so-duration-1000</span>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-transition so-duration-300"&gt;Smooth transition&lt;/div&gt;
&lt;div class="so-transition-all so-duration-500"&gt;All properties animate&lt;/div&gt;
&lt;div class="so-transition-transform so-duration-200"&gt;Transform only&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         TRANSFORM UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Transforms</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Scale, rotate, and skew utilities.</p>

            <!-- Scale -->
            <h5 class="so-fw-semibold so-mb-3">Scale</h5>
            <div class="so-d-flex so-gap-4 so-flex-wrap so-align-items-center so-mb-4">
                <div class="so-scale-75 so-bg-primary so-text-white so-p-3 so-rounded">.so-scale-75</div>
                <div class="so-scale-90 so-bg-primary so-text-white so-p-3 so-rounded">.so-scale-90</div>
                <div class="so-scale-100 so-bg-primary so-text-white so-p-3 so-rounded">.so-scale-100</div>
                <div class="so-scale-105 so-bg-primary so-text-white so-p-3 so-rounded">.so-scale-105</div>
                <div class="so-scale-110 so-bg-primary so-text-white so-p-3 so-rounded">.so-scale-110</div>
                <div class="so-scale-125 so-bg-primary so-text-white so-p-3 so-rounded">.so-scale-125</div>
            </div>

            <!-- Rotate -->
            <h5 class="so-fw-semibold so-mb-3">Rotate</h5>
            <div class="so-d-flex so-gap-4 so-flex-wrap so-align-items-center so-mb-4">
                <div class="so-rotate-0 so-bg-success so-text-white so-p-3 so-rounded">.so-rotate-0</div>
                <div class="so-rotate-45 so-bg-success so-text-white so-p-3 so-rounded">.so-rotate-45</div>
                <div class="so-rotate-90 so-bg-success so-text-white so-p-3 so-rounded">.so-rotate-90</div>
                <div class="so-rotate-180 so-bg-success so-text-white so-p-3 so-rounded">.so-rotate-180</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-scale-110"&gt;Scaled up 110%&lt;/div&gt;
&lt;div class="so-rotate-45"&gt;Rotated 45 degrees&lt;/div&gt;
&lt;div class="so-transition-transform so-hover:so-scale-105"&gt;Scale on hover&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         FILTER UTILITIES
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Filters</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">CSS filter utilities for blur, grayscale, and more.</p>

            <h5 class="so-fw-semibold so-mb-3">Blur</h5>
            <div class="so-d-flex so-gap-4 so-flex-wrap so-mb-4">
                <div class="so-blur-none so-bg-info so-text-white so-p-3 so-rounded">.so-blur-none</div>
                <div class="so-blur-sm so-bg-info so-text-white so-p-3 so-rounded">.so-blur-sm</div>
                <div class="so-blur so-bg-info so-text-white so-p-3 so-rounded">.so-blur</div>
                <div class="so-blur-md so-bg-info so-text-white so-p-3 so-rounded">.so-blur-md</div>
                <div class="so-blur-lg so-bg-info so-text-white so-p-3 so-rounded">.so-blur-lg</div>
            </div>

            <h5 class="so-fw-semibold so-mb-3">Color Filters</h5>
            <div class="so-d-flex so-gap-4 so-flex-wrap so-mb-4">
                <div class="so-p-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">Original</p>
                    <div class="so-bg-gradient-primary so-text-white so-p-3 so-rounded">Sample</div>
                </div>
                <div class="so-p-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-grayscale</p>
                    <div class="so-grayscale so-bg-gradient-primary so-text-white so-p-3 so-rounded">Sample</div>
                </div>
                <div class="so-p-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-sepia</p>
                    <div class="so-sepia so-bg-gradient-primary so-text-white so-p-3 so-rounded">Sample</div>
                </div>
                <div class="so-p-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">.so-invert</p>
                    <div class="so-invert so-bg-gradient-primary so-text-white so-p-3 so-rounded">Sample</div>
                </div>
            </div>

            <h5 class="so-fw-semibold so-mb-3">Backdrop Blur</h5>
            <div class="so-position-relative so-rounded so-overflow-hidden so-mb-4" style="height: 150px;">
                <div class="so-bg-gradient-primary so-h-100 so-d-flex so-align-items-center so-justify-content-center so-text-white so-fs-lg">Background Content</div>
                <div class="so-position-absolute so-bottom-0 so-start-0 so-end-0 so-backdrop-blur-sm so-bg-white so-bg-opacity-50 so-p-3">
                    .so-backdrop-blur-sm - Blurs content behind element
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-blur-sm"&gt;Blurred element&lt;/div&gt;
&lt;div class="so-grayscale"&gt;Grayscale&lt;/div&gt;
&lt;div class="so-backdrop-blur-md so-bg-white so-bg-opacity-50"&gt;Frosted glass effect&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         USER SELECT & POINTER EVENTS
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Interactivity</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Control user selection and pointer events.</p>

            <h5 class="so-fw-semibold so-mb-3">User Select</h5>
            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <div class="so-user-select-all so-bg-body-secondary so-p-3 so-rounded">.so-user-select-all (click to select all)</div>
                <div class="so-user-select-none so-bg-body-secondary so-p-3 so-rounded">.so-user-select-none (cannot select)</div>
                <div class="so-user-select-auto so-bg-body-secondary so-p-3 so-rounded">.so-user-select-auto (default)</div>
            </div>

            <h5 class="so-fw-semibold so-mb-3">Pointer Events</h5>
            <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                <button class="so-btn so-btn-primary so-pe-none">.so-pe-none (disabled clicks)</button>
                <button class="so-btn so-btn-primary so-pe-auto">.so-pe-auto (normal)</button>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-user-select-none"&gt;Cannot be selected&lt;/div&gt;
&lt;div class="so-user-select-all"&gt;Click to select all text&lt;/div&gt;
&lt;button class="so-pe-none"&gt;Click-through (disabled)&lt;/button&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- ============================================
         SKELETON LOADING
         ============================================ -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Skeleton Loading</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Skeleton loaders provide visual placeholders while content is loading. Apply <code>.so-skeleton-loading</code> to a container to enable the animated skeleton effect.</p>

            <!-- Basic Skeleton Elements -->
            <h5 class="so-fw-semibold so-mb-3">Basic Skeleton Elements</h5>
            <div class="so-row so-mb-4">
                <div class="so-col-md-6">
                    <div class="so-bg-body-secondary so-p-4 so-rounded so-skeleton-loading">
                        <div class="so-d-flex so-gap-3 so-flex-wrap so-align-items-center">
                            <div>
                                <p class="so-fs-sm so-text-muted so-mb-1">Text</p>
                                <div class="so-skeleton so-skeleton-text" style="width: 150px;"></div>
                            </div>
                            <div>
                                <p class="so-fs-sm so-text-muted so-mb-1">Title</p>
                                <div class="so-skeleton so-skeleton-title" style="width: 120px;"></div>
                            </div>
                            <div>
                                <p class="so-fs-sm so-text-muted so-mb-1">Avatar</p>
                                <div class="so-skeleton so-skeleton-avatar"></div>
                            </div>
                            <div>
                                <p class="so-fs-sm so-text-muted so-mb-1">Button</p>
                                <div class="so-skeleton so-skeleton-btn"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-col-md-6">
                    <p class="so-fs-sm so-text-muted so-mb-2">Available skeleton classes:</p>
                    <div class="so-d-flex so-gap-2 so-flex-wrap">
                        <span class="so-badge so-badge-soft-primary">.so-skeleton</span>
                        <span class="so-badge so-badge-soft-primary">.so-skeleton-text</span>
                        <span class="so-badge so-badge-soft-primary">.so-skeleton-title</span>
                        <span class="so-badge so-badge-soft-primary">.so-skeleton-avatar</span>
                        <span class="so-badge so-badge-soft-primary">.so-skeleton-img</span>
                        <span class="so-badge so-badge-soft-primary">.so-skeleton-btn</span>
                    </div>
                </div>
            </div>

            <div class="so-code-block so-mb-5">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Wrap with .so-skeleton-loading to enable animation --&gt;
&lt;div class="so-skeleton-loading"&gt;
    &lt;div class="so-skeleton so-skeleton-text"&gt;&lt;/div&gt;
    &lt;div class="so-skeleton so-skeleton-title"&gt;&lt;/div&gt;
    &lt;div class="so-skeleton so-skeleton-avatar"&gt;&lt;/div&gt;
    &lt;div class="so-skeleton so-skeleton-btn"&gt;&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>

            <!-- Skeleton Card Examples -->
            <h5 class="so-fw-semibold so-mb-3">Skeleton Card Layouts</h5>
            <div class="so-row so-mb-4">
                <!-- Basic Card Skeleton -->
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">Basic Card</p>
                    <div class="so-card so-skeleton-loading">
                        <div class="so-card-body">
                            <div class="so-skeleton so-skeleton-title"></div>
                            <div class="so-skeleton so-skeleton-text"></div>
                            <div class="so-skeleton so-skeleton-text"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 60%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Card with Image Skeleton -->
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">Card with Image</p>
                    <div class="so-card so-skeleton-loading">
                        <div class="so-skeleton so-skeleton-img"></div>
                        <div class="so-card-body">
                            <div class="so-skeleton so-skeleton-title"></div>
                            <div class="so-skeleton so-skeleton-text"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 80%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Card with Avatar Skeleton -->
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">Card with Avatar</p>
                    <div class="so-card so-skeleton-loading">
                        <div class="so-card-header">
                            <div class="so-d-flex so-align-items-center so-gap-3">
                                <div class="so-skeleton so-skeleton-avatar"></div>
                                <div class="so-flex-grow-1">
                                    <div class="so-skeleton so-skeleton-text" style="width: 60%; margin-bottom: 6px;"></div>
                                    <div class="so-skeleton so-skeleton-text" style="width: 40%; height: 0.8em; margin-bottom: 0;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="so-card-body">
                            <div class="so-skeleton so-skeleton-text"></div>
                            <div class="so-skeleton so-skeleton-text"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 70%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="so-code-block so-mb-5">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Card with Image Skeleton --&gt;
&lt;div class="so-card so-skeleton-loading"&gt;
    &lt;div class="so-skeleton so-skeleton-img"&gt;&lt;/div&gt;
    &lt;div class="so-card-body"&gt;
        &lt;div class="so-skeleton so-skeleton-title"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton so-skeleton-text"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton so-skeleton-text" style="width: 80%;"&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Card with Avatar Skeleton --&gt;
&lt;div class="so-card so-skeleton-loading"&gt;
    &lt;div class="so-card-header"&gt;
        &lt;div class="so-d-flex so-align-items-center so-gap-3"&gt;
            &lt;div class="so-skeleton so-skeleton-avatar"&gt;&lt;/div&gt;
            &lt;div class="so-flex-grow-1"&gt;
                &lt;div class="so-skeleton so-skeleton-text" style="width: 60%;"&gt;&lt;/div&gt;
                &lt;div class="so-skeleton so-skeleton-text" style="width: 40%;"&gt;&lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-card-body"&gt;
        &lt;div class="so-skeleton so-skeleton-text"&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>

            <!-- Skeleton List/Table -->
            <h5 class="so-fw-semibold so-mb-3">Skeleton List & Table</h5>
            <div class="so-row so-mb-4">
                <!-- List Skeleton -->
                <div class="so-col-md-6 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">List Items</p>
                    <div class="so-card so-skeleton-loading">
                        <div class="so-card-body so-p-0">
                            <div class="so-d-flex so-align-items-center so-gap-3 so-p-3 so-border-bottom">
                                <div class="so-skeleton so-skeleton-avatar"></div>
                                <div class="so-flex-grow-1">
                                    <div class="so-skeleton so-skeleton-text" style="width: 50%; margin-bottom: 6px;"></div>
                                    <div class="so-skeleton so-skeleton-text" style="width: 30%; height: 0.8em; margin-bottom: 0;"></div>
                                </div>
                                <div class="so-skeleton so-skeleton-btn" style="width: 60px;"></div>
                            </div>
                            <div class="so-d-flex so-align-items-center so-gap-3 so-p-3 so-border-bottom">
                                <div class="so-skeleton so-skeleton-avatar"></div>
                                <div class="so-flex-grow-1">
                                    <div class="so-skeleton so-skeleton-text" style="width: 65%; margin-bottom: 6px;"></div>
                                    <div class="so-skeleton so-skeleton-text" style="width: 40%; height: 0.8em; margin-bottom: 0;"></div>
                                </div>
                                <div class="so-skeleton so-skeleton-btn" style="width: 60px;"></div>
                            </div>
                            <div class="so-d-flex so-align-items-center so-gap-3 so-p-3">
                                <div class="so-skeleton so-skeleton-avatar"></div>
                                <div class="so-flex-grow-1">
                                    <div class="so-skeleton so-skeleton-text" style="width: 45%; margin-bottom: 6px;"></div>
                                    <div class="so-skeleton so-skeleton-text" style="width: 25%; height: 0.8em; margin-bottom: 0;"></div>
                                </div>
                                <div class="so-skeleton so-skeleton-btn" style="width: 60px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Skeleton -->
                <div class="so-col-md-6 so-mb-3">
                    <p class="so-fs-sm so-text-muted so-mb-2">Table Rows</p>
                    <div class="so-card so-skeleton-loading">
                        <div class="so-table-responsive">
                            <table class="so-table so-mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;"></th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><div class="so-skeleton so-skeleton-avatar" style="width: 32px; height: 32px;"></div></td>
                                        <td><div class="so-skeleton so-skeleton-text" style="width: 80%; margin-bottom: 0;"></div></td>
                                        <td><div class="so-skeleton" style="width: 60px; height: 22px; border-radius: 9999px;"></div></td>
                                        <td><div class="so-skeleton so-skeleton-btn" style="width: 50px; height: 28px;"></div></td>
                                    </tr>
                                    <tr>
                                        <td><div class="so-skeleton so-skeleton-avatar" style="width: 32px; height: 32px;"></div></td>
                                        <td><div class="so-skeleton so-skeleton-text" style="width: 65%; margin-bottom: 0;"></div></td>
                                        <td><div class="so-skeleton" style="width: 60px; height: 22px; border-radius: 9999px;"></div></td>
                                        <td><div class="so-skeleton so-skeleton-btn" style="width: 50px; height: 28px;"></div></td>
                                    </tr>
                                    <tr>
                                        <td><div class="so-skeleton so-skeleton-avatar" style="width: 32px; height: 32px;"></div></td>
                                        <td><div class="so-skeleton so-skeleton-text" style="width: 90%; margin-bottom: 0;"></div></td>
                                        <td><div class="so-skeleton" style="width: 60px; height: 22px; border-radius: 9999px;"></div></td>
                                        <td><div class="so-skeleton so-skeleton-btn" style="width: 50px; height: 28px;"></div></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="so-code-block so-mb-5">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- List Item Skeleton --&gt;
&lt;div class="so-d-flex so-align-items-center so-gap-3 so-p-3"&gt;
    &lt;div class="so-skeleton so-skeleton-avatar"&gt;&lt;/div&gt;
    &lt;div class="so-flex-grow-1"&gt;
        &lt;div class="so-skeleton so-skeleton-text" style="width: 50%;"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton so-skeleton-text" style="width: 30%;"&gt;&lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-skeleton so-skeleton-btn"&gt;&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Table Row Skeleton --&gt;
&lt;tr&gt;
    &lt;td&gt;&lt;div class="so-skeleton so-skeleton-avatar" style="width: 32px; height: 32px;"&gt;&lt;/div&gt;&lt;/td&gt;
    &lt;td&gt;&lt;div class="so-skeleton so-skeleton-text" style="width: 80%;"&gt;&lt;/div&gt;&lt;/td&gt;
    &lt;td&gt;&lt;div class="so-skeleton" style="width: 60px; height: 22px; border-radius: 9999px;"&gt;&lt;/div&gt;&lt;/td&gt;
    &lt;td&gt;&lt;div class="so-skeleton so-skeleton-btn"&gt;&lt;/div&gt;&lt;/td&gt;
&lt;/tr&gt;</code></pre>
            </div>

            <!-- Custom Skeleton Shapes -->
            <h5 class="so-fw-semibold so-mb-3">Custom Skeleton Shapes</h5>
            <p class="so-text-muted so-mb-3">Use inline styles or utility classes to create custom skeleton shapes for any element.</p>
            <div class="so-row so-mb-4">
                <div class="so-col-md-6 so-mb-3">
                    <div class="so-bg-body-secondary so-p-4 so-rounded so-skeleton-loading">
                        <div class="so-d-flex so-gap-3 so-flex-wrap so-align-items-end">
                            <!-- Square -->
                            <div>
                                <p class="so-fs-sm so-text-muted so-mb-1">Square</p>
                                <div class="so-skeleton" style="width: 60px; height: 60px; border-radius: 8px;"></div>
                            </div>
                            <!-- Circle -->
                            <div>
                                <p class="so-fs-sm so-text-muted so-mb-1">Circle</p>
                                <div class="so-skeleton" style="width: 60px; height: 60px; border-radius: 50%;"></div>
                            </div>
                            <!-- Pill/Badge -->
                            <div>
                                <p class="so-fs-sm so-text-muted so-mb-1">Pill</p>
                                <div class="so-skeleton" style="width: 80px; height: 24px; border-radius: 9999px;"></div>
                            </div>
                            <!-- Icon -->
                            <div>
                                <p class="so-fs-sm so-text-muted so-mb-1">Icon</p>
                                <div class="so-skeleton" style="width: 24px; height: 24px; border-radius: 4px;"></div>
                            </div>
                            <!-- Chart Bar -->
                            <div>
                                <p class="so-fs-sm so-text-muted so-mb-1">Chart</p>
                                <div class="so-d-flex so-gap-1 so-align-items-end">
                                    <div class="so-skeleton" style="width: 12px; height: 30px; border-radius: 2px;"></div>
                                    <div class="so-skeleton" style="width: 12px; height: 50px; border-radius: 2px;"></div>
                                    <div class="so-skeleton" style="width: 12px; height: 35px; border-radius: 2px;"></div>
                                    <div class="so-skeleton" style="width: 12px; height: 60px; border-radius: 2px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-col-md-6 so-mb-3">
                    <div class="so-bg-body-secondary so-p-4 so-rounded so-skeleton-loading">
                        <p class="so-fs-sm so-text-muted so-mb-2">Profile Header</p>
                        <div class="so-d-flex so-flex-column so-align-items-center so-text-center">
                            <div class="so-skeleton" style="width: 80px; height: 80px; border-radius: 50%; margin-bottom: 12px;"></div>
                            <div class="so-skeleton so-skeleton-title" style="width: 120px;"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 160px;"></div>
                            <div class="so-d-flex so-gap-2 so-mt-3">
                                <div class="so-skeleton so-skeleton-btn"></div>
                                <div class="so-skeleton so-skeleton-btn"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="so-code-block so-mb-5">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Custom shapes with inline styles --&gt;
&lt;div class="so-skeleton" style="width: 60px; height: 60px; border-radius: 8px;"&gt;&lt;/div&gt;
&lt;div class="so-skeleton" style="width: 60px; height: 60px; border-radius: 50%;"&gt;&lt;/div&gt;
&lt;div class="so-skeleton" style="width: 80px; height: 24px; border-radius: 9999px;"&gt;&lt;/div&gt;

&lt;!-- Chart bars --&gt;
&lt;div class="so-d-flex so-gap-1 so-align-items-end"&gt;
    &lt;div class="so-skeleton" style="width: 12px; height: 30px;"&gt;&lt;/div&gt;
    &lt;div class="so-skeleton" style="width: 12px; height: 50px;"&gt;&lt;/div&gt;
    &lt;div class="so-skeleton" style="width: 12px; height: 35px;"&gt;&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>

            <!-- Grid of Skeleton Cards -->
            <h5 class="so-fw-semibold so-mb-3">Skeleton Grid Layout</h5>
            <div class="so-row so-mb-4">
                <div class="so-col-md-3 so-col-6 so-mb-3">
                    <div class="so-card so-skeleton-loading">
                        <div class="so-skeleton so-skeleton-img" style="height: 120px;"></div>
                        <div class="so-card-body so-p-3">
                            <div class="so-skeleton so-skeleton-text" style="margin-bottom: 4px;"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 60%; height: 0.8em;"></div>
                        </div>
                    </div>
                </div>
                <div class="so-col-md-3 so-col-6 so-mb-3">
                    <div class="so-card so-skeleton-loading">
                        <div class="so-skeleton so-skeleton-img" style="height: 120px;"></div>
                        <div class="so-card-body so-p-3">
                            <div class="so-skeleton so-skeleton-text" style="margin-bottom: 4px;"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 60%; height: 0.8em;"></div>
                        </div>
                    </div>
                </div>
                <div class="so-col-md-3 so-col-6 so-mb-3">
                    <div class="so-card so-skeleton-loading">
                        <div class="so-skeleton so-skeleton-img" style="height: 120px;"></div>
                        <div class="so-card-body so-p-3">
                            <div class="so-skeleton so-skeleton-text" style="margin-bottom: 4px;"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 60%; height: 0.8em;"></div>
                        </div>
                    </div>
                </div>
                <div class="so-col-md-3 so-col-6 so-mb-3">
                    <div class="so-card so-skeleton-loading">
                        <div class="so-skeleton so-skeleton-img" style="height: 120px;"></div>
                        <div class="so-card-body so-p-3">
                            <div class="so-skeleton so-skeleton-text" style="margin-bottom: 4px;"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 60%; height: 0.8em;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skeleton Reference -->
            <h5 class="so-fw-semibold so-mb-3">Skeleton Class Reference</h5>
            <div class="so-table-responsive">
                <table class="so-table">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Description</th>
                            <th>Default Size</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>.so-skeleton-loading</code></td>
                            <td>Container class that enables animation for all nested skeletons</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td><code>.so-skeleton</code></td>
                            <td>Base skeleton class with shimmer animation gradient</td>
                            <td>Auto (set via style)</td>
                        </tr>
                        <tr>
                            <td><code>.so-skeleton-text</code></td>
                            <td>Single line text placeholder</td>
                            <td>height: 1em</td>
                        </tr>
                        <tr>
                            <td><code>.so-skeleton-title</code></td>
                            <td>Title/heading placeholder</td>
                            <td>height: 1.5em, width: 50%</td>
                        </tr>
                        <tr>
                            <td><code>.so-skeleton-avatar</code></td>
                            <td>Circular avatar placeholder</td>
                            <td>40px × 40px, circle</td>
                        </tr>
                        <tr>
                            <td><code>.so-skeleton-img</code></td>
                            <td>Image placeholder with rounded top corners</td>
                            <td>height: 200px, full width</td>
                        </tr>
                        <tr>
                            <td><code>.so-skeleton-btn</code></td>
                            <td>Button placeholder</td>
                            <td>80px × 36px</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ============================================
         RESPONSIVE UTILITIES REFERENCE
         ============================================ -->
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Responsive Breakpoints</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-muted so-mb-4">Most utilities support responsive prefixes. Add breakpoint prefix to apply at specific screen sizes.</p>

            <div class="so-table-responsive so-mb-4">
                <table class="so-table">
                    <thead>
                        <tr>
                            <th>Breakpoint</th>
                            <th>Prefix</th>
                            <th>Min Width</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Small</td>
                            <td><code>sm</code></td>
                            <td>576px</td>
                            <td><code>.so-d-sm-none</code></td>
                        </tr>
                        <tr>
                            <td>Medium</td>
                            <td><code>md</code></td>
                            <td>768px</td>
                            <td><code>.so-d-md-flex</code></td>
                        </tr>
                        <tr>
                            <td>Large</td>
                            <td><code>lg</code></td>
                            <td>992px</td>
                            <td><code>.so-text-lg-center</code></td>
                        </tr>
                        <tr>
                            <td>Extra Large</td>
                            <td><code>xl</code></td>
                            <td>1200px</td>
                            <td><code>.so-p-xl-5</code></td>
                        </tr>
                        <tr>
                            <td>Extra Extra Large</td>
                            <td><code>xxl</code></td>
                            <td>1400px</td>
                            <td><code>.so-m-xxl-auto</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Hidden on mobile, visible on md and up --&gt;
&lt;div class="so-d-none so-d-md-block"&gt;...&lt;/div&gt;

&lt;!-- Stack on mobile, row on lg and up --&gt;
&lt;div class="so-d-flex so-flex-column so-flex-lg-row"&gt;...&lt;/div&gt;

&lt;!-- Different padding at breakpoints --&gt;
&lt;div class="so-p-2 so-p-md-4 so-p-xl-5"&gt;...&lt;/div&gt;

&lt;!-- Center text on mobile, left-align on md+ --&gt;
&lt;p class="so-text-center so-text-md-start"&gt;...&lt;/p&gt;</code></pre>
            </div>
        </div>
    </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
