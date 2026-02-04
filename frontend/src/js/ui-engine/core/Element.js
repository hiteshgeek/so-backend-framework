// ============================================
// SIXORBIT UI ENGINE - ELEMENT BASE CLASS
// Foundation for all UI Engine elements
// ============================================

import SOComponent from '../../core/so-component.js';
import SixOrbit from '../../core/so-config.js';

/**
 * Element - Base class for all UI Engine elements
 * Extends SOComponent with config-based creation and rendering
 */
class Element extends SOComponent {
    static NAME = 'ui-element';

    static DEFAULTS = {
        type: 'element',
        tagName: 'div',
        renderMode: 'dom', // 'dom' | 'html'
    };

    /**
     * Create a new Element
     * @param {Element|Object} elementOrConfig - DOM element or config object
     * @param {Object} [options={}] - Additional options
     */
    constructor(elementOrConfig, options = {}) {
        // If first arg is config (no DOM element), we're creating from config
        if (elementOrConfig && typeof elementOrConfig === 'object' && !elementOrConfig.nodeType) {
            // Config mode - create element later
            const config = elementOrConfig;
            super(null, {}); // Skip SOComponent element validation

            this.element = null;
            this._config = config;
            this._initFromConfig(config);
        } else {
            // Normal SOComponent mode - element exists
            super(elementOrConfig, options);
            this._config = options;
        }

        // Additional properties
        this._extraClasses = new Set();
        this._extraAttributes = new Map();
        this._dataAttributes = new Map();
        this._children = [];
    }

    /**
     * Initialize from config object
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        this.options = { ...this.constructor.DEFAULTS, ...config };

        // Type and tag
        this._type = config.type || 'element';
        this._tagName = config.tagName || 'div';
        this._id = config.id || null;
        this._content = config.content || null;

        // Classes
        if (config.class) {
            const classes = Array.isArray(config.class)
                ? config.class
                : String(config.class).split(/\s+/);
            classes.forEach(cls => this._extraClasses.add(cls));
        }

        // Attributes
        if (config.attributes) {
            Object.entries(config.attributes).forEach(([key, value]) => {
                this._extraAttributes.set(key, value);
            });
        }

        // Data attributes
        if (config.data) {
            Object.entries(config.data).forEach(([key, value]) => {
                this._dataAttributes.set(key, value);
            });
        }
    }

    /**
     * Factory method to create from config
     * @param {Object} config
     * @returns {Element}
     */
    static make(config = {}) {
        return new this(config);
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set element ID
     * @param {string} id
     * @returns {this}
     */
    setId(id) {
        this._id = id;
        if (this.element) {
            this.element.id = id;
        }
        return this;
    }

    /**
     * Get element ID
     * @returns {string|null}
     */
    getId() {
        return this._id;
    }

    /**
     * Set element ID (alias for setId)
     * @param {string} id
     * @returns {this}
     */
    id(id) {
        return this.setId(id);
    }

    /**
     * Add CSS class
     * @param {string} className
     * @returns {this}
     */
    setClass(className) {
        const classes = String(className).split(/\s+/);
        classes.forEach(cls => {
            if (cls) this._extraClasses.add(cls);
        });
        if (this.element) {
            this.element.classList.add(...classes.filter(Boolean));
        }
        return this;
    }

    /**
     * Remove CSS class
     * @param {string} className
     * @returns {this}
     */
    unsetClass(className) {
        const classes = String(className).split(/\s+/);
        classes.forEach(cls => this._extraClasses.delete(cls));
        if (this.element) {
            this.element.classList.remove(...classes);
        }
        return this;
    }

    /**
     * Set HTML attribute
     * @param {string} name
     * @param {*} value
     * @returns {this}
     */
    setAttr(name, value) {
        this._extraAttributes.set(name, value);
        if (this.element) {
            if (value === true) {
                this.element.setAttribute(name, '');
            } else if (value !== false && value !== null) {
                this.element.setAttribute(name, value);
            }
        }
        return this;
    }

    /**
     * Get HTML attribute
     * @param {string} name
     * @returns {*}
     */
    getAttr(name) {
        return this._extraAttributes.get(name) ??
               (this.element ? this.element.getAttribute(name) : null);
    }

    /**
     * Remove HTML attribute
     * @param {string} name
     * @returns {this}
     */
    removeAttr(name) {
        this._extraAttributes.delete(name);
        if (this.element) {
            this.element.removeAttribute(name);
        }
        return this;
    }

    /**
     * Set data attribute
     * @param {string} name - Without data- prefix
     * @param {*} value
     * @returns {this}
     */
    setDataAttr(name, value) {
        this._dataAttributes.set(name, value);
        if (this.element) {
            this.element.dataset[this._camelCase(name)] = value;
        }
        return this;
    }

    /**
     * Get data attribute
     * @param {string} name
     * @returns {*}
     */
    getDataAttr(name) {
        return this._dataAttributes.get(name) ??
               (this.element ? this.element.dataset[this._camelCase(name)] : null);
    }

    /**
     * Set text content
     * @param {string} content
     * @returns {this}
     */
    setContent(content) {
        this._content = content;
        if (this.element) {
            this.element.textContent = content;
        }
        return this;
    }

    /**
     * Conditional fluent method
     * @param {boolean} condition
     * @param {Function} callback
     * @param {Function} [fallback]
     * @returns {this}
     */
    when(condition, callback, fallback = null) {
        if (condition) {
            callback(this);
        } else if (fallback) {
            fallback(this);
        }
        return this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Get the HTML tag name
     * @returns {string}
     */
    getTagName() {
        return this._tagName || 'div';
    }

    /**
     * Get element type
     * @returns {string}
     */
    getType() {
        return this._type || 'element';
    }

    /**
     * Check if element is self-closing
     * @returns {boolean}
     */
    isSelfClosing() {
        const voidElements = [
            'area', 'base', 'br', 'col', 'embed', 'hr', 'img',
            'input', 'link', 'meta', 'param', 'source', 'track', 'wbr'
        ];
        return voidElements.includes(this.getTagName());
    }

    /**
     * Build CSS class string
     * @returns {string}
     */
    buildClassString() {
        return Array.from(this._extraClasses).join(' ');
    }

    /**
     * Build attributes object
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = {};

        // ID
        if (this._id) {
            attrs.id = this._id;
        }

        // Classes
        const classString = this.buildClassString();
        if (classString) {
            attrs.class = classString;
        }

        // Regular attributes
        this._extraAttributes.forEach((value, key) => {
            attrs[key] = value;
        });

        // Data attributes
        this._dataAttributes.forEach((value, key) => {
            attrs[`data-${this._kebabCase(key)}`] = value;
        });

        return attrs;
    }

    /**
     * Build attributes string for HTML
     * @returns {string}
     */
    buildAttributeString() {
        const attrs = this.buildAttributes();
        const parts = [];

        Object.entries(attrs).forEach(([name, value]) => {
            if (value === false || value === null || value === undefined) {
                return;
            }
            if (value === true) {
                parts.push(this._escapeHtml(name));
            } else {
                parts.push(`${this._escapeHtml(name)}="${this._escapeHtml(String(value))}"`);
            }
        });

        return parts.join(' ');
    }

    /**
     * Render content inside the element
     * @returns {string}
     */
    renderContent() {
        let html = '';

        if (this._content) {
            html += this._escapeHtml(this._content);
        }

        // Render children
        this._children.forEach(child => {
            if (child instanceof Element) {
                html += child.toHtml();
            } else if (typeof child === 'string') {
                html += this._escapeHtml(child);
            }
        });

        return html;
    }

    /**
     * Render to DOM element
     * @returns {HTMLElement}
     */
    render() {
        const el = document.createElement(this.getTagName());

        // Apply attributes
        const attrs = this.buildAttributes();
        Object.entries(attrs).forEach(([name, value]) => {
            if (value === true) {
                el.setAttribute(name, '');
            } else if (value !== false && value !== null && value !== undefined) {
                el.setAttribute(name, value);
            }
        });

        // Apply content
        if (!this.isSelfClosing()) {
            // Text content
            if (this._content) {
                el.textContent = this._content;
            }

            // Children
            this._children.forEach(child => {
                if (child instanceof Element) {
                    el.appendChild(child.render());
                } else if (child instanceof HTMLElement) {
                    el.appendChild(child);
                } else if (typeof child === 'string') {
                    el.appendChild(document.createTextNode(child));
                }
            });
        }

        this.element = el;
        return el;
    }

    /**
     * Render to HTML string
     * @returns {string}
     */
    toHtml() {
        const tag = this.getTagName();
        const attrs = this.buildAttributeString();
        const attrStr = attrs ? ` ${attrs}` : '';

        if (this.isSelfClosing()) {
            return `<${tag}${attrStr}>`;
        }

        return `<${tag}${attrStr}>${this.renderContent()}</${tag}>`;
    }

    /**
     * Append to a container
     * @param {Element|HTMLElement|string} container
     * @returns {this}
     */
    appendTo(container) {
        const target = typeof container === 'string'
            ? document.querySelector(container)
            : (container instanceof Element ? container.element : container);

        if (target) {
            target.appendChild(this.render());
        }
        return this;
    }

    /**
     * Prepend to a container
     * @param {Element|HTMLElement|string} container
     * @returns {this}
     */
    prependTo(container) {
        const target = typeof container === 'string'
            ? document.querySelector(container)
            : (container instanceof Element ? container.element : container);

        if (target) {
            target.insertBefore(this.render(), target.firstChild);
        }
        return this;
    }

    // ==================
    // Config Export
    // ==================

    /**
     * Convert to config object
     * @returns {Object}
     */
    toConfig() {
        const config = {
            type: this.getType(),
        };

        if (this._id) config.id = this._id;
        if (this._extraClasses.size > 0) config.class = Array.from(this._extraClasses);
        if (this._extraAttributes.size > 0) config.attributes = Object.fromEntries(this._extraAttributes);
        if (this._dataAttributes.size > 0) config.data = Object.fromEntries(this._dataAttributes);
        if (this._content) config.content = this._content;
        if (this._children.length > 0) {
            config.children = this._children.map(child =>
                child instanceof Element ? child.toConfig() : child
            );
        }

        return config;
    }

    /**
     * Convert to JSON string
     * @param {number} [indent]
     * @returns {string}
     */
    toJson(indent = 0) {
        return JSON.stringify(this.toConfig(), null, indent);
    }

    // ==================
    // Utility Methods
    // ==================

    /**
     * Convert to camelCase
     * @param {string} str
     * @returns {string}
     * @private
     */
    _camelCase(str) {
        return str.replace(/-([a-z])/g, (_, letter) => letter.toUpperCase());
    }

    /**
     * Convert to kebab-case
     * @param {string} str
     * @returns {string}
     * @private
     */
    _kebabCase(str) {
        return str.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
    }

    /**
     * Escape HTML special characters
     * @param {string} str
     * @returns {string}
     * @private
     */
    _escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        // innerHTML escapes <, >, & but not quotes
        // We need to also escape quotes for attribute values
        return div.innerHTML.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    /**
     * Dispatch custom event on the element
     * @param {string} eventName - Event name (e.g., 'so:progress:change')
     * @param {Object} detail - Event detail data
     * @private
     */
    _dispatchEvent(eventName, detail = {}) {
        if (this.element) {
            const event = new CustomEvent(eventName, {
                bubbles: true,
                cancelable: true,
                detail
            });
            this.element.dispatchEvent(event);
        }
    }

    /**
     * Clone the element
     * @returns {Element}
     */
    clone() {
        const config = this.toConfig();
        return this.constructor.make(config);
    }
}

export default Element;
export { Element };
