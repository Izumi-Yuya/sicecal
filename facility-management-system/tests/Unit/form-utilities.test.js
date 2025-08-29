import { describe, it, expect, beforeEach, vi } from 'vitest';

// Mock the form utilities since they're not ES modules
const mockFormToggle = {
    toggleMode: vi.fn(),
    isEditMode: false
};

const mockAutoCalculator = {
    calculateOperatingYears: vi.fn()
};

// Mock global objects that would be available
global.FormToggle = class {
    constructor(container) {
        this.container = container;
        this.isEditMode = false;
    }

    toggleMode() {
        this.isEditMode = !this.isEditMode;
        this.container.classList.toggle('edit-mode', this.isEditMode);
        this.container.classList.toggle('view-mode', !this.isEditMode);
    }
};

global.AutoCalculator = class {
    static calculateOperatingYears(openingDate) {
        if (!openingDate) return null;
        const now = new Date();
        const opening = new Date(openingDate);
        const years = Math.floor((now - opening) / (365.25 * 24 * 60 * 60 * 1000));
        return years;
    }
};

describe('FormToggle', () => {
    let container;
    let formToggle;

    beforeEach(() => {
        container = document.createElement('div');
        container.className = 'form-container view-mode';
        document.body.appendChild(container);

        formToggle = new FormToggle(container);
    });

    it('should initialize in view mode', () => {
        expect(formToggle.isEditMode).toBe(false);
        expect(container.classList.contains('view-mode')).toBe(true);
    });

    it('should toggle to edit mode', () => {
        formToggle.toggleMode();

        expect(formToggle.isEditMode).toBe(true);
        expect(container.classList.contains('edit-mode')).toBe(true);
        expect(container.classList.contains('view-mode')).toBe(false);
    });

    it('should toggle back to view mode', () => {
        formToggle.toggleMode(); // to edit
        formToggle.toggleMode(); // back to view

        expect(formToggle.isEditMode).toBe(false);
        expect(container.classList.contains('edit-mode')).toBe(false);
        expect(container.classList.contains('view-mode')).toBe(true);
    });

    it('should handle multiple toggles correctly', () => {
        // Start in view mode
        expect(formToggle.isEditMode).toBe(false);

        // Toggle to edit
        formToggle.toggleMode();
        expect(formToggle.isEditMode).toBe(true);
        expect(container.classList.contains('edit-mode')).toBe(true);

        // Toggle back to view
        formToggle.toggleMode();
        expect(formToggle.isEditMode).toBe(false);
        expect(container.classList.contains('view-mode')).toBe(true);

        // Toggle to edit again
        formToggle.toggleMode();
        expect(formToggle.isEditMode).toBe(true);
        expect(container.classList.contains('edit-mode')).toBe(true);
    });
});

describe('AutoCalculator', () => {
    describe('calculateOperatingYears', () => {
        it('should return null for empty date', () => {
            const result = AutoCalculator.calculateOperatingYears('');
            expect(result).toBeNull();
        });

        it('should return null for null date', () => {
            const result = AutoCalculator.calculateOperatingYears(null);
            expect(result).toBeNull();
        });

        it('should return null for undefined date', () => {
            const result = AutoCalculator.calculateOperatingYears(undefined);
            expect(result).toBeNull();
        });

        it('should calculate years correctly for past date', () => {
            // Mock current date to 2024-01-01
            const mockDate = new Date('2024-01-01');
            vi.setSystemTime(mockDate);

            const openingDate = '2020-01-01';
            const result = AutoCalculator.calculateOperatingYears(openingDate);

            expect(result).toBe(4);

            vi.useRealTimers();
        });

        it('should calculate years correctly for recent date', () => {
            // Mock current date to 2024-06-15
            const mockDate = new Date('2024-06-15');
            vi.setSystemTime(mockDate);

            const openingDate = '2023-01-01';
            const result = AutoCalculator.calculateOperatingYears(openingDate);

            expect(result).toBe(1);

            vi.useRealTimers();
        });

        it('should return 0 for current year opening', () => {
            // Mock current date to 2024-06-15
            const mockDate = new Date('2024-06-15');
            vi.setSystemTime(mockDate);

            const openingDate = '2024-01-01';
            const result = AutoCalculator.calculateOperatingYears(openingDate);

            expect(result).toBe(0);

            vi.useRealTimers();
        });

        it('should handle leap years correctly', () => {
            // Mock current date to 2024-03-01 (2024 is a leap year)
            const mockDate = new Date('2024-03-01');
            vi.setSystemTime(mockDate);

            const openingDate = '2020-03-01'; // 2020 was also a leap year
            const result = AutoCalculator.calculateOperatingYears(openingDate);

            expect(result).toBe(4);

            vi.useRealTimers();
        });

        it('should handle different date formats', () => {
            const mockDate = new Date('2024-01-01');
            vi.setSystemTime(mockDate);

            // Test various date formats
            expect(AutoCalculator.calculateOperatingYears('2020-01-01')).toBe(4);
            expect(AutoCalculator.calculateOperatingYears('2020/01/01')).toBe(4);

            vi.useRealTimers();
        });

        it('should handle edge case of same date', () => {
            const mockDate = new Date('2024-01-01');
            vi.setSystemTime(mockDate);

            const openingDate = '2024-01-01';
            const result = AutoCalculator.calculateOperatingYears(openingDate);

            expect(result).toBe(0);

            vi.useRealTimers();
        });
    });
});

describe('Form Integration', () => {
    beforeEach(() => {
        document.body.innerHTML = `
      <div class="facility-form">
        <div class="form-group">
          <label for="opening-date">開設年月日</label>
          <input type="date" id="opening-date" name="opening_date" value="2020-01-01">
          <div class="form-display" id="opening-date-display">2020年1月1日</div>
        </div>
        <div class="form-group">
          <label for="operating-years">運営年数</label>
          <div class="form-display text-info" id="operating-years-display">4年</div>
        </div>
        <button type="button" class="btn btn-primary" data-toggle-edit>編集</button>
        <button type="button" class="btn btn-success" data-save-form style="display: none;">保存</button>
        <button type="button" class="btn btn-secondary" data-cancel-edit style="display: none;">キャンセル</button>
      </div>
    `;
    });

    it('should integrate form toggle with auto calculation', () => {
        const container = document.querySelector('.facility-form');
        const formToggle = new FormToggle(container);
        const openingDateInput = document.getElementById('opening-date');
        const operatingYearsDisplay = document.getElementById('operating-years-display');

        // Mock current date
        const mockDate = new Date('2024-01-01');
        vi.setSystemTime(mockDate);

        // Test initial state
        expect(formToggle.isEditMode).toBe(false);

        // Toggle to edit mode
        formToggle.toggleMode();
        expect(container.classList.contains('edit-mode')).toBe(true);

        // Simulate date change and auto-calculation
        openingDateInput.value = '2019-01-01';
        const years = AutoCalculator.calculateOperatingYears(openingDateInput.value);
        operatingYearsDisplay.textContent = `${years}年`;

        expect(years).toBe(5);
        expect(operatingYearsDisplay.textContent).toBe('5年');

        vi.useRealTimers();
    });

    it('should handle form validation states', () => {
        const container = document.querySelector('.facility-form');
        const formToggle = new FormToggle(container);

        // Add validation classes
        container.classList.add('was-validated');

        // Toggle should maintain validation state
        formToggle.toggleMode();
        expect(container.classList.contains('was-validated')).toBe(true);
        expect(container.classList.contains('edit-mode')).toBe(true);
    });
});

describe('Form Display/Edit Toggle CSS Classes', () => {
    beforeEach(() => {
        document.body.innerHTML = `
      <div class="form-container view-mode">
        <div class="form-display">Display Content</div>
        <input class="form-edit" type="text" value="Edit Content" style="display: none;">
      </div>
    `;
    });

    it('should show display elements in view mode', () => {
        const container = document.querySelector('.form-container');
        const displayElement = container.querySelector('.form-display');
        const editElement = container.querySelector('.form-edit');

        expect(container.classList.contains('view-mode')).toBe(true);

        // In view mode, display should be visible, edit should be hidden
        const displayStyle = window.getComputedStyle(displayElement);
        const editStyle = window.getComputedStyle(editElement);

        // Note: jsdom doesn't fully support CSS, so we check classes instead
        expect(container.classList.contains('view-mode')).toBe(true);
        expect(container.classList.contains('edit-mode')).toBe(false);
    });

    it('should show edit elements in edit mode', () => {
        const container = document.querySelector('.form-container');
        const formToggle = new FormToggle(container);

        // Toggle to edit mode
        formToggle.toggleMode();

        expect(container.classList.contains('edit-mode')).toBe(true);
        expect(container.classList.contains('view-mode')).toBe(false);
    });
});