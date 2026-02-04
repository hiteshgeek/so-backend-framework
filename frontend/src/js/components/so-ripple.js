// ============================================
// SIXORBIT UI - RIPPLE EFFECT
// Material Design ripple effect for buttons
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SORipple - Material design ripple effect
 * Automatically adds ripple effects to elements with .so-btn class
 */
class SORipple extends SOComponent {
  static NAME = 'ripple';

  static DEFAULTS = {
    selector: '.so-btn',
    duration: 600,
    color: 'rgba(255, 255, 255, 0.35)',
  };

  /**
   * Initialize ripple effect
   * @private
   */
  _init() {
    this._bindEvents();
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Use event delegation on document for all ripple elements
    this.on('click', this._handleClick, document);
  }

  /**
   * Handle click event
   * @param {MouseEvent} e - Click event
   * @private
   */
  _handleClick(e) {
    const target = e.target.closest(this.options.selector);
    if (!target) return;

    // Don't add ripple to disabled buttons
    if (target.disabled || target.classList.contains('so-disabled')) return;

    this._createRipple(target, e);
  }

  /**
   * Create ripple effect
   * @param {Element} element - Target element
   * @param {MouseEvent} event - Click event
   * @private
   */
  _createRipple(element, event) {
    const rect = element.getBoundingClientRect();

    // Calculate ripple size (largest of width/height to ensure full coverage)
    const size = Math.max(rect.width, rect.height);

    // Calculate click position relative to element
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;

    // Create ripple element
    const ripple = document.createElement('span');
    ripple.className = 'so-ripple-effect';
    ripple.style.cssText = `
      position: absolute;
      width: ${size}px;
      height: ${size}px;
      left: ${x}px;
      top: ${y}px;
      background: ${this._getRippleColor(element)};
      border-radius: 50%;
      transform: scale(0);
      opacity: 1;
      pointer-events: none;
      animation: so-ripple-animation ${this.options.duration}ms ease-out forwards;
    `;

    // Ensure element has relative positioning
    const position = getComputedStyle(element).position;
    if (position === 'static') {
      element.style.position = 'relative';
    }

    // Ensure overflow is hidden
    element.style.overflow = 'hidden';

    // Add ripple to element
    element.appendChild(ripple);

    // Remove ripple after animation
    setTimeout(() => {
      ripple.remove();
    }, this.options.duration);
  }

  /**
   * Get ripple color based on element
   * @param {Element} element - Target element
   * @returns {string} Ripple color
   * @private
   */
  _getRippleColor(element) {
    // Use darker ripple for light buttons
    if (element.classList.contains('so-btn-outline') ||
        element.classList.contains('so-btn-ghost') ||
        element.classList.contains('so-btn-light')) {
      return 'rgba(0, 0, 0, 0.1)';
    }

    return this.options.color;
  }

  /**
   * Add CSS animation if not present
   * @private
   */
  static _ensureStyles() {
    if (document.getElementById('so-ripple-styles')) return;

    const style = document.createElement('style');
    style.id = 'so-ripple-styles';
    style.textContent = `
      @keyframes so-ripple-animation {
        to {
          transform: scale(4);
          opacity: 0;
        }
      }
    `;
    document.head.appendChild(style);
  }
}

// Ensure styles are added
SORipple._ensureStyles();

// Auto-initialize global ripple handler
document.addEventListener('DOMContentLoaded', () => {
  new SORipple(document.body);
});

// Register component
SORipple.register();

// Expose to global scope
window.SORipple = SORipple;

// Export for ES modules
export default SORipple;
export { SORipple };
