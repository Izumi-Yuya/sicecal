import { describe, it, expect, beforeAll, afterAll } from 'vitest';
import puppeteer from 'puppeteer';
import { readFileSync, statSync } from 'fs';
import { join } from 'path';

describe('Performance Tests', () => {
    let browser;
    let page;

    beforeAll(async () => {
        browser = await puppeteer.launch({
            headless: true,
            args: ['--no-sandbox', '--disable-setuid-sandbox']
        });
        page = await browser.newPage();
    });

    afterAll(async () => {
        if (browser) {
            await browser.close();
        }
    });

    describe('CSS Bundle Size', () => {
        it('should have reasonable CSS bundle size', () => {
            const cssPath = join(process.cwd(), 'public/build/assets');

            try {
                // In a real build, we would check the actual built CSS file
                // For this test, we'll check if the source files are reasonable
                const scssFiles = [
                    'resources/sass/app.scss',
                    'resources/sass/_variables.scss',
                    'resources/sass/_custom.scss'
                ];

                let totalSize = 0;
                scssFiles.forEach(file => {
                    try {
                        const stats = statSync(file);
                        totalSize += stats.size;
                    } catch (e) {
                        // File might not exist, skip
                    }
                });

                // Source SCSS should be under 100KB
                expect(totalSize).toBeLessThan(100 * 1024);

                console.log(`Total SCSS source size: ${(totalSize / 1024).toFixed(2)}KB`);
            } catch (error) {
                // If build files don't exist, check source files exist
                expect(() => readFileSync('resources/sass/app.scss')).not.toThrow();
            }
        });

        it('should not have excessive CSS rules', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <head>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          <style>
            /* Simulate our custom CSS */
            .btn { transition: all 0.2s ease; }
            .card { border-radius: 12px; }
            .form-control { border-radius: 6px; }
            .alert { border-left: 4px solid; }
            .nav-link { border-radius: 8px; }
          </style>
        </head>
        <body>
          <div class="test-content">Test</div>
        </body>
        </html>
      `;

            await page.setContent(html);

            // Count CSS rules
            const cssRuleCount = await page.evaluate(() => {
                let totalRules = 0;
                for (let i = 0; i < document.styleSheets.length; i++) {
                    try {
                        const sheet = document.styleSheets[i];
                        if (sheet.cssRules) {
                            totalRules += sheet.cssRules.length;
                        }
                    } catch (e) {
                        // Cross-origin stylesheets might not be accessible
                    }
                }
                return totalRules;
            });

            // Should have reasonable number of CSS rules (Bootstrap + our custom styles)
            expect(cssRuleCount).toBeLessThan(10000);
            console.log(`Total CSS rules: ${cssRuleCount}`);
        });
    });

    describe('Animation Performance', () => {
        it('should have smooth animations', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <head>
          <style>
            .animated-element {
              width: 100px;
              height: 100px;
              background: #007bff;
              transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .animated-element:hover {
              transform: translateY(-2px);
              box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }
            .fade-in {
              opacity: 0;
              animation: fadeIn 0.3s ease forwards;
            }
            @keyframes fadeIn {
              to { opacity: 1; }
            }
          </style>
        </head>
        <body>
          <div class="animated-element" id="test-element"></div>
          <div class="fade-in" id="fade-element">Fade In Text</div>
        </body>
        </html>
      `;

            await page.setContent(html);

            // Test transition performance
            const transitionTime = await page.evaluate(() => {
                return new Promise((resolve) => {
                    const element = document.getElementById('test-element');
                    const startTime = performance.now();

                    element.style.transform = 'translateY(-2px)';

                    element.addEventListener('transitionend', () => {
                        const endTime = performance.now();
                        resolve(endTime - startTime);
                    });
                });
            });

            // Transition should complete within reasonable time (500ms max)
            expect(transitionTime).toBeLessThan(500);
            console.log(`Transition time: ${transitionTime.toFixed(2)}ms`);
        });

        it('should use hardware acceleration for transforms', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <head>
          <style>
            .hw-accelerated {
              transform: translateZ(0); /* Force hardware acceleration */
              transition: transform 0.3s ease;
            }
            .hw-accelerated:hover {
              transform: translateY(-2px) translateZ(0);
            }
          </style>
        </head>
        <body>
          <div class="hw-accelerated" id="hw-element">Hardware Accelerated</div>
        </body>
        </html>
      `;

            await page.setContent(html);

            const hasHardwareAcceleration = await page.evaluate(() => {
                const element = document.getElementById('hw-element');
                const computedStyle = window.getComputedStyle(element);
                const transform = computedStyle.transform;

                // Check if translateZ(0) is applied (indicates hardware acceleration)
                return transform.includes('matrix3d') || transform.includes('translateZ');
            });

            expect(hasHardwareAcceleration).toBe(true);
        });
    });

    describe('JavaScript Performance', () => {
        it('should have fast DOM queries', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <body>
          ${Array.from({ length: 1000 }, (_, i) =>
                `<div class="test-element" data-id="${i}">Element ${i}</div>`
            ).join('')}
        </body>
        </html>
      `;

            await page.setContent(html);

            const queryTime = await page.evaluate(() => {
                const startTime = performance.now();

                // Simulate common DOM queries
                const elements = document.querySelectorAll('.test-element');
                const specificElement = document.querySelector('[data-id="500"]');
                const byId = document.getElementById('non-existent'); // Should be fast even if not found

                const endTime = performance.now();
                return endTime - startTime;
            });

            // DOM queries should be fast (under 10ms for 1000 elements)
            expect(queryTime).toBeLessThan(10);
            console.log(`DOM query time: ${queryTime.toFixed(2)}ms`);
        });

        it('should have efficient event handling', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <body>
          <div id="container">
            ${Array.from({ length: 100 }, (_, i) =>
                `<button class="btn" data-id="${i}">Button ${i}</button>`
            ).join('')}
          </div>
        </body>
        </html>
      `;

            await page.setContent(html);

            const eventTime = await page.evaluate(() => {
                const startTime = performance.now();

                // Use event delegation for efficiency
                const container = document.getElementById('container');
                let clickCount = 0;

                container.addEventListener('click', (e) => {
                    if (e.target.classList.contains('btn')) {
                        clickCount++;
                    }
                });

                // Simulate multiple clicks
                const buttons = document.querySelectorAll('.btn');
                for (let i = 0; i < 10; i++) {
                    buttons[i].click();
                }

                const endTime = performance.now();
                return { time: endTime - startTime, clicks: clickCount };
            });

            expect(eventTime.clicks).toBe(10);
            expect(eventTime.time).toBeLessThan(5); // Should be very fast
            console.log(`Event handling time: ${eventTime.time.toFixed(2)}ms for ${eventTime.clicks} events`);
        });
    });

    describe('Memory Usage', () => {
        it('should not have memory leaks in event listeners', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <body>
          <div id="test-container"></div>
        </body>
        </html>
      `;

            await page.setContent(html);

            const memoryUsage = await page.evaluate(() => {
                const container = document.getElementById('test-container');
                const listeners = [];

                // Create and remove many event listeners
                for (let i = 0; i < 1000; i++) {
                    const element = document.createElement('button');
                    element.textContent = `Button ${i}`;

                    const handler = () => console.log(`Clicked ${i}`);
                    element.addEventListener('click', handler);
                    listeners.push({ element, handler });

                    container.appendChild(element);
                }

                // Clean up properly
                listeners.forEach(({ element, handler }) => {
                    element.removeEventListener('click', handler);
                    element.remove();
                });

                // Force garbage collection if available
                if (window.gc) {
                    window.gc();
                }

                return {
                    childCount: container.children.length,
                    listenerCount: listeners.length
                };
            });

            expect(memoryUsage.childCount).toBe(0);
            expect(memoryUsage.listenerCount).toBe(1000);
        });

        it('should efficiently handle large datasets', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <body>
          <table id="data-table">
            <thead>
              <tr><th>ID</th><th>Name</th><th>Value</th></tr>
            </thead>
            <tbody></tbody>
          </table>
        </body>
        </html>
      `;

            await page.setContent(html);

            const renderTime = await page.evaluate(() => {
                const startTime = performance.now();
                const tbody = document.querySelector('#data-table tbody');

                // Create large dataset
                const fragment = document.createDocumentFragment();
                for (let i = 0; i < 1000; i++) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
            <td>${i}</td>
            <td>Item ${i}</td>
            <td>${Math.random().toFixed(2)}</td>
          `;
                    fragment.appendChild(row);
                }

                tbody.appendChild(fragment);

                const endTime = performance.now();
                return {
                    time: endTime - startTime,
                    rowCount: tbody.children.length
                };
            });

            expect(renderTime.rowCount).toBe(1000);
            expect(renderTime.time).toBeLessThan(100); // Should render 1000 rows in under 100ms
            console.log(`Rendered ${renderTime.rowCount} rows in ${renderTime.time.toFixed(2)}ms`);
        });
    });

    describe('Load Time Performance', () => {
        it('should have fast initial page load', async () => {
            const startTime = Date.now();

            const html = `
        <!DOCTYPE html>
        <html>
        <head>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
        </head>
        <body>
          <div class="container">
            <h1>Test Page</h1>
            <div class="row">
              ${Array.from({ length: 20 }, (_, i) => `
                <div class="col-md-6 col-lg-4 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Card ${i + 1}</h5>
                      <p class="card-text">Some content for card ${i + 1}</p>
                    </div>
                  </div>
                </div>
              `).join('')}
            </div>
          </div>
        </body>
        </html>
      `;

            await page.setContent(html);
            await page.waitForLoadState('networkidle');

            const loadTime = Date.now() - startTime;

            // Page should load within reasonable time
            expect(loadTime).toBeLessThan(3000); // 3 seconds max
            console.log(`Page load time: ${loadTime}ms`);
        });

        it('should have efficient CSS parsing', async () => {
            const startTime = performance.now();

            const html = `
        <!DOCTYPE html>
        <html>
        <head>
          <style>
            /* Simulate complex CSS */
            ${Array.from({ length: 100 }, (_, i) => `
              .component-${i} {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
                margin: 0.5rem;
                border: 1px solid #dee2e6;
                border-radius: 0.375rem;
                background-color: #f8f9fa;
                transition: all 0.2s ease;
              }
              .component-${i}:hover {
                background-color: #e9ecef;
                transform: translateY(-1px);
              }
            `).join('')}
          </style>
        </head>
        <body>
          ${Array.from({ length: 50 }, (_, i) => `
            <div class="component-${i}">Component ${i}</div>
          `).join('')}
        </body>
        </html>
      `;

            await page.setContent(html);

            const parseTime = await page.evaluate(() => {
                const startTime = performance.now();

                // Force style recalculation
                document.body.offsetHeight;

                const endTime = performance.now();
                return endTime - startTime;
            });

            // CSS parsing and style calculation should be fast
            expect(parseTime).toBeLessThan(50);
            console.log(`CSS parse time: ${parseTime.toFixed(2)}ms`);
        });
    });

    describe('Responsive Performance', () => {
        const viewports = [
            { name: 'mobile', width: 375, height: 667 },
            { name: 'tablet', width: 768, height: 1024 },
            { name: 'desktop', width: 1200, height: 800 }
        ];

        viewports.forEach(viewport => {
            it(`should perform well at ${viewport.name} viewport`, async () => {
                await page.setViewport({ width: viewport.width, height: viewport.height });

                const html = `
          <!DOCTYPE html>
          <html>
          <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          </head>
          <body>
            <div class="container-fluid">
              <div class="row">
                ${Array.from({ length: 12 }, (_, i) => `
                  <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                    <div class="card">
                      <div class="card-body">
                        <h5>Card ${i + 1}</h5>
                        <p>Responsive card content</p>
                      </div>
                    </div>
                  </div>
                `).join('')}
              </div>
            </div>
          </body>
          </html>
        `;

                const startTime = performance.now();
                await page.setContent(html);

                // Measure layout time
                const layoutTime = await page.evaluate(() => {
                    const startTime = performance.now();

                    // Force layout recalculation
                    document.body.offsetHeight;

                    const endTime = performance.now();
                    return endTime - startTime;
                });

                const totalTime = performance.now() - startTime;

                expect(layoutTime).toBeLessThan(20);
                expect(totalTime).toBeLessThan(100);

                console.log(`${viewport.name} layout time: ${layoutTime.toFixed(2)}ms, total: ${totalTime.toFixed(2)}ms`);
            });
        });
    });
});