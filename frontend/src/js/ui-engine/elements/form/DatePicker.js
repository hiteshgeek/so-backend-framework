// ============================================
// SIXORBIT UI ENGINE - DATE PICKER ELEMENT
// Date selection input
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * DatePicker - Date selection
 */
class DatePicker extends FormElement {
    static NAME = 'ui-date-picker';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'date-picker',
        tagName: 'input',
    };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._format = config.format || 'Y-m-d';
        this._minDate = config.minDate || null;
        this._maxDate = config.maxDate || null;
        this._disabledDates = config.disabledDates || [];
        this._disabledDays = config.disabledDays || [];
        this._range = config.range || false;
        this._weekNumbers = config.weekNumbers || false;
        this._clearable = config.clearable !== false;
        this._todayButton = config.todayButton !== false;
        this._firstDayOfWeek = config.firstDayOfWeek ?? 1;
    }

    format(fmt) { this._format = fmt; return this; }
    minDate(date) { this._minDate = date; return this; }
    maxDate(date) { this._maxDate = date; return this; }
    dateRange(min, max) { this._minDate = min; this._maxDate = max; return this; }
    disabledDates(dates) { this._disabledDates = dates; return this; }
    disabledDays(days) { this._disabledDays = days; return this; }
    disableWeekends() { this._disabledDays = [0, 6]; return this; }
    range(val = true) { this._range = val; return this; }
    weekNumbers(val = true) { this._weekNumbers = val; return this; }
    clearable(val = true) { this._clearable = val; return this; }
    todayButton(val = true) { this._todayButton = val; return this; }
    firstDayOfWeek(day) { this._firstDayOfWeek = day; return this; }
    weekStartsSunday() { return this.firstDayOfWeek(0); }
    weekStartsMonday() { return this.firstDayOfWeek(1); }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('form-control'));
        this._extraClasses.add(SixOrbit.cls('datepicker-input'));
        if (this._size) this._extraClasses.add(SixOrbit.cls('form-control', this._size));
        if (this._error) this._extraClasses.add(SixOrbit.cls('is-invalid'));
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs.type = 'text';
        attrs.autocomplete = 'off';
        attrs[SixOrbit.data('ui-init')] = 'date-picker';

        const config = {
            format: this._format,
            clearable: this._clearable,
            todayButton: this._todayButton,
            firstDayOfWeek: this._firstDayOfWeek,
            range: this._range,
            weekNumbers: this._weekNumbers,
        };
        if (this._minDate) config.minDate = this._minDate;
        if (this._maxDate) config.maxDate = this._maxDate;
        if (this._disabledDates.length > 0) config.disabledDates = this._disabledDates;
        if (this._disabledDays.length > 0) config.disabledDays = this._disabledDays;

        attrs[SixOrbit.data('ui-config')] = JSON.stringify(config);
        return attrs;
    }

    renderContent() { return ''; }

    toConfig() {
        const config = super.toConfig();
        if (this._format !== 'Y-m-d') config.format = this._format;
        if (this._minDate) config.minDate = this._minDate;
        if (this._maxDate) config.maxDate = this._maxDate;
        if (this._disabledDates.length > 0) config.disabledDates = this._disabledDates;
        if (this._disabledDays.length > 0) config.disabledDays = this._disabledDays;
        if (this._range) config.range = true;
        if (this._weekNumbers) config.weekNumbers = true;
        if (!this._clearable) config.clearable = false;
        if (!this._todayButton) config.todayButton = false;
        if (this._firstDayOfWeek !== 1) config.firstDayOfWeek = this._firstDayOfWeek;
        return config;
    }
}

export default DatePicker;
export { DatePicker };
