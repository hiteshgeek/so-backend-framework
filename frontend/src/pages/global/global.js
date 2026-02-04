// ============================================
// GLOBAL PAGE SCRIPTS - ENTRY POINT
// Imports all page-level modules
// ============================================

// Import modules
import { SidebarController } from './js/_sidebar.js';
import { NavbarController } from './js/_navbar.js';
import { GlobalSearchController } from './js/_search.js';

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  // Initialize sidebar
  const sidebarEl = document.querySelector('.so-sidebar');
  if (sidebarEl) {
    window.soSidebar = new SidebarController(sidebarEl);
  }

  // Initialize navbar (if needed)
  const navbarEl = document.querySelector('.so-navbar');
  if (navbarEl) {
    window.soNavbar = new NavbarController(navbarEl);
  }

  // Initialize search
  const searchOverlay = document.querySelector('.so-search-overlay');
  if (searchOverlay) {
    window.globalSearchController = new GlobalSearchController();
  }
});

// Export for external use
export { SidebarController, NavbarController, GlobalSearchController };
