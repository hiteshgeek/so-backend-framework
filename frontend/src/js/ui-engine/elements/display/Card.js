// ============================================
// SIXORBIT UI ENGINE - CARD ELEMENT
// Simple card container with header, body, and footer
// ============================================

import { Element } from '../../core/Element.js';
import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Card - Simple card container
 *
 * A flexible container that accepts nested elements for complex layouts.
 * Use _renderMixed() to handle any nested Element objects.
 */
class Card extends ContainerElement {
    static NAME = 'ui-card';

    static DEFAULTS = {
        ...ContainerElement.DEFAULTS,
        type: 'card',
        tagName: 'div',
    };

    /**
     * Initialize from config
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._header = config.header || null;
        this._body = config.body || null;
        this._footer = config.footer || null;
        this._variant = config.variant || null;
    }

    // ==================
    // Content Configuration
    // ==================

    /**
     * Set card header content
     * @param {Element|string|array} content
     * @returns {this}
     */
    header(content) {
        this._header = content;
        return this;
    }

    /**
     * Set card body content
     * @param {Element|string|array} content
     * @returns {this}
     */
    body(content) {
        this._body = content;
        return this;
    }

    /**
     * Set card footer content
     * @param {Element|string|array} content
     * @returns {this}
     */
    footer(content) {
        this._footer = content;
        return this;
    }

    /**
     * Set card border variant
     * @param {string} variant - primary, secondary, success, danger, warning, info
     * @returns {this}
     */
    variant(variant) {
        this._variant = variant;
        return this;
    }

    // Variant shortcuts
    primary() { return this.variant('primary'); }
    secondary() { return this.variant('secondary'); }
    success() { return this.variant('success'); }
    danger() { return this.variant('danger'); }
    warning() { return this.variant('warning'); }
    info() { return this.variant('info'); }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        this.addClass(SixOrbit.cls('card'));

        // Variant class
        if (this._variant) {
            this.addClass(SixOrbit.cls('card-border-' + this._variant));
        }

        return super.buildClassString();
    }

    /**
     * Render card content (HTML string version for toHtml())
     * @returns {string}
     */
    renderContent() {
        let html = '';

        // Header
        if (this._header !== null) {
            html += `<div class="${SixOrbit.cls('card-header')}">`;
            html += this._renderMixed(this._header);
            html += '</div>';
        }

        // Body
        if (this._body !== null) {
            html += `<div class="${SixOrbit.cls('card-body')}">`;
            html += this._renderMixed(this._body);
            html += '</div>';
        }

        // Render children (if using add() method)
        html += this.renderChildren();

        // Footer
        if (this._footer !== null) {
            html += `<div class="${SixOrbit.cls('card-footer')}">`;
            html += this._renderMixed(this._footer);
            html += '</div>';
        }

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

        // Render header
        if (this._header !== null) {
            const headerDiv = document.createElement('div');
            headerDiv.className = SixOrbit.cls('card-header');
            this._appendMixed(headerDiv, this._header);
            el.appendChild(headerDiv);
        }

        // Render body
        if (this._body !== null) {
            const bodyDiv = document.createElement('div');
            bodyDiv.className = SixOrbit.cls('card-body');
            this._appendMixed(bodyDiv, this._body);
            el.appendChild(bodyDiv);
        }

        // Render children (if using add() method)
        el.appendChild(this.renderChildren());

        // Render footer
        if (this._footer !== null) {
            const footerDiv = document.createElement('div');
            footerDiv.className = SixOrbit.cls('card-footer');
            this._appendMixed(footerDiv, this._footer);
            el.appendChild(footerDiv);
        }

        this.element = el;
        return el;
    }

    /**
     * Append mixed content to a container element
     * @param {HTMLElement} container
     * @param {Element|string|array} content
     * @private
     */
    _appendMixed(container, content) {
        if (content === null || content === undefined) return;

        if (Array.isArray(content)) {
            content.forEach(item => this._appendMixed(container, item));
            return;
        }

        if (content instanceof Element) {
            container.appendChild(content.render());
        } else if (content instanceof HTMLElement) {
            container.appendChild(content);
        } else {
            // String content
            const wrapper = document.createElement('div');
            wrapper.innerHTML = String(content);
            while (wrapper.firstChild) {
                container.appendChild(wrapper.firstChild);
            }
        }
    }

    /**
     * Convert to config
     * @returns {Object}
     */
    toConfig() {
        const config = super.toConfig();

        if (this._header) config.header = this._header;
        if (this._body) config.body = this._body;
        if (this._footer) config.footer = this._footer;
        if (this._variant) config.variant = this._variant;

        return config;
    }
}

export default Card;
export { Card };
