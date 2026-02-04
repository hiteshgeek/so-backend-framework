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
