/**
 * Desktop Enhancement Utilities
 * 
 * JavaScript utilities for desktop-specific features like keyboard shortcuts,
 * enhanced tooltips, and desktop-optimized interactions
 */

class DesktopEnhancements {
    constructor() {
        this.isDesktop = window.innerWidth >= 992;
        this.keyboardShortcuts = new Map();
        this.init();
    }

    init() {
        if (this.isDesktop) {
            this.initKeyboardShortcuts();
            this.initEnhancedTooltips();
            this.initDesktopFormEnhancements();
            this.initFocusManagement();
        }

        // Listen for resize events
        window.addEventListener('resize', () => {
            const wasDesktop = this.isDesktop;
            this.isDesktop = window.innerWidth >= 992;

            if (wasDesktop !== this.isDesktop) {
                if (this.isDesktop) {
                    this.enableDesktopFeatures();
                } else {
                    this.disableDesktopFeatures();
                }
            }
        });
    }

    // Keyboard Shortcuts Management
    initKeyboardShortcuts() {
        // Define default shortcuts
        this.registerShortcut('Ctrl+S', 'Save form', (e) => {
            e.preventDefault();
            this.saveCurrentForm();
        });

        this.registerShortcut('Ctrl+E', 'Toggle edit mode', (e) => {
            e.preventDefault();
            this.toggleEditMode();
        });

        this.registerShortcut('Escape', 'Cancel/Close', (e) => {
            this.handleEscape();
        });

        this.registerShortcut('Ctrl+/', 'Show shortcuts', (e) => {
            e.preventDefault();
            this.toggleShortcutsDisplay();
        });

        this.registerShortcut('Tab', 'Navigate fields', null); // Visual only
        this.registerShortcut('Ctrl+Enter', 'Submit form', (e) => {
            e.preventDefault();
            this.submitCurrentForm();
        });

        // Listen for keyboard events
        document.addEventListener('keydown', (e) => {
            this.handleKeydown(e);
        });

        // Create shortcuts display
        this.createShortcutsDisplay();
    }

    registerShortcut(keys, description, handler) {
        this.keyboardShortcuts.set(keys, { description, handler });
    }

    handleKeydown(e) {
        const key = this.getKeyString(e);
        const shortcut = this.keyboardShortcuts.get(key);

        if (shortcut && shortcut.handler) {
            shortcut.handler(e);
        }
    }

    getKeyString(e) {
        const parts = [];
        if (e.ctrlKey) parts.push('Ctrl');
        if (e.altKey) parts.push('Alt');
        if (e.shiftKey) parts.push('Shift');

        if (e.key === 'Escape') {
            parts.push('Escape');
        } else if (e.key === 'Enter') {
            parts.push('Enter');
        } else if (e.key === 'Tab') {
            parts.push('Tab');
        } else if (e.key === '/') {
            parts.push('/');
        } else if (e.key.length === 1) {
            parts.push(e.key.toUpperCase());
        }

        return parts.join('+');
    }

    createShortcutsDisplay() {
        const shortcutsEl = document.createElement('div');
        shortcutsEl.className = 'keyboard-shortcuts';
        shortcutsEl.innerHTML = `
            <div class="shortcuts-header">キーボードショートカット</div>
            ${Array.from(this.keyboardShortcuts.entries()).map(([keys, { description }]) => `
                <div class="shortcut-item">
                    <div class="shortcut-keys">
                        ${keys.split('+').map(key => `<span class="key">${key}</span>`).join('')}
                    </div>
                    <div class="shortcut-description">${description}</div>
                </div>
            `).join('')}
        `;

        document.body.appendChild(shortcutsEl);
        this.shortcutsElement = shortcutsEl;
    }

    toggleShortcutsDisplay() {
        if (this.shortcutsElement) {
            this.shortcutsElement.classList.toggle('show');
        }
    }

    // Form Enhancement Methods
    saveCurrentForm() {
        const form = document.querySelector('form:focus-within, form.active');
        if (form) {
            const saveBtn = form.querySelector('button[type="submit"], .btn-save');
            if (saveBtn && !saveBtn.disabled) {
                saveBtn.click();
            }
        }
    }

    toggleEditMode() {
        const editBtn = document.querySelector('.btn-edit, .edit-toggle');
        if (editBtn) {
            editBtn.click();
        }
    }

    submitCurrentForm() {
        const form = document.querySelector('form:focus-within, form.active');
        if (form) {
            form.submit();
        }
    }

    handleEscape() {
        // Close modals
        const modal = document.querySelector('.modal.show');
        if (modal) {
            const closeBtn = modal.querySelector('.btn-close, [data-bs-dismiss="modal"]');
            if (closeBtn) closeBtn.click();
            return;
        }

        // Cancel edit mode
        const cancelBtn = document.querySelector('.btn-cancel');
        if (cancelBtn) {
            cancelBtn.click();
            return;
        }

        // Hide shortcuts
        if (this.shortcutsElement && this.shortcutsElement.classList.contains('show')) {
            this.shortcutsElement.classList.remove('show');
        }
    }

    // Enhanced Tooltips
    initEnhancedTooltips() {
        // Add enhanced tooltips to elements with data-tooltip attribute
        document.querySelectorAll('[data-tooltip]').forEach(el => {
            el.classList.add('desktop-tooltip');
        });

        // Auto-add tooltips to form labels with help text
        document.querySelectorAll('.form-label[data-help]').forEach(label => {
            label.setAttribute('data-tooltip', label.getAttribute('data-help'));
            label.classList.add('desktop-tooltip');
        });
    }

    // Desktop Form Enhancements
    initDesktopFormEnhancements() {
        // Add desktop enhancement class to forms
        document.querySelectorAll('form').forEach(form => {
            form.classList.add('desktop-form-enhancements');
        });

        // Enhanced validation feedback
        document.querySelectorAll('.needs-validation').forEach(form => {
            form.classList.add('desktop-validation');
        });

        // Auto-calculation field enhancements
        this.initAutoCalculationFields();
    }

    initAutoCalculationFields() {
        // Find fields that should auto-calculate
        const openingDateField = document.querySelector('#opening_date, [name="opening_date"]');
        const operatingYearsField = document.querySelector('#operating_years, [name="operating_years"]');

        if (openingDateField && operatingYearsField) {
            // Wrap in auto-calc styling
            const wrapper = document.createElement('div');
            wrapper.className = 'auto-calc-field';
            operatingYearsField.parentNode.insertBefore(wrapper, operatingYearsField);
            wrapper.appendChild(operatingYearsField);

            // Add indicator
            const indicator = document.createElement('span');
            indicator.className = 'calc-indicator';
            indicator.textContent = '自動計算';
            wrapper.appendChild(indicator);

            // Calculate on opening date change
            openingDateField.addEventListener('change', () => {
                this.calculateOperatingYears(openingDateField.value, operatingYearsField);
            });

            // Initial calculation
            if (openingDateField.value) {
                this.calculateOperatingYears(openingDateField.value, operatingYearsField);
            }
        }
    }

    calculateOperatingYears(openingDate, targetField) {
        if (!openingDate) {
            targetField.value = '';
            return;
        }

        const opening = new Date(openingDate);
        const now = new Date();
        const years = Math.floor((now - opening) / (365.25 * 24 * 60 * 60 * 1000));

        targetField.value = years >= 0 ? years : 0;

        // Add visual feedback
        targetField.style.backgroundColor = 'rgba(13, 202, 240, 0.1)';
        setTimeout(() => {
            targetField.style.backgroundColor = '';
        }, 1000);
    }

    // Focus Management
    initFocusManagement() {
        // Enhanced focus indicators
        document.addEventListener('focusin', (e) => {
            if (e.target.matches('.form-control, .form-select, .btn')) {
                e.target.closest('.form-group, .btn-group')?.classList.add('focused');
            }
        });

        document.addEventListener('focusout', (e) => {
            if (e.target.matches('.form-control, .form-select, .btn')) {
                e.target.closest('.form-group, .btn-group')?.classList.remove('focused');
            }
        });

        // Smooth scrolling to focused elements
        document.addEventListener('focusin', (e) => {
            if (e.target.matches('.form-control, .form-select')) {
                e.target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    }

    // Enable/Disable Desktop Features
    enableDesktopFeatures() {
        document.body.classList.add('desktop-mode');
        this.initKeyboardShortcuts();
        this.initEnhancedTooltips();
        this.initDesktopFormEnhancements();
        this.initFocusManagement();
    }

    disableDesktopFeatures() {
        document.body.classList.remove('desktop-mode');

        // Remove keyboard shortcuts
        if (this.shortcutsElement) {
            this.shortcutsElement.remove();
            this.shortcutsElement = null;
        }

        // Remove desktop classes
        document.querySelectorAll('.desktop-tooltip').forEach(el => {
            el.classList.remove('desktop-tooltip');
        });

        document.querySelectorAll('.desktop-form-enhancements').forEach(el => {
            el.classList.remove('desktop-form-enhancements');
        });
    }
}

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    window.desktopEnhancements = new DesktopEnhancements();
});

export default DesktopEnhancements;