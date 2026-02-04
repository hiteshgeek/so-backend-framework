// ============================================
// SIDEBAR CONTROLLER
// Standalone sidebar component
// ============================================

// Use prefix from SixOrbit config (fallback to 'so' if not available)
const PREFIX = (typeof window !== 'undefined' && window.SixOrbit?.PREFIX) || 'so';
const cls = (...parts) => `${PREFIX}-${parts.join('-')}`;

/**
 * SidebarController - Handles sidebar collapse/expand, pinning, mobile menu, and submenu navigation
 */
class SidebarController {
  static DEFAULTS = {
    mainContentSelector: '.so-main-content',
    overlaySelector: '.so-sidebar-overlay',
    toggleSelector: '.so-sidebar-toggle',
    storageKey: 'so-sidebar-state',
    breakpoint: 1024, // Changed from 768 to 1024 for tablet support
  };

  constructor(element, options = {}) {
    this.element = element;
    this.options = { ...SidebarController.DEFAULTS, ...options };

    if (!this.element) return;

    // Cache DOM elements
    this._mainContent = document.querySelector(this.options.mainContentSelector);
    this._overlay = document.querySelector(this.options.overlaySelector);
    this._toggle = this.element.querySelector(this.options.toggleSelector);

    // State
    this._isMobile = false;
    this._isCollapsed = true;
    this._isOpen = false;

    // Drawer for mobile/tablet
    this._drawer = null;
    this._drawerElement = null;

    // Disable transitions initially
    this.element.classList.add('no-transition');

    // Check viewport and restore state
    this._checkMobile();
    this._restoreState();

    // Initialize drawer for mobile/tablet
    this._initMobileDrawer();

    // Bind events
    this._bindEvents();

    // Initialize submenu state
    this._initSubmenuArrows();
    this._initSubmenuState();

    // Initialize footer buttons
    this._initFooterButtons();

    // Update body class
    this._updateBodyClass();

    // Re-enable transitions after paint
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        this.element.classList.remove('no-transition');
        document.documentElement.classList.remove('sidebar-collapsed', 'sidebar-pinned');
      });
    });
  }

  /**
   * Debounce helper
   */
  static debounce(fn, delay) {
    let timer = null;
    return function (...args) {
      clearTimeout(timer);
      timer = setTimeout(() => fn.apply(this, args), delay);
    };
  }

  /**
   * Initialize mobile drawer from sidebar content
   * Creates a SODrawer that mirrors the sidebar for mobile/tablet
   */
  _initMobileDrawer() {
    // Only create drawer if SODrawer is available
    if (typeof SODrawer === 'undefined') {
      console.warn('SODrawer not available, falling back to overlay sidebar');
      return;
    }

    // Create drawer element
    this._drawerElement = document.createElement('div');
    this._drawerElement.id = 'mobileSidebarDrawer';
    this._drawerElement.className = 'so-drawer so-drawer-left so-drawer-sidebar';
    this._drawerElement.tabIndex = -1;

    // Transfer sidebar-dark class if present
    if (this.element.classList.contains('sidebar-dark')) {
      this._drawerElement.classList.add('drawer-sidebar-dark');
    }

    // Get sidebar content
    const sidebarHeader = this.element.querySelector('.so-sidebar-header');
    const sidebarScroll = this.element.querySelector('.so-sidebar-scroll');
    const sidebarFooter = this.element.querySelector('.so-sidebar-footer');

    // Build drawer HTML
    this._drawerElement.innerHTML = `
      <div class="so-drawer-header">
        <div class="so-drawer-brand">
          ${sidebarHeader ? sidebarHeader.innerHTML : ''}
        </div>
        <button class="so-drawer-close" data-dismiss="drawer">
          <span class="material-icons">close</span>
        </button>
      </div>
      <div class="so-drawer-body so-drawer-sidebar-body">
        ${sidebarScroll ? sidebarScroll.innerHTML : ''}
      </div>
      ${sidebarFooter ? `<div class="so-drawer-footer">${sidebarFooter.innerHTML}</div>` : ''}
    `;

    // Append to body
    document.body.appendChild(this._drawerElement);

    // Initialize SODrawer instance
    this._drawer = new SODrawer(this._drawerElement, {
      backdrop: true,
      keyboard: true,
      scroll: false,
      animation: true,
    });

    // Bind drawer events
    this._bindDrawerEvents();

    // Initialize submenu state in drawer
    this._initDrawerSubmenuState();
  }

  /**
   * Bind drawer-specific events
   */
  _bindDrawerEvents() {
    if (!this._drawerElement) return;

    // Sync drawer close with sidebar state
    this._drawerElement.addEventListener('drawer:hidden', () => {
      this._isOpen = false;
      document.body.classList.remove('so-sidebar-open');
    });

    // Handle navigation clicks in drawer
    this._drawerElement.addEventListener('click', (e) => {
      const link = e.target.closest('.so-sidebar-link');
      if (link) {
        const item = link.parentElement;
        const submenu = item.querySelector('.so-sidebar-submenu');
        if (submenu) {
          // Toggle submenu
          e.preventDefault();
          this._toggleDrawerSubmenu(item);
        } else {
          // Regular link - close drawer after navigation
          // Small delay to allow ripple effect
          setTimeout(() => {
            if (this._drawer) {
              this._drawer.hide();
            }
          }, 150);
        }
      }
    });

    // Handle footer button clicks
    this._drawerElement.querySelectorAll('.so-sidebar-footer-item').forEach(btn => {
      btn.addEventListener('click', () => {
        // Close drawer after footer action
        setTimeout(() => {
          if (this._drawer) {
            this._drawer.hide();
          }
        }, 150);
      });
    });
  }

  /**
   * Toggle submenu in drawer
   */
  _toggleDrawerSubmenu(item) {
    const isOpen = item.classList.contains(cls('open'));
    const parent = item.parentElement;

    // Close siblings
    parent.querySelectorAll(':scope > .so-sidebar-item.so-open').forEach(sibling => {
      if (sibling !== item) {
        sibling.classList.remove(cls('open'));
      }
    });

    // Toggle current
    item.classList.toggle(cls('open'), !isOpen);
  }

  /**
   * Initialize submenu state in drawer based on current page
   */
  _initDrawerSubmenuState() {
    if (!this._drawerElement) return;

    // Copy active/current classes from sidebar to drawer
    const sidebarItems = this.element.querySelectorAll('.so-sidebar-item');
    const drawerItems = this._drawerElement.querySelectorAll('.so-sidebar-item');

    sidebarItems.forEach((sidebarItem, index) => {
      if (drawerItems[index]) {
        if (sidebarItem.classList.contains('current')) {
          drawerItems[index].classList.add('current');
        }
        if (sidebarItem.classList.contains('active')) {
          drawerItems[index].classList.add('active');
        }
        if (sidebarItem.classList.contains(cls('open'))) {
          drawerItems[index].classList.add(cls('open'));
        }
      }
    });
  }

  /**
   * Update drawer theme when sidebar theme changes
   * @param {boolean} isDark - Whether dark theme is active
   */
  setDrawerTheme(isDark) {
    if (this._drawerElement) {
      this._drawerElement.classList.toggle('drawer-sidebar-dark', isDark);
    }
  }

  /**
   * Bind event listeners
   */
  _bindEvents() {
    // Window resize
    window.addEventListener('resize', SidebarController.debounce(() => {
      const wasMobile = this._isMobile;
      this._checkMobile();

      // Close drawer when switching from mobile to desktop
      if (wasMobile && !this._isMobile && this._drawer && this._drawer.isOpen()) {
        this._drawer.hide();
      }

      // Close mobile overlay if using fallback
      if (this._isMobile && !this._drawer) {
        this._closeMobile();
      }

      this._updateBodyClass();
    }, 150));

    // Toggle button (pin/unpin)
    if (this._toggle) {
      this._toggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.togglePinned();
      });
    }

    // Mobile toggle buttons
    document.querySelectorAll('[data-toggle="sidebar"]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        if (this._isMobile) {
          this.toggleMobile();
        } else {
          this.togglePinned();
        }
      });
    });

    // Overlay click
    if (this._overlay) {
      this._overlay.addEventListener('click', () => this._closeMobile());
    }

    // Submenu toggle
    this.element.addEventListener('click', (e) => {
      const link = e.target.closest('.so-sidebar-link');
      if (link) {
        const item = link.parentElement;
        const submenu = item.querySelector('.so-sidebar-submenu');
        if (submenu) {
          e.preventDefault();
          this._toggleSubmenu(item);
        }
      }
    });

    // Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this._isMobile && this._isOpen) {
        this._closeMobile();
      }
    });
  }

  /**
   * Check if viewport is mobile
   */
  _checkMobile() {
    // Use < to match CSS media query: @include media-down('lg') = max-width: 1023px
    this._isMobile = window.innerWidth < this.options.breakpoint;
  }

  /**
   * Update body class based on sidebar state
   */
  _updateBodyClass() {
    if (this._isCollapsed && !this._isMobile) {
      document.body.classList.add('sidebar-collapsed');
    } else {
      document.body.classList.remove('sidebar-collapsed');
    }
  }

  /**
   * Toggle pinned state
   */
  togglePinned() {
    this._isCollapsed = !this._isCollapsed;

    // Batch all class changes in a single frame for synchronized animation
    requestAnimationFrame(() => {
      if (this._isCollapsed) {
        this.element.classList.add('so-collapsed');
        this.element.classList.remove('pinned');
        document.body.classList.add('sidebar-collapsed');
      } else {
        this.element.classList.remove('so-collapsed');
        this.element.classList.add('pinned');
        document.body.classList.remove('sidebar-collapsed');
      }
    });

    this._saveState(this._isCollapsed ? 'collapsed' : 'pinned');

    return this;
  }

  /**
   * Pin the sidebar (expand)
   */
  pin() {
    if (!this._isCollapsed) return this;
    return this.togglePinned();
  }

  /**
   * Unpin the sidebar (collapse)
   */
  unpin() {
    if (this._isCollapsed) return this;
    return this.togglePinned();
  }

  /**
   * Check if sidebar is pinned
   */
  isPinned() {
    return !this._isCollapsed;
  }

  /**
   * Toggle mobile sidebar
   */
  toggleMobile() {
    // Use drawer if available
    if (this._drawer) {
      return this._drawer.toggle();
    }
    // Fallback to overlay pattern
    return this._isOpen ? this._closeMobile() : this._openMobile();
  }

  /**
   * Open mobile sidebar
   */
  _openMobile() {
    // Use drawer if available
    if (this._drawer) {
      this._isOpen = true;
      document.body.classList.add('so-sidebar-open');
      return this._drawer.show();
    }
    // Fallback to overlay pattern
    this._isOpen = true;
    this.element.classList.add(cls('open'));
    this._overlay?.classList.add(cls('active'));
    document.body.classList.add('so-sidebar-open');
    document.body.style.overflow = 'hidden';
    return this;
  }

  /**
   * Close mobile sidebar
   */
  _closeMobile() {
    // Use drawer if available
    if (this._drawer) {
      this._isOpen = false;
      document.body.classList.remove('so-sidebar-open');
      return this._drawer.hide();
    }
    // Fallback to overlay pattern
    this._isOpen = false;
    this.element.classList.remove(cls('open'));
    this._overlay?.classList.remove(cls('active'));
    document.body.classList.remove('so-sidebar-open');
    document.body.style.overflow = '';
    return this;
  }

  /**
   * Toggle submenu
   */
  _toggleSubmenu(item) {
    const isOpen = item.classList.contains(cls('open'));
    const parent = item.parentElement;

    // Close siblings
    parent.querySelectorAll(':scope > .so-sidebar-item.so-open').forEach(sibling => {
      if (sibling !== item) {
        sibling.classList.remove(cls('open'));
      }
    });

    // Toggle current
    item.classList.toggle(cls('open'), !isOpen);
  }

  /**
   * Initialize arrows for nested submenu items
   */
  _initSubmenuArrows() {
    this.element.querySelectorAll('.so-sidebar-submenu .so-sidebar-item').forEach(item => {
      const nestedSubmenu = item.querySelector(':scope > .so-sidebar-submenu');
      if (nestedSubmenu) {
        item.classList.add('has-children');

        const link = item.querySelector(':scope > .so-sidebar-link');
        if (link && !link.querySelector('.so-sidebar-arrow')) {
          const arrow = document.createElement('span');
          arrow.className = 'so-sidebar-arrow';
          arrow.innerHTML = '<span class="material-icons">chevron_right</span>';
          link.appendChild(arrow);
        }
      }
    });
  }

  /**
   * Initialize submenu state based on active items
   */
  _initSubmenuState() {
    this.element.querySelectorAll('.so-sidebar-item.current, .so-sidebar-item.active').forEach(item => {
      let parent = item.parentElement.closest('.so-sidebar-item');
      while (parent) {
        parent.classList.add(cls('open'));
        parent = parent.parentElement.closest('.so-sidebar-item');
      }
    });
  }

  /**
   * Initialize sidebar footer buttons
   */
  _initFooterButtons() {
    const footer = this.element.querySelector('.so-sidebar-footer');
    if (!footer) return;

    // Info button - toggle popup
    const infoBtn = footer.querySelector('#sidebarInfoBtn');
    const infoPopup = footer.querySelector('#sidebarInfoPopup');
    if (infoBtn && infoPopup) {
      infoBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        infoPopup.classList.toggle('so-active');
      });

      // Close popup on outside click
      document.addEventListener('click', (e) => {
        if (!infoPopup.contains(e.target) && !infoBtn.contains(e.target)) {
          infoPopup.classList.remove('so-active');
        }
      });
    }

    // Fullscreen button
    const fullscreenBtn = footer.querySelector('#sidebarFullscreenBtn');
    if (fullscreenBtn) {
      fullscreenBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        this._toggleFullscreen();
      });
    }

    // Navbar fullscreen button (in user dropdown)
    const navbarFullscreenBtn = document.getElementById('navbarFullscreenBtn');
    if (navbarFullscreenBtn) {
      navbarFullscreenBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        this._toggleFullscreen();
      });
    }

    // Listen for fullscreen change to update icons
    document.addEventListener('fullscreenchange', () => this._updateFullscreenIcon());
    document.addEventListener('webkitfullscreenchange', () => this._updateFullscreenIcon());

    // Logout buttons - use framework's SOModal.confirm()
    const sidebarLogoutBtn = footer.querySelector('#sidebarLogoutBtn');
    const navbarLogoutBtn = document.getElementById('navbarLogoutBtn');

    const handleLogout = () => {
      localStorage.removeItem('so-user-session');
      localStorage.removeItem('so-screen-locked');
      sessionStorage.clear();
      // Navigate to login page relative to demo root
      const currentPath = window.location.pathname;
      const demoIndex = currentPath.indexOf('/demo/');
      if (demoIndex !== -1) {
        const basePath = currentPath.substring(0, demoIndex + 6); // includes '/demo/'
        window.location.href = basePath + 'login.php';
      } else {
        window.location.href = '/demo/login.php';
      }
    };

    const showLogoutConfirmation = async () => {
      // Use framework's SOModal.confirm()
      if (typeof SOModal !== 'undefined' && SOModal.confirm) {
        const confirmed = await SOModal.confirm({
          title: 'Confirm Logout',
          message: 'Are you sure you want to logout? Any unsaved changes will be lost.',
          icon: { name: 'logout', type: 'danger' },
          confirm: [{ icon: 'logout' }, 'Logout'],
          cancel: 'Cancel',
          danger: true
        });
        if (confirmed) {
          handleLogout();
        }
      } else {
        // Fallback if SOModal not available
        if (confirm('Are you sure you want to logout?')) {
          handleLogout();
        }
      }
    };

    if (sidebarLogoutBtn) {
      sidebarLogoutBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        showLogoutConfirmation();
      });
    }

    if (navbarLogoutBtn) {
      navbarLogoutBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        showLogoutConfirmation();
      });
    }

    // Lock Screen button
    const lockScreenBtn = document.getElementById('lockScreenBtn');
    const lockScreen = document.getElementById('lockScreen');
    const lockScreenForm = document.getElementById('lockScreenForm');
    const lockScreenPassword = document.getElementById('lockScreenPassword');
    const lockScreenTime = document.getElementById('lockScreenTime');
    const lockScreenDate = document.getElementById('lockScreenDate');

    const updateLockScreenTime = () => {
      const now = new Date();
      const hours = now.getHours().toString().padStart(2, '0');
      const minutes = now.getMinutes().toString().padStart(2, '0');
      if (lockScreenTime) lockScreenTime.textContent = `${hours}:${minutes}`;
      if (lockScreenDate) {
        const options = { weekday: 'long', month: 'long', day: 'numeric' };
        lockScreenDate.textContent = now.toLocaleDateString('en-US', options);
      }
    };

    const lockScreenAction = () => {
      if (lockScreen) {
        lockScreen.classList.add('active');
        document.body.classList.add('screen-locked');
        localStorage.setItem('so-screen-locked', 'true');
        updateLockScreenTime();
        if (lockScreenPassword) lockScreenPassword.focus();
      }
    };

    const unlockScreenAction = () => {
      if (lockScreen) {
        lockScreen.classList.remove('active');
        document.body.classList.remove('screen-locked');
        localStorage.removeItem('so-screen-locked');
        if (lockScreenPassword) lockScreenPassword.value = '';
      }
    };

    if (lockScreenBtn) {
      lockScreenBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        lockScreenAction();
      });
    }

    if (lockScreenForm) {
      lockScreenForm.addEventListener('submit', (e) => {
        e.preventDefault();
        unlockScreenAction();
      });
    }

    // Check if screen was locked on page load
    if (localStorage.getItem('so-screen-locked') === 'true' && lockScreen) {
      lockScreen.classList.add('active');
      document.body.classList.add('screen-locked');
      updateLockScreenTime();
      if (lockScreenPassword) lockScreenPassword.focus();
    }

  }

  /**
   * Toggle fullscreen mode
   */
  _toggleFullscreen() {
    if (!document.fullscreenElement && !document.webkitFullscreenElement) {
      // Enter fullscreen
      const elem = document.documentElement;
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen();
      }
    } else {
      // Exit fullscreen
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      }
    }
  }

  /**
   * Update fullscreen button icons
   */
  _updateFullscreenIcon() {
    const isFullscreen = document.fullscreenElement || document.webkitFullscreenElement;
    const iconText = isFullscreen ? 'fullscreen_exit' : 'fullscreen';

    // Update sidebar button
    const sidebarBtn = this.element.querySelector('#sidebarFullscreenBtn .material-icons');
    if (sidebarBtn) sidebarBtn.textContent = iconText;

    // Update navbar button
    const navbarBtn = document.querySelector('#navbarFullscreenBtn .material-icons');
    if (navbarBtn) navbarBtn.textContent = iconText;
  }

  /**
   * Save sidebar state to storage
   */
  _saveState(state) {
    try {
      localStorage.setItem(this.options.storageKey, state);
    } catch (e) {
      // Storage not available
    }
  }

  /**
   * Restore sidebar state from storage
   */
  _restoreState() {
    if (this._isMobile) return;

    try {
      const state = localStorage.getItem(this.options.storageKey);
      if (state === 'pinned') {
        this._isCollapsed = false;
        this.element.classList.remove('so-collapsed');
        this.element.classList.add('pinned');
      } else {
        this._isCollapsed = true;
        this.element.classList.add('so-collapsed');
      }
    } catch (e) {
      // Storage not available
      this._isCollapsed = true;
      this.element.classList.add('so-collapsed');
    }
  }
}

// Export
export { SidebarController };
export default SidebarController;
