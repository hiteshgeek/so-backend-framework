<?php
/**
 * Documentation Components Loader
 *
 * Loads all documentation UI components for use in PHP views.
 *
 * Usage in a page:
 *   <?php include __DIR__ . '/../_components.php'; ?>
 *
 * Then use any component:
 *   <?= callout('info', 'This is an info message') ?>
 *   <?= codeBlock('php', $code) ?>
 *   <?= featureCard('shield', 'Security', 'Built-in protection') ?>
 */

// Load all component helpers
require_once __DIR__ . '/_components/_callout.php';
require_once __DIR__ . '/_components/_api-endpoint.php';
require_once __DIR__ . '/_components/_code.php';
require_once __DIR__ . '/_components/_tabs.php';
require_once __DIR__ . '/_components/_feature-card.php';
require_once __DIR__ . '/_components/_method-signature.php';
require_once __DIR__ . '/_components/_keyboard.php';
require_once __DIR__ . '/_components/_file-path.php';
require_once __DIR__ . '/_components/_table.php';
require_once __DIR__ . '/_components/_badge.php';
require_once __DIR__ . '/_components/_toc.php';
require_once __DIR__ . '/_components/_diagram.php';
