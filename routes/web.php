<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CareerCompassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SystemSettingsController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\Admin\DirectoryController as AdminDirectoryController;
use App\Http\Controllers\Admin\DirectoryCategoryController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Career Compass Tool (before generic tools routes)
Route::prefix('tools/career-compass')->name('career-compass.')->group(function () {
    Route::get('/', [CareerCompassController::class, 'index'])->name('index');
    Route::get('/assess', [CareerCompassController::class, 'assess'])->name('assess');
    Route::get('/results/{id?}', [CareerCompassController::class, 'results'])->name('results');
    Route::get('/download-pdf/{id?}', [CareerCompassController::class, 'downloadPdf'])->name('download-pdf'); // Added PDF download route
    Route::get('/history', [CareerCompassController::class, 'history'])
        ->middleware('auth')->name('history');
});

// Strategic Roadmap - Public Landing Page (must be before generic /tools/{category}/{tool})
Route::get('/tools/strategic-roadmap', [\App\Http\Controllers\StrategicRoadmapController::class, 'publicLanding'])->name('strategic-roadmap.landing');

// Tools
Route::get('/tools', [ToolsController::class, 'index'])->name('tools.index');
Route::get('/tools/{category}', [ToolsController::class, 'category'])->name('tools.category');
Route::get('/tools/{category}/{tool}', [ToolsController::class, 'show'])->name('tools.show');

// Book Library (Public)
Route::controller(\App\Http\Controllers\BookLibraryController::class)->prefix('books')->name('books.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{slug}', 'show')->name('show');
});

// Portfolio
Route::get('/portfolio', [CaseStudyController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [CaseStudyController::class, 'show'])->name('portfolio.show');

// Prompt Library (Public)
Route::prefix('prompts')->name('prompts.')->group(function () {
    Route::get('/', [\App\Http\Controllers\PromptLibraryController::class, 'index'])->name('index');
    Route::get('/{slug}', [\App\Http\Controllers\PromptLibraryController::class, 'show'])->name('show');
    Route::post('/{id}/copy', [\App\Http\Controllers\PromptLibraryController::class, 'trackCopy'])->name('copy');
});

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


// Onboarding Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/complete-profile', [\App\Http\Controllers\UserOnboardingController::class, 'create'])->name('onboarding.create');
    Route::post('/complete-profile', [\App\Http\Controllers\UserOnboardingController::class, 'store'])->name('onboarding.store');
});

// User Dashboard & Profile
Route::middleware(['auth', 'onboarding'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');

    // User YT Summarize
    Route::prefix('my/yt-summarize')->name('user.yt-summarize.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\YTSummarizeController::class, 'index'])->name('index');
        Route::get('/{video}', [\App\Http\Controllers\User\YTSummarizeController::class, 'show'])->name('show');
    });

    // Strategic Roadmap Generator
    Route::prefix('my/strategic-roadmap')->name('user.strategic-roadmap.')->group(function () {
        Route::get('/', [\App\Http\Controllers\StrategicRoadmapController::class, 'index'])->name('index');
        Route::get('/quick-start', [\App\Http\Controllers\StrategicRoadmapController::class, 'quickStart'])->name('quick-start');
        Route::get('/advanced', [\App\Http\Controllers\StrategicRoadmapController::class, 'advancedInput'])->name('advanced');
        Route::post('/quick-start', [\App\Http\Controllers\StrategicRoadmapController::class, 'storeQuickInput']);
        Route::post('/advanced', [\App\Http\Controllers\StrategicRoadmapController::class, 'storeAdvancedInput']);
        Route::get('/results/{id?}', [\App\Http\Controllers\StrategicRoadmapController::class, 'results'])->name('results');
        Route::get('/history', [\App\Http\Controllers\StrategicRoadmapController::class, 'history'])->name('history');
        Route::post('/progress', [\App\Http\Controllers\StrategicRoadmapController::class, 'updateProgress'])->name('progress');
        Route::post('/metric', [\App\Http\Controllers\StrategicRoadmapController::class, 'updateMetric'])->name('metric');
    });

    // Resume Builder
    Route::prefix('my/resume-builder')->name('resume-builder.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ResumeBuilderController::class, 'index'])->name('index');
        Route::post('/upload', [\App\Http\Controllers\ResumeBuilderController::class, 'upload'])->name('upload');
        Route::post('/generate', [\App\Http\Controllers\ResumeBuilderController::class, 'generate'])->name('generate');
        Route::get('/download/{format}', [\App\Http\Controllers\ResumeBuilderController::class, 'download'])->name('download');
    });

    // Interview Preparation
    Route::prefix('my/interview-prep')->name('user.interview-prep.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\InterviewPrepController::class, 'index'])->name('index');
        Route::post('/start', [\App\Http\Controllers\User\InterviewPrepController::class, 'startPractice'])->name('start');
        Route::get('/practice/{session}', [\App\Http\Controllers\User\InterviewPrepController::class, 'practice'])->name('practice');
        Route::post('/grade/{question}', [\App\Http\Controllers\User\InterviewPrepController::class, 'gradeAnswer'])->name('grade'); // Added grading route
        Route::post('/submit/{session}', [\App\Http\Controllers\User\InterviewPrepController::class, 'submitAnswer'])->name('submit'); // Added submit route
        Route::get('/end/{session}', [\App\Http\Controllers\User\InterviewPrepController::class, 'endSession'])->name('end');
    });
});

// Public Roadmap
Route::get('/roadmap', [\App\Http\Controllers\RoadmapController::class, 'index'])->name('roadmap.index');
Route::post('/roadmap/status', [\App\Http\Controllers\RoadmapController::class, 'updateStatus'])
    ->middleware('auth')
    ->name('roadmap.update-status');

// YT Summarize (Public)
Route::prefix('yt-summarize')->name('yt-summarize.')->group(function () {
    Route::get('/', [\App\Http\Controllers\YTSummarizeController::class, 'index'])->name('index');
    Route::get('/{video}', [\App\Http\Controllers\YTSummarizeController::class, 'show'])->name('show');
});

// Admin Routes (Protected by auth and role:admin middleware)
use App\Http\Controllers\Admin\DashboardController;

// ...

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Analytics & Charts API
    Route::get('/analytics/user-registrations', [DashboardController::class, 'getUserRegistrationData'])->name('admin.analytics.user-registrations');
    Route::get('/analytics/credit-consumption', [DashboardController::class, 'getCreditConsumptionData'])->name('admin.analytics.credit-consumption');
    Route::get('/analytics/metrics', [DashboardController::class, 'getDashboardMetrics'])->name('admin.analytics.metrics');

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
    // Profile Management
    Route::get('/profile', [SettingsController::class, 'index'])->name('admin.profile.index');
    Route::put('/profile/profile', [SettingsController::class, 'updateProfile'])->name('admin.profile.update-profile');
    Route::put('/profile/password', [SettingsController::class, 'updatePassword'])->name('admin.profile.update-password');

    // System Settings (Global)
    Route::get('/settings', [SystemSettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SystemSettingsController::class, 'update'])->name('admin.settings.update');

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

    // Prompt Library Management
    Route::resource('prompts', \App\Http\Controllers\Admin\PromptController::class)->names('admin.prompts');
    Route::post('prompts/{prompt}/toggle', [\App\Http\Controllers\Admin\PromptController::class, 'toggleStatus'])->name('admin.prompts.toggle');
    Route::post('prompts/{prompt}/feature', [\App\Http\Controllers\Admin\PromptController::class, 'toggleFeatured'])->name('admin.prompts.feature');
    Route::post('prompts/{prompt}/duplicate', [\App\Http\Controllers\Admin\PromptController::class, 'duplicate'])->name('admin.prompts.duplicate');

    // PM Roadmap Management
    Route::resource('roadmap', \App\Http\Controllers\Admin\RoadmapController::class, ['parameters' => ['roadmap' => 'topic']])->names('admin.roadmap');

    // Strategic Roadmap Sessions (User Generated)
    Route::post('strategic-roadmap/settings', [\App\Http\Controllers\Admin\StrategicRoadmapController::class, 'updateSettings'])->name('admin.strategic-roadmap.settings');
    Route::resource('strategic-roadmap', \App\Http\Controllers\Admin\StrategicRoadmapController::class)->names('admin.strategic-roadmap');

    // AI Provider Management
    Route::get('ai-providers/health', [\App\Http\Controllers\Admin\AiHealthController::class, 'index'])->name('admin.ai-providers.health');
    Route::get('ai-providers/health/chart-data', [\App\Http\Controllers\Admin\AiHealthController::class, 'chartData'])->name('admin.ai-providers.health.data');
    Route::resource('ai-providers', \App\Http\Controllers\Admin\AiProviderController::class)->names('admin.ai-providers');
    Route::patch('ai-providers/{provider}/toggle', [\App\Http\Controllers\Admin\AiProviderController::class, 'toggleActive'])->name('admin.ai-providers.toggle');
    Route::patch('ai-providers/{provider}/set-default', [\App\Http\Controllers\Admin\AiProviderController::class, 'setDefault'])->name('admin.ai-providers.set-default');
    Route::post('ai-providers/{provider}/test', [\App\Http\Controllers\Admin\AiProviderController::class, 'testConnection'])->name('admin.ai-providers.test');
    Route::get('ai-providers/{provider}/models', [\App\Http\Controllers\Admin\AiProviderController::class, 'models'])->name('admin.ai-providers.models');
    Route::post('ai-providers/{provider}/models', [\App\Http\Controllers\Admin\AiProviderController::class, 'storeModel'])->name('admin.ai-providers.models.store');
    Route::delete('ai-providers/{provider}/models/{model}', [\App\Http\Controllers\Admin\AiProviderController::class, 'destroyModel'])->name('admin.ai-providers.models.destroy');

    // Video Analysis Management
    Route::get('/videos', \App\Livewire\Admin\VideoList::class)->name('admin.videos.index');
    Route::get('/videos/upload', \App\Livewire\Admin\VideoUpload::class)->name('admin.videos.upload');
    Route::get('/videos/{video}', \App\Livewire\Admin\VideoDetail::class)->name('admin.videos.show');

    // YouTube Content Generation
    Route::post('/youtube-content/generate', [\App\Http\Controllers\Admin\YouTubeContentController::class, 'generate'])->name('admin.youtube-content.generate');

    // System Settings
    Route::get('/settings/prompts', \App\Livewire\Admin\Settings\SystemPrompts::class)->name('admin.settings.prompts');

    // Onboarding Settings
    Route::get('/settings/onboarding', [\App\Http\Controllers\Admin\OnboardingSettingsController::class, 'index'])->name('admin.onboarding.index');
    Route::post('/settings/onboarding', [\App\Http\Controllers\Admin\OnboardingSettingsController::class, 'update'])->name('admin.onboarding.update');

    // Book Management
    Route::resource('books', \App\Http\Controllers\Admin\BookController::class)->names('admin.books');
    Route::post('books/{book}/process', [\App\Http\Controllers\Admin\BookController::class, 'process'])->name('admin.books.process');
    Route::post('books/{book}/retry', [\App\Http\Controllers\Admin\BookController::class, 'process'])->name('admin.books.retry');
    Route::post('books/{book}/toggle', [\App\Http\Controllers\Admin\BookController::class, 'toggleStatus'])->name('admin.books.toggle');

    // Support Section Management
    Route::get('support-section', [\App\Http\Controllers\Admin\SupportSectionController::class, 'index'])->name('admin.support-section.index');
    Route::post('support-section', [\App\Http\Controllers\Admin\SupportSectionController::class, 'store'])->name('admin.support-section.store');
    Route::post('support-section/{support}/toggle', [\App\Http\Controllers\Admin\SupportSectionController::class, 'toggle'])->name('admin.support-section.toggle');
    Route::delete('support-section/remove-image', [\App\Http\Controllers\Admin\SupportSectionController::class, 'removeImage'])->name('admin.support-section.remove-image');

    // Question Bank Management
    Route::resource('question-categories', \App\Http\Controllers\Admin\QuestionCategoryController::class)->names('admin.question-categories');
    Route::resource('questions', \App\Http\Controllers\Admin\QuestionController::class)->names('admin.questions');
    Route::patch('questions/{question}/toggle', [\App\Http\Controllers\Admin\QuestionController::class, 'toggleActive'])->name('admin.questions.toggle');
    // Features Management
    // Features Management
    Route::get('features', [\App\Http\Controllers\Admin\FeatureController::class, 'index'])->name('admin.features.index');
    Route::put('features/{feature}', [\App\Http\Controllers\Admin\FeatureController::class, 'update'])->name('admin.features.update');

    // Activity Logs
    Route::get('activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
});

