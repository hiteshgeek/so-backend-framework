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
</body>
</html>
