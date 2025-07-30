<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PwaController extends Controller
{
    /**
     * Handle PWA install request
     */
    public function install(Request $request): JsonResponse
    {
        // Log PWA install event
        Log::info('PWA install requested', [
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'PWA install request logged'
        ]);
    }

    /**
     * Handle PWA update check
     */
    public function checkUpdate(Request $request): JsonResponse
    {
        $currentVersion = '1.0.0';
        $latestVersion = '1.0.0'; // In real app, this would come from API or config

        return response()->json([
            'current_version' => $currentVersion,
            'latest_version' => $latestVersion,
            'update_available' => version_compare($latestVersion, $currentVersion, '>'),
            'force_update' => false
        ]);
    }

    /**
     * Handle offline data sync
     */
    public function syncOfflineData(Request $request): JsonResponse
    {
        $offlineData = $request->input('data', []);

        // Process offline data
        $processed = 0;
        $errors = [];

        foreach ($offlineData as $item) {
            try {
                // Process each offline item
                // This would typically involve saving to database
                $processed++;
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        return response()->json([
            'success' => true,
            'processed' => $processed,
            'errors' => $errors,
            'message' => "Processed {$processed} offline items"
        ]);
    }

    /**
     * Get PWA configuration
     */
    public function config(): JsonResponse
    {
        return response()->json([
            'name' => 'Financial Management',
            'short_name' => 'Finance',
            'version' => '1.0.0',
            'theme_color' => '#3b82f6',
            'background_color' => '#ffffff',
            'display' => 'standalone',
            'orientation' => 'portrait-primary',
            'scope' => '/',
            'start_url' => '/',
            'icons' => [
                [
                    'src' => '/icons/icon-192x192.png',
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'purpose' => 'maskable any'
                ],
                [
                    'src' => '/icons/icon-512x512.png',
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'maskable any'
                ]
            ]
        ]);
    }
}
