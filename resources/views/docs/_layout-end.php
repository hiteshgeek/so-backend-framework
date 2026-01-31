<?php
/**
 * Documentation Page Layout End
 *
 * Closes the layout started by _layout.php. Include this at the end of each page.
 */
?>

        <?php $position = 'bottom'; include __DIR__ . '/_partials/_footer-nav.php'; ?>
        <?php include __DIR__ . '/_partials/_footer.php'; ?>

    </article>
</main>

<?= render_assets('body_end') ?>
<?= render_stack('scripts') ?>

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
