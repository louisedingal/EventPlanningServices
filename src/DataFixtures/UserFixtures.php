<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * One fixture user per role. All accounts share the same password: password123
 */
class UserFixtures extends Fixture
{
    private const DEFAULT_PASSWORD = 'password123';

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setName('Admin');
        $admin->setLastName('User');
        $admin->setStatus('active');
        $admin->setIsVerified(true);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, self::DEFAULT_PASSWORD));
        $manager->persist($admin);
        $this->addReference('user_6', $admin);

        $staff = new User();
        $staff->setEmail('staff@gmail.com');
        $staff->setRoles(['ROLE_STAFF']);
        $staff->setStatus('active');
        $staff->setIsVerified(true);
        $staff->setPassword($this->passwordHasher->hashPassword($staff, self::DEFAULT_PASSWORD));
        $manager->persist($staff);
        $this->addReference('user_4', $staff);

        $customer = new User();
        $customer->setEmail('customer@gmail.com');
        $customer->setUsername('customer');
        $customer->setRoles([]);
        $customer->setName('Customer');
        $customer->setLastName('User');
        $customer->setStatus('active');
        $customer->setIsVerified(true);
        $customer->setPassword($this->passwordHasher->hashPassword($customer, self::DEFAULT_PASSWORD));
        $manager->persist($customer);
        $this->addReference('user_19', $customer);

        $manager->flush();
    }
}
