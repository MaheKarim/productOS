<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $interviewSessions = \App\Models\InterviewSession::where('user_id', auth()->id())
            ->latest('completed_at')
            ->take(5)
            ->get();

        return view('user.dashboard', compact('interviewSessions'));
    }
}
