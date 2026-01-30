<?php
/**
 * Documentation Page Header Partial
 *
 * Renders the page header with breadcrumbs and title.
 *
 * Variables expected:
 *   $title - Page title
 *   $icon - MDI icon name (optional)
 *   $breadcrumbs - Array of breadcrumb items (optional)
 *   $badge - Badge text (optional, e.g., 'New', 'Beta')
 *   $badgeType - Badge type (optional, e.g., 'new', 'beta')
 */

$title = $title ?? 'Documentation';
$icon = $icon ?? 'file-document';
$breadcrumbs = $breadcrumbs ?? [];
$badge = $badge ?? null;
$badgeType = $badgeType ?? 'new';
?>

<header class="docs-header">
    <div class="docs-header-inner">
        <h1>
            <span class="mdi mdi-<?= htmlspecialchars($icon) ?>"></span>
            <?= htmlspecialchars($title) ?>
            <?php if ($badge): ?>
                <span class="badge badge-<?= htmlspecialchars($badgeType) ?>" style="font-size: 11px; margin-left: 8px;">
                    <?= htmlspecialchars($badge) ?>
                </span>
            <?php endif; ?>
        </h1>
        <a href="<?= htmlspecialchars(config('app.url')) ?>/docs" class="docs-nav-link">
            <span class="mdi mdi-arrow-left"></span> Back to Docs
        </a>
    </div>
</header>

<?php if (!empty($breadcrumbs)): ?>
<div class="docs-content" style="padding: var(--space-2) var(--space-5); margin-bottom: 0; border-bottom: none; border-radius: var(--radius) var(--radius) 0 0;">
    <nav class="breadcrumbs" style="margin-bottom: 0;">
        <a href="<?= htmlspecialchars(config('app.url')) ?>/docs" class="breadcrumb-item">
            <span class="mdi mdi-home"></span> Docs
        </a>
        <?php foreach ($breadcrumbs as $crumb): ?>
            <span class="mdi mdi-chevron-right breadcrumb-separator"></span>
            <?php if (isset($crumb['url'])): ?>
                <a href="<?= htmlspecialchars($crumb['url']) ?>" class="breadcrumb-item">
                    <?= htmlspecialchars($crumb['label']) ?>
                </a>
            <?php else: ?>
                <span class="breadcrumb-current"><?= htmlspecialchars($crumb['label']) ?></span>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
</div>
<?php endif; ?>
