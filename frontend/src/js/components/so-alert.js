// ============================================
// SIXORBIT UI - ALERT COMPONENT
// Dismissible alerts with animations
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOAlert - Alert notification component
 * Supports dismissible alerts with smooth animations
 */
class SOAlert extends SOComponent {
  static NAME = 'alert';

  static DEFAULTS = {
    dismissible: true,
    animation: true,
    autoDismiss: false,
    autoDismissDelay: 5000,
  };

  static EVENTS = {
    CLOSE: 'alert:close',
    CLOSED: 'alert:closed',
  };

  // Icon map for contextual types
  static ICONS = {
    primary: 'lightbulb',
    secondary: 'info',
    success: 'check_circle',
    danger: 'error',
    error: 'error',
    warning: 'warning',
    info: 'info',
    light: 'help_outline',
    dark: 'info',
  };

  /**
   * Initialize the alert
   * @private
   */
  _init() {
    // State
    this._isClosing = false;
    this._autoDismissTimer = null;

    // Bind events
    this._bindEvents();

    // Start auto-dismiss timer if enabled
    if (this.options.autoDismiss) {
      this._startAutoDismiss();
    }
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Close button click
    this.delegate('click', '.so-alert-close, [data-dismiss="alert"]', () => this.close());
  }

  /**
   * Start auto-dismiss timer
   * @private
   */
  _startAutoDismiss() {
    this._autoDismissTimer = setTimeout(() => {
      this.close();
    }, this.options.autoDismissDelay);
  }

  /**
   * Clear auto-dismiss timer
   * @private
   */
  _clearAutoDismiss() {
    if (this._autoDismissTimer) {
      clearTimeout(this._autoDismissTimer);
      this._autoDismissTimer = null;
    }
  }

  // ============================================
  // PUBLIC API
  // ============================================

  /**
   * Close/dismiss the alert
   * @returns {this} For chaining
   */
  close() {
    if (this._isClosing) return this;

    // Emit close event (can be prevented)
    if (!this.emit(SOAlert.EVENTS.CLOSE)) {
      return this;
    }

    this._isClosing = true;
    this._clearAutoDismiss();

    if (this.options.animation) {
      // Add closing animation
      this.element.style.opacity = '0';
      this.element.style.transform = 'translateY(-10px)';
      this.element.style.transition = 'opacity 0.15s ease, transform 0.15s ease, margin 0.15s ease, padding 0.15s ease';

      // After initial fade, collapse height
      setTimeout(() => {
        this.element.style.overflow = 'hidden';
        this.element.style.height = this.element.offsetHeight + 'px';
        this.element.style.marginTop = '0';
        this.element.style.marginBottom = '0';
        this.element.style.paddingTop = '0';
        this.element.style.paddingBottom = '0';

        // Force reflow
        this.element.offsetHeight;

        this.element.style.height = '0';
      }, 150);

      // Remove element after animation
      this.element.addEventListener('transitionend', (e) => {
        if (e.propertyName === 'height') {
          this._removeElement();
        }
      }, { once: true });
    } else {
      this._removeElement();
    }

    return this;
  }

  /**
   * Remove element from DOM and cleanup
   * @private
   */
  _removeElement() {
    // Guard against multiple calls
    if (!this.element || !this.element.parentNode) return;

    this.emit(SOAlert.EVENTS.CLOSED);
    this.element.remove();
    this.destroy();
  }

  /**
   * Show a hidden alert
   * @returns {this} For chaining
   */
  show() {
    this.element.style.display = '';
    this.element.style.opacity = '';
    this.element.style.transform = '';
    this.element.style.height = '';
    this.element.style.overflow = '';

    if (this.options.autoDismiss) {
      this._startAutoDismiss();
    }

    return this;
  }

  // ============================================
  // STATIC METHODS
  // ============================================

  /**
   * Create an alert programmatically
   * @param {Object} options - Alert configuration
   * @returns {SOAlert} Alert instance
   */
  static create(options = {}) {
    const {
      type = 'info',
      title = '',
      message = '',
      icon = null,
      dismissible = true,
      outline = false,
      small = false,
      autoDismiss = false,
      autoDismissDelay = 5000,
      container = document.body,
      insertPosition = 'afterbegin', // 'beforeend' | 'afterbegin'
      className = '',
    } = options;

    // Determine icon
    const alertIcon = icon || SOAlert.ICONS[type] || 'info';

    // Build class list
    const classes = [
      'so-alert',
      `so-alert-${type}`,
      dismissible ? 'so-alert-dismissible' : '',
      outline ? 'so-alert-outline' : '',
      small ? 'so-alert-sm' : '',
      className,
    ].filter(Boolean).join(' ');

    // Create element
    const alert = document.createElement('div');
    alert.className = classes;
    alert.setAttribute('role', 'alert');

    // Build HTML
    let html = `
      <span class="so-alert-icon">
        <span class="material-icons">${alertIcon}</span>
      </span>
      <div class="so-alert-content">
        ${title ? `<strong>${title}</strong>` : ''}
        ${message}
      </div>
    `;

    if (dismissible) {
      html += `
        <button type="button" class="so-alert-close" data-dismiss="alert" aria-label="Close">
          <span class="material-icons">close</span>
        </button>
      `;
    }

    alert.innerHTML = html;

    // Insert into container
    const containerEl = typeof container === 'string'
      ? document.querySelector(container)
      : container;

    if (containerEl) {
      containerEl.insertAdjacentElement(insertPosition, alert);
    }

    // Create and return instance
    return new SOAlert(alert, {
      dismissible,
      animation: true,
      autoDismiss,
      autoDismissDelay,
    });
  }

  /**
   * Create a success alert
   * @param {string} message - Alert message
   * @param {Object} options - Additional options
   * @returns {SOAlert} Alert instance
   */
  static success(message, options = {}) {
    return SOAlert.create({ ...options, type: 'success', message });
  }

  /**
   * Create an error/danger alert
   * @param {string} message - Alert message
   * @param {Object} options - Additional options
   * @returns {SOAlert} Alert instance
   */
  static error(message, options = {}) {
    return SOAlert.create({ ...options, type: 'danger', message });
  }

  /**
   * Create a warning alert
   * @param {string} message - Alert message
   * @param {Object} options - Additional options
   * @returns {SOAlert} Alert instance
   */
  static warning(message, options = {}) {
    return SOAlert.create({ ...options, type: 'warning', message });
  }

  /**
   * Create an info alert
   * @param {string} message - Alert message
   * @param {Object} options - Additional options
   * @returns {SOAlert} Alert instance
   */
  static info(message, options = {}) {
    return SOAlert.create({ ...options, type: 'info', message });
  }

  /**
   * Initialize all dismissible alerts on page
   * @param {string} selector - Optional custom selector
   * @returns {SOAlert[]} Array of instances
   */
  static initAll(selector = '.so-alert-dismissible') {
    const elements = document.querySelectorAll(selector);
    return Array.from(elements).map(el => SOAlert.getInstance(el));
  }
}

// Register component
SOAlert.register();

// Expose to global scope
window.SOAlert = SOAlert;

// Export for ES modules
export default SOAlert;
export { SOAlert };
