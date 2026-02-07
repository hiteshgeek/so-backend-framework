// ============================================
// SIXORBIT UI - DRAGDROP COMPONENT
// Reusable drag-drop plugin for any elements
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SODragDrop - Generic drag-drop component
 * Works with cards, tabs, lists, tables, any DOM elements
 * Uses HTML5 Drag & Drop API
 */
class SODragDrop extends SOComponent {
  static NAME = 'dragdrop';

  static DEFAULTS = {
    items: null,              // Selector for draggable items (null = direct children)
    handle: null,             // Drag handle selector (null = entire item)
    group: null,              // Group name for cross-container dragging
    animation: 150,           // Animation duration (ms)
    ghostClass: 'so-ghost',   // Class for ghost element
    dragClass: 'so-dragging', // Class while dragging
    chosenClass: 'so-chosen', // Class for chosen element
    dropPlaceholder: true,    // Show placeholder during drag
    dragRotation: true,       // Apply rotation to drag ghost (true = inclined, false = straight)
    liveReorder: false,       // Live reorder while dragging (true) or only on drop (false)
    accept: null,             // Function(dragged, target) or selector to accept drops
    storage: null,            // 'localStorage' | 'sessionStorage' | null
    storageKey: null,         // Key for storage
    disabled: false,          // Disable dragging
    onStart: null,            // Callback on drag start
    onEnd: null,              // Callback on drag end
    onReorder: null,          // Callback on reorder
    onMove: null,             // Callback on move (return false to cancel)
  };

  static EVENTS = {
    START: 'dragdrop:start',
    END: 'dragdrop:end',
    MOVE: 'dragdrop:move',
    REORDER: 'dragdrop:reorder',
  };

  /**
   * Initialize the drag-drop component
   * @private
   */
  _init() {
    this._items = [];
    this._draggedEl = null;
    this._draggedIndex = null;
    this._placeholder = null;
    this._dragOverElement = null;

    // Parse data attributes
    this._parseDataAttributes();

    // Update items
    this._updateItems();

    // Attach events
    this._attachEvents();

    // Restore order from storage
    this._restoreOrder();
  }

  /**
   * Parse data attributes for configuration
   * @private
   */
  _parseDataAttributes() {
    const el = this.element;

    // items selector
    if (el.hasAttribute('data-so-items')) {
      this.options.items = el.getAttribute('data-so-items');
    }

    // handle selector
    if (el.hasAttribute('data-so-handle')) {
      this.options.handle = el.getAttribute('data-so-handle');
    }

    // group name
    if (el.hasAttribute('data-so-group')) {
      this.options.group = el.getAttribute('data-so-group');
    }

    // storage
    if (el.hasAttribute('data-so-storage')) {
      this.options.storage = el.getAttribute('data-so-storage');
    }

    // storage key
    if (el.hasAttribute('data-so-storage-key')) {
      this.options.storageKey = el.getAttribute('data-so-storage-key');
    }

    // disabled
    if (el.hasAttribute('data-so-disabled')) {
      this.options.disabled = el.getAttribute('data-so-disabled') !== 'false';
    }

    // liveReorder
    if (el.hasAttribute('data-so-live-reorder')) {
      this.options.liveReorder = el.getAttribute('data-so-live-reorder') !== 'false';
    }
  }

  /**
   * Update draggable items
   * @private
   */
  _updateItems() {
    const selector = this.options.items;
    this._items = selector
      ? Array.from(this.element.querySelectorAll(selector))
      : Array.from(this.element.children).filter(el => el.nodeType === 1);

    this._items.forEach((item, index) => {
      item.dataset.dragIndex = index;

      if (this.options.handle) {
        // If handle specified, make only the HANDLE draggable, not the item
        const handle = item.querySelector(this.options.handle);
        if (handle) {
          handle.setAttribute('draggable', !this.options.disabled);
          handle.style.cursor = 'move';
          handle.classList.add(SixOrbit.cls('drag-handle'));
          // Store reference to parent item
          handle.dataset.dragParent = index;
        }
        // Item itself is NOT draggable
        item.removeAttribute('draggable');
      } else {
        // No handle - entire item is draggable
        item.setAttribute('draggable', !this.options.disabled);
        item.style.cursor = 'move';
      }
    });
  }

  /**
   * Attach drag event handlers
   * @private
   */
  _attachEvents() {
    // If handle is specified, listen on handles AND items
    // Otherwise, just listen on items
    const dragSelector = this.options.handle
      ? `${this.options.handle}, ${this.options.items || '*'}`
      : this.options.items || '*';
    const dropSelector = this.options.items || '*';

    // Drag events (on draggable elements - handles or items)
    this.delegate('dragstart', dragSelector, this._onDragStart.bind(this));
    this.delegate('dragend', dragSelector, this._onDragEnd.bind(this));

    // Drop events (on items)
    this.delegate('dragover', dropSelector, this._onDragOver.bind(this));
    this.delegate('dragenter', dropSelector, this._onDragEnter.bind(this));
    this.delegate('dragleave', dropSelector, this._onDragLeave.bind(this));
    this.delegate('drop', dropSelector, this._onDrop.bind(this));

    // Also listen on container for drop zones
    this.element.addEventListener('dragover', this._onContainerDragOver.bind(this));
    this.element.addEventListener('drop', this._onContainerDrop.bind(this));
  }

  /**
   * Handle drag start
   * @private
   */
  _onDragStart(e, target) {
    if (this.options.disabled) {
      e.preventDefault();
      return;
    }

    // If handle is specified and target is the handle, find the parent item
    let draggedItem = target;
    if (this.options.handle && target.matches(this.options.handle)) {
      // Target is the handle, find the parent item
      const parentIndex = parseInt(target.dataset.dragParent);
      draggedItem = this._items[parentIndex];
    } else if (!this.options.handle) {
      // No handle - dragging the item directly
    } else {
      // Has handle but not dragging by handle - this shouldn't happen
      e.preventDefault();
      return;
    }

    this._draggedEl = draggedItem;
    this._draggedIndex = parseInt(draggedItem.dataset.dragIndex);

    draggedItem.classList.add(SixOrbit.cls(this.options.dragClass));
    draggedItem.classList.add(SixOrbit.cls(this.options.chosenClass));

    // Create custom drag ghost (entire card clone with rotation)
    this._createDragGhost(draggedItem, e);

    // Set drag data
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', draggedItem.innerHTML);

    // Set group data for cross-container dragging
    if (this.options.group) {
      e.dataTransfer.setData('so-drag-group', this.options.group);
    }

    // Create placeholder if enabled
    if (this.options.dropPlaceholder) {
      this._createPlaceholder(draggedItem);
    }

    // Emit event
    this.emit('dragdrop:start', {
      element: draggedItem,
      index: this._draggedIndex
    });

    // Call user callback
    if (this.options.onStart) {
      this.options.onStart.call(this, e, draggedItem);
    }
  }

  /**
   * Handle drag end
   * @private
   */
  _onDragEnd(e, target) {
    // Use the stored dragged element, not the event target (which might be the handle)
    const draggedEl = this._draggedEl;

    if (draggedEl) {
      draggedEl.classList.remove(SixOrbit.cls(this.options.dragClass));
      draggedEl.classList.remove(SixOrbit.cls(this.options.chosenClass));
    }

    // Remove placeholder
    if (this._placeholder) {
      this._placeholder.remove();
      this._placeholder = null;
    }

    // Clear drag over
    if (this._dragOverElement) {
      this._clearDragOverClasses(this._dragOverElement);
      this._dragOverElement = null;
    }

    const newIndex = draggedEl ? this._getElementIndex(draggedEl) : -1;

    // Emit event
    this.emit('dragdrop:end', {
      element: draggedEl,
      oldIndex: this._draggedIndex,
      newIndex: newIndex
    });

    // Call user callback
    if (this.options.onEnd) {
      this.options.onEnd.call(this, e, draggedEl);
    }

    this._draggedEl = null;
    this._draggedIndex = null;
  }

  /**
   * Handle drag over
   * @private
   */
  _onDragOver(e, target) {
    e.preventDefault(); // Allow drop

    if (!this._draggedEl || target === this._draggedEl) return;

    // Check if drop is accepted
    const canDrop = this._canAcceptDrop(this._draggedEl, target);

    if (!canDrop) {
      e.dataTransfer.dropEffect = 'none';
      target.classList.add(SixOrbit.cls('drag-not-allowed'));
      return;
    }

    e.dataTransfer.dropEffect = 'move';

    // Remove previous drag over indicator
    if (this._dragOverElement && this._dragOverElement !== target) {
      this._clearDragOverClasses(this._dragOverElement);
    }

    this._dragOverElement = target;

    // Add drag-over indicator
    target.classList.add(SixOrbit.cls('drag-over'));

    // Live reorder: move element while dragging
    if (this.options.liveReorder) {
      const draggedIndex = this._getElementIndex(this._draggedEl);
      const targetIndex = this._getElementIndex(target);

      if (draggedIndex === targetIndex) return;

      // Perform DOM manipulation based on direction
      if (draggedIndex < targetIndex) {
        // Moving left to right: insert AFTER target
        this.element.insertBefore(this._draggedEl, target.nextElementSibling);
      } else {
        // Moving right to left: insert BEFORE target
        this.element.insertBefore(this._draggedEl, target);
      }

      // Update indices immediately for next dragover
      this._updateIndices();

      // Emit move event
      this.emit('dragdrop:move', {
        element: this._draggedEl,
        target: target,
        fromIndex: draggedIndex,
        toIndex: this._getElementIndex(this._draggedEl)
      });
    }
  }

  /**
   * Check if drop is accepted
   * @private
   */
  _canAcceptDrop(draggedEl, targetEl) {
    if (!this.options.accept) {
      return true; // No restriction
    }

    // If accept is a function
    if (typeof this.options.accept === 'function') {
      return this.options.accept(draggedEl, targetEl);
    }

    // If accept is a selector string
    if (typeof this.options.accept === 'string') {
      return targetEl.matches(this.options.accept);
    }

    return true;
  }

  /**
   * Clear drag over classes
   * @private
   */
  _clearDragOverClasses(element) {
    element.classList.remove(SixOrbit.cls('drag-over'));
    element.classList.remove(SixOrbit.cls('drag-not-allowed'));
  }

  /**
   * Handle drag enter
   * @private
   */
  _onDragEnter(e, target) {
    if (target === this._draggedEl) return;
    target.classList.add(SixOrbit.cls('drag-over'));
  }

  /**
   * Handle drag leave
   * @private
   */
  _onDragLeave(e, target) {
    this._clearDragOverClasses(target);
  }

  /**
   * Handle drop
   * @private
   */
  _onDrop(e, target) {
    e.stopPropagation();
    e.preventDefault();

    // Check if drop is accepted
    if (!this._canAcceptDrop(this._draggedEl, target)) {
      return;
    }

    // Clear drag over indicator
    if (this._dragOverElement) {
      this._clearDragOverClasses(this._dragOverElement);
      this._dragOverElement = null;
    }

    const oldIndex = this._draggedIndex;

    // For liveReorder, DOM was already manipulated during dragover
    // For non-liveReorder, do DOM manipulation now
    if (!this.options.liveReorder) {
      const targetIndex = parseInt(target.dataset.dragIndex);

      // Skip if dropping on itself
      if (oldIndex === targetIndex || target === this._draggedEl) {
        return;
      }

      // Perform DOM manipulation based on direction
      if (oldIndex < targetIndex) {
        // Moving left to right: insert AFTER target
        this.element.insertBefore(this._draggedEl, target.nextElementSibling);
      } else {
        // Moving right to left: insert BEFORE target
        this.element.insertBefore(this._draggedEl, target);
      }

      // Update indices after DOM change
      this._updateIndices();
    }

    const newIndex = this._getElementIndex(this._draggedEl);

    // Skip if no change occurred
    if (oldIndex === newIndex) {
      return;
    }

    this._saveOrder();

    // Emit event
    this.emit('dragdrop:reorder', {
      element: this._draggedEl,
      oldIndex,
      newIndex,
      order: this.getOrder()
    });

    // Call user callback
    if (this.options.onReorder) {
      this.options.onReorder.call(this, oldIndex, newIndex);
    }
  }

  /**
   * Handle drag over on container
   * @private
   */
  _onContainerDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
  }

  /**
   * Handle drop on container
   * @private
   */
  _onContainerDrop(e) {
    e.preventDefault();
  }

  /**
   * Create placeholder element
   * @private
   */
  _createPlaceholder(target) {
    this._placeholder = document.createElement('div');
    this._placeholder.className = SixOrbit.cls(this.options.ghostClass);
    this._placeholder.style.height = target.offsetHeight + 'px';
    this._placeholder.style.width = target.offsetWidth + 'px';
  }

  /**
   * Create custom drag ghost image (entire card with optional rotation)
   * @private
   */
  _createDragGhost(target, e) {
    // Clone the entire card
    const ghost = target.cloneNode(true);

    // Style the ghost
    ghost.style.position = 'absolute';
    ghost.style.top = '-9999px';
    ghost.style.left = '-9999px';
    ghost.style.width = target.offsetWidth + 'px';
    ghost.style.height = target.offsetHeight + 'px';
    ghost.style.opacity = '0.9';
    ghost.style.border = '2px solid rgba(0, 0, 0, 0.2)';

    // Apply rotation only if enabled in config
    if (this.options.dragRotation) {
      ghost.style.transform = 'rotate(3deg) scale(0.95)';
      ghost.style.boxShadow = '0 8px 24px rgba(0, 0, 0, 0.3)';
    } else {
      ghost.style.transform = 'scale(1)';
      ghost.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.2)';
    }

    ghost.style.pointerEvents = 'none';
    ghost.style.zIndex = '10000';

    // Append to body temporarily
    document.body.appendChild(ghost);

    // Calculate offset from cursor to element's top-left corner
    // This preserves the exact grab position instead of centering
    const rect = target.getBoundingClientRect();
    const offsetX = e.clientX - rect.left;
    const offsetY = e.clientY - rect.top;

    // Set as drag image with the actual grab offset
    e.dataTransfer.setDragImage(ghost, offsetX, offsetY);

    // Remove ghost after a brief delay (browser has captured it)
    setTimeout(() => {
      if (ghost.parentNode) {
        ghost.remove();
      }
    }, 0);
  }

  /**
   * Get element index in container
   * @private
   */
  _getElementIndex(el) {
    return Array.from(this.element.children).indexOf(el);
  }

  /**
   * Update item indices
   * @private
   */
  _updateIndices() {
    this._items = Array.from(this.element.children).filter(el => el.nodeType === 1 && el !== this._placeholder);
    this._items.forEach((item, index) => {
      item.dataset.dragIndex = index;

      // Also update dragParent on handles if handle is specified
      if (this.options.handle) {
        const handle = item.querySelector(this.options.handle);
        if (handle) {
          handle.dataset.dragParent = index;
        }
      }
    });
  }

  // ==================
  // Public API
  // ==================

  /**
   * Get current order of items
   * @returns {Array}
   */
  getOrder() {
    return this._items.map((item, index) => ({
      index,
      id: item.id || item.dataset.dragIndex,
      element: item
    }));
  }

  /**
   * Set order of items
   * @param {Array} order - Array of item IDs or indices
   * @returns {this}
   */
  setOrder(order) {
    // Reorder DOM based on order array
    order.forEach((item) => {
      const el = typeof item === 'string'
        ? document.getElementById(item)
        : this._items[item];
      if (el && el.parentElement === this.element) {
        this.element.appendChild(el);
      }
    });

    this._updateIndices();
    return this;
  }

  /**
   * Save order to storage
   * @private
   */
  _saveOrder() {
    if (!this.options.storage || !this.options.storageKey) return;

    const storage = window[this.options.storage];
    if (!storage) return;

    const order = this._items.map(item => item.id || item.dataset.dragIndex);
    try {
      storage.setItem(this.options.storageKey, JSON.stringify(order));
    } catch (e) {
      console.error('Failed to save order:', e);
    }
  }

  /**
   * Restore order from storage
   * @private
   */
  _restoreOrder() {
    if (!this.options.storage || !this.options.storageKey) return;

    const storage = window[this.options.storage];
    if (!storage) return;

    try {
      const savedOrder = storage.getItem(this.options.storageKey);
      if (savedOrder) {
        const order = JSON.parse(savedOrder);
        this.setOrder(order);
      }
    } catch (e) {
      console.error('Failed to restore order:', e);
    }
  }

  /**
   * Enable dragging
   * @returns {this}
   */
  enable() {
    this.options.disabled = false;
    this._updateItems();
    return this;
  }

  /**
   * Disable dragging
   * @returns {this}
   */
  disable() {
    this.options.disabled = true;
    this._updateItems();
    return this;
  }

  /**
   * Refresh items (re-scan for draggable items)
   * @returns {this}
   */
  refresh() {
    this._updateItems();
    return this;
  }

  /**
   * Destroy the component
   */
  destroy() {
    // Remove drag attributes
    this._items.forEach(item => {
      item.removeAttribute('draggable');
      item.removeAttribute('data-drag-index');
      item.style.cursor = '';
    });

    // Call parent destroy
    super.destroy();
  }
}

// Register component
SODragDrop.register();

export default SODragDrop;
