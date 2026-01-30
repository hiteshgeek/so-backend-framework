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

<div class="docs-page-nav <?= !empty($position) ? 'docs-page-nav--' . $position : '' ?>">
    <?php if ($prevPage): ?>
        <a href="<?= htmlspecialchars($prevPage['url']) ?>" class="page-nav-item page-nav-prev">
            <span class="mdi mdi-arrow-left"></span>
            <?= htmlspecialchars($prevPage['title']) ?>
        </a>
    <?php else: ?>
        <div></div>
    <?php endif; ?>

    <?php if ($nextPage): ?>
        <a href="<?= htmlspecialchars($nextPage['url']) ?>" class="page-nav-item page-nav-next">
            <?= htmlspecialchars($nextPage['title']) ?>
            <span class="mdi mdi-arrow-right"></span>
        </a>
    <?php endif; ?>
</div>
