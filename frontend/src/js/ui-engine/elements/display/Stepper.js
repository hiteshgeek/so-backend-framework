// ============================================
// SIXORBIT UI ENGINE - STEPPER ELEMENT
// Step wizard
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class Stepper extends Element {
    static NAME = 'ui-stepper';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'stepper', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._steps = config.steps || [];
        this._currentStep = config.currentStep || 0;
        this._orientation = config.orientation || 'horizontal';
        this._variant = config.variant || 'default';
        this._clickable = config.clickable || false;
    }

    steps(steps) { this._steps = steps; return this; }
    addStep(label, description = null, icon = null) {
        this._steps.push({ label, description, icon });
        return this;
    }
    currentStep(step) { this._currentStep = step; return this; }
    orientation(o) { this._orientation = o; return this; }
    horizontal() { return this.orientation('horizontal'); }
    vertical() { return this.orientation('vertical'); }
    variant(v) { this._variant = v; return this; }
    clickable(val = true) { this._clickable = val; return this; }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('stepper'));
        this._extraClasses.add(SixOrbit.cls('stepper', this._orientation));
        if (this._variant !== 'default') this._extraClasses.add(SixOrbit.cls('stepper', this._variant));
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs[SixOrbit.data('ui-init')] = 'stepper';
        attrs[SixOrbit.data('ui-config')] = JSON.stringify({
            currentStep: this._currentStep,
            clickable: this._clickable
        });
        return attrs;
    }

    renderContent() {
        let html = '';
        this._steps.forEach((step, idx) => {
            let stepClass = SixOrbit.cls('stepper-step');
            if (idx < this._currentStep) stepClass += ` ${SixOrbit.cls('completed')}`;
            if (idx === this._currentStep) stepClass += ` ${SixOrbit.cls('active')}`;

            html += `<div class="${stepClass}"`;
            if (this._clickable) html += ` ${SixOrbit.data('step')}="${idx}"`;
            html += '>';

            html += `<div class="${SixOrbit.cls('stepper-indicator')}">`;
            if (step.icon) {
                html += `<span class="material-icons">${this._escapeHtml(step.icon)}</span>`;
            } else if (idx < this._currentStep) {
                html += '<span class="material-icons">check</span>';
            } else {
                html += `<span>${idx + 1}</span>`;
            }
            html += '</div>';

            html += `<div class="${SixOrbit.cls('stepper-content')}">`;
            html += `<div class="${SixOrbit.cls('stepper-label')}">${this._escapeHtml(step.label)}</div>`;
            if (step.description) {
                html += `<div class="${SixOrbit.cls('stepper-description')}">${this._escapeHtml(step.description)}</div>`;
            }
            html += '</div></div>';

            // Connector line (except for last step)
            if (idx < this._steps.length - 1) {
                html += `<div class="${SixOrbit.cls('stepper-connector')}"></div>`;
            }
        });
        return html;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._steps.length > 0) config.steps = this._steps;
        if (this._currentStep !== 0) config.currentStep = this._currentStep;
        if (this._orientation !== 'horizontal') config.orientation = this._orientation;
        if (this._variant !== 'default') config.variant = this._variant;
        if (this._clickable) config.clickable = true;
        return config;
    }
}

export default Stepper;
export { Stepper };
