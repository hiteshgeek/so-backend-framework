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

        // Store DOM element if provided (for initialization from existing DOM)
        if (config._domElement) {
            this._domElement = config._domElement;
            // Initialize component after storing DOM reference
            this._initializeComponent();
        }

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
        this._extraClasses.add(SixOrbit.cls('form-file-dropzone'));
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
        let html = '';

        // Hidden file input
        html += '<input type="file"';
        if (this._name) html += ` name="${this._escapeHtml(this._name)}${this._multiple ? '[]' : ''}"`;
        if (this._accept) html += ` accept="${this._escapeHtml(this._accept)}"`;
        if (this._multiple) html += ' multiple';
        html += '>';

        // Icon
        html += `<div class="${SixOrbit.cls('form-file-dropzone-icon')}">`;
        html += `<span class="material-icons">${this._escapeHtml(this._icon)}</span>`;
        html += '</div>';

        // Message text
        html += `<div class="${SixOrbit.cls('form-file-dropzone-text')}">`;
        html += this._escapeHtml(this._message);
        html += '</div>';

        // Hint text
        if (this._accept || this._maxFileSize) {
            html += `<div class="${SixOrbit.cls('form-file-dropzone-hint')}">`;
            const hints = [];
            if (this._accept) hints.push(`Accepts: ${this._escapeHtml(this._accept)}`);
            if (this._maxFileSize) {
                const maxMB = Math.round(this._maxFileSize / 1024 / 1024);
                hints.push(`Max ${maxMB}MB`);
            }
            html += hints.join(' | ');
            html += '</div>';
        }

        // Preview area
        if (this._showPreview) {
            html += `<div class="${SixOrbit.cls('form-file-dropzone-files')}"></div>`;
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

    /**
     * Initialize dropzone after DOM is ready
     * Called automatically when initialized from existing DOM
     */
    _initializeComponent() {
        console.log('Dropzone _initializeComponent called', this._domElement);

        if (!this._domElement) {
            console.warn('Dropzone: No _domElement found');
            return;
        }

        const fileInput = this._domElement.querySelector('input[type="file"]');
        const filesContainer = this._domElement.querySelector(`.${SixOrbit.cls('form-file-dropzone-files')}`);

        console.log('Dropzone fileInput:', fileInput);
        console.log('Dropzone filesContainer:', filesContainer);

        if (!fileInput) {
            console.warn('Dropzone: No file input found');
            return;
        }

        // Click anywhere on dropzone to select files
        this._domElement.addEventListener('click', (e) => {
            if (e.target !== fileInput) {
                fileInput.click();
            }
        });

        // Drag and drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            this._domElement.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        this._domElement.addEventListener('dragenter', () => {
            this._domElement.classList.add(SixOrbit.cls('dragover'));
        });

        this._domElement.addEventListener('dragleave', (e) => {
            if (e.target === this._domElement) {
                this._domElement.classList.remove(SixOrbit.cls('dragover'));
            }
        });

        this._domElement.addEventListener('drop', (e) => {
            this._domElement.classList.remove(SixOrbit.cls('dragover'));
            const files = e.dataTransfer.files;
            this._handleFiles(files, filesContainer);
        });

        // File input change
        fileInput.addEventListener('change', (e) => {
            this._handleFiles(e.target.files, filesContainer);
        });
    }

    /**
     * Handle selected files
     * @private
     */
    _handleFiles(files, filesContainer) {
        console.log('Dropzone _handleFiles called', files, filesContainer);

        if (!files || files.length === 0) return;

        let fileArray = Array.from(files);
        console.log('File array:', fileArray);

        // Validate max files
        if (this._maxFiles && fileArray.length > this._maxFiles) {
            console.warn(`Maximum ${this._maxFiles} files allowed`);
            fileArray = fileArray.slice(0, this._maxFiles);
        }

        // Validate file size
        if (this._maxFileSize) {
            fileArray = fileArray.filter(file => {
                if (file.size > this._maxFileSize) {
                    console.warn(`File ${file.name} exceeds maximum size of ${this._maxFileSize / 1024 / 1024}MB`);
                    return false;
                }
                return true;
            });
        }

        // Always update text to show file count and names
        if (fileArray.length > 0) {
            const textEl = this._domElement.querySelector(`.${SixOrbit.cls('form-file-dropzone-text')}`);
            if (textEl) {
                const fileNames = fileArray.map(f => f.name).join(', ');
                textEl.innerHTML = `<strong>${fileArray.length} file(s) selected:</strong> ${fileNames}`;
            }
        }

        // Auto upload if enabled
        if (this._autoUpload && this._uploadUrl) {
            this._uploadFiles(fileArray);
        }
    }

    /**
     * Create preview for a file
     * @private
     */
    _createPreview(file, filesContainer) {
        if (!filesContainer) return;

        const item = document.createElement('div');
        item.className = SixOrbit.cls('form-file-dropzone-file');

        let content = '';
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = item.querySelector('img');
                if (img) img.src = e.target.result;
            };
            reader.readAsDataURL(file);
            content = `<img class="${SixOrbit.cls('dropzone-thumb')}" alt="${this._escapeHtml(file.name)}">`;
        } else {
            content = `<span class="material-icons ${SixOrbit.cls('dropzone-file-icon')}">description</span>`;
        }

        item.innerHTML = `
            ${content}
            <div class="${SixOrbit.cls('dropzone-file-info')}">
                <span class="${SixOrbit.cls('dropzone-filename')}">${this._escapeHtml(file.name)}</span>
                <span class="${SixOrbit.cls('dropzone-filesize')}">${this._formatFileSize(file.size)}</span>
            </div>
            <button type="button" class="${SixOrbit.cls('dropzone-remove')}" aria-label="Remove">
                <span class="material-icons">close</span>
            </button>
        `;

        const removeBtn = item.querySelector(`.${SixOrbit.cls('dropzone-remove')}`);
        removeBtn.addEventListener('click', () => {
            item.remove();
        });

        filesContainer.appendChild(item);
    }

    /**
     * Format file size for display
     * @private
     */
    _formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    /**
     * Upload files to server
     * @private
     */
    _uploadFiles(files) {
        // TODO: Implement actual upload logic
        console.log('Uploading files:', files);
    }
}

export default Dropzone;
export { Dropzone };
