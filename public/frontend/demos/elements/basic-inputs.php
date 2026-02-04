<?php
/**
 * SixOrbit UI Demo - Basic Inputs
 */
$pageTitle = 'Basic Inputs';
$pageDescription = 'Text, email, password, number, and textarea inputs with various states and sizes';

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
            <h1 class="so-page-title"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="so-page-subtitle"><?= htmlspecialchars($pageDescription) ?></p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

        <!-- Section 1: Default Input -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Default Input</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <label class="so-form-label" for="input-default">Default Input</label>
                    <input type="text" class="so-form-control" id="input-default" placeholder="Enter text...">
                </div>
<?= so_code_block('<div class="so-form-group">
    <label class="so-form-label" for="input-default">Default Input</label>
    <input type="text" class="so-form-control" id="input-default" placeholder="Enter text...">
</div>', 'html') ?>
            </div>
        </div>

        <!-- Section 2: Input Types -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input Types</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <label class="so-form-label">Text</label>
                        <input type="text" class="so-form-control" placeholder="Text input">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Email</label>
                        <input type="email" class="so-form-control" placeholder="email@example.com">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Password</label>
                        <input type="password" class="so-form-control" placeholder="Password">
                    </div>
                </div>
                <div class="so-form-row">
                    <div class="so-form-group">
                        <label class="so-form-label">Number</label>
                        <input type="number" class="so-form-control" placeholder="0">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Tel</label>
                        <input type="tel" class="so-form-control" placeholder="+1 (555) 123-4567">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">URL</label>
                        <input type="url" class="so-form-control" placeholder="https://example.com">
                    </div>
                </div>
                <div class="so-form-row">
                    <div class="so-form-group">
                        <label class="so-form-label">Date</label>
                        <input type="date" class="so-form-control">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Time</label>
                        <input type="time" class="so-form-control">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Search</label>
                        <input type="search" class="so-form-control" placeholder="Search...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Input Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input Sizes</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <label class="so-form-label">Small</label>
                    <input type="text" class="so-form-control so-form-control-sm" placeholder="Small input">
                </div>
                <div class="so-form-group">
                    <label class="so-form-label">Default</label>
                    <input type="text" class="so-form-control" placeholder="Default input">
                </div>
                <div class="so-form-group">
                    <label class="so-form-label">Large</label>
                    <input type="text" class="so-form-control so-form-control-lg" placeholder="Large input">
                </div>
<?= so_code_block('<input type="text" class="so-form-control so-form-control-sm" placeholder="Small">
<input type="text" class="so-form-control" placeholder="Default">
<input type="text" class="so-form-control so-form-control-lg" placeholder="Large">', 'html') ?>
            </div>
        </div>

        <!-- Section 4: Input States -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input States</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <label class="so-form-label">Normal</label>
                        <input type="text" class="so-form-control" value="Normal input">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Disabled</label>
                        <input type="text" class="so-form-control" value="Disabled input" disabled>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Readonly</label>
                        <input type="text" class="so-form-control" value="Readonly input" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 5: Textarea -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Textarea</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <label class="so-form-label">Default Textarea</label>
                    <textarea class="so-form-control" rows="3" placeholder="Enter your message..."></textarea>
                </div>
                <div class="so-form-group">
                    <label class="so-form-label">Textarea with Character Counter</label>
                    <textarea class="so-form-control" rows="3" maxlength="200" placeholder="Limited to 200 characters..." data-char-counter="200" data-counter-target="#charCounter1"></textarea>
                    <div class="so-form-hints">
                        <span class="so-form-hint">Write a short description</span>
                        <span class="so-form-char-counter" id="charCounter1">0/200</span>
                    </div>
                </div>
                <div class="so-form-group">
                    <label class="so-form-label">Autosize Textarea</label>
                    <textarea class="so-form-control so-form-control-autosize" placeholder="This textarea auto-expands as you type..." data-autosize="true"></textarea>
                    <span class="so-form-hint">Automatically adjusts height based on content</span>
                </div>
<?= so_code_block('<!-- Default Textarea -->
<textarea class="so-form-control" rows="3" placeholder="Enter your message..."></textarea>

<!-- Textarea with Character Counter -->
<textarea class="so-form-control" rows="3" maxlength="200"
    data-char-counter="200" data-counter-target="#charCounter"></textarea>
<div class="so-form-hints">
    <span class="so-form-hint">Write a short description</span>
    <span class="so-form-char-counter" id="charCounter">0/200</span>
</div>

<!-- Autosize Textarea -->
<textarea class="so-form-control so-form-control-autosize" data-autosize="true"></textarea>', 'html') ?>
            </div>
        </div>

        <!-- Section 6: Required Field -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Required Field</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <label class="so-form-label so-required">Required Field</label>
                    <input type="text" class="so-form-control" placeholder="This field is required" required>
                    <span class="so-form-hint">Fields marked with * are required</span>
                </div>
<?= so_code_block('<div class="so-form-group">
    <label class="so-form-label so-required">Required Field</label>
    <input type="text" class="so-form-control" required>
    <span class="so-form-hint">Fields marked with * are required</span>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Section 7: Input with Icon -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input with Icon</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <label class="so-form-label">Icon Left</label>
                        <div class="so-input-wrapper">
                            <input type="text" class="so-form-control" placeholder="Search...">
                            <span class="so-input-icon"><span class="material-icons">search</span></span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Icon Right</label>
                        <div class="so-input-wrapper icon-right">
                            <input type="email" class="so-form-control" placeholder="Email address">
                            <span class="so-input-icon"><span class="material-icons">email</span></span>
                        </div>
                    </div>
                </div>
<?= so_code_block('<div class="so-input-wrapper">
    <input type="text" class="so-form-control" placeholder="Search...">
    <span class="so-input-icon"><span class="material-icons">search</span></span>
</div>

<div class="so-input-wrapper icon-right">
    <input type="email" class="so-form-control" placeholder="Email">
    <span class="so-input-icon"><span class="material-icons">email</span></span>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Section 8: Plaintext Readonly -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Plaintext Readonly</h3>
                <p class="so-card-subtitle">Display form values as plain text without input styling.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <label class="so-form-label">Email</label>
                        <div class="so-form-control-plaintext">john.doe@example.com</div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">With Underline</label>
                        <div class="so-form-control-plaintext so-form-control-plaintext-underline">$1,234.56</div>
                    </div>
                </div>
<?= so_code_block('<div class="so-form-control-plaintext">john.doe@example.com</div>
<div class="so-form-control-plaintext so-form-control-plaintext-underline">$1,234.56</div>', 'html') ?>
            </div>
        </div>

    </div>
</main>

<?php
$inlineJs = <<<JS
document.addEventListener('DOMContentLoaded', function() {
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

    // Autosize textarea
    document.querySelectorAll('[data-autosize="true"]').forEach(function(textarea) {
        function resize() {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }
        textarea.addEventListener('input', resize);
        resize();
    });
});
JS;

require_once '../includes/footer.php';
?>
