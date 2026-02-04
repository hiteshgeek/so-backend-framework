// ============================================
// SIXORBIT UI ENGINE - TIME PICKER ELEMENT
// Time selection input
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * TimePicker - Time selection
 */
class TimePicker extends FormElement {
    static NAME = 'ui-time-picker';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'time-picker',
        tagName: 'input',
    };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._hourFormat = config.hourFormat ?? 24;
        this._minuteStep = config.minuteStep ?? 5;
        this._showSeconds = config.showSeconds || false;
        this._minTime = config.minTime || null;
        this._maxTime = config.maxTime || null;
        this._clearable = config.clearable !== false;
        this._nowButton = config.nowButton !== false;
    }

    hourFormat(fmt) { this._hourFormat = fmt; return this; }
    hour12() { return this.hourFormat(12); }
    hour24() { return this.hourFormat(24); }
    minuteStep(step) { this._minuteStep = step; return this; }
    showSeconds(val = true) { this._showSeconds = val; return this; }
    minTime(time) { this._minTime = time; return this; }
    maxTime(time) { this._maxTime = time; return this; }
    timeRange(min, max) { this._minTime = min; this._maxTime = max; return this; }
    businessHours() { return this.timeRange('09:00', '17:00'); }
    clearable(val = true) { this._clearable = val; return this; }
    nowButton(val = true) { this._nowButton = val; return this; }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('form-control'));
        this._extraClasses.add(SixOrbit.cls('timepicker-input'));
        if (this._size) this._extraClasses.add(SixOrbit.cls('form-control', this._size));
        if (this._error) this._extraClasses.add(SixOrbit.cls('is-invalid'));
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs.type = 'text';
        attrs.autocomplete = 'off';
        attrs[SixOrbit.data('ui-init')] = 'time-picker';

        const config = {
            hourFormat: this._hourFormat,
            minuteStep: this._minuteStep,
            showSeconds: this._showSeconds,
            clearable: this._clearable,
            nowButton: this._nowButton,
        };
        if (this._minTime) config.minTime = this._minTime;
        if (this._maxTime) config.maxTime = this._maxTime;

        attrs[SixOrbit.data('ui-config')] = JSON.stringify(config);
        return attrs;
    }

    renderContent() { return ''; }

    toConfig() {
        const config = super.toConfig();
        if (this._hourFormat !== 24) config.hourFormat = this._hourFormat;
        if (this._minuteStep !== 5) config.minuteStep = this._minuteStep;
        if (this._showSeconds) config.showSeconds = true;
        if (this._minTime) config.minTime = this._minTime;
        if (this._maxTime) config.maxTime = this._maxTime;
        if (!this._clearable) config.clearable = false;
        if (!this._nowButton) config.nowButton = false;
        return config;
    }
}

export default TimePicker;
export { TimePicker };
