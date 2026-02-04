// ============================================
// SIXORBIT UI - GO TO TOP/BOTTOM COMPONENT
// Scroll navigation button with progress indicator
// Uses existing button classes
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOGoToTop - Scroll navigation button
 * Supports both go-to-top and go-to-bottom directions
 * Shows/hides based on scroll position
 * Optional progress indicator ring
 */
class SOGoToTop extends SOComponent {
  static NAME = 'go-to-top';

  static DEFAULTS = {
    // Direction: 'top' or 'bottom'
    direction: 'top',
    // Show after scrolling this many pixels (for top direction)
    // For bottom, shows when NOT scrolled past this threshold from bottom
    showAfter: 300,
    // Position on screen: bottom-right, bottom-left, bottom-center
    position: 'bottom-right',
    // Material icon name (auto-set based on direction if not provided)
    icon: null,
    // Button size: xs, sm, md, lg
    size: 'md',
    // Button variant: primary, secondary, ghost, outline, etc.
    variant: 'primary',
    // Use smooth scroll
    smooth: true,
    // Show scroll progress indicator ring
    showProgress: false,
    // Callback when scrolled
    onScroll: null,
    // Legacy callback support
    onScrollToTop: null,
  };

  static EVENTS = {
    SHOW: 'go-to-top:show',
    HIDE: 'go-to-top:hide',
    SCROLL: 'go-to-top:scroll',
  };

  /**
   * Initialize the component
   * @private
   */
  _init() {
    this._isVisible = false;
    this._scrollTimeout = null;
    this._progressRing = null;
    this._progressCircle = null;

    // Set default icon based on direction
    if (!this.options.icon) {
      this.options.icon = this.options.direction === 'bottom' ? 'arrow_downward' : 'arrow_upward';
    }

    // Bind scroll handler
    this._boundScrollHandler = this._handleScroll.bind(this);
    window.addEventListener('scroll', this._boundScrollHandler, { passive: true });

    // Bind click handler
    this.on('click', (e) => {
      e.preventDefault();
      this.scrollTo();
    });

    // Initial visibility check
    this._updateVisibility();

    // Create progress ring if enabled
    if (this.options.showProgress) {
      this.element.classList.add('so-go-to-top-progress');
      this._createProgressRing();
      this._updateProgress();
    }
  }

  /**
   * Create SVG progress ring
   * @private
   */
  _createProgressRing() {
    // Button sizes (matching so-btn sizes)
    const buttonSizes = {
      xs: 28,
      sm: 32,
      md: 40,
      lg: 48,
    };

    // Get button size from options or detect from class
    let buttonSize = buttonSizes[this.options.size] || buttonSizes.md;

    // Check for size class if not set in options
    if (!this.options.size || this.options.size === 'md') {
      if (this.element.classList.contains('so-btn-xs')) buttonSize = buttonSizes.xs;
      else if (this.element.classList.contains('so-btn-sm')) buttonSize = buttonSizes.sm;
      else if (this.element.classList.contains('so-btn-lg')) buttonSize = buttonSizes.lg;
    }

    const size = buttonSize + 8; // Add padding for ring
    const radius = (size / 2) - 3; // Account for stroke width
    const circumference = 2 * Math.PI * radius;

    // Create SVG
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('class', 'so-progress-ring');
    svg.setAttribute('viewBox', `0 0 ${size} ${size}`);

    // Track circle (background)
    const trackCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    trackCircle.setAttribute('class', 'so-progress-ring-track');
    trackCircle.setAttribute('cx', size / 2);
    trackCircle.setAttribute('cy', size / 2);
    trackCircle.setAttribute('r', radius);

    // Progress circle
    const progressCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    progressCircle.setAttribute('class', 'so-progress-ring-progress');
    progressCircle.setAttribute('cx', size / 2);
    progressCircle.setAttribute('cy', size / 2);
    progressCircle.setAttribute('r', radius);
    progressCircle.setAttribute('stroke-dasharray', circumference);
    progressCircle.setAttribute('stroke-dashoffset', circumference);

    svg.appendChild(trackCircle);
    svg.appendChild(progressCircle);
    this.element.insertBefore(svg, this.element.firstChild);

    this._progressRing = svg;
    this._progressCircle = progressCircle;
    this._circumference = circumference;
  }

  /**
   * Handle scroll event (debounced)
   * @private
   */
  _handleScroll() {
    if (this._scrollTimeout) {
      cancelAnimationFrame(this._scrollTimeout);
    }

    this._scrollTimeout = requestAnimationFrame(() => {
      this._updateVisibility();

      if (this.options.showProgress) {
        this._updateProgress();
      }
    });
  }

  /**
   * Update button visibility based on scroll position
   * @private
   */
  _updateVisibility() {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const distanceFromBottom = docHeight - scrollTop;

    let shouldShow;

    if (this.options.direction === 'bottom') {
      // Show go-to-bottom when near top (not scrolled much)
      shouldShow = distanceFromBottom > this.options.showAfter;
    } else {
      // Show go-to-top when scrolled down
      shouldShow = scrollTop > this.options.showAfter;
    }

    if (shouldShow && !this._isVisible) {
      this._show();
    } else if (!shouldShow && this._isVisible) {
      this._hide();
    }
  }

  /**
   * Update scroll progress indicator
   * @private
   */
  _updateProgress() {
    if (!this._progressCircle || !this._circumference) return;

    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const progress = docHeight > 0 ? Math.min(100, Math.max(0, (scrollTop / docHeight) * 100)) : 0;

    // Calculate stroke-dashoffset (full circle = circumference, empty = 0)
    const offset = this._circumference - (progress / 100) * this._circumference;
    this._progressCircle.setAttribute('stroke-dashoffset', offset);
  }

  /**
   * Show the button
   * @private
   */
  _show() {
    this._isVisible = true;
    this.element.classList.add('so-show');
    this.emit(SOGoToTop.EVENTS.SHOW);
  }

  /**
   * Hide the button
   * @private
   */
  _hide() {
    this._isVisible = false;
    this.element.classList.remove('so-show');
    this.emit(SOGoToTop.EVENTS.HIDE);
  }

  /**
   * Scroll to target position
   * @returns {this}
   */
  scrollTo() {
    const behavior = this.options.smooth ? 'smooth' : 'instant';
    const target = this.options.direction === 'bottom'
      ? document.documentElement.scrollHeight
      : 0;

    window.scrollTo({
      top: target,
      behavior,
    });

    this.emit(SOGoToTop.EVENTS.SCROLL);

    // Call callbacks
    if (typeof this.options.onScroll === 'function') {
      this.options.onScroll(this);
    }
    // Legacy support
    if (typeof this.options.onScrollToTop === 'function') {
      this.options.onScrollToTop(this);
    }

    return this;
  }

  /**
   * Scroll to top of page (legacy method)
   * @returns {this}
   */
  scrollToTop() {
    const originalDirection = this.options.direction;
    this.options.direction = 'top';
    this.scrollTo();
    this.options.direction = originalDirection;
    return this;
  }

  /**
   * Scroll to bottom of page
   * @returns {this}
   */
  scrollToBottom() {
    const originalDirection = this.options.direction;
    this.options.direction = 'bottom';
    this.scrollTo();
    this.options.direction = originalDirection;
    return this;
  }

  /**
   * Manually show the button
   * @returns {this}
   */
  show() {
    this._show();
    return this;
  }

  /**
   * Manually hide the button
   * @returns {this}
   */
  hide() {
    this._hide();
    return this;
  }

  /**
   * Check if button is visible
   * @returns {boolean}
   */
  isVisible() {
    return this._isVisible;
  }

  /**
   * Get current scroll progress (0-100)
   * @returns {number}
   */
  getProgress() {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    return docHeight > 0 ? Math.min(100, Math.max(0, (scrollTop / docHeight) * 100)) : 0;
  }

  /**
   * Destroy the component
   */
  destroy() {
    window.removeEventListener('scroll', this._boundScrollHandler);

    if (this._scrollTimeout) {
      cancelAnimationFrame(this._scrollTimeout);
    }

    super.destroy();
  }

  // ============================================
  // STATIC METHODS
  // ============================================

  /**
   * Create and inject a scroll navigation button
   * @param {Object} options - Configuration options
   * @returns {SOGoToTop}
   */
  static create(options = {}) {
    const {
      direction = 'top',
      position = 'bottom-right',
      icon = null,
      size = 'md',
      variant = 'primary',
      showProgress = false,
      container = document.body,
      ...restOptions
    } = options;

    // Determine icon based on direction
    const finalIcon = icon || (direction === 'bottom' ? 'arrow_downward' : 'arrow_upward');

    // Create button element
    const button = document.createElement('button');
    button.type = 'button';
    button.setAttribute('aria-label', direction === 'bottom' ? 'Scroll to bottom' : 'Scroll to top');
    button.setAttribute('data-so-go-to-top', '');
    button.setAttribute('data-direction', direction);

    // Build class list using existing button classes
    const classes = [
      'so-btn',
      'so-btn-icon',
      'so-btn-circle',
      `so-btn-${variant}`,
      'so-go-to-top',
      `so-go-to-top-${position}`,
    ];

    if (direction === 'bottom') {
      classes.push('so-go-to-bottom');
    }

    if (size && size !== 'md') {
      classes.push(`so-btn-${size}`);
    }

    if (showProgress) {
      classes.push('so-go-to-top-progress');
    }

    button.className = classes.join(' ');
    button.innerHTML = `<span class="material-icons">${finalIcon}</span>`;

    // Append to container
    const containerEl = typeof container === 'string'
      ? document.querySelector(container)
      : container;

    if (containerEl) {
      containerEl.appendChild(button);
    }

    // Initialize and return instance
    return new SOGoToTop(button, {
      direction,
      position,
      icon: finalIcon,
      size,
      variant,
      showProgress,
      ...restOptions,
    });
  }

  /**
   * Create both go-to-top and go-to-bottom buttons
   * They show/hide based on scroll position
   * @param {Object} options - Configuration options
   * @returns {{ top: SOGoToTop, bottom: SOGoToTop }}
   */
  static createPair(options = {}) {
    const {
      position = 'bottom-right',
      size = 'md',
      variant = 'primary',
      showProgress = false,
      container = document.body,
      topIcon = 'arrow_upward',
      bottomIcon = 'arrow_downward',
      showAfter = 300,
      ...restOptions
    } = options;

    // Determine positions for both buttons
    let topPosition = position;
    let bottomPosition = position;

    // If same position, offset the bottom button
    if (position === 'bottom-right') {
      // Stack vertically - bottom button slightly higher
    } else if (position === 'bottom-left') {
      // Stack vertically
    }

    const top = SOGoToTop.create({
      direction: 'top',
      position: topPosition,
      icon: topIcon,
      size,
      variant,
      showProgress,
      container,
      showAfter,
      ...restOptions,
    });

    const bottom = SOGoToTop.create({
      direction: 'bottom',
      position: bottomPosition,
      icon: bottomIcon,
      size,
      variant,
      showProgress: false, // Only show progress on top button
      container,
      showAfter,
      ...restOptions,
    });

    // Add offset class to bottom button when paired
    bottom.element.classList.add('so-go-to-top-paired');

    return { top, bottom };
  }

  /**
   * Initialize all scroll navigation buttons on the page
   */
  static initAll() {
    document.querySelectorAll('[data-so-go-to-top]').forEach(el => {
      if (!el._soGoToTopInstance) {
        const direction = el.getAttribute('data-direction') || 'top';
        el._soGoToTopInstance = new SOGoToTop(el, { direction });
      }
    });
  }
}

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => SOGoToTop.initAll());
} else {
  SOGoToTop.initAll();
}

// Register with SixOrbit
SixOrbit.registerComponent(SOGoToTop);

export default SOGoToTop;
