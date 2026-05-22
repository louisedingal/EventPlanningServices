<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture data exported from local `user` table on 2026-05-22 04:30:37.
 * Regenerate: php scripts/generate-fixtures-from-db.php
 */
class UserFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $user_4 = new User();
        $user_4->setEmail('staff@gmail.com');
        $user_4->setRoles(['ROLE_STAFF']);
        $user_4->setPassword('$2y$13$SxwsUlceb2X.WrxycxRLvuxMcK9HEv3Ryfmr2sYMkT8c77jFsDaOq');
        $user_4->setName(null);
        $user_4->setStatus('active');
        $user_4->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:43:42'));
        $user_4->setLastName(null);
        $user_4->setUsername(null);
        $user_4->setIsVerified(true);
        $user_4->setVerificationToken(null);
        $manager->persist($user_4);
        $this->addReference('user_4', $user_4);

        $user_6 = new User();
        $user_6->setEmail('admin@gmail.com');
        $user_6->setRoles(['ROLE_ADMIN']);
        $user_6->setPassword('$2y$13$27brxYW9v9wSHCtxmu9EQOF23aqrf70cTJe0KcIyXcLG/uD0xj3dW');
        $user_6->setName('Louise');
        $user_6->setStatus('active');
        $user_6->setCreatedAt(new \DateTimeImmutable('2025-12-11 05:41:33'));
        $user_6->setLastName('Dingal');
        $user_6->setUsername(null);
        $user_6->setIsVerified(true);
        $user_6->setVerificationToken(null);
        $manager->persist($user_6);
        $this->addReference('user_6', $user_6);

        $user_18 = new User();
        $user_18->setEmail('luckydingal46@gmail.com');
        $user_18->setRoles(['ROLE_STAFF']);
        $user_18->setPassword('$2y$13$48MvJu/ECt2ECptjvIW0AOt26gO83246aGxOf64YE/uDKVn78ZxL6');
        $user_18->setName(null);
        $user_18->setStatus('active');
        $user_18->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:31:11'));
        $user_18->setLastName(null);
        $user_18->setUsername('luckydingal46');
        $user_18->setIsVerified(true);
        $user_18->setVerificationToken(null);
        $manager->persist($user_18);
        $this->addReference('user_18', $user_18);

        $user_19 = new User();
        $user_19->setEmail('edudingal17@gmail.com');
        $user_19->setRoles(['ROLE_USER']);
        $user_19->setPassword('$2y$13$a2CYX5Bhl7FKTB/h2ZGYp.R4t9YS6Dx.uj3rYuGQpwXJNOQxdsClq');
        $user_19->setName('Eduardo');
        $user_19->setStatus('active');
        $user_19->setCreatedAt(new \DateTimeImmutable('2026-05-20 17:50:23'));
        $user_19->setLastName('Dingal');
        $user_19->setUsername('edudingal17');
        $user_19->setIsVerified(true);
        $user_19->setVerificationToken(null);
        $manager->persist($user_19);
        $this->addReference('user_19', $user_19);

        $manager->flush();
    }
}
