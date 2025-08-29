import './bootstrap';

// Import our custom Sass
import '../sass/app.scss';

// Import form utilities
import './form-utilities';

// Custom JavaScript for the application
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Bootstrap components
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Initialize Bootstrap dropdowns
    const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    const dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });

    // Handle logout form submission
    const logoutForm = document.getElementById('logout-form');
    if (logoutForm) {
        logoutForm.addEventListener('submit', function (e) {
            console.log('Logout form submitted');
        });
    }

    // File upload drag and drop functionality
    const fileUploadAreas = document.querySelectorAll('.file-upload-area');
    fileUploadAreas.forEach(area => {
        area.addEventListener('dragover', function (e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        area.addEventListener('dragleave', function (e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        area.addEventListener('drop', function (e) {
            e.preventDefault();
            this.classList.remove('dragover');
            // Handle file drop logic here
        });
    });

    // Form validation enhancement
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Sidebar toggle functionality for responsive behavior
    const sidebarToggle = document.querySelector('[data-bs-toggle="offcanvas"]');
    const sidebar = document.querySelector('.shise-sidebar');
    const content = document.querySelector('.shise-content');
    let sidebarBackdrop = null;

    function createBackdrop() {
        if (!sidebarBackdrop) {
            sidebarBackdrop = document.createElement('div');
            sidebarBackdrop.className = 'sidebar-backdrop';
            document.body.appendChild(sidebarBackdrop);

            sidebarBackdrop.addEventListener('click', closeSidebar);
        }
    }

    function showSidebar() {
        if (window.innerWidth <= 991.98) {
            createBackdrop();
            sidebar.classList.add('show');
            sidebarBackdrop.classList.add('show');
            content.classList.add('sidebar-open');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeSidebar() {
        sidebar.classList.remove('show');
        if (sidebarBackdrop) {
            sidebarBackdrop.classList.remove('show');
        }
        content.classList.remove('sidebar-open');
        document.body.style.overflow = '';
    }

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function (e) {
            e.preventDefault();
            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                showSidebar();
            }
        });
    }

    // Handle window resize to close sidebar on desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth > 991.98) {
            closeSidebar();
        }
    });

    // Keyboard shortcuts for desktop usage
    if (window.innerWidth >= 992) {
        document.addEventListener('keydown', function (e) {
            // Alt + S to toggle sidebar (desktop only)
            if (e.altKey && e.key === 's') {
                e.preventDefault();
                if (sidebarToggle) {
                    sidebarToggle.click();
                }
            }

            // Escape to close any open overlays
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });

        // Show keyboard shortcuts hint on Alt key press
        let keyboardHints = null;
        document.addEventListener('keydown', function (e) {
            if (e.altKey && !keyboardHints) {
                keyboardHints = document.createElement('div');
                keyboardHints.className = 'keyboard-shortcuts show';
                keyboardHints.innerHTML = `
                    <div class="shortcut-item">
                        <span>Toggle Sidebar</span>
                        <span class="key">Alt + S</span>
                    </div>
                    <div class="shortcut-item">
                        <span>Close Overlays</span>
                        <span class="key">Esc</span>
                    </div>
                `;
                document.body.appendChild(keyboardHints);
            }
        });

        document.addEventListener('keyup', function (e) {
            if (!e.altKey && keyboardHints) {
                keyboardHints.remove();
                keyboardHints = null;
            }
        });
    }
});
