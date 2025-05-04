<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ChartAnalysisController extends Controller
{
    public function generateSubtitle(Request $request)
    {
        $labels = $request->input('labels', []);
        $counts = $request->input('counts', []);
        $title = $request->input('title', 'Data');

        // Combine into a string
        $dataSummary = $title . " - ";
        $parts = collect($labels)->map(function($label, $index) use ($counts) {
            return "$label: " . ($counts[$index] ?? 0);
        });
        $dataSummary .= $parts->implode(', ');

        // Check cache first (for performance and to avoid rate limits)
        $cacheKey = md5($dataSummary);
        $cachedResponse = Cache::get("chart_summary_$cacheKey");

        if ($cachedResponse) {
            return response()->json(['summary' => $cachedResponse]);
        }

        // Prepare the prompt
        $prompt = "
            You are a data analyst. Given the following chart data, write a concise summary in this style:
            \"From this data, it can be observed that [key findings]. The distribution shows [overall trend or demographic insights].\"

            Data:
            $dataSummary
        ";

        // Call OpenRouter
        $apiKey = config('services.openrouter.api_key');
        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/json',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'mistralai/mistral-small-3.1-24b-instruct:free',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
        ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'AI request failed', 'details' => $response->json()], 429);
        }

        $reply = data_get($response->json(), 'choices.0.message.content', 'No summary generated.');

        // Cache for 12 hours to avoid repeat API calls
        Cache::put("chart_summary_$cacheKey", $reply, now()->addHours(12));

        return response()->json(['summary' => $reply]);
    }
}
