<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Comprehensive Guide') ?></title>
    <?php include __DIR__ . '/_design.php'; ?>
    <?php include __DIR__ . '/_markdown.php'; ?>
</head>
<body>
    <header class="docs-header">
        <div class="docs-header-inner">
            <h1><span class="mdi mdi-book-open-variant"></span> Comprehensive Guide</h1>
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs" class="docs-nav-link">
                <span class="mdi mdi-arrow-left"></span> Back to Docs
            </a>
        </div>
    </header>

    <?php
    $toc = extractToc($markdown ?? '');
    $content = parseMarkdown($markdown ?? '');
    ?>

    <main class="docs-layout">
        <aside class="docs-sidebar">
            <h3><span class="mdi mdi-format-list-bulleted"></span> On This Page</h3>
            <ul>
                <?php foreach ($toc as $item): ?>
                <li>
                    <a href="#<?= htmlspecialchars($item['id']) ?>" class="toc-h<?= $item['level'] ?>">
                        <span class="mdi mdi-<?= $item['level'] == 2 ? 'chevron-right' : 'circle-small' ?>"></span>
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
</body>
</html>
