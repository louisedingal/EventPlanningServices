<?php

namespace App\DataFixtures;

use App\Entity\ServicePackage;
use App\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture data exported from local `service_package` table on 2026-05-22 04:30:37.
 * Regenerate: php scripts/generate-fixtures-from-db.php
 */
class ServicePackageFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $servicePackage_1 = new ServicePackage();
        $servicePackage_1->setName('Wedding');
        $servicePackage_1->setDescription('sample ra');
        $servicePackage_1->setPrice(20000);
        $servicePackage_1->setImagePath('uploads/service-packages/sample-package-6a0ee99fe4bb49.16569853.jpg');
        $manager->persist($servicePackage_1);
        $this->addReference('service_package_1', $servicePackage_1);

        $servicePackage_2 = new ServicePackage();
        $servicePackage_2->setName('Birthday');
        $servicePackage_2->setDescription('nindut ni');
        $servicePackage_2->setPrice(10000);
        $servicePackage_2->setCreatedBy($this->getReference('user_4', User::class));
        $servicePackage_2->setImagePath('uploads/service-packages/birthday-6a0ee25d2c79f4.89422943.jpg');
        $manager->persist($servicePackage_2);
        $this->addReference('service_package_2', $servicePackage_2);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
