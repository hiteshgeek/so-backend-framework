<?php
/**
 * Documentation Page Layout
 *
 * Base layout for documentation pages. Include this at the top of each page.
 *
 * Variables:
 *   $pageTitle - Page title
 *   $pageIcon - MDI icon name
 *   $toc - Table of contents array
 *   $prevPage - Previous page info
 *   $nextPage - Next page info
 *   $breadcrumbs - Breadcrumb items
 *   $lastUpdated - Last updated date
 *
 * Usage:
 *   <?php
 *   $pageTitle = 'Getting Started';
 *   $pageIcon = 'rocket-launch';
 *   $toc = [
 *       ['id' => 'installation', 'title' => 'Installation', 'level' => 2],
 *       ['id' => 'configuration', 'title' => 'Configuration', 'level' => 2],
 *   ];
 *   include __DIR__ . '/../_layout.php';
 *   ?>
 *   <!-- Your content here -->
 *   <?php include __DIR__ . '/../_layout-end.php'; ?>
 */

// Set defaults
$pageTitle = $pageTitle ?? 'Documentation';
$pageIcon = $pageIcon ?? 'file-document';
$toc = $toc ?? [];
$prevPage = $prevPage ?? null;
$nextPage = $nextPage ?? null;
$breadcrumbs = $breadcrumbs ?? [];
$lastUpdated = $lastUpdated ?? date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> - <?= htmlspecialchars(config('app.name', 'SO Framework')) ?> Documentation</title>
    <?php include __DIR__ . '/_design.php'; ?>
</head>
<body>
<?php
// Include components
include __DIR__ . '/_components.php';

// Set header variables
$title = $pageTitle;
$icon = $pageIcon;
include __DIR__ . '/_partials/_header.php';
?>

<main class="docs-layout">
    <?php include __DIR__ . '/_partials/_sidebar.php'; ?>

    <article class="docs-content">
