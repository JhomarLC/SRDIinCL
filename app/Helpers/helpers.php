<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('getAddressName')) {
    function getAddressName($type, $code) {
        if (!$code) return 'Unknown';

        $apiUrl = match ($type) {
            'region' => "https://psgc.gitlab.io/api/regions/{$code}/",
            'province' => "https://psgc.gitlab.io/api/provinces/{$code}/",
            'municipality' => "https://psgc.gitlab.io/api/cities-municipalities/{$code}/",
            'barangay' => "https://psgc.gitlab.io/api/barangays/{$code}/",
            default => null
        };

        if (!$apiUrl) return 'Unknown';

        try {
            $response = Http::get($apiUrl);
            if ($response->successful()) {
                return $response->json()['name'] ?? 'Unknown';
            }
        } catch (\Exception $e) {
            return 'Unknown';
        }

        return 'Unknown';
    }
}

if (! function_exists('scoreLabel')) {
    function scoreLabel($score)
    {
        if ($score >= 4.21) return 'Excellent';
        if ($score >= 3.41) return 'Very Good';
        if ($score >= 2.61) return 'Good';
        if ($score >= 1.81) return 'Fair';
        return 'Poor';
    }
}
