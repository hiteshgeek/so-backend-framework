<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Documentation') ?></title>
    <?php include __DIR__ . '/_design.php'; ?>
    <?php include __DIR__ . '/_markdown.php'; ?>
    <script>
        (function() {
            var t = localStorage.getItem("theme");
            if (!t && window.matchMedia("(prefers-color-scheme:dark)").matches) t = "dark";
            if (t) document.documentElement.setAttribute("data-theme", t);
        })()
    </script>
    <?= render_assets('head') ?>
</head>

<body>
    <?php
    // Format the filename nicely for display
    $displayName = str_replace(['.md', '-', '_'], ['', ' ', ' '], $filename ?? 'Documentation');
    $displayName = ucwords(strtolower($displayName));
    ?>

    <?php
    $title = $displayName;
    $breadcrumbs = [['label' => $displayName]];
    include __DIR__ . '/_partials/_header.php';
    ?>

    <?php
    $toc = extractToc($markdown ?? '');
    $content = parseMarkdown($markdown ?? '');
    ?>

    <main class="docs-layout">
        <aside class="docs-sidebar">
            <div class="sidebar-header">
                <button class="sidebar-close" aria-label="Close sidebar">
                    <span class="mdi mdi-close"></span>
                </button>
            </div>
            <ul>
                <?php foreach ($toc as $item): ?>
                    <li>
                        <a href="#<?= htmlspecialchars($item['id']) ?>" class="toc-h<?= $item['level'] ?>">
                            <?= htmlspecialchars($item['title']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($toc)): ?>
                    <li style="padding: 16px; color: var(--text-secondary); font-size: 14px;">
                        No sections found
                    </li>
                <?php endif; ?>
            </ul>
        </aside>
        <div class="sidebar-backdrop"></div>

        <article class="docs-content">
            <?php $position = 'top'; include __DIR__ . '/_partials/_footer-nav.php'; ?>

            <?= $content ?>

            <?php $position = 'bottom'; include __DIR__ . '/_partials/_footer-nav.php'; ?>
            <?php include __DIR__ . '/_partials/_footer.php'; ?>
        </article>
    </main>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    document.querySelectorAll('.docs-sidebar a').forEach(a => a.classList.remove('active'));
                    const link = document.querySelector(`.docs-sidebar a[href="#${entry.target.id}"]`);
                    if (link) link.classList.add('active');
                }
            });
        }, {
            rootMargin: '-80px 0px -80% 0px'
        });
        document.querySelectorAll('.heading[id]').forEach(h => observer.observe(h));
    </script>
    <?= render_assets('body_end') ?>
</body>

</html>