# Portfolio CMS - Laravel Dynamic Homepage System

## Overview

A complete Laravel-based Content Management System (CMS) for managing a dynamic portfolio homepage with an admin backend.

## Features Implemented

### 1. Database Structure

Separate tables for each section with common fields:
- `hero_sections` - Hero section with stats, CTAs, and images
- `about_sections` - About section with philosophy and values
- `services` - Multiple service items with features
- `projects` - Portfolio/case studies with metrics
- `testimonials` - Customer testimonials with ratings
- `footer_settings` - Footer configuration with social links

### 2. Models Created

All models include:
- Mass assignable fields
- Type casting for boolean and JSON fields
- Scopes for `active()` and `ordered()`
- Accessor methods for image URLs
- Relationships where applicable

### 3. Form Requests

Validation rules for each section:
- Image validation (max 2MB, JPG/PNG/WebP)
- URL validation for links
- Required field validation
- Custom error messages

### 4. Admin Controllers

Full CRUD operations with:
- `index()` - List all items with pagination
- `create()` - Show create form
- `store()` - Validate and save new item
- `show()` - Display single item
- `edit()` - Show edit form
- `update()` - Validate and update item
- `destroy()` - Delete item and associated images
- `toggle()` - Quick enable/disable status

### 5. Admin Views

- **Layout** (`resources/views/admin/layout.blade.php`)
  - Sidebar navigation
  - Top bar with user info and logout
  - Flash messages for success/error
  - Validation error display

- **Dashboard** (`resources/views/admin/dashboard.blade.php`)
  - Overview cards for each section
  - Quick action buttons
  - Statistics counts

- **Hero Section Views**
  - `index.blade.php` - List with status toggle
  - `create.blade.php` - Full form with all fields
  - `edit.blade.php` - Edit form with current values

### 6. Frontend Views

- **Layout** (`resources/views/frontend/layout.blade.php`)
  - Includes header and footer
  - Tailwind CSS configuration
  - Smooth scroll animations

- **Section Partials**
  - `sections/header.blade.php` - Navigation header
  - `sections/hero.blade.php` - Dynamic hero section
  - `sections/footer.blade.php` - Dynamic footer

- **Home Page** (`resources/views/frontend/home.blade.php`)
  - Displays all active sections
  - Conditional rendering based on data availability
  - Contact section (static)

### 7. Routes

**Public Routes:**
- `/` - Homepage (HomeController@index)

**Admin Routes (protected by auth middleware):**
- `/admin/dashboard` - Admin dashboard
- `/admin/hero` - Hero CRUD
- `/admin/about` - About CRUD
- `/admin/services` - Services CRUD
- `/admin/projects` - Projects CRUD
- `/admin/testimonials` - Testimonials CRUD
- `/admin/footer` - Footer CRUD

## Setup Instructions

### Step 1: Run Migrations

```bash
php artisan migrate
```

### Step 2: Create Storage Link

```bash
php artisan storage:link
```

### Step 3: Configure Authentication (if not already set)

Choose one of the following:

**Option A: Laravel Breeze (Recommended)**
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
```

**Option B: Laravel Jetstream**
```bash
composer require laravel/jetstream
php artisan jetstream:install
```

**Option C: Custom Auth**
```bash
php artisan make:auth
```

### Step 4: Access Admin Panel

1. Register/login at `/login`
2. Navigate to `/admin/dashboard`
3. Start managing your homepage sections

## Admin Panel Features

- **Dashboard**: Overview of all sections with quick actions
- **Hero Management**: Create, edit, delete, toggle active status
- **About Management**: Manage about section content
- **Services Management**: CRUD for service items
- **Projects Management**: Portfolio management with metrics
- **Testimonials Management**: Customer feedback management
- **Footer Management**: Configure footer links and social media

## Frontend Features

- **Dynamic Sections**: Each section can be enabled/disabled independently
- **Ordering**: Sections display in specified order
- **Image Support**: Automatic image URL generation
- **Responsive**: Mobile-friendly design using Tailwind CSS
- **SEO Ready**: Meta title and description fields

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── HeroController.php
│   │   │   ├── AboutController.php
│   │   │   ├── ServiceController.php
│   │   │   ├── ProjectController.php
│   │   │   ├── TestimonialController.php
│   │   │   └── FooterController.php
│   │   └── HomeController.php
│   └── Requests/
│       ├── HeroSectionFormRequest.php
│       ├── AboutSectionFormRequest.php
│       ├── ServiceFormRequest.php
│       ├── ProjectFormRequest.php
│       ├── TestimonialFormRequest.php
│       └── FooterSettingsFormRequest.php
├── Models/
│   ├── HeroSection.php
│   ├── AboutSection.php
│   ├── Service.php
│   ├── Project.php
│   ├── Testimonial.php
│   └── FooterSettings.php
└── Providers/
    └── AppServiceProvider.php (add routes)

database/
└── migrations/
    ├── 2024_01_21_000001_create_hero_sections_table.php
    ├── 2024_01_21_000002_create_about_sections_table.php
    ├── 2024_01_21_000003_create_services_table.php
    ├── 2024_01_21_000004_create_projects_table.php
    ├── 2024_01_21_000005_create_testimonials_table.php
    └── 2024_01_21_000006_create_footer_settings_table.php

resources/
├── views/
│   ├── admin/
│   │   ├── layout.blade.php
│   │   ├── dashboard.blade.php
│   │   └── hero/
│   │       ├── index.blade.php
│   │       ├── create.blade.php
│   │       └── edit.blade.php
│   └── frontend/
│       ├── layout.blade.php
│       ├── home.blade.php
│       └── sections/
│           ├── header.blade.php
│           ├── hero.blade.php
│           └── footer.blade.php
routes/
└── web.php
```

## Security Notes

- All admin routes are protected by `auth` middleware
- Form requests include proper validation
- Image uploads are restricted to 2MB
- SQL injection protection via Eloquent ORM
- CSRF protection on all forms

## Future Enhancements

1. **Additional Admin Views**: Create views for About, Services, Projects, Testimonials, and Footer sections
2. **Role-Based Access**: Add Admin/Editor roles
3. **Image Optimization**: Add image compression on upload
4. **Rich Text Editor**: Integrate WYSIWYG editor for description fields
5. **Preview Mode**: Live preview of changes before publishing
6. **Version History**: Track changes with ability to rollback
7. **Multi-language Support**: Add localization support
8. **Export/Import**: Bulk export/import of content
9. **Analytics Integration**: Track section performance
10. **API Endpoints**: RESTful API for content management

## Troubleshooting

### Images not displaying
- Run `php artisan storage:link`
- Ensure `APP_URL` is correct in `.env`
- Check file permissions in `storage/app/public`

### Auth not working
- Ensure authentication is properly configured
- Check middleware in routes
- Clear cache: `php artisan cache:clear`

### Database errors
- Run migrations: `php artisan migrate:fresh --seed`
- Check database credentials in `.env`
- Ensure MySQL service is running

## License

This CMS is built for portfolio management and can be freely used and modified.

## Support

For issues or questions, refer to Laravel documentation: https://laravel.com/docs
