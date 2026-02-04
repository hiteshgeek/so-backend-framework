// ============================================
// SIXORBIT UI ENGINE - OTP INPUT ELEMENT
// One-Time Password input
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * OtpInput - OTP/PIN code input
 */
class OtpInput extends FormElement {
    static NAME = 'ui-otp-input';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'otp-input',
        tagName: 'div',
    };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._length = config.length ?? 6;
        this._inputType = config.inputType || 'text';
        this._masked = config.masked || false;
        this._autoSubmit = config.autoSubmit || false;
        this._autoFocus = config.autoFocus !== false;
        this._allowPaste = config.allowPaste !== false;
        this._groupSize = config.groupSize || null;
        this._variant = config.variant || 'default';
    }

    length(len) { this._length = len; return this; }
    pin4() { return this.length(4); }
    pin6() { return this.length(6); }
    inputType(type) { this._inputType = type; return this; }
    numeric() { return this.inputType('number'); }
    alphanumeric() { return this.inputType('text'); }
    masked(val = true) { this._masked = val; return this; }
    password() { this._inputType = 'password'; return this.masked(true); }
    autoSubmit(val = true) { this._autoSubmit = val; return this; }
    autoFocus(val = true) { this._autoFocus = val; return this; }
    allowPaste(val = true) { this._allowPaste = val; return this; }
    groupSize(size) { this._groupSize = size; return this; }
    grouped() { return this.groupSize(3); }
    variant(v) { this._variant = v; return this; }
    outline() { return this.variant('outline'); }
    filled() { return this.variant('filled'); }
    underline() { return this.variant('underline'); }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('otp-input'));
        this._extraClasses.add(SixOrbit.cls('otp', this._variant));
        if (this._error) this._extraClasses.add(SixOrbit.cls('is-invalid'));
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs[SixOrbit.data('ui-init')] = 'otp-input';

        const config = {
            length: this._length,
            inputType: this._inputType,
            masked: this._masked,
            autoSubmit: this._autoSubmit,
            autoFocus: this._autoFocus,
            allowPaste: this._allowPaste,
        };
        if (this._groupSize) config.groupSize = this._groupSize;

        attrs[SixOrbit.data('ui-config')] = JSON.stringify(config);
        return attrs;
    }

    renderContent() {
        let html = `<input type="hidden" class="${SixOrbit.cls('otp-value')}"`;
        if (this._name) html += ` name="${this._escapeHtml(this._name)}"`;
        if (this._value !== null) html += ` value="${this._escapeHtml(this._value)}"`;
        html += '>';

        html += `<div class="${SixOrbit.cls('otp-inputs')}">`;
        const currentValue = this._value || '';

        for (let i = 0; i < this._length; i++) {
            if (this._groupSize && i > 0 && i % this._groupSize === 0) {
                html += `<span class="${SixOrbit.cls('otp-separator')}">-</span>`;
            }
            const digitValue = currentValue[i] || '';
            const inputType = this._masked ? 'password' : (this._inputType === 'number' ? 'tel' : 'text');

            html += `<input type="${inputType}"`;
            html += ` class="${SixOrbit.cls('otp-digit')}"`;
            html += ' maxlength="1"';
            html += ' autocomplete="one-time-code"';
            html += ` inputmode="${this._inputType === 'number' ? 'numeric' : 'text'}"`;
            html += ` pattern="${this._inputType === 'number' ? '[0-9]' : '[a-zA-Z0-9]'}"`;
            html += ` ${SixOrbit.data('index')}="${i}"`;
            if (digitValue) html += ` value="${this._escapeHtml(digitValue)}"`;
            if (i === 0 && this._autoFocus) html += ' autofocus';
            if (this._disabled) html += ' disabled';
            if (this._readonly) html += ' readonly';
            html += '>';
        }

        html += '</div>';
        return html;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._length !== 6) config.length = this._length;
        if (this._inputType !== 'text') config.inputType = this._inputType;
        if (this._masked) config.masked = true;
        if (this._autoSubmit) config.autoSubmit = true;
        if (!this._autoFocus) config.autoFocus = false;
        if (!this._allowPaste) config.allowPaste = false;
        if (this._groupSize) config.groupSize = this._groupSize;
        if (this._variant !== 'default') config.variant = this._variant;
        return config;
    }
}

export default OtpInput;
export { OtpInput };
