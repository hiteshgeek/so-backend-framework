<?php
/**
 * SixOrbit UI Demo - Z-Index
 */
$pageTitle = 'Z-Index';
$pageDescription = 'Stacking order and layering utilities';

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
            <h1 class="so-page-title">Z-Index</h1>
            <p class="so-page-subtitle">Stacking order and layering utilities</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <!-- Z-index Overview -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Z-index</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">SixOrbit UI uses a defined z-index scale to manage stacking contexts. This ensures consistent layering of components like dropdowns, modals, and tooltips.</p>

            <div class="so-table-responsive so-mb-4">
                <table class="so-table so-table-bordered">
                    <thead>
                        <tr>
                            <th>Level</th>
                            <th>Z-index Value</th>
                            <th>Usage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Negative</td>
                            <td><code>-1</code></td>
                            <td>Background elements, decorative layers</td>
                        </tr>
                        <tr>
                            <td>Base</td>
                            <td><code>0</code></td>
                            <td>Default stacking level</td>
                        </tr>
                        <tr>
                            <td>Dropdown</td>
                            <td><code>1000</code></td>
                            <td>Dropdown menus</td>
                        </tr>
                        <tr>
                            <td>Sticky</td>
                            <td><code>1020</code></td>
                            <td>Sticky positioned elements</td>
                        </tr>
                        <tr>
                            <td>Fixed</td>
                            <td><code>1030</code></td>
                            <td>Fixed positioned elements (navbar)</td>
                        </tr>
                        <tr>
                            <td>Sidebar Backdrop</td>
                            <td><code>1035</code></td>
                            <td>Mobile sidebar overlay</td>
                        </tr>
                        <tr>
                            <td>Sidebar</td>
                            <td><code>1040</code></td>
                            <td>Sidebar navigation</td>
                        </tr>
                        <tr>
                            <td>Modal Backdrop</td>
                            <td><code>1050</code></td>
                            <td>Modal overlay background</td>
                        </tr>
                        <tr>
                            <td>Modal</td>
                            <td><code>1055</code></td>
                            <td>Modal dialogs</td>
                        </tr>
                        <tr>
                            <td>Popover</td>
                            <td><code>1060</code></td>
                            <td>Popovers, context menus</td>
                        </tr>
                        <tr>
                            <td>Tooltip</td>
                            <td><code>1070</code></td>
                            <td>Tooltips (highest common level)</td>
                        </tr>
                        <tr>
                            <td>Toast</td>
                            <td><code>1080</code></td>
                            <td>Toast notifications (topmost)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Z-index Utility Classes -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Z-index Utility Classes</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use these utility classes to set z-index values directly in your markup.</p>

            <h6 class="so-mb-3">Numeric Z-index Classes</h6>
            <div class="so-table-responsive so-mb-4">
                <table class="so-table so-table-bordered">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Z-index Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>.so-z-n1</code></td>
                            <td>-1</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-0</code></td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-10</code></td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-20</code></td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-30</code></td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-40</code></td>
                            <td>40</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-50</code></td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-auto</code></td>
                            <td>auto</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h6 class="so-mb-3">Named Z-index Classes</h6>
            <div class="so-table-responsive so-mb-4">
                <table class="so-table so-table-bordered">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Z-index Value</th>
                            <th>Use Case</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>.so-z-dropdown</code></td>
                            <td>1000</td>
                            <td>Dropdown menus</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-sticky</code></td>
                            <td>1020</td>
                            <td>Sticky elements</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-fixed</code></td>
                            <td>1030</td>
                            <td>Fixed headers/footers</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-sidebar</code></td>
                            <td>1040</td>
                            <td>Sidebar navigation</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-modal-backdrop</code></td>
                            <td>1050</td>
                            <td>Modal background overlay</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-modal</code></td>
                            <td>1055</td>
                            <td>Modal dialogs</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-popover</code></td>
                            <td>1060</td>
                            <td>Popovers, context menus</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-tooltip</code></td>
                            <td>1070</td>
                            <td>Tooltips</td>
                        </tr>
                        <tr>
                            <td><code>.so-z-toast</code></td>
                            <td>1080</td>
                            <td>Toast notifications</td>
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
                <pre class="so-code-content"><code class="language-html">&lt;!-- Numeric z-index --&gt;
&lt;div class="so-z-10"&gt;z-index: 10&lt;/div&gt;
&lt;div class="so-z-20"&gt;z-index: 20&lt;/div&gt;

&lt;!-- Named z-index --&gt;
&lt;div class="so-z-dropdown"&gt;Dropdown level&lt;/div&gt;
&lt;div class="so-z-modal"&gt;Modal level&lt;/div&gt;
&lt;div class="so-z-tooltip"&gt;Tooltip level&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Visual Demo -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Visual Demo</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Hover over the stacked elements to see the z-index layering in action.</p>

            <div class="so-position-relative" style="height: 250px; background: var(--so-grey-100); border-radius: var(--so-radius-lg); overflow: hidden;">
                <div class="so-position-absolute so-z-10" style="top: 20px; left: 20px; width: 200px; height: 150px; background: var(--so-accent-primary); opacity: 0.9; border-radius: var(--so-radius-md); display: flex; align-items: center; justify-content: center; color: white; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <div class="so-text-center">
                        <div class="so-text-sm so-mb-1">z-index: 10</div>
                        <code class="so-text-xs">.so-z-10</code>
                    </div>
                </div>
                <div class="so-position-absolute so-z-20" style="top: 60px; left: 100px; width: 200px; height: 150px; background: var(--so-accent-info); opacity: 0.9; border-radius: var(--so-radius-md); display: flex; align-items: center; justify-content: center; color: white; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <div class="so-text-center">
                        <div class="so-text-sm so-mb-1">z-index: 20</div>
                        <code class="so-text-xs">.so-z-20</code>
                    </div>
                </div>
                <div class="so-position-absolute so-z-30" style="top: 100px; left: 180px; width: 200px; height: 150px; background: var(--so-accent-success); opacity: 0.9; border-radius: var(--so-radius-md); display: flex; align-items: center; justify-content: center; color: white; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <div class="so-text-center">
                        <div class="so-text-sm so-mb-1">z-index: 30</div>
                        <code class="so-text-xs">.so-z-30</code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCSS Variables -->
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">SCSS Variables</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">The z-index scale is defined in SCSS variables for easy customization.</p>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> SCSS</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-scss">// Z-index scale
$so-z-indexes: (
  'negative':       -1,
  'base':            0,
  'dropdown':     1000,
  'sticky':       1020,
  'fixed':        1030,
  'sidebar-backdrop': 1035,
  'sidebar':      1040,
  'modal-backdrop': 1050,
  'modal':        1055,
  'popover':      1060,
  'tooltip':      1070,
  'toast':        1080
);

// Usage in SCSS
.my-element {
  z-index: map.get($so-z-indexes, 'dropdown'); // 1000
}

// Or use the z-index() function
.my-element {
  z-index: z-index('modal'); // 1055
}</code></pre>
            </div>
        </div>
    </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
