/**
 * Data Table Utilities
 * 
 * JavaScript utilities for responsive data table functionality including
 * sorting, filtering, pagination, and responsive behavior management
 */

class DataTableUtils {
    constructor(tableElement, options = {}) {
        this.table = tableElement;
        this.options = {
            sortable: true,
            filterable: true,
            paginated: false,
            pageSize: 10,
            responsive: true,
            ...options
        };

        this.currentSort = { column: null, direction: null };
        this.currentFilters = new Map();
        this.currentPage = 1;
        this.originalRows = [];

        this.init();
    }

    init() {
        this.setupResponsiveLabels();

        if (this.options.sortable) {
            this.initSorting();
        }

        if (this.options.filterable) {
            this.initFiltering();
        }

        if (this.options.paginated) {
            this.initPagination();
        }

        if (this.options.responsive) {
            this.initResponsiveBehavior();
        }

        this.storeOriginalRows();
    }

    // Setup responsive data labels for mobile card layout
    setupResponsiveLabels() {
        const headers = this.table.querySelectorAll('thead th');
        const rows = this.table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, index) => {
                if (headers[index]) {
                    const headerText = headers[index].textContent.trim();
                    cell.setAttribute('data-label', headerText);
                }
            });
        });
    }

    // Initialize sorting functionality
    initSorting() {
        const headers = this.table.querySelectorAll('thead th[data-sortable]');

        headers.forEach((header, index) => {
            header.classList.add('sortable-header');
            header.addEventListener('click', () => {
                this.sortByColumn(index, header);
            });
        });
    }

    sortByColumn(columnIndex, headerElement) {
        const tbody = this.table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        // Determine sort direction
        let direction = 'asc';
        if (this.currentSort.column === columnIndex) {
            direction = this.currentSort.direction === 'asc' ? 'desc' : 'asc';
        }

        // Update header classes
        this.table.querySelectorAll('thead th').forEach(th => {
            th.classList.remove('sort-asc', 'sort-desc');
        });
        headerElement.classList.add(`sort-${direction}`);

        // Sort rows
        rows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent.trim();
            const bValue = b.cells[columnIndex].textContent.trim();

            // Try to parse as numbers
            const aNum = parseFloat(aValue);
            const bNum = parseFloat(bValue);

            let comparison = 0;
            if (!isNaN(aNum) && !isNaN(bNum)) {
                comparison = aNum - bNum;
            } else {
                comparison = aValue.localeCompare(bValue, 'ja');
            }

            return direction === 'asc' ? comparison : -comparison;
        });

        // Reorder DOM
        rows.forEach(row => tbody.appendChild(row));

        // Update current sort state
        this.currentSort = { column: columnIndex, direction };
    }

    // Initialize filtering functionality
    initFiltering() {
        // Create filter controls if they don't exist
        this.createFilterControls();

        // Setup search input
        const searchInput = document.querySelector('.table-search .search-input');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.filterBySearch(e.target.value);
            });
        }

        // Setup filter selects
        const filterSelects = document.querySelectorAll('.table-search .filter-select');
        filterSelects.forEach((select, index) => {
            select.addEventListener('change', (e) => {
                this.filterByColumn(index, e.target.value);
            });
        });
    }

    createFilterControls() {
        if (document.querySelector('.table-controls')) return;

        const controlsHtml = `
            <div class="table-controls">
                <div class="table-search">
                    <input type="text" class="form-control search-input" placeholder="施設名で検索...">
                    <select class="form-select filter-select">
                        <option value="">すべての種別</option>
                        <option value="有料老人ホーム">有料老人ホーム</option>
                        <option value="グループホーム">グループホーム</option>
                        <option value="デイサービスセンター">デイサービスセンター</option>
                    </select>
                </div>
                <div class="table-actions">
                    <button class="btn btn-outline-primary btn-sm" onclick="window.dataTableUtils.exportTable('csv')">
                        CSV出力
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="window.dataTableUtils.resetFilters()">
                        フィルタリセット
                    </button>
                </div>
            </div>
        `;

        this.table.insertAdjacentHTML('beforebegin', controlsHtml);
    }

    filterBySearch(searchTerm) {
        const rows = this.table.querySelectorAll('tbody tr');
        const term = searchTerm.toLowerCase();

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const shouldShow = !term || text.includes(term);
            row.style.display = shouldShow ? '' : 'none';
        });

        this.updateRowCount();
    }

    filterByColumn(columnIndex, filterValue) {
        const rows = this.table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const cellValue = row.cells[columnIndex]?.textContent.trim();
            const shouldShow = !filterValue || cellValue === filterValue;

            // Only hide if not already hidden by search
            if (row.style.display !== 'none' || shouldShow) {
                row.style.display = shouldShow ? '' : 'none';
            }
        });

        this.updateRowCount();
    }

    resetFilters() {
        // Clear search input
        const searchInput = document.querySelector('.table-search .search-input');
        if (searchInput) searchInput.value = '';

        // Reset filter selects
        const filterSelects = document.querySelectorAll('.table-search .filter-select');
        filterSelects.forEach(select => select.value = '');

        // Show all rows
        const rows = this.table.querySelectorAll('tbody tr');
        rows.forEach(row => row.style.display = '');

        this.updateRowCount();
    }

    updateRowCount() {
        const totalRows = this.table.querySelectorAll('tbody tr').length;
        const visibleRows = this.table.querySelectorAll('tbody tr:not([style*="display: none"])').length;

        let countElement = document.querySelector('.table-row-count');
        if (!countElement) {
            countElement = document.createElement('div');
            countElement.className = 'table-row-count text-muted small mt-2';
            this.table.parentNode.appendChild(countElement);
        }

        countElement.textContent = `${visibleRows} / ${totalRows} 件表示`;
    }

    // Initialize responsive behavior
    initResponsiveBehavior() {
        this.handleResize();
        window.addEventListener('resize', () => this.handleResize());
    }

    handleResize() {
        const isDesktop = window.innerWidth >= 992;
        const isTablet = window.innerWidth >= 768 && window.innerWidth < 992;
        const isMobile = window.innerWidth < 768;

        // Update table classes based on screen size
        this.table.classList.toggle('desktop-view', isDesktop);
        this.table.classList.toggle('tablet-view', isTablet);
        this.table.classList.toggle('mobile-view', isMobile);

        // Handle column visibility
        if (isMobile) {
            this.hideColumnsForMobile();
        } else if (isTablet) {
            this.hideColumnsForTablet();
        } else {
            this.showAllColumns();
        }
    }

    hideColumnsForMobile() {
        const headers = this.table.querySelectorAll('th.hide-mobile');
        const cells = this.table.querySelectorAll('td.hide-mobile');

        [...headers, ...cells].forEach(el => {
            el.style.display = 'none';
        });
    }

    hideColumnsForTablet() {
        const headers = this.table.querySelectorAll('th.hide-tablet');
        const cells = this.table.querySelectorAll('td.hide-tablet');

        [...headers, ...cells].forEach(el => {
            el.style.display = 'none';
        });
    }

    showAllColumns() {
        const hiddenElements = this.table.querySelectorAll('[style*="display: none"]');
        hiddenElements.forEach(el => {
            if (el.tagName === 'TH' || el.tagName === 'TD') {
                el.style.display = '';
            }
        });
    }

    // Store original rows for reset functionality
    storeOriginalRows() {
        const rows = this.table.querySelectorAll('tbody tr');
        this.originalRows = Array.from(rows).map(row => row.cloneNode(true));
    }

    // Export functionality
    exportTable(format = 'csv') {
        const rows = Array.from(this.table.querySelectorAll('tr:not([style*="display: none"])'));

        if (format === 'csv') {
            this.exportToCSV(rows);
        }
    }

    exportToCSV(rows) {
        const csvContent = rows.map(row => {
            const cells = Array.from(row.querySelectorAll('th, td'));
            return cells.map(cell => {
                const text = cell.textContent.trim();
                // Escape quotes and wrap in quotes if contains comma
                return text.includes(',') ? `"${text.replace(/"/g, '""')}"` : text;
            }).join(',');
        }).join('\n');

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);

        link.setAttribute('href', url);
        link.setAttribute('download', `facility-data-${new Date().toISOString().split('T')[0]}.csv`);
        link.style.visibility = 'hidden';

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Loading state management
    showLoading() {
        this.table.classList.add('table-loading');
    }

    hideLoading() {
        this.table.classList.remove('table-loading');
    }

    // Empty state management
    showEmptyState(message = 'データがありません') {
        const tbody = this.table.querySelector('tbody');
        const colCount = this.table.querySelectorAll('thead th').length;

        tbody.innerHTML = `
            <tr class="table-empty-row">
                <td colspan="${colCount}" class="table-empty">
                    <div class="empty-icon">📋</div>
                    <div class="empty-title">データがありません</div>
                    <div class="empty-description">${message}</div>
                </td>
            </tr>
        `;
    }
}

// Auto-initialize data tables
document.addEventListener('DOMContentLoaded', () => {
    const dataTables = document.querySelectorAll('.data-table table, .facility-table');

    dataTables.forEach(table => {
        const options = {
            sortable: table.hasAttribute('data-sortable'),
            filterable: table.hasAttribute('data-filterable'),
            paginated: table.hasAttribute('data-paginated'),
            responsive: true
        };

        const dataTableInstance = new DataTableUtils(table, options);

        // Store instance globally for access from buttons
        if (!window.dataTableUtils) {
            window.dataTableUtils = dataTableInstance;
        }
    });
});

export default DataTableUtils;