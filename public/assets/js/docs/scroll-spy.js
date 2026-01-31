/**
 * Documentation Scroll Spy
 *
 * Highlights the current section in the sidebar navigation
 * as the user scrolls through the documentation page.
 */
(function() {
    'use strict';

    let activeSection = null;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                activeSection = entry.target.id;
                updateActiveSidebarLink(activeSection);
            }
        });
    }, {
        rootMargin: '-100px 0px -66% 0px',
        threshold: [0, 0.25, 0.5, 0.75, 1]
    });

    function updateActiveSidebarLink(sectionId) {
        // Remove active from all links
        document.querySelectorAll('.docs-sidebar a').forEach(a => {
            a.classList.remove('active');
        });

        // Add active to current section link
        const link = document.querySelector(`.docs-sidebar a[href="#${sectionId}"]`);
        if (link) {
            link.classList.add('active');
            // Scroll sidebar to show active link if needed
            link.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }
    }

    // Observe all headings with IDs
    const headings = document.querySelectorAll('.heading[id]');
    headings.forEach(h => observer.observe(h));

    // Handle hash changes
    window.addEventListener('hashchange', () => {
        const hash = window.location.hash.substring(1);
        if (hash) {
            updateActiveSidebarLink(hash);
        }
    });

    // Set initial active state based on URL hash
    if (window.location.hash) {
        const hash = window.location.hash.substring(1);
        setTimeout(() => updateActiveSidebarLink(hash), 100);
    }
})();
