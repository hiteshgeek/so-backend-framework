// ============================================
// SIXORBIT UI ENGINE - IMAGE ELEMENT
// Image element with responsive features
// ============================================

import Html from '../Html.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Image - Image element
 */
class Image extends Html {
    static NAME = 'ui-image';

    static DEFAULTS = {
        ...Html.DEFAULTS,
        type: 'image',
        tag: 'img',
        selfClosing: true,
        src: null,
        alt: '',
        width: null,
        height: null,
        lazy: false,
        fluid: false,
        rounded: false,
        circle: false,
        thumbnail: false,
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._tag = 'img';
        this._selfClosing = true;
        this._src = config.src ?? null;
        this._alt = config.alt ?? '';
        this._width = config.width ?? null;
        this._height = config.height ?? null;
        this._lazy = config.lazy ?? false;
        this._fluid = config.fluid ?? false;
        this._rounded = config.rounded ?? false;
        this._circle = config.circle ?? false;
        this._thumbnail = config.thumbnail ?? false;
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set image source
     * @param {string} src
     * @returns {this}
     */
    src(src) {
        this._src = src;
        return this;
    }

    /**
     * Set alt text
     * @param {string} alt
     * @returns {this}
     */
    alt(alt) {
        this._alt = alt;
        return this;
    }

    /**
     * Set image width
     * @param {number|string} width
     * @returns {this}
     */
    width(width) {
        this._width = width;
        return this;
    }

    /**
     * Set image height
     * @param {number|string} height
     * @returns {this}
     */
    height(height) {
        this._height = height;
        return this;
    }

    /**
     * Set dimensions (width and height)
     * @param {number|string} width
     * @param {number|string|null} height
     * @returns {this}
     */
    size(width, height = null) {
        this._width = width;
        this._height = height ?? width;
        return this;
    }

    /**
     * Enable lazy loading
     * @param {boolean} lazy
     * @returns {this}
     */
    lazy(lazy = true) {
        this._lazy = lazy;
        return this;
    }

    /**
     * Make image responsive (fluid)
     * @param {boolean} fluid
     * @returns {this}
     */
    fluid(fluid = true) {
        this._fluid = fluid;
        return this;
    }

    /**
     * Add rounded corners
     * @param {boolean} rounded
     * @returns {this}
     */
    rounded(rounded = true) {
        this._rounded = rounded;
        return this;
    }

    /**
     * Make image circular
     * @param {boolean} circle
     * @returns {this}
     */
    circle(circle = true) {
        this._circle = circle;
        return this;
    }

    /**
     * Add thumbnail styling
     * @param {boolean} thumbnail
     * @returns {this}
     */
    thumbnail(thumbnail = true) {
        this._thumbnail = thumbnail;
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
        if (this._fluid) {
            this._extraClasses.add(SixOrbit.cls('img-fluid'));
        }

        if (this._rounded) {
            this._extraClasses.add(SixOrbit.cls('rounded'));
        }

        if (this._circle) {
            this._extraClasses.add(SixOrbit.cls('rounded-circle'));
        }

        if (this._thumbnail) {
            this._extraClasses.add(SixOrbit.cls('img-thumbnail'));
        }

        return super.buildClassString();
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        if (this._src !== null) {
            attrs.src = this._src;
        }

        attrs.alt = this._alt;

        if (this._width !== null) {
            attrs.width = this._width;
        }

        if (this._height !== null) {
            attrs.height = this._height;
        }

        if (this._lazy) {
            attrs.loading = 'lazy';
        }

        return attrs;
    }

    /**
     * Convert to config
     * @returns {Object}
     */
    toConfig() {
        const config = super.toConfig();

        if (this._src !== null) {
            config.src = this._src;
        }

        if (this._alt !== '') {
            config.alt = this._alt;
        }

        if (this._width !== null) {
            config.width = this._width;
        }

        if (this._height !== null) {
            config.height = this._height;
        }

        if (this._lazy) {
            config.lazy = true;
        }

        if (this._fluid) {
            config.fluid = true;
        }

        if (this._rounded) {
            config.rounded = true;
        }

        if (this._circle) {
            config.circle = true;
        }

        if (this._thumbnail) {
            config.thumbnail = true;
        }

        return config;
    }
}

export default Image;
export { Image };
