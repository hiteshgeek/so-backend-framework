// ============================================
// SIXORBIT UI ENGINE - FLEX ELEMENT
// Flexbox layout wrapper
// ============================================

import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';

class Flex extends ContainerElement {
    static NAME = 'ui-flex';
    static DEFAULTS = { ...ContainerElement.DEFAULTS, type: 'flex', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._direction = config.direction || null;
        this._justify = config.justify || null;
        this._align = config.align || null;
        this._alignContent = config.alignContent || null;
        this._wrap = config.wrap || null;
        this._flexGap = config.gap ?? null;
        this._inline = config.inline || false;
    }

    direction(val) { this._direction = val; return this; }
    row() { return this.direction('row'); }
    rowReverse() { return this.direction('row-reverse'); }
    column() { return this.direction('column'); }
    columnReverse() { return this.direction('column-reverse'); }
    justify(val) { this._justify = val; return this; }
    justifyStart() { return this.justify('start'); }
    justifyCenter() { return this.justify('center'); }
    justifyEnd() { return this.justify('end'); }
    justifyBetween() { return this.justify('between'); }
    justifyAround() { return this.justify('around'); }
    justifyEvenly() { return this.justify('evenly'); }
    align(val) { this._align = val; return this; }
    alignStart() { return this.align('start'); }
    alignCenter() { return this.align('center'); }
    alignEnd() { return this.align('end'); }
    alignBaseline() { return this.align('baseline'); }
    alignStretch() { return this.align('stretch'); }
    alignContent(val) { this._alignContent = val; return this; }
    wrap(val = 'wrap') { this._wrap = val; return this; }
    nowrap() { return this.wrap('nowrap'); }
    wrapReverse() { return this.wrap('wrap-reverse'); }
    gap(val) { this._flexGap = val; return this; }
    inline(val = true) { this._inline = val; return this; }
    center() { return this.justifyCenter().alignCenter(); }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls(this._inline ? 'd-inline-flex' : 'd-flex'));
        if (this._direction) this._extraClasses.add(SixOrbit.cls('flex', this._direction));
        if (this._justify) this._extraClasses.add(SixOrbit.cls('justify-content', this._justify));
        if (this._align) this._extraClasses.add(SixOrbit.cls('align-items', this._align));
        if (this._alignContent) this._extraClasses.add(SixOrbit.cls('align-content', this._alignContent));
        if (this._wrap) this._extraClasses.add(SixOrbit.cls('flex', this._wrap));
        if (this._flexGap !== null) this._extraClasses.add(SixOrbit.cls('gap', this._flexGap));
        return super.buildClassString();
    }

    renderContent() { return this.renderChildren(); }

    toConfig() {
        const config = super.toConfig();
        if (this._direction) config.direction = this._direction;
        if (this._justify) config.justify = this._justify;
        if (this._align) config.align = this._align;
        if (this._alignContent) config.alignContent = this._alignContent;
        if (this._wrap) config.wrap = this._wrap;
        if (this._flexGap !== null) config.gap = this._flexGap;
        if (this._inline) config.inline = true;
        return config;
    }
}

export default Flex;
export { Flex };
