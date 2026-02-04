// ============================================
// SIXORBIT UI ENGINE - AUTOCOMPLETE ELEMENT
// Search input with suggestions
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Autocomplete - Search with suggestions
 * Supports single/multi-select, async data, free solo mode, and token display
 */
class Autocomplete extends FormElement {
    static NAME = 'ui-autocomplete';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'autocomplete',
        tagName: 'div',
    };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._options = config.options || [];
        this._asyncUrl = config.asyncUrl || config.async || null;
        this._minLength = config.minLength ?? config.minChars ?? 0;
        this._debounce = config.debounce ?? 300;
        this._maxResults = config.maxResults ?? 10;
        this._freeSolo = config.freeSolo ?? false;
        this._highlightMatches = config.highlightMatches !== false;
        this._clearable = config.clearable !== false;
        this._multiple = config.multiple ?? false;
        this._displayMode = config.displayMode || 'chips';
        this._maxVisibleTokens = config.maxVisibleTokens ?? 3;
        this._tokenDelimiters = config.tokenDelimiters || [',', ';'];
        this._noResultsText = config.noResultsText || 'No results found';
        this._loadingText = config.loadingText || 'Loading...';
        this._itemTemplate = config.itemTemplate || null;
    }

    // Fluent setters
    options(options) { this._options = options; return this; }
    addOption(option) { this._options.push(option); return this; }
    async(url) { this._asyncUrl = url; return this; }
    ajaxUrl(url) { return this.async(url); }
    minLength(length) { this._minLength = length; return this; }
    minChars(chars) { return this.minLength(chars); }
    debounce(ms) { this._debounce = ms; return this; }
    maxResults(max) { this._maxResults = max; return this; }
    freeSolo(val = true) { this._freeSolo = val; return this; }
    strict() { return this.freeSolo(false); }
    highlightMatches(val = true) { this._highlightMatches = val; return this; }
    highlight(val = true) { return this.highlightMatches(val); }
    clearable(val = true) { this._clearable = val; return this; }
    multiple(val = true) { this._multiple = val; return this; }
    displayMode(mode) { this._displayMode = mode; return this; }
    maxVisibleTokens(max) { this._maxVisibleTokens = max; return this; }
    tokenDelimiters(delimiters) { this._tokenDelimiters = delimiters; return this; }
    noResultsText(text) { this._noResultsText = text; return this; }
    loadingText(text) { this._loadingText = text; return this; }
    itemTemplate(template) { this._itemTemplate = template; return this; }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('autocomplete'));

        if (this._multiple) {
            this._extraClasses.add(SixOrbit.cls('autocomplete-multiple'));
            this._extraClasses.add(SixOrbit.cls(`autocomplete-display-${this._displayMode}`));
        }

        if (this._size) {
            this._extraClasses.add(SixOrbit.cls(`autocomplete-${this._size}`));
        }

        if (this._disabled) {
            this._extraClasses.add(SixOrbit.cls('disabled'));
        }

        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = {};

        if (this._id) {
            attrs.id = this._id;
        }

        attrs.class = this.buildClassString();

        // Data attributes for JS initialization
        if (this._multiple) {
            attrs[SixOrbit.data('multiple')] = 'true';
        }

        if (this._freeSolo) {
            attrs[SixOrbit.data('free-solo')] = 'true';
        }

        if (this._asyncUrl) {
            attrs[SixOrbit.data('async')] = this._asyncUrl;
        }

        return attrs;
    }

    renderContent() {
        const containerId = `autocomplete-${this._id || Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
        const dropdownId = `${containerId}-dropdown`;

        // Build input
        const inputAttrs = {
            type: 'text',
            class: SixOrbit.cls('autocomplete-input'),
            placeholder: this._placeholder || 'Type to search...',
            autocomplete: 'off',
            role: 'combobox',
            'aria-expanded': 'false',
            'aria-haspopup': 'listbox',
            'aria-owns': dropdownId,
            'aria-autocomplete': 'list'
        };

        if (this._name && !this._multiple) {
            inputAttrs.name = this._name;
        }

        if (this._disabled) {
            inputAttrs.disabled = 'disabled';
        }

        if (this._readonly) {
            inputAttrs.readonly = 'readonly';
        }

        const inputAttrStr = Object.entries(inputAttrs)
            .map(([k, v]) => `${k}="${v}"`)
            .join(' ');
        const inputHtml = `<input ${inputAttrStr}>`;

        // Build input area
        let inputArea;
        if (this._multiple) {
            inputArea = `<div class="${SixOrbit.cls('autocomplete-tokens')}">${inputHtml}</div>`;
        } else {
            inputArea = inputHtml;
        }

        // Clear button
        const clearBtn = this._clearable
            ? `<button type="button" class="${SixOrbit.cls('autocomplete-clear')}" style="display: none;" aria-label="Clear all">
                <span class="material-icons">close</span>
               </button>`
            : '';

        // Arrow
        const arrow = `<span class="${SixOrbit.cls('autocomplete-arrow')}">
            <span class="material-icons">expand_more</span>
        </span>`;

        // Container
        const container = `<div class="${SixOrbit.cls('autocomplete-container')}" id="${containerId}">
            ${inputArea}
            ${clearBtn}
            ${arrow}
        </div>`;

        // Dropdown
        const dropdown = `<div class="${SixOrbit.cls('autocomplete-dropdown')}" id="${dropdownId}" role="listbox">
            <div class="${SixOrbit.cls('autocomplete-loading')}" style="display: none;">
                <span class="${SixOrbit.cls('spinner')} ${SixOrbit.cls('spinner-sm')}"></span>
                <span>${this._loadingText}</span>
            </div>
            <div class="${SixOrbit.cls('autocomplete-options')}"></div>
            <div class="${SixOrbit.cls('autocomplete-no-results')}" style="display: none;">
                ${this._noResultsText}
            </div>
        </div>`;

        return container + dropdown;
    }

    toConfig() {
        const config = super.toConfig();

        if (this._options.length > 0) config.options = this._options;
        if (this._asyncUrl) config.async = this._asyncUrl;
        if (this._minLength !== 0) config.minLength = this._minLength;
        if (this._debounce !== 300) config.debounce = this._debounce;
        if (this._maxResults !== 10) config.maxResults = this._maxResults;
        if (this._freeSolo) config.freeSolo = true;
        if (!this._highlightMatches) config.highlightMatches = false;
        if (!this._clearable) config.clearable = false;
        if (this._multiple) config.multiple = true;
        if (this._displayMode !== 'chips') config.displayMode = this._displayMode;
        if (this._maxVisibleTokens !== 3) config.maxVisibleTokens = this._maxVisibleTokens;
        if (JSON.stringify(this._tokenDelimiters) !== JSON.stringify([',', ';'])) {
            config.tokenDelimiters = this._tokenDelimiters;
        }
        if (this._itemTemplate) config.itemTemplate = this._itemTemplate;

        return config;
    }
}

export default Autocomplete;
export { Autocomplete };
