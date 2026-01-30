<?php
/**
 * Documentation Sidebar Partial
 *
 * Renders the sidebar with table of contents.
 *
 * Variables expected:
 *   $toc - Array of TOC items [['id' => '', 'title' => '', 'level' => 2]]
 *   $sections - Optional grouped sections [['title' => '', 'items' => [...]]]
 */

$toc = $toc ?? [];
$sections = $sections ?? [];
?>

<aside class="docs-sidebar">
    <h3><span class="mdi mdi-format-list-bulleted"></span> On This Page</h3>

    <?php if (!empty($sections)): ?>
        <?php foreach ($sections as $section): ?>
            <div class="sidebar-group">
                <div class="sidebar-group-header" onclick="this.parentElement.classList.toggle('collapsed')">
                    <span><?= htmlspecialchars($section['title'] ?? 'Section') ?></span>
                    <span class="mdi mdi-chevron-down"></span>
                </div>
                <ul class="sidebar-group-items">
                    <?php foreach ($section['items'] ?? [] as $item): ?>
                        <li>
                            <a href="#<?= htmlspecialchars($item['id'] ?? '') ?>" class="toc-h<?= $item['level'] ?? 2 ?>">
                                <span class="mdi mdi-<?= ($item['level'] ?? 2) == 2 ? 'chevron-right' : 'circle-small' ?>"></span>
                                <?= htmlspecialchars($item['title'] ?? '') ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>

    <?php elseif (!empty($toc)): ?>
        <ul>
            <?php foreach ($toc as $item): ?>
                <li>
                    <a href="#<?= htmlspecialchars($item['id']) ?>" class="toc-h<?= $item['level'] ?>">
                        <span class="mdi mdi-<?= $item['level'] == 2 ? 'chevron-right' : 'circle-small' ?>"></span>
                        <?= htmlspecialchars($item['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <ul>
            <li style="padding: 16px; color: var(--text-secondary); font-size: 14px;">
                No sections found
            </li>
        </ul>
    <?php endif; ?>
</aside>

<script>
// Active section highlighting on scroll
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                document.querySelectorAll('.docs-sidebar a').forEach(a => a.classList.remove('active'));
                const link = document.querySelector('.docs-sidebar a[href="#' + entry.target.id + '"]');
                if (link) link.classList.add('active');
            }
        });
    }, { rootMargin: '-80px 0px -80% 0px' });

    document.querySelectorAll('.heading[id], h2[id], h3[id]').forEach(h => observer.observe(h));
});
</script>
