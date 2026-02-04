// ============================================
// SIXORBIT UI - THEME CONTROLLER
// Handles theme switching and font size scaling
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOTheme - Theme controller component
 * Manages theme switching (light, dark, sidebar-dark, system)
 * and font size scaling (small, default, large)
 */
class SOTheme extends SOComponent {
  static NAME = 'theme';

  static DEFAULTS = {
    themes: ['light', 'dark', 'sidebar-dark', 'system'],
    fontSizes: ['small', 'default', 'large'],
    defaultTheme: 'sidebar-dark',
    defaultFontSize: 'default',
    storageKeyTheme: 'theme-preference',
    storageKeyFont: 'fontsize-preference',
  };

  static EVENTS = {
    CHANGE: 'theme:change',
    FONTSIZE: 'theme:fontsize',
  };

  /**
   * Initialize the theme controller
   * @private
   */
  _init() {
    // Cache DOM elements
    this.themeBtn = this.$('.so-navbar-theme-btn');
    this.themeDropdown = this.$('.so-navbar-theme-dropdown');

    // State
    this._currentTheme = this.options.defaultTheme;
    this._currentFontSize = this.options.defaultFontSize;

    // Restore saved preferences
    this._restoreTheme();
    this._restoreFontSize();

    // Bind events
    this._bindEvents();

    // Apply initial theme and font size
    this._applyTheme();
    this._applyFontSize();
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Toggle dropdown
    if (this.themeBtn) {
      this.on('click', this._handleToggle, this.themeBtn);
    }

    // Theme option clicks
    this.delegate('click', '.so-navbar-theme-option', this._handleOptionClick);

    // Close on outside click
    this.on('click', this._handleOutsideClick, document);

    // Close on escape
    this.on('keydown', this._handleKeydown, document);

    // Listen for system theme changes
    if (window.matchMedia) {
      const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
      mediaQuery.addEventListener('change', () => {
        if (this._currentTheme === 'system') {
          this._applyTheme();
        }
      });
    }

    // Listen for global dropdown close event
    this.on('closeAllDropdowns', this._closeDropdown, document);
  }

  /**
   * Handle toggle button click
   * @param {Event} e - Click event
   * @private
   */
  _handleToggle(e) {
    e.stopPropagation();
    const isOpen = this.hasClass('so-open');

    if (!isOpen) {
      // Close other dropdowns
      document.dispatchEvent(new CustomEvent('closeAllDropdowns'));
    }

    this.toggleClass('so-open');
  }

  /**
   * Handle theme/fontsize option click
   * @param {Event} e - Click event
   * @param {Element} target - Clicked option element
   * @private
   */
  _handleOptionClick(e, target) {
    e.stopPropagation();

    const theme = target.dataset.theme;
    const fontsize = target.dataset.fontsize;

    if (theme) {
      this.setTheme(theme);
    } else if (fontsize) {
      this.setFontSize(fontsize);
    }

    this._closeDropdown();
  }

  /**
   * Handle outside click
   * @private
   */
  _handleOutsideClick() {
    this._closeDropdown();
  }

  /**
   * Handle keydown events
   * @param {KeyboardEvent} e - Keyboard event
   * @private
   */
  _handleKeydown(e) {
    if (e.key === 'Escape') {
      this._closeDropdown();
    }
  }

  /**
   * Close the dropdown
   * @private
   */
  _closeDropdown() {
    this.removeClass('so-open');
  }

  // ============================================
  // THEME METHODS
  // ============================================

  /**
   * Set the current theme
   * @param {string} theme - Theme name (light, dark, sidebar-dark, system)
   * @returns {this} For chaining
   */
  setTheme(theme) {
    if (!this.options.themes.includes(theme)) {
      console.warn(`SOTheme: Invalid theme "${theme}"`);
      return this;
    }

    const previousTheme = this._currentTheme;
    this._currentTheme = theme;

    this._saveTheme();
    this._applyTheme();
    this._updateActiveOption();

    // Emit event
    this.emit(SOTheme.EVENTS.CHANGE, {
      theme,
      previousTheme,
      effectiveTheme: this.getEffectiveTheme(),
    });

    return this;
  }

  /**
   * Get the current theme setting
   * @returns {string} Current theme
   */
  getTheme() {
    return this._currentTheme;
  }

  /**
   * Get the effective theme (resolved system theme)
   * @returns {string} Effective theme (light or dark)
   */
  getEffectiveTheme() {
    if (this._currentTheme === 'system') {
      return this._getSystemTheme();
    }
    if (this._currentTheme === 'sidebar-dark') {
      return 'light';
    }
    return this._currentTheme;
  }

  /**
   * Apply the current theme to the document
   * @private
   */
  _applyTheme() {
    let effectiveTheme = this._currentTheme;
    const sidebar = document.querySelector('.so-sidebar');

    // Handle sidebar-dark theme
    if (this._currentTheme === 'sidebar-dark') {
      effectiveTheme = 'light';
      if (sidebar) sidebar.classList.add('sidebar-dark');
    } else {
      if (sidebar) sidebar.classList.remove('sidebar-dark');

      // Resolve system theme
      if (this._currentTheme === 'system') {
        effectiveTheme = this._getSystemTheme();
      }
    }

    // Apply to document
    document.documentElement.setAttribute('data-theme', effectiveTheme);

    // Update icon
    this._updateIcon(effectiveTheme);
  }

  /**
   * Get system preferred theme
   * @returns {string} System theme (light or dark)
   * @private
   */
  _getSystemTheme() {
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      return 'dark';
    }
    return 'light';
  }

  /**
   * Update the theme button icon
   * @param {string} effectiveTheme - Current effective theme
   * @private
   */
  _updateIcon(effectiveTheme) {
    const icon = this.themeBtn?.querySelector('.theme-icon');
    if (!icon) return;

    if (this._currentTheme === 'sidebar-dark') {
      icon.textContent = 'contrast';
    } else if (this._currentTheme === 'system') {
      icon.textContent = 'computer';
    } else if (effectiveTheme === 'dark') {
      icon.textContent = 'dark_mode';
    } else {
      icon.textContent = 'light_mode';
    }
  }

  /**
   * Update active state on theme options
   * @private
   */
  _updateActiveOption() {
    this.$$('.so-navbar-theme-option').forEach(option => {
      const isActive = option.dataset.theme === this._currentTheme;
      option.classList.toggle('so-active', isActive);
    });
  }

  /**
   * Save theme preference to storage
   * @private
   */
  _saveTheme() {
    SixOrbit.setStorage(this.options.storageKeyTheme, this._currentTheme);
  }

  /**
   * Restore theme preference from storage
   * @private
   */
  _restoreTheme() {
    const saved = SixOrbit.getStorage(this.options.storageKeyTheme);
    if (saved && this.options.themes.includes(saved)) {
      this._currentTheme = saved;
    }
    this._updateActiveOption();
  }

  // ============================================
  // FONT SIZE METHODS
  // ============================================

  /**
   * Set the font size
   * @param {string} size - Font size (small, default, large)
   * @returns {this} For chaining
   */
  setFontSize(size) {
    if (!this.options.fontSizes.includes(size)) {
      console.warn(`SOTheme: Invalid font size "${size}"`);
      return this;
    }

    const previousSize = this._currentFontSize;
    this._currentFontSize = size;

    this._saveFontSize();
    this._applyFontSize();
    this._updateActiveFontSizeOption();

    // Emit event
    this.emit(SOTheme.EVENTS.FONTSIZE, {
      fontSize: size,
      previousFontSize: previousSize,
    });

    return this;
  }

  /**
   * Get the current font size
   * @returns {string} Current font size
   */
  getFontSize() {
    return this._currentFontSize;
  }

  /**
   * Apply the current font size to the document
   * @private
   */
  _applyFontSize() {
    if (this._currentFontSize === 'default') {
      document.documentElement.removeAttribute('data-fontsize');
    } else {
      document.documentElement.setAttribute('data-fontsize', this._currentFontSize);
    }
  }

  /**
   * Update active state on font size options
   * @private
   */
  _updateActiveFontSizeOption() {
    this.$$('.so-navbar-theme-option').forEach(option => {
      if (option.dataset.fontsize) {
        const isActive = option.dataset.fontsize === this._currentFontSize;
        option.classList.toggle('so-active', isActive);
      }
    });
  }

  /**
   * Save font size preference to storage
   * @private
   */
  _saveFontSize() {
    SixOrbit.setStorage(this.options.storageKeyFont, this._currentFontSize);
  }

  /**
   * Restore font size preference from storage
   * @private
   */
  _restoreFontSize() {
    const saved = SixOrbit.getStorage(this.options.storageKeyFont);
    if (saved && this.options.fontSizes.includes(saved)) {
      this._currentFontSize = saved;
    }
    this._updateActiveFontSizeOption();
  }
}

// Register component
SOTheme.register();

// Expose to global scope
window.SOTheme = SOTheme;

// Export for ES modules
export default SOTheme;
export { SOTheme };
