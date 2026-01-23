<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\FooterSettings;
use App\Models\DirectoryItem;
use App\Models\DirectoryClick;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            // CMS Stats
            'hero' => HeroSection::count(),
            'about' => AboutSection::count(),
            'services' => Service::count(),
            'projects' => Project::count(),
            'testimonials' => Testimonial::count(),
            'footer' => FooterSettings::count(),

            // Directory Stats
            'directory_items' => DirectoryItem::count(),
            'directory_pending' => DirectoryItem::where('verification_status', 'pending')->count(),
            'directory_clicks' => DirectoryClick::whereMonth('clicked_at', now()->month)->count(),
            'directory_featured' => DirectoryItem::where('is_featured', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
