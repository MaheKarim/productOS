<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\Admin\DirectoryController as AdminDirectoryController;
use App\Http\Controllers\Admin\DirectoryCategoryController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
// Tools
Route::get('/tools', [ToolsController::class, 'index'])->name('tools.index');
Route::get('/tools/{category}', [ToolsController::class, 'category'])->name('tools.category');
Route::get('/tools/{category}/{tool}', [ToolsController::class, 'show'])->name('tools.show');

// Portfolio
Route::get('/portfolio', [CaseStudyController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [CaseStudyController::class, 'show'])->name('portfolio.show');

// Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Directory (Public)
Route::prefix('directory')->name('directory.')->group(function () {
    Route::get('/', [DirectoryController::class, 'index'])->name('index');
    Route::get('/search', [DirectoryController::class, 'search'])->name('search');
    Route::post('/track-click/{uuid}', [DirectoryController::class, 'trackClick'])->name('track-click');

    // Category Pages
    Route::get('/tools', [DirectoryController::class, 'tools'])->name('tools');
    Route::get('/learning', [DirectoryController::class, 'learning'])->name('learning');
    Route::get('/companies', [DirectoryController::class, 'companies'])->name('companies');
    Route::get('/communities', [DirectoryController::class, 'communities'])->name('communities');
    Route::get('/templates', [DirectoryController::class, 'templates'])->name('templates');
});

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Auth Routes
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// User Dashboard & Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes (Protected by auth and role:admin middleware)
use App\Http\Controllers\Admin\DashboardController;

// ...

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Hero
    Route::resource('hero', HeroController::class)->names('admin.hero');
    Route::post('hero/{hero}/toggle', [HeroController::class, 'toggle'])->name('admin.hero.toggle');

    // About
    Route::resource('about', AboutController::class)->names('admin.about');
    Route::post('about/{about}/toggle', [AboutController::class, 'toggle'])->name('admin.about.toggle');

    // Services
    Route::resource('services', ServiceController::class)->names('admin.services');
    Route::post('services/{service}/toggle', [ServiceController::class, 'toggle'])->name('admin.services.toggle');

    // Projects
    Route::resource('projects', ProjectController::class)->names('admin.projects');
    Route::post('projects/{project}/toggle', [ProjectController::class, 'toggle'])->name('admin.projects.toggle');

    // Testimonials
    Route::resource('testimonials', TestimonialController::class)->names('admin.testimonials');
    Route::post('testimonials/{testimonial}/toggle', [TestimonialController::class, 'toggle'])->name('admin.testimonials.toggle');

    // Footer
    Route::resource('footer', FooterController::class)->names('admin.footer');
    Route::post('footer/{footer}/toggle', [FooterController::class, 'toggle'])->name('admin.footer.toggle');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('admin.settings.update-profile');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('admin.settings.update-password');

    // Tools Management
    Route::resource('tools', \App\Http\Controllers\Admin\ToolsController::class)->names('admin.tools');
    Route::post('tools/{tool}/toggle', [\App\Http\Controllers\Admin\ToolsController::class, 'toggleStatus'])->name('admin.tools.toggle');

    // Directory Management
    Route::prefix('directory')->name('admin.directory.')->group(function () {
        Route::get('/dashboard', [AdminDirectoryController::class, 'dashboard'])->name('dashboard');
        Route::get('/analytics', [AdminDirectoryController::class, 'analytics'])->name('analytics');
        Route::get('/export', [AdminDirectoryController::class, 'export'])->name('export');

        // Toggles
        Route::patch('/{id}/toggle-active', [AdminDirectoryController::class, 'toggleActive'])->name('toggle-active');
        Route::patch('/{id}/toggle-featured', [AdminDirectoryController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::patch('/{id}/verify', [AdminDirectoryController::class, 'verify'])->name('verify');
        Route::post('/bulk-action', [AdminDirectoryController::class, 'bulkAction'])->name('bulk-action');

        // Categories
        Route::resource('categories', DirectoryCategoryController::class);
    });
    // Main Directory Resource
    Route::resource('directory', AdminDirectoryController::class)->names('admin.directory');

    // User Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');
    Route::patch('users/{user}/toggle', [\App\Http\Controllers\Admin\UserController::class, 'toggle'])->name('admin.users.toggle');
});

