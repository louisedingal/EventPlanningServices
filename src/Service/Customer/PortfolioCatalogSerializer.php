<?php

namespace App\Service\Customer;

final class PortfolioCatalogSerializer
{
    public function item(array $item, string $baseUrl): array
    {
        return [
            'id' => $item['id'],
            'title' => $item['title'],
            'subtitle' => $item['subtitle'],
            'category' => $item['category'],
            'featured' => $item['featured'],
            'imageUrl' => $this->resolveImageUrl($item['image'], $baseUrl),
        ];
    }

    private function resolveImageUrl(string $image, string $baseUrl): string
    {
        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        return rtrim($baseUrl, '/').'/'.ltrim($image, '/');
    }
}
