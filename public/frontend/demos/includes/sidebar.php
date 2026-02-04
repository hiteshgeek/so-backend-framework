<?php
/**
 * SixOrbit UI Demo - Sidebar Component
 */

// Load sidebar menu data
$sidebarMenu = load_data('sidebar-menu.json');
$currentPagePath = get_current_page_path();

// Base path for all demo URLs (absolute)
$demoBase = defined('SO_DEMO_BASE') ? SO_DEMO_BASE : '/demo/';
$GLOBALS['demoBase'] = $demoBase; // Store in GLOBALS for function access

/**
 * Check if any child item is active (recursively)
 */
function check_children_active($children, $currentPagePath) {
    foreach ($children as $child) {
        $childUrl = $child['url'] ?? '';
        // Skip external URLs (containing ..) from active check
        if (strpos($childUrl, '..') === false) {
            // Compare full paths for exact matching
            if ($childUrl === $currentPagePath) {
                return true;
            }
        }
        if (!empty($child['children']) && check_children_active($child['children'], $currentPagePath)) {
            return true;
        }
    }
    return false;
}

/**
 * Render sidebar menu items recursively
 */
function render_menu_items($items, $currentPagePath, $depth = 0) {
    $demoBase = $GLOBALS['demoBase'] ?? (defined('SO_DEMO_BASE') ? SO_DEMO_BASE : '/demo/');
    $html = '';
    foreach ($items as $item) {
        $hasChildren = !empty($item['children']);
        $itemUrl = $item['url'] ?? '';
        // Skip external URLs (containing ..) from active check
        $isActive = false;
        if (strpos($itemUrl, '..') === false) {
            // Compare full paths for exact matching
            $isActive = ($itemUrl === $currentPagePath);
        }
        $isCurrent = $isActive;

        // Check if any child is active (recursively)
        if ($hasChildren) {
            $isActive = check_children_active($item['children'], $currentPagePath) || $isActive;
        }

        $itemClass = 'so-sidebar-item';
        if ($hasChildren) $itemClass .= ' has-children';
        if ($isActive && $hasChildren) $itemClass .= ' open';
        if ($isCurrent) $itemClass .= ' current';

        $html .= '<li class="' . $itemClass . '">';

        $url = $hasChildren ? '#' : ($item['url'] ?? '#');
        // Prepend /demo/ base for internal URLs (not #, not http, not ..)
        if ($url !== '#' && strpos($url, '#') !== 0 && strpos($url, 'http') !== 0 && strpos($url, '..') !== 0) {
            // Strip .php extension for router compatibility
            $url = preg_replace('/\.php$/', '', $url);
            $url = $demoBase . $url;
        }
        $html .= '<a href="' . htmlspecialchars($url) . '" class="so-sidebar-link">';
        $html .= '<span class="so-sidebar-icon"><span class="material-icons">' . ($item['icon'] ?? 'circle') . '</span></span>';
        $html .= '<span class="so-sidebar-text">' . htmlspecialchars($item['title'] ?? '') . '</span>';

        if (!empty($item['badge'])) {
            $badgeClass = $item['badgeClass'] ?? 'so-badge-primary';
            $html .= '<span class="so-badge ' . $badgeClass . ' so-badge-sm">' . htmlspecialchars($item['badge']) . '</span>';
        }

        if ($hasChildren) {
            $html .= '<span class="so-sidebar-arrow"><span class="material-icons">chevron_right</span></span>';
        }

        $html .= '</a>';

        if ($hasChildren) {
            $html .= '<ul class="so-sidebar-submenu">';
            $html .= render_menu_items($item['children'], $currentPagePath, $depth + 1);
            $html .= '</ul>';
        }

        $html .= '</li>';
    }
    return $html;
}
?>

<!-- Sidebar -->
<aside class="so-sidebar">
    <!-- Sidebar Header with Logo -->
    <div class="so-sidebar-header">
        <div class="so-sidebar-logo"><?= DEMO_COMPANY_INITIALS ?></div>
        <div class="so-sidebar-brand-info">
            <div class="so-sidebar-brand-name"><?= DEMO_COMPANY_NAME ?></div>
        </div>
        <button class="so-sidebar-toggle" title="Pin sidebar">
            <span class="toggle-circle"></span>
        </button>
    </div>

    <div class="so-sidebar-scroll">
        <!-- Navigation Menu -->
        <ul class="so-sidebar-nav">
            <?php if (!empty($sidebarMenu['menu'])): ?>
                <?= render_menu_items($sidebarMenu['menu'], $currentPagePath) ?>
            <?php else: ?>
                <!-- Fallback menu -->
                <li class="so-sidebar-item <?= is_page('index') ? 'current' : '' ?>">
                    <a href="index.php" class="so-sidebar-link">
                        <span class="so-sidebar-icon"><span class="material-icons">dashboard</span></span>
                        <span class="so-sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li class="so-sidebar-item <?= is_page('form-elements') ? 'current' : '' ?>">
                    <a href="form-elements.php" class="so-sidebar-link">
                        <span class="so-sidebar-icon"><span class="material-icons">input</span></span>
                        <span class="so-sidebar-text">Form Elements</span>
                    </a>
                </li>
                <li class="so-sidebar-item <?= is_page('profit-loss') ? 'current' : '' ?>">
                    <a href="profit-loss.php" class="so-sidebar-link">
                        <span class="so-sidebar-icon"><span class="material-icons">assessment</span></span>
                        <span class="so-sidebar-text">Reports</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Sidebar Footer -->
    <div class="so-sidebar-footer" data-server-ip="139.59.29.99" data-version="<?= SO_VERSION ?>" data-company-id="166262" data-licence-id="410002934">
        <div class="so-sidebar-footer-buttons">
            <button class="so-sidebar-footer-btn" id="sidebarInfoBtn" title="Connection Info">
                <span class="material-icons">info_outline</span>
            </button>
            <button class="so-sidebar-footer-btn" id="sidebarFullscreenBtn" title="Fullscreen">
                <span class="material-icons">fullscreen</span>
            </button>
            <button class="so-sidebar-footer-btn" id="sidebarSwitchCompanyBtn" title="Switch Company">
                <span class="material-icons">swap_horiz</span>
            </button>
            <button class="so-sidebar-footer-btn" id="sidebarLogoutBtn" title="Logout">
                <span class="material-icons">power_settings_new</span>
            </button>
        </div>

        <!-- Info Popup -->
        <div class="so-sidebar-info-popup" id="sidebarInfoPopup">
            <div class="so-sidebar-info-popup-header">
                <span class="material-icons">dns</span>
                <span>Connection Info</span>
            </div>
            <div class="so-sidebar-info-popup-content">
                <div class="so-sidebar-info-popup-row">
                    <span class="so-sidebar-info-popup-label">Server IP</span>
                    <span class="so-sidebar-info-popup-value" id="popupServerIp">139.59.29.99</span>
                </div>
                <div class="so-sidebar-info-popup-row">
                    <span class="so-sidebar-info-popup-label">Version</span>
                    <span class="so-sidebar-info-popup-value" id="popupVersion"><?= SO_VERSION ?></span>
                </div>
                <div class="so-sidebar-info-popup-row">
                    <span class="so-sidebar-info-popup-label">Company ID</span>
                    <span class="so-sidebar-info-popup-value" id="popupCompanyId">166262</span>
                </div>
                <div class="so-sidebar-info-popup-row">
                    <span class="so-sidebar-info-popup-label">Licence ID</span>
                    <span class="so-sidebar-info-popup-value" id="popupLicenceId">410002934</span>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay (for mobile) -->
<div class="so-sidebar-overlay"></div>
