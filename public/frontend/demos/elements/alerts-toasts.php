<?php
/**
 * SixOrbit UI Demo - Alerts & Toasts
 */
$pageTitle = 'Alerts & Toasts';
$pageDescription = 'Alert messages and toast notifications';

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
            <h1 class="so-page-title">Alerts &amp; Toasts</h1>
            <p class="so-page-subtitle">Alert messages and toast notifications</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- ============================================
         ALERTS SECTION
         ============================================ -->

    <!-- Basic Alerts -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Basic Alerts</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Alerts provide contextual feedback messages. Available in all 8 contextual variants.</p>

                    <div class="so-alert so-alert-primary so-mb-3">
                        <span class="so-alert-icon"><span class="material-icons">lightbulb</span></span>
                        <div class="so-alert-content">
                            <strong>Primary Alert</strong>
                            This is a primary alert for tips and highlights.
                        </div>
                    </div>

                    <div class="so-alert so-alert-secondary so-mb-3">
                        <span class="so-alert-icon"><span class="material-icons">info</span></span>
                        <div class="so-alert-content">
                            <strong>Secondary Alert</strong>
                            A neutral secondary alert for general information.
                        </div>
                    </div>

                    <div class="so-alert so-alert-success so-mb-3">
                        <span class="so-alert-icon"><span class="material-icons">check_circle</span></span>
                        <div class="so-alert-content">
                            <strong>Success Alert</strong>
                            Operation completed successfully!
                        </div>
                    </div>

                    <div class="so-alert so-alert-danger so-mb-3">
                        <span class="so-alert-icon"><span class="material-icons">error</span></span>
                        <div class="so-alert-content">
                            <strong>Danger Alert</strong>
                            Something went wrong. Please try again.
                        </div>
                    </div>

                    <div class="so-alert so-alert-warning so-mb-3">
                        <span class="so-alert-icon"><span class="material-icons">warning</span></span>
                        <div class="so-alert-content">
                            <strong>Warning Alert</strong>
                            Please review your changes before proceeding.
                        </div>
                    </div>

                    <div class="so-alert so-alert-info so-mb-3">
                        <span class="so-alert-icon"><span class="material-icons">info</span></span>
                        <div class="so-alert-content">
                            <strong>Info Alert</strong>
                            Here's some helpful information you might need.
                        </div>
                    </div>

                    <div class="so-alert so-alert-light so-mb-3">
                        <span class="so-alert-icon"><span class="material-icons">help_outline</span></span>
                        <div class="so-alert-content">
                            <strong>Light Alert</strong>
                            A subtle light-themed alert.
                        </div>
                    </div>

                    <div class="so-alert so-alert-dark">
                        <span class="so-alert-icon"><span class="material-icons">info</span></span>
                        <div class="so-alert-content">
                            <strong>Dark Alert</strong>
                            A high-contrast dark alert.
                        </div>
                    </div>

            <?= so_code_block('<div class="so-alert so-alert-success">
    <span class="so-alert-icon"><span class="material-icons">check_circle</span></span>
    <div class="so-alert-content">
        <strong>Success Alert</strong>
        Operation completed successfully!
    </div>
</div>

<!-- Available variants: primary, secondary, success, danger, warning, info, light, dark -->', 'html') ?>
        </div>
    </div>

    <!-- Dismissible Alerts -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Dismissible Alerts</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Add the <code>.so-alert-dismissible</code> class and a close button to make alerts dismissible.</p>

                    <div class="so-alert so-alert-info so-alert-dismissible so-mb-3">
                        <span class="so-alert-icon"><span class="material-icons">info</span></span>
                        <div class="so-alert-content">
                            <strong>Dismissible Info</strong>
                            Click the X button to dismiss this alert.
                        </div>
                        <button type="button" class="so-alert-close" data-dismiss="alert" aria-label="Close">
                            <span class="material-icons">close</span>
                        </button>
                    </div>

                    <div class="so-alert so-alert-success so-alert-dismissible so-mb-3">
                        <span class="so-alert-icon"><span class="material-icons">check_circle</span></span>
                        <div class="so-alert-content">
                            <strong>File Uploaded</strong>
                            Your file has been uploaded successfully.
                        </div>
                        <button type="button" class="so-alert-close" data-dismiss="alert" aria-label="Close">
                            <span class="material-icons">close</span>
                        </button>
                    </div>

                    <div class="so-alert so-alert-warning so-alert-dismissible">
                        <span class="so-alert-icon"><span class="material-icons">warning</span></span>
                        <div class="so-alert-content">
                            <strong>Session Expiring</strong>
                            Your session will expire in 5 minutes. Save your work.
                        </div>
                        <button type="button" class="so-alert-close" data-dismiss="alert" aria-label="Close">
                            <span class="material-icons">close</span>
                        </button>
                    </div>

            <?= so_code_block('<div class="so-alert so-alert-info so-alert-dismissible">
    <span class="so-alert-icon"><span class="material-icons">info</span></span>
    <div class="so-alert-content">
        <strong>Dismissible Alert</strong>
        Click the X button to dismiss.
    </div>
    <button type="button" class="so-alert-close" data-dismiss="alert">
        <span class="material-icons">close</span>
    </button>
</div>', 'html') ?>
        </div>
    </div>

    <!-- Outline Alerts -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Outline Alerts</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Add <code>.so-alert-outline</code> for a lighter, border-only style.</p>

                    <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1 so-gap-3">
                        <div class="so-alert so-alert-primary so-alert-outline">
                            <span class="so-alert-icon"><span class="material-icons">lightbulb</span></span>
                            <div>Primary outline alert</div>
                        </div>
                        <div class="so-alert so-alert-success so-alert-outline">
                            <span class="so-alert-icon"><span class="material-icons">check_circle</span></span>
                            <div>Success outline alert</div>
                        </div>
                        <div class="so-alert so-alert-warning so-alert-outline">
                            <span class="so-alert-icon"><span class="material-icons">warning</span></span>
                            <div>Warning outline alert</div>
                        </div>
                        <div class="so-alert so-alert-danger so-alert-outline">
                            <span class="so-alert-icon"><span class="material-icons">error</span></span>
                            <div>Danger outline alert</div>
                        </div>
                    </div>

            <?= so_code_block('<div class="so-alert so-alert-primary so-alert-outline">
    <span class="so-alert-icon"><span class="material-icons">lightbulb</span></span>
    <div>Primary outline alert</div>
</div>', 'html') ?>
        </div>
    </div>

    <!-- Alert Sizes -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Alert Sizes</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>.so-alert-sm</code> for a compact alert.</p>

                    <div class="so-alert so-alert-info so-alert-sm so-mb-3">
                        <span class="so-alert-icon"><span class="material-icons">info</span></span>
                        <div class="so-alert-content">
                            <strong>Small Alert</strong>
                            This is a compact alert with smaller padding.
                        </div>
                    </div>

                    <div class="so-alert so-alert-info">
                        <span class="so-alert-icon"><span class="material-icons">info</span></span>
                        <div class="so-alert-content">
                            <strong>Default Alert</strong>
                            This is a standard alert with default padding.
                        </div>
                    </div>
        </div>
    </div>

    <!-- Additional Content -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Additional Content</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Alerts can contain headings, paragraphs, lists, and links.</p>

                    <div class="so-alert so-alert-success so-mb-4">
                        <span class="so-alert-icon"><span class="material-icons">check_circle</span></span>
                        <div class="so-alert-content">
                            <h4 class="so-alert-heading">Well done!</h4>
                            <p>You have successfully completed the registration process. Your account is now active and ready to use.</p>
                            <hr>
                            <p class="so-mb-0">Need help? <a href="#" class="so-alert-link">Contact support</a> for assistance.</p>
                        </div>
                    </div>

                    <div class="so-alert so-alert-warning">
                        <span class="so-alert-icon"><span class="material-icons">warning</span></span>
                        <div class="so-alert-content">
                            <h4 class="so-alert-heading">Before you proceed</h4>
                            <p>Please ensure you have completed the following:</p>
                            <ul>
                                <li>Verified your email address</li>
                                <li>Completed your profile information</li>
                                <li>Reviewed the <a href="#" class="so-alert-link">terms of service</a></li>
                            </ul>
                        </div>
                    </div>

            <?= so_code_block('<div class="so-alert so-alert-success">
    <span class="so-alert-icon">...</span>
    <div class="so-alert-content">
        <h4 class="so-alert-heading">Well done!</h4>
        <p>You have successfully completed...</p>
        <hr>
        <p>Need help? <a href="#" class="so-alert-link">Contact support</a></p>
    </div>
</div>', 'html') ?>
        </div>
    </div>

    <!-- JavaScript Alerts -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">JavaScript API</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Create alerts programmatically using the JavaScript API.</p>

                    <div class="so-btn-group so-mb-4">
                        <button type="button" class="so-btn so-btn-success" onclick="SOAlert.success('File saved successfully!', { title: 'Success', container: '#js-alerts-container' })">
                            Success Alert
                        </button>
                        <button type="button" class="so-btn so-btn-danger" onclick="SOAlert.error('Failed to save changes.', { title: 'Error', container: '#js-alerts-container' })">
                            Error Alert
                        </button>
                        <button type="button" class="so-btn so-btn-warning" onclick="SOAlert.warning('Your session will expire soon.', { title: 'Warning', container: '#js-alerts-container' })">
                            Warning Alert
                        </button>
                        <button type="button" class="so-btn so-btn-info" onclick="SOAlert.info('New features available!', { title: 'Info', container: '#js-alerts-container' })">
                            Info Alert
                        </button>
                    </div>

                    <div id="js-alerts-container"></div>

            <?= so_code_block('// Quick methods
SOAlert.success(\'File saved!\', { title: \'Success\' });
SOAlert.error(\'Something went wrong\');
SOAlert.warning(\'Check your input\');
SOAlert.info(\'New updates available\');

// Full options
SOAlert.create({
    type: \'success\',      // primary, secondary, success, danger, warning, info, light, dark
    title: \'Success!\',
    message: \'Your changes have been saved.\',
    icon: \'check_circle\', // Material icon name
    dismissible: true,
    outline: false,
    small: false,
    autoDismiss: false,
    autoDismissDelay: 5000,
    container: \'#my-container\',
    insertPosition: \'afterbegin\' // or \'beforeend\'
});

// Events
alert.element.addEventListener(\'so:alert:close\', (e) => {
    console.log(\'Alert closing\');
    // e.preventDefault(); // to cancel
});
alert.element.addEventListener(\'so:alert:closed\', () => {
    console.log(\'Alert closed\');
});', 'javascript') ?>
        </div>
    </div>

    <!-- ============================================
         TOASTS SECTION
         ============================================ -->

    <h2 class="so-mb-4 so-mt-6">Toast Notifications</h2>

    <!-- Basic Toasts -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Basic Toasts</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Toasts are lightweight notifications designed to mimic push notifications. Click the buttons to show toasts.</p>

                    <div class="so-btn-group so-flex-wrap">
                        <button type="button" class="so-btn so-btn-primary" onclick="SOToast.show({ type: 'primary', title: 'Primary', message: 'This is a primary toast notification.' })">
                            Primary
                        </button>
                        <button type="button" class="so-btn so-btn-secondary" onclick="SOToast.show({ type: 'secondary', title: 'Secondary', message: 'This is a secondary toast notification.' })">
                            Secondary
                        </button>
                        <button type="button" class="so-btn so-btn-success" onclick="SOToast.show({ type: 'success', title: 'Success', message: 'Operation completed successfully!' })">
                            Success
                        </button>
                        <button type="button" class="so-btn so-btn-danger" onclick="SOToast.show({ type: 'danger', title: 'Error', message: 'Something went wrong. Please try again.' })">
                            Danger
                        </button>
                        <button type="button" class="so-btn so-btn-warning" onclick="SOToast.show({ type: 'warning', title: 'Warning', message: 'Please review before continuing.' })">
                            Warning
                        </button>
                        <button type="button" class="so-btn so-btn-info" onclick="SOToast.show({ type: 'info', title: 'Information', message: 'Here is some useful information.' })">
                            Info
                        </button>
                        <button type="button" class="so-btn so-btn-light" onclick="SOToast.show({ type: 'light', title: 'Light', message: 'A light themed toast.' })">
                            Light
                        </button>
                        <button type="button" class="so-btn so-btn-dark" onclick="SOToast.show({ type: 'dark', title: 'Dark', message: 'A dark themed toast.' })">
                            Dark
                        </button>
                    </div>

            <?= so_code_block('SOToast.show({
    type: \'success\',
    title: \'Success\',
    message: \'Operation completed!\'
});', 'javascript') ?>
        </div>
    </div>

    <!-- Simple Toasts -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Simple Toasts (Compact)</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>simple: true</code> for a compact, header-less toast style.</p>

                    <div class="so-btn-group so-flex-wrap">
                        <button type="button" class="so-btn so-btn-success" onclick="SOToast.success('Your changes have been saved!')">
                            SOToast.success()
                        </button>
                        <button type="button" class="so-btn so-btn-danger" onclick="SOToast.error('Failed to connect to server.')">
                            SOToast.error()
                        </button>
                        <button type="button" class="so-btn so-btn-warning" onclick="SOToast.warning('Your session expires in 5 minutes.')">
                            SOToast.warning()
                        </button>
                        <button type="button" class="so-btn so-btn-info" onclick="SOToast.info('New version available.')">
                            SOToast.info()
                        </button>
                    </div>

            <?= so_code_block('// Quick toast methods (simple style)
SOToast.success(\'File uploaded!\');
SOToast.error(\'Upload failed\');
SOToast.warning(\'Storage almost full\');
SOToast.info(\'Processing...\');', 'javascript') ?>
        </div>
    </div>

    <!-- Toast Positions -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Toast Positions</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Toasts can be positioned in 6 different locations.</p>

                    <h5 class="so-mb-3">Edge Positions</h5>
                    <div class="so-grid so-grid-cols-3 so-grid-cols-sm-2 so-gap-2 so-mb-4">
                        <button type="button" class="so-btn so-btn-outline" onclick="SOToast.info('Top Left', { position: 'top-left', simple: true })">
                            Top Left
                        </button>
                        <button type="button" class="so-btn so-btn-outline" onclick="SOToast.info('Top Center', { position: 'top-center', simple: true })">
                            Top Center
                        </button>
                        <button type="button" class="so-btn so-btn-outline" onclick="SOToast.info('Top Right', { position: 'top-right', simple: true })">
                            Top Right
                        </button>
                        <button type="button" class="so-btn so-btn-outline" onclick="SOToast.info('Bottom Left', { position: 'bottom-left', simple: true })">
                            Bottom Left
                        </button>
                        <button type="button" class="so-btn so-btn-outline" onclick="SOToast.info('Bottom Center', { position: 'bottom-center', simple: true })">
                            Bottom Center
                        </button>
                        <button type="button" class="so-btn so-btn-outline" onclick="SOToast.info('Bottom Right', { position: 'bottom-right', simple: true })">
                            Bottom Right
                        </button>
                    </div>

                    <h5 class="so-mb-3">Center & Custom Positions</h5>
                    <div class="so-d-flex so-gap-2 so-flex-wrap">
                        <button type="button" class="so-btn so-btn-primary" onclick="SOToast.info('Center of Screen', { position: 'center', simple: true })">
                            Center
                        </button>
                        <button type="button" class="so-btn so-btn-secondary" onclick="SOToast.info('Custom Position', { position: 'custom', x: 100, y: 200, simple: true })">
                            Custom (100px, 200px)
                        </button>
                        <button type="button" class="so-btn so-btn-secondary" onclick="SOToast.info('Percentage Position', { position: 'custom', x: '25%', y: '75%', simple: true })">
                            Custom (25%, 75%)
                        </button>
                    </div>

            <?= so_code_block('// Standard positions
SOToast.show({
    message: \'Toast message\',
    position: \'bottom-right\' // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
});

// Center of screen
SOToast.show({
    message: \'Centered toast\',
    position: \'center\'
});

// Custom position with pixel coordinates
SOToast.show({
    message: \'Custom position\',
    position: \'custom\',
    x: 100,  // 100px from left
    y: 200   // 200px from top
});

// Custom position with percentage
SOToast.show({
    message: \'Percentage position\',
    position: \'custom\',
    x: \'25%\',  // 25% from left
    y: \'75%\'   // 75% from top
});', 'javascript') ?>
        </div>
    </div>

    <!-- Toast Options -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Toast Options</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Configure toast behavior with various options.</p>

                    <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1 so-gap-3">
                        <div>
                            <h5 class="so-mb-2">Auto-hide Settings</h5>
                            <button type="button" class="so-btn so-btn-outline so-mb-2 so-mr-2" onclick="SOToast.info('Stays until dismissed', { autohide: false, simple: true })">
                                No Auto-hide
                            </button>
                            <button type="button" class="so-btn so-btn-outline so-mb-2 so-mr-2" onclick="SOToast.info('Closes in 10 seconds', { delay: 10000, simple: true })">
                                10s Delay
                            </button>
                            <button type="button" class="so-btn so-btn-outline so-mb-2" onclick="SOToast.info('No progress bar', { showProgress: false, simple: true })">
                                No Progress
                            </button>
                        </div>

                        <div>
                            <h5 class="so-mb-2">Stacking</h5>
                            <button type="button" class="so-btn so-btn-outline so-mb-2 so-mr-2" onclick="showMultipleToasts()">
                                Show Multiple
                            </button>
                            <button type="button" class="so-btn so-btn-outline so-mb-2" onclick="SOToast.clear()">
                                Clear All
                            </button>
                        </div>
                    </div>

            <?= so_code_block('SOToast.show({
    type: \'info\',
    title: \'Toast Options\',
    message: \'Fully configurable\',
    position: \'top-right\',   // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center, custom
    autohide: true,
    delay: 5000,             // Auto-hide after 5 seconds
    showProgress: true,      // Show countdown progress bar
    pauseOnHover: true,      // Pause timer on hover
    closeButton: true,       // Show close button
    newestOnTop: true,       // New toasts appear on top
    maxVisible: 5,           // Maximum visible toasts
    simple: false,           // Use compact style
    x: null,                 // Custom x position (only with position: \'custom\')
    y: null,                 // Custom y position (only with position: \'custom\')
    onClick: () => {         // Click handler
        console.log(\'Toast clicked\');
    }
});

// Clear methods
SOToast.clear();                    // Clear all toasts
SOToast.clear(\'top-right\');         // Clear by position
SOToast.clearByType(\'success\');     // Clear by type
SOToast.getCount();                 // Get active toast count', 'javascript') ?>
        </div>
    </div>

    <!-- Toast with Actions -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Toast with Actions</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Add action buttons to toasts for user interaction.</p>

                    <button type="button" class="so-btn so-btn-primary" onclick="showActionToast()">
                        Show Toast with Actions
                    </button>

            <?= so_code_block('SOToast.show({
    type: \'info\',
    title: \'New Message\',
    message: \'You have a new message from John.\',
    autohide: false,
    actions: `
        <button class="so-btn so-btn-sm so-btn-primary">View</button>
        <button class="so-btn so-btn-sm so-btn-outline" data-dismiss="toast">Dismiss</button>
    `
});', 'javascript') ?>
        </div>
    </div>

    <!-- Toast Events -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Toast Events</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Listen to toast lifecycle events.</p>

                    <button type="button" class="so-btn so-btn-primary" onclick="showEventToast()">
                        Show Toast (Check Console)
                    </button>

            <?= so_code_block('const toast = SOToast.show({
    type: \'info\',
    message: \'Click me!\'
});

// Listen to events
toast.element.addEventListener(\'so:toast:show\', () => {
    console.log(\'Toast is about to show\');
});

toast.element.addEventListener(\'so:toast:shown\', () => {
    console.log(\'Toast is now visible\');
});

toast.element.addEventListener(\'so:toast:hide\', () => {
    console.log(\'Toast is about to hide\');
});

toast.element.addEventListener(\'so:toast:hidden\', () => {
    console.log(\'Toast has been hidden\');
});

toast.element.addEventListener(\'so:toast:click\', () => {
    console.log(\'Toast was clicked\');
});

// Instance methods
toast.pause();   // Pause auto-hide timer
toast.resume();  // Resume auto-hide timer
toast.hide();    // Hide the toast', 'javascript') ?>
        </div>
    </div>

<script>
function showMultipleToasts() {
    SOToast.success('First notification');
    setTimeout(() => SOToast.info('Second notification'), 300);
    setTimeout(() => SOToast.warning('Third notification'), 600);
    setTimeout(() => SOToast.error('Fourth notification'), 900);
}

function showActionToast() {
    SOToast.show({
        type: 'info',
        title: 'New Message',
        message: 'You have a new message from John Doe.',
        autohide: false,
        actions: '<button class="so-btn so-btn-sm so-btn-primary">View</button> <button class="so-btn so-btn-sm so-btn-outline" data-dismiss="toast">Dismiss</button>'
    });
}

function showEventToast() {
    const toast = SOToast.show({
        type: 'primary',
        title: 'Event Demo',
        message: 'Check the browser console for events.',
        delay: 8000
    });

    toast.element.addEventListener('so:toast:shown', () => {
        console.log('Toast shown event fired');
    });

    toast.element.addEventListener('so:toast:click', () => {
        console.log('Toast clicked!');
    });

    toast.element.addEventListener('so:toast:hidden', () => {
        console.log('Toast hidden event fired');
    });
}
</script>

    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
