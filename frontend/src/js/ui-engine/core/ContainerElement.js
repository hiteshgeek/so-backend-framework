// ============================================
// SIXORBIT UI ENGINE - CONTAINER ELEMENT CLASS
// Foundation for container elements
// ============================================

import { Element } from './Element.js';

/**
 * ContainerElement - Base class for container elements
 * Extends Element with children management
 */
class ContainerElement extends Element {
    static NAME = 'ui-container';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'container',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        // Process children from config
        if (config.children && Array.isArray(config.children)) {
            config.children.forEach(childConfig => {
                if (childConfig instanceof Element) {
                    this._children.push(childConfig);
                } else if (typeof childConfig === 'object') {
                    // Import UiEngine lazily to avoid circular dependency
                    const child = this._createChildFromConfig(childConfig);
                    if (child) {
                        this._children.push(child);
                    }
                }
            });
        }
    }

    /**
     * Create child element from config
     * @param {Object} config
     * @returns {Element|null}
     * @protected
     */
    _createChildFromConfig(config) {
        // This will be overridden when UiEngine is available
        // For now, just store the config
        return config;
    }

    // ==================
    // Children Management
    // ==================

    /**
     * Get all children
     * @returns {Array}
     */
    getChildren() {
        return [...this._children];
    }

    /**
     * Add a child element
     * @param {Element|Object} element
     * @returns {this}
     */
    add(element) {
        if (element instanceof Element) {
            this._children.push(element);
        } else if (typeof element === 'object') {
            const child = this._createChildFromConfig(element);
            if (child) {
                this._children.push(child);
            }
        }
        return this;
    }

    /**
     * Add multiple children
     * @param {Array} elements
     * @returns {this}
     */
    addMany(elements) {
        elements.forEach(el => this.add(el));
        return this;
    }

    /**
     * Prepend a child
     * @param {Element|Object} element
     * @returns {this}
     */
    prepend(element) {
        if (element instanceof Element) {
            this._children.unshift(element);
        } else if (typeof element === 'object') {
            const child = this._createChildFromConfig(element);
            if (child) {
                this._children.unshift(child);
            }
        }
        return this;
    }

    /**
     * Insert at specific index
     * @param {number} index
     * @param {Element|Object} element
     * @returns {this}
     */
    insertAt(index, element) {
        let child = element;
        if (!(element instanceof Element) && typeof element === 'object') {
            child = this._createChildFromConfig(element);
        }
        if (child) {
            this._children.splice(index, 0, child);
        }
        return this;
    }

    /**
     * Remove a child
     * @param {Element|string} element - Element or ID
     * @returns {this}
     */
    remove(element) {
        if (typeof element === 'string') {
            // Remove by ID
            this._children = this._children.filter(child =>
                !(child instanceof Element) || child.getId() !== element
            );
        } else {
            // Remove by instance
            this._children = this._children.filter(child => child !== element);
        }
        return this;
    }

    /**
     * Remove child at index
     * @param {number} index
     * @returns {this}
     */
    removeAt(index) {
        this._children.splice(index, 1);
        return this;
    }

    /**
     * Check if has children
     * @returns {boolean}
     */
    hasChildren() {
        return this._children.length > 0;
    }

    /**
     * Get child count
     * @returns {number}
     */
    count() {
        return this._children.length;
    }

    /**
     * Clear all children
     * @returns {this}
     */
    clear() {
        this._children = [];
        return this;
    }

    /**
     * Find child by ID
     * @param {string} id
     * @returns {Element|null}
     */
    find(id) {
        for (const child of this._children) {
            if (child instanceof Element) {
                if (child.getId() === id) {
                    return child;
                }
                // Recursive search
                if (child instanceof ContainerElement) {
                    const found = child.find(id);
                    if (found) return found;
                }
            }
        }
        return null;
    }

    /**
     * Find all matching a callback
     * @param {Function} callback
     * @returns {Array}
     */
    findAll(callback) {
        const found = [];

        for (const child of this._children) {
            if (child instanceof Element) {
                if (callback(child)) {
                    found.push(child);
                }
                // Recursive search
                if (child instanceof ContainerElement) {
                    found.push(...child.findAll(callback));
                }
            }
        }

        return found;
    }

    /**
     * Find first matching callback
     * @param {Function} callback
     * @returns {Element|null}
     */
    findFirst(callback) {
        for (const child of this._children) {
            if (child instanceof Element) {
                if (callback(child)) {
                    return child;
                }
                if (child instanceof ContainerElement) {
                    const found = child.findFirst(callback);
                    if (found) return found;
                }
            }
        }
        return null;
    }

    /**
     * Find by name (for form elements)
     * @param {string} name
     * @returns {Element|null}
     */
    findByName(name) {
        return this.findFirst(el =>
            typeof el.getName === 'function' && el.getName() === name
        );
    }

    /**
     * Get all form elements
     * @returns {Array}
     */
    getFormElements() {
        return this.findAll(el => typeof el.getName === 'function');
    }

    /**
     * Get child at index
     * @param {number} index
     * @returns {Element|null}
     */
    getChildAt(index) {
        return this._children[index] || null;
    }

    /**
     * Get first child
     * @returns {Element|null}
     */
    first() {
        return this._children[0] || null;
    }

    /**
     * Get last child
     * @returns {Element|null}
     */
    last() {
        return this._children[this._children.length - 1] || null;
    }

    /**
     * Map over children
     * @param {Function} callback
     * @returns {Array}
     */
    map(callback) {
        return this._children.map(callback);
    }

    /**
     * Execute for each child
     * @param {Function} callback
     * @returns {this}
     */
    each(callback) {
        this._children.forEach(callback);
        return this;
    }

    /**
     * Filter children
     * @param {Function} callback
     * @returns {this}
     */
    filter(callback) {
        this._children = this._children.filter(callback);
        return this;
    }

    // ==================
    // Data Operations
    // ==================

    /**
     * Fill form elements with data
     * @param {Object} data
     * @returns {this}
     */
    fill(data) {
        this.getFormElements().forEach(element => {
            const name = element.getName();
            if (name && data.hasOwnProperty(name)) {
                element.setValue(data[name]);
            }
        });
        return this;
    }

    /**
     * Set errors on form elements
     * @param {Object} errors
     * @returns {this}
     */
    setErrors(errors) {
        this.getFormElements().forEach(element => {
            const name = element.getName();
            if (name && errors[name]) {
                const error = Array.isArray(errors[name]) ? errors[name][0] : errors[name];
                element.setError(error);
            }
        });
        return this;
    }

    /**
     * Clear all errors
     * @returns {this}
     */
    clearErrors() {
        this.getFormElements().forEach(element => {
            if (typeof element.clearError === 'function') {
                element.clearError();
            }
        });
        return this;
    }

    /**
     * Get values from all form elements
     * @returns {Object}
     */
    getValues() {
        const values = {};
        this.getFormElements().forEach(element => {
            const name = element.getName();
            if (name) {
                values[name] = element.getValue();
            }
        });
        return values;
    }

    /**
     * Export validation rules
     * @returns {Object}
     */
    exportValidation() {
        const rules = {};
        this.getFormElements().forEach(element => {
            const name = element.getName();
            if (name && typeof element.hasRules === 'function' && element.hasRules()) {
                rules[name] = element.exportValidation();
            }
        });
        return rules;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Render children
     * @returns {DocumentFragment}
     */
    renderChildren() {
        const fragment = document.createDocumentFragment();

        this._children.forEach(child => {
            if (child instanceof Element) {
                fragment.appendChild(child.render());
            } else if (child instanceof HTMLElement) {
                fragment.appendChild(child);
            } else if (typeof child === 'string') {
                fragment.appendChild(document.createTextNode(child));
            } else if (typeof child === 'object' && child.type) {
                // Config object - try to render via UiEngine if available
                if (window.UiEngine) {
                    const element = window.UiEngine.fromConfig(child);
                    fragment.appendChild(element.render());
                }
            }
        });

        return fragment;
    }

    /**
     * Render content (children HTML)
     * @returns {string}
     */
    renderContent() {
        let html = super.renderContent();

        this._children.forEach(child => {
            if (child instanceof Element) {
                html += child.toHtml();
            } else if (typeof child === 'string') {
                html += this._escapeHtml(child);
            } else if (typeof child === 'object' && child.type) {
                // Config object - render via UiEngine if available
                if (window.UiEngine) {
                    const element = window.UiEngine.fromConfig(child);
                    html += element.toHtml();
                }
            }
        });

        return html;
    }

    /**
     * Render to DOM
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

        // Content
        if (this._content) {
            el.appendChild(document.createTextNode(this._content));
        }

        // Children
        el.appendChild(this.renderChildren());

        this.element = el;
        return el;
    }

    // ==================
    // Config Export
    // ==================

    /**
     * Convert to config
     * @returns {Object}
     */
    toConfig() {
        const config = super.toConfig();

        if (this._children.length > 0) {
            config.children = this._children.map(child => {
                if (child instanceof Element) {
                    return child.toConfig();
                }
                return child;
            });
        }

        return config;
    }
}

export default ContainerElement;
export { ContainerElement };
