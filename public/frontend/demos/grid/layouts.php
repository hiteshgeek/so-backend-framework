<?php
/**
 * SixOrbit UI Demo - Layouts
 */
$pageTitle = 'Layouts';
$pageDescription = 'Common layout patterns and examples';

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
            <h1 class="so-page-title">Layouts</h1>
            <p class="so-page-subtitle">Common layout patterns and examples</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <style>
        .demo-box {
            padding: 1rem;
            background: var(--so-accent-primary);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .demo-box-alt {
            padding: 1rem;
            background: var(--so-accent-info);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .demo-box-success {
            padding: 1rem;
            background: var(--so-accent-success);
            color: white;
            text-align: center;
            border-radius: var(--so-radius-md);
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .demo-box-warning {
            padding: 1rem;
            background: var(--so-accent-warning);
            color: var(--so-grey-900);
            text-align: center;
            border-radius: var(--so-radius-md);
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .layout-demo {
            border: 2px dashed var(--so-border-color);
            border-radius: var(--so-radius-lg);
            padding: 1rem;
            min-height: 300px;
        }
        .layout-demo-tall {
            min-height: 400px;
        }
    </style>

    <!-- Dashboard Layout -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Dashboard Layout</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">A responsive dashboard layout with stats cards at the top and a main content area below. Uses CSS Grid with <code>.so-grid-dashboard</code> preset.</p>

            <div class="layout-demo so-mb-4">
                <div class="so-grid-dashboard so-mb-4">
                    <div class="so-card">
                        <div class="so-card-body so-text-center">
                            <div class="so-fs-2xl so-fw-bold so-text-primary">1,234</div>
                            <div class="so-text-muted">Total Users</div>
                        </div>
                    </div>
                    <div class="so-card">
                        <div class="so-card-body so-text-center">
                            <div class="so-fs-2xl so-fw-bold so-text-success">$45,678</div>
                            <div class="so-text-muted">Revenue</div>
                        </div>
                    </div>
                    <div class="so-card">
                        <div class="so-card-body so-text-center">
                            <div class="so-fs-2xl so-fw-bold so-text-info">89%</div>
                            <div class="so-text-muted">Conversion</div>
                        </div>
                    </div>
                    <div class="so-card">
                        <div class="so-card-body so-text-center">
                            <div class="so-fs-2xl so-fw-bold so-text-warning">42</div>
                            <div class="so-text-muted">Pending</div>
                        </div>
                    </div>
                </div>
                <div class="so-row so-g-4">
                    <div class="so-col-lg-8">
                        <div class="so-card so-h-100">
                            <div class="so-card-header"><h5 class="so-card-title so-mb-0">Main Chart</h5></div>
                            <div class="so-card-body" style="min-height: 150px;">
                                <div class="so-d-flex so-align-items-center so-justify-content-center so-h-100 so-text-muted">
                                    Chart placeholder
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-lg-4">
                        <div class="so-card so-h-100">
                            <div class="so-card-header"><h5 class="so-card-title so-mb-0">Activity</h5></div>
                            <div class="so-card-body">
                                <div class="so-text-muted">Recent activity list...</div>
                            </div>
                        </div>
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
                <pre class="so-code-content"><code class="language-html">&lt;!-- Stats Cards - Auto-fit Grid --&gt;
&lt;div class="so-grid-dashboard"&gt;
  &lt;div class="so-card"&gt;...&lt;/div&gt;
  &lt;div class="so-card"&gt;...&lt;/div&gt;
  &lt;div class="so-card"&gt;...&lt;/div&gt;
  &lt;div class="so-card"&gt;...&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Main Content Area --&gt;
&lt;div class="so-row so-g-4"&gt;
  &lt;div class="so-col-lg-8"&gt;
    &lt;div class="so-card"&gt;Main Chart&lt;/div&gt;
  &lt;/div&gt;
  &lt;div class="so-col-lg-4"&gt;
    &lt;div class="so-card"&gt;Activity&lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Sidebar Layout -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Sidebar Layout</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Classic sidebar + main content layout using CSS Grid. The sidebar is fixed width on desktop and stacks on mobile.</p>

            <div class="layout-demo so-mb-4">
                <div class="so-grid-sidebar" style="min-height: 250px;">
                    <div class="demo-box">
                        Sidebar<br>(250px)
                    </div>
                    <div class="demo-box-alt">
                        Main Content<br>(Flexible)
                    </div>
                </div>
            </div>

            <h6 class="so-mb-3">Sidebar Right</h6>
            <div class="layout-demo so-mb-4">
                <div class="so-grid-sidebar-right" style="min-height: 250px;">
                    <div class="demo-box-alt">
                        Main Content<br>(Flexible)
                    </div>
                    <div class="demo-box">
                        Sidebar<br>(250px)
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
                <pre class="so-code-content"><code class="language-html">&lt;!-- Sidebar Left --&gt;
&lt;div class="so-grid-sidebar"&gt;
  &lt;aside&gt;Sidebar (250px)&lt;/aside&gt;
  &lt;main&gt;Main Content&lt;/main&gt;
&lt;/div&gt;

&lt;!-- Sidebar Right --&gt;
&lt;div class="so-grid-sidebar-right"&gt;
  &lt;main&gt;Main Content&lt;/main&gt;
  &lt;aside&gt;Sidebar (250px)&lt;/aside&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Holy Grail Layout -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Holy Grail Layout</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">The classic "Holy Grail" layout with header, footer, main content, and two sidebars. Fully responsive - stacks on mobile.</p>

            <div class="layout-demo layout-demo-tall so-mb-4">
                <div class="so-grid-holy-grail" style="min-height: 350px;">
                    <header style="grid-area: header;" class="demo-box">Header</header>
                    <nav style="grid-area: nav;" class="demo-box-success">Nav</nav>
                    <main style="grid-area: main;" class="demo-box-alt">Main Content</main>
                    <aside style="grid-area: aside;" class="demo-box-warning">Aside</aside>
                    <footer style="grid-area: footer;" class="demo-box">Footer</footer>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-grid-holy-grail"&gt;
  &lt;header style="grid-area: header;"&gt;Header&lt;/header&gt;
  &lt;nav style="grid-area: nav;"&gt;Navigation&lt;/nav&gt;
  &lt;main style="grid-area: main;"&gt;Main Content&lt;/main&gt;
  &lt;aside style="grid-area: aside;"&gt;Aside&lt;/aside&gt;
  &lt;footer style="grid-area: footer;"&gt;Footer&lt;/footer&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Card Grid Layout -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Responsive Card Grid</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Auto-fit cards that adjust based on container width. No media queries needed - uses CSS Grid <code>auto-fit</code>.</p>

            <div class="layout-demo so-mb-4">
                <div class="so-grid-auto-fit so-grid-gap-4" style="--so-grid-min-col: 200px;">
                    <div class="so-card">
                        <div class="so-card-body">
                            <h6 class="so-card-title">Card 1</h6>
                            <p class="so-text-muted so-mb-0">Auto-sizing card</p>
                        </div>
                    </div>
                    <div class="so-card">
                        <div class="so-card-body">
                            <h6 class="so-card-title">Card 2</h6>
                            <p class="so-text-muted so-mb-0">Auto-sizing card</p>
                        </div>
                    </div>
                    <div class="so-card">
                        <div class="so-card-body">
                            <h6 class="so-card-title">Card 3</h6>
                            <p class="so-text-muted so-mb-0">Auto-sizing card</p>
                        </div>
                    </div>
                    <div class="so-card">
                        <div class="so-card-body">
                            <h6 class="so-card-title">Card 4</h6>
                            <p class="so-text-muted so-mb-0">Auto-sizing card</p>
                        </div>
                    </div>
                    <div class="so-card">
                        <div class="so-card-body">
                            <h6 class="so-card-title">Card 5</h6>
                            <p class="so-text-muted so-mb-0">Auto-sizing card</p>
                        </div>
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
                <pre class="so-code-content"><code class="language-html">&lt;!-- Min column width: 200px, auto-adjusts --&gt;
&lt;div class="so-grid-auto-fit so-grid-gap-4" style="--so-grid-min-col: 200px;"&gt;
  &lt;div class="so-card"&gt;Card 1&lt;/div&gt;
  &lt;div class="so-card"&gt;Card 2&lt;/div&gt;
  &lt;div class="so-card"&gt;Card 3&lt;/div&gt;
  &lt;div class="so-card"&gt;Card 4&lt;/div&gt;
  &lt;div class="so-card"&gt;Card 5&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Two-Column Form Layout -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Two-Column Form Layout</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Common form layout with fields in two columns on desktop, stacking on mobile.</p>

            <div class="layout-demo so-mb-4">
                <div class="so-card">
                    <div class="so-card-header">
                        <h5 class="so-card-title so-mb-0">User Details</h5>
                    </div>
                    <div class="so-card-body">
                        <div class="so-row so-g-3">
                            <div class="so-col-md-6">
                                <div class="so-form-group">
                                    <label class="so-form-label">First Name</label>
                                    <input type="text" class="so-form-control" placeholder="John">
                                </div>
                            </div>
                            <div class="so-col-md-6">
                                <div class="so-form-group">
                                    <label class="so-form-label">Last Name</label>
                                    <input type="text" class="so-form-control" placeholder="Doe">
                                </div>
                            </div>
                            <div class="so-col-md-6">
                                <div class="so-form-group">
                                    <label class="so-form-label">Email</label>
                                    <input type="email" class="so-form-control" placeholder="john@example.com">
                                </div>
                            </div>
                            <div class="so-col-md-6">
                                <div class="so-form-group">
                                    <label class="so-form-label">Phone</label>
                                    <input type="tel" class="so-form-control" placeholder="+91 98765 43210">
                                </div>
                            </div>
                            <div class="so-col-12">
                                <div class="so-form-group">
                                    <label class="so-form-label">Address</label>
                                    <textarea class="so-form-control" rows="2" placeholder="Full address"></textarea>
                                </div>
                            </div>
                            <div class="so-col-md-4">
                                <div class="so-form-group">
                                    <label class="so-form-label">City</label>
                                    <input type="text" class="so-form-control" placeholder="Mumbai">
                                </div>
                            </div>
                            <div class="so-col-md-4">
                                <div class="so-form-group">
                                    <label class="so-form-label">State</label>
                                    <input type="text" class="so-form-control" placeholder="Maharashtra">
                                </div>
                            </div>
                            <div class="so-col-md-4">
                                <div class="so-form-group">
                                    <label class="so-form-label">PIN Code</label>
                                    <input type="text" class="so-form-control" placeholder="400001">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="so-card-footer so-d-flex so-justify-content-end so-gap-2">
                        <button class="so-btn so-btn-light">Cancel</button>
                        <button class="so-btn so-btn-primary">Save</button>
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
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-row so-g-3"&gt;
  &lt;div class="so-col-md-6"&gt;
    &lt;div class="so-form-group"&gt;
      &lt;label class="so-form-label"&gt;First Name&lt;/label&gt;
      &lt;input type="text" class="so-form-control"&gt;
    &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class="so-col-md-6"&gt;
    &lt;div class="so-form-group"&gt;
      &lt;label class="so-form-label"&gt;Last Name&lt;/label&gt;
      &lt;input type="text" class="so-form-control"&gt;
    &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class="so-col-12"&gt;
    &lt;div class="so-form-group"&gt;
      &lt;label class="so-form-label"&gt;Address&lt;/label&gt;
      &lt;textarea class="so-form-control"&gt;&lt;/textarea&gt;
    &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class="so-col-md-4"&gt;...&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Masonry-like Layout -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Masonry-like Layout</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">CSS Grid masonry-like layout using dense packing. Items fill available space efficiently.</p>

            <div class="layout-demo so-mb-4">
                <div class="so-grid-masonry">
                    <div class="so-card" style="grid-row: span 15;"><div class="so-card-body">Short</div></div>
                    <div class="so-card" style="grid-row: span 25;"><div class="so-card-body">Tall</div></div>
                    <div class="so-card" style="grid-row: span 20;"><div class="so-card-body">Medium</div></div>
                    <div class="so-card" style="grid-row: span 30;"><div class="so-card-body">Very Tall</div></div>
                    <div class="so-card" style="grid-row: span 18;"><div class="so-card-body">Medium</div></div>
                    <div class="so-card" style="grid-row: span 22;"><div class="so-card-body">Tall</div></div>
                </div>
            </div>

            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-grid-masonry"&gt;
  &lt;div class="so-card" style="grid-row: span 15;"&gt;Short&lt;/div&gt;
  &lt;div class="so-card" style="grid-row: span 25;"&gt;Tall&lt;/div&gt;
  &lt;div class="so-card" style="grid-row: span 20;"&gt;Medium&lt;/div&gt;
  &lt;div class="so-card" style="grid-row: span 30;"&gt;Very Tall&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    <!-- Pricing Table Layout -->
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Pricing Table Layout</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Common pricing table layout with equal-height cards using row-cols.</p>

            <div class="layout-demo so-mb-4">
                <div class="so-row so-row-cols-1 so-row-cols-md-3 so-g-4">
                    <div class="so-col">
                        <div class="so-card so-h-100 so-text-center">
                            <div class="so-card-header">
                                <h5 class="so-card-title so-mb-0">Basic</h5>
                            </div>
                            <div class="so-card-body">
                                <div class="so-fs-2xl so-fw-bold so-mb-3">$9<span class="so-fs-sm so-fw-normal so-text-muted">/mo</span></div>
                                <ul class="so-list-unstyled so-text-muted">
                                    <li class="so-mb-2">5 Users</li>
                                    <li class="so-mb-2">10GB Storage</li>
                                    <li class="so-mb-2">Email Support</li>
                                </ul>
                            </div>
                            <div class="so-card-footer">
                                <button class="so-btn so-btn-outline-primary so-w-100">Get Started</button>
                            </div>
                        </div>
                    </div>
                    <div class="so-col">
                        <div class="so-card so-h-100 so-text-center so-border-primary">
                            <div class="so-card-header so-bg-primary so-text-white">
                                <h5 class="so-card-title so-mb-0">Pro</h5>
                            </div>
                            <div class="so-card-body">
                                <div class="so-fs-2xl so-fw-bold so-mb-3">$29<span class="so-fs-sm so-fw-normal so-text-muted">/mo</span></div>
                                <ul class="so-list-unstyled so-text-muted">
                                    <li class="so-mb-2">25 Users</li>
                                    <li class="so-mb-2">100GB Storage</li>
                                    <li class="so-mb-2">Priority Support</li>
                                    <li class="so-mb-2">API Access</li>
                                </ul>
                            </div>
                            <div class="so-card-footer">
                                <button class="so-btn so-btn-primary so-w-100">Get Started</button>
                            </div>
                        </div>
                    </div>
                    <div class="so-col">
                        <div class="so-card so-h-100 so-text-center">
                            <div class="so-card-header">
                                <h5 class="so-card-title so-mb-0">Enterprise</h5>
                            </div>
                            <div class="so-card-body">
                                <div class="so-fs-2xl so-fw-bold so-mb-3">$99<span class="so-fs-sm so-fw-normal so-text-muted">/mo</span></div>
                                <ul class="so-list-unstyled so-text-muted">
                                    <li class="so-mb-2">Unlimited Users</li>
                                    <li class="so-mb-2">Unlimited Storage</li>
                                    <li class="so-mb-2">24/7 Support</li>
                                    <li class="so-mb-2">Custom Integration</li>
                                </ul>
                            </div>
                            <div class="so-card-footer">
                                <button class="so-btn so-btn-outline-primary so-w-100">Contact Us</button>
                            </div>
                        </div>
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
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-row so-row-cols-1 so-row-cols-md-3 so-g-4"&gt;
  &lt;div class="so-col"&gt;
    &lt;div class="so-card so-h-100 so-text-center"&gt;
      &lt;div class="so-card-header"&gt;Basic&lt;/div&gt;
      &lt;div class="so-card-body"&gt;$9/mo&lt;/div&gt;
      &lt;div class="so-card-footer"&gt;
        &lt;button class="so-btn so-btn-outline-primary"&gt;Get Started&lt;/button&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
  &lt;!-- More pricing cards... --&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
