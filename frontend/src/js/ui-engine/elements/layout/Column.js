// ============================================
// SIXORBIT UI ENGINE - COLUMN ELEMENT
// Grid column
// ============================================

import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Column - Grid column element
 */
class Column extends ContainerElement {
    static NAME = 'ui-column';

    static DEFAULTS = {
        ...ContainerElement.DEFAULTS,
        type: 'column',
        tagName: 'div',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._size = config.size || null; // col-* or {default: 12, md: 6, lg: 4}
        this._offset = config.offset || null; // offset-*
        this._order = config.order || null; // order-*
        this._alignSelf = config.alignSelf || null; // align-self-*
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set column size
     * @param {number|string|Object} size - Column width (1-12, 'auto', or responsive object)
     * @returns {this}
     */
    size(size) {
        this._size = size;
        return this;
    }

    /** Auto-size column */
    auto() { return this.size('auto'); }

    /**
     * Set offset
     * @param {number|Object} offset - Offset columns (0-11 or responsive object)
     * @returns {this}
     */
    offset(offset) {
        this._offset = offset;
        return this;
    }

    /**
     * Set order
     * @param {number|string|Object} order - Column order (0-5, 'first', 'last', or responsive)
     * @returns {this}
     */
    order(order) {
        this._order = order;
        return this;
    }

    /** Order first */
    orderFirst() { return this.order('first'); }

    /** Order last */
    orderLast() { return this.order('last'); }

    /**
     * Set align self
     * @param {string} align - start, center, end, baseline, stretch
     * @returns {this}
     */
    alignSelf(align) {
        this._alignSelf = align;
        return this;
    }

    /** Align self start */
    alignSelfStart() { return this.alignSelf('start'); }

    /** Align self center */
    alignSelfCenter() { return this.alignSelf('center'); }

    /** Align self end */
    alignSelfEnd() { return this.alignSelf('end'); }

    /** Align self baseline */
    alignSelfBaseline() { return this.alignSelf('baseline'); }

    /** Align self stretch */
    alignSelfStretch() { return this.alignSelf('stretch'); }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        // Column size
        if (this._size === null) {
            this._extraClasses.add(SixOrbit.cls('col'));
        } else if (typeof this._size === 'object') {
            // Responsive: {default: 12, md: 6, lg: 4}
            Object.entries(this._size).forEach(([bp, val]) => {
                if (bp === 'default') {
                    this._extraClasses.add(SixOrbit.cls('col', val));
                } else {
                    this._extraClasses.add(SixOrbit.cls('col', bp, val));
                }
            });
        } else if (this._size === 'auto') {
            this._extraClasses.add(SixOrbit.cls('col-auto'));
        } else {
            this._extraClasses.add(SixOrbit.cls('col', this._size));
        }

        // Offset
        if (this._offset !== null) {
            if (typeof this._offset === 'object') {
                Object.entries(this._offset).forEach(([bp, val]) => {
                    if (bp === 'default') {
                        this._extraClasses.add(SixOrbit.cls('offset', val));
                    } else {
                        this._extraClasses.add(SixOrbit.cls('offset', bp, val));
                    }
                });
            } else {
                this._extraClasses.add(SixOrbit.cls('offset', this._offset));
            }
        }

        // Order
        if (this._order !== null) {
            if (typeof this._order === 'object') {
                Object.entries(this._order).forEach(([bp, val]) => {
                    if (bp === 'default') {
                        this._extraClasses.add(SixOrbit.cls('order', val));
                    } else {
                        this._extraClasses.add(SixOrbit.cls('order', bp, val));
                    }
                });
            } else {
                this._extraClasses.add(SixOrbit.cls('order', this._order));
            }
        }

        // Align self
        if (this._alignSelf) {
            this._extraClasses.add(SixOrbit.cls('align-self', this._alignSelf));
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

        if (this._size !== null) config.size = this._size;
        if (this._offset !== null) config.offset = this._offset;
        if (this._order !== null) config.order = this._order;
        if (this._alignSelf) config.alignSelf = this._alignSelf;

        return config;
    }
}

export default Column;
export { Column };
