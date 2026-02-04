// ============================================
// SIXORBIT UI ENGINE - TOAST ELEMENT
// Toast notifications
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class Toast extends Element {
    static NAME = 'ui-toast';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'toast', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._variant = config.variant || 'default';
        this._message = config.message || null;
        this._title = config.title || null;
        this._icon = config.icon || null;
        this._dismissible = config.dismissible !== false;
        this._autoDismiss = config.autoDismiss ?? 5000;
        this._position = config.position || 'top-right';
    }

    variant(v) { this._variant = v; return this; }
    success() { return this.variant('success').icon('check_circle'); }
    danger() { return this.variant('danger').icon('error'); }
    warning() { return this.variant('warning').icon('warning'); }
    info() { return this.variant('info').icon('info'); }
    message(msg) { this._message = msg; return this; }
    title(title) { this._title = title; return this; }
    icon(icon) { this._icon = icon; return this; }
    dismissible(val = true) { this._dismissible = val; return this; }
    autoDismiss(ms) { this._autoDismiss = ms; return this; }
    position(pos) { this._position = pos; return this; }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('toast'));
        this._extraClasses.add(SixOrbit.cls('toast', this._variant));
        if (this._dismissible) {
            this._extraClasses.add(SixOrbit.cls('fade'));
            this._extraClasses.add(SixOrbit.cls('show'));
        }
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs.role = 'alert';
        attrs['aria-live'] = 'assertive';
        attrs['aria-atomic'] = 'true';
        attrs[SixOrbit.data('autohide')] = this._autoDismiss > 0 ? 'true' : 'false';
        attrs[SixOrbit.data('delay')] = this._autoDismiss;
        attrs[SixOrbit.data('ui-init')] = 'toast';
        attrs[SixOrbit.data('ui-config')] = JSON.stringify({
            autoDismiss: this._autoDismiss,
            position: this._position
        });
        return attrs;
    }

    renderContent() {
        let html = `<div class="${SixOrbit.cls('toast-header')}">`;
        if (this._icon) {
            html += `<span class="material-icons ${SixOrbit.cls('me-2')}">${this._escapeHtml(this._icon)}</span>`;
        }
        if (this._title) {
            html += `<strong class="${SixOrbit.cls('me-auto')}">${this._escapeHtml(this._title)}</strong>`;
        }
        if (this._dismissible) {
            html += `<button type="button" class="${SixOrbit.cls('btn-close')}" ${SixOrbit.data('dismiss')}="toast" aria-label="Close"></button>`;
        }
        html += '</div>';
        html += `<div class="${SixOrbit.cls('toast-body')}">`;
        if (this._message) html += this._escapeHtml(this._message);
        html += '</div>';
        return html;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._variant !== 'default') config.variant = this._variant;
        if (this._message) config.message = this._message;
        if (this._title) config.title = this._title;
        if (this._icon) config.icon = this._icon;
        if (!this._dismissible) config.dismissible = false;
        if (this._autoDismiss !== 5000) config.autoDismiss = this._autoDismiss;
        if (this._position !== 'top-right') config.position = this._position;
        return config;
    }
}

export default Toast;
export { Toast };
