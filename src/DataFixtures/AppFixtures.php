<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Optional entry point. Entity data lives in per-table fixture classes:
 * UserFixtures, VenueFixtures, ServicePackageFixtures, ThemeFixtures,
 * EventFixtures, EventRequestFixtures, ActivityLogFixtures.
 *
 * Load everything: php bin/console doctrine:fixtures:load
 * Regenerate from DB: php scripts/generate-fixtures-from-db.php
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Intentionally empty — see entity-specific fixture classes.
    }
}
