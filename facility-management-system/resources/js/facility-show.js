/**
 * Facility Show Page JavaScript
 * 施設詳細ページの機能を管理
 */

document.addEventListener('DOMContentLoaded', function () {
    // Edit mode functionality
    const editModeBtn = document.getElementById('editModeBtn');
    const saveModeBtn = document.getElementById('saveModeBtn');
    const cancelModeBtn = document.getElementById('cancelModeBtn');
    const formDisplays = document.querySelectorAll('.form-display');
    const formEdits = document.querySelectorAll('.form-edit');

    // Edit mode toggle
    if (editModeBtn) {
        editModeBtn.addEventListener('click', function () {
            // Hide display elements and show edit elements
            formDisplays.forEach(el => el.classList.add('d-none'));
            formEdits.forEach(el => el.classList.remove('d-none'));

            // Toggle buttons
            editModeBtn.classList.add('d-none');
            saveModeBtn.classList.remove('d-none');
            cancelModeBtn.classList.remove('d-none');
        });
    }

    if (cancelModeBtn) {
        cancelModeBtn.addEventListener('click', function () {
            // Show display elements and hide edit elements
            formDisplays.forEach(el => el.classList.remove('d-none'));
            formEdits.forEach(el => el.classList.add('d-none'));

            // Toggle buttons
            editModeBtn.classList.remove('d-none');
            saveModeBtn.classList.add('d-none');
            cancelModeBtn.classList.add('d-none');
        });
    }

    if (saveModeBtn) {
        saveModeBtn.addEventListener('click', function () {
            // Here you would collect all form data and submit via AJAX
            alert('保存機能は実装中です');

            // For now, just exit edit mode
            cancelModeBtn.click();
        });
    }

    // Auto-calculation functions
    function calculateAge(startDate) {
        if (!startDate) return '';
        const start = new Date(startDate);
        const now = new Date();
        const years = now.getFullYear() - start.getFullYear();
        const months = now.getMonth() - start.getMonth();

        let totalMonths = years * 12 + months;
        if (now.getDate() < start.getDate()) {
            totalMonths--;
        }

        const finalYears = Math.floor(totalMonths / 12);
        const finalMonths = totalMonths % 12;

        return `${finalYears}年${finalMonths}ヶ月`;
    }

    function calculateUnitPrice(totalPrice, area) {
        if (!totalPrice || !area || area === 0) return '';
        return Math.round(totalPrice / area).toLocaleString();
    }

    // Auto-calculation event listeners
    const openingDateInput = document.querySelector('input[name="opening_date"]');
    const completionDateInput = document.querySelector('input[name="completion_date"]');
    const landPriceInput = document.querySelector('input[name="land_purchase_price"]');
    const landAreaInput = document.querySelector('input[name="site_area_tsubo"]');
    const buildingPriceInput = document.querySelector('input[name="building_main_price"]');
    const buildingAreaInput = document.querySelector('input[name="floor_area_tsubo"]');

    if (openingDateInput) {
        openingDateInput.addEventListener('change', function () {
            const age = calculateAge(this.value);
            // Update display (you would update the actual display element here)
            console.log('Operating years:', age);
        });
    }

    if (completionDateInput) {
        completionDateInput.addEventListener('change', function () {
            const age = calculateAge(this.value);
            // Update display
            console.log('Building age:', age);
        });
    }

    if (landPriceInput && landAreaInput) {
        [landPriceInput, landAreaInput].forEach(input => {
            input.addEventListener('input', function () {
                const unitPrice = calculateUnitPrice(
                    parseFloat(landPriceInput.value) || 0,
                    parseFloat(landAreaInput.value) || 0
                );
                console.log('Land unit price:', unitPrice);
            });
        });
    }

    if (buildingPriceInput && buildingAreaInput) {
        [buildingPriceInput, buildingAreaInput].forEach(input => {
            input.addEventListener('input', function () {
                const unitPrice = calculateUnitPrice(
                    parseFloat(buildingPriceInput.value) || 0,
                    parseFloat(buildingAreaInput.value) || 0
                );
                console.log('Building unit price:', unitPrice);
            });
        });
    }

    // Format number inputs with commas
    document.querySelectorAll('input[type="number"]').forEach(input => {
        if (input.name && (input.name.includes('price') || input.name.includes('rent'))) {
            input.addEventListener('blur', function () {
                if (this.value) {
                    const formatted = parseInt(this.value).toLocaleString();
                    console.log('Formatted value:', formatted);
                }
            });
        }
    });

    // Postal code formatting
    document.querySelectorAll('input[name*="postal_code"]').forEach(input => {
        input.addEventListener('input', function () {
            let value = this.value.replace(/[^\d]/g, '');
            if (value.length >= 3) {
                value = value.substring(0, 3) + '-' + value.substring(3, 7);
            }
            this.value = value;
        });
    });

    // Phone number formatting
    document.querySelectorAll('input[type="tel"]').forEach(input => {
        input.addEventListener('input', function () {
            let value = this.value.replace(/[^\d]/g, '');
            if (value.length >= 6) {
                if (value.startsWith('0120') || value.startsWith('0800')) {
                    // Free dial format
                    value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7, 10);
                } else {
                    // Regular phone format
                    if (value.length >= 10) {
                        value = value.substring(0, 3) + '-' + value.substring(3, 7) + '-' + value.substring(7, 11);
                    }
                }
            }
            this.value = value;
        });
    });
    // Category tab functionality
    function initializeCategoryTabs() {
        const tabs = ['utilities', 'security', 'contracts', 'blueprints', 'maintenance'];

        tabs.forEach(tabName => {
            const categoryTabs = document.querySelectorAll(`#${tabName}-category-tabs .category-tab`);

            categoryTabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Remove active class from all category tabs in this group
                    categoryTabs.forEach(t => t.classList.remove('active'));

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Get category and filter sections
                    const category = this.getAttribute('data-category');
                    filterSections(tabName, category);
                });
            });
        });
    }

    function filterSections(tabName, category) {
        const sections = document.querySelectorAll(`.${tabName}-section`);

        sections.forEach(section => {
            if (category === 'all') {
                section.style.display = 'block';
                section.style.opacity = '1';
            } else {
                const sectionCategory = section.getAttribute('data-category');
                if (sectionCategory === category) {
                    section.style.display = 'block';
                    section.style.opacity = '1';
                } else {
                    section.style.display = 'none';
                    section.style.opacity = '0';
                }
            }
        });
    }

    // Initialize category tabs
    initializeCategoryTabs();
});