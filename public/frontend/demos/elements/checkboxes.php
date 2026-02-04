<?php
/**
 * SixOrbit UI Demo - Checkboxes & Radios
 */
$pageTitle = 'Checkboxes & Radios';
$pageDescription = 'Checkbox and radio input components';

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
            <h1 class="so-page-title">Checkboxes &amp; Radios</h1>
            <p class="so-page-subtitle">Checkbox and radio input components</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Section 1: Basic Checkboxes -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Checkboxes</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1" class="so-demo-grid-gap">
                            <div>
                                <h5 class="so-mb-3" class="so-demo-section-title">States</h5>
                                <div class="so-checkbox-group so-checkbox-group-vertical">
                                    <label class="so-checkbox">
                                        <input type="checkbox">
                                        <span class="so-checkbox-box">
                                            <span class="material-icons">check</span>
                                        </span>
                                        <span class="so-checkbox-label">Default checkbox</span>
                                    </label>
                                    <label class="so-checkbox">
                                        <input type="checkbox" checked>
                                        <span class="so-checkbox-box">
                                            <span class="material-icons">check</span>
                                        </span>
                                        <span class="so-checkbox-label">Checked checkbox</span>
                                    </label>
                                    <label class="so-checkbox" id="indeterminate-checkbox">
                                        <input type="checkbox">
                                        <span class="so-checkbox-box">
                                            <span class="material-icons">remove</span>
                                        </span>
                                        <span class="so-checkbox-label">Indeterminate checkbox</span>
                                    </label>
                                    <label class="so-checkbox so-disabled">
                                        <input type="checkbox" disabled>
                                        <span class="so-checkbox-box">
                                            <span class="material-icons">check</span>
                                        </span>
                                        <span class="so-checkbox-label">Disabled checkbox</span>
                                    </label>
                                    <label class="so-checkbox so-disabled">
                                        <input type="checkbox" checked disabled>
                                        <span class="so-checkbox-box">
                                            <span class="material-icons">check</span>
                                        </span>
                                        <span class="so-checkbox-label">Disabled checked</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <h5 class="so-mb-3" class="so-demo-section-title">Inline Layout</h5>
                                <div class="so-checkbox-group so-checkbox-group-inline so-mb-4">
                                    <label class="so-checkbox">
                                        <input type="checkbox" checked>
                                        <span class="so-checkbox-box">
                                            <span class="material-icons">check</span>
                                        </span>
                                        <span class="so-checkbox-label">Option A</span>
                                    </label>
                                    <label class="so-checkbox">
                                        <input type="checkbox">
                                        <span class="so-checkbox-box">
                                            <span class="material-icons">check</span>
                                        </span>
                                        <span class="so-checkbox-label">Option B</span>
                                    </label>
                                    <label class="so-checkbox">
                                        <input type="checkbox">
                                        <span class="so-checkbox-box">
                                            <span class="material-icons">check</span>
                                        </span>
                                        <span class="so-checkbox-label">Option C</span>
                                    </label>
                                </div>

                                <h5 class="so-mb-3" class="so-demo-section-title">Without Label</h5>
                                <div class="so-flex so-gap-3">
                                    <label class="so-checkbox">
                                        <input type="checkbox">
                                        <span class="so-checkbox-box">
                                            <span class="material-icons">check</span>
                                        </span>
                                    </label>
                                    <label class="so-checkbox">
                                        <input type="checkbox" checked>
                                        <span class="so-checkbox-box">
                                            <span class="material-icons">check</span>
                                        </span>
                                    </label>
                                    <label class="so-checkbox" id="indeterminate-checkbox-2">
                                        <input type="checkbox">
                                        <span class="so-checkbox-box">
                                            <span class="material-icons">remove</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?= so_code_block('<!-- Default Checkbox -->
<label class="so-checkbox">
    <input type="checkbox">
    <span class="so-checkbox-box">
        <span class="material-icons">check</span>
    </span>
    <span class="so-checkbox-label">Default checkbox</span>
</label>

<!-- Indeterminate (set via JavaScript) -->
<label class="so-checkbox">
    <input type="checkbox" id="myCheckbox">
    <span class="so-checkbox-box">
        <span class="material-icons">remove</span>
    </span>
    <span class="so-checkbox-label">Indeterminate</span>
</label>
<script>document.getElementById(\'myCheckbox\').indeterminate = true;</script>

<!-- Disabled -->
<label class="so-checkbox so-disabled">
    <input type="checkbox" disabled>
    ...
</label>

<!-- Inline Group -->
<div class="so-checkbox-group so-checkbox-group-inline">
    <label class="so-checkbox">...</label>
    <label class="so-checkbox">...</label>
</div>

<!-- Vertical Group -->
<div class="so-checkbox-group so-checkbox-group-vertical">
    <label class="so-checkbox">...</label>
    <label class="so-checkbox">...</label>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Section 2: Checkbox Sizes -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Checkbox Sizes</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-flex so-gap-5 so-items-start so-flex-wrap">
                            <label class="so-checkbox so-checkbox-sm">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Small</span>
                            </label>
                            <label class="so-checkbox">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Default</span>
                            </label>
                            <label class="so-checkbox so-checkbox-lg">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Large</span>
                            </label>
                        </div>
                        <?= so_code_block('<label class="so-checkbox so-checkbox-sm">...</label>
<label class="so-checkbox">...</label>
<label class="so-checkbox so-checkbox-lg">...</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 3: Checkbox Colors -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Checkbox Colors</h3>
                    </div>
                    <div class="so-card-body">
                        <h5 class="so-mb-3" class="so-demo-section-title">Color Variants</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <label class="so-checkbox so-checkbox-primary">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Primary</span>
                            </label>
                            <label class="so-checkbox so-checkbox-secondary">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Secondary</span>
                            </label>
                            <label class="so-checkbox so-checkbox-success">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Success</span>
                            </label>
                            <label class="so-checkbox so-checkbox-danger">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Danger</span>
                            </label>
                            <label class="so-checkbox so-checkbox-warning">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Warning</span>
                            </label>
                            <label class="so-checkbox so-checkbox-info">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Info</span>
                            </label>
                            <label class="so-checkbox so-checkbox-light">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Light</span>
                            </label>
                            <label class="so-checkbox so-checkbox-dark">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Dark</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3" class="so-demo-section-title">With Contextual Labels (label color matches when checked)</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap">
                            <label class="so-checkbox so-checkbox-primary so-checkbox-label-contextual">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Primary</span>
                            </label>
                            <label class="so-checkbox so-checkbox-success so-checkbox-label-contextual">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Success</span>
                            </label>
                            <label class="so-checkbox so-checkbox-danger so-checkbox-label-contextual">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Danger</span>
                            </label>
                            <label class="so-checkbox so-checkbox-warning so-checkbox-label-contextual">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Warning</span>
                            </label>
                            <label class="so-checkbox so-checkbox-info so-checkbox-label-contextual">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Info</span>
                            </label>
                            <label class="so-checkbox so-checkbox-secondary so-checkbox-label-contextual">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Secondary</span>
                            </label>
                            <label class="so-checkbox so-checkbox-light so-checkbox-label-contextual">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Light</span>
                            </label>
                            <label class="so-checkbox so-checkbox-dark so-checkbox-label-contextual">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Dark</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Color variant -->
<label class="so-checkbox so-checkbox-primary">...</label>
<label class="so-checkbox so-checkbox-success">...</label>
<label class="so-checkbox so-checkbox-danger">...</label>
<label class="so-checkbox so-checkbox-warning">...</label>
<label class="so-checkbox so-checkbox-info">...</label>
<label class="so-checkbox so-checkbox-secondary">...</label>
<label class="so-checkbox so-checkbox-light">...</label>
<label class="so-checkbox so-checkbox-dark">...</label>

<!-- With contextual label color (label matches when checked) -->
<label class="so-checkbox so-checkbox-success so-checkbox-label-contextual">
    <input type="checkbox">
    <span class="so-checkbox-box">
        <span class="material-icons">check</span>
    </span>
    <span class="so-checkbox-label">Success</span>
</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 4: Radio Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Radio Buttons</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1" class="so-demo-grid-gap">
                            <div>
                                <h5 class="so-mb-3" class="so-demo-section-title">Vertical Group (Default)</h5>
                                <div class="so-radio-group so-radio-group-vertical">
                                    <label class="so-radio">
                                        <input type="radio" name="radio-demo-1" value="1">
                                        <span class="so-radio-circle"></span>
                                        <span class="so-radio-label">Option 1</span>
                                    </label>
                                    <label class="so-radio">
                                        <input type="radio" name="radio-demo-1" value="2" checked>
                                        <span class="so-radio-circle"></span>
                                        <span class="so-radio-label">Option 2 (Selected)</span>
                                    </label>
                                    <label class="so-radio">
                                        <input type="radio" name="radio-demo-1" value="3">
                                        <span class="so-radio-circle"></span>
                                        <span class="so-radio-label">Option 3</span>
                                    </label>
                                    <label class="so-radio so-disabled">
                                        <input type="radio" name="radio-demo-1" value="4" disabled>
                                        <span class="so-radio-circle"></span>
                                        <span class="so-radio-label">Disabled option</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <h5 class="so-mb-3" class="so-demo-section-title">Inline Layout</h5>
                                <div class="so-radio-group so-radio-group-inline so-mb-4">
                                    <label class="so-radio">
                                        <input type="radio" name="radio-demo-2" value="a" checked>
                                        <span class="so-radio-circle"></span>
                                        <span class="so-radio-label">Option A</span>
                                    </label>
                                    <label class="so-radio">
                                        <input type="radio" name="radio-demo-2" value="b">
                                        <span class="so-radio-circle"></span>
                                        <span class="so-radio-label">Option B</span>
                                    </label>
                                    <label class="so-radio">
                                        <input type="radio" name="radio-demo-2" value="c">
                                        <span class="so-radio-circle"></span>
                                        <span class="so-radio-label">Option C</span>
                                    </label>
                                </div>

                                <h5 class="so-mb-3" class="so-demo-section-title">Without Label</h5>
                                <div class="so-flex so-gap-3">
                                    <label class="so-radio">
                                        <input type="radio" name="radio-demo-3" value="1">
                                        <span class="so-radio-circle"></span>
                                    </label>
                                    <label class="so-radio">
                                        <input type="radio" name="radio-demo-3" value="2" checked>
                                        <span class="so-radio-circle"></span>
                                    </label>
                                    <label class="so-radio">
                                        <input type="radio" name="radio-demo-3" value="3">
                                        <span class="so-radio-circle"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?= so_code_block('<!-- Radio Button -->
<label class="so-radio">
    <input type="radio" name="group" value="1">
    <span class="so-radio-circle"></span>
    <span class="so-radio-label">Option 1</span>
</label>

<!-- Vertical Group -->
<div class="so-radio-group so-radio-group-vertical">
    <label class="so-radio">...</label>
    <label class="so-radio">...</label>
</div>

<!-- Inline Group -->
<div class="so-radio-group so-radio-group-inline">
    <label class="so-radio">...</label>
    <label class="so-radio">...</label>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Section 5: Radio Sizes -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Radio Sizes</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-flex so-gap-5 so-items-start so-flex-wrap">
                            <label class="so-radio so-radio-sm">
                                <input type="radio" name="radio-size" value="sm" checked>
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Small</span>
                            </label>
                            <label class="so-radio">
                                <input type="radio" name="radio-size" value="md">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Default</span>
                            </label>
                            <label class="so-radio so-radio-lg">
                                <input type="radio" name="radio-size" value="lg">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Large</span>
                            </label>
                        </div>
                        <?= so_code_block('<label class="so-radio so-radio-sm">...</label>
<label class="so-radio">...</label>
<label class="so-radio so-radio-lg">...</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 6: Radio Colors -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Radio Colors</h3>
                    </div>
                    <div class="so-card-body">
                        <h5 class="so-mb-3" class="so-demo-section-title">Color Variants</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <label class="so-radio so-radio-primary">
                                <input type="radio" name="radio-color" value="primary" checked>
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Primary</span>
                            </label>
                            <label class="so-radio so-radio-secondary">
                                <input type="radio" name="radio-color" value="secondary">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Secondary</span>
                            </label>
                            <label class="so-radio so-radio-success">
                                <input type="radio" name="radio-color" value="success">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Success</span>
                            </label>
                            <label class="so-radio so-radio-danger">
                                <input type="radio" name="radio-color" value="danger">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Danger</span>
                            </label>
                            <label class="so-radio so-radio-warning">
                                <input type="radio" name="radio-color" value="warning">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Warning</span>
                            </label>
                            <label class="so-radio so-radio-info">
                                <input type="radio" name="radio-color" value="info">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Info</span>
                            </label>
                            <label class="so-radio so-radio-light">
                                <input type="radio" name="radio-color" value="light">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Light</span>
                            </label>
                            <label class="so-radio so-radio-dark">
                                <input type="radio" name="radio-color" value="dark">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Dark</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3" class="so-demo-section-title">With Contextual Labels (label color matches when selected)</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap">
                            <label class="so-radio so-radio-primary so-radio-label-contextual">
                                <input type="radio" name="radio-color-contextual" value="primary" checked>
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Primary</span>
                            </label>
                            <label class="so-radio so-radio-success so-radio-label-contextual">
                                <input type="radio" name="radio-color-contextual" value="success">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Success</span>
                            </label>
                            <label class="so-radio so-radio-danger so-radio-label-contextual">
                                <input type="radio" name="radio-color-contextual" value="danger">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Danger</span>
                            </label>
                            <label class="so-radio so-radio-warning so-radio-label-contextual">
                                <input type="radio" name="radio-color-contextual" value="warning">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Warning</span>
                            </label>
                            <label class="so-radio so-radio-info so-radio-label-contextual">
                                <input type="radio" name="radio-color-contextual" value="info">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Info</span>
                            </label>
                            <label class="so-radio so-radio-secondary so-radio-label-contextual">
                                <input type="radio" name="radio-color-contextual" value="secondary">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Secondary</span>
                            </label>
                            <label class="so-radio so-radio-light so-radio-label-contextual">
                                <input type="radio" name="radio-color-contextual" value="light">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Light</span>
                            </label>
                            <label class="so-radio so-radio-dark so-radio-label-contextual">
                                <input type="radio" name="radio-color-contextual" value="dark">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Dark</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Color variant -->
<label class="so-radio so-radio-primary">...</label>
<label class="so-radio so-radio-success">...</label>
<label class="so-radio so-radio-danger">...</label>
<label class="so-radio so-radio-secondary">...</label>
<label class="so-radio so-radio-light">...</label>
<label class="so-radio so-radio-dark">...</label>

<!-- With contextual label color -->
<label class="so-radio so-radio-success so-radio-label-contextual">
    <input type="radio" name="group" value="1">
    <span class="so-radio-circle"></span>
    <span class="so-radio-label">Success</span>
</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 7: Switches -->
                <div class="so-card so-mt-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Switches</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1" class="so-demo-grid-gap">
                            <div>
                                <h5 class="so-mb-3" class="so-demo-section-title">Basic Switches</h5>
                                <div class="so-flex so-flex-col so-gap-3">
                                    <label class="so-switch">
                                        <input type="checkbox">
                                        <span class="so-switch-track"></span>
                                        <span class="so-switch-label">Default switch</span>
                                    </label>
                                    <label class="so-switch">
                                        <input type="checkbox" checked>
                                        <span class="so-switch-track"></span>
                                        <span class="so-switch-label">Checked switch</span>
                                    </label>
                                    <label class="so-switch so-disabled">
                                        <input type="checkbox" disabled>
                                        <span class="so-switch-track"></span>
                                        <span class="so-switch-label">Disabled switch</span>
                                    </label>
                                    <label class="so-switch so-disabled">
                                        <input type="checkbox" checked disabled>
                                        <span class="so-switch-track"></span>
                                        <span class="so-switch-label">Disabled checked</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <h5 class="so-mb-3" class="so-demo-section-title">Switch Sizes</h5>
                                <div class="so-flex so-flex-col so-gap-3">
                                    <label class="so-switch so-switch-sm">
                                        <input type="checkbox" checked>
                                        <span class="so-switch-track"></span>
                                        <span class="so-switch-label">Small</span>
                                    </label>
                                    <label class="so-switch">
                                        <input type="checkbox" checked>
                                        <span class="so-switch-track"></span>
                                        <span class="so-switch-label">Default</span>
                                    </label>
                                    <label class="so-switch so-switch-lg">
                                        <input type="checkbox" checked>
                                        <span class="so-switch-track"></span>
                                        <span class="so-switch-label">Large</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <h5 class="so-mb-3 so-mt-4" class="so-demo-section-title">Color Variants</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <label class="so-switch so-switch-primary">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Primary</span>
                            </label>
                            <label class="so-switch so-switch-secondary">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Secondary</span>
                            </label>
                            <label class="so-switch so-switch-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Success</span>
                            </label>
                            <label class="so-switch so-switch-danger">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Danger</span>
                            </label>
                            <label class="so-switch so-switch-warning">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Warning</span>
                            </label>
                            <label class="so-switch so-switch-info">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Info</span>
                            </label>
                            <label class="so-switch so-switch-light">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Light</span>
                            </label>
                            <label class="so-switch so-switch-dark">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Dark</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3" class="so-demo-section-title">Contextual Label Colors</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <label class="so-switch so-switch-success so-switch-label-contextual">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Success contextual</span>
                            </label>
                            <label class="so-switch so-switch-danger so-switch-label-contextual">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Danger contextual</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3" class="so-demo-section-title">Switch with Inner Icons</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-icon so-switch-success">
                                <input type="checkbox">
                                <span class="so-switch-track">
                                    <span class="so-switch-on"><span class="material-icons">check</span></span>
                                    <span class="so-switch-off"><span class="material-icons">close</span></span>
                                </span>
                                <span class="so-switch-label">Icon switch</span>
                            </label>
                            <label class="so-switch so-switch-icon so-switch-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track">
                                    <span class="so-switch-on"><span class="material-icons">check</span></span>
                                    <span class="so-switch-off"><span class="material-icons">close</span></span>
                                </span>
                                <span class="so-switch-label">Checked</span>
                            </label>
                            <label class="so-switch so-switch-icon so-switch-danger">
                                <input type="checkbox" checked>
                                <span class="so-switch-track">
                                    <span class="so-switch-on"><span class="material-icons">notifications_active</span></span>
                                    <span class="so-switch-off"><span class="material-icons">notifications_off</span></span>
                                </span>
                                <span class="so-switch-label">Notifications</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3" class="so-demo-section-title">Switch with Inner Text</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-text so-switch-success">
                                <input type="checkbox">
                                <span class="so-switch-track">
                                    <span class="so-switch-on">ON</span>
                                    <span class="so-switch-off">OFF</span>
                                </span>
                                <span class="so-switch-label">Text switch</span>
                            </label>
                            <label class="so-switch so-switch-text so-switch-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track">
                                    <span class="so-switch-on">ON</span>
                                    <span class="so-switch-off">OFF</span>
                                </span>
                                <span class="so-switch-label">Checked</span>
                            </label>
                            <label class="so-switch so-switch-text so-switch-primary">
                                <input type="checkbox" checked>
                                <span class="so-switch-track">
                                    <span class="so-switch-on">YES</span>
                                    <span class="so-switch-off">NO</span>
                                </span>
                                <span class="so-switch-label">Yes/No</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3" class="so-demo-section-title">Switch with Icon + Text</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-icon-text so-switch-success">
                                <input type="checkbox">
                                <span class="so-switch-track">
                                    <span class="so-switch-on"><span class="material-icons">check</span>ON</span>
                                    <span class="so-switch-off">OFF<span class="material-icons">close</span></span>
                                </span>
                                <span class="so-switch-label">Icon + Text</span>
                            </label>
                            <label class="so-switch so-switch-icon-text so-switch-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track">
                                    <span class="so-switch-on"><span class="material-icons">check</span>ON</span>
                                    <span class="so-switch-off">OFF<span class="material-icons">close</span></span>
                                </span>
                                <span class="so-switch-label">Checked</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3" class="so-demo-section-title">Inner Switch Sizes</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center">
                            <label class="so-switch so-switch-icon so-switch-icon-sm so-switch-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track">
                                    <span class="so-switch-on"><span class="material-icons">check</span></span>
                                    <span class="so-switch-off"><span class="material-icons">close</span></span>
                                </span>
                                <span class="so-switch-label">Small</span>
                            </label>
                            <label class="so-switch so-switch-icon so-switch-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track">
                                    <span class="so-switch-on"><span class="material-icons">check</span></span>
                                    <span class="so-switch-off"><span class="material-icons">close</span></span>
                                </span>
                                <span class="so-switch-label">Default</span>
                            </label>
                            <label class="so-switch so-switch-icon so-switch-icon-lg so-switch-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track">
                                    <span class="so-switch-on"><span class="material-icons">check</span></span>
                                    <span class="so-switch-off"><span class="material-icons">close</span></span>
                                </span>
                                <span class="so-switch-label">Large</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Basic Switch -->
<label class="so-switch">
    <input type="checkbox">
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Switch label</span>
</label>

<!-- Size Variants -->
<label class="so-switch so-switch-sm">...</label>
<label class="so-switch">...</label>
<label class="so-switch so-switch-lg">...</label>

<!-- Color Variants -->
<label class="so-switch so-switch-primary">...</label>
<label class="so-switch so-switch-success">...</label>
<label class="so-switch so-switch-danger">...</label>

<!-- Contextual Label Color -->
<label class="so-switch so-switch-success so-switch-label-contextual">
    <input type="checkbox" checked>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Success</span>
</label>

<!-- Switch with Inner Icons -->
<label class="so-switch so-switch-icon so-switch-success">
    <input type="checkbox">
    <span class="so-switch-track">
        <span class="so-switch-on"><span class="material-icons">check</span></span>
        <span class="so-switch-off"><span class="material-icons">close</span></span>
    </span>
    <span class="so-switch-label">Icon switch</span>
</label>

<!-- Switch with Inner Text -->
<label class="so-switch so-switch-text so-switch-success">
    <input type="checkbox">
    <span class="so-switch-track">
        <span class="so-switch-on">ON</span>
        <span class="so-switch-off">OFF</span>
    </span>
    <span class="so-switch-label">Text switch</span>
</label>

<!-- Switch with Icon + Text -->
<label class="so-switch so-switch-icon-text so-switch-success">
    <input type="checkbox">
    <span class="so-switch-track">
        <span class="so-switch-on"><span class="material-icons">check</span>ON</span>
        <span class="so-switch-off">OFF<span class="material-icons">close</span></span>
    </span>
    <span class="so-switch-label">Icon + Text</span>
</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 8: MUI-Style Soft/Muted Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Soft/Muted Variants (MUI-Style)</h3>
                        <span class="so-badge so-badge-primary">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Soft variants have a subtle, muted background and colored icon when checked - inspired by Material UI.</p>

                        <h5 class="so-mb-3">Soft Checkboxes</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <label class="so-checkbox so-checkbox-soft-primary">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Soft Primary</span>
                            </label>
                            <label class="so-checkbox so-checkbox-soft-success">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Soft Success</span>
                            </label>
                            <label class="so-checkbox so-checkbox-soft-danger">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Soft Danger</span>
                            </label>
                            <label class="so-checkbox so-checkbox-soft-warning">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Soft Warning</span>
                            </label>
                            <label class="so-checkbox so-checkbox-soft-info">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Soft Info</span>
                            </label>
                            <label class="so-checkbox so-checkbox-soft-secondary">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Soft Secondary</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Soft Radios</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <label class="so-radio so-radio-soft-primary">
                                <input type="radio" name="soft-radio" value="primary" checked>
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Soft Primary</span>
                            </label>
                            <label class="so-radio so-radio-soft-success">
                                <input type="radio" name="soft-radio" value="success">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Soft Success</span>
                            </label>
                            <label class="so-radio so-radio-soft-danger">
                                <input type="radio" name="soft-radio" value="danger">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Soft Danger</span>
                            </label>
                            <label class="so-radio so-radio-soft-warning">
                                <input type="radio" name="soft-radio" value="warning">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Soft Warning</span>
                            </label>
                            <label class="so-radio so-radio-soft-info">
                                <input type="radio" name="soft-radio" value="info">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Soft Info</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Soft Switches</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap">
                            <label class="so-switch so-switch-soft-primary">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Soft Primary</span>
                            </label>
                            <label class="so-switch so-switch-soft-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Soft Success</span>
                            </label>
                            <label class="so-switch so-switch-soft-danger">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Soft Danger</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Soft Checkbox -->
<label class="so-checkbox so-checkbox-soft-primary">
    <input type="checkbox">
    <span class="so-checkbox-box">
        <span class="material-icons">check</span>
    </span>
    <span class="so-checkbox-label">Soft Primary</span>
</label>

<!-- Soft Radio -->
<label class="so-radio so-radio-soft-success">
    <input type="radio" name="group" value="1">
    <span class="so-radio-circle"></span>
    <span class="so-radio-label">Soft Success</span>
</label>

<!-- Soft Switch -->
<label class="so-switch so-switch-soft-danger">
    <input type="checkbox">
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Soft Danger</span>
</label>

<!-- Available: soft-primary, soft-secondary, soft-success, soft-danger, soft-warning, soft-info -->', 'html') ?>
                    </div>
                </div>

                <!-- Section 9: Outlined Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Outlined Variants (MUI-Style)</h3>
                        <span class="so-badge so-badge-primary">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Outlined variants show only border and icon colors - no filled background when checked.</p>

                        <h5 class="so-mb-3">Outlined Checkboxes</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <label class="so-checkbox so-checkbox-outlined-primary">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Outlined Primary</span>
                            </label>
                            <label class="so-checkbox so-checkbox-outlined-success">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Outlined Success</span>
                            </label>
                            <label class="so-checkbox so-checkbox-outlined-danger">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Outlined Danger</span>
                            </label>
                            <label class="so-checkbox so-checkbox-outlined-warning">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Outlined Warning</span>
                            </label>
                            <label class="so-checkbox so-checkbox-outlined-info">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Outlined Info</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Outlined Radios</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap">
                            <label class="so-radio so-radio-outlined-primary">
                                <input type="radio" name="outlined-radio" value="primary" checked>
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Outlined Primary</span>
                            </label>
                            <label class="so-radio so-radio-outlined-success">
                                <input type="radio" name="outlined-radio" value="success">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Outlined Success</span>
                            </label>
                            <label class="so-radio so-radio-outlined-danger">
                                <input type="radio" name="outlined-radio" value="danger">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Outlined Danger</span>
                            </label>
                            <label class="so-radio so-radio-outlined-warning">
                                <input type="radio" name="outlined-radio" value="warning">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Outlined Warning</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Outlined Checkbox -->
<label class="so-checkbox so-checkbox-outlined-primary">
    <input type="checkbox">
    <span class="so-checkbox-box">
        <span class="material-icons">check</span>
    </span>
    <span class="so-checkbox-label">Outlined Primary</span>
</label>

<!-- Outlined Radio -->
<label class="so-radio so-radio-outlined-success">
    <input type="radio" name="group" value="1">
    <span class="so-radio-circle"></span>
    <span class="so-radio-label">Outlined Success</span>
</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 10: Filled Style -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Filled Style Variants</h3>
                        <span class="so-badge so-badge-primary">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Filled variants have a subtle background even when unchecked, creating a more prominent visual style.</p>

                        <h5 class="so-mb-3">Filled Checkboxes</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <label class="so-checkbox so-checkbox-filled so-checkbox-filled-primary">
                                <input type="checkbox">
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Unchecked</span>
                            </label>
                            <label class="so-checkbox so-checkbox-filled so-checkbox-filled-primary">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Filled Primary</span>
                            </label>
                            <label class="so-checkbox so-checkbox-filled so-checkbox-filled-success">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Filled Success</span>
                            </label>
                            <label class="so-checkbox so-checkbox-filled so-checkbox-filled-danger">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Filled Danger</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Filled Radios</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap">
                            <label class="so-radio so-radio-filled so-radio-filled-primary">
                                <input type="radio" name="filled-radio" value="primary" checked>
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Filled Primary</span>
                            </label>
                            <label class="so-radio so-radio-filled so-radio-filled-success">
                                <input type="radio" name="filled-radio" value="success">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Filled Success</span>
                            </label>
                            <label class="so-radio so-radio-filled so-radio-filled-danger">
                                <input type="radio" name="filled-radio" value="danger">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Filled Danger</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Filled Checkbox -->
<label class="so-checkbox so-checkbox-filled so-checkbox-filled-primary">
    <input type="checkbox">
    <span class="so-checkbox-box">
        <span class="material-icons">check</span>
    </span>
    <span class="so-checkbox-label">Filled Primary</span>
</label>

<!-- Filled Radio -->
<label class="so-radio so-radio-filled so-radio-filled-success">
    <input type="radio" name="group" value="1">
    <span class="so-radio-circle"></span>
    <span class="so-radio-label">Filled Success</span>
</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 11: iOS-Style Switches -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">iOS-Style Switches</h3>
                        <span class="so-badge so-badge-primary">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Clean, rounded iOS-inspired switch design with smooth animations.</p>

                        <h5 class="so-mb-3">Default iOS Switch</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-ios">
                                <input type="checkbox">
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Off</span>
                            </label>
                            <label class="so-switch so-switch-ios">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">On</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">iOS Switch Color Variants</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-ios so-switch-ios-primary">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Primary</span>
                            </label>
                            <label class="so-switch so-switch-ios so-switch-ios-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Success</span>
                            </label>
                            <label class="so-switch so-switch-ios so-switch-ios-danger">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Danger</span>
                            </label>
                            <label class="so-switch so-switch-ios so-switch-ios-warning">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Warning</span>
                            </label>
                            <label class="so-switch so-switch-ios so-switch-ios-info">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Info</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">iOS Switch Sizes</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center">
                            <label class="so-switch so-switch-ios so-switch-ios-sm">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Small</span>
                            </label>
                            <label class="so-switch so-switch-ios">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Default</span>
                            </label>
                            <label class="so-switch so-switch-ios so-switch-ios-lg">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Large</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- iOS Style Switch -->
<label class="so-switch so-switch-ios">
    <input type="checkbox">
    <span class="so-switch-track"></span>
    <span class="so-switch-label">iOS Switch</span>
</label>

<!-- iOS Switch with Color -->
<label class="so-switch so-switch-ios so-switch-ios-primary">...</label>
<label class="so-switch so-switch-ios so-switch-ios-success">...</label>
<label class="so-switch so-switch-ios so-switch-ios-danger">...</label>

<!-- iOS Switch Sizes -->
<label class="so-switch so-switch-ios so-switch-ios-sm">...</label>
<label class="so-switch so-switch-ios">...</label>
<label class="so-switch so-switch-ios so-switch-ios-lg">...</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 12: Android/Material Switches -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Android/Material Switches</h3>
                        <span class="so-badge so-badge-primary">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Material Design 2 style switch with elevated thumb and hover ripple effect.</p>

                        <h5 class="so-mb-3">Default Android Switch</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-android">
                                <input type="checkbox">
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Off</span>
                            </label>
                            <label class="so-switch so-switch-android">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">On</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Android Switch Color Variants</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-android so-switch-android-primary">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Primary</span>
                            </label>
                            <label class="so-switch so-switch-android so-switch-android-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Success</span>
                            </label>
                            <label class="so-switch so-switch-android so-switch-android-danger">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Danger</span>
                            </label>
                            <label class="so-switch so-switch-android so-switch-android-warning">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Warning</span>
                            </label>
                            <label class="so-switch so-switch-android so-switch-android-info">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Info</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Android Switch Sizes</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center">
                            <label class="so-switch so-switch-android so-switch-android-sm">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Small</span>
                            </label>
                            <label class="so-switch so-switch-android">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Default</span>
                            </label>
                            <label class="so-switch so-switch-android so-switch-android-lg">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Large</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Android/Material Style Switch -->
<label class="so-switch so-switch-android">
    <input type="checkbox">
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Android Switch</span>
</label>

<!-- Android Switch with Color -->
<label class="so-switch so-switch-android so-switch-android-primary">...</label>
<label class="so-switch so-switch-android so-switch-android-success">...</label>

<!-- Android Switch Sizes -->
<label class="so-switch so-switch-android so-switch-android-sm">...</label>
<label class="so-switch so-switch-android so-switch-android-lg">...</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 13: Material 3 Switches -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Material 3 Switches</h3>
                        <span class="so-badge so-badge-primary">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Latest Material Design 3 style with bordered track and expanding thumb.</p>

                        <h5 class="so-mb-3">Default M3 Switch</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-m3">
                                <input type="checkbox">
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Off</span>
                            </label>
                            <label class="so-switch so-switch-m3">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">On</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">M3 Switch Color Variants</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-m3 so-switch-m3-primary">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Primary</span>
                            </label>
                            <label class="so-switch so-switch-m3 so-switch-m3-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Success</span>
                            </label>
                            <label class="so-switch so-switch-m3 so-switch-m3-danger">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Danger</span>
                            </label>
                            <label class="so-switch so-switch-m3 so-switch-m3-warning">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Warning</span>
                            </label>
                            <label class="so-switch so-switch-m3 so-switch-m3-info">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Info</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">M3 Switch with Icons</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-m3 so-switch-m3-success">
                                <input type="checkbox">
                                <span class="so-switch-track">
                                    <span class="so-switch-icon-on material-icons">check</span>
                                    <span class="so-switch-icon-off material-icons">close</span>
                                </span>
                                <span class="so-switch-label">With Icons (Off)</span>
                            </label>
                            <label class="so-switch so-switch-m3 so-switch-m3-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track">
                                    <span class="so-switch-icon-on material-icons">check</span>
                                    <span class="so-switch-icon-off material-icons">close</span>
                                </span>
                                <span class="so-switch-label">With Icons (On)</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">M3 Switch Sizes</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center">
                            <label class="so-switch so-switch-m3 so-switch-m3-sm">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Small</span>
                            </label>
                            <label class="so-switch so-switch-m3">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Default</span>
                            </label>
                            <label class="so-switch so-switch-m3 so-switch-m3-lg">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Large</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Material 3 Style Switch -->
<label class="so-switch so-switch-m3">
    <input type="checkbox">
    <span class="so-switch-track"></span>
    <span class="so-switch-label">M3 Switch</span>
</label>

<!-- M3 Switch with Icons -->
<label class="so-switch so-switch-m3 so-switch-m3-success">
    <input type="checkbox">
    <span class="so-switch-track">
        <span class="so-switch-icon-on material-icons">check</span>
        <span class="so-switch-icon-off material-icons">close</span>
    </span>
    <span class="so-switch-label">With Icons</span>
</label>

<!-- M3 Switch with Color -->
<label class="so-switch so-switch-m3 so-switch-m3-primary">...</label>

<!-- M3 Switch Sizes -->
<label class="so-switch so-switch-m3 so-switch-m3-sm">...</label>
<label class="so-switch so-switch-m3 so-switch-m3-lg">...</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 14: Ant Design Switches -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Ant Design Switches</h3>
                        <span class="so-badge so-badge-primary">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Ant Design inspired compact switch style.</p>

                        <h5 class="so-mb-3">Default Ant Design Switch</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-ant">
                                <input type="checkbox">
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Off</span>
                            </label>
                            <label class="so-switch so-switch-ant">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">On</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Ant Design Switch Color Variants</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center so-mb-4">
                            <label class="so-switch so-switch-ant so-switch-ant-primary">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Primary</span>
                            </label>
                            <label class="so-switch so-switch-ant so-switch-ant-success">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Success</span>
                            </label>
                            <label class="so-switch so-switch-ant so-switch-ant-danger">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Danger</span>
                            </label>
                            <label class="so-switch so-switch-ant so-switch-ant-warning">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Warning</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Ant Design Switch Sizes</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-items-center">
                            <label class="so-switch so-switch-ant so-switch-ant-sm">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Small</span>
                            </label>
                            <label class="so-switch so-switch-ant">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Default</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Ant Design Style Switch -->
<label class="so-switch so-switch-ant">
    <input type="checkbox">
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Ant Switch</span>
</label>

<!-- Ant Switch with Color -->
<label class="so-switch so-switch-ant so-switch-ant-primary">...</label>
<label class="so-switch so-switch-ant so-switch-ant-success">...</label>

<!-- Ant Switch Small -->
<label class="so-switch so-switch-ant so-switch-ant-sm">...</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 15: Label Placement -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Label Placement (MUI-Style)</h3>
                        <span class="so-badge so-badge-primary">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Control the position of labels relative to the checkbox/radio/switch - just like Material UI.</p>

                        <h5 class="so-mb-3">Checkbox Label Positions</h5>
                        <div class="so-flex so-gap-6 so-flex-wrap so-items-start so-mb-4">
                            <label class="so-checkbox so-checkbox-label-end">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Label End (Default)</span>
                            </label>
                            <label class="so-checkbox so-checkbox-label-start">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Label Start</span>
                            </label>
                            <label class="so-checkbox so-checkbox-label-top">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Label Top</span>
                            </label>
                            <label class="so-checkbox so-checkbox-label-bottom">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Label Bottom</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Radio Label Positions</h5>
                        <div class="so-flex so-gap-6 so-flex-wrap so-items-start so-mb-4">
                            <label class="so-radio so-radio-label-end">
                                <input type="radio" name="label-pos-radio" value="end" checked>
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Label End</span>
                            </label>
                            <label class="so-radio so-radio-label-start">
                                <input type="radio" name="label-pos-radio" value="start">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Label Start</span>
                            </label>
                            <label class="so-radio so-radio-label-top">
                                <input type="radio" name="label-pos-radio" value="top">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Label Top</span>
                            </label>
                            <label class="so-radio so-radio-label-bottom">
                                <input type="radio" name="label-pos-radio" value="bottom">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Label Bottom</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Switch Label Positions</h5>
                        <div class="so-flex so-gap-6 so-flex-wrap so-items-start">
                            <label class="so-switch so-switch-label-end">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Label End</span>
                            </label>
                            <label class="so-switch so-switch-label-start">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Label Start</span>
                            </label>
                            <label class="so-switch so-switch-label-top">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Label Top</span>
                            </label>
                            <label class="so-switch so-switch-label-bottom">
                                <input type="checkbox" checked>
                                <span class="so-switch-track"></span>
                                <span class="so-switch-label">Label Bottom</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Label End (Default) -->
<label class="so-checkbox so-checkbox-label-end">...</label>

<!-- Label Start (Before Input) -->
<label class="so-checkbox so-checkbox-label-start">...</label>
<label class="so-radio so-radio-label-start">...</label>
<label class="so-switch so-switch-label-start">...</label>

<!-- Label Top -->
<label class="so-checkbox so-checkbox-label-top">...</label>
<label class="so-radio so-radio-label-top">...</label>
<label class="so-switch so-switch-label-top">...</label>

<!-- Label Bottom -->
<label class="so-checkbox so-checkbox-label-bottom">...</label>
<label class="so-radio so-radio-label-bottom">...</label>
<label class="so-switch so-switch-label-bottom">...</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 16: Card Style Checkbox/Radio -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Card Style Checkbox &amp; Radio</h3>
                        <span class="so-badge so-badge-primary">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Selectable card-style checkboxes and radios for rich selection interfaces.</p>

                        <h5 class="so-mb-3">Card Checkboxes</h5>
                        <div class="so-grid so-grid-cols-3 so-grid-cols-md-2 so-grid-cols-sm-1 so-gap-3 so-mb-4">
                            <label class="so-checkbox so-checkbox-card">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <div class="so-checkbox-card-content">
                                    <div class="so-checkbox-card-title">Standard Plan</div>
                                    <div class="so-checkbox-card-description">Best for individuals and small teams</div>
                                </div>
                            </label>
                            <label class="so-checkbox so-checkbox-card so-checkbox-card-success">
                                <input type="checkbox">
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <div class="so-checkbox-card-content">
                                    <div class="so-checkbox-card-title">Professional Plan</div>
                                    <div class="so-checkbox-card-description">For growing businesses</div>
                                </div>
                            </label>
                            <label class="so-checkbox so-checkbox-card so-checkbox-card-primary">
                                <input type="checkbox">
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <div class="so-checkbox-card-content">
                                    <div class="so-checkbox-card-title">Enterprise Plan</div>
                                    <div class="so-checkbox-card-description">For large organizations</div>
                                </div>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Card Radios</h5>
                        <div class="so-grid so-grid-cols-3 so-grid-cols-md-2 so-grid-cols-sm-1 so-gap-3">
                            <label class="so-radio so-radio-card">
                                <input type="radio" name="card-radio" value="free" checked>
                                <span class="so-radio-circle"></span>
                                <div class="so-radio-card-content">
                                    <div class="so-radio-card-title">Free</div>
                                    <div class="so-radio-card-description">$0/month - Basic features</div>
                                </div>
                            </label>
                            <label class="so-radio so-radio-card so-radio-card-success">
                                <input type="radio" name="card-radio" value="pro">
                                <span class="so-radio-circle"></span>
                                <div class="so-radio-card-content">
                                    <div class="so-radio-card-title">Pro</div>
                                    <div class="so-radio-card-description">$19/month - Advanced features</div>
                                </div>
                            </label>
                            <label class="so-radio so-radio-card so-radio-card-primary">
                                <input type="radio" name="card-radio" value="team">
                                <span class="so-radio-circle"></span>
                                <div class="so-radio-card-content">
                                    <div class="so-radio-card-title">Team</div>
                                    <div class="so-radio-card-description">$49/month - Team collaboration</div>
                                </div>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Card Checkbox -->
<label class="so-checkbox so-checkbox-card">
    <input type="checkbox">
    <span class="so-checkbox-box">
        <span class="material-icons">check</span>
    </span>
    <div class="so-checkbox-card-content">
        <div class="so-checkbox-card-title">Plan Name</div>
        <div class="so-checkbox-card-description">Description text</div>
    </div>
</label>

<!-- Card Radio -->
<label class="so-radio so-radio-card">
    <input type="radio" name="group" value="1">
    <span class="so-radio-circle"></span>
    <div class="so-radio-card-content">
        <div class="so-radio-card-title">Option Title</div>
        <div class="so-radio-card-description">Option description</div>
    </div>
</label>

<!-- Card with Color Variant -->
<label class="so-checkbox so-checkbox-card so-checkbox-card-success">...</label>
<label class="so-radio so-radio-card so-radio-card-primary">...</label>', 'html') ?>
                    </div>
                </div>

                <!-- Section 17: Ripple Effect -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Ripple Effect (MUI-Style)</h3>
                        <span class="so-badge so-badge-primary">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-secondary so-mb-4">Add Material UI style ripple/pulse animation on hover and click.</p>

                        <h5 class="so-mb-3">Checkbox with Ripple</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <label class="so-checkbox so-checkbox-ripple so-checkbox-primary">
                                <input type="checkbox">
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Hover/Click for Ripple</span>
                            </label>
                            <label class="so-checkbox so-checkbox-ripple so-checkbox-success">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box">
                                    <span class="material-icons">check</span>
                                </span>
                                <span class="so-checkbox-label">Success Ripple</span>
                            </label>
                        </div>

                        <h5 class="so-mb-3">Radio with Ripple</h5>
                        <div class="so-flex so-gap-4 so-flex-wrap">
                            <label class="so-radio so-radio-ripple so-radio-primary">
                                <input type="radio" name="ripple-radio" value="1" checked>
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Option 1</span>
                            </label>
                            <label class="so-radio so-radio-ripple so-radio-primary">
                                <input type="radio" name="ripple-radio" value="2">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Option 2</span>
                            </label>
                        </div>
                        <?= so_code_block('<!-- Checkbox with Ripple Effect -->
<label class="so-checkbox so-checkbox-ripple so-checkbox-primary">
    <input type="checkbox">
    <span class="so-checkbox-box">
        <span class="material-icons">check</span>
    </span>
    <span class="so-checkbox-label">With Ripple</span>
</label>

<!-- Radio with Ripple Effect -->
<label class="so-radio so-radio-ripple so-radio-primary">
    <input type="radio" name="group" value="1">
    <span class="so-radio-circle"></span>
    <span class="so-radio-label">With Ripple</span>
</label>', 'html') ?>
                    </div>
                </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
