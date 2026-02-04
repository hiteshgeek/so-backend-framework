var SixOrbitCore = (() => {
  var __defProp = Object.defineProperty;
  var __defProps = Object.defineProperties;
  var __getOwnPropDescs = Object.getOwnPropertyDescriptors;
  var __getOwnPropSymbols = Object.getOwnPropertySymbols;
  var __hasOwnProp = Object.prototype.hasOwnProperty;
  var __propIsEnum = Object.prototype.propertyIsEnumerable;
  var __defNormalProp = (obj, key, value) => key in obj ? __defProp(obj, key, { enumerable: true, configurable: true, writable: true, value }) : obj[key] = value;
  var __spreadValues = (a, b) => {
    for (var prop in b || (b = {}))
      if (__hasOwnProp.call(b, prop))
        __defNormalProp(a, prop, b[prop]);
    if (__getOwnPropSymbols)
      for (var prop of __getOwnPropSymbols(b)) {
        if (__propIsEnum.call(b, prop))
          __defNormalProp(a, prop, b[prop]);
      }
    return a;
  };
  var __spreadProps = (a, b) => __defProps(a, __getOwnPropDescs(b));
  var __objRest = (source, exclude) => {
    var target = {};
    for (var prop in source)
      if (__hasOwnProp.call(source, prop) && exclude.indexOf(prop) < 0)
        target[prop] = source[prop];
    if (source != null && __getOwnPropSymbols)
      for (var prop of __getOwnPropSymbols(source)) {
        if (exclude.indexOf(prop) < 0 && __propIsEnum.call(source, prop))
          target[prop] = source[prop];
      }
    return target;
  };
  var __publicField = (obj, key, value) => {
    __defNormalProp(obj, typeof key !== "symbol" ? key + "" : key, value);
    return value;
  };

  // src/js/core/so-config.js
  var SixOrbit = {
    // Expose to window immediately for other scripts
    // This ensures SixOrbit is available before any other code runs
  };
  window.SixOrbit = SixOrbit;
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
      return value !== void 0 ? `[${attr}="${value}"]` : `[${attr}]`;
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
      return getComputedStyle(element).getPropertyValue(`--${this.PREFIX}-${name}`).trim();
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
      return function(...args) {
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
      return function(...args) {
        if (!inThrottle) {
          fn.apply(this, args);
          inThrottle = true;
          setTimeout(() => inThrottle = false, limit);
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
      if (!element || !element.dataset)
        return options;
      Object.keys(element.dataset).forEach((key) => {
        if (key.startsWith(prefix)) {
          const optionKey = key.slice(prefix.length);
          const normalizedKey = optionKey.charAt(0).toLowerCase() + optionKey.slice(1);
          if (keys.length > 0 && !keys.includes(normalizedKey))
            return;
          let value = element.dataset[key];
          try {
            value = JSON.parse(value);
          } catch (e) {
          }
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
      xl: 1200
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
    _instances: /* @__PURE__ */ new WeakMap(),
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
      if (!element)
        return null;
      let instances = this._instances.get(element);
      if (instances && instances[name]) {
        return instances[name];
      }
      const ComponentClass = this._components[name];
      if (!ComponentClass)
        return null;
      const instance = new ComponentClass(element, options);
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
      if (this._initialized)
        return;
      this._initialized = true;
      document.dispatchEvent(
        new CustomEvent(this.evt("ready"), {
          detail: { version: this.VERSION }
        })
      );
    }
  });
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", () => SixOrbit.init());
  } else {
    SixOrbit.init();
  }
  var so_config_default = SixOrbit;

  // src/js/core/so-component.js
  var SOComponent = class {
    // ============================================
    // CONSTRUCTOR
    // ============================================
    /**
     * Create a new component instance
     * @param {Element|string} element - DOM element or selector
     * @param {Object} [options={}] - Component options
     */
    constructor(element, options = {}) {
      this.element = typeof element === "string" ? document.querySelector(element) : element;
      if (!this.element && typeof element === "string") {
        console.warn(`${this.constructor.NAME}: Element not found for selector "${element}"`);
        return;
      }
      if (!this.element && element === null) {
        return;
      }
      this.options = this._mergeOptions(options);
      this._boundHandlers = /* @__PURE__ */ new Map();
      this._delegatedHandlers = [];
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
      const dataOptions = so_config_default.parseDataOptions(this.element);
      return __spreadValues(__spreadValues(__spreadValues({}, defaults), dataOptions), options);
    }
    /**
     * Initialize the component (override in subclass)
     * @private
     */
    _init() {
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
      return this.$(so_config_default.sel(...parts));
    }
    /**
     * Find all elements by prefixed class name
     * @param {...string} parts - Class name parts
     * @returns {Element[]} Array of found elements
     */
    $$cls(...parts) {
      return this.$$(so_config_default.sel(...parts));
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
      return this.element.getAttribute(so_config_default.data(name));
    }
    /**
     * Set a data attribute value
     * @param {string} name - Attribute name (without data-so- prefix)
     * @param {string} value - Value to set
     * @returns {this} For chaining
     */
    setData(name, value) {
      this.element.setAttribute(so_config_default.data(name), value);
      return this;
    }
    /**
     * Remove a data attribute
     * @param {string} name - Attribute name (without data-so- prefix)
     * @returns {this} For chaining
     */
    removeData(name) {
      this.element.removeAttribute(so_config_default.data(name));
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
      const event = new CustomEvent(so_config_default.evt(name), {
        detail: __spreadProps(__spreadValues({}, detail), { component: this }),
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
      const oldState = __spreadValues({}, this._state);
      this._state = __spreadValues(__spreadValues({}, this._state), newState);
      this._onStateChange(this._state, oldState);
    }
    /**
     * Get current state
     * @returns {Object} Current state
     */
    getState() {
      return __spreadValues({}, this._state);
    }
    /**
     * Called when state changes (override in subclass)
     * @param {Object} newState - New state
     * @param {Object} oldState - Previous state
     * @protected
     */
    _onStateChange(newState, oldState) {
    }
    // ============================================
    // VISIBILITY
    // ============================================
    /**
     * Show the component element
     * @returns {this} For chaining
     */
    show() {
      this.element.style.display = "";
      this.element.removeAttribute("hidden");
      this.emit("show");
      return this;
    }
    /**
     * Hide the component element
     * @returns {this} For chaining
     */
    hide() {
      this.element.style.display = "none";
      this.element.setAttribute("hidden", "");
      this.emit("hide");
      return this;
    }
    /**
     * Toggle component visibility
     * @param {boolean} [force] - Force show or hide
     * @returns {this} For chaining
     */
    toggle(force) {
      const shouldShow = force !== void 0 ? force : this.element.hidden;
      return shouldShow ? this.show() : this.hide();
    }
    /**
     * Check if component is visible
     * @returns {boolean} Whether component is visible
     */
    isVisible() {
      return !this.element.hidden && this.element.style.display !== "none";
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
        "a[href]",
        "button:not([disabled])",
        "input:not([disabled])",
        "select:not([disabled])",
        "textarea:not([disabled])",
        '[tabindex]:not([tabindex="-1"])'
      ].join(", ");
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
        if (e.key !== "Tab")
          return;
        if (e.shiftKey) {
          if (document.activeElement === firstElement) {
            e.preventDefault();
            lastElement == null ? void 0 : lastElement.focus();
          }
        } else {
          if (document.activeElement === lastElement) {
            e.preventDefault();
            firstElement == null ? void 0 : firstElement.focus();
          }
        }
      };
      this.element.addEventListener("keydown", handleKeydown);
      if (!skipInitialFocus) {
        firstElement == null ? void 0 : firstElement.focus();
      }
      return () => {
        this.element.removeEventListener("keydown", handleKeydown);
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
      this.element.removeAttribute("disabled");
      this.removeClass(so_config_default.cls("disabled"));
      this._disabled = false;
      this.emit("enable");
      return this;
    }
    /**
     * Disable the component
     * @returns {this} For chaining
     */
    disable() {
      this.element.setAttribute("disabled", "");
      this.addClass(so_config_default.cls("disabled"));
      this._disabled = true;
      this.emit("disable");
      return this;
    }
    /**
     * Check if component is disabled
     * @returns {boolean} Whether component is disabled
     */
    isDisabled() {
      return this._disabled || this.element.hasAttribute("disabled");
    }
    /**
     * Update component options
     * @param {Object} newOptions - New options to merge
     * @returns {this} For chaining
     */
    setOptions(newOptions) {
      this.options = __spreadValues(__spreadValues({}, this.options), newOptions);
      this._onOptionsChange();
      return this;
    }
    /**
     * Called when options change (override in subclass)
     * @protected
     */
    _onOptionsChange() {
    }
    /**
     * Destroy the component and clean up
     */
    destroy() {
      this._boundHandlers.forEach((stored, handler) => {
        stored.target.removeEventListener(stored.event, stored.boundHandler, stored.options);
      });
      this._boundHandlers.clear();
      this._delegatedHandlers.forEach(({ event, handler }) => {
        this.element.removeEventListener(event, handler);
      });
      this._delegatedHandlers = [];
      this.emit("destroy");
      so_config_default.removeInstance(this.element, this.constructor.NAME);
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
      const el = typeof element === "string" ? document.querySelector(element) : element;
      return so_config_default.getInstance(el, this.NAME, options);
    }
    /**
     * Initialize all components matching selector
     * @param {string} [selector] - CSS selector (default: data attribute)
     * @param {Object} [options={}] - Default options for all instances
     * @returns {SOComponent[]} Array of instances
     */
    static initAll(selector, options = {}) {
      const sel = selector || so_config_default.dataSel(this.NAME);
      const elements = document.querySelectorAll(sel);
      return Array.from(elements).map((el) => this.getInstance(el, options));
    }
    /**
     * Register this component with SixOrbit
     */
    static register() {
      so_config_default.registerComponent(this.NAME, this);
    }
  };
  // ============================================
  // STATIC PROPERTIES
  // ============================================
  /** Component name for registration */
  __publicField(SOComponent, "NAME", "component");
  /** Default options (override in subclass) */
  __publicField(SOComponent, "DEFAULTS", {});
  /** Events emitted by this component */
  __publicField(SOComponent, "EVENTS", {});
  window.SOComponent = SOComponent;
  var so_component_default = SOComponent;

  // src/js/components/so-theme.js
  var _SOTheme = class _SOTheme extends so_component_default {
    /**
     * Initialize the theme controller
     * @private
     */
    _init() {
      this.themeBtn = this.$(".so-navbar-theme-btn");
      this.themeDropdown = this.$(".so-navbar-theme-dropdown");
      this._currentTheme = this.options.defaultTheme;
      this._currentFontSize = this.options.defaultFontSize;
      this._restoreTheme();
      this._restoreFontSize();
      this._bindEvents();
      this._applyTheme();
      this._applyFontSize();
    }
    /**
     * Bind event listeners
     * @private
     */
    _bindEvents() {
      if (this.themeBtn) {
        this.on("click", this._handleToggle, this.themeBtn);
      }
      this.delegate("click", ".so-navbar-theme-option", this._handleOptionClick);
      this.on("click", this._handleOutsideClick, document);
      this.on("keydown", this._handleKeydown, document);
      if (window.matchMedia) {
        const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");
        mediaQuery.addEventListener("change", () => {
          if (this._currentTheme === "system") {
            this._applyTheme();
          }
        });
      }
      this.on("closeAllDropdowns", this._closeDropdown, document);
    }
    /**
     * Handle toggle button click
     * @param {Event} e - Click event
     * @private
     */
    _handleToggle(e) {
      e.stopPropagation();
      const isOpen = this.hasClass("so-open");
      if (!isOpen) {
        document.dispatchEvent(new CustomEvent("closeAllDropdowns"));
      }
      this.toggleClass("so-open");
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
      if (e.key === "Escape") {
        this._closeDropdown();
      }
    }
    /**
     * Close the dropdown
     * @private
     */
    _closeDropdown() {
      this.removeClass("so-open");
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
      this.emit(_SOTheme.EVENTS.CHANGE, {
        theme,
        previousTheme,
        effectiveTheme: this.getEffectiveTheme()
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
      if (this._currentTheme === "system") {
        return this._getSystemTheme();
      }
      if (this._currentTheme === "sidebar-dark") {
        return "light";
      }
      return this._currentTheme;
    }
    /**
     * Apply the current theme to the document
     * @private
     */
    _applyTheme() {
      let effectiveTheme = this._currentTheme;
      const sidebar = document.querySelector(".so-sidebar");
      if (this._currentTheme === "sidebar-dark") {
        effectiveTheme = "light";
        if (sidebar)
          sidebar.classList.add("sidebar-dark");
      } else {
        if (sidebar)
          sidebar.classList.remove("sidebar-dark");
        if (this._currentTheme === "system") {
          effectiveTheme = this._getSystemTheme();
        }
      }
      document.documentElement.setAttribute("data-theme", effectiveTheme);
      this._updateIcon(effectiveTheme);
    }
    /**
     * Get system preferred theme
     * @returns {string} System theme (light or dark)
     * @private
     */
    _getSystemTheme() {
      if (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) {
        return "dark";
      }
      return "light";
    }
    /**
     * Update the theme button icon
     * @param {string} effectiveTheme - Current effective theme
     * @private
     */
    _updateIcon(effectiveTheme) {
      var _a;
      const icon = (_a = this.themeBtn) == null ? void 0 : _a.querySelector(".theme-icon");
      if (!icon)
        return;
      if (this._currentTheme === "sidebar-dark") {
        icon.textContent = "contrast";
      } else if (this._currentTheme === "system") {
        icon.textContent = "computer";
      } else if (effectiveTheme === "dark") {
        icon.textContent = "dark_mode";
      } else {
        icon.textContent = "light_mode";
      }
    }
    /**
     * Update active state on theme options
     * @private
     */
    _updateActiveOption() {
      this.$$(".so-navbar-theme-option").forEach((option) => {
        const isActive = option.dataset.theme === this._currentTheme;
        option.classList.toggle("so-active", isActive);
      });
    }
    /**
     * Save theme preference to storage
     * @private
     */
    _saveTheme() {
      so_config_default.setStorage(this.options.storageKeyTheme, this._currentTheme);
    }
    /**
     * Restore theme preference from storage
     * @private
     */
    _restoreTheme() {
      const saved = so_config_default.getStorage(this.options.storageKeyTheme);
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
      this.emit(_SOTheme.EVENTS.FONTSIZE, {
        fontSize: size,
        previousFontSize: previousSize
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
      if (this._currentFontSize === "default") {
        document.documentElement.removeAttribute("data-fontsize");
      } else {
        document.documentElement.setAttribute("data-fontsize", this._currentFontSize);
      }
    }
    /**
     * Update active state on font size options
     * @private
     */
    _updateActiveFontSizeOption() {
      this.$$(".so-navbar-theme-option").forEach((option) => {
        if (option.dataset.fontsize) {
          const isActive = option.dataset.fontsize === this._currentFontSize;
          option.classList.toggle("so-active", isActive);
        }
      });
    }
    /**
     * Save font size preference to storage
     * @private
     */
    _saveFontSize() {
      so_config_default.setStorage(this.options.storageKeyFont, this._currentFontSize);
    }
    /**
     * Restore font size preference from storage
     * @private
     */
    _restoreFontSize() {
      const saved = so_config_default.getStorage(this.options.storageKeyFont);
      if (saved && this.options.fontSizes.includes(saved)) {
        this._currentFontSize = saved;
      }
      this._updateActiveFontSizeOption();
    }
  };
  __publicField(_SOTheme, "NAME", "theme");
  __publicField(_SOTheme, "DEFAULTS", {
    themes: ["light", "dark", "sidebar-dark", "system"],
    fontSizes: ["small", "default", "large"],
    defaultTheme: "sidebar-dark",
    defaultFontSize: "default",
    storageKeyTheme: "theme-preference",
    storageKeyFont: "fontsize-preference"
  });
  __publicField(_SOTheme, "EVENTS", {
    CHANGE: "theme:change",
    FONTSIZE: "theme:fontsize"
  });
  var SOTheme2 = _SOTheme;
  SOTheme2.register();
  window.SOTheme = SOTheme2;

  // src/js/components/so-dropdown.js
  var _SODropdown = class _SODropdown extends so_component_default {
    /**
     * Initialize the dropdown
     * @private
     */
    _init() {
      this._type = this._detectType();
      this._cacheElements();
      this._isOpen = false;
      this._disabled = false;
      this._selectedValues = [];
      this._selectedTexts = [];
      this._originalItems = [];
      this._focusedIndex = -1;
      this._originalClasses = {
        dropup: this.element.classList.contains("so-dropup"),
        dropstart: this.element.classList.contains("so-dropstart"),
        dropend: this.element.classList.contains("so-dropend"),
        menuEnd: this.element.classList.contains("so-dropdown-menu-end")
      };
      if (this._itemsList) {
        this._originalItems = Array.from(this._itemsList.children);
      }
      this._parseDataAttributes();
      this._getInitialSelection();
      this._bindEvents();
    }
    /**
     * Parse data attributes for configuration
     * @private
     */
    _parseDataAttributes() {
      const el = this.element;
      if (el.hasAttribute("data-so-auto-close")) {
        const val = el.getAttribute("data-so-auto-close");
        if (val === "true")
          this.options.autoClose = true;
        else if (val === "false")
          this.options.autoClose = false;
        else
          this.options.autoClose = val;
      }
      if (el.hasAttribute("data-so-direction")) {
        this.options.direction = el.getAttribute("data-so-direction");
      }
      if (el.hasAttribute("data-so-alignment")) {
        this.options.alignment = el.getAttribute("data-so-alignment");
      }
      if (el.hasAttribute("data-so-selection-style")) {
        this.options.selectionStyle = el.getAttribute("data-so-selection-style");
      }
      if (el.hasAttribute("data-so-multiple")) {
        this.options.multiple = el.getAttribute("data-so-multiple") !== "false";
      }
      if (el.hasAttribute("data-so-max-selections")) {
        this.options.maxSelections = parseInt(el.getAttribute("data-so-max-selections"), 10) || null;
      }
      if (el.hasAttribute("data-so-min-selections")) {
        this.options.minSelections = parseInt(el.getAttribute("data-so-min-selections"), 10) || null;
      }
      if (el.hasAttribute("data-so-multiple-style")) {
        this.options.multipleStyle = el.getAttribute("data-so-multiple-style");
      }
      if (this.options.selectionStyle !== "default") {
        this.addClass(`so-dropdown-selection-${this.options.selectionStyle}`);
      }
      if (this.options.multiple) {
        this.addClass("so-dropdown-multiple");
        if (this.options.multipleStyle === "checkbox") {
          this._initCheckboxes();
        } else if (this.options.multipleStyle === "check") {
          this.addClass("so-dropdown-multiple-check");
        }
      }
      if (el.hasAttribute("data-so-show-actions")) {
        this.options.showActions = el.getAttribute("data-so-show-actions") !== "false";
      }
      if (el.hasAttribute("data-so-select-all-text")) {
        this.options.selectAllText = el.getAttribute("data-so-select-all-text");
      }
      if (el.hasAttribute("data-so-select-none-text")) {
        this.options.selectNoneText = el.getAttribute("data-so-select-none-text");
      }
      if (this.options.multiple && this.options.showActions) {
        this._createActionsBar();
      }
      if (el.hasAttribute("data-so-all-selected-text")) {
        this.options.allSelectedText = el.getAttribute("data-so-all-selected-text");
      }
      if (el.hasAttribute("data-so-multiple-selected-text")) {
        this.options.multipleSelectedText = el.getAttribute("data-so-multiple-selected-text");
      }
    }
    /**
     * Initialize checkbox elements for multiple selection items
     * @private
     */
    _initCheckboxes() {
      const itemSelector = this._getItemSelector();
      const items = this.$$(itemSelector);
      items.forEach((item) => {
        if (item.querySelector(".so-checkbox-box"))
          return;
        const checkboxBox = document.createElement("span");
        checkboxBox.className = "so-checkbox-box";
        checkboxBox.innerHTML = '<span class="material-icons">check</span>';
        item.insertBefore(checkboxBox, item.firstChild);
      });
    }
    /**
     * Create actions bar with Select All / Select None links
     * @private
     */
    _createActionsBar() {
      if (!this._menu)
        return;
      if (this._menu.querySelector(".so-dropdown-actions"))
        return;
      const actionsBar = document.createElement("div");
      actionsBar.className = "so-dropdown-actions";
      const selectAllLink = document.createElement("button");
      selectAllLink.type = "button";
      selectAllLink.className = "so-dropdown-action so-dropdown-select-all";
      selectAllLink.textContent = this.options.selectAllText;
      selectAllLink.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.selectAll();
      });
      const separator = document.createElement("span");
      separator.className = "so-dropdown-action-separator";
      separator.textContent = "|";
      const selectNoneLink = document.createElement("button");
      selectNoneLink.type = "button";
      selectNoneLink.className = "so-dropdown-action so-dropdown-select-none";
      selectNoneLink.textContent = this.options.selectNoneText;
      selectNoneLink.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.selectNone();
      });
      actionsBar.appendChild(selectAllLink);
      if (this.options.selectNoneText) {
        actionsBar.appendChild(separator);
        actionsBar.appendChild(selectNoneLink);
      }
      const searchBox = this._menu.querySelector(".so-searchable-search, .so-dropdown-search");
      if (searchBox) {
        searchBox.after(actionsBar);
      } else {
        this._menu.insertBefore(actionsBar, this._menu.firstChild);
      }
      this._actionsBar = actionsBar;
      this._selectAllLink = selectAllLink;
      this._selectNoneLink = selectNoneLink;
    }
    /**
     * Detect dropdown type based on classes
     * @returns {string} Dropdown type
     * @private
     */
    _detectType() {
      if (this.hasClass("so-searchable-dropdown"))
        return "searchable";
      if (this.hasClass("so-options-dropdown"))
        return "options";
      if (this.hasClass("so-outlet-dropdown"))
        return "outlet";
      return "standard";
    }
    /**
     * Cache DOM elements based on type
     * @private
     */
    _cacheElements() {
      switch (this._type) {
        case "searchable":
          this._trigger = this.$(".so-searchable-trigger");
          this._menu = this.$(".so-searchable-menu");
          this._searchInput = this.$(".so-searchable-input");
          this._itemsList = this.$(".so-searchable-items");
          this._selectedEl = this.$(".so-searchable-selected");
          break;
        case "options":
          this._trigger = this.$(".so-options-trigger");
          this._menu = this.$(".so-options-menu");
          break;
        case "outlet":
          this._trigger = this.$(".so-outlet-dropdown-trigger");
          this._menu = this.$(".so-outlet-dropdown-menu");
          this._searchInput = this.$(".so-outlet-dropdown-search input");
          this._itemsList = this.$(".so-outlet-dropdown-list");
          this._selectedEl = this.$(".outlet-text");
          break;
        default:
          this._trigger = this.$(".so-dropdown-trigger") || this.$(".so-dropdown-toggle") || this.$(".so-btn");
          this._menu = this.$(".so-dropdown-menu");
          this._selectedEl = this.$(".so-dropdown-selected");
          this._searchInput = this.$(".so-dropdown-search-input");
          this._itemsList = this.$(".so-dropdown-items");
      }
    }
    /**
     * Get initial selection from DOM
     * @private
     */
    _getInitialSelection() {
      var _a;
      const selectedItems = ((_a = this._menu) == null ? void 0 : _a.querySelectorAll(".so-selected, .so-active")) || [];
      selectedItems.forEach((item) => {
        const value = item.dataset.value;
        const text = this._getItemText(item);
        if (value !== void 0) {
          this._selectedValues.push(value);
          this._selectedTexts.push(text);
        }
      });
    }
    /**
     * Bind event listeners
     * @private
     */
    _bindEvents() {
      if (this._trigger) {
        this.on("click", this._handleTriggerClick, this._trigger);
      }
      const itemSelector = this._getItemSelector();
      const itemsContainer = this._itemsList || this._menu;
      if (itemSelector && itemsContainer) {
        this._itemClickHandler = (e) => {
          const item = e.target.closest(itemSelector);
          if (item && itemsContainer.contains(item)) {
            this._handleItemClick(e, item);
          }
        };
        this._itemsContainer = itemsContainer;
        itemsContainer.addEventListener("click", this._itemClickHandler);
      }
      if (this._searchInput) {
        this.on("input", this._handleSearch, this._searchInput);
        this.on("click", (e) => e.stopPropagation(), this._searchInput);
      }
      if (this._menu) {
        this.on("click", (e) => {
          if (this.options.autoClose !== "outside") {
            e.stopPropagation();
          }
        }, this._menu);
      }
      if (this.options.closeOnOutsideClick) {
        this.on("click", this._handleOutsideClick, document);
      }
      this.on("keydown", this._handleKeydown, this.element);
    }
    /**
     * Get item selector based on type
     * @returns {string} CSS selector
     * @private
     */
    _getItemSelector() {
      switch (this._type) {
        case "searchable":
          return ".so-searchable-item";
        case "options":
          return ".so-options-item";
        case "outlet":
          return ".so-outlet-dropdown-item";
        default:
          return ".so-dropdown-item";
      }
    }
    /**
     * Handle trigger click
     * @param {Event} e - Click event
     * @private
     */
    _handleTriggerClick(e) {
      e.preventDefault();
      e.stopPropagation();
      if (this._disabled)
        return;
      this._closeOtherDropdowns();
      if (this._type === "options" && !this._isOpen) {
        this._positionMenu();
      }
      this.toggle();
    }
    /**
     * Handle item click
     * @param {Event} e - Click event
     * @param {Element} item - Clicked item
     * @private
     */
    _handleItemClick(e, item) {
      var _a;
      e.stopPropagation();
      if (item.classList.contains("so-disabled") || item.hasAttribute("disabled") || item.getAttribute("aria-disabled") === "true") {
        return;
      }
      if (this._type === "options") {
        const action = item.dataset.action;
        this.emit(_SODropdown.EVENTS.ACTION, { action, element: item });
        if (this._shouldCloseOnItemClick()) {
          this.close();
        }
        return;
      }
      const text = this._type === "outlet" ? ((_a = item.querySelector(".outlet-item-text")) == null ? void 0 : _a.textContent.trim()) || this._getItemText(item) : this._getItemText(item);
      const value = item.dataset.value !== void 0 ? item.dataset.value : text;
      if (this.options.multiple) {
        this.toggleSelect(value, text, item);
      } else {
        this.select(value, text, item);
      }
      if (!this.options.multiple && this._shouldCloseOnItemClick()) {
        this.close();
      }
    }
    /**
     * Check if dropdown should close on item click based on autoClose
     * @returns {boolean}
     * @private
     */
    _shouldCloseOnItemClick() {
      const autoClose = this.options.autoClose;
      return this.options.closeOnSelect && (autoClose === true || autoClose === "inside");
    }
    /**
     * Handle search input
     * @param {Event} e - Input event
     * @private
     */
    _handleSearch(e) {
      const query = e.target.value.toLowerCase().trim();
      this._filterItems(query);
      this.emit(_SODropdown.EVENTS.SEARCH, { query });
    }
    /**
     * Filter items by search query
     * @param {string} query - Search query
     * @private
     */
    _filterItems(query) {
      this._originalItems.forEach((item) => {
        const text = this._getItemText(item).toLowerCase();
        const matches = !query || text.includes(query);
        item.style.display = matches ? "" : "none";
      });
    }
    /**
     * Get clean text from an item, excluding check icons and checkbox elements
     * @param {Element} item - Item element
     * @returns {string} Clean text content
     * @private
     */
    _getItemText(item) {
      const clone = item.cloneNode(true);
      clone.querySelectorAll(".so-dropdown-check, .check-icon, .so-checkbox-box").forEach((el) => el.remove());
      return clone.textContent.trim();
    }
    /**
     * Handle outside click based on autoClose option
     * @param {Event} e - Click event
     * @private
     */
    _handleOutsideClick(e) {
      if (!this._isOpen)
        return;
      if (this._ignoreOutsideClick)
        return;
      if (this.element.contains(e.target))
        return;
      const dropdownTrigger = e.target.closest('.so-dropdown-trigger, .so-searchable-trigger, .so-options-trigger, .so-outlet-dropdown-trigger, .so-btn[data-so-toggle="dropdown"]');
      const dropdownElement = e.target.closest(".so-dropdown, .so-searchable-dropdown, .so-options-dropdown, .so-outlet-dropdown");
      if (dropdownTrigger || dropdownElement)
        return;
      const navbarDropdownBtn = e.target.closest(".so-navbar-user-btn, .so-navbar-apps-btn, .so-navbar-outlet-btn, .so-navbar-status-btn, .so-navbar-theme-btn");
      const navbarDropdown = e.target.closest(".so-navbar-user-dropdown, .so-navbar-apps, .so-navbar-outlet-dropdown, .so-navbar-status-dropdown, .so-navbar-theme-dropdown");
      if (navbarDropdownBtn || navbarDropdown)
        return;
      const autoClose = this.options.autoClose;
      if (autoClose === false)
        return;
      if (autoClose === "inside")
        return;
      this.close();
    }
    /**
     * Handle keyboard navigation
     * @param {KeyboardEvent} e - Keyboard event
     * @private
     */
    _handleKeydown(e) {
      var _a;
      if (e.key === "Escape" && this._isOpen) {
        e.preventDefault();
        this.close();
        (_a = this._trigger) == null ? void 0 : _a.focus();
        return;
      }
      if (e.key === "ArrowDown" && !this._isOpen) {
        e.preventDefault();
        this.open();
        return;
      }
      if (this._isOpen) {
        const items = this._getNavigableItems();
        if (e.key === "ArrowDown") {
          e.preventDefault();
          this._focusNextItem(items, 1);
        } else if (e.key === "ArrowUp") {
          e.preventDefault();
          this._focusNextItem(items, -1);
        } else if (e.key === "Enter" || e.key === " ") {
          e.preventDefault();
          if (this._focusedIndex >= 0 && items[this._focusedIndex]) {
            items[this._focusedIndex].click();
          }
        } else if (e.key === "Home") {
          e.preventDefault();
          this._focusItem(items, 0);
        } else if (e.key === "End") {
          e.preventDefault();
          this._focusItem(items, items.length - 1);
        }
      }
    }
    /**
     * Get all navigable (non-disabled) items
     * @returns {Element[]} Array of navigable items
     * @private
     */
    _getNavigableItems() {
      const selector = this._getItemSelector();
      return this.$$(selector).filter(
        (item) => !item.classList.contains("so-disabled") && !item.hasAttribute("disabled") && item.getAttribute("aria-disabled") !== "true" && !item.classList.contains("so-dropdown-header") && !item.classList.contains("so-dropdown-divider") && item.style.display !== "none"
      );
    }
    /**
     * Focus next/previous item in the list
     * @param {Element[]} items - Navigable items
     * @param {number} direction - 1 for next, -1 for previous
     * @private
     */
    _focusNextItem(items, direction) {
      if (items.length === 0)
        return;
      let newIndex = this._focusedIndex + direction;
      if (newIndex < 0)
        newIndex = items.length - 1;
      if (newIndex >= items.length)
        newIndex = 0;
      this._focusItem(items, newIndex);
    }
    /**
     * Focus a specific item by index
     * @param {Element[]} items - Navigable items
     * @param {number} index - Item index
     * @private
     */
    _focusItem(items, index) {
      const allItems = this.$$(this._getItemSelector());
      allItems.forEach((item) => item.classList.remove("so-focused"));
      this._focusedIndex = index;
      if (items[index]) {
        items[index].classList.add("so-focused");
        items[index].scrollIntoView({ block: "nearest" });
      }
    }
    /**
     * Clear focused item state
     * @private
     */
    _clearFocusedItem() {
      const items = this.$$(this._getItemSelector());
      items.forEach((item) => item.classList.remove("so-focused"));
      this._focusedIndex = -1;
    }
    /**
     * Close other open dropdowns
     * @private
     */
    _closeOtherDropdowns() {
      document.querySelectorAll(".so-dropdown.so-open, .so-searchable-dropdown.so-open, .so-options-dropdown.so-open, .so-outlet-dropdown.so-open").forEach((dropdown) => {
        if (dropdown !== this.element) {
          const instance = _SODropdown.getInstance(dropdown);
          if (instance && instance._isOpen) {
            instance._isOpen = false;
            instance.removeClass("so-open", "position-left", "position-top");
            instance._removeDirectionClasses();
          } else {
            dropdown.classList.remove("so-open", "position-left", "position-top");
            dropdown.classList.remove("so-dropup", "so-dropstart", "so-dropend", "so-dropdown-menu-end");
          }
        }
      });
      document.dispatchEvent(new CustomEvent("closeNavbarDropdowns"));
    }
    /**
     * Apply direction and alignment classes
     * @private
     */
    _applyDirectionClasses() {
      const direction = this.options.direction;
      const alignment = this.options.alignment;
      if (direction === "up" && !this._originalClasses.dropup)
        this.addClass("so-dropup");
      if (direction === "start" && !this._originalClasses.dropstart)
        this.addClass("so-dropstart");
      if (direction === "end" && !this._originalClasses.dropend)
        this.addClass("so-dropend");
      if (alignment === "end" && !this._originalClasses.menuEnd)
        this.addClass("so-dropdown-menu-end");
    }
    /**
     * Remove direction and alignment classes (only those added dynamically, not via HTML)
     * @private
     */
    _removeDirectionClasses() {
      if (!this._originalClasses.dropup)
        this.removeClass("so-dropup");
      if (!this._originalClasses.dropstart)
        this.removeClass("so-dropstart");
      if (!this._originalClasses.dropend)
        this.removeClass("so-dropend");
      if (!this._originalClasses.menuEnd)
        this.removeClass("so-dropdown-menu-end");
    }
    /**
     * Position options dropdown menu
     * @private
     */
    _positionMenu() {
      if (this._type !== "options")
        return;
      this.removeClass("position-left", "position-top");
      const triggerRect = this._trigger.getBoundingClientRect();
      const menuWidth = this._menu.offsetWidth || 180;
      const menuHeight = this._menu.offsetHeight || 150;
      const viewportWidth = window.innerWidth;
      const viewportHeight = window.innerHeight;
      const spaceRight = viewportWidth - triggerRect.right;
      const spaceBottom = viewportHeight - triggerRect.bottom;
      const spaceTop = triggerRect.top;
      if (spaceRight >= menuWidth) {
        this.addClass("position-left");
      }
      if (spaceBottom < menuHeight + 10 && spaceTop > menuHeight + 10) {
        this.addClass("position-top");
      }
    }
    // ============================================
    // PUBLIC API
    // ============================================
    /**
     * Open the dropdown
     * @returns {this} For chaining
     */
    open() {
      if (this._isOpen || this._disabled)
        return this;
      const showAllowed = this.emit(_SODropdown.EVENTS.SHOW, {}, true, true);
      if (!showAllowed)
        return this;
      this._isOpen = true;
      this.addClass("so-open");
      this._applyDirectionClasses();
      this._focusedIndex = -1;
      this._ignoreOutsideClick = true;
      setTimeout(() => {
        this._ignoreOutsideClick = false;
      }, 10);
      if (this._searchInput) {
        setTimeout(() => this._searchInput.focus(), 50);
      }
      setTimeout(() => {
        this.emit(_SODropdown.EVENTS.SHOWN);
      }, 150);
      return this;
    }
    /**
     * Close the dropdown
     * @returns {this} For chaining
     */
    close() {
      if (!this._isOpen)
        return this;
      const hideAllowed = this.emit(_SODropdown.EVENTS.HIDE, {}, true, true);
      if (!hideAllowed)
        return this;
      this._isOpen = false;
      this.removeClass("so-open");
      this._clearFocusedItem();
      if (this._searchInput) {
        this._searchInput.value = "";
        this._filterItems("");
      }
      setTimeout(() => {
        this.removeClass("position-left", "position-top");
        this._removeDirectionClasses();
        this.emit(_SODropdown.EVENTS.HIDDEN);
      }, 150);
      return this;
    }
    /**
     * Toggle the dropdown
     * @returns {this} For chaining
     */
    toggle() {
      return this._isOpen ? this.close() : this.open();
    }
    /**
     * Select an option (single selection mode)
     * @param {string} value - Option value
     * @param {string} [text] - Display text
     * @param {Element} [clickedItem] - Clicked item element
     * @returns {this} For chaining
     */
    select(value, text, clickedItem = null) {
      const previousValues = [...this._selectedValues];
      this._selectedValues = [value];
      this._selectedTexts = [text];
      if (this._selectedEl) {
        this._selectedEl.textContent = text;
      }
      const itemSelector = this._getItemSelector();
      this.$$(itemSelector).forEach((item) => {
        const isSelected = clickedItem ? item === clickedItem : item.dataset.value !== void 0 ? item.dataset.value === value : this._getItemText(item) === value;
        item.classList.toggle("so-selected", isSelected);
        item.classList.toggle("so-active", isSelected);
      });
      this.emit(_SODropdown.EVENTS.CHANGE, {
        value,
        text,
        values: this._selectedValues,
        texts: this._selectedTexts,
        previousValues
      });
      return this;
    }
    /**
     * Toggle selection for multiple mode
     * @param {string} value - Option value
     * @param {string} text - Display text
     * @param {Element} item - Item element
     * @returns {this} For chaining
     */
    toggleSelect(value, text, item) {
      const previousValues = [...this._selectedValues];
      const index = this._selectedValues.indexOf(value);
      if (index > -1) {
        const minSelections = this.options.minSelections || 0;
        if (this._selectedValues.length <= minSelections) {
          return this;
        }
        this._selectedValues.splice(index, 1);
        this._selectedTexts.splice(index, 1);
        item.classList.remove("so-selected", "so-active");
      } else {
        if (this.options.maxSelections && this._selectedValues.length >= this.options.maxSelections) {
          return this;
        }
        this._selectedValues.push(value);
        this._selectedTexts.push(text);
        item.classList.add("so-selected", "so-active");
      }
      this._updateMultipleDisplay();
      this.emit(_SODropdown.EVENTS.CHANGE, {
        value,
        text,
        values: this._selectedValues,
        texts: this._selectedTexts,
        previousValues,
        action: index > -1 ? "deselect" : "select"
      });
      return this;
    }
    /**
     * Update display text for multiple selection
     * @private
     */
    _updateMultipleDisplay() {
      if (!this._selectedEl)
        return;
      const count = this._selectedValues.length;
      const totalItems = this._getTotalSelectableItems();
      if (count === 0) {
        this._selectedEl.textContent = this.options.placeholder;
        this._selectedEl.classList.add("so-placeholder");
      } else if (count === totalItems && this.options.allSelectedText) {
        this._selectedEl.textContent = this.options.allSelectedText;
        this._selectedEl.classList.remove("so-placeholder");
      } else if (count === 1) {
        this._selectedEl.textContent = this._selectedTexts[0];
        this._selectedEl.classList.remove("so-placeholder");
      } else {
        this._selectedEl.textContent = this.options.multipleSelectedText.replace("{count}", count);
        this._selectedEl.classList.remove("so-placeholder");
      }
    }
    /**
     * Get total number of selectable (non-disabled) items
     * @returns {number} Total selectable items
     * @private
     */
    _getTotalSelectableItems() {
      const itemSelector = this._getItemSelector();
      return this.$$(itemSelector).filter(
        (item) => !item.classList.contains("so-disabled") && !item.hasAttribute("disabled") && item.getAttribute("aria-disabled") !== "true"
      ).length;
    }
    /**
     * Get selected value (returns first for multiple, or single value)
     * @returns {string|null} Selected value
     */
    getValue() {
      return this._selectedValues[0] || null;
    }
    /**
     * Get all selected values (for multiple selection)
     * @returns {string[]} Array of selected values
     */
    getValues() {
      return [...this._selectedValues];
    }
    /**
     * Get selected text (returns first for multiple, or single text)
     * @returns {string|null} Selected text
     */
    getText() {
      return this._selectedTexts[0] || null;
    }
    /**
     * Get all selected texts (for multiple selection)
     * @returns {string[]} Array of selected texts
     */
    getTexts() {
      return [...this._selectedTexts];
    }
    /**
     * Clear all selections
     * @returns {this} For chaining
     */
    clearSelection() {
      const previousValues = [...this._selectedValues];
      this._selectedValues = [];
      this._selectedTexts = [];
      const itemSelector = this._getItemSelector();
      this.$$(itemSelector).forEach((item) => {
        item.classList.remove("so-selected", "so-active");
      });
      if (this.options.multiple) {
        this._updateMultipleDisplay();
      } else if (this._selectedEl) {
        this._selectedEl.textContent = this.options.placeholder;
        this._selectedEl.classList.add("so-placeholder");
      }
      this.emit(_SODropdown.EVENTS.CHANGE, {
        value: null,
        text: null,
        values: [],
        texts: [],
        previousValues,
        action: "clear"
      });
      return this;
    }
    /**
     * Select all items (for multiple selection mode)
     * @returns {this} For chaining
     */
    selectAll() {
      if (!this.options.multiple)
        return this;
      const previousValues = [...this._selectedValues];
      const itemSelector = this._getItemSelector();
      const items = this.$$(itemSelector);
      this._selectedValues = [];
      this._selectedTexts = [];
      items.forEach((item) => {
        if (item.classList.contains("so-disabled") || item.hasAttribute("disabled") || item.getAttribute("aria-disabled") === "true") {
          return;
        }
        if (item.style.display === "none") {
          return;
        }
        const text = this._getItemText(item);
        const value = item.dataset.value !== void 0 ? item.dataset.value : text;
        if (this.options.maxSelections && this._selectedValues.length >= this.options.maxSelections) {
          return;
        }
        this._selectedValues.push(value);
        this._selectedTexts.push(text);
        item.classList.add("so-selected", "so-active");
      });
      this._updateMultipleDisplay();
      this.emit(_SODropdown.EVENTS.CHANGE, {
        value: this._selectedValues[0] || null,
        text: this._selectedTexts[0] || null,
        values: this._selectedValues,
        texts: this._selectedTexts,
        previousValues,
        action: "selectAll"
      });
      return this;
    }
    /**
     * Deselect all items (alias for clearSelection, for multiple selection mode)
     * @returns {this} For chaining
     */
    selectNone() {
      if (!this.options.multiple)
        return this;
      const minSelections = this.options.minSelections || 0;
      if (minSelections > 0) {
        return this;
      }
      const previousValues = [...this._selectedValues];
      this._selectedValues = [];
      this._selectedTexts = [];
      const itemSelector = this._getItemSelector();
      this.$$(itemSelector).forEach((item) => {
        item.classList.remove("so-selected", "so-active");
      });
      this._updateMultipleDisplay();
      this.emit(_SODropdown.EVENTS.CHANGE, {
        value: null,
        text: null,
        values: [],
        texts: [],
        previousValues,
        action: "selectNone"
      });
      return this;
    }
    /**
     * Check if dropdown is open
     * @returns {boolean} Open state
     */
    isOpen() {
      return this._isOpen;
    }
    /**
     * Update dropdown position (for dynamic content)
     * @returns {this} For chaining
     */
    update() {
      if (this._isOpen) {
        this._positionMenu();
      }
      return this;
    }
    /**
     * Disable the dropdown
     * @returns {this} For chaining
     */
    disable() {
      this._disabled = true;
      this.addClass("so-disabled");
      if (this._trigger) {
        this._trigger.setAttribute("disabled", "");
        this._trigger.setAttribute("aria-disabled", "true");
      }
      if (this._isOpen) {
        this.close();
      }
      return this;
    }
    /**
     * Enable the dropdown
     * @returns {this} For chaining
     */
    enable() {
      this._disabled = false;
      this.removeClass("so-disabled");
      if (this._trigger) {
        this._trigger.removeAttribute("disabled");
        this._trigger.removeAttribute("aria-disabled");
      }
      return this;
    }
    /**
     * Check if dropdown is disabled
     * @returns {boolean} Disabled state
     */
    isDisabled() {
      return this._disabled;
    }
    /**
     * Enable or disable a specific item
     * @param {string|number} identifier - Value or index of item
     * @param {boolean} disabled - Whether to disable
     * @returns {this} For chaining
     */
    setItemDisabled(identifier, disabled = true) {
      const items = this.$$(this._getItemSelector());
      const item = typeof identifier === "number" ? items[identifier] : items.find((i) => i.dataset.value === identifier);
      if (item) {
        item.classList.toggle("so-disabled", disabled);
        if (disabled) {
          item.setAttribute("aria-disabled", "true");
        } else {
          item.removeAttribute("aria-disabled");
        }
      }
      return this;
    }
    // ============================================
    // STATIC FACTORY METHODS
    // ============================================
    /**
     * Create a standard dropdown programmatically
     * @param {Object} options - Dropdown configuration
     * @returns {HTMLElement} Created dropdown element
     */
    static create(options = {}) {
      const { placeholder = "Select option", items = [], className = "" } = options;
      const dropdown = document.createElement("div");
      dropdown.className = `so-dropdown ${className}`.trim();
      const selectedItem = items.find((i) => i.selected);
      dropdown.innerHTML = `
      <button type="button" class="so-dropdown-trigger">
        <span class="so-dropdown-selected">${(selectedItem == null ? void 0 : selectedItem.label) || placeholder}</span>
        <span class="material-icons so-dropdown-arrow">expand_more</span>
      </button>
      <div class="so-dropdown-menu">
        ${items.map((item) => `
          <div class="so-dropdown-item ${item.selected ? "so-selected" : ""} ${item.disabled ? "so-disabled" : ""}"
               data-value="${item.value}"
               ${item.disabled ? 'aria-disabled="true"' : ""}>
            ${item.icon ? `<span class="material-icons">${item.icon}</span>` : ""}
            ${item.label}
          </div>
        `).join("")}
      </div>
    `;
      return dropdown;
    }
    /**
     * Create a searchable dropdown programmatically
     * @param {Object} options - Dropdown configuration
     * @returns {HTMLElement} Created dropdown element
     */
    static createSearchable(options = {}) {
      const {
        placeholder = "Select option",
        searchPlaceholder = "Search...",
        items = [],
        className = ""
      } = options;
      const dropdown = document.createElement("div");
      dropdown.className = `so-searchable-dropdown ${className}`.trim();
      const selectedItem = items.find((i) => i.selected);
      dropdown.innerHTML = `
      <button type="button" class="so-searchable-trigger">
        <span class="so-searchable-selected">${(selectedItem == null ? void 0 : selectedItem.label) || placeholder}</span>
        <span class="material-icons so-dropdown-arrow">expand_more</span>
      </button>
      <div class="so-searchable-menu">
        <div class="so-searchable-search">
          <span class="material-icons">search</span>
          <input type="text" class="so-searchable-input" placeholder="${searchPlaceholder}">
        </div>
        <div class="so-searchable-items">
          ${items.map((item) => `
            <div class="so-searchable-item ${item.selected ? "so-selected" : ""} ${item.disabled ? "so-disabled" : ""}"
                 data-value="${item.value}"
                 ${item.disabled ? 'aria-disabled="true"' : ""}>
              ${item.label}
            </div>
          `).join("")}
        </div>
      </div>
    `;
      return dropdown;
    }
    /**
     * Create an options dropdown programmatically
     * @param {Object} options - Dropdown configuration
     * @returns {HTMLElement} Created dropdown element
     */
    static createOptions(options = {}) {
      const { icon = "more_vert", items = [], className = "" } = options;
      const dropdown = document.createElement("div");
      dropdown.className = `so-options-dropdown ${className}`.trim();
      dropdown.innerHTML = `
      <button type="button" class="so-options-trigger">
        <span class="material-icons">${icon}</span>
      </button>
      <div class="so-options-menu">
        ${items.map((item) => {
        if (item.divider) {
          return '<div class="so-options-divider"></div>';
        }
        if (item.header) {
          return `<div class="so-dropdown-header">${item.header}</div>`;
        }
        return `
            <div class="so-options-item ${item.danger ? "so-danger" : ""} ${item.disabled ? "so-disabled" : ""}"
                 data-action="${item.action || ""}"
                 ${item.disabled ? 'aria-disabled="true"' : ""}>
              ${item.icon ? `<span class="material-icons">${item.icon}</span>` : ""}
              <span>${item.label}</span>
            </div>
          `;
      }).join("")}
      </div>
    `;
      return dropdown;
    }
  };
  __publicField(_SODropdown, "NAME", "dropdown");
  __publicField(_SODropdown, "DEFAULTS", {
    closeOnSelect: true,
    closeOnOutsideClick: true,
    openOnFocus: false,
    searchable: false,
    placeholder: "Select option",
    searchPlaceholder: "Search...",
    noResultsText: "No results found",
    // New options
    autoClose: true,
    // true, false, 'inside', 'outside'
    direction: "down",
    // down, up, start, end
    alignment: "start",
    // start, end
    // Selection options
    selectionStyle: "default",
    // 'default' (bg + check), 'highlight' (bg only), 'check' (check only)
    multiple: false,
    // Allow multiple selections
    multipleStyle: "checkbox",
    // 'checkbox' (adds checkbox boxes), 'check' (uses checkmark icons)
    maxSelections: null,
    // Max selections allowed (null = unlimited)
    minSelections: null,
    // Min selections required (null = 0, can deselect all)
    showActions: false,
    // Show "Select All" / "Select None" links for multiple selection
    selectAllText: "All",
    // Text for select all link
    selectNoneText: "None",
    // Text for select none link
    allSelectedText: null,
    // Text to show when all items are selected (e.g., "All Outlets")
    multipleSelectedText: "{count} selected"
    // Text template for multiple selections
  });
  __publicField(_SODropdown, "EVENTS", {
    // Before/After show events (Bootstrap pattern)
    SHOW: "dropdown:show",
    // Before opening (cancelable)
    SHOWN: "dropdown:shown",
    // After opened
    HIDE: "dropdown:hide",
    // Before closing (cancelable)
    HIDDEN: "dropdown:hidden",
    // After closed
    // Other events
    CHANGE: "dropdown:change",
    SEARCH: "dropdown:search",
    ACTION: "dropdown:action"
  });
  var SODropdown = _SODropdown;
  SODropdown.register();
  window.SODropdown = SODropdown;

  // src/js/components/so-layout.js
  var _SONavbar = class _SONavbar extends so_component_default {
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
      const searchInput = this.$(this.options.searchInputSelector);
      const searchWrapper = (searchInput == null ? void 0 : searchInput.closest(".so-navbar-search-wrapper")) || (searchInput == null ? void 0 : searchInput.closest(".so-navbar-search"));
      if (searchWrapper) {
        this.on("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
          if (window.soSearchOverlay) {
            window.soSearchOverlay.open();
          }
        }, searchWrapper);
      }
      const userBtn = this.$(this.options.userBtnSelector);
      const userDropdown = this.$(this.options.userDropdownSelector);
      if (userBtn && userDropdown) {
        this.on("click", (e) => {
          e.stopPropagation();
          this._toggleDropdown(userDropdown, "user", "so-active");
        }, userBtn);
        const menuItems = userDropdown.querySelectorAll(".so-navbar-user-menu-item");
        menuItems.forEach((item) => {
          this.on("click", (e) => {
            e.stopPropagation();
            this._closeNavbarDropdowns();
          }, item);
        });
      }
      const appsContainer = this.$(this.options.appsContainerSelector);
      const appsBtn = this.$(this.options.appsBtnSelector);
      if (appsContainer && appsBtn) {
        this.on("click", (e) => {
          e.stopPropagation();
          this._toggleDropdown(appsContainer, "apps", "so-open");
        }, appsBtn);
      }
      this.on("click", (e) => {
        const isInsideNavbarDropdown = e.target.closest(".so-navbar-outlet-dropdown, .so-navbar-status-dropdown, .so-navbar-theme-dropdown, .so-navbar-user-dropdown, .so-navbar-apps, .so-navbar-apps-dropdown");
        const isInsideSODropdown = e.target.closest(".so-dropdown, .so-searchable-dropdown, .so-options-dropdown, .so-outlet-dropdown");
        const isNavbarTrigger = e.target.closest(".so-navbar-user-btn, .so-navbar-apps-btn, .so-navbar-outlet-btn, .so-navbar-status-btn, .so-navbar-theme-btn");
        const isSODropdownTrigger = e.target.closest('.so-dropdown-trigger, .so-searchable-trigger, .so-options-trigger, .so-outlet-dropdown-trigger, .so-btn[data-so-toggle="dropdown"]');
        if (!isInsideNavbarDropdown && !isInsideSODropdown && !isNavbarTrigger && !isSODropdownTrigger) {
          this.closeAllDropdowns();
        }
      }, document);
      this.on("keydown", (e) => {
        if (e.key === "Escape") {
          this.closeAllDropdowns();
        }
      }, document);
      this.on("closeAllDropdowns", () => this.closeAllDropdowns(), document);
      this.on("closeNavbarDropdowns", () => this._closeNavbarDropdowns(), document);
    }
    /**
     * Initialize outlet selector
     * @private
     */
    _initOutletSelector() {
      const outletBtn = this.$(this.options.outletBtnSelector);
      const outletDropdown = this.$(this.options.outletDropdownSelector);
      if (!outletBtn || !outletDropdown)
        return;
      this.on("click", (e) => {
        e.stopPropagation();
        this._toggleDropdown(outletDropdown, "outlet");
      }, outletBtn);
      outletDropdown.querySelectorAll(".so-navbar-outlet-item").forEach((item) => {
        this.on("click", (e) => {
          var _a;
          e.stopPropagation();
          const value = item.dataset.value;
          const text = ((_a = item.querySelector("span:first-child")) == null ? void 0 : _a.textContent) || item.textContent;
          outletDropdown.querySelectorAll(".so-navbar-outlet-item").forEach((i) => {
            i.classList.toggle("so-selected", i === item);
          });
          const btnText = outletBtn.querySelector(".outlet-text");
          if (btnText)
            btnText.textContent = text;
          this.emit(_SONavbar.EVENTS.OUTLET_CHANGE, { value, text });
          this.closeAllDropdowns();
        }, item);
      });
      const searchInput = outletDropdown.querySelector("input");
      if (searchInput) {
        this.on("input", (e) => {
          const query = e.target.value.toLowerCase();
          outletDropdown.querySelectorAll(".so-navbar-outlet-item").forEach((item) => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(query) ? "" : "none";
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
      const statusContainer = statusBtn == null ? void 0 : statusBtn.closest(".so-navbar-status");
      if (!statusBtn || !statusDropdown || !statusContainer)
        return;
      this.on("click", (e) => {
        e.stopPropagation();
        this._toggleStatusDropdown(statusContainer);
      }, statusBtn);
      statusDropdown.querySelectorAll(".so-navbar-status-option").forEach((option) => {
        this.on("click", (e) => {
          var _a;
          e.stopPropagation();
          const status = option.dataset.status;
          const text = (_a = option.querySelector(".so-navbar-status-option-text > div:first-child")) == null ? void 0 : _a.textContent;
          statusDropdown.querySelectorAll(".so-navbar-status-option").forEach((o) => {
            o.classList.toggle("so-selected", o === option);
          });
          const indicator = statusBtn.querySelector(".so-navbar-status-indicator");
          const textEl = statusBtn.querySelector(".so-navbar-status-text");
          if (indicator) {
            indicator.className = `so-navbar-status-indicator ${status}`;
          }
          if (textEl && text) {
            textEl.textContent = text;
          }
          this.emit(_SONavbar.EVENTS.STATUS_CHANGE, { status, text });
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
      if (!themeBtn || !themeDropdown)
        return;
      this.on("click", (e) => {
        e.stopPropagation();
        this._toggleDropdown(themeDropdown, "theme");
      }, themeBtn);
    }
    /**
     * Initialize keyboard shortcuts button
     * @private
     */
    _initKeyboardShortcuts() {
      const keyboardBtn = this.$(this.options.keyboardBtnSelector);
      if (!keyboardBtn)
        return;
      this.on("click", (e) => {
        e.stopPropagation();
        if (window.soKeyboardShortcuts) {
          window.soKeyboardShortcuts.show();
        } else {
          console.log("Keyboard shortcuts modal not implemented yet");
          alert("Keyboard Shortcuts:\n\nCtrl+K - Open Search\nCtrl+S - New Sales Invoice\nCtrl+P - New Purchase Bill\nCtrl+R - Receipt Entry\nCtrl+Y - Payment Entry\nEsc - Close dialogs");
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
    _toggleDropdown(dropdown, type, activeClass = "so-active") {
      const isActive = dropdown.classList.contains(activeClass);
      this.closeAllDropdowns();
      if (!isActive) {
        dropdown.classList.add(activeClass);
        this._activeDropdown = { dropdown, type };
        this.emit(_SONavbar.EVENTS.DROPDOWN_OPEN, { dropdown, type });
      }
    }
    /**
     * Toggle status dropdown (uses 'open' on parent container)
     * @param {Element} container - Status container element (.so-navbar-status)
     * @private
     */
    _toggleStatusDropdown(container) {
      const isOpen = container.classList.contains("so-open");
      this.closeAllDropdowns();
      if (!isOpen) {
        container.classList.add("so-open");
        this._activeDropdown = { dropdown: container, type: "status" };
        this.emit(_SONavbar.EVENTS.DROPDOWN_OPEN, { dropdown: container, type: "status" });
      }
    }
    /**
     * Close only navbar custom dropdowns (not SODropdown instances)
     * @returns {this} For chaining
     * @private
     */
    _closeNavbarDropdowns() {
      this.$$(".so-navbar-user-dropdown").forEach((dropdown) => {
        dropdown.classList.remove("so-active");
      });
      this.$$(".so-navbar-user-btn").forEach((btn) => {
        btn.classList.remove("so-active");
      });
      const appsContainer = this.$(this.options.appsContainerSelector);
      if (appsContainer) {
        appsContainer.classList.remove("so-open");
      }
      this.$$(".so-navbar-outlet-dropdown").forEach((dropdown) => {
        dropdown.classList.remove("so-active");
      });
      this.$$(".so-navbar-status").forEach((container) => {
        container.classList.remove("so-open");
      });
      this.$$(".so-navbar-theme-dropdown").forEach((dropdown) => {
        dropdown.classList.remove("so-active");
      });
      this._activeDropdown = null;
      return this;
    }
    /**
     * Close all dropdowns (navbar custom + SODropdown instances)
     * @returns {this} For chaining
     */
    closeAllDropdowns() {
      this._closeNavbarDropdowns();
      this.$$(".so-dropdown.so-open").forEach((dropdown) => {
        const instance = so_config_default.getInstance(dropdown, "dropdown");
        if (instance && typeof instance.close === "function") {
          instance.close();
        }
      });
      this.emit(_SONavbar.EVENTS.DROPDOWN_CLOSE);
      return this;
    }
  };
  __publicField(_SONavbar, "NAME", "navbar");
  __publicField(_SONavbar, "DEFAULTS", {
    searchInputSelector: ".so-navbar-search-input",
    userBtnSelector: ".so-navbar-user-btn",
    userDropdownSelector: ".so-navbar-user-dropdown",
    appsBtnSelector: ".so-navbar-apps-btn",
    appsContainerSelector: ".so-navbar-apps",
    outletBtnSelector: ".so-navbar-outlet-btn",
    outletDropdownSelector: ".so-navbar-outlet-dropdown",
    statusBtnSelector: ".so-navbar-status-btn",
    statusDropdownSelector: ".so-navbar-status-dropdown",
    themeBtnSelector: ".so-navbar-theme-btn",
    themeDropdownSelector: ".so-navbar-theme-dropdown",
    keyboardBtnSelector: "#keyboardShortcutsBtn"
  });
  __publicField(_SONavbar, "EVENTS", {
    SEARCH: "navbar:search",
    DROPDOWN_OPEN: "navbar:dropdown:open",
    DROPDOWN_CLOSE: "navbar:dropdown:close",
    OUTLET_CHANGE: "navbar:outlet:change",
    STATUS_CHANGE: "navbar:status:change"
  });
  var SONavbar2 = _SONavbar;
  SONavbar2.register();
  window.SONavbar = SONavbar2;

  // src/js/components/so-modal.js
  var _SOModal = class _SOModal extends so_component_default {
    /**
     * Initialize the modal
     * @private
     */
    _init() {
      this._dialog = this.$(".so-modal-dialog");
      this._content = this.$(".so-modal-content");
      this._header = this.$(".so-modal-header");
      this._backdrop = null;
      this._isOpen = false;
      this._focusTrapCleanup = null;
      this._previousActiveElement = null;
      this._isMaximized = false;
      this._isDragging = false;
      this._dragPosition = { x: 0, y: 0 };
      this._originalSize = null;
      this._resizeObserver = null;
      if (this.element.hasAttribute("data-so-static") || this.element.classList.contains("so-modal-static") || this.options.static === true) {
        this.options.static = true;
        this.options.closable = false;
        this.options.keyboard = false;
        this.element.classList.add("so-modal-static");
      }
      if (this.options.draggable) {
        this._setupDraggable();
      }
      if (this.options.maximizable) {
        this._setupMaximizable();
      }
      if (this.options.mobileFullscreen) {
        this._setupMobileFullscreen();
      }
      if (this.options.sidebar) {
        this._setupSidebar();
      }
      this._bindEvents();
    }
    /**
     * Bind event listeners
     * @private
     */
    _bindEvents() {
      this.delegate("click", '.so-modal-close, [data-dismiss="modal"]', () => {
        if (!this.options.static) {
          this.hide();
        }
      });
      if (this.options.backdrop) {
        this.on("click", (e) => {
          if (e.target === this.element) {
            if (this.options.static) {
              this._shakeModal();
            } else if (this.options.closable) {
              this.hide();
            }
          }
        });
      }
      this.delegate("click", "[data-modal-confirm]", () => {
        this.emit(_SOModal.EVENTS.CONFIRM);
        this.hide();
      });
      this.delegate("click", "[data-modal-cancel]", () => {
        this.emit(_SOModal.EVENTS.CANCEL);
        this.hide();
      });
    }
    /**
     * Shake the modal to indicate it cannot be dismissed
     * @private
     */
    _shakeModal() {
      this._playFeedbackAnimation("shake");
    }
    /**
     * Play a feedback animation on the modal
     * @param {string} type - Animation type: 'shake', 'pulse', 'bounce', 'headshake'
     * @private
     */
    _playFeedbackAnimation(type = "shake") {
      const animationClass = `so-modal-feedback-${type}`;
      this.element.classList.add(animationClass);
      setTimeout(() => {
        this.element.classList.remove(animationClass);
      }, 500);
    }
    // ============================================
    // DRAGGABLE FUNCTIONALITY
    // ============================================
    /**
     * Setup draggable functionality
     * @private
     */
    _setupDraggable() {
      if (!this._header || !this._dialog)
        return;
      this.element.classList.add("so-modal-draggable");
      this._header.style.cursor = "move";
      this._boundDragStart = this._handleDragStart.bind(this);
      this._boundDragMove = this._handleDragMove.bind(this);
      this._boundDragEnd = this._handleDragEnd.bind(this);
      this._header.addEventListener("mousedown", this._boundDragStart);
      this._header.addEventListener("touchstart", this._boundDragStart, { passive: false });
    }
    /**
     * Handle drag start
     * @param {MouseEvent|TouchEvent} e
     * @private
     */
    _handleDragStart(e) {
      if (e.target.closest("button, .so-modal-close, .so-modal-maximize"))
        return;
      if (this._isMaximized)
        return;
      e.preventDefault();
      this._isDragging = true;
      const clientX = e.type.includes("touch") ? e.touches[0].clientX : e.clientX;
      const clientY = e.type.includes("touch") ? e.touches[0].clientY : e.clientY;
      const rect = this._dialog.getBoundingClientRect();
      this._dragOffset = {
        x: clientX - rect.left,
        y: clientY - rect.top
      };
      if (!this._dragPosition.x && !this._dragPosition.y) {
        this._dragPosition = {
          x: rect.left,
          y: rect.top
        };
      }
      this.element.classList.add("so-modal-dragging");
      this.emit(_SOModal.EVENTS.DRAG_START);
      document.addEventListener("mousemove", this._boundDragMove);
      document.addEventListener("mouseup", this._boundDragEnd);
      document.addEventListener("touchmove", this._boundDragMove, { passive: false });
      document.addEventListener("touchend", this._boundDragEnd);
    }
    /**
     * Handle drag move
     * @param {MouseEvent|TouchEvent} e
     * @private
     */
    _handleDragMove(e) {
      if (!this._isDragging)
        return;
      e.preventDefault();
      const clientX = e.type.includes("touch") ? e.touches[0].clientX : e.clientX;
      const clientY = e.type.includes("touch") ? e.touches[0].clientY : e.clientY;
      let newX = clientX - this._dragOffset.x;
      let newY = clientY - this._dragOffset.y;
      const dialogRect = this._dialog.getBoundingClientRect();
      const maxX = window.innerWidth - dialogRect.width;
      const maxY = window.innerHeight - dialogRect.height;
      newX = Math.max(0, Math.min(newX, maxX));
      newY = Math.max(0, Math.min(newY, maxY));
      this._dragPosition = { x: newX, y: newY };
      this._dialog.style.position = "fixed";
      this._dialog.style.margin = "0";
      this._dialog.style.left = `${newX}px`;
      this._dialog.style.top = `${newY}px`;
      this._dialog.style.transform = "none";
    }
    /**
     * Handle drag end
     * @private
     */
    _handleDragEnd() {
      if (!this._isDragging)
        return;
      this._isDragging = false;
      this.element.classList.remove("so-modal-dragging");
      this.emit(_SOModal.EVENTS.DRAG_END);
      document.removeEventListener("mousemove", this._boundDragMove);
      document.removeEventListener("mouseup", this._boundDragEnd);
      document.removeEventListener("touchmove", this._boundDragMove);
      document.removeEventListener("touchend", this._boundDragEnd);
    }
    /**
     * Reset drag position
     * @private
     */
    _resetDragPosition() {
      if (this._dialog) {
        this._dialog.style.position = "";
        this._dialog.style.left = "";
        this._dialog.style.top = "";
        this._dialog.style.margin = "";
        this._dialog.style.transform = "";
      }
      this._dragPosition = { x: 0, y: 0 };
    }
    // ============================================
    // MAXIMIZABLE FUNCTIONALITY
    // ============================================
    /**
     * Setup maximizable functionality
     * @private
     */
    _setupMaximizable() {
      if (!this._header)
        return;
      this.element.classList.add("so-modal-maximizable");
      this._maximizeBtn = this._header.querySelector(".so-modal-maximize");
      if (!this._maximizeBtn) {
        this._maximizeBtn = document.createElement("button");
        this._maximizeBtn.type = "button";
        this._maximizeBtn.className = "so-modal-maximize";
        this._maximizeBtn.innerHTML = '<span class="material-icons">open_in_full</span>';
        this._maximizeBtn.title = "Maximize";
        const closeBtn = this._header.querySelector(".so-modal-close");
        if (closeBtn) {
          closeBtn.parentNode.insertBefore(this._maximizeBtn, closeBtn);
        } else {
          this._header.appendChild(this._maximizeBtn);
        }
      }
      this._maximizeBtn.addEventListener("click", () => this.toggleMaximize());
      if (this.options.draggable) {
        this._header.addEventListener("dblclick", (e) => {
          if (!e.target.closest("button, .so-modal-close, .so-modal-maximize")) {
            this.toggleMaximize();
          }
        });
      }
    }
    /**
     * Maximize the modal
     * @returns {this} For chaining
     */
    maximize() {
      if (this._isMaximized)
        return this;
      this._originalSize = {
        width: this._dialog.style.width,
        height: this._dialog.style.height,
        maxWidth: this._dialog.style.maxWidth,
        maxHeight: this._dialog.style.maxHeight,
        position: this._dialog.style.position,
        left: this._dialog.style.left,
        top: this._dialog.style.top,
        transform: this._dialog.style.transform,
        margin: this._dialog.style.margin,
        borderRadius: this._dialog.style.borderRadius,
        dragPosition: __spreadValues({}, this._dragPosition)
      };
      this._isMaximized = true;
      this.element.classList.add("so-modal-maximized");
      this._dialog.style.width = "100%";
      this._dialog.style.height = "100%";
      this._dialog.style.maxWidth = "100%";
      this._dialog.style.maxHeight = "100%";
      this._dialog.style.position = "fixed";
      this._dialog.style.left = "0";
      this._dialog.style.top = "0";
      this._dialog.style.transform = "none";
      this._dialog.style.margin = "0";
      this._dialog.style.borderRadius = "0";
      if (this._maximizeBtn) {
        this._maximizeBtn.innerHTML = '<span class="material-icons">close_fullscreen</span>';
        this._maximizeBtn.title = "Restore";
      }
      if (this._header && this.options.draggable) {
        this._header.style.cursor = "default";
      }
      this.emit(_SOModal.EVENTS.MAXIMIZE);
      return this;
    }
    /**
     * Restore the modal from maximized state
     * @returns {this} For chaining
     */
    restore() {
      if (!this._isMaximized)
        return this;
      this._isMaximized = false;
      this.element.classList.remove("so-modal-maximized");
      if (this._originalSize) {
        this._dialog.style.width = this._originalSize.width;
        this._dialog.style.height = this._originalSize.height;
        this._dialog.style.maxWidth = this._originalSize.maxWidth;
        this._dialog.style.maxHeight = this._originalSize.maxHeight;
        this._dialog.style.position = this._originalSize.position;
        this._dialog.style.left = this._originalSize.left;
        this._dialog.style.top = this._originalSize.top;
        this._dialog.style.transform = this._originalSize.transform;
        this._dialog.style.margin = this._originalSize.margin;
        this._dialog.style.borderRadius = this._originalSize.borderRadius;
        this._dragPosition = this._originalSize.dragPosition;
      }
      if (this._maximizeBtn) {
        this._maximizeBtn.innerHTML = '<span class="material-icons">open_in_full</span>';
        this._maximizeBtn.title = "Maximize";
      }
      if (this._header && this.options.draggable) {
        this._header.style.cursor = "move";
      }
      this.emit(_SOModal.EVENTS.RESTORE);
      return this;
    }
    /**
     * Toggle between maximized and normal state
     * @returns {this} For chaining
     */
    toggleMaximize() {
      return this._isMaximized ? this.restore() : this.maximize();
    }
    /**
     * Check if modal is maximized
     * @returns {boolean}
     */
    isMaximized() {
      return this._isMaximized;
    }
    // ============================================
    // MOBILE FULLSCREEN
    // ============================================
    /**
     * Setup mobile fullscreen auto-switch
     * @private
     */
    _setupMobileFullscreen() {
      this._checkMobileFullscreen = () => {
        const isMobile = window.innerWidth < this.options.mobileBreakpoint;
        if (isMobile && this._isOpen && !this._isMaximized) {
          this.element.classList.add("so-modal-mobile-fullscreen");
        } else {
          this.element.classList.remove("so-modal-mobile-fullscreen");
        }
      };
      this._resizeObserver = new ResizeObserver(() => {
        this._checkMobileFullscreen();
      });
      this._resizeObserver.observe(document.body);
      this._checkMobileFullscreen();
    }
    // ============================================
    // SIDEBAR LAYOUT
    // ============================================
    /**
     * Setup sidebar layout
     * @private
     */
    _setupSidebar() {
      const position = this.options.sidebar === true ? "left" : this.options.sidebar;
      this.element.classList.add("so-modal-with-sidebar");
      this.element.classList.add(`so-modal-sidebar-${position}`);
      if (this.options.sidebarWidth) {
        this._dialog.style.setProperty("--so-modal-sidebar-width", this.options.sidebarWidth);
      }
    }
    /**
     * Focus the initial element based on focusElement option
     * @private
     */
    _focusInitialElement() {
      if (!this.options.focus)
        return;
      const focusOption = this.options.focusElement;
      let elementToFocus = null;
      if (focusOption === "footer") {
        const footer = this.$(".so-modal-footer");
        if (footer) {
          elementToFocus = footer.querySelector('button, [tabindex]:not([tabindex="-1"]), a[href]');
        }
        if (!elementToFocus) {
          elementToFocus = this.$(".so-modal-close");
        }
      } else if (focusOption === "close") {
        elementToFocus = this.$(".so-modal-close");
      } else if (focusOption === "first") {
        const focusableElements = this.getFocusableElements();
        elementToFocus = focusableElements[0];
      } else if (typeof focusOption === "string" && focusOption) {
        elementToFocus = this.$(focusOption);
      }
      if (!elementToFocus) {
        const focusableElements = this.getFocusableElements();
        elementToFocus = focusableElements[0];
      }
      if (elementToFocus && typeof elementToFocus.focus === "function") {
        elementToFocus.classList.add("so-focus-visible");
        elementToFocus.addEventListener("blur", () => {
          elementToFocus.classList.remove("so-focus-visible");
        }, { once: true });
        elementToFocus.focus();
      }
    }
    /**
     * Handle keyboard events
     * @param {KeyboardEvent} e - Keyboard event
     * @private
     */
    _handleKeydown(e) {
      if (e.key === "Escape" && this._isOpen) {
        const openModals = _SOModal._openModals;
        if (openModals.length > 0 && openModals[openModals.length - 1] === this) {
          e.preventDefault();
          e.stopPropagation();
          if (this.options.static) {
            this._shakeModal();
          } else if (this.options.closable) {
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
      if (!this.options.keyboard)
        return;
      this._boundKeydown = this._handleKeydown.bind(this);
      document.addEventListener("keydown", this._boundKeydown);
    }
    /**
     * Unbind document keyboard listener
     * @private
     */
    _unbindDocumentKeydown() {
      if (this._boundKeydown) {
        document.removeEventListener("keydown", this._boundKeydown);
        this._boundKeydown = null;
      }
    }
    /**
     * Create and show backdrop
     * @private
     */
    _showBackdrop() {
      if (!this.options.backdrop)
        return;
      this._backdrop = document.createElement("div");
      this._backdrop.className = "so-modal-backdrop";
      if (this.options.animation) {
        this._backdrop.classList.add("so-fade");
      }
      const modalIndex = _SOModal._openModals.indexOf(this);
      if (modalIndex > 0) {
        this._backdrop.style.zIndex = _SOModal._baseZIndex + modalIndex * 10 - 1;
      }
      document.body.appendChild(this._backdrop);
      this._backdrop.offsetHeight;
      this._backdrop.classList.add("so-show");
    }
    /**
     * Update z-index for nested modals
     * @private
     */
    _updateZIndex() {
      const modalIndex = _SOModal._openModals.indexOf(this);
      if (modalIndex > 0) {
        const zIndex = _SOModal._baseZIndex + modalIndex * 10;
        this.element.style.zIndex = zIndex;
      }
    }
    /**
     * Reset z-index when modal closes
     * @private
     */
    _resetZIndex() {
      this.element.style.zIndex = "";
    }
    /**
     * Hide and remove backdrop
     * @private
     */
    _hideBackdrop() {
      if (!this._backdrop)
        return;
      this._backdrop.classList.remove("so-show");
      if (this.options.animation) {
        this._backdrop.addEventListener("transitionend", () => {
          var _a;
          (_a = this._backdrop) == null ? void 0 : _a.remove();
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
      if (lock) {
        document.body.classList.add("so-modal-open");
        document.body.style.overflow = "hidden";
      } else if (_SOModal._openModals.length === 0) {
        document.body.classList.remove("so-modal-open");
        document.body.style.overflow = "";
      }
    }
    // ============================================
    // PUBLIC API
    // ============================================
    /**
     * Show the modal
     * @returns {this} For chaining
     */
    show() {
      if (this._isOpen)
        return this;
      if (!this.emit(_SOModal.EVENTS.SHOW)) {
        return this;
      }
      this._isOpen = true;
      this._previousActiveElement = document.activeElement;
      _SOModal._openModals.push(this);
      this._updateZIndex();
      if (this.options.mobileFullscreen) {
        this._checkMobileFullscreen();
      }
      this._showBackdrop();
      this._manageBodyScroll(true);
      this.element.style.display = "flex";
      if (this.options.animation) {
        this.addClass("so-fade");
        this.element.offsetHeight;
      }
      this.addClass("so-show");
      if (this.options.focus) {
        this._focusTrapCleanup = this.trapFocus({ skipInitialFocus: true });
      }
      this._bindDocumentKeydown();
      if (this.options.animation) {
        let shownEmitted = false;
        const handleShown = () => {
          if (shownEmitted)
            return;
          shownEmitted = true;
          if (this.options.focus) {
            this._focusInitialElement();
          }
          this.emit(_SOModal.EVENTS.SHOWN);
        };
        const transitionHandler = (e) => {
          if (e.target === this._dialog) {
            this._dialog.removeEventListener("transitionend", transitionHandler);
            handleShown();
          }
        };
        this._dialog.addEventListener("transitionend", transitionHandler);
        setTimeout(handleShown, 350);
      } else {
        if (this.options.focus) {
          this._focusInitialElement();
        }
        this.emit(_SOModal.EVENTS.SHOWN);
      }
      return this;
    }
    /**
     * Hide the modal
     * @returns {this} For chaining
     */
    hide() {
      if (!this._isOpen)
        return this;
      if (!this.emit(_SOModal.EVENTS.HIDE)) {
        return this;
      }
      this._isOpen = false;
      const index = _SOModal._openModals.indexOf(this);
      if (index > -1) {
        _SOModal._openModals.splice(index, 1);
      }
      if (this._focusTrapCleanup) {
        this._focusTrapCleanup();
        this._focusTrapCleanup = null;
      }
      this._unbindDocumentKeydown();
      this.removeClass("so-show");
      const hideComplete = () => {
        this.element.style.display = "none";
        this._hideBackdrop();
        this._manageBodyScroll(false);
        this._resetZIndex();
        if (this.options.draggable) {
          this._resetDragPosition();
        }
        if (this._isMaximized) {
          this._isMaximized = false;
          this.element.classList.remove("so-modal-maximized");
          if (this._maximizeBtn) {
            this._maximizeBtn.innerHTML = '<span class="material-icons">open_in_full</span>';
          }
        }
        this.element.classList.remove("so-modal-mobile-fullscreen");
        if (this._previousActiveElement && typeof this._previousActiveElement.focus === "function") {
          this._previousActiveElement.focus();
        }
        this.emit(_SOModal.EVENTS.HIDDEN);
      };
      if (this.options.animation && this._dialog) {
        let completed = false;
        const safeHideComplete = () => {
          if (completed)
            return;
          completed = true;
          hideComplete();
        };
        this._dialog.addEventListener("transitionend", safeHideComplete, { once: true });
        setTimeout(safeHideComplete, 350);
      } else {
        hideComplete();
      }
      return this;
    }
    /**
     * Toggle modal visibility
     * @returns {this} For chaining
     */
    toggle() {
      return this._isOpen ? this.hide() : this.show();
    }
    /**
     * Check if modal is open
     * @returns {boolean} Open state
     */
    isOpen() {
      return this._isOpen;
    }
    /**
     * Set modal content
     * @param {string|Element} content - Content to set
     * @returns {this} For chaining
     */
    setContent(content) {
      const body = this.$(".so-modal-body");
      if (!body)
        return this;
      if (typeof content === "string") {
        body.innerHTML = content;
      } else if (content instanceof Element) {
        body.innerHTML = "";
        body.appendChild(content);
      }
      return this;
    }
    /**
     * Set modal title
     * @param {string} title - Title text
     * @returns {this} For chaining
     */
    setTitle(title) {
      const titleEl = this.$(".so-modal-title");
      if (titleEl) {
        titleEl.textContent = title;
      }
      return this;
    }
    // ============================================
    // STATIC METHODS
    // ============================================
    /**
     * Create and show a modal programmatically
     *
     * @param {Object} options - Modal configuration
     * @param {string} options.title - Modal title
     * @param {string} options.content - Modal body content (HTML string)
     * @param {string} options.size - Modal size: 'sm', 'default', 'lg', 'xl', 'fullscreen'
     * @param {boolean} options.closable - Whether modal can be closed
     * @param {string} options.className - Additional CSS classes
     * @param {boolean} options.static - Cannot be dismissed without button click
     * @param {string|Array} options.footer - Footer content (flexible format):
     *   - String: Raw HTML string
     *   - Array: Array of button configs, each can be:
     *     - String: 'Cancel' (text only, outline style)
     *     - Array: [{ icon: 'save' }, 'Save'] (flexible content)
     *     - Object: { content: [...], class: 'so-btn-primary', dismiss: true, onclick: fn }
     * @param {string} options.footerPosition - Footer alignment: 'left', 'center', 'right', 'between', 'around'
     * @param {string} options.footerLayout - Footer layout: 'inline' or 'stacked'
     * @param {string} options.focusElement - Element to focus on open: 'footer' (default), 'close', 'first', or CSS selector
     * @returns {SOModal} Modal instance
     *
     * @example
     * // String footer (legacy)
     * SOModal.create({
     *   title: 'My Modal',
     *   content: '<p>Content here</p>',
     *   footer: '<button class="so-btn so-btn-primary" data-dismiss="modal">OK</button>'
     * });
     *
     * @example
     * // Flexible footer buttons
     * SOModal.create({
     *   title: 'My Modal',
     *   content: '<p>Content here</p>',
     *   footer: [
     *     { content: 'Cancel', class: 'so-btn-outline', dismiss: true },
     *     { content: [{ icon: 'save' }, 'Save'], class: 'so-btn-primary', dismiss: true }
     *   ],
     *   footerPosition: 'right'
     * });
     */
    static create(options = {}) {
      const {
        title = "",
        content = "",
        size = "default",
        closable = true,
        footer = null,
        footerPosition = "right",
        footerLayout = "inline",
        className = "",
        static: isStatic = false,
        focusElement = "footer",
        singleton = false,
        singletonId = null,
        singletonFeedback = "shake",
        // 'shake', 'pulse', 'bounce', 'headshake'
        draggable = false,
        maximizable = false,
        mobileFullscreen = false,
        mobileBreakpoint = 768,
        sidebar = false,
        sidebarWidth = "280px"
      } = options;
      if (singleton) {
        const id = singletonId || `singleton-${title.toLowerCase().replace(/\s+/g, "-")}`;
        const existingInstance = _SOModal._singletonInstances.get(id);
        if (existingInstance && existingInstance._isOpen) {
          existingInstance._playFeedbackAnimation(singletonFeedback);
          return existingInstance;
        }
      }
      const parseButtonContent = (btnContent) => {
        if (typeof btnContent === "string") {
          return btnContent;
        }
        if (Array.isArray(btnContent)) {
          return btnContent.map((part) => {
            if (typeof part === "string") {
              return part;
            }
            if (part && typeof part === "object" && part.icon) {
              return `<span class="material-icons">${part.icon}</span>`;
            }
            return "";
          }).join("");
        }
        return "";
      };
      const createButton = (btnConfig, index) => {
        let content2, btnClass, dismiss, onclick;
        if (typeof btnConfig === "string") {
          content2 = btnConfig;
          btnClass = "so-btn-outline";
          dismiss = true;
        } else if (Array.isArray(btnConfig)) {
          content2 = parseButtonContent(btnConfig);
          btnClass = "so-btn-outline";
          dismiss = true;
        } else if (btnConfig && typeof btnConfig === "object") {
          content2 = parseButtonContent(btnConfig.content || btnConfig.text || "");
          btnClass = btnConfig.class || "so-btn-outline";
          dismiss = btnConfig.dismiss !== false;
          onclick = btnConfig.onclick;
        } else {
          return "";
        }
        const dismissAttr = dismiss ? ' data-dismiss="modal"' : "";
        const onclickAttr = onclick ? ` data-modal-btn-index="${index}"` : "";
        return `<button type="button" class="so-btn ${btnClass}"${dismissAttr}${onclickAttr}>${content2}</button>`;
      };
      const sizeClass = size !== "default" ? `so-modal-${size}` : "";
      const staticClass = isStatic ? "so-modal-static" : "";
      const sidebarClass = sidebar ? `so-modal-with-sidebar so-modal-sidebar-${sidebar === true ? "left" : sidebar}` : "";
      const draggableClass = draggable ? "so-modal-draggable" : "";
      const maximizableClass = maximizable ? "so-modal-maximizable" : "";
      const modal = document.createElement("div");
      modal.className = `so-modal so-fade ${sizeClass} ${staticClass} ${sidebarClass} ${draggableClass} ${maximizableClass} ${className}`.trim().replace(/\s+/g, " ");
      modal.tabIndex = -1;
      if (isStatic) {
        modal.setAttribute("data-so-static", "true");
      }
      let footerHtml = "";
      let buttonOnclicks = [];
      if (footer) {
        if (typeof footer === "string") {
          footerHtml = `
          <div class="so-modal-footer">
            ${footer}
          </div>
        `;
        } else if (Array.isArray(footer)) {
          const positionClassMap = {
            left: "justify-start",
            center: "justify-center",
            right: "justify-end",
            between: "justify-between",
            around: "justify-around"
          };
          const positionClass = positionClassMap[footerPosition] || "justify-end";
          const layoutClass = footerLayout === "stacked" ? "so-flex-column" : "";
          const footerClasses = [positionClass, layoutClass].filter(Boolean).join(" ");
          const buttons = footer.map((btn, i) => {
            if (btn && typeof btn === "object" && btn.onclick) {
              buttonOnclicks.push({ index: i, onclick: btn.onclick });
            }
            return createButton(btn, i);
          });
          footerHtml = `
          <div class="so-modal-footer ${footerClasses}">
            ${buttons.join("\n")}
          </div>
        `;
        } else if (typeof footer === "object" && (footer.left || footer.center || footer.right)) {
          let btnIndex = 0;
          const createSectionButtons = (buttons) => {
            if (!buttons || !Array.isArray(buttons))
              return "";
            return buttons.map((btn) => {
              if (btn && typeof btn === "object" && btn.onclick) {
                buttonOnclicks.push({ index: btnIndex, onclick: btn.onclick });
              }
              return createButton(btn, btnIndex++);
            }).join("\n");
          };
          const leftHtml = footer.left ? `<div class="so-footer-left">${createSectionButtons(footer.left)}</div>` : '<div class="so-footer-left"></div>';
          const centerHtml = footer.center ? `<div class="so-footer-center">${createSectionButtons(footer.center)}</div>` : '<div class="so-footer-center"></div>';
          const rightHtml = footer.right ? `<div class="so-footer-right">${createSectionButtons(footer.right)}</div>` : '<div class="so-footer-right"></div>';
          footerHtml = `
          <div class="so-modal-footer so-footer-sections">
            ${leftHtml}
            ${centerHtml}
            ${rightHtml}
          </div>
        `;
        }
      }
      const showCloseButton = closable && !isStatic;
      let headerButtons = "";
      if (maximizable) {
        headerButtons += '<button type="button" class="so-modal-maximize" title="Maximize"><span class="material-icons">open_in_full</span></button>';
      }
      if (showCloseButton) {
        headerButtons += '<button type="button" class="so-modal-close" data-dismiss="modal"><span class="material-icons">close</span></button>';
      }
      let mainContentHtml = "";
      if (sidebar && typeof content === "object" && content.sidebar !== void 0) {
        const sidebarContent = content.sidebar || "";
        const mainContent = content.main || "";
        mainContentHtml = `
        <div class="so-modal-body so-modal-body-with-sidebar">
          <div class="so-modal-sidebar">${sidebarContent}</div>
          <div class="so-modal-main">${mainContent}</div>
        </div>
      `;
      } else {
        const contentStr = typeof content === "object" ? content.main || "" : content;
        mainContentHtml = `<div class="so-modal-body">${contentStr}</div>`;
      }
      let dialogStyle = "";
      if (sidebar && sidebarWidth) {
        dialogStyle = `style="--so-modal-sidebar-width: ${sidebarWidth}"`;
      }
      modal.innerHTML = `
      <div class="so-modal-dialog" ${dialogStyle}>
        <div class="so-modal-content">
          <div class="so-modal-header"${draggable ? ' style="cursor: move"' : ""}>
            <h5 class="so-modal-title">${title}</h5>
            ${headerButtons}
          </div>
          ${mainContentHtml}
          ${footerHtml}
        </div>
      </div>
    `;
      document.body.appendChild(modal);
      buttonOnclicks.forEach(({ index, onclick }) => {
        const btn = modal.querySelector(`[data-modal-btn-index="${index}"]`);
        if (btn && typeof onclick === "function") {
          btn.addEventListener("click", (e) => onclick(e, btn));
        }
      });
      const instance = new _SOModal(modal, __spreadProps(__spreadValues({}, options), {
        animation: true,
        static: isStatic,
        focusElement,
        draggable,
        maximizable,
        mobileFullscreen,
        mobileBreakpoint,
        sidebar,
        sidebarWidth
      }));
      modal._soModalInstance = instance;
      if (singleton) {
        const id = singletonId || `singleton-${title.toLowerCase().replace(/\s+/g, "-")}`;
        _SOModal._singletonInstances.set(id, instance);
      }
      modal.addEventListener(so_config_default.evt(_SOModal.EVENTS.HIDDEN), () => {
        if (singleton) {
          const id = singletonId || `singleton-${title.toLowerCase().replace(/\s+/g, "-")}`;
          _SOModal._singletonInstances.delete(id);
        }
        modal.remove();
      });
      return instance;
    }
    /**
     * Show a confirmation dialog with flexible button and icon configuration
     *
     * @param {Object} options - Dialog options
     * @param {string} options.title - Dialog title
     * @param {string} options.message - Dialog message
     * @param {Array} options.actions - Array of action objects for multi-action dialogs
     *
     * @param {string|Array|Object} options.confirm - Confirm button (flexible format):
     *   - String: 'Delete' (just text)
     *   - Array: [{ icon: 'delete' }, 'Delete'] (icon + text in order)
     *   - Array: ['Continue', { icon: 'arrow_forward' }] (text + icon)
     *   - Array: [{ icon: 'check' }, 'Save', { icon: 'send' }] (multiple icons)
     *   - Object: { content: [...], class: 'so-btn-danger' } (with class override)
     * @param {string|Array|Object} options.cancel - Cancel button (same format as confirm)
     *
     * @param {string|Object} options.icon - Dialog icon above title:
     *   - String: 'warning' (icon name, type from iconType or auto)
     *   - Object: { name: 'warning', type: 'danger' } (icon with type)
     * @param {string} options.iconType - Icon color: 'danger', 'warning', 'success', 'info'
     *
     * @param {boolean} options.danger - Use danger styling (auto-sets iconType to 'danger')
     * @param {boolean} options.static - Cannot be dismissed without clicking a button
     * @param {string} options.buttonPosition - Footer alignment: 'left', 'center', 'right', 'between', 'around'
     * @param {string} options.buttonLayout - 'inline' (side by side) or 'stacked' (vertical)
     * @param {boolean} options.fullWidthButtons - Make buttons full width
     * @param {boolean} options.reverseButtons - Swap cancel/confirm order
     * @param {boolean} options.showCloseButton - Show X close button in header
     * @param {string} options.focusElement - Element to focus on open: 'footer' (default), 'close', 'first', or CSS selector
     *
     * @param {string} options.confirmText - Legacy: text for confirm button
     * @param {string} options.cancelText - Legacy: text for cancel button
     * @param {string} options.confirmIcon - Legacy: icon on confirm button
     * @param {string} options.confirmIconPosition - Legacy: 'left' or 'right'
     * @param {string} options.cancelIcon - Legacy: icon on cancel button
     * @param {string} options.cancelIconPosition - Legacy: 'left' or 'right'
     *
     * @returns {Promise<string|boolean>} Resolves with action id/true/false or 'dismiss' if closed
     *
     * @example
     * // Flexible button API
     * SOModal.confirm({
     *   title: 'Delete Item',
     *   message: 'This cannot be undone.',
     *   icon: { name: 'delete', type: 'danger' },
     *   confirm: [{ icon: 'delete' }, 'Delete'],
     *   cancel: 'Cancel',
     *   danger: true
     * });
     *
     * @example
     * // Multiple icons on button
     * SOModal.confirm({
     *   confirm: [{ icon: 'cloud_upload' }, 'Upload', { icon: 'check' }]
     * });
     */
    static confirm(options = {}) {
      const {
        title = "Confirm",
        message = "Are you sure?",
        actions = null,
        // New flexible button API (takes precedence over legacy options)
        confirm: confirmOpt = null,
        cancel: cancelOpt = null,
        // Legacy button options (for backwards compatibility)
        confirmText = "Confirm",
        cancelText = "Cancel",
        confirmClass = "so-btn-primary",
        confirmIcon = null,
        confirmIconPosition = "left",
        cancelIcon = null,
        cancelIconPosition = "left",
        // Styling options
        danger = false,
        closable = true,
        static: isStatic = false,
        // Dialog icon options
        icon = null,
        iconType = null,
        // Layout options
        buttonPosition = "center",
        buttonLayout = "inline",
        fullWidthButtons = false,
        reverseButtons = false,
        showCloseButton = false,
        size = "sm",
        // Focus options
        focusElement = "footer"
      } = options;
      return new Promise((resolve) => {
        let resolved = false;
        const parseButtonContent = (content) => {
          if (typeof content === "string") {
            return content;
          }
          if (Array.isArray(content)) {
            return content.map((part) => {
              if (typeof part === "string") {
                return part;
              }
              if (part && typeof part === "object" && part.icon) {
                return `<span class="material-icons">${part.icon}</span>`;
              }
              return "";
            }).join("");
          }
          return "";
        };
        const createFlexibleButton = (btnConfig, defaultClass, actionId, isFullWidth) => {
          let content, btnClass;
          if (typeof btnConfig === "string") {
            content = btnConfig;
            btnClass = defaultClass;
          } else if (Array.isArray(btnConfig)) {
            content = parseButtonContent(btnConfig);
            btnClass = defaultClass;
          } else if (btnConfig && typeof btnConfig === "object") {
            content = parseButtonContent(btnConfig.content || btnConfig.text || "");
            btnClass = btnConfig.class || defaultClass;
          } else {
            content = "";
            btnClass = defaultClass;
          }
          const widthClass = isFullWidth ? " so-w-100" : "";
          return `<button type="button" class="so-btn ${btnClass}${widthClass}" data-modal-action="${actionId}">${content}</button>`;
        };
        const createLegacyButton = (text, btnClass, actionId, btnIcon, iconPos, isFullWidth) => {
          const iconHtml = btnIcon ? `<span class="material-icons">${btnIcon}</span>` : "";
          const widthClass = isFullWidth ? " so-w-100" : "";
          if (iconPos === "right") {
            return `<button type="button" class="so-btn ${btnClass}${widthClass}" data-modal-action="${actionId}">${text}${iconHtml}</button>`;
          }
          return `<button type="button" class="so-btn ${btnClass}${widthClass}" data-modal-action="${actionId}">${iconHtml}${text}</button>`;
        };
        let footerHtml = "";
        let useSectionsLayout = false;
        if (actions && Array.isArray(actions)) {
          const buttons = actions.map((action) => {
            if (action.content || Array.isArray(action.content)) {
              return createFlexibleButton(
                { content: action.content, class: action.class || (action.primary ? "so-btn-primary" : "so-btn-outline") },
                action.class || (action.primary ? "so-btn-primary" : "so-btn-outline"),
                action.id,
                fullWidthButtons
              );
            }
            const btnClass = action.class || (action.primary ? "so-btn-primary" : "so-btn-outline");
            return createLegacyButton(action.text, btnClass, action.id, action.icon, action.iconPosition || "left", fullWidthButtons);
          });
          footerHtml = buttons.join("\n");
        } else if (actions && typeof actions === "object" && (actions.left || actions.center || actions.right)) {
          useSectionsLayout = true;
          const defaultConfirmClass = danger ? "so-btn-danger" : confirmClass;
          const createSectionButton = (btn) => {
            if (btn.content || Array.isArray(btn.content) || typeof btn === "string" || Array.isArray(btn)) {
              const btnClass2 = btn.class || (btn.primary ? defaultConfirmClass : "so-btn-outline");
              return createFlexibleButton(btn, btnClass2, btn.id || btn.action || "action", fullWidthButtons);
            }
            const btnClass = btn.class || (btn.primary ? defaultConfirmClass : "so-btn-outline");
            return createLegacyButton(btn.text || "", btnClass, btn.id || btn.action || "action", btn.icon, btn.iconPosition || "left", fullWidthButtons);
          };
          const createSection = (buttons) => {
            if (!buttons || !Array.isArray(buttons))
              return "";
            return buttons.map(createSectionButton).join("\n");
          };
          const leftHtml = `<div class="so-footer-left">${createSection(actions.left)}</div>`;
          const centerHtml = `<div class="so-footer-center">${createSection(actions.center)}</div>`;
          const rightHtml = `<div class="so-footer-right">${createSection(actions.right)}</div>`;
          footerHtml = `${leftHtml}
${centerHtml}
${rightHtml}`;
        } else {
          const defaultConfirmClass = danger ? "so-btn-danger" : confirmClass;
          let cancelBtn, confirmBtn;
          if (cancelOpt !== null) {
            cancelBtn = createFlexibleButton(cancelOpt, "so-btn-outline", "cancel", fullWidthButtons);
          } else {
            cancelBtn = createLegacyButton(cancelText, "so-btn-outline", "cancel", cancelIcon, cancelIconPosition, fullWidthButtons);
          }
          if (confirmOpt !== null) {
            confirmBtn = createFlexibleButton(confirmOpt, defaultConfirmClass, "confirm", fullWidthButtons);
          } else {
            confirmBtn = createLegacyButton(confirmText, defaultConfirmClass, "confirm", confirmIcon, confirmIconPosition, fullWidthButtons);
          }
          footerHtml = reverseButtons ? `${confirmBtn}
${cancelBtn}` : `${cancelBtn}
${confirmBtn}`;
        }
        let resolvedIconName = null;
        let resolvedIconType = iconType || (danger ? "danger" : "info");
        if (icon) {
          if (typeof icon === "string") {
            resolvedIconName = icon;
          } else if (typeof icon === "object") {
            resolvedIconName = icon.name || icon.icon || null;
            if (icon.type) {
              resolvedIconType = icon.type;
            }
          }
        }
        let contentHtml = "";
        if (resolvedIconName) {
          contentHtml = `
          <div class="so-confirm-icon so-${resolvedIconType}">
            <span class="material-icons">${resolvedIconName}</span>
          </div>
          <h3 class="so-confirm-title">${title}</h3>
          <p class="so-confirm-message">${message}</p>
        `;
        } else {
          contentHtml = `<p>${message}</p>`;
        }
        let footerClasses = "";
        if (useSectionsLayout) {
          footerClasses = "so-footer-sections";
        } else {
          const positionClassMap = {
            left: "justify-start",
            center: "justify-center",
            right: "justify-end",
            between: "justify-between",
            around: "justify-around"
          };
          const positionClass = positionClassMap[buttonPosition] || "justify-center";
          const layoutClass = buttonLayout === "stacked" ? "so-flex-column" : "";
          footerClasses = [positionClass, layoutClass].filter(Boolean).join(" ");
        }
        const modalClasses = resolvedIconName ? "so-confirm-dialog" : "";
        const modalEl = document.createElement("div");
        modalEl.className = `so-modal so-fade so-modal-${size} ${modalClasses}`.trim();
        modalEl.tabIndex = -1;
        let headerHtml = "";
        if (resolvedIconName) {
          if (showCloseButton && !isStatic) {
            headerHtml = `
            <div class="so-modal-header" style="border-bottom: none; padding-bottom: 0; justify-content: flex-end;">
              <button type="button" class="so-modal-close" data-dismiss="modal">
                <span class="material-icons">close</span>
              </button>
            </div>
          `;
          }
        } else {
          const closeBtn = showCloseButton && !isStatic ? '<button type="button" class="so-modal-close" data-dismiss="modal"><span class="material-icons">close</span></button>' : "";
          headerHtml = `
          <div class="so-modal-header">
            <h5 class="so-modal-title">${title}</h5>
            ${closeBtn}
          </div>
        `;
        }
        modalEl.innerHTML = `
        <div class="so-modal-dialog">
          <div class="so-modal-content">
            ${headerHtml}
            <div class="so-modal-body">
              ${contentHtml}
            </div>
            <div class="so-modal-footer ${footerClasses}">
              ${footerHtml}
            </div>
          </div>
        </div>
      `;
        document.body.appendChild(modalEl);
        const modal = new _SOModal(modalEl, {
          animation: true,
          static: isStatic,
          closable: isStatic ? false : closable,
          keyboard: !isStatic,
          focusElement
        });
        modalEl._soModalInstance = modal;
        modalEl.addEventListener(so_config_default.evt(_SOModal.EVENTS.HIDDEN), () => {
          modalEl.remove();
        });
        modalEl.querySelectorAll("[data-modal-action]").forEach((btn) => {
          btn.addEventListener("click", () => {
            if (resolved)
              return;
            resolved = true;
            const actionId = btn.getAttribute("data-modal-action");
            if (!actions) {
              resolve(actionId === "confirm");
            } else {
              resolve(actionId);
            }
            modal.hide();
          });
        });
        modalEl.addEventListener(so_config_default.evt(_SOModal.EVENTS.HIDDEN), () => {
          if (resolved)
            return;
          resolved = true;
          resolve(actions ? "dismiss" : false);
        });
        modal.show();
      });
    }
    /**
     * Show an alert dialog
     * @param {Object} options - Alert options
     * @returns {Promise<void>} Resolves when closed
     */
    static alert(options = {}) {
      const {
        title = "Alert",
        message = "",
        buttonText = "OK",
        type = "info"
        // info, success, warning, danger
      } = options;
      const iconMap = {
        info: "info",
        success: "check_circle",
        warning: "warning",
        danger: "error"
      };
      return new Promise((resolve) => {
        const modal = _SOModal.create({
          title,
          content: `
          <div style="text-align: center; padding: 16px 0;">
            <span class="material-icons" style="font-size: 48px; color: var(--so-accent-${type === "info" ? "primary" : type}); margin-bottom: 16px; display: block;">
              ${iconMap[type] || "info"}
            </span>
            <p style="margin: 0;">${message}</p>
          </div>
        `,
          size: "sm",
          closable: true,
          footer: `<button type="button" class="so-btn so-btn-primary" data-dismiss="modal">${buttonText}</button>`
        });
        modal.element.addEventListener(so_config_default.evt(_SOModal.EVENTS.HIDDEN), () => resolve());
        modal.show();
      });
    }
    /**
     * Get modal instance from element
     * Override to also check for instance stored on element (from create())
     * @param {Element|string} element - DOM element or selector
     * @param {Object} [options={}] - Component options
     * @returns {SOModal} Modal instance
     */
    static getInstance(element, options = {}) {
      const el = typeof element === "string" ? document.querySelector(element) : element;
      if (!el)
        return null;
      if (el._soModalInstance) {
        return el._soModalInstance;
      }
      return so_config_default.getInstance(el, this.NAME, options);
    }
  };
  __publicField(_SOModal, "NAME", "modal");
  __publicField(_SOModal, "DEFAULTS", {
    backdrop: true,
    keyboard: true,
    focus: true,
    closable: true,
    size: "default",
    // 'sm', 'default', 'lg', 'xl', 'fullscreen'
    animation: true,
    static: false,
    // When true, modal cannot be dismissed via backdrop/escape/close button
    focusElement: "footer",
    // 'footer' (first footer button), 'close', 'first', or CSS selector
    draggable: false,
    // Allow modal to be dragged by header
    maximizable: false,
    // Show maximize/restore button
    mobileFullscreen: false,
    // Auto-switch to fullscreen on mobile
    mobileBreakpoint: 768,
    // Breakpoint for mobile fullscreen
    sidebar: false,
    // Enable sidebar layout: 'left' or 'right'
    sidebarWidth: "280px"
    // Width of sidebar
  });
  __publicField(_SOModal, "EVENTS", {
    SHOW: "modal:show",
    SHOWN: "modal:shown",
    HIDE: "modal:hide",
    HIDDEN: "modal:hidden",
    CONFIRM: "modal:confirm",
    CANCEL: "modal:cancel",
    MAXIMIZE: "modal:maximize",
    RESTORE: "modal:restore",
    DRAG_START: "modal:drag-start",
    DRAG_END: "modal:drag-end"
  });
  // Base z-index for modals
  __publicField(_SOModal, "_baseZIndex", 1050);
  // Track open modals for stacking
  __publicField(_SOModal, "_openModals", []);
  // Track singleton modal instances by ID
  __publicField(_SOModal, "_singletonInstances", /* @__PURE__ */ new Map());
  var SOModal = _SOModal;
  SOModal.register();
  document.addEventListener("click", (e) => {
    const trigger = e.target.closest('[data-so-toggle="modal"]');
    if (!trigger)
      return;
    e.preventDefault();
    const targetSelector = trigger.getAttribute("data-so-target") || trigger.getAttribute("href");
    if (!targetSelector)
      return;
    const modalEl = document.querySelector(targetSelector);
    if (!modalEl)
      return;
    const modal = SOModal.getInstance(modalEl);
    if (modal) {
      modal.show();
    }
  });
  window.SOModal = SOModal;

  // src/js/components/so-ripple.js
  var SORipple = class extends so_component_default {
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
      this.on("click", this._handleClick, document);
    }
    /**
     * Handle click event
     * @param {MouseEvent} e - Click event
     * @private
     */
    _handleClick(e) {
      const target = e.target.closest(this.options.selector);
      if (!target)
        return;
      if (target.disabled || target.classList.contains("so-disabled"))
        return;
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
      const size = Math.max(rect.width, rect.height);
      const x = event.clientX - rect.left - size / 2;
      const y = event.clientY - rect.top - size / 2;
      const ripple = document.createElement("span");
      ripple.className = "so-ripple-effect";
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
      const position = getComputedStyle(element).position;
      if (position === "static") {
        element.style.position = "relative";
      }
      element.style.overflow = "hidden";
      element.appendChild(ripple);
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
      if (element.classList.contains("so-btn-outline") || element.classList.contains("so-btn-ghost") || element.classList.contains("so-btn-light")) {
        return "rgba(0, 0, 0, 0.1)";
      }
      return this.options.color;
    }
    /**
     * Add CSS animation if not present
     * @private
     */
    static _ensureStyles() {
      if (document.getElementById("so-ripple-styles"))
        return;
      const style = document.createElement("style");
      style.id = "so-ripple-styles";
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
  };
  __publicField(SORipple, "NAME", "ripple");
  __publicField(SORipple, "DEFAULTS", {
    selector: ".so-btn",
    duration: 600,
    color: "rgba(255, 255, 255, 0.35)"
  });
  SORipple._ensureStyles();
  document.addEventListener("DOMContentLoaded", () => {
    new SORipple(document.body);
  });
  SORipple.register();
  window.SORipple = SORipple;

  // src/js/components/so-context-menu.js
  var _SOContextMenu = class _SOContextMenu extends so_component_default {
    /**
     * Initialize the context menu
     * @private
     */
    _init() {
      this._isOpen = false;
      this._disabled = this.options.disabled;
      this._target = null;
      this._menuElement = null;
      this._items = [];
      this._groups = /* @__PURE__ */ new Map();
      this._focusedIndex = -1;
      this._activeSubmenu = null;
      this._submenuTimeout = null;
      if (this.element.classList.contains("so-context-menu")) {
        this._menuElement = this.element;
        const triggerId = this.element.id;
        if (triggerId) {
          this._target = document.querySelector(`[data-so-context-menu="#${triggerId}"]`);
        }
      } else {
        this._target = this.element;
        const menuSelector = this.element.getAttribute("data-so-context-menu");
        if (menuSelector) {
          this._menuElement = document.querySelector(menuSelector);
        }
      }
      if (this.options.items && this.options.items.length > 0) {
        this._buildFromConfig(this.options.items);
      } else if (this._menuElement) {
        this._parseFromDOM();
      }
      this._bindEvents();
    }
    /**
     * Build menu from configuration array
     * @param {Array} items - Items configuration
     * @private
     */
    _buildFromConfig(items) {
      if (!this._menuElement) {
        this._menuElement = document.createElement("div");
        this._menuElement.className = "so-context-menu";
        if (this.options.animated) {
          this._menuElement.classList.add("so-context-menu-animated");
        }
        document.body.appendChild(this._menuElement);
      }
      this._items = [];
      this._menuElement.innerHTML = "";
      this._renderItems(items, this._menuElement);
    }
    /**
     * Render items to container
     * @param {Array} items - Items to render
     * @param {Element} container - Container element
     * @param {number} [level=0] - Nesting level
     * @private
     */
    _renderItems(items, container, level = 0) {
      items.forEach((item, index) => {
        const itemEl = this._createItemElement(item, level);
        container.appendChild(itemEl);
        const itemData = __spreadProps(__spreadValues({}, item), {
          id: item.id || `item-${level}-${index}`,
          element: itemEl,
          level
        });
        this._items.push(itemData);
        if (item.groupId) {
          if (!this._groups.has(item.groupId)) {
            this._groups.set(item.groupId, []);
          }
          this._groups.get(item.groupId).push(itemData.id);
        }
      });
    }
    /**
     * Create a single item element
     * @param {Object} item - Item configuration
     * @param {number} level - Nesting level
     * @returns {Element} Created element
     * @private
     */
    _createItemElement(item, level) {
      if (item.type === "header") {
        const header = document.createElement("div");
        header.className = "so-context-menu-header";
        header.textContent = item.label || item.text || "";
        header.dataset.id = item.id || "";
        return header;
      }
      if (item.type === "divider") {
        const divider = document.createElement("div");
        divider.className = "so-context-menu-divider";
        return divider;
      }
      if (item.type === "group") {
        const group = document.createElement("div");
        group.className = "so-context-menu-group";
        group.dataset.groupId = item.groupId || item.id || "";
        if (item.disabled)
          group.classList.add("so-disabled");
        if (item.items && item.items.length > 0) {
          this._renderItems(item.items.map((i) => __spreadProps(__spreadValues({}, i), { groupId: item.groupId || item.id })), group, level);
        }
        return group;
      }
      const itemEl = document.createElement("div");
      itemEl.className = "so-context-menu-item";
      if (item.id)
        itemEl.dataset.id = item.id;
      if (item.disabled)
        itemEl.classList.add("so-disabled");
      if (item.danger)
        itemEl.classList.add(so_config_default.cls("danger"));
      if (item.checked)
        itemEl.classList.add(so_config_default.cls("checked"));
      if (item.data)
        itemEl.dataset.data = JSON.stringify(item.data);
      const hasSubmenu = item.items && item.items.length > 0 && level < 2;
      if (hasSubmenu)
        itemEl.classList.add("so-has-submenu");
      let html = "";
      if (item.checkable) {
        html += `<span class="so-context-menu-item-check"><span class="material-icons">check</span></span>`;
      }
      if (item.icon) {
        html += `<span class="so-context-menu-item-icon"><span class="material-icons">${item.icon}</span></span>`;
      }
      if (item.description) {
        html += `<span class="so-context-menu-item-content">
        <span class="so-context-menu-item-text">${item.label || item.text || ""}</span>
        <span class="so-context-menu-item-description">${item.description}</span>
      </span>`;
      } else {
        html += `<span class="so-context-menu-item-text">${item.label || item.text || ""}</span>`;
      }
      if (item.shortcut) {
        html += `<span class="so-context-menu-item-shortcut">${item.shortcut}</span>`;
      }
      if (hasSubmenu) {
        html += `<span class="so-context-menu-item-arrow"><span class="material-icons">chevron_right</span></span>`;
      }
      itemEl.innerHTML = html;
      if (hasSubmenu) {
        const submenu = document.createElement("div");
        submenu.className = "so-context-menu-submenu";
        this._renderItems(item.items, submenu, level + 1);
        itemEl.appendChild(submenu);
      }
      return itemEl;
    }
    /**
     * Parse items from existing DOM
     * @private
     */
    _parseFromDOM() {
      if (!this._menuElement)
        return;
      this._items = [];
      const children = this._menuElement.children;
      for (let i = 0; i < children.length; i++) {
        const el = children[i];
        const item = this._parseItemElement(el, 0, i);
        if (item)
          this._items.push(item);
      }
    }
    /**
     * Parse a single item element
     * @param {Element} el - Item element
     * @param {number} level - Nesting level
     * @param {number} index - Item index
     * @returns {Object|null} Parsed item data
     * @private
     */
    _parseItemElement(el, level, index) {
      if (el.classList.contains("so-context-menu-header")) {
        return {
          id: el.dataset.id || `header-${level}-${index}`,
          type: "header",
          label: el.textContent.trim(),
          element: el,
          level
        };
      }
      if (el.classList.contains("so-context-menu-divider")) {
        return {
          id: `divider-${level}-${index}`,
          type: "divider",
          element: el,
          level
        };
      }
      if (el.classList.contains("so-context-menu-group")) {
        const groupId = el.dataset.groupId || `group-${index}`;
        const groupItems = [];
        for (let i = 0; i < el.children.length; i++) {
          const childItem = this._parseItemElement(el.children[i], level, i);
          if (childItem) {
            childItem.groupId = groupId;
            groupItems.push(childItem);
            this._items.push(childItem);
          }
        }
        this._groups.set(groupId, groupItems.map((i) => i.id));
        return null;
      }
      if (el.classList.contains("so-context-menu-item")) {
        const textEl = el.querySelector(".so-context-menu-item-text");
        const iconEl = el.querySelector(".so-context-menu-item-icon .material-icons");
        const shortcutEl = el.querySelector(".so-context-menu-item-shortcut");
        const submenuEl = el.querySelector(".so-context-menu-submenu");
        const item = {
          id: el.dataset.id || `item-${level}-${index}`,
          type: "item",
          label: textEl ? textEl.textContent.trim() : el.textContent.trim(),
          icon: iconEl ? iconEl.textContent.trim() : null,
          shortcut: shortcutEl ? shortcutEl.textContent.trim() : null,
          disabled: el.classList.contains("so-disabled"),
          danger: el.classList.contains(so_config_default.cls("danger")),
          checked: el.classList.contains(so_config_default.cls("checked")),
          data: el.dataset.data ? JSON.parse(el.dataset.data) : {},
          element: el,
          level,
          items: []
        };
        if (submenuEl && level < 2) {
          for (let i = 0; i < submenuEl.children.length; i++) {
            const subItem = this._parseItemElement(submenuEl.children[i], level + 1, i);
            if (subItem)
              item.items.push(subItem);
          }
        }
        return item;
      }
      return null;
    }
    /**
     * Bind event listeners
     * @private
     */
    _bindEvents() {
      if (this._target) {
        const triggerEvent = this.options.trigger === "click" ? "click" : "contextmenu";
        this.on(triggerEvent, this._handleTrigger, this._target);
      }
      if (this._menuElement) {
        this.on("click", this._handleItemClick, this._menuElement);
        this.on("mouseenter", this._handleItemHover, this._menuElement, { capture: true });
        this.on("mouseleave", this._handleItemLeave, this._menuElement, { capture: true });
      }
      if (this.options.closeOnOutsideClick) {
        this.on("click", this._handleOutsideClick, document);
        this.on("contextmenu", this._handleOutsideContextMenu, document);
      }
      this.on("keydown", this._handleKeydown, document);
      this.on("scroll", () => {
        if (this._isOpen)
          this.close();
      }, window, { passive: true });
      this.on("resize", () => {
        if (this._isOpen)
          this.close();
      }, window, { passive: true });
    }
    /**
     * Handle trigger event (contextmenu or click)
     * @param {Event} e - Event object
     * @private
     */
    _handleTrigger(e) {
      e.preventDefault();
      e.stopPropagation();
      if (this._disabled)
        return;
      const x = e.clientX || e.pageX;
      const y = e.clientY || e.pageY;
      this.open(x, y, e);
    }
    /**
     * Handle item click
     * @param {Event} e - Click event
     * @private
     */
    _handleItemClick(e) {
      var _a;
      const itemEl = e.target.closest(".so-context-menu-item");
      if (!itemEl)
        return;
      if (itemEl.classList.contains("so-disabled")) {
        e.stopPropagation();
        return;
      }
      if (itemEl.classList.contains("so-has-submenu")) {
        e.stopPropagation();
        return;
      }
      e.stopPropagation();
      const itemId = itemEl.dataset.id;
      const item = this._items.find((i) => i.id === itemId) || {
        id: itemId,
        label: (_a = itemEl.querySelector(".so-context-menu-item-text")) == null ? void 0 : _a.textContent.trim(),
        data: itemEl.dataset.data ? JSON.parse(itemEl.dataset.data) : {},
        element: itemEl
      };
      if (itemEl.classList.contains(so_config_default.cls("checked")) || item.checkable) {
        itemEl.classList.toggle(so_config_default.cls("checked"));
        item.checked = itemEl.classList.contains(so_config_default.cls("checked"));
      }
      this.emit(_SOContextMenu.EVENTS.SELECT, {
        item,
        id: item.id,
        label: item.label,
        data: item.data,
        checked: item.checked
      });
      if (this.options.closeOnSelect) {
        this.close();
      }
    }
    /**
     * Handle item hover for submenus
     * @param {Event} e - Mouse event
     * @private
     */
    _handleItemHover(e) {
      const itemEl = e.target.closest(".so-context-menu-item");
      if (!itemEl)
        return;
      if (this._submenuTimeout) {
        clearTimeout(this._submenuTimeout);
        this._submenuTimeout = null;
      }
      const parent = itemEl.parentElement;
      const siblings = parent.querySelectorAll(":scope > .so-context-menu-item.submenu-open");
      siblings.forEach((sib) => {
        if (sib !== itemEl) {
          sib.classList.remove("submenu-open");
          const submenu = sib.querySelector(".so-context-menu-submenu");
          if (submenu)
            submenu.classList.remove("so-open");
        }
      });
      if (!itemEl.classList.contains("so-has-submenu"))
        return;
      this._submenuTimeout = setTimeout(() => {
        this._openSubmenu(itemEl);
      }, this.options.submenuDelay);
    }
    /**
     * Handle item leave
     * @param {Event} e - Mouse event
     * @private
     */
    _handleItemLeave(e) {
      if (this._submenuTimeout) {
        clearTimeout(this._submenuTimeout);
        this._submenuTimeout = null;
      }
    }
    /**
     * Open a submenu
     * @param {Element} parentItem - Parent item element
     * @private
     */
    _openSubmenu(parentItem) {
      const submenu = parentItem.querySelector(".so-context-menu-submenu");
      if (!submenu)
        return;
      parentItem.classList.add("submenu-open");
      this._positionSubmenu(parentItem, submenu);
      submenu.classList.add("so-open");
      const itemId = parentItem.dataset.id;
      const item = this._items.find((i) => i.id === itemId);
      this.emit(_SOContextMenu.EVENTS.SUBMENU_SHOW, {
        parentItem: item,
        items: (item == null ? void 0 : item.items) || []
      });
      this._activeSubmenu = submenu;
    }
    /**
     * Position submenu relative to parent
     * @param {Element} parentItem - Parent item element
     * @param {Element} submenu - Submenu element
     * @private
     */
    _positionSubmenu(parentItem, submenu) {
      submenu.classList.remove("so-flip-x");
      const parentRect = parentItem.getBoundingClientRect();
      const submenuWidth = submenu.offsetWidth || 160;
      const viewportWidth = window.innerWidth;
      if (parentRect.right + submenuWidth > viewportWidth - 10) {
        submenu.classList.add("so-flip-x");
      }
      const submenuHeight = submenu.offsetHeight || 100;
      const viewportHeight = window.innerHeight;
      if (parentRect.top + submenuHeight > viewportHeight - 10) {
        const offset = Math.min(
          parentRect.top + submenuHeight - viewportHeight + 10,
          parentRect.top - 10
        );
        submenu.style.top = `-${offset}px`;
      } else {
        submenu.style.top = "0";
      }
    }
    /**
     * Handle outside click
     * @param {Event} e - Click event
     * @private
     */
    _handleOutsideClick(e) {
      if (!this._isOpen)
        return;
      if (this._menuElement && this._menuElement.contains(e.target))
        return;
      this.close();
    }
    /**
     * Handle outside context menu
     * @param {Event} e - Context menu event
     * @private
     */
    _handleOutsideContextMenu(e) {
      if (!this._isOpen)
        return;
      if (this._target && this._target.contains(e.target))
        return;
      if (this._menuElement && this._menuElement.contains(e.target)) {
        e.preventDefault();
        return;
      }
      this.close();
    }
    /**
     * Handle keyboard navigation
     * @param {KeyboardEvent} e - Keyboard event
     * @private
     */
    _handleKeydown(e) {
      if (!this._isOpen)
        return;
      switch (e.key) {
        case "Escape":
          e.preventDefault();
          this.close();
          break;
        case "ArrowDown":
          e.preventDefault();
          this._focusNextItem(1);
          break;
        case "ArrowUp":
          e.preventDefault();
          this._focusNextItem(-1);
          break;
        case "ArrowRight":
          e.preventDefault();
          this._openFocusedSubmenu();
          break;
        case "ArrowLeft":
          e.preventDefault();
          this._closeActiveSubmenu();
          break;
        case "Enter":
        case " ":
          e.preventDefault();
          this._selectFocusedItem();
          break;
        case "Home":
          e.preventDefault();
          this._focusItem(0);
          break;
        case "End":
          e.preventDefault();
          this._focusItem(this._getNavigableItems().length - 1);
          break;
      }
    }
    /**
     * Get navigable items (excluding headers, dividers, disabled)
     * @param {Element} [container] - Container to search in
     * @returns {Element[]} Array of navigable items
     * @private
     */
    _getNavigableItems(container) {
      const cont = container || this._menuElement;
      return Array.from(cont.querySelectorAll(":scope > .so-context-menu-item:not(.disabled)"));
    }
    /**
     * Focus next/previous item
     * @param {number} direction - 1 for next, -1 for previous
     * @private
     */
    _focusNextItem(direction) {
      const items = this._getNavigableItems();
      if (items.length === 0)
        return;
      let newIndex = this._focusedIndex + direction;
      if (newIndex < 0)
        newIndex = items.length - 1;
      if (newIndex >= items.length)
        newIndex = 0;
      this._focusItem(newIndex);
    }
    /**
     * Focus item by index
     * @param {number} index - Item index
     * @private
     */
    _focusItem(index) {
      const items = this._getNavigableItems();
      items.forEach((item) => item.classList.remove("so-focused"));
      this._focusedIndex = index;
      if (items[index]) {
        items[index].classList.add("so-focused");
        items[index].scrollIntoView({ block: "nearest" });
      }
    }
    /**
     * Open submenu of focused item
     * @private
     */
    _openFocusedSubmenu() {
      const items = this._getNavigableItems();
      if (this._focusedIndex < 0 || !items[this._focusedIndex])
        return;
      const item = items[this._focusedIndex];
      if (item.classList.contains("so-has-submenu")) {
        this._openSubmenu(item);
        const submenu = item.querySelector(".so-context-menu-submenu");
        if (submenu) {
          const subItems = this._getNavigableItems(submenu);
          if (subItems[0])
            subItems[0].classList.add("so-focused");
        }
      }
    }
    /**
     * Close active submenu
     * @private
     */
    _closeActiveSubmenu() {
      if (!this._activeSubmenu)
        return;
      const parentItem = this._activeSubmenu.closest(".so-context-menu-item");
      if (parentItem) {
        parentItem.classList.remove("submenu-open");
        this._activeSubmenu.classList.remove("so-open");
        const itemId = parentItem.dataset.id;
        const item = this._items.find((i) => i.id === itemId);
        this.emit(_SOContextMenu.EVENTS.SUBMENU_HIDE, { parentItem: item });
      }
      this._activeSubmenu = null;
    }
    /**
     * Select the focused item
     * @private
     */
    _selectFocusedItem() {
      const items = this._getNavigableItems();
      if (this._focusedIndex < 0 || !items[this._focusedIndex])
        return;
      const item = items[this._focusedIndex];
      if (item.classList.contains("so-has-submenu")) {
        this._openFocusedSubmenu();
        return;
      }
      item.click();
    }
    // ============================================
    // PUBLIC API - MENU CONTROL
    // ============================================
    /**
     * Open the context menu at coordinates
     * @param {number} x - X coordinate
     * @param {number} y - Y coordinate
     * @param {Event} [originalEvent] - Original event that triggered open
     * @returns {this} For chaining
     */
    open(x, y, originalEvent = null) {
      if (this._isOpen || this._disabled || !this._menuElement)
        return this;
      const showAllowed = this.emit(_SOContextMenu.EVENTS.SHOW, {
        x,
        y,
        originalEvent
      }, true, true);
      if (!showAllowed)
        return this;
      this._isOpen = true;
      this._positionMenu(x, y);
      this._menuElement.classList.add("so-open");
      this._focusedIndex = -1;
      setTimeout(() => {
        this.emit(_SOContextMenu.EVENTS.SHOWN, { x, y });
      }, 150);
      return this;
    }
    /**
     * Position the menu at coordinates
     * @param {number} x - X coordinate
     * @param {number} y - Y coordinate
     * @private
     */
    _positionMenu(x, y) {
      const menu = this._menuElement;
      menu.classList.remove("so-flip-x", "so-flip-y");
      menu.style.visibility = "hidden";
      menu.style.display = "block";
      menu.style.opacity = "0";
      const menuWidth = menu.offsetWidth;
      const menuHeight = menu.offsetHeight;
      menu.style.visibility = "";
      menu.style.display = "";
      menu.style.opacity = "";
      const viewportWidth = window.innerWidth;
      const viewportHeight = window.innerHeight;
      let finalX = x;
      let finalY = y;
      if (x + menuWidth > viewportWidth - 10) {
        finalX = x - menuWidth;
        menu.classList.add("so-flip-x");
      }
      if (y + menuHeight > viewportHeight - 10) {
        finalY = y - menuHeight;
        menu.classList.add("so-flip-y");
      }
      finalX = Math.max(10, finalX);
      finalY = Math.max(10, finalY);
      menu.style.left = `${finalX}px`;
      menu.style.top = `${finalY}px`;
    }
    /**
     * Close the context menu
     * @returns {this} For chaining
     */
    close() {
      if (!this._isOpen || !this._menuElement)
        return this;
      const hideAllowed = this.emit(_SOContextMenu.EVENTS.HIDE, {}, true, true);
      if (!hideAllowed)
        return this;
      this._isOpen = false;
      this._closeAllSubmenus();
      const focused = this._menuElement.querySelector(".so-context-menu-item.so-focused");
      if (focused)
        focused.classList.remove("so-focused");
      this._focusedIndex = -1;
      if (this.options.animated) {
        this._menuElement.classList.add("so-closing");
        setTimeout(() => {
          this._menuElement.classList.remove("so-open", "so-closing");
          this.emit(_SOContextMenu.EVENTS.HIDDEN);
        }, 150);
      } else {
        this._menuElement.classList.remove("so-open");
        setTimeout(() => {
          this.emit(_SOContextMenu.EVENTS.HIDDEN);
        }, 150);
      }
      return this;
    }
    /**
     * Close all submenus
     * @private
     */
    _closeAllSubmenus() {
      if (!this._menuElement)
        return;
      const openSubmenus = this._menuElement.querySelectorAll(".so-context-menu-submenu.so-open");
      openSubmenus.forEach((submenu) => submenu.classList.remove("so-open"));
      const openParents = this._menuElement.querySelectorAll(".so-context-menu-item.submenu-open");
      openParents.forEach((parent) => parent.classList.remove("submenu-open"));
      this._activeSubmenu = null;
    }
    /**
     * Toggle the context menu
     * @param {number} x - X coordinate
     * @param {number} y - Y coordinate
     * @returns {this} For chaining
     */
    toggle(x, y) {
      return this._isOpen ? this.close() : this.open(x, y);
    }
    /**
     * Check if menu is open
     * @returns {boolean} Open state
     */
    isOpen() {
      return this._isOpen;
    }
    /**
     * Enable the entire menu
     * @returns {this} For chaining
     */
    enable() {
      this._disabled = false;
      return this;
    }
    /**
     * Disable the entire menu
     * @returns {this} For chaining
     */
    disable() {
      this._disabled = true;
      if (this._isOpen)
        this.close();
      return this;
    }
    /**
     * Check if menu is disabled
     * @returns {boolean} Disabled state
     */
    isDisabled() {
      return this._disabled;
    }
    // ============================================
    // PUBLIC API - ITEM MANAGEMENT
    // ============================================
    /**
     * Add an item to the menu
     * @param {Object} item - Item configuration
     * @param {number|string|Object} [position='bottom'] - Position: index, 'top', 'bottom', {before:'id'}, {after:'id'}, {group:'id',position:'top'|'bottom'}
     * @returns {this} For chaining
     */
    add(item, position = "bottom") {
      if (!this._menuElement)
        return this;
      const itemEl = this._createItemElement(item, 0);
      let referenceNode = null;
      let insertBefore = true;
      if (typeof position === "number") {
        const children = Array.from(this._menuElement.children);
        referenceNode = children[position] || null;
      } else if (position === "top") {
        referenceNode = this._menuElement.firstChild;
      } else if (position === "bottom") {
        referenceNode = null;
        insertBefore = false;
      } else if (typeof position === "object") {
        if (position.before) {
          referenceNode = this._menuElement.querySelector(`[data-id="${position.before}"]`);
        } else if (position.after) {
          const afterEl = this._menuElement.querySelector(`[data-id="${position.after}"]`);
          referenceNode = (afterEl == null ? void 0 : afterEl.nextSibling) || null;
        } else if (position.group) {
          const groupEl = this._menuElement.querySelector(`[data-group-id="${position.group}"]`);
          if (groupEl) {
            if (position.position === "top") {
              referenceNode = groupEl.firstChild;
              insertBefore = true;
            } else {
              referenceNode = null;
              insertBefore = false;
            }
            if (insertBefore && referenceNode) {
              groupEl.insertBefore(itemEl, referenceNode);
            } else {
              groupEl.appendChild(itemEl);
            }
            this._storeItem(item, itemEl, 0);
            return this;
          }
        }
      }
      if (insertBefore && referenceNode) {
        this._menuElement.insertBefore(itemEl, referenceNode);
      } else {
        this._menuElement.appendChild(itemEl);
      }
      this._storeItem(item, itemEl, 0);
      return this;
    }
    /**
     * Store item data
     * @param {Object} item - Item config
     * @param {Element} itemEl - Item element
     * @param {number} level - Nesting level
     * @private
     */
    _storeItem(item, itemEl, level) {
      const itemData = __spreadProps(__spreadValues({}, item), {
        id: item.id || `item-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`,
        element: itemEl,
        level
      });
      itemEl.dataset.id = itemData.id;
      this._items.push(itemData);
      if (item.groupId) {
        if (!this._groups.has(item.groupId)) {
          this._groups.set(item.groupId, []);
        }
        this._groups.get(item.groupId).push(itemData.id);
      }
    }
    /**
     * Add a group of items
     * @param {string} groupId - Group identifier
     * @param {Array} items - Items to add
     * @param {string|number} [position='bottom'] - Position in menu
     * @returns {this} For chaining
     */
    addGroup(groupId, items, position = "bottom") {
      const groupConfig = {
        type: "group",
        id: groupId,
        groupId,
        items
      };
      return this.add(groupConfig, position);
    }
    /**
     * Add a separator/divider
     * @param {number|string|Object} [position='bottom'] - Position
     * @returns {this} For chaining
     */
    addSeparator(position = "bottom") {
      return this.add({ type: "divider" }, position);
    }
    /**
     * Add a header
     * @param {string} text - Header text
     * @param {number|string|Object} [position='bottom'] - Position
     * @returns {this} For chaining
     */
    addHeader(text, position = "bottom") {
      return this.add({ type: "header", label: text }, position);
    }
    /**
     * Remove an item by id or index
     * @param {string|number} identifier - Item id or index
     * @returns {this} For chaining
     */
    remove(identifier) {
      let item;
      if (typeof identifier === "number") {
        item = this._items[identifier];
      } else {
        item = this._items.find((i) => i.id === identifier);
      }
      if (item && item.element) {
        item.element.remove();
        this._items = this._items.filter((i) => i !== item);
        if (item.groupId && this._groups.has(item.groupId)) {
          const groupItems = this._groups.get(item.groupId);
          this._groups.set(item.groupId, groupItems.filter((id) => id !== item.id));
        }
      }
      return this;
    }
    /**
     * Remove all items
     * @returns {this} For chaining
     */
    removeAll() {
      if (this._menuElement) {
        this._menuElement.innerHTML = "";
      }
      this._items = [];
      this._groups.clear();
      return this;
    }
    /**
     * Get an item by id or index
     * @param {string|number} identifier - Item id or index
     * @returns {Object|null} Item data
     */
    getItem(identifier) {
      if (typeof identifier === "number") {
        return this._items[identifier] || null;
      }
      return this._items.find((i) => i.id === identifier) || null;
    }
    /**
     * Get all items
     * @returns {Array} All items
     */
    getItems() {
      return [...this._items];
    }
    /**
     * Update an item's properties
     * @param {string|number} identifier - Item id or index
     * @param {Object} updates - Properties to update
     * @returns {this} For chaining
     */
    updateItem(identifier, updates) {
      const item = this.getItem(identifier);
      if (!item || !item.element)
        return this;
      Object.assign(item, updates);
      const el = item.element;
      if (updates.label !== void 0) {
        const textEl = el.querySelector(".so-context-menu-item-text");
        if (textEl)
          textEl.textContent = updates.label;
      }
      if (updates.icon !== void 0) {
        let iconEl = el.querySelector(".so-context-menu-item-icon .material-icons");
        if (iconEl) {
          iconEl.textContent = updates.icon;
        } else if (updates.icon) {
          const iconWrapper = document.createElement("span");
          iconWrapper.className = "so-context-menu-item-icon";
          iconWrapper.innerHTML = `<span class="material-icons">${updates.icon}</span>`;
          el.insertBefore(iconWrapper, el.firstChild);
        }
      }
      if (updates.disabled !== void 0) {
        el.classList.toggle("so-disabled", updates.disabled);
      }
      if (updates.danger !== void 0) {
        el.classList.toggle(so_config_default.cls("danger"), updates.danger);
      }
      if (updates.checked !== void 0) {
        el.classList.toggle(so_config_default.cls("checked"), updates.checked);
      }
      if (updates.shortcut !== void 0) {
        let shortcutEl = el.querySelector(".so-context-menu-item-shortcut");
        if (shortcutEl) {
          shortcutEl.textContent = updates.shortcut;
        } else if (updates.shortcut) {
          const arrow = el.querySelector(".so-context-menu-item-arrow");
          const shortcutSpan = document.createElement("span");
          shortcutSpan.className = "so-context-menu-item-shortcut";
          shortcutSpan.textContent = updates.shortcut;
          if (arrow) {
            el.insertBefore(shortcutSpan, arrow);
          } else {
            el.appendChild(shortcutSpan);
          }
        }
      }
      return this;
    }
    // ============================================
    // PUBLIC API - ITEM STATE
    // ============================================
    /**
     * Enable a specific item
     * @param {string|number} identifier - Item id or index
     * @returns {this} For chaining
     */
    enableItem(identifier) {
      return this.updateItem(identifier, { disabled: false });
    }
    /**
     * Disable a specific item
     * @param {string|number} identifier - Item id or index
     * @returns {this} For chaining
     */
    disableItem(identifier) {
      return this.updateItem(identifier, { disabled: true });
    }
    /**
     * Enable all items in a group
     * @param {string} groupId - Group identifier
     * @returns {this} For chaining
     */
    enableGroup(groupId) {
      var _a;
      const groupEl = (_a = this._menuElement) == null ? void 0 : _a.querySelector(`[data-group-id="${groupId}"]`);
      if (groupEl) {
        groupEl.classList.remove("so-disabled");
      }
      const itemIds = this._groups.get(groupId) || [];
      itemIds.forEach((id) => this.enableItem(id));
      return this;
    }
    /**
     * Disable all items in a group
     * @param {string} groupId - Group identifier
     * @returns {this} For chaining
     */
    disableGroup(groupId) {
      var _a;
      const groupEl = (_a = this._menuElement) == null ? void 0 : _a.querySelector(`[data-group-id="${groupId}"]`);
      if (groupEl) {
        groupEl.classList.add("so-disabled");
      }
      const itemIds = this._groups.get(groupId) || [];
      itemIds.forEach((id) => this.disableItem(id));
      return this;
    }
    // ============================================
    // PUBLIC API - ATTACHMENT
    // ============================================
    /**
     * Attach menu to a trigger element
     * @param {Element|string} element - Element or selector
     * @returns {this} For chaining
     */
    attach(element) {
      this.detach();
      const el = typeof element === "string" ? document.querySelector(element) : element;
      if (!el)
        return this;
      this._target = el;
      const triggerEvent = this.options.trigger === "click" ? "click" : "contextmenu";
      this.on(triggerEvent, this._handleTrigger, this._target);
      return this;
    }
    /**
     * Detach menu from current trigger element
     * @returns {this} For chaining
     */
    detach() {
      if (!this._target)
        return this;
      const triggerEvent = this.options.trigger === "click" ? "click" : "contextmenu";
      this._boundHandlers.forEach((stored, handler) => {
        if (stored.target === this._target && stored.event === triggerEvent) {
          this._target.removeEventListener(triggerEvent, stored.boundHandler);
          this._boundHandlers.delete(handler);
        }
      });
      this._target = null;
      return this;
    }
    /**
     * Get current trigger element
     * @returns {Element|null} Trigger element
     */
    getTarget() {
      return this._target;
    }
    // ============================================
    // PUBLIC API - LIFECYCLE
    // ============================================
    /**
     * Destroy the context menu and cleanup
     */
    destroy() {
      if (this._isOpen)
        this.close();
      if (this._submenuTimeout) {
        clearTimeout(this._submenuTimeout);
      }
      this.detach();
      if (this._menuElement && !this._menuElement.id) {
        this._menuElement.remove();
      }
      this._items = [];
      this._groups.clear();
      this._menuElement = null;
      super.destroy();
    }
    // ============================================
    // STATIC FACTORY METHODS
    // ============================================
    /**
     * Create a context menu programmatically
     * @param {Object} options - Menu configuration
     * @returns {SOContextMenu} Menu instance
     */
    static create(options = {}) {
      const _a = options, {
        target,
        items = [],
        trigger = "contextmenu"
      } = _a, rest = __objRest(_a, [
        "target",
        "items",
        "trigger"
      ]);
      const wrapper = document.createElement("div");
      wrapper.style.display = "none";
      document.body.appendChild(wrapper);
      const menu = new _SOContextMenu(wrapper, __spreadValues({
        items,
        trigger
      }, rest));
      if (target) {
        menu.attach(target);
      }
      return menu;
    }
  };
  __publicField(_SOContextMenu, "NAME", "contextMenu");
  __publicField(_SOContextMenu, "DEFAULTS", {
    items: [],
    // Menu items configuration
    trigger: "contextmenu",
    // 'contextmenu' or 'click'
    disabled: false,
    // Disable entire menu
    closeOnSelect: true,
    // Close menu when item selected
    closeOnOutsideClick: true,
    // Close on click outside
    submenuDelay: 200,
    // Delay before opening submenu (ms)
    animated: false
    // Use animation keyframes
  });
  __publicField(_SOContextMenu, "EVENTS", {
    SHOW: "contextmenu:show",
    SHOWN: "contextmenu:shown",
    HIDE: "contextmenu:hide",
    HIDDEN: "contextmenu:hidden",
    SELECT: "contextmenu:select",
    SUBMENU_SHOW: "contextmenu:submenu:show",
    SUBMENU_HIDE: "contextmenu:submenu:hide"
  });
  var SOContextMenu = _SOContextMenu;
  SOContextMenu.register();
  window.SOContextMenu = SOContextMenu;

  // src/js/components/so-otp.js
  var _SOOtpInput = class _SOOtpInput extends so_component_default {
    /**
     * Initialize the OTP input
     * @private
     */
    _init() {
      var _a;
      this._inputs = this.$$(this.options.inputSelector);
      if (this._inputs.length === 0)
        return;
      this._bindEvents();
      if (this.options.autoFocus) {
        (_a = this._inputs[0]) == null ? void 0 : _a.focus();
      }
    }
    /**
     * Bind event listeners
     * @private
     */
    _bindEvents() {
      this._inputs.forEach((input, index) => {
        this.on("input", (e) => this._handleInput(e, index), input);
        this.on("keydown", (e) => this._handleKeydown(e, index), input);
        this.on("paste", (e) => this._handlePaste(e, index), input);
        this.on("focus", () => input.select(), input);
      });
    }
    /**
     * Handle input event
     * @param {Event} e - Input event
     * @param {number} index - Input index
     * @private
     */
    _handleInput(e, index) {
      const input = e.target;
      let value = input.value;
      if (this.options.numericOnly) {
        value = value.replace(/[^0-9]/g, "");
      }
      value = value.slice(0, 1);
      input.value = value;
      if (value) {
        input.classList.add("filled");
        if (index < this._inputs.length - 1) {
          this._inputs[index + 1].focus();
        }
      } else {
        input.classList.remove("filled");
      }
      this.emit(_SOOtpInput.EVENTS.CHANGE, { value: this.getValue(), index });
      this._checkComplete();
    }
    /**
     * Handle keydown event
     * @param {KeyboardEvent} e - Keyboard event
     * @param {number} index - Input index
     * @private
     */
    _handleKeydown(e, index) {
      const input = e.target;
      if (e.key === "Backspace") {
        if (!input.value && index > 0) {
          const prevInput = this._inputs[index - 1];
          prevInput.value = "";
          prevInput.classList.remove("filled");
          prevInput.focus();
        } else {
          input.classList.remove("filled");
        }
      }
      if (e.key === "ArrowLeft" && index > 0) {
        e.preventDefault();
        this._inputs[index - 1].focus();
      }
      if (e.key === "ArrowRight" && index < this._inputs.length - 1) {
        e.preventDefault();
        this._inputs[index + 1].focus();
      }
      if (this.options.numericOnly && e.key.length === 1 && !/[0-9]/.test(e.key) && !e.ctrlKey && !e.metaKey) {
        e.preventDefault();
      }
    }
    /**
     * Handle paste event
     * @param {ClipboardEvent} e - Paste event
     * @param {number} startIndex - Starting input index
     * @private
     */
    _handlePaste(e, startIndex) {
      e.preventDefault();
      const pastedData = (e.clipboardData || window.clipboardData).getData("text");
      let chars = this.options.numericOnly ? pastedData.replace(/[^0-9]/g, "").split("") : pastedData.split("");
      chars.forEach((char, i) => {
        const inputIndex = startIndex + i;
        if (this._inputs[inputIndex]) {
          this._inputs[inputIndex].value = char;
          this._inputs[inputIndex].classList.add("filled");
        }
      });
      const nextEmptyIndex = this._inputs.findIndex((input) => !input.value);
      if (nextEmptyIndex !== -1) {
        this._inputs[nextEmptyIndex].focus();
      } else {
        this._inputs[this._inputs.length - 1].focus();
      }
      this.emit(_SOOtpInput.EVENTS.CHANGE, { value: this.getValue() });
      this._checkComplete();
    }
    /**
     * Check if all inputs are filled
     * @private
     */
    _checkComplete() {
      const value = this.getValue();
      if (value.length === this._inputs.length) {
        this.emit(_SOOtpInput.EVENTS.COMPLETE, { value });
      }
    }
    // ============================================
    // PUBLIC API
    // ============================================
    /**
     * Get the current OTP value
     * @returns {string} Combined OTP value
     */
    getValue() {
      return this._inputs.map((input) => input.value).join("");
    }
    /**
     * Set the OTP value
     * @param {string} value - OTP value to set
     * @returns {this} For chaining
     */
    setValue(value) {
      const chars = value.toString().split("");
      this._inputs.forEach((input, i) => {
        const char = chars[i] || "";
        input.value = char;
        input.classList.toggle("filled", !!char);
      });
      this.emit(_SOOtpInput.EVENTS.CHANGE, { value: this.getValue() });
      this._checkComplete();
      return this;
    }
    /**
     * Clear all inputs
     * @returns {this} For chaining
     */
    clear() {
      var _a;
      this._inputs.forEach((input) => {
        input.value = "";
        input.classList.remove("filled", "error");
      });
      if (this.options.autoFocus) {
        (_a = this._inputs[0]) == null ? void 0 : _a.focus();
      }
      this.emit(_SOOtpInput.EVENTS.CHANGE, { value: "" });
      return this;
    }
    /**
     * Focus the first empty input
     * @returns {this} For chaining
     */
    focus() {
      var _a;
      const emptyInput = this._inputs.find((input) => !input.value);
      (_a = emptyInput || this._inputs[0]) == null ? void 0 : _a.focus();
      return this;
    }
    /**
     * Set error state on inputs
     * @param {boolean} [hasError=true] - Whether to show error state
     * @returns {this} For chaining
     */
    setError(hasError = true) {
      this._inputs.forEach((input) => {
        input.classList.toggle("error", hasError);
      });
      return this;
    }
    /**
     * Check if OTP is complete
     * @returns {boolean} Whether all inputs are filled
     */
    isComplete() {
      return this.getValue().length === this._inputs.length;
    }
    /**
     * Validate the OTP against a value
     * @param {string} expected - Expected OTP value
     * @returns {boolean} Whether OTP matches
     */
    validate(expected) {
      const isValid = this.getValue() === expected.toString();
      this.setError(!isValid);
      return isValid;
    }
  };
  __publicField(_SOOtpInput, "NAME", "otp");
  __publicField(_SOOtpInput, "DEFAULTS", {
    length: 6,
    inputSelector: ".so-otp-input",
    autoFocus: true,
    numericOnly: true
  });
  __publicField(_SOOtpInput, "EVENTS", {
    COMPLETE: "otp:complete",
    CHANGE: "otp:change"
  });
  var SOOtpInput = _SOOtpInput;
  SOOtpInput.register();
  window.SOOtpInput = SOOtpInput;

  // src/js/components/so-button-group.js
  var _SOButtonGroup = class _SOButtonGroup extends so_component_default {
    // ============================================
    // INITIALIZATION
    // ============================================
    /**
     * Initialize the button group component
     * @private
     */
    _init() {
      this.options.type = this.element.dataset.toggleType || this.options.type;
      this.options.enforceSelection = this.element.dataset.enforceSelection === "true" || this.options.enforceSelection;
      this._inputs = this.$$(".so-btn-check");
      this._buttons = this._inputs.map((input) => input.nextElementSibling);
      this._bindEvents();
      this._setupAria();
    }
    /**
     * Bind event listeners
     * @private
     */
    _bindEvents() {
      this._inputs.forEach((input) => {
        this.on("change", this._handleChange, input);
      });
      if (this.options.enforceSelection && this.options.type === "radio") {
        this._inputs.forEach((input) => {
          this.on("click", this._handleRadioClick, input);
        });
      }
      if (this.options.keyboard) {
        this.on("keydown", this._handleKeydown);
      }
    }
    /**
     * Set up ARIA attributes
     * @private
     */
    _setupAria() {
      if (this.options.type === "radio") {
        this.element.setAttribute("role", "group");
      } else {
        this.element.setAttribute("role", "group");
      }
      if (this.element.classList.contains("so-btn-group-vertical")) {
        this.element.setAttribute("aria-orientation", "vertical");
      }
      this._inputs.forEach((input, index) => {
        const button = this._buttons[index];
        if (button) {
          if (button.tagName === "LABEL") {
          }
        }
      });
    }
    // ============================================
    // EVENT HANDLERS
    // ============================================
    /**
     * Handle input change
     * @param {Event} e - Change event
     * @private
     */
    _handleChange(e) {
      const input = e.target;
      const value = input.value;
      const checked = input.checked;
      if (this.options.enforceSelection && this.options.type === "checkbox" && !checked) {
        const checkedInputs = this._inputs.filter((i) => i.checked);
        if (checkedInputs.length === 0) {
          input.checked = true;
          return;
        }
      }
      this.emit(_SOButtonGroup.EVENTS.CHANGE, {
        value: this.getValue(),
        changed: value,
        checked,
        input
      });
    }
    /**
     * Handle radio click for enforced selection
     * @param {Event} e - Click event
     * @private
     */
    _handleRadioClick(e) {
      const input = e.target;
      if (input._wasChecked && this.options.enforceSelection) {
        e.preventDefault();
        input.checked = true;
      }
      this._inputs.forEach((i) => {
        i._wasChecked = i.checked;
      });
    }
    /**
     * Handle keyboard navigation
     * @param {KeyboardEvent} e - Keyboard event
     * @private
     */
    _handleKeydown(e) {
      const isVertical = this.element.classList.contains("so-btn-group-vertical");
      const enabledInputs = this._inputs.filter((input) => !input.disabled);
      if (enabledInputs.length === 0)
        return;
      const focusedElement = document.activeElement;
      const currentInput = enabledInputs.find((input) => {
        const label = input.nextElementSibling;
        return label === focusedElement || input === focusedElement;
      });
      if (!currentInput)
        return;
      const currentIndex = enabledInputs.indexOf(currentInput);
      let newIndex = currentIndex;
      switch (e.key) {
        case "ArrowLeft":
          if (!isVertical) {
            e.preventDefault();
            newIndex = currentIndex - 1;
            if (newIndex < 0)
              newIndex = enabledInputs.length - 1;
          }
          break;
        case "ArrowRight":
          if (!isVertical) {
            e.preventDefault();
            newIndex = currentIndex + 1;
            if (newIndex >= enabledInputs.length)
              newIndex = 0;
          }
          break;
        case "ArrowUp":
          if (isVertical) {
            e.preventDefault();
            newIndex = currentIndex - 1;
            if (newIndex < 0)
              newIndex = enabledInputs.length - 1;
          }
          break;
        case "ArrowDown":
          if (isVertical) {
            e.preventDefault();
            newIndex = currentIndex + 1;
            if (newIndex >= enabledInputs.length)
              newIndex = 0;
          }
          break;
        case "Home":
          e.preventDefault();
          newIndex = 0;
          break;
        case "End":
          e.preventDefault();
          newIndex = enabledInputs.length - 1;
          break;
        case " ":
        case "Enter":
          e.preventDefault();
          if (this.options.type === "checkbox") {
            enabledInputs[currentIndex].checked = !enabledInputs[currentIndex].checked;
            enabledInputs[currentIndex].dispatchEvent(new Event("change", { bubbles: true }));
          } else {
            enabledInputs[currentIndex].checked = true;
            enabledInputs[currentIndex].dispatchEvent(new Event("change", { bubbles: true }));
          }
          return;
        default:
          return;
      }
      if (newIndex !== currentIndex && newIndex >= 0) {
        const newLabel = enabledInputs[newIndex].nextElementSibling;
        if (newLabel) {
          newLabel.focus();
        }
      }
    }
    // ============================================
    // PUBLIC API
    // ============================================
    /**
     * Get current selected value(s)
     * @returns {string|string[]|null} Selected value (radio) or array of values (checkbox)
     */
    getValue() {
      if (this.options.type === "radio") {
        const checked = this._inputs.find((input) => input.checked);
        return checked ? checked.value : null;
      } else {
        return this._inputs.filter((input) => input.checked).map((input) => input.value);
      }
    }
    /**
     * Set selected value(s)
     * @param {string|string[]} value - Value or array of values to select
     * @returns {this} For chaining
     */
    setValue(value) {
      if (this.options.type === "radio") {
        const valueStr = String(value);
        this._inputs.forEach((input) => {
          input.checked = input.value === valueStr;
        });
      } else {
        const values = Array.isArray(value) ? value : [value];
        this._inputs.forEach((input) => {
          input.checked = values.includes(input.value);
        });
      }
      this.emit(_SOButtonGroup.EVENTS.CHANGE, {
        value: this.getValue(),
        changed: null,
        checked: null,
        programmatic: true
      });
      return this;
    }
    /**
     * Toggle a specific button by value
     * @param {string} value - Value of button to toggle
     * @returns {this} For chaining
     */
    toggle(value) {
      const input = this._inputs.find((i) => i.value === value);
      if (!input || input.disabled)
        return this;
      if (this.options.type === "radio") {
        input.checked = true;
      } else {
        if (this.options.enforceSelection && input.checked) {
          const checkedCount = this._inputs.filter((i) => i.checked).length;
          if (checkedCount <= 1) {
            return this;
          }
        }
        input.checked = !input.checked;
      }
      input.dispatchEvent(new Event("change", { bubbles: true }));
      return this;
    }
    /**
     * Toggle button by index
     * @param {number} index - Index of button to toggle (0-based)
     * @returns {this} For chaining
     */
    toggleIndex(index) {
      const input = this._inputs[index];
      if (!input)
        return this;
      return this.toggle(input.value);
    }
    /**
     * Select all buttons (checkbox mode only)
     * @returns {this} For chaining
     */
    selectAll() {
      if (this.options.type !== "checkbox")
        return this;
      this._inputs.forEach((input) => {
        if (!input.disabled) {
          input.checked = true;
        }
      });
      this.emit(_SOButtonGroup.EVENTS.CHANGE, {
        value: this.getValue(),
        changed: null,
        checked: true,
        programmatic: true
      });
      return this;
    }
    /**
     * Deselect all buttons
     * @returns {this} For chaining
     */
    deselectAll() {
      if (this.options.enforceSelection)
        return this;
      this._inputs.forEach((input) => {
        input.checked = false;
      });
      this.emit(_SOButtonGroup.EVENTS.CHANGE, {
        value: this.getValue(),
        changed: null,
        checked: false,
        programmatic: true
      });
      return this;
    }
    /**
     * Enable all buttons
     * @returns {this} For chaining
     */
    enable() {
      this._inputs.forEach((input) => {
        input.disabled = false;
      });
      return super.enable();
    }
    /**
     * Disable all buttons
     * @returns {this} For chaining
     */
    disable() {
      this._inputs.forEach((input) => {
        input.disabled = true;
      });
      return super.disable();
    }
    /**
     * Enable a specific button by value
     * @param {string} value - Value of button to enable
     * @returns {this} For chaining
     */
    enableButton(value) {
      const input = this._inputs.find((i) => i.value === value);
      if (input) {
        input.disabled = false;
      }
      return this;
    }
    /**
     * Disable a specific button by value
     * @param {string} value - Value of button to disable
     * @returns {this} For chaining
     */
    disableButton(value) {
      const input = this._inputs.find((i) => i.value === value);
      if (input) {
        input.disabled = true;
      }
      return this;
    }
    /**
     * Get all button values
     * @returns {string[]} Array of all button values
     */
    getValues() {
      return this._inputs.map((input) => input.value);
    }
    /**
     * Check if a specific value is selected
     * @param {string} value - Value to check
     * @returns {boolean} Whether the value is selected
     */
    isSelected(value) {
      const input = this._inputs.find((i) => i.value === value);
      return input ? input.checked : false;
    }
    /**
     * Get the number of selected buttons
     * @returns {number} Count of selected buttons
     */
    getSelectedCount() {
      return this._inputs.filter((input) => input.checked).length;
    }
    /**
     * Refresh the component (re-scan for inputs)
     * @returns {this} For chaining
     */
    refresh() {
      this._inputs = this.$$(".so-btn-check");
      this._buttons = this._inputs.map((input) => input.nextElementSibling);
      this._setupAria();
      return this;
    }
  };
  __publicField(_SOButtonGroup, "NAME", "buttonGroup");
  __publicField(_SOButtonGroup, "DEFAULTS", {
    type: "checkbox",
    // 'radio' or 'checkbox'
    enforceSelection: false,
    // Prevent deselecting last item
    keyboard: true
    // Enable keyboard navigation
  });
  __publicField(_SOButtonGroup, "EVENTS", {
    CHANGE: "toggle:change"
  });
  var SOButtonGroup = _SOButtonGroup;
  SOButtonGroup.register();
  document.addEventListener("DOMContentLoaded", () => {
    SOButtonGroup.initAll('[data-so-toggle="buttons"]');
  });
  window.SOButtonGroup = SOButtonGroup;

  // src/js/components/so-progress-button.js
  var _SOProgressButton = class _SOProgressButton extends so_component_default {
    // ============================================
    // INITIALIZATION
    // ============================================
    /**
     * Initialize the progress button component
     * @private
     */
    _init() {
      this._state = _SOProgressButton.STATES.IDLE;
      this._progress = 0;
      this._simulateInterval = null;
      this._progressBar = this.$(".so-btn-progress-bar");
      this._textEl = this.$(".so-btn-text");
      this._startEl = this.$(".so-btn-start");
      this._doneEl = this.$(".so-btn-done");
      this._parseDataOptions();
      this._bindEvents();
    }
    /**
     * Parse additional data attributes
     * @private
     */
    _parseDataOptions() {
      const el = this.element;
      if (el.dataset.autoDisable !== void 0) {
        this.options.autoDisable = el.dataset.autoDisable !== "false";
      }
      if (el.dataset.autoReset !== void 0) {
        this.options.autoReset = parseInt(el.dataset.autoReset, 10) || 0;
      }
      if (el.dataset.simulateOnClick !== void 0) {
        this.options.simulateOnClick = el.dataset.simulateOnClick === "true";
      }
    }
    /**
     * Bind event listeners
     * @private
     */
    _bindEvents() {
      if (this.options.simulateOnClick) {
        this.on("click", this._handleClick);
      }
    }
    /**
     * Handle click for simulate mode
     * @param {Event} e - Click event
     * @private
     */
    _handleClick(e) {
      if (this._state === _SOProgressButton.STATES.COMPLETED) {
        this.reset();
      } else if (this._state === _SOProgressButton.STATES.IDLE) {
        this.simulate();
      }
    }
    // ============================================
    // PUBLIC API
    // ============================================
    /**
     * Start progress (enter progressing state)
     * @param {number} [initialProgress=0] - Initial progress value (0-100)
     * @returns {this} For chaining
     */
    start(initialProgress = 0) {
      if (this._state === _SOProgressButton.STATES.PROGRESSING) {
        return this;
      }
      this._state = _SOProgressButton.STATES.PROGRESSING;
      this._progress = Math.max(0, Math.min(100, initialProgress));
      this.element.classList.add("so-progressing");
      this.element.classList.remove("so-completed");
      this._updateProgressBar();
      if (this.options.autoDisable) {
        this.element.disabled = true;
      }
      this.emit(_SOProgressButton.EVENTS.START, {
        progress: this._progress,
        state: this._state
      });
      return this;
    }
    /**
     * Set progress value
     * @param {number} value - Progress value (0-100)
     * @returns {this} For chaining
     */
    setProgress(value) {
      if (this._state === _SOProgressButton.STATES.IDLE) {
        this.start(value);
        return this;
      }
      if (this._state !== _SOProgressButton.STATES.PROGRESSING) {
        return this;
      }
      const oldProgress = this._progress;
      this._progress = Math.max(0, Math.min(100, value));
      this._updateProgressBar();
      this.emit(_SOProgressButton.EVENTS.PROGRESS, {
        progress: this._progress,
        previousProgress: oldProgress,
        state: this._state
      });
      if (this._progress >= 100) {
        this._doComplete();
      }
      return this;
    }
    /**
     * Increment progress by a value
     * @param {number} amount - Amount to increment
     * @returns {this} For chaining
     */
    increment(amount) {
      return this.setProgress(this._progress + amount);
    }
    /**
     * Complete the progress (enter completed state)
     * @returns {this} For chaining
     */
    complete() {
      if (this._state === _SOProgressButton.STATES.COMPLETED) {
        return this;
      }
      this._stopSimulation();
      this._progress = 100;
      this._updateProgressBar();
      setTimeout(() => this._doComplete(), 200);
      return this;
    }
    /**
     * Internal complete handler
     * @private
     */
    _doComplete() {
      this._state = _SOProgressButton.STATES.COMPLETED;
      this.element.classList.remove("so-progressing");
      this.element.classList.add("so-completed");
      if (this.options.autoDisable) {
        this.element.disabled = false;
      }
      this.emit(_SOProgressButton.EVENTS.COMPLETE, {
        progress: 100,
        state: this._state
      });
      if (this.options.autoReset > 0) {
        setTimeout(() => this.reset(), this.options.autoReset);
      }
    }
    /**
     * Reset to initial state
     * @returns {this} For chaining
     */
    reset() {
      this._stopSimulation();
      this._state = _SOProgressButton.STATES.IDLE;
      this._progress = 0;
      this.element.classList.remove("so-progressing", "so-completed");
      this._updateProgressBar();
      this.element.disabled = false;
      this.emit(_SOProgressButton.EVENTS.RESET, {
        progress: 0,
        state: this._state
      });
      return this;
    }
    /**
     * Simulate progress automatically
     * @param {Object} [options] - Simulation options
     * @param {number} [options.speed] - Interval in ms
     * @param {number[]} [options.increment] - [min, max] random increment
     * @returns {this} For chaining
     */
    simulate(options = {}) {
      const speed = options.speed || this.options.simulateSpeed;
      const [minInc, maxInc] = options.increment || this.options.simulateIncrement;
      this.start(0);
      this._simulateInterval = setInterval(() => {
        const increment = Math.random() * (maxInc - minInc) + minInc;
        const newProgress = this._progress + increment;
        if (newProgress >= 100) {
          this._stopSimulation();
          this.setProgress(100);
        } else {
          this.setProgress(newProgress);
        }
      }, speed);
      return this;
    }
    /**
     * Stop simulation
     * @private
     */
    _stopSimulation() {
      if (this._simulateInterval) {
        clearInterval(this._simulateInterval);
        this._simulateInterval = null;
      }
    }
    /**
     * Update progress bar CSS
     * @private
     */
    _updateProgressBar() {
      this.element.style.setProperty("--progress", `${this._progress}%`);
    }
    // ============================================
    // GETTERS
    // ============================================
    /**
     * Get current progress value
     * @returns {number} Progress (0-100)
     */
    getProgress() {
      return this._progress;
    }
    /**
     * Get current state
     * @returns {string} Current state (idle, progressing, completed)
     */
    getState() {
      return this._state;
    }
    /**
     * Check if button is progressing
     * @returns {boolean}
     */
    isProgressing() {
      return this._state === _SOProgressButton.STATES.PROGRESSING;
    }
    /**
     * Check if button is completed
     * @returns {boolean}
     */
    isCompleted() {
      return this._state === _SOProgressButton.STATES.COMPLETED;
    }
    /**
     * Check if button is idle
     * @returns {boolean}
     */
    isIdle() {
      return this._state === _SOProgressButton.STATES.IDLE;
    }
    // ============================================
    // CONTENT MANIPULATION
    // ============================================
    /**
     * Set the main text content
     * @param {string} html - HTML content
     * @returns {this} For chaining
     */
    setText(html) {
      if (this._textEl) {
        this._textEl.innerHTML = html;
      }
      return this;
    }
    /**
     * Set the start content (shown during progress)
     * @param {string} html - HTML content
     * @returns {this} For chaining
     */
    setStartContent(html) {
      if (this._startEl) {
        this._startEl.innerHTML = html;
      }
      return this;
    }
    /**
     * Set the done content (shown on complete)
     * @param {string} html - HTML content
     * @returns {this} For chaining
     */
    setDoneContent(html) {
      if (this._doneEl) {
        this._doneEl.innerHTML = html;
      }
      return this;
    }
    // ============================================
    // LIFECYCLE
    // ============================================
    /**
     * Destroy the component
     */
    destroy() {
      this._stopSimulation();
      this.reset();
      super.destroy();
    }
  };
  __publicField(_SOProgressButton, "NAME", "progressButton");
  __publicField(_SOProgressButton, "DEFAULTS", {
    autoDisable: true,
    // Disable button during progress
    autoReset: false,
    // Auto reset after complete (ms, 0 = disabled)
    simulateOnClick: false,
    // Auto-simulate progress on click
    simulateSpeed: 150,
    // Interval for simulated progress (ms)
    simulateIncrement: [5, 15]
    // Random increment range [min, max]
  });
  __publicField(_SOProgressButton, "EVENTS", {
    START: "progress:start",
    PROGRESS: "progress:update",
    COMPLETE: "progress:complete",
    RESET: "progress:reset"
  });
  __publicField(_SOProgressButton, "STATES", {
    IDLE: "idle",
    PROGRESSING: "progressing",
    COMPLETED: "completed"
  });
  var SOProgressButton = _SOProgressButton;
  SOProgressButton.register();
  document.addEventListener("DOMContentLoaded", () => {
    SOProgressButton.initAll(".so-btn-progress[data-so-progress]");
  });
  window.SOProgressButton = SOProgressButton;

  // src/js/features/so-forms.js
  var SOForms2 = class _SOForms {
    /**
     * Initialize all form components on the page
     */
    static initAll() {
      document.querySelectorAll(".so-dropdown").forEach((el) => {
        SODropdown.getInstance(el);
      });
      document.querySelectorAll(".so-searchable-dropdown").forEach((el) => {
        SODropdown.getInstance(el);
      });
      document.querySelectorAll(".so-options-dropdown").forEach((el) => {
        SODropdown.getInstance(el);
      });
      document.querySelectorAll(".so-outlet-dropdown").forEach((el) => {
        SODropdown.getInstance(el);
      });
      document.querySelectorAll(".so-otp-group").forEach((el) => {
        SOOtpInput.getInstance(el);
      });
      document.querySelectorAll('[data-so-toggle="buttons"]').forEach((el) => {
        SOButtonGroup.getInstance(el);
      });
      document.querySelectorAll(".so-btn-progress[data-so-progress]").forEach((el) => {
        SOProgressButton.getInstance(el);
      });
      _SOForms._initCheckboxes();
      _SOForms._initInputEnhancements();
    }
    /**
     * Initialize custom checkbox styling
     * @private
     */
    static _initCheckboxes() {
      document.querySelectorAll('input[type="checkbox"]:not(.so-checkbox input)').forEach((checkbox) => {
        if (checkbox.closest(".so-checkbox, .so-toggle, .so-switch, .so-btn-check"))
          return;
        const wrapper = document.createElement("label");
        wrapper.className = "so-checkbox";
        const box = document.createElement("span");
        box.className = "so-checkbox-box";
        box.innerHTML = '<span class="material-icons">check</span>';
        checkbox.parentNode.insertBefore(wrapper, checkbox);
        wrapper.appendChild(checkbox);
        wrapper.appendChild(box);
      });
    }
    /**
     * Initialize input enhancements
     * @private
     */
    static _initInputEnhancements() {
      document.querySelectorAll(".so-password-toggle").forEach((btn) => {
        btn.addEventListener("click", () => {
          const wrapper = btn.closest(".so-form-input-wrapper, .so-auth-input-wrapper");
          const input = wrapper == null ? void 0 : wrapper.querySelector("input");
          if (!input)
            return;
          const isPassword = input.type === "password";
          input.type = isPassword ? "text" : "password";
          btn.querySelector(".material-icons").textContent = isPassword ? "visibility_off" : "visibility";
        });
      });
      document.querySelectorAll(".so-input-clear").forEach((btn) => {
        const wrapper = btn.closest(".so-input-wrapper, .so-form-input-wrapper");
        const input = wrapper == null ? void 0 : wrapper.querySelector("input");
        btn.addEventListener("click", () => {
          if (input) {
            input.value = "";
            input.focus();
            input.dispatchEvent(new Event("input", { bubbles: true }));
          }
        });
        if (input) {
          input.addEventListener("keydown", (e) => {
            if (e.key === "Escape" && input.value.trim() !== "") {
              e.preventDefault();
              e.stopPropagation();
              input.value = "";
              input.dispatchEvent(new Event("input", { bubbles: true }));
            }
          });
        }
      });
      document.querySelectorAll(".so-form-floating input, .so-form-floating textarea").forEach((input) => {
        const updateState = () => {
          const hasValue = input.value.trim() !== "";
          input.classList.toggle("has-value", hasValue);
        };
        input.addEventListener("input", updateState);
        input.addEventListener("change", updateState);
        updateState();
      });
      document.querySelectorAll(".so-form-control-autosize, .so-form-control-autosize-sm, .so-form-control-autosize-lg").forEach((textarea) => {
        let defaultMinHeight = 80;
        let defaultMaxHeight = 400;
        if (textarea.classList.contains("so-form-control-autosize-sm")) {
          defaultMinHeight = 60;
          defaultMaxHeight = 200;
        } else if (textarea.classList.contains("so-form-control-autosize-lg")) {
          defaultMinHeight = 120;
          defaultMaxHeight = 600;
        }
        const options = {
          minHeight: parseInt(textarea.dataset.minHeight) || defaultMinHeight,
          maxHeight: parseInt(textarea.dataset.maxHeight) || defaultMaxHeight
        };
        SOTextareaAutosize.getInstance(textarea, options);
      });
    }
    // ============================================
    // VALIDATION
    // ============================================
    /**
     * Validate an email address
     * @param {string} email - Email to validate
     * @returns {boolean} Whether email is valid
     */
    static validateEmail(email) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return regex.test(email);
    }
    /**
     * Validate a phone number (10 digits)
     * @param {string} phone - Phone number to validate
     * @returns {boolean} Whether phone is valid
     */
    static validatePhone(phone) {
      const cleaned = phone.replace(/[\s\-\(\)]/g, "");
      return /^[0-9]{10}$/.test(cleaned);
    }
    /**
     * Validate a required field
     * @param {string} value - Value to validate
     * @returns {boolean} Whether value is not empty
     */
    static validateRequired(value) {
      return value !== null && value !== void 0 && value.toString().trim() !== "";
    }
    /**
     * Validate minimum length
     * @param {string} value - Value to validate
     * @param {number} minLength - Minimum length
     * @returns {boolean} Whether value meets minimum length
     */
    static validateMinLength(value, minLength) {
      return value.length >= minLength;
    }
    /**
     * Validate maximum length
     * @param {string} value - Value to validate
     * @param {number} maxLength - Maximum length
     * @returns {boolean} Whether value is within maximum length
     */
    static validateMaxLength(value, maxLength) {
      return value.length <= maxLength;
    }
    /**
     * Validate password strength
     * @param {string} password - Password to validate
     * @param {Object} options - Validation options
     * @returns {Object} Validation result with individual checks
     */
    static validatePassword(password, options = {}) {
      const {
        minLength = 8,
        requireUppercase = true,
        requireLowercase = true,
        requireNumber = true,
        requireSpecial = false
      } = options;
      const result = {
        valid: true,
        length: password.length >= minLength,
        uppercase: !requireUppercase || /[A-Z]/.test(password),
        lowercase: !requireLowercase || /[a-z]/.test(password),
        number: !requireNumber || /[0-9]/.test(password),
        special: !requireSpecial || /[!@#$%^&*(),.?":{}|<>]/.test(password)
      };
      result.valid = result.length && result.uppercase && result.lowercase && result.number && result.special;
      return result;
    }
    /**
     * Validate that two values match
     * @param {string} value1 - First value
     * @param {string} value2 - Second value
     * @returns {boolean} Whether values match
     */
    static validateMatch(value1, value2) {
      return value1 === value2;
    }
    // ============================================
    // FORM STATE
    // ============================================
    /**
     * Show error state on a form group
     * @param {string} fieldId - Field ID (without 'Group' suffix)
     * @param {string} message - Error message
     */
    static showError(fieldId, message) {
      const group = document.getElementById(`${fieldId}Group`);
      const errorEl = document.getElementById(`${fieldId}Error`);
      if (group) {
        group.classList.remove("has-success", "has-warning", "has-info");
        group.classList.add("has-error");
      }
      if (errorEl && message) {
        errorEl.textContent = message;
      }
    }
    /**
     * Show success state on a form group
     * @param {string} fieldId - Field ID (without 'Group' suffix)
     * @param {string} message - Success message (optional)
     */
    static showSuccess(fieldId, message = "") {
      const group = document.getElementById(`${fieldId}Group`);
      const successEl = document.getElementById(`${fieldId}Success`);
      if (group) {
        group.classList.remove("has-error", "has-warning", "has-info");
        group.classList.add("has-success");
      }
      if (successEl && message) {
        successEl.textContent = message;
      }
    }
    /**
     * Show warning state on a form group
     * @param {string} fieldId - Field ID (without 'Group' suffix)
     * @param {string} message - Warning message
     */
    static showWarning(fieldId, message) {
      const group = document.getElementById(`${fieldId}Group`);
      const warningEl = document.getElementById(`${fieldId}Warning`);
      if (group) {
        group.classList.remove("has-error", "has-success", "has-info");
        group.classList.add("has-warning");
      }
      if (warningEl && message) {
        warningEl.textContent = message;
      }
    }
    /**
     * Show info state on a form group
     * @param {string} fieldId - Field ID (without 'Group' suffix)
     * @param {string} message - Info message
     */
    static showInfo(fieldId, message) {
      const group = document.getElementById(`${fieldId}Group`);
      const infoEl = document.getElementById(`${fieldId}Info`);
      if (group) {
        group.classList.remove("has-error", "has-success", "has-warning");
        group.classList.add("has-info");
      }
      if (infoEl && message) {
        infoEl.textContent = message;
      }
    }
    /**
     * Clear error state on a form group
     * @param {string} fieldId - Field ID (without 'Group' suffix)
     */
    static clearError(fieldId) {
      const group = document.getElementById(`${fieldId}Group`);
      if (group) {
        group.classList.remove("has-error");
      }
    }
    /**
     * Clear all validation states on a form group
     * @param {string} fieldId - Field ID (without 'Group' suffix)
     */
    static clearValidation(fieldId) {
      const group = document.getElementById(`${fieldId}Group`);
      if (group) {
        group.classList.remove("has-error", "has-success", "has-warning", "has-info");
      }
    }
    /**
     * Clear all errors in a form
     * @param {HTMLFormElement|string} form - Form element or selector
     */
    static clearAllErrors(form) {
      const formEl = typeof form === "string" ? document.querySelector(form) : form;
      if (!formEl)
        return;
      formEl.querySelectorAll(".has-error").forEach((el) => {
        el.classList.remove("has-error");
      });
    }
    /**
     * Set loading state on a button
     * @param {HTMLButtonElement|string} button - Button element or selector
     * @param {boolean} isLoading - Whether to show loading state
     */
    static setButtonLoading(button, isLoading) {
      const btn = typeof button === "string" ? document.querySelector(button) : button;
      if (!btn)
        return;
      if (isLoading) {
        btn.classList.add("so-loading");
        btn.disabled = true;
      } else {
        btn.classList.remove("so-loading");
        btn.disabled = false;
      }
    }
    /**
     * Get form data as an object
     * @param {HTMLFormElement|string} form - Form element or selector
     * @returns {Object} Form data object
     */
    static getFormData(form) {
      const formEl = typeof form === "string" ? document.querySelector(form) : form;
      if (!formEl)
        return {};
      const formData = new FormData(formEl);
      const data = {};
      for (const [key, value] of formData.entries()) {
        if (data[key]) {
          if (!Array.isArray(data[key])) {
            data[key] = [data[key]];
          }
          data[key].push(value);
        } else {
          data[key] = value;
        }
      }
      return data;
    }
    /**
     * Set form data from an object
     * @param {HTMLFormElement|string} form - Form element or selector
     * @param {Object} data - Data object
     */
    static setFormData(form, data) {
      const formEl = typeof form === "string" ? document.querySelector(form) : form;
      if (!formEl)
        return;
      Object.entries(data).forEach(([name, value]) => {
        const field = formEl.elements[name];
        if (!field)
          return;
        if (field.type === "checkbox") {
          field.checked = !!value;
        } else if (field.type === "radio") {
          const radio = formEl.querySelector(`input[name="${name}"][value="${value}"]`);
          if (radio)
            radio.checked = true;
        } else {
          field.value = value;
        }
      });
    }
    /**
     * Reset form to initial state
     * @param {HTMLFormElement|string} form - Form element or selector
     */
    static resetForm(form) {
      const formEl = typeof form === "string" ? document.querySelector(form) : form;
      if (!formEl)
        return;
      formEl.reset();
      _SOForms.clearAllErrors(formEl);
    }
    // ============================================
    // MASKING
    // ============================================
    /**
     * Mask an email address
     * @param {string} email - Email to mask
     * @returns {string} Masked email
     */
    static maskEmail(email) {
      const [local, domain] = email.split("@");
      if (!domain)
        return email;
      const maskedLocal = local.charAt(0) + "*".repeat(Math.min(local.length - 2, 4)) + local.charAt(local.length - 1);
      return `${maskedLocal}@${domain}`;
    }
    /**
     * Mask a phone number
     * @param {string} phone - Phone number to mask
     * @returns {string} Masked phone
     */
    static maskPhone(phone) {
      const cleaned = phone.replace(/[\s\-\(\)]/g, "");
      if (cleaned.length < 4)
        return phone;
      return cleaned.slice(0, 2) + "*".repeat(cleaned.length - 4) + cleaned.slice(-2);
    }
  };
  var SOTextareaAutosize = class _SOTextareaAutosize {
    /**
     * Create autosize textarea
     * @param {HTMLTextAreaElement} element - The textarea element
     * @param {Object} options - Configuration options
     */
    constructor(element, options = {}) {
      this.element = element;
      this.options = __spreadValues({
        minHeight: options.minHeight || 80,
        maxHeight: options.maxHeight || 400
      }, options);
      this._init();
    }
    /**
     * Initialize the autosize functionality
     * @private
     */
    _init() {
      this._originalStyles = {
        height: this.element.style.height,
        overflow: this.element.style.overflow,
        resize: this.element.style.resize
      };
      this.element.style.overflow = "hidden";
      this.element.style.resize = "none";
      this.element.style.minHeight = `${this.options.minHeight}px`;
      this.element.style.maxHeight = `${this.options.maxHeight}px`;
      this._boundResize = this._resize.bind(this);
      this.element.addEventListener("input", this._boundResize);
      this.element.addEventListener("change", this._boundResize);
      this._resize();
      this._boundWindowResize = this._resize.bind(this);
      window.addEventListener("resize", this._boundWindowResize);
    }
    /**
     * Resize the textarea based on content
     * @private
     */
    _resize() {
      this.element.style.height = "auto";
      const scrollHeight = this.element.scrollHeight;
      const newHeight = Math.min(
        Math.max(scrollHeight, this.options.minHeight),
        this.options.maxHeight
      );
      this.element.style.height = `${newHeight}px`;
      if (scrollHeight > this.options.maxHeight) {
        this.element.style.overflow = "auto";
      } else {
        this.element.style.overflow = "hidden";
      }
      this.element.dispatchEvent(new CustomEvent("so:autosize", {
        detail: { height: newHeight, scrollHeight }
      }));
    }
    /**
     * Update the content and resize
     * @param {string} value - New value
     */
    update(value) {
      this.element.value = value;
      this._resize();
    }
    /**
     * Destroy the autosize instance
     */
    destroy() {
      this.element.removeEventListener("input", this._boundResize);
      this.element.removeEventListener("change", this._boundResize);
      window.removeEventListener("resize", this._boundWindowResize);
      this.element.style.height = this._originalStyles.height;
      this.element.style.overflow = this._originalStyles.overflow;
      this.element.style.resize = this._originalStyles.resize;
      this.element.style.minHeight = "";
      this.element.style.maxHeight = "";
      delete this.element._soAutosize;
    }
    /**
     * Get or create instance for element
     * @param {HTMLTextAreaElement} element - The textarea element
     * @param {Object} options - Configuration options
     * @returns {SOTextareaAutosize}
     */
    static getInstance(element, options = {}) {
      if (!element._soAutosize) {
        element._soAutosize = new _SOTextareaAutosize(element, options);
      }
      return element._soAutosize;
    }
  };
  document.addEventListener("DOMContentLoaded", () => {
    SOForms2.initAll();
  });
  window.SOForms = SOForms2;
  window.SOTextareaAutosize = SOTextareaAutosize;
  window.SOButtonGroup = SOButtonGroup;
  window.SOProgressButton = SOProgressButton;

  // src/js/features/so-chips.js
  var SOChips = class {
    constructor() {
      this.init();
    }
    init() {
      if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", () => {
          this.bindAll();
        });
      } else {
        this.bindAll();
      }
      this.observeDOM();
    }
    bindAll() {
      this.bindCloseButtons();
      this.bindSelectableChips();
    }
    bindCloseButtons() {
      document.querySelectorAll("[data-so-chip] .so-chip-close, [data-so-chip-closable] .so-chip-close").forEach((btn) => {
        if (btn._soChipBound)
          return;
        btn._soChipBound = true;
        btn.addEventListener("click", (e) => {
          e.stopPropagation();
          const chip = btn.closest(".so-chip, [data-so-chip]");
          if (chip) {
            const event = new CustomEvent("so-chip:close", {
              bubbles: true,
              cancelable: true,
              detail: {
                chip,
                value: chip.dataset.value || chip.textContent.trim()
              }
            });
            const shouldRemove = chip.dispatchEvent(event);
            if (shouldRemove) {
              chip.style.transition = "opacity 0.15s, transform 0.15s";
              chip.style.opacity = "0";
              chip.style.transform = "scale(0.8)";
              setTimeout(() => chip.remove(), 150);
            }
          }
        });
      });
    }
    bindSelectableChips() {
      document.querySelectorAll("[data-so-chip-selectable], .so-chip-selectable").forEach((chip) => {
        if (chip._soChipBound)
          return;
        chip._soChipBound = true;
        chip.addEventListener("click", (e) => {
          if (e.target.closest(".so-chip-close"))
            return;
          const isSelected = chip.classList.toggle("so-chip-selected");
          const checkbox = chip.querySelector('input[type="checkbox"]');
          if (checkbox) {
            checkbox.checked = isSelected;
          }
          const eventName = isSelected ? "so-chip:select" : "so-chip:deselect";
          const event = new CustomEvent(eventName, {
            bubbles: true,
            detail: {
              chip,
              value: chip.dataset.value || chip.textContent.trim(),
              selected: isSelected
            }
          });
          chip.dispatchEvent(event);
        });
      });
    }
    observeDOM() {
      const observer = new MutationObserver((mutations) => {
        let shouldRebind = false;
        mutations.forEach((mutation) => {
          if (mutation.addedNodes.length) {
            mutation.addedNodes.forEach((node) => {
              if (node.nodeType === 1) {
                if (node.matches && (node.matches("[data-so-chip], [data-so-chip-closable], [data-so-chip-selectable], .so-chip-selectable") || node.querySelector("[data-so-chip], [data-so-chip-closable], [data-so-chip-selectable], .so-chip-selectable"))) {
                  shouldRebind = true;
                }
              }
            });
          }
        });
        if (shouldRebind) {
          this.bindAll();
        }
      });
      observer.observe(document.body, { childList: true, subtree: true });
    }
    /**
     * Manually close a chip
     * @param {HTMLElement} chip - The chip element to close
     */
    close(chip) {
      if (chip) {
        const closeBtn = chip.querySelector(".so-chip-close");
        if (closeBtn) {
          closeBtn.click();
        } else {
          const event = new CustomEvent("so-chip:close", {
            bubbles: true,
            detail: { chip, value: chip.dataset.value || chip.textContent.trim() }
          });
          chip.dispatchEvent(event);
          chip.remove();
        }
      }
    }
    /**
     * Toggle selection state of a chip
     * @param {HTMLElement} chip - The chip element to toggle
     * @param {boolean} [selected] - Optional explicit state
     */
    toggle(chip, selected) {
      if (chip) {
        if (typeof selected === "boolean") {
          chip.classList.toggle("so-chip-selected", selected);
        } else {
          chip.classList.toggle("so-chip-selected");
        }
        const isSelected = chip.classList.contains("so-chip-selected");
        const checkbox = chip.querySelector('input[type="checkbox"]');
        if (checkbox) {
          checkbox.checked = isSelected;
        }
        const eventName = isSelected ? "so-chip:select" : "so-chip:deselect";
        const event = new CustomEvent(eventName, {
          bubbles: true,
          detail: { chip, value: chip.dataset.value || chip.textContent.trim(), selected: isSelected }
        });
        chip.dispatchEvent(event);
      }
    }
    /**
     * Get all selected chips within a container
     * @param {HTMLElement} [container=document] - Container to search within
     * @returns {Array} Array of selected chip elements
     */
    getSelected(container = document) {
      return Array.from(container.querySelectorAll(".so-chip-selected"));
    }
    /**
     * Get values of all selected chips within a container
     * @param {HTMLElement} [container=document] - Container to search within
     * @returns {Array} Array of chip values
     */
    getSelectedValues(container = document) {
      return this.getSelected(container).map(
        (chip) => chip.dataset.value || chip.textContent.trim()
      );
    }
  };
  var soChips = new SOChips();
  window.SOChips = soChips;

  // src/js/sixorbit-core.js
  document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.querySelector(".so-navbar");
    if (navbar) {
      SONavbar.getInstance(navbar);
    }
    const themeSettings = document.querySelector(".so-navbar-theme");
    if (themeSettings) {
      SOTheme.getInstance(themeSettings);
    }
    SOForms.initAll();
    console.log("SixOrbit UI Core initialized");
  });
})();
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsic3JjL2pzL2NvcmUvc28tY29uZmlnLmpzIiwgInNyYy9qcy9jb3JlL3NvLWNvbXBvbmVudC5qcyIsICJzcmMvanMvY29tcG9uZW50cy9zby10aGVtZS5qcyIsICJzcmMvanMvY29tcG9uZW50cy9zby1kcm9wZG93bi5qcyIsICJzcmMvanMvY29tcG9uZW50cy9zby1sYXlvdXQuanMiLCAic3JjL2pzL2NvbXBvbmVudHMvc28tbW9kYWwuanMiLCAic3JjL2pzL2NvbXBvbmVudHMvc28tcmlwcGxlLmpzIiwgInNyYy9qcy9jb21wb25lbnRzL3NvLWNvbnRleHQtbWVudS5qcyIsICJzcmMvanMvY29tcG9uZW50cy9zby1vdHAuanMiLCAic3JjL2pzL2NvbXBvbmVudHMvc28tYnV0dG9uLWdyb3VwLmpzIiwgInNyYy9qcy9jb21wb25lbnRzL3NvLXByb2dyZXNzLWJ1dHRvbi5qcyIsICJzcmMvanMvZmVhdHVyZXMvc28tZm9ybXMuanMiLCAic3JjL2pzL2ZlYXR1cmVzL3NvLWNoaXBzLmpzIiwgInNyYy9qcy9zaXhvcmJpdC1jb3JlLmpzIl0sCiAgInNvdXJjZXNDb250ZW50IjogWyIvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gU0lYT1JCSVQgVUkgLSBHTE9CQUwgQ09ORklHVVJBVElPTlxuLy8gQ29yZSBjb25maWd1cmF0aW9uIGFuZCB1dGlsaXR5IGhlbHBlcnNcbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbi8qKlxuICogU2l4T3JiaXQgR2xvYmFsIENvbmZpZ3VyYXRpb24gT2JqZWN0XG4gKiBQcm92aWRlcyBjb25zdGFudHMsIGhlbHBlcnMsIGFuZCB1dGlsaXRpZXMgdXNlZCBhY3Jvc3MgYWxsIGNvbXBvbmVudHNcbiAqL1xuY29uc3QgU2l4T3JiaXQgPSB7XG4gIC8vIEV4cG9zZSB0byB3aW5kb3cgaW1tZWRpYXRlbHkgZm9yIG90aGVyIHNjcmlwdHNcbiAgLy8gVGhpcyBlbnN1cmVzIFNpeE9yYml0IGlzIGF2YWlsYWJsZSBiZWZvcmUgYW55IG90aGVyIGNvZGUgcnVuc1xufTtcblxuLy8gRXhwb3NlIHRvIGdsb2JhbCBzY29wZSBpbW1lZGlhdGVseVxud2luZG93LlNpeE9yYml0ID0gU2l4T3JiaXQ7XG5cbi8vIE5vdyBkZWZpbmUgYWxsIHByb3BlcnRpZXNcbk9iamVjdC5hc3NpZ24oU2l4T3JiaXQsIHtcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gQ09SRSBDT05TVEFOVFNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKiogRnJhbWV3b3JrIHZlcnNpb24gKi9cbiAgVkVSU0lPTjogXCIxLjAuMFwiLFxuXG4gIC8qKiBDU1MgY2xhc3MgcHJlZml4ICovXG4gIFBSRUZJWDogXCJzb1wiLFxuXG4gIC8qKiBEYXRhIGF0dHJpYnV0ZSBwcmVmaXggKi9cbiAgREFUQV9QUkVGSVg6IFwiZGF0YS1zb1wiLFxuXG4gIC8qKiBDdXN0b20gZXZlbnQgcHJlZml4ICovXG4gIEVWRU5UX1BSRUZJWDogXCJzbzpcIixcblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBDTEFTUyBOQU1FIEhFTFBFUlNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogR2VuZXJhdGUgYSBwcmVmaXhlZCBjbGFzcyBuYW1lXG4gICAqIEBwYXJhbSB7Li4uc3RyaW5nfSBwYXJ0cyAtIENsYXNzIG5hbWUgcGFydHMgdG8gam9pblxuICAgKiBAcmV0dXJucyB7c3RyaW5nfSBQcmVmaXhlZCBjbGFzcyBuYW1lXG4gICAqIEBleGFtcGxlIFNpeE9yYml0LmNscygnYnRuJywgJ3ByaW1hcnknKSA9PiAnc28tYnRuLXByaW1hcnknXG4gICAqL1xuICBjbHMoLi4ucGFydHMpIHtcbiAgICByZXR1cm4gYCR7dGhpcy5QUkVGSVh9LSR7cGFydHMuam9pbihcIi1cIil9YDtcbiAgfSxcblxuICAvKipcbiAgICogR2VuZXJhdGUgYSBDU1Mgc2VsZWN0b3IgZm9yIGEgcHJlZml4ZWQgY2xhc3NcbiAgICogQHBhcmFtIHsuLi5zdHJpbmd9IHBhcnRzIC0gQ2xhc3MgbmFtZSBwYXJ0c1xuICAgKiBAcmV0dXJucyB7c3RyaW5nfSBDU1Mgc2VsZWN0b3JcbiAgICogQGV4YW1wbGUgU2l4T3JiaXQuc2VsKCdidG4nKSA9PiAnLnNvLWJ0bidcbiAgICovXG4gIHNlbCguLi5wYXJ0cykge1xuICAgIHJldHVybiBgLiR7dGhpcy5jbHMoLi4ucGFydHMpfWA7XG4gIH0sXG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gREFUQSBBVFRSSUJVVEUgSEVMUEVSU1xuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBHZW5lcmF0ZSBhIHByZWZpeGVkIGRhdGEgYXR0cmlidXRlIG5hbWVcbiAgICogQHBhcmFtIHtzdHJpbmd9IG5hbWUgLSBBdHRyaWJ1dGUgbmFtZVxuICAgKiBAcmV0dXJucyB7c3RyaW5nfSBQcmVmaXhlZCBkYXRhIGF0dHJpYnV0ZVxuICAgKiBAZXhhbXBsZSBTaXhPcmJpdC5kYXRhKCd0b2dnbGUnKSA9PiAnZGF0YS1zby10b2dnbGUnXG4gICAqL1xuICBkYXRhKG5hbWUpIHtcbiAgICByZXR1cm4gYCR7dGhpcy5EQVRBX1BSRUZJWH0tJHtuYW1lfWA7XG4gIH0sXG5cbiAgLyoqXG4gICAqIEdlbmVyYXRlIGEgQ1NTIHNlbGVjdG9yIGZvciBhIGRhdGEgYXR0cmlidXRlXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBuYW1lIC0gQXR0cmlidXRlIG5hbWVcbiAgICogQHBhcmFtIHtzdHJpbmd9IFt2YWx1ZV0gLSBPcHRpb25hbCBhdHRyaWJ1dGUgdmFsdWVcbiAgICogQHJldHVybnMge3N0cmluZ30gQ1NTIHNlbGVjdG9yXG4gICAqIEBleGFtcGxlIFNpeE9yYml0LmRhdGFTZWwoJ3RvZ2dsZScsICdtb2RhbCcpID0+ICdbZGF0YS1zby10b2dnbGU9XCJtb2RhbFwiXSdcbiAgICovXG4gIGRhdGFTZWwobmFtZSwgdmFsdWUpIHtcbiAgICBjb25zdCBhdHRyID0gdGhpcy5kYXRhKG5hbWUpO1xuICAgIHJldHVybiB2YWx1ZSAhPT0gdW5kZWZpbmVkID8gYFske2F0dHJ9PVwiJHt2YWx1ZX1cIl1gIDogYFske2F0dHJ9XWA7XG4gIH0sXG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gRVZFTlQgSEVMUEVSU1xuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBHZW5lcmF0ZSBhIHByZWZpeGVkIGV2ZW50IG5hbWVcbiAgICogQHBhcmFtIHtzdHJpbmd9IG5hbWUgLSBFdmVudCBuYW1lXG4gICAqIEByZXR1cm5zIHtzdHJpbmd9IFByZWZpeGVkIGV2ZW50IG5hbWVcbiAgICogQGV4YW1wbGUgU2l4T3JiaXQuZXZ0KCdvcGVuJykgPT4gJ3NvOm9wZW4nXG4gICAqL1xuICBldnQobmFtZSkge1xuICAgIHJldHVybiBgJHt0aGlzLkVWRU5UX1BSRUZJWH0ke25hbWV9YDtcbiAgfSxcblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBTVE9SQUdFIEhFTFBFUlNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogR2VuZXJhdGUgYSBwcmVmaXhlZCBsb2NhbFN0b3JhZ2Uga2V5XG4gICAqIEBwYXJhbSB7c3RyaW5nfSBuYW1lIC0gU3RvcmFnZSBrZXkgbmFtZVxuICAgKiBAcmV0dXJucyB7c3RyaW5nfSBQcmVmaXhlZCBzdG9yYWdlIGtleVxuICAgKiBAZXhhbXBsZSBTaXhPcmJpdC5zdG9yYWdlS2V5KCd0aGVtZScpID0+ICdzby10aGVtZSdcbiAgICovXG4gIHN0b3JhZ2VLZXkobmFtZSkge1xuICAgIHJldHVybiBgJHt0aGlzLlBSRUZJWH0tJHtuYW1lfWA7XG4gIH0sXG5cbiAgLyoqXG4gICAqIEdldCB2YWx1ZSBmcm9tIGxvY2FsU3RvcmFnZSB3aXRoIEpTT04gcGFyc2luZ1xuICAgKiBAcGFyYW0ge3N0cmluZ30gbmFtZSAtIFN0b3JhZ2Uga2V5IG5hbWUgKHdpbGwgYmUgcHJlZml4ZWQpXG4gICAqIEBwYXJhbSB7Kn0gW2RlZmF1bHRWYWx1ZT1udWxsXSAtIERlZmF1bHQgdmFsdWUgaWYgbm90IGZvdW5kXG4gICAqIEByZXR1cm5zIHsqfSBTdG9yZWQgdmFsdWUgb3IgZGVmYXVsdFxuICAgKi9cbiAgZ2V0U3RvcmFnZShuYW1lLCBkZWZhdWx0VmFsdWUgPSBudWxsKSB7XG4gICAgdHJ5IHtcbiAgICAgIGNvbnN0IGtleSA9IHRoaXMuc3RvcmFnZUtleShuYW1lKTtcbiAgICAgIGNvbnN0IHZhbHVlID0gbG9jYWxTdG9yYWdlLmdldEl0ZW0oa2V5KTtcbiAgICAgIHJldHVybiB2YWx1ZSAhPT0gbnVsbCA/IEpTT04ucGFyc2UodmFsdWUpIDogZGVmYXVsdFZhbHVlO1xuICAgIH0gY2F0Y2ggKGUpIHtcbiAgICAgIHJldHVybiBkZWZhdWx0VmFsdWU7XG4gICAgfVxuICB9LFxuXG4gIC8qKlxuICAgKiBTZXQgdmFsdWUgaW4gbG9jYWxTdG9yYWdlIHdpdGggSlNPTiBzdHJpbmdpZmljYXRpb25cbiAgICogQHBhcmFtIHtzdHJpbmd9IG5hbWUgLSBTdG9yYWdlIGtleSBuYW1lICh3aWxsIGJlIHByZWZpeGVkKVxuICAgKiBAcGFyYW0geyp9IHZhbHVlIC0gVmFsdWUgdG8gc3RvcmVcbiAgICovXG4gIHNldFN0b3JhZ2UobmFtZSwgdmFsdWUpIHtcbiAgICB0cnkge1xuICAgICAgY29uc3Qga2V5ID0gdGhpcy5zdG9yYWdlS2V5KG5hbWUpO1xuICAgICAgbG9jYWxTdG9yYWdlLnNldEl0ZW0oa2V5LCBKU09OLnN0cmluZ2lmeSh2YWx1ZSkpO1xuICAgIH0gY2F0Y2ggKGUpIHtcbiAgICAgIGNvbnNvbGUud2FybihgU2l4T3JiaXQ6IEZhaWxlZCB0byBzYXZlIHRvIGxvY2FsU3RvcmFnZTogJHtuYW1lfWAsIGUpO1xuICAgIH1cbiAgfSxcblxuICAvKipcbiAgICogUmVtb3ZlIHZhbHVlIGZyb20gbG9jYWxTdG9yYWdlXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBuYW1lIC0gU3RvcmFnZSBrZXkgbmFtZSAod2lsbCBiZSBwcmVmaXhlZClcbiAgICovXG4gIHJlbW92ZVN0b3JhZ2UobmFtZSkge1xuICAgIHRyeSB7XG4gICAgICBjb25zdCBrZXkgPSB0aGlzLnN0b3JhZ2VLZXkobmFtZSk7XG4gICAgICBsb2NhbFN0b3JhZ2UucmVtb3ZlSXRlbShrZXkpO1xuICAgIH0gY2F0Y2ggKGUpIHtcbiAgICAgIC8vIElnbm9yZSBlcnJvcnNcbiAgICB9XG4gIH0sXG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gQ1NTIFZBUklBQkxFIEhFTFBFUlNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogR2V0IGEgQ1NTIGN1c3RvbSBwcm9wZXJ0eSB2YWx1ZVxuICAgKiBAcGFyYW0ge3N0cmluZ30gbmFtZSAtIFZhcmlhYmxlIG5hbWUgKHdpdGhvdXQgLS1zby0gcHJlZml4KVxuICAgKiBAcGFyYW0ge0VsZW1lbnR9IFtlbGVtZW50PWRvY3VtZW50LmRvY3VtZW50RWxlbWVudF0gLSBFbGVtZW50IHRvIGdldCBmcm9tXG4gICAqIEByZXR1cm5zIHtzdHJpbmd9IENTUyB2YXJpYWJsZSB2YWx1ZVxuICAgKi9cbiAgZ2V0Q3NzVmFyKG5hbWUsIGVsZW1lbnQgPSBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQpIHtcbiAgICByZXR1cm4gZ2V0Q29tcHV0ZWRTdHlsZShlbGVtZW50KVxuICAgICAgLmdldFByb3BlcnR5VmFsdWUoYC0tJHt0aGlzLlBSRUZJWH0tJHtuYW1lfWApXG4gICAgICAudHJpbSgpO1xuICB9LFxuXG4gIC8qKlxuICAgKiBTZXQgYSBDU1MgY3VzdG9tIHByb3BlcnR5IHZhbHVlXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBuYW1lIC0gVmFyaWFibGUgbmFtZSAod2l0aG91dCAtLXNvLSBwcmVmaXgpXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB2YWx1ZSAtIFZhbHVlIHRvIHNldFxuICAgKiBAcGFyYW0ge0VsZW1lbnR9IFtlbGVtZW50PWRvY3VtZW50LmRvY3VtZW50RWxlbWVudF0gLSBFbGVtZW50IHRvIHNldCBvblxuICAgKi9cbiAgc2V0Q3NzVmFyKG5hbWUsIHZhbHVlLCBlbGVtZW50ID0gZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50KSB7XG4gICAgZWxlbWVudC5zdHlsZS5zZXRQcm9wZXJ0eShgLS0ke3RoaXMuUFJFRklYfS0ke25hbWV9YCwgdmFsdWUpO1xuICB9LFxuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIFVUSUxJVFkgRlVOQ1RJT05TXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIERlYm91bmNlIGEgZnVuY3Rpb25cbiAgICogQHBhcmFtIHtGdW5jdGlvbn0gZm4gLSBGdW5jdGlvbiB0byBkZWJvdW5jZVxuICAgKiBAcGFyYW0ge251bWJlcn0gW2RlbGF5PTMwMF0gLSBEZWxheSBpbiBtaWxsaXNlY29uZHNcbiAgICogQHJldHVybnMge0Z1bmN0aW9ufSBEZWJvdW5jZWQgZnVuY3Rpb25cbiAgICovXG4gIGRlYm91bmNlKGZuLCBkZWxheSA9IDMwMCkge1xuICAgIGxldCB0aW1lb3V0SWQ7XG4gICAgcmV0dXJuIGZ1bmN0aW9uICguLi5hcmdzKSB7XG4gICAgICBjbGVhclRpbWVvdXQodGltZW91dElkKTtcbiAgICAgIHRpbWVvdXRJZCA9IHNldFRpbWVvdXQoKCkgPT4gZm4uYXBwbHkodGhpcywgYXJncyksIGRlbGF5KTtcbiAgICB9O1xuICB9LFxuXG4gIC8qKlxuICAgKiBUaHJvdHRsZSBhIGZ1bmN0aW9uXG4gICAqIEBwYXJhbSB7RnVuY3Rpb259IGZuIC0gRnVuY3Rpb24gdG8gdGhyb3R0bGVcbiAgICogQHBhcmFtIHtudW1iZXJ9IFtsaW1pdD0xMDBdIC0gTWluaW11bSB0aW1lIGJldHdlZW4gY2FsbHMgaW4gbWlsbGlzZWNvbmRzXG4gICAqIEByZXR1cm5zIHtGdW5jdGlvbn0gVGhyb3R0bGVkIGZ1bmN0aW9uXG4gICAqL1xuICB0aHJvdHRsZShmbiwgbGltaXQgPSAxMDApIHtcbiAgICBsZXQgaW5UaHJvdHRsZTtcbiAgICByZXR1cm4gZnVuY3Rpb24gKC4uLmFyZ3MpIHtcbiAgICAgIGlmICghaW5UaHJvdHRsZSkge1xuICAgICAgICBmbi5hcHBseSh0aGlzLCBhcmdzKTtcbiAgICAgICAgaW5UaHJvdHRsZSA9IHRydWU7XG4gICAgICAgIHNldFRpbWVvdXQoKCkgPT4gKGluVGhyb3R0bGUgPSBmYWxzZSksIGxpbWl0KTtcbiAgICAgIH1cbiAgICB9O1xuICB9LFxuXG4gIC8qKlxuICAgKiBHZW5lcmF0ZSBhIHVuaXF1ZSBJRFxuICAgKiBAcGFyYW0ge3N0cmluZ30gW3ByZWZpeD0nc28nXSAtIElEIHByZWZpeFxuICAgKiBAcmV0dXJucyB7c3RyaW5nfSBVbmlxdWUgSURcbiAgICovXG4gIHVuaXF1ZUlkKHByZWZpeCA9IFwic29cIikge1xuICAgIHJldHVybiBgJHtwcmVmaXh9LSR7RGF0ZS5ub3coKS50b1N0cmluZygzNil9LSR7TWF0aC5yYW5kb20oKS50b1N0cmluZygzNikuc3Vic3RyaW5nKDIsIDkpfWA7XG4gIH0sXG5cbiAgLyoqXG4gICAqIENoZWNrIGlmIGFuIGVsZW1lbnQgbWF0Y2hlcyBhIHNlbGVjdG9yXG4gICAqIEBwYXJhbSB7RWxlbWVudH0gZWxlbWVudCAtIEVsZW1lbnQgdG8gY2hlY2tcbiAgICogQHBhcmFtIHtzdHJpbmd9IHNlbGVjdG9yIC0gQ1NTIHNlbGVjdG9yXG4gICAqIEByZXR1cm5zIHtib29sZWFufSBXaGV0aGVyIGVsZW1lbnQgbWF0Y2hlc1xuICAgKi9cbiAgbWF0Y2hlcyhlbGVtZW50LCBzZWxlY3Rvcikge1xuICAgIHJldHVybiBlbGVtZW50ICYmIGVsZW1lbnQubWF0Y2hlcyAmJiBlbGVtZW50Lm1hdGNoZXMoc2VsZWN0b3IpO1xuICB9LFxuXG4gIC8qKlxuICAgKiBGaW5kIGNsb3Nlc3QgYW5jZXN0b3IgbWF0Y2hpbmcgc2VsZWN0b3JcbiAgICogQHBhcmFtIHtFbGVtZW50fSBlbGVtZW50IC0gU3RhcnRpbmcgZWxlbWVudFxuICAgKiBAcGFyYW0ge3N0cmluZ30gc2VsZWN0b3IgLSBDU1Mgc2VsZWN0b3JcbiAgICogQHJldHVybnMge0VsZW1lbnR8bnVsbH0gTWF0Y2hpbmcgYW5jZXN0b3Igb3IgbnVsbFxuICAgKi9cbiAgY2xvc2VzdChlbGVtZW50LCBzZWxlY3Rvcikge1xuICAgIHJldHVybiBlbGVtZW50ICYmIGVsZW1lbnQuY2xvc2VzdCA/IGVsZW1lbnQuY2xvc2VzdChzZWxlY3RvcikgOiBudWxsO1xuICB9LFxuXG4gIC8qKlxuICAgKiBQYXJzZSBkYXRhIGF0dHJpYnV0ZXMgZnJvbSBhbiBlbGVtZW50IGludG8gYW4gb3B0aW9ucyBvYmplY3RcbiAgICogQHBhcmFtIHtFbGVtZW50fSBlbGVtZW50IC0gRWxlbWVudCB0byBwYXJzZVxuICAgKiBAcGFyYW0ge3N0cmluZ1tdfSBba2V5cz1bXV0gLSBTcGVjaWZpYyBrZXlzIHRvIHBhcnNlIChhbGwgaWYgZW1wdHkpXG4gICAqIEByZXR1cm5zIHtPYmplY3R9IFBhcnNlZCBvcHRpb25zXG4gICAqL1xuICBwYXJzZURhdGFPcHRpb25zKGVsZW1lbnQsIGtleXMgPSBbXSkge1xuICAgIGNvbnN0IG9wdGlvbnMgPSB7fTtcbiAgICBjb25zdCBwcmVmaXggPSBcInNvXCI7XG5cbiAgICBpZiAoIWVsZW1lbnQgfHwgIWVsZW1lbnQuZGF0YXNldCkgcmV0dXJuIG9wdGlvbnM7XG5cbiAgICBPYmplY3Qua2V5cyhlbGVtZW50LmRhdGFzZXQpLmZvckVhY2goKGtleSkgPT4ge1xuICAgICAgLy8gT25seSBwcm9jZXNzIGtleXMgc3RhcnRpbmcgd2l0aCAnc28nXG4gICAgICBpZiAoa2V5LnN0YXJ0c1dpdGgocHJlZml4KSkge1xuICAgICAgICBjb25zdCBvcHRpb25LZXkgPSBrZXkuc2xpY2UocHJlZml4Lmxlbmd0aCk7XG4gICAgICAgIC8vIENvbnZlcnQgdG8gY2FtZWxDYXNlIHdpdGggbG93ZXJjYXNlIGZpcnN0IGxldHRlclxuICAgICAgICBjb25zdCBub3JtYWxpemVkS2V5ID1cbiAgICAgICAgICBvcHRpb25LZXkuY2hhckF0KDApLnRvTG93ZXJDYXNlKCkgKyBvcHRpb25LZXkuc2xpY2UoMSk7XG5cbiAgICAgICAgLy8gU2tpcCBpZiBrZXlzIHNwZWNpZmllZCBhbmQgdGhpcyBrZXkgaXNuJ3QgaW4gdGhlIGxpc3RcbiAgICAgICAgaWYgKGtleXMubGVuZ3RoID4gMCAmJiAha2V5cy5pbmNsdWRlcyhub3JtYWxpemVkS2V5KSkgcmV0dXJuO1xuXG4gICAgICAgIGxldCB2YWx1ZSA9IGVsZW1lbnQuZGF0YXNldFtrZXldO1xuXG4gICAgICAgIC8vIFRyeSB0byBwYXJzZSBhcyBKU09OIChoYW5kbGVzIGJvb2xlYW5zLCBudW1iZXJzLCBhcnJheXMsIG9iamVjdHMpXG4gICAgICAgIHRyeSB7XG4gICAgICAgICAgdmFsdWUgPSBKU09OLnBhcnNlKHZhbHVlKTtcbiAgICAgICAgfSBjYXRjaCAoZSkge1xuICAgICAgICAgIC8vIEtlZXAgYXMgc3RyaW5nIGlmIG5vdCB2YWxpZCBKU09OXG4gICAgICAgIH1cblxuICAgICAgICAvLyBJZiB2YWx1ZSBpcyBhIHBsYWluIG9iamVjdCAobm90IGFycmF5KSwgc3ByZWFkIGl0cyBwcm9wZXJ0aWVzXG4gICAgICAgIC8vIFRoaXMgYWxsb3dzIGRhdGEtc28tdGFicz0ne1wiY2xvc2FibGVcIjogdHJ1ZX0nIHRvIHdvcmsgY29ycmVjdGx5XG4gICAgICAgIGlmICh2YWx1ZSAmJiB0eXBlb2YgdmFsdWUgPT09IFwib2JqZWN0XCIgJiYgIUFycmF5LmlzQXJyYXkodmFsdWUpKSB7XG4gICAgICAgICAgT2JqZWN0LmFzc2lnbihvcHRpb25zLCB2YWx1ZSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgb3B0aW9uc1tub3JtYWxpemVkS2V5XSA9IHZhbHVlO1xuICAgICAgICB9XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICByZXR1cm4gb3B0aW9ucztcbiAgfSxcblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBCUkVBS1BPSU5UU1xuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKiBSZXNwb25zaXZlIGJyZWFrcG9pbnRzIGluIHBpeGVscyAqL1xuICBicmVha3BvaW50czoge1xuICAgIHNtOiA1NzYsXG4gICAgbWQ6IDc2OCxcbiAgICBsZzogMTAyNCxcbiAgICB4bDogMTIwMCxcbiAgfSxcblxuICAvKipcbiAgICogQ2hlY2sgaWYgdmlld3BvcnQgaXMgYmVsb3cgYSBicmVha3BvaW50XG4gICAqIEBwYXJhbSB7c3RyaW5nfSBicmVha3BvaW50IC0gQnJlYWtwb2ludCBuYW1lIChzbSwgbWQsIGxnLCB4bClcbiAgICogQHJldHVybnMge2Jvb2xlYW59IFdoZXRoZXIgdmlld3BvcnQgaXMgYmVsb3cgYnJlYWtwb2ludFxuICAgKi9cbiAgaXNNb2JpbGUoYnJlYWtwb2ludCA9IFwibWRcIikge1xuICAgIHJldHVybiB3aW5kb3cuaW5uZXJXaWR0aCA8ICh0aGlzLmJyZWFrcG9pbnRzW2JyZWFrcG9pbnRdIHx8IDc2OCk7XG4gIH0sXG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gQ09NUE9ORU5UIFJFR0lTVFJZXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqIFJlZ2lzdGVyZWQgY29tcG9uZW50IGNsYXNzZXMgKi9cbiAgX2NvbXBvbmVudHM6IHt9LFxuXG4gIC8qKiBDb21wb25lbnQgaW5zdGFuY2VzICovXG4gIF9pbnN0YW5jZXM6IG5ldyBXZWFrTWFwKCksXG5cbiAgLyoqXG4gICAqIFJlZ2lzdGVyIGEgY29tcG9uZW50IGNsYXNzXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBuYW1lIC0gQ29tcG9uZW50IG5hbWVcbiAgICogQHBhcmFtIHtGdW5jdGlvbn0gQ29tcG9uZW50Q2xhc3MgLSBDb21wb25lbnQgY2xhc3NcbiAgICovXG4gIHJlZ2lzdGVyQ29tcG9uZW50KG5hbWUsIENvbXBvbmVudENsYXNzKSB7XG4gICAgdGhpcy5fY29tcG9uZW50c1tuYW1lXSA9IENvbXBvbmVudENsYXNzO1xuICB9LFxuXG4gIC8qKlxuICAgKiBHZXQgYSByZWdpc3RlcmVkIGNvbXBvbmVudCBjbGFzc1xuICAgKiBAcGFyYW0ge3N0cmluZ30gbmFtZSAtIENvbXBvbmVudCBuYW1lXG4gICAqIEByZXR1cm5zIHtGdW5jdGlvbnx1bmRlZmluZWR9IENvbXBvbmVudCBjbGFzc1xuICAgKi9cbiAgZ2V0Q29tcG9uZW50KG5hbWUpIHtcbiAgICByZXR1cm4gdGhpcy5fY29tcG9uZW50c1tuYW1lXTtcbiAgfSxcblxuICAvKipcbiAgICogR2V0IG9yIGNyZWF0ZSBjb21wb25lbnQgaW5zdGFuY2UgZm9yIGFuIGVsZW1lbnRcbiAgICogQHBhcmFtIHtFbGVtZW50fSBlbGVtZW50IC0gRE9NIGVsZW1lbnRcbiAgICogQHBhcmFtIHtzdHJpbmd9IG5hbWUgLSBDb21wb25lbnQgbmFtZVxuICAgKiBAcGFyYW0ge09iamVjdH0gW29wdGlvbnM9e31dIC0gQ29tcG9uZW50IG9wdGlvbnNcbiAgICogQHJldHVybnMge09iamVjdHxudWxsfSBDb21wb25lbnQgaW5zdGFuY2VcbiAgICovXG4gIGdldEluc3RhbmNlKGVsZW1lbnQsIG5hbWUsIG9wdGlvbnMgPSB7fSkge1xuICAgIGlmICghZWxlbWVudCkgcmV0dXJuIG51bGw7XG5cbiAgICAvLyBDaGVjayBmb3IgZXhpc3RpbmcgaW5zdGFuY2VcbiAgICBsZXQgaW5zdGFuY2VzID0gdGhpcy5faW5zdGFuY2VzLmdldChlbGVtZW50KTtcbiAgICBpZiAoaW5zdGFuY2VzICYmIGluc3RhbmNlc1tuYW1lXSkge1xuICAgICAgcmV0dXJuIGluc3RhbmNlc1tuYW1lXTtcbiAgICB9XG5cbiAgICAvLyBDcmVhdGUgbmV3IGluc3RhbmNlIGlmIGNvbXBvbmVudCBpcyByZWdpc3RlcmVkXG4gICAgY29uc3QgQ29tcG9uZW50Q2xhc3MgPSB0aGlzLl9jb21wb25lbnRzW25hbWVdO1xuICAgIGlmICghQ29tcG9uZW50Q2xhc3MpIHJldHVybiBudWxsO1xuXG4gICAgY29uc3QgaW5zdGFuY2UgPSBuZXcgQ29tcG9uZW50Q2xhc3MoZWxlbWVudCwgb3B0aW9ucyk7XG5cbiAgICAvLyBTdG9yZSBpbnN0YW5jZVxuICAgIGlmICghaW5zdGFuY2VzKSB7XG4gICAgICBpbnN0YW5jZXMgPSB7fTtcbiAgICAgIHRoaXMuX2luc3RhbmNlcy5zZXQoZWxlbWVudCwgaW5zdGFuY2VzKTtcbiAgICB9XG4gICAgaW5zdGFuY2VzW25hbWVdID0gaW5zdGFuY2U7XG5cbiAgICByZXR1cm4gaW5zdGFuY2U7XG4gIH0sXG5cbiAgLyoqXG4gICAqIFJlbW92ZSBjb21wb25lbnQgaW5zdGFuY2UgZnJvbSBhbiBlbGVtZW50XG4gICAqIEBwYXJhbSB7RWxlbWVudH0gZWxlbWVudCAtIERPTSBlbGVtZW50XG4gICAqIEBwYXJhbSB7c3RyaW5nfSBuYW1lIC0gQ29tcG9uZW50IG5hbWVcbiAgICovXG4gIHJlbW92ZUluc3RhbmNlKGVsZW1lbnQsIG5hbWUpIHtcbiAgICBjb25zdCBpbnN0YW5jZXMgPSB0aGlzLl9pbnN0YW5jZXMuZ2V0KGVsZW1lbnQpO1xuICAgIGlmIChpbnN0YW5jZXMgJiYgaW5zdGFuY2VzW25hbWVdKSB7XG4gICAgICBpZiAodHlwZW9mIGluc3RhbmNlc1tuYW1lXS5kZXN0cm95ID09PSBcImZ1bmN0aW9uXCIpIHtcbiAgICAgICAgaW5zdGFuY2VzW25hbWVdLmRlc3Ryb3koKTtcbiAgICAgIH1cbiAgICAgIGRlbGV0ZSBpbnN0YW5jZXNbbmFtZV07XG4gICAgfVxuICB9LFxuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIElOSVRJQUxJWkFUSU9OXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqIFdoZXRoZXIgdGhlIGZyYW1ld29yayBoYXMgYmVlbiBpbml0aWFsaXplZCAqL1xuICBfaW5pdGlhbGl6ZWQ6IGZhbHNlLFxuXG4gIC8qKlxuICAgKiBJbml0aWFsaXplIHRoZSBmcmFtZXdvcmtcbiAgICogQ2FsbGVkIGF1dG9tYXRpY2FsbHkgb24gRE9NQ29udGVudExvYWRlZFxuICAgKi9cbiAgaW5pdCgpIHtcbiAgICBpZiAodGhpcy5faW5pdGlhbGl6ZWQpIHJldHVybjtcbiAgICB0aGlzLl9pbml0aWFsaXplZCA9IHRydWU7XG5cbiAgICAvLyBEaXNwYXRjaCByZWFkeSBldmVudFxuICAgIGRvY3VtZW50LmRpc3BhdGNoRXZlbnQoXG4gICAgICBuZXcgQ3VzdG9tRXZlbnQodGhpcy5ldnQoXCJyZWFkeVwiKSwge1xuICAgICAgICBkZXRhaWw6IHsgdmVyc2lvbjogdGhpcy5WRVJTSU9OIH0sXG4gICAgICB9KSxcbiAgICApO1xuXG4gICAgLy8gY29uc29sZS5sb2coYFNpeE9yYml0IFVJIHYke3RoaXMuVkVSU0lPTn0gaW5pdGlhbGl6ZWRgKTtcbiAgfSxcbn0pO1xuXG4vLyBBdXRvLWluaXRpYWxpemUgb24gRE9NIHJlYWR5XG5pZiAoZG9jdW1lbnQucmVhZHlTdGF0ZSA9PT0gXCJsb2FkaW5nXCIpIHtcbiAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcihcIkRPTUNvbnRlbnRMb2FkZWRcIiwgKCkgPT4gU2l4T3JiaXQuaW5pdCgpKTtcbn0gZWxzZSB7XG4gIFNpeE9yYml0LmluaXQoKTtcbn1cblxuLy8gRXhwb3J0IGZvciBFUyBtb2R1bGVzXG5leHBvcnQgZGVmYXVsdCBTaXhPcmJpdDtcbmV4cG9ydCB7IFNpeE9yYml0IH07XG4iLCAiLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbi8vIFNJWE9SQklUIFVJIC0gQkFTRSBDT01QT05FTlQgQ0xBU1Ncbi8vIEZvdW5kYXRpb24gZm9yIGFsbCBVSSBjb21wb25lbnRzXG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4vLyBJbXBvcnQgU2l4T3JiaXQgZ2xvYmFsIChhbHNvIGF2YWlsYWJsZSBvbiB3aW5kb3cuU2l4T3JiaXQpXG5pbXBvcnQgU2l4T3JiaXQgZnJvbSAnLi9zby1jb25maWcuanMnO1xuXG4vKipcbiAqIFNPQ29tcG9uZW50IC0gQmFzZSBjbGFzcyBmb3IgYWxsIFNpeE9yYml0IFVJIGNvbXBvbmVudHNcbiAqIFByb3ZpZGVzIGNvbW1vbiBmdW5jdGlvbmFsaXR5OiBvcHRpb25zIG1lcmdpbmcsIGV2ZW50IGhhbmRsaW5nLFxuICogbGlmZWN5Y2xlIG1hbmFnZW1lbnQsIGFuZCBET00gdXRpbGl0aWVzXG4gKi9cbmNsYXNzIFNPQ29tcG9uZW50IHtcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gU1RBVElDIFBST1BFUlRJRVNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKiogQ29tcG9uZW50IG5hbWUgZm9yIHJlZ2lzdHJhdGlvbiAqL1xuICBzdGF0aWMgTkFNRSA9ICdjb21wb25lbnQnO1xuXG4gIC8qKiBEZWZhdWx0IG9wdGlvbnMgKG92ZXJyaWRlIGluIHN1YmNsYXNzKSAqL1xuICBzdGF0aWMgREVGQVVMVFMgPSB7fTtcblxuICAvKiogRXZlbnRzIGVtaXR0ZWQgYnkgdGhpcyBjb21wb25lbnQgKi9cbiAgc3RhdGljIEVWRU5UUyA9IHt9O1xuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIENPTlNUUlVDVE9SXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIENyZWF0ZSBhIG5ldyBjb21wb25lbnQgaW5zdGFuY2VcbiAgICogQHBhcmFtIHtFbGVtZW50fHN0cmluZ30gZWxlbWVudCAtIERPTSBlbGVtZW50IG9yIHNlbGVjdG9yXG4gICAqIEBwYXJhbSB7T2JqZWN0fSBbb3B0aW9ucz17fV0gLSBDb21wb25lbnQgb3B0aW9uc1xuICAgKi9cbiAgY29uc3RydWN0b3IoZWxlbWVudCwgb3B0aW9ucyA9IHt9KSB7XG4gICAgLy8gUmVzb2x2ZSBlbGVtZW50XG4gICAgdGhpcy5lbGVtZW50ID0gdHlwZW9mIGVsZW1lbnQgPT09ICdzdHJpbmcnXG4gICAgICA/IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoZWxlbWVudClcbiAgICAgIDogZWxlbWVudDtcblxuICAgIC8vIE9ubHkgd2FybiBpZiBlbGVtZW50IHdhcyBhIHNlbGVjdG9yIHN0cmluZyB0aGF0IHdhc24ndCBmb3VuZFxuICAgIC8vIChub3QgaWYgZWxlbWVudCBpcyBleHBsaWNpdGx5IG51bGwgZm9yIGNvbmZpZy1iYXNlZCBjb25zdHJ1Y3Rpb24pXG4gICAgaWYgKCF0aGlzLmVsZW1lbnQgJiYgdHlwZW9mIGVsZW1lbnQgPT09ICdzdHJpbmcnKSB7XG4gICAgICBjb25zb2xlLndhcm4oYCR7dGhpcy5jb25zdHJ1Y3Rvci5OQU1FfTogRWxlbWVudCBub3QgZm91bmQgZm9yIHNlbGVjdG9yIFwiJHtlbGVtZW50fVwiYCk7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgLy8gQWxsb3cgbnVsbCBlbGVtZW50IGZvciBjb25maWctYmFzZWQgY29uc3RydWN0aW9uIChFbGVtZW50IGNsYXNzKVxuICAgIGlmICghdGhpcy5lbGVtZW50ICYmIGVsZW1lbnQgPT09IG51bGwpIHtcbiAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICAvLyBNZXJnZSBvcHRpb25zOiBkZWZhdWx0cyA8IGRhdGEgYXR0cmlidXRlcyA8IHBhc3NlZCBvcHRpb25zXG4gICAgdGhpcy5vcHRpb25zID0gdGhpcy5fbWVyZ2VPcHRpb25zKG9wdGlvbnMpO1xuXG4gICAgLy8gU3RvcmUgYm91bmQgZXZlbnQgaGFuZGxlcnMgZm9yIGNsZWFudXBcbiAgICB0aGlzLl9ib3VuZEhhbmRsZXJzID0gbmV3IE1hcCgpO1xuXG4gICAgLy8gRXZlbnQgZGVsZWdhdGlvbiBoYW5kbGVyc1xuICAgIHRoaXMuX2RlbGVnYXRlZEhhbmRsZXJzID0gW107XG5cbiAgICAvLyBJbml0aWFsaXplIHRoZSBjb21wb25lbnRcbiAgICB0aGlzLl9pbml0KCk7XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBQUklWQVRFIE1FVEhPRFNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogTWVyZ2Ugb3B0aW9ucyBmcm9tIGRlZmF1bHRzLCBkYXRhIGF0dHJpYnV0ZXMsIGFuZCBwYXNzZWQgb3B0aW9uc1xuICAgKiBAcGFyYW0ge09iamVjdH0gb3B0aW9ucyAtIFBhc3NlZCBvcHRpb25zXG4gICAqIEByZXR1cm5zIHtPYmplY3R9IE1lcmdlZCBvcHRpb25zXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfbWVyZ2VPcHRpb25zKG9wdGlvbnMpIHtcbiAgICBjb25zdCBkZWZhdWx0cyA9IHRoaXMuY29uc3RydWN0b3IuREVGQVVMVFM7XG4gICAgY29uc3QgZGF0YU9wdGlvbnMgPSBTaXhPcmJpdC5wYXJzZURhdGFPcHRpb25zKHRoaXMuZWxlbWVudCk7XG5cbiAgICByZXR1cm4geyAuLi5kZWZhdWx0cywgLi4uZGF0YU9wdGlvbnMsIC4uLm9wdGlvbnMgfTtcbiAgfVxuXG4gIC8qKlxuICAgKiBJbml0aWFsaXplIHRoZSBjb21wb25lbnQgKG92ZXJyaWRlIGluIHN1YmNsYXNzKVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2luaXQoKSB7XG4gICAgLy8gT3ZlcnJpZGUgaW4gc3ViY2xhc3NcbiAgfVxuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIERPTSBVVElMSVRJRVNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogUXVlcnkgYSBzaW5nbGUgZWxlbWVudCB3aXRoaW4gdGhpcyBjb21wb25lbnRcbiAgICogQHBhcmFtIHtzdHJpbmd9IHNlbGVjdG9yIC0gQ1NTIHNlbGVjdG9yXG4gICAqIEByZXR1cm5zIHtFbGVtZW50fG51bGx9IEZvdW5kIGVsZW1lbnRcbiAgICovXG4gICQoc2VsZWN0b3IpIHtcbiAgICByZXR1cm4gdGhpcy5lbGVtZW50LnF1ZXJ5U2VsZWN0b3Ioc2VsZWN0b3IpO1xuICB9XG5cbiAgLyoqXG4gICAqIFF1ZXJ5IGFsbCBlbGVtZW50cyB3aXRoaW4gdGhpcyBjb21wb25lbnRcbiAgICogQHBhcmFtIHtzdHJpbmd9IHNlbGVjdG9yIC0gQ1NTIHNlbGVjdG9yXG4gICAqIEByZXR1cm5zIHtFbGVtZW50W119IEFycmF5IG9mIGZvdW5kIGVsZW1lbnRzXG4gICAqL1xuICAkJChzZWxlY3Rvcikge1xuICAgIHJldHVybiBBcnJheS5mcm9tKHRoaXMuZWxlbWVudC5xdWVyeVNlbGVjdG9yQWxsKHNlbGVjdG9yKSk7XG4gIH1cblxuICAvKipcbiAgICogRmluZCBlbGVtZW50IGJ5IHByZWZpeGVkIGNsYXNzIG5hbWVcbiAgICogQHBhcmFtIHsuLi5zdHJpbmd9IHBhcnRzIC0gQ2xhc3MgbmFtZSBwYXJ0c1xuICAgKiBAcmV0dXJucyB7RWxlbWVudHxudWxsfSBGb3VuZCBlbGVtZW50XG4gICAqL1xuICAkY2xzKC4uLnBhcnRzKSB7XG4gICAgcmV0dXJuIHRoaXMuJChTaXhPcmJpdC5zZWwoLi4ucGFydHMpKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBGaW5kIGFsbCBlbGVtZW50cyBieSBwcmVmaXhlZCBjbGFzcyBuYW1lXG4gICAqIEBwYXJhbSB7Li4uc3RyaW5nfSBwYXJ0cyAtIENsYXNzIG5hbWUgcGFydHNcbiAgICogQHJldHVybnMge0VsZW1lbnRbXX0gQXJyYXkgb2YgZm91bmQgZWxlbWVudHNcbiAgICovXG4gICQkY2xzKC4uLnBhcnRzKSB7XG4gICAgcmV0dXJuIHRoaXMuJCQoU2l4T3JiaXQuc2VsKC4uLnBhcnRzKSk7XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBDTEFTUyBVVElMSVRJRVNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogQWRkIGNsYXNzKGVzKSB0byB0aGUgY29tcG9uZW50IGVsZW1lbnRcbiAgICogQHBhcmFtIHsuLi5zdHJpbmd9IGNsYXNzZXMgLSBDbGFzcyBuYW1lcyB0byBhZGRcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgYWRkQ2xhc3MoLi4uY2xhc3Nlcykge1xuICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QuYWRkKC4uLmNsYXNzZXMpO1xuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFJlbW92ZSBjbGFzcyhlcykgZnJvbSB0aGUgY29tcG9uZW50IGVsZW1lbnRcbiAgICogQHBhcmFtIHsuLi5zdHJpbmd9IGNsYXNzZXMgLSBDbGFzcyBuYW1lcyB0byByZW1vdmVcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgcmVtb3ZlQ2xhc3MoLi4uY2xhc3Nlcykge1xuICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKC4uLmNsYXNzZXMpO1xuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFRvZ2dsZSBhIGNsYXNzIG9uIHRoZSBjb21wb25lbnQgZWxlbWVudFxuICAgKiBAcGFyYW0ge3N0cmluZ30gY2xhc3NOYW1lIC0gQ2xhc3MgbmFtZSB0byB0b2dnbGVcbiAgICogQHBhcmFtIHtib29sZWFufSBbZm9yY2VdIC0gRm9yY2UgYWRkIG9yIHJlbW92ZVxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICB0b2dnbGVDbGFzcyhjbGFzc05hbWUsIGZvcmNlKSB7XG4gICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC50b2dnbGUoY2xhc3NOYW1lLCBmb3JjZSk7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogQ2hlY2sgaWYgY29tcG9uZW50IGVsZW1lbnQgaGFzIGEgY2xhc3NcbiAgICogQHBhcmFtIHtzdHJpbmd9IGNsYXNzTmFtZSAtIENsYXNzIG5hbWUgdG8gY2hlY2tcbiAgICogQHJldHVybnMge2Jvb2xlYW59IFdoZXRoZXIgZWxlbWVudCBoYXMgY2xhc3NcbiAgICovXG4gIGhhc0NsYXNzKGNsYXNzTmFtZSkge1xuICAgIHJldHVybiB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LmNvbnRhaW5zKGNsYXNzTmFtZSk7XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBBVFRSSUJVVEUgVVRJTElUSUVTXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIEdldCBhIGRhdGEgYXR0cmlidXRlIHZhbHVlXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBuYW1lIC0gQXR0cmlidXRlIG5hbWUgKHdpdGhvdXQgZGF0YS1zby0gcHJlZml4KVxuICAgKiBAcmV0dXJucyB7c3RyaW5nfG51bGx9IEF0dHJpYnV0ZSB2YWx1ZVxuICAgKi9cbiAgZ2V0RGF0YShuYW1lKSB7XG4gICAgcmV0dXJuIHRoaXMuZWxlbWVudC5nZXRBdHRyaWJ1dGUoU2l4T3JiaXQuZGF0YShuYW1lKSk7XG4gIH1cblxuICAvKipcbiAgICogU2V0IGEgZGF0YSBhdHRyaWJ1dGUgdmFsdWVcbiAgICogQHBhcmFtIHtzdHJpbmd9IG5hbWUgLSBBdHRyaWJ1dGUgbmFtZSAod2l0aG91dCBkYXRhLXNvLSBwcmVmaXgpXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB2YWx1ZSAtIFZhbHVlIHRvIHNldFxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBzZXREYXRhKG5hbWUsIHZhbHVlKSB7XG4gICAgdGhpcy5lbGVtZW50LnNldEF0dHJpYnV0ZShTaXhPcmJpdC5kYXRhKG5hbWUpLCB2YWx1ZSk7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogUmVtb3ZlIGEgZGF0YSBhdHRyaWJ1dGVcbiAgICogQHBhcmFtIHtzdHJpbmd9IG5hbWUgLSBBdHRyaWJ1dGUgbmFtZSAod2l0aG91dCBkYXRhLXNvLSBwcmVmaXgpXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHJlbW92ZURhdGEobmFtZSkge1xuICAgIHRoaXMuZWxlbWVudC5yZW1vdmVBdHRyaWJ1dGUoU2l4T3JiaXQuZGF0YShuYW1lKSk7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBFVkVOVCBIQU5ETElOR1xuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBBZGQgYW4gZXZlbnQgbGlzdGVuZXIgd2l0aCBhdXRvbWF0aWMgYmluZGluZ1xuICAgKiBAcGFyYW0ge3N0cmluZ30gZXZlbnQgLSBFdmVudCBuYW1lXG4gICAqIEBwYXJhbSB7RnVuY3Rpb259IGhhbmRsZXIgLSBFdmVudCBoYW5kbGVyXG4gICAqIEBwYXJhbSB7RWxlbWVudH0gW3RhcmdldD10aGlzLmVsZW1lbnRdIC0gVGFyZ2V0IGVsZW1lbnRcbiAgICogQHBhcmFtIHtPYmplY3R9IFtvcHRpb25zPXt9XSAtIEV2ZW50IGxpc3RlbmVyIG9wdGlvbnNcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgb24oZXZlbnQsIGhhbmRsZXIsIHRhcmdldCA9IHRoaXMuZWxlbWVudCwgb3B0aW9ucyA9IHt9KSB7XG4gICAgY29uc3QgYm91bmRIYW5kbGVyID0gaGFuZGxlci5iaW5kKHRoaXMpO1xuICAgIHRoaXMuX2JvdW5kSGFuZGxlcnMuc2V0KGhhbmRsZXIsIHsgYm91bmRIYW5kbGVyLCB0YXJnZXQsIGV2ZW50LCBvcHRpb25zIH0pO1xuICAgIHRhcmdldC5hZGRFdmVudExpc3RlbmVyKGV2ZW50LCBib3VuZEhhbmRsZXIsIG9wdGlvbnMpO1xuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFJlbW92ZSBhbiBldmVudCBsaXN0ZW5lclxuICAgKiBAcGFyYW0ge3N0cmluZ30gZXZlbnQgLSBFdmVudCBuYW1lXG4gICAqIEBwYXJhbSB7RnVuY3Rpb259IGhhbmRsZXIgLSBPcmlnaW5hbCBoYW5kbGVyIGZ1bmN0aW9uXG4gICAqIEBwYXJhbSB7RWxlbWVudH0gW3RhcmdldD10aGlzLmVsZW1lbnRdIC0gVGFyZ2V0IGVsZW1lbnRcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgb2ZmKGV2ZW50LCBoYW5kbGVyLCB0YXJnZXQgPSB0aGlzLmVsZW1lbnQpIHtcbiAgICBjb25zdCBzdG9yZWQgPSB0aGlzLl9ib3VuZEhhbmRsZXJzLmdldChoYW5kbGVyKTtcbiAgICBpZiAoc3RvcmVkKSB7XG4gICAgICB0YXJnZXQucmVtb3ZlRXZlbnRMaXN0ZW5lcihldmVudCwgc3RvcmVkLmJvdW5kSGFuZGxlciwgc3RvcmVkLm9wdGlvbnMpO1xuICAgICAgdGhpcy5fYm91bmRIYW5kbGVycy5kZWxldGUoaGFuZGxlcik7XG4gICAgfVxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIEFkZCBhIG9uZS10aW1lIGV2ZW50IGxpc3RlbmVyXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBldmVudCAtIEV2ZW50IG5hbWVcbiAgICogQHBhcmFtIHtGdW5jdGlvbn0gaGFuZGxlciAtIEV2ZW50IGhhbmRsZXJcbiAgICogQHBhcmFtIHtFbGVtZW50fSBbdGFyZ2V0PXRoaXMuZWxlbWVudF0gLSBUYXJnZXQgZWxlbWVudFxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBvbmNlKGV2ZW50LCBoYW5kbGVyLCB0YXJnZXQgPSB0aGlzLmVsZW1lbnQpIHtcbiAgICByZXR1cm4gdGhpcy5vbihldmVudCwgaGFuZGxlciwgdGFyZ2V0LCB7IG9uY2U6IHRydWUgfSk7XG4gIH1cblxuICAvKipcbiAgICogQWRkIGRlbGVnYXRlZCBldmVudCBsaXN0ZW5lclxuICAgKiBAcGFyYW0ge3N0cmluZ30gZXZlbnQgLSBFdmVudCBuYW1lXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBzZWxlY3RvciAtIENTUyBzZWxlY3RvciBmb3IgZGVsZWdhdGlvblxuICAgKiBAcGFyYW0ge0Z1bmN0aW9ufSBoYW5kbGVyIC0gRXZlbnQgaGFuZGxlclxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBkZWxlZ2F0ZShldmVudCwgc2VsZWN0b3IsIGhhbmRsZXIpIHtcbiAgICBjb25zdCBkZWxlZ2F0ZWRIYW5kbGVyID0gKGUpID0+IHtcbiAgICAgIGNvbnN0IHRhcmdldCA9IGUudGFyZ2V0LmNsb3Nlc3Qoc2VsZWN0b3IpO1xuICAgICAgaWYgKHRhcmdldCAmJiB0aGlzLmVsZW1lbnQuY29udGFpbnModGFyZ2V0KSkge1xuICAgICAgICBoYW5kbGVyLmNhbGwodGhpcywgZSwgdGFyZ2V0KTtcbiAgICAgIH1cbiAgICB9O1xuXG4gICAgdGhpcy5fZGVsZWdhdGVkSGFuZGxlcnMucHVzaCh7IGV2ZW50LCBoYW5kbGVyOiBkZWxlZ2F0ZWRIYW5kbGVyIH0pO1xuICAgIHRoaXMuZWxlbWVudC5hZGRFdmVudExpc3RlbmVyKGV2ZW50LCBkZWxlZ2F0ZWRIYW5kbGVyKTtcbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBFbWl0IGEgY3VzdG9tIGV2ZW50XG4gICAqIEBwYXJhbSB7c3RyaW5nfSBuYW1lIC0gRXZlbnQgbmFtZSAod2lsbCBiZSBwcmVmaXhlZCB3aXRoIHNvOilcbiAgICogQHBhcmFtIHtPYmplY3R9IFtkZXRhaWw9e31dIC0gRXZlbnQgZGV0YWlsIGRhdGFcbiAgICogQHBhcmFtIHtib29sZWFufSBbYnViYmxlcz10cnVlXSAtIFdoZXRoZXIgZXZlbnQgYnViYmxlc1xuICAgKiBAcGFyYW0ge2Jvb2xlYW59IFtjYW5jZWxhYmxlPXRydWVdIC0gV2hldGhlciBldmVudCBpcyBjYW5jZWxhYmxlXG4gICAqIEByZXR1cm5zIHtib29sZWFufSBXaGV0aGVyIGV2ZW50IHdhcyBub3QgcHJldmVudGVkXG4gICAqL1xuICBlbWl0KG5hbWUsIGRldGFpbCA9IHt9LCBidWJibGVzID0gdHJ1ZSwgY2FuY2VsYWJsZSA9IHRydWUpIHtcbiAgICBjb25zdCBldmVudCA9IG5ldyBDdXN0b21FdmVudChTaXhPcmJpdC5ldnQobmFtZSksIHtcbiAgICAgIGRldGFpbDogeyAuLi5kZXRhaWwsIGNvbXBvbmVudDogdGhpcyB9LFxuICAgICAgYnViYmxlcyxcbiAgICAgIGNhbmNlbGFibGVcbiAgICB9KTtcbiAgICByZXR1cm4gdGhpcy5lbGVtZW50LmRpc3BhdGNoRXZlbnQoZXZlbnQpO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gU1RBVEUgTUFOQUdFTUVOVFxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBVcGRhdGUgY29tcG9uZW50IHN0YXRlIGFuZCB0cmlnZ2VyIHJlLXJlbmRlclxuICAgKiBAcGFyYW0ge09iamVjdH0gbmV3U3RhdGUgLSBTdGF0ZSBjaGFuZ2VzXG4gICAqL1xuICBzZXRTdGF0ZShuZXdTdGF0ZSkge1xuICAgIGNvbnN0IG9sZFN0YXRlID0geyAuLi50aGlzLl9zdGF0ZSB9O1xuICAgIHRoaXMuX3N0YXRlID0geyAuLi50aGlzLl9zdGF0ZSwgLi4ubmV3U3RhdGUgfTtcbiAgICB0aGlzLl9vblN0YXRlQ2hhbmdlKHRoaXMuX3N0YXRlLCBvbGRTdGF0ZSk7XG4gIH1cblxuICAvKipcbiAgICogR2V0IGN1cnJlbnQgc3RhdGVcbiAgICogQHJldHVybnMge09iamVjdH0gQ3VycmVudCBzdGF0ZVxuICAgKi9cbiAgZ2V0U3RhdGUoKSB7XG4gICAgcmV0dXJuIHsgLi4udGhpcy5fc3RhdGUgfTtcbiAgfVxuXG4gIC8qKlxuICAgKiBDYWxsZWQgd2hlbiBzdGF0ZSBjaGFuZ2VzIChvdmVycmlkZSBpbiBzdWJjbGFzcylcbiAgICogQHBhcmFtIHtPYmplY3R9IG5ld1N0YXRlIC0gTmV3IHN0YXRlXG4gICAqIEBwYXJhbSB7T2JqZWN0fSBvbGRTdGF0ZSAtIFByZXZpb3VzIHN0YXRlXG4gICAqIEBwcm90ZWN0ZWRcbiAgICovXG4gIF9vblN0YXRlQ2hhbmdlKG5ld1N0YXRlLCBvbGRTdGF0ZSkge1xuICAgIC8vIE92ZXJyaWRlIGluIHN1YmNsYXNzXG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBWSVNJQklMSVRZXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIFNob3cgdGhlIGNvbXBvbmVudCBlbGVtZW50XG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHNob3coKSB7XG4gICAgdGhpcy5lbGVtZW50LnN0eWxlLmRpc3BsYXkgPSAnJztcbiAgICB0aGlzLmVsZW1lbnQucmVtb3ZlQXR0cmlidXRlKCdoaWRkZW4nKTtcbiAgICB0aGlzLmVtaXQoJ3Nob3cnKTtcbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBIaWRlIHRoZSBjb21wb25lbnQgZWxlbWVudFxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBoaWRlKCkge1xuICAgIHRoaXMuZWxlbWVudC5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuICAgIHRoaXMuZWxlbWVudC5zZXRBdHRyaWJ1dGUoJ2hpZGRlbicsICcnKTtcbiAgICB0aGlzLmVtaXQoJ2hpZGUnKTtcbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBUb2dnbGUgY29tcG9uZW50IHZpc2liaWxpdHlcbiAgICogQHBhcmFtIHtib29sZWFufSBbZm9yY2VdIC0gRm9yY2Ugc2hvdyBvciBoaWRlXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHRvZ2dsZShmb3JjZSkge1xuICAgIGNvbnN0IHNob3VsZFNob3cgPSBmb3JjZSAhPT0gdW5kZWZpbmVkID8gZm9yY2UgOiB0aGlzLmVsZW1lbnQuaGlkZGVuO1xuICAgIHJldHVybiBzaG91bGRTaG93ID8gdGhpcy5zaG93KCkgOiB0aGlzLmhpZGUoKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBDaGVjayBpZiBjb21wb25lbnQgaXMgdmlzaWJsZVxuICAgKiBAcmV0dXJucyB7Ym9vbGVhbn0gV2hldGhlciBjb21wb25lbnQgaXMgdmlzaWJsZVxuICAgKi9cbiAgaXNWaXNpYmxlKCkge1xuICAgIHJldHVybiAhdGhpcy5lbGVtZW50LmhpZGRlbiAmJiB0aGlzLmVsZW1lbnQuc3R5bGUuZGlzcGxheSAhPT0gJ25vbmUnO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gRk9DVVMgTUFOQUdFTUVOVFxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBGb2N1cyB0aGUgY29tcG9uZW50IGVsZW1lbnRcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgZm9jdXMoKSB7XG4gICAgdGhpcy5lbGVtZW50LmZvY3VzKCk7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogQmx1ciB0aGUgY29tcG9uZW50IGVsZW1lbnRcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgYmx1cigpIHtcbiAgICB0aGlzLmVsZW1lbnQuYmx1cigpO1xuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIEdldCBhbGwgZm9jdXNhYmxlIGVsZW1lbnRzIHdpdGhpbiBjb21wb25lbnRcbiAgICogQHJldHVybnMge0VsZW1lbnRbXX0gRm9jdXNhYmxlIGVsZW1lbnRzXG4gICAqL1xuICBnZXRGb2N1c2FibGVFbGVtZW50cygpIHtcbiAgICBjb25zdCBmb2N1c2FibGVTZWxlY3RvcnMgPSBbXG4gICAgICAnYVtocmVmXScsXG4gICAgICAnYnV0dG9uOm5vdChbZGlzYWJsZWRdKScsXG4gICAgICAnaW5wdXQ6bm90KFtkaXNhYmxlZF0pJyxcbiAgICAgICdzZWxlY3Q6bm90KFtkaXNhYmxlZF0pJyxcbiAgICAgICd0ZXh0YXJlYTpub3QoW2Rpc2FibGVkXSknLFxuICAgICAgJ1t0YWJpbmRleF06bm90KFt0YWJpbmRleD1cIi0xXCJdKScsXG4gICAgXS5qb2luKCcsICcpO1xuXG4gICAgcmV0dXJuIHRoaXMuJCQoZm9jdXNhYmxlU2VsZWN0b3JzKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBUcmFwIGZvY3VzIHdpdGhpbiBjb21wb25lbnQgKGZvciBtb2RhbHMsIGV0Yy4pXG4gICAqIEBwYXJhbSB7T2JqZWN0fSBbb3B0aW9ucz17fV0gLSBUcmFwIG9wdGlvbnNcbiAgICogQHBhcmFtIHtib29sZWFufSBbb3B0aW9ucy5za2lwSW5pdGlhbEZvY3VzPWZhbHNlXSAtIFNraXAgZm9jdXNpbmcgZmlyc3QgZWxlbWVudFxuICAgKiBAcmV0dXJucyB7RnVuY3Rpb259IEZ1bmN0aW9uIHRvIHJlbW92ZSBmb2N1cyB0cmFwXG4gICAqL1xuICB0cmFwRm9jdXMob3B0aW9ucyA9IHt9KSB7XG4gICAgY29uc3QgeyBza2lwSW5pdGlhbEZvY3VzID0gZmFsc2UgfSA9IG9wdGlvbnM7XG4gICAgY29uc3QgZm9jdXNhYmxlRWxlbWVudHMgPSB0aGlzLmdldEZvY3VzYWJsZUVsZW1lbnRzKCk7XG4gICAgY29uc3QgZmlyc3RFbGVtZW50ID0gZm9jdXNhYmxlRWxlbWVudHNbMF07XG4gICAgY29uc3QgbGFzdEVsZW1lbnQgPSBmb2N1c2FibGVFbGVtZW50c1tmb2N1c2FibGVFbGVtZW50cy5sZW5ndGggLSAxXTtcblxuICAgIGNvbnN0IGhhbmRsZUtleWRvd24gPSAoZSkgPT4ge1xuICAgICAgaWYgKGUua2V5ICE9PSAnVGFiJykgcmV0dXJuO1xuXG4gICAgICBpZiAoZS5zaGlmdEtleSkge1xuICAgICAgICBpZiAoZG9jdW1lbnQuYWN0aXZlRWxlbWVudCA9PT0gZmlyc3RFbGVtZW50KSB7XG4gICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAgIGxhc3RFbGVtZW50Py5mb2N1cygpO1xuICAgICAgICB9XG4gICAgICB9IGVsc2Uge1xuICAgICAgICBpZiAoZG9jdW1lbnQuYWN0aXZlRWxlbWVudCA9PT0gbGFzdEVsZW1lbnQpIHtcbiAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgICAgZmlyc3RFbGVtZW50Py5mb2N1cygpO1xuICAgICAgICB9XG4gICAgICB9XG4gICAgfTtcblxuICAgIHRoaXMuZWxlbWVudC5hZGRFdmVudExpc3RlbmVyKCdrZXlkb3duJywgaGFuZGxlS2V5ZG93bik7XG5cbiAgICBpZiAoIXNraXBJbml0aWFsRm9jdXMpIHtcbiAgICAgIGZpcnN0RWxlbWVudD8uZm9jdXMoKTtcbiAgICB9XG5cbiAgICByZXR1cm4gKCkgPT4ge1xuICAgICAgdGhpcy5lbGVtZW50LnJlbW92ZUV2ZW50TGlzdGVuZXIoJ2tleWRvd24nLCBoYW5kbGVLZXlkb3duKTtcbiAgICB9O1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gTElGRUNZQ0xFXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIEVuYWJsZSB0aGUgY29tcG9uZW50XG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIGVuYWJsZSgpIHtcbiAgICB0aGlzLmVsZW1lbnQucmVtb3ZlQXR0cmlidXRlKCdkaXNhYmxlZCcpO1xuICAgIHRoaXMucmVtb3ZlQ2xhc3MoU2l4T3JiaXQuY2xzKCdkaXNhYmxlZCcpKTtcbiAgICB0aGlzLl9kaXNhYmxlZCA9IGZhbHNlO1xuICAgIHRoaXMuZW1pdCgnZW5hYmxlJyk7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogRGlzYWJsZSB0aGUgY29tcG9uZW50XG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIGRpc2FibGUoKSB7XG4gICAgdGhpcy5lbGVtZW50LnNldEF0dHJpYnV0ZSgnZGlzYWJsZWQnLCAnJyk7XG4gICAgdGhpcy5hZGRDbGFzcyhTaXhPcmJpdC5jbHMoJ2Rpc2FibGVkJykpO1xuICAgIHRoaXMuX2Rpc2FibGVkID0gdHJ1ZTtcbiAgICB0aGlzLmVtaXQoJ2Rpc2FibGUnKTtcbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBDaGVjayBpZiBjb21wb25lbnQgaXMgZGlzYWJsZWRcbiAgICogQHJldHVybnMge2Jvb2xlYW59IFdoZXRoZXIgY29tcG9uZW50IGlzIGRpc2FibGVkXG4gICAqL1xuICBpc0Rpc2FibGVkKCkge1xuICAgIHJldHVybiB0aGlzLl9kaXNhYmxlZCB8fCB0aGlzLmVsZW1lbnQuaGFzQXR0cmlidXRlKCdkaXNhYmxlZCcpO1xuICB9XG5cbiAgLyoqXG4gICAqIFVwZGF0ZSBjb21wb25lbnQgb3B0aW9uc1xuICAgKiBAcGFyYW0ge09iamVjdH0gbmV3T3B0aW9ucyAtIE5ldyBvcHRpb25zIHRvIG1lcmdlXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHNldE9wdGlvbnMobmV3T3B0aW9ucykge1xuICAgIHRoaXMub3B0aW9ucyA9IHsgLi4udGhpcy5vcHRpb25zLCAuLi5uZXdPcHRpb25zIH07XG4gICAgdGhpcy5fb25PcHRpb25zQ2hhbmdlKCk7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogQ2FsbGVkIHdoZW4gb3B0aW9ucyBjaGFuZ2UgKG92ZXJyaWRlIGluIHN1YmNsYXNzKVxuICAgKiBAcHJvdGVjdGVkXG4gICAqL1xuICBfb25PcHRpb25zQ2hhbmdlKCkge1xuICAgIC8vIE92ZXJyaWRlIGluIHN1YmNsYXNzXG4gIH1cblxuICAvKipcbiAgICogRGVzdHJveSB0aGUgY29tcG9uZW50IGFuZCBjbGVhbiB1cFxuICAgKi9cbiAgZGVzdHJveSgpIHtcbiAgICAvLyBSZW1vdmUgYWxsIGJvdW5kIGV2ZW50IGxpc3RlbmVyc1xuICAgIHRoaXMuX2JvdW5kSGFuZGxlcnMuZm9yRWFjaCgoc3RvcmVkLCBoYW5kbGVyKSA9PiB7XG4gICAgICBzdG9yZWQudGFyZ2V0LnJlbW92ZUV2ZW50TGlzdGVuZXIoc3RvcmVkLmV2ZW50LCBzdG9yZWQuYm91bmRIYW5kbGVyLCBzdG9yZWQub3B0aW9ucyk7XG4gICAgfSk7XG4gICAgdGhpcy5fYm91bmRIYW5kbGVycy5jbGVhcigpO1xuXG4gICAgLy8gUmVtb3ZlIGRlbGVnYXRlZCBoYW5kbGVyc1xuICAgIHRoaXMuX2RlbGVnYXRlZEhhbmRsZXJzLmZvckVhY2goKHsgZXZlbnQsIGhhbmRsZXIgfSkgPT4ge1xuICAgICAgdGhpcy5lbGVtZW50LnJlbW92ZUV2ZW50TGlzdGVuZXIoZXZlbnQsIGhhbmRsZXIpO1xuICAgIH0pO1xuICAgIHRoaXMuX2RlbGVnYXRlZEhhbmRsZXJzID0gW107XG5cbiAgICAvLyBFbWl0IGRlc3Ryb3kgZXZlbnRcbiAgICB0aGlzLmVtaXQoJ2Rlc3Ryb3knKTtcblxuICAgIC8vIFJlbW92ZSBpbnN0YW5jZSBmcm9tIHJlZ2lzdHJ5XG4gICAgU2l4T3JiaXQucmVtb3ZlSW5zdGFuY2UodGhpcy5lbGVtZW50LCB0aGlzLmNvbnN0cnVjdG9yLk5BTUUpO1xuXG4gICAgLy8gQ2xlYXIgcmVmZXJlbmNlc1xuICAgIHRoaXMuZWxlbWVudCA9IG51bGw7XG4gICAgdGhpcy5vcHRpb25zID0gbnVsbDtcbiAgfVxuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIFNUQVRJQyBVVElMSVRJRVNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogR2V0IG9yIGNyZWF0ZSBpbnN0YW5jZSBmb3IgYW4gZWxlbWVudFxuICAgKiBAcGFyYW0ge0VsZW1lbnR8c3RyaW5nfSBlbGVtZW50IC0gRE9NIGVsZW1lbnQgb3Igc2VsZWN0b3JcbiAgICogQHBhcmFtIHtPYmplY3R9IFtvcHRpb25zPXt9XSAtIENvbXBvbmVudCBvcHRpb25zXG4gICAqIEByZXR1cm5zIHtTT0NvbXBvbmVudH0gQ29tcG9uZW50IGluc3RhbmNlXG4gICAqL1xuICBzdGF0aWMgZ2V0SW5zdGFuY2UoZWxlbWVudCwgb3B0aW9ucyA9IHt9KSB7XG4gICAgY29uc3QgZWwgPSB0eXBlb2YgZWxlbWVudCA9PT0gJ3N0cmluZycgPyBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKGVsZW1lbnQpIDogZWxlbWVudDtcbiAgICByZXR1cm4gU2l4T3JiaXQuZ2V0SW5zdGFuY2UoZWwsIHRoaXMuTkFNRSwgb3B0aW9ucyk7XG4gIH1cblxuICAvKipcbiAgICogSW5pdGlhbGl6ZSBhbGwgY29tcG9uZW50cyBtYXRjaGluZyBzZWxlY3RvclxuICAgKiBAcGFyYW0ge3N0cmluZ30gW3NlbGVjdG9yXSAtIENTUyBzZWxlY3RvciAoZGVmYXVsdDogZGF0YSBhdHRyaWJ1dGUpXG4gICAqIEBwYXJhbSB7T2JqZWN0fSBbb3B0aW9ucz17fV0gLSBEZWZhdWx0IG9wdGlvbnMgZm9yIGFsbCBpbnN0YW5jZXNcbiAgICogQHJldHVybnMge1NPQ29tcG9uZW50W119IEFycmF5IG9mIGluc3RhbmNlc1xuICAgKi9cbiAgc3RhdGljIGluaXRBbGwoc2VsZWN0b3IsIG9wdGlvbnMgPSB7fSkge1xuICAgIGNvbnN0IHNlbCA9IHNlbGVjdG9yIHx8IFNpeE9yYml0LmRhdGFTZWwodGhpcy5OQU1FKTtcbiAgICBjb25zdCBlbGVtZW50cyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoc2VsKTtcbiAgICByZXR1cm4gQXJyYXkuZnJvbShlbGVtZW50cykubWFwKGVsID0+IHRoaXMuZ2V0SW5zdGFuY2UoZWwsIG9wdGlvbnMpKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBSZWdpc3RlciB0aGlzIGNvbXBvbmVudCB3aXRoIFNpeE9yYml0XG4gICAqL1xuICBzdGF0aWMgcmVnaXN0ZXIoKSB7XG4gICAgU2l4T3JiaXQucmVnaXN0ZXJDb21wb25lbnQodGhpcy5OQU1FLCB0aGlzKTtcbiAgfVxufVxuXG4vLyBFeHBvc2UgdG8gZ2xvYmFsIHNjb3BlXG53aW5kb3cuU09Db21wb25lbnQgPSBTT0NvbXBvbmVudDtcblxuLy8gRXhwb3J0IGZvciBFUyBtb2R1bGVzXG5leHBvcnQgZGVmYXVsdCBTT0NvbXBvbmVudDtcbmV4cG9ydCB7IFNPQ29tcG9uZW50IH07XG4iLCAiLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbi8vIFNJWE9SQklUIFVJIC0gVEhFTUUgQ09OVFJPTExFUlxuLy8gSGFuZGxlcyB0aGVtZSBzd2l0Y2hpbmcgYW5kIGZvbnQgc2l6ZSBzY2FsaW5nXG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG5pbXBvcnQgU2l4T3JiaXQgZnJvbSAnLi4vY29yZS9zby1jb25maWcuanMnO1xuaW1wb3J0IFNPQ29tcG9uZW50IGZyb20gJy4uL2NvcmUvc28tY29tcG9uZW50LmpzJztcblxuLyoqXG4gKiBTT1RoZW1lIC0gVGhlbWUgY29udHJvbGxlciBjb21wb25lbnRcbiAqIE1hbmFnZXMgdGhlbWUgc3dpdGNoaW5nIChsaWdodCwgZGFyaywgc2lkZWJhci1kYXJrLCBzeXN0ZW0pXG4gKiBhbmQgZm9udCBzaXplIHNjYWxpbmcgKHNtYWxsLCBkZWZhdWx0LCBsYXJnZSlcbiAqL1xuY2xhc3MgU09UaGVtZSBleHRlbmRzIFNPQ29tcG9uZW50IHtcbiAgc3RhdGljIE5BTUUgPSAndGhlbWUnO1xuXG4gIHN0YXRpYyBERUZBVUxUUyA9IHtcbiAgICB0aGVtZXM6IFsnbGlnaHQnLCAnZGFyaycsICdzaWRlYmFyLWRhcmsnLCAnc3lzdGVtJ10sXG4gICAgZm9udFNpemVzOiBbJ3NtYWxsJywgJ2RlZmF1bHQnLCAnbGFyZ2UnXSxcbiAgICBkZWZhdWx0VGhlbWU6ICdzaWRlYmFyLWRhcmsnLFxuICAgIGRlZmF1bHRGb250U2l6ZTogJ2RlZmF1bHQnLFxuICAgIHN0b3JhZ2VLZXlUaGVtZTogJ3RoZW1lLXByZWZlcmVuY2UnLFxuICAgIHN0b3JhZ2VLZXlGb250OiAnZm9udHNpemUtcHJlZmVyZW5jZScsXG4gIH07XG5cbiAgc3RhdGljIEVWRU5UUyA9IHtcbiAgICBDSEFOR0U6ICd0aGVtZTpjaGFuZ2UnLFxuICAgIEZPTlRTSVpFOiAndGhlbWU6Zm9udHNpemUnLFxuICB9O1xuXG4gIC8qKlxuICAgKiBJbml0aWFsaXplIHRoZSB0aGVtZSBjb250cm9sbGVyXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaW5pdCgpIHtcbiAgICAvLyBDYWNoZSBET00gZWxlbWVudHNcbiAgICB0aGlzLnRoZW1lQnRuID0gdGhpcy4kKCcuc28tbmF2YmFyLXRoZW1lLWJ0bicpO1xuICAgIHRoaXMudGhlbWVEcm9wZG93biA9IHRoaXMuJCgnLnNvLW5hdmJhci10aGVtZS1kcm9wZG93bicpO1xuXG4gICAgLy8gU3RhdGVcbiAgICB0aGlzLl9jdXJyZW50VGhlbWUgPSB0aGlzLm9wdGlvbnMuZGVmYXVsdFRoZW1lO1xuICAgIHRoaXMuX2N1cnJlbnRGb250U2l6ZSA9IHRoaXMub3B0aW9ucy5kZWZhdWx0Rm9udFNpemU7XG5cbiAgICAvLyBSZXN0b3JlIHNhdmVkIHByZWZlcmVuY2VzXG4gICAgdGhpcy5fcmVzdG9yZVRoZW1lKCk7XG4gICAgdGhpcy5fcmVzdG9yZUZvbnRTaXplKCk7XG5cbiAgICAvLyBCaW5kIGV2ZW50c1xuICAgIHRoaXMuX2JpbmRFdmVudHMoKTtcblxuICAgIC8vIEFwcGx5IGluaXRpYWwgdGhlbWUgYW5kIGZvbnQgc2l6ZVxuICAgIHRoaXMuX2FwcGx5VGhlbWUoKTtcbiAgICB0aGlzLl9hcHBseUZvbnRTaXplKCk7XG4gIH1cblxuICAvKipcbiAgICogQmluZCBldmVudCBsaXN0ZW5lcnNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9iaW5kRXZlbnRzKCkge1xuICAgIC8vIFRvZ2dsZSBkcm9wZG93blxuICAgIGlmICh0aGlzLnRoZW1lQnRuKSB7XG4gICAgICB0aGlzLm9uKCdjbGljaycsIHRoaXMuX2hhbmRsZVRvZ2dsZSwgdGhpcy50aGVtZUJ0bik7XG4gICAgfVxuXG4gICAgLy8gVGhlbWUgb3B0aW9uIGNsaWNrc1xuICAgIHRoaXMuZGVsZWdhdGUoJ2NsaWNrJywgJy5zby1uYXZiYXItdGhlbWUtb3B0aW9uJywgdGhpcy5faGFuZGxlT3B0aW9uQ2xpY2spO1xuXG4gICAgLy8gQ2xvc2Ugb24gb3V0c2lkZSBjbGlja1xuICAgIHRoaXMub24oJ2NsaWNrJywgdGhpcy5faGFuZGxlT3V0c2lkZUNsaWNrLCBkb2N1bWVudCk7XG5cbiAgICAvLyBDbG9zZSBvbiBlc2NhcGVcbiAgICB0aGlzLm9uKCdrZXlkb3duJywgdGhpcy5faGFuZGxlS2V5ZG93biwgZG9jdW1lbnQpO1xuXG4gICAgLy8gTGlzdGVuIGZvciBzeXN0ZW0gdGhlbWUgY2hhbmdlc1xuICAgIGlmICh3aW5kb3cubWF0Y2hNZWRpYSkge1xuICAgICAgY29uc3QgbWVkaWFRdWVyeSA9IHdpbmRvdy5tYXRjaE1lZGlhKCcocHJlZmVycy1jb2xvci1zY2hlbWU6IGRhcmspJyk7XG4gICAgICBtZWRpYVF1ZXJ5LmFkZEV2ZW50TGlzdGVuZXIoJ2NoYW5nZScsICgpID0+IHtcbiAgICAgICAgaWYgKHRoaXMuX2N1cnJlbnRUaGVtZSA9PT0gJ3N5c3RlbScpIHtcbiAgICAgICAgICB0aGlzLl9hcHBseVRoZW1lKCk7XG4gICAgICAgIH1cbiAgICAgIH0pO1xuICAgIH1cblxuICAgIC8vIExpc3RlbiBmb3IgZ2xvYmFsIGRyb3Bkb3duIGNsb3NlIGV2ZW50XG4gICAgdGhpcy5vbignY2xvc2VBbGxEcm9wZG93bnMnLCB0aGlzLl9jbG9zZURyb3Bkb3duLCBkb2N1bWVudCk7XG4gIH1cblxuICAvKipcbiAgICogSGFuZGxlIHRvZ2dsZSBidXR0b24gY2xpY2tcbiAgICogQHBhcmFtIHtFdmVudH0gZSAtIENsaWNrIGV2ZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlVG9nZ2xlKGUpIHtcbiAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuICAgIGNvbnN0IGlzT3BlbiA9IHRoaXMuaGFzQ2xhc3MoJ3NvLW9wZW4nKTtcblxuICAgIGlmICghaXNPcGVuKSB7XG4gICAgICAvLyBDbG9zZSBvdGhlciBkcm9wZG93bnNcbiAgICAgIGRvY3VtZW50LmRpc3BhdGNoRXZlbnQobmV3IEN1c3RvbUV2ZW50KCdjbG9zZUFsbERyb3Bkb3ducycpKTtcbiAgICB9XG5cbiAgICB0aGlzLnRvZ2dsZUNsYXNzKCdzby1vcGVuJyk7XG4gIH1cblxuICAvKipcbiAgICogSGFuZGxlIHRoZW1lL2ZvbnRzaXplIG9wdGlvbiBjbGlja1xuICAgKiBAcGFyYW0ge0V2ZW50fSBlIC0gQ2xpY2sgZXZlbnRcbiAgICogQHBhcmFtIHtFbGVtZW50fSB0YXJnZXQgLSBDbGlja2VkIG9wdGlvbiBlbGVtZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlT3B0aW9uQ2xpY2soZSwgdGFyZ2V0KSB7XG4gICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcblxuICAgIGNvbnN0IHRoZW1lID0gdGFyZ2V0LmRhdGFzZXQudGhlbWU7XG4gICAgY29uc3QgZm9udHNpemUgPSB0YXJnZXQuZGF0YXNldC5mb250c2l6ZTtcblxuICAgIGlmICh0aGVtZSkge1xuICAgICAgdGhpcy5zZXRUaGVtZSh0aGVtZSk7XG4gICAgfSBlbHNlIGlmIChmb250c2l6ZSkge1xuICAgICAgdGhpcy5zZXRGb250U2l6ZShmb250c2l6ZSk7XG4gICAgfVxuXG4gICAgdGhpcy5fY2xvc2VEcm9wZG93bigpO1xuICB9XG5cbiAgLyoqXG4gICAqIEhhbmRsZSBvdXRzaWRlIGNsaWNrXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlT3V0c2lkZUNsaWNrKCkge1xuICAgIHRoaXMuX2Nsb3NlRHJvcGRvd24oKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUga2V5ZG93biBldmVudHNcbiAgICogQHBhcmFtIHtLZXlib2FyZEV2ZW50fSBlIC0gS2V5Ym9hcmQgZXZlbnRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVLZXlkb3duKGUpIHtcbiAgICBpZiAoZS5rZXkgPT09ICdFc2NhcGUnKSB7XG4gICAgICB0aGlzLl9jbG9zZURyb3Bkb3duKCk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIENsb3NlIHRoZSBkcm9wZG93blxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2Nsb3NlRHJvcGRvd24oKSB7XG4gICAgdGhpcy5yZW1vdmVDbGFzcygnc28tb3BlbicpO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gVEhFTUUgTUVUSE9EU1xuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBTZXQgdGhlIGN1cnJlbnQgdGhlbWVcbiAgICogQHBhcmFtIHtzdHJpbmd9IHRoZW1lIC0gVGhlbWUgbmFtZSAobGlnaHQsIGRhcmssIHNpZGViYXItZGFyaywgc3lzdGVtKVxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBzZXRUaGVtZSh0aGVtZSkge1xuICAgIGlmICghdGhpcy5vcHRpb25zLnRoZW1lcy5pbmNsdWRlcyh0aGVtZSkpIHtcbiAgICAgIGNvbnNvbGUud2FybihgU09UaGVtZTogSW52YWxpZCB0aGVtZSBcIiR7dGhlbWV9XCJgKTtcbiAgICAgIHJldHVybiB0aGlzO1xuICAgIH1cblxuICAgIGNvbnN0IHByZXZpb3VzVGhlbWUgPSB0aGlzLl9jdXJyZW50VGhlbWU7XG4gICAgdGhpcy5fY3VycmVudFRoZW1lID0gdGhlbWU7XG5cbiAgICB0aGlzLl9zYXZlVGhlbWUoKTtcbiAgICB0aGlzLl9hcHBseVRoZW1lKCk7XG4gICAgdGhpcy5fdXBkYXRlQWN0aXZlT3B0aW9uKCk7XG5cbiAgICAvLyBFbWl0IGV2ZW50XG4gICAgdGhpcy5lbWl0KFNPVGhlbWUuRVZFTlRTLkNIQU5HRSwge1xuICAgICAgdGhlbWUsXG4gICAgICBwcmV2aW91c1RoZW1lLFxuICAgICAgZWZmZWN0aXZlVGhlbWU6IHRoaXMuZ2V0RWZmZWN0aXZlVGhlbWUoKSxcbiAgICB9KTtcblxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIEdldCB0aGUgY3VycmVudCB0aGVtZSBzZXR0aW5nXG4gICAqIEByZXR1cm5zIHtzdHJpbmd9IEN1cnJlbnQgdGhlbWVcbiAgICovXG4gIGdldFRoZW1lKCkge1xuICAgIHJldHVybiB0aGlzLl9jdXJyZW50VGhlbWU7XG4gIH1cblxuICAvKipcbiAgICogR2V0IHRoZSBlZmZlY3RpdmUgdGhlbWUgKHJlc29sdmVkIHN5c3RlbSB0aGVtZSlcbiAgICogQHJldHVybnMge3N0cmluZ30gRWZmZWN0aXZlIHRoZW1lIChsaWdodCBvciBkYXJrKVxuICAgKi9cbiAgZ2V0RWZmZWN0aXZlVGhlbWUoKSB7XG4gICAgaWYgKHRoaXMuX2N1cnJlbnRUaGVtZSA9PT0gJ3N5c3RlbScpIHtcbiAgICAgIHJldHVybiB0aGlzLl9nZXRTeXN0ZW1UaGVtZSgpO1xuICAgIH1cbiAgICBpZiAodGhpcy5fY3VycmVudFRoZW1lID09PSAnc2lkZWJhci1kYXJrJykge1xuICAgICAgcmV0dXJuICdsaWdodCc7XG4gICAgfVxuICAgIHJldHVybiB0aGlzLl9jdXJyZW50VGhlbWU7XG4gIH1cblxuICAvKipcbiAgICogQXBwbHkgdGhlIGN1cnJlbnQgdGhlbWUgdG8gdGhlIGRvY3VtZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfYXBwbHlUaGVtZSgpIHtcbiAgICBsZXQgZWZmZWN0aXZlVGhlbWUgPSB0aGlzLl9jdXJyZW50VGhlbWU7XG4gICAgY29uc3Qgc2lkZWJhciA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5zby1zaWRlYmFyJyk7XG5cbiAgICAvLyBIYW5kbGUgc2lkZWJhci1kYXJrIHRoZW1lXG4gICAgaWYgKHRoaXMuX2N1cnJlbnRUaGVtZSA9PT0gJ3NpZGViYXItZGFyaycpIHtcbiAgICAgIGVmZmVjdGl2ZVRoZW1lID0gJ2xpZ2h0JztcbiAgICAgIGlmIChzaWRlYmFyKSBzaWRlYmFyLmNsYXNzTGlzdC5hZGQoJ3NpZGViYXItZGFyaycpO1xuICAgIH0gZWxzZSB7XG4gICAgICBpZiAoc2lkZWJhcikgc2lkZWJhci5jbGFzc0xpc3QucmVtb3ZlKCdzaWRlYmFyLWRhcmsnKTtcblxuICAgICAgLy8gUmVzb2x2ZSBzeXN0ZW0gdGhlbWVcbiAgICAgIGlmICh0aGlzLl9jdXJyZW50VGhlbWUgPT09ICdzeXN0ZW0nKSB7XG4gICAgICAgIGVmZmVjdGl2ZVRoZW1lID0gdGhpcy5fZ2V0U3lzdGVtVGhlbWUoKTtcbiAgICAgIH1cbiAgICB9XG5cbiAgICAvLyBBcHBseSB0byBkb2N1bWVudFxuICAgIGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zZXRBdHRyaWJ1dGUoJ2RhdGEtdGhlbWUnLCBlZmZlY3RpdmVUaGVtZSk7XG5cbiAgICAvLyBVcGRhdGUgaWNvblxuICAgIHRoaXMuX3VwZGF0ZUljb24oZWZmZWN0aXZlVGhlbWUpO1xuICB9XG5cbiAgLyoqXG4gICAqIEdldCBzeXN0ZW0gcHJlZmVycmVkIHRoZW1lXG4gICAqIEByZXR1cm5zIHtzdHJpbmd9IFN5c3RlbSB0aGVtZSAobGlnaHQgb3IgZGFyaylcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9nZXRTeXN0ZW1UaGVtZSgpIHtcbiAgICBpZiAod2luZG93Lm1hdGNoTWVkaWEgJiYgd2luZG93Lm1hdGNoTWVkaWEoJyhwcmVmZXJzLWNvbG9yLXNjaGVtZTogZGFyayknKS5tYXRjaGVzKSB7XG4gICAgICByZXR1cm4gJ2RhcmsnO1xuICAgIH1cbiAgICByZXR1cm4gJ2xpZ2h0JztcbiAgfVxuXG4gIC8qKlxuICAgKiBVcGRhdGUgdGhlIHRoZW1lIGJ1dHRvbiBpY29uXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBlZmZlY3RpdmVUaGVtZSAtIEN1cnJlbnQgZWZmZWN0aXZlIHRoZW1lXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfdXBkYXRlSWNvbihlZmZlY3RpdmVUaGVtZSkge1xuICAgIGNvbnN0IGljb24gPSB0aGlzLnRoZW1lQnRuPy5xdWVyeVNlbGVjdG9yKCcudGhlbWUtaWNvbicpO1xuICAgIGlmICghaWNvbikgcmV0dXJuO1xuXG4gICAgaWYgKHRoaXMuX2N1cnJlbnRUaGVtZSA9PT0gJ3NpZGViYXItZGFyaycpIHtcbiAgICAgIGljb24udGV4dENvbnRlbnQgPSAnY29udHJhc3QnO1xuICAgIH0gZWxzZSBpZiAodGhpcy5fY3VycmVudFRoZW1lID09PSAnc3lzdGVtJykge1xuICAgICAgaWNvbi50ZXh0Q29udGVudCA9ICdjb21wdXRlcic7XG4gICAgfSBlbHNlIGlmIChlZmZlY3RpdmVUaGVtZSA9PT0gJ2RhcmsnKSB7XG4gICAgICBpY29uLnRleHRDb250ZW50ID0gJ2RhcmtfbW9kZSc7XG4gICAgfSBlbHNlIHtcbiAgICAgIGljb24udGV4dENvbnRlbnQgPSAnbGlnaHRfbW9kZSc7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIFVwZGF0ZSBhY3RpdmUgc3RhdGUgb24gdGhlbWUgb3B0aW9uc1xuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3VwZGF0ZUFjdGl2ZU9wdGlvbigpIHtcbiAgICB0aGlzLiQkKCcuc28tbmF2YmFyLXRoZW1lLW9wdGlvbicpLmZvckVhY2gob3B0aW9uID0+IHtcbiAgICAgIGNvbnN0IGlzQWN0aXZlID0gb3B0aW9uLmRhdGFzZXQudGhlbWUgPT09IHRoaXMuX2N1cnJlbnRUaGVtZTtcbiAgICAgIG9wdGlvbi5jbGFzc0xpc3QudG9nZ2xlKCdzby1hY3RpdmUnLCBpc0FjdGl2ZSk7XG4gICAgfSk7XG4gIH1cblxuICAvKipcbiAgICogU2F2ZSB0aGVtZSBwcmVmZXJlbmNlIHRvIHN0b3JhZ2VcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9zYXZlVGhlbWUoKSB7XG4gICAgU2l4T3JiaXQuc2V0U3RvcmFnZSh0aGlzLm9wdGlvbnMuc3RvcmFnZUtleVRoZW1lLCB0aGlzLl9jdXJyZW50VGhlbWUpO1xuICB9XG5cbiAgLyoqXG4gICAqIFJlc3RvcmUgdGhlbWUgcHJlZmVyZW5jZSBmcm9tIHN0b3JhZ2VcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9yZXN0b3JlVGhlbWUoKSB7XG4gICAgY29uc3Qgc2F2ZWQgPSBTaXhPcmJpdC5nZXRTdG9yYWdlKHRoaXMub3B0aW9ucy5zdG9yYWdlS2V5VGhlbWUpO1xuICAgIGlmIChzYXZlZCAmJiB0aGlzLm9wdGlvbnMudGhlbWVzLmluY2x1ZGVzKHNhdmVkKSkge1xuICAgICAgdGhpcy5fY3VycmVudFRoZW1lID0gc2F2ZWQ7XG4gICAgfVxuICAgIHRoaXMuX3VwZGF0ZUFjdGl2ZU9wdGlvbigpO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gRk9OVCBTSVpFIE1FVEhPRFNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogU2V0IHRoZSBmb250IHNpemVcbiAgICogQHBhcmFtIHtzdHJpbmd9IHNpemUgLSBGb250IHNpemUgKHNtYWxsLCBkZWZhdWx0LCBsYXJnZSlcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgc2V0Rm9udFNpemUoc2l6ZSkge1xuICAgIGlmICghdGhpcy5vcHRpb25zLmZvbnRTaXplcy5pbmNsdWRlcyhzaXplKSkge1xuICAgICAgY29uc29sZS53YXJuKGBTT1RoZW1lOiBJbnZhbGlkIGZvbnQgc2l6ZSBcIiR7c2l6ZX1cImApO1xuICAgICAgcmV0dXJuIHRoaXM7XG4gICAgfVxuXG4gICAgY29uc3QgcHJldmlvdXNTaXplID0gdGhpcy5fY3VycmVudEZvbnRTaXplO1xuICAgIHRoaXMuX2N1cnJlbnRGb250U2l6ZSA9IHNpemU7XG5cbiAgICB0aGlzLl9zYXZlRm9udFNpemUoKTtcbiAgICB0aGlzLl9hcHBseUZvbnRTaXplKCk7XG4gICAgdGhpcy5fdXBkYXRlQWN0aXZlRm9udFNpemVPcHRpb24oKTtcblxuICAgIC8vIEVtaXQgZXZlbnRcbiAgICB0aGlzLmVtaXQoU09UaGVtZS5FVkVOVFMuRk9OVFNJWkUsIHtcbiAgICAgIGZvbnRTaXplOiBzaXplLFxuICAgICAgcHJldmlvdXNGb250U2l6ZTogcHJldmlvdXNTaXplLFxuICAgIH0pO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogR2V0IHRoZSBjdXJyZW50IGZvbnQgc2l6ZVxuICAgKiBAcmV0dXJucyB7c3RyaW5nfSBDdXJyZW50IGZvbnQgc2l6ZVxuICAgKi9cbiAgZ2V0Rm9udFNpemUoKSB7XG4gICAgcmV0dXJuIHRoaXMuX2N1cnJlbnRGb250U2l6ZTtcbiAgfVxuXG4gIC8qKlxuICAgKiBBcHBseSB0aGUgY3VycmVudCBmb250IHNpemUgdG8gdGhlIGRvY3VtZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfYXBwbHlGb250U2l6ZSgpIHtcbiAgICBpZiAodGhpcy5fY3VycmVudEZvbnRTaXplID09PSAnZGVmYXVsdCcpIHtcbiAgICAgIGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5yZW1vdmVBdHRyaWJ1dGUoJ2RhdGEtZm9udHNpemUnKTtcbiAgICB9IGVsc2Uge1xuICAgICAgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LnNldEF0dHJpYnV0ZSgnZGF0YS1mb250c2l6ZScsIHRoaXMuX2N1cnJlbnRGb250U2l6ZSk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIFVwZGF0ZSBhY3RpdmUgc3RhdGUgb24gZm9udCBzaXplIG9wdGlvbnNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF91cGRhdGVBY3RpdmVGb250U2l6ZU9wdGlvbigpIHtcbiAgICB0aGlzLiQkKCcuc28tbmF2YmFyLXRoZW1lLW9wdGlvbicpLmZvckVhY2gob3B0aW9uID0+IHtcbiAgICAgIGlmIChvcHRpb24uZGF0YXNldC5mb250c2l6ZSkge1xuICAgICAgICBjb25zdCBpc0FjdGl2ZSA9IG9wdGlvbi5kYXRhc2V0LmZvbnRzaXplID09PSB0aGlzLl9jdXJyZW50Rm9udFNpemU7XG4gICAgICAgIG9wdGlvbi5jbGFzc0xpc3QudG9nZ2xlKCdzby1hY3RpdmUnLCBpc0FjdGl2ZSk7XG4gICAgICB9XG4gICAgfSk7XG4gIH1cblxuICAvKipcbiAgICogU2F2ZSBmb250IHNpemUgcHJlZmVyZW5jZSB0byBzdG9yYWdlXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfc2F2ZUZvbnRTaXplKCkge1xuICAgIFNpeE9yYml0LnNldFN0b3JhZ2UodGhpcy5vcHRpb25zLnN0b3JhZ2VLZXlGb250LCB0aGlzLl9jdXJyZW50Rm9udFNpemUpO1xuICB9XG5cbiAgLyoqXG4gICAqIFJlc3RvcmUgZm9udCBzaXplIHByZWZlcmVuY2UgZnJvbSBzdG9yYWdlXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfcmVzdG9yZUZvbnRTaXplKCkge1xuICAgIGNvbnN0IHNhdmVkID0gU2l4T3JiaXQuZ2V0U3RvcmFnZSh0aGlzLm9wdGlvbnMuc3RvcmFnZUtleUZvbnQpO1xuICAgIGlmIChzYXZlZCAmJiB0aGlzLm9wdGlvbnMuZm9udFNpemVzLmluY2x1ZGVzKHNhdmVkKSkge1xuICAgICAgdGhpcy5fY3VycmVudEZvbnRTaXplID0gc2F2ZWQ7XG4gICAgfVxuICAgIHRoaXMuX3VwZGF0ZUFjdGl2ZUZvbnRTaXplT3B0aW9uKCk7XG4gIH1cbn1cblxuLy8gUmVnaXN0ZXIgY29tcG9uZW50XG5TT1RoZW1lLnJlZ2lzdGVyKCk7XG5cbi8vIEV4cG9zZSB0byBnbG9iYWwgc2NvcGVcbndpbmRvdy5TT1RoZW1lID0gU09UaGVtZTtcblxuLy8gRXhwb3J0IGZvciBFUyBtb2R1bGVzXG5leHBvcnQgZGVmYXVsdCBTT1RoZW1lO1xuZXhwb3J0IHsgU09UaGVtZSB9O1xuIiwgIi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4vLyBTSVhPUkJJVCBVSSAtIERST1BET1dOIENPTVBPTkVOVFxuLy8gSGFuZGxlcyBhbGwgZHJvcGRvd24gdmFyaWF0aW9uc1xuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuaW1wb3J0IFNpeE9yYml0IGZyb20gJy4uL2NvcmUvc28tY29uZmlnLmpzJztcbmltcG9ydCBTT0NvbXBvbmVudCBmcm9tICcuLi9jb3JlL3NvLWNvbXBvbmVudC5qcyc7XG5cbi8qKlxuICogU09Ecm9wZG93biAtIEJhc2UgZHJvcGRvd24gY29tcG9uZW50XG4gKiBTdXBwb3J0cyBzdGFuZGFyZCwgc2VhcmNoYWJsZSwgb3B0aW9ucywgYW5kIG91dGxldCBkcm9wZG93bnNcbiAqL1xuY2xhc3MgU09Ecm9wZG93biBleHRlbmRzIFNPQ29tcG9uZW50IHtcbiAgc3RhdGljIE5BTUUgPSAnZHJvcGRvd24nO1xuXG4gIHN0YXRpYyBERUZBVUxUUyA9IHtcbiAgICBjbG9zZU9uU2VsZWN0OiB0cnVlLFxuICAgIGNsb3NlT25PdXRzaWRlQ2xpY2s6IHRydWUsXG4gICAgb3Blbk9uRm9jdXM6IGZhbHNlLFxuICAgIHNlYXJjaGFibGU6IGZhbHNlLFxuICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IG9wdGlvbicsXG4gICAgc2VhcmNoUGxhY2Vob2xkZXI6ICdTZWFyY2guLi4nLFxuICAgIG5vUmVzdWx0c1RleHQ6ICdObyByZXN1bHRzIGZvdW5kJyxcbiAgICAvLyBOZXcgb3B0aW9uc1xuICAgIGF1dG9DbG9zZTogdHJ1ZSwgICAgICAgICAvLyB0cnVlLCBmYWxzZSwgJ2luc2lkZScsICdvdXRzaWRlJ1xuICAgIGRpcmVjdGlvbjogJ2Rvd24nLCAgICAgICAvLyBkb3duLCB1cCwgc3RhcnQsIGVuZFxuICAgIGFsaWdubWVudDogJ3N0YXJ0JywgICAgICAvLyBzdGFydCwgZW5kXG4gICAgLy8gU2VsZWN0aW9uIG9wdGlvbnNcbiAgICBzZWxlY3Rpb25TdHlsZTogJ2RlZmF1bHQnLCAvLyAnZGVmYXVsdCcgKGJnICsgY2hlY2spLCAnaGlnaGxpZ2h0JyAoYmcgb25seSksICdjaGVjaycgKGNoZWNrIG9ubHkpXG4gICAgbXVsdGlwbGU6IGZhbHNlLCAgICAgICAgIC8vIEFsbG93IG11bHRpcGxlIHNlbGVjdGlvbnNcbiAgICBtdWx0aXBsZVN0eWxlOiAnY2hlY2tib3gnLCAvLyAnY2hlY2tib3gnIChhZGRzIGNoZWNrYm94IGJveGVzKSwgJ2NoZWNrJyAodXNlcyBjaGVja21hcmsgaWNvbnMpXG4gICAgbWF4U2VsZWN0aW9uczogbnVsbCwgICAgIC8vIE1heCBzZWxlY3Rpb25zIGFsbG93ZWQgKG51bGwgPSB1bmxpbWl0ZWQpXG4gICAgbWluU2VsZWN0aW9uczogbnVsbCwgICAgIC8vIE1pbiBzZWxlY3Rpb25zIHJlcXVpcmVkIChudWxsID0gMCwgY2FuIGRlc2VsZWN0IGFsbClcbiAgICBzaG93QWN0aW9uczogZmFsc2UsICAgICAgLy8gU2hvdyBcIlNlbGVjdCBBbGxcIiAvIFwiU2VsZWN0IE5vbmVcIiBsaW5rcyBmb3IgbXVsdGlwbGUgc2VsZWN0aW9uXG4gICAgc2VsZWN0QWxsVGV4dDogJ0FsbCcsICAgIC8vIFRleHQgZm9yIHNlbGVjdCBhbGwgbGlua1xuICAgIHNlbGVjdE5vbmVUZXh0OiAnTm9uZScsICAvLyBUZXh0IGZvciBzZWxlY3Qgbm9uZSBsaW5rXG4gICAgYWxsU2VsZWN0ZWRUZXh0OiBudWxsLCAgIC8vIFRleHQgdG8gc2hvdyB3aGVuIGFsbCBpdGVtcyBhcmUgc2VsZWN0ZWQgKGUuZy4sIFwiQWxsIE91dGxldHNcIilcbiAgICBtdWx0aXBsZVNlbGVjdGVkVGV4dDogJ3tjb3VudH0gc2VsZWN0ZWQnLCAvLyBUZXh0IHRlbXBsYXRlIGZvciBtdWx0aXBsZSBzZWxlY3Rpb25zXG4gIH07XG5cbiAgc3RhdGljIEVWRU5UUyA9IHtcbiAgICAvLyBCZWZvcmUvQWZ0ZXIgc2hvdyBldmVudHMgKEJvb3RzdHJhcCBwYXR0ZXJuKVxuICAgIFNIT1c6ICdkcm9wZG93bjpzaG93JywgICAgICAgLy8gQmVmb3JlIG9wZW5pbmcgKGNhbmNlbGFibGUpXG4gICAgU0hPV046ICdkcm9wZG93bjpzaG93bicsICAgICAvLyBBZnRlciBvcGVuZWRcbiAgICBISURFOiAnZHJvcGRvd246aGlkZScsICAgICAgIC8vIEJlZm9yZSBjbG9zaW5nIChjYW5jZWxhYmxlKVxuICAgIEhJRERFTjogJ2Ryb3Bkb3duOmhpZGRlbicsICAgLy8gQWZ0ZXIgY2xvc2VkXG4gICAgLy8gT3RoZXIgZXZlbnRzXG4gICAgQ0hBTkdFOiAnZHJvcGRvd246Y2hhbmdlJyxcbiAgICBTRUFSQ0g6ICdkcm9wZG93bjpzZWFyY2gnLFxuICAgIEFDVElPTjogJ2Ryb3Bkb3duOmFjdGlvbicsXG4gIH07XG5cbiAgLyoqXG4gICAqIEluaXRpYWxpemUgdGhlIGRyb3Bkb3duXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaW5pdCgpIHtcbiAgICAvLyBEZXRlY3QgZHJvcGRvd24gdHlwZVxuICAgIHRoaXMuX3R5cGUgPSB0aGlzLl9kZXRlY3RUeXBlKCk7XG5cbiAgICAvLyBDYWNoZSBlbGVtZW50cyBiYXNlZCBvbiB0eXBlXG4gICAgdGhpcy5fY2FjaGVFbGVtZW50cygpO1xuXG4gICAgLy8gU3RhdGVcbiAgICB0aGlzLl9pc09wZW4gPSBmYWxzZTtcbiAgICB0aGlzLl9kaXNhYmxlZCA9IGZhbHNlO1xuICAgIHRoaXMuX3NlbGVjdGVkVmFsdWVzID0gW107ICAvLyBBcnJheSBmb3IgbXVsdGlwbGUgc2VsZWN0aW9uIHN1cHBvcnRcbiAgICB0aGlzLl9zZWxlY3RlZFRleHRzID0gW107ICAgLy8gQXJyYXkgZm9yIG11bHRpcGxlIHNlbGVjdGlvbiBzdXBwb3J0XG4gICAgdGhpcy5fb3JpZ2luYWxJdGVtcyA9IFtdO1xuICAgIHRoaXMuX2ZvY3VzZWRJbmRleCA9IC0xO1xuXG4gICAgLy8gU3RvcmUgb3JpZ2luYWwgQ1NTIGNsYXNzZXMgZm9yIGRpcmVjdGlvbi9hbGlnbm1lbnQgKHNldCB2aWEgSFRNTClcbiAgICB0aGlzLl9vcmlnaW5hbENsYXNzZXMgPSB7XG4gICAgICBkcm9wdXA6IHRoaXMuZWxlbWVudC5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWRyb3B1cCcpLFxuICAgICAgZHJvcHN0YXJ0OiB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1kcm9wc3RhcnQnKSxcbiAgICAgIGRyb3BlbmQ6IHRoaXMuZWxlbWVudC5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWRyb3BlbmQnKSxcbiAgICAgIG1lbnVFbmQ6IHRoaXMuZWxlbWVudC5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWRyb3Bkb3duLW1lbnUtZW5kJyksXG4gICAgfTtcblxuICAgIC8vIFN0b3JlIG9yaWdpbmFsIGl0ZW1zIGZvciBmaWx0ZXJpbmdcbiAgICBpZiAodGhpcy5faXRlbXNMaXN0KSB7XG4gICAgICB0aGlzLl9vcmlnaW5hbEl0ZW1zID0gQXJyYXkuZnJvbSh0aGlzLl9pdGVtc0xpc3QuY2hpbGRyZW4pO1xuICAgIH1cblxuICAgIC8vIFBhcnNlIGRhdGEgYXR0cmlidXRlcyBmb3Igb3B0aW9uc1xuICAgIHRoaXMuX3BhcnNlRGF0YUF0dHJpYnV0ZXMoKTtcblxuICAgIC8vIEdldCBpbml0aWFsIHNlbGVjdGlvblxuICAgIHRoaXMuX2dldEluaXRpYWxTZWxlY3Rpb24oKTtcblxuICAgIC8vIEJpbmQgZXZlbnRzXG4gICAgdGhpcy5fYmluZEV2ZW50cygpO1xuICB9XG5cbiAgLyoqXG4gICAqIFBhcnNlIGRhdGEgYXR0cmlidXRlcyBmb3IgY29uZmlndXJhdGlvblxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3BhcnNlRGF0YUF0dHJpYnV0ZXMoKSB7XG4gICAgY29uc3QgZWwgPSB0aGlzLmVsZW1lbnQ7XG5cbiAgICAvLyBhdXRvQ2xvc2VcbiAgICBpZiAoZWwuaGFzQXR0cmlidXRlKCdkYXRhLXNvLWF1dG8tY2xvc2UnKSkge1xuICAgICAgY29uc3QgdmFsID0gZWwuZ2V0QXR0cmlidXRlKCdkYXRhLXNvLWF1dG8tY2xvc2UnKTtcbiAgICAgIGlmICh2YWwgPT09ICd0cnVlJykgdGhpcy5vcHRpb25zLmF1dG9DbG9zZSA9IHRydWU7XG4gICAgICBlbHNlIGlmICh2YWwgPT09ICdmYWxzZScpIHRoaXMub3B0aW9ucy5hdXRvQ2xvc2UgPSBmYWxzZTtcbiAgICAgIGVsc2UgdGhpcy5vcHRpb25zLmF1dG9DbG9zZSA9IHZhbDsgLy8gJ2luc2lkZScgb3IgJ291dHNpZGUnXG4gICAgfVxuXG4gICAgLy8gZGlyZWN0aW9uXG4gICAgaWYgKGVsLmhhc0F0dHJpYnV0ZSgnZGF0YS1zby1kaXJlY3Rpb24nKSkge1xuICAgICAgdGhpcy5vcHRpb25zLmRpcmVjdGlvbiA9IGVsLmdldEF0dHJpYnV0ZSgnZGF0YS1zby1kaXJlY3Rpb24nKTtcbiAgICB9XG5cbiAgICAvLyBhbGlnbm1lbnRcbiAgICBpZiAoZWwuaGFzQXR0cmlidXRlKCdkYXRhLXNvLWFsaWdubWVudCcpKSB7XG4gICAgICB0aGlzLm9wdGlvbnMuYWxpZ25tZW50ID0gZWwuZ2V0QXR0cmlidXRlKCdkYXRhLXNvLWFsaWdubWVudCcpO1xuICAgIH1cblxuICAgIC8vIHNlbGVjdGlvblN0eWxlXG4gICAgaWYgKGVsLmhhc0F0dHJpYnV0ZSgnZGF0YS1zby1zZWxlY3Rpb24tc3R5bGUnKSkge1xuICAgICAgdGhpcy5vcHRpb25zLnNlbGVjdGlvblN0eWxlID0gZWwuZ2V0QXR0cmlidXRlKCdkYXRhLXNvLXNlbGVjdGlvbi1zdHlsZScpO1xuICAgIH1cblxuICAgIC8vIG11bHRpcGxlXG4gICAgaWYgKGVsLmhhc0F0dHJpYnV0ZSgnZGF0YS1zby1tdWx0aXBsZScpKSB7XG4gICAgICB0aGlzLm9wdGlvbnMubXVsdGlwbGUgPSBlbC5nZXRBdHRyaWJ1dGUoJ2RhdGEtc28tbXVsdGlwbGUnKSAhPT0gJ2ZhbHNlJztcbiAgICB9XG5cbiAgICAvLyBtYXhTZWxlY3Rpb25zXG4gICAgaWYgKGVsLmhhc0F0dHJpYnV0ZSgnZGF0YS1zby1tYXgtc2VsZWN0aW9ucycpKSB7XG4gICAgICB0aGlzLm9wdGlvbnMubWF4U2VsZWN0aW9ucyA9IHBhcnNlSW50KGVsLmdldEF0dHJpYnV0ZSgnZGF0YS1zby1tYXgtc2VsZWN0aW9ucycpLCAxMCkgfHwgbnVsbDtcbiAgICB9XG5cbiAgICAvLyBtaW5TZWxlY3Rpb25zXG4gICAgaWYgKGVsLmhhc0F0dHJpYnV0ZSgnZGF0YS1zby1taW4tc2VsZWN0aW9ucycpKSB7XG4gICAgICB0aGlzLm9wdGlvbnMubWluU2VsZWN0aW9ucyA9IHBhcnNlSW50KGVsLmdldEF0dHJpYnV0ZSgnZGF0YS1zby1taW4tc2VsZWN0aW9ucycpLCAxMCkgfHwgbnVsbDtcbiAgICB9XG5cbiAgICAvLyBtdWx0aXBsZVN0eWxlXG4gICAgaWYgKGVsLmhhc0F0dHJpYnV0ZSgnZGF0YS1zby1tdWx0aXBsZS1zdHlsZScpKSB7XG4gICAgICB0aGlzLm9wdGlvbnMubXVsdGlwbGVTdHlsZSA9IGVsLmdldEF0dHJpYnV0ZSgnZGF0YS1zby1tdWx0aXBsZS1zdHlsZScpO1xuICAgIH1cblxuICAgIC8vIEFwcGx5IHNlbGVjdGlvbiBzdHlsZSBjbGFzc1xuICAgIGlmICh0aGlzLm9wdGlvbnMuc2VsZWN0aW9uU3R5bGUgIT09ICdkZWZhdWx0Jykge1xuICAgICAgdGhpcy5hZGRDbGFzcyhgc28tZHJvcGRvd24tc2VsZWN0aW9uLSR7dGhpcy5vcHRpb25zLnNlbGVjdGlvblN0eWxlfWApO1xuICAgIH1cblxuICAgIC8vIEFwcGx5IG11bHRpcGxlIGNsYXNzIGFuZCBpbml0aWFsaXplIGNoZWNrYm94ZXMgKG9ubHkgaWYgbXVsdGlwbGVTdHlsZSBpcyAnY2hlY2tib3gnKVxuICAgIGlmICh0aGlzLm9wdGlvbnMubXVsdGlwbGUpIHtcbiAgICAgIHRoaXMuYWRkQ2xhc3MoJ3NvLWRyb3Bkb3duLW11bHRpcGxlJyk7XG4gICAgICBpZiAodGhpcy5vcHRpb25zLm11bHRpcGxlU3R5bGUgPT09ICdjaGVja2JveCcpIHtcbiAgICAgICAgdGhpcy5faW5pdENoZWNrYm94ZXMoKTtcbiAgICAgIH0gZWxzZSBpZiAodGhpcy5vcHRpb25zLm11bHRpcGxlU3R5bGUgPT09ICdjaGVjaycpIHtcbiAgICAgICAgLy8gQWRkIG11bHRpcGxlLWNoZWNrIGNsYXNzIHRvIHNob3cgY2hlY2sgaWNvbnMgd2l0aCBiYWNrZ3JvdW5kIChub3QgY2hlY2tib3hlcylcbiAgICAgICAgdGhpcy5hZGRDbGFzcygnc28tZHJvcGRvd24tbXVsdGlwbGUtY2hlY2snKTtcbiAgICAgIH1cbiAgICB9XG5cbiAgICAvLyBzaG93QWN0aW9uc1xuICAgIGlmIChlbC5oYXNBdHRyaWJ1dGUoJ2RhdGEtc28tc2hvdy1hY3Rpb25zJykpIHtcbiAgICAgIHRoaXMub3B0aW9ucy5zaG93QWN0aW9ucyA9IGVsLmdldEF0dHJpYnV0ZSgnZGF0YS1zby1zaG93LWFjdGlvbnMnKSAhPT0gJ2ZhbHNlJztcbiAgICB9XG5cbiAgICAvLyBzZWxlY3RBbGxUZXh0XG4gICAgaWYgKGVsLmhhc0F0dHJpYnV0ZSgnZGF0YS1zby1zZWxlY3QtYWxsLXRleHQnKSkge1xuICAgICAgdGhpcy5vcHRpb25zLnNlbGVjdEFsbFRleHQgPSBlbC5nZXRBdHRyaWJ1dGUoJ2RhdGEtc28tc2VsZWN0LWFsbC10ZXh0Jyk7XG4gICAgfVxuXG4gICAgLy8gc2VsZWN0Tm9uZVRleHRcbiAgICBpZiAoZWwuaGFzQXR0cmlidXRlKCdkYXRhLXNvLXNlbGVjdC1ub25lLXRleHQnKSkge1xuICAgICAgdGhpcy5vcHRpb25zLnNlbGVjdE5vbmVUZXh0ID0gZWwuZ2V0QXR0cmlidXRlKCdkYXRhLXNvLXNlbGVjdC1ub25lLXRleHQnKTtcbiAgICB9XG5cbiAgICAvLyBDcmVhdGUgYWN0aW9ucyBiYXIgZm9yIG11bHRpcGxlIHNlbGVjdGlvbiBpZiBlbmFibGVkXG4gICAgaWYgKHRoaXMub3B0aW9ucy5tdWx0aXBsZSAmJiB0aGlzLm9wdGlvbnMuc2hvd0FjdGlvbnMpIHtcbiAgICAgIHRoaXMuX2NyZWF0ZUFjdGlvbnNCYXIoKTtcbiAgICB9XG5cbiAgICAvLyBhbGxTZWxlY3RlZFRleHRcbiAgICBpZiAoZWwuaGFzQXR0cmlidXRlKCdkYXRhLXNvLWFsbC1zZWxlY3RlZC10ZXh0JykpIHtcbiAgICAgIHRoaXMub3B0aW9ucy5hbGxTZWxlY3RlZFRleHQgPSBlbC5nZXRBdHRyaWJ1dGUoJ2RhdGEtc28tYWxsLXNlbGVjdGVkLXRleHQnKTtcbiAgICB9XG5cbiAgICAvLyBtdWx0aXBsZVNlbGVjdGVkVGV4dFxuICAgIGlmIChlbC5oYXNBdHRyaWJ1dGUoJ2RhdGEtc28tbXVsdGlwbGUtc2VsZWN0ZWQtdGV4dCcpKSB7XG4gICAgICB0aGlzLm9wdGlvbnMubXVsdGlwbGVTZWxlY3RlZFRleHQgPSBlbC5nZXRBdHRyaWJ1dGUoJ2RhdGEtc28tbXVsdGlwbGUtc2VsZWN0ZWQtdGV4dCcpO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBJbml0aWFsaXplIGNoZWNrYm94IGVsZW1lbnRzIGZvciBtdWx0aXBsZSBzZWxlY3Rpb24gaXRlbXNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9pbml0Q2hlY2tib3hlcygpIHtcbiAgICBjb25zdCBpdGVtU2VsZWN0b3IgPSB0aGlzLl9nZXRJdGVtU2VsZWN0b3IoKTtcbiAgICBjb25zdCBpdGVtcyA9IHRoaXMuJCQoaXRlbVNlbGVjdG9yKTtcblxuICAgIGl0ZW1zLmZvckVhY2goaXRlbSA9PiB7XG4gICAgICAvLyBTa2lwIGlmIGNoZWNrYm94IGFscmVhZHkgZXhpc3RzXG4gICAgICBpZiAoaXRlbS5xdWVyeVNlbGVjdG9yKCcuc28tY2hlY2tib3gtYm94JykpIHJldHVybjtcblxuICAgICAgLy8gQ3JlYXRlIGNoZWNrYm94IGJveCBlbGVtZW50IG1hdGNoaW5nIC5zby1jaGVja2JveC1ib3ggc3RydWN0dXJlXG4gICAgICBjb25zdCBjaGVja2JveEJveCA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ3NwYW4nKTtcbiAgICAgIGNoZWNrYm94Qm94LmNsYXNzTmFtZSA9ICdzby1jaGVja2JveC1ib3gnO1xuICAgICAgY2hlY2tib3hCb3guaW5uZXJIVE1MID0gJzxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnNcIj5jaGVjazwvc3Bhbj4nO1xuXG4gICAgICAvLyBJbnNlcnQgYXQgdGhlIGJlZ2lubmluZyBvZiB0aGUgaXRlbVxuICAgICAgaXRlbS5pbnNlcnRCZWZvcmUoY2hlY2tib3hCb3gsIGl0ZW0uZmlyc3RDaGlsZCk7XG4gICAgfSk7XG4gIH1cblxuICAvKipcbiAgICogQ3JlYXRlIGFjdGlvbnMgYmFyIHdpdGggU2VsZWN0IEFsbCAvIFNlbGVjdCBOb25lIGxpbmtzXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfY3JlYXRlQWN0aW9uc0JhcigpIHtcbiAgICBpZiAoIXRoaXMuX21lbnUpIHJldHVybjtcblxuICAgIC8vIENoZWNrIGlmIGFjdGlvbnMgYmFyIGFscmVhZHkgZXhpc3RzXG4gICAgaWYgKHRoaXMuX21lbnUucXVlcnlTZWxlY3RvcignLnNvLWRyb3Bkb3duLWFjdGlvbnMnKSkgcmV0dXJuO1xuXG4gICAgLy8gQ3JlYXRlIGFjdGlvbnMgYmFyXG4gICAgY29uc3QgYWN0aW9uc0JhciA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2RpdicpO1xuICAgIGFjdGlvbnNCYXIuY2xhc3NOYW1lID0gJ3NvLWRyb3Bkb3duLWFjdGlvbnMnO1xuXG4gICAgLy8gU2VsZWN0IEFsbCBsaW5rXG4gICAgY29uc3Qgc2VsZWN0QWxsTGluayA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2J1dHRvbicpO1xuICAgIHNlbGVjdEFsbExpbmsudHlwZSA9ICdidXR0b24nO1xuICAgIHNlbGVjdEFsbExpbmsuY2xhc3NOYW1lID0gJ3NvLWRyb3Bkb3duLWFjdGlvbiBzby1kcm9wZG93bi1zZWxlY3QtYWxsJztcbiAgICBzZWxlY3RBbGxMaW5rLnRleHRDb250ZW50ID0gdGhpcy5vcHRpb25zLnNlbGVjdEFsbFRleHQ7XG4gICAgc2VsZWN0QWxsTGluay5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgdGhpcy5zZWxlY3RBbGwoKTtcbiAgICB9KTtcblxuICAgIC8vIFNlcGFyYXRvclxuICAgIGNvbnN0IHNlcGFyYXRvciA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ3NwYW4nKTtcbiAgICBzZXBhcmF0b3IuY2xhc3NOYW1lID0gJ3NvLWRyb3Bkb3duLWFjdGlvbi1zZXBhcmF0b3InO1xuICAgIHNlcGFyYXRvci50ZXh0Q29udGVudCA9ICd8JztcblxuICAgIC8vIFNlbGVjdCBOb25lIGxpbmtcbiAgICBjb25zdCBzZWxlY3ROb25lTGluayA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2J1dHRvbicpO1xuICAgIHNlbGVjdE5vbmVMaW5rLnR5cGUgPSAnYnV0dG9uJztcbiAgICBzZWxlY3ROb25lTGluay5jbGFzc05hbWUgPSAnc28tZHJvcGRvd24tYWN0aW9uIHNvLWRyb3Bkb3duLXNlbGVjdC1ub25lJztcbiAgICBzZWxlY3ROb25lTGluay50ZXh0Q29udGVudCA9IHRoaXMub3B0aW9ucy5zZWxlY3ROb25lVGV4dDtcbiAgICBzZWxlY3ROb25lTGluay5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgdGhpcy5zZWxlY3ROb25lKCk7XG4gICAgfSk7XG5cbiAgICBhY3Rpb25zQmFyLmFwcGVuZENoaWxkKHNlbGVjdEFsbExpbmspO1xuXG4gICAgLy8gT25seSBhZGQgc2VwYXJhdG9yIGFuZCBOb25lIGxpbmsgaWYgc2VsZWN0Tm9uZVRleHQgaXMgbm90IGVtcHR5XG4gICAgaWYgKHRoaXMub3B0aW9ucy5zZWxlY3ROb25lVGV4dCkge1xuICAgICAgYWN0aW9uc0Jhci5hcHBlbmRDaGlsZChzZXBhcmF0b3IpO1xuICAgICAgYWN0aW9uc0Jhci5hcHBlbmRDaGlsZChzZWxlY3ROb25lTGluayk7XG4gICAgfVxuXG4gICAgLy8gSW5zZXJ0IGFjdGlvbnMgYmFyIGF0IHRoZSBiZWdpbm5pbmcgb2YgbWVudSAob3IgYWZ0ZXIgc2VhcmNoIGlmIHByZXNlbnQpXG4gICAgY29uc3Qgc2VhcmNoQm94ID0gdGhpcy5fbWVudS5xdWVyeVNlbGVjdG9yKCcuc28tc2VhcmNoYWJsZS1zZWFyY2gsIC5zby1kcm9wZG93bi1zZWFyY2gnKTtcbiAgICBpZiAoc2VhcmNoQm94KSB7XG4gICAgICBzZWFyY2hCb3guYWZ0ZXIoYWN0aW9uc0Jhcik7XG4gICAgfSBlbHNlIHtcbiAgICAgIHRoaXMuX21lbnUuaW5zZXJ0QmVmb3JlKGFjdGlvbnNCYXIsIHRoaXMuX21lbnUuZmlyc3RDaGlsZCk7XG4gICAgfVxuXG4gICAgLy8gU3RvcmUgcmVmZXJlbmNlc1xuICAgIHRoaXMuX2FjdGlvbnNCYXIgPSBhY3Rpb25zQmFyO1xuICAgIHRoaXMuX3NlbGVjdEFsbExpbmsgPSBzZWxlY3RBbGxMaW5rO1xuICAgIHRoaXMuX3NlbGVjdE5vbmVMaW5rID0gc2VsZWN0Tm9uZUxpbms7XG4gIH1cblxuICAvKipcbiAgICogRGV0ZWN0IGRyb3Bkb3duIHR5cGUgYmFzZWQgb24gY2xhc3Nlc1xuICAgKiBAcmV0dXJucyB7c3RyaW5nfSBEcm9wZG93biB0eXBlXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfZGV0ZWN0VHlwZSgpIHtcbiAgICBpZiAodGhpcy5oYXNDbGFzcygnc28tc2VhcmNoYWJsZS1kcm9wZG93bicpKSByZXR1cm4gJ3NlYXJjaGFibGUnO1xuICAgIGlmICh0aGlzLmhhc0NsYXNzKCdzby1vcHRpb25zLWRyb3Bkb3duJykpIHJldHVybiAnb3B0aW9ucyc7XG4gICAgaWYgKHRoaXMuaGFzQ2xhc3MoJ3NvLW91dGxldC1kcm9wZG93bicpKSByZXR1cm4gJ291dGxldCc7XG4gICAgcmV0dXJuICdzdGFuZGFyZCc7XG4gIH1cblxuICAvKipcbiAgICogQ2FjaGUgRE9NIGVsZW1lbnRzIGJhc2VkIG9uIHR5cGVcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9jYWNoZUVsZW1lbnRzKCkge1xuICAgIHN3aXRjaCAodGhpcy5fdHlwZSkge1xuICAgICAgY2FzZSAnc2VhcmNoYWJsZSc6XG4gICAgICAgIC8vIExlZ2FjeSBzZWFyY2hhYmxlIGNsYXNzZXNcbiAgICAgICAgdGhpcy5fdHJpZ2dlciA9IHRoaXMuJCgnLnNvLXNlYXJjaGFibGUtdHJpZ2dlcicpO1xuICAgICAgICB0aGlzLl9tZW51ID0gdGhpcy4kKCcuc28tc2VhcmNoYWJsZS1tZW51Jyk7XG4gICAgICAgIHRoaXMuX3NlYXJjaElucHV0ID0gdGhpcy4kKCcuc28tc2VhcmNoYWJsZS1pbnB1dCcpO1xuICAgICAgICB0aGlzLl9pdGVtc0xpc3QgPSB0aGlzLiQoJy5zby1zZWFyY2hhYmxlLWl0ZW1zJyk7XG4gICAgICAgIHRoaXMuX3NlbGVjdGVkRWwgPSB0aGlzLiQoJy5zby1zZWFyY2hhYmxlLXNlbGVjdGVkJyk7XG4gICAgICAgIGJyZWFrO1xuXG4gICAgICBjYXNlICdvcHRpb25zJzpcbiAgICAgICAgdGhpcy5fdHJpZ2dlciA9IHRoaXMuJCgnLnNvLW9wdGlvbnMtdHJpZ2dlcicpO1xuICAgICAgICB0aGlzLl9tZW51ID0gdGhpcy4kKCcuc28tb3B0aW9ucy1tZW51Jyk7XG4gICAgICAgIGJyZWFrO1xuXG4gICAgICBjYXNlICdvdXRsZXQnOlxuICAgICAgICB0aGlzLl90cmlnZ2VyID0gdGhpcy4kKCcuc28tb3V0bGV0LWRyb3Bkb3duLXRyaWdnZXInKTtcbiAgICAgICAgdGhpcy5fbWVudSA9IHRoaXMuJCgnLnNvLW91dGxldC1kcm9wZG93bi1tZW51Jyk7XG4gICAgICAgIHRoaXMuX3NlYXJjaElucHV0ID0gdGhpcy4kKCcuc28tb3V0bGV0LWRyb3Bkb3duLXNlYXJjaCBpbnB1dCcpO1xuICAgICAgICB0aGlzLl9pdGVtc0xpc3QgPSB0aGlzLiQoJy5zby1vdXRsZXQtZHJvcGRvd24tbGlzdCcpO1xuICAgICAgICB0aGlzLl9zZWxlY3RlZEVsID0gdGhpcy4kKCcub3V0bGV0LXRleHQnKTtcbiAgICAgICAgYnJlYWs7XG5cbiAgICAgIGRlZmF1bHQ6XG4gICAgICAgIC8vIFN0YW5kYXJkIGRyb3Bkb3duIC0gdHJpZ2dlciBjYW4gYmUgLnNvLWRyb3Bkb3duLXRyaWdnZXIsIC5zby1idG4sIG9yIC5zby1kcm9wZG93bi10b2dnbGUgKGZvciBuYXZiYXIpXG4gICAgICAgIHRoaXMuX3RyaWdnZXIgPSB0aGlzLiQoJy5zby1kcm9wZG93bi10cmlnZ2VyJykgfHwgdGhpcy4kKCcuc28tZHJvcGRvd24tdG9nZ2xlJykgfHwgdGhpcy4kKCcuc28tYnRuJyk7XG4gICAgICAgIHRoaXMuX21lbnUgPSB0aGlzLiQoJy5zby1kcm9wZG93bi1tZW51Jyk7XG4gICAgICAgIHRoaXMuX3NlbGVjdGVkRWwgPSB0aGlzLiQoJy5zby1kcm9wZG93bi1zZWxlY3RlZCcpO1xuICAgICAgICAvLyBGb3Igc2VhcmNoYWJsZSBtb2RpZmllciBvbiBzdGFuZGFyZCBkcm9wZG93blxuICAgICAgICB0aGlzLl9zZWFyY2hJbnB1dCA9IHRoaXMuJCgnLnNvLWRyb3Bkb3duLXNlYXJjaC1pbnB1dCcpO1xuICAgICAgICB0aGlzLl9pdGVtc0xpc3QgPSB0aGlzLiQoJy5zby1kcm9wZG93bi1pdGVtcycpO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgaW5pdGlhbCBzZWxlY3Rpb24gZnJvbSBET01cbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9nZXRJbml0aWFsU2VsZWN0aW9uKCkge1xuICAgIGNvbnN0IHNlbGVjdGVkSXRlbXMgPSB0aGlzLl9tZW51Py5xdWVyeVNlbGVjdG9yQWxsKCcuc28tc2VsZWN0ZWQsIC5zby1hY3RpdmUnKSB8fCBbXTtcbiAgICBzZWxlY3RlZEl0ZW1zLmZvckVhY2goaXRlbSA9PiB7XG4gICAgICBjb25zdCB2YWx1ZSA9IGl0ZW0uZGF0YXNldC52YWx1ZTtcbiAgICAgIGNvbnN0IHRleHQgPSB0aGlzLl9nZXRJdGVtVGV4dChpdGVtKTtcbiAgICAgIGlmICh2YWx1ZSAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICAgIHRoaXMuX3NlbGVjdGVkVmFsdWVzLnB1c2godmFsdWUpO1xuICAgICAgICB0aGlzLl9zZWxlY3RlZFRleHRzLnB1c2godGV4dCk7XG4gICAgICB9XG4gICAgfSk7XG4gIH1cblxuICAvKipcbiAgICogQmluZCBldmVudCBsaXN0ZW5lcnNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9iaW5kRXZlbnRzKCkge1xuICAgIC8vIFRyaWdnZXIgY2xpY2tcbiAgICBpZiAodGhpcy5fdHJpZ2dlcikge1xuICAgICAgdGhpcy5vbignY2xpY2snLCB0aGlzLl9oYW5kbGVUcmlnZ2VyQ2xpY2ssIHRoaXMuX3RyaWdnZXIpO1xuICAgIH1cblxuICAgIC8vIEl0ZW0gc2VsZWN0aW9uIC0gYmluZCBkaXJlY3RseSB0byBtZW51L2l0ZW1zIGNvbnRhaW5lciB0byBoYW5kbGUgYmVmb3JlIHN0b3BQcm9wYWdhdGlvblxuICAgIGNvbnN0IGl0ZW1TZWxlY3RvciA9IHRoaXMuX2dldEl0ZW1TZWxlY3RvcigpO1xuICAgIGNvbnN0IGl0ZW1zQ29udGFpbmVyID0gdGhpcy5faXRlbXNMaXN0IHx8IHRoaXMuX21lbnU7XG4gICAgaWYgKGl0ZW1TZWxlY3RvciAmJiBpdGVtc0NvbnRhaW5lcikge1xuICAgICAgLy8gVXNlIGRpcmVjdCBldmVudCBsaXN0ZW5lciBvbiB0aGUgaXRlbXMgY29udGFpbmVyXG4gICAgICB0aGlzLl9pdGVtQ2xpY2tIYW5kbGVyID0gKGUpID0+IHtcbiAgICAgICAgY29uc3QgaXRlbSA9IGUudGFyZ2V0LmNsb3Nlc3QoaXRlbVNlbGVjdG9yKTtcbiAgICAgICAgaWYgKGl0ZW0gJiYgaXRlbXNDb250YWluZXIuY29udGFpbnMoaXRlbSkpIHtcbiAgICAgICAgICB0aGlzLl9oYW5kbGVJdGVtQ2xpY2soZSwgaXRlbSk7XG4gICAgICAgIH1cbiAgICAgIH07XG4gICAgICB0aGlzLl9pdGVtc0NvbnRhaW5lciA9IGl0ZW1zQ29udGFpbmVyO1xuICAgICAgaXRlbXNDb250YWluZXIuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCB0aGlzLl9pdGVtQ2xpY2tIYW5kbGVyKTtcbiAgICB9XG5cbiAgICAvLyBTZWFyY2ggaW5wdXRcbiAgICBpZiAodGhpcy5fc2VhcmNoSW5wdXQpIHtcbiAgICAgIHRoaXMub24oJ2lucHV0JywgdGhpcy5faGFuZGxlU2VhcmNoLCB0aGlzLl9zZWFyY2hJbnB1dCk7XG4gICAgICB0aGlzLm9uKCdjbGljaycsIChlKSA9PiBlLnN0b3BQcm9wYWdhdGlvbigpLCB0aGlzLl9zZWFyY2hJbnB1dCk7XG4gICAgfVxuXG4gICAgLy8gUHJldmVudCBtZW51IGZyb20gY2xvc2luZyB3aGVuIGNsaWNraW5nIGluc2lkZSAoYmFzZWQgb24gYXV0b0Nsb3NlKVxuICAgIGlmICh0aGlzLl9tZW51KSB7XG4gICAgICB0aGlzLm9uKCdjbGljaycsIChlKSA9PiB7XG4gICAgICAgIC8vIE9ubHkgc3RvcCBwcm9wYWdhdGlvbiBpZiBhdXRvQ2xvc2UgaXMgbm90ICdvdXRzaWRlJ1xuICAgICAgICBpZiAodGhpcy5vcHRpb25zLmF1dG9DbG9zZSAhPT0gJ291dHNpZGUnKSB7XG4gICAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgfVxuICAgICAgfSwgdGhpcy5fbWVudSk7XG4gICAgfVxuXG4gICAgLy8gQ2xvc2Ugb24gb3V0c2lkZSBjbGlja1xuICAgIGlmICh0aGlzLm9wdGlvbnMuY2xvc2VPbk91dHNpZGVDbGljaykge1xuICAgICAgdGhpcy5vbignY2xpY2snLCB0aGlzLl9oYW5kbGVPdXRzaWRlQ2xpY2ssIGRvY3VtZW50KTtcbiAgICB9XG5cbiAgICAvLyBLZXlib2FyZCBuYXZpZ2F0aW9uXG4gICAgdGhpcy5vbigna2V5ZG93bicsIHRoaXMuX2hhbmRsZUtleWRvd24sIHRoaXMuZWxlbWVudCk7XG4gIH1cblxuICAvKipcbiAgICogR2V0IGl0ZW0gc2VsZWN0b3IgYmFzZWQgb24gdHlwZVxuICAgKiBAcmV0dXJucyB7c3RyaW5nfSBDU1Mgc2VsZWN0b3JcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9nZXRJdGVtU2VsZWN0b3IoKSB7XG4gICAgc3dpdGNoICh0aGlzLl90eXBlKSB7XG4gICAgICBjYXNlICdzZWFyY2hhYmxlJzogcmV0dXJuICcuc28tc2VhcmNoYWJsZS1pdGVtJztcbiAgICAgIGNhc2UgJ29wdGlvbnMnOiByZXR1cm4gJy5zby1vcHRpb25zLWl0ZW0nO1xuICAgICAgY2FzZSAnb3V0bGV0JzogcmV0dXJuICcuc28tb3V0bGV0LWRyb3Bkb3duLWl0ZW0nO1xuICAgICAgZGVmYXVsdDogcmV0dXJuICcuc28tZHJvcGRvd24taXRlbSc7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIEhhbmRsZSB0cmlnZ2VyIGNsaWNrXG4gICAqIEBwYXJhbSB7RXZlbnR9IGUgLSBDbGljayBldmVudFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2hhbmRsZVRyaWdnZXJDbGljayhlKSB7XG4gICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG5cbiAgICBpZiAodGhpcy5fZGlzYWJsZWQpIHJldHVybjtcblxuICAgIC8vIENsb3NlIG90aGVyIGRyb3Bkb3duc1xuICAgIHRoaXMuX2Nsb3NlT3RoZXJEcm9wZG93bnMoKTtcblxuICAgIC8vIENhbGN1bGF0ZSBwb3NpdGlvbiBmb3Igb3B0aW9ucyBkcm9wZG93blxuICAgIGlmICh0aGlzLl90eXBlID09PSAnb3B0aW9ucycgJiYgIXRoaXMuX2lzT3Blbikge1xuICAgICAgdGhpcy5fcG9zaXRpb25NZW51KCk7XG4gICAgfVxuXG4gICAgdGhpcy50b2dnbGUoKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUgaXRlbSBjbGlja1xuICAgKiBAcGFyYW0ge0V2ZW50fSBlIC0gQ2xpY2sgZXZlbnRcbiAgICogQHBhcmFtIHtFbGVtZW50fSBpdGVtIC0gQ2xpY2tlZCBpdGVtXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlSXRlbUNsaWNrKGUsIGl0ZW0pIHtcbiAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuXG4gICAgLy8gQ2hlY2sgaWYgaXRlbSBpcyBkaXNhYmxlZFxuICAgIGlmIChpdGVtLmNsYXNzTGlzdC5jb250YWlucygnc28tZGlzYWJsZWQnKSB8fCBpdGVtLmhhc0F0dHJpYnV0ZSgnZGlzYWJsZWQnKSB8fCBpdGVtLmdldEF0dHJpYnV0ZSgnYXJpYS1kaXNhYmxlZCcpID09PSAndHJ1ZScpIHtcbiAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICAvLyBPcHRpb25zIGRyb3Bkb3duIGVtaXRzIGFjdGlvbiBldmVudFxuICAgIGlmICh0aGlzLl90eXBlID09PSAnb3B0aW9ucycpIHtcbiAgICAgIGNvbnN0IGFjdGlvbiA9IGl0ZW0uZGF0YXNldC5hY3Rpb247XG4gICAgICB0aGlzLmVtaXQoU09Ecm9wZG93bi5FVkVOVFMuQUNUSU9OLCB7IGFjdGlvbiwgZWxlbWVudDogaXRlbSB9KTtcblxuICAgICAgLy8gQ2hlY2sgYXV0b0Nsb3NlIGZvciBvcHRpb25zXG4gICAgICBpZiAodGhpcy5fc2hvdWxkQ2xvc2VPbkl0ZW1DbGljaygpKSB7XG4gICAgICAgIHRoaXMuY2xvc2UoKTtcbiAgICAgIH1cbiAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICAvLyBPdGhlciBkcm9wZG93bnMgaGFuZGxlIHNlbGVjdGlvblxuICAgIGNvbnN0IHRleHQgPSB0aGlzLl90eXBlID09PSAnb3V0bGV0J1xuICAgICAgPyBpdGVtLnF1ZXJ5U2VsZWN0b3IoJy5vdXRsZXQtaXRlbS10ZXh0Jyk/LnRleHRDb250ZW50LnRyaW0oKSB8fCB0aGlzLl9nZXRJdGVtVGV4dChpdGVtKVxuICAgICAgOiB0aGlzLl9nZXRJdGVtVGV4dChpdGVtKTtcbiAgICAvLyBVc2UgZGF0YS12YWx1ZSBpZiBwcmVzZW50LCBvdGhlcndpc2UgZmFsbCBiYWNrIHRvIHRleHQgY29udGVudFxuICAgIGNvbnN0IHZhbHVlID0gaXRlbS5kYXRhc2V0LnZhbHVlICE9PSB1bmRlZmluZWQgPyBpdGVtLmRhdGFzZXQudmFsdWUgOiB0ZXh0O1xuXG4gICAgLy8gSGFuZGxlIG11bHRpcGxlIHNlbGVjdGlvblxuICAgIGlmICh0aGlzLm9wdGlvbnMubXVsdGlwbGUpIHtcbiAgICAgIHRoaXMudG9nZ2xlU2VsZWN0KHZhbHVlLCB0ZXh0LCBpdGVtKTtcbiAgICB9IGVsc2Uge1xuICAgICAgdGhpcy5zZWxlY3QodmFsdWUsIHRleHQsIGl0ZW0pO1xuICAgIH1cblxuICAgIC8vIEZvciBtdWx0aXBsZSBzZWxlY3Rpb24sIGRvbid0IGNsb3NlIG9uIGl0ZW0gY2xpY2sgYnkgZGVmYXVsdFxuICAgIGlmICghdGhpcy5vcHRpb25zLm11bHRpcGxlICYmIHRoaXMuX3Nob3VsZENsb3NlT25JdGVtQ2xpY2soKSkge1xuICAgICAgdGhpcy5jbG9zZSgpO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBDaGVjayBpZiBkcm9wZG93biBzaG91bGQgY2xvc2Ugb24gaXRlbSBjbGljayBiYXNlZCBvbiBhdXRvQ2xvc2VcbiAgICogQHJldHVybnMge2Jvb2xlYW59XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfc2hvdWxkQ2xvc2VPbkl0ZW1DbGljaygpIHtcbiAgICBjb25zdCBhdXRvQ2xvc2UgPSB0aGlzLm9wdGlvbnMuYXV0b0Nsb3NlO1xuICAgIHJldHVybiB0aGlzLm9wdGlvbnMuY2xvc2VPblNlbGVjdCAmJiAoYXV0b0Nsb3NlID09PSB0cnVlIHx8IGF1dG9DbG9zZSA9PT0gJ2luc2lkZScpO1xuICB9XG5cbiAgLyoqXG4gICAqIEhhbmRsZSBzZWFyY2ggaW5wdXRcbiAgICogQHBhcmFtIHtFdmVudH0gZSAtIElucHV0IGV2ZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlU2VhcmNoKGUpIHtcbiAgICBjb25zdCBxdWVyeSA9IGUudGFyZ2V0LnZhbHVlLnRvTG93ZXJDYXNlKCkudHJpbSgpO1xuICAgIHRoaXMuX2ZpbHRlckl0ZW1zKHF1ZXJ5KTtcblxuICAgIHRoaXMuZW1pdChTT0Ryb3Bkb3duLkVWRU5UUy5TRUFSQ0gsIHsgcXVlcnkgfSk7XG4gIH1cblxuICAvKipcbiAgICogRmlsdGVyIGl0ZW1zIGJ5IHNlYXJjaCBxdWVyeVxuICAgKiBAcGFyYW0ge3N0cmluZ30gcXVlcnkgLSBTZWFyY2ggcXVlcnlcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9maWx0ZXJJdGVtcyhxdWVyeSkge1xuICAgIHRoaXMuX29yaWdpbmFsSXRlbXMuZm9yRWFjaChpdGVtID0+IHtcbiAgICAgIGNvbnN0IHRleHQgPSB0aGlzLl9nZXRJdGVtVGV4dChpdGVtKS50b0xvd2VyQ2FzZSgpO1xuICAgICAgY29uc3QgbWF0Y2hlcyA9ICFxdWVyeSB8fCB0ZXh0LmluY2x1ZGVzKHF1ZXJ5KTtcbiAgICAgIGl0ZW0uc3R5bGUuZGlzcGxheSA9IG1hdGNoZXMgPyAnJyA6ICdub25lJztcbiAgICB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgY2xlYW4gdGV4dCBmcm9tIGFuIGl0ZW0sIGV4Y2x1ZGluZyBjaGVjayBpY29ucyBhbmQgY2hlY2tib3ggZWxlbWVudHNcbiAgICogQHBhcmFtIHtFbGVtZW50fSBpdGVtIC0gSXRlbSBlbGVtZW50XG4gICAqIEByZXR1cm5zIHtzdHJpbmd9IENsZWFuIHRleHQgY29udGVudFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2dldEl0ZW1UZXh0KGl0ZW0pIHtcbiAgICAvLyBDbG9uZSB0aGUgaXRlbSB0byBhdm9pZCBtb2RpZnlpbmcgdGhlIG9yaWdpbmFsXG4gICAgY29uc3QgY2xvbmUgPSBpdGVtLmNsb25lTm9kZSh0cnVlKTtcblxuICAgIC8vIFJlbW92ZSBjaGVjayBpY29uc1xuICAgIGNsb25lLnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1kcm9wZG93bi1jaGVjaywgLmNoZWNrLWljb24sIC5zby1jaGVja2JveC1ib3gnKS5mb3JFYWNoKGVsID0+IGVsLnJlbW92ZSgpKTtcblxuICAgIC8vIFJldHVybiB0cmltbWVkIHRleHRcbiAgICByZXR1cm4gY2xvbmUudGV4dENvbnRlbnQudHJpbSgpO1xuICB9XG5cbiAgLyoqXG4gICAqIEhhbmRsZSBvdXRzaWRlIGNsaWNrIGJhc2VkIG9uIGF1dG9DbG9zZSBvcHRpb25cbiAgICogQHBhcmFtIHtFdmVudH0gZSAtIENsaWNrIGV2ZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlT3V0c2lkZUNsaWNrKGUpIHtcbiAgICBpZiAoIXRoaXMuX2lzT3BlbikgcmV0dXJuO1xuXG4gICAgLy8gU2tpcCBpZiBmbGFnIGlzIHNldCAoZm9yIHByb2dyYW1tYXRpYyBvcGVuIHRoYXQgdHJpZ2dlcnMgZHVyaW5nIGNsaWNrIGV2ZW50KVxuICAgIGlmICh0aGlzLl9pZ25vcmVPdXRzaWRlQ2xpY2spIHJldHVybjtcblxuICAgIC8vIERvbid0IGNsb3NlIGlmIGNsaWNraW5nIGluc2lkZSB0aGlzIGRyb3Bkb3duXG4gICAgaWYgKHRoaXMuZWxlbWVudC5jb250YWlucyhlLnRhcmdldCkpIHJldHVybjtcblxuICAgIC8vIERvbid0IGNsb3NlIGlmIGNsaWNraW5nIG9uIGFueSBkcm9wZG93biB0cmlnZ2VyIG9yIGRyb3Bkb3duIGVsZW1lbnQgKGxldCB0aGF0IGNvbXBvbmVudCBoYW5kbGUgaXQpXG4gICAgY29uc3QgZHJvcGRvd25UcmlnZ2VyID0gZS50YXJnZXQuY2xvc2VzdCgnLnNvLWRyb3Bkb3duLXRyaWdnZXIsIC5zby1zZWFyY2hhYmxlLXRyaWdnZXIsIC5zby1vcHRpb25zLXRyaWdnZXIsIC5zby1vdXRsZXQtZHJvcGRvd24tdHJpZ2dlciwgLnNvLWJ0bltkYXRhLXNvLXRvZ2dsZT1cImRyb3Bkb3duXCJdJyk7XG4gICAgY29uc3QgZHJvcGRvd25FbGVtZW50ID0gZS50YXJnZXQuY2xvc2VzdCgnLnNvLWRyb3Bkb3duLCAuc28tc2VhcmNoYWJsZS1kcm9wZG93biwgLnNvLW9wdGlvbnMtZHJvcGRvd24sIC5zby1vdXRsZXQtZHJvcGRvd24nKTtcbiAgICBpZiAoZHJvcGRvd25UcmlnZ2VyIHx8IGRyb3Bkb3duRWxlbWVudCkgcmV0dXJuO1xuXG4gICAgLy8gRG9uJ3QgY2xvc2UgaWYgY2xpY2tpbmcgb24gbmF2YmFyIGRyb3Bkb3duIGJ1dHRvbnMgb3IgdGhlaXIgZHJvcGRvd25zIChsZXQgbmF2YmFyIGhhbmRsZSBpdClcbiAgICBjb25zdCBuYXZiYXJEcm9wZG93bkJ0biA9IGUudGFyZ2V0LmNsb3Nlc3QoJy5zby1uYXZiYXItdXNlci1idG4sIC5zby1uYXZiYXItYXBwcy1idG4sIC5zby1uYXZiYXItb3V0bGV0LWJ0biwgLnNvLW5hdmJhci1zdGF0dXMtYnRuLCAuc28tbmF2YmFyLXRoZW1lLWJ0bicpO1xuICAgIGNvbnN0IG5hdmJhckRyb3Bkb3duID0gZS50YXJnZXQuY2xvc2VzdCgnLnNvLW5hdmJhci11c2VyLWRyb3Bkb3duLCAuc28tbmF2YmFyLWFwcHMsIC5zby1uYXZiYXItb3V0bGV0LWRyb3Bkb3duLCAuc28tbmF2YmFyLXN0YXR1cy1kcm9wZG93biwgLnNvLW5hdmJhci10aGVtZS1kcm9wZG93bicpO1xuICAgIGlmIChuYXZiYXJEcm9wZG93bkJ0biB8fCBuYXZiYXJEcm9wZG93bikgcmV0dXJuO1xuXG4gICAgY29uc3QgYXV0b0Nsb3NlID0gdGhpcy5vcHRpb25zLmF1dG9DbG9zZTtcblxuICAgIC8vIGF1dG9DbG9zZTogZmFsc2UgLSBuZXZlciBjbG9zZSBvbiBvdXRzaWRlIGNsaWNrXG4gICAgaWYgKGF1dG9DbG9zZSA9PT0gZmFsc2UpIHJldHVybjtcblxuICAgIC8vIGF1dG9DbG9zZTogJ2luc2lkZScgLSBvbmx5IGNsb3NlIHdoZW4gY2xpY2tpbmcgaW5zaWRlXG4gICAgaWYgKGF1dG9DbG9zZSA9PT0gJ2luc2lkZScpIHJldHVybjtcblxuICAgIC8vIGF1dG9DbG9zZTogdHJ1ZSBvciAnb3V0c2lkZScgLSBjbG9zZSBvbiBvdXRzaWRlIGNsaWNrXG4gICAgdGhpcy5jbG9zZSgpO1xuICB9XG5cbiAgLyoqXG4gICAqIEhhbmRsZSBrZXlib2FyZCBuYXZpZ2F0aW9uXG4gICAqIEBwYXJhbSB7S2V5Ym9hcmRFdmVudH0gZSAtIEtleWJvYXJkIGV2ZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlS2V5ZG93bihlKSB7XG4gICAgLy8gRXNjYXBlIHRvIGNsb3NlXG4gICAgaWYgKGUua2V5ID09PSAnRXNjYXBlJyAmJiB0aGlzLl9pc09wZW4pIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgIHRoaXMuY2xvc2UoKTtcbiAgICAgIHRoaXMuX3RyaWdnZXI/LmZvY3VzKCk7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgLy8gQXJyb3dEb3duIHRvIG9wZW4gd2hlbiBjbG9zZWRcbiAgICBpZiAoZS5rZXkgPT09ICdBcnJvd0Rvd24nICYmICF0aGlzLl9pc09wZW4pIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgIHRoaXMub3BlbigpO1xuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIC8vIE5hdmlnYXRlIGl0ZW1zIHdoZW4gb3BlblxuICAgIGlmICh0aGlzLl9pc09wZW4pIHtcbiAgICAgIGNvbnN0IGl0ZW1zID0gdGhpcy5fZ2V0TmF2aWdhYmxlSXRlbXMoKTtcblxuICAgICAgaWYgKGUua2V5ID09PSAnQXJyb3dEb3duJykge1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHRoaXMuX2ZvY3VzTmV4dEl0ZW0oaXRlbXMsIDEpO1xuICAgICAgfSBlbHNlIGlmIChlLmtleSA9PT0gJ0Fycm93VXAnKSB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdGhpcy5fZm9jdXNOZXh0SXRlbShpdGVtcywgLTEpO1xuICAgICAgfSBlbHNlIGlmIChlLmtleSA9PT0gJ0VudGVyJyB8fCBlLmtleSA9PT0gJyAnKSB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgaWYgKHRoaXMuX2ZvY3VzZWRJbmRleCA+PSAwICYmIGl0ZW1zW3RoaXMuX2ZvY3VzZWRJbmRleF0pIHtcbiAgICAgICAgICBpdGVtc1t0aGlzLl9mb2N1c2VkSW5kZXhdLmNsaWNrKCk7XG4gICAgICAgIH1cbiAgICAgIH0gZWxzZSBpZiAoZS5rZXkgPT09ICdIb21lJykge1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHRoaXMuX2ZvY3VzSXRlbShpdGVtcywgMCk7XG4gICAgICB9IGVsc2UgaWYgKGUua2V5ID09PSAnRW5kJykge1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHRoaXMuX2ZvY3VzSXRlbShpdGVtcywgaXRlbXMubGVuZ3RoIC0gMSk7XG4gICAgICB9XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIEdldCBhbGwgbmF2aWdhYmxlIChub24tZGlzYWJsZWQpIGl0ZW1zXG4gICAqIEByZXR1cm5zIHtFbGVtZW50W119IEFycmF5IG9mIG5hdmlnYWJsZSBpdGVtc1xuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2dldE5hdmlnYWJsZUl0ZW1zKCkge1xuICAgIGNvbnN0IHNlbGVjdG9yID0gdGhpcy5fZ2V0SXRlbVNlbGVjdG9yKCk7XG4gICAgcmV0dXJuIHRoaXMuJCQoc2VsZWN0b3IpLmZpbHRlcihpdGVtID0+XG4gICAgICAhaXRlbS5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWRpc2FibGVkJykgJiZcbiAgICAgICFpdGVtLmhhc0F0dHJpYnV0ZSgnZGlzYWJsZWQnKSAmJlxuICAgICAgaXRlbS5nZXRBdHRyaWJ1dGUoJ2FyaWEtZGlzYWJsZWQnKSAhPT0gJ3RydWUnICYmXG4gICAgICAhaXRlbS5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWRyb3Bkb3duLWhlYWRlcicpICYmXG4gICAgICAhaXRlbS5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWRyb3Bkb3duLWRpdmlkZXInKSAmJlxuICAgICAgaXRlbS5zdHlsZS5kaXNwbGF5ICE9PSAnbm9uZSdcbiAgICApO1xuICB9XG5cbiAgLyoqXG4gICAqIEZvY3VzIG5leHQvcHJldmlvdXMgaXRlbSBpbiB0aGUgbGlzdFxuICAgKiBAcGFyYW0ge0VsZW1lbnRbXX0gaXRlbXMgLSBOYXZpZ2FibGUgaXRlbXNcbiAgICogQHBhcmFtIHtudW1iZXJ9IGRpcmVjdGlvbiAtIDEgZm9yIG5leHQsIC0xIGZvciBwcmV2aW91c1xuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2ZvY3VzTmV4dEl0ZW0oaXRlbXMsIGRpcmVjdGlvbikge1xuICAgIGlmIChpdGVtcy5sZW5ndGggPT09IDApIHJldHVybjtcblxuICAgIGxldCBuZXdJbmRleCA9IHRoaXMuX2ZvY3VzZWRJbmRleCArIGRpcmVjdGlvbjtcblxuICAgIC8vIFdyYXAgYXJvdW5kXG4gICAgaWYgKG5ld0luZGV4IDwgMCkgbmV3SW5kZXggPSBpdGVtcy5sZW5ndGggLSAxO1xuICAgIGlmIChuZXdJbmRleCA+PSBpdGVtcy5sZW5ndGgpIG5ld0luZGV4ID0gMDtcblxuICAgIHRoaXMuX2ZvY3VzSXRlbShpdGVtcywgbmV3SW5kZXgpO1xuICB9XG5cbiAgLyoqXG4gICAqIEZvY3VzIGEgc3BlY2lmaWMgaXRlbSBieSBpbmRleFxuICAgKiBAcGFyYW0ge0VsZW1lbnRbXX0gaXRlbXMgLSBOYXZpZ2FibGUgaXRlbXNcbiAgICogQHBhcmFtIHtudW1iZXJ9IGluZGV4IC0gSXRlbSBpbmRleFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2ZvY3VzSXRlbShpdGVtcywgaW5kZXgpIHtcbiAgICAvLyBSZW1vdmUgZm9jdXMgZnJvbSBhbGwgaXRlbXNcbiAgICBjb25zdCBhbGxJdGVtcyA9IHRoaXMuJCQodGhpcy5fZ2V0SXRlbVNlbGVjdG9yKCkpO1xuICAgIGFsbEl0ZW1zLmZvckVhY2goaXRlbSA9PiBpdGVtLmNsYXNzTGlzdC5yZW1vdmUoJ3NvLWZvY3VzZWQnKSk7XG5cbiAgICAvLyBTZXQgbmV3IGZvY3VzXG4gICAgdGhpcy5fZm9jdXNlZEluZGV4ID0gaW5kZXg7XG4gICAgaWYgKGl0ZW1zW2luZGV4XSkge1xuICAgICAgaXRlbXNbaW5kZXhdLmNsYXNzTGlzdC5hZGQoJ3NvLWZvY3VzZWQnKTtcbiAgICAgIGl0ZW1zW2luZGV4XS5zY3JvbGxJbnRvVmlldyh7IGJsb2NrOiAnbmVhcmVzdCcgfSk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIENsZWFyIGZvY3VzZWQgaXRlbSBzdGF0ZVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2NsZWFyRm9jdXNlZEl0ZW0oKSB7XG4gICAgY29uc3QgaXRlbXMgPSB0aGlzLiQkKHRoaXMuX2dldEl0ZW1TZWxlY3RvcigpKTtcbiAgICBpdGVtcy5mb3JFYWNoKGl0ZW0gPT4gaXRlbS5jbGFzc0xpc3QucmVtb3ZlKCdzby1mb2N1c2VkJykpO1xuICAgIHRoaXMuX2ZvY3VzZWRJbmRleCA9IC0xO1xuICB9XG5cbiAgLyoqXG4gICAqIENsb3NlIG90aGVyIG9wZW4gZHJvcGRvd25zXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfY2xvc2VPdGhlckRyb3Bkb3ducygpIHtcbiAgICAvLyBDbG9zZSBvdGhlciBTT0Ryb3Bkb3duIGluc3RhbmNlcyBwcm9wZXJseSB2aWEgdGhlaXIgY2xvc2UoKSBtZXRob2RcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tZHJvcGRvd24uc28tb3BlbiwgLnNvLXNlYXJjaGFibGUtZHJvcGRvd24uc28tb3BlbiwgLnNvLW9wdGlvbnMtZHJvcGRvd24uc28tb3BlbiwgLnNvLW91dGxldC1kcm9wZG93bi5zby1vcGVuJykuZm9yRWFjaChkcm9wZG93biA9PiB7XG4gICAgICBpZiAoZHJvcGRvd24gIT09IHRoaXMuZWxlbWVudCkge1xuICAgICAgICAvLyBUcnkgdG8gZ2V0IHRoZSBpbnN0YW5jZSBhbmQgY2xvc2UgaXQgcHJvcGVybHlcbiAgICAgICAgY29uc3QgaW5zdGFuY2UgPSBTT0Ryb3Bkb3duLmdldEluc3RhbmNlKGRyb3Bkb3duKTtcbiAgICAgICAgaWYgKGluc3RhbmNlICYmIGluc3RhbmNlLl9pc09wZW4pIHtcbiAgICAgICAgICBpbnN0YW5jZS5faXNPcGVuID0gZmFsc2U7XG4gICAgICAgICAgaW5zdGFuY2UucmVtb3ZlQ2xhc3MoJ3NvLW9wZW4nLCAncG9zaXRpb24tbGVmdCcsICdwb3NpdGlvbi10b3AnKTtcbiAgICAgICAgICBpbnN0YW5jZS5fcmVtb3ZlRGlyZWN0aW9uQ2xhc3NlcygpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgIC8vIEZhbGxiYWNrOiBqdXN0IHJlbW92ZSBjbGFzc2VzIGlmIG5vIGluc3RhbmNlIGZvdW5kXG4gICAgICAgICAgZHJvcGRvd24uY2xhc3NMaXN0LnJlbW92ZSgnc28tb3BlbicsICdwb3NpdGlvbi1sZWZ0JywgJ3Bvc2l0aW9uLXRvcCcpO1xuICAgICAgICAgIGRyb3Bkb3duLmNsYXNzTGlzdC5yZW1vdmUoJ3NvLWRyb3B1cCcsICdzby1kcm9wc3RhcnQnLCAnc28tZHJvcGVuZCcsICdzby1kcm9wZG93bi1tZW51LWVuZCcpO1xuICAgICAgICB9XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICAvLyBEaXNwYXRjaCBldmVudCB0byBjbG9zZSBuYXZiYXIgY3VzdG9tIGRyb3Bkb3ducyAoZGlmZmVyZW50IGV2ZW50IHRvIGF2b2lkIGxvb3BzKVxuICAgIGRvY3VtZW50LmRpc3BhdGNoRXZlbnQobmV3IEN1c3RvbUV2ZW50KCdjbG9zZU5hdmJhckRyb3Bkb3ducycpKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBBcHBseSBkaXJlY3Rpb24gYW5kIGFsaWdubWVudCBjbGFzc2VzXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfYXBwbHlEaXJlY3Rpb25DbGFzc2VzKCkge1xuICAgIGNvbnN0IGRpcmVjdGlvbiA9IHRoaXMub3B0aW9ucy5kaXJlY3Rpb247XG4gICAgY29uc3QgYWxpZ25tZW50ID0gdGhpcy5vcHRpb25zLmFsaWdubWVudDtcblxuICAgIC8vIERpcmVjdGlvbiBjbGFzc2VzIChvbmx5IGFkZCBpZiBub3QgYWxyZWFkeSBwcmVzZW50IHZpYSBIVE1MKVxuICAgIGlmIChkaXJlY3Rpb24gPT09ICd1cCcgJiYgIXRoaXMuX29yaWdpbmFsQ2xhc3Nlcy5kcm9wdXApIHRoaXMuYWRkQ2xhc3MoJ3NvLWRyb3B1cCcpO1xuICAgIGlmIChkaXJlY3Rpb24gPT09ICdzdGFydCcgJiYgIXRoaXMuX29yaWdpbmFsQ2xhc3Nlcy5kcm9wc3RhcnQpIHRoaXMuYWRkQ2xhc3MoJ3NvLWRyb3BzdGFydCcpO1xuICAgIGlmIChkaXJlY3Rpb24gPT09ICdlbmQnICYmICF0aGlzLl9vcmlnaW5hbENsYXNzZXMuZHJvcGVuZCkgdGhpcy5hZGRDbGFzcygnc28tZHJvcGVuZCcpO1xuXG4gICAgLy8gQWxpZ25tZW50IGNsYXNzIChvbmx5IGFkZCBpZiBub3QgYWxyZWFkeSBwcmVzZW50IHZpYSBIVE1MKVxuICAgIGlmIChhbGlnbm1lbnQgPT09ICdlbmQnICYmICF0aGlzLl9vcmlnaW5hbENsYXNzZXMubWVudUVuZCkgdGhpcy5hZGRDbGFzcygnc28tZHJvcGRvd24tbWVudS1lbmQnKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBSZW1vdmUgZGlyZWN0aW9uIGFuZCBhbGlnbm1lbnQgY2xhc3NlcyAob25seSB0aG9zZSBhZGRlZCBkeW5hbWljYWxseSwgbm90IHZpYSBIVE1MKVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3JlbW92ZURpcmVjdGlvbkNsYXNzZXMoKSB7XG4gICAgLy8gT25seSByZW1vdmUgY2xhc3NlcyB0aGF0IHdlcmVuJ3Qgb3JpZ2luYWxseSBzZXQgdmlhIEhUTUxcbiAgICBpZiAoIXRoaXMuX29yaWdpbmFsQ2xhc3Nlcy5kcm9wdXApIHRoaXMucmVtb3ZlQ2xhc3MoJ3NvLWRyb3B1cCcpO1xuICAgIGlmICghdGhpcy5fb3JpZ2luYWxDbGFzc2VzLmRyb3BzdGFydCkgdGhpcy5yZW1vdmVDbGFzcygnc28tZHJvcHN0YXJ0Jyk7XG4gICAgaWYgKCF0aGlzLl9vcmlnaW5hbENsYXNzZXMuZHJvcGVuZCkgdGhpcy5yZW1vdmVDbGFzcygnc28tZHJvcGVuZCcpO1xuICAgIGlmICghdGhpcy5fb3JpZ2luYWxDbGFzc2VzLm1lbnVFbmQpIHRoaXMucmVtb3ZlQ2xhc3MoJ3NvLWRyb3Bkb3duLW1lbnUtZW5kJyk7XG4gIH1cblxuICAvKipcbiAgICogUG9zaXRpb24gb3B0aW9ucyBkcm9wZG93biBtZW51XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfcG9zaXRpb25NZW51KCkge1xuICAgIGlmICh0aGlzLl90eXBlICE9PSAnb3B0aW9ucycpIHJldHVybjtcblxuICAgIC8vIFJlc2V0IHBvc2l0aW9uIGNsYXNzZXNcbiAgICB0aGlzLnJlbW92ZUNsYXNzKCdwb3NpdGlvbi1sZWZ0JywgJ3Bvc2l0aW9uLXRvcCcpO1xuXG4gICAgY29uc3QgdHJpZ2dlclJlY3QgPSB0aGlzLl90cmlnZ2VyLmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xuICAgIGNvbnN0IG1lbnVXaWR0aCA9IHRoaXMuX21lbnUub2Zmc2V0V2lkdGggfHwgMTgwO1xuICAgIGNvbnN0IG1lbnVIZWlnaHQgPSB0aGlzLl9tZW51Lm9mZnNldEhlaWdodCB8fCAxNTA7XG5cbiAgICBjb25zdCB2aWV3cG9ydFdpZHRoID0gd2luZG93LmlubmVyV2lkdGg7XG4gICAgY29uc3Qgdmlld3BvcnRIZWlnaHQgPSB3aW5kb3cuaW5uZXJIZWlnaHQ7XG5cbiAgICBjb25zdCBzcGFjZVJpZ2h0ID0gdmlld3BvcnRXaWR0aCAtIHRyaWdnZXJSZWN0LnJpZ2h0O1xuICAgIGNvbnN0IHNwYWNlQm90dG9tID0gdmlld3BvcnRIZWlnaHQgLSB0cmlnZ2VyUmVjdC5ib3R0b207XG4gICAgY29uc3Qgc3BhY2VUb3AgPSB0cmlnZ2VyUmVjdC50b3A7XG5cbiAgICAvLyBIb3Jpem9udGFsIHBvc2l0aW9uXG4gICAgaWYgKHNwYWNlUmlnaHQgPj0gbWVudVdpZHRoKSB7XG4gICAgICB0aGlzLmFkZENsYXNzKCdwb3NpdGlvbi1sZWZ0Jyk7XG4gICAgfVxuXG4gICAgLy8gVmVydGljYWwgcG9zaXRpb25cbiAgICBpZiAoc3BhY2VCb3R0b20gPCBtZW51SGVpZ2h0ICsgMTAgJiYgc3BhY2VUb3AgPiBtZW51SGVpZ2h0ICsgMTApIHtcbiAgICAgIHRoaXMuYWRkQ2xhc3MoJ3Bvc2l0aW9uLXRvcCcpO1xuICAgIH1cbiAgfVxuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIFBVQkxJQyBBUElcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogT3BlbiB0aGUgZHJvcGRvd25cbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgb3BlbigpIHtcbiAgICBpZiAodGhpcy5faXNPcGVuIHx8IHRoaXMuX2Rpc2FibGVkKSByZXR1cm4gdGhpcztcblxuICAgIC8vIEVtaXQgY2FuY2VsYWJsZSBzaG93IGV2ZW50XG4gICAgY29uc3Qgc2hvd0FsbG93ZWQgPSB0aGlzLmVtaXQoU09Ecm9wZG93bi5FVkVOVFMuU0hPVywge30sIHRydWUsIHRydWUpO1xuICAgIGlmICghc2hvd0FsbG93ZWQpIHJldHVybiB0aGlzO1xuXG4gICAgdGhpcy5faXNPcGVuID0gdHJ1ZTtcbiAgICB0aGlzLmFkZENsYXNzKCdzby1vcGVuJyk7XG4gICAgdGhpcy5fYXBwbHlEaXJlY3Rpb25DbGFzc2VzKCk7XG5cbiAgICAvLyBSZXNldCBrZXlib2FyZCBuYXZpZ2F0aW9uXG4gICAgdGhpcy5fZm9jdXNlZEluZGV4ID0gLTE7XG5cbiAgICAvLyBTZXQgZmxhZyB0byBpZ25vcmUgaW1tZWRpYXRlIG91dHNpZGUgY2xpY2tzIChmb3IgcHJvZ3JhbW1hdGljIG9wZW4pXG4gICAgdGhpcy5faWdub3JlT3V0c2lkZUNsaWNrID0gdHJ1ZTtcbiAgICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgIHRoaXMuX2lnbm9yZU91dHNpZGVDbGljayA9IGZhbHNlO1xuICAgIH0sIDEwKTtcblxuICAgIC8vIEZvY3VzIHNlYXJjaCBpbnB1dCBpZiBwcmVzZW50XG4gICAgaWYgKHRoaXMuX3NlYXJjaElucHV0KSB7XG4gICAgICBzZXRUaW1lb3V0KCgpID0+IHRoaXMuX3NlYXJjaElucHV0LmZvY3VzKCksIDUwKTtcbiAgICB9XG5cbiAgICAvLyBFbWl0IHNob3duIGV2ZW50IGFmdGVyIHRyYW5zaXRpb25cbiAgICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgIHRoaXMuZW1pdChTT0Ryb3Bkb3duLkVWRU5UUy5TSE9XTik7XG4gICAgfSwgMTUwKTtcblxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIENsb3NlIHRoZSBkcm9wZG93blxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBjbG9zZSgpIHtcbiAgICBpZiAoIXRoaXMuX2lzT3BlbikgcmV0dXJuIHRoaXM7XG5cbiAgICAvLyBFbWl0IGNhbmNlbGFibGUgaGlkZSBldmVudFxuICAgIGNvbnN0IGhpZGVBbGxvd2VkID0gdGhpcy5lbWl0KFNPRHJvcGRvd24uRVZFTlRTLkhJREUsIHt9LCB0cnVlLCB0cnVlKTtcbiAgICBpZiAoIWhpZGVBbGxvd2VkKSByZXR1cm4gdGhpcztcblxuICAgIHRoaXMuX2lzT3BlbiA9IGZhbHNlO1xuICAgIHRoaXMucmVtb3ZlQ2xhc3MoJ3NvLW9wZW4nKTtcblxuICAgIC8vIENsZWFyIGZvY3VzZWQgaXRlbVxuICAgIHRoaXMuX2NsZWFyRm9jdXNlZEl0ZW0oKTtcblxuICAgIC8vIENsZWFyIHNlYXJjaFxuICAgIGlmICh0aGlzLl9zZWFyY2hJbnB1dCkge1xuICAgICAgdGhpcy5fc2VhcmNoSW5wdXQudmFsdWUgPSAnJztcbiAgICAgIHRoaXMuX2ZpbHRlckl0ZW1zKCcnKTtcbiAgICB9XG5cbiAgICAvLyBSZW1vdmUgcG9zaXRpb24gY2xhc3NlcyBBRlRFUiB0cmFuc2l0aW9uIGNvbXBsZXRlcyB0byBwcmV2ZW50IGp1bXBcbiAgICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgIHRoaXMucmVtb3ZlQ2xhc3MoJ3Bvc2l0aW9uLWxlZnQnLCAncG9zaXRpb24tdG9wJyk7XG4gICAgICB0aGlzLl9yZW1vdmVEaXJlY3Rpb25DbGFzc2VzKCk7XG4gICAgICB0aGlzLmVtaXQoU09Ecm9wZG93bi5FVkVOVFMuSElEREVOKTtcbiAgICB9LCAxNTApO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogVG9nZ2xlIHRoZSBkcm9wZG93blxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICB0b2dnbGUoKSB7XG4gICAgcmV0dXJuIHRoaXMuX2lzT3BlbiA/IHRoaXMuY2xvc2UoKSA6IHRoaXMub3BlbigpO1xuICB9XG5cbiAgLyoqXG4gICAqIFNlbGVjdCBhbiBvcHRpb24gKHNpbmdsZSBzZWxlY3Rpb24gbW9kZSlcbiAgICogQHBhcmFtIHtzdHJpbmd9IHZhbHVlIC0gT3B0aW9uIHZhbHVlXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBbdGV4dF0gLSBEaXNwbGF5IHRleHRcbiAgICogQHBhcmFtIHtFbGVtZW50fSBbY2xpY2tlZEl0ZW1dIC0gQ2xpY2tlZCBpdGVtIGVsZW1lbnRcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgc2VsZWN0KHZhbHVlLCB0ZXh0LCBjbGlja2VkSXRlbSA9IG51bGwpIHtcbiAgICBjb25zdCBwcmV2aW91c1ZhbHVlcyA9IFsuLi50aGlzLl9zZWxlY3RlZFZhbHVlc107XG5cbiAgICAvLyBDbGVhciBwcmV2aW91cyBhbmQgc2V0IG5ld1xuICAgIHRoaXMuX3NlbGVjdGVkVmFsdWVzID0gW3ZhbHVlXTtcbiAgICB0aGlzLl9zZWxlY3RlZFRleHRzID0gW3RleHRdO1xuXG4gICAgLy8gVXBkYXRlIGRpc3BsYXlcbiAgICBpZiAodGhpcy5fc2VsZWN0ZWRFbCkge1xuICAgICAgdGhpcy5fc2VsZWN0ZWRFbC50ZXh0Q29udGVudCA9IHRleHQ7XG4gICAgfVxuXG4gICAgLy8gVXBkYXRlIHNlbGVjdGVkIHN0YXRlIGluIG1lbnVcbiAgICBjb25zdCBpdGVtU2VsZWN0b3IgPSB0aGlzLl9nZXRJdGVtU2VsZWN0b3IoKTtcbiAgICB0aGlzLiQkKGl0ZW1TZWxlY3RvcikuZm9yRWFjaChpdGVtID0+IHtcbiAgICAgIC8vIElmIHdlIGhhdmUgdGhlIGNsaWNrZWQgaXRlbSwgdXNlIGRpcmVjdCBjb21wYXJpc29uXG4gICAgICAvLyBPdGhlcndpc2UgZmFsbCBiYWNrIHRvIHZhbHVlIGNvbXBhcmlzb24gKGZvciBwcm9ncmFtbWF0aWMgc2VsZWN0aW9uKVxuICAgICAgY29uc3QgaXNTZWxlY3RlZCA9IGNsaWNrZWRJdGVtXG4gICAgICAgID8gaXRlbSA9PT0gY2xpY2tlZEl0ZW1cbiAgICAgICAgOiAoaXRlbS5kYXRhc2V0LnZhbHVlICE9PSB1bmRlZmluZWQgPyBpdGVtLmRhdGFzZXQudmFsdWUgPT09IHZhbHVlIDogdGhpcy5fZ2V0SXRlbVRleHQoaXRlbSkgPT09IHZhbHVlKTtcbiAgICAgIGl0ZW0uY2xhc3NMaXN0LnRvZ2dsZSgnc28tc2VsZWN0ZWQnLCBpc1NlbGVjdGVkKTtcbiAgICAgIGl0ZW0uY2xhc3NMaXN0LnRvZ2dsZSgnc28tYWN0aXZlJywgaXNTZWxlY3RlZCk7XG4gICAgfSk7XG5cbiAgICAvLyBFbWl0IGNoYW5nZSBldmVudFxuICAgIHRoaXMuZW1pdChTT0Ryb3Bkb3duLkVWRU5UUy5DSEFOR0UsIHtcbiAgICAgIHZhbHVlLFxuICAgICAgdGV4dCxcbiAgICAgIHZhbHVlczogdGhpcy5fc2VsZWN0ZWRWYWx1ZXMsXG4gICAgICB0ZXh0czogdGhpcy5fc2VsZWN0ZWRUZXh0cyxcbiAgICAgIHByZXZpb3VzVmFsdWVzLFxuICAgIH0pO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogVG9nZ2xlIHNlbGVjdGlvbiBmb3IgbXVsdGlwbGUgbW9kZVxuICAgKiBAcGFyYW0ge3N0cmluZ30gdmFsdWUgLSBPcHRpb24gdmFsdWVcbiAgICogQHBhcmFtIHtzdHJpbmd9IHRleHQgLSBEaXNwbGF5IHRleHRcbiAgICogQHBhcmFtIHtFbGVtZW50fSBpdGVtIC0gSXRlbSBlbGVtZW50XG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHRvZ2dsZVNlbGVjdCh2YWx1ZSwgdGV4dCwgaXRlbSkge1xuICAgIGNvbnN0IHByZXZpb3VzVmFsdWVzID0gWy4uLnRoaXMuX3NlbGVjdGVkVmFsdWVzXTtcbiAgICBjb25zdCBpbmRleCA9IHRoaXMuX3NlbGVjdGVkVmFsdWVzLmluZGV4T2YodmFsdWUpO1xuXG4gICAgaWYgKGluZGV4ID4gLTEpIHtcbiAgICAgIC8vIENoZWNrIG1pblNlbGVjdGlvbnMgYmVmb3JlIGRlc2VsZWN0aW5nXG4gICAgICBjb25zdCBtaW5TZWxlY3Rpb25zID0gdGhpcy5vcHRpb25zLm1pblNlbGVjdGlvbnMgfHwgMDtcbiAgICAgIGlmICh0aGlzLl9zZWxlY3RlZFZhbHVlcy5sZW5ndGggPD0gbWluU2VsZWN0aW9ucykge1xuICAgICAgICByZXR1cm4gdGhpczsgLy8gRG9uJ3QgYWxsb3cgZGVzZWxlY3RpbmcgYmVsb3cgbWluaW11bVxuICAgICAgfVxuICAgICAgLy8gRGVzZWxlY3RcbiAgICAgIHRoaXMuX3NlbGVjdGVkVmFsdWVzLnNwbGljZShpbmRleCwgMSk7XG4gICAgICB0aGlzLl9zZWxlY3RlZFRleHRzLnNwbGljZShpbmRleCwgMSk7XG4gICAgICBpdGVtLmNsYXNzTGlzdC5yZW1vdmUoJ3NvLXNlbGVjdGVkJywgJ3NvLWFjdGl2ZScpO1xuICAgIH0gZWxzZSB7XG4gICAgICAvLyBDaGVjayBtYXggc2VsZWN0aW9uc1xuICAgICAgaWYgKHRoaXMub3B0aW9ucy5tYXhTZWxlY3Rpb25zICYmIHRoaXMuX3NlbGVjdGVkVmFsdWVzLmxlbmd0aCA+PSB0aGlzLm9wdGlvbnMubWF4U2VsZWN0aW9ucykge1xuICAgICAgICByZXR1cm4gdGhpczsgLy8gRG9uJ3QgYWxsb3cgbW9yZSBzZWxlY3Rpb25zXG4gICAgICB9XG4gICAgICAvLyBTZWxlY3RcbiAgICAgIHRoaXMuX3NlbGVjdGVkVmFsdWVzLnB1c2godmFsdWUpO1xuICAgICAgdGhpcy5fc2VsZWN0ZWRUZXh0cy5wdXNoKHRleHQpO1xuICAgICAgaXRlbS5jbGFzc0xpc3QuYWRkKCdzby1zZWxlY3RlZCcsICdzby1hY3RpdmUnKTtcbiAgICB9XG5cbiAgICAvLyBVcGRhdGUgZGlzcGxheVxuICAgIHRoaXMuX3VwZGF0ZU11bHRpcGxlRGlzcGxheSgpO1xuXG4gICAgLy8gRW1pdCBjaGFuZ2UgZXZlbnRcbiAgICB0aGlzLmVtaXQoU09Ecm9wZG93bi5FVkVOVFMuQ0hBTkdFLCB7XG4gICAgICB2YWx1ZSxcbiAgICAgIHRleHQsXG4gICAgICB2YWx1ZXM6IHRoaXMuX3NlbGVjdGVkVmFsdWVzLFxuICAgICAgdGV4dHM6IHRoaXMuX3NlbGVjdGVkVGV4dHMsXG4gICAgICBwcmV2aW91c1ZhbHVlcyxcbiAgICAgIGFjdGlvbjogaW5kZXggPiAtMSA/ICdkZXNlbGVjdCcgOiAnc2VsZWN0JyxcbiAgICB9KTtcblxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFVwZGF0ZSBkaXNwbGF5IHRleHQgZm9yIG11bHRpcGxlIHNlbGVjdGlvblxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3VwZGF0ZU11bHRpcGxlRGlzcGxheSgpIHtcbiAgICBpZiAoIXRoaXMuX3NlbGVjdGVkRWwpIHJldHVybjtcblxuICAgIGNvbnN0IGNvdW50ID0gdGhpcy5fc2VsZWN0ZWRWYWx1ZXMubGVuZ3RoO1xuICAgIGNvbnN0IHRvdGFsSXRlbXMgPSB0aGlzLl9nZXRUb3RhbFNlbGVjdGFibGVJdGVtcygpO1xuXG4gICAgaWYgKGNvdW50ID09PSAwKSB7XG4gICAgICB0aGlzLl9zZWxlY3RlZEVsLnRleHRDb250ZW50ID0gdGhpcy5vcHRpb25zLnBsYWNlaG9sZGVyO1xuICAgICAgdGhpcy5fc2VsZWN0ZWRFbC5jbGFzc0xpc3QuYWRkKCdzby1wbGFjZWhvbGRlcicpO1xuICAgIH0gZWxzZSBpZiAoY291bnQgPT09IHRvdGFsSXRlbXMgJiYgdGhpcy5vcHRpb25zLmFsbFNlbGVjdGVkVGV4dCkge1xuICAgICAgLy8gQWxsIGl0ZW1zIHNlbGVjdGVkIGFuZCBjdXN0b20gdGV4dCBwcm92aWRlZFxuICAgICAgdGhpcy5fc2VsZWN0ZWRFbC50ZXh0Q29udGVudCA9IHRoaXMub3B0aW9ucy5hbGxTZWxlY3RlZFRleHQ7XG4gICAgICB0aGlzLl9zZWxlY3RlZEVsLmNsYXNzTGlzdC5yZW1vdmUoJ3NvLXBsYWNlaG9sZGVyJyk7XG4gICAgfSBlbHNlIGlmIChjb3VudCA9PT0gMSkge1xuICAgICAgdGhpcy5fc2VsZWN0ZWRFbC50ZXh0Q29udGVudCA9IHRoaXMuX3NlbGVjdGVkVGV4dHNbMF07XG4gICAgICB0aGlzLl9zZWxlY3RlZEVsLmNsYXNzTGlzdC5yZW1vdmUoJ3NvLXBsYWNlaG9sZGVyJyk7XG4gICAgfSBlbHNlIHtcbiAgICAgIC8vIFVzZSB0ZW1wbGF0ZSB3aXRoIHtjb3VudH0gcGxhY2Vob2xkZXJcbiAgICAgIHRoaXMuX3NlbGVjdGVkRWwudGV4dENvbnRlbnQgPSB0aGlzLm9wdGlvbnMubXVsdGlwbGVTZWxlY3RlZFRleHQucmVwbGFjZSgne2NvdW50fScsIGNvdW50KTtcbiAgICAgIHRoaXMuX3NlbGVjdGVkRWwuY2xhc3NMaXN0LnJlbW92ZSgnc28tcGxhY2Vob2xkZXInKTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogR2V0IHRvdGFsIG51bWJlciBvZiBzZWxlY3RhYmxlIChub24tZGlzYWJsZWQpIGl0ZW1zXG4gICAqIEByZXR1cm5zIHtudW1iZXJ9IFRvdGFsIHNlbGVjdGFibGUgaXRlbXNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9nZXRUb3RhbFNlbGVjdGFibGVJdGVtcygpIHtcbiAgICBjb25zdCBpdGVtU2VsZWN0b3IgPSB0aGlzLl9nZXRJdGVtU2VsZWN0b3IoKTtcbiAgICByZXR1cm4gdGhpcy4kJChpdGVtU2VsZWN0b3IpLmZpbHRlcihpdGVtID0+XG4gICAgICAhaXRlbS5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWRpc2FibGVkJykgJiZcbiAgICAgICFpdGVtLmhhc0F0dHJpYnV0ZSgnZGlzYWJsZWQnKSAmJlxuICAgICAgaXRlbS5nZXRBdHRyaWJ1dGUoJ2FyaWEtZGlzYWJsZWQnKSAhPT0gJ3RydWUnXG4gICAgKS5sZW5ndGg7XG4gIH1cblxuICAvKipcbiAgICogR2V0IHNlbGVjdGVkIHZhbHVlIChyZXR1cm5zIGZpcnN0IGZvciBtdWx0aXBsZSwgb3Igc2luZ2xlIHZhbHVlKVxuICAgKiBAcmV0dXJucyB7c3RyaW5nfG51bGx9IFNlbGVjdGVkIHZhbHVlXG4gICAqL1xuICBnZXRWYWx1ZSgpIHtcbiAgICByZXR1cm4gdGhpcy5fc2VsZWN0ZWRWYWx1ZXNbMF0gfHwgbnVsbDtcbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgYWxsIHNlbGVjdGVkIHZhbHVlcyAoZm9yIG11bHRpcGxlIHNlbGVjdGlvbilcbiAgICogQHJldHVybnMge3N0cmluZ1tdfSBBcnJheSBvZiBzZWxlY3RlZCB2YWx1ZXNcbiAgICovXG4gIGdldFZhbHVlcygpIHtcbiAgICByZXR1cm4gWy4uLnRoaXMuX3NlbGVjdGVkVmFsdWVzXTtcbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgc2VsZWN0ZWQgdGV4dCAocmV0dXJucyBmaXJzdCBmb3IgbXVsdGlwbGUsIG9yIHNpbmdsZSB0ZXh0KVxuICAgKiBAcmV0dXJucyB7c3RyaW5nfG51bGx9IFNlbGVjdGVkIHRleHRcbiAgICovXG4gIGdldFRleHQoKSB7XG4gICAgcmV0dXJuIHRoaXMuX3NlbGVjdGVkVGV4dHNbMF0gfHwgbnVsbDtcbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgYWxsIHNlbGVjdGVkIHRleHRzIChmb3IgbXVsdGlwbGUgc2VsZWN0aW9uKVxuICAgKiBAcmV0dXJucyB7c3RyaW5nW119IEFycmF5IG9mIHNlbGVjdGVkIHRleHRzXG4gICAqL1xuICBnZXRUZXh0cygpIHtcbiAgICByZXR1cm4gWy4uLnRoaXMuX3NlbGVjdGVkVGV4dHNdO1xuICB9XG5cbiAgLyoqXG4gICAqIENsZWFyIGFsbCBzZWxlY3Rpb25zXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIGNsZWFyU2VsZWN0aW9uKCkge1xuICAgIGNvbnN0IHByZXZpb3VzVmFsdWVzID0gWy4uLnRoaXMuX3NlbGVjdGVkVmFsdWVzXTtcblxuICAgIHRoaXMuX3NlbGVjdGVkVmFsdWVzID0gW107XG4gICAgdGhpcy5fc2VsZWN0ZWRUZXh0cyA9IFtdO1xuXG4gICAgLy8gVXBkYXRlIFVJXG4gICAgY29uc3QgaXRlbVNlbGVjdG9yID0gdGhpcy5fZ2V0SXRlbVNlbGVjdG9yKCk7XG4gICAgdGhpcy4kJChpdGVtU2VsZWN0b3IpLmZvckVhY2goaXRlbSA9PiB7XG4gICAgICBpdGVtLmNsYXNzTGlzdC5yZW1vdmUoJ3NvLXNlbGVjdGVkJywgJ3NvLWFjdGl2ZScpO1xuICAgIH0pO1xuXG4gICAgLy8gVXBkYXRlIGRpc3BsYXlcbiAgICBpZiAodGhpcy5vcHRpb25zLm11bHRpcGxlKSB7XG4gICAgICB0aGlzLl91cGRhdGVNdWx0aXBsZURpc3BsYXkoKTtcbiAgICB9IGVsc2UgaWYgKHRoaXMuX3NlbGVjdGVkRWwpIHtcbiAgICAgIHRoaXMuX3NlbGVjdGVkRWwudGV4dENvbnRlbnQgPSB0aGlzLm9wdGlvbnMucGxhY2Vob2xkZXI7XG4gICAgICB0aGlzLl9zZWxlY3RlZEVsLmNsYXNzTGlzdC5hZGQoJ3NvLXBsYWNlaG9sZGVyJyk7XG4gICAgfVxuXG4gICAgLy8gRW1pdCBjaGFuZ2UgZXZlbnRcbiAgICB0aGlzLmVtaXQoU09Ecm9wZG93bi5FVkVOVFMuQ0hBTkdFLCB7XG4gICAgICB2YWx1ZTogbnVsbCxcbiAgICAgIHRleHQ6IG51bGwsXG4gICAgICB2YWx1ZXM6IFtdLFxuICAgICAgdGV4dHM6IFtdLFxuICAgICAgcHJldmlvdXNWYWx1ZXMsXG4gICAgICBhY3Rpb246ICdjbGVhcicsXG4gICAgfSk7XG5cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBTZWxlY3QgYWxsIGl0ZW1zIChmb3IgbXVsdGlwbGUgc2VsZWN0aW9uIG1vZGUpXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHNlbGVjdEFsbCgpIHtcbiAgICBpZiAoIXRoaXMub3B0aW9ucy5tdWx0aXBsZSkgcmV0dXJuIHRoaXM7XG5cbiAgICBjb25zdCBwcmV2aW91c1ZhbHVlcyA9IFsuLi50aGlzLl9zZWxlY3RlZFZhbHVlc107XG4gICAgY29uc3QgaXRlbVNlbGVjdG9yID0gdGhpcy5fZ2V0SXRlbVNlbGVjdG9yKCk7XG4gICAgY29uc3QgaXRlbXMgPSB0aGlzLiQkKGl0ZW1TZWxlY3Rvcik7XG5cbiAgICB0aGlzLl9zZWxlY3RlZFZhbHVlcyA9IFtdO1xuICAgIHRoaXMuX3NlbGVjdGVkVGV4dHMgPSBbXTtcblxuICAgIGl0ZW1zLmZvckVhY2goaXRlbSA9PiB7XG4gICAgICAvLyBTa2lwIGRpc2FibGVkIGl0ZW1zXG4gICAgICBpZiAoaXRlbS5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWRpc2FibGVkJykgfHxcbiAgICAgICAgICBpdGVtLmhhc0F0dHJpYnV0ZSgnZGlzYWJsZWQnKSB8fFxuICAgICAgICAgIGl0ZW0uZ2V0QXR0cmlidXRlKCdhcmlhLWRpc2FibGVkJykgPT09ICd0cnVlJykge1xuICAgICAgICByZXR1cm47XG4gICAgICB9XG5cbiAgICAgIC8vIFNraXAgaGlkZGVuIGl0ZW1zIChmaWx0ZXJlZCBvdXQpXG4gICAgICBpZiAoaXRlbS5zdHlsZS5kaXNwbGF5ID09PSAnbm9uZScpIHtcbiAgICAgICAgcmV0dXJuO1xuICAgICAgfVxuXG4gICAgICBjb25zdCB0ZXh0ID0gdGhpcy5fZ2V0SXRlbVRleHQoaXRlbSk7XG4gICAgICBjb25zdCB2YWx1ZSA9IGl0ZW0uZGF0YXNldC52YWx1ZSAhPT0gdW5kZWZpbmVkID8gaXRlbS5kYXRhc2V0LnZhbHVlIDogdGV4dDtcblxuICAgICAgLy8gQ2hlY2sgbWF4IHNlbGVjdGlvbnNcbiAgICAgIGlmICh0aGlzLm9wdGlvbnMubWF4U2VsZWN0aW9ucyAmJiB0aGlzLl9zZWxlY3RlZFZhbHVlcy5sZW5ndGggPj0gdGhpcy5vcHRpb25zLm1heFNlbGVjdGlvbnMpIHtcbiAgICAgICAgcmV0dXJuO1xuICAgICAgfVxuXG4gICAgICB0aGlzLl9zZWxlY3RlZFZhbHVlcy5wdXNoKHZhbHVlKTtcbiAgICAgIHRoaXMuX3NlbGVjdGVkVGV4dHMucHVzaCh0ZXh0KTtcbiAgICAgIGl0ZW0uY2xhc3NMaXN0LmFkZCgnc28tc2VsZWN0ZWQnLCAnc28tYWN0aXZlJyk7XG4gICAgfSk7XG5cbiAgICAvLyBVcGRhdGUgZGlzcGxheVxuICAgIHRoaXMuX3VwZGF0ZU11bHRpcGxlRGlzcGxheSgpO1xuXG4gICAgLy8gRW1pdCBjaGFuZ2UgZXZlbnRcbiAgICB0aGlzLmVtaXQoU09Ecm9wZG93bi5FVkVOVFMuQ0hBTkdFLCB7XG4gICAgICB2YWx1ZTogdGhpcy5fc2VsZWN0ZWRWYWx1ZXNbMF0gfHwgbnVsbCxcbiAgICAgIHRleHQ6IHRoaXMuX3NlbGVjdGVkVGV4dHNbMF0gfHwgbnVsbCxcbiAgICAgIHZhbHVlczogdGhpcy5fc2VsZWN0ZWRWYWx1ZXMsXG4gICAgICB0ZXh0czogdGhpcy5fc2VsZWN0ZWRUZXh0cyxcbiAgICAgIHByZXZpb3VzVmFsdWVzLFxuICAgICAgYWN0aW9uOiAnc2VsZWN0QWxsJyxcbiAgICB9KTtcblxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIERlc2VsZWN0IGFsbCBpdGVtcyAoYWxpYXMgZm9yIGNsZWFyU2VsZWN0aW9uLCBmb3IgbXVsdGlwbGUgc2VsZWN0aW9uIG1vZGUpXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHNlbGVjdE5vbmUoKSB7XG4gICAgaWYgKCF0aGlzLm9wdGlvbnMubXVsdGlwbGUpIHJldHVybiB0aGlzO1xuXG4gICAgLy8gQ2hlY2sgbWluU2VsZWN0aW9ucyAtIGlmIHNldCwgZG9uJ3QgYWxsb3cgc2VsZWN0aW5nIG5vbmVcbiAgICBjb25zdCBtaW5TZWxlY3Rpb25zID0gdGhpcy5vcHRpb25zLm1pblNlbGVjdGlvbnMgfHwgMDtcbiAgICBpZiAobWluU2VsZWN0aW9ucyA+IDApIHtcbiAgICAgIHJldHVybiB0aGlzOyAvLyBEb24ndCBhbGxvdyBkZXNlbGVjdGluZyBhbGwgd2hlbiBtaW5TZWxlY3Rpb25zIGlzIHNldFxuICAgIH1cblxuICAgIGNvbnN0IHByZXZpb3VzVmFsdWVzID0gWy4uLnRoaXMuX3NlbGVjdGVkVmFsdWVzXTtcblxuICAgIHRoaXMuX3NlbGVjdGVkVmFsdWVzID0gW107XG4gICAgdGhpcy5fc2VsZWN0ZWRUZXh0cyA9IFtdO1xuXG4gICAgLy8gVXBkYXRlIFVJXG4gICAgY29uc3QgaXRlbVNlbGVjdG9yID0gdGhpcy5fZ2V0SXRlbVNlbGVjdG9yKCk7XG4gICAgdGhpcy4kJChpdGVtU2VsZWN0b3IpLmZvckVhY2goaXRlbSA9PiB7XG4gICAgICBpdGVtLmNsYXNzTGlzdC5yZW1vdmUoJ3NvLXNlbGVjdGVkJywgJ3NvLWFjdGl2ZScpO1xuICAgIH0pO1xuXG4gICAgLy8gVXBkYXRlIGRpc3BsYXlcbiAgICB0aGlzLl91cGRhdGVNdWx0aXBsZURpc3BsYXkoKTtcblxuICAgIC8vIEVtaXQgY2hhbmdlIGV2ZW50XG4gICAgdGhpcy5lbWl0KFNPRHJvcGRvd24uRVZFTlRTLkNIQU5HRSwge1xuICAgICAgdmFsdWU6IG51bGwsXG4gICAgICB0ZXh0OiBudWxsLFxuICAgICAgdmFsdWVzOiBbXSxcbiAgICAgIHRleHRzOiBbXSxcbiAgICAgIHByZXZpb3VzVmFsdWVzLFxuICAgICAgYWN0aW9uOiAnc2VsZWN0Tm9uZScsXG4gICAgfSk7XG5cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBDaGVjayBpZiBkcm9wZG93biBpcyBvcGVuXG4gICAqIEByZXR1cm5zIHtib29sZWFufSBPcGVuIHN0YXRlXG4gICAqL1xuICBpc09wZW4oKSB7XG4gICAgcmV0dXJuIHRoaXMuX2lzT3BlbjtcbiAgfVxuXG4gIC8qKlxuICAgKiBVcGRhdGUgZHJvcGRvd24gcG9zaXRpb24gKGZvciBkeW5hbWljIGNvbnRlbnQpXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHVwZGF0ZSgpIHtcbiAgICBpZiAodGhpcy5faXNPcGVuKSB7XG4gICAgICB0aGlzLl9wb3NpdGlvbk1lbnUoKTtcbiAgICB9XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogRGlzYWJsZSB0aGUgZHJvcGRvd25cbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgZGlzYWJsZSgpIHtcbiAgICB0aGlzLl9kaXNhYmxlZCA9IHRydWU7XG4gICAgdGhpcy5hZGRDbGFzcygnc28tZGlzYWJsZWQnKTtcbiAgICBpZiAodGhpcy5fdHJpZ2dlcikge1xuICAgICAgdGhpcy5fdHJpZ2dlci5zZXRBdHRyaWJ1dGUoJ2Rpc2FibGVkJywgJycpO1xuICAgICAgdGhpcy5fdHJpZ2dlci5zZXRBdHRyaWJ1dGUoJ2FyaWEtZGlzYWJsZWQnLCAndHJ1ZScpO1xuICAgIH1cbiAgICBpZiAodGhpcy5faXNPcGVuKSB7XG4gICAgICB0aGlzLmNsb3NlKCk7XG4gICAgfVxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIEVuYWJsZSB0aGUgZHJvcGRvd25cbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgZW5hYmxlKCkge1xuICAgIHRoaXMuX2Rpc2FibGVkID0gZmFsc2U7XG4gICAgdGhpcy5yZW1vdmVDbGFzcygnc28tZGlzYWJsZWQnKTtcbiAgICBpZiAodGhpcy5fdHJpZ2dlcikge1xuICAgICAgdGhpcy5fdHJpZ2dlci5yZW1vdmVBdHRyaWJ1dGUoJ2Rpc2FibGVkJyk7XG4gICAgICB0aGlzLl90cmlnZ2VyLnJlbW92ZUF0dHJpYnV0ZSgnYXJpYS1kaXNhYmxlZCcpO1xuICAgIH1cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBDaGVjayBpZiBkcm9wZG93biBpcyBkaXNhYmxlZFxuICAgKiBAcmV0dXJucyB7Ym9vbGVhbn0gRGlzYWJsZWQgc3RhdGVcbiAgICovXG4gIGlzRGlzYWJsZWQoKSB7XG4gICAgcmV0dXJuIHRoaXMuX2Rpc2FibGVkO1xuICB9XG5cbiAgLyoqXG4gICAqIEVuYWJsZSBvciBkaXNhYmxlIGEgc3BlY2lmaWMgaXRlbVxuICAgKiBAcGFyYW0ge3N0cmluZ3xudW1iZXJ9IGlkZW50aWZpZXIgLSBWYWx1ZSBvciBpbmRleCBvZiBpdGVtXG4gICAqIEBwYXJhbSB7Ym9vbGVhbn0gZGlzYWJsZWQgLSBXaGV0aGVyIHRvIGRpc2FibGVcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgc2V0SXRlbURpc2FibGVkKGlkZW50aWZpZXIsIGRpc2FibGVkID0gdHJ1ZSkge1xuICAgIGNvbnN0IGl0ZW1zID0gdGhpcy4kJCh0aGlzLl9nZXRJdGVtU2VsZWN0b3IoKSk7XG4gICAgY29uc3QgaXRlbSA9IHR5cGVvZiBpZGVudGlmaWVyID09PSAnbnVtYmVyJ1xuICAgICAgPyBpdGVtc1tpZGVudGlmaWVyXVxuICAgICAgOiBpdGVtcy5maW5kKGkgPT4gaS5kYXRhc2V0LnZhbHVlID09PSBpZGVudGlmaWVyKTtcblxuICAgIGlmIChpdGVtKSB7XG4gICAgICBpdGVtLmNsYXNzTGlzdC50b2dnbGUoJ3NvLWRpc2FibGVkJywgZGlzYWJsZWQpO1xuICAgICAgaWYgKGRpc2FibGVkKSB7XG4gICAgICAgIGl0ZW0uc2V0QXR0cmlidXRlKCdhcmlhLWRpc2FibGVkJywgJ3RydWUnKTtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIGl0ZW0ucmVtb3ZlQXR0cmlidXRlKCdhcmlhLWRpc2FibGVkJyk7XG4gICAgICB9XG4gICAgfVxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gU1RBVElDIEZBQ1RPUlkgTUVUSE9EU1xuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBDcmVhdGUgYSBzdGFuZGFyZCBkcm9wZG93biBwcm9ncmFtbWF0aWNhbGx5XG4gICAqIEBwYXJhbSB7T2JqZWN0fSBvcHRpb25zIC0gRHJvcGRvd24gY29uZmlndXJhdGlvblxuICAgKiBAcmV0dXJucyB7SFRNTEVsZW1lbnR9IENyZWF0ZWQgZHJvcGRvd24gZWxlbWVudFxuICAgKi9cbiAgc3RhdGljIGNyZWF0ZShvcHRpb25zID0ge30pIHtcbiAgICBjb25zdCB7IHBsYWNlaG9sZGVyID0gJ1NlbGVjdCBvcHRpb24nLCBpdGVtcyA9IFtdLCBjbGFzc05hbWUgPSAnJyB9ID0gb3B0aW9ucztcblxuICAgIGNvbnN0IGRyb3Bkb3duID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XG4gICAgZHJvcGRvd24uY2xhc3NOYW1lID0gYHNvLWRyb3Bkb3duICR7Y2xhc3NOYW1lfWAudHJpbSgpO1xuXG4gICAgY29uc3Qgc2VsZWN0ZWRJdGVtID0gaXRlbXMuZmluZChpID0+IGkuc2VsZWN0ZWQpO1xuXG4gICAgZHJvcGRvd24uaW5uZXJIVE1MID0gYFxuICAgICAgPGJ1dHRvbiB0eXBlPVwiYnV0dG9uXCIgY2xhc3M9XCJzby1kcm9wZG93bi10cmlnZ2VyXCI+XG4gICAgICAgIDxzcGFuIGNsYXNzPVwic28tZHJvcGRvd24tc2VsZWN0ZWRcIj4ke3NlbGVjdGVkSXRlbT8ubGFiZWwgfHwgcGxhY2Vob2xkZXJ9PC9zcGFuPlxuICAgICAgICA8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zIHNvLWRyb3Bkb3duLWFycm93XCI+ZXhwYW5kX21vcmU8L3NwYW4+XG4gICAgICA8L2J1dHRvbj5cbiAgICAgIDxkaXYgY2xhc3M9XCJzby1kcm9wZG93bi1tZW51XCI+XG4gICAgICAgICR7aXRlbXMubWFwKGl0ZW0gPT4gYFxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1kcm9wZG93bi1pdGVtICR7aXRlbS5zZWxlY3RlZCA/ICdzby1zZWxlY3RlZCcgOiAnJ30gJHtpdGVtLmRpc2FibGVkID8gJ3NvLWRpc2FibGVkJyA6ICcnfVwiXG4gICAgICAgICAgICAgICBkYXRhLXZhbHVlPVwiJHtpdGVtLnZhbHVlfVwiXG4gICAgICAgICAgICAgICAke2l0ZW0uZGlzYWJsZWQgPyAnYXJpYS1kaXNhYmxlZD1cInRydWVcIicgOiAnJ30+XG4gICAgICAgICAgICAke2l0ZW0uaWNvbiA/IGA8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+JHtpdGVtLmljb259PC9zcGFuPmAgOiAnJ31cbiAgICAgICAgICAgICR7aXRlbS5sYWJlbH1cbiAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgYCkuam9pbignJyl9XG4gICAgICA8L2Rpdj5cbiAgICBgO1xuXG4gICAgcmV0dXJuIGRyb3Bkb3duO1xuICB9XG5cbiAgLyoqXG4gICAqIENyZWF0ZSBhIHNlYXJjaGFibGUgZHJvcGRvd24gcHJvZ3JhbW1hdGljYWxseVxuICAgKiBAcGFyYW0ge09iamVjdH0gb3B0aW9ucyAtIERyb3Bkb3duIGNvbmZpZ3VyYXRpb25cbiAgICogQHJldHVybnMge0hUTUxFbGVtZW50fSBDcmVhdGVkIGRyb3Bkb3duIGVsZW1lbnRcbiAgICovXG4gIHN0YXRpYyBjcmVhdGVTZWFyY2hhYmxlKG9wdGlvbnMgPSB7fSkge1xuICAgIGNvbnN0IHtcbiAgICAgIHBsYWNlaG9sZGVyID0gJ1NlbGVjdCBvcHRpb24nLFxuICAgICAgc2VhcmNoUGxhY2Vob2xkZXIgPSAnU2VhcmNoLi4uJyxcbiAgICAgIGl0ZW1zID0gW10sXG4gICAgICBjbGFzc05hbWUgPSAnJ1xuICAgIH0gPSBvcHRpb25zO1xuXG4gICAgY29uc3QgZHJvcGRvd24gPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcbiAgICBkcm9wZG93bi5jbGFzc05hbWUgPSBgc28tc2VhcmNoYWJsZS1kcm9wZG93biAke2NsYXNzTmFtZX1gLnRyaW0oKTtcblxuICAgIGNvbnN0IHNlbGVjdGVkSXRlbSA9IGl0ZW1zLmZpbmQoaSA9PiBpLnNlbGVjdGVkKTtcblxuICAgIGRyb3Bkb3duLmlubmVySFRNTCA9IGBcbiAgICAgIDxidXR0b24gdHlwZT1cImJ1dHRvblwiIGNsYXNzPVwic28tc2VhcmNoYWJsZS10cmlnZ2VyXCI+XG4gICAgICAgIDxzcGFuIGNsYXNzPVwic28tc2VhcmNoYWJsZS1zZWxlY3RlZFwiPiR7c2VsZWN0ZWRJdGVtPy5sYWJlbCB8fCBwbGFjZWhvbGRlcn08L3NwYW4+XG4gICAgICAgIDxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnMgc28tZHJvcGRvd24tYXJyb3dcIj5leHBhbmRfbW9yZTwvc3Bhbj5cbiAgICAgIDwvYnV0dG9uPlxuICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaGFibGUtbWVudVwiPlxuICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoYWJsZS1zZWFyY2hcIj5cbiAgICAgICAgICA8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+c2VhcmNoPC9zcGFuPlxuICAgICAgICAgIDxpbnB1dCB0eXBlPVwidGV4dFwiIGNsYXNzPVwic28tc2VhcmNoYWJsZS1pbnB1dFwiIHBsYWNlaG9sZGVyPVwiJHtzZWFyY2hQbGFjZWhvbGRlcn1cIj5cbiAgICAgICAgPC9kaXY+XG4gICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2hhYmxlLWl0ZW1zXCI+XG4gICAgICAgICAgJHtpdGVtcy5tYXAoaXRlbSA9PiBgXG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoYWJsZS1pdGVtICR7aXRlbS5zZWxlY3RlZCA/ICdzby1zZWxlY3RlZCcgOiAnJ30gJHtpdGVtLmRpc2FibGVkID8gJ3NvLWRpc2FibGVkJyA6ICcnfVwiXG4gICAgICAgICAgICAgICAgIGRhdGEtdmFsdWU9XCIke2l0ZW0udmFsdWV9XCJcbiAgICAgICAgICAgICAgICAgJHtpdGVtLmRpc2FibGVkID8gJ2FyaWEtZGlzYWJsZWQ9XCJ0cnVlXCInIDogJyd9PlxuICAgICAgICAgICAgICAke2l0ZW0ubGFiZWx9XG4gICAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgICBgKS5qb2luKCcnKX1cbiAgICAgICAgPC9kaXY+XG4gICAgICA8L2Rpdj5cbiAgICBgO1xuXG4gICAgcmV0dXJuIGRyb3Bkb3duO1xuICB9XG5cbiAgLyoqXG4gICAqIENyZWF0ZSBhbiBvcHRpb25zIGRyb3Bkb3duIHByb2dyYW1tYXRpY2FsbHlcbiAgICogQHBhcmFtIHtPYmplY3R9IG9wdGlvbnMgLSBEcm9wZG93biBjb25maWd1cmF0aW9uXG4gICAqIEByZXR1cm5zIHtIVE1MRWxlbWVudH0gQ3JlYXRlZCBkcm9wZG93biBlbGVtZW50XG4gICAqL1xuICBzdGF0aWMgY3JlYXRlT3B0aW9ucyhvcHRpb25zID0ge30pIHtcbiAgICBjb25zdCB7IGljb24gPSAnbW9yZV92ZXJ0JywgaXRlbXMgPSBbXSwgY2xhc3NOYW1lID0gJycgfSA9IG9wdGlvbnM7XG5cbiAgICBjb25zdCBkcm9wZG93biA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2RpdicpO1xuICAgIGRyb3Bkb3duLmNsYXNzTmFtZSA9IGBzby1vcHRpb25zLWRyb3Bkb3duICR7Y2xhc3NOYW1lfWAudHJpbSgpO1xuXG4gICAgZHJvcGRvd24uaW5uZXJIVE1MID0gYFxuICAgICAgPGJ1dHRvbiB0eXBlPVwiYnV0dG9uXCIgY2xhc3M9XCJzby1vcHRpb25zLXRyaWdnZXJcIj5cbiAgICAgICAgPHNwYW4gY2xhc3M9XCJtYXRlcmlhbC1pY29uc1wiPiR7aWNvbn08L3NwYW4+XG4gICAgICA8L2J1dHRvbj5cbiAgICAgIDxkaXYgY2xhc3M9XCJzby1vcHRpb25zLW1lbnVcIj5cbiAgICAgICAgJHtpdGVtcy5tYXAoaXRlbSA9PiB7XG4gICAgICAgICAgaWYgKGl0ZW0uZGl2aWRlcikge1xuICAgICAgICAgICAgcmV0dXJuICc8ZGl2IGNsYXNzPVwic28tb3B0aW9ucy1kaXZpZGVyXCI+PC9kaXY+JztcbiAgICAgICAgICB9XG4gICAgICAgICAgaWYgKGl0ZW0uaGVhZGVyKSB7XG4gICAgICAgICAgICByZXR1cm4gYDxkaXYgY2xhc3M9XCJzby1kcm9wZG93bi1oZWFkZXJcIj4ke2l0ZW0uaGVhZGVyfTwvZGl2PmA7XG4gICAgICAgICAgfVxuICAgICAgICAgIHJldHVybiBgXG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tb3B0aW9ucy1pdGVtICR7aXRlbS5kYW5nZXIgPyAnc28tZGFuZ2VyJyA6ICcnfSAke2l0ZW0uZGlzYWJsZWQgPyAnc28tZGlzYWJsZWQnIDogJyd9XCJcbiAgICAgICAgICAgICAgICAgZGF0YS1hY3Rpb249XCIke2l0ZW0uYWN0aW9uIHx8ICcnfVwiXG4gICAgICAgICAgICAgICAgICR7aXRlbS5kaXNhYmxlZCA/ICdhcmlhLWRpc2FibGVkPVwidHJ1ZVwiJyA6ICcnfT5cbiAgICAgICAgICAgICAgJHtpdGVtLmljb24gPyBgPHNwYW4gY2xhc3M9XCJtYXRlcmlhbC1pY29uc1wiPiR7aXRlbS5pY29ufTwvc3Bhbj5gIDogJyd9XG4gICAgICAgICAgICAgIDxzcGFuPiR7aXRlbS5sYWJlbH08L3NwYW4+XG4gICAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgICBgO1xuICAgICAgICB9KS5qb2luKCcnKX1cbiAgICAgIDwvZGl2PlxuICAgIGA7XG5cbiAgICByZXR1cm4gZHJvcGRvd247XG4gIH1cbn1cblxuLy8gUmVnaXN0ZXIgY29tcG9uZW50XG5TT0Ryb3Bkb3duLnJlZ2lzdGVyKCk7XG5cbi8vIEV4cG9zZSB0byBnbG9iYWwgc2NvcGVcbndpbmRvdy5TT0Ryb3Bkb3duID0gU09Ecm9wZG93bjtcblxuLy8gRXhwb3J0IGZvciBFUyBtb2R1bGVzXG5leHBvcnQgZGVmYXVsdCBTT0Ryb3Bkb3duO1xuZXhwb3J0IHsgU09Ecm9wZG93biB9O1xuIiwgIi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4vLyBTSVhPUkJJVCBVSSAtIExBWU9VVCBDT01QT05FTlRTXG4vLyBOYXZiYXIgY29udHJvbGxlciAoU2lkZWJhciBtb3ZlZCB0byBzcmMvcGFnZXMvZ2xvYmFsL2dsb2JhbC5qcylcbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbmltcG9ydCBTaXhPcmJpdCBmcm9tICcuLi9jb3JlL3NvLWNvbmZpZy5qcyc7XG5pbXBvcnQgU09Db21wb25lbnQgZnJvbSAnLi4vY29yZS9zby1jb21wb25lbnQuanMnO1xuXG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gTkFWQkFSIENPTVBPTkVOVFxuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuLyoqXG4gKiBTT05hdmJhciAtIE5hdmJhciBjb21wb25lbnRcbiAqIEhhbmRsZXMgbmF2YmFyIGRyb3Bkb3ducyBhbmQgaW50ZXJhY3Rpb25zXG4gKi9cbmNsYXNzIFNPTmF2YmFyIGV4dGVuZHMgU09Db21wb25lbnQge1xuICBzdGF0aWMgTkFNRSA9ICduYXZiYXInO1xuXG4gIHN0YXRpYyBERUZBVUxUUyA9IHtcbiAgICBzZWFyY2hJbnB1dFNlbGVjdG9yOiAnLnNvLW5hdmJhci1zZWFyY2gtaW5wdXQnLFxuICAgIHVzZXJCdG5TZWxlY3RvcjogJy5zby1uYXZiYXItdXNlci1idG4nLFxuICAgIHVzZXJEcm9wZG93blNlbGVjdG9yOiAnLnNvLW5hdmJhci11c2VyLWRyb3Bkb3duJyxcbiAgICBhcHBzQnRuU2VsZWN0b3I6ICcuc28tbmF2YmFyLWFwcHMtYnRuJyxcbiAgICBhcHBzQ29udGFpbmVyU2VsZWN0b3I6ICcuc28tbmF2YmFyLWFwcHMnLFxuICAgIG91dGxldEJ0blNlbGVjdG9yOiAnLnNvLW5hdmJhci1vdXRsZXQtYnRuJyxcbiAgICBvdXRsZXREcm9wZG93blNlbGVjdG9yOiAnLnNvLW5hdmJhci1vdXRsZXQtZHJvcGRvd24nLFxuICAgIHN0YXR1c0J0blNlbGVjdG9yOiAnLnNvLW5hdmJhci1zdGF0dXMtYnRuJyxcbiAgICBzdGF0dXNEcm9wZG93blNlbGVjdG9yOiAnLnNvLW5hdmJhci1zdGF0dXMtZHJvcGRvd24nLFxuICAgIHRoZW1lQnRuU2VsZWN0b3I6ICcuc28tbmF2YmFyLXRoZW1lLWJ0bicsXG4gICAgdGhlbWVEcm9wZG93blNlbGVjdG9yOiAnLnNvLW5hdmJhci10aGVtZS1kcm9wZG93bicsXG4gICAga2V5Ym9hcmRCdG5TZWxlY3RvcjogJyNrZXlib2FyZFNob3J0Y3V0c0J0bicsXG4gIH07XG5cbiAgc3RhdGljIEVWRU5UUyA9IHtcbiAgICBTRUFSQ0g6ICduYXZiYXI6c2VhcmNoJyxcbiAgICBEUk9QRE9XTl9PUEVOOiAnbmF2YmFyOmRyb3Bkb3duOm9wZW4nLFxuICAgIERST1BET1dOX0NMT1NFOiAnbmF2YmFyOmRyb3Bkb3duOmNsb3NlJyxcbiAgICBPVVRMRVRfQ0hBTkdFOiAnbmF2YmFyOm91dGxldDpjaGFuZ2UnLFxuICAgIFNUQVRVU19DSEFOR0U6ICduYXZiYXI6c3RhdHVzOmNoYW5nZScsXG4gIH07XG5cbiAgLyoqXG4gICAqIEluaXRpYWxpemUgdGhlIG5hdmJhclxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2luaXQoKSB7XG4gICAgdGhpcy5fYWN0aXZlRHJvcGRvd24gPSBudWxsO1xuICAgIHRoaXMuX2JpbmRFdmVudHMoKTtcbiAgICB0aGlzLl9pbml0T3V0bGV0U2VsZWN0b3IoKTtcbiAgICB0aGlzLl9pbml0U3RhdHVzU2VsZWN0b3IoKTtcbiAgICB0aGlzLl9pbml0VGhlbWVTd2l0Y2hlcigpO1xuICAgIHRoaXMuX2luaXRLZXlib2FyZFNob3J0Y3V0cygpO1xuICB9XG5cbiAgLyoqXG4gICAqIEJpbmQgZXZlbnQgbGlzdGVuZXJzXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfYmluZEV2ZW50cygpIHtcbiAgICAvLyBTZWFyY2ggaW5wdXQgY2xpY2sgLSBvcGVuIHNlYXJjaCBvdmVybGF5XG4gICAgLy8gVXNlIGNsaWNrIGluc3RlYWQgb2YgZm9jdXMgdG8gcHJldmVudCB1bmludGVuZGVkIG92ZXJsYXkgb3BlbmluZ1xuICAgIGNvbnN0IHNlYXJjaElucHV0ID0gdGhpcy4kKHRoaXMub3B0aW9ucy5zZWFyY2hJbnB1dFNlbGVjdG9yKTtcbiAgICBjb25zdCBzZWFyY2hXcmFwcGVyID0gc2VhcmNoSW5wdXQ/LmNsb3Nlc3QoJy5zby1uYXZiYXItc2VhcmNoLXdyYXBwZXInKSB8fCBzZWFyY2hJbnB1dD8uY2xvc2VzdCgnLnNvLW5hdmJhci1zZWFyY2gnKTtcbiAgICBpZiAoc2VhcmNoV3JhcHBlcikge1xuICAgICAgdGhpcy5vbignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgIGlmICh3aW5kb3cuc29TZWFyY2hPdmVybGF5KSB7XG4gICAgICAgICAgd2luZG93LnNvU2VhcmNoT3ZlcmxheS5vcGVuKCk7XG4gICAgICAgIH1cbiAgICAgIH0sIHNlYXJjaFdyYXBwZXIpO1xuICAgIH1cblxuICAgIC8vIFVzZXIgZHJvcGRvd25cbiAgICBjb25zdCB1c2VyQnRuID0gdGhpcy4kKHRoaXMub3B0aW9ucy51c2VyQnRuU2VsZWN0b3IpO1xuICAgIGNvbnN0IHVzZXJEcm9wZG93biA9IHRoaXMuJCh0aGlzLm9wdGlvbnMudXNlckRyb3Bkb3duU2VsZWN0b3IpO1xuICAgIGlmICh1c2VyQnRuICYmIHVzZXJEcm9wZG93bikge1xuICAgICAgdGhpcy5vbignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgICB0aGlzLl90b2dnbGVEcm9wZG93bih1c2VyRHJvcGRvd24sICd1c2VyJywgJ3NvLWFjdGl2ZScpO1xuICAgICAgfSwgdXNlckJ0bik7XG5cbiAgICAgIC8vIEhhbmRsZSBtZW51IGl0ZW0gY2xpY2tzIC0gc3RvcCBwcm9wYWdhdGlvbiB0byBwcmV2ZW50IHRyaWdnZXJpbmcgcGFyZW50XG4gICAgICBjb25zdCBtZW51SXRlbXMgPSB1c2VyRHJvcGRvd24ucXVlcnlTZWxlY3RvckFsbCgnLnNvLW5hdmJhci11c2VyLW1lbnUtaXRlbScpO1xuICAgICAgbWVudUl0ZW1zLmZvckVhY2goaXRlbSA9PiB7XG4gICAgICAgIHRoaXMub24oJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgICAgIC8vIENsb3NlIGRyb3Bkb3duIGFmdGVyIGNsaWNraW5nIGEgbWVudSBpdGVtXG4gICAgICAgICAgdGhpcy5fY2xvc2VOYXZiYXJEcm9wZG93bnMoKTtcbiAgICAgICAgfSwgaXRlbSk7XG4gICAgICB9KTtcbiAgICB9XG5cbiAgICAvLyBBcHBzIGRyb3Bkb3duXG4gICAgY29uc3QgYXBwc0NvbnRhaW5lciA9IHRoaXMuJCh0aGlzLm9wdGlvbnMuYXBwc0NvbnRhaW5lclNlbGVjdG9yKTtcbiAgICBjb25zdCBhcHBzQnRuID0gdGhpcy4kKHRoaXMub3B0aW9ucy5hcHBzQnRuU2VsZWN0b3IpO1xuICAgIGlmIChhcHBzQ29udGFpbmVyICYmIGFwcHNCdG4pIHtcbiAgICAgIHRoaXMub24oJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgdGhpcy5fdG9nZ2xlRHJvcGRvd24oYXBwc0NvbnRhaW5lciwgJ2FwcHMnLCAnc28tb3BlbicpO1xuICAgICAgfSwgYXBwc0J0bik7XG4gICAgfVxuXG4gICAgLy8gQ2xvc2UgZHJvcGRvd25zIG9uIG91dHNpZGUgY2xpY2tcbiAgICB0aGlzLm9uKCdjbGljaycsIChlKSA9PiB7XG4gICAgICAvLyBEb24ndCBjbG9zZSBpZiBjbGlja2luZyBpbnNpZGUgYW55IGRyb3Bkb3duXG4gICAgICBjb25zdCBpc0luc2lkZU5hdmJhckRyb3Bkb3duID0gZS50YXJnZXQuY2xvc2VzdCgnLnNvLW5hdmJhci1vdXRsZXQtZHJvcGRvd24sIC5zby1uYXZiYXItc3RhdHVzLWRyb3Bkb3duLCAuc28tbmF2YmFyLXRoZW1lLWRyb3Bkb3duLCAuc28tbmF2YmFyLXVzZXItZHJvcGRvd24sIC5zby1uYXZiYXItYXBwcywgLnNvLW5hdmJhci1hcHBzLWRyb3Bkb3duJyk7XG4gICAgICBjb25zdCBpc0luc2lkZVNPRHJvcGRvd24gPSBlLnRhcmdldC5jbG9zZXN0KCcuc28tZHJvcGRvd24sIC5zby1zZWFyY2hhYmxlLWRyb3Bkb3duLCAuc28tb3B0aW9ucy1kcm9wZG93biwgLnNvLW91dGxldC1kcm9wZG93bicpO1xuXG4gICAgICAvLyBEb24ndCBjbG9zZSBpZiBjbGlja2luZyBvbiBhbnkgZHJvcGRvd24gdHJpZ2dlclxuICAgICAgY29uc3QgaXNOYXZiYXJUcmlnZ2VyID0gZS50YXJnZXQuY2xvc2VzdCgnLnNvLW5hdmJhci11c2VyLWJ0biwgLnNvLW5hdmJhci1hcHBzLWJ0biwgLnNvLW5hdmJhci1vdXRsZXQtYnRuLCAuc28tbmF2YmFyLXN0YXR1cy1idG4sIC5zby1uYXZiYXItdGhlbWUtYnRuJyk7XG4gICAgICBjb25zdCBpc1NPRHJvcGRvd25UcmlnZ2VyID0gZS50YXJnZXQuY2xvc2VzdCgnLnNvLWRyb3Bkb3duLXRyaWdnZXIsIC5zby1zZWFyY2hhYmxlLXRyaWdnZXIsIC5zby1vcHRpb25zLXRyaWdnZXIsIC5zby1vdXRsZXQtZHJvcGRvd24tdHJpZ2dlciwgLnNvLWJ0bltkYXRhLXNvLXRvZ2dsZT1cImRyb3Bkb3duXCJdJyk7XG5cbiAgICAgIGlmICghaXNJbnNpZGVOYXZiYXJEcm9wZG93biAmJiAhaXNJbnNpZGVTT0Ryb3Bkb3duICYmICFpc05hdmJhclRyaWdnZXIgJiYgIWlzU09Ecm9wZG93blRyaWdnZXIpIHtcbiAgICAgICAgdGhpcy5jbG9zZUFsbERyb3Bkb3ducygpO1xuICAgICAgfVxuICAgIH0sIGRvY3VtZW50KTtcblxuICAgIC8vIENsb3NlIG9uIGVzY2FwZVxuICAgIHRoaXMub24oJ2tleWRvd24nLCAoZSkgPT4ge1xuICAgICAgaWYgKGUua2V5ID09PSAnRXNjYXBlJykge1xuICAgICAgICB0aGlzLmNsb3NlQWxsRHJvcGRvd25zKCk7XG4gICAgICB9XG4gICAgfSwgZG9jdW1lbnQpO1xuXG4gICAgLy8gTGlzdGVuIGZvciBnbG9iYWwgY2xvc2UgZXZlbnRcbiAgICB0aGlzLm9uKCdjbG9zZUFsbERyb3Bkb3ducycsICgpID0+IHRoaXMuY2xvc2VBbGxEcm9wZG93bnMoKSwgZG9jdW1lbnQpO1xuXG4gICAgLy8gTGlzdGVuIGZvciBjbG9zZSBuYXZiYXIgZHJvcGRvd25zIGV2ZW50IChkaXNwYXRjaGVkIGJ5IFNPRHJvcGRvd24gd2hlbiBvcGVuaW5nKVxuICAgIHRoaXMub24oJ2Nsb3NlTmF2YmFyRHJvcGRvd25zJywgKCkgPT4gdGhpcy5fY2xvc2VOYXZiYXJEcm9wZG93bnMoKSwgZG9jdW1lbnQpO1xuICB9XG5cbiAgLyoqXG4gICAqIEluaXRpYWxpemUgb3V0bGV0IHNlbGVjdG9yXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaW5pdE91dGxldFNlbGVjdG9yKCkge1xuICAgIGNvbnN0IG91dGxldEJ0biA9IHRoaXMuJCh0aGlzLm9wdGlvbnMub3V0bGV0QnRuU2VsZWN0b3IpO1xuICAgIGNvbnN0IG91dGxldERyb3Bkb3duID0gdGhpcy4kKHRoaXMub3B0aW9ucy5vdXRsZXREcm9wZG93blNlbGVjdG9yKTtcblxuICAgIGlmICghb3V0bGV0QnRuIHx8ICFvdXRsZXREcm9wZG93bikgcmV0dXJuO1xuXG4gICAgLy8gVG9nZ2xlIGRyb3Bkb3duXG4gICAgdGhpcy5vbignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgIHRoaXMuX3RvZ2dsZURyb3Bkb3duKG91dGxldERyb3Bkb3duLCAnb3V0bGV0Jyk7XG4gICAgfSwgb3V0bGV0QnRuKTtcblxuICAgIC8vIEhhbmRsZSBvdXRsZXQgc2VsZWN0aW9uXG4gICAgb3V0bGV0RHJvcGRvd24ucXVlcnlTZWxlY3RvckFsbCgnLnNvLW5hdmJhci1vdXRsZXQtaXRlbScpLmZvckVhY2goaXRlbSA9PiB7XG4gICAgICB0aGlzLm9uKCdjbGljaycsIChlKSA9PiB7XG4gICAgICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgIGNvbnN0IHZhbHVlID0gaXRlbS5kYXRhc2V0LnZhbHVlO1xuICAgICAgICBjb25zdCB0ZXh0ID0gaXRlbS5xdWVyeVNlbGVjdG9yKCdzcGFuOmZpcnN0LWNoaWxkJyk/LnRleHRDb250ZW50IHx8IGl0ZW0udGV4dENvbnRlbnQ7XG5cbiAgICAgICAgLy8gVXBkYXRlIHNlbGVjdGVkIHN0YXRlXG4gICAgICAgIG91dGxldERyb3Bkb3duLnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1uYXZiYXItb3V0bGV0LWl0ZW0nKS5mb3JFYWNoKGkgPT4ge1xuICAgICAgICAgIGkuY2xhc3NMaXN0LnRvZ2dsZSgnc28tc2VsZWN0ZWQnLCBpID09PSBpdGVtKTtcbiAgICAgICAgfSk7XG5cbiAgICAgICAgLy8gVXBkYXRlIGJ1dHRvbiB0ZXh0XG4gICAgICAgIGNvbnN0IGJ0blRleHQgPSBvdXRsZXRCdG4ucXVlcnlTZWxlY3RvcignLm91dGxldC10ZXh0Jyk7XG4gICAgICAgIGlmIChidG5UZXh0KSBidG5UZXh0LnRleHRDb250ZW50ID0gdGV4dDtcblxuICAgICAgICB0aGlzLmVtaXQoU09OYXZiYXIuRVZFTlRTLk9VVExFVF9DSEFOR0UsIHsgdmFsdWUsIHRleHQgfSk7XG4gICAgICAgIHRoaXMuY2xvc2VBbGxEcm9wZG93bnMoKTtcbiAgICAgIH0sIGl0ZW0pO1xuICAgIH0pO1xuXG4gICAgLy8gU2VhcmNoIGZpbHRlclxuICAgIGNvbnN0IHNlYXJjaElucHV0ID0gb3V0bGV0RHJvcGRvd24ucXVlcnlTZWxlY3RvcignaW5wdXQnKTtcbiAgICBpZiAoc2VhcmNoSW5wdXQpIHtcbiAgICAgIHRoaXMub24oJ2lucHV0JywgKGUpID0+IHtcbiAgICAgICAgY29uc3QgcXVlcnkgPSBlLnRhcmdldC52YWx1ZS50b0xvd2VyQ2FzZSgpO1xuICAgICAgICBvdXRsZXREcm9wZG93bi5xdWVyeVNlbGVjdG9yQWxsKCcuc28tbmF2YmFyLW91dGxldC1pdGVtJykuZm9yRWFjaChpdGVtID0+IHtcbiAgICAgICAgICBjb25zdCB0ZXh0ID0gaXRlbS50ZXh0Q29udGVudC50b0xvd2VyQ2FzZSgpO1xuICAgICAgICAgIGl0ZW0uc3R5bGUuZGlzcGxheSA9IHRleHQuaW5jbHVkZXMocXVlcnkpID8gJycgOiAnbm9uZSc7XG4gICAgICAgIH0pO1xuICAgICAgfSwgc2VhcmNoSW5wdXQpO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBJbml0aWFsaXplIHN0YXR1cyBzZWxlY3RvclxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2luaXRTdGF0dXNTZWxlY3RvcigpIHtcbiAgICBjb25zdCBzdGF0dXNCdG4gPSB0aGlzLiQodGhpcy5vcHRpb25zLnN0YXR1c0J0blNlbGVjdG9yKTtcbiAgICBjb25zdCBzdGF0dXNEcm9wZG93biA9IHRoaXMuJCh0aGlzLm9wdGlvbnMuc3RhdHVzRHJvcGRvd25TZWxlY3Rvcik7XG4gICAgLy8gU3RhdHVzIGRyb3Bkb3duIHJlcXVpcmVzICdvcGVuJyBjbGFzcyBvbiBwYXJlbnQgLnNvLW5hdmJhci1zdGF0dXMgY29udGFpbmVyXG4gICAgY29uc3Qgc3RhdHVzQ29udGFpbmVyID0gc3RhdHVzQnRuPy5jbG9zZXN0KCcuc28tbmF2YmFyLXN0YXR1cycpO1xuXG4gICAgaWYgKCFzdGF0dXNCdG4gfHwgIXN0YXR1c0Ryb3Bkb3duIHx8ICFzdGF0dXNDb250YWluZXIpIHJldHVybjtcblxuICAgIC8vIFRvZ2dsZSBkcm9wZG93biAtIGFkZCAnb3BlbicgdG8gcGFyZW50IGNvbnRhaW5lclxuICAgIHRoaXMub24oJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICB0aGlzLl90b2dnbGVTdGF0dXNEcm9wZG93bihzdGF0dXNDb250YWluZXIpO1xuICAgIH0sIHN0YXR1c0J0bik7XG5cbiAgICAvLyBIYW5kbGUgc3RhdHVzIHNlbGVjdGlvblxuICAgIHN0YXR1c0Ryb3Bkb3duLnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1uYXZiYXItc3RhdHVzLW9wdGlvbicpLmZvckVhY2gob3B0aW9uID0+IHtcbiAgICAgIHRoaXMub24oJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgY29uc3Qgc3RhdHVzID0gb3B0aW9uLmRhdGFzZXQuc3RhdHVzO1xuICAgICAgICBjb25zdCB0ZXh0ID0gb3B0aW9uLnF1ZXJ5U2VsZWN0b3IoJy5zby1uYXZiYXItc3RhdHVzLW9wdGlvbi10ZXh0ID4gZGl2OmZpcnN0LWNoaWxkJyk/LnRleHRDb250ZW50O1xuXG4gICAgICAgIC8vIFVwZGF0ZSBzZWxlY3RlZCBzdGF0ZVxuICAgICAgICBzdGF0dXNEcm9wZG93bi5xdWVyeVNlbGVjdG9yQWxsKCcuc28tbmF2YmFyLXN0YXR1cy1vcHRpb24nKS5mb3JFYWNoKG8gPT4ge1xuICAgICAgICAgIG8uY2xhc3NMaXN0LnRvZ2dsZSgnc28tc2VsZWN0ZWQnLCBvID09PSBvcHRpb24pO1xuICAgICAgICB9KTtcblxuICAgICAgICAvLyBVcGRhdGUgYnV0dG9uIGluZGljYXRvciBhbmQgdGV4dFxuICAgICAgICBjb25zdCBpbmRpY2F0b3IgPSBzdGF0dXNCdG4ucXVlcnlTZWxlY3RvcignLnNvLW5hdmJhci1zdGF0dXMtaW5kaWNhdG9yJyk7XG4gICAgICAgIGNvbnN0IHRleHRFbCA9IHN0YXR1c0J0bi5xdWVyeVNlbGVjdG9yKCcuc28tbmF2YmFyLXN0YXR1cy10ZXh0Jyk7XG4gICAgICAgIGlmIChpbmRpY2F0b3IpIHtcbiAgICAgICAgICBpbmRpY2F0b3IuY2xhc3NOYW1lID0gYHNvLW5hdmJhci1zdGF0dXMtaW5kaWNhdG9yICR7c3RhdHVzfWA7XG4gICAgICAgIH1cbiAgICAgICAgaWYgKHRleHRFbCAmJiB0ZXh0KSB7XG4gICAgICAgICAgdGV4dEVsLnRleHRDb250ZW50ID0gdGV4dDtcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuZW1pdChTT05hdmJhci5FVkVOVFMuU1RBVFVTX0NIQU5HRSwgeyBzdGF0dXMsIHRleHQgfSk7XG4gICAgICAgIHRoaXMuY2xvc2VBbGxEcm9wZG93bnMoKTtcbiAgICAgIH0sIG9wdGlvbik7XG4gICAgfSk7XG4gIH1cblxuICAvKipcbiAgICogSW5pdGlhbGl6ZSB0aGVtZSBzd2l0Y2hlclxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2luaXRUaGVtZVN3aXRjaGVyKCkge1xuICAgIGNvbnN0IHRoZW1lQnRuID0gdGhpcy4kKHRoaXMub3B0aW9ucy50aGVtZUJ0blNlbGVjdG9yKTtcbiAgICBjb25zdCB0aGVtZURyb3Bkb3duID0gdGhpcy4kKHRoaXMub3B0aW9ucy50aGVtZURyb3Bkb3duU2VsZWN0b3IpO1xuXG4gICAgaWYgKCF0aGVtZUJ0biB8fCAhdGhlbWVEcm9wZG93bikgcmV0dXJuO1xuXG4gICAgLy8gVG9nZ2xlIGRyb3Bkb3duXG4gICAgdGhpcy5vbignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgIHRoaXMuX3RvZ2dsZURyb3Bkb3duKHRoZW1lRHJvcGRvd24sICd0aGVtZScpO1xuICAgIH0sIHRoZW1lQnRuKTtcblxuICAgIC8vIFRoZW1lIG9wdGlvbnMgaGFuZGxlZCBieSBzby10aGVtZS5qc1xuICB9XG5cbiAgLyoqXG4gICAqIEluaXRpYWxpemUga2V5Ym9hcmQgc2hvcnRjdXRzIGJ1dHRvblxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2luaXRLZXlib2FyZFNob3J0Y3V0cygpIHtcbiAgICBjb25zdCBrZXlib2FyZEJ0biA9IHRoaXMuJCh0aGlzLm9wdGlvbnMua2V5Ym9hcmRCdG5TZWxlY3Rvcik7XG4gICAgaWYgKCFrZXlib2FyZEJ0bikgcmV0dXJuO1xuXG4gICAgdGhpcy5vbignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgIC8vIFRyaWdnZXIga2V5Ym9hcmQgc2hvcnRjdXRzIG1vZGFsXG4gICAgICBpZiAod2luZG93LnNvS2V5Ym9hcmRTaG9ydGN1dHMpIHtcbiAgICAgICAgd2luZG93LnNvS2V5Ym9hcmRTaG9ydGN1dHMuc2hvdygpO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgLy8gU2ltcGxlIGFsZXJ0IGZvciBub3cgLSBzaG91bGQgYmUgcmVwbGFjZWQgd2l0aCBwcm9wZXIgbW9kYWxcbiAgICAgICAgY29uc29sZS5sb2coJ0tleWJvYXJkIHNob3J0Y3V0cyBtb2RhbCBub3QgaW1wbGVtZW50ZWQgeWV0Jyk7XG4gICAgICAgIGFsZXJ0KCdLZXlib2FyZCBTaG9ydGN1dHM6XFxuXFxuQ3RybCtLIC0gT3BlbiBTZWFyY2hcXG5DdHJsK1MgLSBOZXcgU2FsZXMgSW52b2ljZVxcbkN0cmwrUCAtIE5ldyBQdXJjaGFzZSBCaWxsXFxuQ3RybCtSIC0gUmVjZWlwdCBFbnRyeVxcbkN0cmwrWSAtIFBheW1lbnQgRW50cnlcXG5Fc2MgLSBDbG9zZSBkaWFsb2dzJyk7XG4gICAgICB9XG4gICAgfSwga2V5Ym9hcmRCdG4pO1xuICB9XG5cbiAgLyoqXG4gICAqIFRvZ2dsZSBhIGRyb3Bkb3duXG4gICAqIEBwYXJhbSB7RWxlbWVudH0gZHJvcGRvd24gLSBEcm9wZG93biBlbGVtZW50XG4gICAqIEBwYXJhbSB7c3RyaW5nfSB0eXBlIC0gRHJvcGRvd24gdHlwZSBpZGVudGlmaWVyXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBhY3RpdmVDbGFzcyAtIENsYXNzIHRvIHRvZ2dsZSAoZGVmYXVsdDogJ2FjdGl2ZScpXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfdG9nZ2xlRHJvcGRvd24oZHJvcGRvd24sIHR5cGUsIGFjdGl2ZUNsYXNzID0gJ3NvLWFjdGl2ZScpIHtcbiAgICBjb25zdCBpc0FjdGl2ZSA9IGRyb3Bkb3duLmNsYXNzTGlzdC5jb250YWlucyhhY3RpdmVDbGFzcyk7XG5cbiAgICAvLyBDbG9zZSBhbGwgZmlyc3QgKGluY2x1ZGluZyBTT0Ryb3Bkb3ducylcbiAgICB0aGlzLmNsb3NlQWxsRHJvcGRvd25zKCk7XG5cbiAgICBpZiAoIWlzQWN0aXZlKSB7XG4gICAgICBkcm9wZG93bi5jbGFzc0xpc3QuYWRkKGFjdGl2ZUNsYXNzKTtcbiAgICAgIHRoaXMuX2FjdGl2ZURyb3Bkb3duID0geyBkcm9wZG93biwgdHlwZSB9O1xuXG4gICAgICB0aGlzLmVtaXQoU09OYXZiYXIuRVZFTlRTLkRST1BET1dOX09QRU4sIHsgZHJvcGRvd24sIHR5cGUgfSk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIFRvZ2dsZSBzdGF0dXMgZHJvcGRvd24gKHVzZXMgJ29wZW4nIG9uIHBhcmVudCBjb250YWluZXIpXG4gICAqIEBwYXJhbSB7RWxlbWVudH0gY29udGFpbmVyIC0gU3RhdHVzIGNvbnRhaW5lciBlbGVtZW50ICguc28tbmF2YmFyLXN0YXR1cylcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF90b2dnbGVTdGF0dXNEcm9wZG93bihjb250YWluZXIpIHtcbiAgICBjb25zdCBpc09wZW4gPSBjb250YWluZXIuY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1vcGVuJyk7XG5cbiAgICAvLyBDbG9zZSBhbGwgZmlyc3RcbiAgICB0aGlzLmNsb3NlQWxsRHJvcGRvd25zKCk7XG5cbiAgICBpZiAoIWlzT3Blbikge1xuICAgICAgY29udGFpbmVyLmNsYXNzTGlzdC5hZGQoJ3NvLW9wZW4nKTtcbiAgICAgIHRoaXMuX2FjdGl2ZURyb3Bkb3duID0geyBkcm9wZG93bjogY29udGFpbmVyLCB0eXBlOiAnc3RhdHVzJyB9O1xuXG4gICAgICB0aGlzLmVtaXQoU09OYXZiYXIuRVZFTlRTLkRST1BET1dOX09QRU4sIHsgZHJvcGRvd246IGNvbnRhaW5lciwgdHlwZTogJ3N0YXR1cycgfSk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIENsb3NlIG9ubHkgbmF2YmFyIGN1c3RvbSBkcm9wZG93bnMgKG5vdCBTT0Ryb3Bkb3duIGluc3RhbmNlcylcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2Nsb3NlTmF2YmFyRHJvcGRvd25zKCkge1xuICAgIC8vIENsb3NlIHVzZXIgZHJvcGRvd25cbiAgICB0aGlzLiQkKCcuc28tbmF2YmFyLXVzZXItZHJvcGRvd24nKS5mb3JFYWNoKGRyb3Bkb3duID0+IHtcbiAgICAgIGRyb3Bkb3duLmNsYXNzTGlzdC5yZW1vdmUoJ3NvLWFjdGl2ZScpO1xuICAgIH0pO1xuICAgIHRoaXMuJCQoJy5zby1uYXZiYXItdXNlci1idG4nKS5mb3JFYWNoKGJ0biA9PiB7XG4gICAgICBidG4uY2xhc3NMaXN0LnJlbW92ZSgnc28tYWN0aXZlJyk7XG4gICAgfSk7XG5cbiAgICAvLyBDbG9zZSBhcHBzIGRyb3Bkb3duXG4gICAgY29uc3QgYXBwc0NvbnRhaW5lciA9IHRoaXMuJCh0aGlzLm9wdGlvbnMuYXBwc0NvbnRhaW5lclNlbGVjdG9yKTtcbiAgICBpZiAoYXBwc0NvbnRhaW5lcikge1xuICAgICAgYXBwc0NvbnRhaW5lci5jbGFzc0xpc3QucmVtb3ZlKCdzby1vcGVuJyk7XG4gICAgfVxuXG4gICAgLy8gQ2xvc2Ugb3V0bGV0IGRyb3Bkb3duXG4gICAgdGhpcy4kJCgnLnNvLW5hdmJhci1vdXRsZXQtZHJvcGRvd24nKS5mb3JFYWNoKGRyb3Bkb3duID0+IHtcbiAgICAgIGRyb3Bkb3duLmNsYXNzTGlzdC5yZW1vdmUoJ3NvLWFjdGl2ZScpO1xuICAgIH0pO1xuXG4gICAgLy8gQ2xvc2Ugc3RhdHVzIGRyb3Bkb3duICh1c2VzICdvcGVuJyBvbiBwYXJlbnQgY29udGFpbmVyKVxuICAgIHRoaXMuJCQoJy5zby1uYXZiYXItc3RhdHVzJykuZm9yRWFjaChjb250YWluZXIgPT4ge1xuICAgICAgY29udGFpbmVyLmNsYXNzTGlzdC5yZW1vdmUoJ3NvLW9wZW4nKTtcbiAgICB9KTtcblxuICAgIC8vIENsb3NlIHRoZW1lIGRyb3Bkb3duXG4gICAgdGhpcy4kJCgnLnNvLW5hdmJhci10aGVtZS1kcm9wZG93bicpLmZvckVhY2goZHJvcGRvd24gPT4ge1xuICAgICAgZHJvcGRvd24uY2xhc3NMaXN0LnJlbW92ZSgnc28tYWN0aXZlJyk7XG4gICAgfSk7XG5cbiAgICB0aGlzLl9hY3RpdmVEcm9wZG93biA9IG51bGw7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogQ2xvc2UgYWxsIGRyb3Bkb3ducyAobmF2YmFyIGN1c3RvbSArIFNPRHJvcGRvd24gaW5zdGFuY2VzKVxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBjbG9zZUFsbERyb3Bkb3ducygpIHtcbiAgICAvLyBDbG9zZSBuYXZiYXIgY3VzdG9tIGRyb3Bkb3duc1xuICAgIHRoaXMuX2Nsb3NlTmF2YmFyRHJvcGRvd25zKCk7XG5cbiAgICAvLyBDbG9zZSBhbGwgU09Ecm9wZG93biBpbnN0YW5jZXNcbiAgICB0aGlzLiQkKCcuc28tZHJvcGRvd24uc28tb3BlbicpLmZvckVhY2goZHJvcGRvd24gPT4ge1xuICAgICAgY29uc3QgaW5zdGFuY2UgPSBTaXhPcmJpdC5nZXRJbnN0YW5jZShkcm9wZG93biwgJ2Ryb3Bkb3duJyk7XG4gICAgICBpZiAoaW5zdGFuY2UgJiYgdHlwZW9mIGluc3RhbmNlLmNsb3NlID09PSAnZnVuY3Rpb24nKSB7XG4gICAgICAgIGluc3RhbmNlLmNsb3NlKCk7XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICB0aGlzLmVtaXQoU09OYXZiYXIuRVZFTlRTLkRST1BET1dOX0NMT1NFKTtcbiAgICByZXR1cm4gdGhpcztcbiAgfVxufVxuXG4vLyBSZWdpc3RlciBjb21wb25lbnRcblNPTmF2YmFyLnJlZ2lzdGVyKCk7XG5cbi8vIEV4cG9zZSB0byBnbG9iYWwgc2NvcGVcbndpbmRvdy5TT05hdmJhciA9IFNPTmF2YmFyO1xuXG4vLyBFeHBvcnQgZm9yIEVTIG1vZHVsZXNcbmV4cG9ydCB7IFNPTmF2YmFyIH07XG5leHBvcnQgZGVmYXVsdCBTT05hdmJhcjtcbiIsICIvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gU0lYT1JCSVQgVUkgLSBNT0RBTCBDT01QT05FTlRcbi8vIE1vZGFsIGRpYWxvZ3Mgd2l0aCBmb2N1cyB0cmFwcGluZ1xuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuaW1wb3J0IFNpeE9yYml0IGZyb20gJy4uL2NvcmUvc28tY29uZmlnLmpzJztcbmltcG9ydCBTT0NvbXBvbmVudCBmcm9tICcuLi9jb3JlL3NvLWNvbXBvbmVudC5qcyc7XG5cbi8qKlxuICogU09Nb2RhbCAtIE1vZGFsIGRpYWxvZyBjb21wb25lbnRcbiAqIFN1cHBvcnRzIHN0YW5kYXJkIG1vZGFscywgY29uZmlybWF0aW9uIGRpYWxvZ3MsIGFuZCBhbGVydHNcbiAqL1xuY2xhc3MgU09Nb2RhbCBleHRlbmRzIFNPQ29tcG9uZW50IHtcbiAgc3RhdGljIE5BTUUgPSAnbW9kYWwnO1xuXG4gIHN0YXRpYyBERUZBVUxUUyA9IHtcbiAgICBiYWNrZHJvcDogdHJ1ZSxcbiAgICBrZXlib2FyZDogdHJ1ZSxcbiAgICBmb2N1czogdHJ1ZSxcbiAgICBjbG9zYWJsZTogdHJ1ZSxcbiAgICBzaXplOiAnZGVmYXVsdCcsIC8vICdzbScsICdkZWZhdWx0JywgJ2xnJywgJ3hsJywgJ2Z1bGxzY3JlZW4nXG4gICAgYW5pbWF0aW9uOiB0cnVlLFxuICAgIHN0YXRpYzogZmFsc2UsIC8vIFdoZW4gdHJ1ZSwgbW9kYWwgY2Fubm90IGJlIGRpc21pc3NlZCB2aWEgYmFja2Ryb3AvZXNjYXBlL2Nsb3NlIGJ1dHRvblxuICAgIGZvY3VzRWxlbWVudDogJ2Zvb3RlcicsIC8vICdmb290ZXInIChmaXJzdCBmb290ZXIgYnV0dG9uKSwgJ2Nsb3NlJywgJ2ZpcnN0Jywgb3IgQ1NTIHNlbGVjdG9yXG4gICAgZHJhZ2dhYmxlOiBmYWxzZSwgLy8gQWxsb3cgbW9kYWwgdG8gYmUgZHJhZ2dlZCBieSBoZWFkZXJcbiAgICBtYXhpbWl6YWJsZTogZmFsc2UsIC8vIFNob3cgbWF4aW1pemUvcmVzdG9yZSBidXR0b25cbiAgICBtb2JpbGVGdWxsc2NyZWVuOiBmYWxzZSwgLy8gQXV0by1zd2l0Y2ggdG8gZnVsbHNjcmVlbiBvbiBtb2JpbGVcbiAgICBtb2JpbGVCcmVha3BvaW50OiA3NjgsIC8vIEJyZWFrcG9pbnQgZm9yIG1vYmlsZSBmdWxsc2NyZWVuXG4gICAgc2lkZWJhcjogZmFsc2UsIC8vIEVuYWJsZSBzaWRlYmFyIGxheW91dDogJ2xlZnQnIG9yICdyaWdodCdcbiAgICBzaWRlYmFyV2lkdGg6ICcyODBweCcsIC8vIFdpZHRoIG9mIHNpZGViYXJcbiAgfTtcblxuICBzdGF0aWMgRVZFTlRTID0ge1xuICAgIFNIT1c6ICdtb2RhbDpzaG93JyxcbiAgICBTSE9XTjogJ21vZGFsOnNob3duJyxcbiAgICBISURFOiAnbW9kYWw6aGlkZScsXG4gICAgSElEREVOOiAnbW9kYWw6aGlkZGVuJyxcbiAgICBDT05GSVJNOiAnbW9kYWw6Y29uZmlybScsXG4gICAgQ0FOQ0VMOiAnbW9kYWw6Y2FuY2VsJyxcbiAgICBNQVhJTUlaRTogJ21vZGFsOm1heGltaXplJyxcbiAgICBSRVNUT1JFOiAnbW9kYWw6cmVzdG9yZScsXG4gICAgRFJBR19TVEFSVDogJ21vZGFsOmRyYWctc3RhcnQnLFxuICAgIERSQUdfRU5EOiAnbW9kYWw6ZHJhZy1lbmQnLFxuICB9O1xuXG4gIC8vIEJhc2Ugei1pbmRleCBmb3IgbW9kYWxzXG4gIHN0YXRpYyBfYmFzZVpJbmRleCA9IDEwNTA7XG5cbiAgLy8gVHJhY2sgb3BlbiBtb2RhbHMgZm9yIHN0YWNraW5nXG4gIHN0YXRpYyBfb3Blbk1vZGFscyA9IFtdO1xuXG4gIC8vIFRyYWNrIHNpbmdsZXRvbiBtb2RhbCBpbnN0YW5jZXMgYnkgSURcbiAgc3RhdGljIF9zaW5nbGV0b25JbnN0YW5jZXMgPSBuZXcgTWFwKCk7XG5cbiAgLyoqXG4gICAqIEluaXRpYWxpemUgdGhlIG1vZGFsXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaW5pdCgpIHtcbiAgICAvLyBDYWNoZSBlbGVtZW50c1xuICAgIHRoaXMuX2RpYWxvZyA9IHRoaXMuJCgnLnNvLW1vZGFsLWRpYWxvZycpO1xuICAgIHRoaXMuX2NvbnRlbnQgPSB0aGlzLiQoJy5zby1tb2RhbC1jb250ZW50Jyk7XG4gICAgdGhpcy5faGVhZGVyID0gdGhpcy4kKCcuc28tbW9kYWwtaGVhZGVyJyk7XG4gICAgdGhpcy5fYmFja2Ryb3AgPSBudWxsO1xuXG4gICAgLy8gU3RhdGVcbiAgICB0aGlzLl9pc09wZW4gPSBmYWxzZTtcbiAgICB0aGlzLl9mb2N1c1RyYXBDbGVhbnVwID0gbnVsbDtcbiAgICB0aGlzLl9wcmV2aW91c0FjdGl2ZUVsZW1lbnQgPSBudWxsO1xuICAgIHRoaXMuX2lzTWF4aW1pemVkID0gZmFsc2U7XG4gICAgdGhpcy5faXNEcmFnZ2luZyA9IGZhbHNlO1xuICAgIHRoaXMuX2RyYWdQb3NpdGlvbiA9IHsgeDogMCwgeTogMCB9O1xuICAgIHRoaXMuX29yaWdpbmFsU2l6ZSA9IG51bGw7XG4gICAgdGhpcy5fcmVzaXplT2JzZXJ2ZXIgPSBudWxsO1xuXG4gICAgLy8gQ2hlY2sgZm9yIHN0YXRpYyBtb2RlIGZyb20gZGF0YSBhdHRyaWJ1dGUsIGNsYXNzLCBvciBvcHRpb25zXG4gICAgLy8gKG9wdGlvbnMuc3RhdGljIG1heSBhbHJlYWR5IGJlIHNldCBmcm9tIGNvbnN0cnVjdG9yKVxuICAgIGlmICh0aGlzLmVsZW1lbnQuaGFzQXR0cmlidXRlKCdkYXRhLXNvLXN0YXRpYycpIHx8XG4gICAgICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLW1vZGFsLXN0YXRpYycpIHx8XG4gICAgICAgIHRoaXMub3B0aW9ucy5zdGF0aWMgPT09IHRydWUpIHtcbiAgICAgIHRoaXMub3B0aW9ucy5zdGF0aWMgPSB0cnVlO1xuICAgICAgdGhpcy5vcHRpb25zLmNsb3NhYmxlID0gZmFsc2U7XG4gICAgICB0aGlzLm9wdGlvbnMua2V5Ym9hcmQgPSBmYWxzZTtcbiAgICAgIC8vIEFkZCBzdGF0aWMgY2xhc3MgaWYgbm90IHByZXNlbnRcbiAgICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QuYWRkKCdzby1tb2RhbC1zdGF0aWMnKTtcbiAgICB9XG5cbiAgICAvLyBTZXR1cCBkcmFnZ2FibGVcbiAgICBpZiAodGhpcy5vcHRpb25zLmRyYWdnYWJsZSkge1xuICAgICAgdGhpcy5fc2V0dXBEcmFnZ2FibGUoKTtcbiAgICB9XG5cbiAgICAvLyBTZXR1cCBtYXhpbWl6YWJsZVxuICAgIGlmICh0aGlzLm9wdGlvbnMubWF4aW1pemFibGUpIHtcbiAgICAgIHRoaXMuX3NldHVwTWF4aW1pemFibGUoKTtcbiAgICB9XG5cbiAgICAvLyBTZXR1cCBtb2JpbGUgZnVsbHNjcmVlblxuICAgIGlmICh0aGlzLm9wdGlvbnMubW9iaWxlRnVsbHNjcmVlbikge1xuICAgICAgdGhpcy5fc2V0dXBNb2JpbGVGdWxsc2NyZWVuKCk7XG4gICAgfVxuXG4gICAgLy8gU2V0dXAgc2lkZWJhciBsYXlvdXRcbiAgICBpZiAodGhpcy5vcHRpb25zLnNpZGViYXIpIHtcbiAgICAgIHRoaXMuX3NldHVwU2lkZWJhcigpO1xuICAgIH1cblxuICAgIC8vIEJpbmQgZXZlbnRzXG4gICAgdGhpcy5fYmluZEV2ZW50cygpO1xuICB9XG5cbiAgLyoqXG4gICAqIEJpbmQgZXZlbnQgbGlzdGVuZXJzXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfYmluZEV2ZW50cygpIHtcbiAgICAvLyBDbG9zZSBidXR0b24gKG9ubHkgaWYgY2xvc2FibGUvbm90IHN0YXRpYylcbiAgICB0aGlzLmRlbGVnYXRlKCdjbGljaycsICcuc28tbW9kYWwtY2xvc2UsIFtkYXRhLWRpc21pc3M9XCJtb2RhbFwiXScsICgpID0+IHtcbiAgICAgIGlmICghdGhpcy5vcHRpb25zLnN0YXRpYykge1xuICAgICAgICB0aGlzLmhpZGUoKTtcbiAgICAgIH1cbiAgICB9KTtcblxuICAgIC8vIEJhY2tkcm9wIGNsaWNrXG4gICAgaWYgKHRoaXMub3B0aW9ucy5iYWNrZHJvcCkge1xuICAgICAgdGhpcy5vbignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgICBpZiAoZS50YXJnZXQgPT09IHRoaXMuZWxlbWVudCkge1xuICAgICAgICAgIGlmICh0aGlzLm9wdGlvbnMuc3RhdGljKSB7XG4gICAgICAgICAgICAvLyBTaGFrZSBhbmltYXRpb24gZm9yIHN0YXRpYyBtb2RhbFxuICAgICAgICAgICAgdGhpcy5fc2hha2VNb2RhbCgpO1xuICAgICAgICAgIH0gZWxzZSBpZiAodGhpcy5vcHRpb25zLmNsb3NhYmxlKSB7XG4gICAgICAgICAgICB0aGlzLmhpZGUoKTtcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH0pO1xuICAgIH1cblxuICAgIC8vIE5vdGU6IEtleWJvYXJkIGV2ZW50cyBhcmUgYm91bmQgdG8gZG9jdW1lbnQgaW4gc2hvdygpIGFuZCB1bmJvdW5kIGluIGhpZGUoKVxuXG4gICAgLy8gQ29uZmlybS9DYW5jZWwgYnV0dG9uc1xuICAgIHRoaXMuZGVsZWdhdGUoJ2NsaWNrJywgJ1tkYXRhLW1vZGFsLWNvbmZpcm1dJywgKCkgPT4ge1xuICAgICAgdGhpcy5lbWl0KFNPTW9kYWwuRVZFTlRTLkNPTkZJUk0pO1xuICAgICAgdGhpcy5oaWRlKCk7XG4gICAgfSk7XG5cbiAgICB0aGlzLmRlbGVnYXRlKCdjbGljaycsICdbZGF0YS1tb2RhbC1jYW5jZWxdJywgKCkgPT4ge1xuICAgICAgdGhpcy5lbWl0KFNPTW9kYWwuRVZFTlRTLkNBTkNFTCk7XG4gICAgICB0aGlzLmhpZGUoKTtcbiAgICB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBTaGFrZSB0aGUgbW9kYWwgdG8gaW5kaWNhdGUgaXQgY2Fubm90IGJlIGRpc21pc3NlZFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3NoYWtlTW9kYWwoKSB7XG4gICAgdGhpcy5fcGxheUZlZWRiYWNrQW5pbWF0aW9uKCdzaGFrZScpO1xuICB9XG5cbiAgLyoqXG4gICAqIFBsYXkgYSBmZWVkYmFjayBhbmltYXRpb24gb24gdGhlIG1vZGFsXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB0eXBlIC0gQW5pbWF0aW9uIHR5cGU6ICdzaGFrZScsICdwdWxzZScsICdib3VuY2UnLCAnaGVhZHNoYWtlJ1xuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3BsYXlGZWVkYmFja0FuaW1hdGlvbih0eXBlID0gJ3NoYWtlJykge1xuICAgIGNvbnN0IGFuaW1hdGlvbkNsYXNzID0gYHNvLW1vZGFsLWZlZWRiYWNrLSR7dHlwZX1gO1xuICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QuYWRkKGFuaW1hdGlvbkNsYXNzKTtcbiAgICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKGFuaW1hdGlvbkNsYXNzKTtcbiAgICB9LCA1MDApO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gRFJBR0dBQkxFIEZVTkNUSU9OQUxJVFlcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogU2V0dXAgZHJhZ2dhYmxlIGZ1bmN0aW9uYWxpdHlcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9zZXR1cERyYWdnYWJsZSgpIHtcbiAgICBpZiAoIXRoaXMuX2hlYWRlciB8fCAhdGhpcy5fZGlhbG9nKSByZXR1cm47XG5cbiAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LmFkZCgnc28tbW9kYWwtZHJhZ2dhYmxlJyk7XG4gICAgdGhpcy5faGVhZGVyLnN0eWxlLmN1cnNvciA9ICdtb3ZlJztcblxuICAgIC8vIEJpbmQgZHJhZyBoYW5kbGVyc1xuICAgIHRoaXMuX2JvdW5kRHJhZ1N0YXJ0ID0gdGhpcy5faGFuZGxlRHJhZ1N0YXJ0LmJpbmQodGhpcyk7XG4gICAgdGhpcy5fYm91bmREcmFnTW92ZSA9IHRoaXMuX2hhbmRsZURyYWdNb3ZlLmJpbmQodGhpcyk7XG4gICAgdGhpcy5fYm91bmREcmFnRW5kID0gdGhpcy5faGFuZGxlRHJhZ0VuZC5iaW5kKHRoaXMpO1xuXG4gICAgdGhpcy5faGVhZGVyLmFkZEV2ZW50TGlzdGVuZXIoJ21vdXNlZG93bicsIHRoaXMuX2JvdW5kRHJhZ1N0YXJ0KTtcbiAgICB0aGlzLl9oZWFkZXIuYWRkRXZlbnRMaXN0ZW5lcigndG91Y2hzdGFydCcsIHRoaXMuX2JvdW5kRHJhZ1N0YXJ0LCB7IHBhc3NpdmU6IGZhbHNlIH0pO1xuICB9XG5cbiAgLyoqXG4gICAqIEhhbmRsZSBkcmFnIHN0YXJ0XG4gICAqIEBwYXJhbSB7TW91c2VFdmVudHxUb3VjaEV2ZW50fSBlXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlRHJhZ1N0YXJ0KGUpIHtcbiAgICAvLyBEb24ndCBkcmFnIGlmIGNsaWNraW5nIG9uIGJ1dHRvbnMgb3IgY2xvc2UgaWNvblxuICAgIGlmIChlLnRhcmdldC5jbG9zZXN0KCdidXR0b24sIC5zby1tb2RhbC1jbG9zZSwgLnNvLW1vZGFsLW1heGltaXplJykpIHJldHVybjtcbiAgICAvLyBEb24ndCBkcmFnIGlmIG1heGltaXplZFxuICAgIGlmICh0aGlzLl9pc01heGltaXplZCkgcmV0dXJuO1xuXG4gICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgIHRoaXMuX2lzRHJhZ2dpbmcgPSB0cnVlO1xuXG4gICAgY29uc3QgY2xpZW50WCA9IGUudHlwZS5pbmNsdWRlcygndG91Y2gnKSA/IGUudG91Y2hlc1swXS5jbGllbnRYIDogZS5jbGllbnRYO1xuICAgIGNvbnN0IGNsaWVudFkgPSBlLnR5cGUuaW5jbHVkZXMoJ3RvdWNoJykgPyBlLnRvdWNoZXNbMF0uY2xpZW50WSA6IGUuY2xpZW50WTtcblxuICAgIGNvbnN0IHJlY3QgPSB0aGlzLl9kaWFsb2cuZ2V0Qm91bmRpbmdDbGllbnRSZWN0KCk7XG4gICAgdGhpcy5fZHJhZ09mZnNldCA9IHtcbiAgICAgIHg6IGNsaWVudFggLSByZWN0LmxlZnQsXG4gICAgICB5OiBjbGllbnRZIC0gcmVjdC50b3BcbiAgICB9O1xuXG4gICAgLy8gU3RvcmUgaW5pdGlhbCBwb3NpdGlvbiBpZiBub3QgYWxyZWFkeSBkcmFnZ2VkXG4gICAgaWYgKCF0aGlzLl9kcmFnUG9zaXRpb24ueCAmJiAhdGhpcy5fZHJhZ1Bvc2l0aW9uLnkpIHtcbiAgICAgIHRoaXMuX2RyYWdQb3NpdGlvbiA9IHtcbiAgICAgICAgeDogcmVjdC5sZWZ0LFxuICAgICAgICB5OiByZWN0LnRvcFxuICAgICAgfTtcbiAgICB9XG5cbiAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LmFkZCgnc28tbW9kYWwtZHJhZ2dpbmcnKTtcbiAgICB0aGlzLmVtaXQoU09Nb2RhbC5FVkVOVFMuRFJBR19TVEFSVCk7XG5cbiAgICAvLyBBZGQgbW92ZS9lbmQgbGlzdGVuZXJzIHRvIGRvY3VtZW50XG4gICAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignbW91c2Vtb3ZlJywgdGhpcy5fYm91bmREcmFnTW92ZSk7XG4gICAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignbW91c2V1cCcsIHRoaXMuX2JvdW5kRHJhZ0VuZCk7XG4gICAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcigndG91Y2htb3ZlJywgdGhpcy5fYm91bmREcmFnTW92ZSwgeyBwYXNzaXZlOiBmYWxzZSB9KTtcbiAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCd0b3VjaGVuZCcsIHRoaXMuX2JvdW5kRHJhZ0VuZCk7XG4gIH1cblxuICAvKipcbiAgICogSGFuZGxlIGRyYWcgbW92ZVxuICAgKiBAcGFyYW0ge01vdXNlRXZlbnR8VG91Y2hFdmVudH0gZVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2hhbmRsZURyYWdNb3ZlKGUpIHtcbiAgICBpZiAoIXRoaXMuX2lzRHJhZ2dpbmcpIHJldHVybjtcbiAgICBlLnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICBjb25zdCBjbGllbnRYID0gZS50eXBlLmluY2x1ZGVzKCd0b3VjaCcpID8gZS50b3VjaGVzWzBdLmNsaWVudFggOiBlLmNsaWVudFg7XG4gICAgY29uc3QgY2xpZW50WSA9IGUudHlwZS5pbmNsdWRlcygndG91Y2gnKSA/IGUudG91Y2hlc1swXS5jbGllbnRZIDogZS5jbGllbnRZO1xuXG4gICAgbGV0IG5ld1ggPSBjbGllbnRYIC0gdGhpcy5fZHJhZ09mZnNldC54O1xuICAgIGxldCBuZXdZID0gY2xpZW50WSAtIHRoaXMuX2RyYWdPZmZzZXQueTtcblxuICAgIC8vIENvbnN0cmFpbiB0byB2aWV3cG9ydFxuICAgIGNvbnN0IGRpYWxvZ1JlY3QgPSB0aGlzLl9kaWFsb2cuZ2V0Qm91bmRpbmdDbGllbnRSZWN0KCk7XG4gICAgY29uc3QgbWF4WCA9IHdpbmRvdy5pbm5lcldpZHRoIC0gZGlhbG9nUmVjdC53aWR0aDtcbiAgICBjb25zdCBtYXhZID0gd2luZG93LmlubmVySGVpZ2h0IC0gZGlhbG9nUmVjdC5oZWlnaHQ7XG5cbiAgICBuZXdYID0gTWF0aC5tYXgoMCwgTWF0aC5taW4obmV3WCwgbWF4WCkpO1xuICAgIG5ld1kgPSBNYXRoLm1heCgwLCBNYXRoLm1pbihuZXdZLCBtYXhZKSk7XG5cbiAgICB0aGlzLl9kcmFnUG9zaXRpb24gPSB7IHg6IG5ld1gsIHk6IG5ld1kgfTtcbiAgICB0aGlzLl9kaWFsb2cuc3R5bGUucG9zaXRpb24gPSAnZml4ZWQnO1xuICAgIHRoaXMuX2RpYWxvZy5zdHlsZS5tYXJnaW4gPSAnMCc7XG4gICAgdGhpcy5fZGlhbG9nLnN0eWxlLmxlZnQgPSBgJHtuZXdYfXB4YDtcbiAgICB0aGlzLl9kaWFsb2cuc3R5bGUudG9wID0gYCR7bmV3WX1weGA7XG4gICAgdGhpcy5fZGlhbG9nLnN0eWxlLnRyYW5zZm9ybSA9ICdub25lJztcbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUgZHJhZyBlbmRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVEcmFnRW5kKCkge1xuICAgIGlmICghdGhpcy5faXNEcmFnZ2luZykgcmV0dXJuO1xuXG4gICAgdGhpcy5faXNEcmFnZ2luZyA9IGZhbHNlO1xuICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKCdzby1tb2RhbC1kcmFnZ2luZycpO1xuICAgIHRoaXMuZW1pdChTT01vZGFsLkVWRU5UUy5EUkFHX0VORCk7XG5cbiAgICAvLyBSZW1vdmUgbW92ZS9lbmQgbGlzdGVuZXJzXG4gICAgZG9jdW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcignbW91c2Vtb3ZlJywgdGhpcy5fYm91bmREcmFnTW92ZSk7XG4gICAgZG9jdW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcignbW91c2V1cCcsIHRoaXMuX2JvdW5kRHJhZ0VuZCk7XG4gICAgZG9jdW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcigndG91Y2htb3ZlJywgdGhpcy5fYm91bmREcmFnTW92ZSk7XG4gICAgZG9jdW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcigndG91Y2hlbmQnLCB0aGlzLl9ib3VuZERyYWdFbmQpO1xuICB9XG5cbiAgLyoqXG4gICAqIFJlc2V0IGRyYWcgcG9zaXRpb25cbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9yZXNldERyYWdQb3NpdGlvbigpIHtcbiAgICBpZiAodGhpcy5fZGlhbG9nKSB7XG4gICAgICB0aGlzLl9kaWFsb2cuc3R5bGUucG9zaXRpb24gPSAnJztcbiAgICAgIHRoaXMuX2RpYWxvZy5zdHlsZS5sZWZ0ID0gJyc7XG4gICAgICB0aGlzLl9kaWFsb2cuc3R5bGUudG9wID0gJyc7XG4gICAgICB0aGlzLl9kaWFsb2cuc3R5bGUubWFyZ2luID0gJyc7XG4gICAgICB0aGlzLl9kaWFsb2cuc3R5bGUudHJhbnNmb3JtID0gJyc7XG4gICAgfVxuICAgIHRoaXMuX2RyYWdQb3NpdGlvbiA9IHsgeDogMCwgeTogMCB9O1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gTUFYSU1JWkFCTEUgRlVOQ1RJT05BTElUWVxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBTZXR1cCBtYXhpbWl6YWJsZSBmdW5jdGlvbmFsaXR5XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfc2V0dXBNYXhpbWl6YWJsZSgpIHtcbiAgICBpZiAoIXRoaXMuX2hlYWRlcikgcmV0dXJuO1xuXG4gICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5hZGQoJ3NvLW1vZGFsLW1heGltaXphYmxlJyk7XG5cbiAgICAvLyBDaGVjayBpZiBtYXhpbWl6ZSBidXR0b24gYWxyZWFkeSBleGlzdHMgKGUuZy4sIGZyb20gU09Nb2RhbC5jcmVhdGUoKSlcbiAgICB0aGlzLl9tYXhpbWl6ZUJ0biA9IHRoaXMuX2hlYWRlci5xdWVyeVNlbGVjdG9yKCcuc28tbW9kYWwtbWF4aW1pemUnKTtcblxuICAgIC8vIENyZWF0ZSBtYXhpbWl6ZSBidXR0b24gb25seSBpZiBpdCBkb2Vzbid0IGV4aXN0XG4gICAgaWYgKCF0aGlzLl9tYXhpbWl6ZUJ0bikge1xuICAgICAgdGhpcy5fbWF4aW1pemVCdG4gPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdidXR0b24nKTtcbiAgICAgIHRoaXMuX21heGltaXplQnRuLnR5cGUgPSAnYnV0dG9uJztcbiAgICAgIHRoaXMuX21heGltaXplQnRuLmNsYXNzTmFtZSA9ICdzby1tb2RhbC1tYXhpbWl6ZSc7XG4gICAgICB0aGlzLl9tYXhpbWl6ZUJ0bi5pbm5lckhUTUwgPSAnPHNwYW4gY2xhc3M9XCJtYXRlcmlhbC1pY29uc1wiPm9wZW5faW5fZnVsbDwvc3Bhbj4nO1xuICAgICAgdGhpcy5fbWF4aW1pemVCdG4udGl0bGUgPSAnTWF4aW1pemUnO1xuXG4gICAgICAvLyBJbnNlcnQgYmVmb3JlIGNsb3NlIGJ1dHRvbiBvciBhdCBlbmQgb2YgaGVhZGVyXG4gICAgICBjb25zdCBjbG9zZUJ0biA9IHRoaXMuX2hlYWRlci5xdWVyeVNlbGVjdG9yKCcuc28tbW9kYWwtY2xvc2UnKTtcbiAgICAgIGlmIChjbG9zZUJ0bikge1xuICAgICAgICBjbG9zZUJ0bi5wYXJlbnROb2RlLmluc2VydEJlZm9yZSh0aGlzLl9tYXhpbWl6ZUJ0biwgY2xvc2VCdG4pO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgdGhpcy5faGVhZGVyLmFwcGVuZENoaWxkKHRoaXMuX21heGltaXplQnRuKTtcbiAgICAgIH1cbiAgICB9XG5cbiAgICAvLyBCaW5kIGNsaWNrIGhhbmRsZXJcbiAgICB0aGlzLl9tYXhpbWl6ZUJ0bi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsICgpID0+IHRoaXMudG9nZ2xlTWF4aW1pemUoKSk7XG5cbiAgICAvLyBEb3VibGUtY2xpY2sgaGVhZGVyIHRvIG1heGltaXplIChpZiBkcmFnZ2FibGUpXG4gICAgaWYgKHRoaXMub3B0aW9ucy5kcmFnZ2FibGUpIHtcbiAgICAgIHRoaXMuX2hlYWRlci5hZGRFdmVudExpc3RlbmVyKCdkYmxjbGljaycsIChlKSA9PiB7XG4gICAgICAgIGlmICghZS50YXJnZXQuY2xvc2VzdCgnYnV0dG9uLCAuc28tbW9kYWwtY2xvc2UsIC5zby1tb2RhbC1tYXhpbWl6ZScpKSB7XG4gICAgICAgICAgdGhpcy50b2dnbGVNYXhpbWl6ZSgpO1xuICAgICAgICB9XG4gICAgICB9KTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogTWF4aW1pemUgdGhlIG1vZGFsXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIG1heGltaXplKCkge1xuICAgIGlmICh0aGlzLl9pc01heGltaXplZCkgcmV0dXJuIHRoaXM7XG5cbiAgICAvLyBTdG9yZSBvcmlnaW5hbCBwb3NpdGlvbi9zaXplIGZvciByZXN0b3JlXG4gICAgdGhpcy5fb3JpZ2luYWxTaXplID0ge1xuICAgICAgd2lkdGg6IHRoaXMuX2RpYWxvZy5zdHlsZS53aWR0aCxcbiAgICAgIGhlaWdodDogdGhpcy5fZGlhbG9nLnN0eWxlLmhlaWdodCxcbiAgICAgIG1heFdpZHRoOiB0aGlzLl9kaWFsb2cuc3R5bGUubWF4V2lkdGgsXG4gICAgICBtYXhIZWlnaHQ6IHRoaXMuX2RpYWxvZy5zdHlsZS5tYXhIZWlnaHQsXG4gICAgICBwb3NpdGlvbjogdGhpcy5fZGlhbG9nLnN0eWxlLnBvc2l0aW9uLFxuICAgICAgbGVmdDogdGhpcy5fZGlhbG9nLnN0eWxlLmxlZnQsXG4gICAgICB0b3A6IHRoaXMuX2RpYWxvZy5zdHlsZS50b3AsXG4gICAgICB0cmFuc2Zvcm06IHRoaXMuX2RpYWxvZy5zdHlsZS50cmFuc2Zvcm0sXG4gICAgICBtYXJnaW46IHRoaXMuX2RpYWxvZy5zdHlsZS5tYXJnaW4sXG4gICAgICBib3JkZXJSYWRpdXM6IHRoaXMuX2RpYWxvZy5zdHlsZS5ib3JkZXJSYWRpdXMsXG4gICAgICBkcmFnUG9zaXRpb246IHsgLi4udGhpcy5fZHJhZ1Bvc2l0aW9uIH1cbiAgICB9O1xuXG4gICAgdGhpcy5faXNNYXhpbWl6ZWQgPSB0cnVlO1xuICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QuYWRkKCdzby1tb2RhbC1tYXhpbWl6ZWQnKTtcblxuICAgIC8vIEFwcGx5IG1heGltaXplZCBzdHlsZXNcbiAgICB0aGlzLl9kaWFsb2cuc3R5bGUud2lkdGggPSAnMTAwJSc7XG4gICAgdGhpcy5fZGlhbG9nLnN0eWxlLmhlaWdodCA9ICcxMDAlJztcbiAgICB0aGlzLl9kaWFsb2cuc3R5bGUubWF4V2lkdGggPSAnMTAwJSc7XG4gICAgdGhpcy5fZGlhbG9nLnN0eWxlLm1heEhlaWdodCA9ICcxMDAlJztcbiAgICB0aGlzLl9kaWFsb2cuc3R5bGUucG9zaXRpb24gPSAnZml4ZWQnO1xuICAgIHRoaXMuX2RpYWxvZy5zdHlsZS5sZWZ0ID0gJzAnO1xuICAgIHRoaXMuX2RpYWxvZy5zdHlsZS50b3AgPSAnMCc7XG4gICAgdGhpcy5fZGlhbG9nLnN0eWxlLnRyYW5zZm9ybSA9ICdub25lJztcbiAgICB0aGlzLl9kaWFsb2cuc3R5bGUubWFyZ2luID0gJzAnO1xuICAgIHRoaXMuX2RpYWxvZy5zdHlsZS5ib3JkZXJSYWRpdXMgPSAnMCc7XG5cbiAgICAvLyBVcGRhdGUgbWF4aW1pemUgYnV0dG9uIGljb25cbiAgICBpZiAodGhpcy5fbWF4aW1pemVCdG4pIHtcbiAgICAgIHRoaXMuX21heGltaXplQnRuLmlubmVySFRNTCA9ICc8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+Y2xvc2VfZnVsbHNjcmVlbjwvc3Bhbj4nO1xuICAgICAgdGhpcy5fbWF4aW1pemVCdG4udGl0bGUgPSAnUmVzdG9yZSc7XG4gICAgfVxuXG4gICAgLy8gVXBkYXRlIGhlYWRlciBjdXJzb3JcbiAgICBpZiAodGhpcy5faGVhZGVyICYmIHRoaXMub3B0aW9ucy5kcmFnZ2FibGUpIHtcbiAgICAgIHRoaXMuX2hlYWRlci5zdHlsZS5jdXJzb3IgPSAnZGVmYXVsdCc7XG4gICAgfVxuXG4gICAgdGhpcy5lbWl0KFNPTW9kYWwuRVZFTlRTLk1BWElNSVpFKTtcbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBSZXN0b3JlIHRoZSBtb2RhbCBmcm9tIG1heGltaXplZCBzdGF0ZVxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICByZXN0b3JlKCkge1xuICAgIGlmICghdGhpcy5faXNNYXhpbWl6ZWQpIHJldHVybiB0aGlzO1xuXG4gICAgdGhpcy5faXNNYXhpbWl6ZWQgPSBmYWxzZTtcbiAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZSgnc28tbW9kYWwtbWF4aW1pemVkJyk7XG5cbiAgICAvLyBSZXN0b3JlIG9yaWdpbmFsIHN0eWxlc1xuICAgIGlmICh0aGlzLl9vcmlnaW5hbFNpemUpIHtcbiAgICAgIHRoaXMuX2RpYWxvZy5zdHlsZS53aWR0aCA9IHRoaXMuX29yaWdpbmFsU2l6ZS53aWR0aDtcbiAgICAgIHRoaXMuX2RpYWxvZy5zdHlsZS5oZWlnaHQgPSB0aGlzLl9vcmlnaW5hbFNpemUuaGVpZ2h0O1xuICAgICAgdGhpcy5fZGlhbG9nLnN0eWxlLm1heFdpZHRoID0gdGhpcy5fb3JpZ2luYWxTaXplLm1heFdpZHRoO1xuICAgICAgdGhpcy5fZGlhbG9nLnN0eWxlLm1heEhlaWdodCA9IHRoaXMuX29yaWdpbmFsU2l6ZS5tYXhIZWlnaHQ7XG4gICAgICB0aGlzLl9kaWFsb2cuc3R5bGUucG9zaXRpb24gPSB0aGlzLl9vcmlnaW5hbFNpemUucG9zaXRpb247XG4gICAgICB0aGlzLl9kaWFsb2cuc3R5bGUubGVmdCA9IHRoaXMuX29yaWdpbmFsU2l6ZS5sZWZ0O1xuICAgICAgdGhpcy5fZGlhbG9nLnN0eWxlLnRvcCA9IHRoaXMuX29yaWdpbmFsU2l6ZS50b3A7XG4gICAgICB0aGlzLl9kaWFsb2cuc3R5bGUudHJhbnNmb3JtID0gdGhpcy5fb3JpZ2luYWxTaXplLnRyYW5zZm9ybTtcbiAgICAgIHRoaXMuX2RpYWxvZy5zdHlsZS5tYXJnaW4gPSB0aGlzLl9vcmlnaW5hbFNpemUubWFyZ2luO1xuICAgICAgdGhpcy5fZGlhbG9nLnN0eWxlLmJvcmRlclJhZGl1cyA9IHRoaXMuX29yaWdpbmFsU2l6ZS5ib3JkZXJSYWRpdXM7XG4gICAgICB0aGlzLl9kcmFnUG9zaXRpb24gPSB0aGlzLl9vcmlnaW5hbFNpemUuZHJhZ1Bvc2l0aW9uO1xuICAgIH1cblxuICAgIC8vIFVwZGF0ZSBtYXhpbWl6ZSBidXR0b24gaWNvblxuICAgIGlmICh0aGlzLl9tYXhpbWl6ZUJ0bikge1xuICAgICAgdGhpcy5fbWF4aW1pemVCdG4uaW5uZXJIVE1MID0gJzxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnNcIj5vcGVuX2luX2Z1bGw8L3NwYW4+JztcbiAgICAgIHRoaXMuX21heGltaXplQnRuLnRpdGxlID0gJ01heGltaXplJztcbiAgICB9XG5cbiAgICAvLyBSZXN0b3JlIGhlYWRlciBjdXJzb3JcbiAgICBpZiAodGhpcy5faGVhZGVyICYmIHRoaXMub3B0aW9ucy5kcmFnZ2FibGUpIHtcbiAgICAgIHRoaXMuX2hlYWRlci5zdHlsZS5jdXJzb3IgPSAnbW92ZSc7XG4gICAgfVxuXG4gICAgdGhpcy5lbWl0KFNPTW9kYWwuRVZFTlRTLlJFU1RPUkUpO1xuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFRvZ2dsZSBiZXR3ZWVuIG1heGltaXplZCBhbmQgbm9ybWFsIHN0YXRlXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHRvZ2dsZU1heGltaXplKCkge1xuICAgIHJldHVybiB0aGlzLl9pc01heGltaXplZCA/IHRoaXMucmVzdG9yZSgpIDogdGhpcy5tYXhpbWl6ZSgpO1xuICB9XG5cbiAgLyoqXG4gICAqIENoZWNrIGlmIG1vZGFsIGlzIG1heGltaXplZFxuICAgKiBAcmV0dXJucyB7Ym9vbGVhbn1cbiAgICovXG4gIGlzTWF4aW1pemVkKCkge1xuICAgIHJldHVybiB0aGlzLl9pc01heGltaXplZDtcbiAgfVxuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIE1PQklMRSBGVUxMU0NSRUVOXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIFNldHVwIG1vYmlsZSBmdWxsc2NyZWVuIGF1dG8tc3dpdGNoXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfc2V0dXBNb2JpbGVGdWxsc2NyZWVuKCkge1xuICAgIHRoaXMuX2NoZWNrTW9iaWxlRnVsbHNjcmVlbiA9ICgpID0+IHtcbiAgICAgIGNvbnN0IGlzTW9iaWxlID0gd2luZG93LmlubmVyV2lkdGggPCB0aGlzLm9wdGlvbnMubW9iaWxlQnJlYWtwb2ludDtcblxuICAgICAgaWYgKGlzTW9iaWxlICYmIHRoaXMuX2lzT3BlbiAmJiAhdGhpcy5faXNNYXhpbWl6ZWQpIHtcbiAgICAgICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5hZGQoJ3NvLW1vZGFsLW1vYmlsZS1mdWxsc2NyZWVuJyk7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZSgnc28tbW9kYWwtbW9iaWxlLWZ1bGxzY3JlZW4nKTtcbiAgICAgIH1cbiAgICB9O1xuXG4gICAgLy8gQ2hlY2sgb24gcmVzaXplXG4gICAgdGhpcy5fcmVzaXplT2JzZXJ2ZXIgPSBuZXcgUmVzaXplT2JzZXJ2ZXIoKCkgPT4ge1xuICAgICAgdGhpcy5fY2hlY2tNb2JpbGVGdWxsc2NyZWVuKCk7XG4gICAgfSk7XG4gICAgdGhpcy5fcmVzaXplT2JzZXJ2ZXIub2JzZXJ2ZShkb2N1bWVudC5ib2R5KTtcblxuICAgIC8vIEluaXRpYWwgY2hlY2tcbiAgICB0aGlzLl9jaGVja01vYmlsZUZ1bGxzY3JlZW4oKTtcbiAgfVxuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIFNJREVCQVIgTEFZT1VUXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIFNldHVwIHNpZGViYXIgbGF5b3V0XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfc2V0dXBTaWRlYmFyKCkge1xuICAgIGNvbnN0IHBvc2l0aW9uID0gdGhpcy5vcHRpb25zLnNpZGViYXIgPT09IHRydWUgPyAnbGVmdCcgOiB0aGlzLm9wdGlvbnMuc2lkZWJhcjtcblxuICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QuYWRkKCdzby1tb2RhbC13aXRoLXNpZGViYXInKTtcbiAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LmFkZChgc28tbW9kYWwtc2lkZWJhci0ke3Bvc2l0aW9ufWApO1xuXG4gICAgLy8gU2V0IHNpZGViYXIgd2lkdGggYXMgQ1NTIHZhcmlhYmxlXG4gICAgaWYgKHRoaXMub3B0aW9ucy5zaWRlYmFyV2lkdGgpIHtcbiAgICAgIHRoaXMuX2RpYWxvZy5zdHlsZS5zZXRQcm9wZXJ0eSgnLS1zby1tb2RhbC1zaWRlYmFyLXdpZHRoJywgdGhpcy5vcHRpb25zLnNpZGViYXJXaWR0aCk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIEZvY3VzIHRoZSBpbml0aWFsIGVsZW1lbnQgYmFzZWQgb24gZm9jdXNFbGVtZW50IG9wdGlvblxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2ZvY3VzSW5pdGlhbEVsZW1lbnQoKSB7XG4gICAgaWYgKCF0aGlzLm9wdGlvbnMuZm9jdXMpIHJldHVybjtcblxuICAgIGNvbnN0IGZvY3VzT3B0aW9uID0gdGhpcy5vcHRpb25zLmZvY3VzRWxlbWVudDtcbiAgICBsZXQgZWxlbWVudFRvRm9jdXMgPSBudWxsO1xuXG4gICAgaWYgKGZvY3VzT3B0aW9uID09PSAnZm9vdGVyJykge1xuICAgICAgLy8gRm9jdXMgZmlyc3QgYnV0dG9uIGluIGZvb3RlclxuICAgICAgY29uc3QgZm9vdGVyID0gdGhpcy4kKCcuc28tbW9kYWwtZm9vdGVyJyk7XG4gICAgICBpZiAoZm9vdGVyKSB7XG4gICAgICAgIGVsZW1lbnRUb0ZvY3VzID0gZm9vdGVyLnF1ZXJ5U2VsZWN0b3IoJ2J1dHRvbiwgW3RhYmluZGV4XTpub3QoW3RhYmluZGV4PVwiLTFcIl0pLCBhW2hyZWZdJyk7XG4gICAgICB9XG4gICAgICAvLyBGYWxsYmFjayB0byBjbG9zZSBidXR0b24gaWYgbm8gZm9vdGVyIGJ1dHRvblxuICAgICAgaWYgKCFlbGVtZW50VG9Gb2N1cykge1xuICAgICAgICBlbGVtZW50VG9Gb2N1cyA9IHRoaXMuJCgnLnNvLW1vZGFsLWNsb3NlJyk7XG4gICAgICB9XG4gICAgfSBlbHNlIGlmIChmb2N1c09wdGlvbiA9PT0gJ2Nsb3NlJykge1xuICAgICAgLy8gRm9jdXMgY2xvc2UgYnV0dG9uXG4gICAgICBlbGVtZW50VG9Gb2N1cyA9IHRoaXMuJCgnLnNvLW1vZGFsLWNsb3NlJyk7XG4gICAgfSBlbHNlIGlmIChmb2N1c09wdGlvbiA9PT0gJ2ZpcnN0Jykge1xuICAgICAgLy8gRm9jdXMgZmlyc3QgZm9jdXNhYmxlIGVsZW1lbnQgKG9yaWdpbmFsIGJlaGF2aW9yKVxuICAgICAgY29uc3QgZm9jdXNhYmxlRWxlbWVudHMgPSB0aGlzLmdldEZvY3VzYWJsZUVsZW1lbnRzKCk7XG4gICAgICBlbGVtZW50VG9Gb2N1cyA9IGZvY3VzYWJsZUVsZW1lbnRzWzBdO1xuICAgIH0gZWxzZSBpZiAodHlwZW9mIGZvY3VzT3B0aW9uID09PSAnc3RyaW5nJyAmJiBmb2N1c09wdGlvbikge1xuICAgICAgLy8gQ1NTIHNlbGVjdG9yXG4gICAgICBlbGVtZW50VG9Gb2N1cyA9IHRoaXMuJChmb2N1c09wdGlvbik7XG4gICAgfVxuXG4gICAgLy8gRmFsbGJhY2sgdG8gZmlyc3QgZm9jdXNhYmxlIGVsZW1lbnRcbiAgICBpZiAoIWVsZW1lbnRUb0ZvY3VzKSB7XG4gICAgICBjb25zdCBmb2N1c2FibGVFbGVtZW50cyA9IHRoaXMuZ2V0Rm9jdXNhYmxlRWxlbWVudHMoKTtcbiAgICAgIGVsZW1lbnRUb0ZvY3VzID0gZm9jdXNhYmxlRWxlbWVudHNbMF07XG4gICAgfVxuXG4gICAgaWYgKGVsZW1lbnRUb0ZvY3VzICYmIHR5cGVvZiBlbGVtZW50VG9Gb2N1cy5mb2N1cyA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgLy8gQWRkIGNsYXNzIHRvIHNob3cgZm9jdXMgcmluZyAoc2luY2UgOmZvY3VzLXZpc2libGUgZG9lc24ndCB3b3JrIGZvciBwcm9ncmFtbWF0aWMgZm9jdXMpXG4gICAgICBlbGVtZW50VG9Gb2N1cy5jbGFzc0xpc3QuYWRkKCdzby1mb2N1cy12aXNpYmxlJyk7XG4gICAgICBlbGVtZW50VG9Gb2N1cy5hZGRFdmVudExpc3RlbmVyKCdibHVyJywgKCkgPT4ge1xuICAgICAgICBlbGVtZW50VG9Gb2N1cy5jbGFzc0xpc3QucmVtb3ZlKCdzby1mb2N1cy12aXNpYmxlJyk7XG4gICAgICB9LCB7IG9uY2U6IHRydWUgfSk7XG4gICAgICBlbGVtZW50VG9Gb2N1cy5mb2N1cygpO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUga2V5Ym9hcmQgZXZlbnRzXG4gICAqIEBwYXJhbSB7S2V5Ym9hcmRFdmVudH0gZSAtIEtleWJvYXJkIGV2ZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlS2V5ZG93bihlKSB7XG4gICAgLy8gT25seSBoYW5kbGUgaWYgdGhpcyBpcyB0aGUgdG9wbW9zdCBtb2RhbFxuICAgIGlmIChlLmtleSA9PT0gJ0VzY2FwZScgJiYgdGhpcy5faXNPcGVuKSB7XG4gICAgICBjb25zdCBvcGVuTW9kYWxzID0gU09Nb2RhbC5fb3Blbk1vZGFscztcbiAgICAgIGlmIChvcGVuTW9kYWxzLmxlbmd0aCA+IDAgJiYgb3Blbk1vZGFsc1tvcGVuTW9kYWxzLmxlbmd0aCAtIDFdID09PSB0aGlzKSB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgaWYgKHRoaXMub3B0aW9ucy5zdGF0aWMpIHtcbiAgICAgICAgICAvLyBTaGFrZSBhbmltYXRpb24gZm9yIHN0YXRpYyBtb2RhbFxuICAgICAgICAgIHRoaXMuX3NoYWtlTW9kYWwoKTtcbiAgICAgICAgfSBlbHNlIGlmICh0aGlzLm9wdGlvbnMuY2xvc2FibGUpIHtcbiAgICAgICAgICB0aGlzLmhpZGUoKTtcbiAgICAgICAgfVxuICAgICAgfVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBCaW5kIGRvY3VtZW50IGtleWJvYXJkIGxpc3RlbmVyXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfYmluZERvY3VtZW50S2V5ZG93bigpIHtcbiAgICBpZiAoIXRoaXMub3B0aW9ucy5rZXlib2FyZCkgcmV0dXJuO1xuICAgIHRoaXMuX2JvdW5kS2V5ZG93biA9IHRoaXMuX2hhbmRsZUtleWRvd24uYmluZCh0aGlzKTtcbiAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdrZXlkb3duJywgdGhpcy5fYm91bmRLZXlkb3duKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBVbmJpbmQgZG9jdW1lbnQga2V5Ym9hcmQgbGlzdGVuZXJcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF91bmJpbmREb2N1bWVudEtleWRvd24oKSB7XG4gICAgaWYgKHRoaXMuX2JvdW5kS2V5ZG93bikge1xuICAgICAgZG9jdW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcigna2V5ZG93bicsIHRoaXMuX2JvdW5kS2V5ZG93bik7XG4gICAgICB0aGlzLl9ib3VuZEtleWRvd24gPSBudWxsO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBDcmVhdGUgYW5kIHNob3cgYmFja2Ryb3BcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9zaG93QmFja2Ryb3AoKSB7XG4gICAgaWYgKCF0aGlzLm9wdGlvbnMuYmFja2Ryb3ApIHJldHVybjtcblxuICAgIHRoaXMuX2JhY2tkcm9wID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XG4gICAgdGhpcy5fYmFja2Ryb3AuY2xhc3NOYW1lID0gJ3NvLW1vZGFsLWJhY2tkcm9wJztcblxuICAgIGlmICh0aGlzLm9wdGlvbnMuYW5pbWF0aW9uKSB7XG4gICAgICB0aGlzLl9iYWNrZHJvcC5jbGFzc0xpc3QuYWRkKCdzby1mYWRlJyk7XG4gICAgfVxuXG4gICAgLy8gU2V0IHotaW5kZXggZm9yIHN0YWNrZWQgbW9kYWxzXG4gICAgY29uc3QgbW9kYWxJbmRleCA9IFNPTW9kYWwuX29wZW5Nb2RhbHMuaW5kZXhPZih0aGlzKTtcbiAgICBpZiAobW9kYWxJbmRleCA+IDApIHtcbiAgICAgIHRoaXMuX2JhY2tkcm9wLnN0eWxlLnpJbmRleCA9IFNPTW9kYWwuX2Jhc2VaSW5kZXggKyAobW9kYWxJbmRleCAqIDEwKSAtIDE7XG4gICAgfVxuXG4gICAgZG9jdW1lbnQuYm9keS5hcHBlbmRDaGlsZCh0aGlzLl9iYWNrZHJvcCk7XG5cbiAgICAvLyBGb3JjZSByZWZsb3cgZm9yIGFuaW1hdGlvblxuICAgIHRoaXMuX2JhY2tkcm9wLm9mZnNldEhlaWdodDtcbiAgICB0aGlzLl9iYWNrZHJvcC5jbGFzc0xpc3QuYWRkKCdzby1zaG93Jyk7XG4gIH1cblxuICAvKipcbiAgICogVXBkYXRlIHotaW5kZXggZm9yIG5lc3RlZCBtb2RhbHNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF91cGRhdGVaSW5kZXgoKSB7XG4gICAgY29uc3QgbW9kYWxJbmRleCA9IFNPTW9kYWwuX29wZW5Nb2RhbHMuaW5kZXhPZih0aGlzKTtcbiAgICBpZiAobW9kYWxJbmRleCA+IDApIHtcbiAgICAgIC8vIEVhY2ggbmVzdGVkIG1vZGFsIGdldHMgYSBoaWdoZXIgei1pbmRleFxuICAgICAgY29uc3QgekluZGV4ID0gU09Nb2RhbC5fYmFzZVpJbmRleCArIChtb2RhbEluZGV4ICogMTApO1xuICAgICAgdGhpcy5lbGVtZW50LnN0eWxlLnpJbmRleCA9IHpJbmRleDtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogUmVzZXQgei1pbmRleCB3aGVuIG1vZGFsIGNsb3Nlc1xuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3Jlc2V0WkluZGV4KCkge1xuICAgIHRoaXMuZWxlbWVudC5zdHlsZS56SW5kZXggPSAnJztcbiAgfVxuXG4gIC8qKlxuICAgKiBIaWRlIGFuZCByZW1vdmUgYmFja2Ryb3BcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oaWRlQmFja2Ryb3AoKSB7XG4gICAgaWYgKCF0aGlzLl9iYWNrZHJvcCkgcmV0dXJuO1xuXG4gICAgdGhpcy5fYmFja2Ryb3AuY2xhc3NMaXN0LnJlbW92ZSgnc28tc2hvdycpO1xuXG4gICAgaWYgKHRoaXMub3B0aW9ucy5hbmltYXRpb24pIHtcbiAgICAgIHRoaXMuX2JhY2tkcm9wLmFkZEV2ZW50TGlzdGVuZXIoJ3RyYW5zaXRpb25lbmQnLCAoKSA9PiB7XG4gICAgICAgIHRoaXMuX2JhY2tkcm9wPy5yZW1vdmUoKTtcbiAgICAgICAgdGhpcy5fYmFja2Ryb3AgPSBudWxsO1xuICAgICAgfSwgeyBvbmNlOiB0cnVlIH0pO1xuICAgIH0gZWxzZSB7XG4gICAgICB0aGlzLl9iYWNrZHJvcC5yZW1vdmUoKTtcbiAgICAgIHRoaXMuX2JhY2tkcm9wID0gbnVsbDtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogTWFuYWdlIGJvZHkgc2Nyb2xsIGxvY2tcbiAgICogQHBhcmFtIHtib29sZWFufSBsb2NrIC0gV2hldGhlciB0byBsb2NrIHNjcm9sbFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX21hbmFnZUJvZHlTY3JvbGwobG9jaykge1xuICAgIGlmIChsb2NrKSB7XG4gICAgICBkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5hZGQoJ3NvLW1vZGFsLW9wZW4nKTtcbiAgICAgIGRvY3VtZW50LmJvZHkuc3R5bGUub3ZlcmZsb3cgPSAnaGlkZGVuJztcbiAgICB9IGVsc2UgaWYgKFNPTW9kYWwuX29wZW5Nb2RhbHMubGVuZ3RoID09PSAwKSB7XG4gICAgICBkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5yZW1vdmUoJ3NvLW1vZGFsLW9wZW4nKTtcbiAgICAgIGRvY3VtZW50LmJvZHkuc3R5bGUub3ZlcmZsb3cgPSAnJztcbiAgICB9XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBQVUJMSUMgQVBJXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIFNob3cgdGhlIG1vZGFsXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHNob3coKSB7XG4gICAgaWYgKHRoaXMuX2lzT3BlbikgcmV0dXJuIHRoaXM7XG5cbiAgICAvLyBFbWl0IHNob3cgZXZlbnQgKGNhbiBiZSBwcmV2ZW50ZWQpXG4gICAgaWYgKCF0aGlzLmVtaXQoU09Nb2RhbC5FVkVOVFMuU0hPVykpIHtcbiAgICAgIHJldHVybiB0aGlzO1xuICAgIH1cblxuICAgIHRoaXMuX2lzT3BlbiA9IHRydWU7XG4gICAgdGhpcy5fcHJldmlvdXNBY3RpdmVFbGVtZW50ID0gZG9jdW1lbnQuYWN0aXZlRWxlbWVudDtcblxuICAgIC8vIEFkZCB0byBvcGVuIG1vZGFscyBzdGFja1xuICAgIFNPTW9kYWwuX29wZW5Nb2RhbHMucHVzaCh0aGlzKTtcblxuICAgIC8vIFVwZGF0ZSB6LWluZGV4IGZvciBuZXN0ZWQgbW9kYWxzXG4gICAgdGhpcy5fdXBkYXRlWkluZGV4KCk7XG5cbiAgICAvLyBDaGVjayBtb2JpbGUgZnVsbHNjcmVlblxuICAgIGlmICh0aGlzLm9wdGlvbnMubW9iaWxlRnVsbHNjcmVlbikge1xuICAgICAgdGhpcy5fY2hlY2tNb2JpbGVGdWxsc2NyZWVuKCk7XG4gICAgfVxuXG4gICAgLy8gU2hvdyBiYWNrZHJvcFxuICAgIHRoaXMuX3Nob3dCYWNrZHJvcCgpO1xuXG4gICAgLy8gTG9jayBib2R5IHNjcm9sbFxuICAgIHRoaXMuX21hbmFnZUJvZHlTY3JvbGwodHJ1ZSk7XG5cbiAgICAvLyBTaG93IG1vZGFsXG4gICAgdGhpcy5lbGVtZW50LnN0eWxlLmRpc3BsYXkgPSAnZmxleCc7XG5cbiAgICBpZiAodGhpcy5vcHRpb25zLmFuaW1hdGlvbikge1xuICAgICAgdGhpcy5hZGRDbGFzcygnc28tZmFkZScpO1xuICAgICAgLy8gRm9yY2UgcmVmbG93XG4gICAgICB0aGlzLmVsZW1lbnQub2Zmc2V0SGVpZ2h0O1xuICAgIH1cblxuICAgIHRoaXMuYWRkQ2xhc3MoJ3NvLXNob3cnKTtcblxuICAgIC8vIFNldCB1cCBmb2N1cyB0cmFwICh3aXRob3V0IGluaXRpYWwgZm9jdXMgLSB3ZSdsbCBoYW5kbGUgdGhhdCBhZnRlciBhbmltYXRpb24pXG4gICAgaWYgKHRoaXMub3B0aW9ucy5mb2N1cykge1xuICAgICAgdGhpcy5fZm9jdXNUcmFwQ2xlYW51cCA9IHRoaXMudHJhcEZvY3VzKHsgc2tpcEluaXRpYWxGb2N1czogdHJ1ZSB9KTtcbiAgICB9XG5cbiAgICAvLyBCaW5kIGRvY3VtZW50IGtleWJvYXJkIGxpc3RlbmVyIGZvciBFc2NhcGVcbiAgICB0aGlzLl9iaW5kRG9jdW1lbnRLZXlkb3duKCk7XG5cbiAgICAvLyBFbWl0IHNob3duIGV2ZW50IGFmdGVyIHRyYW5zaXRpb24gYW5kIHNldCBmb2N1c1xuICAgIGlmICh0aGlzLm9wdGlvbnMuYW5pbWF0aW9uKSB7XG4gICAgICBsZXQgc2hvd25FbWl0dGVkID0gZmFsc2U7XG4gICAgICBjb25zdCBoYW5kbGVTaG93biA9ICgpID0+IHtcbiAgICAgICAgaWYgKHNob3duRW1pdHRlZCkgcmV0dXJuO1xuICAgICAgICBzaG93bkVtaXR0ZWQgPSB0cnVlO1xuICAgICAgICAvLyBGb2N1cyB0aGUgYXBwcm9wcmlhdGUgZWxlbWVudCBhZnRlciBhbmltYXRpb24gY29tcGxldGVzXG4gICAgICAgIGlmICh0aGlzLm9wdGlvbnMuZm9jdXMpIHtcbiAgICAgICAgICB0aGlzLl9mb2N1c0luaXRpYWxFbGVtZW50KCk7XG4gICAgICAgIH1cbiAgICAgICAgdGhpcy5lbWl0KFNPTW9kYWwuRVZFTlRTLlNIT1dOKTtcbiAgICAgIH07XG5cbiAgICAgIC8vIExpc3RlbiBmb3IgdHJhbnNpdGlvbmVuZCBvbiB0aGUgZGlhbG9nIGl0c2VsZiAobm90IGJ1YmJsZWQgZnJvbSBjaGlsZHJlbilcbiAgICAgIGNvbnN0IHRyYW5zaXRpb25IYW5kbGVyID0gKGUpID0+IHtcbiAgICAgICAgaWYgKGUudGFyZ2V0ID09PSB0aGlzLl9kaWFsb2cpIHtcbiAgICAgICAgICB0aGlzLl9kaWFsb2cucmVtb3ZlRXZlbnRMaXN0ZW5lcigndHJhbnNpdGlvbmVuZCcsIHRyYW5zaXRpb25IYW5kbGVyKTtcbiAgICAgICAgICBoYW5kbGVTaG93bigpO1xuICAgICAgICB9XG4gICAgICB9O1xuICAgICAgdGhpcy5fZGlhbG9nLmFkZEV2ZW50TGlzdGVuZXIoJ3RyYW5zaXRpb25lbmQnLCB0cmFuc2l0aW9uSGFuZGxlcik7XG5cbiAgICAgIC8vIEZhbGxiYWNrIHRpbWVvdXQgaW4gY2FzZSB0cmFuc2l0aW9uZW5kIGRvZXNuJ3QgZmlyZVxuICAgICAgc2V0VGltZW91dChoYW5kbGVTaG93biwgMzUwKTtcbiAgICB9IGVsc2Uge1xuICAgICAgLy8gRm9jdXMgaW1tZWRpYXRlbHkgd2hlbiBubyBhbmltYXRpb25cbiAgICAgIGlmICh0aGlzLm9wdGlvbnMuZm9jdXMpIHtcbiAgICAgICAgdGhpcy5fZm9jdXNJbml0aWFsRWxlbWVudCgpO1xuICAgICAgfVxuICAgICAgdGhpcy5lbWl0KFNPTW9kYWwuRVZFTlRTLlNIT1dOKTtcbiAgICB9XG5cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBIaWRlIHRoZSBtb2RhbFxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBoaWRlKCkge1xuICAgIGlmICghdGhpcy5faXNPcGVuKSByZXR1cm4gdGhpcztcblxuICAgIC8vIEVtaXQgaGlkZSBldmVudCAoY2FuIGJlIHByZXZlbnRlZClcbiAgICBpZiAoIXRoaXMuZW1pdChTT01vZGFsLkVWRU5UUy5ISURFKSkge1xuICAgICAgcmV0dXJuIHRoaXM7XG4gICAgfVxuXG4gICAgdGhpcy5faXNPcGVuID0gZmFsc2U7XG5cbiAgICAvLyBSZW1vdmUgZnJvbSBvcGVuIG1vZGFscyBzdGFja1xuICAgIGNvbnN0IGluZGV4ID0gU09Nb2RhbC5fb3Blbk1vZGFscy5pbmRleE9mKHRoaXMpO1xuICAgIGlmIChpbmRleCA+IC0xKSB7XG4gICAgICBTT01vZGFsLl9vcGVuTW9kYWxzLnNwbGljZShpbmRleCwgMSk7XG4gICAgfVxuXG4gICAgLy8gUmVtb3ZlIGZvY3VzIHRyYXBcbiAgICBpZiAodGhpcy5fZm9jdXNUcmFwQ2xlYW51cCkge1xuICAgICAgdGhpcy5fZm9jdXNUcmFwQ2xlYW51cCgpO1xuICAgICAgdGhpcy5fZm9jdXNUcmFwQ2xlYW51cCA9IG51bGw7XG4gICAgfVxuXG4gICAgLy8gVW5iaW5kIGRvY3VtZW50IGtleWJvYXJkIGxpc3RlbmVyXG4gICAgdGhpcy5fdW5iaW5kRG9jdW1lbnRLZXlkb3duKCk7XG5cbiAgICAvLyBIaWRlIG1vZGFsXG4gICAgdGhpcy5yZW1vdmVDbGFzcygnc28tc2hvdycpO1xuXG4gICAgY29uc3QgaGlkZUNvbXBsZXRlID0gKCkgPT4ge1xuICAgICAgdGhpcy5lbGVtZW50LnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gICAgICB0aGlzLl9oaWRlQmFja2Ryb3AoKTtcbiAgICAgIHRoaXMuX21hbmFnZUJvZHlTY3JvbGwoZmFsc2UpO1xuXG4gICAgICAvLyBSZXNldCB6LWluZGV4IGZvciBuZXN0ZWQgbW9kYWxzXG4gICAgICB0aGlzLl9yZXNldFpJbmRleCgpO1xuXG4gICAgICAvLyBSZXNldCBkcmFnIHBvc2l0aW9uIGlmIGRyYWdnYWJsZVxuICAgICAgaWYgKHRoaXMub3B0aW9ucy5kcmFnZ2FibGUpIHtcbiAgICAgICAgdGhpcy5fcmVzZXREcmFnUG9zaXRpb24oKTtcbiAgICAgIH1cblxuICAgICAgLy8gUmVzZXQgbWF4aW1pemVkIHN0YXRlXG4gICAgICBpZiAodGhpcy5faXNNYXhpbWl6ZWQpIHtcbiAgICAgICAgdGhpcy5faXNNYXhpbWl6ZWQgPSBmYWxzZTtcbiAgICAgICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5yZW1vdmUoJ3NvLW1vZGFsLW1heGltaXplZCcpO1xuICAgICAgICBpZiAodGhpcy5fbWF4aW1pemVCdG4pIHtcbiAgICAgICAgICB0aGlzLl9tYXhpbWl6ZUJ0bi5pbm5lckhUTUwgPSAnPHNwYW4gY2xhc3M9XCJtYXRlcmlhbC1pY29uc1wiPm9wZW5faW5fZnVsbDwvc3Bhbj4nO1xuICAgICAgICB9XG4gICAgICB9XG5cbiAgICAgIC8vIFJlbW92ZSBtb2JpbGUgZnVsbHNjcmVlbiBjbGFzc1xuICAgICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5yZW1vdmUoJ3NvLW1vZGFsLW1vYmlsZS1mdWxsc2NyZWVuJyk7XG5cbiAgICAgIC8vIFJlc3RvcmUgZm9jdXNcbiAgICAgIGlmICh0aGlzLl9wcmV2aW91c0FjdGl2ZUVsZW1lbnQgJiYgdHlwZW9mIHRoaXMuX3ByZXZpb3VzQWN0aXZlRWxlbWVudC5mb2N1cyA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgICB0aGlzLl9wcmV2aW91c0FjdGl2ZUVsZW1lbnQuZm9jdXMoKTtcbiAgICAgIH1cblxuICAgICAgdGhpcy5lbWl0KFNPTW9kYWwuRVZFTlRTLkhJRERFTik7XG4gICAgfTtcblxuICAgIGlmICh0aGlzLm9wdGlvbnMuYW5pbWF0aW9uICYmIHRoaXMuX2RpYWxvZykge1xuICAgICAgLy8gVXNlIGEgZmxhZyB0byBwcmV2ZW50IGRvdWJsZSBleGVjdXRpb25cbiAgICAgIGxldCBjb21wbGV0ZWQgPSBmYWxzZTtcbiAgICAgIGNvbnN0IHNhZmVIaWRlQ29tcGxldGUgPSAoKSA9PiB7XG4gICAgICAgIGlmIChjb21wbGV0ZWQpIHJldHVybjtcbiAgICAgICAgY29tcGxldGVkID0gdHJ1ZTtcbiAgICAgICAgaGlkZUNvbXBsZXRlKCk7XG4gICAgICB9O1xuXG4gICAgICB0aGlzLl9kaWFsb2cuYWRkRXZlbnRMaXN0ZW5lcigndHJhbnNpdGlvbmVuZCcsIHNhZmVIaWRlQ29tcGxldGUsIHsgb25jZTogdHJ1ZSB9KTtcbiAgICAgIC8vIEZhbGxiYWNrIHRpbWVvdXQgaW4gY2FzZSB0cmFuc2l0aW9uZW5kIGRvZXNuJ3QgZmlyZVxuICAgICAgc2V0VGltZW91dChzYWZlSGlkZUNvbXBsZXRlLCAzNTApO1xuICAgIH0gZWxzZSB7XG4gICAgICBoaWRlQ29tcGxldGUoKTtcbiAgICB9XG5cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBUb2dnbGUgbW9kYWwgdmlzaWJpbGl0eVxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICB0b2dnbGUoKSB7XG4gICAgcmV0dXJuIHRoaXMuX2lzT3BlbiA/IHRoaXMuaGlkZSgpIDogdGhpcy5zaG93KCk7XG4gIH1cblxuICAvKipcbiAgICogQ2hlY2sgaWYgbW9kYWwgaXMgb3BlblxuICAgKiBAcmV0dXJucyB7Ym9vbGVhbn0gT3BlbiBzdGF0ZVxuICAgKi9cbiAgaXNPcGVuKCkge1xuICAgIHJldHVybiB0aGlzLl9pc09wZW47XG4gIH1cblxuICAvKipcbiAgICogU2V0IG1vZGFsIGNvbnRlbnRcbiAgICogQHBhcmFtIHtzdHJpbmd8RWxlbWVudH0gY29udGVudCAtIENvbnRlbnQgdG8gc2V0XG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHNldENvbnRlbnQoY29udGVudCkge1xuICAgIGNvbnN0IGJvZHkgPSB0aGlzLiQoJy5zby1tb2RhbC1ib2R5Jyk7XG4gICAgaWYgKCFib2R5KSByZXR1cm4gdGhpcztcblxuICAgIGlmICh0eXBlb2YgY29udGVudCA9PT0gJ3N0cmluZycpIHtcbiAgICAgIGJvZHkuaW5uZXJIVE1MID0gY29udGVudDtcbiAgICB9IGVsc2UgaWYgKGNvbnRlbnQgaW5zdGFuY2VvZiBFbGVtZW50KSB7XG4gICAgICBib2R5LmlubmVySFRNTCA9ICcnO1xuICAgICAgYm9keS5hcHBlbmRDaGlsZChjb250ZW50KTtcbiAgICB9XG5cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBTZXQgbW9kYWwgdGl0bGVcbiAgICogQHBhcmFtIHtzdHJpbmd9IHRpdGxlIC0gVGl0bGUgdGV4dFxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBzZXRUaXRsZSh0aXRsZSkge1xuICAgIGNvbnN0IHRpdGxlRWwgPSB0aGlzLiQoJy5zby1tb2RhbC10aXRsZScpO1xuICAgIGlmICh0aXRsZUVsKSB7XG4gICAgICB0aXRsZUVsLnRleHRDb250ZW50ID0gdGl0bGU7XG4gICAgfVxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gU1RBVElDIE1FVEhPRFNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogQ3JlYXRlIGFuZCBzaG93IGEgbW9kYWwgcHJvZ3JhbW1hdGljYWxseVxuICAgKlxuICAgKiBAcGFyYW0ge09iamVjdH0gb3B0aW9ucyAtIE1vZGFsIGNvbmZpZ3VyYXRpb25cbiAgICogQHBhcmFtIHtzdHJpbmd9IG9wdGlvbnMudGl0bGUgLSBNb2RhbCB0aXRsZVxuICAgKiBAcGFyYW0ge3N0cmluZ30gb3B0aW9ucy5jb250ZW50IC0gTW9kYWwgYm9keSBjb250ZW50IChIVE1MIHN0cmluZylcbiAgICogQHBhcmFtIHtzdHJpbmd9IG9wdGlvbnMuc2l6ZSAtIE1vZGFsIHNpemU6ICdzbScsICdkZWZhdWx0JywgJ2xnJywgJ3hsJywgJ2Z1bGxzY3JlZW4nXG4gICAqIEBwYXJhbSB7Ym9vbGVhbn0gb3B0aW9ucy5jbG9zYWJsZSAtIFdoZXRoZXIgbW9kYWwgY2FuIGJlIGNsb3NlZFxuICAgKiBAcGFyYW0ge3N0cmluZ30gb3B0aW9ucy5jbGFzc05hbWUgLSBBZGRpdGlvbmFsIENTUyBjbGFzc2VzXG4gICAqIEBwYXJhbSB7Ym9vbGVhbn0gb3B0aW9ucy5zdGF0aWMgLSBDYW5ub3QgYmUgZGlzbWlzc2VkIHdpdGhvdXQgYnV0dG9uIGNsaWNrXG4gICAqIEBwYXJhbSB7c3RyaW5nfEFycmF5fSBvcHRpb25zLmZvb3RlciAtIEZvb3RlciBjb250ZW50IChmbGV4aWJsZSBmb3JtYXQpOlxuICAgKiAgIC0gU3RyaW5nOiBSYXcgSFRNTCBzdHJpbmdcbiAgICogICAtIEFycmF5OiBBcnJheSBvZiBidXR0b24gY29uZmlncywgZWFjaCBjYW4gYmU6XG4gICAqICAgICAtIFN0cmluZzogJ0NhbmNlbCcgKHRleHQgb25seSwgb3V0bGluZSBzdHlsZSlcbiAgICogICAgIC0gQXJyYXk6IFt7IGljb246ICdzYXZlJyB9LCAnU2F2ZSddIChmbGV4aWJsZSBjb250ZW50KVxuICAgKiAgICAgLSBPYmplY3Q6IHsgY29udGVudDogWy4uLl0sIGNsYXNzOiAnc28tYnRuLXByaW1hcnknLCBkaXNtaXNzOiB0cnVlLCBvbmNsaWNrOiBmbiB9XG4gICAqIEBwYXJhbSB7c3RyaW5nfSBvcHRpb25zLmZvb3RlclBvc2l0aW9uIC0gRm9vdGVyIGFsaWdubWVudDogJ2xlZnQnLCAnY2VudGVyJywgJ3JpZ2h0JywgJ2JldHdlZW4nLCAnYXJvdW5kJ1xuICAgKiBAcGFyYW0ge3N0cmluZ30gb3B0aW9ucy5mb290ZXJMYXlvdXQgLSBGb290ZXIgbGF5b3V0OiAnaW5saW5lJyBvciAnc3RhY2tlZCdcbiAgICogQHBhcmFtIHtzdHJpbmd9IG9wdGlvbnMuZm9jdXNFbGVtZW50IC0gRWxlbWVudCB0byBmb2N1cyBvbiBvcGVuOiAnZm9vdGVyJyAoZGVmYXVsdCksICdjbG9zZScsICdmaXJzdCcsIG9yIENTUyBzZWxlY3RvclxuICAgKiBAcmV0dXJucyB7U09Nb2RhbH0gTW9kYWwgaW5zdGFuY2VcbiAgICpcbiAgICogQGV4YW1wbGVcbiAgICogLy8gU3RyaW5nIGZvb3RlciAobGVnYWN5KVxuICAgKiBTT01vZGFsLmNyZWF0ZSh7XG4gICAqICAgdGl0bGU6ICdNeSBNb2RhbCcsXG4gICAqICAgY29udGVudDogJzxwPkNvbnRlbnQgaGVyZTwvcD4nLFxuICAgKiAgIGZvb3RlcjogJzxidXR0b24gY2xhc3M9XCJzby1idG4gc28tYnRuLXByaW1hcnlcIiBkYXRhLWRpc21pc3M9XCJtb2RhbFwiPk9LPC9idXR0b24+J1xuICAgKiB9KTtcbiAgICpcbiAgICogQGV4YW1wbGVcbiAgICogLy8gRmxleGlibGUgZm9vdGVyIGJ1dHRvbnNcbiAgICogU09Nb2RhbC5jcmVhdGUoe1xuICAgKiAgIHRpdGxlOiAnTXkgTW9kYWwnLFxuICAgKiAgIGNvbnRlbnQ6ICc8cD5Db250ZW50IGhlcmU8L3A+JyxcbiAgICogICBmb290ZXI6IFtcbiAgICogICAgIHsgY29udGVudDogJ0NhbmNlbCcsIGNsYXNzOiAnc28tYnRuLW91dGxpbmUnLCBkaXNtaXNzOiB0cnVlIH0sXG4gICAqICAgICB7IGNvbnRlbnQ6IFt7IGljb246ICdzYXZlJyB9LCAnU2F2ZSddLCBjbGFzczogJ3NvLWJ0bi1wcmltYXJ5JywgZGlzbWlzczogdHJ1ZSB9XG4gICAqICAgXSxcbiAgICogICBmb290ZXJQb3NpdGlvbjogJ3JpZ2h0J1xuICAgKiB9KTtcbiAgICovXG4gIHN0YXRpYyBjcmVhdGUob3B0aW9ucyA9IHt9KSB7XG4gICAgY29uc3Qge1xuICAgICAgdGl0bGUgPSAnJyxcbiAgICAgIGNvbnRlbnQgPSAnJyxcbiAgICAgIHNpemUgPSAnZGVmYXVsdCcsXG4gICAgICBjbG9zYWJsZSA9IHRydWUsXG4gICAgICBmb290ZXIgPSBudWxsLFxuICAgICAgZm9vdGVyUG9zaXRpb24gPSAncmlnaHQnLFxuICAgICAgZm9vdGVyTGF5b3V0ID0gJ2lubGluZScsXG4gICAgICBjbGFzc05hbWUgPSAnJyxcbiAgICAgIHN0YXRpYzogaXNTdGF0aWMgPSBmYWxzZSxcbiAgICAgIGZvY3VzRWxlbWVudCA9ICdmb290ZXInLFxuICAgICAgc2luZ2xldG9uID0gZmFsc2UsXG4gICAgICBzaW5nbGV0b25JZCA9IG51bGwsXG4gICAgICBzaW5nbGV0b25GZWVkYmFjayA9ICdzaGFrZScsIC8vICdzaGFrZScsICdwdWxzZScsICdib3VuY2UnLCAnaGVhZHNoYWtlJ1xuICAgICAgZHJhZ2dhYmxlID0gZmFsc2UsXG4gICAgICBtYXhpbWl6YWJsZSA9IGZhbHNlLFxuICAgICAgbW9iaWxlRnVsbHNjcmVlbiA9IGZhbHNlLFxuICAgICAgbW9iaWxlQnJlYWtwb2ludCA9IDc2OCxcbiAgICAgIHNpZGViYXIgPSBmYWxzZSxcbiAgICAgIHNpZGViYXJXaWR0aCA9ICcyODBweCcsXG4gICAgfSA9IG9wdGlvbnM7XG5cbiAgICAvLyBTaW5nbGV0b24gY2hlY2sgLSBpZiBtb2RhbCB3aXRoIHNhbWUgSUQgZXhpc3RzLCBwcm92aWRlIGZlZWRiYWNrIGFuZCByZXR1cm4gZXhpc3RpbmdcbiAgICBpZiAoc2luZ2xldG9uKSB7XG4gICAgICBjb25zdCBpZCA9IHNpbmdsZXRvbklkIHx8IGBzaW5nbGV0b24tJHt0aXRsZS50b0xvd2VyQ2FzZSgpLnJlcGxhY2UoL1xccysvZywgJy0nKX1gO1xuICAgICAgY29uc3QgZXhpc3RpbmdJbnN0YW5jZSA9IFNPTW9kYWwuX3NpbmdsZXRvbkluc3RhbmNlcy5nZXQoaWQpO1xuXG4gICAgICBpZiAoZXhpc3RpbmdJbnN0YW5jZSAmJiBleGlzdGluZ0luc3RhbmNlLl9pc09wZW4pIHtcbiAgICAgICAgZXhpc3RpbmdJbnN0YW5jZS5fcGxheUZlZWRiYWNrQW5pbWF0aW9uKHNpbmdsZXRvbkZlZWRiYWNrKTtcbiAgICAgICAgcmV0dXJuIGV4aXN0aW5nSW5zdGFuY2U7XG4gICAgICB9XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogUGFyc2UgYnV0dG9uIGNvbnRlbnQgZnJvbSB2YXJpb3VzIGZvcm1hdHMgKHNhbWUgYXMgY29uZmlybSlcbiAgICAgKi9cbiAgICBjb25zdCBwYXJzZUJ1dHRvbkNvbnRlbnQgPSAoYnRuQ29udGVudCkgPT4ge1xuICAgICAgaWYgKHR5cGVvZiBidG5Db250ZW50ID09PSAnc3RyaW5nJykge1xuICAgICAgICByZXR1cm4gYnRuQ29udGVudDtcbiAgICAgIH1cbiAgICAgIGlmIChBcnJheS5pc0FycmF5KGJ0bkNvbnRlbnQpKSB7XG4gICAgICAgIHJldHVybiBidG5Db250ZW50Lm1hcChwYXJ0ID0+IHtcbiAgICAgICAgICBpZiAodHlwZW9mIHBhcnQgPT09ICdzdHJpbmcnKSB7XG4gICAgICAgICAgICByZXR1cm4gcGFydDtcbiAgICAgICAgICB9XG4gICAgICAgICAgaWYgKHBhcnQgJiYgdHlwZW9mIHBhcnQgPT09ICdvYmplY3QnICYmIHBhcnQuaWNvbikge1xuICAgICAgICAgICAgcmV0dXJuIGA8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+JHtwYXJ0Lmljb259PC9zcGFuPmA7XG4gICAgICAgICAgfVxuICAgICAgICAgIHJldHVybiAnJztcbiAgICAgICAgfSkuam9pbignJyk7XG4gICAgICB9XG4gICAgICByZXR1cm4gJyc7XG4gICAgfTtcblxuICAgIC8qKlxuICAgICAqIENyZWF0ZSBidXR0b24gSFRNTCBmcm9tIGZsZXhpYmxlIGZvcm1hdFxuICAgICAqL1xuICAgIGNvbnN0IGNyZWF0ZUJ1dHRvbiA9IChidG5Db25maWcsIGluZGV4KSA9PiB7XG4gICAgICBsZXQgY29udGVudCwgYnRuQ2xhc3MsIGRpc21pc3MsIG9uY2xpY2s7XG5cbiAgICAgIGlmICh0eXBlb2YgYnRuQ29uZmlnID09PSAnc3RyaW5nJykge1xuICAgICAgICAvLyBTaW1wbGUgc3RyaW5nOiAnQ2FuY2VsJ1xuICAgICAgICBjb250ZW50ID0gYnRuQ29uZmlnO1xuICAgICAgICBidG5DbGFzcyA9ICdzby1idG4tb3V0bGluZSc7XG4gICAgICAgIGRpc21pc3MgPSB0cnVlO1xuICAgICAgfSBlbHNlIGlmIChBcnJheS5pc0FycmF5KGJ0bkNvbmZpZykpIHtcbiAgICAgICAgLy8gQXJyYXkgZm9ybWF0OiBbeyBpY29uOiAnc2F2ZScgfSwgJ1NhdmUnXVxuICAgICAgICBjb250ZW50ID0gcGFyc2VCdXR0b25Db250ZW50KGJ0bkNvbmZpZyk7XG4gICAgICAgIGJ0bkNsYXNzID0gJ3NvLWJ0bi1vdXRsaW5lJztcbiAgICAgICAgZGlzbWlzcyA9IHRydWU7XG4gICAgICB9IGVsc2UgaWYgKGJ0bkNvbmZpZyAmJiB0eXBlb2YgYnRuQ29uZmlnID09PSAnb2JqZWN0Jykge1xuICAgICAgICAvLyBPYmplY3QgZm9ybWF0OiB7IGNvbnRlbnQ6IFsuLi5dLCBjbGFzczogJ3NvLWJ0bi1wcmltYXJ5JywgZGlzbWlzczogdHJ1ZSB9XG4gICAgICAgIGNvbnRlbnQgPSBwYXJzZUJ1dHRvbkNvbnRlbnQoYnRuQ29uZmlnLmNvbnRlbnQgfHwgYnRuQ29uZmlnLnRleHQgfHwgJycpO1xuICAgICAgICBidG5DbGFzcyA9IGJ0bkNvbmZpZy5jbGFzcyB8fCAnc28tYnRuLW91dGxpbmUnO1xuICAgICAgICBkaXNtaXNzID0gYnRuQ29uZmlnLmRpc21pc3MgIT09IGZhbHNlO1xuICAgICAgICBvbmNsaWNrID0gYnRuQ29uZmlnLm9uY2xpY2s7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICByZXR1cm4gJyc7XG4gICAgICB9XG5cbiAgICAgIGNvbnN0IGRpc21pc3NBdHRyID0gZGlzbWlzcyA/ICcgZGF0YS1kaXNtaXNzPVwibW9kYWxcIicgOiAnJztcbiAgICAgIGNvbnN0IG9uY2xpY2tBdHRyID0gb25jbGljayA/IGAgZGF0YS1tb2RhbC1idG4taW5kZXg9XCIke2luZGV4fVwiYCA6ICcnO1xuICAgICAgcmV0dXJuIGA8YnV0dG9uIHR5cGU9XCJidXR0b25cIiBjbGFzcz1cInNvLWJ0biAke2J0bkNsYXNzfVwiJHtkaXNtaXNzQXR0cn0ke29uY2xpY2tBdHRyfT4ke2NvbnRlbnR9PC9idXR0b24+YDtcbiAgICB9O1xuXG4gICAgLy8gU2l6ZSBjbGFzcyBnb2VzIG9uIHRoZSBtb2RhbCBjb250YWluZXIsIG5vdCB0aGUgZGlhbG9nXG4gICAgY29uc3Qgc2l6ZUNsYXNzID0gc2l6ZSAhPT0gJ2RlZmF1bHQnID8gYHNvLW1vZGFsLSR7c2l6ZX1gIDogJyc7XG4gICAgY29uc3Qgc3RhdGljQ2xhc3MgPSBpc1N0YXRpYyA/ICdzby1tb2RhbC1zdGF0aWMnIDogJyc7XG4gICAgY29uc3Qgc2lkZWJhckNsYXNzID0gc2lkZWJhciA/IGBzby1tb2RhbC13aXRoLXNpZGViYXIgc28tbW9kYWwtc2lkZWJhci0ke3NpZGViYXIgPT09IHRydWUgPyAnbGVmdCcgOiBzaWRlYmFyfWAgOiAnJztcbiAgICBjb25zdCBkcmFnZ2FibGVDbGFzcyA9IGRyYWdnYWJsZSA/ICdzby1tb2RhbC1kcmFnZ2FibGUnIDogJyc7XG4gICAgY29uc3QgbWF4aW1pemFibGVDbGFzcyA9IG1heGltaXphYmxlID8gJ3NvLW1vZGFsLW1heGltaXphYmxlJyA6ICcnO1xuXG4gICAgY29uc3QgbW9kYWwgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcbiAgICBtb2RhbC5jbGFzc05hbWUgPSBgc28tbW9kYWwgc28tZmFkZSAke3NpemVDbGFzc30gJHtzdGF0aWNDbGFzc30gJHtzaWRlYmFyQ2xhc3N9ICR7ZHJhZ2dhYmxlQ2xhc3N9ICR7bWF4aW1pemFibGVDbGFzc30gJHtjbGFzc05hbWV9YC50cmltKCkucmVwbGFjZSgvXFxzKy9nLCAnICcpO1xuICAgIG1vZGFsLnRhYkluZGV4ID0gLTE7XG5cbiAgICAvLyBGb3Igc3RhdGljIG1vZGFscywgc2V0IHRoZSBkYXRhIGF0dHJpYnV0ZVxuICAgIGlmIChpc1N0YXRpYykge1xuICAgICAgbW9kYWwuc2V0QXR0cmlidXRlKCdkYXRhLXNvLXN0YXRpYycsICd0cnVlJyk7XG4gICAgfVxuXG4gICAgLy8gQnVpbGQgZm9vdGVyIEhUTUxcbiAgICBsZXQgZm9vdGVySHRtbCA9ICcnO1xuICAgIGxldCBidXR0b25PbmNsaWNrcyA9IFtdO1xuICAgIGlmIChmb290ZXIpIHtcbiAgICAgIGlmICh0eXBlb2YgZm9vdGVyID09PSAnc3RyaW5nJykge1xuICAgICAgICAvLyBMZWdhY3kgc3RyaW5nIGZvcm1hdFxuICAgICAgICBmb290ZXJIdG1sID0gYFxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1tb2RhbC1mb290ZXJcIj5cbiAgICAgICAgICAgICR7Zm9vdGVyfVxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICBgO1xuICAgICAgfSBlbHNlIGlmIChBcnJheS5pc0FycmF5KGZvb3RlcikpIHtcbiAgICAgICAgLy8gTmV3IGZsZXhpYmxlIGFycmF5IGZvcm1hdFxuICAgICAgICBjb25zdCBwb3NpdGlvbkNsYXNzTWFwID0ge1xuICAgICAgICAgIGxlZnQ6ICdqdXN0aWZ5LXN0YXJ0JyxcbiAgICAgICAgICBjZW50ZXI6ICdqdXN0aWZ5LWNlbnRlcicsXG4gICAgICAgICAgcmlnaHQ6ICdqdXN0aWZ5LWVuZCcsXG4gICAgICAgICAgYmV0d2VlbjogJ2p1c3RpZnktYmV0d2VlbicsXG4gICAgICAgICAgYXJvdW5kOiAnanVzdGlmeS1hcm91bmQnLFxuICAgICAgICB9O1xuICAgICAgICBjb25zdCBwb3NpdGlvbkNsYXNzID0gcG9zaXRpb25DbGFzc01hcFtmb290ZXJQb3NpdGlvbl0gfHwgJ2p1c3RpZnktZW5kJztcbiAgICAgICAgY29uc3QgbGF5b3V0Q2xhc3MgPSBmb290ZXJMYXlvdXQgPT09ICdzdGFja2VkJyA/ICdzby1mbGV4LWNvbHVtbicgOiAnJztcbiAgICAgICAgY29uc3QgZm9vdGVyQ2xhc3NlcyA9IFtwb3NpdGlvbkNsYXNzLCBsYXlvdXRDbGFzc10uZmlsdGVyKEJvb2xlYW4pLmpvaW4oJyAnKTtcblxuICAgICAgICBjb25zdCBidXR0b25zID0gZm9vdGVyLm1hcCgoYnRuLCBpKSA9PiB7XG4gICAgICAgICAgaWYgKGJ0biAmJiB0eXBlb2YgYnRuID09PSAnb2JqZWN0JyAmJiBidG4ub25jbGljaykge1xuICAgICAgICAgICAgYnV0dG9uT25jbGlja3MucHVzaCh7IGluZGV4OiBpLCBvbmNsaWNrOiBidG4ub25jbGljayB9KTtcbiAgICAgICAgICB9XG4gICAgICAgICAgcmV0dXJuIGNyZWF0ZUJ1dHRvbihidG4sIGkpO1xuICAgICAgICB9KTtcblxuICAgICAgICBmb290ZXJIdG1sID0gYFxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1tb2RhbC1mb290ZXIgJHtmb290ZXJDbGFzc2VzfVwiPlxuICAgICAgICAgICAgJHtidXR0b25zLmpvaW4oJ1xcbicpfVxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICBgO1xuICAgICAgfSBlbHNlIGlmICh0eXBlb2YgZm9vdGVyID09PSAnb2JqZWN0JyAmJiAoZm9vdGVyLmxlZnQgfHwgZm9vdGVyLmNlbnRlciB8fCBmb290ZXIucmlnaHQpKSB7XG4gICAgICAgIC8vIFNlY3Rpb25zIGZvcm1hdDogeyBsZWZ0OiBbLi4uXSwgY2VudGVyOiBbLi4uXSwgcmlnaHQ6IFsuLi5dIH1cbiAgICAgICAgbGV0IGJ0bkluZGV4ID0gMDtcblxuICAgICAgICBjb25zdCBjcmVhdGVTZWN0aW9uQnV0dG9ucyA9IChidXR0b25zKSA9PiB7XG4gICAgICAgICAgaWYgKCFidXR0b25zIHx8ICFBcnJheS5pc0FycmF5KGJ1dHRvbnMpKSByZXR1cm4gJyc7XG4gICAgICAgICAgcmV0dXJuIGJ1dHRvbnMubWFwKGJ0biA9PiB7XG4gICAgICAgICAgICBpZiAoYnRuICYmIHR5cGVvZiBidG4gPT09ICdvYmplY3QnICYmIGJ0bi5vbmNsaWNrKSB7XG4gICAgICAgICAgICAgIGJ1dHRvbk9uY2xpY2tzLnB1c2goeyBpbmRleDogYnRuSW5kZXgsIG9uY2xpY2s6IGJ0bi5vbmNsaWNrIH0pO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgcmV0dXJuIGNyZWF0ZUJ1dHRvbihidG4sIGJ0bkluZGV4KyspO1xuICAgICAgICAgIH0pLmpvaW4oJ1xcbicpO1xuICAgICAgICB9O1xuXG4gICAgICAgIGNvbnN0IGxlZnRIdG1sID0gZm9vdGVyLmxlZnQgPyBgPGRpdiBjbGFzcz1cInNvLWZvb3Rlci1sZWZ0XCI+JHtjcmVhdGVTZWN0aW9uQnV0dG9ucyhmb290ZXIubGVmdCl9PC9kaXY+YCA6ICc8ZGl2IGNsYXNzPVwic28tZm9vdGVyLWxlZnRcIj48L2Rpdj4nO1xuICAgICAgICBjb25zdCBjZW50ZXJIdG1sID0gZm9vdGVyLmNlbnRlciA/IGA8ZGl2IGNsYXNzPVwic28tZm9vdGVyLWNlbnRlclwiPiR7Y3JlYXRlU2VjdGlvbkJ1dHRvbnMoZm9vdGVyLmNlbnRlcil9PC9kaXY+YCA6ICc8ZGl2IGNsYXNzPVwic28tZm9vdGVyLWNlbnRlclwiPjwvZGl2Pic7XG4gICAgICAgIGNvbnN0IHJpZ2h0SHRtbCA9IGZvb3Rlci5yaWdodCA/IGA8ZGl2IGNsYXNzPVwic28tZm9vdGVyLXJpZ2h0XCI+JHtjcmVhdGVTZWN0aW9uQnV0dG9ucyhmb290ZXIucmlnaHQpfTwvZGl2PmAgOiAnPGRpdiBjbGFzcz1cInNvLWZvb3Rlci1yaWdodFwiPjwvZGl2Pic7XG5cbiAgICAgICAgZm9vdGVySHRtbCA9IGBcbiAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tbW9kYWwtZm9vdGVyIHNvLWZvb3Rlci1zZWN0aW9uc1wiPlxuICAgICAgICAgICAgJHtsZWZ0SHRtbH1cbiAgICAgICAgICAgICR7Y2VudGVySHRtbH1cbiAgICAgICAgICAgICR7cmlnaHRIdG1sfVxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICBgO1xuICAgICAgfVxuICAgIH1cblxuICAgIC8vIERvbid0IHNob3cgY2xvc2UgYnV0dG9uIGlmIHN0YXRpYyBvciBub3QgY2xvc2FibGVcbiAgICBjb25zdCBzaG93Q2xvc2VCdXR0b24gPSBjbG9zYWJsZSAmJiAhaXNTdGF0aWM7XG5cbiAgICAvLyBCdWlsZCBoZWFkZXIgYnV0dG9ucyAobWF4aW1pemUgKyBjbG9zZSlcbiAgICBsZXQgaGVhZGVyQnV0dG9ucyA9ICcnO1xuICAgIGlmIChtYXhpbWl6YWJsZSkge1xuICAgICAgaGVhZGVyQnV0dG9ucyArPSAnPGJ1dHRvbiB0eXBlPVwiYnV0dG9uXCIgY2xhc3M9XCJzby1tb2RhbC1tYXhpbWl6ZVwiIHRpdGxlPVwiTWF4aW1pemVcIj48c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+b3Blbl9pbl9mdWxsPC9zcGFuPjwvYnV0dG9uPic7XG4gICAgfVxuICAgIGlmIChzaG93Q2xvc2VCdXR0b24pIHtcbiAgICAgIGhlYWRlckJ1dHRvbnMgKz0gJzxidXR0b24gdHlwZT1cImJ1dHRvblwiIGNsYXNzPVwic28tbW9kYWwtY2xvc2VcIiBkYXRhLWRpc21pc3M9XCJtb2RhbFwiPjxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnNcIj5jbG9zZTwvc3Bhbj48L2J1dHRvbj4nO1xuICAgIH1cblxuICAgIC8vIEJ1aWxkIG1haW4gY29udGVudCBhcmVhICh3aXRoIHNpZGViYXIgc3VwcG9ydClcbiAgICBsZXQgbWFpbkNvbnRlbnRIdG1sID0gJyc7XG4gICAgaWYgKHNpZGViYXIgJiYgdHlwZW9mIGNvbnRlbnQgPT09ICdvYmplY3QnICYmIGNvbnRlbnQuc2lkZWJhciAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICAvLyBDb250ZW50IGhhcyBzaWRlYmFyICsgbWFpbiBzZWN0aW9uc1xuICAgICAgY29uc3Qgc2lkZWJhckNvbnRlbnQgPSBjb250ZW50LnNpZGViYXIgfHwgJyc7XG4gICAgICBjb25zdCBtYWluQ29udGVudCA9IGNvbnRlbnQubWFpbiB8fCAnJztcbiAgICAgIG1haW5Db250ZW50SHRtbCA9IGBcbiAgICAgICAgPGRpdiBjbGFzcz1cInNvLW1vZGFsLWJvZHkgc28tbW9kYWwtYm9keS13aXRoLXNpZGViYXJcIj5cbiAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tbW9kYWwtc2lkZWJhclwiPiR7c2lkZWJhckNvbnRlbnR9PC9kaXY+XG4gICAgICAgICAgPGRpdiBjbGFzcz1cInNvLW1vZGFsLW1haW5cIj4ke21haW5Db250ZW50fTwvZGl2PlxuICAgICAgICA8L2Rpdj5cbiAgICAgIGA7XG4gICAgfSBlbHNlIHtcbiAgICAgIC8vIFJlZ3VsYXIgY29udGVudFxuICAgICAgY29uc3QgY29udGVudFN0ciA9IHR5cGVvZiBjb250ZW50ID09PSAnb2JqZWN0JyA/IChjb250ZW50Lm1haW4gfHwgJycpIDogY29udGVudDtcbiAgICAgIG1haW5Db250ZW50SHRtbCA9IGA8ZGl2IGNsYXNzPVwic28tbW9kYWwtYm9keVwiPiR7Y29udGVudFN0cn08L2Rpdj5gO1xuICAgIH1cblxuICAgIC8vIFNldCBzaWRlYmFyIHdpZHRoIGFzIENTUyB2YXJpYWJsZVxuICAgIGxldCBkaWFsb2dTdHlsZSA9ICcnO1xuICAgIGlmIChzaWRlYmFyICYmIHNpZGViYXJXaWR0aCkge1xuICAgICAgZGlhbG9nU3R5bGUgPSBgc3R5bGU9XCItLXNvLW1vZGFsLXNpZGViYXItd2lkdGg6ICR7c2lkZWJhcldpZHRofVwiYDtcbiAgICB9XG5cbiAgICBtb2RhbC5pbm5lckhUTUwgPSBgXG4gICAgICA8ZGl2IGNsYXNzPVwic28tbW9kYWwtZGlhbG9nXCIgJHtkaWFsb2dTdHlsZX0+XG4gICAgICAgIDxkaXYgY2xhc3M9XCJzby1tb2RhbC1jb250ZW50XCI+XG4gICAgICAgICAgPGRpdiBjbGFzcz1cInNvLW1vZGFsLWhlYWRlclwiJHtkcmFnZ2FibGUgPyAnIHN0eWxlPVwiY3Vyc29yOiBtb3ZlXCInIDogJyd9PlxuICAgICAgICAgICAgPGg1IGNsYXNzPVwic28tbW9kYWwtdGl0bGVcIj4ke3RpdGxlfTwvaDU+XG4gICAgICAgICAgICAke2hlYWRlckJ1dHRvbnN9XG4gICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgJHttYWluQ29udGVudEh0bWx9XG4gICAgICAgICAgJHtmb290ZXJIdG1sfVxuICAgICAgICA8L2Rpdj5cbiAgICAgIDwvZGl2PlxuICAgIGA7XG5cbiAgICBkb2N1bWVudC5ib2R5LmFwcGVuZENoaWxkKG1vZGFsKTtcblxuICAgIC8vIEF0dGFjaCBvbmNsaWNrIGhhbmRsZXJzIGZvciBidXR0b25zIHRoYXQgaGF2ZSB0aGVtXG4gICAgYnV0dG9uT25jbGlja3MuZm9yRWFjaCgoeyBpbmRleCwgb25jbGljayB9KSA9PiB7XG4gICAgICBjb25zdCBidG4gPSBtb2RhbC5xdWVyeVNlbGVjdG9yKGBbZGF0YS1tb2RhbC1idG4taW5kZXg9XCIke2luZGV4fVwiXWApO1xuICAgICAgaWYgKGJ0biAmJiB0eXBlb2Ygb25jbGljayA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgICBidG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoZSkgPT4gb25jbGljayhlLCBidG4pKTtcbiAgICAgIH1cbiAgICB9KTtcblxuICAgIGNvbnN0IGluc3RhbmNlID0gbmV3IFNPTW9kYWwobW9kYWwsIHtcbiAgICAgIC4uLm9wdGlvbnMsXG4gICAgICBhbmltYXRpb246IHRydWUsXG4gICAgICBzdGF0aWM6IGlzU3RhdGljLFxuICAgICAgZm9jdXNFbGVtZW50LFxuICAgICAgZHJhZ2dhYmxlLFxuICAgICAgbWF4aW1pemFibGUsXG4gICAgICBtb2JpbGVGdWxsc2NyZWVuLFxuICAgICAgbW9iaWxlQnJlYWtwb2ludCxcbiAgICAgIHNpZGViYXIsXG4gICAgICBzaWRlYmFyV2lkdGgsXG4gICAgfSk7XG5cbiAgICAvLyBTdG9yZSB0aGUgaW5zdGFuY2Ugb24gdGhlIGVsZW1lbnQgZm9yIGVhc3kgcmV0cmlldmFsXG4gICAgbW9kYWwuX3NvTW9kYWxJbnN0YW5jZSA9IGluc3RhbmNlO1xuXG4gICAgLy8gUmVnaXN0ZXIgc2luZ2xldG9uIGluc3RhbmNlXG4gICAgaWYgKHNpbmdsZXRvbikge1xuICAgICAgY29uc3QgaWQgPSBzaW5nbGV0b25JZCB8fCBgc2luZ2xldG9uLSR7dGl0bGUudG9Mb3dlckNhc2UoKS5yZXBsYWNlKC9cXHMrL2csICctJyl9YDtcbiAgICAgIFNPTW9kYWwuX3NpbmdsZXRvbkluc3RhbmNlcy5zZXQoaWQsIGluc3RhbmNlKTtcbiAgICB9XG5cbiAgICAvLyBSZW1vdmUgZnJvbSBET00gd2hlbiBoaWRkZW5cbiAgICBtb2RhbC5hZGRFdmVudExpc3RlbmVyKFNpeE9yYml0LmV2dChTT01vZGFsLkVWRU5UUy5ISURERU4pLCAoKSA9PiB7XG4gICAgICAvLyBSZW1vdmUgc2luZ2xldG9uIGZyb20gcmVnaXN0cnlcbiAgICAgIGlmIChzaW5nbGV0b24pIHtcbiAgICAgICAgY29uc3QgaWQgPSBzaW5nbGV0b25JZCB8fCBgc2luZ2xldG9uLSR7dGl0bGUudG9Mb3dlckNhc2UoKS5yZXBsYWNlKC9cXHMrL2csICctJyl9YDtcbiAgICAgICAgU09Nb2RhbC5fc2luZ2xldG9uSW5zdGFuY2VzLmRlbGV0ZShpZCk7XG4gICAgICB9XG4gICAgICBtb2RhbC5yZW1vdmUoKTtcbiAgICB9KTtcblxuICAgIHJldHVybiBpbnN0YW5jZTtcbiAgfVxuXG4gIC8qKlxuICAgKiBTaG93IGEgY29uZmlybWF0aW9uIGRpYWxvZyB3aXRoIGZsZXhpYmxlIGJ1dHRvbiBhbmQgaWNvbiBjb25maWd1cmF0aW9uXG4gICAqXG4gICAqIEBwYXJhbSB7T2JqZWN0fSBvcHRpb25zIC0gRGlhbG9nIG9wdGlvbnNcbiAgICogQHBhcmFtIHtzdHJpbmd9IG9wdGlvbnMudGl0bGUgLSBEaWFsb2cgdGl0bGVcbiAgICogQHBhcmFtIHtzdHJpbmd9IG9wdGlvbnMubWVzc2FnZSAtIERpYWxvZyBtZXNzYWdlXG4gICAqIEBwYXJhbSB7QXJyYXl9IG9wdGlvbnMuYWN0aW9ucyAtIEFycmF5IG9mIGFjdGlvbiBvYmplY3RzIGZvciBtdWx0aS1hY3Rpb24gZGlhbG9nc1xuICAgKlxuICAgKiBAcGFyYW0ge3N0cmluZ3xBcnJheXxPYmplY3R9IG9wdGlvbnMuY29uZmlybSAtIENvbmZpcm0gYnV0dG9uIChmbGV4aWJsZSBmb3JtYXQpOlxuICAgKiAgIC0gU3RyaW5nOiAnRGVsZXRlJyAoanVzdCB0ZXh0KVxuICAgKiAgIC0gQXJyYXk6IFt7IGljb246ICdkZWxldGUnIH0sICdEZWxldGUnXSAoaWNvbiArIHRleHQgaW4gb3JkZXIpXG4gICAqICAgLSBBcnJheTogWydDb250aW51ZScsIHsgaWNvbjogJ2Fycm93X2ZvcndhcmQnIH1dICh0ZXh0ICsgaWNvbilcbiAgICogICAtIEFycmF5OiBbeyBpY29uOiAnY2hlY2snIH0sICdTYXZlJywgeyBpY29uOiAnc2VuZCcgfV0gKG11bHRpcGxlIGljb25zKVxuICAgKiAgIC0gT2JqZWN0OiB7IGNvbnRlbnQ6IFsuLi5dLCBjbGFzczogJ3NvLWJ0bi1kYW5nZXInIH0gKHdpdGggY2xhc3Mgb3ZlcnJpZGUpXG4gICAqIEBwYXJhbSB7c3RyaW5nfEFycmF5fE9iamVjdH0gb3B0aW9ucy5jYW5jZWwgLSBDYW5jZWwgYnV0dG9uIChzYW1lIGZvcm1hdCBhcyBjb25maXJtKVxuICAgKlxuICAgKiBAcGFyYW0ge3N0cmluZ3xPYmplY3R9IG9wdGlvbnMuaWNvbiAtIERpYWxvZyBpY29uIGFib3ZlIHRpdGxlOlxuICAgKiAgIC0gU3RyaW5nOiAnd2FybmluZycgKGljb24gbmFtZSwgdHlwZSBmcm9tIGljb25UeXBlIG9yIGF1dG8pXG4gICAqICAgLSBPYmplY3Q6IHsgbmFtZTogJ3dhcm5pbmcnLCB0eXBlOiAnZGFuZ2VyJyB9IChpY29uIHdpdGggdHlwZSlcbiAgICogQHBhcmFtIHtzdHJpbmd9IG9wdGlvbnMuaWNvblR5cGUgLSBJY29uIGNvbG9yOiAnZGFuZ2VyJywgJ3dhcm5pbmcnLCAnc3VjY2VzcycsICdpbmZvJ1xuICAgKlxuICAgKiBAcGFyYW0ge2Jvb2xlYW59IG9wdGlvbnMuZGFuZ2VyIC0gVXNlIGRhbmdlciBzdHlsaW5nIChhdXRvLXNldHMgaWNvblR5cGUgdG8gJ2RhbmdlcicpXG4gICAqIEBwYXJhbSB7Ym9vbGVhbn0gb3B0aW9ucy5zdGF0aWMgLSBDYW5ub3QgYmUgZGlzbWlzc2VkIHdpdGhvdXQgY2xpY2tpbmcgYSBidXR0b25cbiAgICogQHBhcmFtIHtzdHJpbmd9IG9wdGlvbnMuYnV0dG9uUG9zaXRpb24gLSBGb290ZXIgYWxpZ25tZW50OiAnbGVmdCcsICdjZW50ZXInLCAncmlnaHQnLCAnYmV0d2VlbicsICdhcm91bmQnXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBvcHRpb25zLmJ1dHRvbkxheW91dCAtICdpbmxpbmUnIChzaWRlIGJ5IHNpZGUpIG9yICdzdGFja2VkJyAodmVydGljYWwpXG4gICAqIEBwYXJhbSB7Ym9vbGVhbn0gb3B0aW9ucy5mdWxsV2lkdGhCdXR0b25zIC0gTWFrZSBidXR0b25zIGZ1bGwgd2lkdGhcbiAgICogQHBhcmFtIHtib29sZWFufSBvcHRpb25zLnJldmVyc2VCdXR0b25zIC0gU3dhcCBjYW5jZWwvY29uZmlybSBvcmRlclxuICAgKiBAcGFyYW0ge2Jvb2xlYW59IG9wdGlvbnMuc2hvd0Nsb3NlQnV0dG9uIC0gU2hvdyBYIGNsb3NlIGJ1dHRvbiBpbiBoZWFkZXJcbiAgICogQHBhcmFtIHtzdHJpbmd9IG9wdGlvbnMuZm9jdXNFbGVtZW50IC0gRWxlbWVudCB0byBmb2N1cyBvbiBvcGVuOiAnZm9vdGVyJyAoZGVmYXVsdCksICdjbG9zZScsICdmaXJzdCcsIG9yIENTUyBzZWxlY3RvclxuICAgKlxuICAgKiBAcGFyYW0ge3N0cmluZ30gb3B0aW9ucy5jb25maXJtVGV4dCAtIExlZ2FjeTogdGV4dCBmb3IgY29uZmlybSBidXR0b25cbiAgICogQHBhcmFtIHtzdHJpbmd9IG9wdGlvbnMuY2FuY2VsVGV4dCAtIExlZ2FjeTogdGV4dCBmb3IgY2FuY2VsIGJ1dHRvblxuICAgKiBAcGFyYW0ge3N0cmluZ30gb3B0aW9ucy5jb25maXJtSWNvbiAtIExlZ2FjeTogaWNvbiBvbiBjb25maXJtIGJ1dHRvblxuICAgKiBAcGFyYW0ge3N0cmluZ30gb3B0aW9ucy5jb25maXJtSWNvblBvc2l0aW9uIC0gTGVnYWN5OiAnbGVmdCcgb3IgJ3JpZ2h0J1xuICAgKiBAcGFyYW0ge3N0cmluZ30gb3B0aW9ucy5jYW5jZWxJY29uIC0gTGVnYWN5OiBpY29uIG9uIGNhbmNlbCBidXR0b25cbiAgICogQHBhcmFtIHtzdHJpbmd9IG9wdGlvbnMuY2FuY2VsSWNvblBvc2l0aW9uIC0gTGVnYWN5OiAnbGVmdCcgb3IgJ3JpZ2h0J1xuICAgKlxuICAgKiBAcmV0dXJucyB7UHJvbWlzZTxzdHJpbmd8Ym9vbGVhbj59IFJlc29sdmVzIHdpdGggYWN0aW9uIGlkL3RydWUvZmFsc2Ugb3IgJ2Rpc21pc3MnIGlmIGNsb3NlZFxuICAgKlxuICAgKiBAZXhhbXBsZVxuICAgKiAvLyBGbGV4aWJsZSBidXR0b24gQVBJXG4gICAqIFNPTW9kYWwuY29uZmlybSh7XG4gICAqICAgdGl0bGU6ICdEZWxldGUgSXRlbScsXG4gICAqICAgbWVzc2FnZTogJ1RoaXMgY2Fubm90IGJlIHVuZG9uZS4nLFxuICAgKiAgIGljb246IHsgbmFtZTogJ2RlbGV0ZScsIHR5cGU6ICdkYW5nZXInIH0sXG4gICAqICAgY29uZmlybTogW3sgaWNvbjogJ2RlbGV0ZScgfSwgJ0RlbGV0ZSddLFxuICAgKiAgIGNhbmNlbDogJ0NhbmNlbCcsXG4gICAqICAgZGFuZ2VyOiB0cnVlXG4gICAqIH0pO1xuICAgKlxuICAgKiBAZXhhbXBsZVxuICAgKiAvLyBNdWx0aXBsZSBpY29ucyBvbiBidXR0b25cbiAgICogU09Nb2RhbC5jb25maXJtKHtcbiAgICogICBjb25maXJtOiBbeyBpY29uOiAnY2xvdWRfdXBsb2FkJyB9LCAnVXBsb2FkJywgeyBpY29uOiAnY2hlY2snIH1dXG4gICAqIH0pO1xuICAgKi9cbiAgc3RhdGljIGNvbmZpcm0ob3B0aW9ucyA9IHt9KSB7XG4gICAgY29uc3Qge1xuICAgICAgdGl0bGUgPSAnQ29uZmlybScsXG4gICAgICBtZXNzYWdlID0gJ0FyZSB5b3Ugc3VyZT8nLFxuICAgICAgYWN0aW9ucyA9IG51bGwsXG4gICAgICAvLyBOZXcgZmxleGlibGUgYnV0dG9uIEFQSSAodGFrZXMgcHJlY2VkZW5jZSBvdmVyIGxlZ2FjeSBvcHRpb25zKVxuICAgICAgY29uZmlybTogY29uZmlybU9wdCA9IG51bGwsXG4gICAgICBjYW5jZWw6IGNhbmNlbE9wdCA9IG51bGwsXG4gICAgICAvLyBMZWdhY3kgYnV0dG9uIG9wdGlvbnMgKGZvciBiYWNrd2FyZHMgY29tcGF0aWJpbGl0eSlcbiAgICAgIGNvbmZpcm1UZXh0ID0gJ0NvbmZpcm0nLFxuICAgICAgY2FuY2VsVGV4dCA9ICdDYW5jZWwnLFxuICAgICAgY29uZmlybUNsYXNzID0gJ3NvLWJ0bi1wcmltYXJ5JyxcbiAgICAgIGNvbmZpcm1JY29uID0gbnVsbCxcbiAgICAgIGNvbmZpcm1JY29uUG9zaXRpb24gPSAnbGVmdCcsXG4gICAgICBjYW5jZWxJY29uID0gbnVsbCxcbiAgICAgIGNhbmNlbEljb25Qb3NpdGlvbiA9ICdsZWZ0JyxcbiAgICAgIC8vIFN0eWxpbmcgb3B0aW9uc1xuICAgICAgZGFuZ2VyID0gZmFsc2UsXG4gICAgICBjbG9zYWJsZSA9IHRydWUsXG4gICAgICBzdGF0aWM6IGlzU3RhdGljID0gZmFsc2UsXG4gICAgICAvLyBEaWFsb2cgaWNvbiBvcHRpb25zXG4gICAgICBpY29uID0gbnVsbCxcbiAgICAgIGljb25UeXBlID0gbnVsbCxcbiAgICAgIC8vIExheW91dCBvcHRpb25zXG4gICAgICBidXR0b25Qb3NpdGlvbiA9ICdjZW50ZXInLFxuICAgICAgYnV0dG9uTGF5b3V0ID0gJ2lubGluZScsXG4gICAgICBmdWxsV2lkdGhCdXR0b25zID0gZmFsc2UsXG4gICAgICByZXZlcnNlQnV0dG9ucyA9IGZhbHNlLFxuICAgICAgc2hvd0Nsb3NlQnV0dG9uID0gZmFsc2UsXG4gICAgICBzaXplID0gJ3NtJyxcbiAgICAgIC8vIEZvY3VzIG9wdGlvbnNcbiAgICAgIGZvY3VzRWxlbWVudCA9ICdmb290ZXInLFxuICAgIH0gPSBvcHRpb25zO1xuXG4gICAgcmV0dXJuIG5ldyBQcm9taXNlKChyZXNvbHZlKSA9PiB7XG4gICAgICBsZXQgcmVzb2x2ZWQgPSBmYWxzZTtcblxuICAgICAgLyoqXG4gICAgICAgKiBQYXJzZSBidXR0b24gY29udGVudCBmcm9tIHZhcmlvdXMgZm9ybWF0czpcbiAgICAgICAqIC0gU3RyaW5nOiAnRGVsZXRlJyBcdTIxOTIganVzdCB0ZXh0XG4gICAgICAgKiAtIEFycmF5OiBbeyBpY29uOiAnZGVsZXRlJyB9LCAnRGVsZXRlJ10gXHUyMTkyIGljb24gdGhlbiB0ZXh0XG4gICAgICAgKiAtIEFycmF5OiBbJ0RlbGV0ZScsIHsgaWNvbjogJ2Fycm93X2ZvcndhcmQnIH1dIFx1MjE5MiB0ZXh0IHRoZW4gaWNvblxuICAgICAgICogLSBBcnJheTogW3sgaWNvbjogJ2NoZWNrJyB9LCAnU2F2ZScsIHsgaWNvbjogJ3NlbmQnIH1dIFx1MjE5MiBtdWx0aXBsZSBpY29uc1xuICAgICAgICogLSBPYmplY3Q6IHsgY29udGVudDogWy4uLl0sIGNsYXNzOiAnc28tYnRuLWRhbmdlcicgfSBcdTIxOTIgd2l0aCBjbGFzcyBvdmVycmlkZVxuICAgICAgICovXG4gICAgICBjb25zdCBwYXJzZUJ1dHRvbkNvbnRlbnQgPSAoY29udGVudCkgPT4ge1xuICAgICAgICBpZiAodHlwZW9mIGNvbnRlbnQgPT09ICdzdHJpbmcnKSB7XG4gICAgICAgICAgcmV0dXJuIGNvbnRlbnQ7XG4gICAgICAgIH1cbiAgICAgICAgaWYgKEFycmF5LmlzQXJyYXkoY29udGVudCkpIHtcbiAgICAgICAgICByZXR1cm4gY29udGVudC5tYXAocGFydCA9PiB7XG4gICAgICAgICAgICBpZiAodHlwZW9mIHBhcnQgPT09ICdzdHJpbmcnKSB7XG4gICAgICAgICAgICAgIHJldHVybiBwYXJ0O1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgaWYgKHBhcnQgJiYgdHlwZW9mIHBhcnQgPT09ICdvYmplY3QnICYmIHBhcnQuaWNvbikge1xuICAgICAgICAgICAgICByZXR1cm4gYDxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnNcIj4ke3BhcnQuaWNvbn08L3NwYW4+YDtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIHJldHVybiAnJztcbiAgICAgICAgICB9KS5qb2luKCcnKTtcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gJyc7XG4gICAgICB9O1xuXG4gICAgICAvKipcbiAgICAgICAqIENyZWF0ZSBidXR0b24gSFRNTCBmcm9tIGZsZXhpYmxlIGZvcm1hdFxuICAgICAgICogQHBhcmFtIHtzdHJpbmd8QXJyYXl8T2JqZWN0fSBidG5Db25maWcgLSBCdXR0b24gY29uZmlndXJhdGlvblxuICAgICAgICogQHBhcmFtIHtzdHJpbmd9IGRlZmF1bHRDbGFzcyAtIERlZmF1bHQgYnV0dG9uIGNsYXNzXG4gICAgICAgKiBAcGFyYW0ge3N0cmluZ30gYWN0aW9uSWQgLSBBY3Rpb24gaWRlbnRpZmllclxuICAgICAgICogQHBhcmFtIHtib29sZWFufSBpc0Z1bGxXaWR0aCAtIFdoZXRoZXIgYnV0dG9uIHNob3VsZCBiZSBmdWxsIHdpZHRoXG4gICAgICAgKi9cbiAgICAgIGNvbnN0IGNyZWF0ZUZsZXhpYmxlQnV0dG9uID0gKGJ0bkNvbmZpZywgZGVmYXVsdENsYXNzLCBhY3Rpb25JZCwgaXNGdWxsV2lkdGgpID0+IHtcbiAgICAgICAgbGV0IGNvbnRlbnQsIGJ0bkNsYXNzO1xuXG4gICAgICAgIGlmICh0eXBlb2YgYnRuQ29uZmlnID09PSAnc3RyaW5nJykge1xuICAgICAgICAgIC8vIFNpbXBsZSBzdHJpbmc6ICdEZWxldGUnXG4gICAgICAgICAgY29udGVudCA9IGJ0bkNvbmZpZztcbiAgICAgICAgICBidG5DbGFzcyA9IGRlZmF1bHRDbGFzcztcbiAgICAgICAgfSBlbHNlIGlmIChBcnJheS5pc0FycmF5KGJ0bkNvbmZpZykpIHtcbiAgICAgICAgICAvLyBBcnJheSBmb3JtYXQ6IFt7IGljb246ICdkZWxldGUnIH0sICdEZWxldGUnXVxuICAgICAgICAgIGNvbnRlbnQgPSBwYXJzZUJ1dHRvbkNvbnRlbnQoYnRuQ29uZmlnKTtcbiAgICAgICAgICBidG5DbGFzcyA9IGRlZmF1bHRDbGFzcztcbiAgICAgICAgfSBlbHNlIGlmIChidG5Db25maWcgJiYgdHlwZW9mIGJ0bkNvbmZpZyA9PT0gJ29iamVjdCcpIHtcbiAgICAgICAgICAvLyBPYmplY3QgZm9ybWF0OiB7IGNvbnRlbnQ6IFsuLi5dLCBjbGFzczogJ3NvLWJ0bi1kYW5nZXInIH1cbiAgICAgICAgICBjb250ZW50ID0gcGFyc2VCdXR0b25Db250ZW50KGJ0bkNvbmZpZy5jb250ZW50IHx8IGJ0bkNvbmZpZy50ZXh0IHx8ICcnKTtcbiAgICAgICAgICBidG5DbGFzcyA9IGJ0bkNvbmZpZy5jbGFzcyB8fCBkZWZhdWx0Q2xhc3M7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgY29udGVudCA9ICcnO1xuICAgICAgICAgIGJ0bkNsYXNzID0gZGVmYXVsdENsYXNzO1xuICAgICAgICB9XG5cbiAgICAgICAgY29uc3Qgd2lkdGhDbGFzcyA9IGlzRnVsbFdpZHRoID8gJyBzby13LTEwMCcgOiAnJztcbiAgICAgICAgcmV0dXJuIGA8YnV0dG9uIHR5cGU9XCJidXR0b25cIiBjbGFzcz1cInNvLWJ0biAke2J0bkNsYXNzfSR7d2lkdGhDbGFzc31cIiBkYXRhLW1vZGFsLWFjdGlvbj1cIiR7YWN0aW9uSWR9XCI+JHtjb250ZW50fTwvYnV0dG9uPmA7XG4gICAgICB9O1xuXG4gICAgICAvKipcbiAgICAgICAqIExlZ2FjeSBoZWxwZXIgdG8gY3JlYXRlIGJ1dHRvbiBIVE1MIHdpdGggb3B0aW9uYWwgaWNvblxuICAgICAgICogKGtlcHQgZm9yIGJhY2t3YXJkcyBjb21wYXRpYmlsaXR5IHdpdGggb2xkIG9wdGlvbnMpXG4gICAgICAgKi9cbiAgICAgIGNvbnN0IGNyZWF0ZUxlZ2FjeUJ1dHRvbiA9ICh0ZXh0LCBidG5DbGFzcywgYWN0aW9uSWQsIGJ0bkljb24sIGljb25Qb3MsIGlzRnVsbFdpZHRoKSA9PiB7XG4gICAgICAgIGNvbnN0IGljb25IdG1sID0gYnRuSWNvbiA/IGA8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+JHtidG5JY29ufTwvc3Bhbj5gIDogJyc7XG4gICAgICAgIGNvbnN0IHdpZHRoQ2xhc3MgPSBpc0Z1bGxXaWR0aCA/ICcgc28tdy0xMDAnIDogJyc7XG4gICAgICAgIGlmIChpY29uUG9zID09PSAncmlnaHQnKSB7XG4gICAgICAgICAgcmV0dXJuIGA8YnV0dG9uIHR5cGU9XCJidXR0b25cIiBjbGFzcz1cInNvLWJ0biAke2J0bkNsYXNzfSR7d2lkdGhDbGFzc31cIiBkYXRhLW1vZGFsLWFjdGlvbj1cIiR7YWN0aW9uSWR9XCI+JHt0ZXh0fSR7aWNvbkh0bWx9PC9idXR0b24+YDtcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gYDxidXR0b24gdHlwZT1cImJ1dHRvblwiIGNsYXNzPVwic28tYnRuICR7YnRuQ2xhc3N9JHt3aWR0aENsYXNzfVwiIGRhdGEtbW9kYWwtYWN0aW9uPVwiJHthY3Rpb25JZH1cIj4ke2ljb25IdG1sfSR7dGV4dH08L2J1dHRvbj5gO1xuICAgICAgfTtcblxuICAgICAgLy8gQnVpbGQgZm9vdGVyIEhUTUxcbiAgICAgIGxldCBmb290ZXJIdG1sID0gJyc7XG4gICAgICBsZXQgdXNlU2VjdGlvbnNMYXlvdXQgPSBmYWxzZTtcblxuICAgICAgaWYgKGFjdGlvbnMgJiYgQXJyYXkuaXNBcnJheShhY3Rpb25zKSkge1xuICAgICAgICAvLyBNdWx0aXBsZSBhY3Rpb25zIG1vZGUgLSBzdXBwb3J0cyBib3RoIG5ldyBhbmQgbGVnYWN5IGZvcm1hdCBpbiBhY3Rpb24gb2JqZWN0c1xuICAgICAgICBjb25zdCBidXR0b25zID0gYWN0aW9ucy5tYXAoYWN0aW9uID0+IHtcbiAgICAgICAgICBpZiAoYWN0aW9uLmNvbnRlbnQgfHwgQXJyYXkuaXNBcnJheShhY3Rpb24uY29udGVudCkpIHtcbiAgICAgICAgICAgIC8vIE5ldyBmb3JtYXQgaW4gYWN0aW9uczogeyBpZDogJ3NhdmUnLCBjb250ZW50OiBbeyBpY29uOiAnc2F2ZScgfSwgJ1NhdmUnXSwgY2xhc3M6ICdzby1idG4tcHJpbWFyeScgfVxuICAgICAgICAgICAgcmV0dXJuIGNyZWF0ZUZsZXhpYmxlQnV0dG9uKFxuICAgICAgICAgICAgICB7IGNvbnRlbnQ6IGFjdGlvbi5jb250ZW50LCBjbGFzczogYWN0aW9uLmNsYXNzIHx8IChhY3Rpb24ucHJpbWFyeSA/ICdzby1idG4tcHJpbWFyeScgOiAnc28tYnRuLW91dGxpbmUnKSB9LFxuICAgICAgICAgICAgICBhY3Rpb24uY2xhc3MgfHwgKGFjdGlvbi5wcmltYXJ5ID8gJ3NvLWJ0bi1wcmltYXJ5JyA6ICdzby1idG4tb3V0bGluZScpLFxuICAgICAgICAgICAgICBhY3Rpb24uaWQsXG4gICAgICAgICAgICAgIGZ1bGxXaWR0aEJ1dHRvbnNcbiAgICAgICAgICAgICk7XG4gICAgICAgICAgfVxuICAgICAgICAgIC8vIExlZ2FjeSBmb3JtYXQgaW4gYWN0aW9uczogeyBpZDogJ3NhdmUnLCB0ZXh0OiAnU2F2ZScsIGljb246ICdzYXZlJywgY2xhc3M6ICdzby1idG4tcHJpbWFyeScgfVxuICAgICAgICAgIGNvbnN0IGJ0bkNsYXNzID0gYWN0aW9uLmNsYXNzIHx8IChhY3Rpb24ucHJpbWFyeSA/ICdzby1idG4tcHJpbWFyeScgOiAnc28tYnRuLW91dGxpbmUnKTtcbiAgICAgICAgICByZXR1cm4gY3JlYXRlTGVnYWN5QnV0dG9uKGFjdGlvbi50ZXh0LCBidG5DbGFzcywgYWN0aW9uLmlkLCBhY3Rpb24uaWNvbiwgYWN0aW9uLmljb25Qb3NpdGlvbiB8fCAnbGVmdCcsIGZ1bGxXaWR0aEJ1dHRvbnMpO1xuICAgICAgICB9KTtcbiAgICAgICAgZm9vdGVySHRtbCA9IGJ1dHRvbnMuam9pbignXFxuJyk7XG4gICAgICB9IGVsc2UgaWYgKGFjdGlvbnMgJiYgdHlwZW9mIGFjdGlvbnMgPT09ICdvYmplY3QnICYmIChhY3Rpb25zLmxlZnQgfHwgYWN0aW9ucy5jZW50ZXIgfHwgYWN0aW9ucy5yaWdodCkpIHtcbiAgICAgICAgLy8gU2VjdGlvbnMgZm9ybWF0OiB7IGxlZnQ6IFsuLi5dLCBjZW50ZXI6IFsuLi5dLCByaWdodDogWy4uLl0gfVxuICAgICAgICB1c2VTZWN0aW9uc0xheW91dCA9IHRydWU7XG4gICAgICAgIGNvbnN0IGRlZmF1bHRDb25maXJtQ2xhc3MgPSBkYW5nZXIgPyAnc28tYnRuLWRhbmdlcicgOiBjb25maXJtQ2xhc3M7XG5cbiAgICAgICAgY29uc3QgY3JlYXRlU2VjdGlvbkJ1dHRvbiA9IChidG4pID0+IHtcbiAgICAgICAgICBpZiAoYnRuLmNvbnRlbnQgfHwgQXJyYXkuaXNBcnJheShidG4uY29udGVudCkgfHwgdHlwZW9mIGJ0biA9PT0gJ3N0cmluZycgfHwgQXJyYXkuaXNBcnJheShidG4pKSB7XG4gICAgICAgICAgICBjb25zdCBidG5DbGFzcyA9IGJ0bi5jbGFzcyB8fCAoYnRuLnByaW1hcnkgPyBkZWZhdWx0Q29uZmlybUNsYXNzIDogJ3NvLWJ0bi1vdXRsaW5lJyk7XG4gICAgICAgICAgICByZXR1cm4gY3JlYXRlRmxleGlibGVCdXR0b24oYnRuLCBidG5DbGFzcywgYnRuLmlkIHx8IGJ0bi5hY3Rpb24gfHwgJ2FjdGlvbicsIGZ1bGxXaWR0aEJ1dHRvbnMpO1xuICAgICAgICAgIH1cbiAgICAgICAgICBjb25zdCBidG5DbGFzcyA9IGJ0bi5jbGFzcyB8fCAoYnRuLnByaW1hcnkgPyBkZWZhdWx0Q29uZmlybUNsYXNzIDogJ3NvLWJ0bi1vdXRsaW5lJyk7XG4gICAgICAgICAgcmV0dXJuIGNyZWF0ZUxlZ2FjeUJ1dHRvbihidG4udGV4dCB8fCAnJywgYnRuQ2xhc3MsIGJ0bi5pZCB8fCBidG4uYWN0aW9uIHx8ICdhY3Rpb24nLCBidG4uaWNvbiwgYnRuLmljb25Qb3NpdGlvbiB8fCAnbGVmdCcsIGZ1bGxXaWR0aEJ1dHRvbnMpO1xuICAgICAgICB9O1xuXG4gICAgICAgIGNvbnN0IGNyZWF0ZVNlY3Rpb24gPSAoYnV0dG9ucykgPT4ge1xuICAgICAgICAgIGlmICghYnV0dG9ucyB8fCAhQXJyYXkuaXNBcnJheShidXR0b25zKSkgcmV0dXJuICcnO1xuICAgICAgICAgIHJldHVybiBidXR0b25zLm1hcChjcmVhdGVTZWN0aW9uQnV0dG9uKS5qb2luKCdcXG4nKTtcbiAgICAgICAgfTtcblxuICAgICAgICBjb25zdCBsZWZ0SHRtbCA9IGA8ZGl2IGNsYXNzPVwic28tZm9vdGVyLWxlZnRcIj4ke2NyZWF0ZVNlY3Rpb24oYWN0aW9ucy5sZWZ0KX08L2Rpdj5gO1xuICAgICAgICBjb25zdCBjZW50ZXJIdG1sID0gYDxkaXYgY2xhc3M9XCJzby1mb290ZXItY2VudGVyXCI+JHtjcmVhdGVTZWN0aW9uKGFjdGlvbnMuY2VudGVyKX08L2Rpdj5gO1xuICAgICAgICBjb25zdCByaWdodEh0bWwgPSBgPGRpdiBjbGFzcz1cInNvLWZvb3Rlci1yaWdodFwiPiR7Y3JlYXRlU2VjdGlvbihhY3Rpb25zLnJpZ2h0KX08L2Rpdj5gO1xuXG4gICAgICAgIGZvb3Rlckh0bWwgPSBgJHtsZWZ0SHRtbH1cXG4ke2NlbnRlckh0bWx9XFxuJHtyaWdodEh0bWx9YDtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIC8vIFNpbXBsZSBjb25maXJtL2NhbmNlbCBtb2RlXG4gICAgICAgIGNvbnN0IGRlZmF1bHRDb25maXJtQ2xhc3MgPSBkYW5nZXIgPyAnc28tYnRuLWRhbmdlcicgOiBjb25maXJtQ2xhc3M7XG5cbiAgICAgICAgbGV0IGNhbmNlbEJ0biwgY29uZmlybUJ0bjtcblxuICAgICAgICAvLyBVc2UgbmV3IGZsZXhpYmxlIEFQSSBpZiBwcm92aWRlZCwgb3RoZXJ3aXNlIGZhbGwgYmFjayB0byBsZWdhY3kgb3B0aW9uc1xuICAgICAgICBpZiAoY2FuY2VsT3B0ICE9PSBudWxsKSB7XG4gICAgICAgICAgY2FuY2VsQnRuID0gY3JlYXRlRmxleGlibGVCdXR0b24oY2FuY2VsT3B0LCAnc28tYnRuLW91dGxpbmUnLCAnY2FuY2VsJywgZnVsbFdpZHRoQnV0dG9ucyk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgY2FuY2VsQnRuID0gY3JlYXRlTGVnYWN5QnV0dG9uKGNhbmNlbFRleHQsICdzby1idG4tb3V0bGluZScsICdjYW5jZWwnLCBjYW5jZWxJY29uLCBjYW5jZWxJY29uUG9zaXRpb24sIGZ1bGxXaWR0aEJ1dHRvbnMpO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYgKGNvbmZpcm1PcHQgIT09IG51bGwpIHtcbiAgICAgICAgICBjb25maXJtQnRuID0gY3JlYXRlRmxleGlibGVCdXR0b24oY29uZmlybU9wdCwgZGVmYXVsdENvbmZpcm1DbGFzcywgJ2NvbmZpcm0nLCBmdWxsV2lkdGhCdXR0b25zKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICBjb25maXJtQnRuID0gY3JlYXRlTGVnYWN5QnV0dG9uKGNvbmZpcm1UZXh0LCBkZWZhdWx0Q29uZmlybUNsYXNzLCAnY29uZmlybScsIGNvbmZpcm1JY29uLCBjb25maXJtSWNvblBvc2l0aW9uLCBmdWxsV2lkdGhCdXR0b25zKTtcbiAgICAgICAgfVxuXG4gICAgICAgIC8vIE9yZGVyIGJ1dHRvbnMgYmFzZWQgb24gcmV2ZXJzZUJ1dHRvbnNcbiAgICAgICAgZm9vdGVySHRtbCA9IHJldmVyc2VCdXR0b25zID8gYCR7Y29uZmlybUJ0bn1cXG4ke2NhbmNlbEJ0bn1gIDogYCR7Y2FuY2VsQnRufVxcbiR7Y29uZmlybUJ0bn1gO1xuICAgICAgfVxuXG4gICAgICAvKipcbiAgICAgICAqIFBhcnNlIGRpYWxvZyBpY29uIGZyb20gdmFyaW91cyBmb3JtYXRzOlxuICAgICAgICogLSBTdHJpbmc6ICdhcnJvd19mb3J3YXJkJyBcdTIxOTIgdXNlIGljb25UeXBlIG9yIGRlZmF1bHRcbiAgICAgICAqIC0gT2JqZWN0OiB7IG5hbWU6ICdhcnJvd19mb3J3YXJkJywgdHlwZTogJ2luZm8nIH1cbiAgICAgICAqIC0gT2JqZWN0OiB7IGljb246ICdhcnJvd19mb3J3YXJkJywgdHlwZTogJ3dhcm5pbmcnIH1cbiAgICAgICAqL1xuICAgICAgbGV0IHJlc29sdmVkSWNvbk5hbWUgPSBudWxsO1xuICAgICAgbGV0IHJlc29sdmVkSWNvblR5cGUgPSBpY29uVHlwZSB8fCAoZGFuZ2VyID8gJ2RhbmdlcicgOiAnaW5mbycpO1xuXG4gICAgICBpZiAoaWNvbikge1xuICAgICAgICBpZiAodHlwZW9mIGljb24gPT09ICdzdHJpbmcnKSB7XG4gICAgICAgICAgcmVzb2x2ZWRJY29uTmFtZSA9IGljb247XG4gICAgICAgIH0gZWxzZSBpZiAodHlwZW9mIGljb24gPT09ICdvYmplY3QnKSB7XG4gICAgICAgICAgcmVzb2x2ZWRJY29uTmFtZSA9IGljb24ubmFtZSB8fCBpY29uLmljb24gfHwgbnVsbDtcbiAgICAgICAgICBpZiAoaWNvbi50eXBlKSB7XG4gICAgICAgICAgICByZXNvbHZlZEljb25UeXBlID0gaWNvbi50eXBlO1xuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfVxuXG4gICAgICAvLyBCdWlsZCBjb250ZW50IEhUTUxcbiAgICAgIGxldCBjb250ZW50SHRtbCA9ICcnO1xuICAgICAgaWYgKHJlc29sdmVkSWNvbk5hbWUpIHtcbiAgICAgICAgLy8gVXNlIGNlbnRlcmVkIGNvbmZpcm0gZGlhbG9nIGxheW91dFxuICAgICAgICBjb250ZW50SHRtbCA9IGBcbiAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tY29uZmlybS1pY29uIHNvLSR7cmVzb2x2ZWRJY29uVHlwZX1cIj5cbiAgICAgICAgICAgIDxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnNcIj4ke3Jlc29sdmVkSWNvbk5hbWV9PC9zcGFuPlxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgIDxoMyBjbGFzcz1cInNvLWNvbmZpcm0tdGl0bGVcIj4ke3RpdGxlfTwvaDM+XG4gICAgICAgICAgPHAgY2xhc3M9XCJzby1jb25maXJtLW1lc3NhZ2VcIj4ke21lc3NhZ2V9PC9wPlxuICAgICAgICBgO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgY29udGVudEh0bWwgPSBgPHA+JHttZXNzYWdlfTwvcD5gO1xuICAgICAgfVxuXG4gICAgICAvLyBCdWlsZCBmb290ZXIgY2xhc3Nlc1xuICAgICAgbGV0IGZvb3RlckNsYXNzZXMgPSAnJztcbiAgICAgIGlmICh1c2VTZWN0aW9uc0xheW91dCkge1xuICAgICAgICBmb290ZXJDbGFzc2VzID0gJ3NvLWZvb3Rlci1zZWN0aW9ucyc7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICBjb25zdCBwb3NpdGlvbkNsYXNzTWFwID0ge1xuICAgICAgICAgIGxlZnQ6ICdqdXN0aWZ5LXN0YXJ0JyxcbiAgICAgICAgICBjZW50ZXI6ICdqdXN0aWZ5LWNlbnRlcicsXG4gICAgICAgICAgcmlnaHQ6ICdqdXN0aWZ5LWVuZCcsXG4gICAgICAgICAgYmV0d2VlbjogJ2p1c3RpZnktYmV0d2VlbicsXG4gICAgICAgICAgYXJvdW5kOiAnanVzdGlmeS1hcm91bmQnLFxuICAgICAgICB9O1xuICAgICAgICBjb25zdCBwb3NpdGlvbkNsYXNzID0gcG9zaXRpb25DbGFzc01hcFtidXR0b25Qb3NpdGlvbl0gfHwgJ2p1c3RpZnktY2VudGVyJztcbiAgICAgICAgY29uc3QgbGF5b3V0Q2xhc3MgPSBidXR0b25MYXlvdXQgPT09ICdzdGFja2VkJyA/ICdzby1mbGV4LWNvbHVtbicgOiAnJztcbiAgICAgICAgZm9vdGVyQ2xhc3NlcyA9IFtwb3NpdGlvbkNsYXNzLCBsYXlvdXRDbGFzc10uZmlsdGVyKEJvb2xlYW4pLmpvaW4oJyAnKTtcbiAgICAgIH1cblxuICAgICAgLy8gTW9kYWwgY2xhc3Nlc1xuICAgICAgY29uc3QgbW9kYWxDbGFzc2VzID0gcmVzb2x2ZWRJY29uTmFtZSA/ICdzby1jb25maXJtLWRpYWxvZycgOiAnJztcblxuICAgICAgLy8gQ3JlYXRlIG1vZGFsIHdpdGggY3VzdG9tIHN0cnVjdHVyZSBmb3IgY2VudGVyZWQgaWNvbiBsYXlvdXRcbiAgICAgIGNvbnN0IG1vZGFsRWwgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcbiAgICAgIG1vZGFsRWwuY2xhc3NOYW1lID0gYHNvLW1vZGFsIHNvLWZhZGUgc28tbW9kYWwtJHtzaXplfSAke21vZGFsQ2xhc3Nlc31gLnRyaW0oKTtcbiAgICAgIG1vZGFsRWwudGFiSW5kZXggPSAtMTtcblxuICAgICAgLy8gQnVpbGQgaGVhZGVyIEhUTUwgLSBvbmx5IGNsb3NlIGJ1dHRvbiBpZiBzaG93Q2xvc2VCdXR0b24gaXMgdHJ1ZVxuICAgICAgbGV0IGhlYWRlckh0bWwgPSAnJztcbiAgICAgIGlmIChyZXNvbHZlZEljb25OYW1lKSB7XG4gICAgICAgIC8vIEZvciBjZW50ZXJlZCBsYXlvdXQsIGhlYWRlciBvbmx5IGNvbnRhaW5zIGNsb3NlIGJ1dHRvbiAoaWYgc2hvd24pXG4gICAgICAgIGlmIChzaG93Q2xvc2VCdXR0b24gJiYgIWlzU3RhdGljKSB7XG4gICAgICAgICAgaGVhZGVySHRtbCA9IGBcbiAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1tb2RhbC1oZWFkZXJcIiBzdHlsZT1cImJvcmRlci1ib3R0b206IG5vbmU7IHBhZGRpbmctYm90dG9tOiAwOyBqdXN0aWZ5LWNvbnRlbnQ6IGZsZXgtZW5kO1wiPlxuICAgICAgICAgICAgICA8YnV0dG9uIHR5cGU9XCJidXR0b25cIiBjbGFzcz1cInNvLW1vZGFsLWNsb3NlXCIgZGF0YS1kaXNtaXNzPVwibW9kYWxcIj5cbiAgICAgICAgICAgICAgICA8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+Y2xvc2U8L3NwYW4+XG4gICAgICAgICAgICAgIDwvYnV0dG9uPlxuICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgYDtcbiAgICAgICAgfVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgLy8gUmVndWxhciBsYXlvdXQgd2l0aCB0aXRsZSBpbiBoZWFkZXJcbiAgICAgICAgY29uc3QgY2xvc2VCdG4gPSAoc2hvd0Nsb3NlQnV0dG9uICYmICFpc1N0YXRpYylcbiAgICAgICAgICA/ICc8YnV0dG9uIHR5cGU9XCJidXR0b25cIiBjbGFzcz1cInNvLW1vZGFsLWNsb3NlXCIgZGF0YS1kaXNtaXNzPVwibW9kYWxcIj48c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+Y2xvc2U8L3NwYW4+PC9idXR0b24+J1xuICAgICAgICAgIDogJyc7XG4gICAgICAgIGhlYWRlckh0bWwgPSBgXG4gICAgICAgICAgPGRpdiBjbGFzcz1cInNvLW1vZGFsLWhlYWRlclwiPlxuICAgICAgICAgICAgPGg1IGNsYXNzPVwic28tbW9kYWwtdGl0bGVcIj4ke3RpdGxlfTwvaDU+XG4gICAgICAgICAgICAke2Nsb3NlQnRufVxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICBgO1xuICAgICAgfVxuXG4gICAgICBtb2RhbEVsLmlubmVySFRNTCA9IGBcbiAgICAgICAgPGRpdiBjbGFzcz1cInNvLW1vZGFsLWRpYWxvZ1wiPlxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1tb2RhbC1jb250ZW50XCI+XG4gICAgICAgICAgICAke2hlYWRlckh0bWx9XG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tbW9kYWwtYm9keVwiPlxuICAgICAgICAgICAgICAke2NvbnRlbnRIdG1sfVxuICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tbW9kYWwtZm9vdGVyICR7Zm9vdGVyQ2xhc3Nlc31cIj5cbiAgICAgICAgICAgICAgJHtmb290ZXJIdG1sfVxuICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgPC9kaXY+XG4gICAgICAgIDwvZGl2PlxuICAgICAgYDtcblxuICAgICAgZG9jdW1lbnQuYm9keS5hcHBlbmRDaGlsZChtb2RhbEVsKTtcblxuICAgICAgY29uc3QgbW9kYWwgPSBuZXcgU09Nb2RhbChtb2RhbEVsLCB7XG4gICAgICAgIGFuaW1hdGlvbjogdHJ1ZSxcbiAgICAgICAgc3RhdGljOiBpc1N0YXRpYyxcbiAgICAgICAgY2xvc2FibGU6IGlzU3RhdGljID8gZmFsc2UgOiBjbG9zYWJsZSxcbiAgICAgICAga2V5Ym9hcmQ6ICFpc1N0YXRpYyxcbiAgICAgICAgZm9jdXNFbGVtZW50LFxuICAgICAgfSk7XG5cbiAgICAgIC8vIFN0b3JlIGluc3RhbmNlIG9uIGVsZW1lbnRcbiAgICAgIG1vZGFsRWwuX3NvTW9kYWxJbnN0YW5jZSA9IG1vZGFsO1xuXG4gICAgICAvLyBSZW1vdmUgZnJvbSBET00gd2hlbiBoaWRkZW5cbiAgICAgIG1vZGFsRWwuYWRkRXZlbnRMaXN0ZW5lcihTaXhPcmJpdC5ldnQoU09Nb2RhbC5FVkVOVFMuSElEREVOKSwgKCkgPT4ge1xuICAgICAgICBtb2RhbEVsLnJlbW92ZSgpO1xuICAgICAgfSk7XG5cbiAgICAgIC8vIEhhbmRsZSBhY3Rpb24gYnV0dG9uIGNsaWNrc1xuICAgICAgbW9kYWxFbC5xdWVyeVNlbGVjdG9yQWxsKCdbZGF0YS1tb2RhbC1hY3Rpb25dJykuZm9yRWFjaChidG4gPT4ge1xuICAgICAgICBidG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoKSA9PiB7XG4gICAgICAgICAgaWYgKHJlc29sdmVkKSByZXR1cm47XG4gICAgICAgICAgcmVzb2x2ZWQgPSB0cnVlO1xuICAgICAgICAgIGNvbnN0IGFjdGlvbklkID0gYnRuLmdldEF0dHJpYnV0ZSgnZGF0YS1tb2RhbC1hY3Rpb24nKTtcblxuICAgICAgICAgIC8vIEZvciBzaW1wbGUgbW9kZSwgY29udmVydCB0byBib29sZWFuIGZvciBiYWNrd2FyZHMgY29tcGF0aWJpbGl0eVxuICAgICAgICAgIGlmICghYWN0aW9ucykge1xuICAgICAgICAgICAgcmVzb2x2ZShhY3Rpb25JZCA9PT0gJ2NvbmZpcm0nKTtcbiAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgcmVzb2x2ZShhY3Rpb25JZCk7XG4gICAgICAgICAgfVxuICAgICAgICAgIG1vZGFsLmhpZGUoKTtcbiAgICAgICAgfSk7XG4gICAgICB9KTtcblxuICAgICAgLy8gSGFuZGxlIGRpc21pc3MgKGNsb3NlIGJ1dHRvbiwgZXNjYXBlLCBiYWNrZHJvcCBjbGljaylcbiAgICAgIG1vZGFsRWwuYWRkRXZlbnRMaXN0ZW5lcihTaXhPcmJpdC5ldnQoU09Nb2RhbC5FVkVOVFMuSElEREVOKSwgKCkgPT4ge1xuICAgICAgICBpZiAocmVzb2x2ZWQpIHJldHVybjtcbiAgICAgICAgcmVzb2x2ZWQgPSB0cnVlO1xuICAgICAgICAvLyBSZXR1cm4gZmFsc2UgZm9yIHNpbXBsZSBtb2RlLCAnZGlzbWlzcycgZm9yIGFjdGlvbnMgbW9kZVxuICAgICAgICByZXNvbHZlKGFjdGlvbnMgPyAnZGlzbWlzcycgOiBmYWxzZSk7XG4gICAgICB9KTtcblxuICAgICAgbW9kYWwuc2hvdygpO1xuICAgIH0pO1xuICB9XG5cbiAgLyoqXG4gICAqIFNob3cgYW4gYWxlcnQgZGlhbG9nXG4gICAqIEBwYXJhbSB7T2JqZWN0fSBvcHRpb25zIC0gQWxlcnQgb3B0aW9uc1xuICAgKiBAcmV0dXJucyB7UHJvbWlzZTx2b2lkPn0gUmVzb2x2ZXMgd2hlbiBjbG9zZWRcbiAgICovXG4gIHN0YXRpYyBhbGVydChvcHRpb25zID0ge30pIHtcbiAgICBjb25zdCB7XG4gICAgICB0aXRsZSA9ICdBbGVydCcsXG4gICAgICBtZXNzYWdlID0gJycsXG4gICAgICBidXR0b25UZXh0ID0gJ09LJyxcbiAgICAgIHR5cGUgPSAnaW5mbycsIC8vIGluZm8sIHN1Y2Nlc3MsIHdhcm5pbmcsIGRhbmdlclxuICAgIH0gPSBvcHRpb25zO1xuXG4gICAgY29uc3QgaWNvbk1hcCA9IHtcbiAgICAgIGluZm86ICdpbmZvJyxcbiAgICAgIHN1Y2Nlc3M6ICdjaGVja19jaXJjbGUnLFxuICAgICAgd2FybmluZzogJ3dhcm5pbmcnLFxuICAgICAgZGFuZ2VyOiAnZXJyb3InLFxuICAgIH07XG5cbiAgICByZXR1cm4gbmV3IFByb21pc2UoKHJlc29sdmUpID0+IHtcbiAgICAgIGNvbnN0IG1vZGFsID0gU09Nb2RhbC5jcmVhdGUoe1xuICAgICAgICB0aXRsZSxcbiAgICAgICAgY29udGVudDogYFxuICAgICAgICAgIDxkaXYgc3R5bGU9XCJ0ZXh0LWFsaWduOiBjZW50ZXI7IHBhZGRpbmc6IDE2cHggMDtcIj5cbiAgICAgICAgICAgIDxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnNcIiBzdHlsZT1cImZvbnQtc2l6ZTogNDhweDsgY29sb3I6IHZhcigtLXNvLWFjY2VudC0ke3R5cGUgPT09ICdpbmZvJyA/ICdwcmltYXJ5JyA6IHR5cGV9KTsgbWFyZ2luLWJvdHRvbTogMTZweDsgZGlzcGxheTogYmxvY2s7XCI+XG4gICAgICAgICAgICAgICR7aWNvbk1hcFt0eXBlXSB8fCAnaW5mbyd9XG4gICAgICAgICAgICA8L3NwYW4+XG4gICAgICAgICAgICA8cCBzdHlsZT1cIm1hcmdpbjogMDtcIj4ke21lc3NhZ2V9PC9wPlxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICBgLFxuICAgICAgICBzaXplOiAnc20nLFxuICAgICAgICBjbG9zYWJsZTogdHJ1ZSxcbiAgICAgICAgZm9vdGVyOiBgPGJ1dHRvbiB0eXBlPVwiYnV0dG9uXCIgY2xhc3M9XCJzby1idG4gc28tYnRuLXByaW1hcnlcIiBkYXRhLWRpc21pc3M9XCJtb2RhbFwiPiR7YnV0dG9uVGV4dH08L2J1dHRvbj5gLFxuICAgICAgfSk7XG5cbiAgICAgIG1vZGFsLmVsZW1lbnQuYWRkRXZlbnRMaXN0ZW5lcihTaXhPcmJpdC5ldnQoU09Nb2RhbC5FVkVOVFMuSElEREVOKSwgKCkgPT4gcmVzb2x2ZSgpKTtcbiAgICAgIG1vZGFsLnNob3coKTtcbiAgICB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgbW9kYWwgaW5zdGFuY2UgZnJvbSBlbGVtZW50XG4gICAqIE92ZXJyaWRlIHRvIGFsc28gY2hlY2sgZm9yIGluc3RhbmNlIHN0b3JlZCBvbiBlbGVtZW50IChmcm9tIGNyZWF0ZSgpKVxuICAgKiBAcGFyYW0ge0VsZW1lbnR8c3RyaW5nfSBlbGVtZW50IC0gRE9NIGVsZW1lbnQgb3Igc2VsZWN0b3JcbiAgICogQHBhcmFtIHtPYmplY3R9IFtvcHRpb25zPXt9XSAtIENvbXBvbmVudCBvcHRpb25zXG4gICAqIEByZXR1cm5zIHtTT01vZGFsfSBNb2RhbCBpbnN0YW5jZVxuICAgKi9cbiAgc3RhdGljIGdldEluc3RhbmNlKGVsZW1lbnQsIG9wdGlvbnMgPSB7fSkge1xuICAgIGNvbnN0IGVsID0gdHlwZW9mIGVsZW1lbnQgPT09ICdzdHJpbmcnID8gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihlbGVtZW50KSA6IGVsZW1lbnQ7XG4gICAgaWYgKCFlbCkgcmV0dXJuIG51bGw7XG5cbiAgICAvLyBGaXJzdCBjaGVjayBmb3IgaW5zdGFuY2Ugc3RvcmVkIGRpcmVjdGx5IG9uIGVsZW1lbnQgKGZyb20gU09Nb2RhbC5jcmVhdGUoKSlcbiAgICBpZiAoZWwuX3NvTW9kYWxJbnN0YW5jZSkge1xuICAgICAgcmV0dXJuIGVsLl9zb01vZGFsSW5zdGFuY2U7XG4gICAgfVxuXG4gICAgLy8gRmFsbCBiYWNrIHRvIHN0YW5kYXJkIFNpeE9yYml0IGluc3RhbmNlIGxvb2t1cFxuICAgIHJldHVybiBTaXhPcmJpdC5nZXRJbnN0YW5jZShlbCwgdGhpcy5OQU1FLCBvcHRpb25zKTtcbiAgfVxufVxuXG4vLyBSZWdpc3RlciBjb21wb25lbnRcblNPTW9kYWwucmVnaXN0ZXIoKTtcblxuLy8gR2xvYmFsIGNsaWNrIGhhbmRsZXIgZm9yIGRhdGEtc28tdG9nZ2xlPVwibW9kYWxcIlxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoZSkgPT4ge1xuICBjb25zdCB0cmlnZ2VyID0gZS50YXJnZXQuY2xvc2VzdCgnW2RhdGEtc28tdG9nZ2xlPVwibW9kYWxcIl0nKTtcbiAgaWYgKCF0cmlnZ2VyKSByZXR1cm47XG5cbiAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gIGNvbnN0IHRhcmdldFNlbGVjdG9yID0gdHJpZ2dlci5nZXRBdHRyaWJ1dGUoJ2RhdGEtc28tdGFyZ2V0JykgfHwgdHJpZ2dlci5nZXRBdHRyaWJ1dGUoJ2hyZWYnKTtcbiAgaWYgKCF0YXJnZXRTZWxlY3RvcikgcmV0dXJuO1xuXG4gIGNvbnN0IG1vZGFsRWwgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKHRhcmdldFNlbGVjdG9yKTtcbiAgaWYgKCFtb2RhbEVsKSByZXR1cm47XG5cbiAgY29uc3QgbW9kYWwgPSBTT01vZGFsLmdldEluc3RhbmNlKG1vZGFsRWwpO1xuICBpZiAobW9kYWwpIHtcbiAgICBtb2RhbC5zaG93KCk7XG4gIH1cbn0pO1xuXG4vLyBFeHBvc2UgdG8gZ2xvYmFsIHNjb3BlXG53aW5kb3cuU09Nb2RhbCA9IFNPTW9kYWw7XG5cbi8vIEV4cG9ydCBmb3IgRVMgbW9kdWxlc1xuZXhwb3J0IGRlZmF1bHQgU09Nb2RhbDtcbmV4cG9ydCB7IFNPTW9kYWwgfTtcbiIsICIvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gU0lYT1JCSVQgVUkgLSBSSVBQTEUgRUZGRUNUXG4vLyBNYXRlcmlhbCBEZXNpZ24gcmlwcGxlIGVmZmVjdCBmb3IgYnV0dG9uc1xuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuaW1wb3J0IFNpeE9yYml0IGZyb20gJy4uL2NvcmUvc28tY29uZmlnLmpzJztcbmltcG9ydCBTT0NvbXBvbmVudCBmcm9tICcuLi9jb3JlL3NvLWNvbXBvbmVudC5qcyc7XG5cbi8qKlxuICogU09SaXBwbGUgLSBNYXRlcmlhbCBkZXNpZ24gcmlwcGxlIGVmZmVjdFxuICogQXV0b21hdGljYWxseSBhZGRzIHJpcHBsZSBlZmZlY3RzIHRvIGVsZW1lbnRzIHdpdGggLnNvLWJ0biBjbGFzc1xuICovXG5jbGFzcyBTT1JpcHBsZSBleHRlbmRzIFNPQ29tcG9uZW50IHtcbiAgc3RhdGljIE5BTUUgPSAncmlwcGxlJztcblxuICBzdGF0aWMgREVGQVVMVFMgPSB7XG4gICAgc2VsZWN0b3I6ICcuc28tYnRuJyxcbiAgICBkdXJhdGlvbjogNjAwLFxuICAgIGNvbG9yOiAncmdiYSgyNTUsIDI1NSwgMjU1LCAwLjM1KScsXG4gIH07XG5cbiAgLyoqXG4gICAqIEluaXRpYWxpemUgcmlwcGxlIGVmZmVjdFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2luaXQoKSB7XG4gICAgdGhpcy5fYmluZEV2ZW50cygpO1xuICB9XG5cbiAgLyoqXG4gICAqIEJpbmQgZXZlbnQgbGlzdGVuZXJzXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfYmluZEV2ZW50cygpIHtcbiAgICAvLyBVc2UgZXZlbnQgZGVsZWdhdGlvbiBvbiBkb2N1bWVudCBmb3IgYWxsIHJpcHBsZSBlbGVtZW50c1xuICAgIHRoaXMub24oJ2NsaWNrJywgdGhpcy5faGFuZGxlQ2xpY2ssIGRvY3VtZW50KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUgY2xpY2sgZXZlbnRcbiAgICogQHBhcmFtIHtNb3VzZUV2ZW50fSBlIC0gQ2xpY2sgZXZlbnRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVDbGljayhlKSB7XG4gICAgY29uc3QgdGFyZ2V0ID0gZS50YXJnZXQuY2xvc2VzdCh0aGlzLm9wdGlvbnMuc2VsZWN0b3IpO1xuICAgIGlmICghdGFyZ2V0KSByZXR1cm47XG5cbiAgICAvLyBEb24ndCBhZGQgcmlwcGxlIHRvIGRpc2FibGVkIGJ1dHRvbnNcbiAgICBpZiAodGFyZ2V0LmRpc2FibGVkIHx8IHRhcmdldC5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWRpc2FibGVkJykpIHJldHVybjtcblxuICAgIHRoaXMuX2NyZWF0ZVJpcHBsZSh0YXJnZXQsIGUpO1xuICB9XG5cbiAgLyoqXG4gICAqIENyZWF0ZSByaXBwbGUgZWZmZWN0XG4gICAqIEBwYXJhbSB7RWxlbWVudH0gZWxlbWVudCAtIFRhcmdldCBlbGVtZW50XG4gICAqIEBwYXJhbSB7TW91c2VFdmVudH0gZXZlbnQgLSBDbGljayBldmVudFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2NyZWF0ZVJpcHBsZShlbGVtZW50LCBldmVudCkge1xuICAgIGNvbnN0IHJlY3QgPSBlbGVtZW50LmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xuXG4gICAgLy8gQ2FsY3VsYXRlIHJpcHBsZSBzaXplIChsYXJnZXN0IG9mIHdpZHRoL2hlaWdodCB0byBlbnN1cmUgZnVsbCBjb3ZlcmFnZSlcbiAgICBjb25zdCBzaXplID0gTWF0aC5tYXgocmVjdC53aWR0aCwgcmVjdC5oZWlnaHQpO1xuXG4gICAgLy8gQ2FsY3VsYXRlIGNsaWNrIHBvc2l0aW9uIHJlbGF0aXZlIHRvIGVsZW1lbnRcbiAgICBjb25zdCB4ID0gZXZlbnQuY2xpZW50WCAtIHJlY3QubGVmdCAtIHNpemUgLyAyO1xuICAgIGNvbnN0IHkgPSBldmVudC5jbGllbnRZIC0gcmVjdC50b3AgLSBzaXplIC8gMjtcblxuICAgIC8vIENyZWF0ZSByaXBwbGUgZWxlbWVudFxuICAgIGNvbnN0IHJpcHBsZSA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ3NwYW4nKTtcbiAgICByaXBwbGUuY2xhc3NOYW1lID0gJ3NvLXJpcHBsZS1lZmZlY3QnO1xuICAgIHJpcHBsZS5zdHlsZS5jc3NUZXh0ID0gYFxuICAgICAgcG9zaXRpb246IGFic29sdXRlO1xuICAgICAgd2lkdGg6ICR7c2l6ZX1weDtcbiAgICAgIGhlaWdodDogJHtzaXplfXB4O1xuICAgICAgbGVmdDogJHt4fXB4O1xuICAgICAgdG9wOiAke3l9cHg7XG4gICAgICBiYWNrZ3JvdW5kOiAke3RoaXMuX2dldFJpcHBsZUNvbG9yKGVsZW1lbnQpfTtcbiAgICAgIGJvcmRlci1yYWRpdXM6IDUwJTtcbiAgICAgIHRyYW5zZm9ybTogc2NhbGUoMCk7XG4gICAgICBvcGFjaXR5OiAxO1xuICAgICAgcG9pbnRlci1ldmVudHM6IG5vbmU7XG4gICAgICBhbmltYXRpb246IHNvLXJpcHBsZS1hbmltYXRpb24gJHt0aGlzLm9wdGlvbnMuZHVyYXRpb259bXMgZWFzZS1vdXQgZm9yd2FyZHM7XG4gICAgYDtcblxuICAgIC8vIEVuc3VyZSBlbGVtZW50IGhhcyByZWxhdGl2ZSBwb3NpdGlvbmluZ1xuICAgIGNvbnN0IHBvc2l0aW9uID0gZ2V0Q29tcHV0ZWRTdHlsZShlbGVtZW50KS5wb3NpdGlvbjtcbiAgICBpZiAocG9zaXRpb24gPT09ICdzdGF0aWMnKSB7XG4gICAgICBlbGVtZW50LnN0eWxlLnBvc2l0aW9uID0gJ3JlbGF0aXZlJztcbiAgICB9XG5cbiAgICAvLyBFbnN1cmUgb3ZlcmZsb3cgaXMgaGlkZGVuXG4gICAgZWxlbWVudC5zdHlsZS5vdmVyZmxvdyA9ICdoaWRkZW4nO1xuXG4gICAgLy8gQWRkIHJpcHBsZSB0byBlbGVtZW50XG4gICAgZWxlbWVudC5hcHBlbmRDaGlsZChyaXBwbGUpO1xuXG4gICAgLy8gUmVtb3ZlIHJpcHBsZSBhZnRlciBhbmltYXRpb25cbiAgICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgIHJpcHBsZS5yZW1vdmUoKTtcbiAgICB9LCB0aGlzLm9wdGlvbnMuZHVyYXRpb24pO1xuICB9XG5cbiAgLyoqXG4gICAqIEdldCByaXBwbGUgY29sb3IgYmFzZWQgb24gZWxlbWVudFxuICAgKiBAcGFyYW0ge0VsZW1lbnR9IGVsZW1lbnQgLSBUYXJnZXQgZWxlbWVudFxuICAgKiBAcmV0dXJucyB7c3RyaW5nfSBSaXBwbGUgY29sb3JcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9nZXRSaXBwbGVDb2xvcihlbGVtZW50KSB7XG4gICAgLy8gVXNlIGRhcmtlciByaXBwbGUgZm9yIGxpZ2h0IGJ1dHRvbnNcbiAgICBpZiAoZWxlbWVudC5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWJ0bi1vdXRsaW5lJykgfHxcbiAgICAgICAgZWxlbWVudC5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWJ0bi1naG9zdCcpIHx8XG4gICAgICAgIGVsZW1lbnQuY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1idG4tbGlnaHQnKSkge1xuICAgICAgcmV0dXJuICdyZ2JhKDAsIDAsIDAsIDAuMSknO1xuICAgIH1cblxuICAgIHJldHVybiB0aGlzLm9wdGlvbnMuY29sb3I7XG4gIH1cblxuICAvKipcbiAgICogQWRkIENTUyBhbmltYXRpb24gaWYgbm90IHByZXNlbnRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIHN0YXRpYyBfZW5zdXJlU3R5bGVzKCkge1xuICAgIGlmIChkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnc28tcmlwcGxlLXN0eWxlcycpKSByZXR1cm47XG5cbiAgICBjb25zdCBzdHlsZSA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ3N0eWxlJyk7XG4gICAgc3R5bGUuaWQgPSAnc28tcmlwcGxlLXN0eWxlcyc7XG4gICAgc3R5bGUudGV4dENvbnRlbnQgPSBgXG4gICAgICBAa2V5ZnJhbWVzIHNvLXJpcHBsZS1hbmltYXRpb24ge1xuICAgICAgICB0byB7XG4gICAgICAgICAgdHJhbnNmb3JtOiBzY2FsZSg0KTtcbiAgICAgICAgICBvcGFjaXR5OiAwO1xuICAgICAgICB9XG4gICAgICB9XG4gICAgYDtcbiAgICBkb2N1bWVudC5oZWFkLmFwcGVuZENoaWxkKHN0eWxlKTtcbiAgfVxufVxuXG4vLyBFbnN1cmUgc3R5bGVzIGFyZSBhZGRlZFxuU09SaXBwbGUuX2Vuc3VyZVN0eWxlcygpO1xuXG4vLyBBdXRvLWluaXRpYWxpemUgZ2xvYmFsIHJpcHBsZSBoYW5kbGVyXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgKCkgPT4ge1xuICBuZXcgU09SaXBwbGUoZG9jdW1lbnQuYm9keSk7XG59KTtcblxuLy8gUmVnaXN0ZXIgY29tcG9uZW50XG5TT1JpcHBsZS5yZWdpc3RlcigpO1xuXG4vLyBFeHBvc2UgdG8gZ2xvYmFsIHNjb3BlXG53aW5kb3cuU09SaXBwbGUgPSBTT1JpcHBsZTtcblxuLy8gRXhwb3J0IGZvciBFUyBtb2R1bGVzXG5leHBvcnQgZGVmYXVsdCBTT1JpcHBsZTtcbmV4cG9ydCB7IFNPUmlwcGxlIH07XG4iLCAiLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbi8vIFNJWE9SQklUIFVJIC0gQ09OVEVYVCBNRU5VIENPTVBPTkVOVFxuLy8gUmlnaHQtY2xpY2sgY29udGV4dHVhbCBtZW51IHdpdGggc3VibWVudXNcbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbmltcG9ydCBTaXhPcmJpdCBmcm9tICcuLi9jb3JlL3NvLWNvbmZpZy5qcyc7XG5pbXBvcnQgU09Db21wb25lbnQgZnJvbSAnLi4vY29yZS9zby1jb21wb25lbnQuanMnO1xuXG4vKipcbiAqIFNPQ29udGV4dE1lbnUgLSBDb250ZXh0IG1lbnUgY29tcG9uZW50XG4gKiBTdXBwb3J0cyBoZWFkZXJzLCBkaXZpZGVycywgc3VibWVudXMgKDIgbGV2ZWxzKSwgYW5kIGZ1bGwgSmF2YVNjcmlwdCBBUElcbiAqL1xuY2xhc3MgU09Db250ZXh0TWVudSBleHRlbmRzIFNPQ29tcG9uZW50IHtcbiAgc3RhdGljIE5BTUUgPSAnY29udGV4dE1lbnUnO1xuXG4gIHN0YXRpYyBERUZBVUxUUyA9IHtcbiAgICBpdGVtczogW10sICAgICAgICAgICAgICAgICAgICAvLyBNZW51IGl0ZW1zIGNvbmZpZ3VyYXRpb25cbiAgICB0cmlnZ2VyOiAnY29udGV4dG1lbnUnLCAgICAgICAvLyAnY29udGV4dG1lbnUnIG9yICdjbGljaydcbiAgICBkaXNhYmxlZDogZmFsc2UsICAgICAgICAgICAgICAvLyBEaXNhYmxlIGVudGlyZSBtZW51XG4gICAgY2xvc2VPblNlbGVjdDogdHJ1ZSwgICAgICAgICAgLy8gQ2xvc2UgbWVudSB3aGVuIGl0ZW0gc2VsZWN0ZWRcbiAgICBjbG9zZU9uT3V0c2lkZUNsaWNrOiB0cnVlLCAgICAvLyBDbG9zZSBvbiBjbGljayBvdXRzaWRlXG4gICAgc3VibWVudURlbGF5OiAyMDAsICAgICAgICAgICAgLy8gRGVsYXkgYmVmb3JlIG9wZW5pbmcgc3VibWVudSAobXMpXG4gICAgYW5pbWF0ZWQ6IGZhbHNlLCAgICAgICAgICAgICAgLy8gVXNlIGFuaW1hdGlvbiBrZXlmcmFtZXNcbiAgfTtcblxuICBzdGF0aWMgRVZFTlRTID0ge1xuICAgIFNIT1c6ICdjb250ZXh0bWVudTpzaG93JyxcbiAgICBTSE9XTjogJ2NvbnRleHRtZW51OnNob3duJyxcbiAgICBISURFOiAnY29udGV4dG1lbnU6aGlkZScsXG4gICAgSElEREVOOiAnY29udGV4dG1lbnU6aGlkZGVuJyxcbiAgICBTRUxFQ1Q6ICdjb250ZXh0bWVudTpzZWxlY3QnLFxuICAgIFNVQk1FTlVfU0hPVzogJ2NvbnRleHRtZW51OnN1Ym1lbnU6c2hvdycsXG4gICAgU1VCTUVOVV9ISURFOiAnY29udGV4dG1lbnU6c3VibWVudTpoaWRlJyxcbiAgfTtcblxuICAvKipcbiAgICogSW5pdGlhbGl6ZSB0aGUgY29udGV4dCBtZW51XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaW5pdCgpIHtcbiAgICAvLyBTdGF0ZVxuICAgIHRoaXMuX2lzT3BlbiA9IGZhbHNlO1xuICAgIHRoaXMuX2Rpc2FibGVkID0gdGhpcy5vcHRpb25zLmRpc2FibGVkO1xuICAgIHRoaXMuX3RhcmdldCA9IG51bGw7ICAgICAgICAgICAvLyBFbGVtZW50IG1lbnUgaXMgYXR0YWNoZWQgdG9cbiAgICB0aGlzLl9tZW51RWxlbWVudCA9IG51bGw7ICAgICAgLy8gVGhlIG1lbnUgRE9NIGVsZW1lbnRcbiAgICB0aGlzLl9pdGVtcyA9IFtdOyAgICAgICAgICAgICAgLy8gSW50ZXJuYWwgaXRlbXMgc3RvcmVcbiAgICB0aGlzLl9ncm91cHMgPSBuZXcgTWFwKCk7ICAgICAgLy8gR3JvdXAgSUQgLT4gaXRlbSBJRHMgbWFwcGluZ1xuICAgIHRoaXMuX2ZvY3VzZWRJbmRleCA9IC0xO1xuICAgIHRoaXMuX2FjdGl2ZVN1Ym1lbnUgPSBudWxsO1xuICAgIHRoaXMuX3N1Ym1lbnVUaW1lb3V0ID0gbnVsbDtcblxuICAgIC8vIENoZWNrIGlmIGVsZW1lbnQgaXMgdGhlIG1lbnUgaXRzZWxmIG9yIGEgdHJpZ2dlclxuICAgIGlmICh0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1jb250ZXh0LW1lbnUnKSkge1xuICAgICAgLy8gRWxlbWVudCBpcyB0aGUgbWVudSAtIGZpbmQgdHJpZ2dlciB2aWEgZGF0YSBhdHRyaWJ1dGVcbiAgICAgIHRoaXMuX21lbnVFbGVtZW50ID0gdGhpcy5lbGVtZW50O1xuICAgICAgY29uc3QgdHJpZ2dlcklkID0gdGhpcy5lbGVtZW50LmlkO1xuICAgICAgaWYgKHRyaWdnZXJJZCkge1xuICAgICAgICB0aGlzLl90YXJnZXQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKGBbZGF0YS1zby1jb250ZXh0LW1lbnU9XCIjJHt0cmlnZ2VySWR9XCJdYCk7XG4gICAgICB9XG4gICAgfSBlbHNlIHtcbiAgICAgIC8vIEVsZW1lbnQgaXMgYSB0cmlnZ2VyIC0gZmluZCBvciBjcmVhdGUgbWVudVxuICAgICAgdGhpcy5fdGFyZ2V0ID0gdGhpcy5lbGVtZW50O1xuICAgICAgY29uc3QgbWVudVNlbGVjdG9yID0gdGhpcy5lbGVtZW50LmdldEF0dHJpYnV0ZSgnZGF0YS1zby1jb250ZXh0LW1lbnUnKTtcbiAgICAgIGlmIChtZW51U2VsZWN0b3IpIHtcbiAgICAgICAgdGhpcy5fbWVudUVsZW1lbnQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKG1lbnVTZWxlY3Rvcik7XG4gICAgICB9XG4gICAgfVxuXG4gICAgLy8gQnVpbGQgaXRlbXMgZnJvbSBvcHRpb25zIG9yIHBhcnNlIGZyb20gRE9NXG4gICAgaWYgKHRoaXMub3B0aW9ucy5pdGVtcyAmJiB0aGlzLm9wdGlvbnMuaXRlbXMubGVuZ3RoID4gMCkge1xuICAgICAgdGhpcy5fYnVpbGRGcm9tQ29uZmlnKHRoaXMub3B0aW9ucy5pdGVtcyk7XG4gICAgfSBlbHNlIGlmICh0aGlzLl9tZW51RWxlbWVudCkge1xuICAgICAgdGhpcy5fcGFyc2VGcm9tRE9NKCk7XG4gICAgfVxuXG4gICAgLy8gQmluZCBldmVudHNcbiAgICB0aGlzLl9iaW5kRXZlbnRzKCk7XG4gIH1cblxuICAvKipcbiAgICogQnVpbGQgbWVudSBmcm9tIGNvbmZpZ3VyYXRpb24gYXJyYXlcbiAgICogQHBhcmFtIHtBcnJheX0gaXRlbXMgLSBJdGVtcyBjb25maWd1cmF0aW9uXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfYnVpbGRGcm9tQ29uZmlnKGl0ZW1zKSB7XG4gICAgaWYgKCF0aGlzLl9tZW51RWxlbWVudCkge1xuICAgICAgLy8gQ3JlYXRlIG1lbnUgZWxlbWVudFxuICAgICAgdGhpcy5fbWVudUVsZW1lbnQgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcbiAgICAgIHRoaXMuX21lbnVFbGVtZW50LmNsYXNzTmFtZSA9ICdzby1jb250ZXh0LW1lbnUnO1xuICAgICAgaWYgKHRoaXMub3B0aW9ucy5hbmltYXRlZCkge1xuICAgICAgICB0aGlzLl9tZW51RWxlbWVudC5jbGFzc0xpc3QuYWRkKCdzby1jb250ZXh0LW1lbnUtYW5pbWF0ZWQnKTtcbiAgICAgIH1cbiAgICAgIGRvY3VtZW50LmJvZHkuYXBwZW5kQ2hpbGQodGhpcy5fbWVudUVsZW1lbnQpO1xuICAgIH1cblxuICAgIHRoaXMuX2l0ZW1zID0gW107XG4gICAgdGhpcy5fbWVudUVsZW1lbnQuaW5uZXJIVE1MID0gJyc7XG4gICAgdGhpcy5fcmVuZGVySXRlbXMoaXRlbXMsIHRoaXMuX21lbnVFbGVtZW50KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBSZW5kZXIgaXRlbXMgdG8gY29udGFpbmVyXG4gICAqIEBwYXJhbSB7QXJyYXl9IGl0ZW1zIC0gSXRlbXMgdG8gcmVuZGVyXG4gICAqIEBwYXJhbSB7RWxlbWVudH0gY29udGFpbmVyIC0gQ29udGFpbmVyIGVsZW1lbnRcbiAgICogQHBhcmFtIHtudW1iZXJ9IFtsZXZlbD0wXSAtIE5lc3RpbmcgbGV2ZWxcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9yZW5kZXJJdGVtcyhpdGVtcywgY29udGFpbmVyLCBsZXZlbCA9IDApIHtcbiAgICBpdGVtcy5mb3JFYWNoKChpdGVtLCBpbmRleCkgPT4ge1xuICAgICAgY29uc3QgaXRlbUVsID0gdGhpcy5fY3JlYXRlSXRlbUVsZW1lbnQoaXRlbSwgbGV2ZWwpO1xuICAgICAgY29udGFpbmVyLmFwcGVuZENoaWxkKGl0ZW1FbCk7XG5cbiAgICAgIC8vIFN0b3JlIGl0ZW0gcmVmZXJlbmNlXG4gICAgICBjb25zdCBpdGVtRGF0YSA9IHtcbiAgICAgICAgLi4uaXRlbSxcbiAgICAgICAgaWQ6IGl0ZW0uaWQgfHwgYGl0ZW0tJHtsZXZlbH0tJHtpbmRleH1gLFxuICAgICAgICBlbGVtZW50OiBpdGVtRWwsXG4gICAgICAgIGxldmVsLFxuICAgICAgfTtcbiAgICAgIHRoaXMuX2l0ZW1zLnB1c2goaXRlbURhdGEpO1xuXG4gICAgICAvLyBUcmFjayBncm91cHNcbiAgICAgIGlmIChpdGVtLmdyb3VwSWQpIHtcbiAgICAgICAgaWYgKCF0aGlzLl9ncm91cHMuaGFzKGl0ZW0uZ3JvdXBJZCkpIHtcbiAgICAgICAgICB0aGlzLl9ncm91cHMuc2V0KGl0ZW0uZ3JvdXBJZCwgW10pO1xuICAgICAgICB9XG4gICAgICAgIHRoaXMuX2dyb3Vwcy5nZXQoaXRlbS5ncm91cElkKS5wdXNoKGl0ZW1EYXRhLmlkKTtcbiAgICAgIH1cbiAgICB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBDcmVhdGUgYSBzaW5nbGUgaXRlbSBlbGVtZW50XG4gICAqIEBwYXJhbSB7T2JqZWN0fSBpdGVtIC0gSXRlbSBjb25maWd1cmF0aW9uXG4gICAqIEBwYXJhbSB7bnVtYmVyfSBsZXZlbCAtIE5lc3RpbmcgbGV2ZWxcbiAgICogQHJldHVybnMge0VsZW1lbnR9IENyZWF0ZWQgZWxlbWVudFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2NyZWF0ZUl0ZW1FbGVtZW50KGl0ZW0sIGxldmVsKSB7XG4gICAgLy8gSGVhZGVyXG4gICAgaWYgKGl0ZW0udHlwZSA9PT0gJ2hlYWRlcicpIHtcbiAgICAgIGNvbnN0IGhlYWRlciA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2RpdicpO1xuICAgICAgaGVhZGVyLmNsYXNzTmFtZSA9ICdzby1jb250ZXh0LW1lbnUtaGVhZGVyJztcbiAgICAgIGhlYWRlci50ZXh0Q29udGVudCA9IGl0ZW0ubGFiZWwgfHwgaXRlbS50ZXh0IHx8ICcnO1xuICAgICAgaGVhZGVyLmRhdGFzZXQuaWQgPSBpdGVtLmlkIHx8ICcnO1xuICAgICAgcmV0dXJuIGhlYWRlcjtcbiAgICB9XG5cbiAgICAvLyBEaXZpZGVyXG4gICAgaWYgKGl0ZW0udHlwZSA9PT0gJ2RpdmlkZXInKSB7XG4gICAgICBjb25zdCBkaXZpZGVyID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XG4gICAgICBkaXZpZGVyLmNsYXNzTmFtZSA9ICdzby1jb250ZXh0LW1lbnUtZGl2aWRlcic7XG4gICAgICByZXR1cm4gZGl2aWRlcjtcbiAgICB9XG5cbiAgICAvLyBHcm91cCB3cmFwcGVyXG4gICAgaWYgKGl0ZW0udHlwZSA9PT0gJ2dyb3VwJykge1xuICAgICAgY29uc3QgZ3JvdXAgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcbiAgICAgIGdyb3VwLmNsYXNzTmFtZSA9ICdzby1jb250ZXh0LW1lbnUtZ3JvdXAnO1xuICAgICAgZ3JvdXAuZGF0YXNldC5ncm91cElkID0gaXRlbS5ncm91cElkIHx8IGl0ZW0uaWQgfHwgJyc7XG4gICAgICBpZiAoaXRlbS5kaXNhYmxlZCkgZ3JvdXAuY2xhc3NMaXN0LmFkZCgnc28tZGlzYWJsZWQnKTtcblxuICAgICAgLy8gUmVuZGVyIGdyb3VwIGl0ZW1zXG4gICAgICBpZiAoaXRlbS5pdGVtcyAmJiBpdGVtLml0ZW1zLmxlbmd0aCA+IDApIHtcbiAgICAgICAgdGhpcy5fcmVuZGVySXRlbXMoaXRlbS5pdGVtcy5tYXAoaSA9PiAoeyAuLi5pLCBncm91cElkOiBpdGVtLmdyb3VwSWQgfHwgaXRlbS5pZCB9KSksIGdyb3VwLCBsZXZlbCk7XG4gICAgICB9XG4gICAgICByZXR1cm4gZ3JvdXA7XG4gICAgfVxuXG4gICAgLy8gUmVndWxhciBpdGVtXG4gICAgY29uc3QgaXRlbUVsID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XG4gICAgaXRlbUVsLmNsYXNzTmFtZSA9ICdzby1jb250ZXh0LW1lbnUtaXRlbSc7XG4gICAgaWYgKGl0ZW0uaWQpIGl0ZW1FbC5kYXRhc2V0LmlkID0gaXRlbS5pZDtcbiAgICBpZiAoaXRlbS5kaXNhYmxlZCkgaXRlbUVsLmNsYXNzTGlzdC5hZGQoJ3NvLWRpc2FibGVkJyk7XG4gICAgaWYgKGl0ZW0uZGFuZ2VyKSBpdGVtRWwuY2xhc3NMaXN0LmFkZChTaXhPcmJpdC5jbHMoJ2RhbmdlcicpKTtcbiAgICBpZiAoaXRlbS5jaGVja2VkKSBpdGVtRWwuY2xhc3NMaXN0LmFkZChTaXhPcmJpdC5jbHMoJ2NoZWNrZWQnKSk7XG4gICAgaWYgKGl0ZW0uZGF0YSkgaXRlbUVsLmRhdGFzZXQuZGF0YSA9IEpTT04uc3RyaW5naWZ5KGl0ZW0uZGF0YSk7XG5cbiAgICAvLyBIYXMgc3VibWVudT9cbiAgICBjb25zdCBoYXNTdWJtZW51ID0gaXRlbS5pdGVtcyAmJiBpdGVtLml0ZW1zLmxlbmd0aCA+IDAgJiYgbGV2ZWwgPCAyO1xuICAgIGlmIChoYXNTdWJtZW51KSBpdGVtRWwuY2xhc3NMaXN0LmFkZCgnc28taGFzLXN1Ym1lbnUnKTtcblxuICAgIC8vIEJ1aWxkIGlubmVyIEhUTUxcbiAgICBsZXQgaHRtbCA9ICcnO1xuXG4gICAgLy8gQ2hlY2ttYXJrIGZvciBjaGVja2FibGUgaXRlbXNcbiAgICBpZiAoaXRlbS5jaGVja2FibGUpIHtcbiAgICAgIGh0bWwgKz0gYDxzcGFuIGNsYXNzPVwic28tY29udGV4dC1tZW51LWl0ZW0tY2hlY2tcIj48c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+Y2hlY2s8L3NwYW4+PC9zcGFuPmA7XG4gICAgfVxuXG4gICAgLy8gSWNvblxuICAgIGlmIChpdGVtLmljb24pIHtcbiAgICAgIGh0bWwgKz0gYDxzcGFuIGNsYXNzPVwic28tY29udGV4dC1tZW51LWl0ZW0taWNvblwiPjxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnNcIj4ke2l0ZW0uaWNvbn08L3NwYW4+PC9zcGFuPmA7XG4gICAgfVxuXG4gICAgLy8gVGV4dC9MYWJlbCB3aXRoIG9wdGlvbmFsIGRlc2NyaXB0aW9uXG4gICAgaWYgKGl0ZW0uZGVzY3JpcHRpb24pIHtcbiAgICAgIGh0bWwgKz0gYDxzcGFuIGNsYXNzPVwic28tY29udGV4dC1tZW51LWl0ZW0tY29udGVudFwiPlxuICAgICAgICA8c3BhbiBjbGFzcz1cInNvLWNvbnRleHQtbWVudS1pdGVtLXRleHRcIj4ke2l0ZW0ubGFiZWwgfHwgaXRlbS50ZXh0IHx8ICcnfTwvc3Bhbj5cbiAgICAgICAgPHNwYW4gY2xhc3M9XCJzby1jb250ZXh0LW1lbnUtaXRlbS1kZXNjcmlwdGlvblwiPiR7aXRlbS5kZXNjcmlwdGlvbn08L3NwYW4+XG4gICAgICA8L3NwYW4+YDtcbiAgICB9IGVsc2Uge1xuICAgICAgaHRtbCArPSBgPHNwYW4gY2xhc3M9XCJzby1jb250ZXh0LW1lbnUtaXRlbS10ZXh0XCI+JHtpdGVtLmxhYmVsIHx8IGl0ZW0udGV4dCB8fCAnJ308L3NwYW4+YDtcbiAgICB9XG5cbiAgICAvLyBLZXlib2FyZCBzaG9ydGN1dFxuICAgIGlmIChpdGVtLnNob3J0Y3V0KSB7XG4gICAgICBodG1sICs9IGA8c3BhbiBjbGFzcz1cInNvLWNvbnRleHQtbWVudS1pdGVtLXNob3J0Y3V0XCI+JHtpdGVtLnNob3J0Y3V0fTwvc3Bhbj5gO1xuICAgIH1cblxuICAgIC8vIFN1Ym1lbnUgYXJyb3dcbiAgICBpZiAoaGFzU3VibWVudSkge1xuICAgICAgaHRtbCArPSBgPHNwYW4gY2xhc3M9XCJzby1jb250ZXh0LW1lbnUtaXRlbS1hcnJvd1wiPjxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnNcIj5jaGV2cm9uX3JpZ2h0PC9zcGFuPjwvc3Bhbj5gO1xuICAgIH1cblxuICAgIGl0ZW1FbC5pbm5lckhUTUwgPSBodG1sO1xuXG4gICAgLy8gQ3JlYXRlIHN1Ym1lbnVcbiAgICBpZiAoaGFzU3VibWVudSkge1xuICAgICAgY29uc3Qgc3VibWVudSA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2RpdicpO1xuICAgICAgc3VibWVudS5jbGFzc05hbWUgPSAnc28tY29udGV4dC1tZW51LXN1Ym1lbnUnO1xuICAgICAgdGhpcy5fcmVuZGVySXRlbXMoaXRlbS5pdGVtcywgc3VibWVudSwgbGV2ZWwgKyAxKTtcbiAgICAgIGl0ZW1FbC5hcHBlbmRDaGlsZChzdWJtZW51KTtcbiAgICB9XG5cbiAgICByZXR1cm4gaXRlbUVsO1xuICB9XG5cbiAgLyoqXG4gICAqIFBhcnNlIGl0ZW1zIGZyb20gZXhpc3RpbmcgRE9NXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfcGFyc2VGcm9tRE9NKCkge1xuICAgIGlmICghdGhpcy5fbWVudUVsZW1lbnQpIHJldHVybjtcblxuICAgIHRoaXMuX2l0ZW1zID0gW107XG4gICAgY29uc3QgY2hpbGRyZW4gPSB0aGlzLl9tZW51RWxlbWVudC5jaGlsZHJlbjtcblxuICAgIGZvciAobGV0IGkgPSAwOyBpIDwgY2hpbGRyZW4ubGVuZ3RoOyBpKyspIHtcbiAgICAgIGNvbnN0IGVsID0gY2hpbGRyZW5baV07XG4gICAgICBjb25zdCBpdGVtID0gdGhpcy5fcGFyc2VJdGVtRWxlbWVudChlbCwgMCwgaSk7XG4gICAgICBpZiAoaXRlbSkgdGhpcy5faXRlbXMucHVzaChpdGVtKTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogUGFyc2UgYSBzaW5nbGUgaXRlbSBlbGVtZW50XG4gICAqIEBwYXJhbSB7RWxlbWVudH0gZWwgLSBJdGVtIGVsZW1lbnRcbiAgICogQHBhcmFtIHtudW1iZXJ9IGxldmVsIC0gTmVzdGluZyBsZXZlbFxuICAgKiBAcGFyYW0ge251bWJlcn0gaW5kZXggLSBJdGVtIGluZGV4XG4gICAqIEByZXR1cm5zIHtPYmplY3R8bnVsbH0gUGFyc2VkIGl0ZW0gZGF0YVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3BhcnNlSXRlbUVsZW1lbnQoZWwsIGxldmVsLCBpbmRleCkge1xuICAgIGlmIChlbC5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWNvbnRleHQtbWVudS1oZWFkZXInKSkge1xuICAgICAgcmV0dXJuIHtcbiAgICAgICAgaWQ6IGVsLmRhdGFzZXQuaWQgfHwgYGhlYWRlci0ke2xldmVsfS0ke2luZGV4fWAsXG4gICAgICAgIHR5cGU6ICdoZWFkZXInLFxuICAgICAgICBsYWJlbDogZWwudGV4dENvbnRlbnQudHJpbSgpLFxuICAgICAgICBlbGVtZW50OiBlbCxcbiAgICAgICAgbGV2ZWwsXG4gICAgICB9O1xuICAgIH1cblxuICAgIGlmIChlbC5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWNvbnRleHQtbWVudS1kaXZpZGVyJykpIHtcbiAgICAgIHJldHVybiB7XG4gICAgICAgIGlkOiBgZGl2aWRlci0ke2xldmVsfS0ke2luZGV4fWAsXG4gICAgICAgIHR5cGU6ICdkaXZpZGVyJyxcbiAgICAgICAgZWxlbWVudDogZWwsXG4gICAgICAgIGxldmVsLFxuICAgICAgfTtcbiAgICB9XG5cbiAgICBpZiAoZWwuY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1jb250ZXh0LW1lbnUtZ3JvdXAnKSkge1xuICAgICAgY29uc3QgZ3JvdXBJZCA9IGVsLmRhdGFzZXQuZ3JvdXBJZCB8fCBgZ3JvdXAtJHtpbmRleH1gO1xuICAgICAgY29uc3QgZ3JvdXBJdGVtcyA9IFtdO1xuXG4gICAgICBmb3IgKGxldCBpID0gMDsgaSA8IGVsLmNoaWxkcmVuLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgIGNvbnN0IGNoaWxkSXRlbSA9IHRoaXMuX3BhcnNlSXRlbUVsZW1lbnQoZWwuY2hpbGRyZW5baV0sIGxldmVsLCBpKTtcbiAgICAgICAgaWYgKGNoaWxkSXRlbSkge1xuICAgICAgICAgIGNoaWxkSXRlbS5ncm91cElkID0gZ3JvdXBJZDtcbiAgICAgICAgICBncm91cEl0ZW1zLnB1c2goY2hpbGRJdGVtKTtcbiAgICAgICAgICB0aGlzLl9pdGVtcy5wdXNoKGNoaWxkSXRlbSk7XG4gICAgICAgIH1cbiAgICAgIH1cblxuICAgICAgdGhpcy5fZ3JvdXBzLnNldChncm91cElkLCBncm91cEl0ZW1zLm1hcChpID0+IGkuaWQpKTtcblxuICAgICAgcmV0dXJuIG51bGw7IC8vIEdyb3VwIGl0c2VsZiBpcyBub3Qgc3RvcmVkIGFzIGl0ZW1cbiAgICB9XG5cbiAgICBpZiAoZWwuY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1jb250ZXh0LW1lbnUtaXRlbScpKSB7XG4gICAgICBjb25zdCB0ZXh0RWwgPSBlbC5xdWVyeVNlbGVjdG9yKCcuc28tY29udGV4dC1tZW51LWl0ZW0tdGV4dCcpO1xuICAgICAgY29uc3QgaWNvbkVsID0gZWwucXVlcnlTZWxlY3RvcignLnNvLWNvbnRleHQtbWVudS1pdGVtLWljb24gLm1hdGVyaWFsLWljb25zJyk7XG4gICAgICBjb25zdCBzaG9ydGN1dEVsID0gZWwucXVlcnlTZWxlY3RvcignLnNvLWNvbnRleHQtbWVudS1pdGVtLXNob3J0Y3V0Jyk7XG4gICAgICBjb25zdCBzdWJtZW51RWwgPSBlbC5xdWVyeVNlbGVjdG9yKCcuc28tY29udGV4dC1tZW51LXN1Ym1lbnUnKTtcblxuICAgICAgY29uc3QgaXRlbSA9IHtcbiAgICAgICAgaWQ6IGVsLmRhdGFzZXQuaWQgfHwgYGl0ZW0tJHtsZXZlbH0tJHtpbmRleH1gLFxuICAgICAgICB0eXBlOiAnaXRlbScsXG4gICAgICAgIGxhYmVsOiB0ZXh0RWwgPyB0ZXh0RWwudGV4dENvbnRlbnQudHJpbSgpIDogZWwudGV4dENvbnRlbnQudHJpbSgpLFxuICAgICAgICBpY29uOiBpY29uRWwgPyBpY29uRWwudGV4dENvbnRlbnQudHJpbSgpIDogbnVsbCxcbiAgICAgICAgc2hvcnRjdXQ6IHNob3J0Y3V0RWwgPyBzaG9ydGN1dEVsLnRleHRDb250ZW50LnRyaW0oKSA6IG51bGwsXG4gICAgICAgIGRpc2FibGVkOiBlbC5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWRpc2FibGVkJyksXG4gICAgICAgIGRhbmdlcjogZWwuY2xhc3NMaXN0LmNvbnRhaW5zKFNpeE9yYml0LmNscygnZGFuZ2VyJykpLFxuICAgICAgICBjaGVja2VkOiBlbC5jbGFzc0xpc3QuY29udGFpbnMoU2l4T3JiaXQuY2xzKCdjaGVja2VkJykpLFxuICAgICAgICBkYXRhOiBlbC5kYXRhc2V0LmRhdGEgPyBKU09OLnBhcnNlKGVsLmRhdGFzZXQuZGF0YSkgOiB7fSxcbiAgICAgICAgZWxlbWVudDogZWwsXG4gICAgICAgIGxldmVsLFxuICAgICAgICBpdGVtczogW10sXG4gICAgICB9O1xuXG4gICAgICAvLyBQYXJzZSBzdWJtZW51IGl0ZW1zXG4gICAgICBpZiAoc3VibWVudUVsICYmIGxldmVsIDwgMikge1xuICAgICAgICBmb3IgKGxldCBpID0gMDsgaSA8IHN1Ym1lbnVFbC5jaGlsZHJlbi5sZW5ndGg7IGkrKykge1xuICAgICAgICAgIGNvbnN0IHN1Ykl0ZW0gPSB0aGlzLl9wYXJzZUl0ZW1FbGVtZW50KHN1Ym1lbnVFbC5jaGlsZHJlbltpXSwgbGV2ZWwgKyAxLCBpKTtcbiAgICAgICAgICBpZiAoc3ViSXRlbSkgaXRlbS5pdGVtcy5wdXNoKHN1Ykl0ZW0pO1xuICAgICAgICB9XG4gICAgICB9XG5cbiAgICAgIHJldHVybiBpdGVtO1xuICAgIH1cblxuICAgIHJldHVybiBudWxsO1xuICB9XG5cbiAgLyoqXG4gICAqIEJpbmQgZXZlbnQgbGlzdGVuZXJzXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfYmluZEV2ZW50cygpIHtcbiAgICAvLyBUcmlnZ2VyIGV2ZW50XG4gICAgaWYgKHRoaXMuX3RhcmdldCkge1xuICAgICAgY29uc3QgdHJpZ2dlckV2ZW50ID0gdGhpcy5vcHRpb25zLnRyaWdnZXIgPT09ICdjbGljaycgPyAnY2xpY2snIDogJ2NvbnRleHRtZW51JztcbiAgICAgIHRoaXMub24odHJpZ2dlckV2ZW50LCB0aGlzLl9oYW5kbGVUcmlnZ2VyLCB0aGlzLl90YXJnZXQpO1xuICAgIH1cblxuICAgIC8vIE1lbnUgaXRlbSBjbGlja3NcbiAgICBpZiAodGhpcy5fbWVudUVsZW1lbnQpIHtcbiAgICAgIHRoaXMub24oJ2NsaWNrJywgdGhpcy5faGFuZGxlSXRlbUNsaWNrLCB0aGlzLl9tZW51RWxlbWVudCk7XG4gICAgICB0aGlzLm9uKCdtb3VzZWVudGVyJywgdGhpcy5faGFuZGxlSXRlbUhvdmVyLCB0aGlzLl9tZW51RWxlbWVudCwgeyBjYXB0dXJlOiB0cnVlIH0pO1xuICAgICAgdGhpcy5vbignbW91c2VsZWF2ZScsIHRoaXMuX2hhbmRsZUl0ZW1MZWF2ZSwgdGhpcy5fbWVudUVsZW1lbnQsIHsgY2FwdHVyZTogdHJ1ZSB9KTtcbiAgICB9XG5cbiAgICAvLyBDbG9zZSBvbiBvdXRzaWRlIGNsaWNrXG4gICAgaWYgKHRoaXMub3B0aW9ucy5jbG9zZU9uT3V0c2lkZUNsaWNrKSB7XG4gICAgICB0aGlzLm9uKCdjbGljaycsIHRoaXMuX2hhbmRsZU91dHNpZGVDbGljaywgZG9jdW1lbnQpO1xuICAgICAgdGhpcy5vbignY29udGV4dG1lbnUnLCB0aGlzLl9oYW5kbGVPdXRzaWRlQ29udGV4dE1lbnUsIGRvY3VtZW50KTtcbiAgICB9XG5cbiAgICAvLyBLZXlib2FyZCBuYXZpZ2F0aW9uXG4gICAgdGhpcy5vbigna2V5ZG93bicsIHRoaXMuX2hhbmRsZUtleWRvd24sIGRvY3VtZW50KTtcblxuICAgIC8vIENsb3NlIG9uIHNjcm9sbFxuICAgIHRoaXMub24oJ3Njcm9sbCcsICgpID0+IHtcbiAgICAgIGlmICh0aGlzLl9pc09wZW4pIHRoaXMuY2xvc2UoKTtcbiAgICB9LCB3aW5kb3csIHsgcGFzc2l2ZTogdHJ1ZSB9KTtcblxuICAgIC8vIENsb3NlIG9uIHJlc2l6ZVxuICAgIHRoaXMub24oJ3Jlc2l6ZScsICgpID0+IHtcbiAgICAgIGlmICh0aGlzLl9pc09wZW4pIHRoaXMuY2xvc2UoKTtcbiAgICB9LCB3aW5kb3csIHsgcGFzc2l2ZTogdHJ1ZSB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUgdHJpZ2dlciBldmVudCAoY29udGV4dG1lbnUgb3IgY2xpY2spXG4gICAqIEBwYXJhbSB7RXZlbnR9IGUgLSBFdmVudCBvYmplY3RcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVUcmlnZ2VyKGUpIHtcbiAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcblxuICAgIGlmICh0aGlzLl9kaXNhYmxlZCkgcmV0dXJuO1xuXG4gICAgY29uc3QgeCA9IGUuY2xpZW50WCB8fCBlLnBhZ2VYO1xuICAgIGNvbnN0IHkgPSBlLmNsaWVudFkgfHwgZS5wYWdlWTtcblxuICAgIHRoaXMub3Blbih4LCB5LCBlKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUgaXRlbSBjbGlja1xuICAgKiBAcGFyYW0ge0V2ZW50fSBlIC0gQ2xpY2sgZXZlbnRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVJdGVtQ2xpY2soZSkge1xuICAgIGNvbnN0IGl0ZW1FbCA9IGUudGFyZ2V0LmNsb3Nlc3QoJy5zby1jb250ZXh0LW1lbnUtaXRlbScpO1xuICAgIGlmICghaXRlbUVsKSByZXR1cm47XG5cbiAgICAvLyBDaGVjayBpZiBkaXNhYmxlZFxuICAgIGlmIChpdGVtRWwuY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1kaXNhYmxlZCcpKSB7XG4gICAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIC8vIENoZWNrIGlmIGhhcyBzdWJtZW51IChkb24ndCBzZWxlY3QsIGxldCBob3ZlciBoYW5kbGUgaXQpXG4gICAgaWYgKGl0ZW1FbC5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWhhcy1zdWJtZW51JykpIHtcbiAgICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcblxuICAgIC8vIEZpbmQgaXRlbSBkYXRhXG4gICAgY29uc3QgaXRlbUlkID0gaXRlbUVsLmRhdGFzZXQuaWQ7XG4gICAgY29uc3QgaXRlbSA9IHRoaXMuX2l0ZW1zLmZpbmQoaSA9PiBpLmlkID09PSBpdGVtSWQpIHx8IHtcbiAgICAgIGlkOiBpdGVtSWQsXG4gICAgICBsYWJlbDogaXRlbUVsLnF1ZXJ5U2VsZWN0b3IoJy5zby1jb250ZXh0LW1lbnUtaXRlbS10ZXh0Jyk/LnRleHRDb250ZW50LnRyaW0oKSxcbiAgICAgIGRhdGE6IGl0ZW1FbC5kYXRhc2V0LmRhdGEgPyBKU09OLnBhcnNlKGl0ZW1FbC5kYXRhc2V0LmRhdGEpIDoge30sXG4gICAgICBlbGVtZW50OiBpdGVtRWwsXG4gICAgfTtcblxuICAgIC8vIEhhbmRsZSBjaGVja2FibGUgaXRlbXNcbiAgICBpZiAoaXRlbUVsLmNsYXNzTGlzdC5jb250YWlucyhTaXhPcmJpdC5jbHMoJ2NoZWNrZWQnKSkgfHwgaXRlbS5jaGVja2FibGUpIHtcbiAgICAgIGl0ZW1FbC5jbGFzc0xpc3QudG9nZ2xlKFNpeE9yYml0LmNscygnY2hlY2tlZCcpKTtcbiAgICAgIGl0ZW0uY2hlY2tlZCA9IGl0ZW1FbC5jbGFzc0xpc3QuY29udGFpbnMoU2l4T3JiaXQuY2xzKCdjaGVja2VkJykpO1xuICAgIH1cblxuICAgIC8vIEVtaXQgc2VsZWN0IGV2ZW50XG4gICAgdGhpcy5lbWl0KFNPQ29udGV4dE1lbnUuRVZFTlRTLlNFTEVDVCwge1xuICAgICAgaXRlbSxcbiAgICAgIGlkOiBpdGVtLmlkLFxuICAgICAgbGFiZWw6IGl0ZW0ubGFiZWwsXG4gICAgICBkYXRhOiBpdGVtLmRhdGEsXG4gICAgICBjaGVja2VkOiBpdGVtLmNoZWNrZWQsXG4gICAgfSk7XG5cbiAgICAvLyBDbG9zZSBtZW51XG4gICAgaWYgKHRoaXMub3B0aW9ucy5jbG9zZU9uU2VsZWN0KSB7XG4gICAgICB0aGlzLmNsb3NlKCk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIEhhbmRsZSBpdGVtIGhvdmVyIGZvciBzdWJtZW51c1xuICAgKiBAcGFyYW0ge0V2ZW50fSBlIC0gTW91c2UgZXZlbnRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVJdGVtSG92ZXIoZSkge1xuICAgIGNvbnN0IGl0ZW1FbCA9IGUudGFyZ2V0LmNsb3Nlc3QoJy5zby1jb250ZXh0LW1lbnUtaXRlbScpO1xuICAgIGlmICghaXRlbUVsKSByZXR1cm47XG5cbiAgICAvLyBDbGVhciBhbnkgcGVuZGluZyBzdWJtZW51IHRpbWVvdXRcbiAgICBpZiAodGhpcy5fc3VibWVudVRpbWVvdXQpIHtcbiAgICAgIGNsZWFyVGltZW91dCh0aGlzLl9zdWJtZW51VGltZW91dCk7XG4gICAgICB0aGlzLl9zdWJtZW51VGltZW91dCA9IG51bGw7XG4gICAgfVxuXG4gICAgLy8gQ2xvc2Ugb3RoZXIgc3VibWVudXMgYXQgdGhpcyBsZXZlbFxuICAgIGNvbnN0IHBhcmVudCA9IGl0ZW1FbC5wYXJlbnRFbGVtZW50O1xuICAgIGNvbnN0IHNpYmxpbmdzID0gcGFyZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJzpzY29wZSA+IC5zby1jb250ZXh0LW1lbnUtaXRlbS5zdWJtZW51LW9wZW4nKTtcbiAgICBzaWJsaW5ncy5mb3JFYWNoKHNpYiA9PiB7XG4gICAgICBpZiAoc2liICE9PSBpdGVtRWwpIHtcbiAgICAgICAgc2liLmNsYXNzTGlzdC5yZW1vdmUoJ3N1Ym1lbnUtb3BlbicpO1xuICAgICAgICBjb25zdCBzdWJtZW51ID0gc2liLnF1ZXJ5U2VsZWN0b3IoJy5zby1jb250ZXh0LW1lbnUtc3VibWVudScpO1xuICAgICAgICBpZiAoc3VibWVudSkgc3VibWVudS5jbGFzc0xpc3QucmVtb3ZlKCdzby1vcGVuJyk7XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICAvLyBDaGVjayBpZiBoYXMgc3VibWVudVxuICAgIGlmICghaXRlbUVsLmNsYXNzTGlzdC5jb250YWlucygnc28taGFzLXN1Ym1lbnUnKSkgcmV0dXJuO1xuXG4gICAgLy8gT3BlbiBzdWJtZW51IHdpdGggZGVsYXlcbiAgICB0aGlzLl9zdWJtZW51VGltZW91dCA9IHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgdGhpcy5fb3BlblN1Ym1lbnUoaXRlbUVsKTtcbiAgICB9LCB0aGlzLm9wdGlvbnMuc3VibWVudURlbGF5KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUgaXRlbSBsZWF2ZVxuICAgKiBAcGFyYW0ge0V2ZW50fSBlIC0gTW91c2UgZXZlbnRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVJdGVtTGVhdmUoZSkge1xuICAgIC8vIENsZWFyIHN1Ym1lbnUgdGltZW91dFxuICAgIGlmICh0aGlzLl9zdWJtZW51VGltZW91dCkge1xuICAgICAgY2xlYXJUaW1lb3V0KHRoaXMuX3N1Ym1lbnVUaW1lb3V0KTtcbiAgICAgIHRoaXMuX3N1Ym1lbnVUaW1lb3V0ID0gbnVsbDtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogT3BlbiBhIHN1Ym1lbnVcbiAgICogQHBhcmFtIHtFbGVtZW50fSBwYXJlbnRJdGVtIC0gUGFyZW50IGl0ZW0gZWxlbWVudFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX29wZW5TdWJtZW51KHBhcmVudEl0ZW0pIHtcbiAgICBjb25zdCBzdWJtZW51ID0gcGFyZW50SXRlbS5xdWVyeVNlbGVjdG9yKCcuc28tY29udGV4dC1tZW51LXN1Ym1lbnUnKTtcbiAgICBpZiAoIXN1Ym1lbnUpIHJldHVybjtcblxuICAgIC8vIE1hcmsgcGFyZW50IGFzIG9wZW5cbiAgICBwYXJlbnRJdGVtLmNsYXNzTGlzdC5hZGQoJ3N1Ym1lbnUtb3BlbicpO1xuXG4gICAgLy8gUG9zaXRpb24gc3VibWVudVxuICAgIHRoaXMuX3Bvc2l0aW9uU3VibWVudShwYXJlbnRJdGVtLCBzdWJtZW51KTtcblxuICAgIC8vIFNob3cgc3VibWVudVxuICAgIHN1Ym1lbnUuY2xhc3NMaXN0LmFkZCgnc28tb3BlbicpO1xuXG4gICAgLy8gRW1pdCBldmVudFxuICAgIGNvbnN0IGl0ZW1JZCA9IHBhcmVudEl0ZW0uZGF0YXNldC5pZDtcbiAgICBjb25zdCBpdGVtID0gdGhpcy5faXRlbXMuZmluZChpID0+IGkuaWQgPT09IGl0ZW1JZCk7XG4gICAgdGhpcy5lbWl0KFNPQ29udGV4dE1lbnUuRVZFTlRTLlNVQk1FTlVfU0hPVywge1xuICAgICAgcGFyZW50SXRlbTogaXRlbSxcbiAgICAgIGl0ZW1zOiBpdGVtPy5pdGVtcyB8fCBbXSxcbiAgICB9KTtcblxuICAgIHRoaXMuX2FjdGl2ZVN1Ym1lbnUgPSBzdWJtZW51O1xuICB9XG5cbiAgLyoqXG4gICAqIFBvc2l0aW9uIHN1Ym1lbnUgcmVsYXRpdmUgdG8gcGFyZW50XG4gICAqIEBwYXJhbSB7RWxlbWVudH0gcGFyZW50SXRlbSAtIFBhcmVudCBpdGVtIGVsZW1lbnRcbiAgICogQHBhcmFtIHtFbGVtZW50fSBzdWJtZW51IC0gU3VibWVudSBlbGVtZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfcG9zaXRpb25TdWJtZW51KHBhcmVudEl0ZW0sIHN1Ym1lbnUpIHtcbiAgICAvLyBSZXNldCBwb3NpdGlvbiBjbGFzc2VzXG4gICAgc3VibWVudS5jbGFzc0xpc3QucmVtb3ZlKCdzby1mbGlwLXgnKTtcblxuICAgIGNvbnN0IHBhcmVudFJlY3QgPSBwYXJlbnRJdGVtLmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xuICAgIGNvbnN0IHN1Ym1lbnVXaWR0aCA9IHN1Ym1lbnUub2Zmc2V0V2lkdGggfHwgMTYwO1xuICAgIGNvbnN0IHZpZXdwb3J0V2lkdGggPSB3aW5kb3cuaW5uZXJXaWR0aDtcblxuICAgIC8vIENoZWNrIGlmIHN1Ym1lbnUgd291bGQgb3ZlcmZsb3cgcmlnaHQgZWRnZVxuICAgIGlmIChwYXJlbnRSZWN0LnJpZ2h0ICsgc3VibWVudVdpZHRoID4gdmlld3BvcnRXaWR0aCAtIDEwKSB7XG4gICAgICBzdWJtZW51LmNsYXNzTGlzdC5hZGQoJ3NvLWZsaXAteCcpO1xuICAgIH1cblxuICAgIC8vIFZlcnRpY2FsIHBvc2l0aW9uIC0gYWxpZ24gdG9wIHdpdGggcGFyZW50XG4gICAgY29uc3Qgc3VibWVudUhlaWdodCA9IHN1Ym1lbnUub2Zmc2V0SGVpZ2h0IHx8IDEwMDtcbiAgICBjb25zdCB2aWV3cG9ydEhlaWdodCA9IHdpbmRvdy5pbm5lckhlaWdodDtcblxuICAgIGlmIChwYXJlbnRSZWN0LnRvcCArIHN1Ym1lbnVIZWlnaHQgPiB2aWV3cG9ydEhlaWdodCAtIDEwKSB7XG4gICAgICAvLyBTaGlmdCB1cFxuICAgICAgY29uc3Qgb2Zmc2V0ID0gTWF0aC5taW4oXG4gICAgICAgIHBhcmVudFJlY3QudG9wICsgc3VibWVudUhlaWdodCAtIHZpZXdwb3J0SGVpZ2h0ICsgMTAsXG4gICAgICAgIHBhcmVudFJlY3QudG9wIC0gMTBcbiAgICAgICk7XG4gICAgICBzdWJtZW51LnN0eWxlLnRvcCA9IGAtJHtvZmZzZXR9cHhgO1xuICAgIH0gZWxzZSB7XG4gICAgICBzdWJtZW51LnN0eWxlLnRvcCA9ICcwJztcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogSGFuZGxlIG91dHNpZGUgY2xpY2tcbiAgICogQHBhcmFtIHtFdmVudH0gZSAtIENsaWNrIGV2ZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlT3V0c2lkZUNsaWNrKGUpIHtcbiAgICBpZiAoIXRoaXMuX2lzT3BlbikgcmV0dXJuO1xuXG4gICAgLy8gQ2hlY2sgaWYgY2xpY2sgaXMgaW5zaWRlIG1lbnVcbiAgICBpZiAodGhpcy5fbWVudUVsZW1lbnQgJiYgdGhpcy5fbWVudUVsZW1lbnQuY29udGFpbnMoZS50YXJnZXQpKSByZXR1cm47XG5cbiAgICB0aGlzLmNsb3NlKCk7XG4gIH1cblxuICAvKipcbiAgICogSGFuZGxlIG91dHNpZGUgY29udGV4dCBtZW51XG4gICAqIEBwYXJhbSB7RXZlbnR9IGUgLSBDb250ZXh0IG1lbnUgZXZlbnRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVPdXRzaWRlQ29udGV4dE1lbnUoZSkge1xuICAgIGlmICghdGhpcy5faXNPcGVuKSByZXR1cm47XG5cbiAgICAvLyBJZiBpdCdzIG9uIG91ciB0YXJnZXQsIGxldCBfaGFuZGxlVHJpZ2dlciBoYW5kbGUgaXRcbiAgICBpZiAodGhpcy5fdGFyZ2V0ICYmIHRoaXMuX3RhcmdldC5jb250YWlucyhlLnRhcmdldCkpIHJldHVybjtcblxuICAgIC8vIElmIGl0J3MgaW5zaWRlIHRoZSBtZW51LCBkb24ndCBjbG9zZVxuICAgIGlmICh0aGlzLl9tZW51RWxlbWVudCAmJiB0aGlzLl9tZW51RWxlbWVudC5jb250YWlucyhlLnRhcmdldCkpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICB0aGlzLmNsb3NlKCk7XG4gIH1cblxuICAvKipcbiAgICogSGFuZGxlIGtleWJvYXJkIG5hdmlnYXRpb25cbiAgICogQHBhcmFtIHtLZXlib2FyZEV2ZW50fSBlIC0gS2V5Ym9hcmQgZXZlbnRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVLZXlkb3duKGUpIHtcbiAgICBpZiAoIXRoaXMuX2lzT3BlbikgcmV0dXJuO1xuXG4gICAgc3dpdGNoIChlLmtleSkge1xuICAgICAgY2FzZSAnRXNjYXBlJzpcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB0aGlzLmNsb3NlKCk7XG4gICAgICAgIGJyZWFrO1xuXG4gICAgICBjYXNlICdBcnJvd0Rvd24nOlxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHRoaXMuX2ZvY3VzTmV4dEl0ZW0oMSk7XG4gICAgICAgIGJyZWFrO1xuXG4gICAgICBjYXNlICdBcnJvd1VwJzpcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB0aGlzLl9mb2N1c05leHRJdGVtKC0xKTtcbiAgICAgICAgYnJlYWs7XG5cbiAgICAgIGNhc2UgJ0Fycm93UmlnaHQnOlxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHRoaXMuX29wZW5Gb2N1c2VkU3VibWVudSgpO1xuICAgICAgICBicmVhaztcblxuICAgICAgY2FzZSAnQXJyb3dMZWZ0JzpcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB0aGlzLl9jbG9zZUFjdGl2ZVN1Ym1lbnUoKTtcbiAgICAgICAgYnJlYWs7XG5cbiAgICAgIGNhc2UgJ0VudGVyJzpcbiAgICAgIGNhc2UgJyAnOlxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHRoaXMuX3NlbGVjdEZvY3VzZWRJdGVtKCk7XG4gICAgICAgIGJyZWFrO1xuXG4gICAgICBjYXNlICdIb21lJzpcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB0aGlzLl9mb2N1c0l0ZW0oMCk7XG4gICAgICAgIGJyZWFrO1xuXG4gICAgICBjYXNlICdFbmQnOlxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHRoaXMuX2ZvY3VzSXRlbSh0aGlzLl9nZXROYXZpZ2FibGVJdGVtcygpLmxlbmd0aCAtIDEpO1xuICAgICAgICBicmVhaztcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogR2V0IG5hdmlnYWJsZSBpdGVtcyAoZXhjbHVkaW5nIGhlYWRlcnMsIGRpdmlkZXJzLCBkaXNhYmxlZClcbiAgICogQHBhcmFtIHtFbGVtZW50fSBbY29udGFpbmVyXSAtIENvbnRhaW5lciB0byBzZWFyY2ggaW5cbiAgICogQHJldHVybnMge0VsZW1lbnRbXX0gQXJyYXkgb2YgbmF2aWdhYmxlIGl0ZW1zXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfZ2V0TmF2aWdhYmxlSXRlbXMoY29udGFpbmVyKSB7XG4gICAgY29uc3QgY29udCA9IGNvbnRhaW5lciB8fCB0aGlzLl9tZW51RWxlbWVudDtcbiAgICByZXR1cm4gQXJyYXkuZnJvbShjb250LnF1ZXJ5U2VsZWN0b3JBbGwoJzpzY29wZSA+IC5zby1jb250ZXh0LW1lbnUtaXRlbTpub3QoLmRpc2FibGVkKScpKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBGb2N1cyBuZXh0L3ByZXZpb3VzIGl0ZW1cbiAgICogQHBhcmFtIHtudW1iZXJ9IGRpcmVjdGlvbiAtIDEgZm9yIG5leHQsIC0xIGZvciBwcmV2aW91c1xuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2ZvY3VzTmV4dEl0ZW0oZGlyZWN0aW9uKSB7XG4gICAgY29uc3QgaXRlbXMgPSB0aGlzLl9nZXROYXZpZ2FibGVJdGVtcygpO1xuICAgIGlmIChpdGVtcy5sZW5ndGggPT09IDApIHJldHVybjtcblxuICAgIGxldCBuZXdJbmRleCA9IHRoaXMuX2ZvY3VzZWRJbmRleCArIGRpcmVjdGlvbjtcblxuICAgIC8vIFdyYXAgYXJvdW5kXG4gICAgaWYgKG5ld0luZGV4IDwgMCkgbmV3SW5kZXggPSBpdGVtcy5sZW5ndGggLSAxO1xuICAgIGlmIChuZXdJbmRleCA+PSBpdGVtcy5sZW5ndGgpIG5ld0luZGV4ID0gMDtcblxuICAgIHRoaXMuX2ZvY3VzSXRlbShuZXdJbmRleCk7XG4gIH1cblxuICAvKipcbiAgICogRm9jdXMgaXRlbSBieSBpbmRleFxuICAgKiBAcGFyYW0ge251bWJlcn0gaW5kZXggLSBJdGVtIGluZGV4XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfZm9jdXNJdGVtKGluZGV4KSB7XG4gICAgY29uc3QgaXRlbXMgPSB0aGlzLl9nZXROYXZpZ2FibGVJdGVtcygpO1xuXG4gICAgLy8gUmVtb3ZlIGZvY3VzIGZyb20gYWxsXG4gICAgaXRlbXMuZm9yRWFjaChpdGVtID0+IGl0ZW0uY2xhc3NMaXN0LnJlbW92ZSgnc28tZm9jdXNlZCcpKTtcblxuICAgIHRoaXMuX2ZvY3VzZWRJbmRleCA9IGluZGV4O1xuICAgIGlmIChpdGVtc1tpbmRleF0pIHtcbiAgICAgIGl0ZW1zW2luZGV4XS5jbGFzc0xpc3QuYWRkKCdzby1mb2N1c2VkJyk7XG4gICAgICBpdGVtc1tpbmRleF0uc2Nyb2xsSW50b1ZpZXcoeyBibG9jazogJ25lYXJlc3QnIH0pO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBPcGVuIHN1Ym1lbnUgb2YgZm9jdXNlZCBpdGVtXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfb3BlbkZvY3VzZWRTdWJtZW51KCkge1xuICAgIGNvbnN0IGl0ZW1zID0gdGhpcy5fZ2V0TmF2aWdhYmxlSXRlbXMoKTtcbiAgICBpZiAodGhpcy5fZm9jdXNlZEluZGV4IDwgMCB8fCAhaXRlbXNbdGhpcy5fZm9jdXNlZEluZGV4XSkgcmV0dXJuO1xuXG4gICAgY29uc3QgaXRlbSA9IGl0ZW1zW3RoaXMuX2ZvY3VzZWRJbmRleF07XG4gICAgaWYgKGl0ZW0uY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1oYXMtc3VibWVudScpKSB7XG4gICAgICB0aGlzLl9vcGVuU3VibWVudShpdGVtKTtcbiAgICAgIC8vIEZvY3VzIGZpcnN0IGl0ZW0gaW4gc3VibWVudVxuICAgICAgY29uc3Qgc3VibWVudSA9IGl0ZW0ucXVlcnlTZWxlY3RvcignLnNvLWNvbnRleHQtbWVudS1zdWJtZW51Jyk7XG4gICAgICBpZiAoc3VibWVudSkge1xuICAgICAgICBjb25zdCBzdWJJdGVtcyA9IHRoaXMuX2dldE5hdmlnYWJsZUl0ZW1zKHN1Ym1lbnUpO1xuICAgICAgICBpZiAoc3ViSXRlbXNbMF0pIHN1Ykl0ZW1zWzBdLmNsYXNzTGlzdC5hZGQoJ3NvLWZvY3VzZWQnKTtcbiAgICAgIH1cbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogQ2xvc2UgYWN0aXZlIHN1Ym1lbnVcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9jbG9zZUFjdGl2ZVN1Ym1lbnUoKSB7XG4gICAgaWYgKCF0aGlzLl9hY3RpdmVTdWJtZW51KSByZXR1cm47XG5cbiAgICBjb25zdCBwYXJlbnRJdGVtID0gdGhpcy5fYWN0aXZlU3VibWVudS5jbG9zZXN0KCcuc28tY29udGV4dC1tZW51LWl0ZW0nKTtcbiAgICBpZiAocGFyZW50SXRlbSkge1xuICAgICAgcGFyZW50SXRlbS5jbGFzc0xpc3QucmVtb3ZlKCdzdWJtZW51LW9wZW4nKTtcbiAgICAgIHRoaXMuX2FjdGl2ZVN1Ym1lbnUuY2xhc3NMaXN0LnJlbW92ZSgnc28tb3BlbicpO1xuXG4gICAgICAvLyBFbWl0IGV2ZW50XG4gICAgICBjb25zdCBpdGVtSWQgPSBwYXJlbnRJdGVtLmRhdGFzZXQuaWQ7XG4gICAgICBjb25zdCBpdGVtID0gdGhpcy5faXRlbXMuZmluZChpID0+IGkuaWQgPT09IGl0ZW1JZCk7XG4gICAgICB0aGlzLmVtaXQoU09Db250ZXh0TWVudS5FVkVOVFMuU1VCTUVOVV9ISURFLCB7IHBhcmVudEl0ZW06IGl0ZW0gfSk7XG4gICAgfVxuXG4gICAgdGhpcy5fYWN0aXZlU3VibWVudSA9IG51bGw7XG4gIH1cblxuICAvKipcbiAgICogU2VsZWN0IHRoZSBmb2N1c2VkIGl0ZW1cbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9zZWxlY3RGb2N1c2VkSXRlbSgpIHtcbiAgICBjb25zdCBpdGVtcyA9IHRoaXMuX2dldE5hdmlnYWJsZUl0ZW1zKCk7XG4gICAgaWYgKHRoaXMuX2ZvY3VzZWRJbmRleCA8IDAgfHwgIWl0ZW1zW3RoaXMuX2ZvY3VzZWRJbmRleF0pIHJldHVybjtcblxuICAgIGNvbnN0IGl0ZW0gPSBpdGVtc1t0aGlzLl9mb2N1c2VkSW5kZXhdO1xuXG4gICAgLy8gSWYgaGFzIHN1Ym1lbnUsIG9wZW4gaXRcbiAgICBpZiAoaXRlbS5jbGFzc0xpc3QuY29udGFpbnMoJ3NvLWhhcy1zdWJtZW51JykpIHtcbiAgICAgIHRoaXMuX29wZW5Gb2N1c2VkU3VibWVudSgpO1xuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIC8vIFRyaWdnZXIgY2xpY2tcbiAgICBpdGVtLmNsaWNrKCk7XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBQVUJMSUMgQVBJIC0gTUVOVSBDT05UUk9MXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIE9wZW4gdGhlIGNvbnRleHQgbWVudSBhdCBjb29yZGluYXRlc1xuICAgKiBAcGFyYW0ge251bWJlcn0geCAtIFggY29vcmRpbmF0ZVxuICAgKiBAcGFyYW0ge251bWJlcn0geSAtIFkgY29vcmRpbmF0ZVxuICAgKiBAcGFyYW0ge0V2ZW50fSBbb3JpZ2luYWxFdmVudF0gLSBPcmlnaW5hbCBldmVudCB0aGF0IHRyaWdnZXJlZCBvcGVuXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIG9wZW4oeCwgeSwgb3JpZ2luYWxFdmVudCA9IG51bGwpIHtcbiAgICBpZiAodGhpcy5faXNPcGVuIHx8IHRoaXMuX2Rpc2FibGVkIHx8ICF0aGlzLl9tZW51RWxlbWVudCkgcmV0dXJuIHRoaXM7XG5cbiAgICAvLyBFbWl0IGNhbmNlbGFibGUgc2hvdyBldmVudFxuICAgIGNvbnN0IHNob3dBbGxvd2VkID0gdGhpcy5lbWl0KFNPQ29udGV4dE1lbnUuRVZFTlRTLlNIT1csIHtcbiAgICAgIHgsXG4gICAgICB5LFxuICAgICAgb3JpZ2luYWxFdmVudCxcbiAgICB9LCB0cnVlLCB0cnVlKTtcblxuICAgIGlmICghc2hvd0FsbG93ZWQpIHJldHVybiB0aGlzO1xuXG4gICAgdGhpcy5faXNPcGVuID0gdHJ1ZTtcblxuICAgIC8vIFBvc2l0aW9uIG1lbnVcbiAgICB0aGlzLl9wb3NpdGlvbk1lbnUoeCwgeSk7XG5cbiAgICAvLyBTaG93IG1lbnVcbiAgICB0aGlzLl9tZW51RWxlbWVudC5jbGFzc0xpc3QuYWRkKCdzby1vcGVuJyk7XG5cbiAgICAvLyBSZXNldCBmb2N1c1xuICAgIHRoaXMuX2ZvY3VzZWRJbmRleCA9IC0xO1xuXG4gICAgLy8gRW1pdCBzaG93biBldmVudCBhZnRlciB0cmFuc2l0aW9uXG4gICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICB0aGlzLmVtaXQoU09Db250ZXh0TWVudS5FVkVOVFMuU0hPV04sIHsgeCwgeSB9KTtcbiAgICB9LCAxNTApO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogUG9zaXRpb24gdGhlIG1lbnUgYXQgY29vcmRpbmF0ZXNcbiAgICogQHBhcmFtIHtudW1iZXJ9IHggLSBYIGNvb3JkaW5hdGVcbiAgICogQHBhcmFtIHtudW1iZXJ9IHkgLSBZIGNvb3JkaW5hdGVcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9wb3NpdGlvbk1lbnUoeCwgeSkge1xuICAgIGNvbnN0IG1lbnUgPSB0aGlzLl9tZW51RWxlbWVudDtcblxuICAgIC8vIFJlc2V0IHBvc2l0aW9uIGNsYXNzZXNcbiAgICBtZW51LmNsYXNzTGlzdC5yZW1vdmUoJ3NvLWZsaXAteCcsICdzby1mbGlwLXknKTtcblxuICAgIC8vIFRlbXBvcmFyaWx5IHNob3cgdG8gZ2V0IGRpbWVuc2lvbnNcbiAgICBtZW51LnN0eWxlLnZpc2liaWxpdHkgPSAnaGlkZGVuJztcbiAgICBtZW51LnN0eWxlLmRpc3BsYXkgPSAnYmxvY2snO1xuICAgIG1lbnUuc3R5bGUub3BhY2l0eSA9ICcwJztcblxuICAgIGNvbnN0IG1lbnVXaWR0aCA9IG1lbnUub2Zmc2V0V2lkdGg7XG4gICAgY29uc3QgbWVudUhlaWdodCA9IG1lbnUub2Zmc2V0SGVpZ2h0O1xuXG4gICAgbWVudS5zdHlsZS52aXNpYmlsaXR5ID0gJyc7XG4gICAgbWVudS5zdHlsZS5kaXNwbGF5ID0gJyc7XG4gICAgbWVudS5zdHlsZS5vcGFjaXR5ID0gJyc7XG5cbiAgICBjb25zdCB2aWV3cG9ydFdpZHRoID0gd2luZG93LmlubmVyV2lkdGg7XG4gICAgY29uc3Qgdmlld3BvcnRIZWlnaHQgPSB3aW5kb3cuaW5uZXJIZWlnaHQ7XG5cbiAgICBsZXQgZmluYWxYID0geDtcbiAgICBsZXQgZmluYWxZID0geTtcblxuICAgIC8vIENoZWNrIHJpZ2h0IGVkZ2VcbiAgICBpZiAoeCArIG1lbnVXaWR0aCA+IHZpZXdwb3J0V2lkdGggLSAxMCkge1xuICAgICAgZmluYWxYID0geCAtIG1lbnVXaWR0aDtcbiAgICAgIG1lbnUuY2xhc3NMaXN0LmFkZCgnc28tZmxpcC14Jyk7XG4gICAgfVxuXG4gICAgLy8gQ2hlY2sgYm90dG9tIGVkZ2VcbiAgICBpZiAoeSArIG1lbnVIZWlnaHQgPiB2aWV3cG9ydEhlaWdodCAtIDEwKSB7XG4gICAgICBmaW5hbFkgPSB5IC0gbWVudUhlaWdodDtcbiAgICAgIG1lbnUuY2xhc3NMaXN0LmFkZCgnc28tZmxpcC15Jyk7XG4gICAgfVxuXG4gICAgLy8gRW5zdXJlIG1pbmltdW0gYm91bmRzXG4gICAgZmluYWxYID0gTWF0aC5tYXgoMTAsIGZpbmFsWCk7XG4gICAgZmluYWxZID0gTWF0aC5tYXgoMTAsIGZpbmFsWSk7XG5cbiAgICBtZW51LnN0eWxlLmxlZnQgPSBgJHtmaW5hbFh9cHhgO1xuICAgIG1lbnUuc3R5bGUudG9wID0gYCR7ZmluYWxZfXB4YDtcbiAgfVxuXG4gIC8qKlxuICAgKiBDbG9zZSB0aGUgY29udGV4dCBtZW51XG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIGNsb3NlKCkge1xuICAgIGlmICghdGhpcy5faXNPcGVuIHx8ICF0aGlzLl9tZW51RWxlbWVudCkgcmV0dXJuIHRoaXM7XG5cbiAgICAvLyBFbWl0IGNhbmNlbGFibGUgaGlkZSBldmVudFxuICAgIGNvbnN0IGhpZGVBbGxvd2VkID0gdGhpcy5lbWl0KFNPQ29udGV4dE1lbnUuRVZFTlRTLkhJREUsIHt9LCB0cnVlLCB0cnVlKTtcbiAgICBpZiAoIWhpZGVBbGxvd2VkKSByZXR1cm4gdGhpcztcblxuICAgIHRoaXMuX2lzT3BlbiA9IGZhbHNlO1xuXG4gICAgLy8gQ2xvc2UgYWxsIHN1Ym1lbnVzXG4gICAgdGhpcy5fY2xvc2VBbGxTdWJtZW51cygpO1xuXG4gICAgLy8gQ2xlYXIgZm9jdXNcbiAgICBjb25zdCBmb2N1c2VkID0gdGhpcy5fbWVudUVsZW1lbnQucXVlcnlTZWxlY3RvcignLnNvLWNvbnRleHQtbWVudS1pdGVtLnNvLWZvY3VzZWQnKTtcbiAgICBpZiAoZm9jdXNlZCkgZm9jdXNlZC5jbGFzc0xpc3QucmVtb3ZlKCdzby1mb2N1c2VkJyk7XG4gICAgdGhpcy5fZm9jdXNlZEluZGV4ID0gLTE7XG5cbiAgICAvLyBIaWRlIG1lbnVcbiAgICBpZiAodGhpcy5vcHRpb25zLmFuaW1hdGVkKSB7XG4gICAgICB0aGlzLl9tZW51RWxlbWVudC5jbGFzc0xpc3QuYWRkKCdzby1jbG9zaW5nJyk7XG4gICAgICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgICAgdGhpcy5fbWVudUVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZSgnc28tb3BlbicsICdzby1jbG9zaW5nJyk7XG4gICAgICAgIHRoaXMuZW1pdChTT0NvbnRleHRNZW51LkVWRU5UUy5ISURERU4pO1xuICAgICAgfSwgMTUwKTtcbiAgICB9IGVsc2Uge1xuICAgICAgdGhpcy5fbWVudUVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZSgnc28tb3BlbicpO1xuICAgICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIHRoaXMuZW1pdChTT0NvbnRleHRNZW51LkVWRU5UUy5ISURERU4pO1xuICAgICAgfSwgMTUwKTtcbiAgICB9XG5cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBDbG9zZSBhbGwgc3VibWVudXNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9jbG9zZUFsbFN1Ym1lbnVzKCkge1xuICAgIGlmICghdGhpcy5fbWVudUVsZW1lbnQpIHJldHVybjtcblxuICAgIGNvbnN0IG9wZW5TdWJtZW51cyA9IHRoaXMuX21lbnVFbGVtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1jb250ZXh0LW1lbnUtc3VibWVudS5zby1vcGVuJyk7XG4gICAgb3BlblN1Ym1lbnVzLmZvckVhY2goc3VibWVudSA9PiBzdWJtZW51LmNsYXNzTGlzdC5yZW1vdmUoJ3NvLW9wZW4nKSk7XG5cbiAgICBjb25zdCBvcGVuUGFyZW50cyA9IHRoaXMuX21lbnVFbGVtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1jb250ZXh0LW1lbnUtaXRlbS5zdWJtZW51LW9wZW4nKTtcbiAgICBvcGVuUGFyZW50cy5mb3JFYWNoKHBhcmVudCA9PiBwYXJlbnQuY2xhc3NMaXN0LnJlbW92ZSgnc3VibWVudS1vcGVuJykpO1xuXG4gICAgdGhpcy5fYWN0aXZlU3VibWVudSA9IG51bGw7XG4gIH1cblxuICAvKipcbiAgICogVG9nZ2xlIHRoZSBjb250ZXh0IG1lbnVcbiAgICogQHBhcmFtIHtudW1iZXJ9IHggLSBYIGNvb3JkaW5hdGVcbiAgICogQHBhcmFtIHtudW1iZXJ9IHkgLSBZIGNvb3JkaW5hdGVcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgdG9nZ2xlKHgsIHkpIHtcbiAgICByZXR1cm4gdGhpcy5faXNPcGVuID8gdGhpcy5jbG9zZSgpIDogdGhpcy5vcGVuKHgsIHkpO1xuICB9XG5cbiAgLyoqXG4gICAqIENoZWNrIGlmIG1lbnUgaXMgb3BlblxuICAgKiBAcmV0dXJucyB7Ym9vbGVhbn0gT3BlbiBzdGF0ZVxuICAgKi9cbiAgaXNPcGVuKCkge1xuICAgIHJldHVybiB0aGlzLl9pc09wZW47XG4gIH1cblxuICAvKipcbiAgICogRW5hYmxlIHRoZSBlbnRpcmUgbWVudVxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBlbmFibGUoKSB7XG4gICAgdGhpcy5fZGlzYWJsZWQgPSBmYWxzZTtcbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBEaXNhYmxlIHRoZSBlbnRpcmUgbWVudVxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBkaXNhYmxlKCkge1xuICAgIHRoaXMuX2Rpc2FibGVkID0gdHJ1ZTtcbiAgICBpZiAodGhpcy5faXNPcGVuKSB0aGlzLmNsb3NlKCk7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogQ2hlY2sgaWYgbWVudSBpcyBkaXNhYmxlZFxuICAgKiBAcmV0dXJucyB7Ym9vbGVhbn0gRGlzYWJsZWQgc3RhdGVcbiAgICovXG4gIGlzRGlzYWJsZWQoKSB7XG4gICAgcmV0dXJuIHRoaXMuX2Rpc2FibGVkO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gUFVCTElDIEFQSSAtIElURU0gTUFOQUdFTUVOVFxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBBZGQgYW4gaXRlbSB0byB0aGUgbWVudVxuICAgKiBAcGFyYW0ge09iamVjdH0gaXRlbSAtIEl0ZW0gY29uZmlndXJhdGlvblxuICAgKiBAcGFyYW0ge251bWJlcnxzdHJpbmd8T2JqZWN0fSBbcG9zaXRpb249J2JvdHRvbSddIC0gUG9zaXRpb246IGluZGV4LCAndG9wJywgJ2JvdHRvbScsIHtiZWZvcmU6J2lkJ30sIHthZnRlcjonaWQnfSwge2dyb3VwOidpZCcscG9zaXRpb246J3RvcCd8J2JvdHRvbSd9XG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIGFkZChpdGVtLCBwb3NpdGlvbiA9ICdib3R0b20nKSB7XG4gICAgaWYgKCF0aGlzLl9tZW51RWxlbWVudCkgcmV0dXJuIHRoaXM7XG5cbiAgICBjb25zdCBpdGVtRWwgPSB0aGlzLl9jcmVhdGVJdGVtRWxlbWVudChpdGVtLCAwKTtcblxuICAgIC8vIERldGVybWluZSBpbnNlcnQgcG9zaXRpb25cbiAgICBsZXQgcmVmZXJlbmNlTm9kZSA9IG51bGw7XG4gICAgbGV0IGluc2VydEJlZm9yZSA9IHRydWU7XG5cbiAgICBpZiAodHlwZW9mIHBvc2l0aW9uID09PSAnbnVtYmVyJykge1xuICAgICAgLy8gSW5zZXJ0IGF0IGluZGV4XG4gICAgICBjb25zdCBjaGlsZHJlbiA9IEFycmF5LmZyb20odGhpcy5fbWVudUVsZW1lbnQuY2hpbGRyZW4pO1xuICAgICAgcmVmZXJlbmNlTm9kZSA9IGNoaWxkcmVuW3Bvc2l0aW9uXSB8fCBudWxsO1xuICAgIH0gZWxzZSBpZiAocG9zaXRpb24gPT09ICd0b3AnKSB7XG4gICAgICByZWZlcmVuY2VOb2RlID0gdGhpcy5fbWVudUVsZW1lbnQuZmlyc3RDaGlsZDtcbiAgICB9IGVsc2UgaWYgKHBvc2l0aW9uID09PSAnYm90dG9tJykge1xuICAgICAgcmVmZXJlbmNlTm9kZSA9IG51bGw7XG4gICAgICBpbnNlcnRCZWZvcmUgPSBmYWxzZTtcbiAgICB9IGVsc2UgaWYgKHR5cGVvZiBwb3NpdGlvbiA9PT0gJ29iamVjdCcpIHtcbiAgICAgIGlmIChwb3NpdGlvbi5iZWZvcmUpIHtcbiAgICAgICAgcmVmZXJlbmNlTm9kZSA9IHRoaXMuX21lbnVFbGVtZW50LnF1ZXJ5U2VsZWN0b3IoYFtkYXRhLWlkPVwiJHtwb3NpdGlvbi5iZWZvcmV9XCJdYCk7XG4gICAgICB9IGVsc2UgaWYgKHBvc2l0aW9uLmFmdGVyKSB7XG4gICAgICAgIGNvbnN0IGFmdGVyRWwgPSB0aGlzLl9tZW51RWxlbWVudC5xdWVyeVNlbGVjdG9yKGBbZGF0YS1pZD1cIiR7cG9zaXRpb24uYWZ0ZXJ9XCJdYCk7XG4gICAgICAgIHJlZmVyZW5jZU5vZGUgPSBhZnRlckVsPy5uZXh0U2libGluZyB8fCBudWxsO1xuICAgICAgfSBlbHNlIGlmIChwb3NpdGlvbi5ncm91cCkge1xuICAgICAgICBjb25zdCBncm91cEVsID0gdGhpcy5fbWVudUVsZW1lbnQucXVlcnlTZWxlY3RvcihgW2RhdGEtZ3JvdXAtaWQ9XCIke3Bvc2l0aW9uLmdyb3VwfVwiXWApO1xuICAgICAgICBpZiAoZ3JvdXBFbCkge1xuICAgICAgICAgIGlmIChwb3NpdGlvbi5wb3NpdGlvbiA9PT0gJ3RvcCcpIHtcbiAgICAgICAgICAgIHJlZmVyZW5jZU5vZGUgPSBncm91cEVsLmZpcnN0Q2hpbGQ7XG4gICAgICAgICAgICBpbnNlcnRCZWZvcmUgPSB0cnVlO1xuICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICByZWZlcmVuY2VOb2RlID0gbnVsbDtcbiAgICAgICAgICAgIGluc2VydEJlZm9yZSA9IGZhbHNlO1xuICAgICAgICAgIH1cbiAgICAgICAgICAvLyBJbnNlcnQgaW50byBncm91cFxuICAgICAgICAgIGlmIChpbnNlcnRCZWZvcmUgJiYgcmVmZXJlbmNlTm9kZSkge1xuICAgICAgICAgICAgZ3JvdXBFbC5pbnNlcnRCZWZvcmUoaXRlbUVsLCByZWZlcmVuY2VOb2RlKTtcbiAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgZ3JvdXBFbC5hcHBlbmRDaGlsZChpdGVtRWwpO1xuICAgICAgICAgIH1cbiAgICAgICAgICB0aGlzLl9zdG9yZUl0ZW0oaXRlbSwgaXRlbUVsLCAwKTtcbiAgICAgICAgICByZXR1cm4gdGhpcztcbiAgICAgICAgfVxuICAgICAgfVxuICAgIH1cblxuICAgIC8vIEluc2VydCBpbnRvIG1haW4gbWVudVxuICAgIGlmIChpbnNlcnRCZWZvcmUgJiYgcmVmZXJlbmNlTm9kZSkge1xuICAgICAgdGhpcy5fbWVudUVsZW1lbnQuaW5zZXJ0QmVmb3JlKGl0ZW1FbCwgcmVmZXJlbmNlTm9kZSk7XG4gICAgfSBlbHNlIHtcbiAgICAgIHRoaXMuX21lbnVFbGVtZW50LmFwcGVuZENoaWxkKGl0ZW1FbCk7XG4gICAgfVxuXG4gICAgdGhpcy5fc3RvcmVJdGVtKGl0ZW0sIGl0ZW1FbCwgMCk7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogU3RvcmUgaXRlbSBkYXRhXG4gICAqIEBwYXJhbSB7T2JqZWN0fSBpdGVtIC0gSXRlbSBjb25maWdcbiAgICogQHBhcmFtIHtFbGVtZW50fSBpdGVtRWwgLSBJdGVtIGVsZW1lbnRcbiAgICogQHBhcmFtIHtudW1iZXJ9IGxldmVsIC0gTmVzdGluZyBsZXZlbFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3N0b3JlSXRlbShpdGVtLCBpdGVtRWwsIGxldmVsKSB7XG4gICAgY29uc3QgaXRlbURhdGEgPSB7XG4gICAgICAuLi5pdGVtLFxuICAgICAgaWQ6IGl0ZW0uaWQgfHwgYGl0ZW0tJHtEYXRlLm5vdygpfS0ke01hdGgucmFuZG9tKCkudG9TdHJpbmcoMzYpLnN1YnN0cigyLCA5KX1gLFxuICAgICAgZWxlbWVudDogaXRlbUVsLFxuICAgICAgbGV2ZWwsXG4gICAgfTtcbiAgICBpdGVtRWwuZGF0YXNldC5pZCA9IGl0ZW1EYXRhLmlkO1xuICAgIHRoaXMuX2l0ZW1zLnB1c2goaXRlbURhdGEpO1xuXG4gICAgaWYgKGl0ZW0uZ3JvdXBJZCkge1xuICAgICAgaWYgKCF0aGlzLl9ncm91cHMuaGFzKGl0ZW0uZ3JvdXBJZCkpIHtcbiAgICAgICAgdGhpcy5fZ3JvdXBzLnNldChpdGVtLmdyb3VwSWQsIFtdKTtcbiAgICAgIH1cbiAgICAgIHRoaXMuX2dyb3Vwcy5nZXQoaXRlbS5ncm91cElkKS5wdXNoKGl0ZW1EYXRhLmlkKTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogQWRkIGEgZ3JvdXAgb2YgaXRlbXNcbiAgICogQHBhcmFtIHtzdHJpbmd9IGdyb3VwSWQgLSBHcm91cCBpZGVudGlmaWVyXG4gICAqIEBwYXJhbSB7QXJyYXl9IGl0ZW1zIC0gSXRlbXMgdG8gYWRkXG4gICAqIEBwYXJhbSB7c3RyaW5nfG51bWJlcn0gW3Bvc2l0aW9uPSdib3R0b20nXSAtIFBvc2l0aW9uIGluIG1lbnVcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgYWRkR3JvdXAoZ3JvdXBJZCwgaXRlbXMsIHBvc2l0aW9uID0gJ2JvdHRvbScpIHtcbiAgICBjb25zdCBncm91cENvbmZpZyA9IHtcbiAgICAgIHR5cGU6ICdncm91cCcsXG4gICAgICBpZDogZ3JvdXBJZCxcbiAgICAgIGdyb3VwSWQ6IGdyb3VwSWQsXG4gICAgICBpdGVtczogaXRlbXMsXG4gICAgfTtcbiAgICByZXR1cm4gdGhpcy5hZGQoZ3JvdXBDb25maWcsIHBvc2l0aW9uKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBBZGQgYSBzZXBhcmF0b3IvZGl2aWRlclxuICAgKiBAcGFyYW0ge251bWJlcnxzdHJpbmd8T2JqZWN0fSBbcG9zaXRpb249J2JvdHRvbSddIC0gUG9zaXRpb25cbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgYWRkU2VwYXJhdG9yKHBvc2l0aW9uID0gJ2JvdHRvbScpIHtcbiAgICByZXR1cm4gdGhpcy5hZGQoeyB0eXBlOiAnZGl2aWRlcicgfSwgcG9zaXRpb24pO1xuICB9XG5cbiAgLyoqXG4gICAqIEFkZCBhIGhlYWRlclxuICAgKiBAcGFyYW0ge3N0cmluZ30gdGV4dCAtIEhlYWRlciB0ZXh0XG4gICAqIEBwYXJhbSB7bnVtYmVyfHN0cmluZ3xPYmplY3R9IFtwb3NpdGlvbj0nYm90dG9tJ10gLSBQb3NpdGlvblxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBhZGRIZWFkZXIodGV4dCwgcG9zaXRpb24gPSAnYm90dG9tJykge1xuICAgIHJldHVybiB0aGlzLmFkZCh7IHR5cGU6ICdoZWFkZXInLCBsYWJlbDogdGV4dCB9LCBwb3NpdGlvbik7XG4gIH1cblxuICAvKipcbiAgICogUmVtb3ZlIGFuIGl0ZW0gYnkgaWQgb3IgaW5kZXhcbiAgICogQHBhcmFtIHtzdHJpbmd8bnVtYmVyfSBpZGVudGlmaWVyIC0gSXRlbSBpZCBvciBpbmRleFxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICByZW1vdmUoaWRlbnRpZmllcikge1xuICAgIGxldCBpdGVtO1xuXG4gICAgaWYgKHR5cGVvZiBpZGVudGlmaWVyID09PSAnbnVtYmVyJykge1xuICAgICAgaXRlbSA9IHRoaXMuX2l0ZW1zW2lkZW50aWZpZXJdO1xuICAgIH0gZWxzZSB7XG4gICAgICBpdGVtID0gdGhpcy5faXRlbXMuZmluZChpID0+IGkuaWQgPT09IGlkZW50aWZpZXIpO1xuICAgIH1cblxuICAgIGlmIChpdGVtICYmIGl0ZW0uZWxlbWVudCkge1xuICAgICAgaXRlbS5lbGVtZW50LnJlbW92ZSgpO1xuICAgICAgdGhpcy5faXRlbXMgPSB0aGlzLl9pdGVtcy5maWx0ZXIoaSA9PiBpICE9PSBpdGVtKTtcblxuICAgICAgLy8gUmVtb3ZlIGZyb20gZ3JvdXAgdHJhY2tpbmdcbiAgICAgIGlmIChpdGVtLmdyb3VwSWQgJiYgdGhpcy5fZ3JvdXBzLmhhcyhpdGVtLmdyb3VwSWQpKSB7XG4gICAgICAgIGNvbnN0IGdyb3VwSXRlbXMgPSB0aGlzLl9ncm91cHMuZ2V0KGl0ZW0uZ3JvdXBJZCk7XG4gICAgICAgIHRoaXMuX2dyb3Vwcy5zZXQoaXRlbS5ncm91cElkLCBncm91cEl0ZW1zLmZpbHRlcihpZCA9PiBpZCAhPT0gaXRlbS5pZCkpO1xuICAgICAgfVxuICAgIH1cblxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFJlbW92ZSBhbGwgaXRlbXNcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgcmVtb3ZlQWxsKCkge1xuICAgIGlmICh0aGlzLl9tZW51RWxlbWVudCkge1xuICAgICAgdGhpcy5fbWVudUVsZW1lbnQuaW5uZXJIVE1MID0gJyc7XG4gICAgfVxuICAgIHRoaXMuX2l0ZW1zID0gW107XG4gICAgdGhpcy5fZ3JvdXBzLmNsZWFyKCk7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogR2V0IGFuIGl0ZW0gYnkgaWQgb3IgaW5kZXhcbiAgICogQHBhcmFtIHtzdHJpbmd8bnVtYmVyfSBpZGVudGlmaWVyIC0gSXRlbSBpZCBvciBpbmRleFxuICAgKiBAcmV0dXJucyB7T2JqZWN0fG51bGx9IEl0ZW0gZGF0YVxuICAgKi9cbiAgZ2V0SXRlbShpZGVudGlmaWVyKSB7XG4gICAgaWYgKHR5cGVvZiBpZGVudGlmaWVyID09PSAnbnVtYmVyJykge1xuICAgICAgcmV0dXJuIHRoaXMuX2l0ZW1zW2lkZW50aWZpZXJdIHx8IG51bGw7XG4gICAgfVxuICAgIHJldHVybiB0aGlzLl9pdGVtcy5maW5kKGkgPT4gaS5pZCA9PT0gaWRlbnRpZmllcikgfHwgbnVsbDtcbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgYWxsIGl0ZW1zXG4gICAqIEByZXR1cm5zIHtBcnJheX0gQWxsIGl0ZW1zXG4gICAqL1xuICBnZXRJdGVtcygpIHtcbiAgICByZXR1cm4gWy4uLnRoaXMuX2l0ZW1zXTtcbiAgfVxuXG4gIC8qKlxuICAgKiBVcGRhdGUgYW4gaXRlbSdzIHByb3BlcnRpZXNcbiAgICogQHBhcmFtIHtzdHJpbmd8bnVtYmVyfSBpZGVudGlmaWVyIC0gSXRlbSBpZCBvciBpbmRleFxuICAgKiBAcGFyYW0ge09iamVjdH0gdXBkYXRlcyAtIFByb3BlcnRpZXMgdG8gdXBkYXRlXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHVwZGF0ZUl0ZW0oaWRlbnRpZmllciwgdXBkYXRlcykge1xuICAgIGNvbnN0IGl0ZW0gPSB0aGlzLmdldEl0ZW0oaWRlbnRpZmllcik7XG4gICAgaWYgKCFpdGVtIHx8ICFpdGVtLmVsZW1lbnQpIHJldHVybiB0aGlzO1xuXG4gICAgLy8gVXBkYXRlIGRhdGFcbiAgICBPYmplY3QuYXNzaWduKGl0ZW0sIHVwZGF0ZXMpO1xuXG4gICAgLy8gVXBkYXRlIERPTVxuICAgIGNvbnN0IGVsID0gaXRlbS5lbGVtZW50O1xuXG4gICAgaWYgKHVwZGF0ZXMubGFiZWwgIT09IHVuZGVmaW5lZCkge1xuICAgICAgY29uc3QgdGV4dEVsID0gZWwucXVlcnlTZWxlY3RvcignLnNvLWNvbnRleHQtbWVudS1pdGVtLXRleHQnKTtcbiAgICAgIGlmICh0ZXh0RWwpIHRleHRFbC50ZXh0Q29udGVudCA9IHVwZGF0ZXMubGFiZWw7XG4gICAgfVxuXG4gICAgaWYgKHVwZGF0ZXMuaWNvbiAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICBsZXQgaWNvbkVsID0gZWwucXVlcnlTZWxlY3RvcignLnNvLWNvbnRleHQtbWVudS1pdGVtLWljb24gLm1hdGVyaWFsLWljb25zJyk7XG4gICAgICBpZiAoaWNvbkVsKSB7XG4gICAgICAgIGljb25FbC50ZXh0Q29udGVudCA9IHVwZGF0ZXMuaWNvbjtcbiAgICAgIH0gZWxzZSBpZiAodXBkYXRlcy5pY29uKSB7XG4gICAgICAgIGNvbnN0IGljb25XcmFwcGVyID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnc3BhbicpO1xuICAgICAgICBpY29uV3JhcHBlci5jbGFzc05hbWUgPSAnc28tY29udGV4dC1tZW51LWl0ZW0taWNvbic7XG4gICAgICAgIGljb25XcmFwcGVyLmlubmVySFRNTCA9IGA8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+JHt1cGRhdGVzLmljb259PC9zcGFuPmA7XG4gICAgICAgIGVsLmluc2VydEJlZm9yZShpY29uV3JhcHBlciwgZWwuZmlyc3RDaGlsZCk7XG4gICAgICB9XG4gICAgfVxuXG4gICAgaWYgKHVwZGF0ZXMuZGlzYWJsZWQgIT09IHVuZGVmaW5lZCkge1xuICAgICAgZWwuY2xhc3NMaXN0LnRvZ2dsZSgnc28tZGlzYWJsZWQnLCB1cGRhdGVzLmRpc2FibGVkKTtcbiAgICB9XG5cbiAgICBpZiAodXBkYXRlcy5kYW5nZXIgIT09IHVuZGVmaW5lZCkge1xuICAgICAgZWwuY2xhc3NMaXN0LnRvZ2dsZShTaXhPcmJpdC5jbHMoJ2RhbmdlcicpLCB1cGRhdGVzLmRhbmdlcik7XG4gICAgfVxuXG4gICAgaWYgKHVwZGF0ZXMuY2hlY2tlZCAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICBlbC5jbGFzc0xpc3QudG9nZ2xlKFNpeE9yYml0LmNscygnY2hlY2tlZCcpLCB1cGRhdGVzLmNoZWNrZWQpO1xuICAgIH1cblxuICAgIGlmICh1cGRhdGVzLnNob3J0Y3V0ICE9PSB1bmRlZmluZWQpIHtcbiAgICAgIGxldCBzaG9ydGN1dEVsID0gZWwucXVlcnlTZWxlY3RvcignLnNvLWNvbnRleHQtbWVudS1pdGVtLXNob3J0Y3V0Jyk7XG4gICAgICBpZiAoc2hvcnRjdXRFbCkge1xuICAgICAgICBzaG9ydGN1dEVsLnRleHRDb250ZW50ID0gdXBkYXRlcy5zaG9ydGN1dDtcbiAgICAgIH0gZWxzZSBpZiAodXBkYXRlcy5zaG9ydGN1dCkge1xuICAgICAgICBjb25zdCBhcnJvdyA9IGVsLnF1ZXJ5U2VsZWN0b3IoJy5zby1jb250ZXh0LW1lbnUtaXRlbS1hcnJvdycpO1xuICAgICAgICBjb25zdCBzaG9ydGN1dFNwYW4gPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdzcGFuJyk7XG4gICAgICAgIHNob3J0Y3V0U3Bhbi5jbGFzc05hbWUgPSAnc28tY29udGV4dC1tZW51LWl0ZW0tc2hvcnRjdXQnO1xuICAgICAgICBzaG9ydGN1dFNwYW4udGV4dENvbnRlbnQgPSB1cGRhdGVzLnNob3J0Y3V0O1xuICAgICAgICBpZiAoYXJyb3cpIHtcbiAgICAgICAgICBlbC5pbnNlcnRCZWZvcmUoc2hvcnRjdXRTcGFuLCBhcnJvdyk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgZWwuYXBwZW5kQ2hpbGQoc2hvcnRjdXRTcGFuKTtcbiAgICAgICAgfVxuICAgICAgfVxuICAgIH1cblxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gUFVCTElDIEFQSSAtIElURU0gU1RBVEVcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogRW5hYmxlIGEgc3BlY2lmaWMgaXRlbVxuICAgKiBAcGFyYW0ge3N0cmluZ3xudW1iZXJ9IGlkZW50aWZpZXIgLSBJdGVtIGlkIG9yIGluZGV4XG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIGVuYWJsZUl0ZW0oaWRlbnRpZmllcikge1xuICAgIHJldHVybiB0aGlzLnVwZGF0ZUl0ZW0oaWRlbnRpZmllciwgeyBkaXNhYmxlZDogZmFsc2UgfSk7XG4gIH1cblxuICAvKipcbiAgICogRGlzYWJsZSBhIHNwZWNpZmljIGl0ZW1cbiAgICogQHBhcmFtIHtzdHJpbmd8bnVtYmVyfSBpZGVudGlmaWVyIC0gSXRlbSBpZCBvciBpbmRleFxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBkaXNhYmxlSXRlbShpZGVudGlmaWVyKSB7XG4gICAgcmV0dXJuIHRoaXMudXBkYXRlSXRlbShpZGVudGlmaWVyLCB7IGRpc2FibGVkOiB0cnVlIH0pO1xuICB9XG5cbiAgLyoqXG4gICAqIEVuYWJsZSBhbGwgaXRlbXMgaW4gYSBncm91cFxuICAgKiBAcGFyYW0ge3N0cmluZ30gZ3JvdXBJZCAtIEdyb3VwIGlkZW50aWZpZXJcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgZW5hYmxlR3JvdXAoZ3JvdXBJZCkge1xuICAgIC8vIEVuYWJsZSB2aWEgRE9NIGNsYXNzXG4gICAgY29uc3QgZ3JvdXBFbCA9IHRoaXMuX21lbnVFbGVtZW50Py5xdWVyeVNlbGVjdG9yKGBbZGF0YS1ncm91cC1pZD1cIiR7Z3JvdXBJZH1cIl1gKTtcbiAgICBpZiAoZ3JvdXBFbCkge1xuICAgICAgZ3JvdXBFbC5jbGFzc0xpc3QucmVtb3ZlKCdzby1kaXNhYmxlZCcpO1xuICAgIH1cblxuICAgIC8vIEVuYWJsZSBpbmRpdmlkdWFsIGl0ZW1zXG4gICAgY29uc3QgaXRlbUlkcyA9IHRoaXMuX2dyb3Vwcy5nZXQoZ3JvdXBJZCkgfHwgW107XG4gICAgaXRlbUlkcy5mb3JFYWNoKGlkID0+IHRoaXMuZW5hYmxlSXRlbShpZCkpO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogRGlzYWJsZSBhbGwgaXRlbXMgaW4gYSBncm91cFxuICAgKiBAcGFyYW0ge3N0cmluZ30gZ3JvdXBJZCAtIEdyb3VwIGlkZW50aWZpZXJcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgZGlzYWJsZUdyb3VwKGdyb3VwSWQpIHtcbiAgICAvLyBEaXNhYmxlIHZpYSBET00gY2xhc3NcbiAgICBjb25zdCBncm91cEVsID0gdGhpcy5fbWVudUVsZW1lbnQ/LnF1ZXJ5U2VsZWN0b3IoYFtkYXRhLWdyb3VwLWlkPVwiJHtncm91cElkfVwiXWApO1xuICAgIGlmIChncm91cEVsKSB7XG4gICAgICBncm91cEVsLmNsYXNzTGlzdC5hZGQoJ3NvLWRpc2FibGVkJyk7XG4gICAgfVxuXG4gICAgLy8gRGlzYWJsZSBpbmRpdmlkdWFsIGl0ZW1zXG4gICAgY29uc3QgaXRlbUlkcyA9IHRoaXMuX2dyb3Vwcy5nZXQoZ3JvdXBJZCkgfHwgW107XG4gICAgaXRlbUlkcy5mb3JFYWNoKGlkID0+IHRoaXMuZGlzYWJsZUl0ZW0oaWQpKTtcblxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gUFVCTElDIEFQSSAtIEFUVEFDSE1FTlRcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogQXR0YWNoIG1lbnUgdG8gYSB0cmlnZ2VyIGVsZW1lbnRcbiAgICogQHBhcmFtIHtFbGVtZW50fHN0cmluZ30gZWxlbWVudCAtIEVsZW1lbnQgb3Igc2VsZWN0b3JcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgYXR0YWNoKGVsZW1lbnQpIHtcbiAgICAvLyBEZXRhY2ggZnJvbSBjdXJyZW50XG4gICAgdGhpcy5kZXRhY2goKTtcblxuICAgIC8vIFJlc29sdmUgZWxlbWVudFxuICAgIGNvbnN0IGVsID0gdHlwZW9mIGVsZW1lbnQgPT09ICdzdHJpbmcnID8gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihlbGVtZW50KSA6IGVsZW1lbnQ7XG4gICAgaWYgKCFlbCkgcmV0dXJuIHRoaXM7XG5cbiAgICB0aGlzLl90YXJnZXQgPSBlbDtcblxuICAgIC8vIEJpbmQgdHJpZ2dlciBldmVudFxuICAgIGNvbnN0IHRyaWdnZXJFdmVudCA9IHRoaXMub3B0aW9ucy50cmlnZ2VyID09PSAnY2xpY2snID8gJ2NsaWNrJyA6ICdjb250ZXh0bWVudSc7XG4gICAgdGhpcy5vbih0cmlnZ2VyRXZlbnQsIHRoaXMuX2hhbmRsZVRyaWdnZXIsIHRoaXMuX3RhcmdldCk7XG5cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBEZXRhY2ggbWVudSBmcm9tIGN1cnJlbnQgdHJpZ2dlciBlbGVtZW50XG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIGRldGFjaCgpIHtcbiAgICBpZiAoIXRoaXMuX3RhcmdldCkgcmV0dXJuIHRoaXM7XG5cbiAgICAvLyBVbmJpbmQgdHJpZ2dlciBldmVudFxuICAgIGNvbnN0IHRyaWdnZXJFdmVudCA9IHRoaXMub3B0aW9ucy50cmlnZ2VyID09PSAnY2xpY2snID8gJ2NsaWNrJyA6ICdjb250ZXh0bWVudSc7XG5cbiAgICAvLyBGaW5kIGFuZCByZW1vdmUgdGhlIGhhbmRsZXJcbiAgICB0aGlzLl9ib3VuZEhhbmRsZXJzLmZvckVhY2goKHN0b3JlZCwgaGFuZGxlcikgPT4ge1xuICAgICAgaWYgKHN0b3JlZC50YXJnZXQgPT09IHRoaXMuX3RhcmdldCAmJiBzdG9yZWQuZXZlbnQgPT09IHRyaWdnZXJFdmVudCkge1xuICAgICAgICB0aGlzLl90YXJnZXQucmVtb3ZlRXZlbnRMaXN0ZW5lcih0cmlnZ2VyRXZlbnQsIHN0b3JlZC5ib3VuZEhhbmRsZXIpO1xuICAgICAgICB0aGlzLl9ib3VuZEhhbmRsZXJzLmRlbGV0ZShoYW5kbGVyKTtcbiAgICAgIH1cbiAgICB9KTtcblxuICAgIHRoaXMuX3RhcmdldCA9IG51bGw7XG5cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgY3VycmVudCB0cmlnZ2VyIGVsZW1lbnRcbiAgICogQHJldHVybnMge0VsZW1lbnR8bnVsbH0gVHJpZ2dlciBlbGVtZW50XG4gICAqL1xuICBnZXRUYXJnZXQoKSB7XG4gICAgcmV0dXJuIHRoaXMuX3RhcmdldDtcbiAgfVxuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIFBVQkxJQyBBUEkgLSBMSUZFQ1lDTEVcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogRGVzdHJveSB0aGUgY29udGV4dCBtZW51IGFuZCBjbGVhbnVwXG4gICAqL1xuICBkZXN0cm95KCkge1xuICAgIC8vIENsb3NlIGlmIG9wZW5cbiAgICBpZiAodGhpcy5faXNPcGVuKSB0aGlzLmNsb3NlKCk7XG5cbiAgICAvLyBDbGVhciB0aW1lb3V0c1xuICAgIGlmICh0aGlzLl9zdWJtZW51VGltZW91dCkge1xuICAgICAgY2xlYXJUaW1lb3V0KHRoaXMuX3N1Ym1lbnVUaW1lb3V0KTtcbiAgICB9XG5cbiAgICAvLyBEZXRhY2ggZnJvbSB0YXJnZXRcbiAgICB0aGlzLmRldGFjaCgpO1xuXG4gICAgLy8gUmVtb3ZlIG1lbnUgZWxlbWVudCBpZiB3ZSBjcmVhdGVkIGl0XG4gICAgaWYgKHRoaXMuX21lbnVFbGVtZW50ICYmICF0aGlzLl9tZW51RWxlbWVudC5pZCkge1xuICAgICAgdGhpcy5fbWVudUVsZW1lbnQucmVtb3ZlKCk7XG4gICAgfVxuXG4gICAgLy8gQ2xlYXIgc3RhdGVcbiAgICB0aGlzLl9pdGVtcyA9IFtdO1xuICAgIHRoaXMuX2dyb3Vwcy5jbGVhcigpO1xuICAgIHRoaXMuX21lbnVFbGVtZW50ID0gbnVsbDtcblxuICAgIC8vIENhbGwgcGFyZW50IGRlc3Ryb3lcbiAgICBzdXBlci5kZXN0cm95KCk7XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBTVEFUSUMgRkFDVE9SWSBNRVRIT0RTXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIENyZWF0ZSBhIGNvbnRleHQgbWVudSBwcm9ncmFtbWF0aWNhbGx5XG4gICAqIEBwYXJhbSB7T2JqZWN0fSBvcHRpb25zIC0gTWVudSBjb25maWd1cmF0aW9uXG4gICAqIEByZXR1cm5zIHtTT0NvbnRleHRNZW51fSBNZW51IGluc3RhbmNlXG4gICAqL1xuICBzdGF0aWMgY3JlYXRlKG9wdGlvbnMgPSB7fSkge1xuICAgIGNvbnN0IHtcbiAgICAgIHRhcmdldCxcbiAgICAgIGl0ZW1zID0gW10sXG4gICAgICB0cmlnZ2VyID0gJ2NvbnRleHRtZW51JyxcbiAgICAgIC4uLnJlc3RcbiAgICB9ID0gb3B0aW9ucztcblxuICAgIC8vIENyZWF0ZSBhIGR1bW15IGVsZW1lbnQgZm9yIHRoZSBjb21wb25lbnRcbiAgICBjb25zdCB3cmFwcGVyID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XG4gICAgd3JhcHBlci5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuICAgIGRvY3VtZW50LmJvZHkuYXBwZW5kQ2hpbGQod3JhcHBlcik7XG5cbiAgICBjb25zdCBtZW51ID0gbmV3IFNPQ29udGV4dE1lbnUod3JhcHBlciwge1xuICAgICAgaXRlbXMsXG4gICAgICB0cmlnZ2VyLFxuICAgICAgLi4ucmVzdCxcbiAgICB9KTtcblxuICAgIC8vIEF0dGFjaCB0byB0YXJnZXQgaWYgcHJvdmlkZWRcbiAgICBpZiAodGFyZ2V0KSB7XG4gICAgICBtZW51LmF0dGFjaCh0YXJnZXQpO1xuICAgIH1cblxuICAgIHJldHVybiBtZW51O1xuICB9XG59XG5cbi8vIFJlZ2lzdGVyIGNvbXBvbmVudFxuU09Db250ZXh0TWVudS5yZWdpc3RlcigpO1xuXG4vLyBFeHBvc2UgdG8gZ2xvYmFsIHNjb3BlXG53aW5kb3cuU09Db250ZXh0TWVudSA9IFNPQ29udGV4dE1lbnU7XG5cbi8vIEV4cG9ydCBmb3IgRVMgbW9kdWxlc1xuZXhwb3J0IGRlZmF1bHQgU09Db250ZXh0TWVudTtcbmV4cG9ydCB7IFNPQ29udGV4dE1lbnUgfTtcbiIsICIvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gU0lYT1JCSVQgVUkgLSBPVFAgSU5QVVQgQ09NUE9ORU5UXG4vLyBBdXRvLWFkdmFuY2luZyBPVFAvUElOIGlucHV0IGZpZWxkc1xuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuaW1wb3J0IFNpeE9yYml0IGZyb20gJy4uL2NvcmUvc28tY29uZmlnLmpzJztcbmltcG9ydCBTT0NvbXBvbmVudCBmcm9tICcuLi9jb3JlL3NvLWNvbXBvbmVudC5qcyc7XG5cbi8qKlxuICogU09PdHBJbnB1dCAtIE9UUC9QSU4gaW5wdXQgY29tcG9uZW50XG4gKiBIYW5kbGVzIGF1dG8tYWR2YW5jZSwgcGFzdGUsIGFuZCBiYWNrc3BhY2UgbmF2aWdhdGlvblxuICovXG5jbGFzcyBTT090cElucHV0IGV4dGVuZHMgU09Db21wb25lbnQge1xuICBzdGF0aWMgTkFNRSA9ICdvdHAnO1xuXG4gIHN0YXRpYyBERUZBVUxUUyA9IHtcbiAgICBsZW5ndGg6IDYsXG4gICAgaW5wdXRTZWxlY3RvcjogJy5zby1vdHAtaW5wdXQnLFxuICAgIGF1dG9Gb2N1czogdHJ1ZSxcbiAgICBudW1lcmljT25seTogdHJ1ZSxcbiAgfTtcblxuICBzdGF0aWMgRVZFTlRTID0ge1xuICAgIENPTVBMRVRFOiAnb3RwOmNvbXBsZXRlJyxcbiAgICBDSEFOR0U6ICdvdHA6Y2hhbmdlJyxcbiAgfTtcblxuICAvKipcbiAgICogSW5pdGlhbGl6ZSB0aGUgT1RQIGlucHV0XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaW5pdCgpIHtcbiAgICAvLyBHZXQgYWxsIGlucHV0IGVsZW1lbnRzXG4gICAgdGhpcy5faW5wdXRzID0gdGhpcy4kJCh0aGlzLm9wdGlvbnMuaW5wdXRTZWxlY3Rvcik7XG5cbiAgICBpZiAodGhpcy5faW5wdXRzLmxlbmd0aCA9PT0gMCkgcmV0dXJuO1xuXG4gICAgLy8gQmluZCBldmVudHNcbiAgICB0aGlzLl9iaW5kRXZlbnRzKCk7XG5cbiAgICAvLyBBdXRvLWZvY3VzIGZpcnN0IGlucHV0XG4gICAgaWYgKHRoaXMub3B0aW9ucy5hdXRvRm9jdXMpIHtcbiAgICAgIHRoaXMuX2lucHV0c1swXT8uZm9jdXMoKTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogQmluZCBldmVudCBsaXN0ZW5lcnNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9iaW5kRXZlbnRzKCkge1xuICAgIHRoaXMuX2lucHV0cy5mb3JFYWNoKChpbnB1dCwgaW5kZXgpID0+IHtcbiAgICAgIC8vIElucHV0IGV2ZW50XG4gICAgICB0aGlzLm9uKCdpbnB1dCcsIChlKSA9PiB0aGlzLl9oYW5kbGVJbnB1dChlLCBpbmRleCksIGlucHV0KTtcblxuICAgICAgLy8gS2V5ZG93biBldmVudCAoZm9yIGJhY2tzcGFjZSBuYXZpZ2F0aW9uKVxuICAgICAgdGhpcy5vbigna2V5ZG93bicsIChlKSA9PiB0aGlzLl9oYW5kbGVLZXlkb3duKGUsIGluZGV4KSwgaW5wdXQpO1xuXG4gICAgICAvLyBQYXN0ZSBldmVudFxuICAgICAgdGhpcy5vbigncGFzdGUnLCAoZSkgPT4gdGhpcy5faGFuZGxlUGFzdGUoZSwgaW5kZXgpLCBpbnB1dCk7XG5cbiAgICAgIC8vIEZvY3VzIGV2ZW50IChzZWxlY3QgY29udGVudClcbiAgICAgIHRoaXMub24oJ2ZvY3VzJywgKCkgPT4gaW5wdXQuc2VsZWN0KCksIGlucHV0KTtcbiAgICB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUgaW5wdXQgZXZlbnRcbiAgICogQHBhcmFtIHtFdmVudH0gZSAtIElucHV0IGV2ZW50XG4gICAqIEBwYXJhbSB7bnVtYmVyfSBpbmRleCAtIElucHV0IGluZGV4XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlSW5wdXQoZSwgaW5kZXgpIHtcbiAgICBjb25zdCBpbnB1dCA9IGUudGFyZ2V0O1xuICAgIGxldCB2YWx1ZSA9IGlucHV0LnZhbHVlO1xuXG4gICAgLy8gT25seSBhbGxvdyBkaWdpdHMgaWYgbnVtZXJpYyBvbmx5XG4gICAgaWYgKHRoaXMub3B0aW9ucy5udW1lcmljT25seSkge1xuICAgICAgdmFsdWUgPSB2YWx1ZS5yZXBsYWNlKC9bXjAtOV0vZywgJycpO1xuICAgIH1cblxuICAgIC8vIE9ubHkga2VlcCBmaXJzdCBjaGFyYWN0ZXJcbiAgICB2YWx1ZSA9IHZhbHVlLnNsaWNlKDAsIDEpO1xuICAgIGlucHV0LnZhbHVlID0gdmFsdWU7XG5cbiAgICAvLyBVcGRhdGUgZmlsbGVkIHN0YXRlXG4gICAgaWYgKHZhbHVlKSB7XG4gICAgICBpbnB1dC5jbGFzc0xpc3QuYWRkKCdmaWxsZWQnKTtcblxuICAgICAgLy8gTW92ZSB0byBuZXh0IGlucHV0XG4gICAgICBpZiAoaW5kZXggPCB0aGlzLl9pbnB1dHMubGVuZ3RoIC0gMSkge1xuICAgICAgICB0aGlzLl9pbnB1dHNbaW5kZXggKyAxXS5mb2N1cygpO1xuICAgICAgfVxuICAgIH0gZWxzZSB7XG4gICAgICBpbnB1dC5jbGFzc0xpc3QucmVtb3ZlKCdmaWxsZWQnKTtcbiAgICB9XG5cbiAgICAvLyBFbWl0IGNoYW5nZSBldmVudFxuICAgIHRoaXMuZW1pdChTT090cElucHV0LkVWRU5UUy5DSEFOR0UsIHsgdmFsdWU6IHRoaXMuZ2V0VmFsdWUoKSwgaW5kZXggfSk7XG5cbiAgICAvLyBDaGVjayBpZiBjb21wbGV0ZVxuICAgIHRoaXMuX2NoZWNrQ29tcGxldGUoKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUga2V5ZG93biBldmVudFxuICAgKiBAcGFyYW0ge0tleWJvYXJkRXZlbnR9IGUgLSBLZXlib2FyZCBldmVudFxuICAgKiBAcGFyYW0ge251bWJlcn0gaW5kZXggLSBJbnB1dCBpbmRleFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2hhbmRsZUtleWRvd24oZSwgaW5kZXgpIHtcbiAgICBjb25zdCBpbnB1dCA9IGUudGFyZ2V0O1xuXG4gICAgLy8gSGFuZGxlIGJhY2tzcGFjZVxuICAgIGlmIChlLmtleSA9PT0gJ0JhY2tzcGFjZScpIHtcbiAgICAgIGlmICghaW5wdXQudmFsdWUgJiYgaW5kZXggPiAwKSB7XG4gICAgICAgIC8vIE1vdmUgdG8gcHJldmlvdXMgaW5wdXQgYW5kIGNsZWFyIGl0XG4gICAgICAgIGNvbnN0IHByZXZJbnB1dCA9IHRoaXMuX2lucHV0c1tpbmRleCAtIDFdO1xuICAgICAgICBwcmV2SW5wdXQudmFsdWUgPSAnJztcbiAgICAgICAgcHJldklucHV0LmNsYXNzTGlzdC5yZW1vdmUoJ2ZpbGxlZCcpO1xuICAgICAgICBwcmV2SW5wdXQuZm9jdXMoKTtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIGlucHV0LmNsYXNzTGlzdC5yZW1vdmUoJ2ZpbGxlZCcpO1xuICAgICAgfVxuICAgIH1cblxuICAgIC8vIEhhbmRsZSBhcnJvdyBrZXlzXG4gICAgaWYgKGUua2V5ID09PSAnQXJyb3dMZWZ0JyAmJiBpbmRleCA+IDApIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgIHRoaXMuX2lucHV0c1tpbmRleCAtIDFdLmZvY3VzKCk7XG4gICAgfVxuXG4gICAgaWYgKGUua2V5ID09PSAnQXJyb3dSaWdodCcgJiYgaW5kZXggPCB0aGlzLl9pbnB1dHMubGVuZ3RoIC0gMSkge1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgdGhpcy5faW5wdXRzW2luZGV4ICsgMV0uZm9jdXMoKTtcbiAgICB9XG5cbiAgICAvLyBQcmV2ZW50IG5vbi1udW1lcmljIGlucHV0IGlmIG51bWVyaWMgb25seVxuICAgIGlmICh0aGlzLm9wdGlvbnMubnVtZXJpY09ubHkgJiZcbiAgICAgICAgZS5rZXkubGVuZ3RoID09PSAxICYmXG4gICAgICAgICEvWzAtOV0vLnRlc3QoZS5rZXkpICYmXG4gICAgICAgICFlLmN0cmxLZXkgJiYgIWUubWV0YUtleSkge1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUgcGFzdGUgZXZlbnRcbiAgICogQHBhcmFtIHtDbGlwYm9hcmRFdmVudH0gZSAtIFBhc3RlIGV2ZW50XG4gICAqIEBwYXJhbSB7bnVtYmVyfSBzdGFydEluZGV4IC0gU3RhcnRpbmcgaW5wdXQgaW5kZXhcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVQYXN0ZShlLCBzdGFydEluZGV4KSB7XG4gICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgY29uc3QgcGFzdGVkRGF0YSA9IChlLmNsaXBib2FyZERhdGEgfHwgd2luZG93LmNsaXBib2FyZERhdGEpLmdldERhdGEoJ3RleHQnKTtcbiAgICBsZXQgY2hhcnMgPSB0aGlzLm9wdGlvbnMubnVtZXJpY09ubHlcbiAgICAgID8gcGFzdGVkRGF0YS5yZXBsYWNlKC9bXjAtOV0vZywgJycpLnNwbGl0KCcnKVxuICAgICAgOiBwYXN0ZWREYXRhLnNwbGl0KCcnKTtcblxuICAgIC8vIEZpbGwgaW5wdXRzIHN0YXJ0aW5nIGZyb20gY3VycmVudCBwb3NpdGlvblxuICAgIGNoYXJzLmZvckVhY2goKGNoYXIsIGkpID0+IHtcbiAgICAgIGNvbnN0IGlucHV0SW5kZXggPSBzdGFydEluZGV4ICsgaTtcbiAgICAgIGlmICh0aGlzLl9pbnB1dHNbaW5wdXRJbmRleF0pIHtcbiAgICAgICAgdGhpcy5faW5wdXRzW2lucHV0SW5kZXhdLnZhbHVlID0gY2hhcjtcbiAgICAgICAgdGhpcy5faW5wdXRzW2lucHV0SW5kZXhdLmNsYXNzTGlzdC5hZGQoJ2ZpbGxlZCcpO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgLy8gRm9jdXMgbmV4dCBlbXB0eSBvciBsYXN0IGlucHV0XG4gICAgY29uc3QgbmV4dEVtcHR5SW5kZXggPSB0aGlzLl9pbnB1dHMuZmluZEluZGV4KGlucHV0ID0+ICFpbnB1dC52YWx1ZSk7XG4gICAgaWYgKG5leHRFbXB0eUluZGV4ICE9PSAtMSkge1xuICAgICAgdGhpcy5faW5wdXRzW25leHRFbXB0eUluZGV4XS5mb2N1cygpO1xuICAgIH0gZWxzZSB7XG4gICAgICB0aGlzLl9pbnB1dHNbdGhpcy5faW5wdXRzLmxlbmd0aCAtIDFdLmZvY3VzKCk7XG4gICAgfVxuXG4gICAgLy8gRW1pdCBjaGFuZ2UgYW5kIGNoZWNrIGNvbXBsZXRlXG4gICAgdGhpcy5lbWl0KFNPT3RwSW5wdXQuRVZFTlRTLkNIQU5HRSwgeyB2YWx1ZTogdGhpcy5nZXRWYWx1ZSgpIH0pO1xuICAgIHRoaXMuX2NoZWNrQ29tcGxldGUoKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBDaGVjayBpZiBhbGwgaW5wdXRzIGFyZSBmaWxsZWRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9jaGVja0NvbXBsZXRlKCkge1xuICAgIGNvbnN0IHZhbHVlID0gdGhpcy5nZXRWYWx1ZSgpO1xuICAgIGlmICh2YWx1ZS5sZW5ndGggPT09IHRoaXMuX2lucHV0cy5sZW5ndGgpIHtcbiAgICAgIHRoaXMuZW1pdChTT090cElucHV0LkVWRU5UUy5DT01QTEVURSwgeyB2YWx1ZSB9KTtcbiAgICB9XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBQVUJMSUMgQVBJXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIEdldCB0aGUgY3VycmVudCBPVFAgdmFsdWVcbiAgICogQHJldHVybnMge3N0cmluZ30gQ29tYmluZWQgT1RQIHZhbHVlXG4gICAqL1xuICBnZXRWYWx1ZSgpIHtcbiAgICByZXR1cm4gdGhpcy5faW5wdXRzLm1hcChpbnB1dCA9PiBpbnB1dC52YWx1ZSkuam9pbignJyk7XG4gIH1cblxuICAvKipcbiAgICogU2V0IHRoZSBPVFAgdmFsdWVcbiAgICogQHBhcmFtIHtzdHJpbmd9IHZhbHVlIC0gT1RQIHZhbHVlIHRvIHNldFxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBzZXRWYWx1ZSh2YWx1ZSkge1xuICAgIGNvbnN0IGNoYXJzID0gdmFsdWUudG9TdHJpbmcoKS5zcGxpdCgnJyk7XG5cbiAgICB0aGlzLl9pbnB1dHMuZm9yRWFjaCgoaW5wdXQsIGkpID0+IHtcbiAgICAgIGNvbnN0IGNoYXIgPSBjaGFyc1tpXSB8fCAnJztcbiAgICAgIGlucHV0LnZhbHVlID0gY2hhcjtcbiAgICAgIGlucHV0LmNsYXNzTGlzdC50b2dnbGUoJ2ZpbGxlZCcsICEhY2hhcik7XG4gICAgfSk7XG5cbiAgICB0aGlzLmVtaXQoU09PdHBJbnB1dC5FVkVOVFMuQ0hBTkdFLCB7IHZhbHVlOiB0aGlzLmdldFZhbHVlKCkgfSk7XG4gICAgdGhpcy5fY2hlY2tDb21wbGV0ZSgpO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogQ2xlYXIgYWxsIGlucHV0c1xuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBjbGVhcigpIHtcbiAgICB0aGlzLl9pbnB1dHMuZm9yRWFjaChpbnB1dCA9PiB7XG4gICAgICBpbnB1dC52YWx1ZSA9ICcnO1xuICAgICAgaW5wdXQuY2xhc3NMaXN0LnJlbW92ZSgnZmlsbGVkJywgJ2Vycm9yJyk7XG4gICAgfSk7XG5cbiAgICBpZiAodGhpcy5vcHRpb25zLmF1dG9Gb2N1cykge1xuICAgICAgdGhpcy5faW5wdXRzWzBdPy5mb2N1cygpO1xuICAgIH1cblxuICAgIHRoaXMuZW1pdChTT090cElucHV0LkVWRU5UUy5DSEFOR0UsIHsgdmFsdWU6ICcnIH0pO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogRm9jdXMgdGhlIGZpcnN0IGVtcHR5IGlucHV0XG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIGZvY3VzKCkge1xuICAgIGNvbnN0IGVtcHR5SW5wdXQgPSB0aGlzLl9pbnB1dHMuZmluZChpbnB1dCA9PiAhaW5wdXQudmFsdWUpO1xuICAgIChlbXB0eUlucHV0IHx8IHRoaXMuX2lucHV0c1swXSk/LmZvY3VzKCk7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogU2V0IGVycm9yIHN0YXRlIG9uIGlucHV0c1xuICAgKiBAcGFyYW0ge2Jvb2xlYW59IFtoYXNFcnJvcj10cnVlXSAtIFdoZXRoZXIgdG8gc2hvdyBlcnJvciBzdGF0ZVxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBzZXRFcnJvcihoYXNFcnJvciA9IHRydWUpIHtcbiAgICB0aGlzLl9pbnB1dHMuZm9yRWFjaChpbnB1dCA9PiB7XG4gICAgICBpbnB1dC5jbGFzc0xpc3QudG9nZ2xlKCdlcnJvcicsIGhhc0Vycm9yKTtcbiAgICB9KTtcbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBDaGVjayBpZiBPVFAgaXMgY29tcGxldGVcbiAgICogQHJldHVybnMge2Jvb2xlYW59IFdoZXRoZXIgYWxsIGlucHV0cyBhcmUgZmlsbGVkXG4gICAqL1xuICBpc0NvbXBsZXRlKCkge1xuICAgIHJldHVybiB0aGlzLmdldFZhbHVlKCkubGVuZ3RoID09PSB0aGlzLl9pbnB1dHMubGVuZ3RoO1xuICB9XG5cbiAgLyoqXG4gICAqIFZhbGlkYXRlIHRoZSBPVFAgYWdhaW5zdCBhIHZhbHVlXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBleHBlY3RlZCAtIEV4cGVjdGVkIE9UUCB2YWx1ZVxuICAgKiBAcmV0dXJucyB7Ym9vbGVhbn0gV2hldGhlciBPVFAgbWF0Y2hlc1xuICAgKi9cbiAgdmFsaWRhdGUoZXhwZWN0ZWQpIHtcbiAgICBjb25zdCBpc1ZhbGlkID0gdGhpcy5nZXRWYWx1ZSgpID09PSBleHBlY3RlZC50b1N0cmluZygpO1xuICAgIHRoaXMuc2V0RXJyb3IoIWlzVmFsaWQpO1xuICAgIHJldHVybiBpc1ZhbGlkO1xuICB9XG59XG5cbi8vIFJlZ2lzdGVyIGNvbXBvbmVudFxuU09PdHBJbnB1dC5yZWdpc3RlcigpO1xuXG4vLyBFeHBvc2UgdG8gZ2xvYmFsIHNjb3BlXG53aW5kb3cuU09PdHBJbnB1dCA9IFNPT3RwSW5wdXQ7XG5cbi8vIEV4cG9ydCBmb3IgRVMgbW9kdWxlc1xuZXhwb3J0IGRlZmF1bHQgU09PdHBJbnB1dDtcbmV4cG9ydCB7IFNPT3RwSW5wdXQgfTtcbiIsICIvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gU0lYT1JCSVQgVUkgLSBCVVRUT04gR1JPVVAgQ09NUE9ORU5UXG4vLyBUb2dnbGUgYnV0dG9ucyB3aXRoIHJhZGlvL2NoZWNrYm94IGJlaGF2aW9yXG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG5pbXBvcnQgU2l4T3JiaXQgZnJvbSAnLi4vY29yZS9zby1jb25maWcuanMnO1xuaW1wb3J0IFNPQ29tcG9uZW50IGZyb20gJy4uL2NvcmUvc28tY29tcG9uZW50LmpzJztcblxuLyoqXG4gKiBTT0J1dHRvbkdyb3VwIC0gVG9nZ2xlIGJ1dHRvbiBncm91cCBjb21wb25lbnRcbiAqIFN1cHBvcnRzIHJhZGlvIChzaW5nbGUgc2VsZWN0aW9uKSBhbmQgY2hlY2tib3ggKG11bHRpLXNlbGVjdGlvbikgbW9kZXNcbiAqL1xuY2xhc3MgU09CdXR0b25Hcm91cCBleHRlbmRzIFNPQ29tcG9uZW50IHtcbiAgc3RhdGljIE5BTUUgPSAnYnV0dG9uR3JvdXAnO1xuXG4gIHN0YXRpYyBERUZBVUxUUyA9IHtcbiAgICB0eXBlOiAnY2hlY2tib3gnLCAgICAgICAgICAvLyAncmFkaW8nIG9yICdjaGVja2JveCdcbiAgICBlbmZvcmNlU2VsZWN0aW9uOiBmYWxzZSwgICAvLyBQcmV2ZW50IGRlc2VsZWN0aW5nIGxhc3QgaXRlbVxuICAgIGtleWJvYXJkOiB0cnVlLCAgICAgICAgICAgIC8vIEVuYWJsZSBrZXlib2FyZCBuYXZpZ2F0aW9uXG4gIH07XG5cbiAgc3RhdGljIEVWRU5UUyA9IHtcbiAgICBDSEFOR0U6ICd0b2dnbGU6Y2hhbmdlJyxcbiAgfTtcblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBJTklUSUFMSVpBVElPTlxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBJbml0aWFsaXplIHRoZSBidXR0b24gZ3JvdXAgY29tcG9uZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaW5pdCgpIHtcbiAgICAvLyBHZXQgdG9nZ2xlIHR5cGUgZnJvbSBkYXRhIGF0dHJpYnV0ZSBvciBvcHRpb25zXG4gICAgdGhpcy5vcHRpb25zLnR5cGUgPSB0aGlzLmVsZW1lbnQuZGF0YXNldC50b2dnbGVUeXBlIHx8IHRoaXMub3B0aW9ucy50eXBlO1xuICAgIHRoaXMub3B0aW9ucy5lbmZvcmNlU2VsZWN0aW9uID0gdGhpcy5lbGVtZW50LmRhdGFzZXQuZW5mb3JjZVNlbGVjdGlvbiA9PT0gJ3RydWUnIHx8IHRoaXMub3B0aW9ucy5lbmZvcmNlU2VsZWN0aW9uO1xuXG4gICAgLy8gQ2FjaGUgaW5wdXQgZWxlbWVudHNcbiAgICB0aGlzLl9pbnB1dHMgPSB0aGlzLiQkKCcuc28tYnRuLWNoZWNrJyk7XG4gICAgdGhpcy5fYnV0dG9ucyA9IHRoaXMuX2lucHV0cy5tYXAoaW5wdXQgPT4gaW5wdXQubmV4dEVsZW1lbnRTaWJsaW5nKTtcblxuICAgIC8vIEJpbmQgZXZlbnRzXG4gICAgdGhpcy5fYmluZEV2ZW50cygpO1xuXG4gICAgLy8gU2V0IHVwIEFSSUEgYXR0cmlidXRlc1xuICAgIHRoaXMuX3NldHVwQXJpYSgpO1xuICB9XG5cbiAgLyoqXG4gICAqIEJpbmQgZXZlbnQgbGlzdGVuZXJzXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfYmluZEV2ZW50cygpIHtcbiAgICAvLyBDaGFuZ2UgaGFuZGxlciBmb3IgaW5wdXRzXG4gICAgdGhpcy5faW5wdXRzLmZvckVhY2goaW5wdXQgPT4ge1xuICAgICAgdGhpcy5vbignY2hhbmdlJywgdGhpcy5faGFuZGxlQ2hhbmdlLCBpbnB1dCk7XG4gICAgfSk7XG5cbiAgICAvLyBDbGljayBoYW5kbGVyIGZvciBlbmZvcmNlZCBzZWxlY3Rpb24gKHJhZGlvKVxuICAgIGlmICh0aGlzLm9wdGlvbnMuZW5mb3JjZVNlbGVjdGlvbiAmJiB0aGlzLm9wdGlvbnMudHlwZSA9PT0gJ3JhZGlvJykge1xuICAgICAgdGhpcy5faW5wdXRzLmZvckVhY2goaW5wdXQgPT4ge1xuICAgICAgICB0aGlzLm9uKCdjbGljaycsIHRoaXMuX2hhbmRsZVJhZGlvQ2xpY2ssIGlucHV0KTtcbiAgICAgIH0pO1xuICAgIH1cblxuICAgIC8vIEtleWJvYXJkIG5hdmlnYXRpb25cbiAgICBpZiAodGhpcy5vcHRpb25zLmtleWJvYXJkKSB7XG4gICAgICB0aGlzLm9uKCdrZXlkb3duJywgdGhpcy5faGFuZGxlS2V5ZG93bik7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIFNldCB1cCBBUklBIGF0dHJpYnV0ZXNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9zZXR1cEFyaWEoKSB7XG4gICAgLy8gU2V0IHJvbGUgb24gY29udGFpbmVyXG4gICAgaWYgKHRoaXMub3B0aW9ucy50eXBlID09PSAncmFkaW8nKSB7XG4gICAgICB0aGlzLmVsZW1lbnQuc2V0QXR0cmlidXRlKCdyb2xlJywgJ2dyb3VwJyk7XG4gICAgfSBlbHNlIHtcbiAgICAgIHRoaXMuZWxlbWVudC5zZXRBdHRyaWJ1dGUoJ3JvbGUnLCAnZ3JvdXAnKTtcbiAgICB9XG5cbiAgICAvLyBDaGVjayBmb3IgdmVydGljYWwgb3JpZW50YXRpb25cbiAgICBpZiAodGhpcy5lbGVtZW50LmNsYXNzTGlzdC5jb250YWlucygnc28tYnRuLWdyb3VwLXZlcnRpY2FsJykpIHtcbiAgICAgIHRoaXMuZWxlbWVudC5zZXRBdHRyaWJ1dGUoJ2FyaWEtb3JpZW50YXRpb24nLCAndmVydGljYWwnKTtcbiAgICB9XG5cbiAgICAvLyBTZXQgdXAgZWFjaCBidXR0b25cbiAgICB0aGlzLl9pbnB1dHMuZm9yRWFjaCgoaW5wdXQsIGluZGV4KSA9PiB7XG4gICAgICBjb25zdCBidXR0b24gPSB0aGlzLl9idXR0b25zW2luZGV4XTtcbiAgICAgIGlmIChidXR0b24pIHtcbiAgICAgICAgLy8gQnV0dG9uIHNob3VsZCBub3QgaGF2ZSByb2xlIHdoZW4gaXQncyBhIGxhYmVsXG4gICAgICAgIGlmIChidXR0b24udGFnTmFtZSA9PT0gJ0xBQkVMJykge1xuICAgICAgICAgIC8vIExhYmVsIGlzIHN1ZmZpY2llbnQgZm9yIGFjY2Vzc2liaWxpdHlcbiAgICAgICAgfVxuICAgICAgfVxuICAgIH0pO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gRVZFTlQgSEFORExFUlNcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogSGFuZGxlIGlucHV0IGNoYW5nZVxuICAgKiBAcGFyYW0ge0V2ZW50fSBlIC0gQ2hhbmdlIGV2ZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlQ2hhbmdlKGUpIHtcbiAgICBjb25zdCBpbnB1dCA9IGUudGFyZ2V0O1xuICAgIGNvbnN0IHZhbHVlID0gaW5wdXQudmFsdWU7XG4gICAgY29uc3QgY2hlY2tlZCA9IGlucHV0LmNoZWNrZWQ7XG5cbiAgICAvLyBFbmZvcmNlIHNlbGVjdGlvbiBmb3IgY2hlY2tib3ggbW9kZVxuICAgIGlmICh0aGlzLm9wdGlvbnMuZW5mb3JjZVNlbGVjdGlvbiAmJiB0aGlzLm9wdGlvbnMudHlwZSA9PT0gJ2NoZWNrYm94JyAmJiAhY2hlY2tlZCkge1xuICAgICAgY29uc3QgY2hlY2tlZElucHV0cyA9IHRoaXMuX2lucHV0cy5maWx0ZXIoaSA9PiBpLmNoZWNrZWQpO1xuICAgICAgaWYgKGNoZWNrZWRJbnB1dHMubGVuZ3RoID09PSAwKSB7XG4gICAgICAgIC8vIFByZXZlbnQgdW5jaGVja2luZyB0aGUgbGFzdCBpdGVtXG4gICAgICAgIGlucHV0LmNoZWNrZWQgPSB0cnVlO1xuICAgICAgICByZXR1cm47XG4gICAgICB9XG4gICAgfVxuXG4gICAgLy8gRW1pdCBjaGFuZ2UgZXZlbnRcbiAgICB0aGlzLmVtaXQoU09CdXR0b25Hcm91cC5FVkVOVFMuQ0hBTkdFLCB7XG4gICAgICB2YWx1ZTogdGhpcy5nZXRWYWx1ZSgpLFxuICAgICAgY2hhbmdlZDogdmFsdWUsXG4gICAgICBjaGVja2VkOiBjaGVja2VkLFxuICAgICAgaW5wdXQ6IGlucHV0XG4gICAgfSk7XG4gIH1cblxuICAvKipcbiAgICogSGFuZGxlIHJhZGlvIGNsaWNrIGZvciBlbmZvcmNlZCBzZWxlY3Rpb25cbiAgICogQHBhcmFtIHtFdmVudH0gZSAtIENsaWNrIGV2ZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlUmFkaW9DbGljayhlKSB7XG4gICAgY29uc3QgaW5wdXQgPSBlLnRhcmdldDtcblxuICAgIC8vIFN0b3JlIHRoZSBwcmV2aW91cyBzdGF0ZSBiZWZvcmUgdGhlIGNsaWNrIGNoYW5nZXMgaXRcbiAgICBpZiAoaW5wdXQuX3dhc0NoZWNrZWQgJiYgdGhpcy5vcHRpb25zLmVuZm9yY2VTZWxlY3Rpb24pIHtcbiAgICAgIC8vIFJhZGlvIHdhcyBhbHJlYWR5IGNoZWNrZWQsIHByZXZlbnQgbmF0aXZlIGJlaGF2aW9yIGZyb20gdW5jaGVja2luZ1xuICAgICAgLy8gKE5vdGU6IG5hdGl2ZSByYWRpbyBpbnB1dHMgZG9uJ3QgdW5jaGVjayBvbiBjbGljaywgYnV0IHRoaXMgaXMgZm9yIHNhZmV0eSlcbiAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgIGlucHV0LmNoZWNrZWQgPSB0cnVlO1xuICAgIH1cblxuICAgIC8vIE1hcmsgY3VycmVudCBzdGF0ZSBmb3IgbmV4dCBjbGlja1xuICAgIHRoaXMuX2lucHV0cy5mb3JFYWNoKGkgPT4ge1xuICAgICAgaS5fd2FzQ2hlY2tlZCA9IGkuY2hlY2tlZDtcbiAgICB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUga2V5Ym9hcmQgbmF2aWdhdGlvblxuICAgKiBAcGFyYW0ge0tleWJvYXJkRXZlbnR9IGUgLSBLZXlib2FyZCBldmVudFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2hhbmRsZUtleWRvd24oZSkge1xuICAgIGNvbnN0IGlzVmVydGljYWwgPSB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1idG4tZ3JvdXAtdmVydGljYWwnKTtcbiAgICBjb25zdCBlbmFibGVkSW5wdXRzID0gdGhpcy5faW5wdXRzLmZpbHRlcihpbnB1dCA9PiAhaW5wdXQuZGlzYWJsZWQpO1xuXG4gICAgaWYgKGVuYWJsZWRJbnB1dHMubGVuZ3RoID09PSAwKSByZXR1cm47XG5cbiAgICAvLyBGaW5kIHRoZSBjdXJyZW50bHkgZm9jdXNlZCBidXR0b24vbGFiZWxcbiAgICBjb25zdCBmb2N1c2VkRWxlbWVudCA9IGRvY3VtZW50LmFjdGl2ZUVsZW1lbnQ7XG4gICAgY29uc3QgY3VycmVudElucHV0ID0gZW5hYmxlZElucHV0cy5maW5kKGlucHV0ID0+IHtcbiAgICAgIGNvbnN0IGxhYmVsID0gaW5wdXQubmV4dEVsZW1lbnRTaWJsaW5nO1xuICAgICAgcmV0dXJuIGxhYmVsID09PSBmb2N1c2VkRWxlbWVudCB8fCBpbnB1dCA9PT0gZm9jdXNlZEVsZW1lbnQ7XG4gICAgfSk7XG5cbiAgICBpZiAoIWN1cnJlbnRJbnB1dCkgcmV0dXJuO1xuXG4gICAgY29uc3QgY3VycmVudEluZGV4ID0gZW5hYmxlZElucHV0cy5pbmRleE9mKGN1cnJlbnRJbnB1dCk7XG4gICAgbGV0IG5ld0luZGV4ID0gY3VycmVudEluZGV4O1xuXG4gICAgc3dpdGNoIChlLmtleSkge1xuICAgICAgY2FzZSAnQXJyb3dMZWZ0JzpcbiAgICAgICAgaWYgKCFpc1ZlcnRpY2FsKSB7XG4gICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAgIG5ld0luZGV4ID0gY3VycmVudEluZGV4IC0gMTtcbiAgICAgICAgICBpZiAobmV3SW5kZXggPCAwKSBuZXdJbmRleCA9IGVuYWJsZWRJbnB1dHMubGVuZ3RoIC0gMTtcbiAgICAgICAgfVxuICAgICAgICBicmVhaztcblxuICAgICAgY2FzZSAnQXJyb3dSaWdodCc6XG4gICAgICAgIGlmICghaXNWZXJ0aWNhbCkge1xuICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgICBuZXdJbmRleCA9IGN1cnJlbnRJbmRleCArIDE7XG4gICAgICAgICAgaWYgKG5ld0luZGV4ID49IGVuYWJsZWRJbnB1dHMubGVuZ3RoKSBuZXdJbmRleCA9IDA7XG4gICAgICAgIH1cbiAgICAgICAgYnJlYWs7XG5cbiAgICAgIGNhc2UgJ0Fycm93VXAnOlxuICAgICAgICBpZiAoaXNWZXJ0aWNhbCkge1xuICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgICBuZXdJbmRleCA9IGN1cnJlbnRJbmRleCAtIDE7XG4gICAgICAgICAgaWYgKG5ld0luZGV4IDwgMCkgbmV3SW5kZXggPSBlbmFibGVkSW5wdXRzLmxlbmd0aCAtIDE7XG4gICAgICAgIH1cbiAgICAgICAgYnJlYWs7XG5cbiAgICAgIGNhc2UgJ0Fycm93RG93bic6XG4gICAgICAgIGlmIChpc1ZlcnRpY2FsKSB7XG4gICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAgIG5ld0luZGV4ID0gY3VycmVudEluZGV4ICsgMTtcbiAgICAgICAgICBpZiAobmV3SW5kZXggPj0gZW5hYmxlZElucHV0cy5sZW5ndGgpIG5ld0luZGV4ID0gMDtcbiAgICAgICAgfVxuICAgICAgICBicmVhaztcblxuICAgICAgY2FzZSAnSG9tZSc6XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgbmV3SW5kZXggPSAwO1xuICAgICAgICBicmVhaztcblxuICAgICAgY2FzZSAnRW5kJzpcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICBuZXdJbmRleCA9IGVuYWJsZWRJbnB1dHMubGVuZ3RoIC0gMTtcbiAgICAgICAgYnJlYWs7XG5cbiAgICAgIGNhc2UgJyAnOlxuICAgICAgY2FzZSAnRW50ZXInOlxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIGlmICh0aGlzLm9wdGlvbnMudHlwZSA9PT0gJ2NoZWNrYm94Jykge1xuICAgICAgICAgIGVuYWJsZWRJbnB1dHNbY3VycmVudEluZGV4XS5jaGVja2VkID0gIWVuYWJsZWRJbnB1dHNbY3VycmVudEluZGV4XS5jaGVja2VkO1xuICAgICAgICAgIGVuYWJsZWRJbnB1dHNbY3VycmVudEluZGV4XS5kaXNwYXRjaEV2ZW50KG5ldyBFdmVudCgnY2hhbmdlJywgeyBidWJibGVzOiB0cnVlIH0pKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICBlbmFibGVkSW5wdXRzW2N1cnJlbnRJbmRleF0uY2hlY2tlZCA9IHRydWU7XG4gICAgICAgICAgZW5hYmxlZElucHV0c1tjdXJyZW50SW5kZXhdLmRpc3BhdGNoRXZlbnQobmV3IEV2ZW50KCdjaGFuZ2UnLCB7IGJ1YmJsZXM6IHRydWUgfSkpO1xuICAgICAgICB9XG4gICAgICAgIHJldHVybjtcblxuICAgICAgZGVmYXVsdDpcbiAgICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIC8vIEZvY3VzIHRoZSBuZXcgYnV0dG9uJ3MgbGFiZWxcbiAgICBpZiAobmV3SW5kZXggIT09IGN1cnJlbnRJbmRleCAmJiBuZXdJbmRleCA+PSAwKSB7XG4gICAgICBjb25zdCBuZXdMYWJlbCA9IGVuYWJsZWRJbnB1dHNbbmV3SW5kZXhdLm5leHRFbGVtZW50U2libGluZztcbiAgICAgIGlmIChuZXdMYWJlbCkge1xuICAgICAgICBuZXdMYWJlbC5mb2N1cygpO1xuICAgICAgfVxuICAgIH1cbiAgfVxuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIFBVQkxJQyBBUElcbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuICAvKipcbiAgICogR2V0IGN1cnJlbnQgc2VsZWN0ZWQgdmFsdWUocylcbiAgICogQHJldHVybnMge3N0cmluZ3xzdHJpbmdbXXxudWxsfSBTZWxlY3RlZCB2YWx1ZSAocmFkaW8pIG9yIGFycmF5IG9mIHZhbHVlcyAoY2hlY2tib3gpXG4gICAqL1xuICBnZXRWYWx1ZSgpIHtcbiAgICBpZiAodGhpcy5vcHRpb25zLnR5cGUgPT09ICdyYWRpbycpIHtcbiAgICAgIGNvbnN0IGNoZWNrZWQgPSB0aGlzLl9pbnB1dHMuZmluZChpbnB1dCA9PiBpbnB1dC5jaGVja2VkKTtcbiAgICAgIHJldHVybiBjaGVja2VkID8gY2hlY2tlZC52YWx1ZSA6IG51bGw7XG4gICAgfSBlbHNlIHtcbiAgICAgIHJldHVybiB0aGlzLl9pbnB1dHNcbiAgICAgICAgLmZpbHRlcihpbnB1dCA9PiBpbnB1dC5jaGVja2VkKVxuICAgICAgICAubWFwKGlucHV0ID0+IGlucHV0LnZhbHVlKTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogU2V0IHNlbGVjdGVkIHZhbHVlKHMpXG4gICAqIEBwYXJhbSB7c3RyaW5nfHN0cmluZ1tdfSB2YWx1ZSAtIFZhbHVlIG9yIGFycmF5IG9mIHZhbHVlcyB0byBzZWxlY3RcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgc2V0VmFsdWUodmFsdWUpIHtcbiAgICBpZiAodGhpcy5vcHRpb25zLnR5cGUgPT09ICdyYWRpbycpIHtcbiAgICAgIGNvbnN0IHZhbHVlU3RyID0gU3RyaW5nKHZhbHVlKTtcbiAgICAgIHRoaXMuX2lucHV0cy5mb3JFYWNoKGlucHV0ID0+IHtcbiAgICAgICAgaW5wdXQuY2hlY2tlZCA9IGlucHV0LnZhbHVlID09PSB2YWx1ZVN0cjtcbiAgICAgIH0pO1xuICAgIH0gZWxzZSB7XG4gICAgICBjb25zdCB2YWx1ZXMgPSBBcnJheS5pc0FycmF5KHZhbHVlKSA/IHZhbHVlIDogW3ZhbHVlXTtcbiAgICAgIHRoaXMuX2lucHV0cy5mb3JFYWNoKGlucHV0ID0+IHtcbiAgICAgICAgaW5wdXQuY2hlY2tlZCA9IHZhbHVlcy5pbmNsdWRlcyhpbnB1dC52YWx1ZSk7XG4gICAgICB9KTtcbiAgICB9XG5cbiAgICAvLyBFbWl0IGNoYW5nZSBldmVudFxuICAgIHRoaXMuZW1pdChTT0J1dHRvbkdyb3VwLkVWRU5UUy5DSEFOR0UsIHtcbiAgICAgIHZhbHVlOiB0aGlzLmdldFZhbHVlKCksXG4gICAgICBjaGFuZ2VkOiBudWxsLFxuICAgICAgY2hlY2tlZDogbnVsbCxcbiAgICAgIHByb2dyYW1tYXRpYzogdHJ1ZVxuICAgIH0pO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogVG9nZ2xlIGEgc3BlY2lmaWMgYnV0dG9uIGJ5IHZhbHVlXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB2YWx1ZSAtIFZhbHVlIG9mIGJ1dHRvbiB0byB0b2dnbGVcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgdG9nZ2xlKHZhbHVlKSB7XG4gICAgY29uc3QgaW5wdXQgPSB0aGlzLl9pbnB1dHMuZmluZChpID0+IGkudmFsdWUgPT09IHZhbHVlKTtcbiAgICBpZiAoIWlucHV0IHx8IGlucHV0LmRpc2FibGVkKSByZXR1cm4gdGhpcztcblxuICAgIGlmICh0aGlzLm9wdGlvbnMudHlwZSA9PT0gJ3JhZGlvJykge1xuICAgICAgLy8gUmFkaW86IGp1c3Qgc2VsZWN0IHRoaXMgb25lXG4gICAgICBpbnB1dC5jaGVja2VkID0gdHJ1ZTtcbiAgICB9IGVsc2Uge1xuICAgICAgLy8gQ2hlY2tib3g6IHRvZ2dsZVxuICAgICAgaWYgKHRoaXMub3B0aW9ucy5lbmZvcmNlU2VsZWN0aW9uICYmIGlucHV0LmNoZWNrZWQpIHtcbiAgICAgICAgY29uc3QgY2hlY2tlZENvdW50ID0gdGhpcy5faW5wdXRzLmZpbHRlcihpID0+IGkuY2hlY2tlZCkubGVuZ3RoO1xuICAgICAgICBpZiAoY2hlY2tlZENvdW50IDw9IDEpIHtcbiAgICAgICAgICByZXR1cm4gdGhpczsgLy8gRG9uJ3QgdW5jaGVjayB0aGUgbGFzdCBvbmVcbiAgICAgICAgfVxuICAgICAgfVxuICAgICAgaW5wdXQuY2hlY2tlZCA9ICFpbnB1dC5jaGVja2VkO1xuICAgIH1cblxuICAgIGlucHV0LmRpc3BhdGNoRXZlbnQobmV3IEV2ZW50KCdjaGFuZ2UnLCB7IGJ1YmJsZXM6IHRydWUgfSkpO1xuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFRvZ2dsZSBidXR0b24gYnkgaW5kZXhcbiAgICogQHBhcmFtIHtudW1iZXJ9IGluZGV4IC0gSW5kZXggb2YgYnV0dG9uIHRvIHRvZ2dsZSAoMC1iYXNlZClcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgdG9nZ2xlSW5kZXgoaW5kZXgpIHtcbiAgICBjb25zdCBpbnB1dCA9IHRoaXMuX2lucHV0c1tpbmRleF07XG4gICAgaWYgKCFpbnB1dCkgcmV0dXJuIHRoaXM7XG4gICAgcmV0dXJuIHRoaXMudG9nZ2xlKGlucHV0LnZhbHVlKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBTZWxlY3QgYWxsIGJ1dHRvbnMgKGNoZWNrYm94IG1vZGUgb25seSlcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgc2VsZWN0QWxsKCkge1xuICAgIGlmICh0aGlzLm9wdGlvbnMudHlwZSAhPT0gJ2NoZWNrYm94JykgcmV0dXJuIHRoaXM7XG5cbiAgICB0aGlzLl9pbnB1dHMuZm9yRWFjaChpbnB1dCA9PiB7XG4gICAgICBpZiAoIWlucHV0LmRpc2FibGVkKSB7XG4gICAgICAgIGlucHV0LmNoZWNrZWQgPSB0cnVlO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgdGhpcy5lbWl0KFNPQnV0dG9uR3JvdXAuRVZFTlRTLkNIQU5HRSwge1xuICAgICAgdmFsdWU6IHRoaXMuZ2V0VmFsdWUoKSxcbiAgICAgIGNoYW5nZWQ6IG51bGwsXG4gICAgICBjaGVja2VkOiB0cnVlLFxuICAgICAgcHJvZ3JhbW1hdGljOiB0cnVlXG4gICAgfSk7XG5cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBEZXNlbGVjdCBhbGwgYnV0dG9uc1xuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBkZXNlbGVjdEFsbCgpIHtcbiAgICBpZiAodGhpcy5vcHRpb25zLmVuZm9yY2VTZWxlY3Rpb24pIHJldHVybiB0aGlzO1xuXG4gICAgdGhpcy5faW5wdXRzLmZvckVhY2goaW5wdXQgPT4ge1xuICAgICAgaW5wdXQuY2hlY2tlZCA9IGZhbHNlO1xuICAgIH0pO1xuXG4gICAgdGhpcy5lbWl0KFNPQnV0dG9uR3JvdXAuRVZFTlRTLkNIQU5HRSwge1xuICAgICAgdmFsdWU6IHRoaXMuZ2V0VmFsdWUoKSxcbiAgICAgIGNoYW5nZWQ6IG51bGwsXG4gICAgICBjaGVja2VkOiBmYWxzZSxcbiAgICAgIHByb2dyYW1tYXRpYzogdHJ1ZVxuICAgIH0pO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogRW5hYmxlIGFsbCBidXR0b25zXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIGVuYWJsZSgpIHtcbiAgICB0aGlzLl9pbnB1dHMuZm9yRWFjaChpbnB1dCA9PiB7XG4gICAgICBpbnB1dC5kaXNhYmxlZCA9IGZhbHNlO1xuICAgIH0pO1xuICAgIHJldHVybiBzdXBlci5lbmFibGUoKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBEaXNhYmxlIGFsbCBidXR0b25zXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIGRpc2FibGUoKSB7XG4gICAgdGhpcy5faW5wdXRzLmZvckVhY2goaW5wdXQgPT4ge1xuICAgICAgaW5wdXQuZGlzYWJsZWQgPSB0cnVlO1xuICAgIH0pO1xuICAgIHJldHVybiBzdXBlci5kaXNhYmxlKCk7XG4gIH1cblxuICAvKipcbiAgICogRW5hYmxlIGEgc3BlY2lmaWMgYnV0dG9uIGJ5IHZhbHVlXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB2YWx1ZSAtIFZhbHVlIG9mIGJ1dHRvbiB0byBlbmFibGVcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgZW5hYmxlQnV0dG9uKHZhbHVlKSB7XG4gICAgY29uc3QgaW5wdXQgPSB0aGlzLl9pbnB1dHMuZmluZChpID0+IGkudmFsdWUgPT09IHZhbHVlKTtcbiAgICBpZiAoaW5wdXQpIHtcbiAgICAgIGlucHV0LmRpc2FibGVkID0gZmFsc2U7XG4gICAgfVxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIERpc2FibGUgYSBzcGVjaWZpYyBidXR0b24gYnkgdmFsdWVcbiAgICogQHBhcmFtIHtzdHJpbmd9IHZhbHVlIC0gVmFsdWUgb2YgYnV0dG9uIHRvIGRpc2FibGVcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgZGlzYWJsZUJ1dHRvbih2YWx1ZSkge1xuICAgIGNvbnN0IGlucHV0ID0gdGhpcy5faW5wdXRzLmZpbmQoaSA9PiBpLnZhbHVlID09PSB2YWx1ZSk7XG4gICAgaWYgKGlucHV0KSB7XG4gICAgICBpbnB1dC5kaXNhYmxlZCA9IHRydWU7XG4gICAgfVxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIEdldCBhbGwgYnV0dG9uIHZhbHVlc1xuICAgKiBAcmV0dXJucyB7c3RyaW5nW119IEFycmF5IG9mIGFsbCBidXR0b24gdmFsdWVzXG4gICAqL1xuICBnZXRWYWx1ZXMoKSB7XG4gICAgcmV0dXJuIHRoaXMuX2lucHV0cy5tYXAoaW5wdXQgPT4gaW5wdXQudmFsdWUpO1xuICB9XG5cbiAgLyoqXG4gICAqIENoZWNrIGlmIGEgc3BlY2lmaWMgdmFsdWUgaXMgc2VsZWN0ZWRcbiAgICogQHBhcmFtIHtzdHJpbmd9IHZhbHVlIC0gVmFsdWUgdG8gY2hlY2tcbiAgICogQHJldHVybnMge2Jvb2xlYW59IFdoZXRoZXIgdGhlIHZhbHVlIGlzIHNlbGVjdGVkXG4gICAqL1xuICBpc1NlbGVjdGVkKHZhbHVlKSB7XG4gICAgY29uc3QgaW5wdXQgPSB0aGlzLl9pbnB1dHMuZmluZChpID0+IGkudmFsdWUgPT09IHZhbHVlKTtcbiAgICByZXR1cm4gaW5wdXQgPyBpbnB1dC5jaGVja2VkIDogZmFsc2U7XG4gIH1cblxuICAvKipcbiAgICogR2V0IHRoZSBudW1iZXIgb2Ygc2VsZWN0ZWQgYnV0dG9uc1xuICAgKiBAcmV0dXJucyB7bnVtYmVyfSBDb3VudCBvZiBzZWxlY3RlZCBidXR0b25zXG4gICAqL1xuICBnZXRTZWxlY3RlZENvdW50KCkge1xuICAgIHJldHVybiB0aGlzLl9pbnB1dHMuZmlsdGVyKGlucHV0ID0+IGlucHV0LmNoZWNrZWQpLmxlbmd0aDtcbiAgfVxuXG4gIC8qKlxuICAgKiBSZWZyZXNoIHRoZSBjb21wb25lbnQgKHJlLXNjYW4gZm9yIGlucHV0cylcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgcmVmcmVzaCgpIHtcbiAgICB0aGlzLl9pbnB1dHMgPSB0aGlzLiQkKCcuc28tYnRuLWNoZWNrJyk7XG4gICAgdGhpcy5fYnV0dG9ucyA9IHRoaXMuX2lucHV0cy5tYXAoaW5wdXQgPT4gaW5wdXQubmV4dEVsZW1lbnRTaWJsaW5nKTtcbiAgICB0aGlzLl9zZXR1cEFyaWEoKTtcbiAgICByZXR1cm4gdGhpcztcbiAgfVxufVxuXG4vLyBSZWdpc3RlciBjb21wb25lbnRcblNPQnV0dG9uR3JvdXAucmVnaXN0ZXIoKTtcblxuLy8gQXV0by1pbml0aWFsaXplIGJ1dHRvbiBncm91cHMgd2l0aCBkYXRhIGF0dHJpYnV0ZVxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignRE9NQ29udGVudExvYWRlZCcsICgpID0+IHtcbiAgU09CdXR0b25Hcm91cC5pbml0QWxsKCdbZGF0YS1zby10b2dnbGU9XCJidXR0b25zXCJdJyk7XG59KTtcblxuLy8gRXhwb3NlIHRvIGdsb2JhbCBzY29wZVxud2luZG93LlNPQnV0dG9uR3JvdXAgPSBTT0J1dHRvbkdyb3VwO1xuXG4vLyBFeHBvcnQgZm9yIEVTIG1vZHVsZXNcbmV4cG9ydCBkZWZhdWx0IFNPQnV0dG9uR3JvdXA7XG5leHBvcnQgeyBTT0J1dHRvbkdyb3VwIH07XG4iLCAiLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbi8vIFNJWE9SQklUIFVJIC0gUFJPR1JFU1MgQlVUVE9OIENPTVBPTkVOVFxuLy8gQnV0dG9ucyB3aXRoIHByb2dyZXNzIGluZGljYXRvciBhbmQgc3RhdGUgbWFuYWdlbWVudFxuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuaW1wb3J0IFNpeE9yYml0IGZyb20gJy4uL2NvcmUvc28tY29uZmlnLmpzJztcbmltcG9ydCBTT0NvbXBvbmVudCBmcm9tICcuLi9jb3JlL3NvLWNvbXBvbmVudC5qcyc7XG5cbi8qKlxuICogU09Qcm9ncmVzc0J1dHRvbiAtIFByb2dyZXNzIGJ1dHRvbiBjb21wb25lbnRcbiAqIFByb3ZpZGVzIHByb2dyYW1tYXRpYyBjb250cm9sIG92ZXIgYnV0dG9uIHByb2dyZXNzIHN0YXRlc1xuICovXG5jbGFzcyBTT1Byb2dyZXNzQnV0dG9uIGV4dGVuZHMgU09Db21wb25lbnQge1xuICBzdGF0aWMgTkFNRSA9ICdwcm9ncmVzc0J1dHRvbic7XG5cbiAgc3RhdGljIERFRkFVTFRTID0ge1xuICAgIGF1dG9EaXNhYmxlOiB0cnVlLCAgICAgICAgICAvLyBEaXNhYmxlIGJ1dHRvbiBkdXJpbmcgcHJvZ3Jlc3NcbiAgICBhdXRvUmVzZXQ6IGZhbHNlLCAgICAgICAgICAgLy8gQXV0byByZXNldCBhZnRlciBjb21wbGV0ZSAobXMsIDAgPSBkaXNhYmxlZClcbiAgICBzaW11bGF0ZU9uQ2xpY2s6IGZhbHNlLCAgICAgLy8gQXV0by1zaW11bGF0ZSBwcm9ncmVzcyBvbiBjbGlja1xuICAgIHNpbXVsYXRlU3BlZWQ6IDE1MCwgICAgICAgICAvLyBJbnRlcnZhbCBmb3Igc2ltdWxhdGVkIHByb2dyZXNzIChtcylcbiAgICBzaW11bGF0ZUluY3JlbWVudDogWzUsIDE1XSwgLy8gUmFuZG9tIGluY3JlbWVudCByYW5nZSBbbWluLCBtYXhdXG4gIH07XG5cbiAgc3RhdGljIEVWRU5UUyA9IHtcbiAgICBTVEFSVDogJ3Byb2dyZXNzOnN0YXJ0JyxcbiAgICBQUk9HUkVTUzogJ3Byb2dyZXNzOnVwZGF0ZScsXG4gICAgQ09NUExFVEU6ICdwcm9ncmVzczpjb21wbGV0ZScsXG4gICAgUkVTRVQ6ICdwcm9ncmVzczpyZXNldCcsXG4gIH07XG5cbiAgc3RhdGljIFNUQVRFUyA9IHtcbiAgICBJRExFOiAnaWRsZScsXG4gICAgUFJPR1JFU1NJTkc6ICdwcm9ncmVzc2luZycsXG4gICAgQ09NUExFVEVEOiAnY29tcGxldGVkJyxcbiAgfTtcblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBJTklUSUFMSVpBVElPTlxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBJbml0aWFsaXplIHRoZSBwcm9ncmVzcyBidXR0b24gY29tcG9uZW50XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaW5pdCgpIHtcbiAgICAvLyBDdXJyZW50IHN0YXRlXG4gICAgdGhpcy5fc3RhdGUgPSBTT1Byb2dyZXNzQnV0dG9uLlNUQVRFUy5JRExFO1xuICAgIHRoaXMuX3Byb2dyZXNzID0gMDtcbiAgICB0aGlzLl9zaW11bGF0ZUludGVydmFsID0gbnVsbDtcblxuICAgIC8vIENhY2hlIGVsZW1lbnRzXG4gICAgdGhpcy5fcHJvZ3Jlc3NCYXIgPSB0aGlzLiQoJy5zby1idG4tcHJvZ3Jlc3MtYmFyJyk7XG4gICAgdGhpcy5fdGV4dEVsID0gdGhpcy4kKCcuc28tYnRuLXRleHQnKTtcbiAgICB0aGlzLl9zdGFydEVsID0gdGhpcy4kKCcuc28tYnRuLXN0YXJ0Jyk7XG4gICAgdGhpcy5fZG9uZUVsID0gdGhpcy4kKCcuc28tYnRuLWRvbmUnKTtcblxuICAgIC8vIFBhcnNlIG9wdGlvbnMgZnJvbSBkYXRhIGF0dHJpYnV0ZXNcbiAgICB0aGlzLl9wYXJzZURhdGFPcHRpb25zKCk7XG5cbiAgICAvLyBCaW5kIGV2ZW50c1xuICAgIHRoaXMuX2JpbmRFdmVudHMoKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBQYXJzZSBhZGRpdGlvbmFsIGRhdGEgYXR0cmlidXRlc1xuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3BhcnNlRGF0YU9wdGlvbnMoKSB7XG4gICAgY29uc3QgZWwgPSB0aGlzLmVsZW1lbnQ7XG5cbiAgICBpZiAoZWwuZGF0YXNldC5hdXRvRGlzYWJsZSAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICB0aGlzLm9wdGlvbnMuYXV0b0Rpc2FibGUgPSBlbC5kYXRhc2V0LmF1dG9EaXNhYmxlICE9PSAnZmFsc2UnO1xuICAgIH1cbiAgICBpZiAoZWwuZGF0YXNldC5hdXRvUmVzZXQgIT09IHVuZGVmaW5lZCkge1xuICAgICAgdGhpcy5vcHRpb25zLmF1dG9SZXNldCA9IHBhcnNlSW50KGVsLmRhdGFzZXQuYXV0b1Jlc2V0LCAxMCkgfHwgMDtcbiAgICB9XG4gICAgaWYgKGVsLmRhdGFzZXQuc2ltdWxhdGVPbkNsaWNrICE9PSB1bmRlZmluZWQpIHtcbiAgICAgIHRoaXMub3B0aW9ucy5zaW11bGF0ZU9uQ2xpY2sgPSBlbC5kYXRhc2V0LnNpbXVsYXRlT25DbGljayA9PT0gJ3RydWUnO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBCaW5kIGV2ZW50IGxpc3RlbmVyc1xuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2JpbmRFdmVudHMoKSB7XG4gICAgLy8gQ2xpY2sgaGFuZGxlciBmb3Igc2ltdWxhdGUgbW9kZVxuICAgIGlmICh0aGlzLm9wdGlvbnMuc2ltdWxhdGVPbkNsaWNrKSB7XG4gICAgICB0aGlzLm9uKCdjbGljaycsIHRoaXMuX2hhbmRsZUNsaWNrKTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogSGFuZGxlIGNsaWNrIGZvciBzaW11bGF0ZSBtb2RlXG4gICAqIEBwYXJhbSB7RXZlbnR9IGUgLSBDbGljayBldmVudFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2hhbmRsZUNsaWNrKGUpIHtcbiAgICBpZiAodGhpcy5fc3RhdGUgPT09IFNPUHJvZ3Jlc3NCdXR0b24uU1RBVEVTLkNPTVBMRVRFRCkge1xuICAgICAgdGhpcy5yZXNldCgpO1xuICAgIH0gZWxzZSBpZiAodGhpcy5fc3RhdGUgPT09IFNPUHJvZ3Jlc3NCdXR0b24uU1RBVEVTLklETEUpIHtcbiAgICAgIHRoaXMuc2ltdWxhdGUoKTtcbiAgICB9XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBQVUJMSUMgQVBJXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIFN0YXJ0IHByb2dyZXNzIChlbnRlciBwcm9ncmVzc2luZyBzdGF0ZSlcbiAgICogQHBhcmFtIHtudW1iZXJ9IFtpbml0aWFsUHJvZ3Jlc3M9MF0gLSBJbml0aWFsIHByb2dyZXNzIHZhbHVlICgwLTEwMClcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgc3RhcnQoaW5pdGlhbFByb2dyZXNzID0gMCkge1xuICAgIGlmICh0aGlzLl9zdGF0ZSA9PT0gU09Qcm9ncmVzc0J1dHRvbi5TVEFURVMuUFJPR1JFU1NJTkcpIHtcbiAgICAgIHJldHVybiB0aGlzO1xuICAgIH1cblxuICAgIHRoaXMuX3N0YXRlID0gU09Qcm9ncmVzc0J1dHRvbi5TVEFURVMuUFJPR1JFU1NJTkc7XG4gICAgdGhpcy5fcHJvZ3Jlc3MgPSBNYXRoLm1heCgwLCBNYXRoLm1pbigxMDAsIGluaXRpYWxQcm9ncmVzcykpO1xuXG4gICAgLy8gVXBkYXRlIFVJXG4gICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5hZGQoJ3NvLXByb2dyZXNzaW5nJyk7XG4gICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5yZW1vdmUoJ3NvLWNvbXBsZXRlZCcpO1xuICAgIHRoaXMuX3VwZGF0ZVByb2dyZXNzQmFyKCk7XG5cbiAgICAvLyBEaXNhYmxlIGlmIGNvbmZpZ3VyZWRcbiAgICBpZiAodGhpcy5vcHRpb25zLmF1dG9EaXNhYmxlKSB7XG4gICAgICB0aGlzLmVsZW1lbnQuZGlzYWJsZWQgPSB0cnVlO1xuICAgIH1cblxuICAgIC8vIEVtaXQgZXZlbnRcbiAgICB0aGlzLmVtaXQoU09Qcm9ncmVzc0J1dHRvbi5FVkVOVFMuU1RBUlQsIHtcbiAgICAgIHByb2dyZXNzOiB0aGlzLl9wcm9ncmVzcyxcbiAgICAgIHN0YXRlOiB0aGlzLl9zdGF0ZSxcbiAgICB9KTtcblxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFNldCBwcm9ncmVzcyB2YWx1ZVxuICAgKiBAcGFyYW0ge251bWJlcn0gdmFsdWUgLSBQcm9ncmVzcyB2YWx1ZSAoMC0xMDApXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHNldFByb2dyZXNzKHZhbHVlKSB7XG4gICAgLy8gQXV0by1zdGFydCBpZiBub3QgcHJvZ3Jlc3NpbmdcbiAgICBpZiAodGhpcy5fc3RhdGUgPT09IFNPUHJvZ3Jlc3NCdXR0b24uU1RBVEVTLklETEUpIHtcbiAgICAgIHRoaXMuc3RhcnQodmFsdWUpO1xuICAgICAgcmV0dXJuIHRoaXM7XG4gICAgfVxuXG4gICAgaWYgKHRoaXMuX3N0YXRlICE9PSBTT1Byb2dyZXNzQnV0dG9uLlNUQVRFUy5QUk9HUkVTU0lORykge1xuICAgICAgcmV0dXJuIHRoaXM7XG4gICAgfVxuXG4gICAgY29uc3Qgb2xkUHJvZ3Jlc3MgPSB0aGlzLl9wcm9ncmVzcztcbiAgICB0aGlzLl9wcm9ncmVzcyA9IE1hdGgubWF4KDAsIE1hdGgubWluKDEwMCwgdmFsdWUpKTtcbiAgICB0aGlzLl91cGRhdGVQcm9ncmVzc0JhcigpO1xuXG4gICAgLy8gRW1pdCBldmVudFxuICAgIHRoaXMuZW1pdChTT1Byb2dyZXNzQnV0dG9uLkVWRU5UUy5QUk9HUkVTUywge1xuICAgICAgcHJvZ3Jlc3M6IHRoaXMuX3Byb2dyZXNzLFxuICAgICAgcHJldmlvdXNQcm9ncmVzczogb2xkUHJvZ3Jlc3MsXG4gICAgICBzdGF0ZTogdGhpcy5fc3RhdGUsXG4gICAgfSk7XG5cbiAgICAvLyBBdXRvLWNvbXBsZXRlIGF0IDEwMCVcbiAgICBpZiAodGhpcy5fcHJvZ3Jlc3MgPj0gMTAwKSB7XG4gICAgICB0aGlzLl9kb0NvbXBsZXRlKCk7XG4gICAgfVxuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogSW5jcmVtZW50IHByb2dyZXNzIGJ5IGEgdmFsdWVcbiAgICogQHBhcmFtIHtudW1iZXJ9IGFtb3VudCAtIEFtb3VudCB0byBpbmNyZW1lbnRcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgaW5jcmVtZW50KGFtb3VudCkge1xuICAgIHJldHVybiB0aGlzLnNldFByb2dyZXNzKHRoaXMuX3Byb2dyZXNzICsgYW1vdW50KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBDb21wbGV0ZSB0aGUgcHJvZ3Jlc3MgKGVudGVyIGNvbXBsZXRlZCBzdGF0ZSlcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgY29tcGxldGUoKSB7XG4gICAgaWYgKHRoaXMuX3N0YXRlID09PSBTT1Byb2dyZXNzQnV0dG9uLlNUQVRFUy5DT01QTEVURUQpIHtcbiAgICAgIHJldHVybiB0aGlzO1xuICAgIH1cblxuICAgIC8vIFN0b3AgYW55IHNpbXVsYXRpb25cbiAgICB0aGlzLl9zdG9wU2ltdWxhdGlvbigpO1xuXG4gICAgLy8gU2V0IHRvIDEwMCUgZmlyc3RcbiAgICB0aGlzLl9wcm9ncmVzcyA9IDEwMDtcbiAgICB0aGlzLl91cGRhdGVQcm9ncmVzc0JhcigpO1xuXG4gICAgLy8gU21hbGwgZGVsYXkgZm9yIHZpc3VhbCBmZWVkYmFjaywgdGhlbiBjb21wbGV0ZVxuICAgIHNldFRpbWVvdXQoKCkgPT4gdGhpcy5fZG9Db21wbGV0ZSgpLCAyMDApO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogSW50ZXJuYWwgY29tcGxldGUgaGFuZGxlclxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2RvQ29tcGxldGUoKSB7XG4gICAgdGhpcy5fc3RhdGUgPSBTT1Byb2dyZXNzQnV0dG9uLlNUQVRFUy5DT01QTEVURUQ7XG5cbiAgICAvLyBVcGRhdGUgVUlcbiAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZSgnc28tcHJvZ3Jlc3NpbmcnKTtcbiAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LmFkZCgnc28tY29tcGxldGVkJyk7XG5cbiAgICAvLyBSZS1lbmFibGUgYnV0dG9uXG4gICAgaWYgKHRoaXMub3B0aW9ucy5hdXRvRGlzYWJsZSkge1xuICAgICAgdGhpcy5lbGVtZW50LmRpc2FibGVkID0gZmFsc2U7XG4gICAgfVxuXG4gICAgLy8gRW1pdCBldmVudFxuICAgIHRoaXMuZW1pdChTT1Byb2dyZXNzQnV0dG9uLkVWRU5UUy5DT01QTEVURSwge1xuICAgICAgcHJvZ3Jlc3M6IDEwMCxcbiAgICAgIHN0YXRlOiB0aGlzLl9zdGF0ZSxcbiAgICB9KTtcblxuICAgIC8vIEF1dG8tcmVzZXQgaWYgY29uZmlndXJlZFxuICAgIGlmICh0aGlzLm9wdGlvbnMuYXV0b1Jlc2V0ID4gMCkge1xuICAgICAgc2V0VGltZW91dCgoKSA9PiB0aGlzLnJlc2V0KCksIHRoaXMub3B0aW9ucy5hdXRvUmVzZXQpO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBSZXNldCB0byBpbml0aWFsIHN0YXRlXG4gICAqIEByZXR1cm5zIHt0aGlzfSBGb3IgY2hhaW5pbmdcbiAgICovXG4gIHJlc2V0KCkge1xuICAgIC8vIFN0b3AgYW55IHNpbXVsYXRpb25cbiAgICB0aGlzLl9zdG9wU2ltdWxhdGlvbigpO1xuXG4gICAgdGhpcy5fc3RhdGUgPSBTT1Byb2dyZXNzQnV0dG9uLlNUQVRFUy5JRExFO1xuICAgIHRoaXMuX3Byb2dyZXNzID0gMDtcblxuICAgIC8vIFVwZGF0ZSBVSVxuICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKCdzby1wcm9ncmVzc2luZycsICdzby1jb21wbGV0ZWQnKTtcbiAgICB0aGlzLl91cGRhdGVQcm9ncmVzc0JhcigpO1xuXG4gICAgLy8gUmUtZW5hYmxlIGJ1dHRvblxuICAgIHRoaXMuZWxlbWVudC5kaXNhYmxlZCA9IGZhbHNlO1xuXG4gICAgLy8gRW1pdCBldmVudFxuICAgIHRoaXMuZW1pdChTT1Byb2dyZXNzQnV0dG9uLkVWRU5UUy5SRVNFVCwge1xuICAgICAgcHJvZ3Jlc3M6IDAsXG4gICAgICBzdGF0ZTogdGhpcy5fc3RhdGUsXG4gICAgfSk7XG5cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBTaW11bGF0ZSBwcm9ncmVzcyBhdXRvbWF0aWNhbGx5XG4gICAqIEBwYXJhbSB7T2JqZWN0fSBbb3B0aW9uc10gLSBTaW11bGF0aW9uIG9wdGlvbnNcbiAgICogQHBhcmFtIHtudW1iZXJ9IFtvcHRpb25zLnNwZWVkXSAtIEludGVydmFsIGluIG1zXG4gICAqIEBwYXJhbSB7bnVtYmVyW119IFtvcHRpb25zLmluY3JlbWVudF0gLSBbbWluLCBtYXhdIHJhbmRvbSBpbmNyZW1lbnRcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgc2ltdWxhdGUob3B0aW9ucyA9IHt9KSB7XG4gICAgY29uc3Qgc3BlZWQgPSBvcHRpb25zLnNwZWVkIHx8IHRoaXMub3B0aW9ucy5zaW11bGF0ZVNwZWVkO1xuICAgIGNvbnN0IFttaW5JbmMsIG1heEluY10gPSBvcHRpb25zLmluY3JlbWVudCB8fCB0aGlzLm9wdGlvbnMuc2ltdWxhdGVJbmNyZW1lbnQ7XG5cbiAgICAvLyBTdGFydCBwcm9ncmVzc1xuICAgIHRoaXMuc3RhcnQoMCk7XG5cbiAgICAvLyBSdW4gc2ltdWxhdGlvblxuICAgIHRoaXMuX3NpbXVsYXRlSW50ZXJ2YWwgPSBzZXRJbnRlcnZhbCgoKSA9PiB7XG4gICAgICBjb25zdCBpbmNyZW1lbnQgPSBNYXRoLnJhbmRvbSgpICogKG1heEluYyAtIG1pbkluYykgKyBtaW5JbmM7XG4gICAgICBjb25zdCBuZXdQcm9ncmVzcyA9IHRoaXMuX3Byb2dyZXNzICsgaW5jcmVtZW50O1xuXG4gICAgICBpZiAobmV3UHJvZ3Jlc3MgPj0gMTAwKSB7XG4gICAgICAgIHRoaXMuX3N0b3BTaW11bGF0aW9uKCk7XG4gICAgICAgIHRoaXMuc2V0UHJvZ3Jlc3MoMTAwKTtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIHRoaXMuc2V0UHJvZ3Jlc3MobmV3UHJvZ3Jlc3MpO1xuICAgICAgfVxuICAgIH0sIHNwZWVkKTtcblxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFN0b3Agc2ltdWxhdGlvblxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3N0b3BTaW11bGF0aW9uKCkge1xuICAgIGlmICh0aGlzLl9zaW11bGF0ZUludGVydmFsKSB7XG4gICAgICBjbGVhckludGVydmFsKHRoaXMuX3NpbXVsYXRlSW50ZXJ2YWwpO1xuICAgICAgdGhpcy5fc2ltdWxhdGVJbnRlcnZhbCA9IG51bGw7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIFVwZGF0ZSBwcm9ncmVzcyBiYXIgQ1NTXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfdXBkYXRlUHJvZ3Jlc3NCYXIoKSB7XG4gICAgdGhpcy5lbGVtZW50LnN0eWxlLnNldFByb3BlcnR5KCctLXByb2dyZXNzJywgYCR7dGhpcy5fcHJvZ3Jlc3N9JWApO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gR0VUVEVSU1xuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBHZXQgY3VycmVudCBwcm9ncmVzcyB2YWx1ZVxuICAgKiBAcmV0dXJucyB7bnVtYmVyfSBQcm9ncmVzcyAoMC0xMDApXG4gICAqL1xuICBnZXRQcm9ncmVzcygpIHtcbiAgICByZXR1cm4gdGhpcy5fcHJvZ3Jlc3M7XG4gIH1cblxuICAvKipcbiAgICogR2V0IGN1cnJlbnQgc3RhdGVcbiAgICogQHJldHVybnMge3N0cmluZ30gQ3VycmVudCBzdGF0ZSAoaWRsZSwgcHJvZ3Jlc3NpbmcsIGNvbXBsZXRlZClcbiAgICovXG4gIGdldFN0YXRlKCkge1xuICAgIHJldHVybiB0aGlzLl9zdGF0ZTtcbiAgfVxuXG4gIC8qKlxuICAgKiBDaGVjayBpZiBidXR0b24gaXMgcHJvZ3Jlc3NpbmdcbiAgICogQHJldHVybnMge2Jvb2xlYW59XG4gICAqL1xuICBpc1Byb2dyZXNzaW5nKCkge1xuICAgIHJldHVybiB0aGlzLl9zdGF0ZSA9PT0gU09Qcm9ncmVzc0J1dHRvbi5TVEFURVMuUFJPR1JFU1NJTkc7XG4gIH1cblxuICAvKipcbiAgICogQ2hlY2sgaWYgYnV0dG9uIGlzIGNvbXBsZXRlZFxuICAgKiBAcmV0dXJucyB7Ym9vbGVhbn1cbiAgICovXG4gIGlzQ29tcGxldGVkKCkge1xuICAgIHJldHVybiB0aGlzLl9zdGF0ZSA9PT0gU09Qcm9ncmVzc0J1dHRvbi5TVEFURVMuQ09NUExFVEVEO1xuICB9XG5cbiAgLyoqXG4gICAqIENoZWNrIGlmIGJ1dHRvbiBpcyBpZGxlXG4gICAqIEByZXR1cm5zIHtib29sZWFufVxuICAgKi9cbiAgaXNJZGxlKCkge1xuICAgIHJldHVybiB0aGlzLl9zdGF0ZSA9PT0gU09Qcm9ncmVzc0J1dHRvbi5TVEFURVMuSURMRTtcbiAgfVxuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIENPTlRFTlQgTUFOSVBVTEFUSU9OXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIFNldCB0aGUgbWFpbiB0ZXh0IGNvbnRlbnRcbiAgICogQHBhcmFtIHtzdHJpbmd9IGh0bWwgLSBIVE1MIGNvbnRlbnRcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgc2V0VGV4dChodG1sKSB7XG4gICAgaWYgKHRoaXMuX3RleHRFbCkge1xuICAgICAgdGhpcy5fdGV4dEVsLmlubmVySFRNTCA9IGh0bWw7XG4gICAgfVxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFNldCB0aGUgc3RhcnQgY29udGVudCAoc2hvd24gZHVyaW5nIHByb2dyZXNzKVxuICAgKiBAcGFyYW0ge3N0cmluZ30gaHRtbCAtIEhUTUwgY29udGVudFxuICAgKiBAcmV0dXJucyB7dGhpc30gRm9yIGNoYWluaW5nXG4gICAqL1xuICBzZXRTdGFydENvbnRlbnQoaHRtbCkge1xuICAgIGlmICh0aGlzLl9zdGFydEVsKSB7XG4gICAgICB0aGlzLl9zdGFydEVsLmlubmVySFRNTCA9IGh0bWw7XG4gICAgfVxuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFNldCB0aGUgZG9uZSBjb250ZW50IChzaG93biBvbiBjb21wbGV0ZSlcbiAgICogQHBhcmFtIHtzdHJpbmd9IGh0bWwgLSBIVE1MIGNvbnRlbnRcbiAgICogQHJldHVybnMge3RoaXN9IEZvciBjaGFpbmluZ1xuICAgKi9cbiAgc2V0RG9uZUNvbnRlbnQoaHRtbCkge1xuICAgIGlmICh0aGlzLl9kb25lRWwpIHtcbiAgICAgIHRoaXMuX2RvbmVFbC5pbm5lckhUTUwgPSBodG1sO1xuICAgIH1cbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gIC8vIExJRkVDWUNMRVxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBEZXN0cm95IHRoZSBjb21wb25lbnRcbiAgICovXG4gIGRlc3Ryb3koKSB7XG4gICAgdGhpcy5fc3RvcFNpbXVsYXRpb24oKTtcbiAgICB0aGlzLnJlc2V0KCk7XG4gICAgc3VwZXIuZGVzdHJveSgpO1xuICB9XG59XG5cbi8vIFJlZ2lzdGVyIGNvbXBvbmVudFxuU09Qcm9ncmVzc0J1dHRvbi5yZWdpc3RlcigpO1xuXG4vLyBBdXRvLWluaXRpYWxpemUgcHJvZ3Jlc3MgYnV0dG9ucyB3aXRoIGRhdGEgYXR0cmlidXRlXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgKCkgPT4ge1xuICBTT1Byb2dyZXNzQnV0dG9uLmluaXRBbGwoJy5zby1idG4tcHJvZ3Jlc3NbZGF0YS1zby1wcm9ncmVzc10nKTtcbn0pO1xuXG4vLyBFeHBvc2UgdG8gZ2xvYmFsIHNjb3BlXG53aW5kb3cuU09Qcm9ncmVzc0J1dHRvbiA9IFNPUHJvZ3Jlc3NCdXR0b247XG5cbi8vIEV4cG9ydCBmb3IgRVMgbW9kdWxlc1xuZXhwb3J0IGRlZmF1bHQgU09Qcm9ncmVzc0J1dHRvbjtcbmV4cG9ydCB7IFNPUHJvZ3Jlc3NCdXR0b24gfTtcbiIsICIvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gU0lYT1JCSVQgVUkgLSBGT1JNUyBGRUFUVVJFXG4vLyBGb3JtIHV0aWxpdGllcywgdmFsaWRhdGlvbiwgYW5kIGVuaGFuY2VtZW50c1xuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuaW1wb3J0IFNpeE9yYml0IGZyb20gJy4uL2NvcmUvc28tY29uZmlnLmpzJztcbmltcG9ydCB7IFNPRHJvcGRvd24gfSBmcm9tICcuLi9jb21wb25lbnRzL3NvLWRyb3Bkb3duLmpzJztcbmltcG9ydCB7IFNPT3RwSW5wdXQgfSBmcm9tICcuLi9jb21wb25lbnRzL3NvLW90cC5qcyc7XG5pbXBvcnQgeyBTT0J1dHRvbkdyb3VwIH0gZnJvbSAnLi4vY29tcG9uZW50cy9zby1idXR0b24tZ3JvdXAuanMnO1xuaW1wb3J0IHsgU09Qcm9ncmVzc0J1dHRvbiB9IGZyb20gJy4uL2NvbXBvbmVudHMvc28tcHJvZ3Jlc3MtYnV0dG9uLmpzJztcblxuLyoqXG4gKiBTT0Zvcm1zIC0gRm9ybSB1dGlsaXRpZXMgYW5kIHZhbGlkYXRpb25cbiAqIFByb3ZpZGVzIGZvcm0gZmllbGQgZW5oYW5jZW1lbnRzIGFuZCB2YWxpZGF0aW9uIGhlbHBlcnNcbiAqL1xuY2xhc3MgU09Gb3JtcyB7XG4gIC8qKlxuICAgKiBJbml0aWFsaXplIGFsbCBmb3JtIGNvbXBvbmVudHMgb24gdGhlIHBhZ2VcbiAgICovXG4gIHN0YXRpYyBpbml0QWxsKCkge1xuICAgIC8vIEluaXRpYWxpemUgc3RhbmRhcmQgZHJvcGRvd25zXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnNvLWRyb3Bkb3duJykuZm9yRWFjaChlbCA9PiB7XG4gICAgICBTT0Ryb3Bkb3duLmdldEluc3RhbmNlKGVsKTtcbiAgICB9KTtcblxuICAgIC8vIEluaXRpYWxpemUgc2VhcmNoYWJsZSBkcm9wZG93bnNcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tc2VhcmNoYWJsZS1kcm9wZG93bicpLmZvckVhY2goZWwgPT4ge1xuICAgICAgU09Ecm9wZG93bi5nZXRJbnN0YW5jZShlbCk7XG4gICAgfSk7XG5cbiAgICAvLyBJbml0aWFsaXplIG9wdGlvbnMgZHJvcGRvd25zXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnNvLW9wdGlvbnMtZHJvcGRvd24nKS5mb3JFYWNoKGVsID0+IHtcbiAgICAgIFNPRHJvcGRvd24uZ2V0SW5zdGFuY2UoZWwpO1xuICAgIH0pO1xuXG4gICAgLy8gSW5pdGlhbGl6ZSBvdXRsZXQgZHJvcGRvd25zXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnNvLW91dGxldC1kcm9wZG93bicpLmZvckVhY2goZWwgPT4ge1xuICAgICAgU09Ecm9wZG93bi5nZXRJbnN0YW5jZShlbCk7XG4gICAgfSk7XG5cbiAgICAvLyBJbml0aWFsaXplIE9UUCBpbnB1dHNcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tb3RwLWdyb3VwJykuZm9yRWFjaChlbCA9PiB7XG4gICAgICBTT090cElucHV0LmdldEluc3RhbmNlKGVsKTtcbiAgICB9KTtcblxuICAgIC8vIEluaXRpYWxpemUgdG9nZ2xlIGJ1dHRvbiBncm91cHNcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCdbZGF0YS1zby10b2dnbGU9XCJidXR0b25zXCJdJykuZm9yRWFjaChlbCA9PiB7XG4gICAgICBTT0J1dHRvbkdyb3VwLmdldEluc3RhbmNlKGVsKTtcbiAgICB9KTtcblxuICAgIC8vIEluaXRpYWxpemUgcHJvZ3Jlc3MgYnV0dG9ucyB3aXRoIGRhdGEgYXR0cmlidXRlXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnNvLWJ0bi1wcm9ncmVzc1tkYXRhLXNvLXByb2dyZXNzXScpLmZvckVhY2goZWwgPT4ge1xuICAgICAgU09Qcm9ncmVzc0J1dHRvbi5nZXRJbnN0YW5jZShlbCk7XG4gICAgfSk7XG5cbiAgICAvLyBJbml0aWFsaXplIGNoZWNrYm94ZXMgc3R5bGluZ1xuICAgIFNPRm9ybXMuX2luaXRDaGVja2JveGVzKCk7XG5cbiAgICAvLyBJbml0aWFsaXplIGlucHV0IGVuaGFuY2VtZW50c1xuICAgIFNPRm9ybXMuX2luaXRJbnB1dEVuaGFuY2VtZW50cygpO1xuICB9XG5cbiAgLyoqXG4gICAqIEluaXRpYWxpemUgY3VzdG9tIGNoZWNrYm94IHN0eWxpbmdcbiAgICogQHByaXZhdGVcbiAgICovXG4gIHN0YXRpYyBfaW5pdENoZWNrYm94ZXMoKSB7XG4gICAgLy8gU3R5bGUgbmF0aXZlIGNoZWNrYm94ZXMgdGhhdCBhcmVuJ3QgYWxyZWFkeSB3cmFwcGVkXG4gICAgLy8gRXhjbHVkZSBjaGVja2JveGVzIHRoYXQgYXJlIGluc2lkZSAuc28tY2hlY2tib3gsIC5zby10b2dnbGUsIC5zby1zd2l0Y2gsIG9yIC5zby1idG4tY2hlY2tcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCdpbnB1dFt0eXBlPVwiY2hlY2tib3hcIl06bm90KC5zby1jaGVja2JveCBpbnB1dCknKS5mb3JFYWNoKGNoZWNrYm94ID0+IHtcbiAgICAgIGlmIChjaGVja2JveC5jbG9zZXN0KCcuc28tY2hlY2tib3gsIC5zby10b2dnbGUsIC5zby1zd2l0Y2gsIC5zby1idG4tY2hlY2snKSkgcmV0dXJuO1xuXG4gICAgICBjb25zdCB3cmFwcGVyID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnbGFiZWwnKTtcbiAgICAgIHdyYXBwZXIuY2xhc3NOYW1lID0gJ3NvLWNoZWNrYm94JztcblxuICAgICAgY29uc3QgYm94ID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnc3BhbicpO1xuICAgICAgYm94LmNsYXNzTmFtZSA9ICdzby1jaGVja2JveC1ib3gnO1xuICAgICAgYm94LmlubmVySFRNTCA9ICc8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+Y2hlY2s8L3NwYW4+JztcblxuICAgICAgY2hlY2tib3gucGFyZW50Tm9kZS5pbnNlcnRCZWZvcmUod3JhcHBlciwgY2hlY2tib3gpO1xuICAgICAgd3JhcHBlci5hcHBlbmRDaGlsZChjaGVja2JveCk7XG4gICAgICB3cmFwcGVyLmFwcGVuZENoaWxkKGJveCk7XG4gICAgfSk7XG4gIH1cblxuICAvKipcbiAgICogSW5pdGlhbGl6ZSBpbnB1dCBlbmhhbmNlbWVudHNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIHN0YXRpYyBfaW5pdElucHV0RW5oYW5jZW1lbnRzKCkge1xuICAgIC8vIFBhc3N3b3JkIHRvZ2dsZVxuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1wYXNzd29yZC10b2dnbGUnKS5mb3JFYWNoKGJ0biA9PiB7XG4gICAgICBidG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoKSA9PiB7XG4gICAgICAgIGNvbnN0IHdyYXBwZXIgPSBidG4uY2xvc2VzdCgnLnNvLWZvcm0taW5wdXQtd3JhcHBlciwgLnNvLWF1dGgtaW5wdXQtd3JhcHBlcicpO1xuICAgICAgICBjb25zdCBpbnB1dCA9IHdyYXBwZXI/LnF1ZXJ5U2VsZWN0b3IoJ2lucHV0Jyk7XG4gICAgICAgIGlmICghaW5wdXQpIHJldHVybjtcblxuICAgICAgICBjb25zdCBpc1Bhc3N3b3JkID0gaW5wdXQudHlwZSA9PT0gJ3Bhc3N3b3JkJztcbiAgICAgICAgaW5wdXQudHlwZSA9IGlzUGFzc3dvcmQgPyAndGV4dCcgOiAncGFzc3dvcmQnO1xuICAgICAgICBidG4ucXVlcnlTZWxlY3RvcignLm1hdGVyaWFsLWljb25zJykudGV4dENvbnRlbnQgPSBpc1Bhc3N3b3JkID8gJ3Zpc2liaWxpdHlfb2ZmJyA6ICd2aXNpYmlsaXR5JztcbiAgICAgIH0pO1xuICAgIH0pO1xuXG4gICAgLy8gSW5wdXQgY2xlYXIgYnV0dG9uc1xuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1pbnB1dC1jbGVhcicpLmZvckVhY2goYnRuID0+IHtcbiAgICAgIGNvbnN0IHdyYXBwZXIgPSBidG4uY2xvc2VzdCgnLnNvLWlucHV0LXdyYXBwZXIsIC5zby1mb3JtLWlucHV0LXdyYXBwZXInKTtcbiAgICAgIGNvbnN0IGlucHV0ID0gd3JhcHBlcj8ucXVlcnlTZWxlY3RvcignaW5wdXQnKTtcblxuICAgICAgLy8gQ2xpY2sgaGFuZGxlciBmb3IgY2xlYXIgYnV0dG9uXG4gICAgICBidG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoKSA9PiB7XG4gICAgICAgIGlmIChpbnB1dCkge1xuICAgICAgICAgIGlucHV0LnZhbHVlID0gJyc7XG4gICAgICAgICAgaW5wdXQuZm9jdXMoKTtcbiAgICAgICAgICBpbnB1dC5kaXNwYXRjaEV2ZW50KG5ldyBFdmVudCgnaW5wdXQnLCB7IGJ1YmJsZXM6IHRydWUgfSkpO1xuICAgICAgICB9XG4gICAgICB9KTtcblxuICAgICAgLy8gRXNjYXBlIGtleSBoYW5kbGVyIG9uIHRoZSBpbnB1dFxuICAgICAgaWYgKGlucHV0KSB7XG4gICAgICAgIGlucHV0LmFkZEV2ZW50TGlzdGVuZXIoJ2tleWRvd24nLCAoZSkgPT4ge1xuICAgICAgICAgIGlmIChlLmtleSA9PT0gJ0VzY2FwZScgJiYgaW5wdXQudmFsdWUudHJpbSgpICE9PSAnJykge1xuICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgICAgIGlucHV0LnZhbHVlID0gJyc7XG4gICAgICAgICAgICBpbnB1dC5kaXNwYXRjaEV2ZW50KG5ldyBFdmVudCgnaW5wdXQnLCB7IGJ1YmJsZXM6IHRydWUgfSkpO1xuICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICAvLyBGbG9hdGluZyBsYWJlbHNcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tZm9ybS1mbG9hdGluZyBpbnB1dCwgLnNvLWZvcm0tZmxvYXRpbmcgdGV4dGFyZWEnKS5mb3JFYWNoKGlucHV0ID0+IHtcbiAgICAgIGNvbnN0IHVwZGF0ZVN0YXRlID0gKCkgPT4ge1xuICAgICAgICBjb25zdCBoYXNWYWx1ZSA9IGlucHV0LnZhbHVlLnRyaW0oKSAhPT0gJyc7XG4gICAgICAgIGlucHV0LmNsYXNzTGlzdC50b2dnbGUoJ2hhcy12YWx1ZScsIGhhc1ZhbHVlKTtcbiAgICAgIH07XG5cbiAgICAgIGlucHV0LmFkZEV2ZW50TGlzdGVuZXIoJ2lucHV0JywgdXBkYXRlU3RhdGUpO1xuICAgICAgaW5wdXQuYWRkRXZlbnRMaXN0ZW5lcignY2hhbmdlJywgdXBkYXRlU3RhdGUpO1xuICAgICAgdXBkYXRlU3RhdGUoKTtcbiAgICB9KTtcblxuICAgIC8vIEluaXRpYWxpemUgYXV0b3NpemUgdGV4dGFyZWFzIChpbmNsdWRpbmcgc2l6ZSB2YXJpYW50cylcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tZm9ybS1jb250cm9sLWF1dG9zaXplLCAuc28tZm9ybS1jb250cm9sLWF1dG9zaXplLXNtLCAuc28tZm9ybS1jb250cm9sLWF1dG9zaXplLWxnJykuZm9yRWFjaCh0ZXh0YXJlYSA9PiB7XG4gICAgICAvLyBEZXRlcm1pbmUgZGVmYXVsdCBtaW4vbWF4IGJhc2VkIG9uIHNpemUgdmFyaWFudFxuICAgICAgbGV0IGRlZmF1bHRNaW5IZWlnaHQgPSA4MDtcbiAgICAgIGxldCBkZWZhdWx0TWF4SGVpZ2h0ID0gNDAwO1xuXG4gICAgICBpZiAodGV4dGFyZWEuY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1mb3JtLWNvbnRyb2wtYXV0b3NpemUtc20nKSkge1xuICAgICAgICBkZWZhdWx0TWluSGVpZ2h0ID0gNjA7XG4gICAgICAgIGRlZmF1bHRNYXhIZWlnaHQgPSAyMDA7XG4gICAgICB9IGVsc2UgaWYgKHRleHRhcmVhLmNsYXNzTGlzdC5jb250YWlucygnc28tZm9ybS1jb250cm9sLWF1dG9zaXplLWxnJykpIHtcbiAgICAgICAgZGVmYXVsdE1pbkhlaWdodCA9IDEyMDtcbiAgICAgICAgZGVmYXVsdE1heEhlaWdodCA9IDYwMDtcbiAgICAgIH1cblxuICAgICAgY29uc3Qgb3B0aW9ucyA9IHtcbiAgICAgICAgbWluSGVpZ2h0OiBwYXJzZUludCh0ZXh0YXJlYS5kYXRhc2V0Lm1pbkhlaWdodCkgfHwgZGVmYXVsdE1pbkhlaWdodCxcbiAgICAgICAgbWF4SGVpZ2h0OiBwYXJzZUludCh0ZXh0YXJlYS5kYXRhc2V0Lm1heEhlaWdodCkgfHwgZGVmYXVsdE1heEhlaWdodFxuICAgICAgfTtcbiAgICAgIFNPVGV4dGFyZWFBdXRvc2l6ZS5nZXRJbnN0YW5jZSh0ZXh0YXJlYSwgb3B0aW9ucyk7XG4gICAgfSk7XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBWQUxJREFUSU9OXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIFZhbGlkYXRlIGFuIGVtYWlsIGFkZHJlc3NcbiAgICogQHBhcmFtIHtzdHJpbmd9IGVtYWlsIC0gRW1haWwgdG8gdmFsaWRhdGVcbiAgICogQHJldHVybnMge2Jvb2xlYW59IFdoZXRoZXIgZW1haWwgaXMgdmFsaWRcbiAgICovXG4gIHN0YXRpYyB2YWxpZGF0ZUVtYWlsKGVtYWlsKSB7XG4gICAgY29uc3QgcmVnZXggPSAvXlteXFxzQF0rQFteXFxzQF0rXFwuW15cXHNAXSskLztcbiAgICByZXR1cm4gcmVnZXgudGVzdChlbWFpbCk7XG4gIH1cblxuICAvKipcbiAgICogVmFsaWRhdGUgYSBwaG9uZSBudW1iZXIgKDEwIGRpZ2l0cylcbiAgICogQHBhcmFtIHtzdHJpbmd9IHBob25lIC0gUGhvbmUgbnVtYmVyIHRvIHZhbGlkYXRlXG4gICAqIEByZXR1cm5zIHtib29sZWFufSBXaGV0aGVyIHBob25lIGlzIHZhbGlkXG4gICAqL1xuICBzdGF0aWMgdmFsaWRhdGVQaG9uZShwaG9uZSkge1xuICAgIGNvbnN0IGNsZWFuZWQgPSBwaG9uZS5yZXBsYWNlKC9bXFxzXFwtXFwoXFwpXS9nLCAnJyk7XG4gICAgcmV0dXJuIC9eWzAtOV17MTB9JC8udGVzdChjbGVhbmVkKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBWYWxpZGF0ZSBhIHJlcXVpcmVkIGZpZWxkXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB2YWx1ZSAtIFZhbHVlIHRvIHZhbGlkYXRlXG4gICAqIEByZXR1cm5zIHtib29sZWFufSBXaGV0aGVyIHZhbHVlIGlzIG5vdCBlbXB0eVxuICAgKi9cbiAgc3RhdGljIHZhbGlkYXRlUmVxdWlyZWQodmFsdWUpIHtcbiAgICByZXR1cm4gdmFsdWUgIT09IG51bGwgJiYgdmFsdWUgIT09IHVuZGVmaW5lZCAmJiB2YWx1ZS50b1N0cmluZygpLnRyaW0oKSAhPT0gJyc7XG4gIH1cblxuICAvKipcbiAgICogVmFsaWRhdGUgbWluaW11bSBsZW5ndGhcbiAgICogQHBhcmFtIHtzdHJpbmd9IHZhbHVlIC0gVmFsdWUgdG8gdmFsaWRhdGVcbiAgICogQHBhcmFtIHtudW1iZXJ9IG1pbkxlbmd0aCAtIE1pbmltdW0gbGVuZ3RoXG4gICAqIEByZXR1cm5zIHtib29sZWFufSBXaGV0aGVyIHZhbHVlIG1lZXRzIG1pbmltdW0gbGVuZ3RoXG4gICAqL1xuICBzdGF0aWMgdmFsaWRhdGVNaW5MZW5ndGgodmFsdWUsIG1pbkxlbmd0aCkge1xuICAgIHJldHVybiB2YWx1ZS5sZW5ndGggPj0gbWluTGVuZ3RoO1xuICB9XG5cbiAgLyoqXG4gICAqIFZhbGlkYXRlIG1heGltdW0gbGVuZ3RoXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB2YWx1ZSAtIFZhbHVlIHRvIHZhbGlkYXRlXG4gICAqIEBwYXJhbSB7bnVtYmVyfSBtYXhMZW5ndGggLSBNYXhpbXVtIGxlbmd0aFxuICAgKiBAcmV0dXJucyB7Ym9vbGVhbn0gV2hldGhlciB2YWx1ZSBpcyB3aXRoaW4gbWF4aW11bSBsZW5ndGhcbiAgICovXG4gIHN0YXRpYyB2YWxpZGF0ZU1heExlbmd0aCh2YWx1ZSwgbWF4TGVuZ3RoKSB7XG4gICAgcmV0dXJuIHZhbHVlLmxlbmd0aCA8PSBtYXhMZW5ndGg7XG4gIH1cblxuICAvKipcbiAgICogVmFsaWRhdGUgcGFzc3dvcmQgc3RyZW5ndGhcbiAgICogQHBhcmFtIHtzdHJpbmd9IHBhc3N3b3JkIC0gUGFzc3dvcmQgdG8gdmFsaWRhdGVcbiAgICogQHBhcmFtIHtPYmplY3R9IG9wdGlvbnMgLSBWYWxpZGF0aW9uIG9wdGlvbnNcbiAgICogQHJldHVybnMge09iamVjdH0gVmFsaWRhdGlvbiByZXN1bHQgd2l0aCBpbmRpdmlkdWFsIGNoZWNrc1xuICAgKi9cbiAgc3RhdGljIHZhbGlkYXRlUGFzc3dvcmQocGFzc3dvcmQsIG9wdGlvbnMgPSB7fSkge1xuICAgIGNvbnN0IHtcbiAgICAgIG1pbkxlbmd0aCA9IDgsXG4gICAgICByZXF1aXJlVXBwZXJjYXNlID0gdHJ1ZSxcbiAgICAgIHJlcXVpcmVMb3dlcmNhc2UgPSB0cnVlLFxuICAgICAgcmVxdWlyZU51bWJlciA9IHRydWUsXG4gICAgICByZXF1aXJlU3BlY2lhbCA9IGZhbHNlLFxuICAgIH0gPSBvcHRpb25zO1xuXG4gICAgY29uc3QgcmVzdWx0ID0ge1xuICAgICAgdmFsaWQ6IHRydWUsXG4gICAgICBsZW5ndGg6IHBhc3N3b3JkLmxlbmd0aCA+PSBtaW5MZW5ndGgsXG4gICAgICB1cHBlcmNhc2U6ICFyZXF1aXJlVXBwZXJjYXNlIHx8IC9bQS1aXS8udGVzdChwYXNzd29yZCksXG4gICAgICBsb3dlcmNhc2U6ICFyZXF1aXJlTG93ZXJjYXNlIHx8IC9bYS16XS8udGVzdChwYXNzd29yZCksXG4gICAgICBudW1iZXI6ICFyZXF1aXJlTnVtYmVyIHx8IC9bMC05XS8udGVzdChwYXNzd29yZCksXG4gICAgICBzcGVjaWFsOiAhcmVxdWlyZVNwZWNpYWwgfHwgL1shQCMkJV4mKigpLC4/XCI6e318PD5dLy50ZXN0KHBhc3N3b3JkKSxcbiAgICB9O1xuXG4gICAgcmVzdWx0LnZhbGlkID0gcmVzdWx0Lmxlbmd0aCAmJiByZXN1bHQudXBwZXJjYXNlICYmIHJlc3VsdC5sb3dlcmNhc2UgJiYgcmVzdWx0Lm51bWJlciAmJiByZXN1bHQuc3BlY2lhbDtcblxuICAgIHJldHVybiByZXN1bHQ7XG4gIH1cblxuICAvKipcbiAgICogVmFsaWRhdGUgdGhhdCB0d28gdmFsdWVzIG1hdGNoXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB2YWx1ZTEgLSBGaXJzdCB2YWx1ZVxuICAgKiBAcGFyYW0ge3N0cmluZ30gdmFsdWUyIC0gU2Vjb25kIHZhbHVlXG4gICAqIEByZXR1cm5zIHtib29sZWFufSBXaGV0aGVyIHZhbHVlcyBtYXRjaFxuICAgKi9cbiAgc3RhdGljIHZhbGlkYXRlTWF0Y2godmFsdWUxLCB2YWx1ZTIpIHtcbiAgICByZXR1cm4gdmFsdWUxID09PSB2YWx1ZTI7XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBGT1JNIFNUQVRFXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIFNob3cgZXJyb3Igc3RhdGUgb24gYSBmb3JtIGdyb3VwXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBmaWVsZElkIC0gRmllbGQgSUQgKHdpdGhvdXQgJ0dyb3VwJyBzdWZmaXgpXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBtZXNzYWdlIC0gRXJyb3IgbWVzc2FnZVxuICAgKi9cbiAgc3RhdGljIHNob3dFcnJvcihmaWVsZElkLCBtZXNzYWdlKSB7XG4gICAgY29uc3QgZ3JvdXAgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChgJHtmaWVsZElkfUdyb3VwYCk7XG4gICAgY29uc3QgZXJyb3JFbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGAke2ZpZWxkSWR9RXJyb3JgKTtcblxuICAgIGlmIChncm91cCkge1xuICAgICAgZ3JvdXAuY2xhc3NMaXN0LnJlbW92ZSgnaGFzLXN1Y2Nlc3MnLCAnaGFzLXdhcm5pbmcnLCAnaGFzLWluZm8nKTtcbiAgICAgIGdyb3VwLmNsYXNzTGlzdC5hZGQoJ2hhcy1lcnJvcicpO1xuICAgIH1cbiAgICBpZiAoZXJyb3JFbCAmJiBtZXNzYWdlKSB7XG4gICAgICBlcnJvckVsLnRleHRDb250ZW50ID0gbWVzc2FnZTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogU2hvdyBzdWNjZXNzIHN0YXRlIG9uIGEgZm9ybSBncm91cFxuICAgKiBAcGFyYW0ge3N0cmluZ30gZmllbGRJZCAtIEZpZWxkIElEICh3aXRob3V0ICdHcm91cCcgc3VmZml4KVxuICAgKiBAcGFyYW0ge3N0cmluZ30gbWVzc2FnZSAtIFN1Y2Nlc3MgbWVzc2FnZSAob3B0aW9uYWwpXG4gICAqL1xuICBzdGF0aWMgc2hvd1N1Y2Nlc3MoZmllbGRJZCwgbWVzc2FnZSA9ICcnKSB7XG4gICAgY29uc3QgZ3JvdXAgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChgJHtmaWVsZElkfUdyb3VwYCk7XG4gICAgY29uc3Qgc3VjY2Vzc0VsID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoYCR7ZmllbGRJZH1TdWNjZXNzYCk7XG5cbiAgICBpZiAoZ3JvdXApIHtcbiAgICAgIGdyb3VwLmNsYXNzTGlzdC5yZW1vdmUoJ2hhcy1lcnJvcicsICdoYXMtd2FybmluZycsICdoYXMtaW5mbycpO1xuICAgICAgZ3JvdXAuY2xhc3NMaXN0LmFkZCgnaGFzLXN1Y2Nlc3MnKTtcbiAgICB9XG4gICAgaWYgKHN1Y2Nlc3NFbCAmJiBtZXNzYWdlKSB7XG4gICAgICBzdWNjZXNzRWwudGV4dENvbnRlbnQgPSBtZXNzYWdlO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBTaG93IHdhcm5pbmcgc3RhdGUgb24gYSBmb3JtIGdyb3VwXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBmaWVsZElkIC0gRmllbGQgSUQgKHdpdGhvdXQgJ0dyb3VwJyBzdWZmaXgpXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBtZXNzYWdlIC0gV2FybmluZyBtZXNzYWdlXG4gICAqL1xuICBzdGF0aWMgc2hvd1dhcm5pbmcoZmllbGRJZCwgbWVzc2FnZSkge1xuICAgIGNvbnN0IGdyb3VwID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoYCR7ZmllbGRJZH1Hcm91cGApO1xuICAgIGNvbnN0IHdhcm5pbmdFbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGAke2ZpZWxkSWR9V2FybmluZ2ApO1xuXG4gICAgaWYgKGdyb3VwKSB7XG4gICAgICBncm91cC5jbGFzc0xpc3QucmVtb3ZlKCdoYXMtZXJyb3InLCAnaGFzLXN1Y2Nlc3MnLCAnaGFzLWluZm8nKTtcbiAgICAgIGdyb3VwLmNsYXNzTGlzdC5hZGQoJ2hhcy13YXJuaW5nJyk7XG4gICAgfVxuICAgIGlmICh3YXJuaW5nRWwgJiYgbWVzc2FnZSkge1xuICAgICAgd2FybmluZ0VsLnRleHRDb250ZW50ID0gbWVzc2FnZTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogU2hvdyBpbmZvIHN0YXRlIG9uIGEgZm9ybSBncm91cFxuICAgKiBAcGFyYW0ge3N0cmluZ30gZmllbGRJZCAtIEZpZWxkIElEICh3aXRob3V0ICdHcm91cCcgc3VmZml4KVxuICAgKiBAcGFyYW0ge3N0cmluZ30gbWVzc2FnZSAtIEluZm8gbWVzc2FnZVxuICAgKi9cbiAgc3RhdGljIHNob3dJbmZvKGZpZWxkSWQsIG1lc3NhZ2UpIHtcbiAgICBjb25zdCBncm91cCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGAke2ZpZWxkSWR9R3JvdXBgKTtcbiAgICBjb25zdCBpbmZvRWwgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChgJHtmaWVsZElkfUluZm9gKTtcblxuICAgIGlmIChncm91cCkge1xuICAgICAgZ3JvdXAuY2xhc3NMaXN0LnJlbW92ZSgnaGFzLWVycm9yJywgJ2hhcy1zdWNjZXNzJywgJ2hhcy13YXJuaW5nJyk7XG4gICAgICBncm91cC5jbGFzc0xpc3QuYWRkKCdoYXMtaW5mbycpO1xuICAgIH1cbiAgICBpZiAoaW5mb0VsICYmIG1lc3NhZ2UpIHtcbiAgICAgIGluZm9FbC50ZXh0Q29udGVudCA9IG1lc3NhZ2U7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIENsZWFyIGVycm9yIHN0YXRlIG9uIGEgZm9ybSBncm91cFxuICAgKiBAcGFyYW0ge3N0cmluZ30gZmllbGRJZCAtIEZpZWxkIElEICh3aXRob3V0ICdHcm91cCcgc3VmZml4KVxuICAgKi9cbiAgc3RhdGljIGNsZWFyRXJyb3IoZmllbGRJZCkge1xuICAgIGNvbnN0IGdyb3VwID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoYCR7ZmllbGRJZH1Hcm91cGApO1xuICAgIGlmIChncm91cCkge1xuICAgICAgZ3JvdXAuY2xhc3NMaXN0LnJlbW92ZSgnaGFzLWVycm9yJyk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIENsZWFyIGFsbCB2YWxpZGF0aW9uIHN0YXRlcyBvbiBhIGZvcm0gZ3JvdXBcbiAgICogQHBhcmFtIHtzdHJpbmd9IGZpZWxkSWQgLSBGaWVsZCBJRCAod2l0aG91dCAnR3JvdXAnIHN1ZmZpeClcbiAgICovXG4gIHN0YXRpYyBjbGVhclZhbGlkYXRpb24oZmllbGRJZCkge1xuICAgIGNvbnN0IGdyb3VwID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoYCR7ZmllbGRJZH1Hcm91cGApO1xuICAgIGlmIChncm91cCkge1xuICAgICAgZ3JvdXAuY2xhc3NMaXN0LnJlbW92ZSgnaGFzLWVycm9yJywgJ2hhcy1zdWNjZXNzJywgJ2hhcy13YXJuaW5nJywgJ2hhcy1pbmZvJyk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIENsZWFyIGFsbCBlcnJvcnMgaW4gYSBmb3JtXG4gICAqIEBwYXJhbSB7SFRNTEZvcm1FbGVtZW50fHN0cmluZ30gZm9ybSAtIEZvcm0gZWxlbWVudCBvciBzZWxlY3RvclxuICAgKi9cbiAgc3RhdGljIGNsZWFyQWxsRXJyb3JzKGZvcm0pIHtcbiAgICBjb25zdCBmb3JtRWwgPSB0eXBlb2YgZm9ybSA9PT0gJ3N0cmluZycgPyBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKGZvcm0pIDogZm9ybTtcbiAgICBpZiAoIWZvcm1FbCkgcmV0dXJuO1xuXG4gICAgZm9ybUVsLnF1ZXJ5U2VsZWN0b3JBbGwoJy5oYXMtZXJyb3InKS5mb3JFYWNoKGVsID0+IHtcbiAgICAgIGVsLmNsYXNzTGlzdC5yZW1vdmUoJ2hhcy1lcnJvcicpO1xuICAgIH0pO1xuICB9XG5cbiAgLyoqXG4gICAqIFNldCBsb2FkaW5nIHN0YXRlIG9uIGEgYnV0dG9uXG4gICAqIEBwYXJhbSB7SFRNTEJ1dHRvbkVsZW1lbnR8c3RyaW5nfSBidXR0b24gLSBCdXR0b24gZWxlbWVudCBvciBzZWxlY3RvclxuICAgKiBAcGFyYW0ge2Jvb2xlYW59IGlzTG9hZGluZyAtIFdoZXRoZXIgdG8gc2hvdyBsb2FkaW5nIHN0YXRlXG4gICAqL1xuICBzdGF0aWMgc2V0QnV0dG9uTG9hZGluZyhidXR0b24sIGlzTG9hZGluZykge1xuICAgIGNvbnN0IGJ0biA9IHR5cGVvZiBidXR0b24gPT09ICdzdHJpbmcnID8gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihidXR0b24pIDogYnV0dG9uO1xuICAgIGlmICghYnRuKSByZXR1cm47XG5cbiAgICBpZiAoaXNMb2FkaW5nKSB7XG4gICAgICBidG4uY2xhc3NMaXN0LmFkZCgnc28tbG9hZGluZycpO1xuICAgICAgYnRuLmRpc2FibGVkID0gdHJ1ZTtcbiAgICB9IGVsc2Uge1xuICAgICAgYnRuLmNsYXNzTGlzdC5yZW1vdmUoJ3NvLWxvYWRpbmcnKTtcbiAgICAgIGJ0bi5kaXNhYmxlZCA9IGZhbHNlO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgZm9ybSBkYXRhIGFzIGFuIG9iamVjdFxuICAgKiBAcGFyYW0ge0hUTUxGb3JtRWxlbWVudHxzdHJpbmd9IGZvcm0gLSBGb3JtIGVsZW1lbnQgb3Igc2VsZWN0b3JcbiAgICogQHJldHVybnMge09iamVjdH0gRm9ybSBkYXRhIG9iamVjdFxuICAgKi9cbiAgc3RhdGljIGdldEZvcm1EYXRhKGZvcm0pIHtcbiAgICBjb25zdCBmb3JtRWwgPSB0eXBlb2YgZm9ybSA9PT0gJ3N0cmluZycgPyBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKGZvcm0pIDogZm9ybTtcbiAgICBpZiAoIWZvcm1FbCkgcmV0dXJuIHt9O1xuXG4gICAgY29uc3QgZm9ybURhdGEgPSBuZXcgRm9ybURhdGEoZm9ybUVsKTtcbiAgICBjb25zdCBkYXRhID0ge307XG5cbiAgICBmb3IgKGNvbnN0IFtrZXksIHZhbHVlXSBvZiBmb3JtRGF0YS5lbnRyaWVzKCkpIHtcbiAgICAgIC8vIEhhbmRsZSBtdWx0aXBsZSB2YWx1ZXMgKGxpa2UgY2hlY2tib3hlcylcbiAgICAgIGlmIChkYXRhW2tleV0pIHtcbiAgICAgICAgaWYgKCFBcnJheS5pc0FycmF5KGRhdGFba2V5XSkpIHtcbiAgICAgICAgICBkYXRhW2tleV0gPSBbZGF0YVtrZXldXTtcbiAgICAgICAgfVxuICAgICAgICBkYXRhW2tleV0ucHVzaCh2YWx1ZSk7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICBkYXRhW2tleV0gPSB2YWx1ZTtcbiAgICAgIH1cbiAgICB9XG5cbiAgICByZXR1cm4gZGF0YTtcbiAgfVxuXG4gIC8qKlxuICAgKiBTZXQgZm9ybSBkYXRhIGZyb20gYW4gb2JqZWN0XG4gICAqIEBwYXJhbSB7SFRNTEZvcm1FbGVtZW50fHN0cmluZ30gZm9ybSAtIEZvcm0gZWxlbWVudCBvciBzZWxlY3RvclxuICAgKiBAcGFyYW0ge09iamVjdH0gZGF0YSAtIERhdGEgb2JqZWN0XG4gICAqL1xuICBzdGF0aWMgc2V0Rm9ybURhdGEoZm9ybSwgZGF0YSkge1xuICAgIGNvbnN0IGZvcm1FbCA9IHR5cGVvZiBmb3JtID09PSAnc3RyaW5nJyA/IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoZm9ybSkgOiBmb3JtO1xuICAgIGlmICghZm9ybUVsKSByZXR1cm47XG5cbiAgICBPYmplY3QuZW50cmllcyhkYXRhKS5mb3JFYWNoKChbbmFtZSwgdmFsdWVdKSA9PiB7XG4gICAgICBjb25zdCBmaWVsZCA9IGZvcm1FbC5lbGVtZW50c1tuYW1lXTtcbiAgICAgIGlmICghZmllbGQpIHJldHVybjtcblxuICAgICAgaWYgKGZpZWxkLnR5cGUgPT09ICdjaGVja2JveCcpIHtcbiAgICAgICAgZmllbGQuY2hlY2tlZCA9ICEhdmFsdWU7XG4gICAgICB9IGVsc2UgaWYgKGZpZWxkLnR5cGUgPT09ICdyYWRpbycpIHtcbiAgICAgICAgY29uc3QgcmFkaW8gPSBmb3JtRWwucXVlcnlTZWxlY3RvcihgaW5wdXRbbmFtZT1cIiR7bmFtZX1cIl1bdmFsdWU9XCIke3ZhbHVlfVwiXWApO1xuICAgICAgICBpZiAocmFkaW8pIHJhZGlvLmNoZWNrZWQgPSB0cnVlO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgZmllbGQudmFsdWUgPSB2YWx1ZTtcbiAgICAgIH1cbiAgICB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBSZXNldCBmb3JtIHRvIGluaXRpYWwgc3RhdGVcbiAgICogQHBhcmFtIHtIVE1MRm9ybUVsZW1lbnR8c3RyaW5nfSBmb3JtIC0gRm9ybSBlbGVtZW50IG9yIHNlbGVjdG9yXG4gICAqL1xuICBzdGF0aWMgcmVzZXRGb3JtKGZvcm0pIHtcbiAgICBjb25zdCBmb3JtRWwgPSB0eXBlb2YgZm9ybSA9PT0gJ3N0cmluZycgPyBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKGZvcm0pIDogZm9ybTtcbiAgICBpZiAoIWZvcm1FbCkgcmV0dXJuO1xuXG4gICAgZm9ybUVsLnJlc2V0KCk7XG4gICAgU09Gb3Jtcy5jbGVhckFsbEVycm9ycyhmb3JtRWwpO1xuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gTUFTS0lOR1xuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBNYXNrIGFuIGVtYWlsIGFkZHJlc3NcbiAgICogQHBhcmFtIHtzdHJpbmd9IGVtYWlsIC0gRW1haWwgdG8gbWFza1xuICAgKiBAcmV0dXJucyB7c3RyaW5nfSBNYXNrZWQgZW1haWxcbiAgICovXG4gIHN0YXRpYyBtYXNrRW1haWwoZW1haWwpIHtcbiAgICBjb25zdCBbbG9jYWwsIGRvbWFpbl0gPSBlbWFpbC5zcGxpdCgnQCcpO1xuICAgIGlmICghZG9tYWluKSByZXR1cm4gZW1haWw7XG5cbiAgICBjb25zdCBtYXNrZWRMb2NhbCA9IGxvY2FsLmNoYXJBdCgwKSArXG4gICAgICAnKicucmVwZWF0KE1hdGgubWluKGxvY2FsLmxlbmd0aCAtIDIsIDQpKSArXG4gICAgICBsb2NhbC5jaGFyQXQobG9jYWwubGVuZ3RoIC0gMSk7XG5cbiAgICByZXR1cm4gYCR7bWFza2VkTG9jYWx9QCR7ZG9tYWlufWA7XG4gIH1cblxuICAvKipcbiAgICogTWFzayBhIHBob25lIG51bWJlclxuICAgKiBAcGFyYW0ge3N0cmluZ30gcGhvbmUgLSBQaG9uZSBudW1iZXIgdG8gbWFza1xuICAgKiBAcmV0dXJucyB7c3RyaW5nfSBNYXNrZWQgcGhvbmVcbiAgICovXG4gIHN0YXRpYyBtYXNrUGhvbmUocGhvbmUpIHtcbiAgICBjb25zdCBjbGVhbmVkID0gcGhvbmUucmVwbGFjZSgvW1xcc1xcLVxcKFxcKV0vZywgJycpO1xuICAgIGlmIChjbGVhbmVkLmxlbmd0aCA8IDQpIHJldHVybiBwaG9uZTtcblxuICAgIHJldHVybiBjbGVhbmVkLnNsaWNlKDAsIDIpICsgJyonLnJlcGVhdChjbGVhbmVkLmxlbmd0aCAtIDQpICsgY2xlYW5lZC5zbGljZSgtMik7XG4gIH1cbn1cblxuLyoqXG4gKiBTT1RleHRhcmVhQXV0b3NpemUgLSBBdXRvLWV4cGFuZGluZyB0ZXh0YXJlYVxuICogQXV0b21hdGljYWxseSBhZGp1c3RzIGhlaWdodCBiYXNlZCBvbiBjb250ZW50XG4gKi9cbmNsYXNzIFNPVGV4dGFyZWFBdXRvc2l6ZSB7XG4gIC8qKlxuICAgKiBDcmVhdGUgYXV0b3NpemUgdGV4dGFyZWFcbiAgICogQHBhcmFtIHtIVE1MVGV4dEFyZWFFbGVtZW50fSBlbGVtZW50IC0gVGhlIHRleHRhcmVhIGVsZW1lbnRcbiAgICogQHBhcmFtIHtPYmplY3R9IG9wdGlvbnMgLSBDb25maWd1cmF0aW9uIG9wdGlvbnNcbiAgICovXG4gIGNvbnN0cnVjdG9yKGVsZW1lbnQsIG9wdGlvbnMgPSB7fSkge1xuICAgIHRoaXMuZWxlbWVudCA9IGVsZW1lbnQ7XG4gICAgdGhpcy5vcHRpb25zID0ge1xuICAgICAgbWluSGVpZ2h0OiBvcHRpb25zLm1pbkhlaWdodCB8fCA4MCxcbiAgICAgIG1heEhlaWdodDogb3B0aW9ucy5tYXhIZWlnaHQgfHwgNDAwLFxuICAgICAgLi4ub3B0aW9uc1xuICAgIH07XG5cbiAgICB0aGlzLl9pbml0KCk7XG4gIH1cblxuICAvKipcbiAgICogSW5pdGlhbGl6ZSB0aGUgYXV0b3NpemUgZnVuY3Rpb25hbGl0eVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2luaXQoKSB7XG4gICAgLy8gU3RvcmUgb3JpZ2luYWwgc3R5bGVzXG4gICAgdGhpcy5fb3JpZ2luYWxTdHlsZXMgPSB7XG4gICAgICBoZWlnaHQ6IHRoaXMuZWxlbWVudC5zdHlsZS5oZWlnaHQsXG4gICAgICBvdmVyZmxvdzogdGhpcy5lbGVtZW50LnN0eWxlLm92ZXJmbG93LFxuICAgICAgcmVzaXplOiB0aGlzLmVsZW1lbnQuc3R5bGUucmVzaXplXG4gICAgfTtcblxuICAgIC8vIEFwcGx5IGF1dG9zaXplIHN0eWxlc1xuICAgIHRoaXMuZWxlbWVudC5zdHlsZS5vdmVyZmxvdyA9ICdoaWRkZW4nO1xuICAgIHRoaXMuZWxlbWVudC5zdHlsZS5yZXNpemUgPSAnbm9uZSc7XG4gICAgdGhpcy5lbGVtZW50LnN0eWxlLm1pbkhlaWdodCA9IGAke3RoaXMub3B0aW9ucy5taW5IZWlnaHR9cHhgO1xuICAgIHRoaXMuZWxlbWVudC5zdHlsZS5tYXhIZWlnaHQgPSBgJHt0aGlzLm9wdGlvbnMubWF4SGVpZ2h0fXB4YDtcblxuICAgIC8vIEJpbmQgZXZlbnRzXG4gICAgdGhpcy5fYm91bmRSZXNpemUgPSB0aGlzLl9yZXNpemUuYmluZCh0aGlzKTtcbiAgICB0aGlzLmVsZW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignaW5wdXQnLCB0aGlzLl9ib3VuZFJlc2l6ZSk7XG4gICAgdGhpcy5lbGVtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2NoYW5nZScsIHRoaXMuX2JvdW5kUmVzaXplKTtcblxuICAgIC8vIEluaXRpYWwgcmVzaXplXG4gICAgdGhpcy5fcmVzaXplKCk7XG5cbiAgICAvLyBIYW5kbGUgd2luZG93IHJlc2l6ZVxuICAgIHRoaXMuX2JvdW5kV2luZG93UmVzaXplID0gdGhpcy5fcmVzaXplLmJpbmQodGhpcyk7XG4gICAgd2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ3Jlc2l6ZScsIHRoaXMuX2JvdW5kV2luZG93UmVzaXplKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBSZXNpemUgdGhlIHRleHRhcmVhIGJhc2VkIG9uIGNvbnRlbnRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9yZXNpemUoKSB7XG4gICAgLy8gUmVzZXQgaGVpZ2h0IHRvIGF1dG8gdG8gZ2V0IHRoZSBjb3JyZWN0IHNjcm9sbEhlaWdodFxuICAgIHRoaXMuZWxlbWVudC5zdHlsZS5oZWlnaHQgPSAnYXV0byc7XG5cbiAgICAvLyBDYWxjdWxhdGUgbmV3IGhlaWdodFxuICAgIGNvbnN0IHNjcm9sbEhlaWdodCA9IHRoaXMuZWxlbWVudC5zY3JvbGxIZWlnaHQ7XG4gICAgY29uc3QgbmV3SGVpZ2h0ID0gTWF0aC5taW4oXG4gICAgICBNYXRoLm1heChzY3JvbGxIZWlnaHQsIHRoaXMub3B0aW9ucy5taW5IZWlnaHQpLFxuICAgICAgdGhpcy5vcHRpb25zLm1heEhlaWdodFxuICAgICk7XG5cbiAgICB0aGlzLmVsZW1lbnQuc3R5bGUuaGVpZ2h0ID0gYCR7bmV3SGVpZ2h0fXB4YDtcblxuICAgIC8vIFNob3cgc2Nyb2xsYmFyIGlmIGNvbnRlbnQgZXhjZWVkcyBtYXggaGVpZ2h0XG4gICAgaWYgKHNjcm9sbEhlaWdodCA+IHRoaXMub3B0aW9ucy5tYXhIZWlnaHQpIHtcbiAgICAgIHRoaXMuZWxlbWVudC5zdHlsZS5vdmVyZmxvdyA9ICdhdXRvJztcbiAgICB9IGVsc2Uge1xuICAgICAgdGhpcy5lbGVtZW50LnN0eWxlLm92ZXJmbG93ID0gJ2hpZGRlbic7XG4gICAgfVxuXG4gICAgLy8gRGlzcGF0Y2ggY3VzdG9tIGV2ZW50XG4gICAgdGhpcy5lbGVtZW50LmRpc3BhdGNoRXZlbnQobmV3IEN1c3RvbUV2ZW50KCdzbzphdXRvc2l6ZScsIHtcbiAgICAgIGRldGFpbDogeyBoZWlnaHQ6IG5ld0hlaWdodCwgc2Nyb2xsSGVpZ2h0IH1cbiAgICB9KSk7XG4gIH1cblxuICAvKipcbiAgICogVXBkYXRlIHRoZSBjb250ZW50IGFuZCByZXNpemVcbiAgICogQHBhcmFtIHtzdHJpbmd9IHZhbHVlIC0gTmV3IHZhbHVlXG4gICAqL1xuICB1cGRhdGUodmFsdWUpIHtcbiAgICB0aGlzLmVsZW1lbnQudmFsdWUgPSB2YWx1ZTtcbiAgICB0aGlzLl9yZXNpemUoKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBEZXN0cm95IHRoZSBhdXRvc2l6ZSBpbnN0YW5jZVxuICAgKi9cbiAgZGVzdHJveSgpIHtcbiAgICAvLyBSZW1vdmUgZXZlbnQgbGlzdGVuZXJzXG4gICAgdGhpcy5lbGVtZW50LnJlbW92ZUV2ZW50TGlzdGVuZXIoJ2lucHV0JywgdGhpcy5fYm91bmRSZXNpemUpO1xuICAgIHRoaXMuZWxlbWVudC5yZW1vdmVFdmVudExpc3RlbmVyKCdjaGFuZ2UnLCB0aGlzLl9ib3VuZFJlc2l6ZSk7XG4gICAgd2luZG93LnJlbW92ZUV2ZW50TGlzdGVuZXIoJ3Jlc2l6ZScsIHRoaXMuX2JvdW5kV2luZG93UmVzaXplKTtcblxuICAgIC8vIFJlc3RvcmUgb3JpZ2luYWwgc3R5bGVzXG4gICAgdGhpcy5lbGVtZW50LnN0eWxlLmhlaWdodCA9IHRoaXMuX29yaWdpbmFsU3R5bGVzLmhlaWdodDtcbiAgICB0aGlzLmVsZW1lbnQuc3R5bGUub3ZlcmZsb3cgPSB0aGlzLl9vcmlnaW5hbFN0eWxlcy5vdmVyZmxvdztcbiAgICB0aGlzLmVsZW1lbnQuc3R5bGUucmVzaXplID0gdGhpcy5fb3JpZ2luYWxTdHlsZXMucmVzaXplO1xuICAgIHRoaXMuZWxlbWVudC5zdHlsZS5taW5IZWlnaHQgPSAnJztcbiAgICB0aGlzLmVsZW1lbnQuc3R5bGUubWF4SGVpZ2h0ID0gJyc7XG5cbiAgICAvLyBSZW1vdmUgaW5zdGFuY2UgcmVmZXJlbmNlXG4gICAgZGVsZXRlIHRoaXMuZWxlbWVudC5fc29BdXRvc2l6ZTtcbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgb3IgY3JlYXRlIGluc3RhbmNlIGZvciBlbGVtZW50XG4gICAqIEBwYXJhbSB7SFRNTFRleHRBcmVhRWxlbWVudH0gZWxlbWVudCAtIFRoZSB0ZXh0YXJlYSBlbGVtZW50XG4gICAqIEBwYXJhbSB7T2JqZWN0fSBvcHRpb25zIC0gQ29uZmlndXJhdGlvbiBvcHRpb25zXG4gICAqIEByZXR1cm5zIHtTT1RleHRhcmVhQXV0b3NpemV9XG4gICAqL1xuICBzdGF0aWMgZ2V0SW5zdGFuY2UoZWxlbWVudCwgb3B0aW9ucyA9IHt9KSB7XG4gICAgaWYgKCFlbGVtZW50Ll9zb0F1dG9zaXplKSB7XG4gICAgICBlbGVtZW50Ll9zb0F1dG9zaXplID0gbmV3IFNPVGV4dGFyZWFBdXRvc2l6ZShlbGVtZW50LCBvcHRpb25zKTtcbiAgICB9XG4gICAgcmV0dXJuIGVsZW1lbnQuX3NvQXV0b3NpemU7XG4gIH1cbn1cblxuLy8gQXV0by1pbml0aWFsaXplIHdoZW4gRE9NIGlzIHJlYWR5XG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgKCkgPT4ge1xuICBTT0Zvcm1zLmluaXRBbGwoKTtcbn0pO1xuXG4vLyBFeHBvc2UgdG8gZ2xvYmFsIHNjb3BlXG53aW5kb3cuU09Gb3JtcyA9IFNPRm9ybXM7XG53aW5kb3cuU09UZXh0YXJlYUF1dG9zaXplID0gU09UZXh0YXJlYUF1dG9zaXplO1xud2luZG93LlNPQnV0dG9uR3JvdXAgPSBTT0J1dHRvbkdyb3VwO1xud2luZG93LlNPUHJvZ3Jlc3NCdXR0b24gPSBTT1Byb2dyZXNzQnV0dG9uO1xuXG4vLyBFeHBvcnQgZm9yIEVTIG1vZHVsZXNcbmV4cG9ydCBkZWZhdWx0IFNPRm9ybXM7XG5leHBvcnQgeyBTT0Zvcm1zLCBTT1RleHRhcmVhQXV0b3NpemUsIFNPQnV0dG9uR3JvdXAsIFNPUHJvZ3Jlc3NCdXR0b24gfTtcbiIsICIvKipcbiAqIFNpeE9yYml0IFVJIC0gQ2hpcHMgQ29tcG9uZW50XG4gKiBIYW5kbGVzIGNsb3NhYmxlIGFuZCBzZWxlY3RhYmxlIGNoaXAgaW50ZXJhY3Rpb25zXG4gKi9cblxuY2xhc3MgU09DaGlwcyB7XG4gIGNvbnN0cnVjdG9yKCkge1xuICAgIHRoaXMuaW5pdCgpO1xuICB9XG5cbiAgaW5pdCgpIHtcbiAgICAvLyBJbml0aWFsaXplIG9uIERPTSByZWFkeVxuICAgIGlmIChkb2N1bWVudC5yZWFkeVN0YXRlID09PSAnbG9hZGluZycpIHtcbiAgICAgIGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCAoKSA9PiB7XG4gICAgICAgIHRoaXMuYmluZEFsbCgpO1xuICAgICAgfSk7XG4gICAgfSBlbHNlIHtcbiAgICAgIHRoaXMuYmluZEFsbCgpO1xuICAgIH1cblxuICAgIC8vIFJlLWluaXRpYWxpemUgZm9yIGR5bmFtaWNhbGx5IGFkZGVkIGNoaXBzXG4gICAgdGhpcy5vYnNlcnZlRE9NKCk7XG4gIH1cblxuICBiaW5kQWxsKCkge1xuICAgIHRoaXMuYmluZENsb3NlQnV0dG9ucygpO1xuICAgIHRoaXMuYmluZFNlbGVjdGFibGVDaGlwcygpO1xuICB9XG5cbiAgYmluZENsb3NlQnV0dG9ucygpIHtcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCdbZGF0YS1zby1jaGlwXSAuc28tY2hpcC1jbG9zZSwgW2RhdGEtc28tY2hpcC1jbG9zYWJsZV0gLnNvLWNoaXAtY2xvc2UnKS5mb3JFYWNoKGJ0biA9PiB7XG4gICAgICBpZiAoYnRuLl9zb0NoaXBCb3VuZCkgcmV0dXJuO1xuICAgICAgYnRuLl9zb0NoaXBCb3VuZCA9IHRydWU7XG5cbiAgICAgIGJ0bi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB7XG4gICAgICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgIGNvbnN0IGNoaXAgPSBidG4uY2xvc2VzdCgnLnNvLWNoaXAsIFtkYXRhLXNvLWNoaXBdJyk7XG4gICAgICAgIGlmIChjaGlwKSB7XG4gICAgICAgICAgLy8gRGlzcGF0Y2ggY3VzdG9tIGV2ZW50IGJlZm9yZSByZW1vdmFsXG4gICAgICAgICAgY29uc3QgZXZlbnQgPSBuZXcgQ3VzdG9tRXZlbnQoJ3NvLWNoaXA6Y2xvc2UnLCB7XG4gICAgICAgICAgICBidWJibGVzOiB0cnVlLFxuICAgICAgICAgICAgY2FuY2VsYWJsZTogdHJ1ZSxcbiAgICAgICAgICAgIGRldGFpbDoge1xuICAgICAgICAgICAgICBjaGlwLFxuICAgICAgICAgICAgICB2YWx1ZTogY2hpcC5kYXRhc2V0LnZhbHVlIHx8IGNoaXAudGV4dENvbnRlbnQudHJpbSgpXG4gICAgICAgICAgICB9XG4gICAgICAgICAgfSk7XG5cbiAgICAgICAgICBjb25zdCBzaG91bGRSZW1vdmUgPSBjaGlwLmRpc3BhdGNoRXZlbnQoZXZlbnQpO1xuXG4gICAgICAgICAgaWYgKHNob3VsZFJlbW92ZSkge1xuICAgICAgICAgICAgLy8gQW5pbWF0ZSBvdXQgYW5kIHJlbW92ZVxuICAgICAgICAgICAgY2hpcC5zdHlsZS50cmFuc2l0aW9uID0gJ29wYWNpdHkgMC4xNXMsIHRyYW5zZm9ybSAwLjE1cyc7XG4gICAgICAgICAgICBjaGlwLnN0eWxlLm9wYWNpdHkgPSAnMCc7XG4gICAgICAgICAgICBjaGlwLnN0eWxlLnRyYW5zZm9ybSA9ICdzY2FsZSgwLjgpJztcbiAgICAgICAgICAgIHNldFRpbWVvdXQoKCkgPT4gY2hpcC5yZW1vdmUoKSwgMTUwKTtcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH0pO1xuICAgIH0pO1xuICB9XG5cbiAgYmluZFNlbGVjdGFibGVDaGlwcygpIHtcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCdbZGF0YS1zby1jaGlwLXNlbGVjdGFibGVdLCAuc28tY2hpcC1zZWxlY3RhYmxlJykuZm9yRWFjaChjaGlwID0+IHtcbiAgICAgIGlmIChjaGlwLl9zb0NoaXBCb3VuZCkgcmV0dXJuO1xuICAgICAgY2hpcC5fc29DaGlwQm91bmQgPSB0cnVlO1xuXG4gICAgICBjaGlwLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgLy8gRG9uJ3QgdG9nZ2xlIGlmIGNsaWNraW5nIG9uIGNsb3NlIGJ1dHRvblxuICAgICAgICBpZiAoZS50YXJnZXQuY2xvc2VzdCgnLnNvLWNoaXAtY2xvc2UnKSkgcmV0dXJuO1xuXG4gICAgICAgIGNvbnN0IGlzU2VsZWN0ZWQgPSBjaGlwLmNsYXNzTGlzdC50b2dnbGUoJ3NvLWNoaXAtc2VsZWN0ZWQnKTtcblxuICAgICAgICAvLyBVcGRhdGUgaGlkZGVuIGNoZWNrYm94IGlmIHByZXNlbnRcbiAgICAgICAgY29uc3QgY2hlY2tib3ggPSBjaGlwLnF1ZXJ5U2VsZWN0b3IoJ2lucHV0W3R5cGU9XCJjaGVja2JveFwiXScpO1xuICAgICAgICBpZiAoY2hlY2tib3gpIHtcbiAgICAgICAgICBjaGVja2JveC5jaGVja2VkID0gaXNTZWxlY3RlZDtcbiAgICAgICAgfVxuXG4gICAgICAgIC8vIERpc3BhdGNoIGN1c3RvbSBldmVudFxuICAgICAgICBjb25zdCBldmVudE5hbWUgPSBpc1NlbGVjdGVkID8gJ3NvLWNoaXA6c2VsZWN0JyA6ICdzby1jaGlwOmRlc2VsZWN0JztcbiAgICAgICAgY29uc3QgZXZlbnQgPSBuZXcgQ3VzdG9tRXZlbnQoZXZlbnROYW1lLCB7XG4gICAgICAgICAgYnViYmxlczogdHJ1ZSxcbiAgICAgICAgICBkZXRhaWw6IHtcbiAgICAgICAgICAgIGNoaXAsXG4gICAgICAgICAgICB2YWx1ZTogY2hpcC5kYXRhc2V0LnZhbHVlIHx8IGNoaXAudGV4dENvbnRlbnQudHJpbSgpLFxuICAgICAgICAgICAgc2VsZWN0ZWQ6IGlzU2VsZWN0ZWRcbiAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgICAgICBjaGlwLmRpc3BhdGNoRXZlbnQoZXZlbnQpO1xuICAgICAgfSk7XG4gICAgfSk7XG4gIH1cblxuICBvYnNlcnZlRE9NKCkge1xuICAgIGNvbnN0IG9ic2VydmVyID0gbmV3IE11dGF0aW9uT2JzZXJ2ZXIoKG11dGF0aW9ucykgPT4ge1xuICAgICAgbGV0IHNob3VsZFJlYmluZCA9IGZhbHNlO1xuXG4gICAgICBtdXRhdGlvbnMuZm9yRWFjaCgobXV0YXRpb24pID0+IHtcbiAgICAgICAgaWYgKG11dGF0aW9uLmFkZGVkTm9kZXMubGVuZ3RoKSB7XG4gICAgICAgICAgbXV0YXRpb24uYWRkZWROb2Rlcy5mb3JFYWNoKChub2RlKSA9PiB7XG4gICAgICAgICAgICBpZiAobm9kZS5ub2RlVHlwZSA9PT0gMSkge1xuICAgICAgICAgICAgICAvLyBDaGVjayBpZiB0aGUgbm9kZSBpcyBhIGNoaXAgb3IgY29udGFpbnMgY2hpcHNcbiAgICAgICAgICAgICAgaWYgKG5vZGUubWF0Y2hlcyAmJiAoXG4gICAgICAgICAgICAgICAgbm9kZS5tYXRjaGVzKCdbZGF0YS1zby1jaGlwXSwgW2RhdGEtc28tY2hpcC1jbG9zYWJsZV0sIFtkYXRhLXNvLWNoaXAtc2VsZWN0YWJsZV0sIC5zby1jaGlwLXNlbGVjdGFibGUnKSB8fFxuICAgICAgICAgICAgICAgIG5vZGUucXVlcnlTZWxlY3RvcignW2RhdGEtc28tY2hpcF0sIFtkYXRhLXNvLWNoaXAtY2xvc2FibGVdLCBbZGF0YS1zby1jaGlwLXNlbGVjdGFibGVdLCAuc28tY2hpcC1zZWxlY3RhYmxlJylcbiAgICAgICAgICAgICAgKSkge1xuICAgICAgICAgICAgICAgIHNob3VsZFJlYmluZCA9IHRydWU7XG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgICAgfSk7XG5cbiAgICAgIGlmIChzaG91bGRSZWJpbmQpIHtcbiAgICAgICAgdGhpcy5iaW5kQWxsKCk7XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICBvYnNlcnZlci5vYnNlcnZlKGRvY3VtZW50LmJvZHksIHsgY2hpbGRMaXN0OiB0cnVlLCBzdWJ0cmVlOiB0cnVlIH0pO1xuICB9XG5cbiAgLyoqXG4gICAqIE1hbnVhbGx5IGNsb3NlIGEgY2hpcFxuICAgKiBAcGFyYW0ge0hUTUxFbGVtZW50fSBjaGlwIC0gVGhlIGNoaXAgZWxlbWVudCB0byBjbG9zZVxuICAgKi9cbiAgY2xvc2UoY2hpcCkge1xuICAgIGlmIChjaGlwKSB7XG4gICAgICBjb25zdCBjbG9zZUJ0biA9IGNoaXAucXVlcnlTZWxlY3RvcignLnNvLWNoaXAtY2xvc2UnKTtcbiAgICAgIGlmIChjbG9zZUJ0bikge1xuICAgICAgICBjbG9zZUJ0bi5jbGljaygpO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgLy8gRGlzcGF0Y2ggZXZlbnQgYW5kIHJlbW92ZVxuICAgICAgICBjb25zdCBldmVudCA9IG5ldyBDdXN0b21FdmVudCgnc28tY2hpcDpjbG9zZScsIHtcbiAgICAgICAgICBidWJibGVzOiB0cnVlLFxuICAgICAgICAgIGRldGFpbDogeyBjaGlwLCB2YWx1ZTogY2hpcC5kYXRhc2V0LnZhbHVlIHx8IGNoaXAudGV4dENvbnRlbnQudHJpbSgpIH1cbiAgICAgICAgfSk7XG4gICAgICAgIGNoaXAuZGlzcGF0Y2hFdmVudChldmVudCk7XG4gICAgICAgIGNoaXAucmVtb3ZlKCk7XG4gICAgICB9XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIFRvZ2dsZSBzZWxlY3Rpb24gc3RhdGUgb2YgYSBjaGlwXG4gICAqIEBwYXJhbSB7SFRNTEVsZW1lbnR9IGNoaXAgLSBUaGUgY2hpcCBlbGVtZW50IHRvIHRvZ2dsZVxuICAgKiBAcGFyYW0ge2Jvb2xlYW59IFtzZWxlY3RlZF0gLSBPcHRpb25hbCBleHBsaWNpdCBzdGF0ZVxuICAgKi9cbiAgdG9nZ2xlKGNoaXAsIHNlbGVjdGVkKSB7XG4gICAgaWYgKGNoaXApIHtcbiAgICAgIGlmICh0eXBlb2Ygc2VsZWN0ZWQgPT09ICdib29sZWFuJykge1xuICAgICAgICBjaGlwLmNsYXNzTGlzdC50b2dnbGUoJ3NvLWNoaXAtc2VsZWN0ZWQnLCBzZWxlY3RlZCk7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICBjaGlwLmNsYXNzTGlzdC50b2dnbGUoJ3NvLWNoaXAtc2VsZWN0ZWQnKTtcbiAgICAgIH1cblxuICAgICAgY29uc3QgaXNTZWxlY3RlZCA9IGNoaXAuY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1jaGlwLXNlbGVjdGVkJyk7XG4gICAgICBjb25zdCBjaGVja2JveCA9IGNoaXAucXVlcnlTZWxlY3RvcignaW5wdXRbdHlwZT1cImNoZWNrYm94XCJdJyk7XG4gICAgICBpZiAoY2hlY2tib3gpIHtcbiAgICAgICAgY2hlY2tib3guY2hlY2tlZCA9IGlzU2VsZWN0ZWQ7XG4gICAgICB9XG5cbiAgICAgIGNvbnN0IGV2ZW50TmFtZSA9IGlzU2VsZWN0ZWQgPyAnc28tY2hpcDpzZWxlY3QnIDogJ3NvLWNoaXA6ZGVzZWxlY3QnO1xuICAgICAgY29uc3QgZXZlbnQgPSBuZXcgQ3VzdG9tRXZlbnQoZXZlbnROYW1lLCB7XG4gICAgICAgIGJ1YmJsZXM6IHRydWUsXG4gICAgICAgIGRldGFpbDogeyBjaGlwLCB2YWx1ZTogY2hpcC5kYXRhc2V0LnZhbHVlIHx8IGNoaXAudGV4dENvbnRlbnQudHJpbSgpLCBzZWxlY3RlZDogaXNTZWxlY3RlZCB9XG4gICAgICB9KTtcbiAgICAgIGNoaXAuZGlzcGF0Y2hFdmVudChldmVudCk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIEdldCBhbGwgc2VsZWN0ZWQgY2hpcHMgd2l0aGluIGEgY29udGFpbmVyXG4gICAqIEBwYXJhbSB7SFRNTEVsZW1lbnR9IFtjb250YWluZXI9ZG9jdW1lbnRdIC0gQ29udGFpbmVyIHRvIHNlYXJjaCB3aXRoaW5cbiAgICogQHJldHVybnMge0FycmF5fSBBcnJheSBvZiBzZWxlY3RlZCBjaGlwIGVsZW1lbnRzXG4gICAqL1xuICBnZXRTZWxlY3RlZChjb250YWluZXIgPSBkb2N1bWVudCkge1xuICAgIHJldHVybiBBcnJheS5mcm9tKGNvbnRhaW5lci5xdWVyeVNlbGVjdG9yQWxsKCcuc28tY2hpcC1zZWxlY3RlZCcpKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgdmFsdWVzIG9mIGFsbCBzZWxlY3RlZCBjaGlwcyB3aXRoaW4gYSBjb250YWluZXJcbiAgICogQHBhcmFtIHtIVE1MRWxlbWVudH0gW2NvbnRhaW5lcj1kb2N1bWVudF0gLSBDb250YWluZXIgdG8gc2VhcmNoIHdpdGhpblxuICAgKiBAcmV0dXJucyB7QXJyYXl9IEFycmF5IG9mIGNoaXAgdmFsdWVzXG4gICAqL1xuICBnZXRTZWxlY3RlZFZhbHVlcyhjb250YWluZXIgPSBkb2N1bWVudCkge1xuICAgIHJldHVybiB0aGlzLmdldFNlbGVjdGVkKGNvbnRhaW5lcikubWFwKGNoaXAgPT5cbiAgICAgIGNoaXAuZGF0YXNldC52YWx1ZSB8fCBjaGlwLnRleHRDb250ZW50LnRyaW0oKVxuICAgICk7XG4gIH1cbn1cblxuLy8gQXV0by1pbml0aWFsaXplIGFuZCBleHBvc2UgZ2xvYmFsbHlcbmNvbnN0IHNvQ2hpcHMgPSBuZXcgU09DaGlwcygpO1xud2luZG93LlNPQ2hpcHMgPSBzb0NoaXBzO1xuXG5leHBvcnQgZGVmYXVsdCBzb0NoaXBzO1xuIiwgIi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4vLyBTSVhPUkJJVCBVSSAtIENPUkUgSkFWQVNDUklQVFxuLy8gRXNzZW50aWFsIGNvbXBvbmVudHMgZm9yIGJhc2ljIGZ1bmN0aW9uYWxpdHlcbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbi8vIENvcmUgbW9kdWxlc1xuaW1wb3J0ICcuL2NvcmUvc28tY29uZmlnLmpzJztcbmltcG9ydCAnLi9jb3JlL3NvLWNvbXBvbmVudC5qcyc7XG5cbi8vIENvcmUgY29tcG9uZW50c1xuaW1wb3J0ICcuL2NvbXBvbmVudHMvc28tdGhlbWUuanMnO1xuaW1wb3J0ICcuL2NvbXBvbmVudHMvc28tZHJvcGRvd24uanMnO1xuaW1wb3J0ICcuL2NvbXBvbmVudHMvc28tbGF5b3V0LmpzJztcbmltcG9ydCAnLi9jb21wb25lbnRzL3NvLW1vZGFsLmpzJztcbmltcG9ydCAnLi9jb21wb25lbnRzL3NvLXJpcHBsZS5qcyc7XG5pbXBvcnQgJy4vY29tcG9uZW50cy9zby1jb250ZXh0LW1lbnUuanMnO1xuXG4vLyBDb3JlIGZlYXR1cmVzXG5pbXBvcnQgJy4vZmVhdHVyZXMvc28tZm9ybXMuanMnO1xuaW1wb3J0ICcuL2ZlYXR1cmVzL3NvLWNoaXBzLmpzJztcblxuLy8gQXV0by1pbml0aWFsaXplIGNvcmUgY29tcG9uZW50cyB3aGVuIERPTSBpcyByZWFkeVxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignRE9NQ29udGVudExvYWRlZCcsICgpID0+IHtcbiAgLy8gTm90ZTogU2lkZWJhciBpbml0aWFsaXphdGlvbiBtb3ZlZCB0byBzcmMvcGFnZXMvZ2xvYmFsL2dsb2JhbC5qc1xuXG4gIC8vIEluaXRpYWxpemUgbmF2YmFyIGlmIHByZXNlbnRcbiAgY29uc3QgbmF2YmFyID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLnNvLW5hdmJhcicpO1xuICBpZiAobmF2YmFyKSB7XG4gICAgU09OYXZiYXIuZ2V0SW5zdGFuY2UobmF2YmFyKTtcbiAgfVxuXG4gIC8vIEluaXRpYWxpemUgdGhlbWUgY29udHJvbGxlciBpZiBzZXR0aW5ncyBleGlzdFxuICBjb25zdCB0aGVtZVNldHRpbmdzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLnNvLW5hdmJhci10aGVtZScpO1xuICBpZiAodGhlbWVTZXR0aW5ncykge1xuICAgIFNPVGhlbWUuZ2V0SW5zdGFuY2UodGhlbWVTZXR0aW5ncyk7XG4gIH1cblxuICAvLyBJbml0aWFsaXplIGZvcm1zXG4gIFNPRm9ybXMuaW5pdEFsbCgpO1xuXG4gIGNvbnNvbGUubG9nKCdTaXhPcmJpdCBVSSBDb3JlIGluaXRpYWxpemVkJyk7XG59KTtcbiJdLAogICJtYXBwaW5ncyI6ICI7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBU0EsTUFBTSxXQUFXO0FBQUE7QUFBQTtBQUFBLEVBR2pCO0FBR0EsU0FBTyxXQUFXO0FBR2xCLFNBQU8sT0FBTyxVQUFVO0FBQUE7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QTtBQUFBO0FBQUE7QUFBQSxJQU9BLFlBQVksWUFBWSxVQUFVO0FBQ2hDLGFBQU8sTUFBTSxLQUFLLFVBQVUsaUJBQWlCLG1CQUFtQixDQUFDO0FBQUEsSUFDbkU7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUEsSUFPQSxrQkFBa0IsWUFBWSxVQUFVO0FBQ3RDLGFBQU8sS0FBSyxZQUFZLFNBQVMsRUFBRTtBQUFBLFFBQUksVUFDckMsS0FBSyxRQUFRLFNBQVMsS0FBSyxZQUFZLEtBQUs7QUFBQSxNQUM5QztBQUFBLElBQ0Y7QUFBQSxFQUNGO0FBR0EsTUFBTSxVQUFVLElBQUksUUFBUTtBQUM1QixTQUFPLFVBQVU7OztBQzVLakIsV0FBUyxpQkFBaUIsb0JBQW9CLE1BQU07QUFJbEQsVUFBTSxTQUFTLFNBQVMsY0FBYyxZQUFZO0FBQ2xELFFBQUksUUFBUTtBQUNWLGVBQVMsWUFBWSxNQUFNO0FBQUEsSUFDN0I7QUFHQSxVQUFNLGdCQUFnQixTQUFTLGNBQWMsa0JBQWtCO0FBQy9ELFFBQUksZUFBZTtBQUNqQixjQUFRLFlBQVksYUFBYTtBQUFBLElBQ25DO0FBR0EsWUFBUSxRQUFRO0FBRWhCLFlBQVEsSUFBSSw4QkFBOEI7QUFBQSxFQUM1QyxDQUFDOyIsCiAgIm5hbWVzIjogWyJTT1RoZW1lIiwgIlNPTmF2YmFyIiwgImNvbnRlbnQiLCAiYnRuQ2xhc3MiLCAiU09Gb3JtcyJdCn0K
