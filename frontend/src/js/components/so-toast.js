// ============================================
// SIXORBIT UI - TOAST COMPONENT
// Toast notifications with auto-dismiss
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOToast - Toast notification component
 * Supports multiple positions, auto-dismiss, and stacking
 */
class SOToast extends SOComponent {
  static NAME = 'toast';

  static DEFAULTS = {
    position: 'top-right', // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center, custom
    autohide: true,
    delay: 5000,
    animation: true,
    showProgress: true,
    pauseOnHover: true,
    pauseOnFocusLoss: false,
    closeButton: true,
    newestOnTop: true,
    maxVisible: 5,
    // Custom position coordinates (only used when position: 'custom')
    x: null, // left position in px or percentage (e.g., 100 or '50%')
    y: null, // top position in px or percentage (e.g., 100 or '50%')
  };

  static EVENTS = {
    SHOW: 'toast:show',
    SHOWN: 'toast:shown',
    HIDE: 'toast:hide',
    HIDDEN: 'toast:hidden',
    CLICK: 'toast:click',
  };

  // Icon map for contextual types
  static ICONS = {
    primary: 'star',
    secondary: 'info',
    success: 'check_circle',
    danger: 'error',
    error: 'error',
    warning: 'warning',
    info: 'info',
    light: 'lightbulb',
    dark: 'info',
  };

  // Container cache by position
  static _containers = {};

  // Track all active toasts
  static _activeToasts = [];

  /**
   * Initialize the toast
   * @private
   */
  _init() {
    // State
    this._isShown = false;
    this._isHiding = false;
    this._isPaused = false;
    this._autohideTimer = null;
    this._remainingTime = this.options.delay;
    this._startTime = null;
    this._progressBar = null;
    this._progressAnimation = null;

    // Bind events
    this._bindEvents();
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Close button
    this.delegate('click', '.so-toast-close, [data-dismiss="toast"]', (e) => {
      e.stopPropagation();
      this.hide();
    });

    // Click on toast body
    this.on('click', (e) => {
      if (!e.target.closest('.so-toast-close')) {
        this.emit(SOToast.EVENTS.CLICK);
      }
    });

    // Pause on hover - bind directly to element
    if (this.options.pauseOnHover && this.options.autohide) {
      this._handleMouseEnter = () => this.pause();
      this._handleMouseLeave = () => this.resume();
      this.element.addEventListener('mouseenter', this._handleMouseEnter);
      this.element.addEventListener('mouseleave', this._handleMouseLeave);
    }

    // Pause on focus loss
    if (this.options.pauseOnFocusLoss && this.options.autohide) {
      this._handleWindowBlur = () => this.pause();
      this._handleWindowFocus = () => this.resume();
      window.addEventListener('blur', this._handleWindowBlur);
      window.addEventListener('focus', this._handleWindowFocus);
    }
  }

  /**
   * Start auto-hide timer
   * @private
   */
  _startAutohide() {
    if (!this.options.autohide) return;

    this._startTime = Date.now();

    this._autohideTimer = setTimeout(() => {
      this.hide();
    }, this._remainingTime);

    // Start progress bar animation
    if (this.options.showProgress && this._progressBar) {
      this._animateProgress();
    }
  }

  /**
   * Animate progress bar
   * @private
   */
  _animateProgress() {
    if (!this._progressBar) return;

    // Calculate remaining percentage
    const elapsed = this.options.delay - this._remainingTime;
    const startPercentage = elapsed / this.options.delay;

    // Reset transition first
    this._progressBar.style.transition = 'none';
    this._progressBar.style.transform = `scaleX(${1 - startPercentage})`;

    // Force reflow
    this._progressBar.offsetHeight;

    // Now set transition and animate to 0
    this._progressBar.style.transition = `transform ${this._remainingTime}ms linear`;
    this._progressBar.style.transform = 'scaleX(0)';
  }

  /**
   * Clear auto-hide timer
   * @private
   */
  _clearAutohide() {
    if (this._autohideTimer) {
      clearTimeout(this._autohideTimer);
      this._autohideTimer = null;
    }

    // Pause progress bar
    if (this._progressBar) {
      const computedStyle = getComputedStyle(this._progressBar);
      const currentTransform = computedStyle.transform;
      this._progressBar.style.transition = 'none';
      this._progressBar.style.transform = currentTransform;
    }
  }

  // ============================================
  // PUBLIC API
  // ============================================

  /**
   * Show the toast
   * @returns {this} For chaining
   */
  show() {
    if (this._isShown) return this;

    // Emit show event (can be prevented)
    if (!this.emit(SOToast.EVENTS.SHOW)) {
      return this;
    }

    this._isShown = true;

    // Add to active toasts
    SOToast._activeToasts.push(this);

    // Enforce max visible
    this._enforceMaxVisible();

    // Get or create container (with custom coords if applicable)
    const customCoords = this.options.position === 'custom'
      ? { x: this.options.x, y: this.options.y }
      : null;
    const container = SOToast._getContainer(this.options.position, customCoords);

    // Add to container
    if (this.options.newestOnTop) {
      container.prepend(this.element);
    } else {
      container.appendChild(this.element);
    }

    // Show with animation
    if (this.options.animation) {
      // Force reflow
      this.element.offsetHeight;
      this.addClass('so-show');

      this.element.addEventListener('transitionend', () => {
        this.emit(SOToast.EVENTS.SHOWN);
      }, { once: true });
    } else {
      this.addClass('so-show');
      this.emit(SOToast.EVENTS.SHOWN);
    }

    // Start auto-hide
    if (this.options.autohide) {
      this._remainingTime = this.options.delay;
      this._startAutohide();
    }

    return this;
  }

  /**
   * Hide the toast
   * @returns {this} For chaining
   */
  hide() {
    if (!this._isShown || this._isHiding) return this;

    // Emit hide event (can be prevented)
    if (!this.emit(SOToast.EVENTS.HIDE)) {
      return this;
    }

    this._isHiding = true;
    this._clearAutohide();

    // Hide with animation
    this.removeClass('so-show');
    this.addClass('so-hiding');

    const hideComplete = () => {
      // Guard against multiple calls
      if (!this.element || !this.element.parentNode) return;

      this._isShown = false;
      this._isHiding = false;

      // Remove from active toasts
      const index = SOToast._activeToasts.indexOf(this);
      if (index > -1) {
        SOToast._activeToasts.splice(index, 1);
      }

      // Remove from DOM
      this.element.remove();

      // Emit hidden event
      this.emit(SOToast.EVENTS.HIDDEN);

      // Cleanup
      this.destroy();
    };

    if (this.options.animation) {
      this.element.addEventListener('transitionend', hideComplete, { once: true });

      // Fallback timeout in case transition doesn't fire
      setTimeout(hideComplete, 350);
    } else {
      hideComplete();
    }

    return this;
  }

  /**
   * Pause auto-hide timer
   * @returns {this} For chaining
   */
  pause() {
    if (!this.options.autohide) return this;
    if (!this._autohideTimer) return this;

    // Calculate remaining time before clearing the timer
    if (this._startTime) {
      const elapsed = Date.now() - this._startTime;
      this._remainingTime = Math.max(100, this._remainingTime - elapsed);
    }

    this._clearAutohide();
    this._isPaused = true;

    return this;
  }

  /**
   * Resume auto-hide timer
   * @returns {this} For chaining
   */
  resume() {
    if (!this.options.autohide) return this;
    if (!this._isPaused) return this;
    if (!this._isShown) return this;
    if (this._isHiding) return this;

    this._isPaused = false;
    this._startAutohide();

    return this;
  }

  /**
   * Update toast content
   * @param {Object} options - New options
   * @returns {this} For chaining
   */
  update(options = {}) {
    const { title, message } = options;

    if (title !== undefined) {
      const titleEl = this.$('.so-toast-title');
      if (titleEl) titleEl.textContent = title;
    }

    if (message !== undefined) {
      const bodyEl = this.$('.so-toast-body');
      const messageEl = this.$('.so-toast-message');
      if (messageEl) {
        messageEl.textContent = message;
      } else if (bodyEl) {
        bodyEl.textContent = message;
      }
    }

    return this;
  }

  /**
   * Enforce max visible toasts
   * @private
   */
  _enforceMaxVisible() {
    const samePositionToasts = SOToast._activeToasts.filter(
      t => t.options.position === this.options.position && t !== this
    );

    while (samePositionToasts.length >= this.options.maxVisible) {
      const oldest = this.options.newestOnTop
        ? samePositionToasts.pop()
        : samePositionToasts.shift();

      if (oldest) {
        oldest.hide();
      }
    }
  }

  // ============================================
  // STATIC METHODS
  // ============================================

  /**
   * Get or create container for position
   * @param {string} position - Toast position
   * @param {Object} customCoords - Custom coordinates { x, y } for 'custom' position
   * @returns {HTMLElement} Container element
   * @private
   */
  static _getContainer(position, customCoords = null) {
    // For custom positions, create a unique key based on coordinates
    const containerKey = position === 'custom' && customCoords
      ? `custom-${customCoords.x}-${customCoords.y}`
      : position;

    if (!SOToast._containers[containerKey]) {
      const container = document.createElement('div');
      container.className = `so-toast-container ${position}`;
      container.setAttribute('aria-live', 'polite');
      container.setAttribute('aria-atomic', 'true');

      // Apply custom coordinates if position is 'custom'
      if (position === 'custom' && customCoords) {
        const { x, y } = customCoords;
        if (x !== null) {
          container.style.left = typeof x === 'number' ? `${x}px` : x;
        }
        if (y !== null) {
          container.style.top = typeof y === 'number' ? `${y}px` : y;
        }
      }

      document.body.appendChild(container);
      SOToast._containers[containerKey] = container;
    }
    return SOToast._containers[containerKey];
  }

  /**
   * Create and show a toast
   * @param {Object} options - Toast options
   * @returns {SOToast} Toast instance
   */
  static show(options = {}) {
    const {
      type = 'info',
      title = '',
      message = '',
      icon = null,
      position = 'top-right',
      autohide = true,
      delay = 5000,
      showProgress = true,
      pauseOnHover = true,
      closeButton = true,
      simple = false,
      actions = null,
      className = '',
      onClick = null,
      x = null,
      y = null,
    } = options;

    // Determine icon
    const toastIcon = icon || SOToast.ICONS[type] || 'info';

    // Build class list
    const classes = [
      'so-toast',
      `so-toast-${type}`,
      className,
    ].filter(Boolean).join(' ');

    // Create element
    const toast = document.createElement('div');
    toast.className = classes;
    toast.setAttribute('role', 'status');
    toast.setAttribute('aria-live', 'polite');
    toast.setAttribute('aria-atomic', 'true');

    // Build HTML based on style
    let html = '';

    if (simple) {
      // Simple toast (compact, no header)
      html = `
        <div class="so-toast-simple">
          <span class="so-toast-icon">
            <span class="material-icons">${toastIcon}</span>
          </span>
          <div class="so-toast-content">
            ${title ? `<div class="so-toast-title">${title}</div>` : ''}
            <div class="so-toast-message">${message}</div>
          </div>
          ${closeButton ? `
            <button type="button" class="so-toast-close" data-dismiss="toast" aria-label="Close">
              <span class="material-icons">close</span>
            </button>
          ` : ''}
        </div>
      `;
    } else {
      // Standard toast with header
      html = `
        <div class="so-toast-header">
          <span class="so-toast-icon">
            <span class="material-icons">${toastIcon}</span>
          </span>
          <strong class="so-toast-title">${title || type.charAt(0).toUpperCase() + type.slice(1)}</strong>
          <small class="so-toast-time">just now</small>
          ${closeButton ? `
            <button type="button" class="so-toast-close" data-dismiss="toast" aria-label="Close">
              <span class="material-icons">close</span>
            </button>
          ` : ''}
        </div>
        <div class="so-toast-body">
          ${message}
          ${actions ? `
            <div class="so-toast-actions">
              ${actions}
            </div>
          ` : ''}
        </div>
      `;
    }

    // Add progress bar if enabled
    if (autohide && showProgress) {
      html += `
        <div class="so-toast-progress-wrapper">
          <div class="so-toast-progress">
            <div class="so-toast-progress-bar"></div>
          </div>
        </div>
      `;
    }

    toast.innerHTML = html;

    // Create instance
    const instance = new SOToast(toast, {
      position,
      autohide,
      delay,
      showProgress,
      pauseOnHover,
      closeButton,
      animation: true,
      x,
      y,
    });

    // Store progress bar reference (the inner bar that animates)
    instance._progressBar = toast.querySelector('.so-toast-progress-bar');

    // Add click handler if provided
    if (onClick) {
      toast.addEventListener(SixOrbit.evt(SOToast.EVENTS.CLICK), onClick);
    }

    // Show the toast
    instance.show();

    return instance;
  }

  /**
   * Quick success toast
   * @param {string} message - Toast message
   * @param {Object} options - Additional options
   * @returns {SOToast} Toast instance
   */
  static success(message, options = {}) {
    return SOToast.show({
      type: 'success',
      title: 'Success',
      message,
      simple: true,
      ...options,
    });
  }

  /**
   * Quick error toast
   * @param {string} message - Toast message
   * @param {Object} options - Additional options
   * @returns {SOToast} Toast instance
   */
  static error(message, options = {}) {
    return SOToast.show({
      type: 'danger',
      title: 'Error',
      message,
      simple: true,
      delay: 8000, // Longer delay for errors
      ...options,
    });
  }

  /**
   * Quick warning toast
   * @param {string} message - Toast message
   * @param {Object} options - Additional options
   * @returns {SOToast} Toast instance
   */
  static warning(message, options = {}) {
    return SOToast.show({
      type: 'warning',
      title: 'Warning',
      message,
      simple: true,
      ...options,
    });
  }

  /**
   * Quick info toast
   * @param {string} message - Toast message
   * @param {Object} options - Additional options
   * @returns {SOToast} Toast instance
   */
  static info(message, options = {}) {
    return SOToast.show({
      type: 'info',
      title: 'Info',
      message,
      simple: true,
      ...options,
    });
  }

  /**
   * Clear all toasts
   * @param {string} [position] - Optional position to clear
   */
  static clear(position = null) {
    const toastsToClear = position
      ? SOToast._activeToasts.filter(t => t.options.position === position)
      : [...SOToast._activeToasts];

    toastsToClear.forEach(toast => toast.hide());
  }

  /**
   * Clear toasts by type
   * @param {string} type - Toast type (success, error, warning, info)
   */
  static clearByType(type) {
    const toastsToClear = SOToast._activeToasts.filter(
      t => t.element.classList.contains(`so-toast-${type}`)
    );
    toastsToClear.forEach(toast => toast.hide());
  }

  /**
   * Get count of active toasts
   * @param {string} [position] - Optional position filter
   * @returns {number} Count of active toasts
   */
  static getCount(position = null) {
    if (position) {
      return SOToast._activeToasts.filter(t => t.options.position === position).length;
    }
    return SOToast._activeToasts.length;
  }
}

// Register component
SOToast.register();

// Expose to global scope
window.SOToast = SOToast;

// Export for ES modules
export default SOToast;
export { SOToast };
