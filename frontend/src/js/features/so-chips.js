/**
 * SixOrbit UI - Chips Component
 * Handles closable and selectable chip interactions
 */

class SOChips {
  constructor() {
    this.init();
  }

  init() {
    // Initialize on DOM ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => {
        this.bindAll();
      });
    } else {
      this.bindAll();
    }

    // Re-initialize for dynamically added chips
    this.observeDOM();
  }

  bindAll() {
    this.bindCloseButtons();
    this.bindSelectableChips();
  }

  bindCloseButtons() {
    document.querySelectorAll('[data-so-chip] .so-chip-close, [data-so-chip-closable] .so-chip-close').forEach(btn => {
      if (btn._soChipBound) return;
      btn._soChipBound = true;

      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const chip = btn.closest('.so-chip, [data-so-chip]');
        if (chip) {
          // Dispatch custom event before removal
          const event = new CustomEvent('so-chip:close', {
            bubbles: true,
            cancelable: true,
            detail: {
              chip,
              value: chip.dataset.value || chip.textContent.trim()
            }
          });

          const shouldRemove = chip.dispatchEvent(event);

          if (shouldRemove) {
            // Animate out and remove
            chip.style.transition = 'opacity 0.15s, transform 0.15s';
            chip.style.opacity = '0';
            chip.style.transform = 'scale(0.8)';
            setTimeout(() => chip.remove(), 150);
          }
        }
      });
    });
  }

  bindSelectableChips() {
    document.querySelectorAll('[data-so-chip-selectable], .so-chip-selectable').forEach(chip => {
      if (chip._soChipBound) return;
      chip._soChipBound = true;

      chip.addEventListener('click', (e) => {
        // Don't toggle if clicking on close button
        if (e.target.closest('.so-chip-close')) return;

        const isSelected = chip.classList.toggle('so-chip-selected');

        // Update hidden checkbox if present
        const checkbox = chip.querySelector('input[type="checkbox"]');
        if (checkbox) {
          checkbox.checked = isSelected;
        }

        // Dispatch custom event
        const eventName = isSelected ? 'so-chip:select' : 'so-chip:deselect';
        const event = new CustomEvent(eventName, {
          bubbles: true,
          detail: {
            chip,
            value: chip.dataset.value || chip.textContent.trim(),
            selected: isSelected
          }
        });
        chip.dispatchEvent(event);
      });
    });
  }

  observeDOM() {
    const observer = new MutationObserver((mutations) => {
      let shouldRebind = false;

      mutations.forEach((mutation) => {
        if (mutation.addedNodes.length) {
          mutation.addedNodes.forEach((node) => {
            if (node.nodeType === 1) {
              // Check if the node is a chip or contains chips
              if (node.matches && (
                node.matches('[data-so-chip], [data-so-chip-closable], [data-so-chip-selectable], .so-chip-selectable') ||
                node.querySelector('[data-so-chip], [data-so-chip-closable], [data-so-chip-selectable], .so-chip-selectable')
              )) {
                shouldRebind = true;
              }
            }
          });
        }
      });

      if (shouldRebind) {
        this.bindAll();
      }
    });

    observer.observe(document.body, { childList: true, subtree: true });
  }

  /**
   * Manually close a chip
   * @param {HTMLElement} chip - The chip element to close
   */
  close(chip) {
    if (chip) {
      const closeBtn = chip.querySelector('.so-chip-close');
      if (closeBtn) {
        closeBtn.click();
      } else {
        // Dispatch event and remove
        const event = new CustomEvent('so-chip:close', {
          bubbles: true,
          detail: { chip, value: chip.dataset.value || chip.textContent.trim() }
        });
        chip.dispatchEvent(event);
        chip.remove();
      }
    }
  }

  /**
   * Toggle selection state of a chip
   * @param {HTMLElement} chip - The chip element to toggle
   * @param {boolean} [selected] - Optional explicit state
   */
  toggle(chip, selected) {
    if (chip) {
      if (typeof selected === 'boolean') {
        chip.classList.toggle('so-chip-selected', selected);
      } else {
        chip.classList.toggle('so-chip-selected');
      }

      const isSelected = chip.classList.contains('so-chip-selected');
      const checkbox = chip.querySelector('input[type="checkbox"]');
      if (checkbox) {
        checkbox.checked = isSelected;
      }

      const eventName = isSelected ? 'so-chip:select' : 'so-chip:deselect';
      const event = new CustomEvent(eventName, {
        bubbles: true,
        detail: { chip, value: chip.dataset.value || chip.textContent.trim(), selected: isSelected }
      });
      chip.dispatchEvent(event);
    }
  }

  /**
   * Get all selected chips within a container
   * @param {HTMLElement} [container=document] - Container to search within
   * @returns {Array} Array of selected chip elements
   */
  getSelected(container = document) {
    return Array.from(container.querySelectorAll('.so-chip-selected'));
  }

  /**
   * Get values of all selected chips within a container
   * @param {HTMLElement} [container=document] - Container to search within
   * @returns {Array} Array of chip values
   */
  getSelectedValues(container = document) {
    return this.getSelected(container).map(chip =>
      chip.dataset.value || chip.textContent.trim()
    );
  }
}

// Auto-initialize and expose globally
const soChips = new SOChips();
window.SOChips = soChips;

export default soChips;
