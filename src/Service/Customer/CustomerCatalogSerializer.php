<?php

namespace App\Service\Customer;

use App\Entity\Event;
use App\Entity\ServicePackage;
use App\Entity\Theme;
use App\Entity\Venue;
use App\Service\ServicePackageImageUrlResolver;

final class CustomerCatalogSerializer
{
    public function __construct(
        private readonly ServicePackageImageUrlResolver $packageImageUrlResolver,
    ) {
    }
    public function venue(Venue $venue): array
    {
        return [
            'id' => $venue->getId(),
            'name' => $venue->getName(),
            'address' => $venue->getAddress(),
            'capacity' => $venue->getCapacity(),
            'contactInfo' => $venue->getContactInfo(),
        ];
    }

    public function theme(Theme $theme, ?string $baseUrl = null): array
    {
        $sampleImageUrls = [];
        foreach ($theme->getSampleImagePaths() as $path) {
            $url = $this->packageImageUrlResolver->resolve($path, $baseUrl);
            if ($url) {
                $sampleImageUrls[] = $url;
            }
        }

        return [
            'id' => $theme->getId(),
            'name' => $theme->getName(),
            'description' => $theme->getDescription(),
            'eventType' => $theme->getEventType(),
            'sampleImageUrls' => $sampleImageUrls,
            'sampleImagePaths' => $theme->getSampleImagePaths(),
        ];
    }

    public function package(ServicePackage $package, ?string $baseUrl = null): array
    {
        return [
            'id' => $package->getId(),
            'name' => $package->getName(),
            'description' => $package->getDescription(),
            'price' => $package->getPrice(),
            'imageUrl' => $this->packageImageUrlResolver->resolve($package->getImagePath(), $baseUrl),
        ];
    }

    public function event(Event $event): array
    {
        return [
            'id' => $event->getId(),
            'customerName' => $event->getCustomerName(),
            'eventType' => $event->getEventType(),
            'eventDate' => $event->getEventDate()?->format(\DateTimeInterface::ATOM),
            'venue' => $event->getVenue(),
            'theme' => $event->getTheme(),
            'guestCount' => $event->getGuestCount(),
            'price' => $event->getPrice(),
        ];
    }
}
