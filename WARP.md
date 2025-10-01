# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Common Development Commands

### Server and Development
- `composer dev` - Start full development environment (server, queue, logs, vite)
- `php artisan serve` - Start Laravel development server only
- `npm run dev` - Start Vite development server for frontend assets
- `npm run build` - Build production assets

### Testing
- `composer test` - Run PHPUnit tests with configuration clearing
- `php artisan test` - Run tests directly via Artisan
- `vendor/bin/phpunit` - Run specific test files or groups

### Code Quality
- `vendor/bin/pint` - Format code using Laravel Pint (configured in composer.json)
- `php artisan config:clear` - Clear configuration cache
- `php artisan route:clear` - Clear route cache

### Database Operations
- `php artisan migrate` - Run database migrations
- `php artisan migrate:fresh --seed` - Fresh migration with seeding
- `php artisan db:seed` - Run database seeders

## Project Architecture

### Technology Stack
- **Laravel 12** - Core framework using PHP 8.2+
- **Filament 4.0** - Admin panel framework for backend management
- **Laravel Breeze 2.3** - Authentication scaffolding for user login
- **Vite** - Frontend build tool with Tailwind CSS
- **SQLite** - Default database (see .env.example)

### Application Structure

#### User System & Authentication
- **Two-tier user system**: Regular users and admin users
- Users have `is_admin` boolean field determining access level
- Regular users earn points (20 initial points on registration)
- WhatsApp number (`no_wa`) field for customer contact
- Authentication handled by Laravel Breeze at `/login`

#### Admin Panel Architecture
- **Filament Admin Panel** at `/admin` path
- Custom `EnsureUserIsAdmin` middleware protects admin routes
- Brand name: "Coffee Shop Admin" with amber color scheme
- Admin access requires both authentication and `is_admin = true`

#### Product Management
- Products have categories: 'makanan' (food) or 'minuman' (drinks)
- Decimal pricing (10,2 precision)
- Optional photo uploads
- Managed through Filament resources with full CRUD operations

#### Filament Resources Structure
```
app/Filament/
├── Resources/
│   ├── Products/
│   │   ├── ProductResource.php (main resource)
│   │   ├── Pages/ (Create, Edit, List)
│   │   ├── Schemas/ (form definitions)
│   │   └── Tables/ (table configurations)
│   └── Users/
│       └── UserResource.php
├── Widgets/
│   ├── StatsOverview.php (dashboard statistics)
│   └── UsersChart.php (6-month user growth)
└── Providers/
    └── AdminPanelProvider.php (panel configuration)
```

### Key Middleware
- `EnsureUserIsAdmin` - Redirects non-admin users to `/login` with intended URL
- Standard Laravel middleware stack in admin panel

### Database Schema Highlights
- **Users**: Extended with `no_wa`, `points`, and `is_admin` fields  
- **Products**: Category enum, title, description, decimal price, optional photo
- Uses SQLite by default (database queue and cache drivers)

## Development Notes

### Admin Panel Features
- Dashboard with user/product statistics and growth charts
- Full user management (regular users get 20 points on creation)
- Product CRUD with category filtering
- File upload support for product photos
- Admin-only access with proper authentication flow

### Frontend Integration
- Tailwind CSS with Alpine.js for interactive components
- Laravel Vite plugin for asset compilation
- Form components with `@tailwindcss/forms` plugin

### Authentication Flow
- Users login via Laravel Breeze at `/login`
- Admin users can access `/admin` panel after authentication
- Non-admin access to admin routes redirects to login with intended URL
- Admin panel uses custom middleware rather than Filament's built-in auth

### Testing Configuration
- PHPUnit configured for Feature and Unit tests
- Uses in-memory SQLite for testing
- Test environment configured in phpunit.xml
