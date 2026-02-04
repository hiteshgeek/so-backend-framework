// ============================================
// SIXORBIT UI ENGINE - MEDIA OBJECT ELEMENT
// Media + content layout component
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * MediaObject - Media object layout component
 *
 * Displays media (image/icon) alongside content with flexible alignment options.
 * Generates proper .so-media structure matching CSS framework.
 */
class MediaObject extends Element {
    static NAME = 'ui-media-object';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'media-object',
        tagName: 'div',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._media = config.media || null;
        this._mediaType = config.mediaType || 'image';
        this._imageAlt = config.imageAlt || '';
        this._mediaSize = config.mediaSize || '64px';
        this._iconVariant = config.iconVariant || null;
        this._title = config.title || null;
        this._bodyContent = config.content || null;
        this._mediaPosition = config.mediaPosition || 'start';
        this._align = config.align || 'top';
    }

    // ==================
    // Media Methods
    // ==================

    /**
     * Set image media
     * @param {string} url - Image URL
     * @param {string} alt - Alt text
     * @returns {this}
     */
    image(url, alt = '') {
        this._media = url;
        this._mediaType = 'image';
        this._imageAlt = alt;
        return this;
    }

    /**
     * Set icon media
     * @param {string} icon - Material icon name
     * @param {string|null} variant - Color variant (primary, success, warning, danger, info, secondary)
     * @returns {this}
     */
    icon(icon, variant = null) {
        this._media = icon;
        this._mediaType = 'icon';
        this._iconVariant = variant;
        return this;
    }

    /**
     * Set media size
     * @param {string} size - CSS size value (e.g., '64px', '4rem')
     * @returns {this}
     */
    mediaSize(size) {
        this._mediaSize = size;
        this._triggerEvent('so:media:sizeChanged', { size });
        return this;
    }

    /**
     * Set icon variant
     * @param {string} variant - primary, success, warning, danger, info, secondary
     * @returns {this}
     */
    iconVariant(variant) {
        this._iconVariant = variant;
        this._triggerEvent('so:media:variantChanged', { variant });
        return this;
    }

    // ==================
    // Content Methods
    // ==================

    /**
     * Set title/heading
     * @param {string} title
     * @returns {this}
     */
    title(title) {
        this._title = title;
        this._triggerEvent('so:media:titleChanged', { title });
        return this;
    }

    /**
     * Set body content
     * @param {string} content
     * @returns {this}
     */
    content(content) {
        this._bodyContent = content;
        this._triggerEvent('so:media:contentChanged', { content });
        return this;
    }

    /**
     * Alias for content()
     * @param {string} body
     * @returns {this}
     */
    body(body) {
        return this.content(body);
    }

    // ==================
    // Position Methods
    // ==================

    /**
     * Set media position
     * @param {string} position - 'start' or 'end'
     * @returns {this}
     */
    mediaPosition(position) {
        this._mediaPosition = position;
        this._triggerEvent('so:media:positionChanged', { position });
        return this;
    }

    /**
     * Media on start (left in LTR)
     * @returns {this}
     */
    mediaStart() {
        return this.mediaPosition('start');
    }

    /**
     * Media on end (right in LTR)
     * @returns {this}
     */
    mediaEnd() {
        return this.mediaPosition('end');
    }

    /**
     * Alias for mediaEnd() - media on right
     * @returns {this}
     */
    reverse() {
        return this.mediaEnd();
    }

    // ==================
    // Alignment Methods
    // ==================

    /**
     * Set vertical alignment
     * @param {string} align - 'top', 'middle', 'bottom'
     * @returns {this}
     */
    align(align) {
        this._align = align;
        this._triggerEvent('so:media:alignChanged', { align });
        return this;
    }

    /**
     * Align top (default)
     * @returns {this}
     */
    alignTop() {
        return this.align('top');
    }

    /**
     * Align middle/center
     * @returns {this}
     */
    alignMiddle() {
        return this.align('middle');
    }

    /**
     * Alias for alignMiddle()
     * @returns {this}
     */
    alignCenter() {
        return this.alignMiddle();
    }

    /**
     * Align bottom
     * @returns {this}
     */
    alignBottom() {
        return this.align('bottom');
    }

    // ==================
    // Dynamic Update Methods
    // ==================

    /**
     * Update media dynamically
     * @param {string} media - New media URL or icon
     * @param {string} type - 'image' or 'icon'
     * @returns {this}
     */
    setMedia(media, type = 'image') {
        this._media = media;
        this._mediaType = type;
        this._triggerEvent('so:media:mediaChanged', { media, type });
        return this;
    }

    /**
     * Update title dynamically
     * @param {string} title
     * @returns {this}
     */
    setTitle(title) {
        this._title = title;
        this._triggerEvent('so:media:titleChanged', { title });
        return this;
    }

    /**
     * Update content dynamically
     * @param {string} content
     * @returns {this}
     */
    setContent(content) {
        this._bodyContent = content;
        this._triggerEvent('so:media:contentChanged', { content });
        return this;
    }

    /**
     * Toggle media position
     * @returns {this}
     */
    togglePosition() {
        this._mediaPosition = this._mediaPosition === 'start' ? 'end' : 'start';
        this._triggerEvent('so:media:positionToggled', { position: this._mediaPosition });
        return this;
    }

    // ==================
    // Getters
    // ==================

    /**
     * Get media source
     * @returns {string|null}
     */
    getMedia() {
        return this._media;
    }

    /**
     * Get media type
     * @returns {string}
     */
    getMediaType() {
        return this._mediaType;
    }

    /**
     * Get title
     * @returns {string|null}
     */
    getTitle() {
        return this._title;
    }

    /**
     * Get body content
     * @returns {string|null}
     */
    getContent() {
        return this._bodyContent;
    }

    /**
     * Get media position
     * @returns {string}
     */
    getMediaPosition() {
        return this._mediaPosition;
    }

    /**
     * Get alignment
     * @returns {string}
     */
    getAlign() {
        return this._align;
    }

    // ==================
    // Event Methods
    // ==================

    /**
     * Add media change event listener
     * @param {Function} callback
     * @returns {this}
     */
    onMediaChange(callback) {
        return this.on('so:media:mediaChanged', callback);
    }

    /**
     * Add title change event listener
     * @param {Function} callback
     * @returns {this}
     */
    onTitleChange(callback) {
        return this.on('so:media:titleChanged', callback);
    }

    /**
     * Add content change event listener
     * @param {Function} callback
     * @returns {this}
     */
    onContentChange(callback) {
        return this.on('so:media:contentChanged', callback);
    }

    /**
     * Add position change event listener
     * @param {Function} callback
     * @returns {this}
     */
    onPositionChange(callback) {
        return this.on('so:media:positionChanged', callback);
    }

    /**
     * Trigger custom event
     * @param {string} eventName
     * @param {Object} detail
     * @private
     */
    _triggerEvent(eventName, detail = {}) {
        if (this._element) {
            const event = new CustomEvent(eventName, {
                detail: { ...detail, mediaObject: this },
                bubbles: true,
                cancelable: true,
            });
            this._element.dispatchEvent(event);
        }
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('media'));

        // Add alignment class
        if (this._align === 'middle') {
            this._extraClasses.add(SixOrbit.cls('media-middle'));
        } else if (this._align === 'bottom') {
            this._extraClasses.add(SixOrbit.cls('media-bottom'));
        }

        return super.buildClassString();
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        let html = '';

        // Determine media container class
        const mediaContainerClass = this._mediaPosition === 'end'
            ? SixOrbit.cls('media-right')
            : SixOrbit.cls('media-left');

        // Render media first if position is start
        if (this._mediaPosition === 'start') {
            html += this._renderMedia(mediaContainerClass);
        }

        // Render body
        html += this._renderBody();

        // Render media last if position is end
        if (this._mediaPosition === 'end') {
            html += this._renderMedia(mediaContainerClass);
        }

        return html;
    }

    /**
     * Render media element
     * @param {string} containerClass
     * @returns {string}
     * @private
     */
    _renderMedia(containerClass) {
        if (!this._media) {
            return '';
        }

        let html = `<div class="${containerClass}">`;

        if (this._mediaType === 'image') {
            html += `<img src="${this._escapeHtml(this._media)}"`;
            html += ` class="${SixOrbit.cls('media-image')}"`;
            html += ` alt="${this._escapeHtml(this._imageAlt)}"`;
            html += ` style="width: ${this._mediaSize}; height: ${this._mediaSize};">`;
        } else if (this._mediaType === 'icon') {
            let iconClass = SixOrbit.cls('media-icon');
            if (this._iconVariant) {
                iconClass += ` ${SixOrbit.cls(`media-icon-${this._iconVariant}`)}`;
            }

            html += `<div class="${iconClass}"`;
            html += ` style="width: ${this._mediaSize}; height: ${this._mediaSize};">`;
            html += `<span class="material-icons">${this._escapeHtml(this._media)}</span>`;
            html += '</div>';
        }

        html += '</div>';
        return html;
    }

    /**
     * Render body content
     * @returns {string}
     * @private
     */
    _renderBody() {
        let html = `<div class="${SixOrbit.cls('media-body')}">`;

        if (this._title) {
            html += `<h5 class="${SixOrbit.cls('media-heading')}">${this._escapeHtml(this._title)}</h5>`;
        }

        if (this._bodyContent) {
            html += `<p>${this._escapeHtml(this._bodyContent)}</p>`;
        }

        html += '</div>';
        return html;
    }

    /**
     * Convert to config
     * @returns {Object}
     */
    toConfig() {
        const config = super.toConfig();

        if (this._media) config.media = this._media;
        if (this._mediaType !== 'image') config.mediaType = this._mediaType;
        if (this._imageAlt) config.imageAlt = this._imageAlt;
        if (this._mediaSize !== '64px') config.mediaSize = this._mediaSize;
        if (this._iconVariant) config.iconVariant = this._iconVariant;
        if (this._title) config.title = this._title;
        if (this._bodyContent) config.content = this._bodyContent;
        if (this._mediaPosition !== 'start') config.mediaPosition = this._mediaPosition;
        if (this._align !== 'top') config.align = this._align;

        return config;
    }
}

export default MediaObject;
export { MediaObject };
