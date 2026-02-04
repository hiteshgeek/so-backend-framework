// ============================================
// SIXORBIT UI - DRAWER/OFFCANVAS COMPONENT
// Side panel component with slide animations
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SODrawer - Slide-out drawer/offcanvas component
 * Supports left/right positioning, sizes, and static mode
 */
class SODrawer extends SOComponent {
  static NAME = 'drawer';

  static DEFAULTS = {
    backdrop: true,      // Show backdrop behind drawer
    keyboard: true,      // Close on Escape key
    scroll: false,       // Allow body scroll when drawer is open
    static: false,       // Non-dismissible mode (must use buttons to close)
    animation: true,     // Animate open/close
  };

  static EVENTS = {
    SHOW: 'drawer:show',
    SHOWN: 'drawer:shown',
    HIDE: 'drawer:hide',
    HIDDEN: 'drawer:hidden',
  };

  // Track open drawers for stacking
  static _openDrawers = [];

  /**
   * Initialize the drawer
   * @private
   */
  _init() {
    // Cache elements
    this._header = this.$('.so-drawer-header');
    this._body = this.$('.so-drawer-body');
    this._footer = this.$('.so-drawer-footer');
    this._backdrop = null;

    // State
    this._isOpen = false;
    this._focusTrapCleanup = null;
    this._previousActiveElement = null;

    // Detect position from class
    this._isLeft = this.element.classList.contains('so-drawer-left');

    // Check for static mode from data attribute, class, or options
    if (this.element.hasAttribute('data-so-static') ||
        this.element.classList.contains('so-drawer-static') ||
        this.options.static === true) {
      this.options.static = true;
      this.options.keyboard = false;
      this.element.classList.add('so-drawer-static');
    }

    // Bind events
    this._bindEvents();
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Close button (only if not static)
    this.delegate('click', '.so-drawer-close, [data-dismiss="drawer"]', () => {
      if (!this.options.static) {
        this.hide();
      }
    });

    // Note: Backdrop click and keyboard events are bound in show() and unbound in hide()
  }

  /**
   * Shake the drawer to indicate it cannot be dismissed
   * @private
   */
  _shakeDrawer() {
    this.element.classList.add('drawer-static-shake');
    setTimeout(() => {
      this.element.classList.remove('drawer-static-shake');
    }, 300);
  }

  /**
   * Handle keyboard events
   * @param {KeyboardEvent} e - Keyboard event
   * @private
   */
  _handleKeydown(e) {
    // Only handle if this is the topmost drawer
    if (e.key === 'Escape' && this._isOpen) {
      const openDrawers = SODrawer._openDrawers;
      if (openDrawers.length > 0 && openDrawers[openDrawers.length - 1] === this) {
        e.preventDefault();
        e.stopPropagation();
        if (this.options.static) {
          this._shakeDrawer();
        } else {
          this.hide();
        }
      }
    }
  }

  /**
   * Bind document keyboard listener
   * @private
   */
  _bindDocumentKeydown() {
    if (!this.options.keyboard) return;
    this._boundKeydown = this._handleKeydown.bind(this);
    document.addEventListener('keydown', this._boundKeydown);
  }

  /**
   * Unbind document keyboard listener
   * @private
   */
  _unbindDocumentKeydown() {
    if (this._boundKeydown) {
      document.removeEventListener('keydown', this._boundKeydown);
      this._boundKeydown = null;
    }
  }

  /**
   * Handle backdrop click
   * @param {Event} e - Click event
   * @private
   */
  _handleBackdropClick(e) {
    if (e.target === this._backdrop) {
      if (this.options.static) {
        this._shakeDrawer();
      } else {
        this.hide();
      }
    }
  }

  /**
   * Create and show backdrop
   * @private
   */
  _showBackdrop() {
    if (!this.options.backdrop) return;

    this._backdrop = document.createElement('div');
    this._backdrop.className = 'so-modal-backdrop';

    if (this.options.animation) {
      this._backdrop.classList.add('so-fade');
    }

    // Bind backdrop click
    this._boundBackdropClick = this._handleBackdropClick.bind(this);
    this._backdrop.addEventListener('click', this._boundBackdropClick);

    document.body.appendChild(this._backdrop);

    // Force reflow for animation
    this._backdrop.offsetHeight;
    this._backdrop.classList.add('so-show');
  }

  /**
   * Hide and remove backdrop
   * @private
   */
  _hideBackdrop() {
    if (!this._backdrop) return;

    // Unbind backdrop click
    if (this._boundBackdropClick) {
      this._backdrop.removeEventListener('click', this._boundBackdropClick);
      this._boundBackdropClick = null;
    }

    this._backdrop.classList.remove('so-show');

    if (this.options.animation) {
      this._backdrop.addEventListener('transitionend', () => {
        this._backdrop?.remove();
        this._backdrop = null;
      }, { once: true });
    } else {
      this._backdrop.remove();
      this._backdrop = null;
    }
  }

  /**
   * Manage body scroll lock
   * @param {boolean} lock - Whether to lock scroll
   * @private
   */
  _manageBodyScroll(lock) {
    if (this.options.scroll) return; // Allow scroll if option is set

    if (lock) {
      document.body.classList.add('so-drawer-open');
      document.body.style.overflow = 'hidden';
    } else if (SODrawer._openDrawers.length === 0) {
      document.body.classList.remove('so-drawer-open');
      document.body.style.overflow = '';
    }
  }

  // ============================================
  // PUBLIC API
  // ============================================

  /**
   * Show the drawer
   * @returns {this} For chaining
   */
  show() {
    if (this._isOpen) return this;

    // Emit show event (can be prevented)
    if (!this.emit(SODrawer.EVENTS.SHOW)) {
      return this;
    }

    this._isOpen = true;
    this._previousActiveElement = document.activeElement;

    // Add to open drawers stack
    SODrawer._openDrawers.push(this);

    // Show backdrop
    this._showBackdrop();

    // Lock body scroll
    this._manageBodyScroll(true);

    // Force reflow
    this.element.offsetHeight;

    // Show drawer
    this.addClass('so-show');

    // Set up focus trap
    this._focusTrapCleanup = this.trapFocus();

    // Bind document keyboard listener for Escape
    this._bindDocumentKeydown();

    // Emit shown event after transition
    if (this.options.animation) {
      this.element.addEventListener('transitionend', () => {
        this.emit(SODrawer.EVENTS.SHOWN);
      }, { once: true });
    } else {
      this.emit(SODrawer.EVENTS.SHOWN);
    }

    return this;
  }

  /**
   * Hide the drawer
   * @returns {this} For chaining
   */
  hide() {
    if (!this._isOpen) return this;

    // Emit hide event (can be prevented)
    if (!this.emit(SODrawer.EVENTS.HIDE)) {
      return this;
    }

    this._isOpen = false;

    // Remove from open drawers stack
    const index = SODrawer._openDrawers.indexOf(this);
    if (index > -1) {
      SODrawer._openDrawers.splice(index, 1);
    }

    // Remove focus trap
    if (this._focusTrapCleanup) {
      this._focusTrapCleanup();
      this._focusTrapCleanup = null;
    }

    // Unbind document keyboard listener
    this._unbindDocumentKeydown();

    // Hide drawer
    this.removeClass('so-show');

    const hideComplete = () => {
      this._hideBackdrop();
      this._manageBodyScroll(false);

      // Restore focus
      if (this._previousActiveElement && typeof this._previousActiveElement.focus === 'function') {
        this._previousActiveElement.focus();
      }

      this.emit(SODrawer.EVENTS.HIDDEN);
    };

    if (this.options.animation) {
      let completed = false;
      const safeHideComplete = () => {
        if (completed) return;
        completed = true;
        hideComplete();
      };

      this.element.addEventListener('transitionend', safeHideComplete, { once: true });
      // Fallback timeout in case transitionend doesn't fire
      setTimeout(safeHideComplete, 350);
    } else {
      hideComplete();
    }

    return this;
  }

  /**
   * Toggle drawer visibility
   * @returns {this} For chaining
   */
  toggle() {
    return this._isOpen ? this.hide() : this.show();
  }

  /**
   * Check if drawer is open
   * @returns {boolean} Open state
   */
  isOpen() {
    return this._isOpen;
  }

  /**
   * Set drawer body content
   * @param {string|Element} content - Content to set
   * @returns {this} For chaining
   */
  setContent(content) {
    if (!this._body) return this;

    if (typeof content === 'string') {
      this._body.innerHTML = content;
    } else if (content instanceof Element) {
      this._body.innerHTML = '';
      this._body.appendChild(content);
    }

    return this;
  }

  /**
   * Set drawer title
   * @param {string} title - Title text
   * @returns {this} For chaining
   */
  setTitle(title) {
    const titleEl = this.$('.so-drawer-title');
    if (titleEl) {
      titleEl.textContent = title;
    }
    return this;
  }

  // ============================================
  // STATIC METHODS
  // ============================================

  /**
   * Create and show a drawer programmatically
   * @param {Object} options - Drawer configuration
   * @returns {SODrawer} Drawer instance
   */
  static create(options = {}) {
    const {
      title = '',
      content = '',
      position = 'right',  // 'left' or 'right'
      size = 'default',    // 'sm', 'default', 'lg', 'xl'
      closable = true,
      footer = null,
      className = '',
      static: isStatic = false,
    } = options;

    // Build class list
    const positionClass = position === 'left' ? 'so-drawer-left' : '';
    const sizeClass = size !== 'default' ? `so-drawer-${size}` : '';
    const staticClass = isStatic ? 'so-drawer-static' : '';

    const drawer = document.createElement('div');
    drawer.className = `so-drawer ${positionClass} ${sizeClass} ${staticClass} ${className}`.trim().replace(/\s+/g, ' ');
    drawer.tabIndex = -1;

    if (isStatic) {
      drawer.setAttribute('data-so-static', 'true');
    }

    let footerHtml = '';
    if (footer) {
      footerHtml = `
        <div class="so-drawer-footer">
          ${footer}
        </div>
      `;
    }

    const showCloseButton = closable && !isStatic;

    drawer.innerHTML = `
      <div class="so-drawer-header">
        <h5 class="so-drawer-title">${title}</h5>
        ${showCloseButton ? '<button type="button" class="so-drawer-close" data-dismiss="drawer"><span class="material-icons">close</span></button>' : ''}
      </div>
      <div class="so-drawer-body">
        ${content}
      </div>
      ${footerHtml}
    `;

    document.body.appendChild(drawer);

    const instance = new SODrawer(drawer, { ...options, animation: true, static: isStatic });

    // Store the instance on the element
    drawer._soDrawerInstance = instance;

    // Remove from DOM when hidden
    drawer.addEventListener(SixOrbit.evt(SODrawer.EVENTS.HIDDEN), () => {
      drawer.remove();
    });

    return instance;
  }

  /**
   * Get drawer instance from element
   * @param {Element|string} element - DOM element or selector
   * @param {Object} [options={}] - Component options
   * @returns {SODrawer} Drawer instance
   */
  static getInstance(element, options = {}) {
    const el = typeof element === 'string' ? document.querySelector(element) : element;
    if (!el) return null;

    // Check for instance stored directly on element (from SODrawer.create())
    if (el._soDrawerInstance) {
      return el._soDrawerInstance;
    }

    // Fall back to standard SixOrbit instance lookup
    return SixOrbit.getInstance(el, this.NAME, options);
  }

  /**
   * Initialize all drawers on the page
   */
  static initAll() {
    document.querySelectorAll('.so-drawer[data-so-drawer]').forEach(el => {
      SODrawer.getInstance(el);
    });

    // Also set up trigger buttons
    document.querySelectorAll('[data-drawer-toggle]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const targetSelector = btn.getAttribute('data-drawer-toggle');
        const drawer = document.querySelector(targetSelector);
        if (drawer) {
          const instance = SODrawer.getInstance(drawer);
          instance.toggle();
        }
      });
    });
  }
}

// Register component
SODrawer.register();

// Expose to global scope
window.SODrawer = SODrawer;

// Export for ES modules
export default SODrawer;
export { SODrawer };
