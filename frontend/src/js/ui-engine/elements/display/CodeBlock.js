// ============================================
// SIXORBIT UI ENGINE - CODE BLOCK ELEMENT
// Code display
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class CodeBlock extends Element {
    static NAME = 'ui-code-block';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'code-block', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._code = config.code || '';
        this._language = config.language || 'plaintext';
        this._showLineNumbers = config.showLineNumbers || false;
        this._showCopy = config.showCopy !== false;
        this._title = config.title || null;
        this._highlightLines = config.highlightLines || [];
    }

    code(code) { this._code = code; return this; }
    language(lang) { this._language = lang; return this; }
    javascript() { return this.language('javascript'); }
    php() { return this.language('php'); }
    html() { return this.language('html'); }
    css() { return this.language('css'); }
    json() { return this.language('json'); }
    sql() { return this.language('sql'); }
    bash() { return this.language('bash'); }
    showLineNumbers(val = true) { this._showLineNumbers = val; return this; }
    showCopy(val = true) { this._showCopy = val; return this; }
    hideCopy() { return this.showCopy(false); }
    title(title) { this._title = title; return this; }
    highlightLines(lines) { this._highlightLines = lines; return this; }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('code-block'));
        if (this._showLineNumbers) this._extraClasses.add(SixOrbit.cls('code-block-numbered'));
        return super.buildClassString();
    }

    renderContent() {
        let html = '';

        if (this._title || this._showCopy) {
            html += `<div class="${SixOrbit.cls('code-block-header')}">`;
            if (this._title) {
                html += `<span class="${SixOrbit.cls('code-block-title')}">${this._escapeHtml(this._title)}</span>`;
            }
            if (this._language && this._language !== 'plaintext') {
                html += `<span class="${SixOrbit.cls('code-block-language')}">${this._escapeHtml(this._language)}</span>`;
            }
            if (this._showCopy) {
                html += `<button type="button" class="${SixOrbit.cls('code-block-copy')}" ${SixOrbit.data('copy-target')}="code">`;
                html += '<span class="material-icons">content_copy</span>';
                html += '</button>';
            }
            html += '</div>';
        }

        html += `<pre class="${SixOrbit.cls('code-block-pre')}"><code class="language-${this._escapeHtml(this._language)}">`;

        if (this._showLineNumbers) {
            const lines = this._code.split('\n');
            lines.forEach((line, idx) => {
                const lineNum = idx + 1;
                const highlightClass = this._highlightLines.includes(lineNum) ? ` ${SixOrbit.cls('highlight')}` : '';
                html += `<span class="${SixOrbit.cls('code-line')}${highlightClass}">`;
                html += `<span class="${SixOrbit.cls('code-line-number')}">${lineNum}</span>`;
                html += `<span class="${SixOrbit.cls('code-line-content')}">${this._escapeHtml(line)}</span>`;
                html += '</span>\n';
            });
        } else {
            html += this._escapeHtml(this._code);
        }

        html += '</code></pre>';
        return html;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._code) config.code = this._code;
        if (this._language !== 'plaintext') config.language = this._language;
        if (this._showLineNumbers) config.showLineNumbers = true;
        if (!this._showCopy) config.showCopy = false;
        if (this._title) config.title = this._title;
        if (this._highlightLines.length > 0) config.highlightLines = this._highlightLines;
        return config;
    }
}

export default CodeBlock;
export { CodeBlock };
