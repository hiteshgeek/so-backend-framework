<?php
/**
 * Documentation Footer Navigation Partial
 *
 * Renders prev/next navigation links.
 *
 * Variables expected:
 *   $prevPage - Previous page info ['url' => '', 'title' => ''] (optional)
 *   $nextPage - Next page info ['url' => '', 'title' => ''] (optional)
 */

$prevPage = $prevPage ?? null;
$nextPage = $nextPage ?? null;

if (!$prevPage && !$nextPage) {
    return;
}
?>

<div class="docs-footer-nav">
    <?php if ($prevPage): ?>
        <a href="<?= htmlspecialchars($prevPage['url']) ?>" class="footer-nav-item footer-nav-prev">
            <span class="footer-nav-label">Previous</span>
            <span class="footer-nav-title">
                <span class="mdi mdi-arrow-left"></span>
                <?= htmlspecialchars($prevPage['title']) ?>
            </span>
        </a>
    <?php else: ?>
        <div></div>
    <?php endif; ?>

    <?php if ($nextPage): ?>
        <a href="<?= htmlspecialchars($nextPage['url']) ?>" class="footer-nav-item footer-nav-next">
            <span class="footer-nav-label">Next</span>
            <span class="footer-nav-title">
                <?= htmlspecialchars($nextPage['title']) ?>
                <span class="mdi mdi-arrow-right"></span>
            </span>
        </a>
    <?php endif; ?>
</div>
