// ============================================
// SIXORBIT UI - GLOBAL CONFIGURATION
// Core configuration and utility helpers
// ============================================

/**
 * SixOrbit Global Configuration Object
 * Provides constants, helpers, and utilities used across all components
 */
const SixOrbit = {
  // Expose to window immediately for other scripts
  // This ensures SixOrbit is available before any other code runs
};

// Expose to global scope immediately
window.SixOrbit = SixOrbit;

// Now define all properties
Object.assign(SixOrbit, {
  // ============================================
  // CORE CONSTANTS
  // ============================================

  /** Framework version */
  VERSION: "1.0.0",

  /** CSS class prefix */
  PREFIX: "so",

  /** Data attribute prefix */
  DATA_PREFIX: "data-so",

  /** Custom event prefix */
  EVENT_PREFIX: "so:",

  // ============================================
  // CLASS NAME HELPERS
  // ============================================

  /**
   * Generate a prefixed class name
   * @param {...string} parts - Class name parts to join
   * @returns {string} Prefixed class name
   * @example SixOrbit.cls('btn', 'primary') => 'so-btn-primary'
   */
  cls(...parts) {
    return `${this.PREFIX}-${parts.join("-")}`;
  },

  /**
   * Generate a CSS selector for a prefixed class
   * @param {...string} parts - Class name parts
   * @returns {string} CSS selector
   * @example SixOrbit.sel('btn') => '.so-btn'
   */
  sel(...parts) {
    return `.${this.cls(...parts)}`;
  },

  // ============================================
  // DATA ATTRIBUTE HELPERS
  // ============================================

  /**
   * Generate a prefixed data attribute name
   * @param {string} name - Attribute name
   * @returns {string} Prefixed data attribute
   * @example SixOrbit.data('toggle') => 'data-so-toggle'
   */
  data(name) {
    return `${this.DATA_PREFIX}-${name}`;
  },

  /**
   * Generate a CSS selector for a data attribute
   * @param {string} name - Attribute name
   * @param {string} [value] - Optional attribute value
   * @returns {string} CSS selector
   * @example SixOrbit.dataSel('toggle', 'modal') => '[data-so-toggle="modal"]'
   */
  dataSel(name, value) {
    const attr = this.data(name);
    return value !== undefined ? `[${attr}="${value}"]` : `[${attr}]`;
  },

  // ============================================
  // EVENT HELPERS
  // ============================================

  /**
   * Generate a prefixed event name
   * @param {string} name - Event name
   * @returns {string} Prefixed event name
   * @example SixOrbit.evt('open') => 'so:open'
   */
  evt(name) {
    return `${this.EVENT_PREFIX}${name}`;
  },

  // ============================================
  // STORAGE HELPERS
  // ============================================

  /**
   * Generate a prefixed localStorage key
   * @param {string} name - Storage key name
   * @returns {string} Prefixed storage key
   * @example SixOrbit.storageKey('theme') => 'so-theme'
   */
  storageKey(name) {
    return `${this.PREFIX}-${name}`;
  },

  /**
   * Get value from localStorage with JSON parsing
   * @param {string} name - Storage key name (will be prefixed)
   * @param {*} [defaultValue=null] - Default value if not found
   * @returns {*} Stored value or default
   */
  getStorage(name, defaultValue = null) {
    try {
      const key = this.storageKey(name);
      const value = localStorage.getItem(key);
      return value !== null ? JSON.parse(value) : defaultValue;
    } catch (e) {
      return defaultValue;
    }
  },

  /**
   * Set value in localStorage with JSON stringification
   * @param {string} name - Storage key name (will be prefixed)
   * @param {*} value - Value to store
   */
  setStorage(name, value) {
    try {
      const key = this.storageKey(name);
      localStorage.setItem(key, JSON.stringify(value));
    } catch (e) {
      console.warn(`SixOrbit: Failed to save to localStorage: ${name}`, e);
    }
  },

  /**
   * Remove value from localStorage
   * @param {string} name - Storage key name (will be prefixed)
   */
  removeStorage(name) {
    try {
      const key = this.storageKey(name);
      localStorage.removeItem(key);
    } catch (e) {
      // Ignore errors
    }
  },

  // ============================================
  // CSS VARIABLE HELPERS
  // ============================================

  /**
   * Get a CSS custom property value
   * @param {string} name - Variable name (without --so- prefix)
   * @param {Element} [element=document.documentElement] - Element to get from
   * @returns {string} CSS variable value
   */
  getCssVar(name, element = document.documentElement) {
    return getComputedStyle(element)
      .getPropertyValue(`--${this.PREFIX}-${name}`)
      .trim();
  },

  /**
   * Set a CSS custom property value
   * @param {string} name - Variable name (without --so- prefix)
   * @param {string} value - Value to set
   * @param {Element} [element=document.documentElement] - Element to set on
   */
  setCssVar(name, value, element = document.documentElement) {
    element.style.setProperty(`--${this.PREFIX}-${name}`, value);
  },

  // ============================================
  // UTILITY FUNCTIONS
  // ============================================

  /**
   * Debounce a function
   * @param {Function} fn - Function to debounce
   * @param {number} [delay=300] - Delay in milliseconds
   * @returns {Function} Debounced function
   */
  debounce(fn, delay = 300) {
    let timeoutId;
    return function (...args) {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(() => fn.apply(this, args), delay);
    };
  },

  /**
   * Throttle a function
   * @param {Function} fn - Function to throttle
   * @param {number} [limit=100] - Minimum time between calls in milliseconds
   * @returns {Function} Throttled function
   */
  throttle(fn, limit = 100) {
    let inThrottle;
    return function (...args) {
      if (!inThrottle) {
        fn.apply(this, args);
        inThrottle = true;
        setTimeout(() => (inThrottle = false), limit);
      }
    };
  },

  /**
   * Generate a unique ID
   * @param {string} [prefix='so'] - ID prefix
   * @returns {string} Unique ID
   */
  uniqueId(prefix = "so") {
    return `${prefix}-${Date.now().toString(36)}-${Math.random().toString(36).substring(2, 9)}`;
  },

  /**
   * Check if an element matches a selector
   * @param {Element} element - Element to check
   * @param {string} selector - CSS selector
   * @returns {boolean} Whether element matches
   */
  matches(element, selector) {
    return element && element.matches && element.matches(selector);
  },

  /**
   * Find closest ancestor matching selector
   * @param {Element} element - Starting element
   * @param {string} selector - CSS selector
   * @returns {Element|null} Matching ancestor or null
   */
  closest(element, selector) {
    return element && element.closest ? element.closest(selector) : null;
  },

  /**
   * Parse data attributes from an element into an options object
   * @param {Element} element - Element to parse
   * @param {string[]} [keys=[]] - Specific keys to parse (all if empty)
   * @returns {Object} Parsed options
   */
  parseDataOptions(element, keys = []) {
    const options = {};
    const prefix = "so";

    if (!element || !element.dataset) return options;

    Object.keys(element.dataset).forEach((key) => {
      // Only process keys starting with 'so'
      if (key.startsWith(prefix)) {
        const optionKey = key.slice(prefix.length);
        // Convert to camelCase with lowercase first letter
        const normalizedKey =
          optionKey.charAt(0).toLowerCase() + optionKey.slice(1);

        // Skip if keys specified and this key isn't in the list
        if (keys.length > 0 && !keys.includes(normalizedKey)) return;

        let value = element.dataset[key];

        // Try to parse as JSON (handles booleans, numbers, arrays, objects)
        try {
          value = JSON.parse(value);
        } catch (e) {
          // Keep as string if not valid JSON
        }

        // If value is a plain object (not array), spread its properties
        // This allows data-so-tabs='{"closable": true}' to work correctly
        if (value && typeof value === "object" && !Array.isArray(value)) {
          Object.assign(options, value);
        } else {
          options[normalizedKey] = value;
        }
      }
    });

    return options;
  },

  // ============================================
  // BREAKPOINTS
  // ============================================

  /** Responsive breakpoints in pixels */
  breakpoints: {
    sm: 576,
    md: 768,
    lg: 1024,
    xl: 1200,
  },

  /**
   * Check if viewport is below a breakpoint
   * @param {string} breakpoint - Breakpoint name (sm, md, lg, xl)
   * @returns {boolean} Whether viewport is below breakpoint
   */
  isMobile(breakpoint = "md") {
    return window.innerWidth < (this.breakpoints[breakpoint] || 768);
  },

  // ============================================
  // COMPONENT REGISTRY
  // ============================================

  /** Registered component classes */
  _components: {},

  /** Component instances */
  _instances: new WeakMap(),

  /**
   * Register a component class
   * @param {string} name - Component name
   * @param {Function} ComponentClass - Component class
   */
  registerComponent(name, ComponentClass) {
    this._components[name] = ComponentClass;
  },

  /**
   * Get a registered component class
   * @param {string} name - Component name
   * @returns {Function|undefined} Component class
   */
  getComponent(name) {
    return this._components[name];
  },

  /**
   * Get or create component instance for an element
   * @param {Element} element - DOM element
   * @param {string} name - Component name
   * @param {Object} [options={}] - Component options
   * @returns {Object|null} Component instance
   */
  getInstance(element, name, options = {}) {
    if (!element) return null;

    // Check for existing instance
    let instances = this._instances.get(element);
    if (instances && instances[name]) {
      return instances[name];
    }

    // Create new instance if component is registered
    const ComponentClass = this._components[name];
    if (!ComponentClass) return null;

    const instance = new ComponentClass(element, options);

    // Store instance
    if (!instances) {
      instances = {};
      this._instances.set(element, instances);
    }
    instances[name] = instance;

    return instance;
  },

  /**
   * Remove component instance from an element
   * @param {Element} element - DOM element
   * @param {string} name - Component name
   */
  removeInstance(element, name) {
    const instances = this._instances.get(element);
    if (instances && instances[name]) {
      if (typeof instances[name].destroy === "function") {
        instances[name].destroy();
      }
      delete instances[name];
    }
  },

  // ============================================
  // INITIALIZATION
  // ============================================

  /** Whether the framework has been initialized */
  _initialized: false,

  /**
   * Initialize the framework
   * Called automatically on DOMContentLoaded
   */
  init() {
    if (this._initialized) return;
    this._initialized = true;

    // Dispatch ready event
    document.dispatchEvent(
      new CustomEvent(this.evt("ready"), {
        detail: { version: this.VERSION },
      }),
    );

    // console.log(`SixOrbit UI v${this.VERSION} initialized`);
  },
});

// Auto-initialize on DOM ready
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", () => SixOrbit.init());
} else {
  SixOrbit.init();
}

// Export for ES modules
export default SixOrbit;
export { SixOrbit };
