<?php

namespace App\Service;

/**
 * Canonical public base URL for absolute links (email verification, OAuth, API docs).
 */
final class AppUrlService
{
    public function __construct(
        private readonly string $appUrl,
    ) {
    }

    public function getBaseUrl(): ?string
    {
        $url = trim($this->appUrl);
        if ($url === '') {
            return null;
        }

        return rtrim($url, '/');
    }

    public function resolveHost(): ?string
    {
        $base = $this->getBaseUrl();
        if ($base === null) {
            return null;
        }

        $parsed = parse_url($base);

        return $parsed['host'] ?? null;
    }

    public function resolveScheme(): ?string
    {
        $base = $this->getBaseUrl();
        if ($base === null) {
            return null;
        }

        $parsed = parse_url($base);

        return $parsed['scheme'] ?? null;
    }
}
