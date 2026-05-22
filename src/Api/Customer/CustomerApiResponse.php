<?php

namespace App\Api\Customer;

use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerApiResponse
{
    public static function success(mixed $data = null, int $status = 200, array $extra = []): JsonResponse
    {
        return new JsonResponse(array_merge([
            'success' => true,
            'data' => $data,
        ], $extra), $status);
    }

    public static function items(array $items, int $status = 200): JsonResponse
    {
        return self::success([
            'items' => $items,
            'total' => count($items),
        ], $status);
    }

    public static function error(string $message, int $status = 400, array $extra = []): JsonResponse
    {
        return new JsonResponse(array_merge([
            'success' => false,
            'message' => $message,
        ], $extra), $status);
    }
}
