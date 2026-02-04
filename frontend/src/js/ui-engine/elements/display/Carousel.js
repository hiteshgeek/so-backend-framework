// ============================================
// SIXORBIT UI ENGINE - CAROUSEL ELEMENT
// Image/content slider
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Carousel - Image/content slider element
 */
class Carousel extends Element {
    static NAME = 'ui-carousel';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'carousel',
        tagName: 'div',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._slides = config.slides || [];
        this._indicators = config.indicators !== false;
        this._controls = config.controls !== false;
        this._autoplay = config.autoplay || false;
        this._interval = config.interval || 5000;
        this._fade = config.fade || false;
        this._touch = config.touch !== false;
        this._pauseOnHover = config.pauseOnHover !== false;
        this._dark = config.dark || false;
        this._keyboard = config.keyboard !== false;
        this._loop = config.loop !== false;
        this._items = config.items || 1;
    }

    // ==================
    // Slide Management
    // ==================

    /**
     * Set slides
     * @param {Array} slides
     * @returns {this}
     */
    slides(slides) {
        this._slides = slides;
        return this;
    }

    /**
     * Add slide
     * @param {string} image
     * @param {string|null} title
     * @param {string|null} description
     * @param {string|null} alt
     * @returns {this}
     */
    addSlide(image, title = null, description = null, alt = null) {
        const slide = { image };
        if (title !== null) slide.title = title;
        if (description !== null) slide.description = description;
        if (alt !== null) slide.alt = alt;
        this._slides.push(slide);
        return this;
    }

    // ==================
    // Control Configuration
    // ==================

    /**
     * Show/hide indicators
     * @param {boolean} show
     * @returns {this}
     */
    indicators(show = true) {
        this._indicators = show;
        return this;
    }

    /**
     * Show/hide controls
     * @param {boolean} show
     * @returns {this}
     */
    controls(show = true) {
        this._controls = show;
        return this;
    }

    /**
     * Enable autoplay
     * @param {boolean} autoplay
     * @returns {this}
     */
    autoplay(autoplay = true) {
        this._autoplay = autoplay;
        return this;
    }

    /**
     * Set interval
     * @param {number} ms
     * @returns {this}
     */
    interval(ms) {
        this._interval = ms;
        return this;
    }

    /**
     * Enable fade transition
     * @param {boolean} fade
     * @returns {this}
     */
    fade(fade = true) {
        this._fade = fade;
        return this;
    }

    /**
     * Enable/disable touch
     * @param {boolean} touch
     * @returns {this}
     */
    touch(touch = true) {
        this._touch = touch;
        return this;
    }

    /**
     * Pause on hover
     * @param {boolean} pause
     * @returns {this}
     */
    pauseOnHover(pause = true) {
        this._pauseOnHover = pause;
        return this;
    }

    /**
     * Dark variant
     * @param {boolean} dark
     * @returns {this}
     */
    dark(dark = true) {
        this._dark = dark;
        return this;
    }

    /**
     * Enable keyboard navigation
     * @param {boolean} keyboard
     * @returns {this}
     */
    keyboard(keyboard = true) {
        this._keyboard = keyboard;
        return this;
    }

    /**
     * Enable loop/wrap around
     * @param {boolean} loop
     * @returns {this}
     */
    loop(loop = true) {
        this._loop = loop;
        return this;
    }

    // ==================
    // Carousel Variants
    // ==================

    /**
     * Hero carousel (center with peek effect)
     * @returns {this}
     */
    hero() {
        return this.addClass(SixOrbit.cls('carousel-hero'));
    }

    /**
     * Multi-item carousel
     * @param {number|null} items Number of visible items
     * @returns {this}
     */
    multi(items = null) {
        this.addClass(SixOrbit.cls('carousel-multi'));
        if (items !== null) {
            this._items = items;
        }
        return this;
    }

    /**
     * Small size variant
     * @returns {this}
     */
    small() {
        return this.addClass(SixOrbit.cls('carousel-sm'));
    }

    /**
     * Large size variant
     * @returns {this}
     */
    large() {
        return this.addClass(SixOrbit.cls('carousel-lg'));
    }

    /**
     * Show controls only on hover
     * @returns {this}
     */
    controlsHover() {
        return this.addClass(SixOrbit.cls('carousel-controls-hover'));
    }

    /**
     * Use line-style indicators
     * @returns {this}
     */
    lineIndicators() {
        return this.addClass(SixOrbit.cls('carousel-indicators-line'));
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('carousel'));

        if (this._fade) {
            this._extraClasses.add(SixOrbit.cls('carousel-fade'));
        }

        if (this._dark) {
            this._extraClasses.add(SixOrbit.cls('carousel-dark'));
        }

        return super.buildClassString();
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        // Main carousel identifier
        attrs[SixOrbit.data('carousel')] = '';

        // Autoplay
        if (this._autoplay) {
            attrs[SixOrbit.data('autoplay')] = 'true';
        }

        // Interval
        attrs[SixOrbit.data('interval')] = this._interval;

        // Loop
        if (!this._loop) {
            attrs[SixOrbit.data('loop')] = 'false';
        }

        // Pause on hover
        if (!this._pauseOnHover) {
            attrs[SixOrbit.data('pause-on-hover')] = 'false';
        }

        // Keyboard
        if (!this._keyboard) {
            attrs[SixOrbit.data('keyboard')] = 'false';
        }

        // Touch
        if (!this._touch) {
            attrs[SixOrbit.data('touch')] = 'false';
        }

        // Items (for multi-item carousel)
        if (this._items > 1) {
            attrs[SixOrbit.data('items')] = this._items;
        }

        return attrs;
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        const carouselId = this._id || `carousel-${Math.random().toString(36).substring(2, 11)}`;
        let html = '';

        // Indicators
        if (this._indicators && this._slides.length > 1) {
            html += `<div class="${SixOrbit.cls('carousel-indicators')}">`;
            this._slides.forEach((_, index) => {
                const activeClass = index === 0 ? ` ${SixOrbit.cls('active')}` : '';
                html += `<button type="button" class="${SixOrbit.cls('carousel-indicator')}${activeClass}"`;
                html += ` ${SixOrbit.data('slide')}="${index}"`;
                if (index === 0) {
                    html += ' aria-current="true"';
                }
                html += ` aria-label="Go to slide ${index + 1}"></button>`;
            });
            html += '</div>';
        }

        // Slides
        html += `<div class="${SixOrbit.cls('carousel-inner')}">`;
        this._slides.forEach((slide, index) => {
            const activeClass = index === 0 ? ` ${SixOrbit.cls('active')}` : '';
            html += `<div class="${SixOrbit.cls('carousel-slide')}${activeClass}">`;

            if (slide.image) {
                html += `<img src="${this._escapeHtml(slide.image)}" class="${SixOrbit.cls('d-block')} ${SixOrbit.cls('w-100')}"`;
                html += ` alt="${this._escapeHtml(slide.alt || '')}">`;
            }

            // Caption
            if (slide.title || slide.description) {
                html += `<div class="${SixOrbit.cls('carousel-caption')}">`;
                if (slide.title) {
                    html += `<h4 class="${SixOrbit.cls('carousel-caption-title')}">${this._escapeHtml(slide.title)}</h4>`;
                }
                if (slide.description) {
                    html += `<p class="${SixOrbit.cls('carousel-caption-text')}">${this._escapeHtml(slide.description)}</p>`;
                }
                html += '</div>';
            }

            html += '</div>';
        });
        html += '</div>';

        // Controls
        if (this._controls && this._slides.length > 1) {
            html += `<button class="${SixOrbit.cls('carousel-control')} ${SixOrbit.cls('carousel-control-prev')}" type="button" aria-label="Previous slide">`;
            html += `<span class="material-icons">chevron_left</span>`;
            html += `</button>`;

            html += `<button class="${SixOrbit.cls('carousel-control')} ${SixOrbit.cls('carousel-control-next')}" type="button" aria-label="Next slide">`;
            html += `<span class="material-icons">chevron_right</span>`;
            html += `</button>`;
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

        if (this._slides.length > 0) {
            config.slides = this._slides;
        }

        if (!this._indicators) {
            config.indicators = false;
        }

        if (!this._controls) {
            config.controls = false;
        }

        if (this._autoplay) {
            config.autoplay = true;
        }

        if (this._interval !== 5000) {
            config.interval = this._interval;
        }

        if (this._fade) {
            config.fade = true;
        }

        if (!this._touch) {
            config.touch = false;
        }

        if (!this._pauseOnHover) {
            config.pauseOnHover = false;
        }

        if (this._dark) {
            config.dark = true;
        }

        if (!this._keyboard) {
            config.keyboard = false;
        }

        if (!this._loop) {
            config.loop = false;
        }

        if (this._items !== 1) {
            config.items = this._items;
        }

        return config;
    }
}

export default Carousel;
export { Carousel };
