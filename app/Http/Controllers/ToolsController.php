<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsController extends Controller
{
    /**
     * Display the tools page with all PM calculators
     */
    public function index()
    {
        return view('frontend.tools');
    }
}
