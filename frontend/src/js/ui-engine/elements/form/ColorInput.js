// ============================================
// SIXORBIT UI ENGINE - COLOR INPUT ELEMENT
// Color picker input
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * ColorInput - Color picker
 */
class ColorInput extends FormElement {
    static NAME = 'ui-color-input';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'color-input',
        tagName: 'input',
    };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._presets = config.presets || [];
        this._showInput = config.showInput !== false;
        this._format = config.format || 'hex';
        this._alpha = config.alpha || false;
    }

    presets(presets) { this._presets = presets; return this; }
    addPreset(color) { this._presets.push(color); return this; }
    bootstrapPresets() {
        this._presets = [
            '#0d6efd', '#6610f2', '#6f42c1', '#d63384',
            '#dc3545', '#fd7e14', '#ffc107', '#198754',
            '#20c997', '#0dcaf0', '#adb5bd', '#212529',
        ];
        return this;
    }
    showInput(show = true) { this._showInput = show; return this; }
    hideInput() { return this.showInput(false); }
    format(fmt) { this._format = fmt; return this; }
    hex() { return this.format('hex'); }
    rgb() { return this.format('rgb'); }
    hsl() { return this.format('hsl'); }
    alpha(val = true) { this._alpha = val; return this; }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('form-control'));
        this._extraClasses.add(SixOrbit.cls('form-control-color'));
        if (this._size) this._extraClasses.add(SixOrbit.cls('form-control', this._size));
        if (this._error) this._extraClasses.add(SixOrbit.cls('is-invalid'));
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs.type = 'color';
        attrs[SixOrbit.data('ui-init')] = 'color-input';

        const config = {
            showInput: this._showInput,
            format: this._format,
            alpha: this._alpha,
        };
        if (this._presets.length > 0) config.presets = this._presets;

        attrs[SixOrbit.data('ui-config')] = JSON.stringify(config);
        return attrs;
    }

    renderContent() { return ''; }

    toConfig() {
        const config = super.toConfig();
        if (this._presets.length > 0) config.presets = this._presets;
        if (!this._showInput) config.showInput = false;
        if (this._format !== 'hex') config.format = this._format;
        if (this._alpha) config.alpha = true;
        return config;
    }
}

export default ColorInput;
export { ColorInput };
