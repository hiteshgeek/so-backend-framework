<?php
/**
 * SixOrbit UI Demo - Grid Utilities
 */
$pageTitle = 'Grid Utilities';
$pageDescription = 'Helper classes for grid layouts';

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
            <h1 class="so-page-title">Grid Utilities</h1>
            <p class="so-page-subtitle">Helper classes for grid layouts</p>
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
            min-height: 60px;
        }
        .demo-col-alt {
            padding: 0.75rem;
            background: var(--so-accent-info);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
            min-height: 60px;
        }
        .demo-col-tall {
            padding: 0.75rem;
            background: var(--so-accent-primary);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
            min-height: 100px;
        }
        .demo-col-short {
            padding: 0.75rem;
            background: var(--so-accent-info);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
            min-height: 40px;
        }
    </style>

    <!-- Vertical Alignment -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Vertical Alignment</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-align-items-*</code> classes on the row to vertically align all columns within that row.</p>

            <h6 class="so-mb-2">Align items start</h6>
            <div class="so-container-fluid so-mb-3 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg); min-height: 120px;">
                <div class="so-row so-align-items-start" style="min-height: 100px;">
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                </div>
            </div>

            <h6 class="so-mb-2">Align items center</h6>
            <div class="so-container-fluid so-mb-3 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg); min-height: 120px;">
                <div class="so-row so-align-items-center" style="min-height: 100px;">
                    <div class="so-col"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col"><div class="demo-col-alt">Column</div></div>
                </div>
            </div>

            <h6 class="so-mb-2">Align items end</h6>
            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg); min-height: 120px;">
                <div class="so-row so-align-items-end" style="min-height: 100px;">
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                    <div class="so-col"><div class="demo-col">Column</div></div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-row so-align-items-start"&gt;...&lt;/div&gt;
&lt;div class="so-row so-align-items-center"&gt;...&lt;/div&gt;
&lt;div class="so-row so-align-items-end"&gt;...&lt;/div&gt;
&lt;div class="so-row so-align-items-baseline"&gt;...&lt;/div&gt;
&lt;div class="so-row so-align-items-stretch"&gt;...&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Individual Column Alignment -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Individual Column Alignment</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-align-self-*</code> classes on individual columns to change their vertical alignment.</p>

            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg); min-height: 150px;">
                <div class="so-row" style="min-height: 130px;">
                    <div class="so-col so-align-self-start"><div class="demo-col">align-self-start</div></div>
                    <div class="so-col so-align-self-center"><div class="demo-col-alt">align-self-center</div></div>
                    <div class="so-col so-align-self-end"><div class="demo-col">align-self-end</div></div>
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
  &lt;div class="so-col so-align-self-start"&gt;...&lt;/div&gt;
  &lt;div class="so-col so-align-self-center"&gt;...&lt;/div&gt;
  &lt;div class="so-col so-align-self-end"&gt;...&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Horizontal Alignment -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Horizontal Alignment</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-justify-content-*</code> classes to horizontally align columns within a row.</p>

            <h6 class="so-mb-2">Justify content start (default)</h6>
            <div class="so-container-fluid so-mb-3 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-justify-content-start">
                    <div class="so-col-3"><div class="demo-col">Column</div></div>
                    <div class="so-col-3"><div class="demo-col">Column</div></div>
                </div>
            </div>

            <h6 class="so-mb-2">Justify content center</h6>
            <div class="so-container-fluid so-mb-3 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-justify-content-center">
                    <div class="so-col-3"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-3"><div class="demo-col-alt">Column</div></div>
                </div>
            </div>

            <h6 class="so-mb-2">Justify content end</h6>
            <div class="so-container-fluid so-mb-3 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-justify-content-end">
                    <div class="so-col-3"><div class="demo-col">Column</div></div>
                    <div class="so-col-3"><div class="demo-col">Column</div></div>
                </div>
            </div>

            <h6 class="so-mb-2">Justify content between</h6>
            <div class="so-container-fluid so-mb-3 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-justify-content-between">
                    <div class="so-col-3"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-3"><div class="demo-col-alt">Column</div></div>
                </div>
            </div>

            <h6 class="so-mb-2">Justify content around</h6>
            <div class="so-container-fluid so-mb-3 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-justify-content-around">
                    <div class="so-col-3"><div class="demo-col">Column</div></div>
                    <div class="so-col-3"><div class="demo-col">Column</div></div>
                </div>
            </div>

            <h6 class="so-mb-2">Justify content evenly</h6>
            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row so-justify-content-evenly">
                    <div class="so-col-3"><div class="demo-col-alt">Column</div></div>
                    <div class="so-col-3"><div class="demo-col-alt">Column</div></div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-row so-justify-content-start"&gt;...&lt;/div&gt;
&lt;div class="so-row so-justify-content-center"&gt;...&lt;/div&gt;
&lt;div class="so-row so-justify-content-end"&gt;...&lt;/div&gt;
&lt;div class="so-row so-justify-content-between"&gt;...&lt;/div&gt;
&lt;div class="so-row so-justify-content-around"&gt;...&lt;/div&gt;
&lt;div class="so-row so-justify-content-evenly"&gt;...&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Column Ordering -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Column Ordering</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-order-*</code> classes to control the visual order of your content. These classes are responsive, so you can set the order by breakpoint.</p>

            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row">
                    <div class="so-col so-order-3"><div class="demo-col">First in DOM, order-3</div></div>
                    <div class="so-col so-order-1"><div class="demo-col-alt">Second in DOM, order-1</div></div>
                    <div class="so-col so-order-2"><div class="demo-col">Third in DOM, order-2</div></div>
                </div>
            </div>

            <h6 class="so-mt-4 so-mb-3">Order first and last</h6>
            <div class="so-container-fluid so-mb-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-row">
                    <div class="so-col so-order-last"><div class="demo-col">First in DOM, order-last</div></div>
                    <div class="so-col"><div class="demo-col-alt">Second in DOM, no order</div></div>
                    <div class="so-col so-order-first"><div class="demo-col">Third in DOM, order-first</div></div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Numeric ordering --&gt;
&lt;div class="so-row"&gt;
  &lt;div class="so-col so-order-3"&gt;First in DOM&lt;/div&gt;
  &lt;div class="so-col so-order-1"&gt;Second in DOM&lt;/div&gt;
  &lt;div class="so-col so-order-2"&gt;Third in DOM&lt;/div&gt;
&lt;/div&gt;

&lt;!-- First and last --&gt;
&lt;div class="so-row"&gt;
  &lt;div class="so-col so-order-last"&gt;First&lt;/div&gt;
  &lt;div class="so-col"&gt;Second&lt;/div&gt;
  &lt;div class="so-col so-order-first"&gt;Third&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Responsive ordering --&gt;
&lt;div class="so-row"&gt;
  &lt;div class="so-col so-order-md-2"&gt;First on mobile, second on md+&lt;/div&gt;
  &lt;div class="so-col so-order-md-1"&gt;Second on mobile, first on md+&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Spacing (Margin) Utilities -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Spacing (Margin) Utilities</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-m-*</code> classes to add margin to elements. The scale ranges from 0-8 plus auto.</p>

            <style>
                .spacing-demo-box {
                    background: var(--so-accent-primary);
                    color: white;
                    padding: 0.5rem;
                    text-align: center;
                    border-radius: var(--so-radius-sm);
                    font-size: 12px;
                }
                .spacing-demo-wrapper {
                    background: var(--so-grey-200);
                    border-radius: var(--so-radius-md);
                    display: inline-block;
                }
            </style>

            <h6 class="so-mb-3">Margin Scale</h6>
            <div class="so-flex so-flex-wrap so-gap-3 so-mb-4">
                <div>
                    <div class="spacing-demo-wrapper">
                        <div class="spacing-demo-box so-m-0">m-0</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">0</div>
                </div>
                <div>
                    <div class="spacing-demo-wrapper">
                        <div class="spacing-demo-box so-m-1">m-1</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">0.25rem</div>
                </div>
                <div>
                    <div class="spacing-demo-wrapper">
                        <div class="spacing-demo-box so-m-2">m-2</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">0.5rem</div>
                </div>
                <div>
                    <div class="spacing-demo-wrapper">
                        <div class="spacing-demo-box so-m-3">m-3</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">1rem</div>
                </div>
                <div>
                    <div class="spacing-demo-wrapper">
                        <div class="spacing-demo-box so-m-4">m-4</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">1.5rem</div>
                </div>
                <div>
                    <div class="spacing-demo-wrapper">
                        <div class="spacing-demo-box so-m-5">m-5</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">3rem</div>
                </div>
            </div>

            <h6 class="so-mb-3">Directional Margins</h6>
            <div class="so-row so-mb-4">
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-wrapper so-d-block">
                        <div class="spacing-demo-box so-mt-3">mt-3</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">margin-top</div>
                </div>
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-wrapper so-d-block">
                        <div class="spacing-demo-box so-mb-3">mb-3</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">margin-bottom</div>
                </div>
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-wrapper so-d-block">
                        <div class="spacing-demo-box so-ms-3">ms-3</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">margin-start (left)</div>
                </div>
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-wrapper so-d-block">
                        <div class="spacing-demo-box so-me-3">me-3</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">margin-end (right)</div>
                </div>
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-wrapper so-d-block">
                        <div class="spacing-demo-box so-mx-3">mx-3</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">margin-x (left+right)</div>
                </div>
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-wrapper so-d-block">
                        <div class="spacing-demo-box so-my-3">my-3</div>
                    </div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">margin-y (top+bottom)</div>
                </div>
            </div>

            <h6 class="so-mb-3">Auto Margins (Centering)</h6>
            <div class="so-p-3 so-mb-4" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="spacing-demo-box so-mx-auto" style="width: 150px;">mx-auto (centered)</div>
            </div>
            <div class="so-p-3 so-mb-4" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="spacing-demo-box so-ms-auto" style="width: 150px;">ms-auto (right)</div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- All sides margin --&gt;
&lt;div class="so-m-0"&gt;...&lt;/div&gt;  &lt;!-- margin: 0 --&gt;
&lt;div class="so-m-1"&gt;...&lt;/div&gt;  &lt;!-- margin: 0.25rem (4px) --&gt;
&lt;div class="so-m-2"&gt;...&lt;/div&gt;  &lt;!-- margin: 0.5rem (8px) --&gt;
&lt;div class="so-m-3"&gt;...&lt;/div&gt;  &lt;!-- margin: 1rem (16px) --&gt;
&lt;div class="so-m-4"&gt;...&lt;/div&gt;  &lt;!-- margin: 1.5rem (24px) --&gt;
&lt;div class="so-m-5"&gt;...&lt;/div&gt;  &lt;!-- margin: 3rem (48px) --&gt;
&lt;div class="so-m-6"&gt;...&lt;/div&gt;  &lt;!-- margin: 4rem (64px) --&gt;
&lt;div class="so-m-7"&gt;...&lt;/div&gt;  &lt;!-- margin: 5rem (80px) --&gt;
&lt;div class="so-m-8"&gt;...&lt;/div&gt;  &lt;!-- margin: 6rem (96px) --&gt;

&lt;!-- Directional margins --&gt;
&lt;div class="so-mt-3"&gt;...&lt;/div&gt;  &lt;!-- margin-top --&gt;
&lt;div class="so-mb-3"&gt;...&lt;/div&gt;  &lt;!-- margin-bottom --&gt;
&lt;div class="so-ms-3"&gt;...&lt;/div&gt;  &lt;!-- margin-start (left in LTR) --&gt;
&lt;div class="so-me-3"&gt;...&lt;/div&gt;  &lt;!-- margin-end (right in LTR) --&gt;
&lt;div class="so-mx-3"&gt;...&lt;/div&gt;  &lt;!-- margin-left + margin-right --&gt;
&lt;div class="so-my-3"&gt;...&lt;/div&gt;  &lt;!-- margin-top + margin-bottom --&gt;

&lt;!-- Auto margins for centering --&gt;
&lt;div class="so-mx-auto"&gt;...&lt;/div&gt;  &lt;!-- Center horizontally --&gt;
&lt;div class="so-ms-auto"&gt;...&lt;/div&gt;  &lt;!-- Push to right --&gt;
&lt;div class="so-me-auto"&gt;...&lt;/div&gt;  &lt;!-- Push to left --&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Padding Utilities -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Padding Utilities</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-p-*</code> classes to add padding to elements. Same scale as margins (0-8).</p>

            <h6 class="so-mb-3">Padding Scale</h6>
            <div class="so-flex so-flex-wrap so-gap-3 so-mb-4">
                <div class="spacing-demo-box so-p-0">p-0</div>
                <div class="spacing-demo-box so-p-1">p-1</div>
                <div class="spacing-demo-box so-p-2">p-2</div>
                <div class="spacing-demo-box so-p-3">p-3</div>
                <div class="spacing-demo-box so-p-4">p-4</div>
                <div class="spacing-demo-box so-p-5">p-5</div>
            </div>

            <h6 class="so-mb-3">Directional Padding</h6>
            <div class="so-row so-mb-4">
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-box so-pt-4">pt-4</div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">padding-top</div>
                </div>
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-box so-pb-4">pb-4</div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">padding-bottom</div>
                </div>
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-box so-ps-4">ps-4</div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">padding-start (left)</div>
                </div>
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-box so-pe-4">pe-4</div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">padding-end (right)</div>
                </div>
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-box so-px-4">px-4</div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">padding-x</div>
                </div>
                <div class="so-col-6 so-col-md-4 so-col-lg-2 so-mb-3">
                    <div class="spacing-demo-box so-py-4">py-4</div>
                    <div class="so-text-muted so-text-center" style="font-size: 11px;">padding-y</div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- All sides padding --&gt;
&lt;div class="so-p-0"&gt;...&lt;/div&gt;  &lt;!-- padding: 0 --&gt;
&lt;div class="so-p-1"&gt;...&lt;/div&gt;  &lt;!-- padding: 0.25rem (4px) --&gt;
&lt;div class="so-p-2"&gt;...&lt;/div&gt;  &lt;!-- padding: 0.5rem (8px) --&gt;
&lt;div class="so-p-3"&gt;...&lt;/div&gt;  &lt;!-- padding: 1rem (16px) --&gt;
&lt;div class="so-p-4"&gt;...&lt;/div&gt;  &lt;!-- padding: 1.5rem (24px) --&gt;
&lt;div class="so-p-5"&gt;...&lt;/div&gt;  &lt;!-- padding: 3rem (48px) --&gt;

&lt;!-- Directional padding --&gt;
&lt;div class="so-pt-3"&gt;...&lt;/div&gt;  &lt;!-- padding-top --&gt;
&lt;div class="so-pb-3"&gt;...&lt;/div&gt;  &lt;!-- padding-bottom --&gt;
&lt;div class="so-ps-3"&gt;...&lt;/div&gt;  &lt;!-- padding-start (left in LTR) --&gt;
&lt;div class="so-pe-3"&gt;...&lt;/div&gt;  &lt;!-- padding-end (right in LTR) --&gt;
&lt;div class="so-px-3"&gt;...&lt;/div&gt;  &lt;!-- padding-left + padding-right --&gt;
&lt;div class="so-py-3"&gt;...&lt;/div&gt;  &lt;!-- padding-top + padding-bottom --&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Gap Utilities -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Gap Utilities (Flexbox & Grid)</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-gap-*</code> classes to add spacing between flex or grid items without affecting outer margins.</p>

            <h6 class="so-mb-3">Gap Scale</h6>
            <div class="so-row so-mb-4">
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-mb-2"><code>.so-gap-1</code> (0.25rem)</p>
                    <div class="so-flex so-flex-wrap so-gap-1 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-md);">
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                    </div>
                </div>
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-mb-2"><code>.so-gap-3</code> (1rem)</p>
                    <div class="so-flex so-flex-wrap so-gap-3 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-md);">
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                    </div>
                </div>
                <div class="so-col-md-4 so-mb-3">
                    <p class="so-mb-2"><code>.so-gap-5</code> (3rem)</p>
                    <div class="so-flex so-flex-wrap so-gap-5 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-md);">
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                    </div>
                </div>
            </div>

            <h6 class="so-mb-3">Row Gap & Column Gap</h6>
            <div class="so-row so-mb-4">
                <div class="so-col-md-6 so-mb-3">
                    <p class="so-mb-2"><code>.so-row-gap-3 .so-column-gap-1</code></p>
                    <div class="so-flex so-flex-wrap so-row-gap-3 so-column-gap-1 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-md);">
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                    </div>
                </div>
                <div class="so-col-md-6 so-mb-3">
                    <p class="so-mb-2"><code>.so-row-gap-1 .so-column-gap-4</code></p>
                    <div class="so-flex so-flex-wrap so-row-gap-1 so-column-gap-4 so-p-3" style="background: var(--so-grey-100); border-radius: var(--so-radius-md);">
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
                        <div class="spacing-demo-box">Item</div>
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
                <pre class="so-code-content"><code class="language-html">&lt;!-- Gap on both axes --&gt;
&lt;div class="so-flex so-gap-3"&gt;
    &lt;div&gt;Item&lt;/div&gt;
    &lt;div&gt;Item&lt;/div&gt;
    &lt;div&gt;Item&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Different row and column gaps --&gt;
&lt;div class="so-flex so-flex-wrap so-row-gap-3 so-column-gap-1"&gt;
    &lt;div&gt;Item&lt;/div&gt;
    &lt;div&gt;Item&lt;/div&gt;
    &lt;div&gt;Item&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Available gap classes: so-gap-{0-8} --&gt;
&lt;!-- Also: so-row-gap-{0-8} and so-column-gap-{0-8} --&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Negative Margins -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Negative Margins</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-m-n*</code> classes to apply negative margins, useful for pulling elements outside their container or overlapping elements.</p>

            <div class="so-p-4 so-mb-4" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="so-p-3" style="background: var(--so-grey-200); border-radius: var(--so-radius-md);">
                    <div class="spacing-demo-box so-mx-n3">mx-n3 (negative margin pulling outside)</div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Negative margins --&gt;
&lt;div class="so-m-n1"&gt;...&lt;/div&gt;  &lt;!-- margin: -0.25rem --&gt;
&lt;div class="so-m-n2"&gt;...&lt;/div&gt;  &lt;!-- margin: -0.5rem --&gt;
&lt;div class="so-m-n3"&gt;...&lt;/div&gt;  &lt;!-- margin: -1rem --&gt;

&lt;!-- Directional negative margins --&gt;
&lt;div class="so-mt-n3"&gt;...&lt;/div&gt;  &lt;!-- margin-top: -1rem --&gt;
&lt;div class="so-mx-n3"&gt;...&lt;/div&gt;  &lt;!-- margin-left + margin-right: -1rem --&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Responsive Spacing -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Responsive Spacing</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">All spacing utilities support responsive breakpoints. Use <code>.so-{property}-{breakpoint}-{size}</code> format.</p>

            <div class="so-alert so-alert-info so-mb-4">
                <span class="material-icons">info</span>
                <div>Resize your browser to see the spacing change at different breakpoints.</div>
            </div>

            <div class="so-p-3 so-mb-4" style="background: var(--so-grey-100); border-radius: var(--so-radius-lg);">
                <div class="spacing-demo-box so-p-2 so-p-md-4 so-p-lg-5">
                    p-2 on mobile, p-4 on md, p-5 on lg
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Responsive margins --&gt;
&lt;div class="so-m-2 so-m-md-4 so-m-lg-5"&gt;...&lt;/div&gt;

&lt;!-- Responsive padding --&gt;
&lt;div class="so-p-2 so-p-md-4 so-p-lg-5"&gt;...&lt;/div&gt;

&lt;!-- Responsive directional spacing --&gt;
&lt;div class="so-mt-3 so-mt-md-5"&gt;...&lt;/div&gt;
&lt;div class="so-px-2 so-px-lg-4"&gt;...&lt;/div&gt;

&lt;!-- Responsive gap --&gt;
&lt;div class="so-flex so-gap-2 so-gap-md-4"&gt;...&lt;/div&gt;

&lt;!-- Breakpoints: sm (576px), md (768px), lg (1024px), xl (1200px), xxl (1400px) --&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Spacing Reference Table -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Spacing Scale Reference</h3>
        </div>
        <div class="so-card-body">
            <div class="so-table-responsive">
                <table class="so-table so-table-bordered">
                    <thead>
                        <tr>
                            <th>Size</th>
                            <th>Value</th>
                            <th>Pixels</th>
                            <th>Margin Class</th>
                            <th>Padding Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>0</td>
                            <td>0</td>
                            <td>0px</td>
                            <td><code>.so-m-0</code></td>
                            <td><code>.so-p-0</code></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>0.25rem</td>
                            <td>4px</td>
                            <td><code>.so-m-1</code></td>
                            <td><code>.so-p-1</code></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>0.5rem</td>
                            <td>8px</td>
                            <td><code>.so-m-2</code></td>
                            <td><code>.so-p-2</code></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>1rem</td>
                            <td>16px</td>
                            <td><code>.so-m-3</code></td>
                            <td><code>.so-p-3</code></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>1.5rem</td>
                            <td>24px</td>
                            <td><code>.so-m-4</code></td>
                            <td><code>.so-p-4</code></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>3rem</td>
                            <td>48px</td>
                            <td><code>.so-m-5</code></td>
                            <td><code>.so-p-5</code></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>4rem</td>
                            <td>64px</td>
                            <td><code>.so-m-6</code></td>
                            <td><code>.so-p-6</code></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>5rem</td>
                            <td>80px</td>
                            <td><code>.so-m-7</code></td>
                            <td><code>.so-p-7</code></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>6rem</td>
                            <td>96px</td>
                            <td><code>.so-m-8</code></td>
                            <td><code>.so-p-8</code></td>
                        </tr>
                        <tr>
                            <td>auto</td>
                            <td>auto</td>
                            <td>-</td>
                            <td><code>.so-m-auto</code></td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h6 class="so-mt-4 so-mb-3">Direction Abbreviations</h6>
            <div class="so-table-responsive">
                <table class="so-table so-table-bordered">
                    <thead>
                        <tr>
                            <th>Abbreviation</th>
                            <th>Description</th>
                            <th>CSS Property</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>t</code></td>
                            <td>Top</td>
                            <td>margin-top / padding-top</td>
                        </tr>
                        <tr>
                            <td><code>b</code></td>
                            <td>Bottom</td>
                            <td>margin-bottom / padding-bottom</td>
                        </tr>
                        <tr>
                            <td><code>s</code></td>
                            <td>Start (left in LTR)</td>
                            <td>margin-left / padding-left</td>
                        </tr>
                        <tr>
                            <td><code>e</code></td>
                            <td>End (right in LTR)</td>
                            <td>margin-right / padding-right</td>
                        </tr>
                        <tr>
                            <td><code>x</code></td>
                            <td>Horizontal (left + right)</td>
                            <td>margin-left + margin-right</td>
                        </tr>
                        <tr>
                            <td><code>y</code></td>
                            <td>Vertical (top + bottom)</td>
                            <td>margin-top + margin-bottom</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Alignment Classes Reference -->
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Alignment Classes Reference</h3>
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
                            <td colspan="2"><strong>Vertical Alignment (Row)</strong></td>
                        </tr>
                        <tr>
                            <td><code>.so-align-items-start</code></td>
                            <td>Align items to the start (top)</td>
                        </tr>
                        <tr>
                            <td><code>.so-align-items-center</code></td>
                            <td>Align items to the center</td>
                        </tr>
                        <tr>
                            <td><code>.so-align-items-end</code></td>
                            <td>Align items to the end (bottom)</td>
                        </tr>
                        <tr>
                            <td><code>.so-align-items-baseline</code></td>
                            <td>Align items to baseline</td>
                        </tr>
                        <tr>
                            <td><code>.so-align-items-stretch</code></td>
                            <td>Stretch items to fill container</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Vertical Alignment (Column)</strong></td>
                        </tr>
                        <tr>
                            <td><code>.so-align-self-start</code></td>
                            <td>Align self to the start</td>
                        </tr>
                        <tr>
                            <td><code>.so-align-self-center</code></td>
                            <td>Align self to the center</td>
                        </tr>
                        <tr>
                            <td><code>.so-align-self-end</code></td>
                            <td>Align self to the end</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Horizontal Alignment</strong></td>
                        </tr>
                        <tr>
                            <td><code>.so-justify-content-start</code></td>
                            <td>Justify to start (left)</td>
                        </tr>
                        <tr>
                            <td><code>.so-justify-content-center</code></td>
                            <td>Justify to center</td>
                        </tr>
                        <tr>
                            <td><code>.so-justify-content-end</code></td>
                            <td>Justify to end (right)</td>
                        </tr>
                        <tr>
                            <td><code>.so-justify-content-between</code></td>
                            <td>Space between items</td>
                        </tr>
                        <tr>
                            <td><code>.so-justify-content-around</code></td>
                            <td>Space around items</td>
                        </tr>
                        <tr>
                            <td><code>.so-justify-content-evenly</code></td>
                            <td>Equal space between items</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Ordering</strong></td>
                        </tr>
                        <tr>
                            <td><code>.so-order-{0-5}</code></td>
                            <td>Set order value (0-5)</td>
                        </tr>
                        <tr>
                            <td><code>.so-order-first</code></td>
                            <td>Order -1 (first)</td>
                        </tr>
                        <tr>
                            <td><code>.so-order-last</code></td>
                            <td>Order 6 (last)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
