/**
 * Form Utilities
 * 
 * JavaScript utilities for facility form interactions including:
 * - Form display/edit toggle system
 * - Auto-calculation utilities
 * - Form validation enhancements
 */

/**
 * FormToggle Class
 * Manages switching between display and edit modes for form fields
 */
class FormToggle {
    constructor(container, options = {}) {
        this.container = typeof container === 'string' ? document.querySelector(container) : container;
        this.options = {
            editButtonSelector: '.form-toggle-btn',
            displaySelector: '.form-display',
            editSelector: '.form-edit',
            animationDuration: 200,
            ...options
        };

        this.isEditMode = false;
        this.init();
    }

    init() {
        if (!this.container) {
            console.warn('FormToggle: Container not found');
            return;
        }

        // Add initial classes
        this.container.classList.add('form-toggle-container', 'view-mode');

        // Find or create toggle button
        this.toggleButton = this.container.querySelector(this.options.editButtonSelector);
        if (!this.toggleButton) {
            this.createToggleButton();
        }

        // Bind events
        this.bindEvents();

        // Initialize display state
        this.updateDisplay();
    }

    createToggleButton() {
        this.toggleButton = document.createElement('button');
        this.toggleButton.className = 'form-toggle-btn';
        this.toggleButton.type = 'button';
        this.toggleButton.innerHTML = '<i class="bi bi-pencil"></i>';
        this.toggleButton.setAttribute('aria-label', '編集');
        this.toggleButton.setAttribute('title', '編集');

        this.container.appendChild(this.toggleButton);
    }

    bindEvents() {
        this.toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            this.toggle();
        });

        // Handle escape key to cancel edit mode
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isEditMode) {
                this.setViewMode();
            }
        });

        // Handle form submission in edit mode
        const form = this.container.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                if (this.isEditMode) {
                    this.setViewMode();
                }
            });
        }
    }

    toggle() {
        if (this.isEditMode) {
            this.setViewMode();
        } else {
            this.setEditMode();
        }
    }

    setEditMode() {
        this.isEditMode = true;
        this.container.classList.remove('view-mode');
        this.container.classList.add('edit-mode');

        // Update button
        this.toggleButton.innerHTML = '<i class="bi bi-check"></i>';
        this.toggleButton.setAttribute('aria-label', '保存');
        this.toggleButton.setAttribute('title', '保存');

        // Focus first input in edit mode
        setTimeout(() => {
            const firstInput = this.container.querySelector(`${this.options.editSelector} input, ${this.options.editSelector} select, ${this.options.editSelector} textarea`);
            if (firstInput) {
                firstInput.focus();
            }
        }, this.options.animationDuration);

        // Dispatch custom event
        this.container.dispatchEvent(new CustomEvent('formToggle:editMode', {
            detail: { container: this.container }
        }));
    }

    setViewMode() {
        this.isEditMode = false;
        this.container.classList.remove('edit-mode');
        this.container.classList.add('view-mode');

        // Update button
        this.toggleButton.innerHTML = '<i class="bi bi-pencil"></i>';
        this.toggleButton.setAttribute('aria-label', '編集');
        this.toggleButton.setAttribute('title', '編集');

        // Update display values from edit inputs
        this.updateDisplayFromEdit();

        // Dispatch custom event
        this.container.dispatchEvent(new CustomEvent('formToggle:viewMode', {
            detail: { container: this.container }
        }));
    }

    updateDisplay() {
        const displayElements = this.container.querySelectorAll(this.options.displaySelector);
        const editElements = this.container.querySelectorAll(`${this.options.editSelector} input, ${this.options.editSelector} select, ${this.options.editSelector} textarea`);

        editElements.forEach((editElement, index) => {
            const displayElement = displayElements[index];
            if (displayElement && editElement.value) {
                displayElement.textContent = this.formatDisplayValue(editElement.value, editElement.type);
                displayElement.classList.remove('empty');
            } else if (displayElement) {
                displayElement.textContent = '';
                displayElement.classList.add('empty');
            }
        });
    }

    updateDisplayFromEdit() {
        this.updateDisplay();
    }

    formatDisplayValue(value, inputType) {
        if (!value) return '';

        switch (inputType) {
            case 'date':
                return new Date(value).toLocaleDateString('ja-JP');
            case 'number':
                return Number(value).toLocaleString('ja-JP');
            case 'email':
                return value;
            case 'tel':
                return value;
            default:
                return value;
        }
    }

    // Public methods
    getValue() {
        const editElements = this.container.querySelectorAll(`${this.options.editSelector} input, ${this.options.editSelector} select, ${this.options.editSelector} textarea`);
        const values = {};

        editElements.forEach(element => {
            if (element.name) {
                values[element.name] = element.value;
            }
        });

        return values;
    }

    setValue(values) {
        Object.keys(values).forEach(name => {
            const element = this.container.querySelector(`${this.options.editSelector} [name="${name}"]`);
            if (element) {
                element.value = values[name];
            }
        });

        this.updateDisplay();
    }

    destroy() {
        if (this.toggleButton && this.toggleButton.parentNode) {
            this.toggleButton.parentNode.removeChild(this.toggleButton);
        }

        this.container.classList.remove('form-toggle-container', 'view-mode', 'edit-mode');
    }
}

/**
 * AutoCalculator Class
 * Handles automatic calculations for form fields
 */
class AutoCalculator {
    constructor() {
        this.calculators = new Map();
        this.init();
    }

    init() {
        // Initialize auto-calculated fields
        document.querySelectorAll('.auto-calculated-field').forEach(field => {
            this.initializeField(field);
        });
    }

    initializeField(field) {
        const input = field.querySelector('input, .form-display');
        const calculationType = field.dataset.calculation;

        if (input && calculationType) {
            this.calculators.set(field, {
                type: calculationType,
                input: input,
                dependencies: this.findDependencies(field)
            });

            this.bindDependencyEvents(field);
        }
    }

    findDependencies(field) {
        const dependencies = [];
        const dependsOn = field.dataset.dependsOn;

        if (dependsOn) {
            dependsOn.split(',').forEach(selector => {
                const element = document.querySelector(selector.trim());
                if (element) {
                    dependencies.push(element);
                }
            });
        }

        return dependencies;
    }

    bindDependencyEvents(field) {
        const calculator = this.calculators.get(field);

        calculator.dependencies.forEach(dependency => {
            dependency.addEventListener('change', () => {
                this.calculate(field);
            });

            dependency.addEventListener('input', () => {
                this.debounce(() => this.calculate(field), 300);
            });
        });
    }

    calculate(field) {
        const calculator = this.calculators.get(field);
        if (!calculator) return;

        field.classList.add('calculating');

        try {
            let result;

            switch (calculator.type) {
                case 'operating-years':
                    result = this.calculateOperatingYears(calculator.dependencies[0]);
                    break;
                case 'age':
                    result = this.calculateAge(calculator.dependencies[0]);
                    break;
                case 'area-total':
                    result = this.calculateAreaTotal(calculator.dependencies);
                    break;
                case 'land-unit-price':
                    result = this.calculateLandUnitPrice(calculator.dependencies[0], calculator.dependencies[1]);
                    break;
                default:
                    console.warn(`Unknown calculation type: ${calculator.type}`);
                    return;
            }

            // Update the field value
            if (calculator.input.tagName === 'INPUT') {
                calculator.input.value = result;
            } else {
                calculator.input.textContent = result;
            }

            field.classList.remove('calculating', 'calculation-error');

            // Dispatch calculation complete event
            field.dispatchEvent(new CustomEvent('autoCalculation:complete', {
                detail: { result, type: calculator.type }
            }));

        } catch (error) {
            console.error('Calculation error:', error);
            field.classList.remove('calculating');
            field.classList.add('calculation-error');

            field.dispatchEvent(new CustomEvent('autoCalculation:error', {
                detail: { error, type: calculator.type }
            }));
        }
    }

    calculateOperatingYears(dateInput) {
        const openingDate = new Date(dateInput.value);
        if (isNaN(openingDate.getTime())) {
            return '';
        }

        const now = new Date();
        const years = Math.floor((now - openingDate) / (365.25 * 24 * 60 * 60 * 1000));
        return years >= 0 ? `${years}年` : '';
    }

    calculateAge(dateInput) {
        const birthDate = new Date(dateInput.value);
        if (isNaN(birthDate.getTime())) {
            return '';
        }

        const now = new Date();
        const age = Math.floor((now - birthDate) / (365.25 * 24 * 60 * 60 * 1000));
        return age >= 0 ? `${age}歳` : '';
    }

    calculateAreaTotal(areaInputs) {
        let total = 0;
        let hasValues = false;

        areaInputs.forEach(input => {
            const value = parseFloat(input.value);
            if (!isNaN(value)) {
                total += value;
                hasValues = true;
            }
        });

        return hasValues ? `${total.toLocaleString('ja-JP')}㎡` : '';
    }

    calculateLandUnitPrice(priceInput, areaInput) {
        const price = parseFloat(priceInput.value);
        const area = parseFloat(areaInput.value);

        if (isNaN(price) || isNaN(area) || area === 0) {
            return '';
        }

        const unitPrice = Math.round(price / area);
        return `¥${unitPrice.toLocaleString('ja-JP')}/坪`;
    }

    debounce(func, wait) {
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(func, wait);
    }

    // Static utility methods
    static calculateOperatingYears(openingDate) {
        if (!openingDate) return null;

        const opening = new Date(openingDate);
        if (isNaN(opening.getTime())) return null;

        const now = new Date();
        const years = Math.floor((now - opening) / (365.25 * 24 * 60 * 60 * 1000));
        return years >= 0 ? years : null;
    }

    static formatNumber(value, options = {}) {
        const {
            locale = 'ja-JP',
            minimumFractionDigits = 0,
            maximumFractionDigits = 2
        } = options;

        return Number(value).toLocaleString(locale, {
            minimumFractionDigits,
            maximumFractionDigits
        });
    }

    static formatDate(date, options = {}) {
        const {
            locale = 'ja-JP',
            year = 'numeric',
            month = 'long',
            day = 'numeric'
        } = options;

        return new Date(date).toLocaleDateString(locale, {
            year,
            month,
            day
        });
    }
}

/**
 * FormValidationEnhancer Class
 * Enhances form validation with better UX
 */
class FormValidationEnhancer {
    constructor(form, options = {}) {
        this.form = typeof form === 'string' ? document.querySelector(form) : form;
        this.options = {
            showValidationOnBlur: true,
            showValidationOnInput: false,
            clearValidationOnFocus: true,
            ...options
        };

        this.init();
    }

    init() {
        if (!this.form) return;

        this.bindEvents();
    }

    bindEvents() {
        // Form submission
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
                this.focusFirstError();
            }
        });

        // Field validation
        const fields = this.form.querySelectorAll('input, select, textarea');
        fields.forEach(field => {
            if (this.options.showValidationOnBlur) {
                field.addEventListener('blur', () => this.validateField(field));
            }

            if (this.options.showValidationOnInput) {
                field.addEventListener('input', () => this.validateField(field));
            }

            if (this.options.clearValidationOnFocus) {
                field.addEventListener('focus', () => this.clearFieldValidation(field));
            }
        });
    }

    validateForm() {
        const fields = this.form.querySelectorAll('input, select, textarea');
        let isValid = true;

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const isValid = field.checkValidity();

        if (isValid) {
            this.showFieldSuccess(field);
        } else {
            this.showFieldError(field, field.validationMessage);
        }

        return isValid;
    }

    showFieldError(field, message) {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');

        this.updateFeedback(field, message, 'invalid-feedback');
    }

    showFieldSuccess(field) {
        field.classList.add('is-valid');
        field.classList.remove('is-invalid');

        this.updateFeedback(field, '', 'valid-feedback');
    }

    clearFieldValidation(field) {
        field.classList.remove('is-valid', 'is-invalid');
        this.updateFeedback(field, '', 'invalid-feedback');
        this.updateFeedback(field, '', 'valid-feedback');
    }

    updateFeedback(field, message, className) {
        let feedback = field.parentNode.querySelector(`.${className}`);

        if (!feedback && message) {
            feedback = document.createElement('div');
            feedback.className = className;
            field.parentNode.appendChild(feedback);
        }

        if (feedback) {
            feedback.textContent = message;
            feedback.style.display = message ? 'block' : 'none';
        }
    }

    focusFirstError() {
        const firstError = this.form.querySelector('.is-invalid');
        if (firstError) {
            firstError.focus();
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
}

// Export classes for use in other modules
export { FormToggle, AutoCalculator, FormValidationEnhancer };

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize auto-calculator
    new AutoCalculator();

    // Initialize form toggles
    document.querySelectorAll('.form-toggle-container').forEach(container => {
        new FormToggle(container);
    });

    // Initialize form validation enhancers
    document.querySelectorAll('form[data-enhanced-validation]').forEach(form => {
        new FormValidationEnhancer(form);
    });
});