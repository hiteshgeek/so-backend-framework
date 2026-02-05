<?php
/**
 * Common Layout Wrapper
 * Provides header, sidebar, navbar and footer for demo pages
 */

// Load common includes
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/sidebar.php';
require_once __DIR__ . '/navbar.php';
?>

<main class="so-main-content">
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title"><?php echo $pageTitle ?? 'UiEngine'; ?></h1>
            <p class="so-page-subtitle"><?php echo $pageSubtitle ?? 'Testing components'; ?></p>
        </div>
    </div>

    <div class="so-page-body">
        <?php
        // Page content goes here
        if (isset($pageContent)) {
            echo $pageContent;
        }
        ?>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
