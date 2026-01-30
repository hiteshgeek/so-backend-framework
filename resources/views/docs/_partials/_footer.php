<?php
/**
 * Documentation Page Footer Partial
 *
 * Renders the page footer with helpful links.
 *
 * Variables expected:
 *   $lastUpdated - Last updated date string (optional)
 *   $editUrl - Edit on GitHub URL (optional)
 */

$lastUpdated = $lastUpdated ?? null;
$editUrl = $editUrl ?? null;
?>

<footer style="margin-top: var(--space-4); padding-top: var(--space-3); border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--space-2);">
    <div style="font-size: 13px; color: var(--text-muted);">
        <?php if ($lastUpdated): ?>
            <span class="mdi mdi-clock-outline" style="margin-right: 4px;"></span>
            Last updated: <?= htmlspecialchars($lastUpdated) ?>
        <?php endif; ?>
    </div>

    <div style="display: flex; gap: var(--space-2); font-size: 13px;">
        <?php if ($editUrl): ?>
            <a href="<?= htmlspecialchars($editUrl) ?>" class="link" style="display: flex; align-items: center; gap: 4px;">
                <span class="mdi mdi-pencil"></span> Edit this page
            </a>
        <?php endif; ?>

        <a href="<?= htmlspecialchars(config('app.url')) ?>/docs" class="link" style="display: flex; align-items: center; gap: 4px;">
            <span class="mdi mdi-book-open-variant"></span> All Docs
        </a>
    </div>
</footer>
