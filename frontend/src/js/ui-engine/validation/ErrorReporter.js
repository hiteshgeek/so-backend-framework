// ============================================
// SIXORBIT UI ENGINE - ERROR REPORTER
// Centralized error display UI
// ============================================

import SOComponent from '../../core/so-component.js';
import SixOrbit from '../../core/so-config.js';

/**
 * ErrorReporter - Centralized error display component
 * Supports multiple positions and styles
 */
class ErrorReporter extends SOComponent {
    static NAME = 'error-reporter';

    /**
     * Supported positions
     */
    static POSITIONS = {
        TOP_RIGHT: 'top-right',
        TOP_LEFT: 'top-left',
        TOP_CENTER: 'top-center',
        BOTTOM_RIGHT: 'bottom-right',
        BOTTOM_LEFT: 'bottom-left',
        BOTTOM_CENTER: 'bottom-center',
        INLINE_TOP: 'inline-top',
        INLINE_BOTTOM: 'inline-bottom',
    };

    static DEFAULTS = {
        position: 'top-right',
        autoHide: false,
        autoHideDelay: 5000,
        animation: 'fade',
        maxErrors: 10,
        groupByField: true,
        showFieldLinks: true,
        dismissible: true,
        theme: 'default',
    };

    /**
     * Singleton instance
     * @type {ErrorReporter|null}
     */
    static _instance = null;

    /**
     * Get singleton instance
     * @param {Object} options
     * @returns {ErrorReporter}
     */
    static getInstance(options = {}) {
        if (!this._instance) {
            this._instance = new ErrorReporter(null, options);
        }
        return this._instance;
    }

    /**
     * Create a new ErrorReporter
     * @param {Element|null} element
     * @param {Object} options
     */
    constructor(element, options = {}) {
        // Create container if not provided
        if (!element) {
            element = document.createElement('div');
            element.className = SixOrbit.cls('error-reporter');
            document.body.appendChild(element);
        }

        super(element, options);

        this._errors = {};
        this._autoHideTimer = null;
    }

    /**
     * Initialize the component
     * @private
     */
    _init() {
        this._updatePosition();
        this._bindEvents();
    }

    /**
     * Update container position
     * @private
     */
    _updatePosition() {
        const position = this.options.position;

        // Remove existing position classes
        Object.values(ErrorReporter.POSITIONS).forEach(pos => {
            this.element.classList.remove(SixOrbit.cls('error-reporter', pos));
        });

        // Add new position class
        this.element.classList.add(SixOrbit.cls('error-reporter', position));
    }

    /**
     * Bind event handlers
     * @private
     */
    _bindEvents() {
        // Close button click
        this.delegate('click', SixOrbit.sel('error-reporter-close'), () => {
            this.clearAll();
        });

        // Error item click (focus field)
        if (this.options.showFieldLinks) {
            this.delegate('click', SixOrbit.sel('error-reporter-item'), (e, target) => {
                const field = target.dataset.field;
                if (field) {
                    this._focusField(field);
                }
            });
        }

        // Dismiss individual error
        if (this.options.dismissible) {
            this.delegate('click', SixOrbit.sel('error-item-close'), (e, target) => {
                e.stopPropagation();
                const item = target.closest(SixOrbit.sel('error-reporter-item'));
                if (item) {
                    const field = item.dataset.field;
                    if (field) {
                        this.clearField(field);
                    }
                }
            });
        }
    }

    // ==================
    // Configuration
    // ==================

    /**
     * Configure the reporter
     * @param {Object} options
     * @returns {this}
     */
    configure(options) {
        this.setOptions(options);

        if (options.position) {
            this._updatePosition();
        }

        return this;
    }

    /**
     * Set position
     * @param {string} position
     * @returns {this}
     */
    setPosition(position) {
        this.options.position = position;
        this._updatePosition();
        return this;
    }

    // ==================
    // Error Management
    // ==================

    /**
     * Show all errors at once
     * @param {Object} errors - Field => messages map
     * @returns {this}
     */
    showAll(errors) {
        this._errors = { ...errors };
        this._render();
        this._startAutoHide();
        return this;
    }

    /**
     * Add errors (merge with existing)
     * @param {Object} errors
     * @returns {this}
     */
    addErrors(errors) {
        Object.entries(errors).forEach(([field, messages]) => {
            this._errors[field] = Array.isArray(messages) ? messages : [messages];
        });
        this._render();
        this._startAutoHide();
        return this;
    }

    /**
     * Add error for single field
     * @param {string} field
     * @param {string|string[]} messages
     * @returns {this}
     */
    addError(field, messages) {
        this._errors[field] = Array.isArray(messages) ? messages : [messages];
        this._render();
        this._startAutoHide();
        return this;
    }

    /**
     * Clear errors for a field
     * @param {string} field
     * @returns {this}
     */
    clearField(field) {
        delete this._errors[field];
        this._render();
        return this;
    }

    /**
     * Clear all errors
     * @returns {this}
     */
    clearAll() {
        this._errors = {};
        this._render();
        this._stopAutoHide();
        return this;
    }

    /**
     * Get all errors
     * @returns {Object}
     */
    getErrors() {
        return { ...this._errors };
    }

    /**
     * Check if has errors
     * @returns {boolean}
     */
    hasErrors() {
        return Object.keys(this._errors).length > 0;
    }

    /**
     * Get error count
     * @returns {number}
     */
    getErrorCount() {
        let count = 0;
        Object.values(this._errors).forEach(messages => {
            count += Array.isArray(messages) ? messages.length : 1;
        });
        return count;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Render the error display
     * @private
     */
    _render() {
        const errorCount = Object.keys(this._errors).length;

        if (errorCount === 0) {
            this.element.innerHTML = '';
            this.element.classList.remove(SixOrbit.cls('show'));
            this.emit('cleared');
            return;
        }

        const totalMessages = this.getErrorCount();

        this.element.innerHTML = `
            <div class="${SixOrbit.cls('error-reporter-content')}">
                <div class="${SixOrbit.cls('error-reporter-header')}">
                    <span class="material-icons ${SixOrbit.cls('text-danger')}">error</span>
                    <span class="${SixOrbit.cls('error-reporter-title')}">
                        ${totalMessages} ${totalMessages === 1 ? 'error' : 'errors'} found
                    </span>
                    <button type="button" class="${SixOrbit.cls('error-reporter-close')}" aria-label="Close">
                        <span class="material-icons">close</span>
                    </button>
                </div>
                <ul class="${SixOrbit.cls('error-reporter-list')}">
                    ${this._renderErrors()}
                </ul>
            </div>
        `;

        this.element.classList.add(SixOrbit.cls('show'));
        this.emit('shown', { errors: this._errors, count: totalMessages });
    }

    /**
     * Render error list items
     * @returns {string}
     * @private
     */
    _renderErrors() {
        const maxErrors = this.options.maxErrors;
        let renderedCount = 0;
        let html = '';

        for (const [field, messages] of Object.entries(this._errors)) {
            const fieldMessages = Array.isArray(messages) ? messages : [messages];

            for (const message of fieldMessages) {
                if (renderedCount >= maxErrors) {
                    const remaining = this.getErrorCount() - maxErrors;
                    html += `
                        <li class="${SixOrbit.cls('error-reporter-item')} ${SixOrbit.cls('error-reporter-more')}">
                            <span class="${SixOrbit.cls('text-muted')}">... and ${remaining} more error(s)</span>
                        </li>
                    `;
                    return html;
                }

                html += `
                    <li class="${SixOrbit.cls('error-reporter-item')}" data-field="${this._escapeHtml(field)}">
                        ${this.options.groupByField ? `
                            <span class="${SixOrbit.cls('error-field')}">${this._formatFieldName(field)}:</span>
                        ` : ''}
                        <span class="${SixOrbit.cls('error-message')}">${this._escapeHtml(message)}</span>
                        ${this.options.dismissible ? `
                            <button type="button" class="${SixOrbit.cls('error-item-close')}" aria-label="Dismiss">
                                <span class="material-icons">close</span>
                            </button>
                        ` : ''}
                    </li>
                `;

                renderedCount++;
            }
        }

        return html;
    }

    /**
     * Format field name for display
     * @param {string} field
     * @returns {string}
     * @private
     */
    _formatFieldName(field) {
        return field
            .replace(/([a-z])([A-Z])/g, '$1 $2')
            .replace(/[_-]/g, ' ')
            .replace(/\b\w/g, l => l.toUpperCase());
    }

    /**
     * Escape HTML
     * @param {string} str
     * @returns {string}
     * @private
     */
    _escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // ==================
    // Auto-hide
    // ==================

    /**
     * Start auto-hide timer
     * @private
     */
    _startAutoHide() {
        if (!this.options.autoHide) return;

        this._stopAutoHide();
        this._autoHideTimer = setTimeout(() => {
            this.clearAll();
        }, this.options.autoHideDelay);
    }

    /**
     * Stop auto-hide timer
     * @private
     */
    _stopAutoHide() {
        if (this._autoHideTimer) {
            clearTimeout(this._autoHideTimer);
            this._autoHideTimer = null;
        }
    }

    // ==================
    // Field Focus
    // ==================

    /**
     * Focus a field by name
     * @param {string} fieldName
     * @private
     */
    _focusField(fieldName) {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.focus();
            field.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // ==================
    // Lifecycle
    // ==================

    /**
     * Destroy the component
     */
    destroy() {
        this._stopAutoHide();
        this.element.remove();
        ErrorReporter._instance = null;
        super.destroy();
    }
}

// Register with SixOrbit
ErrorReporter.register();

export default ErrorReporter;
export { ErrorReporter };
