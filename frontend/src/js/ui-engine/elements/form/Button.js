// ============================================
// SIXORBIT UI ENGINE - BUTTON ELEMENT
// Button with variants and states
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Button - Button element with variants
 */
class Button extends Element {
    static NAME = 'ui-button';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'button',
        tagName: 'button',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._buttonType = config.buttonType || 'button';
        this._variant = config.variant || 'primary';
        this._size = config.size || null;
        this._outline = config.outline || false;
        this._block = config.block || false;
        this._disabled = config.disabled || false;
        this._loading = config.loading || false;
        this._loadingText = config.loadingText || null;
        this._icon = config.icon || null;
        this._iconPosition = config.iconPosition || 'left';
        this._iconOnly = config.iconOnly || false;
        this._text = config.text || null;
        this._href = config.href || null;
        this._target = config.target || null;

        // Events
        this._eventHandlers = config.events || {};
    }

    // ==================
    // Fluent API - Type
    // ==================

    /**
     * Set button type
     * @param {string} type - button, submit, reset
     * @returns {this}
     */
    buttonType(type) {
        this._buttonType = type;
        return this;
    }

    /** Submit button */
    submit() { return this.buttonType('submit'); }

    /** Reset button */
    reset() { return this.buttonType('reset'); }

    // ==================
    // Fluent API - Variant
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

    /** Link variant */
    link() { return this.variant('link'); }

    // ==================
    // Fluent API - Style
    // ==================

    /**
     * Set as outline style
     * @param {boolean} val
     * @returns {this}
     */
    outline(val = true) {
        this._outline = val;
        return this;
    }

    /**
     * Set size
     * @param {string} size - sm, lg
     * @returns {this}
     */
    size(size) {
        this._size = size;
        return this;
    }

    /** Small size */
    small() { return this.size('sm'); }

    /** Large size */
    large() { return this.size('lg'); }

    /**
     * Set as block button (full width)
     * @param {boolean} val
     * @returns {this}
     */
    block(val = true) {
        this._block = val;
        return this;
    }

    /**
     * Set disabled state
     * @param {boolean} val
     * @returns {this}
     */
    disabled(val = true) {
        this._disabled = val;
        return this;
    }

    /**
     * Set loading state
     * @param {boolean} val
     * @param {string|null} loadingText
     * @returns {this}
     */
    loading(val = true, loadingText = null) {
        this._loading = val;
        if (loadingText !== null) {
            this._loadingText = loadingText;
        }
        return this;
    }

    /**
     * Set icon
     * @param {string} icon - Material Icons name
     * @param {string} position - left, right
     * @returns {this}
     */
    icon(icon, position = 'left') {
        this._icon = icon;
        this._iconPosition = position;
        return this;
    }

    /**
     * Set as icon-only button
     * @param {string} icon - Material Icons name
     * @returns {this}
     */
    iconOnly(icon) {
        this._icon = icon;
        this._iconOnly = true;
        return this;
    }

    /**
     * Set button text
     * @param {string} text
     * @returns {this}
     */
    text(text) {
        this._text = text;
        return this;
    }

    /**
     * Set as link button
     * @param {string} url
     * @param {string|null} target
     * @returns {this}
     */
    href(url, target = null) {
        this._href = url;
        this._target = target;
        return this;
    }

    /**
     * Open link in new tab
     * @returns {this}
     */
    newTab() {
        this._target = '_blank';
        return this;
    }

    // ==================
    // Events
    // ==================

    /**
     * Set click handler
     * @param {Function|string} handler
     * @returns {this}
     */
    onClick(handler) {
        this._eventHandlers.click = handler;
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
        return this._href ? 'a' : 'button';
    }

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('btn'));

        // Variant
        const variantClass = this._outline
            ? SixOrbit.cls('btn', 'outline', this._variant)
            : SixOrbit.cls('btn', this._variant);
        this._extraClasses.add(variantClass);

        // Size
        if (this._size) {
            this._extraClasses.add(SixOrbit.cls('btn', this._size));
        }

        // Block
        if (this._block) {
            this._extraClasses.add(SixOrbit.cls('w-100'));
        }

        // Loading
        if (this._loading) {
            this._extraClasses.add(SixOrbit.cls('btn-loading'));
        }

        // Icon-only
        if (this._iconOnly) {
            this._extraClasses.add(SixOrbit.cls('btn-icon'));
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
            // Anchor element
            attrs.href = this._href;
            attrs.role = 'button';

            if (this._target) {
                attrs.target = this._target;
                if (this._target === '_blank') {
                    attrs.rel = 'noopener noreferrer';
                }
            }

            if (this._disabled) {
                attrs['aria-disabled'] = 'true';
                attrs.tabindex = '-1';
            }
        } else {
            // Button element
            attrs.type = this._buttonType;

            if (this._disabled || this._loading) {
                attrs.disabled = true;
            }
        }

        // Loading data attributes
        if (this._loading) {
            attrs[SixOrbit.data('loading')] = 'true';
            if (this._loadingText) {
                attrs[SixOrbit.data('loading-text')] = this._loadingText;
            }
        }

        return attrs;
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        let html = '';

        // Loading spinner
        if (this._loading) {
            html += `<span class="${SixOrbit.cls('spinner')} ${SixOrbit.cls('spinner-border')} ${SixOrbit.cls('spinner-border-sm')}" role="status" aria-hidden="true"></span> `;
        }

        // Icon left
        if (this._icon && this._iconPosition === 'left' && !this._loading) {
            html += `<span class="material-icons">${this._escapeHtml(this._icon)}</span>`;
            if (!this._iconOnly && this._text) {
                html += ' ';
            }
        }

        // Text
        if (!this._iconOnly) {
            if (this._loading && this._loadingText) {
                html += this._escapeHtml(this._loadingText);
            } else if (this._text) {
                html += this._escapeHtml(this._text);
            } else if (this._content) {
                html += this._escapeHtml(this._content);
            }
        }

        // Icon right
        if (this._icon && this._iconPosition === 'right' && !this._loading) {
            if (!this._iconOnly && this._text) {
                html += ' ';
            }
            html += `<span class="material-icons">${this._escapeHtml(this._icon)}</span>`;
        }

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

        // Set content
        el.innerHTML = this.renderContent();

        // Attach events
        Object.entries(this._eventHandlers).forEach(([event, handler]) => {
            if (typeof handler === 'function') {
                el.addEventListener(event, handler);
            } else if (typeof handler === 'string' && typeof window[handler] === 'function') {
                el.addEventListener(event, window[handler]);
            }
        });

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

        if (this._buttonType !== 'button') config.buttonType = this._buttonType;
        if (this._variant !== 'primary') config.variant = this._variant;
        if (this._size) config.size = this._size;
        if (this._outline) config.outline = true;
        if (this._block) config.block = true;
        if (this._disabled) config.disabled = true;
        if (this._loading) {
            config.loading = true;
            if (this._loadingText) config.loadingText = this._loadingText;
        }
        if (this._icon) {
            config.icon = this._icon;
            if (this._iconPosition !== 'left') config.iconPosition = this._iconPosition;
        }
        if (this._iconOnly) config.iconOnly = true;
        if (this._text) config.text = this._text;
        if (this._href) config.href = this._href;
        if (this._target) config.target = this._target;

        return config;
    }
}

export default Button;
export { Button };
