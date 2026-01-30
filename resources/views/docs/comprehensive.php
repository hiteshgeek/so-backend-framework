<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Comprehensive Guide') ?></title>
    <?php include __DIR__ . '/_design.php'; ?>
    <?php include __DIR__ . '/_markdown.php'; ?>
    <script>(function(){var t=localStorage.getItem("theme");if(!t&&window.matchMedia("(prefers-color-scheme:dark)").matches)t="dark";if(t)document.documentElement.setAttribute("data-theme",t);})()</script>
    <?= render_assets('head') ?>
</head>
<body>
    <header class="docs-header">
        <div class="docs-header-inner">
            <button class="sidebar-toggle" aria-label="Toggle sidebar">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
            <h1><span class="mdi mdi-book-open-variant"></span> Comprehensive Guide</h1>
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs" class="docs-nav-link">
                <span class="mdi mdi-arrow-left"></span> Back to Docs
            </a>
        </div>
    </header>

    <div class="breadcrumb-bar">
        <nav class="breadcrumbs">
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs" class="breadcrumb-item">
                <span class="mdi mdi-home"></span> Docs
            </a>
            <span class="mdi mdi-chevron-right breadcrumb-separator"></span>
            <span class="breadcrumb-current">Comprehensive Guide</span>
        </nav>
    </div>

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
            <?= $content ?>
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
        }, { rootMargin: '-80px 0px -80% 0px' });
        document.querySelectorAll('.heading[id]').forEach(h => observer.observe(h));
    </script>
<?= render_assets('body_end') ?>
</body>
</html>
