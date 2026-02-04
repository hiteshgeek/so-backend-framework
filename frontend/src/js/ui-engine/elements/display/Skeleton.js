// ============================================
// SIXORBIT UI ENGINE - SKELETON ELEMENT
// Loading skeleton
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class Skeleton extends Element {
    static NAME = 'ui-skeleton';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'skeleton', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._skeletonType = config.skeletonType || 'text';
        this._width = config.width || null;
        this._height = config.height || null;
        this._lines = config.lines || 1;
        this._animation = config.animation !== false;
    }

    skeletonType(type) { this._skeletonType = type; return this; }
    text() { return this.skeletonType('text'); }
    circle() { return this.skeletonType('circle'); }
    rect() { return this.skeletonType('rect'); }
    card() { return this.skeletonType('card'); }
    avatar() { return this.skeletonType('avatar'); }
    width(w) { this._width = w; return this; }
    height(h) { this._height = h; return this; }
    lines(n) { this._lines = n; return this; }
    animation(val = true) { this._animation = val; return this; }
    noAnimation() { return this.animation(false); }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('skeleton'));
        this._extraClasses.add(SixOrbit.cls('skeleton', this._skeletonType));
        if (this._animation) this._extraClasses.add(SixOrbit.cls('skeleton-animated'));
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        const styles = [];
        if (this._width) styles.push(`width: ${this._width}`);
        if (this._height) styles.push(`height: ${this._height}`);
        if (styles.length > 0) {
            attrs.style = (attrs.style ? attrs.style + '; ' : '') + styles.join('; ');
        }
        return attrs;
    }

    renderContent() {
        if (this._skeletonType === 'text' && this._lines > 1) {
            let html = '';
            for (let i = 0; i < this._lines; i++) {
                const lastLineClass = i === this._lines - 1 ? ` ${SixOrbit.cls('skeleton-line-short')}` : '';
                html += `<div class="${SixOrbit.cls('skeleton-line')}${lastLineClass}"></div>`;
            }
            return html;
        }

        if (this._skeletonType === 'card') {
            let html = `<div class="${SixOrbit.cls('skeleton-card-image')}"></div>`;
            html += `<div class="${SixOrbit.cls('skeleton-card-body')}">`;
            html += `<div class="${SixOrbit.cls('skeleton-line')}"></div>`;
            html += `<div class="${SixOrbit.cls('skeleton-line')} ${SixOrbit.cls('skeleton-line-short')}"></div>`;
            html += '</div>';
            return html;
        }

        return '';
    }

    toConfig() {
        const config = super.toConfig();
        if (this._skeletonType !== 'text') config.skeletonType = this._skeletonType;
        if (this._width) config.width = this._width;
        if (this._height) config.height = this._height;
        if (this._lines !== 1) config.lines = this._lines;
        if (!this._animation) config.animation = false;
        return config;
    }
}

export default Skeleton;
export { Skeleton };
