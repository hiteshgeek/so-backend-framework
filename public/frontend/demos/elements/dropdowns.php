<?php
/**
 * SixOrbit UI Demo - Dropdowns
 */
$pageTitle = 'Dropdowns';
$pageDescription = 'Dropdown menu components';

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
            <h1 class="so-page-title">Dropdowns</h1>
            <p class="so-page-subtitle">Dropdown menu components</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Section 1: Basic Dropdowns -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Basic Dropdowns</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-3 so-grid-cols-md-2 so-grid-cols-sm-1" class="so-demo-grid-gap">

                            <!-- Standard Dropdown -->
                            <div class="so-form-group">
                                <label class="so-form-label">Standard Dropdown</label>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">Option 1</div>
                                        <div class="so-dropdown-item" data-value="2">Option 2</div>
                                        <div class="so-dropdown-item" data-value="3">Option 3</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Searchable Dropdown -->
                            <div class="so-form-group">
                                <label class="so-form-label">Searchable Dropdown</label>
                                <div class="so-dropdown so-dropdown-searchable" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Search & Select</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-search">
                                            <input type="text" class="so-dropdown-search-input" placeholder="Search...">
                                        </div>
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="1">Apple</div>
                                            <div class="so-dropdown-item" data-value="2">Banana</div>
                                            <div class="so-dropdown-item" data-value="3">Cherry</div>
                                            <div class="so-dropdown-item" data-value="4">Date</div>
                                            <div class="so-dropdown-item" data-value="5">Elderberry</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Options Dropdown (Action Menu) -->
                            <div class="so-form-group">
                                <label class="so-form-label">Options Dropdown</label>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-btn-icon so-dropdown-trigger">
                                        <span class="material-icons">more_vert</span>
                                    </button>
                                    <div class="so-dropdown-menu so-dropdown-menu-end">
                                        <div class="so-dropdown-item" data-action="edit">
                                            <span class="material-icons">edit</span>
                                            <span>Edit</span>
                                        </div>
                                        <div class="so-dropdown-item" data-action="duplicate">
                                            <span class="material-icons">content_copy</span>
                                            <span>Duplicate</span>
                                        </div>
                                        <div class="so-dropdown-divider"></div>
                                        <div class="so-dropdown-item so-dropdown-item-danger" data-action="delete">
                                            <span class="material-icons">delete</span>
                                            <span>Delete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- Standard Dropdown --&gt;
&lt;div class="so-dropdown" data-so-dropdown&gt;
    &lt;button type="button" class="so-btn so-btn-light so-dropdown-trigger"&gt;
        &lt;span class="so-dropdown-selected"&gt;Select option&lt;/span&gt;
        &lt;span class="material-icons so-dropdown-arrow"&gt;expand_more&lt;/span&gt;
    &lt;/button&gt;
    &lt;div class="so-dropdown-menu"&gt;
        &lt;div class="so-dropdown-item" data-value="1"&gt;Option 1&lt;/div&gt;
        &lt;div class="so-dropdown-item" data-value="2"&gt;Option 2&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Searchable Dropdown --&gt;
&lt;div class="so-dropdown so-dropdown-searchable" data-so-dropdown&gt;
    &lt;button type="button" class="so-btn so-btn-light so-dropdown-trigger"&gt;
        &lt;span class="so-dropdown-selected"&gt;Search &amp; Select&lt;/span&gt;
        &lt;span class="material-icons so-dropdown-arrow"&gt;expand_more&lt;/span&gt;
    &lt;/button&gt;
    &lt;div class="so-dropdown-menu"&gt;
        &lt;div class="so-dropdown-search"&gt;
            &lt;input type="text" class="so-dropdown-search-input" placeholder="Search..."&gt;
        &lt;/div&gt;
        &lt;div class="so-dropdown-items"&gt;
            &lt;div class="so-dropdown-item" data-value="1"&gt;Apple&lt;/div&gt;
            &lt;div class="so-dropdown-item" data-value="2"&gt;Banana&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Options/Action Dropdown --&gt;
&lt;div class="so-dropdown" data-so-dropdown&gt;
    &lt;button type="button" class="so-btn so-btn-light so-btn-icon so-dropdown-trigger"&gt;
        &lt;span class="material-icons"&gt;more_vert&lt;/span&gt;
    &lt;/button&gt;
    &lt;div class="so-dropdown-menu so-dropdown-menu-end"&gt;
        &lt;div class="so-dropdown-item" data-action="edit"&gt;
            &lt;span class="material-icons"&gt;edit&lt;/span&gt;
            &lt;span&gt;Edit&lt;/span&gt;
        &lt;/div&gt;
        &lt;div class="so-dropdown-divider"&gt;&lt;/div&gt;
        &lt;div class="so-dropdown-item so-dropdown-item-danger" data-action="delete"&gt;
            &lt;span class="material-icons"&gt;delete&lt;/span&gt;
            &lt;span&gt;Delete&lt;/span&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Menu Content Types -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Menu Content Types</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1" class="so-demo-grid-gap">

                            <!-- Headers & Dividers -->
                            <div class="so-form-group">
                                <label class="so-form-label">Headers & Dividers</label>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select category</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-header">Fruits</div>
                                        <div class="so-dropdown-item" data-value="apple">Apple</div>
                                        <div class="so-dropdown-item" data-value="banana">Banana</div>
                                        <div class="so-dropdown-divider"></div>
                                        <div class="so-dropdown-header">Vegetables</div>
                                        <div class="so-dropdown-item" data-value="carrot">Carrot</div>
                                        <div class="so-dropdown-item" data-value="broccoli">Broccoli</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Icons with Items -->
                            <div class="so-form-group">
                                <label class="so-form-label">Icons with Items</label>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select action</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="new">
                                            <span class="material-icons">add</span>
                                            New File
                                        </div>
                                        <div class="so-dropdown-item" data-value="open">
                                            <span class="material-icons">folder_open</span>
                                            Open
                                        </div>
                                        <div class="so-dropdown-item" data-value="save">
                                            <span class="material-icons">save</span>
                                            Save
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Disabled Items -->
                            <div class="so-form-group">
                                <label class="so-form-label">Disabled Items</label>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">Available Option</div>
                                        <div class="so-dropdown-item so-disabled" data-value="2">Unavailable (disabled)</div>
                                        <div class="so-dropdown-item" data-value="3">Another Option</div>
                                        <div class="so-dropdown-item so-disabled" data-value="4">Also Disabled</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Active/Selected State -->
                            <div class="so-form-group">
                                <label class="so-form-label">Active/Selected State</label>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Option 2</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">Option 1</div>
                                        <div class="so-dropdown-item so-active" data-value="2">
                                            Option 2
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="3">Option 3</div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- Headers & Dividers --&gt;
&lt;div class="so-dropdown-menu"&gt;
    &lt;div class="so-dropdown-header"&gt;Category&lt;/div&gt;
    &lt;div class="so-dropdown-item"&gt;Item 1&lt;/div&gt;
    &lt;div class="so-dropdown-divider"&gt;&lt;/div&gt;
    &lt;div class="so-dropdown-item"&gt;Item 2&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Icons with Items --&gt;
&lt;div class="so-dropdown-item"&gt;
    &lt;span class="material-icons"&gt;edit&lt;/span&gt;
    Edit
&lt;/div&gt;

&lt;!-- Disabled Items --&gt;
&lt;div class="so-dropdown-item disabled"&gt;Unavailable&lt;/div&gt;

&lt;!-- Active/Selected with Checkmark --&gt;
&lt;div class="so-dropdown-item active"&gt;
    Selected Option
    &lt;span class="material-icons so-dropdown-check"&gt;check&lt;/span&gt;
&lt;/div&gt;</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Direction & Alignment Variants</h3>
                    </div>
                    <div class="so-card-body">

                        <h4 class="so-demo-section-heading">Dropdown Directions</h4>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">

                            <!-- Dropdown (default) -->
                            <div class="so-dropdown" data-so-dropdown>
                                <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                    <span class="so-dropdown-selected">Dropdown</span>
                                    <span class="material-icons so-dropdown-arrow">expand_more</span>
                                </button>
                                <div class="so-dropdown-menu">
                                    <div class="so-dropdown-item">Action 1</div>
                                    <div class="so-dropdown-item">Action 2</div>
                                </div>
                            </div>

                            <!-- Dropup -->
                            <div class="so-dropdown so-dropup" data-so-dropdown>
                                <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                    <span class="so-dropdown-selected">Dropup</span>
                                    <span class="material-icons so-dropdown-arrow">expand_less</span>
                                </button>
                                <div class="so-dropdown-menu">
                                    <div class="so-dropdown-item">Action 1</div>
                                    <div class="so-dropdown-item">Action 2</div>
                                </div>
                            </div>

                            <!-- Dropstart -->
                            <div class="so-dropdown so-dropstart" data-so-dropdown>
                                <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                    <span class="material-icons">chevron_left</span>
                                    <span class="so-dropdown-selected">Dropstart</span>
                                </button>
                                <div class="so-dropdown-menu">
                                    <div class="so-dropdown-item">Action 1</div>
                                    <div class="so-dropdown-item">Action 2</div>
                                </div>
                            </div>

                            <!-- Dropend -->
                            <div class="so-dropdown so-dropend" data-so-dropdown>
                                <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                    <span class="so-dropdown-selected">Dropend</span>
                                    <span class="material-icons">chevron_right</span>
                                </button>
                                <div class="so-dropdown-menu">
                                    <div class="so-dropdown-item">Action 1</div>
                                    <div class="so-dropdown-item">Action 2</div>
                                </div>
                            </div>

                        </div>

                        <h4 class="so-demo-section-heading">Menu Alignment</h4>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">

                            <!-- Left aligned (default) -->
                            <div class="so-dropdown" data-so-dropdown>
                                <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                    <span class="so-dropdown-selected">Left Aligned</span>
                                    <span class="material-icons so-dropdown-arrow">expand_more</span>
                                </button>
                                <div class="so-dropdown-menu">
                                    <div class="so-dropdown-item">This menu is left-aligned</div>
                                    <div class="so-dropdown-item">Default behavior</div>
                                </div>
                            </div>

                            <!-- Right aligned -->
                            <div class="so-dropdown so-dropdown-menu-end" data-so-dropdown>
                                <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                    <span class="so-dropdown-selected">Right Aligned</span>
                                    <span class="material-icons so-dropdown-arrow">expand_more</span>
                                </button>
                                <div class="so-dropdown-menu">
                                    <div class="so-dropdown-item">This menu is right-aligned</div>
                                    <div class="so-dropdown-item">Use .so-dropdown-menu-end</div>
                                </div>
                            </div>

                        </div>

                        <h4 class="so-demo-section-heading">Size Variants</h4>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-end">

                            <!-- Small -->
                            <div class="so-dropdown so-dropdown-sm" data-so-dropdown>
                                <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                    <span class="so-dropdown-selected">Small</span>
                                    <span class="material-icons so-dropdown-arrow">expand_more</span>
                                </button>
                                <div class="so-dropdown-menu">
                                    <div class="so-dropdown-item">Small Option 1</div>
                                    <div class="so-dropdown-item">Small Option 2</div>
                                </div>
                            </div>

                            <!-- Default -->
                            <div class="so-dropdown" data-so-dropdown>
                                <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                    <span class="so-dropdown-selected">Default</span>
                                    <span class="material-icons so-dropdown-arrow">expand_more</span>
                                </button>
                                <div class="so-dropdown-menu">
                                    <div class="so-dropdown-item">Default Option 1</div>
                                    <div class="so-dropdown-item">Default Option 2</div>
                                </div>
                            </div>

                            <!-- Large -->
                            <div class="so-dropdown so-dropdown-lg" data-so-dropdown>
                                <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                    <span class="so-dropdown-selected">Large</span>
                                    <span class="material-icons so-dropdown-arrow">expand_more</span>
                                </button>
                                <div class="so-dropdown-menu">
                                    <div class="so-dropdown-item">Large Option 1</div>
                                    <div class="so-dropdown-item">Large Option 2</div>
                                </div>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- Dropup (opens above) --&gt;
&lt;div class="so-dropdown so-dropup" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Dropstart (opens left) --&gt;
&lt;div class="so-dropdown so-dropstart" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Dropend (opens right) --&gt;
&lt;div class="so-dropdown so-dropend" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Right-aligned menu --&gt;
&lt;div class="so-dropdown so-dropdown-menu-end" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Size variants --&gt;
&lt;div class="so-dropdown so-dropdown-sm" data-so-dropdown&gt;...&lt;/div&gt;
&lt;div class="so-dropdown so-dropdown-lg" data-so-dropdown&gt;...&lt;/div&gt;</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Behaviors -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Auto-Close Behaviors</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Control how the dropdown closes with the <code>data-so-auto-close</code> attribute.
                        </p>

                        <div class="so-grid so-grid-cols-4 so-grid-cols-md-2 so-grid-cols-sm-1" class="so-demo-grid-gap-sm">

                            <!-- autoClose: true (default) -->
                            <div>
                                <div class="so-dropdown" data-so-dropdown data-so-auto-close="true">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">true (default)</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item-text">Closes on any click</div>
                                        <div class="so-dropdown-divider"></div>
                                        <div class="so-dropdown-item">Click me</div>
                                        <div class="so-dropdown-item">Or me</div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Closes on any click</small>
                            </div>

                            <!-- autoClose: 'inside' -->
                            <div>
                                <div class="so-dropdown" data-so-dropdown data-so-auto-close="inside">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">inside</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item-text">Only closes on inside click</div>
                                        <div class="so-dropdown-divider"></div>
                                        <div class="so-dropdown-item">Click me to close</div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Only closes on item click</small>
                            </div>

                            <!-- autoClose: 'outside' -->
                            <div>
                                <div class="so-dropdown" data-so-dropdown data-so-auto-close="outside">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">outside</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item-text">Only closes on outside click</div>
                                        <div class="so-dropdown-divider"></div>
                                        <div class="so-dropdown-item">Click won't close</div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Only closes on outside click</small>
                            </div>

                            <!-- autoClose: false -->
                            <div>
                                <div class="so-dropdown" data-so-dropdown data-so-auto-close="false">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">false</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item-text">Manual close only (Esc or toggle)</div>
                                        <div class="so-dropdown-divider"></div>
                                        <div class="so-dropdown-item">Nothing closes me</div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Use Escape or toggle button</small>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- autoClose: true (default) - closes on any click --&gt;
&lt;div class="so-dropdown" data-so-dropdown data-so-auto-close="true"&gt;...&lt;/div&gt;

&lt;!-- autoClose: inside - only closes when clicking menu items --&gt;
&lt;div class="so-dropdown" data-so-dropdown data-so-auto-close="inside"&gt;...&lt;/div&gt;

&lt;!-- autoClose: outside - only closes when clicking outside --&gt;
&lt;div class="so-dropdown" data-so-dropdown data-so-auto-close="outside"&gt;...&lt;/div&gt;

&lt;!-- autoClose: false - only closes via Escape key or programmatically --&gt;
&lt;div class="so-dropdown" data-so-dropdown data-so-auto-close="false"&gt;...&lt;/div&gt;</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 5: JavaScript API -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">JavaScript API</h3>
                    </div>
                    <div class="so-card-body">

                        <h4 class="so-demo-section-heading">Event Listeners Demo</h4>
                        <div class="so-flex so-gap-4 so-items-start so-mb-4">
                            <div class="so-dropdown" id="demo-events-dropdown" data-so-dropdown>
                                <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                    <span class="so-dropdown-selected">Select to see events</span>
                                    <span class="material-icons so-dropdown-arrow">expand_more</span>
                                </button>
                                <div class="so-dropdown-menu">
                                    <div class="so-dropdown-item" data-value="1">Option 1</div>
                                    <div class="so-dropdown-item" data-value="2">Option 2</div>
                                    <div class="so-dropdown-item" data-value="3">Option 3</div>
                                </div>
                            </div>

                            <div class="so-demo-event-output">
                                <span class="material-icons" class="so-demo-terminal-icon">terminal</span>
                                Events are logged to browser console (F12)
                            </div>
                        </div>

                        <h4 class="so-demo-section-heading so-mt-6">Programmatic Control</h4>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-3">
                            <button class="so-btn so-btn-outline" onclick="window.demoDropdown && demoDropdown.open()">
                                <span class="material-icons">expand_more</span>
                                Open
                            </button>
                            <button class="so-btn so-btn-outline" onclick="window.demoDropdown && demoDropdown.close()">
                                <span class="material-icons">expand_less</span>
                                Close
                            </button>
                            <button class="so-btn so-btn-outline" onclick="window.demoDropdown && demoDropdown.toggle()">
                                <span class="material-icons">swap_vert</span>
                                Toggle
                            </button>
                            <button class="so-btn so-btn-outline" onclick="window.demoDropdown && demoDropdown.select('2', 'Option 2')">
                                <span class="material-icons">check</span>
                                Select Option 2
                            </button>
                            <button class="so-btn so-btn-outline" onclick="alert('Value: ' + (window.demoDropdown ? demoDropdown.getValue() : 'N/A'))">
                                <span class="material-icons">info</span>
                                Get Value
                            </button>
                        </div>

                        <h4 class="so-demo-section-heading">Enable/Disable Demo</h4>
                        <div class="so-flex so-gap-4 so-items-center">
                            <div class="so-dropdown" id="demo-disable-dropdown" data-so-dropdown>
                                <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                    <span class="so-dropdown-selected">Enable/Disable Me</span>
                                    <span class="material-icons so-dropdown-arrow">expand_more</span>
                                </button>
                                <div class="so-dropdown-menu">
                                    <div class="so-dropdown-item" data-value="1">Option 1</div>
                                    <div class="so-dropdown-item" data-value="2">Option 2</div>
                                </div>
                            </div>

                            <button class="so-btn so-btn-outline-danger" onclick="window.disableDropdown && disableDropdown.disable()">Disable</button>
                            <button class="so-btn so-btn-outline-success" onclick="window.disableDropdown && disableDropdown.enable()">Enable</button>
                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> JavaScript</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-javascript">// Get dropdown instance
const dropdown = SODropdown.getInstance('#my-dropdown');

// Listen for events
dropdown.element.addEventListener('so:dropdown:show', (e) => {
  console.log('Dropdown is about to open');
  // e.preventDefault(); // Cancel opening
});

dropdown.element.addEventListener('so:dropdown:shown', () => {
  console.log('Dropdown is now open');
});

dropdown.element.addEventListener('so:dropdown:change', (e) => {
  console.log('Selected:', e.detail.value, e.detail.text);
});

// Programmatic control
dropdown.open();
dropdown.close();
dropdown.toggle();
dropdown.select('value', 'Display Text');
dropdown.getValue(); // Returns current value
dropdown.disable();
dropdown.enable();
dropdown.setItemDisabled('value', true); // Disable specific item</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 6: Split Button Dropdown -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Split Button Dropdown</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Combine a primary action button with a dropdown for additional options.
                        </p>

                        <div class="so-flex so-gap-4 so-flex-wrap">

                            <!-- Primary Split Button -->
                            <div class="so-btn-group">
                                <button class="so-btn so-btn-primary">Save</button>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-dropdown-trigger so-btn so-btn-primary">
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-action="save-draft">Save as Draft</div>
                                        <div class="so-dropdown-item" data-action="save-publish">Save & Publish</div>
                                        <div class="so-dropdown-item" data-action="save-copy">Save as Copy</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Success Split Button -->
                            <div class="so-btn-group">
                                <button class="so-btn so-btn-success">
                                    <span class="material-icons">download</span>
                                    Export
                                </button>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-dropdown-trigger so-btn so-btn-success">
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item">Export as CSV</div>
                                        <div class="so-dropdown-item">Export as Excel</div>
                                        <div class="so-dropdown-item">Export as PDF</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Outline Split Button -->
                            <div class="so-btn-group">
                                <button class="so-btn so-btn-outline">Actions</button>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-dropdown-trigger so-btn so-btn-outline">
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item">Action 1</div>
                                        <div class="so-dropdown-item">Action 2</div>
                                        <div class="so-dropdown-divider"></div>
                                        <div class="so-dropdown-item" class="so-dropdown-item-danger">Delete</div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;div class="so-btn-group"&gt;
    &lt;button class="so-btn so-btn-primary"&gt;Save&lt;/button&gt;
    &lt;div class="so-dropdown" data-so-dropdown&gt;
        &lt;button type="button" class="so-dropdown-trigger so-btn so-btn-primary"&gt;
            &lt;span class="material-icons so-dropdown-arrow"&gt;expand_more&lt;/span&gt;
        &lt;/button&gt;
        &lt;div class="so-dropdown-menu"&gt;
            &lt;div class="so-dropdown-item"&gt;Save as Draft&lt;/div&gt;
            &lt;div class="so-dropdown-item"&gt;Save &amp; Publish&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 7: Selection Styles -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Selection Styles</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Control how selected items are displayed with the <code>data-so-selection-style</code> attribute.
                        </p>

                        <div class="so-grid so-grid-cols-3 so-grid-cols-md-2 so-grid-cols-sm-1" class="so-demo-grid-gap">

                            <!-- Default: Background + Check -->
                            <div class="so-form-group">
                                <label class="so-form-label">Default (background + check)</label>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">
                                            Option 1
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="2">
                                            Option 2
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="3">
                                            Option 3
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Background highlight + checkmark</small>
                            </div>

                            <!-- Highlight Only -->
                            <div class="so-form-group">
                                <label class="so-form-label">Highlight Only</label>
                                <div class="so-dropdown" data-so-dropdown data-so-selection-style="highlight">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">Option 1</div>
                                        <div class="so-dropdown-item" data-value="2">Option 2</div>
                                        <div class="so-dropdown-item" data-value="3">Option 3</div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Background highlight only, no checkmark</small>
                            </div>

                            <!-- Check Only -->
                            <div class="so-form-group">
                                <label class="so-form-label">Check Only</label>
                                <div class="so-dropdown" data-so-dropdown data-so-selection-style="check">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">
                                            Option 1
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="2">
                                            Option 2
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="3">
                                            Option 3
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Checkmark only, no background</small>
                            </div>

                            <!-- Custom Icon -->
                            <div class="so-form-group">
                                <label class="so-form-label">Custom Icon (star)</label>
                                <div class="so-dropdown" data-so-dropdown data-so-selection-style="check">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select favorite</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="pizza">
                                            <span class="material-icons">local_pizza</span>
                                            Pizza
                                            <span class="material-icons so-dropdown-check">star</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="burger">
                                            <span class="material-icons">lunch_dining</span>
                                            Burger
                                            <span class="material-icons so-dropdown-check">star</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="sushi">
                                            <span class="material-icons">set_meal</span>
                                            Sushi
                                            <span class="material-icons so-dropdown-check">star</span>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Use any icon for selection indicator</small>
                            </div>

                            <!-- With Item Icons -->
                            <div class="so-form-group">
                                <label class="so-form-label">Items with Icons</label>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select status</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="active">
                                            <span class="material-icons" class="so-selection-icon-success">check_circle</span>
                                            Active
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="pending">
                                            <span class="material-icons" class="so-selection-icon-warning">schedule</span>
                                            Pending
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="inactive">
                                            <span class="material-icons" class="so-dropdown-item-danger">cancel</span>
                                            Inactive
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Icons on left, checkmark on right</small>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- Default: background + check (no attribute needed) --&gt;
&lt;div class="so-dropdown" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Highlight only: just background color --&gt;
&lt;div class="so-dropdown" data-so-dropdown data-so-selection-style="highlight"&gt;...&lt;/div&gt;

&lt;!-- Check only: just checkmark, no background --&gt;
&lt;div class="so-dropdown" data-so-dropdown data-so-selection-style="check"&gt;...&lt;/div&gt;

&lt;!-- Custom selection icon (use any Material Icon) --&gt;
&lt;div class="so-dropdown-item" data-value="pizza"&gt;
    &lt;span class="material-icons"&gt;local_pizza&lt;/span&gt;
    Pizza
    &lt;span class="material-icons so-dropdown-check"&gt;star&lt;/span&gt;
&lt;/div&gt;

&lt;!-- Item with colored icon --&gt;
&lt;div class="so-dropdown-item" data-value="active"&gt;
    &lt;span class="material-icons" class="so-selection-icon-success"&gt;check_circle&lt;/span&gt;
    Active
    &lt;span class="material-icons so-dropdown-check"&gt;check&lt;/span&gt;
&lt;/div&gt;</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 8: Multiple Selection -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Multiple Selection</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Enable multiple selection with <code>data-so-multiple</code>. Add <code>data-so-show-actions</code> for All/None links. Optionally limit selections with <code>data-so-max-selections</code>.
                        </p>

                        <div class="so-grid so-grid-cols-3 so-grid-cols-md-2 so-grid-cols-sm-1" class="so-demo-grid-gap">

                            <!-- Multiple with All/None actions -->
                            <div class="so-form-group">
                                <label class="so-form-label">With All/None Actions</label>
                                <div class="so-dropdown so-dropdown-searchable" data-so-dropdown data-so-multiple="true" data-so-show-actions="true">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected placeholder">Select items</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-search">
                                            <input type="text" class="so-dropdown-search-input" placeholder="Search...">
                                        </div>
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="apple">Apple</div>
                                            <div class="so-dropdown-item" data-value="banana">Banana</div>
                                            <div class="so-dropdown-item" data-value="cherry">Cherry</div>
                                            <div class="so-dropdown-item" data-value="date">Date</div>
                                            <div class="so-dropdown-item" data-value="elderberry">Elderberry</div>
                                            <div class="so-dropdown-item" data-value="fig">Fig</div>
                                            <div class="so-dropdown-item" data-value="grape">Grape</div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Click All/None to quick select</small>
                            </div>

                            <!-- Multiple Selection (Checkbox style) -->
                            <div class="so-form-group">
                                <label class="so-form-label">Multiple (checkbox style)</label>
                                <div class="so-dropdown so-dropdown-searchable" data-so-dropdown data-so-multiple="true">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected placeholder">Select items</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-search">
                                            <input type="text" class="so-dropdown-search-input" placeholder="Search...">
                                        </div>
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="red">Red</div>
                                            <div class="so-dropdown-item" data-value="green">Green</div>
                                            <div class="so-dropdown-item" data-value="blue">Blue</div>
                                            <div class="so-dropdown-item" data-value="yellow">Yellow</div>
                                            <div class="so-dropdown-item" data-value="purple">Purple</div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Click multiple items to select</small>
                            </div>

                            <!-- Multiple with Max Selections -->
                            <div class="so-form-group">
                                <label class="so-form-label">Max 3 Selections</label>
                                <div class="so-dropdown so-dropdown-searchable" data-so-dropdown data-so-multiple="true" data-so-max-selections="3">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected placeholder">Select up to 3</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-search">
                                            <input type="text" class="so-dropdown-search-input" placeholder="Search...">
                                        </div>
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="pizza">Pizza</div>
                                            <div class="so-dropdown-item" data-value="burger">Burger</div>
                                            <div class="so-dropdown-item" data-value="pasta">Pasta</div>
                                            <div class="so-dropdown-item" data-value="sushi">Sushi</div>
                                            <div class="so-dropdown-item" data-value="tacos">Tacos</div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Limited to maximum 3 selections</small>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- Multiple selection with All/None actions --&gt;
&lt;div class="so-dropdown so-dropdown-searchable" data-so-dropdown
     data-so-multiple="true"
     data-so-show-actions="true"&gt;
    &lt;button class="so-btn so-btn-light so-dropdown-trigger"&gt;...&lt;/button&gt;
    &lt;div class="so-dropdown-menu"&gt;...&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Custom action text --&gt;
&lt;div class="so-dropdown so-dropdown-searchable" data-so-dropdown
     data-so-multiple="true"
     data-so-show-actions="true"
     data-so-select-all-text="Select All"
     data-so-select-none-text="Clear"&gt;
    ...
&lt;/div&gt;

&lt;!-- Multiple with max selections --&gt;
&lt;div class="so-dropdown so-dropdown-searchable" data-so-dropdown
     data-so-multiple="true"
     data-so-max-selections="3"&gt;
    ...
&lt;/div&gt;

&lt;!-- JavaScript API for multiple selection --&gt;
&lt;script&gt;
const dropdown = SODropdown.getInstance('#my-dropdown');
dropdown.selectAll();       // Select all items
dropdown.selectNone();      // Deselect all items
dropdown.getValues();       // ['apple', 'banana']
dropdown.getTexts();        // ['Apple', 'Banana']
dropdown.clearSelection();  // Clear all selections
&lt;/script&gt;</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 8b: Minimum Selection & Custom Text -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Minimum Selection & Custom Display Text</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Use <code>data-so-min-selections</code> to require at least N items selected (the last item cannot be deselected).
                            Customize display text with <code>data-so-all-selected-text</code> and <code>data-so-multiple-selected-text</code>.
                        </p>

                        <div class="so-grid so-grid-cols-3 so-grid-cols-md-2 so-grid-cols-sm-1" class="so-demo-grid-gap">

                            <!-- Min 1 Selection (like outlet selector) -->
                            <div class="so-form-group">
                                <label class="so-form-label">Min 1 Selection Required</label>
                                <div class="so-dropdown so-dropdown-searchable" data-so-dropdown
                                    data-so-multiple="true"
                                    data-so-min-selections="1"
                                    data-so-show-actions="true"
                                    data-so-select-none-text=""
                                    data-so-all-selected-text="All Outlets"
                                    data-so-multiple-selected-text="{count} Outlets">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="material-icons">storefront</span>
                                        <span class="so-dropdown-selected">All Outlets</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-search">
                                            <input type="text" class="so-dropdown-search-input" placeholder="Search outlets...">
                                        </div>
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item so-active" data-value="head-office">
                                                Head Office
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item so-active" data-value="downtown">
                                                Downtown Branch
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item so-active" data-value="mall">
                                                Mall Location
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item so-active" data-value="airport">
                                                Airport Store
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">At least 1 must remain selected</small>
                            </div>

                            <!-- Min 2 Selections -->
                            <div class="so-form-group">
                                <label class="so-form-label">Min 2 Selections Required</label>
                                <div class="so-dropdown so-dropdown-searchable" data-so-dropdown
                                    data-so-multiple="true"
                                    data-so-min-selections="2"
                                    data-so-all-selected-text="All Categories"
                                    data-so-multiple-selected-text="{count} Categories">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="material-icons">category</span>
                                        <span class="so-dropdown-selected">All Categories</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item so-active" data-value="electronics">
                                                Electronics
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item so-active" data-value="clothing">
                                                Clothing
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item so-active" data-value="food">
                                                Food & Beverages
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item so-active" data-value="home">
                                                Home & Garden
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">At least 2 must remain selected</small>
                            </div>

                            <!-- Custom Display Text -->
                            <div class="so-form-group">
                                <label class="so-form-label">Custom Display Text</label>
                                <div class="so-dropdown so-dropdown-searchable" data-so-dropdown
                                    data-so-multiple="true"
                                    data-so-show-actions="true"
                                    data-so-all-selected-text="All Team Members"
                                    data-so-multiple-selected-text="{count} people assigned">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="material-icons">group</span>
                                        <span class="so-dropdown-selected placeholder">Assign team</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="john">John Doe</div>
                                            <div class="so-dropdown-item" data-value="jane">Jane Smith</div>
                                            <div class="so-dropdown-item" data-value="bob">Bob Wilson</div>
                                            <div class="so-dropdown-item" data-value="alice">Alice Brown</div>
                                            <div class="so-dropdown-item" data-value="charlie">Charlie Davis</div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Shows "X people assigned" or "All Team Members"</small>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- Minimum 1 selection required (outlet selector style) --&gt;
&lt;div class="so-dropdown so-dropdown-searchable" data-so-dropdown
     data-so-multiple="true"
     data-so-min-selections="1"
     data-so-show-actions="true"
     data-so-select-none-text=""
     data-so-all-selected-text="All Outlets"
     data-so-multiple-selected-text="{count} Outlets"&gt;
    &lt;button class="so-btn so-btn-light so-dropdown-trigger"&gt;
        &lt;span class="material-icons"&gt;storefront&lt;/span&gt;
        &lt;span class="so-dropdown-selected"&gt;All Outlets&lt;/span&gt;
        &lt;span class="material-icons so-dropdown-arrow"&gt;expand_more&lt;/span&gt;
    &lt;/button&gt;
    &lt;div class="so-dropdown-menu"&gt;
        &lt;div class="so-dropdown-items"&gt;
            &lt;div class="so-dropdown-item active" data-value="hq"&gt;
                Head Office
                &lt;span class="material-icons so-dropdown-check"&gt;check&lt;/span&gt;
            &lt;/div&gt;
            &lt;!-- More items... --&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Configuration options explained --&gt;
&lt;!-- data-so-min-selections="1"         - At least 1 item must stay selected --&gt;
&lt;!-- data-so-select-none-text=""        - Hides the "None" action link --&gt;
&lt;!-- data-so-all-selected-text="..."    - Text when all items are selected --&gt;
&lt;!-- data-so-multiple-selected-text="..." - Template for multiple selections ({count} is replaced) --&gt;</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 8c: Multiple Selection Styles -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Multiple Selection Styles</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Use <code>data-so-multiple-style</code> to control how selected items are displayed.
                            Use <code>"checkbox"</code> (default) for checkbox boxes, or <code>"check"</code> for checkmark icons only.
                        </p>

                        <div class="so-grid so-grid-cols-2 so-grid-cols-md-1" class="so-demo-grid-gap">

                            <!-- Checkbox Style (default) - with pre-selected items -->
                            <div class="so-form-group">
                                <label class="so-form-label">Checkbox Style (default)</label>
                                <div class="so-dropdown" data-so-dropdown
                                    data-so-multiple="true"
                                    data-so-multiple-style="checkbox"
                                    data-so-show-actions="true">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="material-icons">label</span>
                                        <span class="so-dropdown-selected">2 selected</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item so-active" data-value="important">Important</div>
                                            <div class="so-dropdown-item so-active" data-value="urgent">Urgent</div>
                                            <div class="so-dropdown-item" data-value="review">Needs Review</div>
                                            <div class="so-dropdown-item" data-value="approved">Approved</div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Shows checkbox boxes with checkmarks</small>
                            </div>

                            <!-- Check Style (icon only) - with pre-selected items -->
                            <div class="so-form-group">
                                <label class="so-form-label">Check Style (icon only)</label>
                                <div class="so-dropdown" data-so-dropdown
                                    data-so-multiple="true"
                                    data-so-multiple-style="check"
                                    data-so-show-actions="true"
                                    data-so-select-none-text="">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="material-icons">flag</span>
                                        <span class="so-dropdown-selected">2 selected</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item so-active" data-value="high">
                                                High Priority
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item so-active" data-value="medium">
                                                Medium Priority
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item" data-value="low">
                                                Low Priority
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item" data-value="none">
                                                No Priority
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Shows checkmark icons only (no checkbox boxes), "None" action hidden</small>
                            </div>

                            <!-- Check Style with Min Selection -->
                            <div class="so-form-group">
                                <label class="so-form-label">Check Style + Min Selection</label>
                                <div class="so-dropdown so-dropdown-searchable" data-so-dropdown
                                    data-so-multiple="true"
                                    data-so-multiple-style="check"
                                    data-so-min-selections="1"
                                    data-so-show-actions="true"
                                    data-so-select-none-text=""
                                    data-so-all-selected-text="All Locations"
                                    data-so-multiple-selected-text="{count} Locations">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="material-icons">location_on</span>
                                        <span class="so-dropdown-selected">All Locations</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-search">
                                            <input type="text" class="so-dropdown-search-input" placeholder="Search locations...">
                                        </div>
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item so-active" data-value="new-york">
                                                New York
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item so-active" data-value="los-angeles">
                                                Los Angeles
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item so-active" data-value="chicago">
                                                Chicago
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                            <div class="so-dropdown-item so-active" data-value="houston">
                                                Houston
                                                <span class="material-icons so-dropdown-check">check</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Outlet selector style with check icons</small>
                            </div>

                            <!-- Checkbox Style with Show Actions (All/None) -->
                            <div class="so-form-group">
                                <label class="so-form-label">Checkbox with All/None Actions</label>
                                <div class="so-dropdown" data-so-dropdown
                                    data-so-multiple="true"
                                    data-so-multiple-style="checkbox"
                                    data-so-show-actions="true">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="material-icons">folder</span>
                                        <span class="so-dropdown-selected placeholder">Select folders</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="documents">Documents</div>
                                            <div class="so-dropdown-item" data-value="images">Images</div>
                                            <div class="so-dropdown-item" data-value="videos">Videos</div>
                                            <div class="so-dropdown-item" data-value="archives">Archives</div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Shows "All" and "None" action links</small>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- Checkbox style (default) - adds checkbox boxes --&gt;
&lt;div class="so-dropdown" data-so-dropdown
     data-so-multiple="true"
     data-so-multiple-style="checkbox"
     data-so-show-actions="true"&gt;
    ...
&lt;/div&gt;

&lt;!-- Check style - uses checkmark icons only (no checkbox boxes) --&gt;
&lt;div class="so-dropdown" data-so-dropdown
     data-so-multiple="true"
     data-so-multiple-style="check"
     data-so-show-actions="true"
     data-so-select-none-text=""&gt;
    &lt;button class="so-btn so-btn-light so-dropdown-trigger"&gt;
        &lt;span class="so-dropdown-selected"&gt;Select items&lt;/span&gt;
        &lt;span class="material-icons so-dropdown-arrow"&gt;expand_more&lt;/span&gt;
    &lt;/button&gt;
    &lt;div class="so-dropdown-menu"&gt;
        &lt;div class="so-dropdown-items"&gt;
            &lt;div class="so-dropdown-item" data-value="1"&gt;
                Item 1
                &lt;span class="material-icons so-dropdown-check"&gt;check&lt;/span&gt;
            &lt;/div&gt;
            &lt;!-- More items with so-dropdown-check spans --&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Configuration options --&gt;
&lt;!-- data-so-multiple-style="checkbox" - Adds checkbox UI elements (default) --&gt;
&lt;!-- data-so-multiple-style="check"    - Uses checkmark icons only --&gt;
&lt;!-- data-so-select-none-text=""       - Hides the "None" action link --&gt;</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 9: No Scroll Dropdown -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">No Scroll Dropdown</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            By default, dropdown menus have a max-height with scrolling for long lists.
                            Use <code>.so-dropdown-no-scroll</code> to remove the max-height constraint and show all items without scrolling.
                        </p>

                        <div class="so-grid so-grid-cols-2 so-grid-cols-md-1" class="so-demo-grid-gap">

                            <!-- Default (with scroll) -->
                            <div class="so-form-group">
                                <label class="so-form-label">Default (with scroll)</label>
                                <div class="so-dropdown so-dropdown-searchable" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select country</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-search">
                                            <input type="text" class="so-dropdown-search-input" placeholder="Search...">
                                        </div>
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="us">United States</div>
                                            <div class="so-dropdown-item" data-value="uk">United Kingdom</div>
                                            <div class="so-dropdown-item" data-value="ca">Canada</div>
                                            <div class="so-dropdown-item" data-value="au">Australia</div>
                                            <div class="so-dropdown-item" data-value="de">Germany</div>
                                            <div class="so-dropdown-item" data-value="fr">France</div>
                                            <div class="so-dropdown-item" data-value="jp">Japan</div>
                                            <div class="so-dropdown-item" data-value="in">India</div>
                                            <div class="so-dropdown-item" data-value="br">Brazil</div>
                                            <div class="so-dropdown-item" data-value="mx">Mexico</div>
                                            <div class="so-dropdown-item" data-value="es">Spain</div>
                                            <div class="so-dropdown-item" data-value="it">Italy</div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Max height with scrollbar for long lists</small>
                            </div>

                            <!-- No Scroll -->
                            <div class="so-form-group">
                                <label class="so-form-label">No Scroll</label>
                                <div class="so-dropdown so-dropdown-searchable so-dropdown-no-scroll" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select country</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-search">
                                            <input type="text" class="so-dropdown-search-input" placeholder="Search...">
                                        </div>
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="us">United States</div>
                                            <div class="so-dropdown-item" data-value="uk">United Kingdom</div>
                                            <div class="so-dropdown-item" data-value="ca">Canada</div>
                                            <div class="so-dropdown-item" data-value="au">Australia</div>
                                            <div class="so-dropdown-item" data-value="de">Germany</div>
                                            <div class="so-dropdown-item" data-value="fr">France</div>
                                            <div class="so-dropdown-item" data-value="jp">Japan</div>
                                            <div class="so-dropdown-item" data-value="in">India</div>
                                            <div class="so-dropdown-item" data-value="br">Brazil</div>
                                            <div class="so-dropdown-item" data-value="mx">Mexico</div>
                                            <div class="so-dropdown-item" data-value="es">Spain</div>
                                            <div class="so-dropdown-item" data-value="it">Italy</div>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Shows all items without scrolling</small>
                            </div>

                            <!-- Action Menu No Scroll -->
                            <div class="so-form-group">
                                <label class="so-form-label">Action Menu (No Scroll)</label>
                                <div class="so-dropdown so-dropdown-no-scroll" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-btn-icon so-dropdown-trigger">
                                        <span class="material-icons">more_vert</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-action="view">
                                            <span class="material-icons">visibility</span>
                                            <span>View Details</span>
                                        </div>
                                        <div class="so-dropdown-item" data-action="edit">
                                            <span class="material-icons">edit</span>
                                            <span>Edit</span>
                                        </div>
                                        <div class="so-dropdown-item" data-action="duplicate">
                                            <span class="material-icons">content_copy</span>
                                            <span>Duplicate</span>
                                        </div>
                                        <div class="so-dropdown-item" data-action="archive">
                                            <span class="material-icons">archive</span>
                                            <span>Archive</span>
                                        </div>
                                        <div class="so-dropdown-divider"></div>
                                        <div class="so-dropdown-item so-dropdown-item-danger" data-action="delete">
                                            <span class="material-icons">delete</span>
                                            <span>Delete</span>
                                        </div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Action menus typically don't need scroll</small>
                            </div>

                            <!-- Alternative: Class on Menu -->
                            <div class="so-form-group">
                                <label class="so-form-label">Class on Menu Element</label>
                                <div class="so-dropdown" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu so-dropdown-menu-no-scroll">
                                        <div class="so-dropdown-item" data-value="1">Option 1</div>
                                        <div class="so-dropdown-item" data-value="2">Option 2</div>
                                        <div class="so-dropdown-item" data-value="3">Option 3</div>
                                        <div class="so-dropdown-item" data-value="4">Option 4</div>
                                        <div class="so-dropdown-item" data-value="5">Option 5</div>
                                        <div class="so-dropdown-item" data-value="6">Option 6</div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Can also add class to menu element directly</small>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- No scroll on dropdown wrapper --&gt;
&lt;div class="so-dropdown so-dropdown-no-scroll" data-so-dropdown&gt;
    &lt;button type="button" class="so-btn so-btn-light so-dropdown-trigger"&gt;
        &lt;span class="so-dropdown-selected"&gt;Select option&lt;/span&gt;
        &lt;span class="material-icons so-dropdown-arrow"&gt;expand_more&lt;/span&gt;
    &lt;/button&gt;
    &lt;div class="so-dropdown-menu"&gt;
        &lt;div class="so-dropdown-item" data-value="1"&gt;Option 1&lt;/div&gt;
        &lt;div class="so-dropdown-item" data-value="2"&gt;Option 2&lt;/div&gt;
        &lt;!-- All items shown without scroll --&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Alternative: No scroll on menu element --&gt;
&lt;div class="so-dropdown" data-so-dropdown&gt;
    &lt;button type="button" class="so-btn so-btn-light so-dropdown-trigger"&gt;...&lt;/button&gt;
    &lt;div class="so-dropdown-menu so-dropdown-menu-no-scroll"&gt;
        &lt;!-- Items without scroll --&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 10: No Wrap Dropdown -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">No Wrap Dropdown</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Use <code>.so-dropdown-nowrap</code> to prevent text wrapping in dropdown items. The menu will expand to fit the content width.
                        </p>

                        <div class="so-grid so-grid-cols-2 so-grid-cols-md-1" class="so-demo-grid-gap">

                            <!-- Default (with wrap) -->
                            <div class="so-form-group">
                                <label class="so-form-label">Default (allows wrap)</label>
                                <div class="so-dropdown" data-so-dropdown style="max-width: 200px;">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">Short option</div>
                                        <div class="so-dropdown-item" data-value="2">This is a very long option that will wrap to multiple lines</div>
                                        <div class="so-dropdown-item" data-value="3">Another long text option for demonstration</div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Long text wraps within fixed width</small>
                            </div>

                            <!-- No Wrap -->
                            <div class="so-form-group">
                                <label class="so-form-label">No Wrap</label>
                                <div class="so-dropdown so-dropdown-nowrap" data-so-dropdown style="max-width: 200px;">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">Short option</div>
                                        <div class="so-dropdown-item" data-value="2">This is a very long option that will not wrap</div>
                                        <div class="so-dropdown-item" data-value="3">Another long text option for demonstration</div>
                                    </div>
                                </div>
                                <small class="so-demo-small-note">Menu expands to fit content, no text wrap</small>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- No wrap dropdown --&gt;
&lt;div class="so-dropdown so-dropdown-nowrap" data-so-dropdown&gt;
    &lt;button type="button" class="so-btn so-btn-light so-dropdown-trigger"&gt;
        &lt;span class="so-dropdown-selected"&gt;Select option&lt;/span&gt;
        &lt;span class="material-icons so-dropdown-arrow"&gt;expand_more&lt;/span&gt;
    &lt;/button&gt;
    &lt;div class="so-dropdown-menu"&gt;
        &lt;div class="so-dropdown-item" data-value="1"&gt;This text will not wrap&lt;/div&gt;
        &lt;div class="so-dropdown-item" data-value="2"&gt;Menu expands to fit content&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Section 11: Contextual Selection Colors -->
                <div class="so-card">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Contextual Selection Colors</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Apply contextual colors to the selected item state using <code>.so-dropdown-{context}</code> classes.
                        </p>

                        <div class="so-grid so-grid-cols-3 so-grid-cols-md-2 so-grid-cols-sm-1" class="so-demo-grid-gap">

                            <!-- Primary (default) -->
                            <div class="so-form-group">
                                <label class="so-form-label">Primary (default)</label>
                                <div class="so-dropdown so-dropdown-primary" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">
                                            Option 1
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="2">
                                            Option 2
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="3">
                                            Option 3
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Success -->
                            <div class="so-form-group">
                                <label class="so-form-label">Success</label>
                                <div class="so-dropdown so-dropdown-success" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">
                                            Option 1
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="2">
                                            Option 2
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="3">
                                            Option 3
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Danger -->
                            <div class="so-form-group">
                                <label class="so-form-label">Danger</label>
                                <div class="so-dropdown so-dropdown-danger" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">
                                            Option 1
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="2">
                                            Option 2
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="3">
                                            Option 3
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Warning -->
                            <div class="so-form-group">
                                <label class="so-form-label">Warning</label>
                                <div class="so-dropdown so-dropdown-warning" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">
                                            Option 1
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="2">
                                            Option 2
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="3">
                                            Option 3
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="so-form-group">
                                <label class="so-form-label">Info</label>
                                <div class="so-dropdown so-dropdown-info" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">
                                            Option 1
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="2">
                                            Option 2
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="3">
                                            Option 3
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Secondary -->
                            <div class="so-form-group">
                                <label class="so-form-label">Secondary</label>
                                <div class="so-dropdown so-dropdown-secondary" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">
                                            Option 1
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="2">
                                            Option 2
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="3">
                                            Option 3
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Light -->
                            <div class="so-form-group">
                                <label class="so-form-label">Light</label>
                                <div class="so-dropdown so-dropdown-light" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">
                                            Option 1
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="2">
                                            Option 2
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="3">
                                            Option 3
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dark -->
                            <div class="so-form-group">
                                <label class="so-form-label">Dark</label>
                                <div class="so-dropdown so-dropdown-dark" data-so-dropdown>
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected">Select option</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-item" data-value="1">
                                            Option 1
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="2">
                                            Option 2
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                        <div class="so-dropdown-item" data-value="3">
                                            Option 3
                                            <span class="material-icons so-dropdown-check">check</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <h4 class="so-demo-section-heading-spaced">Multiple Selection with Contextual Colors</h4>
                        <div class="so-grid so-grid-cols-3 so-grid-cols-md-2 so-grid-cols-sm-1" class="so-demo-grid-gap">

                            <!-- Multiple Success -->
                            <div class="so-form-group">
                                <label class="so-form-label">Multiple (Success)</label>
                                <div class="so-dropdown so-dropdown-searchable so-dropdown-success" data-so-dropdown data-so-multiple="true">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected placeholder">Select items</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="apple">Apple</div>
                                            <div class="so-dropdown-item" data-value="banana">Banana</div>
                                            <div class="so-dropdown-item" data-value="cherry">Cherry</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Multiple Danger -->
                            <div class="so-form-group">
                                <label class="so-form-label">Multiple (Danger)</label>
                                <div class="so-dropdown so-dropdown-searchable so-dropdown-danger" data-so-dropdown data-so-multiple="true">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected placeholder">Select items</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="red">Red</div>
                                            <div class="so-dropdown-item" data-value="orange">Orange</div>
                                            <div class="so-dropdown-item" data-value="pink">Pink</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Multiple Info -->
                            <div class="so-form-group">
                                <label class="so-form-label">Multiple (Info)</label>
                                <div class="so-dropdown so-dropdown-searchable so-dropdown-info" data-so-dropdown data-so-multiple="true">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected placeholder">Select items</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="css">CSS</div>
                                            <div class="so-dropdown-item" data-value="html">HTML</div>
                                            <div class="so-dropdown-item" data-value="js">JavaScript</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Multiple Light -->
                            <div class="so-form-group">
                                <label class="so-form-label">Multiple (Light)</label>
                                <div class="so-dropdown so-dropdown-searchable so-dropdown-light" data-so-dropdown data-so-multiple="true">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected placeholder">Select items</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="one">Option One</div>
                                            <div class="so-dropdown-item" data-value="two">Option Two</div>
                                            <div class="so-dropdown-item" data-value="three">Option Three</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Multiple Dark -->
                            <div class="so-form-group">
                                <label class="so-form-label">Multiple (Dark)</label>
                                <div class="so-dropdown so-dropdown-searchable so-dropdown-dark" data-so-dropdown data-so-multiple="true">
                                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                                        <span class="so-dropdown-selected placeholder">Select items</span>
                                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                                    </button>
                                    <div class="so-dropdown-menu">
                                        <div class="so-dropdown-items">
                                            <div class="so-dropdown-item" data-value="a">Choice A</div>
                                            <div class="so-dropdown-item" data-value="b">Choice B</div>
                                            <div class="so-dropdown-item" data-value="c">Choice C</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Code Example -->
                        <div class="so-code-block so-code-block-spaced">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- Primary selection color (default) --&gt;
&lt;div class="so-dropdown so-dropdown-primary" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Success selection color --&gt;
&lt;div class="so-dropdown so-dropdown-success" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Danger selection color --&gt;
&lt;div class="so-dropdown so-dropdown-danger" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Warning selection color --&gt;
&lt;div class="so-dropdown so-dropdown-warning" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Info selection color --&gt;
&lt;div class="so-dropdown so-dropdown-info" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Secondary selection color --&gt;
&lt;div class="so-dropdown so-dropdown-secondary" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Light selection color --&gt;
&lt;div class="so-dropdown so-dropdown-light" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Dark selection color --&gt;
&lt;div class="so-dropdown so-dropdown-dark" data-so-dropdown&gt;...&lt;/div&gt;

&lt;!-- Multiple selection with contextual color --&gt;
&lt;div class="so-dropdown so-dropdown-searchable so-dropdown-success"
     data-so-dropdown data-so-multiple="true"&gt;
    ...
&lt;/div&gt;</code></pre>
                        </div>
                    </div>
                </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
