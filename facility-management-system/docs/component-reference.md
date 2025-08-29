# Component Reference Guide

## Button Components

### Primary Button
**Usage**: Main actions, form submissions
```html
<button class="btn btn-primary">
    <i class="bi bi-check-circle me-2"></i>Save
</button>
```

### Secondary Button
**Usage**: Secondary actions, alternative options
```html
<button class="btn btn-secondary">
    <i class="bi bi-gear me-2"></i>Settings
</button>
```

### Outline Button
**Usage**: Less prominent actions, cancel buttons
```html
<button class="btn btn-outline-primary">
    <i class="bi bi-arrow-left me-2"></i>Back
</button>
```

### Button Sizes
```html
<!-- Small -->
<button class="btn btn-primary btn-sm">Small</button>

<!-- Default -->
<button class="btn btn-primary">Default</button>

<!-- Large -->
<button class="btn btn-primary btn-lg">Large</button>
```

### Button States
```html
<!-- Normal -->
<button class="btn btn-primary">Normal</button>

<!-- Disabled -->
<button class="btn btn-primary" disabled>Disabled</button>

<!-- Loading (with spinner) -->
<button class="btn btn-primary" disabled>
    <span class="spinner-border spinner-border-sm me-2"></span>
    Loading...
</button>
```

## Form Components

### Basic Input
```html
<div class="mb-3">
    <label for="basic-input" class="form-label">Label</label>
    <input type="text" class="form-control" id="basic-input" placeholder="Enter text">
</div>
```

### Required Input
```html
<div class="mb-3">
    <label for="required-input" class="form-label">
        Required Field <span class="text-danger">*</span>
    </label>
    <input type="text" class="form-control" id="required-input" required>
</div>
```

### Input with Validation
```html
<div class="mb-3">
    <label for="validated-input" class="form-label">Validated Input</label>
    <input type="email" class="form-control is-invalid" id="validated-input">
    <div class="invalid-feedback">Please provide a valid email address.</div>
</div>

<div class="mb-3">
    <label for="valid-input" class="form-label">Valid Input</label>
    <input type="email" class="form-control is-valid" id="valid-input">
    <div class="valid-feedback">Looks good!</div>
</div>
```

### Select Dropdown
```html
<div class="mb-3">
    <label for="select-input" class="form-label">Select Option</label>
    <select class="form-select" id="select-input">
        <option value="">Choose...</option>
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
    </select>
</div>
```

### Textarea
```html
<div class="mb-3">
    <label for="textarea-input" class="form-label">Description</label>
    <textarea class="form-control" id="textarea-input" rows="3" placeholder="Enter description"></textarea>
</div>
```

### Form Toggle System
**Usage**: Switch between display and edit modes
```html
<div class="form-toggle-container">
    <label class="form-label">Facility Name</label>
    <div class="form-display">Current Facility Name</div>
    <div class="form-edit">
        <input type="text" class="form-control" name="facility_name" value="Current Facility Name">
    </div>
</div>
```

### Auto-calculated Field
**Usage**: Fields that are automatically calculated from other inputs
```html
<div class="auto-calculated-field" data-calculation="operating-years" data-depends-on="input[name='opening_date']">
    <label class="form-label">Operating Years (Auto-calculated)</label>
    <div class="form-display text-info">5 years</div>
</div>
```

## Card Components

### Basic Card
```html
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Card Title</h5>
    </div>
    <div class="card-body">
        <p class="card-text">Card content goes here.</p>
    </div>
</div>
```

### Dashboard Statistics Card
```html
<div class="card dashboard-card border-left-primary shadow h-100 py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total Facilities
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">42</div>
            </div>
            <div class="col-auto">
                <i class="bi bi-building text-primary" style="font-size: 2rem;"></i>
            </div>
        </div>
    </div>
</div>
```

### Card Variants
```html
<!-- Success Card -->
<div class="card dashboard-card border-left-success shadow h-100 py-2">...</div>

<!-- Warning Card -->
<div class="card dashboard-card border-left-warning shadow h-100 py-2">...</div>

<!-- Info Card -->
<div class="card dashboard-card border-left-info shadow h-100 py-2">...</div>

<!-- Danger Card -->
<div class="card dashboard-card border-left-danger shadow h-100 py-2">...</div>
```

### Welcome Card
```html
<div class="card dashboard-welcome shadow-sm">
    <div class="card-body">
        <div class="welcome-layout">
            <div class="welcome-content">
                <h5 class="welcome-greeting">
                    <i class="bi bi-person-circle"></i>
                    <span>Welcome back, User Name</span>
                </h5>
                <p class="welcome-details">
                    <span class="role-badge role-admin">Administrator</span>
                    <span class="login-time">Last login: 2024-01-15 09:30</span>
                </p>
            </div>
        </div>
    </div>
</div>
```

## Alert Components

### Basic Alerts
```html
<div class="alert alert-primary">
    <i class="bi bi-info-circle me-2"></i>
    Primary alert message
</div>

<div class="alert alert-success">
    <i class="bi bi-check-circle me-2"></i>
    Success alert message
</div>

<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle me-2"></i>
    Warning alert message
</div>

<div class="alert alert-danger">
    <i class="bi bi-exclamation-triangle me-2"></i>
    Danger alert message
</div>

<div class="alert alert-info">
    <i class="bi bi-info-circle me-2"></i>
    Info alert message
</div>
```

### Dismissible Alert
```html
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>
    Success message with dismiss button
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
```

### System Notification Alert
```html
<div class="alert alert-info">
    <div class="d-flex align-items-start">
        <i class="bi bi-info-circle"></i>
        <div>
            <strong>System Notification</strong> - 2 weeks ago<br>
            <small class="text-muted">Detailed notification message goes here.</small>
        </div>
    </div>
</div>
```

## Navigation Components

### Sidebar Navigation
```html
<nav class="shise-sidebar">
    <div class="shise-nav">
        <div class="nav-header">Main Menu</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="bi bi-house-door"></i>Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-building"></i>Facilities
                </a>
            </li>
        </ul>
    </div>
</nav>
```

### Tab Navigation
```html
<ul class="nav nav-tabs facility-tabs mb-4">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#basic">
            <i class="bi bi-info-circle me-2"></i>Basic Info
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#land">
            <i class="bi bi-geo-alt me-2"></i>Land Info
        </button>
    </li>
</ul>
```

### Breadcrumb Navigation
```html
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Facilities</a></li>
        <li class="breadcrumb-item active" aria-current="page">Facility Details</li>
    </ol>
</nav>
```

## Table Components

### Basic Data Table
```html
<div class="table-responsive">
    <table class="table data-table table-hover">
        <thead class="table-light">
            <tr>
                <th>Column 1</th>
                <th>Column 2</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Data 1</td>
                <td>Data 2</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary">Edit</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

### Responsive Table with Hidden Columns
```html
<div class="table-responsive">
    <table class="table data-table table-hover">
        <thead class="table-light">
            <tr>
                <th>Always Visible</th>
                <th class="d-none-tablet">Hidden on Tablet</th>
                <th class="d-none-mobile">Hidden on Mobile</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="Always Visible">Data</td>
                <td data-label="Hidden on Tablet" class="d-none-tablet">Data</td>
                <td data-label="Hidden on Mobile" class="d-none-mobile">Data</td>
            </tr>
        </tbody>
    </table>
</div>
```

### Clickable Table Rows
```html
<table class="table data-table table-hover">
    <tbody>
        <tr class="facility-row" data-href="/facilities/1" style="cursor: pointer;">
            <td><code class="text-primary fw-bold">FAC001</code></td>
            <td><strong class="text-dark">Facility Name</strong></td>
        </tr>
    </tbody>
</table>
```

## Layout Components

### Header Layout
```html
<header class="shise-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="shise-logo">
                <a href="/">
                    <img src="logo.png" alt="Logo" class="logo-image">
                    <div class="logo-fallback">
                        <span class="logo-text">Shise-Cal</span>
                    </div>
                </a>
            </div>
            <div class="approver-section">
                <button class="btn approver-btn dropdown-toggle" data-bs-toggle="dropdown">
                    User Name
                </button>
            </div>
        </div>
    </div>
</header>
```

### Page Header with Actions
```html
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Current Page</li>
            </ol>
        </nav>
        <h1 class="h3 mb-0">
            <i class="bi bi-building me-2"></i>Page Title
        </h1>
    </div>
    
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary">Secondary Action</button>
        <button class="btn btn-primary">Primary Action</button>
    </div>
</div>
```

### Search and Filter Section
```html
<div class="card mb-4 facility-search">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-search me-2"></i>Search & Filter
        </h5>
    </div>
    <div class="card-body">
        <form>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Department</label>
                    <select class="form-select">
                        <option value="">All Departments</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Facility Name</label>
                    <input type="text" class="form-control" placeholder="Search by name">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search me-2"></i>Search
                    </button>
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
```

## Accordion Components

### Basic Accordion
```html
<div class="accordion facility-accordion">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                <i class="bi bi-lightning-charge me-2"></i>Section Title
            </button>
        </h2>
        <div id="collapse1" class="accordion-collapse collapse show">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <!-- Form fields -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

## Badge Components

### Role Badges
```html
<span class="role-badge role-admin">Administrator</span>
<span class="role-badge role-editor">Editor</span>
<span class="role-badge role-viewer">Viewer</span>
```

### Status Badges
```html
<span class="badge bg-success">Active</span>
<span class="badge bg-warning">Pending</span>
<span class="badge bg-danger">Inactive</span>
<span class="badge bg-info">Info</span>
```

### Service Type Badges
```html
<span class="badge bg-info me-1">Day Service</span>
<span class="badge bg-info me-1">Home Care</span>
<span class="badge bg-info me-1">Nursing Care</span>
```

## Loading States

### Button Loading State
```html
<button class="btn btn-primary" disabled>
    <span class="spinner-border spinner-border-sm me-2"></span>
    Loading...
</button>
```

### Card Loading State
```html
<div class="card">
    <div class="card-body text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Loading data...</p>
    </div>
</div>
```

## Empty States

### No Data State
```html
<div class="text-center py-5">
    <i class="bi bi-building text-muted" style="font-size: 3rem;"></i>
    <h5 class="text-muted mt-3">No facilities found</h5>
    <p class="text-muted">Try adjusting your search criteria.</p>
    <button class="btn btn-primary">Add New Facility</button>
</div>
```

### No Activities State
```html
<div class="empty-state">
    <i class="bi bi-inbox"></i>
    <p>No recent activities</p>
</div>
```

## Utility Classes

### Spacing Utilities
```html
<!-- Margin -->
<div class="m-0">No margin</div>
<div class="m-1">Small margin (4px)</div>
<div class="m-2">Medium margin (8px)</div>
<div class="m-4">Large margin (16px)</div>

<!-- Padding -->
<div class="p-0">No padding</div>
<div class="p-1">Small padding (4px)</div>
<div class="p-2">Medium padding (8px)</div>
<div class="p-4">Large padding (16px)</div>

<!-- Specific sides -->
<div class="mt-3">Top margin</div>
<div class="mb-3">Bottom margin</div>
<div class="ms-2">Start margin (left in LTR)</div>
<div class="me-2">End margin (right in LTR)</div>
```

### Color Utilities
```html
<!-- Text colors -->
<span class="text-primary">Primary text</span>
<span class="text-success">Success text</span>
<span class="text-warning">Warning text</span>
<span class="text-danger">Danger text</span>
<span class="text-info">Info text</span>
<span class="text-muted">Muted text</span>

<!-- Background colors -->
<div class="bg-primary text-white">Primary background</div>
<div class="bg-light">Light background</div>
```

### Typography Utilities
```html
<!-- Font weights -->
<span class="fw-normal">Normal weight</span>
<span class="fw-bold">Bold weight</span>
<span class="fw-semibold">Semibold weight</span>

<!-- Font sizes -->
<span class="fs-1">Largest</span>
<span class="fs-6">Smallest</span>

<!-- Text alignment -->
<div class="text-start">Left aligned</div>
<div class="text-center">Center aligned</div>
<div class="text-end">Right aligned</div>
```

### Display Utilities
```html
<!-- Display -->
<div class="d-none">Hidden</div>
<div class="d-block">Block</div>
<div class="d-flex">Flex</div>

<!-- Responsive display -->
<div class="d-none d-md-block">Hidden on mobile, visible on tablet+</div>
<div class="d-block d-md-none">Visible on mobile, hidden on tablet+</div>
```

This component reference provides practical examples for implementing the design system components in your Blade templates.