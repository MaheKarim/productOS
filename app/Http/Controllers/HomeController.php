<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\FooterSettings;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Fetch active sections ordered by their order
        $hero = HeroSection::active()->ordered()->first();
        $about = AboutSection::active()->ordered()->first();
        $services = Service::active()->ordered()->get();
        $projects = Project::active()->ordered()->get();
        $testimonials = Testimonial::active()->ordered()->get();
        $footer = FooterSettings::firstActive();

        return view('frontend.home', compact(
            'hero',
            'about',
            'services',
            'projects',
            'testimonials',
            'footer'
        ));
    }
}
