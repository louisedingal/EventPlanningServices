<?php

namespace App\Twig;

use App\Entity\EventRequest;
use App\Service\EventRequestStyleImageResolver;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class EventRequestExtension extends AbstractExtension
{
    public function __construct(
        private readonly EventRequestStyleImageResolver $styleImageResolver,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('event_request_style_image_url', [$this, 'styleImageUrl']),
        ];
    }

    public function styleImageUrl(EventRequest $request): ?string
    {
        $url = $this->styleImageResolver->resolveUrl($request);

        return $url !== null && $url !== '' ? $url : null;
    }
}
