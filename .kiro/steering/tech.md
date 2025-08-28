# Technology Stack & Build System

## Framework & Core Technologies
- **Backend**: Laravel 10.x (PHP 8.1+)
- **Frontend**: Bootstrap 5.3.x with Sass/SCSS
- **Build System**: Vite (Laravel Vite Plugin)
- **Database**: SQLite (development), supports MySQL/PostgreSQL
- **Authentication**: Laravel Sanctum + Custom Session-based Demo Auth

## Key Dependencies
### PHP (Composer)
- `laravel/framework: ^10.10`
- `laravel/sanctum: ^3.3` - API authentication
- `laravel/tinker: ^2.8` - REPL for debugging

### JavaScript (NPM)
- `bootstrap: ^5.3.8` - UI framework
- `@popperjs/core: ^2.11.8` - Bootstrap tooltips/dropdowns
- `sass: ^1.91.0` - CSS preprocessing
- `vite: ^5.0.0` - Build tool
- `axios: ^1.6.4` - HTTP client

## Development Commands

### Frontend Development
```bash
# Start development server with hot reload
npm run dev

# Build for production
npm run build

# Build static site (custom command)
npm run build:static
```

### Laravel Development
```bash
# Start development server
php artisan serve

# Clear application caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run database migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Generate application key
php artisan key:generate
```

### Testing
```bash
# Run PHPUnit tests
php artisan test
# or
./vendor/bin/phpunit
```

## Build Configuration
- **Vite Config**: `vite.config.js` - Asset compilation and hot reload
- **Composer**: `composer.json` - PHP dependencies and scripts
- **Package.json**: Frontend dependencies and build scripts

## Environment Setup
- Copy `.env.example` to `.env`
- Configure database connection (SQLite by default)
- Set `APP_KEY` using `php artisan key:generate`
- Run `composer install` and `npm install`