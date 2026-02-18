<?php

namespace App\Http\Controllers;

use App\Models\Gift;

class GiftPageController extends Controller
{
    public function index()
    {
        $gifts = Gift::active()->ordered()->get();
        return view('frontend.gifts', compact('gifts'));
    }
}
