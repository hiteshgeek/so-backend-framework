// ============================================
// SIXORBIT UI ENGINE - FILE INPUT ELEMENT
// File upload input
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * FileInput - File upload element
 */
class FileInput extends FormElement {
    static NAME = 'ui-file-input';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'file-input',
        tagName: 'input',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._accept = config.accept || null;
        this._multiple = config.multiple || false;
        this._capture = config.capture || null;
        this._maxSize = config.maxSize || null;
        this._preview = config.preview || false;
        this._dropzone = config.dropzone || false;
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set accepted file types
     * @param {string} accept - MIME types or extensions
     * @returns {this}
     */
    accept(accept) {
        this._accept = accept;
        return this;
    }

    /**
     * Accept images only
     * @returns {this}
     */
    images() {
        return this.accept('image/*');
    }

    /**
     * Accept videos only
     * @returns {this}
     */
    videos() {
        return this.accept('video/*');
    }

    /**
     * Accept audio only
     * @returns {this}
     */
    audio() {
        return this.accept('audio/*');
    }

    /**
     * Accept PDFs
     * @returns {this}
     */
    pdf() {
        return this.accept('application/pdf,.pdf');
    }

    /**
     * Accept documents
     * @returns {this}
     */
    documents() {
        return this.accept('.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt');
    }

    /**
     * Set multiple files
     * @param {boolean} val
     * @returns {this}
     */
    multiple(val = true) {
        this._multiple = val;
        return this;
    }

    /**
     * Set maximum file size in bytes
     * @param {number} bytes
     * @returns {this}
     */
    maxSize(bytes) {
        this._maxSize = bytes;
        return this;
    }

    /**
     * Set maximum file size in megabytes
     * @param {number} mb
     * @returns {this}
     */
    maxSizeMB(mb) {
        return this.maxSize(mb * 1024 * 1024);
    }

    /**
     * Set capture mode (camera, microphone)
     * @param {string} type - user, environment
     * @returns {this}
     */
    capture(type = 'user') {
        this._capture = type;
        return this;
    }

    /**
     * Use front camera
     * @returns {this}
     */
    frontCamera() {
        return this.capture('user');
    }

    /**
     * Use back camera
     * @returns {this}
     */
    backCamera() {
        return this.capture('environment');
    }

    /**
     * Enable file preview
     * @param {boolean} val
     * @returns {this}
     */
    preview(val = true) {
        this._preview = val;
        return this;
    }

    /**
     * Enable drag and drop zone
     * @param {boolean} val
     * @returns {this}
     */
    dropzone(val = true) {
        this._dropzone = val;
        return this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Get tag name
     * @returns {string}
     */
    getTagName() {
        return 'input';
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        attrs.type = 'file';

        if (this._accept) attrs.accept = this._accept;
        if (this._multiple) attrs.multiple = true;
        if (this._capture) attrs.capture = this._capture;
        if (this._maxSize) attrs[SixOrbit.data('max-size')] = this._maxSize;
        if (this._preview) attrs[SixOrbit.data('preview')] = 'true';
        if (this._dropzone) attrs[SixOrbit.data('dropzone')] = 'true';

        // Remove value (not applicable for file inputs)
        delete attrs.value;

        return attrs;
    }

    /**
     * Don't render value as attribute
     * @returns {boolean}
     */
    _shouldRenderValueAttr() {
        return false;
    }

    /**
     * Render content (empty for input)
     * @returns {string}
     */
    renderContent() {
        return '';
    }

    /**
     * Render to DOM (matches PHP structure)
     * @returns {HTMLElement}
     */
    render() {
        if (this._dropzone) {
            return this._renderDropzone();
        }
        return this._renderStyledInput();
    }

    /**
     * Render styled file input with wrapper (matches PHP)
     * @returns {HTMLElement}
     * @private
     */
    _renderStyledInput() {
        const wrapper = document.createElement('div');
        wrapper.className = SixOrbit.cls('form-control-file');

        // Render the actual file input
        const input = super.render();
        wrapper.appendChild(input);

        // Add button
        const button = document.createElement('span');
        button.className = SixOrbit.cls('form-file-button');

        const icon = document.createElement('span');
        icon.className = 'material-icons';
        icon.textContent = 'upload_file';
        button.appendChild(icon);
        button.appendChild(document.createTextNode('Browse'));

        wrapper.appendChild(button);

        // Add text display
        const text = document.createElement('span');
        text.className = SixOrbit.cls('form-file-text');
        text.textContent = 'No file chosen';
        wrapper.appendChild(text);

        return wrapper;
    }

    /**
     * Render as dropzone (matches PHP)
     * @returns {HTMLElement}
     * @private
     */
    _renderDropzone() {
        const wrapper = document.createElement('div');
        wrapper.className = SixOrbit.cls('dropzone');

        // Content area
        const content = document.createElement('div');
        content.className = SixOrbit.cls('dropzone-content');

        const icon = document.createElement('span');
        icon.className = `material-icons ${SixOrbit.cls('dropzone-icon')}`;
        icon.textContent = 'cloud_upload';
        content.appendChild(icon);

        const text = document.createElement('p');
        text.className = SixOrbit.cls('dropzone-text');
        text.textContent = 'Drag and drop files here or click to browse';
        content.appendChild(text);

        if (this._accept) {
            const hint = document.createElement('p');
            hint.className = SixOrbit.cls('dropzone-hint');
            hint.textContent = `Accepted: ${this._accept}`;
            content.appendChild(hint);
        }

        if (this._maxSize) {
            const hint = document.createElement('p');
            hint.className = SixOrbit.cls('dropzone-hint');
            hint.textContent = `Max size: ${this._formatBytes(this._maxSize)}`;
            content.appendChild(hint);
        }

        wrapper.appendChild(content);

        // Hidden file input
        const input = super.render();
        wrapper.appendChild(input);

        // Preview area
        if (this._preview) {
            const preview = document.createElement('div');
            preview.className = SixOrbit.cls('dropzone-preview');
            wrapper.appendChild(preview);
        }

        return wrapper;
    }

    /**
     * Render to HTML string (matches PHP structure)
     * @returns {string}
     */
    toHtml() {
        if (this._dropzone) {
            return this._toHtmlDropzone();
        }
        return this._toHtmlStyledInput();
    }

    /**
     * Render styled input to HTML string
     * @returns {string}
     * @private
     */
    _toHtmlStyledInput() {
        let html = `<div class="${SixOrbit.cls('form-control-file')}">`;

        // Render the actual file input
        html += super.toHtml();

        // Add button
        html += `<span class="${SixOrbit.cls('form-file-button')}">`;
        html += '<span class="material-icons">upload_file</span>';
        html += 'Browse';
        html += '</span>';

        // Add text display
        html += `<span class="${SixOrbit.cls('form-file-text')}">No file chosen</span>`;

        html += '</div>';

        return html;
    }

    /**
     * Render dropzone to HTML string
     * @returns {string}
     * @private
     */
    _toHtmlDropzone() {
        let html = `<div class="${SixOrbit.cls('dropzone')}">`;
        html += `<div class="${SixOrbit.cls('dropzone-content')}">`;
        html += `<span class="material-icons ${SixOrbit.cls('dropzone-icon')}">cloud_upload</span>`;
        html += `<p class="${SixOrbit.cls('dropzone-text')}">Drag and drop files here or click to browse</p>`;

        if (this._accept) {
            html += `<p class="${SixOrbit.cls('dropzone-hint')}">Accepted: ${this._escapeHtml(this._accept)}</p>`;
        }

        if (this._maxSize) {
            html += `<p class="${SixOrbit.cls('dropzone-hint')}">Max size: ${this._formatBytes(this._maxSize)}</p>`;
        }

        html += '</div>';

        // Hidden file input
        html += super.toHtml();

        // Preview area
        if (this._preview) {
            html += `<div class="${SixOrbit.cls('dropzone-preview')}"></div>`;
        }

        html += '</div>';

        return html;
    }

    /**
     * Format bytes to human readable
     * @param {number} bytes
     * @returns {string}
     * @private
     */
    _formatBytes(bytes) {
        const units = ['B', 'KB', 'MB', 'GB'];
        let i = 0;

        while (bytes >= 1024 && i < units.length - 1) {
            bytes /= 1024;
            i++;
        }

        return `${Math.round(bytes * 100) / 100} ${units[i]}`;
    }

    /**
     * Get files
     * @returns {FileList|null}
     */
    getFiles() {
        return this.element?.files || null;
    }

    /**
     * Get value (file names)
     * @returns {string|Array}
     */
    getValue() {
        if (this.element && this.element.files) {
            const files = Array.from(this.element.files);
            if (this._multiple) {
                return files.map(f => f.name);
            }
            return files[0]?.name || '';
        }
        return '';
    }

    // ==================
    // Config Export
    // ==================

    /**
     * Convert to config
     * @returns {Object}
     */
    toConfig() {
        const config = super.toConfig();

        if (this._accept) config.accept = this._accept;
        if (this._multiple) config.multiple = true;
        if (this._capture) config.capture = this._capture;
        if (this._maxSize) config.maxSize = this._maxSize;
        if (this._preview) config.preview = true;
        if (this._dropzone) config.dropzone = true;

        return config;
    }
}

export default FileInput;
export { FileInput };
