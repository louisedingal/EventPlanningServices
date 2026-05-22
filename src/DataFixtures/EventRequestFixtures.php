<?php

namespace App\DataFixtures;

use App\Entity\EventRequest;
use App\Entity\User;
use App\Entity\ServicePackage;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture data exported from local `event_request` table on 2026-05-22 04:30:37.
 * Regenerate: php scripts/generate-fixtures-from-db.php
 */
class EventRequestFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $eventRequest_1 = new EventRequest();
        $eventRequest_1->setEventType('Wedding');
        $eventRequest_1->setPreferredDate(new \DateTime('2026-03-10 00:00:00'));
        $eventRequest_1->setEstimatedGuestCount(500);
        $eventRequest_1->setPreferredVenue('sag asa');
        $eventRequest_1->setTheme('vintage');
        $eventRequest_1->setSpecialRequests('sample lang sa');
        $eventRequest_1->setBudget('4000');
        $eventRequest_1->setCreatedAt(new \DateTime('2025-12-11 03:40:05'));
        $eventRequest_1->setStatus('completed');
        $eventRequest_1->setAdminNotes('Your request has been reviewed by our team. We will reach out to you shortly with next steps.');
        $eventRequest_1->setSource('web');
        $eventRequest_1->setPreferredTime(null);
        $eventRequest_1->setPreferredStyleLabel(null);
        $eventRequest_1->setPreferredStyleImagePath(null);
        $manager->persist($eventRequest_1);

        $eventRequest_2 = new EventRequest();
        $eventRequest_2->setRequestedBy($this->getReference('user_4', User::class));
        $eventRequest_2->setEventType('Wedding');
        $eventRequest_2->setPreferredDate(new \DateTime('2025-12-01 00:00:00'));
        $eventRequest_2->setEstimatedGuestCount(50);
        $eventRequest_2->setPreferredVenue('fff');
        $eventRequest_2->setTheme('ggg');
        $eventRequest_2->setSpecialRequests('gggg');
        $eventRequest_2->setBudget('4000');
        $eventRequest_2->setCreatedAt(new \DateTime('2025-12-11 10:48:31'));
        $eventRequest_2->setStatus('pending');
        $eventRequest_2->setAdminNotes(null);
        $eventRequest_2->setSource('web');
        $eventRequest_2->setPreferredTime(null);
        $eventRequest_2->setPreferredStyleLabel(null);
        $eventRequest_2->setPreferredStyleImagePath(null);
        $manager->persist($eventRequest_2);

        $eventRequest_3 = new EventRequest();
        $eventRequest_3->setEventType('Birthday');
        $eventRequest_3->setPreferredDate(new \DateTime('2026-05-21 00:00:00'));
        $eventRequest_3->setEstimatedGuestCount(150);
        $eventRequest_3->setPreferredVenue('moa');
        $eventRequest_3->setTheme('chuy2');
        $eventRequest_3->setSpecialRequests('lami ang pagkaon');
        $eventRequest_3->setBudget('3500-4000');
        $eventRequest_3->setCreatedAt(new \DateTime('2026-04-08 04:00:42'));
        $eventRequest_3->setStatus('completed');
        $eventRequest_3->setAdminNotes(null);
        $eventRequest_3->setSource('web');
        $eventRequest_3->setPreferredTime(null);
        $eventRequest_3->setPreferredStyleLabel(null);
        $eventRequest_3->setPreferredStyleImagePath(null);
        $manager->persist($eventRequest_3);

        $eventRequest_4 = new EventRequest();
        $eventRequest_4->setRequestedBy($this->getReference('user_19', User::class));
        $eventRequest_4->setEventType('Service: lain sample');
        $eventRequest_4->setPreferredDate(new \DateTime('2026-05-30 00:00:00'));
        $eventRequest_4->setEstimatedGuestCount(1000);
        $eventRequest_4->setPreferredVenue('Didto luyo moa');
        $eventRequest_4->setTheme(null);
        $eventRequest_4->setSpecialRequests('Service booking for package "lain sample" (₱1,500.00).');
        $eventRequest_4->setBudget('1500.00');
        $eventRequest_4->setCreatedAt(new \DateTime('2026-05-21 10:40:30'));
        $eventRequest_4->setStatus('pending');
        $eventRequest_4->setAdminNotes(null);
        $eventRequest_4->setSource('mobile_app');
        $eventRequest_4->setServicePackage($this->getReference('service_package_2', ServicePackage::class));
        $eventRequest_4->setPreferredTime('08:39');
        $eventRequest_4->setPreferredStyleLabel(null);
        $eventRequest_4->setPreferredStyleImagePath(null);
        $manager->persist($eventRequest_4);

        $eventRequest_6 = new EventRequest();
        $eventRequest_6->setRequestedBy($this->getReference('user_19', User::class));
        $eventRequest_6->setEventType('Wedding');
        $eventRequest_6->setPreferredDate(new \DateTime('2026-06-07 00:00:00'));
        $eventRequest_6->setEstimatedGuestCount(550);
        $eventRequest_6->setPreferredVenue('Mangga Ave.');
        $eventRequest_6->setTheme('LUXURY & GLAMOUR');
        $eventRequest_6->setSpecialRequests('Preferred style look: Sunset ceremony (LUXURY & GLAMOUR)');
        $eventRequest_6->setBudget(null);
        $eventRequest_6->setCreatedAt(new \DateTime('2026-05-21 16:34:43'));
        $eventRequest_6->setStatus('pending');
        $eventRequest_6->setAdminNotes(null);
        $eventRequest_6->setSource('mobile_app');
        $eventRequest_6->setPreferredTime('15:00');
        $eventRequest_6->setPreferredStyleLabel('Sunset ceremony');
        $eventRequest_6->setPreferredStyleImagePath('uploads/theme-samples/luxury-glamour-sunset-ceremony.png');
        $manager->persist($eventRequest_6);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ServicePackageFixtures::class,
        ];
    }
}
