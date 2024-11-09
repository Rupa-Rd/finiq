<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot');
    }

    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('message');

        // Prepare data for Vultr API request
        $apiUrl = "http://api.vultrinference.com/v1/chat/completions/RAG";
        $apiKey = env('VULTR_API_KEY'); // Ensure API key is set in .env file
        set_time_limit(60); 
        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/json',
        ])
        ->withoutVerifying()
        ->post($apiUrl, [
            'collection' => 'financialresou',
            'model' => 'llama2-7b-chat-Q5_K_M',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $userMessage
                ]
            ],
            'max_tokens' => 512,
            'seed' => -1,
            'temperature' => 0.8,
            'top_k' => 40,
            'top_p' => 0.9,
        ]);

        Log::info('Vultr API Response:', $response->json());
        // Check response and handle errors
        if ($response->successful()) {
            $content = $response->json('choices.0.message.content');
            Log::info("Chatbot API response: " . $content); // Log response content for debugging

            return response()->json(['response' => $content]);
        } else {
            Log::error('API Error:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return response()->json(['error' => 'Failed to get response from chatbot'], 500);
        }
    }
}
