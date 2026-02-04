// ============================================
// SIXORBIT UI - BASE COMPONENT CLASS
// Foundation for all UI components
// ============================================

// Import SixOrbit global (also available on window.SixOrbit)
import SixOrbit from './so-config.js';

/**
 * SOComponent - Base class for all SixOrbit UI components
 * Provides common functionality: options merging, event handling,
 * lifecycle management, and DOM utilities
 */
class SOComponent {
  // ============================================
  // STATIC PROPERTIES
  // ============================================

  /** Component name for registration */
  static NAME = 'component';

  /** Default options (override in subclass) */
  static DEFAULTS = {};

  /** Events emitted by this component */
  static EVENTS = {};

  // ============================================
  // CONSTRUCTOR
  // ============================================

  /**
   * Create a new component instance
   * @param {Element|string} element - DOM element or selector
   * @param {Object} [options={}] - Component options
   */
  constructor(element, options = {}) {
    // Resolve element
    this.element = typeof element === 'string'
      ? document.querySelector(element)
      : element;

    // Only warn if element was a selector string that wasn't found
    // (not if element is explicitly null for config-based construction)
    if (!this.element && typeof element === 'string') {
      console.warn(`${this.constructor.NAME}: Element not found for selector "${element}"`);
      return;
    }

    // Allow null element for config-based construction (Element class)
    if (!this.element && element === null) {
      return;
    }

    // Merge options: defaults < data attributes < passed options
    this.options = this._mergeOptions(options);

    // Store bound event handlers for cleanup
    this._boundHandlers = new Map();

    // Event delegation handlers
    this._delegatedHandlers = [];

    // Initialize the component
    this._init();
  }

  // ============================================
  // PRIVATE METHODS
  // ============================================

  /**
   * Merge options from defaults, data attributes, and passed options
   * @param {Object} options - Passed options
   * @returns {Object} Merged options
   * @private
   */
  _mergeOptions(options) {
    const defaults = this.constructor.DEFAULTS;
    const dataOptions = SixOrbit.parseDataOptions(this.element);

    return { ...defaults, ...dataOptions, ...options };
  }

  /**
   * Initialize the component (override in subclass)
   * @private
   */
  _init() {
    // Override in subclass
  }

  // ============================================
  // DOM UTILITIES
  // ============================================

  /**
   * Query a single element within this component
   * @param {string} selector - CSS selector
   * @returns {Element|null} Found element
   */
  $(selector) {
    return this.element.querySelector(selector);
  }

  /**
   * Query all elements within this component
   * @param {string} selector - CSS selector
   * @returns {Element[]} Array of found elements
   */
  $$(selector) {
    return Array.from(this.element.querySelectorAll(selector));
  }

  /**
   * Find element by prefixed class name
   * @param {...string} parts - Class name parts
   * @returns {Element|null} Found element
   */
  $cls(...parts) {
    return this.$(SixOrbit.sel(...parts));
  }

  /**
   * Find all elements by prefixed class name
   * @param {...string} parts - Class name parts
   * @returns {Element[]} Array of found elements
   */
  $$cls(...parts) {
    return this.$$(SixOrbit.sel(...parts));
  }

  // ============================================
  // CLASS UTILITIES
  // ============================================

  /**
   * Add class(es) to the component element
   * @param {...string} classes - Class names to add
   * @returns {this} For chaining
   */
  addClass(...classes) {
    this.element.classList.add(...classes);
    return this;
  }

  /**
   * Remove class(es) from the component element
   * @param {...string} classes - Class names to remove
   * @returns {this} For chaining
   */
  removeClass(...classes) {
    this.element.classList.remove(...classes);
    return this;
  }

  /**
   * Toggle a class on the component element
   * @param {string} className - Class name to toggle
   * @param {boolean} [force] - Force add or remove
   * @returns {this} For chaining
   */
  toggleClass(className, force) {
    this.element.classList.toggle(className, force);
    return this;
  }

  /**
   * Check if component element has a class
   * @param {string} className - Class name to check
   * @returns {boolean} Whether element has class
   */
  hasClass(className) {
    return this.element.classList.contains(className);
  }

  // ============================================
  // ATTRIBUTE UTILITIES
  // ============================================

  /**
   * Get a data attribute value
   * @param {string} name - Attribute name (without data-so- prefix)
   * @returns {string|null} Attribute value
   */
  getData(name) {
    return this.element.getAttribute(SixOrbit.data(name));
  }

  /**
   * Set a data attribute value
   * @param {string} name - Attribute name (without data-so- prefix)
   * @param {string} value - Value to set
   * @returns {this} For chaining
   */
  setData(name, value) {
    this.element.setAttribute(SixOrbit.data(name), value);
    return this;
  }

  /**
   * Remove a data attribute
   * @param {string} name - Attribute name (without data-so- prefix)
   * @returns {this} For chaining
   */
  removeData(name) {
    this.element.removeAttribute(SixOrbit.data(name));
    return this;
  }

  // ============================================
  // EVENT HANDLING
  // ============================================

  /**
   * Add an event listener with automatic binding
   * @param {string} event - Event name
   * @param {Function} handler - Event handler
   * @param {Element} [target=this.element] - Target element
   * @param {Object} [options={}] - Event listener options
   * @returns {this} For chaining
   */
  on(event, handler, target = this.element, options = {}) {
    const boundHandler = handler.bind(this);
    this._boundHandlers.set(handler, { boundHandler, target, event, options });
    target.addEventListener(event, boundHandler, options);
    return this;
  }

  /**
   * Remove an event listener
   * @param {string} event - Event name
   * @param {Function} handler - Original handler function
   * @param {Element} [target=this.element] - Target element
   * @returns {this} For chaining
   */
  off(event, handler, target = this.element) {
    const stored = this._boundHandlers.get(handler);
    if (stored) {
      target.removeEventListener(event, stored.boundHandler, stored.options);
      this._boundHandlers.delete(handler);
    }
    return this;
  }

  /**
   * Add a one-time event listener
   * @param {string} event - Event name
   * @param {Function} handler - Event handler
   * @param {Element} [target=this.element] - Target element
   * @returns {this} For chaining
   */
  once(event, handler, target = this.element) {
    return this.on(event, handler, target, { once: true });
  }

  /**
   * Add delegated event listener
   * @param {string} event - Event name
   * @param {string} selector - CSS selector for delegation
   * @param {Function} handler - Event handler
   * @returns {this} For chaining
   */
  delegate(event, selector, handler) {
    const delegatedHandler = (e) => {
      const target = e.target.closest(selector);
      if (target && this.element.contains(target)) {
        handler.call(this, e, target);
      }
    };

    this._delegatedHandlers.push({ event, handler: delegatedHandler });
    this.element.addEventListener(event, delegatedHandler);
    return this;
  }

  /**
   * Emit a custom event
   * @param {string} name - Event name (will be prefixed with so:)
   * @param {Object} [detail={}] - Event detail data
   * @param {boolean} [bubbles=true] - Whether event bubbles
   * @param {boolean} [cancelable=true] - Whether event is cancelable
   * @returns {boolean} Whether event was not prevented
   */
  emit(name, detail = {}, bubbles = true, cancelable = true) {
    const event = new CustomEvent(SixOrbit.evt(name), {
      detail: { ...detail, component: this },
      bubbles,
      cancelable
    });
    return this.element.dispatchEvent(event);
  }

  // ============================================
  // STATE MANAGEMENT
  // ============================================

  /**
   * Update component state and trigger re-render
   * @param {Object} newState - State changes
   */
  setState(newState) {
    const oldState = { ...this._state };
    this._state = { ...this._state, ...newState };
    this._onStateChange(this._state, oldState);
  }

  /**
   * Get current state
   * @returns {Object} Current state
   */
  getState() {
    return { ...this._state };
  }

  /**
   * Called when state changes (override in subclass)
   * @param {Object} newState - New state
   * @param {Object} oldState - Previous state
   * @protected
   */
  _onStateChange(newState, oldState) {
    // Override in subclass
  }

  // ============================================
  // VISIBILITY
  // ============================================

  /**
   * Show the component element
   * @returns {this} For chaining
   */
  show() {
    this.element.style.display = '';
    this.element.removeAttribute('hidden');
    this.emit('show');
    return this;
  }

  /**
   * Hide the component element
   * @returns {this} For chaining
   */
  hide() {
    this.element.style.display = 'none';
    this.element.setAttribute('hidden', '');
    this.emit('hide');
    return this;
  }

  /**
   * Toggle component visibility
   * @param {boolean} [force] - Force show or hide
   * @returns {this} For chaining
   */
  toggle(force) {
    const shouldShow = force !== undefined ? force : this.element.hidden;
    return shouldShow ? this.show() : this.hide();
  }

  /**
   * Check if component is visible
   * @returns {boolean} Whether component is visible
   */
  isVisible() {
    return !this.element.hidden && this.element.style.display !== 'none';
  }

  // ============================================
  // FOCUS MANAGEMENT
  // ============================================

  /**
   * Focus the component element
   * @returns {this} For chaining
   */
  focus() {
    this.element.focus();
    return this;
  }

  /**
   * Blur the component element
   * @returns {this} For chaining
   */
  blur() {
    this.element.blur();
    return this;
  }

  /**
   * Get all focusable elements within component
   * @returns {Element[]} Focusable elements
   */
  getFocusableElements() {
    const focusableSelectors = [
      'a[href]',
      'button:not([disabled])',
      'input:not([disabled])',
      'select:not([disabled])',
      'textarea:not([disabled])',
      '[tabindex]:not([tabindex="-1"])',
    ].join(', ');

    return this.$$(focusableSelectors);
  }

  /**
   * Trap focus within component (for modals, etc.)
   * @param {Object} [options={}] - Trap options
   * @param {boolean} [options.skipInitialFocus=false] - Skip focusing first element
   * @returns {Function} Function to remove focus trap
   */
  trapFocus(options = {}) {
    const { skipInitialFocus = false } = options;
    const focusableElements = this.getFocusableElements();
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];

    const handleKeydown = (e) => {
      if (e.key !== 'Tab') return;

      if (e.shiftKey) {
        if (document.activeElement === firstElement) {
          e.preventDefault();
          lastElement?.focus();
        }
      } else {
        if (document.activeElement === lastElement) {
          e.preventDefault();
          firstElement?.focus();
        }
      }
    };

    this.element.addEventListener('keydown', handleKeydown);

    if (!skipInitialFocus) {
      firstElement?.focus();
    }

    return () => {
      this.element.removeEventListener('keydown', handleKeydown);
    };
  }

  // ============================================
  // LIFECYCLE
  // ============================================

  /**
   * Enable the component
   * @returns {this} For chaining
   */
  enable() {
    this.element.removeAttribute('disabled');
    this.removeClass(SixOrbit.cls('disabled'));
    this._disabled = false;
    this.emit('enable');
    return this;
  }

  /**
   * Disable the component
   * @returns {this} For chaining
   */
  disable() {
    this.element.setAttribute('disabled', '');
    this.addClass(SixOrbit.cls('disabled'));
    this._disabled = true;
    this.emit('disable');
    return this;
  }

  /**
   * Check if component is disabled
   * @returns {boolean} Whether component is disabled
   */
  isDisabled() {
    return this._disabled || this.element.hasAttribute('disabled');
  }

  /**
   * Update component options
   * @param {Object} newOptions - New options to merge
   * @returns {this} For chaining
   */
  setOptions(newOptions) {
    this.options = { ...this.options, ...newOptions };
    this._onOptionsChange();
    return this;
  }

  /**
   * Called when options change (override in subclass)
   * @protected
   */
  _onOptionsChange() {
    // Override in subclass
  }

  /**
   * Destroy the component and clean up
   */
  destroy() {
    // Remove all bound event listeners
    this._boundHandlers.forEach((stored, handler) => {
      stored.target.removeEventListener(stored.event, stored.boundHandler, stored.options);
    });
    this._boundHandlers.clear();

    // Remove delegated handlers
    this._delegatedHandlers.forEach(({ event, handler }) => {
      this.element.removeEventListener(event, handler);
    });
    this._delegatedHandlers = [];

    // Emit destroy event
    this.emit('destroy');

    // Remove instance from registry
    SixOrbit.removeInstance(this.element, this.constructor.NAME);

    // Clear references
    this.element = null;
    this.options = null;
  }

  // ============================================
  // STATIC UTILITIES
  // ============================================

  /**
   * Get or create instance for an element
   * @param {Element|string} element - DOM element or selector
   * @param {Object} [options={}] - Component options
   * @returns {SOComponent} Component instance
   */
  static getInstance(element, options = {}) {
    const el = typeof element === 'string' ? document.querySelector(element) : element;
    return SixOrbit.getInstance(el, this.NAME, options);
  }

  /**
   * Initialize all components matching selector
   * @param {string} [selector] - CSS selector (default: data attribute)
   * @param {Object} [options={}] - Default options for all instances
   * @returns {SOComponent[]} Array of instances
   */
  static initAll(selector, options = {}) {
    const sel = selector || SixOrbit.dataSel(this.NAME);
    const elements = document.querySelectorAll(sel);
    return Array.from(elements).map(el => this.getInstance(el, options));
  }

  /**
   * Register this component with SixOrbit
   */
  static register() {
    SixOrbit.registerComponent(this.NAME, this);
  }
}

// Expose to global scope
window.SOComponent = SOComponent;

// Export for ES modules
export default SOComponent;
export { SOComponent };
