<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Feedback API Routes (require authentication)
Route::middleware('auth:sanctum')->prefix('feedback')->name('api.feedback.')->group(function () {
    // Get all user's feedback
    Route::get('/', [FeedbackController::class, 'dashboard'])->name('index');

    // Get specific feedback details
    Route::get('/{feedbackId}', [FeedbackController::class, 'show'])->name('show');

    // Submit new feedback
    Route::post('/', [FeedbackController::class, 'store'])->name('store');

    // Withdraw feedback
    Route::patch('/{feedbackId}/withdraw', [FeedbackController::class, 'withdraw'])->name('withdraw');

    // Get feedback status history
    Route::get('/{feedbackId}/history', function ($feedbackId) {
        $feedback = \App\Models\Feedback::where('feedback_id', $feedbackId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return response()->json($feedback->statusHistory()->latest()->get());
    })->name('history');
});
