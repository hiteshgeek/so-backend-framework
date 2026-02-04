// ============================================
// SIXORBIT UI - TOOLTIP COMPONENT
// JavaScript-controlled tooltips with shortcuts
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOTooltip - Dynamic tooltip component with keyboard shortcut support
 * Features: positions, colors, sizes, themes, animations, shortcuts, events
 */
class SOTooltip extends SOComponent {
  static NAME = 'tooltip';

  static DEFAULTS = {
    content: '',
    shortcut: '',
    position: 'top',        // top, bottom, left, right
    color: '',              // primary, success, danger, warning, info
    size: '',               // sm, lg (empty = default)
    theme: '',              // light (empty = dark default)
    html: false,
    animation: 'scale',     // fade, scale, slide
    trigger: 'hover',       // hover, click, focus, manual
    delay: { show: 0, hide: 0 },
    autoHide: 0,            // Auto-hide after X ms (0 = disabled)
    offset: 8,
    container: null,        // Append to specific container (default: body)
    arrow: true,
  };

  static EVENTS = {
    SHOW: 'tooltip:show',
    SHOWN: 'tooltip:shown',
    HIDE: 'tooltip:hide',
    HIDDEN: 'tooltip:hidden',
    INSERT: 'tooltip:insert',
    UPDATE: 'tooltip:update',
    POSITION: 'tooltip:position',
  };

  // Platform detection for keyboard shortcuts
  static isMac = typeof navigator !== 'undefined' &&
    /Mac|iPod|iPhone|iPad/.test(navigator.platform);

  // Key mappings for different platforms
  static KEY_MAPS = {
    mac: {
      'ctrl': '⌃',
      'cmd': '⌘',
      'command': '⌘',
      'alt': '⌥',
      'option': '⌥',
      'shift': '⇧',
      'enter': '↵',
      'return': '↵',
      'backspace': '⌫',
      'delete': '⌦',
      'del': '⌦',
      'tab': '⇥',
      'escape': 'Esc',
      'esc': 'Esc',
      'up': '↑',
      'down': '↓',
      'left': '←',
      'right': '→',
      'space': '␣',
    },
    other: {
      'ctrl': 'Ctrl',
      'cmd': 'Ctrl',
      'command': 'Ctrl',
      'alt': 'Alt',
      'option': 'Alt',
      'shift': 'Shift',
      'enter': 'Enter',
      'return': 'Enter',
      'backspace': 'Backspace',
      'delete': 'Del',
      'del': 'Del',
      'tab': 'Tab',
      'escape': 'Esc',
      'esc': 'Esc',
      'up': '↑',
      'down': '↓',
      'left': '←',
      'right': '→',
      'space': 'Space',
    },
  };

  /**
   * Initialize the tooltip
   * @private
   */
  _init() {
    // State
    this._isVisible = false;
    this._tooltipEl = null;
    this._showTimeout = null;
    this._hideTimeout = null;
    this._autoHideTimeout = null;
    this._disabled = false;

    // Read data attributes
    this._readDataAttributes();

    // Generate unique ID for aria-describedby
    this._tooltipId = SixOrbit.uniqueId('tooltip');

    // Bind events
    this._bindEvents();
  }

  /**
   * Read options from data attributes
   * @private
   */
  _readDataAttributes() {
    const el = this.element;

    // Content from data-so-tooltip
    if (el.hasAttribute('data-so-tooltip')) {
      this.options.content = el.getAttribute('data-so-tooltip');
    }

    // Shortcut from data-so-shortcut
    if (el.hasAttribute('data-so-shortcut')) {
      this.options.shortcut = el.getAttribute('data-so-shortcut');
    }

    // Position from data-so-tooltip-position
    if (el.hasAttribute('data-so-tooltip-position')) {
      this.options.position = el.getAttribute('data-so-tooltip-position');
    }

    // Color from data-so-tooltip-color
    if (el.hasAttribute('data-so-tooltip-color')) {
      this.options.color = el.getAttribute('data-so-tooltip-color');
    }

    // Size from data-so-tooltip-size
    if (el.hasAttribute('data-so-tooltip-size')) {
      this.options.size = el.getAttribute('data-so-tooltip-size');
    }

    // Theme from data-so-tooltip-theme
    if (el.hasAttribute('data-so-tooltip-theme')) {
      this.options.theme = el.getAttribute('data-so-tooltip-theme');
    }

    // HTML from data-so-tooltip-html
    if (el.hasAttribute('data-so-tooltip-html')) {
      this.options.html = el.getAttribute('data-so-tooltip-html') === 'true';
    }

    // Animation from data-so-tooltip-animation
    if (el.hasAttribute('data-so-tooltip-animation')) {
      this.options.animation = el.getAttribute('data-so-tooltip-animation');
    }

    // Trigger from data-so-tooltip-trigger
    if (el.hasAttribute('data-so-tooltip-trigger')) {
      this.options.trigger = el.getAttribute('data-so-tooltip-trigger');
    }

    // Delay from data-so-tooltip-delay
    if (el.hasAttribute('data-so-tooltip-delay')) {
      const delay = parseInt(el.getAttribute('data-so-tooltip-delay'), 10);
      this.options.delay = { show: delay, hide: delay };
    }
  }

  /**
   * Bind event listeners based on trigger type
   * @private
   */
  _bindEvents() {
    const trigger = this.options.trigger;

    if (trigger === 'hover' || trigger === 'hover focus') {
      this.on('mouseenter', this._handleMouseEnter, this.element);
      this.on('mouseleave', this._handleMouseLeave, this.element);
    }

    if (trigger === 'focus' || trigger === 'hover focus') {
      this.on('focus', this._handleFocus, this.element);
      this.on('blur', this._handleBlur, this.element);
    }

    if (trigger === 'click') {
      this.on('click', this._handleClick, this.element);
    }

    // Always listen for escape key
    this.on('keydown', this._handleKeydown, document);
  }

  /**
   * Handle mouse enter
   * @private
   */
  _handleMouseEnter() {
    this._clearTimeouts();
    this._showTimeout = setTimeout(() => {
      this.show('hover');
    }, this.options.delay.show);
  }

  /**
   * Handle mouse leave
   * @private
   */
  _handleMouseLeave() {
    this._clearTimeouts();
    this._hideTimeout = setTimeout(() => {
      this.hide('hover');
    }, this.options.delay.hide);
  }

  /**
   * Handle focus
   * @private
   */
  _handleFocus() {
    this._clearTimeouts();
    this._showTimeout = setTimeout(() => {
      this.show('focus');
    }, this.options.delay.show);
  }

  /**
   * Handle blur
   * @private
   */
  _handleBlur() {
    this._clearTimeouts();
    this._hideTimeout = setTimeout(() => {
      this.hide('focus');
    }, this.options.delay.hide);
  }

  /**
   * Handle click
   * @private
   */
  _handleClick(e) {
    e.stopPropagation();
    if (this._isVisible) {
      this.hide('click');
    } else {
      this.show('click');
    }
  }

  /**
   * Handle keydown (escape to close)
   * @param {KeyboardEvent} e
   * @private
   */
  _handleKeydown(e) {
    if (e.key === 'Escape' && this._isVisible) {
      this.hide('escape');
    }
  }

  /**
   * Clear all timeouts
   * @private
   */
  _clearTimeouts() {
    if (this._showTimeout) {
      clearTimeout(this._showTimeout);
      this._showTimeout = null;
    }
    if (this._hideTimeout) {
      clearTimeout(this._hideTimeout);
      this._hideTimeout = null;
    }
    if (this._autoHideTimeout) {
      clearTimeout(this._autoHideTimeout);
      this._autoHideTimeout = null;
    }
  }

  /**
   * Create tooltip element
   * @returns {HTMLElement}
   * @private
   */
  _createTooltip() {
    const tooltip = document.createElement('div');
    tooltip.id = this._tooltipId;
    tooltip.className = this._getTooltipClasses();
    tooltip.setAttribute('role', 'tooltip');
    tooltip.innerHTML = this._getTooltipContent();

    return tooltip;
  }

  /**
   * Get tooltip CSS classes
   * @returns {string}
   * @private
   */
  _getTooltipClasses() {
    const classes = ['so-tooltip-popup'];

    // Position
    classes.push(`so-tooltip-${this.options.position}`);

    // Color
    if (this.options.color) {
      classes.push(`so-tooltip-${this.options.color}`);
    }

    // Size
    if (this.options.size) {
      classes.push(`so-tooltip-${this.options.size}`);
    }

    // Theme
    if (this.options.theme === 'light') {
      classes.push('so-tooltip-light');
    }

    // Animation
    classes.push(`so-tooltip-animate-${this.options.animation}`);

    // Arrow
    if (this.options.arrow) {
      classes.push('so-tooltip-arrow');
    }

    return classes.join(' ');
  }

  /**
   * Get tooltip inner content HTML
   * @returns {string}
   * @private
   */
  _getTooltipContent() {
    const content = this.options.content;
    const shortcut = this.options.shortcut;
    const hasContent = content && content.trim();
    const hasShortcut = shortcut && shortcut.trim();

    let html = '<div class="so-tooltip-inner">';

    // Content
    if (hasContent) {
      if (this.options.html) {
        html += `<span class="so-tooltip-text">${content}</span>`;
      } else {
        html += `<span class="so-tooltip-text">${this._escapeHtml(content)}</span>`;
      }
    }

    // Divider between content and shortcut
    if (hasContent && hasShortcut) {
      html += '<span class="so-tooltip-divider"></span>';
    }

    // Shortcut
    if (hasShortcut) {
      html += this._renderShortcut(shortcut);
    }

    html += '</div>';

    return html;
  }

  /**
   * Render keyboard shortcut as kbd elements
   * @param {string} shortcut - Shortcut string (e.g., "Ctrl+C", "Cmd+Shift+P")
   * @returns {string} HTML string
   * @private
   */
  _renderShortcut(shortcut) {
    const keyMap = SOTooltip.isMac ? SOTooltip.KEY_MAPS.mac : SOTooltip.KEY_MAPS.other;

    // Split by + and render each key
    const keys = shortcut.split('+').map(key => {
      const normalizedKey = key.trim().toLowerCase();
      const displayKey = keyMap[normalizedKey] || key.trim();
      return `<kbd>${this._escapeHtml(displayKey)}</kbd>`;
    });

    return `<span class="so-tooltip-shortcut">${keys.join('')}</span>`;
  }

  /**
   * Escape HTML to prevent XSS
   * @param {string} str
   * @returns {string}
   * @private
   */
  _escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  /**
   * Position the tooltip relative to trigger element
   * @private
   */
  _positionTooltip() {
    if (!this._tooltipEl) return;

    const triggerRect = this.element.getBoundingClientRect();
    const tooltipRect = this._tooltipEl.getBoundingClientRect();
    const offset = this.options.offset;
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

    let top, left;
    const position = this.options.position;

    switch (position) {
      case 'top':
        top = triggerRect.top + scrollTop - tooltipRect.height - offset;
        left = triggerRect.left + scrollLeft + (triggerRect.width - tooltipRect.width) / 2;
        break;

      case 'bottom':
        top = triggerRect.bottom + scrollTop + offset;
        left = triggerRect.left + scrollLeft + (triggerRect.width - tooltipRect.width) / 2;
        break;

      case 'left':
        top = triggerRect.top + scrollTop + (triggerRect.height - tooltipRect.height) / 2;
        left = triggerRect.left + scrollLeft - tooltipRect.width - offset;
        break;

      case 'right':
        top = triggerRect.top + scrollTop + (triggerRect.height - tooltipRect.height) / 2;
        left = triggerRect.right + scrollLeft + offset;
        break;
    }

    // Ensure tooltip stays within viewport
    const viewportWidth = window.innerWidth;
    const viewportHeight = window.innerHeight;

    // Horizontal bounds
    if (left < 5) {
      left = 5;
    } else if (left + tooltipRect.width > viewportWidth - 5) {
      left = viewportWidth - tooltipRect.width - 5;
    }

    // Vertical bounds
    if (top < 5) {
      top = 5;
    } else if (top + tooltipRect.height > scrollTop + viewportHeight - 5) {
      top = scrollTop + viewportHeight - tooltipRect.height - 5;
    }

    this._tooltipEl.style.top = `${top}px`;
    this._tooltipEl.style.left = `${left}px`;

    // Emit position event
    this.emit(SOTooltip.EVENTS.POSITION, {
      position,
      coords: { top, left },
    }, true, false);
  }

  // ============================================
  // PUBLIC API
  // ============================================

  /**
   * Show the tooltip
   * @param {string} [trigger='manual'] - What triggered the show
   * @returns {this}
   */
  show(trigger = 'manual') {
    if (this._disabled || this._isVisible) return this;

    // Check if content exists
    if (!this.options.content && !this.options.shortcut) return this;

    // Emit show event (cancelable)
    const showAllowed = this.emit(SOTooltip.EVENTS.SHOW, { trigger }, true, true);
    if (!showAllowed) return this;

    this._isVisible = true;

    // Create and insert tooltip
    this._tooltipEl = this._createTooltip();

    const container = this.options.container
      ? document.querySelector(this.options.container)
      : document.body;

    container.appendChild(this._tooltipEl);

    // Emit insert event
    this.emit(SOTooltip.EVENTS.INSERT, {
      tooltipEl: this._tooltipEl,
    }, true, false);

    // Set aria-describedby on trigger
    this.element.setAttribute('aria-describedby', this._tooltipId);

    // Position tooltip accurately without animation shift:
    // 1. Force scale(1) immediately (no transition) to get accurate dimensions
    // 2. Position the tooltip
    // 3. Then enable animation for opacity
    requestAnimationFrame(() => {
      if (this._tooltipEl) {
        // Temporarily disable transition and force full scale for accurate measurement
        this._tooltipEl.style.transform = 'scale(1)';
        this._tooltipEl.style.transition = 'none';

        // Force reflow to apply styles immediately
        this._tooltipEl.offsetHeight;

        // Position with correct full-scale dimensions
        this._positionTooltip();

        // Re-enable CSS control and add show class
        // Since we're already at scale(1), adding so-show won't cause visual shift
        requestAnimationFrame(() => {
          if (this._tooltipEl) {
            this._tooltipEl.style.transform = '';
            this._tooltipEl.style.transition = '';
            this._tooltipEl.classList.add('so-show');
          }
        });
      }
    });

    // Emit shown event after transition
    setTimeout(() => {
      this.emit(SOTooltip.EVENTS.SHOWN, {
        trigger,
        tooltipEl: this._tooltipEl,
      }, true, false);
    }, 150);

    // Auto-hide if configured
    if (this.options.autoHide > 0) {
      this._autoHideTimeout = setTimeout(() => {
        this.hide('auto');
      }, this.options.autoHide);
    }

    return this;
  }

  /**
   * Hide the tooltip
   * @param {string} [trigger='manual'] - What triggered the hide
   * @returns {this}
   */
  hide(trigger = 'manual') {
    if (!this._isVisible) return this;

    // Emit hide event (cancelable)
    const hideAllowed = this.emit(SOTooltip.EVENTS.HIDE, { trigger }, true, true);
    if (!hideAllowed) return this;

    this._clearTimeouts();
    this._isVisible = false;

    // Remove aria-describedby
    this.element.removeAttribute('aria-describedby');

    // Hide with animation
    if (this._tooltipEl) {
      this._tooltipEl.classList.remove('so-show');

      // Remove after transition
      setTimeout(() => {
        if (this._tooltipEl) {
          this._tooltipEl.remove();
          this._tooltipEl = null;
        }

        // Emit hidden event
        this.emit(SOTooltip.EVENTS.HIDDEN, { trigger }, true, false);
      }, 150);
    }

    return this;
  }

  /**
   * Toggle tooltip visibility
   * @returns {this}
   */
  toggle() {
    return this._isVisible ? this.hide() : this.show();
  }

  /**
   * Update tooltip content
   * @param {string} content - New content
   * @returns {this}
   */
  setContent(content) {
    this.options.content = content;

    if (this._tooltipEl) {
      const inner = this._tooltipEl.querySelector('.so-tooltip-inner');
      if (inner) {
        inner.innerHTML = '';
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = this._getTooltipContent();
        inner.innerHTML = tempDiv.firstChild.innerHTML;
        this._positionTooltip();
      }
    }

    this.emit(SOTooltip.EVENTS.UPDATE, {
      content: this.options.content,
      shortcut: this.options.shortcut,
    }, true, false);

    return this;
  }

  /**
   * Update tooltip shortcut
   * @param {string} shortcut - New shortcut
   * @returns {this}
   */
  setShortcut(shortcut) {
    this.options.shortcut = shortcut;

    if (this._tooltipEl) {
      const inner = this._tooltipEl.querySelector('.so-tooltip-inner');
      if (inner) {
        inner.innerHTML = '';
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = this._getTooltipContent();
        inner.innerHTML = tempDiv.firstChild.innerHTML;
        this._positionTooltip();
      }
    }

    this.emit(SOTooltip.EVENTS.UPDATE, {
      content: this.options.content,
      shortcut: this.options.shortcut,
    }, true, false);

    return this;
  }

  /**
   * Update tooltip color
   * @param {string} color - New color (primary, success, danger, warning, info, '')
   * @returns {this}
   */
  setColor(color) {
    this.options.color = color;

    if (this._tooltipEl) {
      // Remove existing color classes
      this._tooltipEl.className = this._getTooltipClasses();
      if (this._isVisible) {
        this._tooltipEl.classList.add('so-show');
      }
    }

    return this;
  }

  /**
   * Update tooltip position
   * @param {string} position - New position (top, bottom, left, right)
   * @returns {this}
   */
  setPosition(position) {
    this.options.position = position;

    if (this._tooltipEl) {
      this._tooltipEl.className = this._getTooltipClasses();
      if (this._isVisible) {
        this._tooltipEl.classList.add('so-show');
      }
      this._positionTooltip();
    }

    return this;
  }

  /**
   * Recalculate tooltip position
   * @returns {this}
   */
  updatePosition() {
    this._positionTooltip();
    return this;
  }

  /**
   * Check if tooltip is visible
   * @returns {boolean}
   */
  isVisible() {
    return this._isVisible;
  }

  /**
   * Enable the tooltip
   * @returns {this}
   */
  enable() {
    this._disabled = false;
    return this;
  }

  /**
   * Disable the tooltip
   * @returns {this}
   */
  disable() {
    this._disabled = true;
    if (this._isVisible) {
      this.hide('disable');
    }
    return this;
  }

  /**
   * Destroy the tooltip instance
   */
  destroy() {
    this._clearTimeouts();

    if (this._tooltipEl) {
      this._tooltipEl.remove();
      this._tooltipEl = null;
    }

    this.element.removeAttribute('aria-describedby');

    super.destroy();
  }

  // ============================================
  // STATIC METHODS
  // ============================================

  /**
   * Initialize all tooltips matching selector
   * @param {string} [selector='[data-so-tooltip], [data-so-shortcut]'] - CSS selector
   * @returns {SOTooltip[]}
   */
  static initAll(selector = '[data-so-tooltip], [data-so-shortcut]') {
    const elements = document.querySelectorAll(selector);
    return Array.from(elements).map(el => SOTooltip.getInstance(el));
  }

  /**
   * Hide all visible tooltips
   */
  static hideAll() {
    document.querySelectorAll('.so-tooltip-popup.show').forEach(tooltip => {
      tooltip.classList.remove('so-show');
      setTimeout(() => tooltip.remove(), 150);
    });
  }

  /**
   * Show a temporary tooltip on an element (useful for feedback like "Copied!")
   * @param {Element|string} element - Target element
   * @param {Object} options - Tooltip options
   * @returns {SOTooltip}
   */
  static showTemporary(element, options = {}) {
    const el = typeof element === 'string' ? document.querySelector(element) : element;
    if (!el) return null;

    // Get or create instance with temporary options
    const instance = SOTooltip.getInstance(el, {
      ...options,
      trigger: 'manual',
      autoHide: options.autoHide || 2000,
    });

    // Update content if provided
    if (options.content) {
      instance.setContent(options.content);
    }

    if (options.shortcut) {
      instance.setShortcut(options.shortcut);
    }

    if (options.color) {
      instance.setColor(options.color);
    }

    if (options.position) {
      instance.setPosition(options.position);
    }

    // Show the tooltip
    instance.show('temporary');

    return instance;
  }
}

// Register component
SOTooltip.register();

// Expose to global scope
window.SOTooltip = SOTooltip;

// Export for ES modules
export default SOTooltip;
export { SOTooltip };
