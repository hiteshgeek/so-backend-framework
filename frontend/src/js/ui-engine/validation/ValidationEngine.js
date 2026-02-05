// ============================================
// SIXORBIT UI ENGINE - VALIDATION ENGINE
// Client-side validation matching PHP rules
// ============================================

import { rules as builtInRules } from './rules/index.js';
import SixOrbit from '../../core/so-config.js';

/**
 * ValidationEngine - Orchestrates client-side validation
 * Works with rules exported from PHP
 */
class ValidationEngine {
    /**
     * Registered validation rules
     * @type {Object}
     */
    static rules = { ...builtInRules };

    /**
     * Field rules loaded from PHP
     * @type {Object}
     */
    static fieldRules = {};

    /**
     * Default error messages
     * @type {Object}
     */
    static defaultMessages = {
        required: 'This field is required.',
        email: 'Please enter a valid email address.',
        url: 'Please enter a valid URL.',
        numeric: 'Please enter a number.',
        integer: 'Please enter a whole number.',
        min: 'Must be at least :min characters.',
        max: 'Must not exceed :max characters.',
        between: 'Must be between :min and :max characters.',
        in: 'Please select a valid option.',
        confirmed: 'The confirmation does not match.',
        date: 'Please enter a valid date.',
        accepted: 'This field must be accepted.',
        regex: 'The format is invalid.',
        alpha: 'Only letters are allowed.',
        alpha_num: 'Only letters and numbers are allowed.',
        same: 'This field must match :other.',
        different: 'This field must be different from :other.',
    };

    /**
     * Load validation rules from PHP export
     * @param {string|Object} formSelectorOrRules - Form selector or rules object
     * @param {Object} [rules] - Rules if first param is selector
     */
    static loadRules(formSelectorOrRules, rules = null) {
        if (typeof formSelectorOrRules === 'string') {
            // Selector + rules
            const formId = formSelectorOrRules.replace('#', '');
            this.fieldRules[formId] = rules;
        } else {
            // Just rules object
            Object.assign(this.fieldRules, formSelectorOrRules);
        }
    }

    /**
     * Register a custom validation rule
     * @param {string} name - Rule name
     * @param {Function} validator - Validation function (value, params, element) => boolean
     * @param {string} [message] - Default error message
     */
    static registerRule(name, validator, message = null) {
        this.rules[name] = {
            validator,
            message: message || `Validation failed for ${name}.`
        };
    }

    /**
     * Get rules for a field
     * @param {string} fieldName
     * @param {string} [formId]
     * @returns {Object}
     */
    static getRulesForField(fieldName, formId = null) {
        if (formId && this.fieldRules[formId] && this.fieldRules[formId][fieldName]) {
            return this.fieldRules[formId][fieldName];
        }

        // Search all forms
        for (const rules of Object.values(this.fieldRules)) {
            if (rules[fieldName]) {
                return rules[fieldName];
            }
        }

        return null;
    }

    /**
     * Validate a single field
     * @param {HTMLElement|Object} element - Form element or FormElement instance
     * @param {Object} [customRules] - Override rules
     * @returns {{valid: boolean, errors: string[]}}
     */
    static validateField(element, customRules = null) {
        const name = element.name || (element.getName ? element.getName() : null);
        const value = element.value ?? (element.getValue ? element.getValue() : null);

        // Get rules
        let fieldConfig = customRules || this.getRulesForField(name);

        // Also check for rules from UiEngine FormElement
        if (!fieldConfig && element.getRules) {
            const elementRules = element.getRules();
            if (Object.keys(elementRules).length > 0) {
                fieldConfig = {
                    rules: elementRules,
                    messages: element.getMessages ? element.getMessages() : {}
                };
            }
        }

        if (!fieldConfig) {
            return { valid: true, errors: [] };
        }

        const rules = fieldConfig.rules || fieldConfig;
        const customMessages = fieldConfig.messages || {};
        const errors = [];

        // Run each rule
        for (const [ruleName, params] of Object.entries(rules)) {
            const isValid = this.runRule(ruleName, value, params, element);

            if (!isValid) {
                const message = this.getMessage(name, ruleName, params, customMessages);
                errors.push(message);
            }
        }

        // Update element error state
        if (element.setError) {
            element.setError(errors.length > 0 ? errors[0] : null);
        } else if (element.classList) {
            // DOM element
            if (errors.length > 0) {
                element.classList.add(SixOrbit.cls('is-invalid'));
            } else {
                element.classList.remove(SixOrbit.cls('is-invalid'));
            }
        }

        return {
            valid: errors.length === 0,
            errors
        };
    }

    /**
     * Validate an entire form
     * @param {HTMLFormElement|Object} form - Form element or ContainerElement
     * @returns {{valid: boolean, errors: Object}}
     */
    static validateForm(form) {
        const allErrors = {};
        let isValid = true;

        // Get form elements
        let fields;
        if (form.getFormElements) {
            // UiEngine ContainerElement
            fields = form.getFormElements();
        } else if (form.elements) {
            // DOM form
            fields = Array.from(form.elements).filter(el =>
                el.name && ['INPUT', 'SELECT', 'TEXTAREA'].includes(el.tagName)
            );
        } else {
            return { valid: true, errors: {} };
        }

        // Validate each field
        fields.forEach(field => {
            const result = this.validateField(field);
            if (!result.valid) {
                isValid = false;
                const name = field.name || (field.getName ? field.getName() : 'field');
                allErrors[name] = result.errors;
            }
        });

        return {
            valid: isValid,
            errors: allErrors
        };
    }

    /**
     * Run a single validation rule
     * @param {string} ruleName
     * @param {*} value
     * @param {*} params
     * @param {*} element
     * @returns {boolean}
     */
    static runRule(ruleName, value, params, element) {
        const rule = this.rules[ruleName];

        if (!rule) {
            console.warn(`Unknown validation rule: ${ruleName}`);
            return true;
        }

        try {
            return rule.validator(value, params, element);
        } catch (error) {
            console.error(`Error in validation rule ${ruleName}:`, error);
            return true;
        }
    }

    /**
     * Get error message for a rule
     * @param {string} field - Field name
     * @param {string} rule - Rule name
     * @param {*} params - Rule parameters
     * @param {Object} [customMessages] - Custom messages
     * @returns {string}
     */
    static getMessage(field, rule, params, customMessages = {}) {
        // Check custom message first
        if (customMessages[rule]) {
            return this.replacePlaceholders(customMessages[rule], params, field);
        }

        // Rule-specific message
        const ruleConfig = this.rules[rule];
        if (ruleConfig && ruleConfig.message) {
            return this.replacePlaceholders(ruleConfig.message, params, field);
        }

        // Default message
        const defaultMsg = this.defaultMessages[rule] || `Validation failed for ${field}.`;
        return this.replacePlaceholders(defaultMsg, params, field);
    }

    /**
     * Replace placeholders in message
     * @param {string} message
     * @param {*} params
     * @param {string} field
     * @returns {string}
     */
    static replacePlaceholders(message, params, field) {
        let result = message;

        // Replace :attribute with field name
        result = result.replace(/:attribute/g, this.formatFieldName(field));

        // Replace params
        if (typeof params === 'object' && !Array.isArray(params)) {
            Object.entries(params).forEach(([key, value]) => {
                result = result.replace(new RegExp(`:${key}`, 'g'), value);
            });
        } else if (Array.isArray(params)) {
            // Handle array params [min, max]
            if (params[0] !== undefined) {
                result = result.replace(/:min/g, params[0]);
            }
            if (params[1] !== undefined) {
                result = result.replace(/:max/g, params[1]);
            }
            result = result.replace(/:value/g, params.join(', '));
        } else if (params !== true && params !== undefined) {
            result = result.replace(/:value/g, params);
            result = result.replace(/:min/g, params);
            result = result.replace(/:max/g, params);
        }

        return result;
    }

    /**
     * Format field name for display
     * @param {string} field
     * @returns {string}
     */
    static formatFieldName(field) {
        return field
            .replace(/([a-z])([A-Z])/g, '$1 $2')
            .replace(/[_-]/g, ' ')
            .replace(/\b\w/g, l => l.toUpperCase());
    }

    /**
     * Set default message for a rule
     * @param {string} rule
     * @param {string} message
     */
    static setDefaultMessage(rule, message) {
        this.defaultMessages[rule] = message;
    }

    /**
     * Set multiple default messages
     * @param {Object} messages
     */
    static setDefaultMessages(messages) {
        Object.assign(this.defaultMessages, messages);
    }

    /**
     * Validate on blur (attach to form)
     * @param {HTMLFormElement|string} form
     */
    static attachBlurValidation(form) {
        const formEl = typeof form === 'string' ? document.querySelector(form) : form;
        if (!formEl) return;

        formEl.addEventListener('blur', (e) => {
            if (e.target.name) {
                this.validateField(e.target);
            }
        }, true);
    }

    /**
     * Validate on submit (attach to form)
     * @param {HTMLFormElement|string} form
     * @param {Function} [onSuccess] - Callback on successful validation
     * @param {Function} [onError] - Callback on validation error
     */
    static attachSubmitValidation(form, onSuccess = null, onError = null) {
        const formEl = typeof form === 'string' ? document.querySelector(form) : form;
        if (!formEl) return;

        formEl.addEventListener('submit', (e) => {
            const result = this.validateForm(formEl);

            if (!result.valid) {
                e.preventDefault();

                // Show errors
                if (window.UiEngine && window.UiEngine.errors) {
                    window.UiEngine.errors.showAll(result.errors);
                }

                if (onError) {
                    onError(result.errors, e);
                }

                // Focus first error field
                const firstErrorField = Object.keys(result.errors)[0];
                const field = formEl.elements[firstErrorField];
                if (field) {
                    field.focus();
                }
            } else {
                if (onSuccess) {
                    onSuccess(e);
                }
            }
        });
    }

    /**
     * Clear all validation errors on a form
     * @param {HTMLFormElement|string} form
     */
    static clearFormErrors(form) {
        const formEl = typeof form === 'string' ? document.querySelector(form) : form;
        if (!formEl) return;

        formEl.querySelectorAll(SixOrbit.sel('is-invalid')).forEach(el => {
            el.classList.remove(SixOrbit.cls('is-invalid'));
        });

        formEl.querySelectorAll(SixOrbit.sel('invalid-feedback')).forEach(el => {
            el.style.display = 'none';
        });

        // Remove error elements and has-error class from form-groups
        formEl.querySelectorAll(SixOrbit.sel('form-error')).forEach(el => {
            el.remove();
        });

        formEl.querySelectorAll('.has-error').forEach(el => {
            el.classList.remove('has-error');
        });
    }

    /**
     * Attach live validation to form fields
     * @param {HTMLFormElement|string} form
     * @param {Object} options
     * @returns {Object} Controller object with methods
     */
    static attachLiveValidation(form, options = {}) {
        const formEl = typeof form === 'string' ? document.querySelector(form) : form;
        if (!formEl) return null;

        // Default options
        const defaults = {
            // Validation Events
            events: {
                input: false,       // Validate on input (real-time)
                change: true,       // Validate on change
                blur: true,         // Validate on blur
            },

            // Error Display
            errorDisplay: {
                inline: true,           // Show inline errors below fields
                reporter: false,        // Show errors in ErrorReporter
                reporterPosition: 'top-right',
                clearOnValid: true,     // Auto-clear errors when field becomes valid
                showOn: 'all',          // 'all' | 'blur' | 'change' - when to show errors
            },

            // Debouncing
            debounce: {
                enabled: false,
                delay: 300,             // ms
                validateOnEnter: true,  // Skip debounce on Enter key
            },

            // Field Filtering
            fields: {
                include: [],            // Only validate these fields (empty = all)
                exclude: [],            // Exclude these fields
                skipEmpty: false,       // Skip validation for empty optional fields
            },

            // First Error Focus
            focusFirstError: true,
            scrollToError: false,
        };

        const opts = this._deepMerge(defaults, options);
        const listeners = [];
        const debounceTimers = {};

        // Get fields to validate
        const getFields = () => {
            const allFields = Array.from(formEl.elements).filter(el =>
                el.name && ['INPUT', 'SELECT', 'TEXTAREA'].includes(el.tagName)
            );

            return allFields.filter(field => {
                if (opts.fields.include.length > 0 && !opts.fields.include.includes(field.name)) {
                    return false;
                }
                if (opts.fields.exclude.includes(field.name)) {
                    return false;
                }
                return true;
            });
        };

        // Validate a field
        const validateFieldLive = (element, eventType) => {
            // Skip if empty and skipEmpty is enabled
            if (opts.fields.skipEmpty && !element.value && !this.getRulesForField(element.name)?.rules?.required) {
                return;
            }

            const result = this.validateField(element);

            // Determine if we should show errors based on showOn setting
            let shouldShowError = false;
            if (opts.errorDisplay.showOn === 'all') {
                shouldShowError = true;
            } else if (opts.errorDisplay.showOn === eventType) {
                shouldShowError = true;
            }

            // Handle inline errors
            if (opts.errorDisplay.inline) {
                const formGroup = element.closest(SixOrbit.sel('form-group'));
                if (formGroup) {
                    let feedbackEl = formGroup.querySelector(SixOrbit.sel('form-error'));

                    if (!result.valid && shouldShowError) {
                        // Show error
                        if (!feedbackEl) {
                            feedbackEl = document.createElement('div');
                            feedbackEl.className = SixOrbit.cls('form-error');
                            feedbackEl.innerHTML = '<span class="material-icons">error</span><span></span>';

                            // Insert after input wrapper or input
                            const inputWrapper = formGroup.querySelector(SixOrbit.sel('input-wrapper')) || element;
                            inputWrapper.insertAdjacentElement('afterend', feedbackEl);
                        }

                        // Update error message
                        const messageSpan = feedbackEl.querySelector('span:not(.material-icons)');
                        if (messageSpan) {
                            messageSpan.textContent = result.errors[0];
                        }
                        feedbackEl.style.display = 'flex';
                        element.classList.add(SixOrbit.cls('is-invalid'));
                        formGroup.classList.add('has-error'); // Add error state to form-group for label styling
                    } else if (result.valid && opts.errorDisplay.clearOnValid) {
                        // Clear error
                        if (feedbackEl) {
                            feedbackEl.remove();
                        }
                        element.classList.remove(SixOrbit.cls('is-invalid'));
                        formGroup.classList.remove('has-error'); // Remove error state from form-group
                    }
                }
            }

            // Handle ErrorReporter
            if (opts.errorDisplay.reporter && window.ErrorReporter) {
                const reporter = window.ErrorReporter.getInstance({
                    position: opts.errorDisplay.reporterPosition
                });

                if (!result.valid && shouldShowError) {
                    reporter.addError(element.name, result.errors);
                } else if (result.valid && opts.errorDisplay.clearOnValid) {
                    reporter.clearField(element.name);
                }
            }

            return result;
        };

        // Attach event listeners
        const fields = getFields();
        fields.forEach(field => {
            // Input event
            if (opts.events.input) {
                const inputHandler = (e) => {
                    if (opts.debounce.enabled) {
                        // Handle Enter key
                        if (opts.debounce.validateOnEnter && e.keyCode === 13) {
                            clearTimeout(debounceTimers[field.name]);
                            validateFieldLive(field, 'input');
                            return;
                        }

                        // Debounced validation
                        clearTimeout(debounceTimers[field.name]);
                        debounceTimers[field.name] = setTimeout(() => {
                            validateFieldLive(field, 'input');
                        }, opts.debounce.delay);
                    } else {
                        validateFieldLive(field, 'input');
                    }
                };

                field.addEventListener('input', inputHandler);
                listeners.push({ element: field, event: 'input', handler: inputHandler });
            }

            // Change event
            if (opts.events.change) {
                const changeHandler = () => {
                    validateFieldLive(field, 'change');
                };

                field.addEventListener('change', changeHandler);
                listeners.push({ element: field, event: 'change', handler: changeHandler });
            }

            // Blur event
            if (opts.events.blur) {
                const blurHandler = () => {
                    validateFieldLive(field, 'blur');
                };

                field.addEventListener('blur', blurHandler);
                listeners.push({ element: field, event: 'blur', handler: blurHandler });
            }
        });

        // Controller object
        return {
            validate: () => this.validateForm(formEl),
            validateField: (fieldName) => {
                const field = formEl.elements[fieldName];
                return field ? validateFieldLive(field, 'manual') : null;
            },
            clearErrors: () => {
                this.clearFormErrors(formEl);
                if (opts.errorDisplay.reporter && window.ErrorReporter) {
                    window.ErrorReporter.getInstance().clearAll();
                }
            },
            detach: () => {
                listeners.forEach(({ element, event, handler }) => {
                    element.removeEventListener(event, handler);
                });
                Object.values(debounceTimers).forEach(timer => clearTimeout(timer));
            },
            pause: () => {
                fields.forEach(field => {
                    field.dataset.validationPaused = 'true';
                });
            },
            resume: () => {
                fields.forEach(field => {
                    delete field.dataset.validationPaused;
                });
            },
        };
    }

    /**
     * Central event handler - attach all validation behaviors at once
     * @param {HTMLFormElement|string} form
     * @param {Object} options
     * @returns {Object} Controller object
     */
    static attachTo(form, options = {}) {
        const formEl = typeof form === 'string' ? document.querySelector(form) : form;
        if (!formEl) return null;

        // Default options
        const defaults = {
            // Event Strategy
            strategy: 'balanced', // 'aggressive' | 'balanced' | 'lazy' | 'minimal'

            // Or custom event configuration
            events: {
                submit: true,
                blur: true,
                change: false,
                input: false,
            },

            // Live Validation Options (same as attachLiveValidation)
            live: {
                errorDisplay: {
                    inline: true,
                    reporter: true,
                    reporterPosition: 'bottom-right',
                    clearOnValid: true,
                    showOn: 'blur',
                },
                debounce: {
                    enabled: false,
                    delay: 300,
                    validateOnEnter: true,
                },
                fields: {
                    include: [],
                    exclude: [],
                    skipEmpty: false,
                },
            },

            // Submit Behavior
            submit: {
                preventDefault: true,
                focusFirstError: true,
                scrollToError: true,
                scrollBehavior: 'smooth',
                scrollBlock: 'center',
            },

            // Callbacks
            callbacks: {
                onSubmit: null,         // Called on submit (before validation)
                onValid: null,          // Called when form is valid
                onInvalid: null,        // Called when form is invalid
                onFieldValid: null,     // Called when a field becomes valid
                onFieldInvalid: null,   // Called when a field becomes invalid
            },
        };

        const opts = this._deepMerge(defaults, options);

        // Apply preset strategy
        if (opts.strategy !== 'balanced') {
            const preset = this.getPreset(opts.strategy);
            if (preset) {
                opts.events = preset.events;
                Object.assign(opts.live, preset.live || {});
            }
        }

        let liveController = null;
        const controllers = [];

        // Attach live validation if any live events are enabled
        if (opts.events.blur || opts.events.change || opts.events.input) {
            liveController = this.attachLiveValidation(formEl, {
                events: {
                    input: opts.events.input,
                    change: opts.events.change,
                    blur: opts.events.blur,
                },
                ...opts.live,
            });

            controllers.push(liveController);
        }

        // Attach submit validation
        if (opts.events.submit) {
            const submitHandler = (e) => {
                // Callback: onSubmit
                if (opts.callbacks.onSubmit) {
                    opts.callbacks.onSubmit(e, formEl);
                }

                const result = this.validateForm(formEl);

                if (!result.valid) {
                    if (opts.submit.preventDefault) {
                        e.preventDefault();
                    }

                    // Show errors in reporter
                    if (opts.live.errorDisplay.reporter && window.ErrorReporter) {
                        const reporter = window.ErrorReporter.getInstance({
                            position: opts.live.errorDisplay.reporterPosition
                        });
                        reporter.showAll(result.errors);
                    }

                    // Show inline errors
                    if (opts.live.errorDisplay.inline) {
                        Object.entries(result.errors).forEach(([fieldName, errors]) => {
                            const field = formEl.elements[fieldName];
                            if (!field) return;

                            const formGroup = field.closest(SixOrbit.sel('form-group'));
                            if (!formGroup) return;

                            let feedbackEl = formGroup.querySelector(SixOrbit.sel('form-error'));

                            // Show error
                            if (!feedbackEl) {
                                feedbackEl = document.createElement('div');
                                feedbackEl.className = SixOrbit.cls('form-error');
                                feedbackEl.innerHTML = '<span class="material-icons">error</span><span></span>';

                                // Insert after input wrapper or input
                                const inputWrapper = formGroup.querySelector(SixOrbit.sel('input-wrapper')) || field;
                                inputWrapper.insertAdjacentElement('afterend', feedbackEl);
                            }

                            // Update error message
                            const messageSpan = feedbackEl.querySelector('span:not(.material-icons)');
                            if (messageSpan) {
                                const errorMessage = Array.isArray(errors) ? errors[0] : errors;
                                messageSpan.textContent = errorMessage;
                            }
                            feedbackEl.style.display = 'flex';
                            field.classList.add(SixOrbit.cls('is-invalid'));
                            formGroup.classList.add('has-error'); // Add error state to form-group for label styling
                        });
                    }

                    // Focus first error
                    if (opts.submit.focusFirstError) {
                        const firstErrorField = Object.keys(result.errors)[0];
                        const field = formEl.elements[firstErrorField];
                        if (field) {
                            field.focus();

                            if (opts.submit.scrollToError) {
                                field.scrollIntoView({
                                    behavior: opts.submit.scrollBehavior,
                                    block: opts.submit.scrollBlock,
                                });
                            }
                        }
                    }

                    // Callback: onInvalid
                    if (opts.callbacks.onInvalid) {
                        opts.callbacks.onInvalid(result.errors, e, formEl);
                    }
                } else {
                    // Clear errors in reporter when form is valid
                    if (opts.live.errorDisplay.reporter && window.ErrorReporter) {
                        const reporter = window.ErrorReporter.getInstance();
                        reporter.clearAll();
                    }

                    // Callback: onValid
                    if (opts.callbacks.onValid) {
                        opts.callbacks.onValid(e, formEl);
                    }
                }
            };

            formEl.addEventListener('submit', submitHandler);
            controllers.push({
                detach: () => formEl.removeEventListener('submit', submitHandler)
            });
        }

        // Return unified controller
        return {
            validate: () => this.validateForm(formEl),
            validateField: (fieldName) => {
                return liveController ? liveController.validateField(fieldName) : null;
            },
            clearErrors: () => {
                this.clearFormErrors(formEl);
                if (opts.live.errorDisplay.reporter && window.ErrorReporter) {
                    window.ErrorReporter.getInstance().clearAll();
                }
            },
            detach: () => {
                controllers.forEach(ctrl => ctrl.detach && ctrl.detach());
            },
            pause: () => {
                liveController && liveController.pause();
            },
            resume: () => {
                liveController && liveController.resume();
            },
            getState: () => ({
                valid: this.validateForm(formEl).valid,
                errors: this.validateForm(formEl).errors,
            }),
        };
    }

    /**
     * Get validation preset configuration
     * @param {string} name - Preset name
     * @returns {Object|null}
     */
    static getPreset(name) {
        const presets = {
            // Validate on every input + blur + submit
            aggressive: {
                events: { submit: true, blur: true, change: true, input: true },
                live: {
                    errorDisplay: { inline: true, reporter: true, clearOnValid: true, showOn: 'all' },
                    debounce: { enabled: false },
                },
            },

            // Validate on blur + submit (default)
            balanced: {
                events: { submit: true, blur: true, change: false, input: false },
                live: {
                    errorDisplay: { inline: true, reporter: true, clearOnValid: true, showOn: 'blur' },
                    debounce: { enabled: false },
                },
            },

            // Validate only on submit, then on blur after first error
            lazy: {
                events: { submit: true, blur: false, change: false, input: false },
                live: {
                    errorDisplay: { inline: true, reporter: true, clearOnValid: false, showOn: 'blur' },
                },
            },

            // Validate only on submit
            minimal: {
                events: { submit: true, blur: false, change: false, input: false },
                live: {
                    errorDisplay: { inline: false, reporter: true, clearOnValid: false, showOn: 'all' },
                },
            },
        };

        return presets[name] || null;
    }

    /**
     * Deep merge utility
     * @param {Object} target
     * @param {Object} source
     * @returns {Object}
     * @private
     */
    static _deepMerge(target, source) {
        const output = { ...target };

        if (this._isObject(target) && this._isObject(source)) {
            Object.keys(source).forEach(key => {
                if (this._isObject(source[key])) {
                    if (!(key in target)) {
                        output[key] = source[key];
                    } else {
                        output[key] = this._deepMerge(target[key], source[key]);
                    }
                } else {
                    output[key] = source[key];
                }
            });
        }

        return output;
    }

    /**
     * Check if value is an object
     * @param {*} item
     * @returns {boolean}
     * @private
     */
    static _isObject(item) {
        return item && typeof item === 'object' && !Array.isArray(item);
    }
}

export default ValidationEngine;
export { ValidationEngine };
