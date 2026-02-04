// ============================================
// SIXORBIT UI ENGINE - TOOLTIP ELEMENT
// Hover tooltips
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class Tooltip extends Element {
    static NAME = 'ui-tooltip';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'tooltip', tagName: 'span' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._text = config.text || '';
        this._placement = config.placement || 'top';
        this._trigger = config.trigger || 'hover';
        this._html = config.html || false;
    }

    text(text) { this._text = text; return this; }
    placement(p) { this._placement = p; return this; }
    top() { return this.placement('top'); }
    bottom() { return this.placement('bottom'); }
    left() { return this.placement('left'); }
    right() { return this.placement('right'); }
    trigger(t) { this._trigger = t; return this; }
    html(val = true) { this._html = val; return this; }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs[SixOrbit.data('toggle')] = 'tooltip';
        attrs[SixOrbit.data('placement')] = this._placement;
        attrs.title = this._text;
        if (this._html) attrs[SixOrbit.data('html')] = 'true';
        attrs[SixOrbit.data('ui-init')] = 'tooltip';
        attrs[SixOrbit.data('ui-config')] = JSON.stringify({
            placement: this._placement,
            trigger: this._trigger,
            html: this._html
        });
        return attrs;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._text) config.text = this._text;
        if (this._placement !== 'top') config.placement = this._placement;
        if (this._trigger !== 'hover') config.trigger = this._trigger;
        if (this._html) config.html = true;
        return config;
    }
}

export default Tooltip;
export { Tooltip };
