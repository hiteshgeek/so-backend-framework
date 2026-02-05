<?php
/**
 * Layout Start
 * Includes header, sidebar, navbar and opens main content area
 */

require_once __DIR__ . '/config.php';

// Set relative prefix for footer links
$relativePrefix = '../';

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/sidebar.php';
require_once __DIR__ . '/navbar.php';

// Load UI Engine CSS
echo '<link rel="stylesheet" href="' . so_asset('css', 'ui-engine') . '">';
?>

<main class="so-main-content">
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title"><?php echo $pageTitle ?? 'UiEngine'; ?></h1>
            <p class="so-page-subtitle"><?php echo $pageSubtitle ?? 'Testing components'; ?></p>
        </div>
    </div>

    <div class="so-page-body"<?php echo isset($pageBodyId) ? ' id="' . $pageBodyId . '"' : ''; ?>>
