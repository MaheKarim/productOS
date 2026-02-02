<?php

namespace App\Http\Controllers;

use App\Models\SupportSection;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('about');
    }

    public function services()
    {
        return view('services');
    }

    public function contact()
    {
        $supportSection = SupportSection::firstActive();
        return view('contact', compact('supportSection'));
    }
}
