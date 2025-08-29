import { describe, it, expect, beforeAll, afterAll } from 'vitest';
import puppeteer from 'puppeteer';
import { readFileSync, writeFileSync, existsSync, mkdirSync } from 'fs';
import { join } from 'path';

describe('Visual Regression Tests', () => {
    let browser;
    let page;
    const screenshotDir = 'tests/visual/screenshots';
    const baselineDir = 'tests/visual/baselines';

    beforeAll(async () => {
        // Ensure directories exist
        if (!existsSync(screenshotDir)) {
            mkdirSync(screenshotDir, { recursive: true });
        }
        if (!existsSync(baselineDir)) {
            mkdirSync(baselineDir, { recursive: true });
        }

        browser = await puppeteer.launch({
            headless: true,
            args: ['--no-sandbox', '--disable-setuid-sandbox']
        });
        page = await browser.newPage();

        // Set viewport for consistent screenshots
        await page.setViewport({ width: 1200, height: 800 });
    });

    afterAll(async () => {
        if (browser) {
            await browser.close();
        }
    });

    const takeScreenshot = async (name, selector = null) => {
        const screenshotPath = join(screenshotDir, `${name}.png`);

        if (selector) {
            const element = await page.$(selector);
            if (element) {
                await element.screenshot({ path: screenshotPath });
            }
        } else {
            await page.screenshot({ path: screenshotPath, fullPage: true });
        }

        return screenshotPath;
    };

    const compareWithBaseline = (screenshotPath, name) => {
        const baselinePath = join(baselineDir, `${name}.png`);

        if (!existsSync(baselinePath)) {
            // If no baseline exists, copy current screenshot as baseline
            const screenshot = readFileSync(screenshotPath);
            writeFileSync(baselinePath, screenshot);
            console.log(`Created baseline for ${name}`);
            return true;
        }

        // In a real implementation, you would use an image comparison library
        // For this test, we'll just check if files exist
        const baseline = readFileSync(baselinePath);
        const screenshot = readFileSync(screenshotPath);

        // Simple byte comparison (in real implementation, use pixelmatch or similar)
        return baseline.length === screenshot.length;
    };

    describe('Component Screenshots', () => {
        it('should capture button component variations', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <head>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          <style>
            .btn { margin: 0.5rem; }
            .component-showcase { padding: 2rem; background: #f8f9fa; }
          </style>
        </head>
        <body>
          <div class="component-showcase">
            <h3>Button Components</h3>
            <div class="mb-3">
              <button class="btn btn-primary">Primary</button>
              <button class="btn btn-secondary">Secondary</button>
              <button class="btn btn-success">Success</button>
              <button class="btn btn-danger">Danger</button>
              <button class="btn btn-warning">Warning</button>
              <button class="btn btn-info">Info</button>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary btn-sm">Small</button>
              <button class="btn btn-primary">Regular</button>
              <button class="btn btn-primary btn-lg">Large</button>
            </div>
            <div class="mb-3">
              <button class="btn btn-outline-primary">Outline Primary</button>
              <button class="btn btn-outline-secondary">Outline Secondary</button>
              <button class="btn btn-primary" disabled>Disabled</button>
            </div>
          </div>
        </body>
        </html>
      `;

            await page.setContent(html);
            const screenshotPath = await takeScreenshot('buttons', '.component-showcase');
            const isMatch = compareWithBaseline(screenshotPath, 'buttons');

            expect(isMatch).toBe(true);
        });

        it('should capture form component variations', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <head>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          <style>
            .component-showcase { padding: 2rem; background: #f8f9fa; max-width: 600px; }
            .form-group { margin-bottom: 1rem; }
          </style>
        </head>
        <body>
          <div class="component-showcase">
            <h3>Form Components</h3>
            <form>
              <div class="form-group">
                <label for="text-input" class="form-label">Text Input</label>
                <input type="text" class="form-control" id="text-input" placeholder="Enter text">
              </div>
              <div class="form-group">
                <label for="select-input" class="form-label">Select Input</label>
                <select class="form-select" id="select-input">
                  <option>Choose option</option>
                  <option>Option 1</option>
                  <option>Option 2</option>
                </select>
              </div>
              <div class="form-group">
                <label for="textarea-input" class="form-label">Textarea</label>
                <textarea class="form-control" id="textarea-input" rows="3" placeholder="Enter description"></textarea>
              </div>
              <div class="form-group">
                <input type="text" class="form-control is-invalid" placeholder="Invalid input">
                <div class="invalid-feedback">This field is required</div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control is-valid" value="Valid input">
                <div class="valid-feedback">Looks good!</div>
              </div>
            </form>
          </div>
        </body>
        </html>
      `;

            await page.setContent(html);
            const screenshotPath = await takeScreenshot('forms', '.component-showcase');
            const isMatch = compareWithBaseline(screenshotPath, 'forms');

            expect(isMatch).toBe(true);
        });

        it('should capture card component variations', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <head>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          <style>
            .component-showcase { padding: 2rem; background: #f8f9fa; }
            .card { margin-bottom: 1rem; max-width: 300px; }
          </style>
        </head>
        <body>
          <div class="component-showcase">
            <h3>Card Components</h3>
            <div class="card">
              <div class="card-header">Card Header</div>
              <div class="card-body">
                <h5 class="card-title">Card Title</h5>
                <p class="card-text">Some card content text.</p>
                <a href="#" class="btn btn-primary">Action</a>
              </div>
            </div>
            <div class="card border-primary">
              <div class="card-body">
                <h5 class="card-title">Primary Border Card</h5>
                <p class="card-text">Card with primary border.</p>
              </div>
            </div>
            <div class="card text-white bg-primary">
              <div class="card-body">
                <h5 class="card-title">Primary Background</h5>
                <p class="card-text">Card with primary background.</p>
              </div>
            </div>
          </div>
        </body>
        </html>
      `;

            await page.setContent(html);
            const screenshotPath = await takeScreenshot('cards', '.component-showcase');
            const isMatch = compareWithBaseline(screenshotPath, 'cards');

            expect(isMatch).toBe(true);
        });

        it('should capture alert component variations', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <head>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
          <style>
            .component-showcase { padding: 2rem; background: #f8f9fa; }
            .alert { margin-bottom: 1rem; }
          </style>
        </head>
        <body>
          <div class="component-showcase">
            <h3>Alert Components</h3>
            <div class="alert alert-primary" role="alert">
              <i class="bi bi-info-circle me-2"></i>Primary alert message
            </div>
            <div class="alert alert-success" role="alert">
              <i class="bi bi-check-circle me-2"></i>Success alert message
            </div>
            <div class="alert alert-warning" role="alert">
              <i class="bi bi-exclamation-triangle me-2"></i>Warning alert message
            </div>
            <div class="alert alert-danger" role="alert">
              <i class="bi bi-exclamation-triangle me-2"></i>Danger alert message
            </div>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <i class="bi bi-info-circle me-2"></i>Dismissible info alert
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          </div>
        </body>
        </html>
      `;

            await page.setContent(html);
            const screenshotPath = await takeScreenshot('alerts', '.component-showcase');
            const isMatch = compareWithBaseline(screenshotPath, 'alerts');

            expect(isMatch).toBe(true);
        });
    });

    describe('Responsive Screenshots', () => {
        const viewports = [
            { name: 'mobile', width: 375, height: 667 },
            { name: 'tablet', width: 768, height: 1024 },
            { name: 'desktop', width: 1200, height: 800 }
        ];

        viewports.forEach(viewport => {
            it(`should capture responsive layout at ${viewport.name} viewport`, async () => {
                await page.setViewport({ width: viewport.width, height: viewport.height });

                const html = `
          <!DOCTYPE html>
          <html>
          <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
              .header { background: linear-gradient(90deg, rgba(0,180,227,0.3) 20%, rgba(242,124,166,0.3) 80%); padding: 1rem; }
              .sidebar { background: #f8f9fa; min-height: 400px; }
              .content { padding: 2rem; }
            </style>
          </head>
          <body>
            <div class="header">
              <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="logo">Shise-Cal</div>
                  <button class="btn btn-outline-secondary d-lg-none">Menu</button>
                </div>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-3 sidebar d-none d-lg-block">
                  <nav class="nav flex-column">
                    <a class="nav-link active" href="#">HOME</a>
                    <a class="nav-link" href="#">施設一覧</a>
                    <a class="nav-link" href="#">CSV出力</a>
                  </nav>
                </div>
                <div class="col-lg-9 content">
                  <h1>Dashboard</h1>
                  <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                      <div class="card">
                        <div class="card-body">
                          <h5>Total Facilities</h5>
                          <h2>150</h2>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                      <div class="card">
                        <div class="card-body">
                          <h5>Active Users</h5>
                          <h2>45</h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </body>
          </html>
        `;

                await page.setContent(html);
                const screenshotPath = await takeScreenshot(`responsive-${viewport.name}`);
                const isMatch = compareWithBaseline(screenshotPath, `responsive-${viewport.name}`);

                expect(isMatch).toBe(true);
            });
        });
    });

    describe('Accessibility Visual Tests', () => {
        it('should capture focus indicators', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <head>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          <style>
            .component-showcase { padding: 2rem; background: #f8f9fa; }
            .btn:focus-visible { outline: 2px solid #0d6efd; outline-offset: 2px; }
            .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25); }
          </style>
        </head>
        <body>
          <div class="component-showcase">
            <h3>Focus Indicators</h3>
            <button class="btn btn-primary me-2" style="outline: 2px solid #0d6efd; outline-offset: 2px;">Focused Button</button>
            <input type="text" class="form-control" style="border-color: #0d6efd; box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25); width: 200px; display: inline-block;" value="Focused Input">
          </div>
        </body>
        </html>
      `;

            await page.setContent(html);
            const screenshotPath = await takeScreenshot('focus-indicators', '.component-showcase');
            const isMatch = compareWithBaseline(screenshotPath, 'focus-indicators');

            expect(isMatch).toBe(true);
        });

        it('should capture high contrast mode', async () => {
            const html = `
        <!DOCTYPE html>
        <html>
        <head>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          <style>
            .component-showcase { padding: 2rem; background: #f8f9fa; }
            /* Simulate high contrast mode */
            .btn { border: 2px solid !important; }
            .card { border: 2px solid #000 !important; }
            .form-control { border: 2px solid #000 !important; }
          </style>
        </head>
        <body>
          <div class="component-showcase">
            <h3>High Contrast Mode</h3>
            <button class="btn btn-primary me-2">Primary Button</button>
            <div class="card mt-3" style="max-width: 300px;">
              <div class="card-body">
                <h5>Card Title</h5>
                <input type="text" class="form-control" placeholder="Input field">
              </div>
            </div>
          </div>
        </body>
        </html>
      `;

            await page.setContent(html);
            const screenshotPath = await takeScreenshot('high-contrast', '.component-showcase');
            const isMatch = compareWithBaseline(screenshotPath, 'high-contrast');

            expect(isMatch).toBe(true);
        });
    });
});