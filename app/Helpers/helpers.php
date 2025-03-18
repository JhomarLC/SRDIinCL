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
