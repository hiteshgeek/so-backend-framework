// ============================================
// SIXORBIT UI - BUNDLE (NO ES MODULES)
// Self-contained bundle for direct browser inclusion
// ============================================

// This file is used by the build system to create a single
// bundle that can be included directly in the browser without
// ES module support. The build.js script will concatenate
// all the individual files in the correct order.

// Load order (handled by build.js):
// 1. core/so-config.js
// 2. core/so-component.js
// 3. components/so-theme.js
// 4. components/so-dropdown.js
// 5. components/so-layout.js
// 6. components/so-modal.js
// 7. components/so-ripple.js
// 8. components/so-otp.js
// 9. components/so-tabs.js
// 10. components/so-tooltip.js
// 11. features/so-forms.js
// 12. features/so-search.js
// 13. features/so-auth.js

// Auto-initialization
(function() {
  'use strict';

  function initSixOrbit() {
    // Initialize sidebar if present
    const sidebar = document.querySelector('.so-sidebar');
    if (sidebar && typeof SOSidebar !== 'undefined') {
      SOSidebar.getInstance(sidebar);
    }

    // Initialize navbar if present
    const navbar = document.querySelector('.so-navbar');
    if (navbar && typeof SONavbar !== 'undefined') {
      SONavbar.getInstance(navbar);
    }

    // Initialize theme controller if settings exist
    const themeSettings = document.querySelector('.so-navbar-theme');
    if (themeSettings && typeof SOTheme !== 'undefined') {
      SOTheme.getInstance(themeSettings);
    }

    // Initialize forms
    if (typeof SOForms !== 'undefined') {
      SOForms.initAll();
    }

    // Initialize search overlay if present
    const searchOverlay = document.querySelector('.so-search-overlay');
    if (searchOverlay && typeof SOSearchOverlay !== 'undefined') {
      new SOSearchOverlay(document.body);
    }

    // Initialize OTP inputs if present
    if (typeof SOOtpInput !== 'undefined') {
      document.querySelectorAll('.so-otp-group').forEach(function(el) {
        SOOtpInput.getInstance(el);
      });
    }

    // Initialize tooltips
    if (typeof SOTooltip !== 'undefined') {
      SOTooltip.initAll();
    }

    console.log('SixOrbit UI initialized');
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSixOrbit);
  } else {
    initSixOrbit();
  }
})();
