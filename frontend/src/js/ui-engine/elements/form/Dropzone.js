// ============================================
// SIXORBIT UI ENGINE - DROPZONE ELEMENT
// Drag-drop file upload
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Dropzone - Drag-drop file upload
 */
class Dropzone extends FormElement {
    static NAME = 'ui-dropzone';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'dropzone',
        tagName: 'div',
    };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._accept = config.accept || null;
        this._multiple = config.multiple !== false;
        this._maxFileSize = config.maxFileSize || null;
        this._maxFiles = config.maxFiles || null;
        this._uploadUrl = config.uploadUrl || null;
        this._showPreview = config.showPreview !== false;
        this._autoUpload = config.autoUpload || false;
        this._message = config.message || 'Drop files here or click to upload';
        this._icon = config.icon || 'cloud_upload';
        this._existingFiles = config.existingFiles || [];
    }

    accept(val) { this._accept = val; return this; }
    images() { return this.accept('image/*'); }
    documents() { return this.accept('.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt'); }
    videos() { return this.accept('video/*'); }
    multiple(val = true) { this._multiple = val; return this; }
    single() { return this.multiple(false); }
    maxFileSize(bytes) { this._maxFileSize = bytes; return this; }
    maxFileSizeMB(mb) { return this.maxFileSize(mb * 1024 * 1024); }
    maxFiles(max) { this._maxFiles = max; return this; }
    uploadUrl(url) { this._uploadUrl = url; return this; }
    showPreview(val = true) { this._showPreview = val; return this; }
    hidePreview() { return this.showPreview(false); }
    autoUpload(val = true) { this._autoUpload = val; return this; }
    message(msg) { this._message = msg; return this; }
    icon(icon) { this._icon = icon; return this; }
    existingFiles(files) { this._existingFiles = files; return this; }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('dropzone'));
        if (this._error) this._extraClasses.add(SixOrbit.cls('is-invalid'));
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs[SixOrbit.data('ui-init')] = 'dropzone';

        const config = {
            multiple: this._multiple,
            showPreview: this._showPreview,
            autoUpload: this._autoUpload,
        };
        if (this._accept) config.accept = this._accept;
        if (this._maxFileSize) config.maxFileSize = this._maxFileSize;
        if (this._maxFiles) config.maxFiles = this._maxFiles;
        if (this._uploadUrl) config.uploadUrl = this._uploadUrl;
        if (this._existingFiles.length > 0) config.existingFiles = this._existingFiles;

        attrs[SixOrbit.data('ui-config')] = JSON.stringify(config);
        return attrs;
    }

    renderContent() {
        let html = `<div class="${SixOrbit.cls('dropzone-area')}">`;
        html += `<span class="material-icons ${SixOrbit.cls('dropzone-icon')}">${this._escapeHtml(this._icon)}</span>`;
        html += `<p class="${SixOrbit.cls('dropzone-message')}">${this._escapeHtml(this._message)}</p>`;
        html += `<input type="file" class="${SixOrbit.cls('dropzone-input')}"`;
        if (this._name) html += ` name="${this._escapeHtml(this._name)}${this._multiple ? '[]' : ''}"`;
        if (this._accept) html += ` accept="${this._escapeHtml(this._accept)}"`;
        if (this._multiple) html += ' multiple';
        html += '>';
        html += '</div>';
        if (this._showPreview) {
            html += `<div class="${SixOrbit.cls('dropzone-preview')}"></div>`;
        }
        return html;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._accept) config.accept = this._accept;
        if (!this._multiple) config.multiple = false;
        if (this._maxFileSize) config.maxFileSize = this._maxFileSize;
        if (this._maxFiles) config.maxFiles = this._maxFiles;
        if (this._uploadUrl) config.uploadUrl = this._uploadUrl;
        if (!this._showPreview) config.showPreview = false;
        if (this._autoUpload) config.autoUpload = true;
        if (this._message !== 'Drop files here or click to upload') config.message = this._message;
        if (this._icon !== 'cloud_upload') config.icon = this._icon;
        if (this._existingFiles.length > 0) config.existingFiles = this._existingFiles;
        return config;
    }
}

export default Dropzone;
export { Dropzone };
