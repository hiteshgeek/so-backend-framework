// ============================================
// SIXORBIT UI ENGINE - HTML ELEMENT
// Generic HTML element for creating any tag
// ============================================

import { ContainerElement } from '../core/ContainerElement.js';

/**
 * Html - Generic HTML element
 */
class Html extends ContainerElement {
    static NAME = 'ui-html';

    static DEFAULTS = {
        ...ContainerElement.DEFAULTS,
        type: 'html',
        tag: 'div',
        textContent: null,
        innerHTML: null,
        selfClosing: false,
        href: null,
        target: null,
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._tag = config.tag || 'div';
        this._textContent = config.textContent ?? null;
        this._innerHTML = config.innerHTML ?? null;
        this._selfClosing = config.selfClosing ?? false;
        this._href = config.href ?? null;
        this._target = config.target ?? null;
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set HTML tag name
     * @param {string} tag
     * @returns {this}
     */
    tag(tag) {
        this._tag = tag;
        return this;
    }

    /**
     * Set text content (escaped)
     * @param {string} text
     * @returns {this}
     */
    text(text) {
        this._textContent = text;
        return this;
    }

    /**
     * Set innerHTML (raw HTML)
     * @param {string} html
     * @returns {this}
     */
    html(html) {
        this._innerHTML = html;
        return this;
    }

    /**
     * Set as self-closing tag
     * @param {boolean} selfClosing
     * @returns {this}
     */
    selfClosing(selfClosing = true) {
        this._selfClosing = selfClosing;
        return this;
    }

    /**
     * Set href attribute (for links)
     * @param {string} href
     * @returns {this}
     */
    href(href) {
        this._href = href;
        return this;
    }

    /**
     * Set target attribute (for links)
     * @param {string} target
     * @returns {this}
     */
    target(target) {
        this._target = target;
        return this;
    }

    /**
     * Open link in new tab
     * @returns {this}
     */
    newTab() {
        return this.target('_blank');
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Get tag name
     * @returns {string}
     */
    getTagName() {
        return this._tag;
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        if (this._href !== null) {
            attrs.href = this._href;
        }

        if (this._target !== null) {
            attrs.target = this._target;
        }

        return attrs;
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        let html = '';

        // Raw innerHTML takes precedence
        if (this._innerHTML !== null) {
            html += this._innerHTML;
        }
        // Then text content (escaped)
        else if (this._textContent !== null) {
            html += this._escapeHtml(String(this._textContent));
        }

        // Render children
        html += this.renderChildren();

        return html;
    }

    /**
     * Render to DOM
     * @returns {HTMLElement}
     */
    render() {
        // Self-closing tags
        if (this._selfClosing) {
            const el = document.createElement(this.getTagName());
            const attrs = this.buildAttributes();
            Object.entries(attrs).forEach(([name, value]) => {
                if (value === true) {
                    el.setAttribute(name, '');
                } else if (value !== false && value !== null && value !== undefined) {
                    el.setAttribute(name, value);
                }
            });
            this.element = el;
            return el;
        }

        // Create element
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

        // Handle content
        // Raw innerHTML takes precedence
        if (this._innerHTML !== null) {
            el.innerHTML = this._innerHTML;
        }
        // Then text content (escaped)
        else if (this._textContent !== null) {
            el.textContent = this._textContent;
        }

        // Render children (if using add() method)
        const childrenFragment = this.renderChildren();
        if (childrenFragment && childrenFragment.childNodes.length > 0) {
            el.appendChild(childrenFragment);
        }

        this.element = el;
        return el;
    }

    /**
     * Convert to config
     * @returns {Object}
     */
    toConfig() {
        const config = super.toConfig();

        if (this._tag !== 'div') {
            config.tag = this._tag;
        }

        if (this._textContent !== null) {
            config.textContent = this._textContent;
        }

        if (this._innerHTML !== null) {
            config.innerHTML = this._innerHTML;
        }

        if (this._selfClosing) {
            config.selfClosing = true;
        }

        if (this._href !== null) {
            config.href = this._href;
        }

        if (this._target !== null) {
            config.target = this._target;
        }

        return config;
    }
}

export default Html;
export { Html };
