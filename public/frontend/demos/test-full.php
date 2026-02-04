<?php
$pageTitle = 'Test Page';
$pageDescription = 'Testing full demo structure';

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="so-main-content">
    <div class="so-page-header">
        <h1>Test Page Works!</h1>
        <p>If you see this, all includes are working correctly.</p>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
