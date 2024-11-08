<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

Route::get('/', function () {
    return view('welcome');
});

// Chatbot UI route
Route::get('/chatbot', [ChatbotController::class, 'index']);

// Route to handle API request to Vultr Inference API
Route::post('/api/chat', [ChatbotController::class, 'sendMessage']);
