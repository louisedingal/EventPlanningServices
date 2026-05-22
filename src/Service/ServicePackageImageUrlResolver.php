<?php

namespace App\Service;

final class ServicePackageImageUrlResolver
{
    public function resolve(?string $imagePath, ?string $baseUrl = null): ?string
    {
        if (!$imagePath || trim($imagePath) === '') {
            return null;
        }

        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath;
        }

        $path = '/'.ltrim($imagePath, '/');

        return $baseUrl ? rtrim($baseUrl, '/').$path : $path;
    }
}
