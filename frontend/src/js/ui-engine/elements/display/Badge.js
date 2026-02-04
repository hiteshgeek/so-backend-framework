// ============================================
// SIXORBIT UI ENGINE - BADGE ELEMENT
// Badge/label display
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Badge - Badge/label element
 */
class Badge extends Element {
    static NAME = 'ui-badge';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'badge',
        tagName: 'span',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._variant = config.variant || 'primary';
        this._text = config.text || null;
        this._soft = config.soft || false;
        this._pill = config.pill || false;
        this._size = config.size || null;
        this._icon = config.icon || null;
        this._dot = config.dot || false;
        this._label = config.label || null;
        this._href = config.href || null;
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set variant
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

    /** Success variant */
    success() { return this.variant('success'); }

    /** Danger variant */
    danger() { return this.variant('danger'); }

    /** Warning variant */
    warning() { return this.variant('warning'); }

    /** Info variant */
    info() { return this.variant('info'); }

    /** Light variant */
    light() { return this.variant('light'); }

    /** Dark variant */
    dark() { return this.variant('dark'); }

    /**
     * Set text
     * @param {string} text
     * @returns {this}
     */
    text(text) {
        this._text = text;
        return this;
    }

    /**
     * Set pill style
     * @param {boolean} pill
     * @returns {this}
     */
    pill(pill = true) {
        this._pill = pill;
        return this;
    }

    /**
     * Enable soft style (light background)
     * @param {boolean} soft
     * @returns {this}
     */
    soft(soft = true) {
        this._soft = soft;
        return this;
    }

    /**
     * Set size
     * @param {string} size
     * @returns {this}
     */
    size(size) {
        this._size = size;
        return this;
    }

    /**
     * Small size
     * @returns {this}
     */
    small() {
        return this.size('sm');
    }

    /**
     * Large size
     * @returns {this}
     */
    large() {
        return this.size('lg');
    }

    /**
     * Set badge icon
     * @param {string} icon Material Icons name
     * @returns {this}
     */
    icon(icon) {
        this._icon = icon;
        return this;
    }

    /**
     * Enable dot style (status indicator)
     * @param {boolean} dot
     * @returns {this}
     */
    dot(dot = true) {
        this._dot = dot;
        return this;
    }

    /**
     * Set label text (displayed after dot badge)
     * @param {string} label
     * @returns {this}
     */
    label(label) {
        this._label = label;
        return this;
    }

    /**
     * Make badge a link
     * @param {string} href
     * @returns {this}
     */
    href(href) {
        this._href = href;
        this._tagName = 'a';
        return this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('badge'));

        // Variant class: so-badge-{variant} or so-badge-soft-{variant}
        if (this._soft) {
            this._extraClasses.add(SixOrbit.cls('badge-soft', this._variant));
        } else {
            this._extraClasses.add(SixOrbit.cls('badge', this._variant));
        }

        // Size class
        if (this._size) {
            this._extraClasses.add(SixOrbit.cls('badge', this._size));
        }

        // Pill style
        if (this._pill) {
            this._extraClasses.add(SixOrbit.cls('badge-pill'));
        }

        // Dot style
        if (this._dot) {
            this._extraClasses.add(SixOrbit.cls('badge-dot'));
        }

        return super.buildClassString();
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        if (this._href) {
            attrs.href = this._href;
        }

        return attrs;
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        // Dot badges have no text content inside
        if (this._dot) {
            return '';
        }

        let html = '';

        // Icon
        if (this._icon) {
            html += `<span class="material-icons" style="font-size: 14px; vertical-align: middle;">${this._escapeHtml(this._icon)}</span> `;
        }

        // Text
        if (this._text) {
            html += this._escapeHtml(this._text);
        } else if (this._content) {
            html += this._escapeHtml(this._content);
        }

        return html;
    }

    /**
     * Render the element
     * @returns {string}
     */
    render() {
        const badge = super.render();

        // For dot badges with label, wrap in container with label
        if (this._dot && this._label) {
            return `<span class="${SixOrbit.cls('d-inline-flex')} ${SixOrbit.cls('align-items-center')} ${SixOrbit.cls('gap-2')}">${badge}<span>${this._escapeHtml(this._label)}</span></span>`;
        }

        return badge;
    }

    // ==================
    // Interactivity Methods
    // ==================

    /**
     * Set text dynamically
     * @param {string} text
     * @returns {this}
     */
    setText(text) {
        this._text = text;
        if (this.element) {
            this.element.innerHTML = this.renderContent();
        }
        return this;
    }

    /**
     * Get current text
     * @returns {string|null}
     */
    getText() {
        return this._text;
    }

    /**
     * Set variant dynamically
     * @param {string} variant
     * @returns {this}
     */
    setVariant(variant) {
        if (!this.element) return this;

        // Remove old variant class
        if (this._soft) {
            this.element.classList.remove(SixOrbit.cls('badge-soft', this._variant));
        } else {
            this.element.classList.remove(SixOrbit.cls('badge', this._variant));
        }

        // Set new variant
        this._variant = variant;

        // Add new variant class
        if (this._soft) {
            this.element.classList.add(SixOrbit.cls('badge-soft', this._variant));
        } else {
            this.element.classList.add(SixOrbit.cls('badge', this._variant));
        }

        return this;
    }

    /**
     * Get current variant
     * @returns {string}
     */
    getVariant() {
        return this._variant;
    }

    /**
     * Toggle soft style
     * @returns {this}
     */
    toggleSoft() {
        if (!this.element) return this;

        // Remove current variant class
        if (this._soft) {
            this.element.classList.remove(SixOrbit.cls('badge-soft', this._variant));
        } else {
            this.element.classList.remove(SixOrbit.cls('badge', this._variant));
        }

        // Toggle soft state
        this._soft = !this._soft;

        // Add new variant class
        if (this._soft) {
            this.element.classList.add(SixOrbit.cls('badge-soft', this._variant));
        } else {
            this.element.classList.add(SixOrbit.cls('badge', this._variant));
        }

        return this;
    }

    /**
     * Toggle pill style
     * @returns {this}
     */
    togglePill() {
        if (!this.element) return this;

        this._pill = !this._pill;
        this.element.classList.toggle(SixOrbit.cls('badge-pill'));

        return this;
    }

    /**
     * Set size dynamically
     * @param {string} size
     * @returns {this}
     */
    setSize(size) {
        if (!this.element) return this;

        // Remove old size class
        if (this._size) {
            this.element.classList.remove(SixOrbit.cls('badge', this._size));
        }

        // Set new size
        this._size = size;

        // Add new size class
        if (this._size) {
            this.element.classList.add(SixOrbit.cls('badge', this._size));
        }

        return this;
    }

    /**
     * Set icon dynamically
     * @param {string} icon
     * @returns {this}
     */
    setIcon(icon) {
        this._icon = icon;
        if (this.element) {
            this.element.innerHTML = this.renderContent();
        }
        return this;
    }

    /**
     * Check if badge has soft style
     * @returns {boolean}
     */
    isSoft() {
        return this._soft;
    }

    /**
     * Check if badge has pill style
     * @returns {boolean}
     */
    isPill() {
        return this._pill;
    }

    /**
     * Get current size
     * @returns {string|null}
     */
    getSize() {
        return this._size;
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

        config.variant = this._variant;
        if (this._text) config.text = this._text;
        if (this._soft) config.soft = true;
        if (this._pill) config.pill = true;
        if (this._size) config.size = this._size;
        if (this._icon) config.icon = this._icon;
        if (this._dot) config.dot = true;
        if (this._label) config.label = this._label;
        if (this._href) config.href = this._href;

        return config;
    }
}

export default Badge;
export { Badge };
