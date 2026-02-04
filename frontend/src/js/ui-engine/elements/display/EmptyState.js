// ============================================
// SIXORBIT UI ENGINE - EMPTY STATE ELEMENT
// Empty state placeholder
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * EmptyState - Empty state placeholder element
 */
class EmptyState extends Element {
    static NAME = 'ui-empty-state';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'empty-state',
        tagName: 'div',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._title = config.title || null;
        this._description = config.description || null;
        this._icon = config.icon || null;
        this._image = config.image || null;
        this._actions = config.actions || [];
        this._variant = config.variant || null;
        this._size = config.size || null;
        this._iconStyle = config.iconStyle || null;
        this._compact = config.compact || false;
        this._card = config.card || false;
        this._headingLevel = config.headingLevel || 'h3';
    }

    // ==================
    // Content Methods
    // ==================

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
     * Set description
     * @param {string} description
     * @returns {this}
     */
    description(description) {
        this._description = description;
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
     * Set image
     * @param {string} url
     * @returns {this}
     */
    image(url) {
        this._image = url;
        return this;
    }

    /**
     * Set heading level
     * @param {string} level h3, h4, h5
     * @returns {this}
     */
    headingLevel(level) {
        this._headingLevel = level;
        return this;
    }

    // ==================
    // Actions
    // ==================

    /**
     * Add action button
     * @param {string} text
     * @param {string|null} url
     * @param {string} variant
     * @returns {this}
     */
    addAction(text, url = null, variant = 'primary') {
        this._actions.push({ text, url, variant });
        return this;
    }

    /**
     * Set single action button (for backwards compatibility)
     * @param {string} text
     * @param {string|null} url
     * @param {string} variant
     * @returns {this}
     */
    action(text, url = null, variant = 'primary') {
        this._actions = [{ text, url, variant }];
        return this;
    }

    /**
     * Set multiple actions
     * @param {Array} actions
     * @returns {this}
     */
    actions(actions) {
        this._actions = actions;
        return this;
    }

    // ==================
    // Contextual Variants
    // ==================

    /**
     * Set contextual variant
     * @param {string} variant search, error, success, warning, info, no-permission
     * @returns {this}
     */
    variant(variant) {
        this._variant = variant;
        return this;
    }

    /**
     * Search empty state
     * @returns {this}
     */
    search() {
        return this.variant('search');
    }

    /**
     * Error/danger empty state
     * @returns {this}
     */
    error() {
        return this.variant('error');
    }

    /**
     * Danger empty state (alias for error)
     * @returns {this}
     */
    danger() {
        return this.variant('danger');
    }

    /**
     * Success empty state
     * @returns {this}
     */
    success() {
        return this.variant('success');
    }

    /**
     * Warning empty state
     * @returns {this}
     */
    warning() {
        return this.variant('warning');
    }

    /**
     * Info empty state
     * @returns {this}
     */
    info() {
        return this.variant('info');
    }

    /**
     * No permission / forbidden empty state
     * @returns {this}
     */
    noPermission() {
        return this.variant('no-permission');
    }

    /**
     * Forbidden empty state (alias for noPermission)
     * @returns {this}
     */
    forbidden() {
        return this.variant('forbidden');
    }

    // ==================
    // Size Variants
    // ==================

    /**
     * Set size variant
     * @param {string} size sm, lg
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

    // ==================
    // Icon Styling
    // ==================

    /**
     * Set icon style
     * @param {string} style circle, gradient
     * @returns {this}
     */
    iconStyle(style) {
        this._iconStyle = style;
        return this;
    }

    /**
     * Circle icon style
     * @returns {this}
     */
    iconCircle() {
        return this.iconStyle('circle');
    }

    /**
     * Gradient icon style
     * @returns {this}
     */
    iconGradient() {
        return this.iconStyle('gradient');
    }

    // ==================
    // Layout Variants
    // ==================

    /**
     * Compact/inline layout
     * @param {boolean} compact
     * @returns {this}
     */
    compact(compact = true) {
        this._compact = compact;
        return this;
    }

    /**
     * Card styling
     * @param {boolean} card
     * @returns {this}
     */
    card(card = true) {
        this._card = card;
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
        this._extraClasses.add(SixOrbit.cls('empty-state'));

        // Contextual variant
        if (this._variant) {
            this._extraClasses.add(SixOrbit.cls(`empty-state-${this._variant}`));
        }

        // Size variant
        if (this._size) {
            this._extraClasses.add(SixOrbit.cls(`empty-state-${this._size}`));
        }

        // Layout variants
        if (this._compact) {
            this._extraClasses.add(SixOrbit.cls('empty-state-compact'));
        }

        if (this._card) {
            this._extraClasses.add(SixOrbit.cls('empty-state-card'));
        }

        return super.buildClassString();
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        let html = '';

        // Image or icon
        if (this._image) {
            html += `<img src="${this._escapeHtml(this._image)}" class="${SixOrbit.cls('empty-state-image')}" alt="">`;
        } else if (this._icon) {
            let iconClasses = SixOrbit.cls('empty-state-icon');

            // Add icon style variant
            if (this._iconStyle) {
                iconClasses += ` ${SixOrbit.cls(`empty-state-icon-${this._iconStyle}`)}`;
            }

            html += `<div class="${iconClasses}">`;
            html += `<span class="material-icons">${this._escapeHtml(this._icon)}</span>`;
            html += '</div>';
        }

        // Title
        if (this._title) {
            html += `<${this._headingLevel} class="${SixOrbit.cls('empty-state-title')}">${this._escapeHtml(this._title)}</${this._headingLevel}>`;
        }

        // Description (text)
        if (this._description) {
            html += `<p class="${SixOrbit.cls('empty-state-text')}">${this._escapeHtml(this._description)}</p>`;
        }

        // Actions
        if (this._actions.length > 0) {
            html += `<div class="${SixOrbit.cls('empty-state-actions')}">`;

            this._actions.forEach(actionConfig => {
                const btnClass = `${SixOrbit.cls('btn')} ${SixOrbit.cls(`btn-${actionConfig.variant || 'primary'}`)}`;

                if (actionConfig.url) {
                    html += `<a href="${this._escapeHtml(actionConfig.url)}" class="${btnClass}">`;
                    html += this._escapeHtml(actionConfig.text);
                    html += '</a>';
                } else {
                    html += `<button type="button" class="${btnClass}">`;
                    html += this._escapeHtml(actionConfig.text);
                    html += '</button>';
                }
            });

            html += '</div>';
        }

        return html;
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

        if (this._title) config.title = this._title;
        if (this._description) config.description = this._description;
        if (this._icon) config.icon = this._icon;
        if (this._image) config.image = this._image;
        if (this._actions.length > 0) config.actions = this._actions;
        if (this._variant) config.variant = this._variant;
        if (this._size) config.size = this._size;
        if (this._iconStyle) config.iconStyle = this._iconStyle;
        if (this._compact) config.compact = true;
        if (this._card) config.card = true;
        if (this._headingLevel !== 'h3') config.headingLevel = this._headingLevel;

        return config;
    }
}

export default EmptyState;
export { EmptyState };
