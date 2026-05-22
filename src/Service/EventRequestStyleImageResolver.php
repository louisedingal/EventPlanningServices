<?php

namespace App\Service;

use App\Entity\EventRequest;
use App\Repository\ThemeRepository;

/**
 * Resolves the style preview image a customer chose (stored path or theme + label).
 */
final class EventRequestStyleImageResolver
{
    private const LUXURY_LABELS = [
        'Chandelier reception',
        'Magenta ballroom',
        'Sunset ceremony',
    ];

    public function __construct(
        private readonly ThemeRepository $themeRepository,
        private readonly ServicePackageImageUrlResolver $imageUrlResolver,
    ) {
    }

    public function resolvePath(EventRequest $request): ?string
    {
        $stored = $request->getPreferredStyleImagePath();
        if ($stored !== null && $stored !== '') {
            return $stored;
        }

        $label = $request->getPreferredStyleLabel() ?? $this->parseLabelFromSpecialRequests(
            $request->getSpecialRequests()
        );
        $themeName = $request->getTheme();

        if ($label === null || $themeName === null || $themeName === '') {
            return null;
        }

        return $this->resolvePathFromThemeAndLabel($themeName, $label);
    }

    public function resolveUrl(EventRequest $request, ?string $baseUrl = null): ?string
    {
        $path = $this->resolvePath($request);

        return $this->imageUrlResolver->resolve($path, $baseUrl);
    }

    public function resolvePathFromThemeAndLabel(string $themeName, string $label): ?string
    {
        $theme = $this->themeRepository->createQueryBuilder('t')
            ->where('UPPER(t.name) = UPPER(:name)')
            ->setParameter('name', trim($themeName))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$theme) {
            return null;
        }

        $paths = $theme->getSampleImagePaths();
        if ($paths === []) {
            return null;
        }

        $index = $this->indexForLabel($themeName, $label);

        return $index !== null ? ($paths[$index] ?? null) : null;
    }

    private function indexForLabel(string $themeName, string $label): ?int
    {
        $label = trim($label);
        if (stripos($themeName, 'luxury') !== false) {
            foreach (self::LUXURY_LABELS as $i => $known) {
                if (strcasecmp($known, $label) === 0) {
                    return $i;
                }
            }
        }

        if (preg_match('/look\s*(\d+)/i', $label, $m)) {
            return max(0, (int) $m[1] - 1);
        }

        return null;
    }

    private function parseLabelFromSpecialRequests(?string $text): ?string
    {
        if ($text === null || $text === '') {
            return null;
        }

        if (preg_match('/Preferred style look:\s*([^(]+)/i', $text, $m)) {
            $parsed = trim($m[1]);

            return $parsed !== '' ? $parsed : null;
        }

        return null;
    }
}
