<?php
/**
 * SixOrbit UI Demo - Button Groups
 */
$pageTitle = 'Button Groups';
$pageDescription = 'Group buttons together for related actions';

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
            <h1 class="so-page-title">Button Groups</h1>
            <p class="so-page-subtitle">Group buttons together for related actions</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Basic Button Group -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Basic Button Groups</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Group buttons together in a single row.</p>
                        <div class="so-flex so-flex-col so-gap-4">
                            <div>
                                <label class="so-form-label so-mb-2">Primary Group</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-primary">Left</button>
                                    <button type="button" class="so-btn so-btn-primary">Middle</button>
                                    <button type="button" class="so-btn so-btn-primary">Right</button>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Outline Group</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-outline">Left</button>
                                    <button type="button" class="so-btn so-btn-outline">Middle</button>
                                    <button type="button" class="so-btn so-btn-outline">Right</button>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Secondary Group</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-secondary">Left</button>
                                    <button type="button" class="so-btn so-btn-secondary">Middle</button>
                                    <button type="button" class="so-btn so-btn-secondary">Right</button>
                                </div>
                            </div>
                        </div>
<?= so_code_block('<div class="so-btn-group">
    <button type="button" class="so-btn so-btn-primary">Left</button>
    <button type="button" class="so-btn so-btn-primary">Middle</button>
    <button type="button" class="so-btn so-btn-primary">Right</button>
</div>

<div class="so-btn-group">
    <button type="button" class="so-btn so-btn-outline">Left</button>
    <button type="button" class="so-btn so-btn-outline">Middle</button>
    <button type="button" class="so-btn so-btn-outline">Right</button>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Icon Button Groups -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Icon Button Groups</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-flex so-flex-col so-gap-4">
                            <div>
                                <label class="so-form-label so-mb-2">Text Formatting</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-light"><span class="material-icons">format_bold</span></button>
                                    <button type="button" class="so-btn so-btn-light"><span class="material-icons">format_italic</span></button>
                                    <button type="button" class="so-btn so-btn-light"><span class="material-icons">format_underlined</span></button>
                                    <button type="button" class="so-btn so-btn-light"><span class="material-icons">strikethrough_s</span></button>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Text Alignment</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-outline"><span class="material-icons">format_align_left</span></button>
                                    <button type="button" class="so-btn so-btn-outline"><span class="material-icons">format_align_center</span></button>
                                    <button type="button" class="so-btn so-btn-outline"><span class="material-icons">format_align_right</span></button>
                                    <button type="button" class="so-btn so-btn-outline"><span class="material-icons">format_align_justify</span></button>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Navigation</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-secondary"><span class="material-icons">chevron_left</span></button>
                                    <button type="button" class="so-btn so-btn-secondary"><span class="material-icons">chevron_right</span></button>
                                </div>
                            </div>
                        </div>
<?= so_code_block('<!-- Text Formatting -->
<div class="so-btn-group">
    <button type="button" class="so-btn so-btn-light"><span class="material-icons">format_bold</span></button>
    <button type="button" class="so-btn so-btn-light"><span class="material-icons">format_italic</span></button>
    <button type="button" class="so-btn so-btn-light"><span class="material-icons">format_underlined</span></button>
</div>

<!-- Text Alignment -->
<div class="so-btn-group">
    <button type="button" class="so-btn so-btn-outline"><span class="material-icons">format_align_left</span></button>
    <button type="button" class="so-btn so-btn-outline"><span class="material-icons">format_align_center</span></button>
    <button type="button" class="so-btn so-btn-outline"><span class="material-icons">format_align_right</span></button>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Button Group Sizes -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Button Group Sizes</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Apply uniform sizing to all buttons in a group using <code>.so-btn-group-sm</code> or <code>.so-btn-group-lg</code> on the group container.</p>
                        <div class="so-flex so-flex-col so-gap-4">
                            <div>
                                <label class="so-form-label so-mb-2">Small (<code>.so-btn-group-sm</code>)</label>
                                <div class="so-btn-group so-btn-group-sm">
                                    <button type="button" class="so-btn so-btn-primary">One</button>
                                    <button type="button" class="so-btn so-btn-primary">Two</button>
                                    <button type="button" class="so-btn so-btn-primary">Three</button>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Default</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-primary">One</button>
                                    <button type="button" class="so-btn so-btn-primary">Two</button>
                                    <button type="button" class="so-btn so-btn-primary">Three</button>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Large (<code>.so-btn-group-lg</code>)</label>
                                <div class="so-btn-group so-btn-group-lg">
                                    <button type="button" class="so-btn so-btn-primary">One</button>
                                    <button type="button" class="so-btn so-btn-primary">Two</button>
                                    <button type="button" class="so-btn so-btn-primary">Three</button>
                                </div>
                            </div>
                        </div>

                        <h6 class="so-mt-4 so-mb-3">Outline Variants</h6>
                        <div class="so-flex so-flex-col so-gap-4">
                            <div>
                                <label class="so-form-label so-mb-2">Small Outline</label>
                                <div class="so-btn-group so-btn-group-sm">
                                    <button type="button" class="so-btn so-btn-outline">One</button>
                                    <button type="button" class="so-btn so-btn-outline">Two</button>
                                    <button type="button" class="so-btn so-btn-outline">Three</button>
                                </div>
                            </div>
                            <div>
                                <label class="so-form-label so-mb-2">Large Outline</label>
                                <div class="so-btn-group so-btn-group-lg">
                                    <button type="button" class="so-btn so-btn-outline">One</button>
                                    <button type="button" class="so-btn so-btn-outline">Two</button>
                                    <button type="button" class="so-btn so-btn-outline">Three</button>
                                </div>
                            </div>
                        </div>

                        <h6 class="so-mt-4 so-mb-3">Icon Button Groups</h6>
                        <div class="so-flex so-flex-col so-gap-4">
                            <div>
                                <label class="so-form-label so-mb-2">Small Icons</label>
                                <div class="so-btn-group so-btn-group-sm">
                                    <button type="button" class="so-btn so-btn-outline so-btn-icon"><span class="material-icons">format_bold</span></button>
                                    <button type="button" class="so-btn so-btn-outline so-btn-icon"><span class="material-icons">format_italic</span></button>
                                    <button type="button" class="so-btn so-btn-outline so-btn-icon"><span class="material-icons">format_underlined</span></button>
                                </div>
                            </div>
                            <div>
                                <label class="so-form-label so-mb-2">Large Icons</label>
                                <div class="so-btn-group so-btn-group-lg">
                                    <button type="button" class="so-btn so-btn-outline so-btn-icon"><span class="material-icons">format_bold</span></button>
                                    <button type="button" class="so-btn so-btn-outline so-btn-icon"><span class="material-icons">format_italic</span></button>
                                    <button type="button" class="so-btn so-btn-outline so-btn-icon"><span class="material-icons">format_underlined</span></button>
                                </div>
                            </div>
                        </div>

<?= so_code_block('<!-- Small Button Group (apply size at group level) -->
<div class="so-btn-group so-btn-group-sm">
    <button class="so-btn so-btn-primary">One</button>
    <button class="so-btn so-btn-primary">Two</button>
    <button class="so-btn so-btn-primary">Three</button>
</div>

<!-- Large Button Group -->
<div class="so-btn-group so-btn-group-lg">
    <button class="so-btn so-btn-primary">One</button>
    <button class="so-btn so-btn-primary">Two</button>
    <button class="so-btn so-btn-primary">Three</button>
</div>

<!-- Large Icon Button Group -->
<div class="so-btn-group so-btn-group-lg">
    <button class="so-btn so-btn-outline so-btn-icon"><span class="material-icons">format_bold</span></button>
    <button class="so-btn so-btn-outline so-btn-icon"><span class="material-icons">format_italic</span></button>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Mixed Button Group -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Mixed Content</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-flex so-flex-col so-gap-4">
                            <div>
                                <label class="so-form-label so-mb-2">Text with Icons</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-primary"><span class="material-icons">save</span> Save</button>
                                    <button type="button" class="so-btn so-btn-primary"><span class="material-icons">edit</span> Edit</button>
                                    <button type="button" class="so-btn so-btn-primary"><span class="material-icons">delete</span> Delete</button>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Toggle Buttons</label>
                                <div class="so-btn-group" role="group">
                                    <button type="button" class="so-btn so-btn-outline so-active">Day</button>
                                    <button type="button" class="so-btn so-btn-outline">Week</button>
                                    <button type="button" class="so-btn so-btn-outline">Month</button>
                                    <button type="button" class="so-btn so-btn-outline">Year</button>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Split Button</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-success">Save Changes</button>
                                    <button type="button" class="so-btn so-btn-success so-dropdown-toggle">
                                        <span class="material-icons">expand_more</span>
                                    </button>
                                </div>
                            </div>
                        </div>
<?= so_code_block('<!-- Text with Icons -->
<div class="so-btn-group">
    <button class="so-btn so-btn-primary"><span class="material-icons">save</span> Save</button>
    <button class="so-btn so-btn-primary"><span class="material-icons">edit</span> Edit</button>
    <button class="so-btn so-btn-primary"><span class="material-icons">delete</span> Delete</button>
</div>

<!-- Toggle Buttons -->
<div class="so-btn-group" role="group">
    <button class="so-btn so-btn-outline so-active">Day</button>
    <button class="so-btn so-btn-outline">Week</button>
    <button class="so-btn so-btn-outline">Month</button>
</div>

<!-- Split Button -->
<div class="so-btn-group">
    <button class="so-btn so-btn-success">Save Changes</button>
    <button class="so-btn so-btn-success so-dropdown-toggle">
        <span class="material-icons">expand_more</span>
    </button>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Split Buttons with Dropdown -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Split Buttons with Dropdown</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Combine a primary action button with a dropdown for additional options.</p>
                        <div class="so-flex so-flex-col so-gap-4">
                            <div>
                                <label class="so-form-label so-mb-2">Primary Split Button</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-primary">Save</button>
                                    <div class="so-dropdown" data-so-dropdown>
                                        <button type="button" class="so-dropdown-trigger so-btn so-btn-icon so-btn-primary">
                                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                                        </button>
                                        <div class="so-dropdown-menu">
                                            <div class="so-dropdown-item">Save as Draft</div>
                                            <div class="so-dropdown-item">Save & Publish</div>
                                            <div class="so-dropdown-item">Save as Copy</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Success Split Button</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-success">
                                        <span class="material-icons">download</span>
                                        Export
                                    </button>
                                    <div class="so-dropdown" data-so-dropdown>
                                        <button type="button" class="so-dropdown-trigger so-btn so-btn-icon so-btn-success">
                                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                                        </button>
                                        <div class="so-dropdown-menu">
                                            <div class="so-dropdown-item">Export as CSV</div>
                                            <div class="so-dropdown-item">Export as Excel</div>
                                            <div class="so-dropdown-item">Export as PDF</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Danger Split Button</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-danger">
                                        <span class="material-icons">delete</span>
                                        Delete
                                    </button>
                                    <div class="so-dropdown" data-so-dropdown>
                                        <button type="button" class="so-dropdown-trigger so-btn so-btn-icon so-btn-danger">
                                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                                        </button>
                                        <div class="so-dropdown-menu">
                                            <div class="so-dropdown-item">Delete Selected</div>
                                            <div class="so-dropdown-item">Delete All</div>
                                            <div class="so-dropdown-divider"></div>
                                            <div class="so-dropdown-item">Move to Trash</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Outline Split Button</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-outline">Actions</button>
                                    <div class="so-dropdown" data-so-dropdown>
                                        <button type="button" class="so-dropdown-trigger so-btn so-btn-icon so-btn-outline">
                                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                                        </button>
                                        <div class="so-dropdown-menu">
                                            <div class="so-dropdown-item">Edit</div>
                                            <div class="so-dropdown-item">Duplicate</div>
                                            <div class="so-dropdown-item">Archive</div>
                                            <div class="so-dropdown-divider"></div>
                                            <div class="so-dropdown-item so-dropdown-item-danger">Delete</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Secondary Split Button</label>
                                <div class="so-btn-group">
                                    <button type="button" class="so-btn so-btn-secondary">
                                        <span class="material-icons">share</span>
                                        Share
                                    </button>
                                    <div class="so-dropdown" data-so-dropdown>
                                        <button type="button" class="so-dropdown-trigger so-btn so-btn-icon so-btn-secondary">
                                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                                        </button>
                                        <div class="so-dropdown-menu">
                                            <div class="so-dropdown-item"><span class="material-icons so-demo-icon-sm">link</span> Copy Link</div>
                                            <div class="so-dropdown-item"><span class="material-icons so-demo-icon-sm">email</span> Email</div>
                                            <div class="so-dropdown-item"><span class="material-icons so-demo-icon-sm">code</span> Embed</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<?= so_code_block('<!-- Primary Split Button -->
<div class="so-btn-group">
    <button type="button" class="so-btn so-btn-primary">Save</button>
    <div class="so-dropdown" data-so-dropdown>
        <button type="button" class="so-dropdown-trigger so-btn so-btn-primary">
            <span class="material-icons so-dropdown-arrow">expand_more</span>
        </button>
        <div class="so-dropdown-menu">
            <div class="so-dropdown-item">Save as Draft</div>
            <div class="so-dropdown-item">Save & Publish</div>
            <div class="so-dropdown-item">Save as Copy</div>
        </div>
    </div>
</div>

<!-- With Icon and Divider -->
<div class="so-btn-group">
    <button type="button" class="so-btn so-btn-success">
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
            <div class="so-dropdown-divider"></div>
            <div class="so-dropdown-item">Export as PDF</div>
        </div>
    </div>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Toggle Buttons (Radio/Checkbox) -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Toggle Buttons</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Interactive toggle buttons with radio (single selection) or checkbox (multi-selection) behavior.</p>

                        <div class="so-flex so-flex-col so-gap-6">
                            <!-- Radio Toggle (Single Selection) -->
                            <div>
                                <label class="so-form-label so-mb-2">Text Alignment (Radio - Single Selection)</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
                                    <input type="radio" class="so-btn-check" name="textAlign" id="alignLeft" value="left" checked>
                                    <label class="so-btn so-btn-outline" for="alignLeft">
                                        <span class="material-icons">format_align_left</span>
                                    </label>

                                    <input type="radio" class="so-btn-check" name="textAlign" id="alignCenter" value="center">
                                    <label class="so-btn so-btn-outline" for="alignCenter">
                                        <span class="material-icons">format_align_center</span>
                                    </label>

                                    <input type="radio" class="so-btn-check" name="textAlign" id="alignRight" value="right">
                                    <label class="so-btn so-btn-outline" for="alignRight">
                                        <span class="material-icons">format_align_right</span>
                                    </label>

                                    <input type="radio" class="so-btn-check" name="textAlign" id="alignJustify" value="justify">
                                    <label class="so-btn so-btn-outline" for="alignJustify">
                                        <span class="material-icons">format_align_justify</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Checkbox Toggle (Multi Selection) -->
                            <div>
                                <label class="so-form-label so-mb-2">Text Formatting (Checkbox - Multi Selection)</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="checkbox">
                                    <input type="checkbox" class="so-btn-check" id="formatBold" value="bold">
                                    <label class="so-btn so-btn-outline" for="formatBold">
                                        <span class="material-icons">format_bold</span>
                                    </label>

                                    <input type="checkbox" class="so-btn-check" id="formatItalic" value="italic">
                                    <label class="so-btn so-btn-outline" for="formatItalic">
                                        <span class="material-icons">format_italic</span>
                                    </label>

                                    <input type="checkbox" class="so-btn-check" id="formatUnderline" value="underline">
                                    <label class="so-btn so-btn-outline" for="formatUnderline">
                                        <span class="material-icons">format_underlined</span>
                                    </label>

                                    <input type="checkbox" class="so-btn-check" id="formatStrike" value="strikethrough">
                                    <label class="so-btn so-btn-outline" for="formatStrike">
                                        <span class="material-icons">strikethrough_s</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Radio with Text -->
                            <div>
                                <label class="so-form-label so-mb-2">View Mode (Radio with Text)</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
                                    <input type="radio" class="so-btn-check" name="viewMode" id="viewDay" value="day" checked>
                                    <label class="so-btn so-btn-outline" for="viewDay">Day</label>

                                    <input type="radio" class="so-btn-check" name="viewMode" id="viewWeek" value="week">
                                    <label class="so-btn so-btn-outline" for="viewWeek">Week</label>

                                    <input type="radio" class="so-btn-check" name="viewMode" id="viewMonth" value="month">
                                    <label class="so-btn so-btn-outline" for="viewMonth">Month</label>

                                    <input type="radio" class="so-btn-check" name="viewMode" id="viewYear" value="year">
                                    <label class="so-btn so-btn-outline" for="viewYear">Year</label>
                                </div>
                            </div>
                        </div>
<?= so_code_block('<!-- Radio Toggle (Single Selection) -->
<div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
    <input type="radio" class="so-btn-check" name="align" id="left" value="left" checked>
    <label class="so-btn so-btn-outline" for="left">
        <span class="material-icons">format_align_left</span>
    </label>
    <input type="radio" class="so-btn-check" name="align" id="center" value="center">
    <label class="so-btn so-btn-outline" for="center">
        <span class="material-icons">format_align_center</span>
    </label>
    <!-- ... more buttons -->
</div>

<!-- Checkbox Toggle (Multi Selection) -->
<div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="checkbox">
    <input type="checkbox" class="so-btn-check" id="bold" value="bold">
    <label class="so-btn so-btn-outline" for="bold">
        <span class="material-icons">format_bold</span>
    </label>
    <input type="checkbox" class="so-btn-check" id="italic" value="italic">
    <label class="so-btn so-btn-outline" for="italic">
        <span class="material-icons">format_italic</span>
    </label>
    <!-- ... more buttons -->
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Contextual Toggle Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Contextual Toggle Buttons</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Outline buttons that fill with color when selected.</p>

                        <div class="so-flex so-flex-col so-gap-4">
                            <!-- Primary -->
                            <div>
                                <label class="so-form-label so-mb-2">Primary Outline Toggle</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
                                    <input type="radio" class="so-btn-check" name="primaryToggle" id="primary1" value="1" checked>
                                    <label class="so-btn so-btn-outline-primary" for="primary1">Option 1</label>

                                    <input type="radio" class="so-btn-check" name="primaryToggle" id="primary2" value="2">
                                    <label class="so-btn so-btn-outline-primary" for="primary2">Option 2</label>

                                    <input type="radio" class="so-btn-check" name="primaryToggle" id="primary3" value="3">
                                    <label class="so-btn so-btn-outline-primary" for="primary3">Option 3</label>
                                </div>
                            </div>

                            <!-- Success -->
                            <div>
                                <label class="so-form-label so-mb-2">Success Outline Toggle</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
                                    <input type="radio" class="so-btn-check" name="successToggle" id="success1" value="approved" checked>
                                    <label class="so-btn so-btn-outline-success" for="success1">Approved</label>

                                    <input type="radio" class="so-btn-check" name="successToggle" id="success2" value="pending">
                                    <label class="so-btn so-btn-outline-success" for="success2">Pending</label>

                                    <input type="radio" class="so-btn-check" name="successToggle" id="success3" value="review">
                                    <label class="so-btn so-btn-outline-success" for="success3">Review</label>
                                </div>
                            </div>

                            <!-- Mixed Priority -->
                            <div>
                                <label class="so-form-label so-mb-2">Priority Level (Mixed Colors)</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
                                    <input type="radio" class="so-btn-check" name="priority" id="priorityLow" value="low">
                                    <label class="so-btn so-btn-outline-success" for="priorityLow">Low</label>

                                    <input type="radio" class="so-btn-check" name="priority" id="priorityMedium" value="medium" checked>
                                    <label class="so-btn so-btn-outline-warning" for="priorityMedium">Medium</label>

                                    <input type="radio" class="so-btn-check" name="priority" id="priorityHigh" value="high">
                                    <label class="so-btn so-btn-outline-danger" for="priorityHigh">High</label>
                                </div>
                            </div>
                        </div>
<?= so_code_block('<!-- Primary Outline Toggle -->
<div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
    <input type="radio" class="so-btn-check" name="opt" id="opt1" value="1" checked>
    <label class="so-btn so-btn-outline-primary" for="opt1">Option 1</label>
    ...
</div>

<!-- Success Outline Toggle -->
<div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
    <input type="radio" class="so-btn-check" name="status" id="approved" value="approved">
    <label class="so-btn so-btn-outline-success" for="approved">Approved</label>
    ...
</div>

<!-- Mixed Colors (Priority) -->
<div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
    <input type="radio" class="so-btn-check" name="priority" id="low" value="low">
    <label class="so-btn so-btn-outline-success" for="low">Low</label>
    <input type="radio" class="so-btn-check" name="priority" id="medium" value="medium">
    <label class="so-btn so-btn-outline-warning" for="medium">Medium</label>
    <input type="radio" class="so-btn-check" name="priority" id="high" value="high">
    <label class="so-btn so-btn-outline-danger" for="high">High</label>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Toggle Button Sizes -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Toggle Button Sizes</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-flex so-flex-col so-gap-4">
                            <div>
                                <label class="so-form-label so-mb-2">Small</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
                                    <input type="radio" class="so-btn-check" name="sizeSm" id="sizeSm1" value="1" checked>
                                    <label class="so-btn so-btn-outline-primary so-btn-sm" for="sizeSm1">One</label>
                                    <input type="radio" class="so-btn-check" name="sizeSm" id="sizeSm2" value="2">
                                    <label class="so-btn so-btn-outline-primary so-btn-sm" for="sizeSm2">Two</label>
                                    <input type="radio" class="so-btn-check" name="sizeSm" id="sizeSm3" value="3">
                                    <label class="so-btn so-btn-outline-primary so-btn-sm" for="sizeSm3">Three</label>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Default</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
                                    <input type="radio" class="so-btn-check" name="sizeMd" id="sizeMd1" value="1" checked>
                                    <label class="so-btn so-btn-outline-primary" for="sizeMd1">One</label>
                                    <input type="radio" class="so-btn-check" name="sizeMd" id="sizeMd2" value="2">
                                    <label class="so-btn so-btn-outline-primary" for="sizeMd2">Two</label>
                                    <input type="radio" class="so-btn-check" name="sizeMd" id="sizeMd3" value="3">
                                    <label class="so-btn so-btn-outline-primary" for="sizeMd3">Three</label>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Large</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
                                    <input type="radio" class="so-btn-check" name="sizeLg" id="sizeLg1" value="1" checked>
                                    <label class="so-btn so-btn-outline-primary so-btn-lg" for="sizeLg1">One</label>
                                    <input type="radio" class="so-btn-check" name="sizeLg" id="sizeLg2" value="2">
                                    <label class="so-btn so-btn-outline-primary so-btn-lg" for="sizeLg2">Two</label>
                                    <input type="radio" class="so-btn-check" name="sizeLg" id="sizeLg3" value="3">
                                    <label class="so-btn so-btn-outline-primary so-btn-lg" for="sizeLg3">Three</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vertical Toggle Button Group -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Vertical Toggle Button Group</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-flex so-gap-6">
                            <div>
                                <label class="so-form-label so-mb-2">Vertical Radio</label>
                                <div class="so-btn-group-vertical" data-so-toggle="buttons" data-toggle-type="radio">
                                    <input type="radio" class="so-btn-check" name="verticalRadio" id="vr1" value="top" checked>
                                    <label class="so-btn so-btn-outline" for="vr1">
                                        <span class="material-icons">vertical_align_top</span> Top
                                    </label>
                                    <input type="radio" class="so-btn-check" name="verticalRadio" id="vr2" value="middle">
                                    <label class="so-btn so-btn-outline" for="vr2">
                                        <span class="material-icons">vertical_align_center</span> Middle
                                    </label>
                                    <input type="radio" class="so-btn-check" name="verticalRadio" id="vr3" value="bottom">
                                    <label class="so-btn so-btn-outline" for="vr3">
                                        <span class="material-icons">vertical_align_bottom</span> Bottom
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">Vertical Checkbox</label>
                                <div class="so-btn-group-vertical" data-so-toggle="buttons" data-toggle-type="checkbox">
                                    <input type="checkbox" class="so-btn-check" id="vc1" value="notifications" checked>
                                    <label class="so-btn so-btn-outline" for="vc1">
                                        <span class="material-icons">notifications</span> Notifications
                                    </label>
                                    <input type="checkbox" class="so-btn-check" id="vc2" value="sound">
                                    <label class="so-btn so-btn-outline" for="vc2">
                                        <span class="material-icons">volume_up</span> Sound
                                    </label>
                                    <input type="checkbox" class="so-btn-check" id="vc3" value="vibration" checked>
                                    <label class="so-btn so-btn-outline" for="vc3">
                                        <span class="material-icons">vibration</span> Vibration
                                    </label>
                                </div>
                            </div>
                        </div>
<?= so_code_block('<!-- Vertical Toggle Group -->
<div class="so-btn-group-vertical" data-so-toggle="buttons" data-toggle-type="radio">
    <input type="radio" class="so-btn-check" name="vert" id="v1" value="top" checked>
    <label class="so-btn so-btn-outline" for="v1">Top</label>
    <input type="radio" class="so-btn-check" name="vert" id="v2" value="middle">
    <label class="so-btn so-btn-outline" for="v2">Middle</label>
    <input type="radio" class="so-btn-check" name="vert" id="v3" value="bottom">
    <label class="so-btn so-btn-outline" for="v3">Bottom</label>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Disabled Toggle Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Disabled States</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-flex so-flex-col so-gap-4">
                            <div>
                                <label class="so-form-label so-mb-2">Single Disabled Button</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="radio">
                                    <input type="radio" class="so-btn-check" name="disabledDemo" id="dd1" value="1" checked>
                                    <label class="so-btn so-btn-outline-primary" for="dd1">Active</label>
                                    <input type="radio" class="so-btn-check" name="disabledDemo" id="dd2" value="2" disabled>
                                    <label class="so-btn so-btn-outline-primary" for="dd2">Disabled</label>
                                    <input type="radio" class="so-btn-check" name="disabledDemo" id="dd3" value="3">
                                    <label class="so-btn so-btn-outline-primary" for="dd3">Normal</label>
                                </div>
                            </div>

                            <div>
                                <label class="so-form-label so-mb-2">All Buttons Disabled</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="checkbox">
                                    <input type="checkbox" class="so-btn-check" id="allDis1" value="1" checked disabled>
                                    <label class="so-btn so-btn-outline" for="allDis1">Selected</label>
                                    <input type="checkbox" class="so-btn-check" id="allDis2" value="2" disabled>
                                    <label class="so-btn so-btn-outline" for="allDis2">Disabled</label>
                                    <input type="checkbox" class="so-btn-check" id="allDis3" value="3" disabled>
                                    <label class="so-btn so-btn-outline" for="allDis3">Disabled</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enforced Selection -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Enforced Selection</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Use <code>data-enforce-selection="true"</code> to prevent deselecting all options in checkbox mode.</p>

                        <div class="so-flex so-flex-col so-gap-4">
                            <div>
                                <label class="so-form-label so-mb-2">At Least One Must Be Selected</label>
                                <div class="so-btn-group" data-so-toggle="buttons" data-toggle-type="checkbox" data-enforce-selection="true">
                                    <input type="checkbox" class="so-btn-check" id="enforce1" value="email" checked>
                                    <label class="so-btn so-btn-outline-primary" for="enforce1">
                                        <span class="material-icons">email</span> Email
                                    </label>
                                    <input type="checkbox" class="so-btn-check" id="enforce2" value="sms">
                                    <label class="so-btn so-btn-outline-primary" for="enforce2">
                                        <span class="material-icons">sms</span> SMS
                                    </label>
                                    <input type="checkbox" class="so-btn-check" id="enforce3" value="push">
                                    <label class="so-btn so-btn-outline-primary" for="enforce3">
                                        <span class="material-icons">notifications</span> Push
                                    </label>
                                </div>
                                <span class="so-form-hint so-mt-1">
                                    <span class="material-icons">info</span>
                                    Try to uncheck all - the last selection will remain.
                                </span>
                            </div>
                        </div>
<?= so_code_block('<!-- Enforced Selection (can\'t deselect all) -->
<div class="so-btn-group"
     data-so-toggle="buttons"
     data-toggle-type="checkbox"
     data-enforce-selection="true">
    <input type="checkbox" class="so-btn-check" id="email" value="email" checked>
    <label class="so-btn so-btn-outline-primary" for="email">Email</label>
    <input type="checkbox" class="so-btn-check" id="sms" value="sms">
    <label class="so-btn so-btn-outline-primary" for="sms">SMS</label>
    <input type="checkbox" class="so-btn-check" id="push" value="push">
    <label class="so-btn so-btn-outline-primary" for="push">Push</label>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- JavaScript API -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">JavaScript API</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Control toggle buttons programmatically using the SOButtonGroup API.</p>

                        <div class="so-flex so-flex-col so-gap-4">
                            <div>
                                <label class="so-form-label so-mb-2">Interactive Demo</label>
                                <div class="so-btn-group so-mb-3" id="apiDemoGroup" data-so-toggle="buttons" data-toggle-type="checkbox">
                                    <input type="checkbox" class="so-btn-check" id="api1" value="option1" checked>
                                    <label class="so-btn so-btn-outline-primary" for="api1">Option 1</label>
                                    <input type="checkbox" class="so-btn-check" id="api2" value="option2">
                                    <label class="so-btn so-btn-outline-primary" for="api2">Option 2</label>
                                    <input type="checkbox" class="so-btn-check" id="api3" value="option3">
                                    <label class="so-btn so-btn-outline-primary" for="api3">Option 3</label>
                                </div>

                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-3">
                                    <button type="button" class="so-btn so-btn-sm so-btn-outline-success" onclick="demoSelectAll()">Select All</button>
                                    <button type="button" class="so-btn so-btn-sm so-btn-outline-danger" onclick="demoDeselectAll()">Deselect All</button>
                                    <button type="button" class="so-btn so-btn-sm so-btn-outline" onclick="demoToggle('option2')">Toggle Option 2</button>
                                    <button type="button" class="so-btn so-btn-sm so-btn-outline" onclick="demoGetValue()">Get Value</button>
                                </div>

                                <div id="apiDemoOutput" class="so-p-3 so-bg-light so-rounded" class="so-demo-output">
                                    Click buttons above to see API output
                                </div>
                            </div>
                        </div>
<?= so_code_block('// Get instance
const group = SOButtonGroup.getInstance(document.querySelector(\'#myGroup\'));

// Get current value(s)
group.getValue()  // Returns array for checkbox, string for radio

// Set value(s)
group.setValue([\'option1\', \'option3\'])  // checkbox
group.setValue(\'option2\')               // radio

// Toggle specific button
group.toggle(\'option2\')

// Select/Deselect all (checkbox only)
group.selectAll()
group.deselectAll()

// Enable/Disable
group.disable()
group.enable()
group.disableButton(\'option2\')
group.enableButton(\'option2\')

// Listen to changes
element.addEventListener(\'so:toggle:change\', (e) => {
    console.log(e.detail.value)    // Current value(s)
    console.log(e.detail.changed)  // Which button changed
    console.log(e.detail.checked)  // New checked state
})', 'javascript') ?>
                    </div>
                </div>

                <script>
                    // API Demo functions
                    function demoSelectAll() {
                        const group = SOButtonGroup.getInstance(document.querySelector('#apiDemoGroup'));
                        group.selectAll();
                        document.getElementById('apiDemoOutput').textContent = 'selectAll() called - Value: ' + JSON.stringify(group.getValue());
                    }

                    function demoDeselectAll() {
                        const group = SOButtonGroup.getInstance(document.querySelector('#apiDemoGroup'));
                        group.deselectAll();
                        document.getElementById('apiDemoOutput').textContent = 'deselectAll() called - Value: ' + JSON.stringify(group.getValue());
                    }

                    function demoToggle(value) {
                        const group = SOButtonGroup.getInstance(document.querySelector('#apiDemoGroup'));
                        group.toggle(value);
                        document.getElementById('apiDemoOutput').textContent = 'toggle("' + value + '") called - Value: ' + JSON.stringify(group.getValue());
                    }

                    function demoGetValue() {
                        const group = SOButtonGroup.getInstance(document.querySelector('#apiDemoGroup'));
                        document.getElementById('apiDemoOutput').textContent = 'getValue() returned: ' + JSON.stringify(group.getValue());
                    }

                    // Listen to change events
                    document.addEventListener('DOMContentLoaded', function() {
                        const apiDemoGroup = document.querySelector('#apiDemoGroup');
                        if (apiDemoGroup) {
                            apiDemoGroup.addEventListener('so:toggle:change', function(e) {
                                if (!e.detail.programmatic) {
                                    document.getElementById('apiDemoOutput').textContent =
                                        'Event: so:toggle:change\n' +
                                        'Value: ' + JSON.stringify(e.detail.value) + '\n' +
                                        'Changed: ' + e.detail.changed + '\n' +
                                        'Checked: ' + e.detail.checked;
                                }
                            });
                        }
                    });
                </script>

                <!-- Block Button Groups -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Block Button Groups (Full Width)</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Make buttons and button groups span the full width of their container.</p>

                        <!-- Single Block Buttons -->
                        <h6 class="so-mb-3">Block Buttons</h6>
                        <p class="so-text-muted so-mb-3">Add <code>.so-btn-block</code> class to make any single button full width.</p>
                        <div class="so-flex so-flex-col so-gap-2 so-mb-4" style="max-width: 400px;">
                            <button class="so-btn so-btn-primary so-btn-block">Primary Block</button>
                            <button class="so-btn so-btn-secondary so-btn-block">Secondary Block</button>
                            <button class="so-btn so-btn-success so-btn-block">Success Block</button>
                            <button class="so-btn so-btn-danger so-btn-block">Danger Block</button>
                            <button class="so-btn so-btn-warning so-btn-block">Warning Block</button>
                            <button class="so-btn so-btn-info so-btn-block">Info Block</button>
                            <button class="so-btn so-btn-light so-btn-block">Light Block</button>
                            <button class="so-btn so-btn-dark so-btn-block">Dark Block</button>
                        </div>

                        <!-- Outline Block Buttons -->
                        <h6 class="so-mb-3">Outline Block Buttons</h6>
                        <div class="so-flex so-flex-col so-gap-2 so-mb-4" style="max-width: 400px;">
                            <button class="so-btn so-btn-outline-primary so-btn-block">Outline Primary</button>
                            <button class="so-btn so-btn-outline-secondary so-btn-block">Outline Secondary</button>
                            <button class="so-btn so-btn-outline-success so-btn-block">Outline Success</button>
                            <button class="so-btn so-btn-outline-danger so-btn-block">Outline Danger</button>
                            <button class="so-btn so-btn-outline-warning so-btn-block">Outline Warning</button>
                            <button class="so-btn so-btn-outline-info so-btn-block">Outline Info</button>
                            <button class="so-btn so-btn-outline-dark so-btn-block">Outline Dark</button>
                        </div>

                        <!-- Light/Soft Block Buttons -->
                        <h6 class="so-mb-3">Light (Soft) Block Buttons</h6>
                        <div class="so-flex so-flex-col so-gap-2 so-mb-4" style="max-width: 400px;">
                            <button class="so-btn so-btn-light-primary so-btn-block">Light Primary</button>
                            <button class="so-btn so-btn-light-secondary so-btn-block">Light Secondary</button>
                            <button class="so-btn so-btn-light-success so-btn-block">Light Success</button>
                            <button class="so-btn so-btn-light-danger so-btn-block">Light Danger</button>
                            <button class="so-btn so-btn-light-warning so-btn-block">Light Warning</button>
                            <button class="so-btn so-btn-light-info so-btn-block">Light Info</button>
                            <button class="so-btn so-btn-light-dark so-btn-block">Light Dark</button>
                        </div>

                        <!-- Ghost Block Buttons -->
                        <h6 class="so-mb-3">Ghost Block Buttons</h6>
                        <div class="so-flex so-flex-col so-gap-2 so-mb-4" style="max-width: 400px;">
                            <button class="so-btn so-btn-ghost so-btn-primary so-btn-block">Ghost Primary</button>
                            <button class="so-btn so-btn-ghost so-btn-secondary so-btn-block">Ghost Secondary</button>
                            <button class="so-btn so-btn-ghost so-btn-success so-btn-block">Ghost Success</button>
                            <button class="so-btn so-btn-ghost so-btn-danger so-btn-block">Ghost Danger</button>
                        </div>

                        <!-- Link Block Buttons -->
                        <h6 class="so-mb-3">Link Block Buttons</h6>
                        <div class="so-flex so-flex-col so-gap-2 so-mb-4" style="max-width: 400px;">
                            <button class="so-btn so-btn-link so-btn-block">Link Block</button>
                            <button class="so-btn so-btn-link so-text-primary so-btn-block">Link Primary</button>
                            <button class="so-btn so-btn-link so-text-danger so-btn-block">Link Danger</button>
                        </div>

                        <!-- Block Button Sizes -->
                        <h6 class="so-mb-3">Block Button Sizes</h6>
                        <div class="so-flex so-flex-col so-gap-2 so-mb-4" style="max-width: 400px;">
                            <button class="so-btn so-btn-primary so-btn-xs so-btn-block">Extra Small Block</button>
                            <button class="so-btn so-btn-primary so-btn-sm so-btn-block">Small Block</button>
                            <button class="so-btn so-btn-primary so-btn-block">Default Block</button>
                            <button class="so-btn so-btn-primary so-btn-lg so-btn-block">Large Block</button>
                        </div>

                        <!-- Block Buttons with Icons -->
                        <h6 class="so-mb-3">Block Buttons with Icons</h6>
                        <div class="so-flex so-flex-col so-gap-2 so-mb-4" style="max-width: 400px;">
                            <button class="so-btn so-btn-primary so-btn-block">
                                <span class="material-icons">download</span>
                                Download File
                            </button>
                            <button class="so-btn so-btn-success so-btn-block">
                                <span class="material-icons">check_circle</span>
                                Confirm Action
                            </button>
                            <button class="so-btn so-btn-outline-danger so-btn-block">
                                <span class="material-icons">delete</span>
                                Delete Item
                            </button>
                            <button class="so-btn so-btn-light-info so-btn-block">
                                Upload Document
                                <span class="material-icons">upload</span>
                            </button>
                        </div>

                        <hr class="so-my-4">

                        <!-- Basic Block Groups -->
                        <h6 class="so-mb-3">Block Button Groups</h6>
                        <p class="so-text-muted so-mb-3">Add <code>.so-btn-group-block</code> class to make button groups full width with equally distributed buttons.</p>
                        <h6 class="so-mb-3">Basic Block Button Groups</h6>
                        <div class="so-flex so-flex-col so-gap-3 so-mb-4" style="max-width: 500px;">
                            <div class="so-btn-group so-btn-group-block">
                                <button type="button" class="so-btn so-btn-primary">Left</button>
                                <button type="button" class="so-btn so-btn-primary">Middle</button>
                                <button type="button" class="so-btn so-btn-primary">Right</button>
                            </div>
                            <div class="so-btn-group so-btn-group-block">
                                <button type="button" class="so-btn so-btn-outline-primary">Left</button>
                                <button type="button" class="so-btn so-btn-outline-primary">Middle</button>
                                <button type="button" class="so-btn so-btn-outline-primary">Right</button>
                            </div>
                            <div class="so-btn-group so-btn-group-block">
                                <button type="button" class="so-btn so-btn-secondary">Left</button>
                                <button type="button" class="so-btn so-btn-secondary">Middle</button>
                                <button type="button" class="so-btn so-btn-secondary">Right</button>
                            </div>
                        </div>

                        <!-- Contextual Block Groups -->
                        <h6 class="so-mb-3">Contextual Block Groups</h6>
                        <div class="so-flex so-flex-col so-gap-3 so-mb-4" style="max-width: 500px;">
                            <div class="so-btn-group so-btn-group-block">
                                <button type="button" class="so-btn so-btn-success">Yes</button>
                                <button type="button" class="so-btn so-btn-danger">No</button>
                            </div>
                            <div class="so-btn-group so-btn-group-block">
                                <button type="button" class="so-btn so-btn-outline-success">Approve</button>
                                <button type="button" class="so-btn so-btn-outline-warning">Pending</button>
                                <button type="button" class="so-btn so-btn-outline-danger">Reject</button>
                            </div>
                            <div class="so-btn-group so-btn-group-block">
                                <button type="button" class="so-btn so-btn-info">Info</button>
                                <button type="button" class="so-btn so-btn-warning">Warning</button>
                                <button type="button" class="so-btn so-btn-danger">Danger</button>
                            </div>
                        </div>

                        <!-- Block Group Sizes -->
                        <h6 class="so-mb-3">Block Group Sizes</h6>
                        <div class="so-flex so-flex-col so-gap-3 so-mb-4" style="max-width: 500px;">
                            <div class="so-btn-group so-btn-group-xs so-btn-group-block">
                                <button type="button" class="so-btn so-btn-primary">Extra Small</button>
                                <button type="button" class="so-btn so-btn-primary">Block</button>
                                <button type="button" class="so-btn so-btn-primary">Group</button>
                            </div>
                            <div class="so-btn-group so-btn-group-sm so-btn-group-block">
                                <button type="button" class="so-btn so-btn-primary">Small</button>
                                <button type="button" class="so-btn so-btn-primary">Block</button>
                                <button type="button" class="so-btn so-btn-primary">Group</button>
                            </div>
                            <div class="so-btn-group so-btn-group-block">
                                <button type="button" class="so-btn so-btn-primary">Default</button>
                                <button type="button" class="so-btn so-btn-primary">Block</button>
                                <button type="button" class="so-btn so-btn-primary">Group</button>
                            </div>
                            <div class="so-btn-group so-btn-group-lg so-btn-group-block">
                                <button type="button" class="so-btn so-btn-primary">Large</button>
                                <button type="button" class="so-btn so-btn-primary">Block</button>
                                <button type="button" class="so-btn so-btn-primary">Group</button>
                            </div>
                        </div>

                        <!-- Block Groups with Icons -->
                        <h6 class="so-mb-3">Block Groups with Icons</h6>
                        <div class="so-flex so-flex-col so-gap-3 so-mb-4" style="max-width: 500px;">
                            <div class="so-btn-group so-btn-group-block">
                                <button type="button" class="so-btn so-btn-primary">
                                    <span class="material-icons">thumb_up</span>
                                    Like
                                </button>
                                <button type="button" class="so-btn so-btn-primary">
                                    <span class="material-icons">comment</span>
                                    Comment
                                </button>
                                <button type="button" class="so-btn so-btn-primary">
                                    <span class="material-icons">share</span>
                                    Share
                                </button>
                            </div>
                            <div class="so-btn-group so-btn-group-block">
                                <button type="button" class="so-btn so-btn-outline-secondary">
                                    <span class="material-icons">edit</span>
                                    Edit
                                </button>
                                <button type="button" class="so-btn so-btn-outline-secondary">
                                    <span class="material-icons">content_copy</span>
                                    Copy
                                </button>
                                <button type="button" class="so-btn so-btn-outline-danger">
                                    <span class="material-icons">delete</span>
                                    Delete
                                </button>
                            </div>
                        </div>

                        <!-- Block Toggle Groups -->
                        <h6 class="so-mb-3">Block Toggle Groups</h6>
                        <div class="so-flex so-flex-col so-gap-3 so-mb-4" style="max-width: 500px;">
                            <div class="so-btn-group so-btn-group-toggle so-btn-group-block" data-so-toggle="buttons" data-toggle-type="radio">
                                <button type="button" class="so-btn so-btn-outline-primary so-active" data-value="daily">Daily</button>
                                <button type="button" class="so-btn so-btn-outline-primary" data-value="weekly">Weekly</button>
                                <button type="button" class="so-btn so-btn-outline-primary" data-value="monthly">Monthly</button>
                            </div>
                            <div class="so-btn-group so-btn-group-toggle so-btn-group-block" data-so-toggle="buttons" data-toggle-type="checkbox">
                                <button type="button" class="so-btn so-btn-light-primary so-active" data-value="bold">
                                    <span class="material-icons">format_bold</span>
                                </button>
                                <button type="button" class="so-btn so-btn-light-primary" data-value="italic">
                                    <span class="material-icons">format_italic</span>
                                </button>
                                <button type="button" class="so-btn so-btn-light-primary so-active" data-value="underline">
                                    <span class="material-icons">format_underlined</span>
                                </button>
                                <button type="button" class="so-btn so-btn-light-primary" data-value="strikethrough">
                                    <span class="material-icons">strikethrough_s</span>
                                </button>
                            </div>
                        </div>

                        <!-- Vertical Block Groups -->
                        <h6 class="so-mb-3">Vertical Block Groups</h6>
                        <div class="so-flex so-gap-4 so-mb-4">
                            <div style="width: 200px;">
                                <div class="so-btn-group so-btn-group-vertical so-btn-group-block">
                                    <button type="button" class="so-btn so-btn-primary">Top</button>
                                    <button type="button" class="so-btn so-btn-primary">Middle</button>
                                    <button type="button" class="so-btn so-btn-primary">Bottom</button>
                                </div>
                            </div>
                            <div style="width: 200px;">
                                <div class="so-btn-group so-btn-group-vertical so-btn-group-block">
                                    <button type="button" class="so-btn so-btn-outline-secondary">
                                        <span class="material-icons">home</span>
                                        Home
                                    </button>
                                    <button type="button" class="so-btn so-btn-outline-secondary">
                                        <span class="material-icons">settings</span>
                                        Settings
                                    </button>
                                    <button type="button" class="so-btn so-btn-outline-secondary">
                                        <span class="material-icons">help</span>
                                        Help
                                    </button>
                                </div>
                            </div>
                        </div>

<?= so_code_block('<!-- ============================================ -->
<!-- SINGLE BLOCK BUTTONS -->
<!-- ============================================ -->

<!-- Solid Block Buttons -->
<button class="so-btn so-btn-primary so-btn-block">Primary Block</button>
<button class="so-btn so-btn-secondary so-btn-block">Secondary Block</button>
<button class="so-btn so-btn-success so-btn-block">Success Block</button>
<button class="so-btn so-btn-danger so-btn-block">Danger Block</button>

<!-- Outline Block Buttons -->
<button class="so-btn so-btn-outline-primary so-btn-block">Outline Primary</button>
<button class="so-btn so-btn-outline-danger so-btn-block">Outline Danger</button>

<!-- Light (Soft) Block Buttons -->
<button class="so-btn so-btn-light-primary so-btn-block">Light Primary</button>
<button class="so-btn so-btn-light-success so-btn-block">Light Success</button>

<!-- Ghost Block Buttons -->
<button class="so-btn so-btn-ghost so-btn-primary so-btn-block">Ghost Primary</button>

<!-- Link Block Buttons -->
<button class="so-btn so-btn-link so-btn-block">Link Block</button>

<!-- Block Button Sizes -->
<button class="so-btn so-btn-primary so-btn-xs so-btn-block">Extra Small</button>
<button class="so-btn so-btn-primary so-btn-sm so-btn-block">Small</button>
<button class="so-btn so-btn-primary so-btn-block">Default</button>
<button class="so-btn so-btn-primary so-btn-lg so-btn-block">Large</button>

<!-- Block Buttons with Icons -->
<button class="so-btn so-btn-primary so-btn-block">
    <span class="material-icons">download</span>
    Download File
</button>

<!-- ============================================ -->
<!-- BLOCK BUTTON GROUPS -->
<!-- ============================================ -->

<!-- Basic Block Button Group -->
<div class="so-btn-group so-btn-group-block">
    <button type="button" class="so-btn so-btn-primary">Left</button>
    <button type="button" class="so-btn so-btn-primary">Middle</button>
    <button type="button" class="so-btn so-btn-primary">Right</button>
</div>

<!-- Outline Block Group -->
<div class="so-btn-group so-btn-group-block">
    <button type="button" class="so-btn so-btn-outline-primary">Left</button>
    <button type="button" class="so-btn so-btn-outline-primary">Middle</button>
    <button type="button" class="so-btn so-btn-outline-primary">Right</button>
</div>

<!-- Contextual Block Groups -->
<div class="so-btn-group so-btn-group-block">
    <button type="button" class="so-btn so-btn-success">Approve</button>
    <button type="button" class="so-btn so-btn-warning">Pending</button>
    <button type="button" class="so-btn so-btn-danger">Reject</button>
</div>

<!-- Block Group with Size -->
<div class="so-btn-group so-btn-group-lg so-btn-group-block">
    <button type="button" class="so-btn so-btn-primary">Large Block</button>
    <button type="button" class="so-btn so-btn-primary">Group</button>
</div>

<!-- Block Group with Icons -->
<div class="so-btn-group so-btn-group-block">
    <button type="button" class="so-btn so-btn-primary">
        <span class="material-icons">thumb_up</span>
        Like
    </button>
    <button type="button" class="so-btn so-btn-primary">
        <span class="material-icons">share</span>
        Share
    </button>
</div>

<!-- Block Toggle Group -->
<div class="so-btn-group so-btn-group-toggle so-btn-group-block" data-so-toggle="buttons" data-toggle-type="radio">
    <button type="button" class="so-btn so-btn-outline-primary so-active" data-value="daily">Daily</button>
    <button type="button" class="so-btn so-btn-outline-primary" data-value="weekly">Weekly</button>
    <button type="button" class="so-btn so-btn-outline-primary" data-value="monthly">Monthly</button>
</div>

<!-- Vertical Block Group -->
<div class="so-btn-group so-btn-group-vertical so-btn-group-block">
    <button type="button" class="so-btn so-btn-primary">Top</button>
    <button type="button" class="so-btn so-btn-primary">Middle</button>
    <button type="button" class="so-btn so-btn-primary">Bottom</button>
</div>', 'html') ?>
                    </div>
                </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
