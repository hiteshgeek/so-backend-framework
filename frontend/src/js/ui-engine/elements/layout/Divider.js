// ============================================
// SIXORBIT UI ENGINE - DIVIDER ELEMENT
// Horizontal or vertical divider/separator
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Divider - Divider/separator element
 */
class Divider extends Element {
    static NAME = 'ui-divider';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'divider',
        tagName: 'hr',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._vertical = config.vertical || false;
        this._text = config.text || null;
        this._variant = config.variant || null;
        this._margin = config.margin || null; // my-* or mx-* value
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set vertical orientation
     * @param {boolean} vertical
     * @returns {this}
     */
    vertical(vertical = true) {
        this._vertical = vertical;
        if (vertical) {
            this._tagName = 'div';
        }
        return this;
    }

    /**
     * Set text for divider with text
     * @param {string} text
     * @returns {this}
     */
    text(text) {
        this._text = text;
        this._tagName = 'div';
        return this;
    }

    /**
     * Set variant/color
     * @param {string} variant
     * @returns {this}
     */
    variant(variant) {
        this._variant = variant;
        return this;
    }

    /** Primary variant */
    primary() { return this.variant('primary'); }

    /** Secondary variant */
    secondary() { return this.variant('secondary'); }

    /** Dark variant */
    dark() { return this.variant('dark'); }

    /** Light variant */
    light() { return this.variant('light'); }

    /**
     * Set margin
     * @param {number} margin - 0-5
     * @returns {this}
     */
    margin(margin) {
        this._margin = margin;
        return this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Get tag name
     * @returns {string}
     */
    getTagName() {
        if (this._text || this._vertical) {
            return 'div';
        }
        return 'hr';
    }

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        if (this._vertical) {
            this._extraClasses.add(SixOrbit.cls('vr'));
            if (this._margin !== null) {
                this._extraClasses.add(SixOrbit.cls('mx', this._margin));
            }
        } else if (this._text) {
            this._extraClasses.add(SixOrbit.cls('divider'));
            this._extraClasses.add(SixOrbit.cls('divider-text'));
            if (this._margin !== null) {
                this._extraClasses.add(SixOrbit.cls('my', this._margin));
            }
        } else {
            // Standard hr
            if (this._margin !== null) {
                this._extraClasses.add(SixOrbit.cls('my', this._margin));
            }
        }

        if (this._variant) {
            this._extraClasses.add(SixOrbit.cls('border', this._variant));
            if (this._text) {
                this._extraClasses.add(SixOrbit.cls('text', this._variant));
            }
        }

        return super.buildClassString();
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        if (!this._text && !this._vertical) {
            attrs.role = 'separator';
        }

        return attrs;
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        if (this._text) {
            return `<span class="${SixOrbit.cls('divider-text-content')}">${this._escapeHtml(this._text)}</span>`;
        }
        return '';
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

        if (this._vertical) config.vertical = true;
        if (this._text) config.text = this._text;
        if (this._variant) config.variant = this._variant;
        if (this._margin !== null) config.margin = this._margin;

        return config;
    }
}

export default Divider;
export { Divider };
