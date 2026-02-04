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
    }
}

export default ValidationEngine;
export { ValidationEngine };
