// ============================================
// SIXORBIT UI ENGINE - ALERT ELEMENT
// Alert/notification display
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Alert - Alert/notification element
 */
class Alert extends Element {
    static NAME = 'ui-alert';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'alert',
        tagName: 'div',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._variant = config.variant || 'info';
        this._message = config.message || null;
        this._title = config.title || null;
        this._icon = config.icon || null;
        this._dismissible = config.dismissible || false;
        this._autoDismiss = config.autoDismiss || 0;
        this._outline = config.outline || false;
        this._small = config.small || false;
        this._footer = config.footer || null;
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
    success() { return this.variant('success').icon('check_circle'); }

    /** Danger variant */
    danger() { return this.variant('danger').icon('error'); }

    /** Warning variant */
    warning() { return this.variant('warning').icon('warning'); }

    /** Info variant */
    info() { return this.variant('info').icon('info'); }

    /** Light variant */
    light() { return this.variant('light'); }

    /** Dark variant */
    dark() { return this.variant('dark'); }

    /**
     * Set message
     * @param {string} message
     * @returns {this}
     */
    message(message) {
        this._message = message;
        return this;
    }

    /**
     * Set title
     * @param {string} title
     * @returns {this}
     */
    title(title) {
        this._title = title;
        return this;
    }

    /**
     * Set icon
     * @param {string} icon
     * @returns {this}
     */
    icon(icon) {
        this._icon = icon;
        return this;
    }

    /**
     * Make dismissible
     * @param {boolean} dismissible
     * @returns {this}
     */
    dismissible(dismissible = true) {
        this._dismissible = dismissible;
        return this;
    }

    /**
     * Set auto-dismiss time
     * @param {number} seconds
     * @returns {this}
     */
    autoDismiss(seconds) {
        this._autoDismiss = seconds;
        return this;
    }

    /**
     * Set outline style
     * @param {boolean} outline
     * @returns {this}
     */
    outline(outline = true) {
        this._outline = outline;
        return this;
    }

    /**
     * Set small size
     * @param {boolean} small
     * @returns {this}
     */
    small(small = true) {
        this._small = small;
        return this;
    }

    /**
     * Set content (alias for message)
     * @param {string} content
     * @returns {this}
     */
    content(content) {
        this._message = content;
        return this;
    }

    /**
     * Set footer content
     * @param {string} footer
     * @returns {this}
     */
    footer(footer) {
        this._footer = footer;
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
        this._extraClasses.add(SixOrbit.cls('alert'));
        this._extraClasses.add(SixOrbit.cls('alert', this._variant));

        if (this._dismissible) {
            this._extraClasses.add(SixOrbit.cls('alert-dismissible'));
        }

        if (this._outline) {
            this._extraClasses.add(SixOrbit.cls('alert-outline'));
        }

        if (this._small) {
            this._extraClasses.add(SixOrbit.cls('alert-sm'));
        }

        return super.buildClassString();
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        attrs.role = 'alert';

        if (this._autoDismiss > 0) {
            attrs[SixOrbit.data('auto-dismiss')] = this._autoDismiss;
        }

        return attrs;
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        let html = '';

        // Icon (wrapped in so-alert-icon)
        if (this._icon) {
            html += `<span class="${SixOrbit.cls('alert-icon')}"><span class="material-icons">${this._escapeHtml(this._icon)}</span></span>`;
        }

        // Content wrapper
        html += `<div class="${SixOrbit.cls('alert-content')}">`;

        // Title (wrapped in strong tag)
        if (this._title) {
            html += `<strong>${this._escapeHtml(this._title)}</strong> `;
        }

        // Message
        if (this._message) {
            html += this._escapeHtml(this._message);
        }

        // Content from parent (children)
        html += this.renderChildren();

        // Footer with hr separator
        if (this._footer) {
            html += '<hr>';
            html += `<p class="${SixOrbit.cls('mb-0')}">${this._footer}</p>`;
        }

        html += '</div>'; // Close content wrapper

        // Dismiss button (so-alert-close with icon)
        if (this._dismissible) {
            html += `<button type="button" class="${SixOrbit.cls('alert-close')}" data-dismiss="alert" aria-label="Close">`;
            html += '<span class="material-icons">close</span>';
            html += '</button>';
        }

        return html;
    }

    // ==================
    // Interactivity Methods
    // ==================

    /**
     * Show the alert (if hidden)
     * @returns {this}
     */
    show() {
        if (this.element && this.element.style.display === 'none') {
            this.element.style.display = '';
        }
        return this;
    }

    /**
     * Hide the alert (non-dismissible, just hides)
     * @returns {this}
     */
    hide() {
        if (this.element) {
            this.element.style.display = 'none';
        }
        return this;
    }

    /**
     * Close/dismiss the alert (removes from DOM)
     * @returns {this}
     */
    close() {
        if (!this.element) return this;

        // Dispatch close event (cancelable)
        const closeEvent = new CustomEvent(SixOrbit.evt('alert:close'), {
            bubbles: true,
            cancelable: true
        });

        if (!this.element.dispatchEvent(closeEvent)) {
            return this; // Event was prevented
        }

        // Remove element
        this.element.remove();

        // Dispatch closed event
        const closedEvent = new CustomEvent(SixOrbit.evt('alert:closed'), {
            bubbles: true
        });
        document.dispatchEvent(closedEvent);

        return this;
    }

    /**
     * Alias for close()
     * @returns {this}
     */
    dismiss() {
        return this.close();
    }

    /**
     * Change alert variant at runtime
     * @param {string} variant
     * @returns {this}
     */
    setVariant(variant) {
        if (!this.element) return this;

        // Remove old variant class
        this.element.classList.remove(SixOrbit.cls('alert', this._variant));

        // Update and add new variant
        this._variant = variant;
        this.element.classList.add(SixOrbit.cls('alert', this._variant));

        return this;
    }

    /**
     * Change alert message at runtime
     * @param {string} message
     * @returns {this}
     */
    setMessage(message) {
        if (!this.element) return this;

        this._message = message;

        const contentEl = this.element.querySelector(`.${SixOrbit.cls('alert-content')}`);
        if (contentEl) {
            // Keep title if exists
            let html = '';
            if (this._title) {
                html += `<strong>${this._escapeHtml(this._title)}</strong> `;
            }
            html += this._escapeHtml(message);
            if (this._footer) {
                html += '<hr>';
                html += `<p class="${SixOrbit.cls('mb-0')}">${this._footer}</p>`;
            }
            contentEl.innerHTML = html;
        }

        return this;
    }

    /**
     * Change alert title at runtime
     * @param {string} title
     * @returns {this}
     */
    setTitle(title) {
        if (!this.element) return this;

        this._title = title;

        const contentEl = this.element.querySelector(`.${SixOrbit.cls('alert-content')}`);
        if (contentEl) {
            let html = '';
            if (title) {
                html += `<strong>${this._escapeHtml(title)}</strong> `;
            }
            if (this._message) {
                html += this._escapeHtml(this._message);
            }
            if (this._footer) {
                html += '<hr>';
                html += `<p class="${SixOrbit.cls('mb-0')}">${this._footer}</p>`;
            }
            contentEl.innerHTML = html;
        }

        return this;
    }

    /**
     * Change alert icon at runtime
     * @param {string} icon
     * @returns {this}
     */
    setIcon(icon) {
        if (!this.element) return this;

        this._icon = icon;

        const iconEl = this.element.querySelector(`.${SixOrbit.cls('alert-icon')} .material-icons`);
        if (iconEl) {
            iconEl.textContent = icon;
        }

        return this;
    }

    /**
     * Toggle outline style
     * @param {boolean} enable
     * @returns {this}
     */
    toggleOutline(enable = null) {
        if (!this.element) return this;

        if (enable === null) {
            enable = !this._outline;
        }

        this._outline = enable;

        if (enable) {
            this.element.classList.add(SixOrbit.cls('alert-outline'));
        } else {
            this.element.classList.remove(SixOrbit.cls('alert-outline'));
        }

        return this;
    }

    /**
     * Toggle small size
     * @param {boolean} enable
     * @returns {this}
     */
    toggleSmall(enable = null) {
        if (!this.element) return this;

        if (enable === null) {
            enable = !this._small;
        }

        this._small = enable;

        if (enable) {
            this.element.classList.add(SixOrbit.cls('alert-sm'));
        } else {
            this.element.classList.remove(SixOrbit.cls('alert-sm'));
        }

        return this;
    }

    /**
     * Check if alert is visible
     * @returns {boolean}
     */
    isVisible() {
        return this.element && this.element.style.display !== 'none';
    }

    /**
     * Get current variant
     * @returns {string}
     */
    getVariant() {
        return this._variant;
    }

    /**
     * Listen to alert close events
     * @param {Function} callback
     * @returns {this}
     */
    onClose(callback) {
        return this.on(SixOrbit.evt('alert:close'), callback);
    }

    /**
     * Listen to alert closed events
     * @param {Function} callback
     * @returns {this}
     */
    onClosed(callback) {
        if (this.element) {
            document.addEventListener(SixOrbit.evt('alert:closed'), callback);
        }
        return this;
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
        if (this._message) config.message = this._message;
        if (this._title) config.title = this._title;
        if (this._icon) config.icon = this._icon;
        if (this._dismissible) config.dismissible = true;
        if (this._autoDismiss > 0) config.autoDismiss = this._autoDismiss;
        if (this._outline) config.outline = true;
        if (this._small) config.small = true;
        if (this._footer) config.footer = this._footer;

        return config;
    }
}

export default Alert;
export { Alert };
