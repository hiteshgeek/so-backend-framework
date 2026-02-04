// ============================================
// SIXORBIT UI - LAYOUT COMPONENTS
// Navbar controller (Sidebar moved to src/pages/global/global.js)
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

// ============================================
// NAVBAR COMPONENT
// ============================================

/**
 * SONavbar - Navbar component
 * Handles navbar dropdowns and interactions
 */
class SONavbar extends SOComponent {
  static NAME = 'navbar';

  static DEFAULTS = {
    searchInputSelector: '.so-navbar-search-input',
    userBtnSelector: '.so-navbar-user-btn',
    userDropdownSelector: '.so-navbar-user-dropdown',
    appsBtnSelector: '.so-navbar-apps-btn',
    appsContainerSelector: '.so-navbar-apps',
    outletBtnSelector: '.so-navbar-outlet-btn',
    outletDropdownSelector: '.so-navbar-outlet-dropdown',
    statusBtnSelector: '.so-navbar-status-btn',
    statusDropdownSelector: '.so-navbar-status-dropdown',
    themeBtnSelector: '.so-navbar-theme-btn',
    themeDropdownSelector: '.so-navbar-theme-dropdown',
    keyboardBtnSelector: '#keyboardShortcutsBtn',
  };

  static EVENTS = {
    SEARCH: 'navbar:search',
    DROPDOWN_OPEN: 'navbar:dropdown:open',
    DROPDOWN_CLOSE: 'navbar:dropdown:close',
    OUTLET_CHANGE: 'navbar:outlet:change',
    STATUS_CHANGE: 'navbar:status:change',
  };

  /**
   * Initialize the navbar
   * @private
   */
  _init() {
    this._activeDropdown = null;
    this._bindEvents();
    this._initOutletSelector();
    this._initStatusSelector();
    this._initThemeSwitcher();
    this._initKeyboardShortcuts();
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Search input click - open search overlay
    // Use click instead of focus to prevent unintended overlay opening
    const searchInput = this.$(this.options.searchInputSelector);
    const searchWrapper = searchInput?.closest('.so-navbar-search-wrapper') || searchInput?.closest('.so-navbar-search');
    if (searchWrapper) {
      this.on('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (window.soSearchOverlay) {
          window.soSearchOverlay.open();
        }
      }, searchWrapper);
    }

    // User dropdown
    const userBtn = this.$(this.options.userBtnSelector);
    const userDropdown = this.$(this.options.userDropdownSelector);
    if (userBtn && userDropdown) {
      this.on('click', (e) => {
        e.stopPropagation();
        this._toggleDropdown(userDropdown, 'user', 'so-active');
      }, userBtn);

      // Handle menu item clicks - stop propagation to prevent triggering parent
      const menuItems = userDropdown.querySelectorAll('.so-navbar-user-menu-item');
      menuItems.forEach(item => {
        this.on('click', (e) => {
          e.stopPropagation();
          // Close dropdown after clicking a menu item
          this._closeNavbarDropdowns();
        }, item);
      });
    }

    // Apps dropdown
    const appsContainer = this.$(this.options.appsContainerSelector);
    const appsBtn = this.$(this.options.appsBtnSelector);
    if (appsContainer && appsBtn) {
      this.on('click', (e) => {
        e.stopPropagation();
        this._toggleDropdown(appsContainer, 'apps', 'so-open');
      }, appsBtn);
    }

    // Close dropdowns on outside click
    this.on('click', (e) => {
      // Don't close if clicking inside any dropdown
      const isInsideNavbarDropdown = e.target.closest('.so-navbar-outlet-dropdown, .so-navbar-status-dropdown, .so-navbar-theme-dropdown, .so-navbar-user-dropdown, .so-navbar-apps, .so-navbar-apps-dropdown');
      const isInsideSODropdown = e.target.closest('.so-dropdown, .so-searchable-dropdown, .so-options-dropdown, .so-outlet-dropdown');

      // Don't close if clicking on any dropdown trigger
      const isNavbarTrigger = e.target.closest('.so-navbar-user-btn, .so-navbar-apps-btn, .so-navbar-outlet-btn, .so-navbar-status-btn, .so-navbar-theme-btn');
      const isSODropdownTrigger = e.target.closest('.so-dropdown-trigger, .so-searchable-trigger, .so-options-trigger, .so-outlet-dropdown-trigger, .so-btn[data-so-toggle="dropdown"]');

      if (!isInsideNavbarDropdown && !isInsideSODropdown && !isNavbarTrigger && !isSODropdownTrigger) {
        this.closeAllDropdowns();
      }
    }, document);

    // Close on escape
    this.on('keydown', (e) => {
      if (e.key === 'Escape') {
        this.closeAllDropdowns();
      }
    }, document);

    // Listen for global close event
    this.on('closeAllDropdowns', () => this.closeAllDropdowns(), document);

    // Listen for close navbar dropdowns event (dispatched by SODropdown when opening)
    this.on('closeNavbarDropdowns', () => this._closeNavbarDropdowns(), document);
  }

  /**
   * Initialize outlet selector
   * @private
   */
  _initOutletSelector() {
    const outletBtn = this.$(this.options.outletBtnSelector);
    const outletDropdown = this.$(this.options.outletDropdownSelector);

    if (!outletBtn || !outletDropdown) return;

    // Toggle dropdown
    this.on('click', (e) => {
      e.stopPropagation();
      this._toggleDropdown(outletDropdown, 'outlet');
    }, outletBtn);

    // Handle outlet selection
    outletDropdown.querySelectorAll('.so-navbar-outlet-item').forEach(item => {
      this.on('click', (e) => {
        e.stopPropagation();
        const value = item.dataset.value;
        const text = item.querySelector('span:first-child')?.textContent || item.textContent;

        // Update selected state
        outletDropdown.querySelectorAll('.so-navbar-outlet-item').forEach(i => {
          i.classList.toggle('so-selected', i === item);
        });

        // Update button text
        const btnText = outletBtn.querySelector('.outlet-text');
        if (btnText) btnText.textContent = text;

        this.emit(SONavbar.EVENTS.OUTLET_CHANGE, { value, text });
        this.closeAllDropdowns();
      }, item);
    });

    // Search filter
    const searchInput = outletDropdown.querySelector('input');
    if (searchInput) {
      this.on('input', (e) => {
        const query = e.target.value.toLowerCase();
        outletDropdown.querySelectorAll('.so-navbar-outlet-item').forEach(item => {
          const text = item.textContent.toLowerCase();
          item.style.display = text.includes(query) ? '' : 'none';
        });
      }, searchInput);
    }
  }

  /**
   * Initialize status selector
   * @private
   */
  _initStatusSelector() {
    const statusBtn = this.$(this.options.statusBtnSelector);
    const statusDropdown = this.$(this.options.statusDropdownSelector);
    // Status dropdown requires 'open' class on parent .so-navbar-status container
    const statusContainer = statusBtn?.closest('.so-navbar-status');

    if (!statusBtn || !statusDropdown || !statusContainer) return;

    // Toggle dropdown - add 'open' to parent container
    this.on('click', (e) => {
      e.stopPropagation();
      this._toggleStatusDropdown(statusContainer);
    }, statusBtn);

    // Handle status selection
    statusDropdown.querySelectorAll('.so-navbar-status-option').forEach(option => {
      this.on('click', (e) => {
        e.stopPropagation();
        const status = option.dataset.status;
        const text = option.querySelector('.so-navbar-status-option-text > div:first-child')?.textContent;

        // Update selected state
        statusDropdown.querySelectorAll('.so-navbar-status-option').forEach(o => {
          o.classList.toggle('so-selected', o === option);
        });

        // Update button indicator and text
        const indicator = statusBtn.querySelector('.so-navbar-status-indicator');
        const textEl = statusBtn.querySelector('.so-navbar-status-text');
        if (indicator) {
          indicator.className = `so-navbar-status-indicator ${status}`;
        }
        if (textEl && text) {
          textEl.textContent = text;
        }

        this.emit(SONavbar.EVENTS.STATUS_CHANGE, { status, text });
        this.closeAllDropdowns();
      }, option);
    });
  }

  /**
   * Initialize theme switcher
   * @private
   */
  _initThemeSwitcher() {
    const themeBtn = this.$(this.options.themeBtnSelector);
    const themeDropdown = this.$(this.options.themeDropdownSelector);

    if (!themeBtn || !themeDropdown) return;

    // Toggle dropdown
    this.on('click', (e) => {
      e.stopPropagation();
      this._toggleDropdown(themeDropdown, 'theme');
    }, themeBtn);

    // Theme options handled by so-theme.js
  }

  /**
   * Initialize keyboard shortcuts button
   * @private
   */
  _initKeyboardShortcuts() {
    const keyboardBtn = this.$(this.options.keyboardBtnSelector);
    if (!keyboardBtn) return;

    this.on('click', (e) => {
      e.stopPropagation();
      // Trigger keyboard shortcuts modal
      if (window.soKeyboardShortcuts) {
        window.soKeyboardShortcuts.show();
      } else {
        // Simple alert for now - should be replaced with proper modal
        console.log('Keyboard shortcuts modal not implemented yet');
        alert('Keyboard Shortcuts:\n\nCtrl+K - Open Search\nCtrl+S - New Sales Invoice\nCtrl+P - New Purchase Bill\nCtrl+R - Receipt Entry\nCtrl+Y - Payment Entry\nEsc - Close dialogs');
      }
    }, keyboardBtn);
  }

  /**
   * Toggle a dropdown
   * @param {Element} dropdown - Dropdown element
   * @param {string} type - Dropdown type identifier
   * @param {string} activeClass - Class to toggle (default: 'active')
   * @private
   */
  _toggleDropdown(dropdown, type, activeClass = 'so-active') {
    const isActive = dropdown.classList.contains(activeClass);

    // Close all first (including SODropdowns)
    this.closeAllDropdowns();

    if (!isActive) {
      dropdown.classList.add(activeClass);
      this._activeDropdown = { dropdown, type };

      this.emit(SONavbar.EVENTS.DROPDOWN_OPEN, { dropdown, type });
    }
  }

  /**
   * Toggle status dropdown (uses 'open' on parent container)
   * @param {Element} container - Status container element (.so-navbar-status)
   * @private
   */
  _toggleStatusDropdown(container) {
    const isOpen = container.classList.contains('so-open');

    // Close all first
    this.closeAllDropdowns();

    if (!isOpen) {
      container.classList.add('so-open');
      this._activeDropdown = { dropdown: container, type: 'status' };

      this.emit(SONavbar.EVENTS.DROPDOWN_OPEN, { dropdown: container, type: 'status' });
    }
  }

  /**
   * Close only navbar custom dropdowns (not SODropdown instances)
   * @returns {this} For chaining
   * @private
   */
  _closeNavbarDropdowns() {
    // Close user dropdown
    this.$$('.so-navbar-user-dropdown').forEach(dropdown => {
      dropdown.classList.remove('so-active');
    });
    this.$$('.so-navbar-user-btn').forEach(btn => {
      btn.classList.remove('so-active');
    });

    // Close apps dropdown
    const appsContainer = this.$(this.options.appsContainerSelector);
    if (appsContainer) {
      appsContainer.classList.remove('so-open');
    }

    // Close outlet dropdown
    this.$$('.so-navbar-outlet-dropdown').forEach(dropdown => {
      dropdown.classList.remove('so-active');
    });

    // Close status dropdown (uses 'open' on parent container)
    this.$$('.so-navbar-status').forEach(container => {
      container.classList.remove('so-open');
    });

    // Close theme dropdown
    this.$$('.so-navbar-theme-dropdown').forEach(dropdown => {
      dropdown.classList.remove('so-active');
    });

    this._activeDropdown = null;
    return this;
  }

  /**
   * Close all dropdowns (navbar custom + SODropdown instances)
   * @returns {this} For chaining
   */
  closeAllDropdowns() {
    // Close navbar custom dropdowns
    this._closeNavbarDropdowns();

    // Close all SODropdown instances
    this.$$('.so-dropdown.so-open').forEach(dropdown => {
      const instance = SixOrbit.getInstance(dropdown, 'dropdown');
      if (instance && typeof instance.close === 'function') {
        instance.close();
      }
    });

    this.emit(SONavbar.EVENTS.DROPDOWN_CLOSE);
    return this;
  }
}

// Register component
SONavbar.register();

// Expose to global scope
window.SONavbar = SONavbar;

// Export for ES modules
export { SONavbar };
export default SONavbar;
