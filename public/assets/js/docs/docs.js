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

// Mobile sidebar toggle
document.addEventListener('DOMContentLoaded', function() {
    var toggle = document.querySelector('.sidebar-toggle');
    var sidebar = document.querySelector('.docs-sidebar');
    var backdrop = document.querySelector('.sidebar-backdrop');
    var closeBtn = document.querySelector('.sidebar-close');
    if (!toggle || !sidebar) return;

    function openSidebar() {
        sidebar.classList.add('open');
        toggle.classList.add('open');
        if (backdrop) backdrop.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        toggle.classList.remove('open');
        if (backdrop) backdrop.classList.remove('active');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', function() {
        if (sidebar.classList.contains('open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    if (backdrop) {
        backdrop.addEventListener('click', closeSidebar);
    }

    // Close button inside sidebar
    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
    }

    // Close on TOC link click
    sidebar.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', closeSidebar);
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });
});

// Scroll-to-top button with progress ring
document.addEventListener('DOMContentLoaded', function() {
    // Create the button via JS so it's centralized across all pages
    var btn = document.createElement('div');
    btn.className = 'scroll-to-top';
    btn.setAttribute('aria-label', 'Scroll to top');
    btn.innerHTML =
        '<svg viewBox="0 0 44 44">' +
            '<circle class="progress-bg" cx="22" cy="22" r="20"/>' +
            '<circle class="progress-ring" cx="22" cy="22" r="20"/>' +
            '<path class="arrow-icon" d="M22 14l-6 6 1.4 1.4L21 17.8V30h2V17.8l3.6 3.6L28 20z"/>' +
        '</svg>';
    document.body.appendChild(btn);

    var ring = btn.querySelector('.progress-ring');
    var circumference = 2 * Math.PI * 20; // r=20 → ~125.66

    btn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    window.addEventListener('scroll', function() {
        var scrollTop = window.scrollY;
        var docHeight = document.documentElement.scrollHeight - window.innerHeight;
        var progress = docHeight > 0 ? scrollTop / docHeight : 0;

        // Show/hide button
        if (scrollTop > 200) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }

        // Update ring progress
        ring.style.strokeDashoffset = circumference - (progress * circumference);
    }, { passive: true });
});
