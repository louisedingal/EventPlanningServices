<?php

namespace App\EventSubscriber;

use App\Service\AppUrlService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Forces the router to use APP_URL in production (Railway proxy / wrong internal host).
 */
final class RouterContextSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly AppUrlService $appUrlService,
        private readonly RouterInterface $router,
        private readonly KernelInterface $kernel,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 100],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest() || $this->kernel->getEnvironment() !== 'prod') {
            return;
        }

        $host = $this->appUrlService->resolveHost();
        if ($host === null) {
            return;
        }

        $scheme = $this->appUrlService->resolveScheme() ?? 'https';
        $context = $this->router->getContext();
        $context->setHost($host);
        $context->setScheme($scheme);
        $context->setHttpPort($scheme === 'https' ? 443 : 80);
        $context->setHttpsPort(443);
    }
}
