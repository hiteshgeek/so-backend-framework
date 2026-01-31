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

    <script src="<?= url('/assets/js/docs/scroll-spy.js') ?>"></script>
    <?= render_assets('body_end') ?>

    <script>
    // Track current documentation page visit for "last visited" highlighting
    (function() {
        // Normalize URL for storage (remove trailing slash, hash, query params)
        function normalizeUrl(url) {
            try {
                var urlObj = new URL(url, window.location.origin);
                return urlObj.origin + urlObj.pathname.replace(/\/$/, '');
            } catch (e) {
                return url.replace(/\/$/, '').split('#')[0].split('?')[0];
            }
        }

        // Store the current page URL when viewing any documentation page
        var currentUrl = normalizeUrl(window.location.href);
        localStorage.setItem('docs-last-visited-card', currentUrl);

        console.log('Docs: Stored last visited ->', currentUrl);
    })();
    </script>
</body>

</html>