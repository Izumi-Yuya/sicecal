import { describe, it, expect, beforeEach, vi } from 'vitest';
import { AccessibilityManager, FormAccessibility, ComponentAccessibility } from '@/accessibility-utils';

describe('AccessibilityManager', () => {
    let accessibilityManager;

    beforeEach(() => {
        accessibilityManager = new AccessibilityManager();
    });

    describe('ARIA Live Regions', () => {
        it('should create polite live region', () => {
            const liveRegion = document.getElementById('aria-live-polite');
            expect(liveRegion).toBeTruthy();
            expect(liveRegion.getAttribute('aria-live')).toBe('polite');
            expect(liveRegion.getAttribute('aria-atomic')).toBe('true');
            expect(liveRegion.classList.contains('sr-only')).toBe(true);
        });

        it('should create assertive live region', () => {
            const liveRegion = document.getElementById('aria-live-assertive');
            expect(liveRegion).toBeTruthy();
            expect(liveRegion.getAttribute('aria-live')).toBe('assertive');
            expect(liveRegion.getAttribute('aria-atomic')).toBe('true');
            expect(liveRegion.classList.contains('sr-only')).toBe(true);
        });
    });

    describe('announce method', () => {
        it('should announce message to polite live region by default', () => {
            const message = 'Test announcement';
            accessibilityManager.announce(message);

            const liveRegion = document.getElementById('aria-live-polite');
            expect(liveRegion.textContent).toBe(message);
        });

        it('should announce message to assertive live region when specified', () => {
            const message = 'Urgent announcement';
            accessibilityManager.announce(message, 'assertive');

            const liveRegion = document.getElementById('aria-live-assertive');
            expect(liveRegion.textContent).toBe(message);
        });

        it('should clear message after timeout', async () => {
            vi.useFakeTimers();

            const message = 'Test message';
            accessibilityManager.announce(message);

            const liveRegion = document.getElementById('aria-live-polite');
            expect(liveRegion.textContent).toBe(message);

            vi.advanceTimersByTime(1000);
            expect(liveRegion.textContent).toBe('');

            vi.useRealTimers();
        });
    });

    describe('keyboard navigation', () => {
        it('should handle tab navigation with arrow keys', () => {
            // Setup tabs
            document.body.innerHTML = `
        <div class="nav-tabs">
          <a class="nav-link" role="tab" href="#tab1">Tab 1</a>
          <a class="nav-link" role="tab" href="#tab2">Tab 2</a>
          <a class="nav-link" role="tab" href="#tab3">Tab 3</a>
        </div>
      `;

            const tabs = document.querySelectorAll('.nav-link[role="tab"]');
            const firstTab = tabs[0];
            const secondTab = tabs[1];

            // Mock focus and click methods
            firstTab.focus = vi.fn();
            firstTab.click = vi.fn();
            secondTab.focus = vi.fn();
            secondTab.click = vi.fn();

            // Simulate ArrowRight key on first tab
            const event = new KeyboardEvent('keydown', { key: 'ArrowRight' });
            Object.defineProperty(event, 'target', { value: firstTab });

            accessibilityManager.handleTabNavigation(event);

            expect(secondTab.focus).toHaveBeenCalled();
            expect(secondTab.click).toHaveBeenCalled();
        });

        it('should handle Home key to go to first tab', () => {
            document.body.innerHTML = `
        <div class="nav-tabs">
          <a class="nav-link" role="tab" href="#tab1">Tab 1</a>
          <a class="nav-link" role="tab" href="#tab2">Tab 2</a>
          <a class="nav-link" role="tab" href="#tab3">Tab 3</a>
        </div>
      `;

            const tabs = document.querySelectorAll('.nav-link[role="tab"]');
            const firstTab = tabs[0];
            const lastTab = tabs[2];

            firstTab.focus = vi.fn();
            firstTab.click = vi.fn();

            const event = new KeyboardEvent('keydown', { key: 'Home' });
            Object.defineProperty(event, 'target', { value: lastTab });

            accessibilityManager.handleTabNavigation(event);

            expect(firstTab.focus).toHaveBeenCalled();
            expect(firstTab.click).toHaveBeenCalled();
        });
    });

    describe('getFieldLabel method', () => {
        it('should get label from for attribute', () => {
            document.body.innerHTML = `
        <label for="test-field">Test Label</label>
        <input id="test-field" type="text">
      `;

            const field = document.getElementById('test-field');
            const label = accessibilityManager.getFieldLabel(field);

            expect(label).toBe('Test Label');
        });

        it('should get label from aria-labelledby', () => {
            document.body.innerHTML = `
        <div id="label-element">Custom Label</div>
        <input id="test-field" type="text" aria-labelledby="label-element">
      `;

            const field = document.getElementById('test-field');
            const label = accessibilityManager.getFieldLabel(field);

            expect(label).toBe('Custom Label');
        });

        it('should get label from aria-label', () => {
            document.body.innerHTML = `
        <input id="test-field" type="text" aria-label="ARIA Label">
      `;

            const field = document.getElementById('test-field');
            const label = accessibilityManager.getFieldLabel(field);

            expect(label).toBe('ARIA Label');
        });

        it('should fallback to placeholder', () => {
            document.body.innerHTML = `
        <input id="test-field" type="text" placeholder="Placeholder Text">
      `;

            const field = document.getElementById('test-field');
            const label = accessibilityManager.getFieldLabel(field);

            expect(label).toBe('Placeholder Text');
        });

        it('should fallback to default when no label found', () => {
            document.body.innerHTML = `
        <input id="test-field" type="text">
      `;

            const field = document.getElementById('test-field');
            const label = accessibilityManager.getFieldLabel(field);

            expect(label).toBe('フィールド');
        });
    });
});

describe('FormAccessibility', () => {
    let formAccessibility;

    beforeEach(() => {
        formAccessibility = new FormAccessibility();
    });

    describe('form validation enhancement', () => {
        it('should add validation ARIA attributes', () => {
            document.body.innerHTML = `
        <form>
          <input id="test-input" name="test" required>
          <div class="invalid-feedback">Error message</div>
        </form>
      `;

            const input = document.getElementById('test-input');
            formAccessibility.addValidationAria(input);

            const feedback = document.querySelector('.invalid-feedback');
            expect(feedback.id).toBe('test-input-feedback');
            expect(input.getAttribute('aria-describedby')).toBe('test-input-feedback');
            expect(input.getAttribute('aria-invalid')).toBe('true');
        });

        it('should add required field indicators', () => {
            document.body.innerHTML = `
        <label for="required-field">Field Label</label>
        <input id="required-field" type="text" required>
      `;

            formAccessibility.addRequiredFieldIndicators();

            const label = document.querySelector('label');
            const indicator = label.querySelector('.required-indicator');

            expect(indicator).toBeTruthy();
            expect(indicator.innerHTML).toContain('*');
            expect(indicator.innerHTML).toContain('aria-label="必須"');
        });
    });

    describe('field descriptions', () => {
        it('should add description for date inputs', () => {
            document.body.innerHTML = `
        <div>
          <input id="date-field" type="date">
        </div>
      `;

            formAccessibility.setupFieldDescriptions();

            const input = document.getElementById('date-field');
            const description = document.getElementById('date-field-desc');

            expect(description).toBeTruthy();
            expect(description.textContent).toContain('形式: YYYY-MM-DD');
            expect(input.getAttribute('aria-describedby')).toBe('date-field-desc');
        });

        it('should add description for number inputs with min/max', () => {
            document.body.innerHTML = `
        <div>
          <input id="number-field" type="number" min="1" max="100">
        </div>
      `;

            formAccessibility.setupFieldDescriptions();

            const input = document.getElementById('number-field');
            const description = document.getElementById('number-field-desc');

            expect(description).toBeTruthy();
            expect(description.textContent).toBe('1から100の間で入力してください');
            expect(input.getAttribute('aria-describedby')).toBe('number-field-desc');
        });
    });
});

describe('ComponentAccessibility', () => {
    let componentAccessibility;

    beforeEach(() => {
        componentAccessibility = new ComponentAccessibility();
    });

    describe('card enhancements', () => {
        it('should add role and tabindex to interactive cards', () => {
            document.body.innerHTML = `
        <div class="card">
          <a href="/test">Link</a>
        </div>
      `;

            componentAccessibility.enhanceCards();

            const card = document.querySelector('.card');
            expect(card.getAttribute('role')).toBe('button');
            expect(card.getAttribute('tabindex')).toBe('0');
        });

        it('should add aria-label from card header', () => {
            document.body.innerHTML = `
        <div class="card">
          <div class="card-header">Card Title</div>
          <a href="/test">Link</a>
        </div>
      `;

            componentAccessibility.enhanceCards();

            const card = document.querySelector('.card');
            expect(card.getAttribute('aria-label')).toBe('Card Title');
        });
    });

    describe('button enhancements', () => {
        it('should add aria-label for icon-only buttons', () => {
            document.body.innerHTML = `
        <button class="btn">
          <i class="bi bi-pencil edit-icon"></i>
        </button>
      `;

            componentAccessibility.enhanceButtons();

            const button = document.querySelector('.btn');
            expect(button.getAttribute('aria-label')).toBe('編集');
        });

        it('should handle loading state', async () => {
            vi.useFakeTimers();

            document.body.innerHTML = `
        <button class="btn" data-loading="true">Save</button>
      `;

            componentAccessibility.enhanceButtons();

            const button = document.querySelector('.btn');
            const originalText = button.textContent;

            button.click();

            expect(button.getAttribute('aria-busy')).toBe('true');
            expect(button.disabled).toBe(true);
            expect(button.textContent).toBe('処理中...');

            vi.advanceTimersByTime(3000);

            expect(button.getAttribute('aria-busy')).toBe('false');
            expect(button.disabled).toBe(false);
            expect(button.textContent).toBe(originalText);

            vi.useRealTimers();
        });
    });

    describe('tab enhancements', () => {
        it('should add proper ARIA attributes to tabs', () => {
            document.body.innerHTML = `
        <ul class="nav-tabs">
          <li><a class="nav-link active" href="#tab1">Tab 1</a></li>
          <li><a class="nav-link" href="#tab2">Tab 2</a></li>
        </ul>
        <div id="tab1" class="tab-pane">Content 1</div>
        <div id="tab2" class="tab-pane">Content 2</div>
      `;

            componentAccessibility.enhanceTabs();

            const tabList = document.querySelector('.nav-tabs');
            const tabs = document.querySelectorAll('.nav-link');
            const panels = document.querySelectorAll('.tab-pane');

            expect(tabList.getAttribute('role')).toBe('tablist');

            tabs.forEach((tab, index) => {
                expect(tab.getAttribute('role')).toBe('tab');
                expect(tab.getAttribute('aria-selected')).toBe(
                    tab.classList.contains('active') ? 'true' : 'false'
                );
                expect(tab.getAttribute('tabindex')).toBe(
                    tab.classList.contains('active') ? '0' : '-1'
                );
            });

            panels.forEach((panel, index) => {
                expect(panel.getAttribute('role')).toBe('tabpanel');
                expect(panel.getAttribute('aria-labelledby')).toBeTruthy();
            });
        });
    });

    describe('data table enhancements', () => {
        it('should add caption to tables without one', () => {
            document.body.innerHTML = `
        <table>
          <thead>
            <tr><th>Header 1</th><th>Header 2</th></tr>
          </thead>
          <tbody>
            <tr><td>Data 1</td><td>Data 2</td></tr>
          </tbody>
        </table>
      `;

            componentAccessibility.enhanceDataTables();

            const caption = document.querySelector('caption');
            expect(caption).toBeTruthy();
            expect(caption.textContent).toBe('データテーブル');
            expect(caption.classList.contains('sr-only')).toBe(true);
        });

        it('should add scope attributes to headers', () => {
            document.body.innerHTML = `
        <table>
          <thead>
            <tr><th>Header 1</th><th>Header 2</th></tr>
          </thead>
          <tbody>
            <tr><th>Row Header</th><td>Data</td></tr>
          </tbody>
        </table>
      `;

            componentAccessibility.enhanceDataTables();

            const headers = document.querySelectorAll('th');
            headers.forEach(header => {
                expect(header.getAttribute('scope')).toBeTruthy();
            });
        });

        it('should add sortable functionality to sortable headers', () => {
            document.body.innerHTML = `
        <table>
          <thead>
            <tr>
              <th data-sort="name">Name</th>
              <th data-sort="date">Date</th>
            </tr>
          </thead>
        </table>
      `;

            // Mock the accessibility manager
            window.accessibilityManager = {
                announce: vi.fn()
            };

            componentAccessibility.enhanceDataTables();

            const sortableHeaders = document.querySelectorAll('th[data-sort]');

            sortableHeaders.forEach(header => {
                expect(header.getAttribute('aria-sort')).toBe('none');
                expect(header.getAttribute('role')).toBe('columnheader');
                expect(header.getAttribute('tabindex')).toBe('0');
            });

            // Test sorting functionality
            const firstHeader = sortableHeaders[0];
            firstHeader.click();

            expect(firstHeader.getAttribute('aria-sort')).toBe('ascending');
            expect(window.accessibilityManager.announce).toHaveBeenCalledWith(
                expect.stringContaining('昇順')
            );
        });
    });
});