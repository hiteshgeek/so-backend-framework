// ============================================
// SIXORBIT UI ENGINE - CONTAINER ELEMENT
// Responsive container wrapper
// ============================================

import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Container - Responsive container element
 */
class Container extends ContainerElement {
    static NAME = 'ui-container';

    static DEFAULTS = {
        ...ContainerElement.DEFAULTS,
        type: 'container',
        tagName: 'div',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._fluid = config.fluid || false;
        this._size = config.size || null; // sm, md, lg, xl, xxl
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set fluid container
     * @param {boolean} fluid
     * @returns {this}
     */
    fluid(fluid = true) {
        this._fluid = fluid;
        return this;
    }

    /**
     * Set max-width breakpoint size
     * @param {string} size - sm, md, lg, xl, xxl
     * @returns {this}
     */
    size(size) {
        this._size = size;
        return this;
    }

    /** Small container (max-width: 540px) */
    sm() { return this.size('sm'); }

    /** Medium container (max-width: 720px) */
    md() { return this.size('md'); }

    /** Large container (max-width: 960px) */
    lg() { return this.size('lg'); }

    /** Extra large container (max-width: 1140px) */
    xl() { return this.size('xl'); }

    /** Extra extra large container (max-width: 1320px) */
    xxl() { return this.size('xxl'); }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        if (this._fluid) {
            this._extraClasses.add(SixOrbit.cls('container-fluid'));
        } else if (this._size) {
            this._extraClasses.add(SixOrbit.cls('container', this._size));
        } else {
            this._extraClasses.add(SixOrbit.cls('container'));
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

        if (this._fluid) config.fluid = true;
        if (this._size) config.size = this._size;

        return config;
    }
}

export default Container;
export { Container };
