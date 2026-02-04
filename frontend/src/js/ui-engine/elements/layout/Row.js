// ============================================
// SIXORBIT UI ENGINE - ROW ELEMENT
// Grid row container
// ============================================

import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Row - Grid row element
 */
class Row extends ContainerElement {
    static NAME = 'ui-row';

    static DEFAULTS = {
        ...ContainerElement.DEFAULTS,
        type: 'row',
        tagName: 'div',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._cols = config.cols || null; // row-cols-*
        this._gutter = config.gutter || null; // g-*
        this._gutterX = config.gutterX || null; // gx-*
        this._gutterY = config.gutterY || null; // gy-*
        this._justify = config.justify || null; // justify-content-*
        this._align = config.align || null; // align-items-*
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set row columns
     * @param {number|string} cols - Number or breakpoint:number (e.g., 'md:3')
     * @returns {this}
     */
    cols(cols) {
        this._cols = cols;
        return this;
    }

    /**
     * Set gutter
     * @param {number} gutter - 0-5
     * @returns {this}
     */
    gutter(gutter) {
        this._gutter = gutter;
        return this;
    }

    /**
     * Set horizontal gutter
     * @param {number} gutter - 0-5
     * @returns {this}
     */
    gutterX(gutter) {
        this._gutterX = gutter;
        return this;
    }

    /**
     * Set vertical gutter
     * @param {number} gutter - 0-5
     * @returns {this}
     */
    gutterY(gutter) {
        this._gutterY = gutter;
        return this;
    }

    /**
     * Set justify content
     * @param {string} justify - start, center, end, around, between, evenly
     * @returns {this}
     */
    justify(justify) {
        this._justify = justify;
        return this;
    }

    /** Justify start */
    justifyStart() { return this.justify('start'); }

    /** Justify center */
    justifyCenter() { return this.justify('center'); }

    /** Justify end */
    justifyEnd() { return this.justify('end'); }

    /** Justify around */
    justifyAround() { return this.justify('around'); }

    /** Justify between */
    justifyBetween() { return this.justify('between'); }

    /** Justify evenly */
    justifyEvenly() { return this.justify('evenly'); }

    /**
     * Set align items
     * @param {string} align - start, center, end, baseline, stretch
     * @returns {this}
     */
    align(align) {
        this._align = align;
        return this;
    }

    /** Align start */
    alignStart() { return this.align('start'); }

    /** Align center */
    alignCenter() { return this.align('center'); }

    /** Align end */
    alignEnd() { return this.align('end'); }

    /** Align baseline */
    alignBaseline() { return this.align('baseline'); }

    /** Align stretch */
    alignStretch() { return this.align('stretch'); }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('row'));

        // Row columns
        if (this._cols !== null) {
            if (typeof this._cols === 'object') {
                // Responsive cols: {default: 1, md: 2, lg: 3}
                Object.entries(this._cols).forEach(([bp, val]) => {
                    if (bp === 'default') {
                        this._extraClasses.add(SixOrbit.cls('row-cols', val));
                    } else {
                        this._extraClasses.add(SixOrbit.cls('row-cols', bp, val));
                    }
                });
            } else {
                this._extraClasses.add(SixOrbit.cls('row-cols', this._cols));
            }
        }

        // Gutters
        if (this._gutter !== null) {
            this._extraClasses.add(SixOrbit.cls('g', this._gutter));
        }
        if (this._gutterX !== null) {
            this._extraClasses.add(SixOrbit.cls('gx', this._gutterX));
        }
        if (this._gutterY !== null) {
            this._extraClasses.add(SixOrbit.cls('gy', this._gutterY));
        }

        // Justify content
        if (this._justify) {
            this._extraClasses.add(SixOrbit.cls('justify-content', this._justify));
        }

        // Align items
        if (this._align) {
            this._extraClasses.add(SixOrbit.cls('align-items', this._align));
        }

        return super.buildClassString();
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        return this.renderChildren();
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

        if (this._cols !== null) config.cols = this._cols;
        if (this._gutter !== null) config.gutter = this._gutter;
        if (this._gutterX !== null) config.gutterX = this._gutterX;
        if (this._gutterY !== null) config.gutterY = this._gutterY;
        if (this._justify) config.justify = this._justify;
        if (this._align) config.align = this._align;

        return config;
    }
}

export default Row;
export { Row };
