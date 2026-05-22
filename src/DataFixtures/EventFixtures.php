<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\User;
use App\Entity\Venue;
use App\Entity\ServicePackage;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture data exported from local `event` table on 2026-05-22 04:30:37.
 * Regenerate: php scripts/generate-fixtures-from-db.php
 */
class EventFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $event_17 = new Event();
        $event_17->setCustomerName('Kian');
        $event_17->setEventType('Birthday');
        $event_17->setEventDate(new \DateTimeImmutable('2026-02-19 20:02:00'));
        $event_17->setVenue('didto basta layu');
        $event_17->setTheme('DESTINATION & ESCAPE');
        $event_17->setGuestCount(500);
        $event_17->setPrice(6500);
        $event_17->setCreatedBy($this->getReference('user_4', User::class));
        $manager->persist($event_17);

        $event_18 = new Event();
        $event_18->setCustomerName('Mark');
        $event_18->setEventType('Wedding');
        $event_18->setEventDate(new \DateTimeImmutable('2026-04-09 17:25:00'));
        $event_18->setVenue('Hawaii');
        $event_18->setTheme('DESTINATION & ESCAPE');
        $event_18->setGuestCount(50);
        $event_18->setPrice(10000);
        $manager->persist($event_18);

        $event_20 = new Event();
        $event_20->setCustomerName('Nino');
        $event_20->setEventType('Birthday');
        $event_20->setEventDate(new \DateTimeImmutable('2026-04-13 14:50:00'));
        $event_20->setVenue('dinhi ra');
        $event_20->setTheme('TRENDY & SOCIAL-MEDIA READY');
        $event_20->setGuestCount(350);
        $event_20->setPrice(4500);
        $event_20->setCreatedBy($this->getReference('user_6', User::class));
        $manager->persist($event_20);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            VenueFixtures::class,
            ServicePackageFixtures::class,
        ];
    }
}
