<?php
/**
 * SixOrbit UI Demo - Footer Include
 * Include this at the bottom of each page
 */
?>

<!-- Lock Screen & Logout Confirmation Styles -->
<style>
/* Lock Screen Overlay */
.so-lock-screen {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    background: linear-gradient(135deg, #1a1c2e 0%, #0d0e17 100%);
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}
.so-lock-screen.active {
    display: flex;
    opacity: 1;
    visibility: visible;
}
.so-lock-screen-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    color: #fff;
}
.so-lock-screen-time {
    font-size: 72px;
    font-weight: 200;
    color: #fff;
    margin-bottom: 8px;
}
.so-lock-screen-date {
    font-size: 18px;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 48px;
}
.so-lock-screen-user {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 32px;
}
.so-lock-screen-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 500;
    color: #fff;
    margin-bottom: 16px;
}
.so-lock-screen-avatar[data-color="teal"] {
    background: linear-gradient(135deg, #00897b, #26a69a);
}
.so-lock-screen-name {
    font-size: 24px;
    font-weight: 500;
    color: #fff;
}
.so-lock-screen-form {
    margin-bottom: 16px;
}
.so-lock-screen-input-group {
    display: flex;
    align-items: center;
    gap: 8px;
}
.so-lock-screen-input {
    width: 280px;
    padding: 12px 16px;
    font-size: 16px;
    font-family: inherit;
    color: #fff;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    outline: none;
    transition: border-color 0.2s ease, background 0.2s ease;
}
.so-lock-screen-input:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.4);
}
.so-lock-screen-input::placeholder {
    color: rgba(255, 255, 255, 0.5);
}
.so-lock-screen-btn {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    color: #fff;
    cursor: pointer;
    transition: background 0.2s ease;
}
.so-lock-screen-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}
.so-lock-screen-switch {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    transition: color 0.2s ease;
}
.so-lock-screen-switch:hover {
    color: #fff;
}

</style>

<!-- Lock Screen Overlay -->
<div class="so-lock-screen" id="lockScreen">
    <div class="so-lock-screen-container">
        <div class="so-lock-screen-time" id="lockScreenTime">12:00</div>
        <div class="so-lock-screen-date" id="lockScreenDate">Saturday, January 25</div>
        <div class="so-lock-screen-user">
            <div class="so-lock-screen-avatar" data-color="teal"><?= substr(DEMO_USER_NAME, 0, 1) ?></div>
            <div class="so-lock-screen-name"><?= DEMO_USER_NAME ?></div>
        </div>
        <form class="so-lock-screen-form" id="lockScreenForm">
            <div class="so-lock-screen-input-group">
                <input type="password" class="so-lock-screen-input" id="lockScreenPassword" placeholder="Enter password to unlock" autocomplete="off">
                <button type="submit" class="so-lock-screen-btn">
                    <span class="material-icons">arrow_forward</span>
                </button>
            </div>
        </form>
        <a href="<?= $relativePrefix ?>login.php" class="so-lock-screen-switch">Switch Account</a>
    </div>
</div>

    <!-- SixOrbit UI JavaScript -->
    <script src="<?= so_asset('js', 'sixorbit-full') ?>"></script>

    <!-- Global Page JS (Search Controller) -->
    <?php $globalJs = so_page_asset('global', 'js'); ?>
    <?php if ($globalJs): ?>
    <script src="<?= htmlspecialchars($globalJs) ?>"></script>
    <script>
    // Configure search with JSON data files
    document.addEventListener('DOMContentLoaded', function() {
        if (window.globalSearchController) {
            window.globalSearchController.configure({
                // Relative paths - resolved from current page location
                searchUrl: 'data/search-results.json',
                isvSearchUrl: 'data/isv-search-results.json',
                onSearch: function(query, results) {
                    console.log('Search:', query, results);
                },
                onItemClick: function(item) {
                    console.log('Item clicked:', item);
                },
                onAccountClick: function(item) {
                    console.log('Account clicked:', item);
                }
            });
        }
    });
    </script>
    <?php endif; ?>

    <?php if (!empty($additionalJs)): ?>
    <?php foreach ($additionalJs as $js): ?>
    <script src="<?= htmlspecialchars($js) ?>"></script>
    <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($inlineJs)): ?>
    <script>
    <?= $inlineJs ?>
    </script>
    <?php endif; ?>

</body>
</html>
