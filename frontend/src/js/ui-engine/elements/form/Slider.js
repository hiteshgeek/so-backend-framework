// ============================================
// SIXORBIT UI ENGINE - SLIDER ELEMENT
// Range slider input with customizable track and thumb
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Slider - Range slider element
 *
 * Generates the following DOM structure:
 * <div class="so-slider so-slider-primary" data-so-slider>
 *     <input type="range" class="so-slider-input" min="0" max="100" value="50">
 *     <div class="so-slider-track">
 *         <div class="so-slider-fill"></div>
 *         <div class="so-slider-thumb"></div>
 *     </div>
 * </div>
 */
class Slider extends FormElement {
    static NAME = 'ui-slider';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'slider',
        tagName: 'div', // Wrapper is a div
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._min = config.min ?? 0;
        this._max = config.max ?? 100;
        this._step = config.step ?? 1;
        this._isRangeSlider = config.range || false;
        this._valueEnd = config.valueEnd ?? null;
        this._showTooltip = config.showTooltip || false;
        this._tickCount = config.ticks || 0;
        this._variant = config.variant || 'primary';
        this._size = config.size || null;
        this._vertical = config.vertical || false;
        this._suffix = config.suffix || null;
        this._prefix = config.prefix || null;
        this._output = config.output || null;
        this._separator = config.separator || ' - ';

        // Enable range if valueEnd is provided
        if (this._valueEnd !== null) {
            this._isRangeSlider = true;
        }
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set minimum value for slider range
     * @param {number} val
     * @returns {this}
     */
    minValue(val) {
        this._min = val;
        return this;
    }

    /**
     * Set maximum value for slider range
     * @param {number} val
     * @returns {this}
     */
    maxValue(val) {
        this._max = val;
        return this;
    }

    /**
     * Set step value
     * @param {number} val
     * @returns {this}
     */
    step(val) {
        this._step = val;
        return this;
    }

    /**
     * Set value range (min, max, step)
     * @param {number} min
     * @param {number} max
     * @param {number} step
     * @returns {this}
     */
    range(min, max, step = 1) {
        this._min = min;
        this._max = max;
        this._step = step;
        return this;
    }

    /**
     * Enable dual handle range mode
     * @param {boolean} val
     * @returns {this}
     */
    dualRange(val = true) {
        this._isRangeSlider = val;
        return this;
    }

    /**
     * Set end value (for range mode)
     * @param {number} val
     * @returns {this}
     */
    valueEnd(val) {
        this._valueEnd = val;
        this._isRangeSlider = true;
        return this;
    }

    /**
     * Show value tooltip on hover/focus
     * @param {boolean} val
     * @returns {this}
     */
    showTooltip(val = true) {
        this._showTooltip = val;
        return this;
    }

    /**
     * Alias for showTooltip(true)
     * @returns {this}
     */
    labeled() {
        return this.showTooltip(true);
    }

    /**
     * Set number of tick marks
     * @param {number} count
     * @returns {this}
     */
    ticks(count) {
        this._tickCount = count;
        return this;
    }

    /**
     * Set variant/color
     * @param {string} v - primary|secondary|success|danger|warning|info|light|dark
     * @returns {this}
     */
    variant(v) {
        this._variant = v;
        return this;
    }

    primary() { return this.variant('primary'); }
    secondary() { return this.variant('secondary'); }
    success() { return this.variant('success'); }
    danger() { return this.variant('danger'); }
    warning() { return this.variant('warning'); }
    info() { return this.variant('info'); }

    /**
     * Set slider size
     * @param {string} s - xs|sm|lg
     * @returns {this}
     */
    size(s) {
        this._size = s;
        return this;
    }

    xs() { return this.size('xs'); }
    sm() { return this.size('sm'); }
    lg() { return this.size('lg'); }

    /**
     * Enable vertical orientation
     * @param {boolean} val
     * @returns {this}
     */
    vertical(val = true) {
        this._vertical = val;
        return this;
    }

    /**
     * Set value suffix
     * @param {string} s
     * @returns {this}
     */
    suffix(s) {
        this._suffix = s;
        return this;
    }

    /**
     * Set value prefix
     * @param {string} p
     * @returns {this}
     */
    prefix(p) {
        this._prefix = p;
        return this;
    }

    /**
     * Set external output element selector
     * @param {string} selector
     * @returns {this}
     */
    output(selector) {
        this._output = selector;
        return this;
    }

    /**
     * Set separator for range slider output
     * @param {string} s
     * @returns {this}
     */
    separator(s) {
        this._separator = s;
        return this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Get tag name (wrapper div)
     * @returns {string}
     */
    getTagName() {
        return 'div';
    }

    /**
     * Build wrapper CSS classes
     * @returns {string}
     */
    buildClassString() {
        const classes = new Set();

        classes.add(SixOrbit.cls('slider'));

        // Size variant
        if (this._size) {
            classes.add(SixOrbit.cls('slider', this._size));
        }

        // Color variant
        classes.add(SixOrbit.cls('slider', this._variant));

        // Discrete (tick marks)
        if (this._tickCount > 0) {
            classes.add(SixOrbit.cls('slider-discrete'));
        }

        // Labeled (tooltip)
        if (this._showTooltip) {
            classes.add(SixOrbit.cls('slider-labeled'));
        }

        // Vertical
        if (this._vertical) {
            classes.add(SixOrbit.cls('slider-vertical'));
        }

        // Range slider
        if (this._isRangeSlider) {
            classes.add(SixOrbit.cls('slider-range'));
        }

        // Disabled
        if (this._disabled) {
            classes.add(SixOrbit.cls('disabled'));
        }

        // Add user-defined classes
        this._extraClasses.forEach(cls => classes.add(cls));

        return Array.from(classes).join(' ');
    }

    /**
     * Build wrapper attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = {};

        // ID on wrapper
        if (this._id) {
            attrs.id = this._id;
        }

        // Main initialization attribute
        if (this._isRangeSlider) {
            attrs[SixOrbit.data('slider-range')] = '';
        } else {
            attrs[SixOrbit.data('slider')] = '';
        }

        // Optional data attributes
        if (this._output) {
            attrs[SixOrbit.data('output')] = this._output;
        }

        if (this._prefix) {
            attrs[SixOrbit.data('prefix')] = this._prefix;
        }

        if (this._suffix) {
            attrs[SixOrbit.data('suffix')] = this._suffix;
        }

        if (this._tickCount > 0) {
            attrs[SixOrbit.data('ticks')] = this._tickCount;
        }

        if (this._isRangeSlider && this._separator !== ' - ') {
            attrs[SixOrbit.data('separator')] = this._separator;
        }

        // Merge user-defined data attributes
        Object.entries(this._dataAttributes).forEach(([key, value]) => {
            attrs[SixOrbit.data(key)] = value;
        });

        return attrs;
    }

    /**
     * Render content (inputs and track structure)
     * @returns {string}
     */
    renderContent() {
        let html = '';

        // Render input(s)
        if (this._isRangeSlider) {
            html += this._renderRangeInputs();
        } else {
            html += this._renderSingleInput();
        }

        // Render track structure
        html += this._renderTrack();

        return html;
    }

    /**
     * Render single range input
     * @returns {string}
     * @private
     */
    _renderSingleInput() {
        const attrs = {
            type: 'range',
            class: SixOrbit.cls('slider-input'),
            min: this._min,
            max: this._max,
            value: this._value ?? this._min,
        };

        if (this._step !== 1) {
            attrs.step = this._step;
        }

        if (this._name) {
            attrs.name = this._name;
        }

        if (this._disabled) {
            attrs.disabled = true;
        }

        return this._buildInputTag(attrs);
    }

    /**
     * Render dual range inputs for range slider
     * @returns {string}
     * @private
     */
    _renderRangeInputs() {
        let html = '';

        // Min input
        const minAttrs = {
            type: 'range',
            class: `${SixOrbit.cls('slider-input')} ${SixOrbit.cls('slider-input-min')}`,
            min: this._min,
            max: this._max,
            value: this._value ?? this._min,
        };

        if (this._step !== 1) {
            minAttrs.step = this._step;
        }

        if (this._name) {
            minAttrs.name = this._name;
        }

        if (this._disabled) {
            minAttrs.disabled = true;
        }

        html += this._buildInputTag(minAttrs);

        // Max input
        const maxAttrs = {
            type: 'range',
            class: `${SixOrbit.cls('slider-input')} ${SixOrbit.cls('slider-input-max')}`,
            min: this._min,
            max: this._max,
            value: this._valueEnd ?? this._max,
        };

        if (this._step !== 1) {
            maxAttrs.step = this._step;
        }

        if (this._name) {
            maxAttrs.name = this._name + '_end';
        }

        if (this._disabled) {
            maxAttrs.disabled = true;
        }

        html += this._buildInputTag(maxAttrs);

        return html;
    }

    /**
     * Build an input tag from attributes
     * @param {Object} attrs
     * @returns {string}
     * @private
     */
    _buildInputTag(attrs) {
        let html = '<input';

        Object.entries(attrs).forEach(([name, value]) => {
            if (value === true) {
                html += ` ${name}`;
            } else if (value !== false && value !== null && value !== undefined) {
                html += ` ${name}="${this._escapeHtml(String(value))}"`;
            }
        });

        html += '>';

        return html;
    }

    /**
     * Render the track structure
     * @returns {string}
     * @private
     */
    _renderTrack() {
        let html = `<div class="${SixOrbit.cls('slider-track')}">`;
        html += `<div class="${SixOrbit.cls('slider-fill')}"></div>`;

        if (this._isRangeSlider) {
            // Two thumbs for range slider
            html += `<div class="${SixOrbit.cls('slider-thumb')} ${SixOrbit.cls('slider-thumb-min')}"></div>`;
            html += `<div class="${SixOrbit.cls('slider-thumb')} ${SixOrbit.cls('slider-thumb-max')}"></div>`;
        } else {
            // Single thumb
            html += `<div class="${SixOrbit.cls('slider-thumb')}">`;

            // Tooltip inside thumb if enabled
            if (this._showTooltip) {
                const tooltipValue = this._value ?? this._min;
                html += `<span class="${SixOrbit.cls('slider-tooltip')}">${this._escapeHtml(String(tooltipValue))}</span>`;
            }

            html += '</div>';
        }

        // Tick marks container for discrete slider
        if (this._tickCount > 0) {
            html += `<div class="${SixOrbit.cls('slider-ticks')}"></div>`;
        }

        html += '</div>';

        return html;
    }

    /**
     * Render to DOM element
     * @returns {HTMLElement}
     */
    render() {
        const el = document.createElement(this.getTagName());

        // Apply classes
        el.className = this.buildClassString();

        // Apply attributes
        const attrs = this.buildAttributes();
        Object.entries(attrs).forEach(([name, value]) => {
            if (value === true || value === '') {
                el.setAttribute(name, '');
            } else if (value !== false && value !== null && value !== undefined) {
                el.setAttribute(name, value);
            }
        });

        // Add content (inputs and track)
        el.innerHTML = this.renderContent();

        this.element = el;
        this._attachEventHandlers();
        return el;
    }

    // ==================
    // Config Export
    // ==================

    /**
     * Convert to config object
     * @returns {Object}
     */
    toConfig() {
        const config = super.toConfig();

        if (this._min !== 0) config.min = this._min;
        if (this._max !== 100) config.max = this._max;
        if (this._step !== 1) config.step = this._step;
        if (this._isRangeSlider) config.range = true;
        if (this._valueEnd !== null) config.valueEnd = this._valueEnd;
        if (this._showTooltip) config.showTooltip = true;
        if (this._tickCount > 0) config.ticks = this._tickCount;
        if (this._variant !== 'primary') config.variant = this._variant;
        if (this._size) config.size = this._size;
        if (this._vertical) config.vertical = true;
        if (this._suffix) config.suffix = this._suffix;
        if (this._prefix) config.prefix = this._prefix;
        if (this._output) config.output = this._output;
        if (this._separator !== ' - ') config.separator = this._separator;

        return config;
    }
}

export default Slider;
export { Slider };
