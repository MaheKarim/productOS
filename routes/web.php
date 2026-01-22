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

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tools', [ToolsController::class, 'index'])->name('tools');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes (Protected by auth middleware)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

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
});

