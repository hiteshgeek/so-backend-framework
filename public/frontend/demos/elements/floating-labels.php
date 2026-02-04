<?php
/**
 * SixOrbit UI Demo - Floating Labels
 */
$pageTitle = 'Floating Labels';
$pageDescription = 'Material Design style floating labels with 3 variants: Outlined, Filled, and Standard';

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

        <!-- Section 1: Material Design Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Material Design Variants</h3>
                <p class="so-card-subtitle">Three distinct styles following Material Design guidelines.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <p class="so-text-muted so-text-sm so-mb-2">Outlined (Default)</p>
                        <div class="so-form-floating so-form-floating-outlined">
                            <input type="text" class="so-form-control" id="floatOutlined" placeholder="Enter text">
                            <label for="floatOutlined">Outlined Label</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <p class="so-text-muted so-text-sm so-mb-2">Filled</p>
                        <div class="so-form-floating so-form-floating-filled">
                            <input type="text" class="so-form-control" id="floatFilled" placeholder="Enter text">
                            <label for="floatFilled">Filled Label</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <p class="so-text-muted so-text-sm so-mb-2">Standard</p>
                        <div class="so-form-floating so-form-floating-standard">
                            <input type="text" class="so-form-control" id="floatStandard" placeholder="Enter text">
                            <label for="floatStandard">Standard Label</label>
                        </div>
                    </div>
                </div>
<?= so_code_block('<!-- Outlined (Default) -->
<div class="so-form-floating so-form-floating-outlined">
    <input type="text" class="so-form-control" placeholder="Enter text">
    <label>Outlined Label</label>
</div>

<!-- Filled -->
<div class="so-form-floating so-form-floating-filled">
    <input type="text" class="so-form-control" placeholder="Enter text">
    <label>Filled Label</label>
</div>

<!-- Standard -->
<div class="so-form-floating so-form-floating-standard">
    <input type="text" class="so-form-control" placeholder="Enter text">
    <label>Standard Label</label>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Section 2: Outlined Form Example -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Outlined Form</h3>
                <p class="so-card-subtitle">Full border with label overlapping the top border when active.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined">
                            <input type="text" class="so-form-control" id="outlinedFirst" placeholder="First name">
                            <label for="outlinedFirst">First Name</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined">
                            <input type="text" class="so-form-control" id="outlinedLast" placeholder="Last name">
                            <label for="outlinedLast">Last Name</label>
                        </div>
                    </div>
                </div>
                <div class="so-form-group">
                    <div class="so-form-floating so-form-floating-outlined">
                        <input type="email" class="so-form-control" id="outlinedEmail" placeholder="Email">
                        <label for="outlinedEmail">Email Address</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Filled Form Example -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Filled Form</h3>
                <p class="so-card-subtitle">Subtle background with underline emphasis on focus.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-filled">
                            <input type="text" class="so-form-control" id="filledFirst" placeholder="First name">
                            <label for="filledFirst">First Name</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-filled">
                            <input type="text" class="so-form-control" id="filledLast" placeholder="Last name">
                            <label for="filledLast">Last Name</label>
                        </div>
                    </div>
                </div>
                <div class="so-form-group">
                    <div class="so-form-floating so-form-floating-filled">
                        <input type="email" class="so-form-control" id="filledEmail" placeholder="Email">
                        <label for="filledEmail">Email Address</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Standard Form Example -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Standard Form</h3>
                <p class="so-card-subtitle">Minimal underline style with animated focus indicator.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-standard">
                            <input type="text" class="so-form-control" id="standardFirst" placeholder="First name">
                            <label for="standardFirst">First Name</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-standard">
                            <input type="text" class="so-form-control" id="standardLast" placeholder="Last name">
                            <label for="standardLast">Last Name</label>
                        </div>
                    </div>
                </div>
                <div class="so-form-group">
                    <div class="so-form-floating so-form-floating-standard">
                        <input type="email" class="so-form-control" id="standardEmail" placeholder="Email">
                        <label for="standardEmail">Email Address</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 5: Size Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <div class="so-form-floating so-form-floating-sm so-form-floating-outlined">
                        <input type="text" class="so-form-control" id="floatSm" placeholder="Small">
                        <label for="floatSm">Small Floating Label</label>
                    </div>
                </div>
                <div class="so-form-group">
                    <div class="so-form-floating so-form-floating-outlined">
                        <input type="text" class="so-form-control" id="floatDefault" placeholder="Default">
                        <label for="floatDefault">Default Floating Label</label>
                    </div>
                </div>
                <div class="so-form-group">
                    <div class="so-form-floating so-form-floating-lg so-form-floating-outlined">
                        <input type="text" class="so-form-control" id="floatLg" placeholder="Large">
                        <label for="floatLg">Large Floating Label</label>
                    </div>
                </div>
<?= so_code_block('<div class="so-form-floating so-form-floating-sm so-form-floating-outlined">...</div>
<div class="so-form-floating so-form-floating-outlined">...</div>
<div class="so-form-floating so-form-floating-lg so-form-floating-outlined">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Section 6: Prefilled Value -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Prefilled Value</h3>
                <p class="so-card-subtitle">When an input has a value, the label stays floated.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined">
                            <input type="text" class="so-form-control" id="prefilledOutlined" placeholder="Name" value="John Doe">
                            <label for="prefilledOutlined">Full Name (Outlined)</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-filled">
                            <input type="text" class="so-form-control" id="prefilledFilled" placeholder="Name" value="Jane Smith">
                            <label for="prefilledFilled">Full Name (Filled)</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-standard">
                            <input type="text" class="so-form-control" id="prefilledStandard" placeholder="Name" value="Bob Wilson">
                            <label for="prefilledStandard">Full Name (Standard)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 7: Required Field -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Required Field</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-floating so-form-floating-outlined">
                    <input type="text" class="so-form-control" id="floatRequired" placeholder="Required" required>
                    <label for="floatRequired" class="so-required">Company Name</label>
                </div>
<?= so_code_block('<div class="so-form-floating so-form-floating-outlined">
    <input type="text" class="so-form-control" placeholder="Required" required>
    <label class="so-required">Company Name</label>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Section 8: Validation States -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation States</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined has-success">
                            <input type="email" class="so-form-control" id="floatSuccess" placeholder="Email" value="valid@email.com">
                            <label for="floatSuccess">Email (Valid)</label>
                        </div>
                        <span class="so-form-success"><span class="material-icons">check_circle</span> Email is valid</span>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined has-error">
                            <input type="email" class="so-form-control" id="floatError" placeholder="Email" value="invalid-email">
                            <label for="floatError">Email (Invalid)</label>
                        </div>
                        <span class="so-form-error"><span class="material-icons">error</span> Please enter a valid email</span>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined has-warning">
                            <input type="text" class="so-form-control" id="floatWarning" placeholder="Username" value="admin">
                            <label for="floatWarning">Username (Warning)</label>
                        </div>
                        <span class="so-form-warning"><span class="material-icons">warning</span> Username is reserved</span>
                    </div>
                </div>
<?= so_code_block('<div class="so-form-floating so-form-floating-outlined has-success">...</div>
<span class="so-form-success">Email is valid</span>

<div class="so-form-floating so-form-floating-outlined has-error">...</div>
<span class="so-form-error">Please enter a valid email</span>

<div class="so-form-floating so-form-floating-outlined has-warning">...</div>
<span class="so-form-warning">Username is reserved</span>', 'html') ?>
            </div>
        </div>

        <!-- Section 9: Disabled State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Disabled State</h3>
                <p class="so-card-subtitle">Disabled inputs cannot be focused or edited.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined so-disabled">
                            <input type="text" class="so-form-control" id="floatDisabled1" placeholder="Disabled" disabled>
                            <label for="floatDisabled1">Disabled (Empty)</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined">
                            <input type="text" class="so-form-control" id="floatDisabled2" placeholder="Disabled" value="Prefilled value" disabled>
                            <label for="floatDisabled2">Disabled (With Value)</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-filled">
                            <input type="text" class="so-form-control" id="floatDisabledFilled" placeholder="Disabled" value="Filled disabled" disabled>
                            <label for="floatDisabledFilled">Disabled Filled</label>
                        </div>
                    </div>
                </div>
<?= so_code_block('<div class="so-form-floating so-form-floating-outlined so-disabled">
    <input type="text" class="so-form-control" placeholder="Disabled" disabled>
    <label>Disabled</label>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Section 10: Read-Only State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Read-Only State</h3>
                <p class="so-card-subtitle">Read-only inputs can be focused and selected but not edited.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined">
                            <input type="text" class="so-form-control" id="floatReadonly1" placeholder="Read-only" value="Cannot edit this" readonly>
                            <label for="floatReadonly1">Read-Only (Outlined)</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-filled">
                            <input type="text" class="so-form-control" id="floatReadonly2" placeholder="Read-only" value="Selectable text" readonly>
                            <label for="floatReadonly2">Read-Only (Filled)</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-standard">
                            <input type="text" class="so-form-control" id="floatReadonly3" placeholder="Read-only" value="Copy this text" readonly>
                            <label for="floatReadonly3">Read-Only (Standard)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 11: With Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Icons (Adornments)</h3>
                <p class="so-card-subtitle">Add leading or trailing icons to floating label inputs.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined so-form-floating-icon-start">
                            <span class="so-input-icon"><span class="material-icons">person</span></span>
                            <input type="text" class="so-form-control" id="floatIconStart" placeholder="Username">
                            <label for="floatIconStart">Username</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined so-form-floating-icon-end">
                            <input type="password" class="so-form-control" id="floatIconEnd" placeholder="Password">
                            <label for="floatIconEnd">Password</label>
                            <button type="button" class="so-input-action" onclick="togglePasswordVisibility(this)">
                                <span class="material-icons">visibility</span>
                            </button>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined so-form-floating-icon-start so-form-floating-icon-end">
                            <span class="so-input-icon"><span class="material-icons">search</span></span>
                            <input type="text" class="so-form-control" id="floatIconBoth" placeholder="Search">
                            <label for="floatIconBoth">Search</label>
                            <button type="button" class="so-input-action"><span class="material-icons">close</span></button>
                        </div>
                    </div>
                </div>
                <div class="so-form-row so-mt-4">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-filled so-form-floating-icon-start">
                            <span class="so-input-icon"><span class="material-icons">email</span></span>
                            <input type="email" class="so-form-control" id="floatFilledIcon" placeholder="Email">
                            <label for="floatFilledIcon">Email Address</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-standard so-form-floating-icon-start">
                            <span class="so-input-icon"><span class="material-icons">phone</span></span>
                            <input type="tel" class="so-form-control" id="floatStandardIcon" placeholder="Phone">
                            <label for="floatStandardIcon">Phone Number</label>
                        </div>
                    </div>
                </div>
<?= so_code_block('<!-- Leading Icon -->
<div class="so-form-floating so-form-floating-outlined so-form-floating-icon-start">
    <span class="so-input-icon"><span class="material-icons">person</span></span>
    <input type="text" class="so-form-control" placeholder="Username">
    <label>Username</label>
</div>

<!-- Trailing Action -->
<div class="so-form-floating so-form-floating-outlined so-form-floating-icon-end">
    <input type="password" class="so-form-control" placeholder="Password">
    <label>Password</label>
    <button type="button" class="so-input-action">
        <span class="material-icons">visibility</span>
    </button>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Section 12: Color Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants</h3>
                <p class="so-card-subtitle">Change the focus color of floating labels.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined">
                            <input type="text" class="so-form-control" id="floatPrimary" placeholder="Primary">
                            <label for="floatPrimary">Primary (Default)</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined so-form-floating-secondary">
                            <input type="text" class="so-form-control" id="floatSecondary" placeholder="Secondary">
                            <label for="floatSecondary">Secondary</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined so-form-floating-info">
                            <input type="text" class="so-form-control" id="floatInfo" placeholder="Info">
                            <label for="floatInfo">Info</label>
                        </div>
                    </div>
                </div>
<?= so_code_block('<div class="so-form-floating so-form-floating-outlined">...</div>
<div class="so-form-floating so-form-floating-outlined so-form-floating-secondary">...</div>
<div class="so-form-floating so-form-floating-outlined so-form-floating-info">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Section 13: With Helper Text -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Helper Text</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined">
                            <input type="password" class="so-form-control" id="floatHelper1" placeholder="Password" minlength="8">
                            <label for="floatHelper1">Password</label>
                        </div>
                        <div class="so-form-hint">
                            <span class="material-icons">info</span>
                            Must be at least 8 characters
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined">
                            <input type="text" class="so-form-control" id="floatHelper2" placeholder="Bio" maxlength="100" data-char-counter="100" data-counter-target="#bioCounter">
                            <label for="floatHelper2">Bio</label>
                        </div>
                        <div class="so-form-hints">
                            <span class="so-form-hint-left so-form-hint">Short description about yourself</span>
                            <span class="so-form-hint-right so-form-char-counter" id="bioCounter">0/100</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 14: Textarea with Floating Label -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Textarea with Floating Label</h3>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined">
                            <textarea class="so-form-control" id="floatTextareaOutlined" placeholder="Description" style="height: 100px;"></textarea>
                            <label for="floatTextareaOutlined">Description (Outlined)</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-filled">
                            <textarea class="so-form-control" id="floatTextareaFilled" placeholder="Description" style="height: 100px;"></textarea>
                            <label for="floatTextareaFilled">Description (Filled)</label>
                        </div>
                    </div>
                </div>
<?= so_code_block('<div class="so-form-floating so-form-floating-outlined">
    <textarea class="so-form-control" placeholder="Description" style="height: 100px;"></textarea>
    <label>Description (Outlined)</label>
</div>', 'html') ?>
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
});

// Password visibility toggle
function togglePasswordVisibility(btn) {
    var input = btn.closest('.so-form-floating').querySelector('input');
    var icon = btn.querySelector('.material-icons');
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}
JS;

require_once '../includes/footer.php';
?>
