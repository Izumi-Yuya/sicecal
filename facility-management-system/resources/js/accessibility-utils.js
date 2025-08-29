/**
 * Accessibility Utilities
 * Provides keyboard navigation, ARIA management, and screen reader support
 */

class AccessibilityManager {
    constructor() {
        this.init();
    }

    init() {
        this.setupKeyboardNavigation();
        this.setupAriaLiveRegions();
        this.setupFocusManagement();
        this.setupScreenReaderAnnouncements();
    }

    /**
     * Setup keyboard navigation for custom components
     */
    setupKeyboardNavigation() {
        // Tab navigation for facility tabs
        document.addEventListener('keydown', (e) => {
            if (e.target.matches('.nav-link[role="tab"]')) {
                this.handleTabNavigation(e);
            }

            // Escape key handling for modals and dropdowns
            if (e.key === 'Escape') {
                this.handleEscapeKey(e);
            }

            // Enter/Space for custom interactive elements
            if ((e.key === 'Enter' || e.key === ' ') && e.target.matches('.interactive-element')) {
                e.preventDefault();
                e.target.click();
            }
        });
    }

    /**
     * Handle tab navigation with arrow keys
     */
    handleTabNavigation(e) {
        const tabs = Array.from(document.querySelectorAll('.nav-link[role="tab"]'));
        const currentIndex = tabs.indexOf(e.target);
        let nextIndex;

        switch (e.key) {
            case 'ArrowRight':
            case 'ArrowDown':
                e.preventDefault();
                nextIndex = (currentIndex + 1) % tabs.length;
                break;
            case 'ArrowLeft':
            case 'ArrowUp':
                e.preventDefault();
                nextIndex = (currentIndex - 1 + tabs.length) % tabs.length;
                break;
            case 'Home':
                e.preventDefault();
                nextIndex = 0;
                break;
            case 'End':
                e.preventDefault();
                nextIndex = tabs.length - 1;
                break;
            default:
                return;
        }

        if (nextIndex !== undefined) {
            tabs[nextIndex].focus();
            tabs[nextIndex].click();
        }
    }

    /**
     * Handle escape key for closing modals and dropdowns
     */
    handleEscapeKey(e) {
        // Close any open dropdowns
        const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
        openDropdowns.forEach(dropdown => {
            const toggle = dropdown.previousElementSibling;
            if (toggle && toggle.classList.contains('dropdown-toggle')) {
                toggle.click();
            }
        });

        // Close modals
        const openModals = document.querySelectorAll('.modal.show');
        openModals.forEach(modal => {
            const closeBtn = modal.querySelector('[data-bs-dismiss="modal"]');
            if (closeBtn) closeBtn.click();
        });
    }

    /**
     * Setup ARIA live regions for dynamic content updates
     */
    setupAriaLiveRegions() {
        // Create polite live region if it doesn't exist
        if (!document.getElementById('aria-live-polite')) {
            const liveRegion = document.createElement('div');
            liveRegion.id = 'aria-live-polite';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.className = 'sr-only';
            document.body.appendChild(liveRegion);
        }

        // Create assertive live region for urgent announcements
        if (!document.getElementById('aria-live-assertive')) {
            const liveRegion = document.createElement('div');
            liveRegion.id = 'aria-live-assertive';
            liveRegion.setAttribute('aria-live', 'assertive');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.className = 'sr-only';
            document.body.appendChild(liveRegion);
        }
    }

    /**
     * Announce message to screen readers
     */
    announce(message, priority = 'polite') {
        const liveRegionId = priority === 'assertive' ? 'aria-live-assertive' : 'aria-live-polite';
        const liveRegion = document.getElementById(liveRegionId);

        if (liveRegion) {
            liveRegion.textContent = message;

            // Clear after announcement to allow repeated messages
            setTimeout(() => {
                liveRegion.textContent = '';
            }, 1000);
        }
    }

    /**
     * Setup focus management for dynamic content
     */
    setupFocusManagement() {
        // Store focus before dynamic content changes
        this.previousFocus = null;

        // Focus management for form toggles
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-toggle-edit]')) {
                this.previousFocus = e.target;
            }
        });
    }

    /**
     * Restore focus to previous element
     */
    restoreFocus() {
        if (this.previousFocus && document.contains(this.previousFocus)) {
            this.previousFocus.focus();
            this.previousFocus = null;
        }
    }

    /**
     * Setup screen reader announcements for form interactions
     */
    setupScreenReaderAnnouncements() {
        // Announce form validation results
        document.addEventListener('invalid', (e) => {
            const field = e.target;
            const label = this.getFieldLabel(field);
            const message = field.validationMessage;
            this.announce(`${label}: ${message}`, 'assertive');
        });

        // Announce successful form submissions
        document.addEventListener('submit', (e) => {
            this.announce('フォームが送信されました', 'polite');
        });
    }

    /**
     * Get accessible label for form field
     */
    getFieldLabel(field) {
        // Try to find label by for attribute
        const label = document.querySelector(`label[for="${field.id}"]`);
        if (label) return label.textContent.trim();

        // Try to find label by aria-labelledby
        const labelledBy = field.getAttribute('aria-labelledby');
        if (labelledBy) {
            const labelElement = document.getElementById(labelledBy);
            if (labelElement) return labelElement.textContent.trim();
        }

        // Try to find label by aria-label
        const ariaLabel = field.getAttribute('aria-label');
        if (ariaLabel) return ariaLabel;

        // Fallback to placeholder or name
        return field.placeholder || field.name || 'フィールド';
    }

    /**
     * Add ARIA attributes to elements
     */
    addAriaAttributes(element, attributes) {
        Object.entries(attributes).forEach(([key, value]) => {
            element.setAttribute(`aria-${key}`, value);
        });
    }

    /**
     * Setup keyboard shortcuts
     */
    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Alt + M for main content
            if (e.altKey && e.key === 'm') {
                e.preventDefault();
                const mainContent = document.getElementById('main-content') || document.querySelector('main');
                if (mainContent) {
                    mainContent.focus();
                    this.announce('メインコンテンツに移動しました');
                }
            }

            // Alt + N for navigation
            if (e.altKey && e.key === 'n') {
                e.preventDefault();
                const nav = document.querySelector('nav') || document.querySelector('.navbar');
                if (nav) {
                    const firstLink = nav.querySelector('a, button');
                    if (firstLink) {
                        firstLink.focus();
                        this.announce('ナビゲーションに移動しました');
                    }
                }
            }

            // Alt + S for search
            if (e.altKey && e.key === 's') {
                e.preventDefault();
                const searchInput = document.querySelector('input[type="search"], input[name*="search"]');
                if (searchInput) {
                    searchInput.focus();
                    this.announce('検索フィールドに移動しました');
                }
            }
        });
    }
}

/**
 * Form Accessibility Enhancements
 */
class FormAccessibility {
    constructor() {
        this.init();
    }

    init() {
        this.enhanceFormValidation();
        this.addRequiredFieldIndicators();
        this.setupFieldDescriptions();
    }

    /**
     * Enhance form validation with accessibility features
     */
    enhanceFormValidation() {
        const forms = document.querySelectorAll('form');

        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const invalidFields = form.querySelectorAll(':invalid');

                if (invalidFields.length > 0) {
                    e.preventDefault();

                    // Focus first invalid field
                    invalidFields[0].focus();

                    // Announce validation errors
                    const errorCount = invalidFields.length;
                    window.accessibilityManager.announce(
                        `${errorCount}個の入力エラーがあります。最初のエラーフィールドに移動しました。`,
                        'assertive'
                    );
                }
            });

            // Add aria-describedby for validation messages
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('invalid', () => {
                    this.addValidationAria(input);
                });
            });
        });
    }

    /**
     * Add ARIA attributes for validation messages
     */
    addValidationAria(input) {
        const feedback = input.parentElement.querySelector('.invalid-feedback');
        if (feedback) {
            const feedbackId = `${input.id || input.name}-feedback`;
            feedback.id = feedbackId;
            input.setAttribute('aria-describedby', feedbackId);
            input.setAttribute('aria-invalid', 'true');
        }
    }

    /**
     * Add visual and screen reader indicators for required fields
     */
    addRequiredFieldIndicators() {
        const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');

        requiredFields.forEach(field => {
            const label = document.querySelector(`label[for="${field.id}"]`);
            if (label && !label.querySelector('.required-indicator')) {
                const indicator = document.createElement('span');
                indicator.className = 'required-indicator';
                indicator.innerHTML = ' <span aria-label="必須">*</span>';
                label.appendChild(indicator);
            }
        });
    }

    /**
     * Setup field descriptions for complex inputs
     */
    setupFieldDescriptions() {
        // Add descriptions for date inputs
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            if (!input.getAttribute('aria-describedby')) {
                const description = document.createElement('div');
                description.id = `${input.id || input.name}-desc`;
                description.className = 'form-text';
                description.textContent = '形式: YYYY-MM-DD (例: 2024-01-15)';
                input.parentElement.appendChild(description);
                input.setAttribute('aria-describedby', description.id);
            }
        });

        // Add descriptions for number inputs
        const numberInputs = document.querySelectorAll('input[type="number"]');
        numberInputs.forEach(input => {
            const min = input.getAttribute('min');
            const max = input.getAttribute('max');
            if ((min || max) && !input.getAttribute('aria-describedby')) {
                const description = document.createElement('div');
                description.id = `${input.id || input.name}-desc`;
                description.className = 'form-text';

                if (min && max) {
                    description.textContent = `${min}から${max}の間で入力してください`;
                } else if (min) {
                    description.textContent = `${min}以上で入力してください`;
                } else if (max) {
                    description.textContent = `${max}以下で入力してください`;
                }

                input.parentElement.appendChild(description);
                input.setAttribute('aria-describedby', description.id);
            }
        });
    }
}

/**
 * Component Accessibility Enhancements
 */
class ComponentAccessibility {
    constructor() {
        this.init();
    }

    init() {
        this.enhanceCards();
        this.enhanceButtons();
        this.enhanceTabs();
        this.enhanceDataTables();
    }

    /**
     * Enhance card components with accessibility features
     */
    enhanceCards() {
        const cards = document.querySelectorAll('.card');

        cards.forEach(card => {
            // Add role and tabindex for interactive cards
            if (card.querySelector('a') || card.onclick) {
                card.setAttribute('role', 'button');
                card.setAttribute('tabindex', '0');

                // Add keyboard support
                card.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const link = card.querySelector('a');
                        if (link) link.click();
                        else if (card.onclick) card.click();
                    }
                });
            }

            // Add aria-label for cards with only visual content
            const header = card.querySelector('.card-header');
            if (header && !card.getAttribute('aria-label')) {
                card.setAttribute('aria-label', header.textContent.trim());
            }
        });
    }

    /**
     * Enhance button accessibility
     */
    enhanceButtons() {
        const buttons = document.querySelectorAll('.btn');

        buttons.forEach(button => {
            // Add aria-label for icon-only buttons
            if (!button.textContent.trim() && !button.getAttribute('aria-label')) {
                const icon = button.querySelector('i, svg');
                if (icon) {
                    const iconClass = icon.className;
                    let label = 'ボタン';

                    if (iconClass.includes('edit')) label = '編集';
                    else if (iconClass.includes('delete')) label = '削除';
                    else if (iconClass.includes('save')) label = '保存';
                    else if (iconClass.includes('cancel')) label = 'キャンセル';

                    button.setAttribute('aria-label', label);
                }
            }

            // Add loading state support
            if (button.dataset.loading) {
                button.addEventListener('click', () => {
                    button.setAttribute('aria-busy', 'true');
                    button.disabled = true;

                    const originalText = button.textContent;
                    button.textContent = '処理中...';

                    // Reset after timeout (should be handled by actual form submission)
                    setTimeout(() => {
                        button.setAttribute('aria-busy', 'false');
                        button.disabled = false;
                        button.textContent = originalText;
                    }, 3000);
                });
            }
        });
    }

    /**
     * Enhance tab components
     */
    enhanceTabs() {
        const tabLists = document.querySelectorAll('.nav-tabs');

        tabLists.forEach(tabList => {
            tabList.setAttribute('role', 'tablist');

            const tabs = tabList.querySelectorAll('.nav-link');
            tabs.forEach((tab, index) => {
                tab.setAttribute('role', 'tab');
                tab.setAttribute('tabindex', tab.classList.contains('active') ? '0' : '-1');

                const targetId = tab.getAttribute('href')?.substring(1) || tab.dataset.bsTarget?.substring(1);
                if (targetId) {
                    tab.setAttribute('aria-controls', targetId);

                    const panel = document.getElementById(targetId);
                    if (panel) {
                        panel.setAttribute('role', 'tabpanel');
                        panel.setAttribute('aria-labelledby', tab.id || `tab-${index}`);
                        if (!tab.id) tab.id = `tab-${index}`;
                    }
                }

                tab.setAttribute('aria-selected', tab.classList.contains('active').toString());
            });
        });
    }

    /**
     * Enhance data table accessibility
     */
    enhanceDataTables() {
        const tables = document.querySelectorAll('table');

        tables.forEach(table => {
            // Add table caption if missing
            if (!table.querySelector('caption')) {
                const caption = document.createElement('caption');
                caption.className = 'sr-only';
                caption.textContent = 'データテーブル';
                table.insertBefore(caption, table.firstChild);
            }

            // Add scope attributes to headers
            const headers = table.querySelectorAll('th');
            headers.forEach(header => {
                if (!header.getAttribute('scope')) {
                    const isRowHeader = header.parentElement.querySelector('th') === header;
                    header.setAttribute('scope', isRowHeader ? 'row' : 'col');
                }
            });

            // Add aria-sort for sortable columns
            const sortableHeaders = table.querySelectorAll('th[data-sort]');
            sortableHeaders.forEach(header => {
                header.setAttribute('aria-sort', 'none');
                header.setAttribute('role', 'columnheader');
                header.setAttribute('tabindex', '0');

                header.addEventListener('click', () => {
                    // Update aria-sort based on current sort state
                    const currentSort = header.getAttribute('aria-sort');
                    let newSort = 'ascending';

                    if (currentSort === 'ascending') newSort = 'descending';
                    else if (currentSort === 'descending') newSort = 'none';

                    // Reset other headers
                    sortableHeaders.forEach(h => h.setAttribute('aria-sort', 'none'));
                    header.setAttribute('aria-sort', newSort);

                    window.accessibilityManager.announce(
                        `${header.textContent} 列を${newSort === 'ascending' ? '昇順' : newSort === 'descending' ? '降順' : '未ソート'}でソートしました`
                    );
                });
            });
        });
    }
}

// Initialize accessibility features when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.accessibilityManager = new AccessibilityManager();
    window.formAccessibility = new FormAccessibility();
    window.componentAccessibility = new ComponentAccessibility();
});

// Export for module usage
export { AccessibilityManager, FormAccessibility, ComponentAccessibility };