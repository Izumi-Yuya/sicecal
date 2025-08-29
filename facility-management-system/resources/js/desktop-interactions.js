/**
 * Desktop Interaction Utilities
 * 
 * JavaScript utilities for enhanced desktop interactions including
 * smooth scrolling, focus management, loading states, and context menus
 */

class DesktopInteractions {
    constructor() {
        this.isDesktop = window.innerWidth >= 992;
        this.scrollToTopButton = null;
        this.contextMenu = null;

        this.init();
    }

    init() {
        if (this.isDesktop) {
            this.initSmoothScrolling();
            this.initScrollToTop();
            this.initFocusManagement();
            this.initLoadingStates();
            this.initContextMenu();
            this.initKeyboardNavigation();
            this.initDragAndDrop();
        }

        // Listen for resize events
        window.addEventListener('resize', () => {
            const wasDesktop = this.isDesktop;
            this.isDesktop = window.innerWidth >= 992;

            if (wasDesktop !== this.isDesktop) {
                if (this.isDesktop) {
                    this.enableDesktopInteractions();
                } else {
                    this.disableDesktopInteractions();
                }
            }
        });
    }

    // Smooth Scrolling Implementation
    initSmoothScrolling() {
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Smooth scroll to focused elements
        document.addEventListener('focusin', (e) => {
            if (e.target.matches('.form-control, .form-select, .btn')) {
                setTimeout(() => {
                    e.target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }, 100);
            }
        });
    }

    // Scroll to Top Button
    initScrollToTop() {
        // Create scroll to top button
        this.scrollToTopButton = document.createElement('button');
        this.scrollToTopButton.className = 'scroll-to-top';
        this.scrollToTopButton.setAttribute('aria-label', 'ページトップへ戻る');
        document.body.appendChild(this.scrollToTopButton);

        // Show/hide based on scroll position
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > 300) {
                this.scrollToTopButton.classList.add('show');
            } else {
                this.scrollToTopButton.classList.remove('show');
            }
        });

        // Click handler
        this.scrollToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Enhanced Focus Management
    initFocusManagement() {
        // Add keyboard navigation class to body
        document.body.classList.add('keyboard-navigation');

        // Track focus for form groups
        document.addEventListener('focusin', (e) => {
            if (e.target.matches('.form-control, .form-select')) {
                const formGroup = e.target.closest('.form-group');
                if (formGroup) {
                    formGroup.classList.add('focused');
                }
            }
        });

        document.addEventListener('focusout', (e) => {
            if (e.target.matches('.form-control, .form-select')) {
                const formGroup = e.target.closest('.form-group');
                if (formGroup) {
                    formGroup.classList.remove('focused');
                }
            }
        });

        // Skip navigation link
        const skipNav = document.createElement('a');
        skipNav.href = '#main-content';
        skipNav.className = 'skip-navigation';
        skipNav.textContent = 'メインコンテンツへスキップ';
        document.body.insertBefore(skipNav, document.body.firstChild);

        // Focus trap for modals
        this.initModalFocusTrap();
    }

    initModalFocusTrap() {
        document.addEventListener('shown.bs.modal', (e) => {
            const modal = e.target;
            const focusableElements = modal.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );

            if (focusableElements.length > 0) {
                focusableElements[0].focus();
            }

            // Trap focus within modal
            modal.addEventListener('keydown', (e) => {
                if (e.key === 'Tab') {
                    const firstElement = focusableElements[0];
                    const lastElement = focusableElements[focusableElements.length - 1];

                    if (e.shiftKey && document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    } else if (!e.shiftKey && document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            });
        });
    }

    // Loading States Management
    initLoadingStates() {
        // Button loading states
        this.initButtonLoadingStates();

        // Form loading states
        this.initFormLoadingStates();

        // Page loading indicator
        this.initPageLoadingIndicator();
    }

    initButtonLoadingStates() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('.btn[data-loading]')) {
                this.setButtonLoading(e.target, true);

                // Auto-remove loading state after timeout (fallback)
                setTimeout(() => {
                    this.setButtonLoading(e.target, false);
                }, 5000);
            }
        });
    }

    setButtonLoading(button, isLoading) {
        if (isLoading) {
            button.classList.add('btn-loading');
            button.disabled = true;
            button.setAttribute('data-original-text', button.textContent);
        } else {
            button.classList.remove('btn-loading');
            button.disabled = false;
            const originalText = button.getAttribute('data-original-text');
            if (originalText) {
                button.textContent = originalText;
                button.removeAttribute('data-original-text');
            }
        }
    }

    initFormLoadingStates() {
        document.addEventListener('submit', (e) => {
            if (e.target.matches('form[data-loading]')) {
                this.setFormLoading(e.target, true);
            }
        });
    }

    setFormLoading(form, isLoading) {
        if (isLoading) {
            form.classList.add('form-loading');

            // Disable all form controls
            const controls = form.querySelectorAll('input, select, textarea, button');
            controls.forEach(control => {
                control.disabled = true;
            });
        } else {
            form.classList.remove('form-loading');

            // Re-enable form controls
            const controls = form.querySelectorAll('input, select, textarea, button');
            controls.forEach(control => {
                control.disabled = false;
            });
        }
    }

    initPageLoadingIndicator() {
        // Create progress bar for page navigation
        const progressBar = document.createElement('div');
        progressBar.className = 'page-loading-progress';
        progressBar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #00B4E3, #F27CA6);
            z-index: 9999;
            transition: width 0.3s ease;
        `;
        document.body.appendChild(progressBar);

        // Show progress on navigation
        let progressInterval;

        window.addEventListener('beforeunload', () => {
            progressBar.style.width = '30%';

            progressInterval = setInterval(() => {
                const currentWidth = parseFloat(progressBar.style.width);
                if (currentWidth < 90) {
                    progressBar.style.width = (currentWidth + 10) + '%';
                }
            }, 100);
        });

        window.addEventListener('load', () => {
            clearInterval(progressInterval);
            progressBar.style.width = '100%';

            setTimeout(() => {
                progressBar.style.width = '0%';
            }, 500);
        });
    }

    // Context Menu Implementation
    initContextMenu() {
        // Create context menu element
        this.contextMenu = document.createElement('div');
        this.contextMenu.className = 'context-menu';
        document.body.appendChild(this.contextMenu);

        // Right-click handler for tables
        document.addEventListener('contextmenu', (e) => {
            if (e.target.closest('.data-table tbody tr')) {
                e.preventDefault();
                this.showContextMenu(e, this.getTableContextMenuItems());
            }
        });

        // Hide context menu on click outside
        document.addEventListener('click', () => {
            this.hideContextMenu();
        });

        // Hide context menu on scroll
        document.addEventListener('scroll', () => {
            this.hideContextMenu();
        });
    }

    showContextMenu(event, items) {
        this.contextMenu.innerHTML = items.map(item => {
            if (item.divider) {
                return '<div class="context-menu-divider"></div>';
            }
            return `
                <a href="#" class="context-menu-item ${item.disabled ? 'disabled' : ''}" 
                   data-action="${item.action}">
                    ${item.label}
                </a>
            `;
        }).join('');

        // Position context menu
        this.contextMenu.style.left = event.pageX + 'px';
        this.contextMenu.style.top = event.pageY + 'px';
        this.contextMenu.classList.add('show');

        // Add click handlers
        this.contextMenu.addEventListener('click', (e) => {
            e.preventDefault();
            const action = e.target.getAttribute('data-action');
            if (action && !e.target.classList.contains('disabled')) {
                this.handleContextMenuAction(action, event.target);
                this.hideContextMenu();
            }
        });
    }

    hideContextMenu() {
        this.contextMenu.classList.remove('show');
    }

    getTableContextMenuItems() {
        return [
            { label: '詳細を表示', action: 'view' },
            { label: '編集', action: 'edit' },
            { divider: true },
            { label: 'コピー', action: 'copy' },
            { label: 'エクスポート', action: 'export' },
            { divider: true },
            { label: '削除', action: 'delete', disabled: false }
        ];
    }

    handleContextMenuAction(action, targetRow) {
        const row = targetRow.closest('tr');

        switch (action) {
            case 'view':
                console.log('View row:', row);
                break;
            case 'edit':
                console.log('Edit row:', row);
                break;
            case 'copy':
                this.copyRowData(row);
                break;
            case 'export':
                console.log('Export row:', row);
                break;
            case 'delete':
                console.log('Delete row:', row);
                break;
        }
    }

    copyRowData(row) {
        const cells = Array.from(row.querySelectorAll('td'));
        const data = cells.map(cell => cell.textContent.trim()).join('\t');

        navigator.clipboard.writeText(data).then(() => {
            this.showNotification('データをクリップボードにコピーしました', 'success');
        });
    }

    // Keyboard Navigation Enhancements
    initKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            // Ctrl+F for search
            if (e.ctrlKey && e.key === 'f') {
                const searchInput = document.querySelector('.search-input, [type="search"]');
                if (searchInput) {
                    e.preventDefault();
                    searchInput.focus();
                }
            }

            // Arrow key navigation for tables
            if (e.target.closest('.data-table')) {
                this.handleTableKeyNavigation(e);
            }

            // Tab navigation improvements
            if (e.key === 'Tab') {
                this.handleTabNavigation(e);
            }
        });
    }

    handleTableKeyNavigation(e) {
        const currentRow = e.target.closest('tr');
        if (!currentRow) return;

        let targetRow = null;

        switch (e.key) {
            case 'ArrowUp':
                targetRow = currentRow.previousElementSibling;
                break;
            case 'ArrowDown':
                targetRow = currentRow.nextElementSibling;
                break;
        }

        if (targetRow) {
            e.preventDefault();
            const firstFocusable = targetRow.querySelector('a, button, input, select, textarea');
            if (firstFocusable) {
                firstFocusable.focus();
            }
        }
    }

    handleTabNavigation(e) {
        // Add visual feedback for tab navigation
        document.body.classList.add('using-keyboard');

        // Remove class on mouse interaction
        const removeKeyboardClass = () => {
            document.body.classList.remove('using-keyboard');
            document.removeEventListener('mousedown', removeKeyboardClass);
        };

        document.addEventListener('mousedown', removeKeyboardClass);
    }

    // Drag and Drop Enhancements
    initDragAndDrop() {
        const dropZones = document.querySelectorAll('.drag-drop-zone');

        dropZones.forEach(zone => {
            zone.addEventListener('dragover', (e) => {
                e.preventDefault();
                zone.classList.add('drag-over');
            });

            zone.addEventListener('dragleave', (e) => {
                if (!zone.contains(e.relatedTarget)) {
                    zone.classList.remove('drag-over');
                }
            });

            zone.addEventListener('drop', (e) => {
                e.preventDefault();
                zone.classList.remove('drag-over');
                zone.classList.add('drag-active');

                // Handle file drop
                const files = Array.from(e.dataTransfer.files);
                this.handleFileDrop(files, zone);

                setTimeout(() => {
                    zone.classList.remove('drag-active');
                }, 2000);
            });
        });
    }

    handleFileDrop(files, zone) {
        console.log('Files dropped:', files);
        this.showNotification(`${files.length}個のファイルがアップロードされました`, 'success');
    }

    // Notification System
    showNotification(message, type = 'info', duration = 3000) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#198754' : type === 'error' ? '#dc3545' : '#0dcaf0'};
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        // Auto remove
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, duration);
    }

    // Enable/Disable Desktop Interactions
    enableDesktopInteractions() {
        document.body.classList.add('desktop-interactions');
        this.initSmoothScrolling();
        this.initScrollToTop();
        this.initFocusManagement();
        this.initLoadingStates();
        this.initContextMenu();
        this.initKeyboardNavigation();
        this.initDragAndDrop();
    }

    disableDesktopInteractions() {
        document.body.classList.remove('desktop-interactions', 'keyboard-navigation');

        if (this.scrollToTopButton) {
            this.scrollToTopButton.remove();
            this.scrollToTopButton = null;
        }

        if (this.contextMenu) {
            this.contextMenu.remove();
            this.contextMenu = null;
        }
    }

    // Public API methods
    static setButtonLoading(button, isLoading) {
        const instance = window.desktopInteractions;
        if (instance) {
            instance.setButtonLoading(button, isLoading);
        }
    }

    static setFormLoading(form, isLoading) {
        const instance = window.desktopInteractions;
        if (instance) {
            instance.setFormLoading(form, isLoading);
        }
    }

    static showNotification(message, type, duration) {
        const instance = window.desktopInteractions;
        if (instance) {
            instance.showNotification(message, type, duration);
        }
    }
}

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    window.desktopInteractions = new DesktopInteractions();
});

export default DesktopInteractions;