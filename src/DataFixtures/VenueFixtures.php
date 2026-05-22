<?php

namespace App\DataFixtures;

use App\Entity\Venue;
use App\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture data exported from local `venue` table on 2026-05-22 04:30:37.
 * Regenerate: php scripts/generate-fixtures-from-db.php
 */
class VenueFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // No rows in local database.
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
