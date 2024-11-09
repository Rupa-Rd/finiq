<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

Route::get('/', function () {
    return redirect()->route('chatbot');
});

// Chatbot UI route
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');

// Route to handle API request to Vultr Inference API
Route::post('/chat', [ChatbotController::class, 'sendMessage']);
