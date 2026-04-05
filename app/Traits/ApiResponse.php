<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Response Success
     */
    protected function success($data, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    /**
     * Response Error with Optional Caching
     */
    protected function error(string $message, int $code, $errors = [], bool $shouldCache = false, int $ttl = 60): JsonResponse
    {
        $responseStructure = [
            'status'  => 'error',
            'message' => $message,
        ];

        if (!empty($errors)) {
            $responseStructure['errors'] = $errors;
        }

        if ($shouldCache) {
            // Use URL as unique cache key
            $cacheKey = 'error_res_' . md5(request()->fullUrl());

            return Cache::remember($cacheKey, $ttl, function () use ($responseStructure, $code) {
                return response()->json($responseStructure, $code);
            });
        }

        return response()->json($responseStructure, $code);
    }
}