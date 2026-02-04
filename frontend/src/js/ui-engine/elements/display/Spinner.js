// ============================================
// SIXORBIT UI ENGINE - SPINNER ELEMENT
// Loading spinner
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class Spinner extends Element {
    static NAME = 'ui-spinner';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'spinner', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._spinnerType = config.spinnerType || 'border';
        this._variant = config.variant || 'primary';
        this._size = config.size || null;
        this._text = config.text || 'Loading...';
    }

    spinnerType(type) { this._spinnerType = type; return this; }
    border() { return this.spinnerType('border'); }
    grow() { return this.spinnerType('grow'); }
    variant(v) { this._variant = v; return this; }
    primary() { return this.variant('primary'); }
    secondary() { return this.variant('secondary'); }
    success() { return this.variant('success'); }
    danger() { return this.variant('danger'); }
    warning() { return this.variant('warning'); }
    info() { return this.variant('info'); }
    light() { return this.variant('light'); }
    dark() { return this.variant('dark'); }
    size(s) { this._size = s; return this; }
    small() { return this.size('sm'); }
    text(t) { this._text = t; return this; }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('spinner', this._spinnerType));
        this._extraClasses.add(SixOrbit.cls('text', this._variant));
        if (this._size) this._extraClasses.add(SixOrbit.cls('spinner', this._spinnerType, this._size));
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs.role = 'status';
        return attrs;
    }

    renderContent() {
        return `<span class="${SixOrbit.cls('visually-hidden')}">${this._escapeHtml(this._text)}</span>`;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._spinnerType !== 'border') config.spinnerType = this._spinnerType;
        if (this._variant !== 'primary') config.variant = this._variant;
        if (this._size) config.size = this._size;
        if (this._text !== 'Loading...') config.text = this._text;
        return config;
    }
}

export default Spinner;
export { Spinner };
