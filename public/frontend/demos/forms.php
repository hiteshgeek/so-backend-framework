<?php
/**
 * SixOrbit UI Demo - Forms
 * Comprehensive form components and layouts
 */
$pageTitle = 'Forms';
$pageDescription = 'Form components, layouts, and validation examples';

require_once 'includes/config.php';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
require_once 'includes/navbar.php';
?>

<!-- Main Content -->
<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="so-page-subtitle"><?= htmlspecialchars($pageDescription) ?></p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <div class="so-tabs-container so-tabs-container-vertical">
            <!-- Tab Navigation (Sticky Sidebar) -->
            <div class="so-tabs so-tabs-vertical so-tabs-pills so-tabs-sticky" role="tablist" data-so-tabs>
                <button class="so-tab so-active" role="tab" data-so-target="#pane-basic-inputs">
                    <span class="material-icons">text_fields</span>
                    Basic Inputs
                </button>
                <button class="so-tab" role="tab" data-so-target="#pane-floating-labels">
                    <span class="material-icons">label</span>
                    Floating Labels
                </button>
                <button class="so-tab" role="tab" data-so-target="#pane-form-layouts">
                    <span class="material-icons">view_quilt</span>
                    Form Layouts
                </button>
                <button class="so-tab" role="tab" data-so-target="#pane-file-color">
                    <span class="material-icons">attach_file</span>
                    File & Color
                </button>
                <button class="so-tab" role="tab" data-so-target="#pane-checkboxes">
                    <span class="material-icons">check_box</span>
                    Checkboxes & Radios
                </button>
                <button class="so-tab" role="tab" data-so-target="#pane-validation">
                    <span class="material-icons">verified</span>
                    Validation
                </button>
                <button class="so-tab" role="tab" data-so-target="#pane-input-groups">
                    <span class="material-icons">group_work</span>
                    Input Groups
                </button>
                <button class="so-tab" role="tab" data-so-target="#pane-complete-forms">
                    <span class="material-icons">assignment</span>
                    Complete Forms
                </button>
            </div>

            <!-- Tab Content -->
            <div class="so-tab-content">
                <?php include 'includes/forms/basic-inputs.php'; ?>
                <?php include 'includes/forms/floating-labels.php'; ?>
                <?php include 'includes/forms/form-layouts.php'; ?>
                <?php include 'includes/forms/file-color-inputs.php'; ?>
                <?php include 'includes/forms/checkboxes-radios.php'; ?>
                <?php include 'includes/forms/validation.php'; ?>
                <?php include 'includes/forms/input-groups.php'; ?>
                <?php include 'includes/forms/complete-forms.php'; ?>
            </div>
        </div>
    </div>
</main>

<?php
$inlineJs = <<<JS
document.addEventListener('DOMContentLoaded', function() {
    // File input handling
    document.querySelectorAll('.so-form-control-file input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function() {
            var fileText = this.closest('.so-form-control-file').querySelector('.so-form-file-text');
            if (fileText) {
                if (this.files.length > 0) {
                    var names = Array.from(this.files).map(f => f.name).join(', ');
                    fileText.textContent = names;
                    fileText.classList.add('has-file');
                } else {
                    fileText.textContent = 'No file chosen';
                    fileText.classList.remove('has-file');
                }
            }
        });
    });

    // Dropzone handling
    document.querySelectorAll('.so-form-file-dropzone').forEach(function(dropzone) {
        var input = dropzone.querySelector('input[type="file"]');

        ['dragenter', 'dragover'].forEach(function(eventName) {
            dropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                dropzone.classList.add('so-dragover');
            });
        });

        ['dragleave', 'drop'].forEach(function(eventName) {
            dropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                dropzone.classList.remove('so-dragover');
            });
        });

        dropzone.addEventListener('drop', function(e) {
            if (input && e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    });

    // Color input handling
    document.querySelectorAll('.so-form-control-color input[type="color"]').forEach(function(input) {
        var wrapper = input.closest('.so-form-control-color');
        var swatch = wrapper.querySelector('.so-form-color-swatch');
        var valueDisplay = wrapper.querySelector('.so-form-color-value');

        function updateColor() {
            if (swatch) {
                swatch.style.setProperty('--selected-color', input.value);
            }
            if (valueDisplay) {
                valueDisplay.textContent = input.value;
            }
        }

        input.addEventListener('input', updateColor);
        updateColor();
    });

    // Color input with text field
    document.querySelectorAll('.so-form-color-input').forEach(function(wrapper) {
        var colorInput = wrapper.querySelector('input[type="color"]');
        var textInput = wrapper.querySelector('.so-form-control');
        var swatch = wrapper.querySelector('.so-form-color-swatch');

        if (colorInput && textInput) {
            colorInput.addEventListener('input', function() {
                textInput.value = colorInput.value;
                if (swatch) swatch.style.setProperty('--selected-color', colorInput.value);
            });

            textInput.addEventListener('input', function() {
                var val = textInput.value;
                if (/^#[0-9A-Fa-f]{6}\$/.test(val)) {
                    colorInput.value = val;
                    if (swatch) swatch.style.setProperty('--selected-color', val);
                }
            });
        }
    });

    // Character counter
    document.querySelectorAll('[data-char-counter]').forEach(function(input) {
        var maxLength = parseInt(input.getAttribute('maxlength')) || parseInt(input.dataset.charCounter);
        var counter = document.querySelector(input.dataset.counterTarget);

        if (counter && maxLength) {
            function updateCounter() {
                var current = input.value.length;
                counter.textContent = current + '/' + maxLength;
                counter.classList.remove('so-warning', 'so-danger');

                var percent = (current / maxLength) * 100;
                if (percent >= 100) {
                    counter.classList.add('so-danger');
                } else if (percent >= 80) {
                    counter.classList.add('so-warning');
                }
            }

            input.addEventListener('input', updateCounter);
            updateCounter();
        }
    });

    // Interactive validation demo
    var validationForm = document.getElementById('validationDemoForm');
    if (validationForm) {
        validationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var isValid = true;
            var groups = this.querySelectorAll('.so-form-group[data-validate]');

            groups.forEach(function(group) {
                var input = group.querySelector('.so-form-control');
                var rule = group.dataset.validate;
                var value = input ? input.value.trim() : '';
                var valid = true;

                // Reset state
                group.classList.remove('has-error', 'has-success', 'so-shake');

                // Validate
                switch(rule) {
                    case 'required':
                        valid = value.length > 0;
                        break;
                    case 'email':
                        valid = value.length > 0 && /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+\$/.test(value);
                        break;
                    case 'minlength':
                        var min = parseInt(group.dataset.minlength) || 3;
                        valid = value.length >= min;
                        break;
                }

                if (valid) {
                    group.classList.add('has-success');
                } else {
                    group.classList.add('has-error', 'so-shake');
                    isValid = false;
                }
            });

            if (isValid) {
                // Show success
                var btn = this.querySelector('button[type="submit"]');
                if (btn) {
                    btn.classList.add('so-loading');
                    btn.disabled = true;

                    setTimeout(function() {
                        btn.classList.remove('so-loading');
                        btn.disabled = false;
                        alert('Form submitted successfully!');
                    }, 1500);
                }
            }
        });

        // Real-time validation on blur
        validationForm.querySelectorAll('.so-form-control').forEach(function(input) {
            input.addEventListener('blur', function() {
                var group = this.closest('.so-form-group[data-validate]');
                if (!group) return;

                var rule = group.dataset.validate;
                var value = this.value.trim();
                var valid = true;

                switch(rule) {
                    case 'required':
                        valid = value.length > 0;
                        break;
                    case 'email':
                        valid = value.length === 0 || /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+\$/.test(value);
                        break;
                    case 'minlength':
                        var min = parseInt(group.dataset.minlength) || 3;
                        valid = value.length === 0 || value.length >= min;
                        break;
                }

                group.classList.remove('has-error', 'has-success');
                if (value.length > 0) {
                    group.classList.add(valid ? 'has-success' : 'has-error');
                }
            });
        });
    }
});
JS;

require_once 'includes/footer.php';
?>
