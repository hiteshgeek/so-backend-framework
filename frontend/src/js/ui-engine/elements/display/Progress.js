// ===========================================================================================
// SIXORBIT UI ENGINE - PROGRESS ELEMENT
// Comprehensive progress indicators with linear and circular variants
// ===========================================================================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class Progress extends Element {
    static NAME = 'ui-progress';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'progress', tagName: 'div' };
    static instances = new Map();

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._progressType = config.progressType || 'linear';
        this._value = config.value ?? 0;
        this._min = config.min ?? 0;
        this._max = config.max ?? 100;
        this._color = config.color || null;
        this._size = config.size || null;
        this._showLabel = config.showLabel || false;
        this._labelText = config.labelText || null;
        this._striped = config.striped || false;
        this._animated = config.animated || false;
        this._indeterminate = config.indeterminate || false;
        this._bufferValue = config.bufferValue || null;
        this._gradient = config.gradient || null;
        this._segments = config.segments || [];
        this._steps = config.steps || [];
        this._externalLabel = config.externalLabel || null;
        this._onProgress = config.onProgress || null;
    }

    // Configuration API
    linear() { this._progressType = 'linear'; return this; }
    circular() { this._progressType = 'circular'; return this; }
    value(v) { this._value = v; return this; }
    max(m) { this._max = m; return this; }
    min(m) { this._min = m; return this; }
    color(c) { this._color = c; return this; }
    primary() { return this.color('primary'); }
    secondary() { return this.color('secondary'); }
    success() { return this.color('success'); }
    danger() { return this.color('danger'); }
    warning() { return this.color('warning'); }
    info() { return this.color('info'); }
    light() { return this.color('light'); }
    dark() { return this.color('dark'); }
    size(s) { this._size = s; return this; }
    extraSmall() { return this.size('xs'); }
    small() { return this.size('sm'); }
    large() { return this.size('lg'); }
    extraLarge() { return this.size('xl'); }
    showLabel(show = true, text = null) {
        this._showLabel = show;
        if (text) this._labelText = text;
        return this;
    }
    striped(s = true) { this._striped = s; return this; }
    animated(a = true) {
        this._animated = a;
        if (a) this._striped = true;
        return this;
    }
    indeterminate(i = true) { this._indeterminate = i; return this; }
    buffer(val) { this._bufferValue = val; return this; }
    gradient(variant = null) { this._gradient = variant || 'gradient'; return this; }
    segment(value, color, label = null) {
        this._segments.push({ value, color, label });
        return this;
    }
    step(active = false, partial = null) {
        this._steps.push({ active, partial });
        return this;
    }
    externalLabel(title, value) {
        this._externalLabel = { title, value };
        return this;
    }
    onProgress(callback) { this._onProgress = callback; return this; }

    _calculatePercent(val = null) {
        const v = val !== null ? val : this._value;
        const range = this._max - this._min;
        return range > 0 ? ((v - this._min) / range) * 100 : 0;
    }

    buildClassString() {
        if (this._progressType === 'circular') {
            let cls = SixOrbit.cls('progress-circular');
            if (this._size) cls += ` ${SixOrbit.cls('progress-circular', this._size)}`;
            if (this._color) cls += ` ${SixOrbit.cls('progress-circular', this._color)}`;
            if (this._indeterminate) cls += ` ${SixOrbit.cls('progress-circular-indeterminate')}`;
            return cls + (this._classes ? ' ' + this._classes : '');
        }

        let cls = SixOrbit.cls('progress');
        if (this._color) cls += ` ${SixOrbit.cls('progress', this._color)}`;
        if (this._size) cls += ` ${SixOrbit.cls('progress', this._size)}`;
        if (this._striped) cls += ` ${SixOrbit.cls('progress-striped')}`;
        if (this._animated) cls += ` ${SixOrbit.cls('progress-animated')}`;
        if (this._indeterminate) cls += ` ${SixOrbit.cls('progress-indeterminate')}`;
        if (this._bufferValue !== null) cls += ` ${SixOrbit.cls('progress-buffer')}`;
        if (this._segments.length) cls += ` ${SixOrbit.cls('progress-stacked')}`;
        if (this._gradient) cls += ` ${SixOrbit.cls('progress', this._gradient)}`;
        if (this._steps.length) cls += ` ${SixOrbit.cls('progress-stepped')}`;
        return cls + (this._classes ? ' ' + this._classes : '');
    }

    _gatherAttributes() {
        const attrs = super._gatherAttributes();
        if (this._progressType === 'linear' && !this._indeterminate) {
            attrs.role = 'progressbar';
            attrs['aria-valuenow'] = this._value;
            attrs['aria-valuemin'] = this._min;
            attrs['aria-valuemax'] = this._max;
        }
        attrs[SixOrbit.data('progress')] = '';
        return attrs;
    }

    renderContent() {
        if (this._progressType === 'circular') return this._renderCircular();
        if (this._steps.length) return this._renderStepped();
        if (this._segments.length) return this._renderStacked();
        return this._renderLinear();
    }

    _renderLinear() {
        let html = `<div class="${SixOrbit.cls('progress-bar')}" style="width: ${this._calculatePercent()}%">`;
        if (this._showLabel) {
            html += `<span class="${SixOrbit.cls('progress-label')}">${this._labelText || Math.round(this._calculatePercent()) + '%'}</span>`;
        }
        html += '</div>';
        if (this._bufferValue !== null) {
            html += `<div class="${SixOrbit.cls('progress-buffer-bar')}" style="width: ${this._calculatePercent(this._bufferValue)}%"></div>`;
        }
        return html;
    }

    _renderStacked() {
        return this._segments.map(seg =>
            `<div class="${SixOrbit.cls('progress')} ${SixOrbit.cls('progress', seg.color)}" style="width: ${seg.value}%">
                <div class="${SixOrbit.cls('progress-bar')}" style="width: 100%">
                    ${seg.label ? `<span class="${SixOrbit.cls('progress-label')}">${seg.label}</span>` : ''}
                </div>
            </div>`
        ).join('');
    }

    _renderStepped() {
        return this._steps.map(step => {
            let cls = SixOrbit.cls('progress-step');
            if (step.active) cls += ` ${SixOrbit.cls('active')}`;
            if (step.partial) cls += ' partial';
            return `<div class="${cls}"${step.partial ? ` style="--step-progress: ${step.partial}%"` : ''}>
                <div class="${SixOrbit.cls('progress-step-fill')}"></div>
            </div>`;
        }).join('');
    }

    _renderCircular() {
        const sizes = {
            xs: { viewBox: '0 0 32 32', cx: 16, cy: 16, r: 13 },
            sm: { viewBox: '0 0 40 40', cx: 20, cy: 20, r: 17 },
            lg: { viewBox: '0 0 64 64', cx: 32, cy: 32, r: 27 },
            xl: { viewBox: '0 0 80 80', cx: 40, cy: 40, r: 34 },
            default: { viewBox: '0 0 48 48', cx: 24, cy: 24, r: 20 }
        };
        const size = sizes[this._size] || sizes.default;
        const circumference = 2 * Math.PI * size.r;
        const offset = this._indeterminate ? 0 : circumference * (1 - this._calculatePercent() / 100);

        let html = `<svg class="${SixOrbit.cls('progress-ring')}" viewBox="${size.viewBox}">`;
        html += `<circle class="${SixOrbit.cls('progress-ring-bg')}" cx="${size.cx}" cy="${size.cy}" r="${size.r}" fill="none"></circle>`;
        html += `<circle class="${SixOrbit.cls('progress-ring-fill')}" cx="${size.cx}" cy="${size.cy}" r="${size.r}" fill="none"`;
        if (!this._indeterminate) html += ` stroke-dasharray="${circumference}" stroke-dashoffset="${offset}"`;
        html += '></circle></svg>';
        if (this._showLabel && !this._indeterminate) {
            html += `<span class="${SixOrbit.cls('progress-text')}">${this._labelText || Math.round(this._calculatePercent()) + '%'}</span>`;
        }
        return html;
    }

    render() {
        let html = super.render();
        if (this._externalLabel) {
            html = `<div class="${SixOrbit.cls('progress-wrapper')}">
                <div class="${SixOrbit.cls('progress-header')}">
                    <span class="${SixOrbit.cls('progress-title')}">${this._externalLabel.title}</span>
                    <span class="${SixOrbit.cls('progress-value')}">${this._externalLabel.value}</span>
                </div>${html}</div>`;
        }
        if (this._element) Progress.instances.set(this._element, this);
        return html;
    }

    // Interactive Methods
    setValue(value) {
        const oldValue = this._value;
        this._value = value;
        if (this._element) {
            if (this._progressType === 'circular') {
                const fill = this._element.querySelector(`.${SixOrbit.cls('progress-ring-fill')}`);
                if (fill && !this._indeterminate) {
                    const r = parseFloat(fill.getAttribute('r'));
                    const circumference = 2 * Math.PI * r;
                    const offset = circumference * (1 - this._calculatePercent() / 100);
                    fill.setAttribute('stroke-dasharray', circumference);
                    fill.setAttribute('stroke-dashoffset', offset);
                }
                const text = this._element.querySelector(`.${SixOrbit.cls('progress-text')}`);
                if (text && this._showLabel) text.textContent = this._labelText || Math.round(this._calculatePercent()) + '%';
            } else {
                const bar = this._element.querySelector(`.${SixOrbit.cls('progress-bar')}`);
                if (bar) {
                    bar.style.width = this._calculatePercent() + '%';
                    const label = bar.querySelector(`.${SixOrbit.cls('progress-label')}`);
                    if (label && this._showLabel) label.textContent = this._labelText || Math.round(this._calculatePercent()) + '%';
                }
            }
            this._element.setAttribute('aria-valuenow', value);
            this._dispatchEvent('so:progress:change', { oldValue, newValue: value, percent: this._calculatePercent() });
            if (this._onProgress) this._onProgress(value, this._calculatePercent());
        }
        return this;
    }

    animate(from, to, duration = 1000) {
        const start = performance.now();
        const animate = (time) => {
            const elapsed = time - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            this.setValue(from + (to - from) * eased);
            if (progress < 1) requestAnimationFrame(animate);
        };
        requestAnimationFrame(animate);
        return this;
    }

    getValue() { return this._value; }
    getPercent() { return this._calculatePercent(); }

    static getInstance(element) {
        if (typeof element === 'string') element = document.querySelector(element);
        if (!element) return null;
        if (Progress.instances.has(element)) return Progress.instances.get(element);
        const config = {
            value: parseInt(element.getAttribute(SixOrbit.data('value'))) || 0,
            max: parseInt(element.getAttribute(SixOrbit.data('max'))) || 100,
            min: parseInt(element.getAttribute(SixOrbit.data('min'))) || 0,
        };
        const instance = new Progress(config);
        instance._element = element;
        Progress.instances.set(element, instance);
        return instance;
    }

    static initAll() {
        document.querySelectorAll(`[${SixOrbit.data('progress')}]`).forEach(el => {
            if (!Progress.instances.has(el)) Progress.getInstance(el);
        });
    }

    toConfig() {
        const config = super.toConfig();
        config.progressType = this._progressType;
        config.value = this._value;
        if (this._min !== 0) config.min = this._min;
        if (this._max !== 100) config.max = this._max;
        if (this._color) config.color = this._color;
        if (this._size) config.size = this._size;
        if (this._showLabel) config.showLabel = true;
        if (this._labelText) config.labelText = this._labelText;
        if (this._striped) config.striped = true;
        if (this._animated) config.animated = true;
        if (this._indeterminate) config.indeterminate = true;
        if (this._bufferValue !== null) config.bufferValue = this._bufferValue;
        if (this._gradient) config.gradient = this._gradient;
        if (this._segments.length) config.segments = this._segments;
        if (this._steps.length) config.steps = this._steps;
        if (this._externalLabel) config.externalLabel = this._externalLabel;
        return config;
    }
}

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => Progress.initAll());
    } else {
        Progress.initAll();
    }
}

export default Progress;
export { Progress };
