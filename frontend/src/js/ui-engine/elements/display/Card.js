// ============================================
// SIXORBIT UI ENGINE - CARD ELEMENT
// Card container with header/body/footer
// ============================================

import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Card - Card container element
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
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._title = config.title || null;
        this._subtitle = config.subtitle || null;
        this._body = config.body || null;
        this._footer = config.footer || null;
        this._image = config.image || null;
        this._imagePosition = config.imagePosition || 'top';
        this._headerActions = config.headerActions || [];
    }

    // ==================
    // Content Configuration
    // ==================

    /**
     * Set title
     * @param {string} title
     * @returns {this}
     */
    title(title) {
        this._title = title;
        if (this.element) this._updateContent();
        return this;
    }

    /**
     * Set subtitle
     * @param {string} subtitle
     * @returns {this}
     */
    subtitle(subtitle) {
        this._subtitle = subtitle;
        if (this.element) this._updateContent();
        return this;
    }

    /**
     * Set body content
     * @param {string} body
     * @returns {this}
     */
    body(body) {
        this._body = body;
        if (this.element) this._updateContent();
        return this;
    }

    /**
     * Set footer content
     * @param {string} footer
     * @returns {this}
     */
    footer(footer) {
        this._footer = footer;
        if (this.element) this._updateContent();
        return this;
    }

    /**
     * Set image
     * @param {string} src
     * @param {string} position - top, bottom
     * @returns {this}
     */
    image(src, position = 'top') {
        this._image = src;
        this._imagePosition = position;
        if (this.element) this._updateContent();
        return this;
    }

    /**
     * Add header action
     * @param {Object} action - {icon, onClick, title}
     * @returns {this}
     */
    addHeaderAction(action) {
        this._headerActions.push(action);
        if (this.element) this._updateContent();
        return this;
    }

    // ==================
    // Border Color Variants
    // ==================

    /**
     * Set border color variant
     * @param {string} variant - primary, success, danger, etc.
     * @returns {this}
     */
    variant(variant) {
        return this.addClass(`card-border-${variant}`);
    }

    /**
     * Primary border color
     * @returns {this}
     */
    borderPrimary() {
        return this.variant('primary');
    }

    /**
     * Success border color
     * @returns {this}
     */
    borderSuccess() {
        return this.variant('success');
    }

    /**
     * Danger border color
     * @returns {this}
     */
    borderDanger() {
        return this.variant('danger');
    }

    /**
     * Warning border color
     * @returns {this}
     */
    borderWarning() {
        return this.variant('warning');
    }

    /**
     * Info border color
     * @returns {this}
     */
    borderInfo() {
        return this.variant('info');
    }

    /**
     * Secondary border color
     * @returns {this}
     */
    borderSecondary() {
        return this.variant('secondary');
    }

    /**
     * Light border color
     * @returns {this}
     */
    borderLight() {
        return this.variant('light');
    }

    /**
     * Dark border color
     * @returns {this}
     */
    borderDark() {
        return this.variant('dark');
    }

    // ==================
    // Header Color Variants
    // ==================

    /**
     * Set header color variant
     * @param {string} variant - primary, success, danger, etc.
     * @param {boolean} soft - Use soft/light style
     * @returns {this}
     */
    headerColor(variant, soft = false) {
        const className = soft ? `card-header-soft-${variant}` : `card-header-${variant}`;
        return this.addClass(className);
    }

    /**
     * Primary header color
     * @returns {this}
     */
    headerPrimary() {
        return this.addClass('card-header-primary');
    }

    /**
     * Success header color
     * @returns {this}
     */
    headerSuccess() {
        return this.addClass('card-header-success');
    }

    /**
     * Danger header color
     * @returns {this}
     */
    headerDanger() {
        return this.addClass('card-header-danger');
    }

    /**
     * Warning header color
     * @returns {this}
     */
    headerWarning() {
        return this.addClass('card-header-warning');
    }

    /**
     * Info header color
     * @returns {this}
     */
    headerInfo() {
        return this.addClass('card-header-info');
    }

    /**
     * Secondary header color
     * @returns {this}
     */
    headerSecondary() {
        return this.addClass('card-header-secondary');
    }

    /**
     * Light header color
     * @returns {this}
     */
    headerLight() {
        return this.addClass('card-header-light');
    }

    /**
     * Dark header color
     * @returns {this}
     */
    headerDark() {
        return this.addClass('card-header-dark');
    }

    // ==================
    // Header Color Variants (Soft)
    // ==================

    /**
     * Soft primary header color
     * @returns {this}
     */
    headerSoftPrimary() {
        return this.addClass('card-header-soft-primary');
    }

    /**
     * Soft success header color
     * @returns {this}
     */
    headerSoftSuccess() {
        return this.addClass('card-header-soft-success');
    }

    /**
     * Soft danger header color
     * @returns {this}
     */
    headerSoftDanger() {
        return this.addClass('card-header-soft-danger');
    }

    /**
     * Soft warning header color
     * @returns {this}
     */
    headerSoftWarning() {
        return this.addClass('card-header-soft-warning');
    }

    /**
     * Soft info header color
     * @returns {this}
     */
    headerSoftInfo() {
        return this.addClass('card-header-soft-info');
    }

    /**
     * Soft secondary header color
     * @returns {this}
     */
    headerSoftSecondary() {
        return this.addClass('card-header-soft-secondary');
    }

    /**
     * Soft light header color
     * @returns {this}
     */
    headerSoftLight() {
        return this.addClass('card-header-soft-light');
    }

    /**
     * Soft dark header color
     * @returns {this}
     */
    headerSoftDark() {
        return this.addClass('card-header-soft-dark');
    }

    // ==================
    // Card Styles
    // ==================

    /**
     * Bordered style (border, no shadow)
     * @returns {this}
     */
    bordered() {
        return this.addClass('card-bordered');
    }

    /**
     * Flat style (no shadow, no border)
     * @returns {this}
     */
    flat() {
        return this.addClass('card-flat');
    }

    /**
     * Elevated style (larger shadow)
     * @returns {this}
     */
    elevated() {
        return this.addClass('card-elevated');
    }

    /**
     * Padded style (direct padding on card)
     * @returns {this}
     */
    padded() {
        return this.addClass('card-padded');
    }

    // ==================
    // Spacing Modes
    // ==================

    /**
     * Compact spacing
     * @returns {this}
     */
    compact() {
        return this.addClass('card-compact');
    }

    /**
     * Spacious spacing
     * @returns {this}
     */
    spacious() {
        return this.addClass('card-spacious');
    }

    // ==================
    // Layout Options
    // ==================

    /**
     * Horizontal layout
     * @returns {this}
     */
    horizontal() {
        return this.addClass('card-horizontal');
    }

    // ==================
    // Interactivity Methods
    // ==================

    /**
     * Get current title
     * @returns {string|null}
     */
    getTitle() {
        return this._title;
    }

    /**
     * Get current subtitle
     * @returns {string|null}
     */
    getSubtitle() {
        return this._subtitle;
    }

    /**
     * Get current body
     * @returns {string|null}
     */
    getBody() {
        return this._body;
    }

    /**
     * Get current footer
     * @returns {string|null}
     */
    getFooter() {
        return this._footer;
    }

    /**
     * Update content in DOM
     * @private
     */
    _updateContent() {
        if (!this.element) return;

        const newContent = this.renderContent();
        this.element.innerHTML = newContent;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('card'));
        return super.buildClassString();
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        let html = '';

        // Image top
        if (this._image && this._imagePosition === 'top') {
            html += `<img src="${this._escapeHtml(this._image)}" class="${SixOrbit.cls('card-img-top')}" alt="">`;
        }

        // Header (title/subtitle)
        if (this._title || this._headerActions.length > 0) {
            html += `<div class="${SixOrbit.cls('card-header')}">`;

            if (this._headerActions.length > 0) {
                html += `<div class="${SixOrbit.cls('d-flex')} ${SixOrbit.cls('justify-content-between')} ${SixOrbit.cls('align-items-center')}">`;
                html += `<div>`;
            }

            if (this._title) {
                html += `<h5 class="${SixOrbit.cls('card-title')} ${SixOrbit.cls('mb-0')}">${this._escapeHtml(this._title)}</h5>`;
            }
            if (this._subtitle) {
                html += `<h6 class="${SixOrbit.cls('card-subtitle')} ${SixOrbit.cls('text-muted')}">${this._escapeHtml(this._subtitle)}</h6>`;
            }

            if (this._headerActions.length > 0) {
                html += `</div>`;
                html += `<div class="${SixOrbit.cls('card-header-actions')}">`;
                this._headerActions.forEach(action => {
                    html += `<button type="button" class="${SixOrbit.cls('btn')} ${SixOrbit.cls('btn-sm')} ${SixOrbit.cls('btn-link')}" title="${this._escapeHtml(action.title || '')}">`;
                    html += `<span class="material-icons">${this._escapeHtml(action.icon)}</span>`;
                    html += `</button>`;
                });
                html += `</div></div>`;
            }

            html += '</div>';
        }

        // Body
        html += `<div class="${SixOrbit.cls('card-body')}">`;

        // Title in body (if no header)
        if (!this._title && this._content) {
            // Just content
        }

        // Body content
        if (this._body) {
            html += `<p class="${SixOrbit.cls('card-text')}">${this._escapeHtml(this._body)}</p>`;
        }

        // Render children
        html += this.renderChildren();

        html += '</div>';

        // Image bottom
        if (this._image && this._imagePosition === 'bottom') {
            html += `<img src="${this._escapeHtml(this._image)}" class="${SixOrbit.cls('card-img-bottom')}" alt="">`;
        }

        // Footer
        if (this._footer) {
            html += `<div class="${SixOrbit.cls('card-footer')}">${this._escapeHtml(this._footer)}</div>`;
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
        if (this._subtitle) config.subtitle = this._subtitle;
        if (this._body) config.body = this._body;
        if (this._footer) config.footer = this._footer;
        if (this._image) {
            config.image = this._image;
            if (this._imagePosition !== 'top') config.imagePosition = this._imagePosition;
        }
        if (this._headerActions.length > 0) config.headerActions = this._headerActions;

        return config;
    }
}

export default Card;
export { Card };
