/**
 * Form Interaction Utilities
 * Enhanced form interaction system for the UI Design System
 * 
 * Provides:
 * - FormToggle class for display/edit mode switching
 * - AutoCalculator utility for real-time field calculations
 * - Form validation enhancement utilities
 * - Smooth transition utilities for form state changes
 */

/**
 * Enhanced FormToggle Class
 * Manages switching between display and edit modes with smooth transitions
 */
class FormToggle {
    constructor(container, options = {}) {
        this.container = typeof container === 'string' ? document.querySelector(container) : container;
        this.options = {
            editButtonSelector: '.form-toggle-btn',
            displaySelector: '.form-display',
            editSelector: '.form-edit',
            animationDuration: 300,
            enableTransitions: true,
            autoSave: false,
            confirmCancel: false,
            ...options
        };

        this.isEditMode = false;
        this.originalValues = new Map();
        this.transitionElements = [];

        this.init();
    }

    init() {
        if (!this.container) {
            console.warn('FormToggle: Container not found');
            return;
        }

        // Add initial classes and setup
        this.container.classList.add('form-toggle-container', 'view-mode');
        this.setupTransitionElements();
        this.createToggleButton();
        this.bindEvents();
        this.updateDisplay();
    }

    setupTransitionElements() {
        // Find all display and edit elements for smooth transitions
        const displayElements = this.container.querySelectorAll(this.options.displaySelector);
        const editElements = this.container.querySelectorAll(this.options.editSelector);

        displayElements.forEach((display, index) => {
            const edit = editElements[index];
            if (edit) {
                this.transitionElements.push({ display, edit });
            }
        });
    }

    createToggleButton() {
        this.toggleButton = this.container.querySelector(this.options.editButtonSelector);

        if (!this.toggleButton) {
            this.toggleButton = document.createElement('button');
            this.toggleButton.className = 'btn btn-outline-primary btn-sm form-toggle-btn';
            this.toggleButton.type = 'button';
            this.toggleButton.innerHTML = '<i class="bi bi-pencil me-1"></i>編集';
            this.toggleButton.setAttribute('aria-label', '編集モードに切り替え');

            // Insert button at the beginning of container
            this.container.insertBefore(this.toggleButton, this.container.firstChild);
        }

        // Create save and cancel buttons
        this.saveButton = document.createElement('button');
        this.saveButton.className = 'btn btn-primary btn-sm form-save-btn me-2';
        this.saveButton.type = 'button';
        this.saveButton.innerHTML = '<i class="bi bi-check me-1"></i>保存';
        this.saveButton.style.display = 'none';

        this.cancelButton = document.createElement('button');
        this.cancelButton.className = 'btn btn-outline-secondary btn-sm form-cancel-btn';
        this.cancelButton.type = 'button';
        this.cancelButton.innerHTML = '<i class="bi bi-x me-1"></i>キャンセル';
        this.cancelButton.style.display = 'none';

        // Insert buttons after toggle button
        this.toggleButton.parentNode.insertBefore(this.saveButton, this.toggleButton.nextSibling);
        this.toggleButton.parentNode.insertBefore(this.cancelButton, this.saveButton.nextSibling);
    }

    bindEvents() {
        // Toggle button
        this.toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            this.setEditMode();
        });

        // Save button
        this.saveButton.addEventListener('click', (e) => {
            e.preventDefault();
            this.save();
        });

        // Cancel button
        this.cancelButton.addEventListener('click', (e) => {
            e.preventDefault();
            this.cancel();
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (!this.isEditMode) return;

            // Escape to cancel
            if (e.key === 'Escape') {
                e.preventDefault();
                this.cancel();
            }

            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                this.save();
            }
        });

        // Auto-save on form submission
        const form = this.container.closest('form');
        if (form && this.options.autoSave) {
            form.addEventListener('submit', () => {
                if (this.isEditMode) {
                    this.save();
                }
            });
        }
    }

    setEditMode() {
        if (this.isEditMode) return;

        // Store original values
        this.storeOriginalValues();

        this.isEditMode = true;
        this.container.classList.remove('view-mode');
        this.container.classList.add('edit-mode');

        // Update buttons
        this.toggleButton.style.display = 'none';
        this.saveButton.style.display = 'inline-block';
        this.cancelButton.style.display = 'inline-block';

        // Apply transitions if enabled
        if (this.options.enableTransitions) {
            this.animateToEditMode();
        }

        // Focus first input
        setTimeout(() => {
            const firstInput = this.container.querySelector(`${this.options.editSelector} input:not([readonly]), ${this.options.editSelector} select, ${this.options.editSelector} textarea`);
            if (firstInput) {
                firstInput.focus();
            }
        }, this.options.animationDuration);

        // Dispatch event
        this.dispatchEvent('editMode');
    }

    setViewMode() {
        if (!this.isEditMode) return;

        this.isEditMode = false;
        this.container.classList.remove('edit-mode');
        this.container.classList.add('view-mode');

        // Update buttons
        this.toggleButton.style.display = 'inline-block';
        this.saveButton.style.display = 'none';
        this.cancelButton.style.display = 'none';

        // Apply transitions if enabled
        if (this.options.enableTransitions) {
            this.animateToViewMode();
        }

        // Update display values
        this.updateDisplay();

        // Dispatch event
        this.dispatchEvent('viewMode');
    }

    save() {
        // Validate form if validation is available
        if (this.validateForm && !this.validateForm()) {
            return false;
        }

        // Update display from edit values
        this.updateDisplayFromEdit();

        // Clear stored values
        this.originalValues.clear();

        // Exit edit mode
        this.setViewMode();

        // Dispatch save event
        this.dispatchEvent('save', { values: this.getValue() });

        return true;
    }

    cancel() {
        if (this.options.confirmCancel && this.hasChanges()) {
            if (!confirm('変更内容が失われますが、よろしいですか？')) {
                return false;
            }
        }

        // Restore original values
        this.restoreOriginalValues();

        // Exit edit mode
        this.setViewMode();

        // Dispatch cancel event
        this.dispatchEvent('cancel');

        return true;
    }

    animateToEditMode() {
        this.transitionElements.forEach(({ display, edit }) => {
            // Fade out display, fade in edit
            display.style.transition = `opacity ${this.options.animationDuration}ms ease`;
            edit.style.transition = `opacity ${this.options.animationDuration}ms ease`;

            display.style.opacity = '0';
            setTimeout(() => {
                display.style.display = 'none';
                edit.style.display = 'block';
                edit.style.opacity = '0';

                requestAnimationFrame(() => {
                    edit.style.opacity = '1';
                });
            }, this.options.animationDuration / 2);
        });
    }

    animateToViewMode() {
        this.transitionElements.forEach(({ display, edit }) => {
            // Fade out edit, fade in display
            edit.style.opacity = '0';

            setTimeout(() => {
                edit.style.display = 'none';
                display.style.display = 'block';
                display.style.opacity = '0';

                requestAnimationFrame(() => {
                    display.style.opacity = '1';
                });
            }, this.options.animationDuration / 2);
        });
    }

    storeOriginalValues() {
        const editElements = this.container.querySelectorAll(`${this.options.editSelector} input, ${this.options.editSelector} select, ${this.options.editSelector} textarea`);

        editElements.forEach(element => {
            if (element.name) {
                this.originalValues.set(element.name, element.value);
            }
        });
    }

    restoreOriginalValues() {
        this.originalValues.forEach((value, name) => {
            const element = this.container.querySelector(`${this.options.editSelector} [name="${name}"]`);
            if (element) {
                element.value = value;
            }
        });
    }

    hasChanges() {
        const editElements = this.container.querySelectorAll(`${this.options.editSelector} input, ${this.options.editSelector} select, ${this.options.editSelector} textarea`);

        for (const element of editElements) {
            if (element.name && this.originalValues.has(element.name)) {
                if (element.value !== this.originalValues.get(element.name)) {
                    return true;
                }
            }
        }

        return false;
    }

    updateDisplay() {
        const displayElements = this.container.querySelectorAll(this.options.displaySelector);
        const editElements = this.container.querySelectorAll(`${this.options.editSelector} input, ${this.options.editSelector} select, ${this.options.editSelector} textarea`);

        editElements.forEach((editElement, index) => {
            const displayElement = displayElements[index];
            if (displayElement) {
                const formattedValue = this.formatDisplayValue(editElement.value, editElement);

                if (formattedValue) {
                    displayElement.textContent = formattedValue;
                    displayElement.classList.remove('empty');
                } else {
                    displayElement.textContent = '';
                    displayElement.classList.add('empty');
                }
            }
        });
    }

    updateDisplayFromEdit() {
        this.updateDisplay();
    }

    formatDisplayValue(value, element) {
        if (!value) return '';

        const type = element.type;
        const format = element.dataset.format;

        switch (type) {
            case 'date':
                return new Date(value).toLocaleDateString('ja-JP', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            case 'number':
                if (format === 'currency') {
                    return `¥${Number(value).toLocaleString('ja-JP')}`;
                } else if (format === 'area') {
                    return `${Number(value).toLocaleString('ja-JP')}㎡`;
                }
                return Number(value).toLocaleString('ja-JP');
            case 'tel':
                return this.formatPhoneNumber(value);
            case 'email':
                return value;
            default:
                if (element.tagName === 'SELECT') {
                    const option = element.querySelector(`option[value="${value}"]`);
                    return option ? option.textContent : value;
                }
                return value;
        }
    }

    formatPhoneNumber(phone) {
        const cleaned = phone.replace(/\D/g, '');

        if (cleaned.length === 10) {
            return cleaned.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
        } else if (cleaned.length === 11) {
            return cleaned.replace(/(\d{3})(\d{4})(\d{4})/, '$1-$2-$3');
        }

        return phone;
    }

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

    dispatchEvent(eventName, detail = {}) {
        this.container.dispatchEvent(new CustomEvent(`formToggle:${eventName}`, {
            detail: { container: this.container, ...detail }
        }));
    }

    destroy() {
        // Remove event listeners and clean up
        if (this.toggleButton && this.toggleButton.parentNode) {
            this.toggleButton.parentNode.removeChild(this.toggleButton);
        }
        if (this.saveButton && this.saveButton.parentNode) {
            this.saveButton.parentNode.removeChild(this.saveButton);
        }
        if (this.cancelButton && this.cancelButton.parentNode) {
            this.cancelButton.parentNode.removeChild(this.cancelButton);
        }

        this.container.classList.remove('form-toggle-container', 'view-mode', 'edit-mode');
    }
}

/**
 * Enhanced AutoCalculator Class
 * Handles automatic calculations with improved performance and features
 */
class AutoCalculator {
    constructor(options = {}) {
        this.options = {
            debounceDelay: 300,
            enableAnimations: true,
            showCalculationIndicator: true,
            ...options
        };

        this.calculators = new Map();
        this.debounceTimers = new Map();

        this.init();
    }

    init() {
        // Initialize auto-calculated fields
        document.querySelectorAll('[data-auto-calculate]').forEach(field => {
            this.initializeField(field);
        });

        // Initialize legacy auto-calculated fields
        document.querySelectorAll('.auto-calculated-field').forEach(field => {
            this.initializeField(field);
        });
    }

    initializeField(field) {
        const calculationType = field.dataset.autoCalculate || field.dataset.calculation;
        const dependsOn = field.dataset.dependsOn;

        if (!calculationType || !dependsOn) {
            console.warn('AutoCalculator: Missing calculation type or dependencies', field);
            return;
        }

        const targetElement = field.querySelector('input, .form-display, [data-calculated-value]');
        if (!targetElement) {
            console.warn('AutoCalculator: No target element found', field);
            return;
        }

        const dependencies = this.findDependencies(dependsOn);
        if (dependencies.length === 0) {
            console.warn('AutoCalculator: No valid dependencies found', field);
            return;
        }

        // Store calculator configuration
        this.calculators.set(field, {
            type: calculationType,
            target: targetElement,
            dependencies: dependencies,
            field: field
        });

        // Bind events to dependencies
        this.bindDependencyEvents(field);

        // Initial calculation
        this.calculate(field);
    }

    findDependencies(dependsOnString) {
        const dependencies = [];
        const selectors = dependsOnString.split(',');

        selectors.forEach(selector => {
            const trimmedSelector = selector.trim();
            const elements = document.querySelectorAll(trimmedSelector);

            elements.forEach(element => {
                // Find the actual input element if selector points to a container
                const input = element.matches('input, select, textarea')
                    ? element
                    : element.querySelector('input, select, textarea');

                if (input) {
                    dependencies.push(input);
                }
            });
        });

        return dependencies;
    }

    bindDependencyEvents(field) {
        const calculator = this.calculators.get(field);

        calculator.dependencies.forEach(dependency => {
            // Immediate calculation on change
            dependency.addEventListener('change', () => {
                this.calculate(field);
            });

            // Debounced calculation on input
            dependency.addEventListener('input', () => {
                this.debouncedCalculate(field);
            });
        });
    }

    debouncedCalculate(field) {
        const timerId = this.debounceTimers.get(field);
        if (timerId) {
            clearTimeout(timerId);
        }

        const newTimerId = setTimeout(() => {
            this.calculate(field);
            this.debounceTimers.delete(field);
        }, this.options.debounceDelay);

        this.debounceTimers.set(field, newTimerId);
    }

    calculate(field) {
        const calculator = this.calculators.get(field);
        if (!calculator) return;

        // Show calculation indicator
        if (this.options.showCalculationIndicator) {
            this.showCalculationIndicator(field);
        }

        try {
            const result = this.performCalculation(calculator);
            this.updateTarget(calculator.target, result, calculator.type);

            // Hide calculation indicator
            this.hideCalculationIndicator(field);

            // Dispatch success event
            field.dispatchEvent(new CustomEvent('autoCalculation:success', {
                detail: {
                    result,
                    type: calculator.type,
                    dependencies: calculator.dependencies.map(dep => ({ name: dep.name, value: dep.value }))
                }
            }));

        } catch (error) {
            console.error('AutoCalculator error:', error);
            this.showCalculationError(field);

            // Dispatch error event
            field.dispatchEvent(new CustomEvent('autoCalculation:error', {
                detail: { error, type: calculator.type }
            }));
        }
    }

    performCalculation(calculator) {
        const { type, dependencies } = calculator;

        switch (type) {
            case 'operating-years':
                return this.calculateOperatingYears(dependencies[0]);

            case 'building-age':
                return this.calculateBuildingAge(dependencies[0]);

            case 'area-total':
                return this.calculateAreaTotal(dependencies);

            case 'land-unit-price':
                return this.calculateLandUnitPrice(dependencies[0], dependencies[1]);

            case 'building-unit-price':
                return this.calculateBuildingUnitPrice(dependencies[0], dependencies[1]);

            case 'total-price':
                return this.calculateTotalPrice(dependencies);

            case 'monthly-rent-per-tsubo':
                return this.calculateMonthlyRentPerTsubo(dependencies[0], dependencies[1]);

            case 'annual-rent':
                return this.calculateAnnualRent(dependencies[0]);

            default:
                throw new Error(`Unknown calculation type: ${type}`);
        }
    }

    calculateOperatingYears(dateInput) {
        const openingDate = new Date(dateInput.value);
        if (isNaN(openingDate.getTime())) return '';

        const now = new Date();
        const diffTime = now - openingDate;
        const diffYears = Math.floor(diffTime / (365.25 * 24 * 60 * 60 * 1000));

        return diffYears >= 0 ? `${diffYears}年` : '';
    }

    calculateBuildingAge(dateInput) {
        const completionDate = new Date(dateInput.value);
        if (isNaN(completionDate.getTime())) return '';

        const now = new Date();
        const diffTime = now - completionDate;
        const diffYears = Math.floor(diffTime / (365.25 * 24 * 60 * 60 * 1000));

        return diffYears >= 0 ? `${diffYears}年` : '';
    }

    calculateAreaTotal(areaInputs) {
        let total = 0;
        let hasValues = false;

        areaInputs.forEach(input => {
            const value = parseFloat(input.value);
            if (!isNaN(value) && value > 0) {
                total += value;
                hasValues = true;
            }
        });

        return hasValues ? `${total.toLocaleString('ja-JP')}㎡` : '';
    }

    calculateLandUnitPrice(priceInput, areaInput) {
        const price = parseFloat(priceInput.value);
        const area = parseFloat(areaInput.value);

        if (isNaN(price) || isNaN(area) || area === 0) return '';

        const unitPrice = Math.round(price / area);
        return `¥${unitPrice.toLocaleString('ja-JP')}/坪`;
    }

    calculateBuildingUnitPrice(priceInput, areaInput) {
        const price = parseFloat(priceInput.value);
        const area = parseFloat(areaInput.value);

        if (isNaN(price) || isNaN(area) || area === 0) return '';

        const unitPrice = Math.round(price / area);
        return `¥${unitPrice.toLocaleString('ja-JP')}/坪`;
    }

    calculateTotalPrice(priceInputs) {
        let total = 0;
        let hasValues = false;

        priceInputs.forEach(input => {
            const value = parseFloat(input.value);
            if (!isNaN(value) && value > 0) {
                total += value;
                hasValues = true;
            }
        });

        return hasValues ? `¥${total.toLocaleString('ja-JP')}` : '';
    }

    calculateMonthlyRentPerTsubo(rentInput, areaInput) {
        const rent = parseFloat(rentInput.value);
        const area = parseFloat(areaInput.value);

        if (isNaN(rent) || isNaN(area) || area === 0) return '';

        const rentPerTsubo = Math.round(rent / area);
        return `¥${rentPerTsubo.toLocaleString('ja-JP')}/坪`;
    }

    calculateAnnualRent(monthlyRentInput) {
        const monthlyRent = parseFloat(monthlyRentInput.value);

        if (isNaN(monthlyRent)) return '';

        const annualRent = monthlyRent * 12;
        return `¥${annualRent.toLocaleString('ja-JP')}`;
    }

    updateTarget(target, result, calculationType) {
        if (target.tagName === 'INPUT') {
            target.value = result;
        } else {
            target.textContent = result;
        }

        // Add visual feedback
        if (this.options.enableAnimations && result) {
            target.classList.add('calculation-updated');
            setTimeout(() => {
                target.classList.remove('calculation-updated');
            }, 1000);
        }
    }

    showCalculationIndicator(field) {
        field.classList.add('calculating');

        // Add spinner if not exists
        let spinner = field.querySelector('.calculation-spinner');
        if (!spinner) {
            spinner = document.createElement('div');
            spinner.className = 'calculation-spinner';
            spinner.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i>';
            field.appendChild(spinner);
        }
    }

    hideCalculationIndicator(field) {
        field.classList.remove('calculating', 'calculation-error');

        const spinner = field.querySelector('.calculation-spinner');
        if (spinner) {
            spinner.remove();
        }
    }

    showCalculationError(field) {
        field.classList.remove('calculating');
        field.classList.add('calculation-error');

        const spinner = field.querySelector('.calculation-spinner');
        if (spinner) {
            spinner.remove();
        }
    }

    // Static utility methods
    static formatCurrency(value, locale = 'ja-JP') {
        return new Intl.NumberFormat(locale, {
            style: 'currency',
            currency: 'JPY',
            minimumFractionDigits: 0
        }).format(value);
    }

    static formatNumber(value, locale = 'ja-JP') {
        return new Intl.NumberFormat(locale).format(value);
    }

    static formatDate(date, locale = 'ja-JP') {
        return new Date(date).toLocaleDateString(locale, {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
}

/**
 * Enhanced FormValidationEnhancer Class
 * Provides advanced form validation with better UX
 */
class FormValidationEnhancer {
    constructor(form, options = {}) {
        this.form = typeof form === 'string' ? document.querySelector(form) : form;
        this.options = {
            showValidationOnBlur: true,
            showValidationOnInput: false,
            clearValidationOnFocus: true,
            enableRealTimeValidation: true,
            customValidators: {},
            ...options
        };

        this.validators = new Map();
        this.init();
    }

    init() {
        if (!this.form) {
            console.warn('FormValidationEnhancer: Form not found');
            return;
        }

        this.setupCustomValidators();
        this.bindEvents();
        this.enhanceFields();
    }

    setupCustomValidators() {
        // Japanese postal code validator
        this.validators.set('postal-code', (value) => {
            const pattern = /^\d{3}-\d{4}$/;
            return pattern.test(value) || ' 郵便番号は000-0000の形式で入力してください';
        });

        // Japanese phone number validator
        this.validators.set('phone', (value) => {
            const pattern = /^0\d{1,4}-\d{1,4}-\d{3,4}$/;
            return pattern.test(value) || '電話番号の形式が正しくありません';
        });

        // Email validator with Japanese message
        this.validators.set('email', (value) => {
            const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return pattern.test(value) || 'メールアドレスの形式が正しくありません';
        });

        // Date range validator
        this.validators.set('date-range', (value, field) => {
            const minDate = field.getAttribute('min');
            const maxDate = field.getAttribute('max');
            const inputDate = new Date(value);

            if (minDate && inputDate < new Date(minDate)) {
                return `日付は${new Date(minDate).toLocaleDateString('ja-JP')}以降を選択してください`;
            }
            if (maxDate && inputDate > new Date(maxDate)) {
                return `日付は${new Date(maxDate).toLocaleDateString('ja-JP')}以前を選択してください`;
            }
            return true;
        });

        // Add custom validators from options
        Object.keys(this.options.customValidators).forEach(name => {
            this.validators.set(name, this.options.customValidators[name]);
        });
    }

    bindEvents() {
        // Form submission
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
                this.focusFirstError();
            }
        });

        // Field validation events
        const fields = this.form.querySelectorAll('input, select, textarea');
        fields.forEach(field => {
            if (this.options.showValidationOnBlur) {
                field.addEventListener('blur', () => this.validateField(field));
            }

            if (this.options.showValidationOnInput) {
                field.addEventListener('input', () => this.debounceValidation(field));
            }

            if (this.options.clearValidationOnFocus) {
                field.addEventListener('focus', () => this.clearFieldValidation(field));
            }
        });
    }

    enhanceFields() {
        // Add input formatting for specific field types
        this.form.querySelectorAll('input[data-format]').forEach(field => {
            const format = field.dataset.format;

            switch (format) {
                case 'postal-code':
                    this.addPostalCodeFormatting(field);
                    break;
                case 'phone':
                    this.addPhoneFormatting(field);
                    break;
                case 'currency':
                    this.addCurrencyFormatting(field);
                    break;
            }
        });
    }

    addPostalCodeFormatting(field) {
        field.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 3) {
                value = value.substring(0, 3) + '-' + value.substring(3, 7);
            }
            e.target.value = value;
        });
    }

    addPhoneFormatting(field) {
        field.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');

            if (value.length >= 6) {
                if (value.startsWith('0120') || value.startsWith('0800')) {
                    // Free dial format
                    value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7, 10);
                } else if (value.length >= 10) {
                    // Regular phone format
                    value = value.substring(0, 3) + '-' + value.substring(3, 7) + '-' + value.substring(7, 11);
                }
            }

            e.target.value = value;
        });
    }

    addCurrencyFormatting(field) {
        field.addEventListener('blur', (e) => {
            const value = parseFloat(e.target.value.replace(/[^\d.-]/g, ''));
            if (!isNaN(value)) {
                e.target.value = value.toLocaleString('ja-JP');
            }
        });

        field.addEventListener('focus', (e) => {
            const value = e.target.value.replace(/[^\d.-]/g, '');
            e.target.value = value;
        });
    }

    debounceValidation(field) {
        clearTimeout(field.validationTimer);
        field.validationTimer = setTimeout(() => {
            this.validateField(field);
        }, 500);
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
        // Skip validation for disabled or readonly fields
        if (field.disabled || field.readOnly) return true;

        let isValid = true;
        let errorMessage = '';

        // HTML5 validation first
        if (!field.checkValidity()) {
            isValid = false;
            errorMessage = field.validationMessage;
        }

        // Custom validation
        if (isValid && field.dataset.validate) {
            const validatorName = field.dataset.validate;
            const validator = this.validators.get(validatorName);

            if (validator) {
                const result = validator(field.value, field);
                if (result !== true) {
                    isValid = false;
                    errorMessage = result;
                }
            }
        }

        // Update field state
        if (isValid) {
            this.showFieldSuccess(field);
        } else {
            this.showFieldError(field, errorMessage);
        }

        return isValid;
    }

    showFieldError(field, message) {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');

        this.updateFeedback(field, message, 'invalid-feedback');

        // Add error styling to parent form group
        const formGroup = field.closest('.form-group, .mb-3');
        if (formGroup) {
            formGroup.classList.add('has-error');
        }
    }

    showFieldSuccess(field) {
        field.classList.add('is-valid');
        field.classList.remove('is-invalid');

        this.updateFeedback(field, '', 'valid-feedback');

        // Remove error styling from parent form group
        const formGroup = field.closest('.form-group, .mb-3');
        if (formGroup) {
            formGroup.classList.remove('has-error');
        }
    }

    clearFieldValidation(field) {
        field.classList.remove('is-valid', 'is-invalid');
        this.updateFeedback(field, '', 'invalid-feedback');
        this.updateFeedback(field, '', 'valid-feedback');

        const formGroup = field.closest('.form-group, .mb-3');
        if (formGroup) {
            formGroup.classList.remove('has-error');
        }
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
            firstError.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    }
}

/**
 * SmoothTransition Utility Class
 * Provides smooth transitions for form state changes
 */
class SmoothTransition {
    static fadeIn(element, duration = 300) {
        return new Promise(resolve => {
            element.style.opacity = '0';
            element.style.display = 'block';

            requestAnimationFrame(() => {
                element.style.transition = `opacity ${duration}ms ease`;
                element.style.opacity = '1';

                setTimeout(resolve, duration);
            });
        });
    }

    static fadeOut(element, duration = 300) {
        return new Promise(resolve => {
            element.style.transition = `opacity ${duration}ms ease`;
            element.style.opacity = '0';

            setTimeout(() => {
                element.style.display = 'none';
                resolve();
            }, duration);
        });
    }

    static slideDown(element, duration = 300) {
        return new Promise(resolve => {
            element.style.height = '0';
            element.style.overflow = 'hidden';
            element.style.display = 'block';

            const targetHeight = element.scrollHeight + 'px';

            requestAnimationFrame(() => {
                element.style.transition = `height ${duration}ms ease`;
                element.style.height = targetHeight;

                setTimeout(() => {
                    element.style.height = '';
                    element.style.overflow = '';
                    resolve();
                }, duration);
            });
        });
    }

    static slideUp(element, duration = 300) {
        return new Promise(resolve => {
            element.style.height = element.scrollHeight + 'px';
            element.style.overflow = 'hidden';

            requestAnimationFrame(() => {
                element.style.transition = `height ${duration}ms ease`;
                element.style.height = '0';

                setTimeout(() => {
                    element.style.display = 'none';
                    element.style.height = '';
                    element.style.overflow = '';
                    resolve();
                }, duration);
            });
        });
    }
}

// Export classes
export { FormToggle, AutoCalculator, FormValidationEnhancer, SmoothTransition };

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize auto-calculator
    new AutoCalculator();

    // Initialize form toggles
    document.querySelectorAll('[data-form-toggle]').forEach(container => {
        new FormToggle(container);
    });

    // Initialize form validation enhancers
    document.querySelectorAll('form[data-enhanced-validation]').forEach(form => {
        new FormValidationEnhancer(form);
    });
});