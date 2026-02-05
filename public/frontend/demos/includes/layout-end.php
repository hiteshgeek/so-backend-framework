    </div>
</main>

<?php
// Output page-specific scripts if set
if (isset($pageScripts)) {
    echo $pageScripts;
}

require_once __DIR__ . '/footer.php';
?>
