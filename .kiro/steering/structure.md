# Project Structure & Organization

## Laravel Application Structure

### Core Application (`app/`)
```
app/
├── Console/Commands/          # Artisan commands
├── Exceptions/Handler.php     # Global exception handling
├── Http/
│   ├── Controllers/          # Request handling logic
│   │   ├── Controller.php    # Base controller
│   │   ├── DashboardController.php
│   │   └── FacilityController.php
│   ├── Middleware/           # Request middleware
│   └── Kernel.php           # HTTP kernel configuration
├── Models/                   # Eloquent models
│   ├── Facility.php         # Main facility model with extensive attributes
│   ├── Department.php       # Department organization
│   ├── Region.php          # Regional organization
│   ├── User.php            # User management
│   └── [Other models]      # Approval, Comment, Role models
├── Providers/              # Service providers
└── Services/               # Business logic services
    └── RoleService.php     # Role management logic
```

### Database (`database/`)
```
database/
├── migrations/             # Database schema definitions
│   ├── *_create_users_table.php
│   ├── *_create_departments_table.php
│   ├── *_create_regions_table.php
│   └── *_create_facilities_table.php  # Main facility schema
├── seeders/               # Sample data generation
│   ├── DatabaseSeeder.php
│   ├── DepartmentSeeder.php
│   ├── RegionSeeder.php
│   └── FacilitySeeder.php
└── database.sqlite        # SQLite database file
```

### Frontend Resources (`resources/`)
```
resources/
├── css/app.css           # Compiled CSS output
├── js/
│   ├── app.js           # Main JavaScript entry
│   └── bootstrap.js     # Bootstrap configuration
├── sass/                # SCSS source files
│   ├── app.scss         # Main Sass entry
│   ├── _variables.scss  # Bootstrap variable overrides
│   └── _custom.scss     # Custom component styles
└── views/               # Blade templates
    ├── layouts/         # Layout templates
    ├── auth/           # Authentication views
    ├── facilities/     # Facility management views
    ├── partials/       # Reusable components
    └── dashboard.blade.php
```

### Configuration (`config/`)
Standard Laravel configuration files for app, database, auth, etc.

### Routes (`routes/`)
- `web.php` - Web routes with session-based authentication
- Facility resource routes with role-based access control

### Public Assets (`public/`)
```
public/
├── build/              # Compiled Vite assets
├── images/            # Static images
│   ├── marble-background.png
│   └── shise-cal-logo.png
└── index.php          # Application entry point
```

## Key Architectural Patterns

### Model Conventions
- Extensive use of `$fillable` arrays for mass assignment
- Eloquent relationships (BelongsTo, HasMany)
- Custom accessor methods for calculated fields
- Date casting for proper date handling
- Input validation examples as static methods

### Controller Patterns
- Resource controllers following Laravel conventions
- Role-based access control in controller methods
- Comprehensive validation with Japanese error messages
- Session-based user management for demo purposes

### View Organization
- Blade template inheritance with layouts
- Partial views for reusable components
- Bootstrap 5 component integration
- Japanese language support throughout UI

### Database Design
- Foreign key relationships between facilities, departments, regions
- Comprehensive facility data model with land/building details
- Soft deletes and status fields for data integrity
- Migration-based schema management

### Department Structure
The system uses the following department categories:
- 有料老人ホーム (Paid Nursing Homes)
- グループホーム (Group Homes)
- デイサービスセンター (Day Service Centers)
- 訪問看護ステーション (Visiting Nursing Stations)
- ヘルパーステーション (Helper Stations)
- ケアプランセンター (Care Plan Centers)
- 他（事務所など）(Others - Offices, etc.)