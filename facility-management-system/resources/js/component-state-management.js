/**
 * Component State Management
 * 
 * Provides centralized state management for UI components including:
 * - Theme configuration with design token values
 * - Component initialization utilities
 * - Event handling utilities for interactive components
 * - Accessibility enhancement utilities
 */

/**
 * Theme Configuration Object
 * Centralized design token values for consistent theming
 */
const ThemeConfig = {
    // Color palette from design tokens
    colors: {
        primary: '#00B4E3',
        secondary: '#F27CA6',
        success: '#198754',
        warning: '#ffc107',
        danger: '#dc3545',
        info: '#0dcaf0',
        light: '#f8f9fa',
        dark: '#212529',

        // Gradient colors
        gradientStart: 'rgba(0, 180, 227, 0.3)',
        gradientEnd: 'rgba(242, 124, 166, 0.3)',

        // Gray scale
        gray: {
            50: '#f8f9fa',
            100: '#e9ecef',
            200: '#dee2e6',
            300: '#ced4da',
            400: '#adb5bd',
            500: '#6c757d',
            600: '#495057',
            700: '#343a40',
            800: '#212529',
            900: '#000000'
        }
    },

    // Typography scale
    typography: {
        fontFamily: {
            base: "'Noto Sans JP', 'Hiragino Kaku Gothic ProN', sans-serif",
            heading: "'Roboto', 'Noto Sans JP', sans-serif",
            monospace: "'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, Courier, monospace"
        },
        fontSize: {
            xs: '0.75rem',    // 12px
            sm: '0.875rem',   // 14px
            base: '1rem',     // 16px
            lg: '1.125rem',   // 18px
            xl: '1.25rem',    // 20px
            '2xl': '1.5rem',  // 24px
            '3xl': '1.875rem' // 30px
        },
        fontWeight: {
            normal: 400,
            medium: 500,
            semibold: 600,
            bold: 700
        },
        lineHeight: {
            tight: 1.25,
            normal: 1.5,
            relaxed: 1.75
        }
    },

    // Spacing system (based on 0.25rem = 4px)
    spacing: {
        0: '0',
        1: '0.25rem',   // 4px
        2: '0.5rem',    // 8px
        3: '0.75rem',   // 12px
        4: '1rem',      // 16px
        5: '1.25rem',   // 20px
        6: '1.5rem',    // 24px
        8: '2rem',      // 32px
        10: '2.5rem',   // 40px
        12: '3rem',     // 48px
        16: '4rem'      // 64px
    },

    // Border radius values
    borderRadius: {
        none: '0',
        sm: '6px',
        base: '8px',
        lg: '12px',
        xl: '16px',
        full: '9999px'
    },

    // Box shadow definitions
    shadows: {
        sm: '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
        base: '0 2px 4px 0 rgba(0, 0, 0, 0.1)',
        md: '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
        lg: '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
        xl: '0 20px 25px -5px rgba(0, 0, 0, 0.1)',
        inner: 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)'
    },

    // Animation timing
    animation: {
        duration: {
            fast: 150,
            base: 300,
            slow: 500
        },
        easing: {
            ease: 'ease',
            easeIn: 'ease-in',
            easeOut: 'ease-out',
            easeInOut: 'ease-in-out'
        }
    },

    // Breakpoints for responsive design
    breakpoints: {
        sm: '576px',
        md: '768px',
        lg: '992px',
        xl: '1200px',
        xxl: '1400px'
    },

    // Z-index scale
    zIndex: {
        dropdown: 1000,
        sticky: 1020,
        fixed: 1030,
        modal: 1040,
        popover: 1050,
        tooltip: 1060
    }
};

/**
 * ComponentRegistry Class
 * Manages component instances and their lifecycle
 */
class ComponentRegistry {
    constructor() {
        this.components = new Map();
        this.observers = new Map();
    }

    register(name, instance, element) {
        if (!this.components.has(name)) {
            this.components.set(name, new Map());
        }

        const componentMap = this.components.get(name);
        const id = this.generateId();

        componentMap.set(id, {
            instance,
            element,
            id,
            created: new Date()
        });

        // Store ID on element for easy lookup
        element.dataset.componentId = id;
        element.dataset.componentType = name;

        return id;
    }

    unregister(name, id) {
        if (this.components.has(name)) {
            const componentMap = this.components.get(name);
            const component = componentMap.get(id);

            if (component) {
                // Clean up component
                if (component.instance.destroy) {
                    component.instance.destroy();
                }

                // Remove dataset attributes
                delete component.element.dataset.componentId;
                delete component.element.dataset.componentType;

                componentMap.delete(id);

                // Remove empty component maps
                if (componentMap.size === 0) {
                    this.components.delete(name);
                }

                return true;
            }
        }

        return false;
    }

    get(name, id) {
        if (this.components.has(name)) {
            const componentMap = this.components.get(name);
            return componentMap.get(id);
        }

        return null;
    }

    getByElement(element) {
        const id = element.dataset.componentId;
        const type = element.dataset.componentType;

        if (id && type) {
            return this.get(type, id);
        }

        return null;
    }

    getAll(name) {
        if (this.components.has(name)) {
            return Array.from(this.components.get(name).values());
        }

        return [];
    }

    getAllComponents() {
        const allComponents = [];

        this.components.forEach((componentMap, name) => {
            componentMap.forEach(component => {
                allComponents.push({ ...component, type: name });
            });
        });

        return allComponents;
    }

    generateId() {
        return 'comp_' + Math.random().toString(36).substr(2, 9);
    }

    // Observer pattern for component events
    observe(componentName, eventType, callback) {
        const key = `${componentName}:${eventType}`;

        if (!this.observers.has(key)) {
            this.observers.set(key, []);
        }

        this.observers.get(key).push(callback);
    }

    notify(componentName, eventType, data) {
        const key = `${componentName}:${eventType}`;

        if (this.observers.has(key)) {
            this.observers.get(key).forEach(callback => {
                try {
                    callback(data);
                } catch (error) {
                    console.error('Observer callback error:', error);
                }
            });
        }
    }
}

/**
 * ComponentInitializer Class
 * Handles automatic component initialization and lifecycle management
 */
class ComponentInitializer {
    constructor(registry) {
        this.registry = registry;
        this.initializers = new Map();
        this.mutationObserver = null;

        this.setupMutationObserver();
    }

    // Register component initializer
    register(selector, componentClass, options = {}) {
        this.initializers.set(selector, {
            componentClass,
            options,
            autoInit: options.autoInit !== false
        });

        // Initialize existing elements if autoInit is enabled
        if (options.autoInit !== false) {
            this.initializeExisting(selector);
        }
    }

    // Initialize existing elements
    initializeExisting(selector) {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
            this.initializeElement(element, selector);
        });
    }

    // Initialize a single element
    initializeElement(element, selector) {
        // Skip if already initialized
        if (element.dataset.componentId) {
            return;
        }

        const initializer = this.initializers.get(selector);
        if (!initializer) {
            return;
        }

        try {
            const instance = new initializer.componentClass(element, initializer.options);
            const componentName = initializer.componentClass.name;

            this.registry.register(componentName, instance, element);

            // Dispatch initialization event
            element.dispatchEvent(new CustomEvent('component:initialized', {
                detail: { componentName, instance }
            }));

        } catch (error) {
            console.error(`Failed to initialize component for selector "${selector}":`, error);
        }
    }

    // Setup mutation observer for dynamic content
    setupMutationObserver() {
        this.mutationObserver = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        this.checkAndInitialize(node);
                    }
                });
            });
        });

        this.mutationObserver.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    // Check and initialize new elements
    checkAndInitialize(element) {
        this.initializers.forEach((initializer, selector) => {
            if (initializer.autoInit) {
                // Check if element matches selector
                if (element.matches && element.matches(selector)) {
                    this.initializeElement(element, selector);
                }

                // Check child elements
                const childElements = element.querySelectorAll(selector);
                childElements.forEach(child => {
                    this.initializeElement(child, selector);
                });
            }
        });
    }

    // Manually initialize component
    initialize(selector, element = null) {
        if (element) {
            this.initializeElement(element, selector);
        } else {
            this.initializeExisting(selector);
        }
    }

    // Destroy components
    destroy(element) {
        const component = this.registry.getByElement(element);
        if (component) {
            this.registry.unregister(component.type, component.id);
        }
    }
}

/**
 * EventManager Class
 * Centralized event handling for components
 */
class EventManager {
    constructor() {
        this.listeners = new Map();
        this.delegatedListeners = new Map();
    }

    // Add event listener with automatic cleanup
    on(element, event, handler, options = {}) {
        const id = this.generateListenerId();

        element.addEventListener(event, handler, options);

        this.listeners.set(id, {
            element,
            event,
            handler,
            options
        });

        return id;
    }

    // Remove event listener
    off(id) {
        const listener = this.listeners.get(id);
        if (listener) {
            listener.element.removeEventListener(listener.event, listener.handler, listener.options);
            this.listeners.delete(id);
            return true;
        }

        return false;
    }

    // Event delegation
    delegate(container, selector, event, handler) {
        const id = this.generateListenerId();

        const delegatedHandler = (e) => {
            const target = e.target.closest(selector);
            if (target && container.contains(target)) {
                handler.call(target, e);
            }
        };

        container.addEventListener(event, delegatedHandler);

        this.delegatedListeners.set(id, {
            container,
            selector,
            event,
            handler: delegatedHandler,
            originalHandler: handler
        });

        return id;
    }

    // Remove delegated event listener
    undelegate(id) {
        const listener = this.delegatedListeners.get(id);
        if (listener) {
            listener.container.removeEventListener(listener.event, listener.handler);
            this.delegatedListeners.delete(id);
            return true;
        }

        return false;
    }

    // Custom event dispatcher
    emit(element, eventName, detail = {}) {
        const event = new CustomEvent(eventName, {
            detail,
            bubbles: true,
            cancelable: true
        });

        return element.dispatchEvent(event);
    }

    // Cleanup all listeners for an element
    cleanup(element) {
        // Remove direct listeners
        this.listeners.forEach((listener, id) => {
            if (listener.element === element) {
                this.off(id);
            }
        });

        // Remove delegated listeners where element is container
        this.delegatedListeners.forEach((listener, id) => {
            if (listener.container === element) {
                this.undelegate(id);
            }
        });
    }

    generateListenerId() {
        return 'listener_' + Math.random().toString(36).substr(2, 9);
    }
}

/**
 * AccessibilityEnhancer Class
 * Provides accessibility enhancements for components
 */
class AccessibilityEnhancer {
    constructor() {
        this.focusTracker = new FocusTracker();
        this.ariaManager = new AriaManager();
    }

    // Enhance component accessibility
    enhance(element, options = {}) {
        const enhancements = {
            focusManagement: true,
            keyboardNavigation: true,
            ariaLabels: true,
            announcements: true,
            ...options
        };

        if (enhancements.focusManagement) {
            this.enhanceFocusManagement(element);
        }

        if (enhancements.keyboardNavigation) {
            this.enhanceKeyboardNavigation(element);
        }

        if (enhancements.ariaLabels) {
            this.enhanceAriaLabels(element);
        }

        if (enhancements.announcements) {
            this.setupAnnouncements(element);
        }
    }

    enhanceFocusManagement(element) {
        // Ensure focusable elements have proper tabindex
        const focusableElements = element.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );

        focusableElements.forEach(el => {
            if (!el.hasAttribute('tabindex')) {
                el.setAttribute('tabindex', '0');
            }
        });

        // Add focus indicators
        element.addEventListener('focusin', (e) => {
            e.target.classList.add('focus-visible');
        });

        element.addEventListener('focusout', (e) => {
            e.target.classList.remove('focus-visible');
        });
    }

    enhanceKeyboardNavigation(element) {
        element.addEventListener('keydown', (e) => {
            switch (e.key) {
                case 'Escape':
                    this.handleEscape(e);
                    break;
                case 'Tab':
                    this.handleTab(e);
                    break;
                case 'Enter':
                case ' ':
                    this.handleActivation(e);
                    break;
                case 'ArrowUp':
                case 'ArrowDown':
                case 'ArrowLeft':
                case 'ArrowRight':
                    this.handleArrowNavigation(e);
                    break;
            }
        });
    }

    enhanceAriaLabels(element) {
        // Auto-generate ARIA labels for unlabeled elements
        const unlabeledButtons = element.querySelectorAll('button:not([aria-label]):not([aria-labelledby])');
        unlabeledButtons.forEach(button => {
            const text = button.textContent.trim();
            if (text) {
                button.setAttribute('aria-label', text);
            }
        });

        // Enhance form controls
        const formControls = element.querySelectorAll('input, select, textarea');
        formControls.forEach(control => {
            const label = element.querySelector(`label[for="${control.id}"]`);
            if (label && !control.hasAttribute('aria-labelledby')) {
                control.setAttribute('aria-labelledby', label.id || this.generateId());
                if (!label.id) {
                    label.id = control.getAttribute('aria-labelledby');
                }
            }
        });
    }

    setupAnnouncements(element) {
        // Create live region for announcements
        if (!element.querySelector('.sr-live-region')) {
            const liveRegion = document.createElement('div');
            liveRegion.className = 'sr-live-region';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.style.cssText = 'position: absolute; left: -10000px; width: 1px; height: 1px; overflow: hidden;';
            element.appendChild(liveRegion);
        }
    }

    // Announce message to screen readers
    announce(element, message, priority = 'polite') {
        const liveRegion = element.querySelector('.sr-live-region');
        if (liveRegion) {
            liveRegion.setAttribute('aria-live', priority);
            liveRegion.textContent = message;

            // Clear after announcement
            setTimeout(() => {
                liveRegion.textContent = '';
            }, 1000);
        }
    }

    handleEscape(e) {
        // Close modals, dropdowns, etc.
        const modal = e.target.closest('.modal');
        const dropdown = e.target.closest('.dropdown');

        if (modal) {
            const closeButton = modal.querySelector('[data-bs-dismiss="modal"]');
            if (closeButton) {
                closeButton.click();
            }
        }

        if (dropdown) {
            const toggle = dropdown.querySelector('.dropdown-toggle');
            if (toggle) {
                toggle.click();
            }
        }
    }

    handleTab(e) {
        // Trap focus within modals
        const modal = e.target.closest('.modal');
        if (modal) {
            this.trapFocus(e, modal);
        }
    }

    handleActivation(e) {
        // Allow space/enter to activate buttons and links
        if (e.target.matches('button, [role="button"]') && e.key === ' ') {
            e.preventDefault();
            e.target.click();
        }
    }

    handleArrowNavigation(e) {
        // Handle arrow navigation in lists, menus, etc.
        const list = e.target.closest('[role="listbox"], [role="menu"], .nav');
        if (list) {
            this.navigateList(e, list);
        }
    }

    trapFocus(e, container) {
        const focusableElements = container.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );

        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        if (e.shiftKey && e.target === firstElement) {
            e.preventDefault();
            lastElement.focus();
        } else if (!e.shiftKey && e.target === lastElement) {
            e.preventDefault();
            firstElement.focus();
        }
    }

    navigateList(e, list) {
        const items = Array.from(list.querySelectorAll('[role="option"], [role="menuitem"], .nav-link'));
        const currentIndex = items.indexOf(e.target);

        let nextIndex;

        switch (e.key) {
            case 'ArrowUp':
                e.preventDefault();
                nextIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
                break;
            case 'ArrowDown':
                e.preventDefault();
                nextIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
                break;
            case 'Home':
                e.preventDefault();
                nextIndex = 0;
                break;
            case 'End':
                e.preventDefault();
                nextIndex = items.length - 1;
                break;
        }

        if (nextIndex !== undefined && items[nextIndex]) {
            items[nextIndex].focus();
        }
    }

    generateId() {
        return 'a11y_' + Math.random().toString(36).substr(2, 9);
    }
}

/**
 * FocusTracker Class
 * Tracks focus state and provides focus management utilities
 */
class FocusTracker {
    constructor() {
        this.focusHistory = [];
        this.maxHistoryLength = 10;

        this.setupTracking();
    }

    setupTracking() {
        document.addEventListener('focusin', (e) => {
            this.addToHistory(e.target);
        });
    }

    addToHistory(element) {
        // Remove element if it already exists in history
        const existingIndex = this.focusHistory.indexOf(element);
        if (existingIndex > -1) {
            this.focusHistory.splice(existingIndex, 1);
        }

        // Add to beginning of history
        this.focusHistory.unshift(element);

        // Limit history length
        if (this.focusHistory.length > this.maxHistoryLength) {
            this.focusHistory = this.focusHistory.slice(0, this.maxHistoryLength);
        }
    }

    getPreviousFocus() {
        return this.focusHistory[1] || null;
    }

    restorePreviousFocus() {
        const previousElement = this.getPreviousFocus();
        if (previousElement && document.contains(previousElement)) {
            previousElement.focus();
            return true;
        }

        return false;
    }
}

/**
 * AriaManager Class
 * Manages ARIA attributes and relationships
 */
class AriaManager {
    constructor() {
        this.relationships = new Map();
    }

    // Create ARIA relationship
    relate(controller, target, relationship) {
        const controllerId = controller.id || this.generateId();
        const targetId = target.id || this.generateId();

        controller.id = controllerId;
        target.id = targetId;

        switch (relationship) {
            case 'controls':
                controller.setAttribute('aria-controls', targetId);
                break;
            case 'describedby':
                controller.setAttribute('aria-describedby', targetId);
                break;
            case 'labelledby':
                target.setAttribute('aria-labelledby', controllerId);
                break;
            case 'owns':
                controller.setAttribute('aria-owns', targetId);
                break;
        }

        this.relationships.set(`${controllerId}-${targetId}`, relationship);
    }

    // Remove ARIA relationship
    unrelate(controller, target, relationship) {
        const controllerId = controller.id;
        const targetId = target.id;

        if (!controllerId || !targetId) return;

        switch (relationship) {
            case 'controls':
                controller.removeAttribute('aria-controls');
                break;
            case 'describedby':
                controller.removeAttribute('aria-describedby');
                break;
            case 'labelledby':
                target.removeAttribute('aria-labelledby');
                break;
            case 'owns':
                controller.removeAttribute('aria-owns');
                break;
        }

        this.relationships.delete(`${controllerId}-${targetId}`);
    }

    generateId() {
        return 'aria_' + Math.random().toString(36).substr(2, 9);
    }
}

// Create global instances
const componentRegistry = new ComponentRegistry();
const componentInitializer = new ComponentInitializer(componentRegistry);
const eventManager = new EventManager();
const accessibilityEnhancer = new AccessibilityEnhancer();

// Export everything
export {
    ThemeConfig,
    ComponentRegistry,
    ComponentInitializer,
    EventManager,
    AccessibilityEnhancer,
    FocusTracker,
    AriaManager,
    componentRegistry,
    componentInitializer,
    eventManager,
    accessibilityEnhancer
};

// Auto-initialize accessibility enhancements
document.addEventListener('DOMContentLoaded', () => {
    // Enhance accessibility for the entire document
    accessibilityEnhancer.enhance(document.body);

    // Register common component initializers
    if (typeof FormToggle !== 'undefined') {
        componentInitializer.register('[data-form-toggle]', FormToggle);
    }

    if (typeof AutoCalculator !== 'undefined') {
        componentInitializer.register('[data-auto-calculate]', AutoCalculator);
    }

    // Setup global keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        // Alt + / to show keyboard shortcuts
        if (e.altKey && e.key === '/') {
            e.preventDefault();
            eventManager.emit(document, 'keyboardShortcuts:toggle');
        }
    });
});