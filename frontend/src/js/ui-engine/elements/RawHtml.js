// ============================================
// SIXORBIT UI ENGINE - RAWHTML ELEMENT
// Outputs raw HTML without wrapper tags
// ============================================

import { Element } from '../core/Element.js';

/**
 * RawHtml - Outputs raw HTML without wrapper tags
 *
 * Unlike Html element which wraps content in tags,
 * RawHtml outputs the HTML content directly without any wrapper.
 * Useful for inserting pre-rendered HTML into containers.
 */
class RawHtml extends Element {
    static NAME = 'ui-rawhtml';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'rawhtml',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        if (config.innerHTML !== undefined) {
            this._content = config.innerHTML;
        }
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set raw HTML content
     * @param {string} html - Raw HTML string
     * @returns {this}
     */
    html(html) {
        this._content = html;
        return this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Render to DOM
     * Creates a temporary wrapper, sets innerHTML, and returns the fragment
     * @returns {DocumentFragment}
     */
    render() {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = this._content || '';

        // Create a document fragment and move all children to it
        const fragment = document.createDocumentFragment();
        while (wrapper.firstChild) {
            fragment.appendChild(wrapper.firstChild);
        }

        this.element = fragment;
        return fragment;
    }

    /**
     * Render to HTML string (no wrapper tags)
     * @returns {string}
     */
    toHtml() {
        return this._content || '';
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

        if (this._content !== null && this._content !== undefined) {
            config.innerHTML = this._content;
        }

        return config;
    }
}

export default RawHtml;
export { RawHtml };
