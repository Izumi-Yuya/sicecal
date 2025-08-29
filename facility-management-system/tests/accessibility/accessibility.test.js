import { describe, it, expect, beforeEach } from 'vitest';
import { getByRole, getByLabelText, queryByRole } from '@testing-library/dom';

describe('Accessibility Tests', () => {
    describe('ARIA Roles and Labels', () => {
        beforeEach(() => {
            document.body.innerHTML = '';
        });

        it('should have proper navigation structure', () => {
            document.body.innerHTML = `
        <nav class="shise-sidebar" role="navigation" aria-labelledby="nav-label">
          <h2 id="nav-label">Navigation Menu</h2>
          <ul role="menubar">
            <li role="none">
              <a href="#" role="menuitem" aria-current="page">Home</a>
            </li>
            <li role="none">
              <a href="#" role="menuitem">Facilities</a>
            </li>
          </ul>
        </nav>
      `;

            const nav = getByRole(document.body, 'navigation');
            expect(nav).toBeTruthy();
            expect(nav.getAttribute('aria-labelledby')).toBe('nav-label');

            const menubar = getByRole(document.body, 'menubar');
            expect(menubar).toBeTruthy();

            const menuItems = document.querySelectorAll('[role="menuitem"]');
            expect(menuItems).toHaveLength(2);

            const currentPage = document.querySelector('[aria-current="page"]');
            expect(currentPage).toBeTruthy();
        });

        it('should have proper form labels and descriptions', () => {
            document.body.innerHTML = `
        <form>
          <div class="form-group">
            <label for="facility-name">施設名 <span aria-label="必須">*</span></label>
            <input type="text" id="facility-name" name="facility_name" required 
                   aria-describedby="facility-name-desc">
            <div id="facility-name-desc" class="form-text">施設の正式名称を入力してください</div>
          </div>
          <div class="form-group">
            <label for="opening-date">開設年月日</label>
            <input type="date" id="opening-date" name="opening_date" 
                   aria-describedby="opening-date-desc">
            <div id="opening-date-desc" class="form-text">形式: YYYY-MM-DD (例: 2024-01-15)</div>
          </div>
        </form>
      `;

            const facilityNameInput = getByLabelText(document.body, /施設名/);
            expect(facilityNameInput).toBeTruthy();
            expect(facilityNameInput.getAttribute('aria-describedby')).toBe('facility-name-desc');
            expect(facilityNameInput.hasAttribute('required')).toBe(true);

            const openingDateInput = getByLabelText(document.body, '開設年月日');
            expect(openingDateInput).toBeTruthy();
            expect(openingDateInput.getAttribute('aria-describedby')).toBe('opening-date-desc');

            const requiredIndicator = document.querySelector('[aria-label="必須"]');
            expect(requiredIndicator).toBeTruthy();
        });

        it('should have proper table structure', () => {
            document.body.innerHTML = `
        <table>
          <caption class="sr-only">施設一覧データテーブル</caption>
          <thead>
            <tr>
              <th scope="col" role="columnheader" tabindex="0" aria-sort="none">施設名</th>
              <th scope="col" role="columnheader" tabindex="0" aria-sort="none">所在地</th>
              <th scope="col">アクション</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">サンプル施設A</th>
              <td>東京都渋谷区</td>
              <td>
                <button class="btn btn-sm btn-primary" aria-label="サンプル施設Aを編集">
                  <i class="bi bi-pencil" aria-hidden="true"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      `;

            const table = document.querySelector('table');
            expect(table).toBeTruthy();

            const caption = document.querySelector('caption');
            expect(caption).toBeTruthy();
            expect(caption.textContent).toBe('施設一覧データテーブル');

            const columnHeaders = document.querySelectorAll('th[scope="col"]');
            expect(columnHeaders).toHaveLength(3);

            const sortableHeaders = document.querySelectorAll('[role="columnheader"]');
            sortableHeaders.forEach(header => {
                expect(header.getAttribute('tabindex')).toBe('0');
                expect(header.getAttribute('aria-sort')).toBe('none');
            });

            const rowHeader = document.querySelector('th[scope="row"]');
            expect(rowHeader).toBeTruthy();

            const editButton = getByLabelText(document.body, 'サンプル施設Aを編集');
            expect(editButton).toBeTruthy();

            const icon = editButton.querySelector('[aria-hidden="true"]');
            expect(icon).toBeTruthy();
        });

        it('should have proper tab structure', () => {
            document.body.innerHTML = `
        <div class="facility-tabs">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="none">
              <a class="nav-link active" id="basic-tab" role="tab" 
                 aria-controls="basic-panel" aria-selected="true" tabindex="0">基本情報</a>
            </li>
            <li class="nav-item" role="none">
              <a class="nav-link" id="land-tab" role="tab" 
                 aria-controls="land-panel" aria-selected="false" tabindex="-1">土地情報</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="basic-panel" role="tabpanel" 
                 aria-labelledby="basic-tab">基本情報の内容</div>
            <div class="tab-pane fade" id="land-panel" role="tabpanel" 
                 aria-labelledby="land-tab">土地情報の内容</div>
          </div>
        </div>
      `;

            const tablist = getByRole(document.body, 'tablist');
            expect(tablist).toBeTruthy();

            const tabs = document.querySelectorAll('[role="tab"]');
            expect(tabs).toHaveLength(2);

            const activeTab = document.querySelector('[aria-selected="true"]');
            expect(activeTab).toBeTruthy();
            expect(activeTab.getAttribute('tabindex')).toBe('0');

            const inactiveTab = document.querySelector('[aria-selected="false"]');
            expect(inactiveTab).toBeTruthy();
            expect(inactiveTab.getAttribute('tabindex')).toBe('-1');

            const tabpanels = document.querySelectorAll('[role="tabpanel"]');
            expect(tabpanels).toHaveLength(2);

            tabpanels.forEach(panel => {
                expect(panel.getAttribute('aria-labelledby')).toBeTruthy();
            });
        });

        it('should have proper alert structure', () => {
            document.body.innerHTML = `
        <div class="alert alert-success" role="alert" aria-live="polite">
          <i class="bi bi-check-circle" aria-hidden="true"></i>
          操作が正常に完了しました
          <button type="button" class="btn-close" aria-label="成功メッセージを閉じる"></button>
        </div>
        <div class="alert alert-danger" role="alert" aria-live="assertive">
          <i class="bi bi-exclamation-triangle" aria-hidden="true"></i>
          エラーが発生しました
          <button type="button" class="btn-close" aria-label="エラーメッセージを閉じる"></button>
        </div>
      `;

            const alerts = document.querySelectorAll('[role="alert"]');
            expect(alerts).toHaveLength(2);

            const successAlert = alerts[0];
            expect(successAlert.getAttribute('aria-live')).toBe('polite');

            const errorAlert = alerts[1];
            expect(errorAlert.getAttribute('aria-live')).toBe('assertive');

            const closeButtons = document.querySelectorAll('.btn-close');
            closeButtons.forEach(button => {
                expect(button.getAttribute('aria-label')).toBeTruthy();
            });

            const icons = document.querySelectorAll('[aria-hidden="true"]');
            expect(icons).toHaveLength(2);
        });
    });

    describe('Keyboard Navigation', () => {
        it('should support keyboard navigation for interactive elements', () => {
            document.body.innerHTML = `
        <div class="interactive-elements">
          <button class="btn btn-primary">Button 1</button>
          <a href="#" class="btn btn-secondary">Link Button</a>
          <input type="text" class="form-control" placeholder="Text input">
          <select class="form-select">
            <option>Option 1</option>
            <option>Option 2</option>
          </select>
          <div class="card" role="button" tabindex="0">Interactive Card</div>
        </div>
      `;

            const interactiveElements = document.querySelectorAll(
                'button, a, input, select, [role="button"][tabindex="0"]'
            );

            expect(interactiveElements.length).toBeGreaterThan(0);

            interactiveElements.forEach(element => {
                // Check that element is focusable
                const tabIndex = element.getAttribute('tabindex');
                const isNaturallyFocusable = ['BUTTON', 'A', 'INPUT', 'SELECT'].includes(element.tagName);

                expect(isNaturallyFocusable || tabIndex === '0').toBe(true);
            });
        });

        it('should have skip links for keyboard navigation', () => {
            document.body.innerHTML = `
        <a href="#main-content" class="skip-link">メインコンテンツへスキップ</a>
        <a href="#sidebar-nav" class="skip-link">ナビゲーションへスキップ</a>
        <nav id="sidebar-nav">Navigation</nav>
        <main id="main-content">Main Content</main>
      `;

            const skipLinks = document.querySelectorAll('.skip-link');
            expect(skipLinks).toHaveLength(2);

            skipLinks.forEach(link => {
                const target = link.getAttribute('href').substring(1);
                const targetElement = document.getElementById(target);
                expect(targetElement).toBeTruthy();
            });
        });
    });

    describe('Screen Reader Support', () => {
        it('should have screen reader only text for visual indicators', () => {
            document.body.innerHTML = `
        <div class="status-indicator status-success" data-status-text="成功">
          ✓ 完了
        </div>
        <div class="loading-state" aria-busy="true">
          <span class="sr-only">読み込み中...</span>
          Loading...
        </div>
        <button class="btn btn-primary">
          <i class="bi bi-save" aria-hidden="true"></i>
          <span class="sr-only">保存</span>
        </button>
      `;

            const srOnlyElements = document.querySelectorAll('.sr-only');
            expect(srOnlyElements.length).toBeGreaterThan(0);

            const statusIndicator = document.querySelector('.status-indicator');
            expect(statusIndicator.getAttribute('data-status-text')).toBe('成功');

            const loadingState = document.querySelector('[aria-busy="true"]');
            expect(loadingState).toBeTruthy();

            const hiddenIcon = document.querySelector('[aria-hidden="true"]');
            expect(hiddenIcon).toBeTruthy();
        });

        it('should have proper live regions', () => {
            document.body.innerHTML = `
        <div id="aria-live-polite" aria-live="polite" aria-atomic="true" class="sr-only"></div>
        <div id="aria-live-assertive" aria-live="assertive" aria-atomic="true" class="sr-only"></div>
      `;

            const politeRegion = document.getElementById('aria-live-polite');
            expect(politeRegion).toBeTruthy();
            expect(politeRegion.getAttribute('aria-live')).toBe('polite');
            expect(politeRegion.getAttribute('aria-atomic')).toBe('true');

            const assertiveRegion = document.getElementById('aria-live-assertive');
            expect(assertiveRegion).toBeTruthy();
            expect(assertiveRegion.getAttribute('aria-live')).toBe('assertive');
            expect(assertiveRegion.getAttribute('aria-atomic')).toBe('true');
        });
    });

    describe('Form Accessibility', () => {
        it('should have proper form validation accessibility', () => {
            document.body.innerHTML = `
        <form>
          <div class="form-group">
            <label for="required-field">必須フィールド <span aria-label="必須">*</span></label>
            <input type="text" id="required-field" class="form-control is-invalid" 
                   required aria-describedby="required-field-feedback">
            <div id="required-field-feedback" class="invalid-feedback">
              このフィールドは必須です
            </div>
          </div>
          <div class="form-group">
            <label for="valid-field">有効なフィールド</label>
            <input type="text" id="valid-field" class="form-control is-valid" 
                   value="Valid input" aria-describedby="valid-field-feedback">
            <div id="valid-field-feedback" class="valid-feedback">
              正しく入力されています
            </div>
          </div>
        </form>
      `;

            const requiredField = document.getElementById('required-field');
            expect(requiredField.hasAttribute('required')).toBe(true);
            expect(requiredField.getAttribute('aria-describedby')).toBe('required-field-feedback');
            expect(requiredField.classList.contains('is-invalid')).toBe(true);

            const validField = document.getElementById('valid-field');
            expect(validField.getAttribute('aria-describedby')).toBe('valid-field-feedback');
            expect(validField.classList.contains('is-valid')).toBe(true);

            const invalidFeedback = document.getElementById('required-field-feedback');
            expect(invalidFeedback.classList.contains('invalid-feedback')).toBe(true);

            const validFeedback = document.getElementById('valid-field-feedback');
            expect(validFeedback.classList.contains('valid-feedback')).toBe(true);
        });

        it('should have fieldset and legend for grouped form controls', () => {
            document.body.innerHTML = `
        <form>
          <fieldset>
            <legend>連絡先情報</legend>
            <div class="form-group">
              <label for="phone">電話番号</label>
              <input type="tel" id="phone" class="form-control">
            </div>
            <div class="form-group">
              <label for="email">メールアドレス</label>
              <input type="email" id="email" class="form-control">
            </div>
          </fieldset>
        </form>
      `;

            const fieldset = document.querySelector('fieldset');
            expect(fieldset).toBeTruthy();

            const legend = document.querySelector('legend');
            expect(legend).toBeTruthy();
            expect(legend.textContent).toBe('連絡先情報');

            const phoneInput = getByLabelText(document.body, '電話番号');
            expect(phoneInput).toBeTruthy();
            expect(phoneInput.type).toBe('tel');

            const emailInput = getByLabelText(document.body, 'メールアドレス');
            expect(emailInput).toBeTruthy();
            expect(emailInput.type).toBe('email');
        });
    });

    describe('Color Contrast and Visual Accessibility', () => {
        it('should not rely solely on color for information', () => {
            document.body.innerHTML = `
        <div class="status-indicators">
          <div class="status-success">
            <i class="bi bi-check-circle" aria-hidden="true"></i>
            <span class="sr-only">成功: </span>
            操作完了
          </div>
          <div class="status-error">
            <i class="bi bi-exclamation-triangle" aria-hidden="true"></i>
            <span class="sr-only">エラー: </span>
            操作失敗
          </div>
          <div class="status-warning">
            <i class="bi bi-exclamation-triangle" aria-hidden="true"></i>
            <span class="sr-only">警告: </span>
            注意が必要
          </div>
        </div>
      `;

            const statusElements = document.querySelectorAll('[class*="status-"]');

            statusElements.forEach(element => {
                // Check that status has both icon and screen reader text
                const icon = element.querySelector('[aria-hidden="true"]');
                const srText = element.querySelector('.sr-only');

                expect(icon).toBeTruthy();
                expect(srText).toBeTruthy();
            });
        });

        it('should have proper focus indicators', () => {
            document.body.innerHTML = `
        <style>
          .focus-test:focus-visible {
            outline: 2px solid #0d6efd;
            outline-offset: 2px;
          }
        </style>
        <button class="btn btn-primary focus-test">Focusable Button</button>
        <input type="text" class="form-control focus-test" placeholder="Focusable Input">
        <a href="#" class="focus-test">Focusable Link</a>
      `;

            const focusableElements = document.querySelectorAll('.focus-test');

            focusableElements.forEach(element => {
                // Simulate focus
                element.focus();

                // Check that element can receive focus
                expect(document.activeElement).toBe(element);
            });
        });
    });
});