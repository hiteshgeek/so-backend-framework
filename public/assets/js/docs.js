function copyCode(btn) {
    const code = btn.closest('.code-container').querySelector('code').textContent;
    const icon = btn.querySelector('.mdi');

    // Try clipboard API first, fallback to execCommand
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(code).then(function() {
            showCopySuccess(icon);
        }).catch(function() {
            fallbackCopy(code, icon);
        });
    } else {
        fallbackCopy(code, icon);
    }
}

function fallbackCopy(text, icon) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    try {
        document.execCommand('copy');
        showCopySuccess(icon);
    } catch (e) {
        console.error('Copy failed', e);
    }
    document.body.removeChild(textarea);
}

function showCopySuccess(icon) {
    icon.classList.remove('mdi-content-copy');
    icon.classList.add('mdi-check');
    setTimeout(function() {
        icon.classList.remove('mdi-check');
        icon.classList.add('mdi-content-copy');
    }, 2000);
}

// Initialize Highlight.js for syntax highlighting
document.addEventListener('DOMContentLoaded', function() {
    if (typeof hljs !== 'undefined') {
        // Map non-standard language aliases to supported ones
        var langMap = {
            'apache': 'xml',
            'env': 'ini',
            'html5': 'html',
            'css3': 'css'
        };

        document.querySelectorAll('pre code[class*="language-"]').forEach(function(block) {
            var match = block.className.match(/language-(\S+)/);
            if (match) {
                var lang = match[1];
                // Remap unsupported language to a supported one
                if (langMap[lang]) {
                    block.classList.remove('language-' + lang);
                    block.classList.add('language-' + langMap[lang]);
                }
                // If language isn't registered, fall back to plaintext
                if (!langMap[lang] && !hljs.getLanguage(lang)) {
                    block.classList.remove('language-' + lang);
                    block.classList.add('language-plaintext');
                }
            }
            hljs.highlightElement(block);
        });
    }
});
