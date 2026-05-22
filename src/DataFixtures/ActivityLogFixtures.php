<?php

namespace App\DataFixtures;

use App\Entity\ActivityLog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture data exported from local `activity_log` table on 2026-05-22 04:30:37.
 * Regenerate: php scripts/generate-fixtures-from-db.php
 */
class ActivityLogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $activityLog_1 = new ActivityLog();
        $activityLog_1->setUserEmail('admin@example.com');
        $activityLog_1->setUserRole('ROLE_ADMIN');
        $activityLog_1->setAction('Delete');
        $activityLog_1->setEntityType('Event');
        $activityLog_1->setEntityId($this->getReference('user_14', User::class));
        $activityLog_1->setAffectedData('{
    "customerName": "Nat",
    "eventType": "Birthday",
    "price": 5000
}');
        $activityLog_1->setDescription('Deleted event: Nat - Birthday');
        $activityLog_1->setCreatedAt(new \DateTimeImmutable('2025-12-08 07:04:28'));
        $manager->persist($activityLog_1);

        $activityLog_2 = new ActivityLog();
        $activityLog_2->setUserEmail('admin@example.com');
        $activityLog_2->setUserRole('ROLE_ADMIN');
        $activityLog_2->setAction('Delete');
        $activityLog_2->setEntityType('Event');
        $activityLog_2->setEntityId($this->getReference('user_15', User::class));
        $activityLog_2->setAffectedData('{
    "customerName": "Jay",
    "eventType": "Wedding",
    "price": 3500
}');
        $activityLog_2->setDescription('Deleted event: Jay - Wedding');
        $activityLog_2->setCreatedAt(new \DateTimeImmutable('2025-12-08 07:04:31'));
        $manager->persist($activityLog_2);

        $activityLog_3 = new ActivityLog();
        $activityLog_3->setUserEmail('admin@example.com');
        $activityLog_3->setUserRole('ROLE_ADMIN');
        $activityLog_3->setAction('Create');
        $activityLog_3->setEntityType('Event');
        $activityLog_3->setEntityId($this->getReference('user_16', User::class));
        $activityLog_3->setAffectedData('{
    "customerName": "Jay",
    "eventType": "Wedding",
    "price": 10000
}');
        $activityLog_3->setDescription('Created event: Jay - Wedding');
        $activityLog_3->setCreatedAt(new \DateTimeImmutable('2025-12-08 07:06:08'));
        $manager->persist($activityLog_3);

        $activityLog_4 = new ActivityLog();
        $activityLog_4->setUserEmail('admin@example.com');
        $activityLog_4->setUserRole('ROLE_ADMIN');
        $activityLog_4->setAction('Create');
        $activityLog_4->setEntityType('ServicePackage');
        $activityLog_4->setEntityId($this->getReference('user_1', User::class));
        $activityLog_4->setAffectedData('{
    "name": "Sample package",
    "price": 5000
}');
        $activityLog_4->setDescription('Created service package: Sample package');
        $activityLog_4->setCreatedAt(new \DateTimeImmutable('2025-12-08 07:12:40'));
        $manager->persist($activityLog_4);

        $activityLog_5 = new ActivityLog();
        $activityLog_5->setUserEmail('admin@example.com');
        $activityLog_5->setUserRole('ROLE_ADMIN');
        $activityLog_5->setAction('Logout');
        $activityLog_5->setEntityType(null);
        $activityLog_5->setAffectedData(null);
        $activityLog_5->setDescription('User logged out');
        $activityLog_5->setCreatedAt(new \DateTimeImmutable('2025-12-08 07:37:36'));
        $manager->persist($activityLog_5);

        $activityLog_6 = new ActivityLog();
        $activityLog_6->setUserEmail('admin@example.com');
        $activityLog_6->setUserRole('ROLE_ADMIN');
        $activityLog_6->setAction('Login');
        $activityLog_6->setEntityType(null);
        $activityLog_6->setAffectedData(null);
        $activityLog_6->setDescription('User logged in');
        $activityLog_6->setCreatedAt(new \DateTimeImmutable('2025-12-08 07:37:44'));
        $manager->persist($activityLog_6);

        $activityLog_7 = new ActivityLog();
        $activityLog_7->setUserEmail('admin@example.com');
        $activityLog_7->setUserRole('ROLE_ADMIN');
        $activityLog_7->setAction('Logout');
        $activityLog_7->setEntityType(null);
        $activityLog_7->setAffectedData(null);
        $activityLog_7->setDescription('User logged out');
        $activityLog_7->setCreatedAt(new \DateTimeImmutable('2025-12-08 07:44:18'));
        $manager->persist($activityLog_7);

        $activityLog_8 = new ActivityLog();
        $activityLog_8->setUserEmail('louise@gmail.com');
        $activityLog_8->setUserRole('ROLE_USER');
        $activityLog_8->setAction('Login');
        $activityLog_8->setEntityType(null);
        $activityLog_8->setAffectedData(null);
        $activityLog_8->setDescription('User logged in');
        $activityLog_8->setCreatedAt(new \DateTimeImmutable('2025-12-08 07:44:25'));
        $manager->persist($activityLog_8);

        $activityLog_9 = new ActivityLog();
        $activityLog_9->setUserEmail('louise@gmail.com');
        $activityLog_9->setUserRole('ROLE_USER');
        $activityLog_9->setAction('Logout');
        $activityLog_9->setEntityType(null);
        $activityLog_9->setAffectedData(null);
        $activityLog_9->setDescription('User logged out');
        $activityLog_9->setCreatedAt(new \DateTimeImmutable('2025-12-08 07:44:30'));
        $manager->persist($activityLog_9);

        $activityLog_10 = new ActivityLog();
        $activityLog_10->setUserEmail('admin@example.com');
        $activityLog_10->setUserRole('ROLE_ADMIN');
        $activityLog_10->setAction('Login');
        $activityLog_10->setEntityType(null);
        $activityLog_10->setAffectedData(null);
        $activityLog_10->setDescription('User logged in');
        $activityLog_10->setCreatedAt(new \DateTimeImmutable('2025-12-08 07:44:35'));
        $manager->persist($activityLog_10);

        $activityLog_11 = new ActivityLog();
        $activityLog_11->setUserEmail('admin@example.com');
        $activityLog_11->setUserRole('ROLE_ADMIN');
        $activityLog_11->setAction('Logout');
        $activityLog_11->setEntityType(null);
        $activityLog_11->setAffectedData(null);
        $activityLog_11->setDescription('User logged out');
        $activityLog_11->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:33:12'));
        $manager->persist($activityLog_11);

        $activityLog_12 = new ActivityLog();
        $activityLog_12->setUserEmail('admin@example.com');
        $activityLog_12->setUserRole('ROLE_ADMIN');
        $activityLog_12->setAction('Login');
        $activityLog_12->setEntityType(null);
        $activityLog_12->setAffectedData(null);
        $activityLog_12->setDescription('User logged in');
        $activityLog_12->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:35:42'));
        $manager->persist($activityLog_12);

        $activityLog_13 = new ActivityLog();
        $activityLog_13->setUserEmail('admin@example.com');
        $activityLog_13->setUserRole('ROLE_ADMIN');
        $activityLog_13->setAction('Logout');
        $activityLog_13->setEntityType(null);
        $activityLog_13->setAffectedData(null);
        $activityLog_13->setDescription('User logged out');
        $activityLog_13->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:35:50'));
        $manager->persist($activityLog_13);

        $activityLog_14 = new ActivityLog();
        $activityLog_14->setUserEmail('admin@example.com');
        $activityLog_14->setUserRole('ROLE_ADMIN');
        $activityLog_14->setAction('Login');
        $activityLog_14->setEntityType(null);
        $activityLog_14->setAffectedData(null);
        $activityLog_14->setDescription('User logged in');
        $activityLog_14->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:37:49'));
        $manager->persist($activityLog_14);

        $activityLog_15 = new ActivityLog();
        $activityLog_15->setUserEmail('admin@example.com');
        $activityLog_15->setUserRole('ROLE_ADMIN');
        $activityLog_15->setAction('Logout');
        $activityLog_15->setEntityType(null);
        $activityLog_15->setAffectedData(null);
        $activityLog_15->setDescription('User logged out');
        $activityLog_15->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:48:44'));
        $manager->persist($activityLog_15);

        $activityLog_16 = new ActivityLog();
        $activityLog_16->setUserEmail('staff@gmail.com');
        $activityLog_16->setUserRole('ROLE_USER');
        $activityLog_16->setAction('Login');
        $activityLog_16->setEntityType(null);
        $activityLog_16->setAffectedData(null);
        $activityLog_16->setDescription('User logged in');
        $activityLog_16->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:48:58'));
        $manager->persist($activityLog_16);

        $activityLog_17 = new ActivityLog();
        $activityLog_17->setUserEmail('staff@gmail.com');
        $activityLog_17->setUserRole('ROLE_USER');
        $activityLog_17->setAction('Logout');
        $activityLog_17->setEntityType(null);
        $activityLog_17->setAffectedData(null);
        $activityLog_17->setDescription('User logged out');
        $activityLog_17->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:49:18'));
        $manager->persist($activityLog_17);

        $activityLog_18 = new ActivityLog();
        $activityLog_18->setUserEmail('staff@gmail.com');
        $activityLog_18->setUserRole('ROLE_USER');
        $activityLog_18->setAction('Login');
        $activityLog_18->setEntityType(null);
        $activityLog_18->setAffectedData(null);
        $activityLog_18->setDescription('User logged in');
        $activityLog_18->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:49:26'));
        $manager->persist($activityLog_18);

        $activityLog_19 = new ActivityLog();
        $activityLog_19->setUserEmail('staff@gmail.com');
        $activityLog_19->setUserRole('ROLE_USER');
        $activityLog_19->setAction('Logout');
        $activityLog_19->setEntityType(null);
        $activityLog_19->setAffectedData(null);
        $activityLog_19->setDescription('User logged out');
        $activityLog_19->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:49:30'));
        $manager->persist($activityLog_19);

        $activityLog_20 = new ActivityLog();
        $activityLog_20->setUserEmail('staff@gmail.com');
        $activityLog_20->setUserRole('ROLE_USER');
        $activityLog_20->setAction('Login');
        $activityLog_20->setEntityType(null);
        $activityLog_20->setAffectedData(null);
        $activityLog_20->setDescription('User logged in');
        $activityLog_20->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:52:50'));
        $manager->persist($activityLog_20);

        $activityLog_21 = new ActivityLog();
        $activityLog_21->setUserEmail('staff@gmail.com');
        $activityLog_21->setUserRole('ROLE_USER');
        $activityLog_21->setAction('Logout');
        $activityLog_21->setEntityType(null);
        $activityLog_21->setAffectedData(null);
        $activityLog_21->setDescription('User logged out');
        $activityLog_21->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:52:57'));
        $manager->persist($activityLog_21);

        $activityLog_22 = new ActivityLog();
        $activityLog_22->setUserEmail('admin@example.com');
        $activityLog_22->setUserRole('ROLE_ADMIN');
        $activityLog_22->setAction('Login');
        $activityLog_22->setEntityType(null);
        $activityLog_22->setAffectedData(null);
        $activityLog_22->setDescription('User logged in');
        $activityLog_22->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:53:13'));
        $manager->persist($activityLog_22);

        $activityLog_23 = new ActivityLog();
        $activityLog_23->setUserEmail('admin@example.com');
        $activityLog_23->setUserRole('ROLE_ADMIN');
        $activityLog_23->setAction('Logout');
        $activityLog_23->setEntityType(null);
        $activityLog_23->setAffectedData(null);
        $activityLog_23->setDescription('User logged out');
        $activityLog_23->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:58:10'));
        $manager->persist($activityLog_23);

        $activityLog_24 = new ActivityLog();
        $activityLog_24->setUserEmail('staff@gmail.com');
        $activityLog_24->setUserRole('ROLE_USER');
        $activityLog_24->setAction('Login');
        $activityLog_24->setEntityType(null);
        $activityLog_24->setAffectedData(null);
        $activityLog_24->setDescription('User logged in');
        $activityLog_24->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:58:18'));
        $manager->persist($activityLog_24);

        $activityLog_25 = new ActivityLog();
        $activityLog_25->setUserEmail('staff@gmail.com');
        $activityLog_25->setUserRole('ROLE_USER');
        $activityLog_25->setAction('Logout');
        $activityLog_25->setEntityType(null);
        $activityLog_25->setAffectedData(null);
        $activityLog_25->setDescription('User logged out');
        $activityLog_25->setCreatedAt(new \DateTimeImmutable('2025-12-08 08:59:57'));
        $manager->persist($activityLog_25);

        $activityLog_26 = new ActivityLog();
        $activityLog_26->setUserEmail('admin@example.com');
        $activityLog_26->setUserRole('ROLE_ADMIN');
        $activityLog_26->setAction('Login');
        $activityLog_26->setEntityType(null);
        $activityLog_26->setAffectedData(null);
        $activityLog_26->setDescription('User logged in');
        $activityLog_26->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:00:05'));
        $manager->persist($activityLog_26);

        $activityLog_27 = new ActivityLog();
        $activityLog_27->setUserEmail('admin@example.com');
        $activityLog_27->setUserRole('ROLE_ADMIN');
        $activityLog_27->setAction('Logout');
        $activityLog_27->setEntityType(null);
        $activityLog_27->setAffectedData(null);
        $activityLog_27->setDescription('User logged out');
        $activityLog_27->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:00:19'));
        $manager->persist($activityLog_27);

        $activityLog_28 = new ActivityLog();
        $activityLog_28->setUserEmail('staff@gmail.com');
        $activityLog_28->setUserRole('ROLE_USER');
        $activityLog_28->setAction('Login');
        $activityLog_28->setEntityType(null);
        $activityLog_28->setAffectedData(null);
        $activityLog_28->setDescription('User logged in');
        $activityLog_28->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:00:47'));
        $manager->persist($activityLog_28);

        $activityLog_29 = new ActivityLog();
        $activityLog_29->setUserEmail('staff@gmail.com');
        $activityLog_29->setUserRole('ROLE_USER');
        $activityLog_29->setAction('Login');
        $activityLog_29->setEntityType(null);
        $activityLog_29->setAffectedData(null);
        $activityLog_29->setDescription('User logged in');
        $activityLog_29->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:01:41'));
        $manager->persist($activityLog_29);

        $activityLog_30 = new ActivityLog();
        $activityLog_30->setUserEmail('staff@gmail.com');
        $activityLog_30->setUserRole('ROLE_USER');
        $activityLog_30->setAction('Logout');
        $activityLog_30->setEntityType(null);
        $activityLog_30->setAffectedData(null);
        $activityLog_30->setDescription('User logged out');
        $activityLog_30->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:01:48'));
        $manager->persist($activityLog_30);

        $activityLog_31 = new ActivityLog();
        $activityLog_31->setUserEmail('staff@gmail.com');
        $activityLog_31->setUserRole('ROLE_STAFF');
        $activityLog_31->setAction('Login');
        $activityLog_31->setEntityType(null);
        $activityLog_31->setAffectedData(null);
        $activityLog_31->setDescription('User logged in');
        $activityLog_31->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:19:10'));
        $manager->persist($activityLog_31);

        $activityLog_32 = new ActivityLog();
        $activityLog_32->setUserEmail('staff@gmail.com');
        $activityLog_32->setUserRole('ROLE_STAFF');
        $activityLog_32->setAction('Logout');
        $activityLog_32->setEntityType(null);
        $activityLog_32->setAffectedData(null);
        $activityLog_32->setDescription('User logged out');
        $activityLog_32->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:26:19'));
        $manager->persist($activityLog_32);

        $activityLog_33 = new ActivityLog();
        $activityLog_33->setUserEmail('staff@gmail.com');
        $activityLog_33->setUserRole('ROLE_STAFF');
        $activityLog_33->setAction('Login');
        $activityLog_33->setEntityType(null);
        $activityLog_33->setAffectedData(null);
        $activityLog_33->setDescription('User logged in');
        $activityLog_33->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:26:27'));
        $manager->persist($activityLog_33);

        $activityLog_34 = new ActivityLog();
        $activityLog_34->setUserEmail('staff@gmail.com');
        $activityLog_34->setUserRole('ROLE_STAFF');
        $activityLog_34->setAction('Logout');
        $activityLog_34->setEntityType(null);
        $activityLog_34->setAffectedData(null);
        $activityLog_34->setDescription('User logged out');
        $activityLog_34->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:35:04'));
        $manager->persist($activityLog_34);

        $activityLog_35 = new ActivityLog();
        $activityLog_35->setUserEmail('admin@example.com');
        $activityLog_35->setUserRole('ROLE_ADMIN');
        $activityLog_35->setAction('Login');
        $activityLog_35->setEntityType(null);
        $activityLog_35->setAffectedData(null);
        $activityLog_35->setDescription('User logged in');
        $activityLog_35->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:35:12'));
        $manager->persist($activityLog_35);

        $activityLog_36 = new ActivityLog();
        $activityLog_36->setUserEmail('admin@example.com');
        $activityLog_36->setUserRole('ROLE_ADMIN');
        $activityLog_36->setAction('Logout');
        $activityLog_36->setEntityType(null);
        $activityLog_36->setAffectedData(null);
        $activityLog_36->setDescription('User logged out');
        $activityLog_36->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:39:28'));
        $manager->persist($activityLog_36);

        $activityLog_37 = new ActivityLog();
        $activityLog_37->setUserEmail('admin@example.com');
        $activityLog_37->setUserRole('ROLE_ADMIN');
        $activityLog_37->setAction('Login');
        $activityLog_37->setEntityType(null);
        $activityLog_37->setAffectedData(null);
        $activityLog_37->setDescription('User logged in');
        $activityLog_37->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:53:54'));
        $manager->persist($activityLog_37);

        $activityLog_38 = new ActivityLog();
        $activityLog_38->setUserEmail('admin@example.com');
        $activityLog_38->setUserRole('ROLE_ADMIN');
        $activityLog_38->setAction('Logout');
        $activityLog_38->setEntityType(null);
        $activityLog_38->setAffectedData(null);
        $activityLog_38->setDescription('User logged out');
        $activityLog_38->setCreatedAt(new \DateTimeImmutable('2025-12-08 09:56:54'));
        $manager->persist($activityLog_38);

        $activityLog_39 = new ActivityLog();
        $activityLog_39->setUserEmail('staff@gmail.com');
        $activityLog_39->setUserRole('ROLE_STAFF');
        $activityLog_39->setAction('Login');
        $activityLog_39->setEntityType(null);
        $activityLog_39->setAffectedData(null);
        $activityLog_39->setDescription('User logged in');
        $activityLog_39->setCreatedAt(new \DateTimeImmutable('2025-12-09 06:32:40'));
        $manager->persist($activityLog_39);

        $activityLog_40 = new ActivityLog();
        $activityLog_40->setUserEmail('staff@gmail.com');
        $activityLog_40->setUserRole('ROLE_STAFF');
        $activityLog_40->setAction('Logout');
        $activityLog_40->setEntityType(null);
        $activityLog_40->setAffectedData(null);
        $activityLog_40->setDescription('User logged out');
        $activityLog_40->setCreatedAt(new \DateTimeImmutable('2025-12-09 06:36:46'));
        $manager->persist($activityLog_40);

        $activityLog_41 = new ActivityLog();
        $activityLog_41->setUserEmail('admin@example.com');
        $activityLog_41->setUserRole('ROLE_ADMIN');
        $activityLog_41->setAction('Login');
        $activityLog_41->setEntityType(null);
        $activityLog_41->setAffectedData(null);
        $activityLog_41->setDescription('User logged in');
        $activityLog_41->setCreatedAt(new \DateTimeImmutable('2025-12-09 06:36:56'));
        $manager->persist($activityLog_41);

        $activityLog_42 = new ActivityLog();
        $activityLog_42->setUserEmail('admin@example.com');
        $activityLog_42->setUserRole('ROLE_ADMIN');
        $activityLog_42->setAction('Logout');
        $activityLog_42->setEntityType(null);
        $activityLog_42->setAffectedData(null);
        $activityLog_42->setDescription('User logged out');
        $activityLog_42->setCreatedAt(new \DateTimeImmutable('2025-12-09 07:01:51'));
        $manager->persist($activityLog_42);

        $activityLog_43 = new ActivityLog();
        $activityLog_43->setUserEmail('staff@gmail.com');
        $activityLog_43->setUserRole('ROLE_STAFF');
        $activityLog_43->setAction('Login');
        $activityLog_43->setEntityType(null);
        $activityLog_43->setAffectedData(null);
        $activityLog_43->setDescription('User logged in');
        $activityLog_43->setCreatedAt(new \DateTimeImmutable('2025-12-09 07:02:06'));
        $manager->persist($activityLog_43);

        $activityLog_44 = new ActivityLog();
        $activityLog_44->setUserEmail('staff@gmail.com');
        $activityLog_44->setUserRole('ROLE_STAFF');
        $activityLog_44->setAction('Login');
        $activityLog_44->setEntityType(null);
        $activityLog_44->setAffectedData(null);
        $activityLog_44->setDescription('User logged in');
        $activityLog_44->setCreatedAt(new \DateTimeImmutable('2025-12-09 07:02:39'));
        $manager->persist($activityLog_44);

        $activityLog_45 = new ActivityLog();
        $activityLog_45->setUserEmail('staff@gmail.com');
        $activityLog_45->setUserRole('ROLE_STAFF');
        $activityLog_45->setAction('Logout');
        $activityLog_45->setEntityType(null);
        $activityLog_45->setAffectedData(null);
        $activityLog_45->setDescription('User logged out');
        $activityLog_45->setCreatedAt(new \DateTimeImmutable('2025-12-09 07:13:44'));
        $manager->persist($activityLog_45);

        $activityLog_46 = new ActivityLog();
        $activityLog_46->setUserEmail('admin@example.com');
        $activityLog_46->setUserRole('ROLE_ADMIN');
        $activityLog_46->setAction('Login');
        $activityLog_46->setEntityType(null);
        $activityLog_46->setAffectedData(null);
        $activityLog_46->setDescription('User logged in');
        $activityLog_46->setCreatedAt(new \DateTimeImmutable('2025-12-09 07:13:59'));
        $manager->persist($activityLog_46);

        $activityLog_47 = new ActivityLog();
        $activityLog_47->setUserEmail('admin@example.com');
        $activityLog_47->setUserRole('ROLE_ADMIN');
        $activityLog_47->setAction('Update');
        $activityLog_47->setEntityType('User');
        $activityLog_47->setEntityId($this->getReference('user_3', User::class));
        $activityLog_47->setAffectedData('{
    "old": {
        "status": "active"
    },
    "new": {
        "status": "disabled"
    }
}');
        $activityLog_47->setDescription('Changed user status: patrick@gmail.com from active to disabled');
        $activityLog_47->setCreatedAt(new \DateTimeImmutable('2025-12-09 07:21:59'));
        $manager->persist($activityLog_47);

        $activityLog_48 = new ActivityLog();
        $activityLog_48->setUserEmail('admin@example.com');
        $activityLog_48->setUserRole('ROLE_ADMIN');
        $activityLog_48->setAction('Update');
        $activityLog_48->setEntityType('User');
        $activityLog_48->setEntityId($this->getReference('user_3', User::class));
        $activityLog_48->setAffectedData('{
    "old": {
        "status": "disabled"
    },
    "new": {
        "status": "active"
    }
}');
        $activityLog_48->setDescription('Changed user status: patrick@gmail.com from disabled to active');
        $activityLog_48->setCreatedAt(new \DateTimeImmutable('2025-12-09 07:22:06'));
        $manager->persist($activityLog_48);

        $activityLog_49 = new ActivityLog();
        $activityLog_49->setUserEmail('admin@example.com');
        $activityLog_49->setUserRole('ROLE_ADMIN');
        $activityLog_49->setAction('Update');
        $activityLog_49->setEntityType('User');
        $activityLog_49->setEntityId($this->getReference('user_3', User::class));
        $activityLog_49->setAffectedData('{
    "old": {
        "status": "active"
    },
    "new": {
        "status": "disabled"
    }
}');
        $activityLog_49->setDescription('Changed user status: patrick@gmail.com from active to disabled');
        $activityLog_49->setCreatedAt(new \DateTimeImmutable('2025-12-09 07:35:23'));
        $manager->persist($activityLog_49);

        $activityLog_50 = new ActivityLog();
        $activityLog_50->setUserEmail('admin@example.com');
        $activityLog_50->setUserRole('ROLE_ADMIN');
        $activityLog_50->setAction('Update');
        $activityLog_50->setEntityType('User');
        $activityLog_50->setEntityId($this->getReference('user_3', User::class));
        $activityLog_50->setAffectedData('{
    "old": {
        "status": "disabled"
    },
    "new": {
        "status": "active"
    }
}');
        $activityLog_50->setDescription('Changed user status: patrick@gmail.com from disabled to active');
        $activityLog_50->setCreatedAt(new \DateTimeImmutable('2025-12-09 07:35:34'));
        $manager->persist($activityLog_50);

        $activityLog_51 = new ActivityLog();
        $activityLog_51->setUserEmail('admin@example.com');
        $activityLog_51->setUserRole('ROLE_ADMIN');
        $activityLog_51->setAction('Update');
        $activityLog_51->setEntityType('User');
        $activityLog_51->setEntityId($this->getReference('user_3', User::class));
        $activityLog_51->setAffectedData('{
    "old": {
        "email": "patrick@gmail.com",
        "name": null,
        "roles": [
            "ROLE_USER"
        ],
        "status": "active"
    },
    "new": {
        "email": "patrick@gmail.com",
        "name": "Patrick",
        "role": "ROLE_ADMIN",
        "status": "active"
    }
}');
        $activityLog_51->setDescription('Updated user account: patrick@gmail.com');
        $activityLog_51->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:20:45'));
        $manager->persist($activityLog_51);

        $activityLog_52 = new ActivityLog();
        $activityLog_52->setUserEmail('admin@example.com');
        $activityLog_52->setUserRole('ROLE_ADMIN');
        $activityLog_52->setAction('Logout');
        $activityLog_52->setEntityType(null);
        $activityLog_52->setAffectedData(null);
        $activityLog_52->setDescription('User logged out');
        $activityLog_52->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:20:52'));
        $manager->persist($activityLog_52);

        $activityLog_53 = new ActivityLog();
        $activityLog_53->setUserEmail('patrick@gmail.com');
        $activityLog_53->setUserRole('ROLE_ADMIN');
        $activityLog_53->setAction('Login');
        $activityLog_53->setEntityType(null);
        $activityLog_53->setAffectedData(null);
        $activityLog_53->setDescription('User logged in');
        $activityLog_53->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:21:12'));
        $manager->persist($activityLog_53);

        $activityLog_54 = new ActivityLog();
        $activityLog_54->setUserEmail('patrick@gmail.com');
        $activityLog_54->setUserRole('ROLE_ADMIN');
        $activityLog_54->setAction('Logout');
        $activityLog_54->setEntityType(null);
        $activityLog_54->setAffectedData(null);
        $activityLog_54->setDescription('User logged out');
        $activityLog_54->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:21:19'));
        $manager->persist($activityLog_54);

        $activityLog_55 = new ActivityLog();
        $activityLog_55->setUserEmail('admin@example.com');
        $activityLog_55->setUserRole('ROLE_ADMIN');
        $activityLog_55->setAction('Login');
        $activityLog_55->setEntityType(null);
        $activityLog_55->setAffectedData(null);
        $activityLog_55->setDescription('User logged in');
        $activityLog_55->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:21:29'));
        $manager->persist($activityLog_55);

        $activityLog_56 = new ActivityLog();
        $activityLog_56->setUserEmail('admin@example.com');
        $activityLog_56->setUserRole('ROLE_ADMIN');
        $activityLog_56->setAction('Update');
        $activityLog_56->setEntityType('User');
        $activityLog_56->setEntityId($this->getReference('user_3', User::class));
        $activityLog_56->setAffectedData('{
    "old": {
        "email": "patrick@gmail.com",
        "name": "Patrick",
        "roles": [
            "ROLE_ADMIN",
            "ROLE_USER"
        ],
        "status": "active"
    },
    "new": {
        "email": "patrick@gmail.com",
        "name": "Patrick",
        "role": "ROLE_STAFF",
        "status": "active"
    }
}');
        $activityLog_56->setDescription('Updated user account: patrick@gmail.com');
        $activityLog_56->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:21:46'));
        $manager->persist($activityLog_56);

        $activityLog_57 = new ActivityLog();
        $activityLog_57->setUserEmail('admin@example.com');
        $activityLog_57->setUserRole('ROLE_ADMIN');
        $activityLog_57->setAction('Update');
        $activityLog_57->setEntityType('User');
        $activityLog_57->setEntityId($this->getReference('user_3', User::class));
        $activityLog_57->setAffectedData('{
    "old": {
        "email": "patrick@gmail.com",
        "name": "Patrick",
        "roles": [
            "ROLE_STAFF",
            "ROLE_USER"
        ],
        "status": "active"
    },
    "new": {
        "email": "patrick@gmail.com",
        "name": "Patrick",
        "role": "ROLE_USER",
        "status": "active"
    }
}');
        $activityLog_57->setDescription('Updated user account: patrick@gmail.com');
        $activityLog_57->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:22:09'));
        $manager->persist($activityLog_57);

        $activityLog_58 = new ActivityLog();
        $activityLog_58->setUserEmail('admin@example.com');
        $activityLog_58->setUserRole('ROLE_ADMIN');
        $activityLog_58->setAction('Update');
        $activityLog_58->setEntityType('User');
        $activityLog_58->setEntityId($this->getReference('user_2', User::class));
        $activityLog_58->setAffectedData('{
    "old": {
        "email": "louise@gmail.com",
        "name": null,
        "roles": [
            "ROLE_USER"
        ],
        "status": "active"
    },
    "new": {
        "email": "louise@gmail.com",
        "name": "Louise",
        "role": "ROLE_USER",
        "status": "disabled"
    }
}');
        $activityLog_58->setDescription('Updated user account: louise@gmail.com');
        $activityLog_58->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:22:25'));
        $manager->persist($activityLog_58);

        $activityLog_59 = new ActivityLog();
        $activityLog_59->setUserEmail('admin@example.com');
        $activityLog_59->setUserRole('ROLE_ADMIN');
        $activityLog_59->setAction('Logout');
        $activityLog_59->setEntityType(null);
        $activityLog_59->setAffectedData(null);
        $activityLog_59->setDescription('User logged out');
        $activityLog_59->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:22:30'));
        $manager->persist($activityLog_59);

        $activityLog_60 = new ActivityLog();
        $activityLog_60->setUserEmail('louise@gmail.com');
        $activityLog_60->setUserRole('ROLE_USER');
        $activityLog_60->setAction('Login');
        $activityLog_60->setEntityType(null);
        $activityLog_60->setAffectedData(null);
        $activityLog_60->setDescription('User logged in');
        $activityLog_60->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:22:42'));
        $manager->persist($activityLog_60);

        $activityLog_61 = new ActivityLog();
        $activityLog_61->setUserEmail('louise@gmail.com');
        $activityLog_61->setUserRole('ROLE_USER');
        $activityLog_61->setAction('Logout');
        $activityLog_61->setEntityType(null);
        $activityLog_61->setAffectedData(null);
        $activityLog_61->setDescription('User logged out');
        $activityLog_61->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:23:07'));
        $manager->persist($activityLog_61);

        $activityLog_62 = new ActivityLog();
        $activityLog_62->setUserEmail('admin@example.com');
        $activityLog_62->setUserRole('ROLE_ADMIN');
        $activityLog_62->setAction('Login');
        $activityLog_62->setEntityType(null);
        $activityLog_62->setAffectedData(null);
        $activityLog_62->setDescription('User logged in');
        $activityLog_62->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:23:49'));
        $manager->persist($activityLog_62);

        $activityLog_63 = new ActivityLog();
        $activityLog_63->setUserEmail('admin@example.com');
        $activityLog_63->setUserRole('ROLE_ADMIN');
        $activityLog_63->setAction('Logout');
        $activityLog_63->setEntityType(null);
        $activityLog_63->setAffectedData(null);
        $activityLog_63->setDescription('User logged out');
        $activityLog_63->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:26:20'));
        $manager->persist($activityLog_63);

        $activityLog_64 = new ActivityLog();
        $activityLog_64->setUserEmail('admin@example.com');
        $activityLog_64->setUserRole('ROLE_ADMIN');
        $activityLog_64->setAction('Login');
        $activityLog_64->setEntityType(null);
        $activityLog_64->setAffectedData(null);
        $activityLog_64->setDescription('User logged in');
        $activityLog_64->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:26:44'));
        $manager->persist($activityLog_64);

        $activityLog_65 = new ActivityLog();
        $activityLog_65->setUserEmail('admin@example.com');
        $activityLog_65->setUserRole('ROLE_ADMIN');
        $activityLog_65->setAction('Update');
        $activityLog_65->setEntityType('User');
        $activityLog_65->setEntityId($this->getReference('user_3', User::class));
        $activityLog_65->setAffectedData('{
    "old": {
        "status": "active"
    },
    "new": {
        "status": "archived"
    }
}');
        $activityLog_65->setDescription('Changed user status: patrick@gmail.com from active to archived');
        $activityLog_65->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:26:58'));
        $manager->persist($activityLog_65);

        $activityLog_66 = new ActivityLog();
        $activityLog_66->setUserEmail('admin@example.com');
        $activityLog_66->setUserRole('ROLE_ADMIN');
        $activityLog_66->setAction('Logout');
        $activityLog_66->setEntityType(null);
        $activityLog_66->setAffectedData(null);
        $activityLog_66->setDescription('User logged out');
        $activityLog_66->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:27:07'));
        $manager->persist($activityLog_66);

        $activityLog_67 = new ActivityLog();
        $activityLog_67->setUserEmail('admin@example.com');
        $activityLog_67->setUserRole('ROLE_ADMIN');
        $activityLog_67->setAction('Login');
        $activityLog_67->setEntityType(null);
        $activityLog_67->setAffectedData(null);
        $activityLog_67->setDescription('User logged in');
        $activityLog_67->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:27:25'));
        $manager->persist($activityLog_67);

        $activityLog_68 = new ActivityLog();
        $activityLog_68->setUserEmail('admin@example.com');
        $activityLog_68->setUserRole('ROLE_ADMIN');
        $activityLog_68->setAction('Update');
        $activityLog_68->setEntityType('User');
        $activityLog_68->setEntityId($this->getReference('user_3', User::class));
        $activityLog_68->setAffectedData('{
    "old": {
        "email": "patrick@gmail.com",
        "name": "Patrick",
        "roles": [
            "ROLE_USER"
        ],
        "status": "archived"
    },
    "new": {
        "email": "patrick@gmail.com",
        "name": "Patrick",
        "role": "ROLE_USER",
        "status": "active"
    }
}');
        $activityLog_68->setDescription('Updated user account: patrick@gmail.com');
        $activityLog_68->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:27:41'));
        $manager->persist($activityLog_68);

        $activityLog_69 = new ActivityLog();
        $activityLog_69->setUserEmail('admin@example.com');
        $activityLog_69->setUserRole('ROLE_ADMIN');
        $activityLog_69->setAction('Create');
        $activityLog_69->setEntityType('User');
        $activityLog_69->setEntityId($this->getReference('user_5', User::class));
        $activityLog_69->setAffectedData('{
    "email": "jaylaw@gmail.com",
    "role": "ROLE_STAFF",
    "status": "active"
}');
        $activityLog_69->setDescription('Created user account: jaylaw@gmail.com (ROLE_STAFF)');
        $activityLog_69->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:28:25'));
        $manager->persist($activityLog_69);

        $activityLog_70 = new ActivityLog();
        $activityLog_70->setUserEmail('admin@example.com');
        $activityLog_70->setUserRole('ROLE_ADMIN');
        $activityLog_70->setAction('Logout');
        $activityLog_70->setEntityType(null);
        $activityLog_70->setAffectedData(null);
        $activityLog_70->setDescription('User logged out');
        $activityLog_70->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:28:48'));
        $manager->persist($activityLog_70);

        $activityLog_71 = new ActivityLog();
        $activityLog_71->setUserEmail('jaylaw@gmail.com');
        $activityLog_71->setUserRole('ROLE_STAFF');
        $activityLog_71->setAction('Login');
        $activityLog_71->setEntityType(null);
        $activityLog_71->setAffectedData(null);
        $activityLog_71->setDescription('User logged in');
        $activityLog_71->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:28:58'));
        $manager->persist($activityLog_71);

        $activityLog_72 = new ActivityLog();
        $activityLog_72->setUserEmail('jaylaw@gmail.com');
        $activityLog_72->setUserRole('ROLE_STAFF');
        $activityLog_72->setAction('Login');
        $activityLog_72->setEntityType(null);
        $activityLog_72->setAffectedData(null);
        $activityLog_72->setDescription('User logged in');
        $activityLog_72->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:29:45'));
        $manager->persist($activityLog_72);

        $activityLog_73 = new ActivityLog();
        $activityLog_73->setUserEmail('admin@example.com');
        $activityLog_73->setUserRole('ROLE_ADMIN');
        $activityLog_73->setAction('Login');
        $activityLog_73->setEntityType(null);
        $activityLog_73->setAffectedData(null);
        $activityLog_73->setDescription('User logged in');
        $activityLog_73->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:30:32'));
        $manager->persist($activityLog_73);

        $activityLog_74 = new ActivityLog();
        $activityLog_74->setUserEmail('admin@example.com');
        $activityLog_74->setUserRole('ROLE_ADMIN');
        $activityLog_74->setAction('Logout');
        $activityLog_74->setEntityType(null);
        $activityLog_74->setAffectedData(null);
        $activityLog_74->setDescription('User logged out');
        $activityLog_74->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:48:36'));
        $manager->persist($activityLog_74);

        $activityLog_75 = new ActivityLog();
        $activityLog_75->setUserEmail('staff@gmail.com');
        $activityLog_75->setUserRole('ROLE_STAFF');
        $activityLog_75->setAction('Login');
        $activityLog_75->setEntityType(null);
        $activityLog_75->setAffectedData(null);
        $activityLog_75->setDescription('User logged in');
        $activityLog_75->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:49:05'));
        $manager->persist($activityLog_75);

        $activityLog_76 = new ActivityLog();
        $activityLog_76->setUserEmail('staff@gmail.com');
        $activityLog_76->setUserRole('ROLE_STAFF');
        $activityLog_76->setAction('Login');
        $activityLog_76->setEntityType(null);
        $activityLog_76->setAffectedData(null);
        $activityLog_76->setDescription('User logged in');
        $activityLog_76->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:49:35'));
        $manager->persist($activityLog_76);

        $activityLog_77 = new ActivityLog();
        $activityLog_77->setUserEmail('patrick@gmail.com');
        $activityLog_77->setUserRole('ROLE_USER');
        $activityLog_77->setAction('Login');
        $activityLog_77->setEntityType(null);
        $activityLog_77->setAffectedData(null);
        $activityLog_77->setDescription('User logged in');
        $activityLog_77->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:50:24'));
        $manager->persist($activityLog_77);

        $activityLog_78 = new ActivityLog();
        $activityLog_78->setUserEmail('patrick@gmail.com');
        $activityLog_78->setUserRole('ROLE_USER');
        $activityLog_78->setAction('Logout');
        $activityLog_78->setEntityType(null);
        $activityLog_78->setAffectedData(null);
        $activityLog_78->setDescription('User logged out');
        $activityLog_78->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:50:55'));
        $manager->persist($activityLog_78);

        $activityLog_79 = new ActivityLog();
        $activityLog_79->setUserEmail('staff@gmail.com');
        $activityLog_79->setUserRole('ROLE_STAFF');
        $activityLog_79->setAction('Login');
        $activityLog_79->setEntityType(null);
        $activityLog_79->setAffectedData(null);
        $activityLog_79->setDescription('User logged in');
        $activityLog_79->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:51:05'));
        $manager->persist($activityLog_79);

        $activityLog_80 = new ActivityLog();
        $activityLog_80->setUserEmail('admin@example.com');
        $activityLog_80->setUserRole('ROLE_ADMIN');
        $activityLog_80->setAction('Login');
        $activityLog_80->setEntityType(null);
        $activityLog_80->setAffectedData(null);
        $activityLog_80->setDescription('User logged in');
        $activityLog_80->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:59:11'));
        $manager->persist($activityLog_80);

        $activityLog_81 = new ActivityLog();
        $activityLog_81->setUserEmail('admin@example.com');
        $activityLog_81->setUserRole('ROLE_ADMIN');
        $activityLog_81->setAction('Logout');
        $activityLog_81->setEntityType(null);
        $activityLog_81->setAffectedData(null);
        $activityLog_81->setDescription('User logged out');
        $activityLog_81->setCreatedAt(new \DateTimeImmutable('2025-12-09 08:59:51'));
        $manager->persist($activityLog_81);

        $activityLog_82 = new ActivityLog();
        $activityLog_82->setUserEmail('staff@gmail.com');
        $activityLog_82->setUserRole('ROLE_STAFF');
        $activityLog_82->setAction('Login');
        $activityLog_82->setEntityType(null);
        $activityLog_82->setAffectedData(null);
        $activityLog_82->setDescription('User logged in');
        $activityLog_82->setCreatedAt(new \DateTimeImmutable('2025-12-09 09:00:03'));
        $manager->persist($activityLog_82);

        $activityLog_83 = new ActivityLog();
        $activityLog_83->setUserEmail('staff@gmail.com');
        $activityLog_83->setUserRole('ROLE_STAFF');
        $activityLog_83->setAction('Create');
        $activityLog_83->setEntityType('Event');
        $activityLog_83->setEntityId($this->getReference('user_17', User::class));
        $activityLog_83->setAffectedData('{
    "customerName": "Kian",
    "eventType": "Birthday",
    "price": 6500
}');
        $activityLog_83->setDescription('Created event: Kian - Birthday');
        $activityLog_83->setCreatedAt(new \DateTimeImmutable('2025-12-09 09:02:45'));
        $manager->persist($activityLog_83);

        $activityLog_84 = new ActivityLog();
        $activityLog_84->setUserEmail('staff@gmail.com');
        $activityLog_84->setUserRole('ROLE_STAFF');
        $activityLog_84->setAction('Logout');
        $activityLog_84->setEntityType(null);
        $activityLog_84->setAffectedData(null);
        $activityLog_84->setDescription('User logged out');
        $activityLog_84->setCreatedAt(new \DateTimeImmutable('2025-12-09 09:22:43'));
        $manager->persist($activityLog_84);

        $activityLog_85 = new ActivityLog();
        $activityLog_85->setUserEmail('admin@example.com');
        $activityLog_85->setUserRole('ROLE_ADMIN');
        $activityLog_85->setAction('Login');
        $activityLog_85->setEntityType(null);
        $activityLog_85->setAffectedData(null);
        $activityLog_85->setDescription('User logged in');
        $activityLog_85->setCreatedAt(new \DateTimeImmutable('2025-12-09 09:22:56'));
        $manager->persist($activityLog_85);

        $activityLog_86 = new ActivityLog();
        $activityLog_86->setUserEmail('admin@example.com');
        $activityLog_86->setUserRole('ROLE_ADMIN');
        $activityLog_86->setAction('Logout');
        $activityLog_86->setEntityType(null);
        $activityLog_86->setAffectedData(null);
        $activityLog_86->setDescription('User logged out');
        $activityLog_86->setCreatedAt(new \DateTimeImmutable('2025-12-09 09:23:25'));
        $manager->persist($activityLog_86);

        $activityLog_87 = new ActivityLog();
        $activityLog_87->setUserEmail('jaylaw@gmail.com');
        $activityLog_87->setUserRole('ROLE_STAFF');
        $activityLog_87->setAction('Login');
        $activityLog_87->setEntityType(null);
        $activityLog_87->setAffectedData(null);
        $activityLog_87->setDescription('User logged in');
        $activityLog_87->setCreatedAt(new \DateTimeImmutable('2025-12-09 09:23:34'));
        $manager->persist($activityLog_87);

        $activityLog_88 = new ActivityLog();
        $activityLog_88->setUserEmail('jaylaw@gmail.com');
        $activityLog_88->setUserRole('ROLE_STAFF');
        $activityLog_88->setAction('Create');
        $activityLog_88->setEntityType('Event');
        $activityLog_88->setEntityId($this->getReference('user_18', User::class));
        $activityLog_88->setAffectedData('{
    "customerName": "Mark",
    "eventType": "Wedding",
    "price": 0
}');
        $activityLog_88->setDescription('Created event: Mark - Wedding');
        $activityLog_88->setCreatedAt(new \DateTimeImmutable('2025-12-09 09:26:02'));
        $manager->persist($activityLog_88);

        $activityLog_89 = new ActivityLog();
        $activityLog_89->setUserEmail('jaylaw@gmail.com');
        $activityLog_89->setUserRole('ROLE_STAFF');
        $activityLog_89->setAction('Update');
        $activityLog_89->setEntityType('Event');
        $activityLog_89->setEntityId($this->getReference('user_18', User::class));
        $activityLog_89->setAffectedData('{
    "old": {
        "customerName": "Mark",
        "eventType": "Wedding",
        "price": 0
    },
    "new": {
        "customerName": "Mark",
        "eventType": "Wedding",
        "price": 10000
    }
}');
        $activityLog_89->setDescription('Updated event: Mark - Wedding');
        $activityLog_89->setCreatedAt(new \DateTimeImmutable('2025-12-09 09:26:25'));
        $manager->persist($activityLog_89);

        $activityLog_90 = new ActivityLog();
        $activityLog_90->setUserEmail('jaylaw@gmail.com');
        $activityLog_90->setUserRole('ROLE_STAFF');
        $activityLog_90->setAction('Logout');
        $activityLog_90->setEntityType(null);
        $activityLog_90->setAffectedData(null);
        $activityLog_90->setDescription('User logged out');
        $activityLog_90->setCreatedAt(new \DateTimeImmutable('2025-12-09 09:36:32'));
        $manager->persist($activityLog_90);

        $activityLog_91 = new ActivityLog();
        $activityLog_91->setUserEmail('admin@example.com');
        $activityLog_91->setUserRole('ROLE_ADMIN');
        $activityLog_91->setAction('Login');
        $activityLog_91->setEntityType(null);
        $activityLog_91->setAffectedData(null);
        $activityLog_91->setDescription('User logged in');
        $activityLog_91->setCreatedAt(new \DateTimeImmutable('2025-12-09 09:36:45'));
        $manager->persist($activityLog_91);

        $activityLog_92 = new ActivityLog();
        $activityLog_92->setUserEmail('admin@example.com');
        $activityLog_92->setUserRole('ROLE_ADMIN');
        $activityLog_92->setAction('Logout');
        $activityLog_92->setEntityType(null);
        $activityLog_92->setAffectedData(null);
        $activityLog_92->setDescription('User logged out');
        $activityLog_92->setCreatedAt(new \DateTimeImmutable('2025-12-09 10:21:37'));
        $manager->persist($activityLog_92);

        $activityLog_93 = new ActivityLog();
        $activityLog_93->setUserEmail('jaylaw@gmail.com');
        $activityLog_93->setUserRole('ROLE_STAFF');
        $activityLog_93->setAction('Login');
        $activityLog_93->setEntityType(null);
        $activityLog_93->setAffectedData(null);
        $activityLog_93->setDescription('User logged in');
        $activityLog_93->setCreatedAt(new \DateTimeImmutable('2025-12-09 10:21:52'));
        $manager->persist($activityLog_93);

        $activityLog_94 = new ActivityLog();
        $activityLog_94->setUserEmail('jaylaw@gmail.com');
        $activityLog_94->setUserRole('ROLE_STAFF');
        $activityLog_94->setAction('Logout');
        $activityLog_94->setEntityType(null);
        $activityLog_94->setAffectedData(null);
        $activityLog_94->setDescription('User logged out');
        $activityLog_94->setCreatedAt(new \DateTimeImmutable('2025-12-09 10:22:43'));
        $manager->persist($activityLog_94);

        $activityLog_95 = new ActivityLog();
        $activityLog_95->setUserEmail('admin@example.com');
        $activityLog_95->setUserRole('ROLE_ADMIN');
        $activityLog_95->setAction('Login');
        $activityLog_95->setEntityType(null);
        $activityLog_95->setAffectedData(null);
        $activityLog_95->setDescription('User logged in');
        $activityLog_95->setCreatedAt(new \DateTimeImmutable('2025-12-09 10:22:54'));
        $manager->persist($activityLog_95);

        $activityLog_96 = new ActivityLog();
        $activityLog_96->setUserEmail('admin@example.com');
        $activityLog_96->setUserRole('ROLE_ADMIN');
        $activityLog_96->setAction('Logout');
        $activityLog_96->setEntityType(null);
        $activityLog_96->setAffectedData(null);
        $activityLog_96->setDescription('User logged out');
        $activityLog_96->setCreatedAt(new \DateTimeImmutable('2025-12-09 10:59:12'));
        $manager->persist($activityLog_96);

        $activityLog_97 = new ActivityLog();
        $activityLog_97->setUserEmail('admin@example.com');
        $activityLog_97->setUserRole('ROLE_ADMIN');
        $activityLog_97->setAction('Login');
        $activityLog_97->setEntityType(null);
        $activityLog_97->setAffectedData(null);
        $activityLog_97->setDescription('User logged in');
        $activityLog_97->setCreatedAt(new \DateTimeImmutable('2025-12-09 11:11:27'));
        $manager->persist($activityLog_97);

        $activityLog_98 = new ActivityLog();
        $activityLog_98->setUserEmail('admin@example.com');
        $activityLog_98->setUserRole('ROLE_ADMIN');
        $activityLog_98->setAction('Logout');
        $activityLog_98->setEntityType(null);
        $activityLog_98->setAffectedData(null);
        $activityLog_98->setDescription('User logged out');
        $activityLog_98->setCreatedAt(new \DateTimeImmutable('2025-12-09 11:12:00'));
        $manager->persist($activityLog_98);

        $activityLog_99 = new ActivityLog();
        $activityLog_99->setUserEmail('admin@example.com');
        $activityLog_99->setUserRole('ROLE_ADMIN');
        $activityLog_99->setAction('Login');
        $activityLog_99->setEntityType(null);
        $activityLog_99->setAffectedData(null);
        $activityLog_99->setDescription('User logged in');
        $activityLog_99->setCreatedAt(new \DateTimeImmutable('2025-12-09 11:35:41'));
        $manager->persist($activityLog_99);

        $activityLog_100 = new ActivityLog();
        $activityLog_100->setUserEmail('admin@example.com');
        $activityLog_100->setUserRole('ROLE_ADMIN');
        $activityLog_100->setAction('Logout');
        $activityLog_100->setEntityType(null);
        $activityLog_100->setAffectedData(null);
        $activityLog_100->setDescription('User logged out');
        $activityLog_100->setCreatedAt(new \DateTimeImmutable('2025-12-09 11:57:47'));
        $manager->persist($activityLog_100);

        $activityLog_101 = new ActivityLog();
        $activityLog_101->setUserEmail('jaylaw@gmail.com');
        $activityLog_101->setUserRole('ROLE_STAFF');
        $activityLog_101->setAction('Login');
        $activityLog_101->setEntityType(null);
        $activityLog_101->setAffectedData(null);
        $activityLog_101->setDescription('User logged in');
        $activityLog_101->setCreatedAt(new \DateTimeImmutable('2025-12-09 11:57:59'));
        $manager->persist($activityLog_101);

        $activityLog_102 = new ActivityLog();
        $activityLog_102->setUserEmail('jaylaw@gmail.com');
        $activityLog_102->setUserRole('ROLE_STAFF');
        $activityLog_102->setAction('Logout');
        $activityLog_102->setEntityType(null);
        $activityLog_102->setAffectedData(null);
        $activityLog_102->setDescription('User logged out');
        $activityLog_102->setCreatedAt(new \DateTimeImmutable('2025-12-09 11:58:31'));
        $manager->persist($activityLog_102);

        $activityLog_103 = new ActivityLog();
        $activityLog_103->setUserEmail('admin@example.com');
        $activityLog_103->setUserRole('ROLE_ADMIN');
        $activityLog_103->setAction('Login');
        $activityLog_103->setEntityType(null);
        $activityLog_103->setAffectedData(null);
        $activityLog_103->setDescription('User logged in');
        $activityLog_103->setCreatedAt(new \DateTimeImmutable('2025-12-09 11:58:51'));
        $manager->persist($activityLog_103);

        $activityLog_104 = new ActivityLog();
        $activityLog_104->setUserEmail('admin@example.com');
        $activityLog_104->setUserRole('ROLE_ADMIN');
        $activityLog_104->setAction('Logout');
        $activityLog_104->setEntityType(null);
        $activityLog_104->setAffectedData(null);
        $activityLog_104->setDescription('User logged out');
        $activityLog_104->setCreatedAt(new \DateTimeImmutable('2025-12-09 12:42:05'));
        $manager->persist($activityLog_104);

        $activityLog_105 = new ActivityLog();
        $activityLog_105->setUserEmail('admin@example.com');
        $activityLog_105->setUserRole('ROLE_ADMIN');
        $activityLog_105->setAction('Login');
        $activityLog_105->setEntityType(null);
        $activityLog_105->setAffectedData(null);
        $activityLog_105->setDescription('User logged in');
        $activityLog_105->setCreatedAt(new \DateTimeImmutable('2025-12-09 12:42:38'));
        $manager->persist($activityLog_105);

        $activityLog_106 = new ActivityLog();
        $activityLog_106->setUserEmail('admin@example.com');
        $activityLog_106->setUserRole('ROLE_ADMIN');
        $activityLog_106->setAction('Logout');
        $activityLog_106->setEntityType(null);
        $activityLog_106->setAffectedData(null);
        $activityLog_106->setDescription('User logged out');
        $activityLog_106->setCreatedAt(new \DateTimeImmutable('2025-12-09 12:47:00'));
        $manager->persist($activityLog_106);

        $activityLog_107 = new ActivityLog();
        $activityLog_107->setUserEmail('admin@example.com');
        $activityLog_107->setUserRole('ROLE_ADMIN');
        $activityLog_107->setAction('Login');
        $activityLog_107->setEntityType(null);
        $activityLog_107->setAffectedData(null);
        $activityLog_107->setDescription('User logged in');
        $activityLog_107->setCreatedAt(new \DateTimeImmutable('2025-12-09 12:52:41'));
        $manager->persist($activityLog_107);

        $activityLog_108 = new ActivityLog();
        $activityLog_108->setUserEmail('admin@example.com');
        $activityLog_108->setUserRole('ROLE_ADMIN');
        $activityLog_108->setAction('Logout');
        $activityLog_108->setEntityType(null);
        $activityLog_108->setAffectedData(null);
        $activityLog_108->setDescription('User logged out');
        $activityLog_108->setCreatedAt(new \DateTimeImmutable('2025-12-09 12:54:10'));
        $manager->persist($activityLog_108);

        $activityLog_109 = new ActivityLog();
        $activityLog_109->setUserEmail('admin@example.com');
        $activityLog_109->setUserRole('ROLE_ADMIN');
        $activityLog_109->setAction('Login');
        $activityLog_109->setEntityType(null);
        $activityLog_109->setAffectedData(null);
        $activityLog_109->setDescription('User logged in');
        $activityLog_109->setCreatedAt(new \DateTimeImmutable('2025-12-09 13:27:49'));
        $manager->persist($activityLog_109);

        $activityLog_110 = new ActivityLog();
        $activityLog_110->setUserEmail('admin@example.com');
        $activityLog_110->setUserRole('ROLE_ADMIN');
        $activityLog_110->setAction('Logout');
        $activityLog_110->setEntityType(null);
        $activityLog_110->setAffectedData(null);
        $activityLog_110->setDescription('User logged out');
        $activityLog_110->setCreatedAt(new \DateTimeImmutable('2025-12-09 13:28:25'));
        $manager->persist($activityLog_110);

        $activityLog_111 = new ActivityLog();
        $activityLog_111->setUserEmail('patrick@gmail.com');
        $activityLog_111->setUserRole('ROLE_USER');
        $activityLog_111->setAction('Login');
        $activityLog_111->setEntityType(null);
        $activityLog_111->setAffectedData(null);
        $activityLog_111->setDescription('User logged in');
        $activityLog_111->setCreatedAt(new \DateTimeImmutable('2025-12-09 13:28:41'));
        $manager->persist($activityLog_111);

        $activityLog_112 = new ActivityLog();
        $activityLog_112->setUserEmail('patrick@gmail.com');
        $activityLog_112->setUserRole('ROLE_USER');
        $activityLog_112->setAction('Logout');
        $activityLog_112->setEntityType(null);
        $activityLog_112->setAffectedData(null);
        $activityLog_112->setDescription('User logged out');
        $activityLog_112->setCreatedAt(new \DateTimeImmutable('2025-12-09 13:30:14'));
        $manager->persist($activityLog_112);

        $activityLog_113 = new ActivityLog();
        $activityLog_113->setUserEmail('admin@example.com');
        $activityLog_113->setUserRole('ROLE_ADMIN');
        $activityLog_113->setAction('Login');
        $activityLog_113->setEntityType(null);
        $activityLog_113->setAffectedData(null);
        $activityLog_113->setDescription('User logged in');
        $activityLog_113->setCreatedAt(new \DateTimeImmutable('2025-12-09 13:30:43'));
        $manager->persist($activityLog_113);

        $activityLog_114 = new ActivityLog();
        $activityLog_114->setUserEmail('admin@example.com');
        $activityLog_114->setUserRole('ROLE_ADMIN');
        $activityLog_114->setAction('Logout');
        $activityLog_114->setEntityType(null);
        $activityLog_114->setAffectedData(null);
        $activityLog_114->setDescription('User logged out');
        $activityLog_114->setCreatedAt(new \DateTimeImmutable('2025-12-09 13:32:36'));
        $manager->persist($activityLog_114);

        $activityLog_115 = new ActivityLog();
        $activityLog_115->setUserEmail('admin@example.com');
        $activityLog_115->setUserRole('ROLE_ADMIN');
        $activityLog_115->setAction('Login');
        $activityLog_115->setEntityType(null);
        $activityLog_115->setAffectedData(null);
        $activityLog_115->setDescription('User logged in');
        $activityLog_115->setCreatedAt(new \DateTimeImmutable('2025-12-09 13:33:06'));
        $manager->persist($activityLog_115);

        $activityLog_116 = new ActivityLog();
        $activityLog_116->setUserEmail('admin@example.com');
        $activityLog_116->setUserRole('ROLE_ADMIN');
        $activityLog_116->setAction('Logout');
        $activityLog_116->setEntityType(null);
        $activityLog_116->setAffectedData(null);
        $activityLog_116->setDescription('User logged out');
        $activityLog_116->setCreatedAt(new \DateTimeImmutable('2025-12-09 13:34:06'));
        $manager->persist($activityLog_116);

        $activityLog_117 = new ActivityLog();
        $activityLog_117->setUserEmail('staff@gmail.com');
        $activityLog_117->setUserRole('ROLE_STAFF');
        $activityLog_117->setAction('Login');
        $activityLog_117->setEntityType(null);
        $activityLog_117->setAffectedData(null);
        $activityLog_117->setDescription('User logged in');
        $activityLog_117->setCreatedAt(new \DateTimeImmutable('2025-12-09 13:34:22'));
        $manager->persist($activityLog_117);

        $activityLog_118 = new ActivityLog();
        $activityLog_118->setUserEmail('staff@gmail.com');
        $activityLog_118->setUserRole('ROLE_STAFF');
        $activityLog_118->setAction('Logout');
        $activityLog_118->setEntityType(null);
        $activityLog_118->setAffectedData(null);
        $activityLog_118->setDescription('User logged out');
        $activityLog_118->setCreatedAt(new \DateTimeImmutable('2025-12-09 13:34:38'));
        $manager->persist($activityLog_118);

        $activityLog_119 = new ActivityLog();
        $activityLog_119->setUserEmail('admin@example.com');
        $activityLog_119->setUserRole('ROLE_ADMIN');
        $activityLog_119->setAction('Login');
        $activityLog_119->setEntityType(null);
        $activityLog_119->setAffectedData(null);
        $activityLog_119->setDescription('User logged in');
        $activityLog_119->setCreatedAt(new \DateTimeImmutable('2025-12-09 13:34:50'));
        $manager->persist($activityLog_119);

        $activityLog_120 = new ActivityLog();
        $activityLog_120->setUserEmail('admin@example.com');
        $activityLog_120->setUserRole('ROLE_ADMIN');
        $activityLog_120->setAction('Logout');
        $activityLog_120->setEntityType(null);
        $activityLog_120->setAffectedData(null);
        $activityLog_120->setDescription('User logged out');
        $activityLog_120->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:13:05'));
        $manager->persist($activityLog_120);

        $activityLog_121 = new ActivityLog();
        $activityLog_121->setUserEmail('admin@example.com');
        $activityLog_121->setUserRole('ROLE_ADMIN');
        $activityLog_121->setAction('Login');
        $activityLog_121->setEntityType(null);
        $activityLog_121->setAffectedData(null);
        $activityLog_121->setDescription('User logged in');
        $activityLog_121->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:15:30'));
        $manager->persist($activityLog_121);

        $activityLog_122 = new ActivityLog();
        $activityLog_122->setUserEmail('admin@example.com');
        $activityLog_122->setUserRole('ROLE_ADMIN');
        $activityLog_122->setAction('Logout');
        $activityLog_122->setEntityType(null);
        $activityLog_122->setAffectedData(null);
        $activityLog_122->setDescription('User logged out');
        $activityLog_122->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:15:39'));
        $manager->persist($activityLog_122);

        $activityLog_123 = new ActivityLog();
        $activityLog_123->setUserEmail('patrick@gmail.com');
        $activityLog_123->setUserRole('ROLE_USER');
        $activityLog_123->setAction('Login');
        $activityLog_123->setEntityType(null);
        $activityLog_123->setAffectedData(null);
        $activityLog_123->setDescription('User logged in');
        $activityLog_123->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:15:46'));
        $manager->persist($activityLog_123);

        $activityLog_124 = new ActivityLog();
        $activityLog_124->setUserEmail('patrick@gmail.com');
        $activityLog_124->setUserRole('ROLE_USER');
        $activityLog_124->setAction('Logout');
        $activityLog_124->setEntityType(null);
        $activityLog_124->setAffectedData(null);
        $activityLog_124->setDescription('User logged out');
        $activityLog_124->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:15:55'));
        $manager->persist($activityLog_124);

        $activityLog_125 = new ActivityLog();
        $activityLog_125->setUserEmail('patrick@gmail.com');
        $activityLog_125->setUserRole('ROLE_USER');
        $activityLog_125->setAction('Login');
        $activityLog_125->setEntityType(null);
        $activityLog_125->setAffectedData(null);
        $activityLog_125->setDescription('User logged in');
        $activityLog_125->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:16:09'));
        $manager->persist($activityLog_125);

        $activityLog_126 = new ActivityLog();
        $activityLog_126->setUserEmail('patrick@gmail.com');
        $activityLog_126->setUserRole('ROLE_USER');
        $activityLog_126->setAction('Logout');
        $activityLog_126->setEntityType(null);
        $activityLog_126->setAffectedData(null);
        $activityLog_126->setDescription('User logged out');
        $activityLog_126->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:16:19'));
        $manager->persist($activityLog_126);

        $activityLog_127 = new ActivityLog();
        $activityLog_127->setUserEmail('patrick@gmail.com');
        $activityLog_127->setUserRole('ROLE_USER');
        $activityLog_127->setAction('Login');
        $activityLog_127->setEntityType(null);
        $activityLog_127->setAffectedData(null);
        $activityLog_127->setDescription('User logged in');
        $activityLog_127->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:17:42'));
        $manager->persist($activityLog_127);

        $activityLog_128 = new ActivityLog();
        $activityLog_128->setUserEmail('patrick@gmail.com');
        $activityLog_128->setUserRole('ROLE_USER');
        $activityLog_128->setAction('Logout');
        $activityLog_128->setEntityType(null);
        $activityLog_128->setAffectedData(null);
        $activityLog_128->setDescription('User logged out');
        $activityLog_128->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:18:39'));
        $manager->persist($activityLog_128);

        $activityLog_129 = new ActivityLog();
        $activityLog_129->setUserEmail('patrick@gmail.com');
        $activityLog_129->setUserRole('ROLE_USER');
        $activityLog_129->setAction('Login');
        $activityLog_129->setEntityType(null);
        $activityLog_129->setAffectedData(null);
        $activityLog_129->setDescription('User logged in');
        $activityLog_129->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:18:50'));
        $manager->persist($activityLog_129);

        $activityLog_130 = new ActivityLog();
        $activityLog_130->setUserEmail('patrick@gmail.com');
        $activityLog_130->setUserRole('ROLE_USER');
        $activityLog_130->setAction('Logout');
        $activityLog_130->setEntityType(null);
        $activityLog_130->setAffectedData(null);
        $activityLog_130->setDescription('User logged out');
        $activityLog_130->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:22:41'));
        $manager->persist($activityLog_130);

        $activityLog_131 = new ActivityLog();
        $activityLog_131->setUserEmail('admin@example.com');
        $activityLog_131->setUserRole('ROLE_ADMIN');
        $activityLog_131->setAction('Login');
        $activityLog_131->setEntityType(null);
        $activityLog_131->setAffectedData(null);
        $activityLog_131->setDescription('User logged in');
        $activityLog_131->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:22:52'));
        $manager->persist($activityLog_131);

        $activityLog_132 = new ActivityLog();
        $activityLog_132->setUserEmail('admin@example.com');
        $activityLog_132->setUserRole('ROLE_ADMIN');
        $activityLog_132->setAction('Logout');
        $activityLog_132->setEntityType(null);
        $activityLog_132->setAffectedData(null);
        $activityLog_132->setDescription('User logged out');
        $activityLog_132->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:23:22'));
        $manager->persist($activityLog_132);

        $activityLog_133 = new ActivityLog();
        $activityLog_133->setUserEmail('patrick@gmail.com');
        $activityLog_133->setUserRole('ROLE_USER');
        $activityLog_133->setAction('Login');
        $activityLog_133->setEntityType(null);
        $activityLog_133->setAffectedData(null);
        $activityLog_133->setDescription('User logged in');
        $activityLog_133->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:23:30'));
        $manager->persist($activityLog_133);

        $activityLog_134 = new ActivityLog();
        $activityLog_134->setUserEmail('patrick@gmail.com');
        $activityLog_134->setUserRole('ROLE_USER');
        $activityLog_134->setAction('Logout');
        $activityLog_134->setEntityType(null);
        $activityLog_134->setAffectedData(null);
        $activityLog_134->setDescription('User logged out');
        $activityLog_134->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:24:41'));
        $manager->persist($activityLog_134);

        $activityLog_135 = new ActivityLog();
        $activityLog_135->setUserEmail('admin@example.com');
        $activityLog_135->setUserRole('ROLE_ADMIN');
        $activityLog_135->setAction('Login');
        $activityLog_135->setEntityType(null);
        $activityLog_135->setAffectedData(null);
        $activityLog_135->setDescription('User logged in');
        $activityLog_135->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:48:13'));
        $manager->persist($activityLog_135);

        $activityLog_136 = new ActivityLog();
        $activityLog_136->setUserEmail('admin@example.com');
        $activityLog_136->setUserRole('ROLE_ADMIN');
        $activityLog_136->setAction('Logout');
        $activityLog_136->setEntityType(null);
        $activityLog_136->setAffectedData(null);
        $activityLog_136->setDescription('User logged out');
        $activityLog_136->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:48:54'));
        $manager->persist($activityLog_136);

        $activityLog_137 = new ActivityLog();
        $activityLog_137->setUserEmail('patrick@gmail.com');
        $activityLog_137->setUserRole('ROLE_USER');
        $activityLog_137->setAction('Login');
        $activityLog_137->setEntityType(null);
        $activityLog_137->setAffectedData(null);
        $activityLog_137->setDescription('User logged in');
        $activityLog_137->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:49:37'));
        $manager->persist($activityLog_137);

        $activityLog_138 = new ActivityLog();
        $activityLog_138->setUserEmail('patrick@gmail.com');
        $activityLog_138->setUserRole('ROLE_USER');
        $activityLog_138->setAction('Logout');
        $activityLog_138->setEntityType(null);
        $activityLog_138->setAffectedData(null);
        $activityLog_138->setDescription('User logged out');
        $activityLog_138->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:59:13'));
        $manager->persist($activityLog_138);

        $activityLog_139 = new ActivityLog();
        $activityLog_139->setUserEmail('admin@example.com');
        $activityLog_139->setUserRole('ROLE_ADMIN');
        $activityLog_139->setAction('Login');
        $activityLog_139->setEntityType(null);
        $activityLog_139->setAffectedData(null);
        $activityLog_139->setDescription('User logged in');
        $activityLog_139->setCreatedAt(new \DateTimeImmutable('2025-12-10 03:59:52'));
        $manager->persist($activityLog_139);

        $activityLog_140 = new ActivityLog();
        $activityLog_140->setUserEmail('admin@example.com');
        $activityLog_140->setUserRole('ROLE_ADMIN');
        $activityLog_140->setAction('Logout');
        $activityLog_140->setEntityType(null);
        $activityLog_140->setAffectedData(null);
        $activityLog_140->setDescription('User logged out');
        $activityLog_140->setCreatedAt(new \DateTimeImmutable('2025-12-10 04:00:19'));
        $manager->persist($activityLog_140);

        $activityLog_141 = new ActivityLog();
        $activityLog_141->setUserEmail('patrick@gmail.com');
        $activityLog_141->setUserRole('ROLE_USER');
        $activityLog_141->setAction('Login');
        $activityLog_141->setEntityType(null);
        $activityLog_141->setAffectedData(null);
        $activityLog_141->setDescription('User logged in');
        $activityLog_141->setCreatedAt(new \DateTimeImmutable('2025-12-10 04:01:06'));
        $manager->persist($activityLog_141);

        $activityLog_142 = new ActivityLog();
        $activityLog_142->setUserEmail('patrick@gmail.com');
        $activityLog_142->setUserRole('ROLE_USER');
        $activityLog_142->setAction('Logout');
        $activityLog_142->setEntityType(null);
        $activityLog_142->setAffectedData(null);
        $activityLog_142->setDescription('User logged out');
        $activityLog_142->setCreatedAt(new \DateTimeImmutable('2025-12-10 04:01:16'));
        $manager->persist($activityLog_142);

        $activityLog_143 = new ActivityLog();
        $activityLog_143->setUserEmail('admin@example.com');
        $activityLog_143->setUserRole('ROLE_ADMIN');
        $activityLog_143->setAction('Login');
        $activityLog_143->setEntityType(null);
        $activityLog_143->setAffectedData(null);
        $activityLog_143->setDescription('User logged in');
        $activityLog_143->setCreatedAt(new \DateTimeImmutable('2025-12-10 04:08:49'));
        $manager->persist($activityLog_143);

        $activityLog_144 = new ActivityLog();
        $activityLog_144->setUserEmail('admin@example.com');
        $activityLog_144->setUserRole('ROLE_ADMIN');
        $activityLog_144->setAction('Logout');
        $activityLog_144->setEntityType(null);
        $activityLog_144->setAffectedData(null);
        $activityLog_144->setDescription('User logged out');
        $activityLog_144->setCreatedAt(new \DateTimeImmutable('2025-12-10 04:10:06'));
        $manager->persist($activityLog_144);

        $activityLog_145 = new ActivityLog();
        $activityLog_145->setUserEmail('staff@gmail.com');
        $activityLog_145->setUserRole('ROLE_STAFF');
        $activityLog_145->setAction('Login');
        $activityLog_145->setEntityType(null);
        $activityLog_145->setAffectedData(null);
        $activityLog_145->setDescription('User logged in');
        $activityLog_145->setCreatedAt(new \DateTimeImmutable('2025-12-10 04:10:17'));
        $manager->persist($activityLog_145);

        $activityLog_146 = new ActivityLog();
        $activityLog_146->setUserEmail('staff@gmail.com');
        $activityLog_146->setUserRole('ROLE_STAFF');
        $activityLog_146->setAction('Logout');
        $activityLog_146->setEntityType(null);
        $activityLog_146->setAffectedData(null);
        $activityLog_146->setDescription('User logged out');
        $activityLog_146->setCreatedAt(new \DateTimeImmutable('2025-12-10 04:11:12'));
        $manager->persist($activityLog_146);

        $activityLog_147 = new ActivityLog();
        $activityLog_147->setUserEmail('admin@example.com');
        $activityLog_147->setUserRole('ROLE_ADMIN');
        $activityLog_147->setAction('Login');
        $activityLog_147->setEntityType(null);
        $activityLog_147->setAffectedData(null);
        $activityLog_147->setDescription('User logged in');
        $activityLog_147->setCreatedAt(new \DateTimeImmutable('2025-12-10 04:52:50'));
        $manager->persist($activityLog_147);

        $activityLog_148 = new ActivityLog();
        $activityLog_148->setUserEmail('admin@example.com');
        $activityLog_148->setUserRole('ROLE_ADMIN');
        $activityLog_148->setAction('Logout');
        $activityLog_148->setEntityType(null);
        $activityLog_148->setAffectedData(null);
        $activityLog_148->setDescription('User logged out');
        $activityLog_148->setCreatedAt(new \DateTimeImmutable('2025-12-10 04:53:46'));
        $manager->persist($activityLog_148);

        $activityLog_149 = new ActivityLog();
        $activityLog_149->setUserEmail('patrick@gmail.com');
        $activityLog_149->setUserRole('ROLE_USER');
        $activityLog_149->setAction('Login');
        $activityLog_149->setEntityType(null);
        $activityLog_149->setAffectedData(null);
        $activityLog_149->setDescription('User logged in');
        $activityLog_149->setCreatedAt(new \DateTimeImmutable('2025-12-10 04:59:33'));
        $manager->persist($activityLog_149);

        $activityLog_150 = new ActivityLog();
        $activityLog_150->setUserEmail('admin@example.com');
        $activityLog_150->setUserRole('ROLE_ADMIN');
        $activityLog_150->setAction('Login');
        $activityLog_150->setEntityType(null);
        $activityLog_150->setAffectedData(null);
        $activityLog_150->setDescription('User logged in');
        $activityLog_150->setCreatedAt(new \DateTimeImmutable('2025-12-10 06:02:31'));
        $manager->persist($activityLog_150);

        $activityLog_151 = new ActivityLog();
        $activityLog_151->setUserEmail('admin@example.com');
        $activityLog_151->setUserRole('ROLE_ADMIN');
        $activityLog_151->setAction('Logout');
        $activityLog_151->setEntityType(null);
        $activityLog_151->setAffectedData(null);
        $activityLog_151->setDescription('User logged out');
        $activityLog_151->setCreatedAt(new \DateTimeImmutable('2025-12-10 06:03:16'));
        $manager->persist($activityLog_151);

        $activityLog_152 = new ActivityLog();
        $activityLog_152->setUserEmail('admin@example.com');
        $activityLog_152->setUserRole('ROLE_ADMIN');
        $activityLog_152->setAction('Login');
        $activityLog_152->setEntityType(null);
        $activityLog_152->setAffectedData(null);
        $activityLog_152->setDescription('User logged in');
        $activityLog_152->setCreatedAt(new \DateTimeImmutable('2025-12-10 06:32:34'));
        $manager->persist($activityLog_152);

        $activityLog_153 = new ActivityLog();
        $activityLog_153->setUserEmail('admin@example.com');
        $activityLog_153->setUserRole('ROLE_ADMIN');
        $activityLog_153->setAction('Logout');
        $activityLog_153->setEntityType(null);
        $activityLog_153->setAffectedData(null);
        $activityLog_153->setDescription('User logged out');
        $activityLog_153->setCreatedAt(new \DateTimeImmutable('2025-12-10 06:35:01'));
        $manager->persist($activityLog_153);

        $activityLog_154 = new ActivityLog();
        $activityLog_154->setUserEmail('admin@example.com');
        $activityLog_154->setUserRole('ROLE_ADMIN');
        $activityLog_154->setAction('Login');
        $activityLog_154->setEntityType(null);
        $activityLog_154->setAffectedData(null);
        $activityLog_154->setDescription('User logged in');
        $activityLog_154->setCreatedAt(new \DateTimeImmutable('2025-12-10 06:35:18'));
        $manager->persist($activityLog_154);

        $activityLog_155 = new ActivityLog();
        $activityLog_155->setUserEmail('admin@example.com');
        $activityLog_155->setUserRole('ROLE_ADMIN');
        $activityLog_155->setAction('Logout');
        $activityLog_155->setEntityType(null);
        $activityLog_155->setAffectedData(null);
        $activityLog_155->setDescription('User logged out');
        $activityLog_155->setCreatedAt(new \DateTimeImmutable('2025-12-10 06:43:44'));
        $manager->persist($activityLog_155);

        $activityLog_156 = new ActivityLog();
        $activityLog_156->setUserEmail('admin@example.com');
        $activityLog_156->setUserRole('ROLE_ADMIN');
        $activityLog_156->setAction('Login');
        $activityLog_156->setEntityType(null);
        $activityLog_156->setAffectedData(null);
        $activityLog_156->setDescription('User logged in');
        $activityLog_156->setCreatedAt(new \DateTimeImmutable('2025-12-10 06:44:03'));
        $manager->persist($activityLog_156);

        $activityLog_157 = new ActivityLog();
        $activityLog_157->setUserEmail('admin@example.com');
        $activityLog_157->setUserRole('ROLE_ADMIN');
        $activityLog_157->setAction('Login');
        $activityLog_157->setEntityType(null);
        $activityLog_157->setAffectedData(null);
        $activityLog_157->setDescription('User logged in');
        $activityLog_157->setCreatedAt(new \DateTimeImmutable('2025-12-10 09:10:54'));
        $manager->persist($activityLog_157);

        $activityLog_158 = new ActivityLog();
        $activityLog_158->setUserEmail('admin@example.com');
        $activityLog_158->setUserRole('ROLE_ADMIN');
        $activityLog_158->setAction('Logout');
        $activityLog_158->setEntityType(null);
        $activityLog_158->setAffectedData(null);
        $activityLog_158->setDescription('User logged out');
        $activityLog_158->setCreatedAt(new \DateTimeImmutable('2025-12-10 09:15:26'));
        $manager->persist($activityLog_158);

        $activityLog_159 = new ActivityLog();
        $activityLog_159->setUserEmail('admin@example.com');
        $activityLog_159->setUserRole('ROLE_ADMIN');
        $activityLog_159->setAction('Login');
        $activityLog_159->setEntityType(null);
        $activityLog_159->setAffectedData(null);
        $activityLog_159->setDescription('User logged in');
        $activityLog_159->setCreatedAt(new \DateTimeImmutable('2025-12-10 09:30:39'));
        $manager->persist($activityLog_159);

        $activityLog_160 = new ActivityLog();
        $activityLog_160->setUserEmail('admin@example.com');
        $activityLog_160->setUserRole('ROLE_ADMIN');
        $activityLog_160->setAction('Logout');
        $activityLog_160->setEntityType(null);
        $activityLog_160->setAffectedData(null);
        $activityLog_160->setDescription('User logged out');
        $activityLog_160->setCreatedAt(new \DateTimeImmutable('2025-12-10 09:56:56'));
        $manager->persist($activityLog_160);

        $activityLog_161 = new ActivityLog();
        $activityLog_161->setUserEmail('admin@example.com');
        $activityLog_161->setUserRole('ROLE_ADMIN');
        $activityLog_161->setAction('Login');
        $activityLog_161->setEntityType(null);
        $activityLog_161->setAffectedData(null);
        $activityLog_161->setDescription('User logged in');
        $activityLog_161->setCreatedAt(new \DateTimeImmutable('2025-12-10 10:24:03'));
        $manager->persist($activityLog_161);

        $activityLog_162 = new ActivityLog();
        $activityLog_162->setUserEmail('admin@example.com');
        $activityLog_162->setUserRole('ROLE_ADMIN');
        $activityLog_162->setAction('Logout');
        $activityLog_162->setEntityType(null);
        $activityLog_162->setAffectedData(null);
        $activityLog_162->setDescription('User logged out');
        $activityLog_162->setCreatedAt(new \DateTimeImmutable('2025-12-10 10:24:38'));
        $manager->persist($activityLog_162);

        $activityLog_163 = new ActivityLog();
        $activityLog_163->setUserEmail('patrick@gmail.com');
        $activityLog_163->setUserRole('ROLE_USER');
        $activityLog_163->setAction('Login');
        $activityLog_163->setEntityType(null);
        $activityLog_163->setAffectedData(null);
        $activityLog_163->setDescription('User logged in');
        $activityLog_163->setCreatedAt(new \DateTimeImmutable('2025-12-10 12:46:45'));
        $manager->persist($activityLog_163);

        $activityLog_164 = new ActivityLog();
        $activityLog_164->setUserEmail('patrick@gmail.com');
        $activityLog_164->setUserRole('ROLE_USER');
        $activityLog_164->setAction('Logout');
        $activityLog_164->setEntityType(null);
        $activityLog_164->setAffectedData(null);
        $activityLog_164->setDescription('User logged out');
        $activityLog_164->setCreatedAt(new \DateTimeImmutable('2025-12-10 12:46:56'));
        $manager->persist($activityLog_164);

        $activityLog_165 = new ActivityLog();
        $activityLog_165->setUserEmail('staff@gmail.com');
        $activityLog_165->setUserRole('ROLE_STAFF');
        $activityLog_165->setAction('Login');
        $activityLog_165->setEntityType(null);
        $activityLog_165->setAffectedData(null);
        $activityLog_165->setDescription('User logged in');
        $activityLog_165->setCreatedAt(new \DateTimeImmutable('2025-12-10 12:47:09'));
        $manager->persist($activityLog_165);

        $activityLog_166 = new ActivityLog();
        $activityLog_166->setUserEmail('staff@gmail.com');
        $activityLog_166->setUserRole('ROLE_STAFF');
        $activityLog_166->setAction('Create');
        $activityLog_166->setEntityType('Event');
        $activityLog_166->setEntityId($this->getReference('user_19', User::class));
        $activityLog_166->setAffectedData('{
    "customerName": "Tatoy",
    "eventType": "Birthday",
    "price": 1500
}');
        $activityLog_166->setDescription('Created event: Tatoy - Birthday');
        $activityLog_166->setCreatedAt(new \DateTimeImmutable('2025-12-10 12:49:59'));
        $manager->persist($activityLog_166);

        $activityLog_167 = new ActivityLog();
        $activityLog_167->setUserEmail('staff@gmail.com');
        $activityLog_167->setUserRole('ROLE_STAFF');
        $activityLog_167->setAction('Delete');
        $activityLog_167->setEntityType('Event');
        $activityLog_167->setEntityId($this->getReference('user_19', User::class));
        $activityLog_167->setAffectedData('{
    "customerName": "Tatoy",
    "eventType": "Birthday",
    "price": 1500
}');
        $activityLog_167->setDescription('Deleted event: Tatoy - Birthday');
        $activityLog_167->setCreatedAt(new \DateTimeImmutable('2025-12-10 12:50:22'));
        $manager->persist($activityLog_167);

        $activityLog_168 = new ActivityLog();
        $activityLog_168->setUserEmail('staff@gmail.com');
        $activityLog_168->setUserRole('ROLE_STAFF');
        $activityLog_168->setAction('Logout');
        $activityLog_168->setEntityType(null);
        $activityLog_168->setAffectedData(null);
        $activityLog_168->setDescription('User logged out');
        $activityLog_168->setCreatedAt(new \DateTimeImmutable('2025-12-10 12:53:28'));
        $manager->persist($activityLog_168);

        $activityLog_169 = new ActivityLog();
        $activityLog_169->setUserEmail('patrick@gmail.com');
        $activityLog_169->setUserRole('ROLE_USER');
        $activityLog_169->setAction('Login');
        $activityLog_169->setEntityType(null);
        $activityLog_169->setAffectedData(null);
        $activityLog_169->setDescription('User logged in');
        $activityLog_169->setCreatedAt(new \DateTimeImmutable('2025-12-10 14:24:25'));
        $manager->persist($activityLog_169);

        $activityLog_170 = new ActivityLog();
        $activityLog_170->setUserEmail('patrick@gmail.com');
        $activityLog_170->setUserRole('ROLE_USER');
        $activityLog_170->setAction('Logout');
        $activityLog_170->setEntityType(null);
        $activityLog_170->setAffectedData(null);
        $activityLog_170->setDescription('User logged out');
        $activityLog_170->setCreatedAt(new \DateTimeImmutable('2025-12-10 14:38:56'));
        $manager->persist($activityLog_170);

        $activityLog_171 = new ActivityLog();
        $activityLog_171->setUserEmail('admin@example.com');
        $activityLog_171->setUserRole('ROLE_ADMIN');
        $activityLog_171->setAction('Login');
        $activityLog_171->setEntityType(null);
        $activityLog_171->setAffectedData(null);
        $activityLog_171->setDescription('User logged in');
        $activityLog_171->setCreatedAt(new \DateTimeImmutable('2025-12-10 14:57:07'));
        $manager->persist($activityLog_171);

        $activityLog_172 = new ActivityLog();
        $activityLog_172->setUserEmail('admin@example.com');
        $activityLog_172->setUserRole('ROLE_ADMIN');
        $activityLog_172->setAction('Delete');
        $activityLog_172->setEntityType('User');
        $activityLog_172->setEntityId($this->getReference('user_5', User::class));
        $activityLog_172->setAffectedData('{
    "email": "jaylaw@gmail.com",
    "name": "Jaylaw",
    "roles": [
        "ROLE_STAFF",
        "ROLE_USER"
    ]
}');
        $activityLog_172->setDescription('Deleted user account: jaylaw@gmail.com');
        $activityLog_172->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:02:50'));
        $manager->persist($activityLog_172);

        $activityLog_173 = new ActivityLog();
        $activityLog_173->setUserEmail('admin@example.com');
        $activityLog_173->setUserRole('ROLE_ADMIN');
        $activityLog_173->setAction('Logout');
        $activityLog_173->setEntityType(null);
        $activityLog_173->setAffectedData(null);
        $activityLog_173->setDescription('User logged out');
        $activityLog_173->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:24:46'));
        $manager->persist($activityLog_173);

        $activityLog_174 = new ActivityLog();
        $activityLog_174->setUserEmail('patrick@gmail.com');
        $activityLog_174->setUserRole('ROLE_USER');
        $activityLog_174->setAction('Login');
        $activityLog_174->setEntityType(null);
        $activityLog_174->setAffectedData(null);
        $activityLog_174->setDescription('User logged in');
        $activityLog_174->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:25:18'));
        $manager->persist($activityLog_174);

        $activityLog_175 = new ActivityLog();
        $activityLog_175->setUserEmail('patrick@gmail.com');
        $activityLog_175->setUserRole('ROLE_USER');
        $activityLog_175->setAction('Logout');
        $activityLog_175->setEntityType(null);
        $activityLog_175->setAffectedData(null);
        $activityLog_175->setDescription('User logged out');
        $activityLog_175->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:27:35'));
        $manager->persist($activityLog_175);

        $activityLog_176 = new ActivityLog();
        $activityLog_176->setUserEmail('patrick@gmail.com');
        $activityLog_176->setUserRole('ROLE_USER');
        $activityLog_176->setAction('Login');
        $activityLog_176->setEntityType(null);
        $activityLog_176->setAffectedData(null);
        $activityLog_176->setDescription('User logged in');
        $activityLog_176->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:28:07'));
        $manager->persist($activityLog_176);

        $activityLog_177 = new ActivityLog();
        $activityLog_177->setUserEmail('patrick@gmail.com');
        $activityLog_177->setUserRole('ROLE_USER');
        $activityLog_177->setAction('Logout');
        $activityLog_177->setEntityType(null);
        $activityLog_177->setAffectedData(null);
        $activityLog_177->setDescription('User logged out');
        $activityLog_177->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:29:43'));
        $manager->persist($activityLog_177);

        $activityLog_178 = new ActivityLog();
        $activityLog_178->setUserEmail('patrick@gmail.com');
        $activityLog_178->setUserRole('ROLE_USER');
        $activityLog_178->setAction('Login');
        $activityLog_178->setEntityType(null);
        $activityLog_178->setAffectedData(null);
        $activityLog_178->setDescription('User logged in');
        $activityLog_178->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:30:03'));
        $manager->persist($activityLog_178);

        $activityLog_179 = new ActivityLog();
        $activityLog_179->setUserEmail('patrick@gmail.com');
        $activityLog_179->setUserRole('ROLE_USER');
        $activityLog_179->setAction('Logout');
        $activityLog_179->setEntityType(null);
        $activityLog_179->setAffectedData(null);
        $activityLog_179->setDescription('User logged out');
        $activityLog_179->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:30:18'));
        $manager->persist($activityLog_179);

        $activityLog_180 = new ActivityLog();
        $activityLog_180->setUserEmail('patrick@gmail.com');
        $activityLog_180->setUserRole('ROLE_USER');
        $activityLog_180->setAction('Login');
        $activityLog_180->setEntityType(null);
        $activityLog_180->setAffectedData(null);
        $activityLog_180->setDescription('User logged in');
        $activityLog_180->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:30:30'));
        $manager->persist($activityLog_180);

        $activityLog_181 = new ActivityLog();
        $activityLog_181->setUserEmail('patrick@gmail.com');
        $activityLog_181->setUserRole('ROLE_USER');
        $activityLog_181->setAction('Logout');
        $activityLog_181->setEntityType(null);
        $activityLog_181->setAffectedData(null);
        $activityLog_181->setDescription('User logged out');
        $activityLog_181->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:31:05'));
        $manager->persist($activityLog_181);

        $activityLog_182 = new ActivityLog();
        $activityLog_182->setUserEmail('admin@example.com');
        $activityLog_182->setUserRole('ROLE_ADMIN');
        $activityLog_182->setAction('Login');
        $activityLog_182->setEntityType(null);
        $activityLog_182->setAffectedData(null);
        $activityLog_182->setDescription('User logged in');
        $activityLog_182->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:31:14'));
        $manager->persist($activityLog_182);

        $activityLog_183 = new ActivityLog();
        $activityLog_183->setUserEmail('admin@example.com');
        $activityLog_183->setUserRole('ROLE_ADMIN');
        $activityLog_183->setAction('Logout');
        $activityLog_183->setEntityType(null);
        $activityLog_183->setAffectedData(null);
        $activityLog_183->setDescription('User logged out');
        $activityLog_183->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:34:12'));
        $manager->persist($activityLog_183);

        $activityLog_184 = new ActivityLog();
        $activityLog_184->setUserEmail('admin@example.com');
        $activityLog_184->setUserRole('ROLE_ADMIN');
        $activityLog_184->setAction('Login');
        $activityLog_184->setEntityType(null);
        $activityLog_184->setAffectedData(null);
        $activityLog_184->setDescription('User logged in');
        $activityLog_184->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:34:49'));
        $manager->persist($activityLog_184);

        $activityLog_185 = new ActivityLog();
        $activityLog_185->setUserEmail('admin@example.com');
        $activityLog_185->setUserRole('ROLE_ADMIN');
        $activityLog_185->setAction('Logout');
        $activityLog_185->setEntityType(null);
        $activityLog_185->setAffectedData(null);
        $activityLog_185->setDescription('User logged out');
        $activityLog_185->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:36:57'));
        $manager->persist($activityLog_185);

        $activityLog_186 = new ActivityLog();
        $activityLog_186->setUserEmail('admin@example.com');
        $activityLog_186->setUserRole('ROLE_ADMIN');
        $activityLog_186->setAction('Login');
        $activityLog_186->setEntityType(null);
        $activityLog_186->setAffectedData(null);
        $activityLog_186->setDescription('User logged in');
        $activityLog_186->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:37:08'));
        $manager->persist($activityLog_186);

        $activityLog_187 = new ActivityLog();
        $activityLog_187->setUserEmail('admin@example.com');
        $activityLog_187->setUserRole('ROLE_ADMIN');
        $activityLog_187->setAction('Logout');
        $activityLog_187->setEntityType(null);
        $activityLog_187->setAffectedData(null);
        $activityLog_187->setDescription('User logged out');
        $activityLog_187->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:38:26'));
        $manager->persist($activityLog_187);

        $activityLog_188 = new ActivityLog();
        $activityLog_188->setUserEmail('admin@example.com');
        $activityLog_188->setUserRole('ROLE_ADMIN');
        $activityLog_188->setAction('Login');
        $activityLog_188->setEntityType(null);
        $activityLog_188->setAffectedData(null);
        $activityLog_188->setDescription('User logged in');
        $activityLog_188->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:39:06'));
        $manager->persist($activityLog_188);

        $activityLog_189 = new ActivityLog();
        $activityLog_189->setUserEmail('admin@example.com');
        $activityLog_189->setUserRole('ROLE_ADMIN');
        $activityLog_189->setAction('Logout');
        $activityLog_189->setEntityType(null);
        $activityLog_189->setAffectedData(null);
        $activityLog_189->setDescription('User logged out');
        $activityLog_189->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:39:50'));
        $manager->persist($activityLog_189);

        $activityLog_190 = new ActivityLog();
        $activityLog_190->setUserEmail('staff@gmail.com');
        $activityLog_190->setUserRole('ROLE_STAFF');
        $activityLog_190->setAction('Login');
        $activityLog_190->setEntityType(null);
        $activityLog_190->setAffectedData(null);
        $activityLog_190->setDescription('User logged in');
        $activityLog_190->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:39:58'));
        $manager->persist($activityLog_190);

        $activityLog_191 = new ActivityLog();
        $activityLog_191->setUserEmail('staff@gmail.com');
        $activityLog_191->setUserRole('ROLE_STAFF');
        $activityLog_191->setAction('Logout');
        $activityLog_191->setEntityType(null);
        $activityLog_191->setAffectedData(null);
        $activityLog_191->setDescription('User logged out');
        $activityLog_191->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:44:07'));
        $manager->persist($activityLog_191);

        $activityLog_192 = new ActivityLog();
        $activityLog_192->setUserEmail('admin@example.com');
        $activityLog_192->setUserRole('ROLE_ADMIN');
        $activityLog_192->setAction('Login');
        $activityLog_192->setEntityType(null);
        $activityLog_192->setAffectedData(null);
        $activityLog_192->setDescription('User logged in');
        $activityLog_192->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:44:23'));
        $manager->persist($activityLog_192);

        $activityLog_193 = new ActivityLog();
        $activityLog_193->setUserEmail('admin@example.com');
        $activityLog_193->setUserRole('ROLE_ADMIN');
        $activityLog_193->setAction('Logout');
        $activityLog_193->setEntityType(null);
        $activityLog_193->setAffectedData(null);
        $activityLog_193->setDescription('User logged out');
        $activityLog_193->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:55:20'));
        $manager->persist($activityLog_193);

        $activityLog_194 = new ActivityLog();
        $activityLog_194->setUserEmail('patrick@gmail.com');
        $activityLog_194->setUserRole('ROLE_USER');
        $activityLog_194->setAction('Login');
        $activityLog_194->setEntityType(null);
        $activityLog_194->setAffectedData(null);
        $activityLog_194->setDescription('User logged in');
        $activityLog_194->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:56:01'));
        $manager->persist($activityLog_194);

        $activityLog_195 = new ActivityLog();
        $activityLog_195->setUserEmail('patrick@gmail.com');
        $activityLog_195->setUserRole('ROLE_USER');
        $activityLog_195->setAction('Logout');
        $activityLog_195->setEntityType(null);
        $activityLog_195->setAffectedData(null);
        $activityLog_195->setDescription('User logged out');
        $activityLog_195->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:56:16'));
        $manager->persist($activityLog_195);

        $activityLog_196 = new ActivityLog();
        $activityLog_196->setUserEmail('staff@gmail.com');
        $activityLog_196->setUserRole('ROLE_STAFF');
        $activityLog_196->setAction('Login');
        $activityLog_196->setEntityType(null);
        $activityLog_196->setAffectedData(null);
        $activityLog_196->setDescription('User logged in');
        $activityLog_196->setCreatedAt(new \DateTimeImmutable('2025-12-10 15:56:24'));
        $manager->persist($activityLog_196);

        $activityLog_197 = new ActivityLog();
        $activityLog_197->setUserEmail('staff@gmail.com');
        $activityLog_197->setUserRole('ROLE_STAFF');
        $activityLog_197->setAction('Logout');
        $activityLog_197->setEntityType(null);
        $activityLog_197->setAffectedData(null);
        $activityLog_197->setDescription('User logged out');
        $activityLog_197->setCreatedAt(new \DateTimeImmutable('2025-12-10 16:03:19'));
        $manager->persist($activityLog_197);

        $activityLog_198 = new ActivityLog();
        $activityLog_198->setUserEmail('admin@example.com');
        $activityLog_198->setUserRole('ROLE_ADMIN');
        $activityLog_198->setAction('Login');
        $activityLog_198->setEntityType(null);
        $activityLog_198->setAffectedData(null);
        $activityLog_198->setDescription('User logged in');
        $activityLog_198->setCreatedAt(new \DateTimeImmutable('2025-12-10 16:05:27'));
        $manager->persist($activityLog_198);

        $activityLog_199 = new ActivityLog();
        $activityLog_199->setUserEmail('admin@example.com');
        $activityLog_199->setUserRole('ROLE_ADMIN');
        $activityLog_199->setAction('Update');
        $activityLog_199->setEntityType('User');
        $activityLog_199->setEntityId($this->getReference('user_4', User::class));
        $activityLog_199->setAffectedData('{
    "old": {
        "email": "staff@gmail.com",
        "name": null,
        "roles": [
            "ROLE_STAFF",
            "ROLE_USER"
        ],
        "status": "active"
    },
    "new": {
        "email": "staff@gmail.com",
        "name": null,
        "role": "ROLE_STAFF",
        "status": "active"
    }
}');
        $activityLog_199->setDescription('Updated user account: staff@gmail.com');
        $activityLog_199->setCreatedAt(new \DateTimeImmutable('2025-12-10 16:06:13'));
        $manager->persist($activityLog_199);

        $activityLog_200 = new ActivityLog();
        $activityLog_200->setUserEmail('admin@example.com');
        $activityLog_200->setUserRole('ROLE_ADMIN');
        $activityLog_200->setAction('Logout');
        $activityLog_200->setEntityType(null);
        $activityLog_200->setAffectedData(null);
        $activityLog_200->setDescription('User logged out');
        $activityLog_200->setCreatedAt(new \DateTimeImmutable('2025-12-10 16:06:58'));
        $manager->persist($activityLog_200);

        $activityLog_201 = new ActivityLog();
        $activityLog_201->setUserEmail('staff@gmail.com');
        $activityLog_201->setUserRole('ROLE_STAFF');
        $activityLog_201->setAction('Login');
        $activityLog_201->setEntityType(null);
        $activityLog_201->setAffectedData(null);
        $activityLog_201->setDescription('User logged in');
        $activityLog_201->setCreatedAt(new \DateTimeImmutable('2025-12-10 16:07:14'));
        $manager->persist($activityLog_201);

        $activityLog_202 = new ActivityLog();
        $activityLog_202->setUserEmail('staff@gmail.com');
        $activityLog_202->setUserRole('ROLE_STAFF');
        $activityLog_202->setAction('Create');
        $activityLog_202->setEntityType('ServicePackage');
        $activityLog_202->setEntityId($this->getReference('user_2', User::class));
        $activityLog_202->setAffectedData('{
    "name": "lain sample",
    "price": 1500
}');
        $activityLog_202->setDescription('Created service package: lain sample');
        $activityLog_202->setCreatedAt(new \DateTimeImmutable('2025-12-10 16:08:17'));
        $manager->persist($activityLog_202);

        $activityLog_203 = new ActivityLog();
        $activityLog_203->setUserEmail('staff@gmail.com');
        $activityLog_203->setUserRole('ROLE_STAFF');
        $activityLog_203->setAction('Logout');
        $activityLog_203->setEntityType(null);
        $activityLog_203->setAffectedData(null);
        $activityLog_203->setDescription('User logged out');
        $activityLog_203->setCreatedAt(new \DateTimeImmutable('2025-12-10 16:08:37'));
        $manager->persist($activityLog_203);

        $activityLog_204 = new ActivityLog();
        $activityLog_204->setUserEmail('admin@example.com');
        $activityLog_204->setUserRole('ROLE_ADMIN');
        $activityLog_204->setAction('Login');
        $activityLog_204->setEntityType(null);
        $activityLog_204->setAffectedData(null);
        $activityLog_204->setDescription('User logged in');
        $activityLog_204->setCreatedAt(new \DateTimeImmutable('2025-12-10 16:08:52'));
        $manager->persist($activityLog_204);

        $activityLog_205 = new ActivityLog();
        $activityLog_205->setUserEmail('admin@example.com');
        $activityLog_205->setUserRole('ROLE_ADMIN');
        $activityLog_205->setAction('Logout');
        $activityLog_205->setEntityType(null);
        $activityLog_205->setAffectedData(null);
        $activityLog_205->setDescription('User logged out');
        $activityLog_205->setCreatedAt(new \DateTimeImmutable('2025-12-11 02:37:25'));
        $manager->persist($activityLog_205);

        $activityLog_206 = new ActivityLog();
        $activityLog_206->setUserEmail('patrick@gmail.com');
        $activityLog_206->setUserRole('ROLE_USER');
        $activityLog_206->setAction('Login');
        $activityLog_206->setEntityType(null);
        $activityLog_206->setAffectedData(null);
        $activityLog_206->setDescription('User logged in');
        $activityLog_206->setCreatedAt(new \DateTimeImmutable('2025-12-11 02:38:43'));
        $manager->persist($activityLog_206);

        $activityLog_207 = new ActivityLog();
        $activityLog_207->setUserEmail('patrick@gmail.com');
        $activityLog_207->setUserRole('ROLE_USER');
        $activityLog_207->setAction('Logout');
        $activityLog_207->setEntityType(null);
        $activityLog_207->setAffectedData(null);
        $activityLog_207->setDescription('User logged out');
        $activityLog_207->setCreatedAt(new \DateTimeImmutable('2025-12-11 02:39:30'));
        $manager->persist($activityLog_207);

        $activityLog_208 = new ActivityLog();
        $activityLog_208->setUserEmail('admin@example.com');
        $activityLog_208->setUserRole('ROLE_ADMIN');
        $activityLog_208->setAction('Login');
        $activityLog_208->setEntityType(null);
        $activityLog_208->setAffectedData(null);
        $activityLog_208->setDescription('User logged in');
        $activityLog_208->setCreatedAt(new \DateTimeImmutable('2025-12-11 02:40:04'));
        $manager->persist($activityLog_208);

        $activityLog_209 = new ActivityLog();
        $activityLog_209->setUserEmail('admin@example.com');
        $activityLog_209->setUserRole('ROLE_ADMIN');
        $activityLog_209->setAction('Logout');
        $activityLog_209->setEntityType(null);
        $activityLog_209->setAffectedData(null);
        $activityLog_209->setDescription('User logged out');
        $activityLog_209->setCreatedAt(new \DateTimeImmutable('2025-12-11 04:37:52'));
        $manager->persist($activityLog_209);

        $activityLog_210 = new ActivityLog();
        $activityLog_210->setUserEmail('admin@example.com');
        $activityLog_210->setUserRole('ROLE_ADMIN');
        $activityLog_210->setAction('Login');
        $activityLog_210->setEntityType(null);
        $activityLog_210->setAffectedData(null);
        $activityLog_210->setDescription('User logged in');
        $activityLog_210->setCreatedAt(new \DateTimeImmutable('2025-12-11 05:02:52'));
        $manager->persist($activityLog_210);

        $activityLog_211 = new ActivityLog();
        $activityLog_211->setUserEmail('admin@example.com');
        $activityLog_211->setUserRole('ROLE_ADMIN');
        $activityLog_211->setAction('Logout');
        $activityLog_211->setEntityType(null);
        $activityLog_211->setAffectedData(null);
        $activityLog_211->setDescription('User logged out');
        $activityLog_211->setCreatedAt(new \DateTimeImmutable('2025-12-11 05:12:55'));
        $manager->persist($activityLog_211);

        $activityLog_212 = new ActivityLog();
        $activityLog_212->setUserEmail('admin@example.com');
        $activityLog_212->setUserRole('ROLE_ADMIN');
        $activityLog_212->setAction('Login');
        $activityLog_212->setEntityType(null);
        $activityLog_212->setAffectedData(null);
        $activityLog_212->setDescription('User logged in');
        $activityLog_212->setCreatedAt(new \DateTimeImmutable('2025-12-11 05:34:23'));
        $manager->persist($activityLog_212);

        $activityLog_213 = new ActivityLog();
        $activityLog_213->setUserEmail('admin@example.com');
        $activityLog_213->setUserRole('ROLE_ADMIN');
        $activityLog_213->setAction('Logout');
        $activityLog_213->setEntityType(null);
        $activityLog_213->setAffectedData(null);
        $activityLog_213->setDescription('User logged out');
        $activityLog_213->setCreatedAt(new \DateTimeImmutable('2025-12-11 05:36:39'));
        $manager->persist($activityLog_213);

        $activityLog_214 = new ActivityLog();
        $activityLog_214->setUserEmail('admin@example.com');
        $activityLog_214->setUserRole('ROLE_ADMIN');
        $activityLog_214->setAction('Login');
        $activityLog_214->setEntityType(null);
        $activityLog_214->setAffectedData(null);
        $activityLog_214->setDescription('User logged in');
        $activityLog_214->setCreatedAt(new \DateTimeImmutable('2025-12-11 05:40:54'));
        $manager->persist($activityLog_214);

        $activityLog_215 = new ActivityLog();
        $activityLog_215->setUserEmail('admin@example.com');
        $activityLog_215->setUserRole('ROLE_ADMIN');
        $activityLog_215->setAction('Create');
        $activityLog_215->setEntityType('User');
        $activityLog_215->setEntityId($this->getReference('user_6', User::class));
        $activityLog_215->setAffectedData('{
    "email": "admin@gmail.com",
    "role": "ROLE_ADMIN",
    "status": "active"
}');
        $activityLog_215->setDescription('Created user account: admin@gmail.com (ROLE_ADMIN)');
        $activityLog_215->setCreatedAt(new \DateTimeImmutable('2025-12-11 05:41:36'));
        $manager->persist($activityLog_215);

        $activityLog_216 = new ActivityLog();
        $activityLog_216->setUserEmail('admin@example.com');
        $activityLog_216->setUserRole('ROLE_ADMIN');
        $activityLog_216->setAction('Logout');
        $activityLog_216->setEntityType(null);
        $activityLog_216->setAffectedData(null);
        $activityLog_216->setDescription('User logged out');
        $activityLog_216->setCreatedAt(new \DateTimeImmutable('2025-12-11 05:42:47'));
        $manager->persist($activityLog_216);

        $activityLog_217 = new ActivityLog();
        $activityLog_217->setUserEmail('admin@gmail.com');
        $activityLog_217->setUserRole('ROLE_ADMIN');
        $activityLog_217->setAction('Login');
        $activityLog_217->setEntityType(null);
        $activityLog_217->setAffectedData(null);
        $activityLog_217->setDescription('User logged in');
        $activityLog_217->setCreatedAt(new \DateTimeImmutable('2025-12-11 05:42:57'));
        $manager->persist($activityLog_217);

        $activityLog_218 = new ActivityLog();
        $activityLog_218->setUserEmail('admin@gmail.com');
        $activityLog_218->setUserRole('ROLE_ADMIN');
        $activityLog_218->setAction('Update');
        $activityLog_218->setEntityType('User');
        $activityLog_218->setEntityId($this->getReference('user_1', User::class));
        $activityLog_218->setAffectedData('{
    "old": {
        "status": "active"
    },
    "new": {
        "status": "disabled"
    }
}');
        $activityLog_218->setDescription('Changed user status: admin@example.com from active to disabled');
        $activityLog_218->setCreatedAt(new \DateTimeImmutable('2025-12-11 05:43:12'));
        $manager->persist($activityLog_218);

        $activityLog_219 = new ActivityLog();
        $activityLog_219->setUserEmail('admin@gmail.com');
        $activityLog_219->setUserRole('ROLE_ADMIN');
        $activityLog_219->setAction('Logout');
        $activityLog_219->setEntityType(null);
        $activityLog_219->setAffectedData(null);
        $activityLog_219->setDescription('User logged out');
        $activityLog_219->setCreatedAt(new \DateTimeImmutable('2025-12-11 06:28:44'));
        $manager->persist($activityLog_219);

        $activityLog_220 = new ActivityLog();
        $activityLog_220->setUserEmail('admin@gmail.com');
        $activityLog_220->setUserRole('ROLE_ADMIN');
        $activityLog_220->setAction('Login');
        $activityLog_220->setEntityType(null);
        $activityLog_220->setAffectedData(null);
        $activityLog_220->setDescription('User logged in');
        $activityLog_220->setCreatedAt(new \DateTimeImmutable('2025-12-11 06:29:00'));
        $manager->persist($activityLog_220);

        $activityLog_221 = new ActivityLog();
        $activityLog_221->setUserEmail('admin@gmail.com');
        $activityLog_221->setUserRole('ROLE_ADMIN');
        $activityLog_221->setAction('Logout');
        $activityLog_221->setEntityType(null);
        $activityLog_221->setAffectedData(null);
        $activityLog_221->setDescription('User logged out');
        $activityLog_221->setCreatedAt(new \DateTimeImmutable('2025-12-11 06:29:35'));
        $manager->persist($activityLog_221);

        $activityLog_222 = new ActivityLog();
        $activityLog_222->setUserEmail('admin@gmail.com');
        $activityLog_222->setUserRole('ROLE_ADMIN');
        $activityLog_222->setAction('Login');
        $activityLog_222->setEntityType(null);
        $activityLog_222->setAffectedData(null);
        $activityLog_222->setDescription('User logged in');
        $activityLog_222->setCreatedAt(new \DateTimeImmutable('2025-12-11 06:48:07'));
        $manager->persist($activityLog_222);

        $activityLog_223 = new ActivityLog();
        $activityLog_223->setUserEmail('admin@gmail.com');
        $activityLog_223->setUserRole('ROLE_ADMIN');
        $activityLog_223->setAction('Delete');
        $activityLog_223->setEntityType('Event');
        $activityLog_223->setEntityId($this->getReference('user_16', User::class));
        $activityLog_223->setAffectedData('{
    "customerName": "Jay",
    "eventType": "Wedding",
    "price": 10000
}');
        $activityLog_223->setDescription('Deleted event: Jay - Wedding');
        $activityLog_223->setCreatedAt(new \DateTimeImmutable('2025-12-11 06:48:53'));
        $manager->persist($activityLog_223);

        $activityLog_224 = new ActivityLog();
        $activityLog_224->setUserEmail('admin@gmail.com');
        $activityLog_224->setUserRole('ROLE_ADMIN');
        $activityLog_224->setAction('Create');
        $activityLog_224->setEntityType('Event');
        $activityLog_224->setEntityId($this->getReference('user_20', User::class));
        $activityLog_224->setAffectedData('{
    "customerName": "Nino",
    "eventType": "Birthday",
    "price": 4500
}');
        $activityLog_224->setDescription('Created event: Nino - Birthday');
        $activityLog_224->setCreatedAt(new \DateTimeImmutable('2025-12-11 06:50:43'));
        $manager->persist($activityLog_224);

        $activityLog_225 = new ActivityLog();
        $activityLog_225->setUserEmail('admin@gmail.com');
        $activityLog_225->setUserRole('ROLE_ADMIN');
        $activityLog_225->setAction('Logout');
        $activityLog_225->setEntityType(null);
        $activityLog_225->setAffectedData(null);
        $activityLog_225->setDescription('User logged out');
        $activityLog_225->setCreatedAt(new \DateTimeImmutable('2025-12-11 06:51:10'));
        $manager->persist($activityLog_225);

        $activityLog_226 = new ActivityLog();
        $activityLog_226->setUserEmail('admin@gmail.com');
        $activityLog_226->setUserRole('ROLE_ADMIN');
        $activityLog_226->setAction('Login');
        $activityLog_226->setEntityType(null);
        $activityLog_226->setAffectedData(null);
        $activityLog_226->setDescription('User logged in');
        $activityLog_226->setCreatedAt(new \DateTimeImmutable('2025-12-11 09:10:03'));
        $manager->persist($activityLog_226);

        $activityLog_227 = new ActivityLog();
        $activityLog_227->setUserEmail('admin@gmail.com');
        $activityLog_227->setUserRole('ROLE_ADMIN');
        $activityLog_227->setAction('Logout');
        $activityLog_227->setEntityType(null);
        $activityLog_227->setAffectedData(null);
        $activityLog_227->setDescription('User logged out');
        $activityLog_227->setCreatedAt(new \DateTimeImmutable('2025-12-11 09:21:56'));
        $manager->persist($activityLog_227);

        $activityLog_228 = new ActivityLog();
        $activityLog_228->setUserEmail('staff@gmail.com');
        $activityLog_228->setUserRole('ROLE_STAFF');
        $activityLog_228->setAction('Login');
        $activityLog_228->setEntityType(null);
        $activityLog_228->setAffectedData(null);
        $activityLog_228->setDescription('User logged in');
        $activityLog_228->setCreatedAt(new \DateTimeImmutable('2025-12-11 09:22:09'));
        $manager->persist($activityLog_228);

        $activityLog_229 = new ActivityLog();
        $activityLog_229->setUserEmail('staff@gmail.com');
        $activityLog_229->setUserRole('ROLE_STAFF');
        $activityLog_229->setAction('Logout');
        $activityLog_229->setEntityType(null);
        $activityLog_229->setAffectedData(null);
        $activityLog_229->setDescription('User logged out');
        $activityLog_229->setCreatedAt(new \DateTimeImmutable('2025-12-11 09:22:35'));
        $manager->persist($activityLog_229);

        $activityLog_230 = new ActivityLog();
        $activityLog_230->setUserEmail('admin@gmail.com');
        $activityLog_230->setUserRole('ROLE_ADMIN');
        $activityLog_230->setAction('Login');
        $activityLog_230->setEntityType(null);
        $activityLog_230->setAffectedData(null);
        $activityLog_230->setDescription('User logged in');
        $activityLog_230->setCreatedAt(new \DateTimeImmutable('2025-12-11 09:22:47'));
        $manager->persist($activityLog_230);

        $activityLog_231 = new ActivityLog();
        $activityLog_231->setUserEmail('admin@gmail.com');
        $activityLog_231->setUserRole('ROLE_ADMIN');
        $activityLog_231->setAction('Logout');
        $activityLog_231->setEntityType(null);
        $activityLog_231->setAffectedData(null);
        $activityLog_231->setDescription('User logged out');
        $activityLog_231->setCreatedAt(new \DateTimeImmutable('2025-12-11 09:34:54'));
        $manager->persist($activityLog_231);

        $activityLog_232 = new ActivityLog();
        $activityLog_232->setUserEmail('staff@gmail.com');
        $activityLog_232->setUserRole('ROLE_STAFF');
        $activityLog_232->setAction('Login');
        $activityLog_232->setEntityType(null);
        $activityLog_232->setAffectedData(null);
        $activityLog_232->setDescription('User logged in');
        $activityLog_232->setCreatedAt(new \DateTimeImmutable('2025-12-11 09:44:29'));
        $manager->persist($activityLog_232);

        $activityLog_233 = new ActivityLog();
        $activityLog_233->setUserEmail('staff@gmail.com');
        $activityLog_233->setUserRole('ROLE_STAFF');
        $activityLog_233->setAction('Logout');
        $activityLog_233->setEntityType(null);
        $activityLog_233->setAffectedData(null);
        $activityLog_233->setDescription('User logged out');
        $activityLog_233->setCreatedAt(new \DateTimeImmutable('2025-12-11 09:45:05'));
        $manager->persist($activityLog_233);

        $activityLog_234 = new ActivityLog();
        $activityLog_234->setUserEmail('patrick@gmail.com');
        $activityLog_234->setUserRole('ROLE_USER');
        $activityLog_234->setAction('Login');
        $activityLog_234->setEntityType(null);
        $activityLog_234->setAffectedData(null);
        $activityLog_234->setDescription('User logged in');
        $activityLog_234->setCreatedAt(new \DateTimeImmutable('2025-12-11 09:45:18'));
        $manager->persist($activityLog_234);

        $activityLog_235 = new ActivityLog();
        $activityLog_235->setUserEmail('patrick@gmail.com');
        $activityLog_235->setUserRole('ROLE_USER');
        $activityLog_235->setAction('Logout');
        $activityLog_235->setEntityType(null);
        $activityLog_235->setAffectedData(null);
        $activityLog_235->setDescription('User logged out');
        $activityLog_235->setCreatedAt(new \DateTimeImmutable('2025-12-11 09:45:35'));
        $manager->persist($activityLog_235);

        $activityLog_236 = new ActivityLog();
        $activityLog_236->setUserEmail('admin@gmail.com');
        $activityLog_236->setUserRole('ROLE_ADMIN');
        $activityLog_236->setAction('Login');
        $activityLog_236->setEntityType(null);
        $activityLog_236->setAffectedData(null);
        $activityLog_236->setDescription('User logged in');
        $activityLog_236->setCreatedAt(new \DateTimeImmutable('2025-12-11 10:44:34'));
        $manager->persist($activityLog_236);

        $activityLog_237 = new ActivityLog();
        $activityLog_237->setUserEmail('staff@gmail.com');
        $activityLog_237->setUserRole('ROLE_STAFF');
        $activityLog_237->setAction('Login');
        $activityLog_237->setEntityType(null);
        $activityLog_237->setAffectedData(null);
        $activityLog_237->setDescription('User logged in');
        $activityLog_237->setCreatedAt(new \DateTimeImmutable('2025-12-11 10:44:58'));
        $manager->persist($activityLog_237);

        $activityLog_238 = new ActivityLog();
        $activityLog_238->setUserEmail('admin@gmail.com');
        $activityLog_238->setUserRole('ROLE_ADMIN');
        $activityLog_238->setAction('Update');
        $activityLog_238->setEntityType('User');
        $activityLog_238->setEntityId($this->getReference('user_4', User::class));
        $activityLog_238->setAffectedData('{
    "old": {
        "status": "active"
    },
    "new": {
        "status": "disabled"
    }
}');
        $activityLog_238->setDescription('Changed user status: staff@gmail.com from active to disabled');
        $activityLog_238->setCreatedAt(new \DateTimeImmutable('2025-12-11 10:46:24'));
        $manager->persist($activityLog_238);

        $activityLog_239 = new ActivityLog();
        $activityLog_239->setUserEmail('staff@gmail.com');
        $activityLog_239->setUserRole('ROLE_STAFF');
        $activityLog_239->setAction('Logout');
        $activityLog_239->setEntityType(null);
        $activityLog_239->setAffectedData(null);
        $activityLog_239->setDescription('User logged out');
        $activityLog_239->setCreatedAt(new \DateTimeImmutable('2025-12-11 10:46:36'));
        $manager->persist($activityLog_239);

        $activityLog_240 = new ActivityLog();
        $activityLog_240->setUserEmail('admin@gmail.com');
        $activityLog_240->setUserRole('ROLE_ADMIN');
        $activityLog_240->setAction('Update');
        $activityLog_240->setEntityType('User');
        $activityLog_240->setEntityId($this->getReference('user_4', User::class));
        $activityLog_240->setAffectedData('{
    "old": {
        "status": "disabled"
    },
    "new": {
        "status": "active"
    }
}');
        $activityLog_240->setDescription('Changed user status: staff@gmail.com from disabled to active');
        $activityLog_240->setCreatedAt(new \DateTimeImmutable('2025-12-11 10:46:58'));
        $manager->persist($activityLog_240);

        $activityLog_241 = new ActivityLog();
        $activityLog_241->setUserEmail('staff@gmail.com');
        $activityLog_241->setUserRole('ROLE_STAFF');
        $activityLog_241->setAction('Login');
        $activityLog_241->setEntityType(null);
        $activityLog_241->setAffectedData(null);
        $activityLog_241->setDescription('User logged in');
        $activityLog_241->setCreatedAt(new \DateTimeImmutable('2025-12-11 10:47:10'));
        $manager->persist($activityLog_241);

        $activityLog_242 = new ActivityLog();
        $activityLog_242->setUserEmail('staff@gmail.com');
        $activityLog_242->setUserRole('ROLE_STAFF');
        $activityLog_242->setAction('Logout');
        $activityLog_242->setEntityType(null);
        $activityLog_242->setAffectedData(null);
        $activityLog_242->setDescription('User logged out');
        $activityLog_242->setCreatedAt(new \DateTimeImmutable('2025-12-12 11:22:38'));
        $manager->persist($activityLog_242);

        $activityLog_243 = new ActivityLog();
        $activityLog_243->setUserEmail('admin@gmail.com');
        $activityLog_243->setUserRole('ROLE_ADMIN');
        $activityLog_243->setAction('Login');
        $activityLog_243->setEntityType(null);
        $activityLog_243->setAffectedData(null);
        $activityLog_243->setDescription('User logged in');
        $activityLog_243->setCreatedAt(new \DateTimeImmutable('2025-12-12 12:04:25'));
        $manager->persist($activityLog_243);

        $activityLog_244 = new ActivityLog();
        $activityLog_244->setUserEmail('admin@gmail.com');
        $activityLog_244->setUserRole('ROLE_ADMIN');
        $activityLog_244->setAction('Logout');
        $activityLog_244->setEntityType(null);
        $activityLog_244->setAffectedData(null);
        $activityLog_244->setDescription('User logged out');
        $activityLog_244->setCreatedAt(new \DateTimeImmutable('2025-12-12 13:22:33'));
        $manager->persist($activityLog_244);

        $activityLog_245 = new ActivityLog();
        $activityLog_245->setUserEmail('admin@gmail.com');
        $activityLog_245->setUserRole('ROLE_ADMIN');
        $activityLog_245->setAction('Login');
        $activityLog_245->setEntityType(null);
        $activityLog_245->setAffectedData(null);
        $activityLog_245->setDescription('User logged in');
        $activityLog_245->setCreatedAt(new \DateTimeImmutable('2025-12-16 05:47:30'));
        $manager->persist($activityLog_245);

        $activityLog_246 = new ActivityLog();
        $activityLog_246->setUserEmail('admin@gmail.com');
        $activityLog_246->setUserRole('ROLE_ADMIN');
        $activityLog_246->setAction('Logout');
        $activityLog_246->setEntityType(null);
        $activityLog_246->setAffectedData(null);
        $activityLog_246->setDescription('User logged out');
        $activityLog_246->setCreatedAt(new \DateTimeImmutable('2025-12-16 05:48:00'));
        $manager->persist($activityLog_246);

        $activityLog_247 = new ActivityLog();
        $activityLog_247->setUserEmail('admin@gmail.com');
        $activityLog_247->setUserRole('ROLE_ADMIN');
        $activityLog_247->setAction('Login');
        $activityLog_247->setEntityType(null);
        $activityLog_247->setAffectedData(null);
        $activityLog_247->setDescription('User logged in');
        $activityLog_247->setCreatedAt(new \DateTimeImmutable('2025-12-16 05:55:50'));
        $manager->persist($activityLog_247);

        $activityLog_248 = new ActivityLog();
        $activityLog_248->setUserEmail('admin@gmail.com');
        $activityLog_248->setUserRole('ROLE_ADMIN');
        $activityLog_248->setAction('Logout');
        $activityLog_248->setEntityType(null);
        $activityLog_248->setAffectedData(null);
        $activityLog_248->setDescription('User logged out');
        $activityLog_248->setCreatedAt(new \DateTimeImmutable('2025-12-16 05:56:39'));
        $manager->persist($activityLog_248);

        $activityLog_249 = new ActivityLog();
        $activityLog_249->setUserEmail('admin@gmail.com');
        $activityLog_249->setUserRole('ROLE_ADMIN');
        $activityLog_249->setAction('Login');
        $activityLog_249->setEntityType(null);
        $activityLog_249->setAffectedData(null);
        $activityLog_249->setDescription('User logged in');
        $activityLog_249->setCreatedAt(new \DateTimeImmutable('2025-12-16 06:16:26'));
        $manager->persist($activityLog_249);

        $activityLog_250 = new ActivityLog();
        $activityLog_250->setUserEmail('admin@gmail.com');
        $activityLog_250->setUserRole('ROLE_ADMIN');
        $activityLog_250->setAction('Logout');
        $activityLog_250->setEntityType(null);
        $activityLog_250->setAffectedData(null);
        $activityLog_250->setDescription('User logged out');
        $activityLog_250->setCreatedAt(new \DateTimeImmutable('2025-12-16 06:16:40'));
        $manager->persist($activityLog_250);

        $activityLog_251 = new ActivityLog();
        $activityLog_251->setUserEmail('admin@gmail.com');
        $activityLog_251->setUserRole('ROLE_ADMIN');
        $activityLog_251->setAction('Login');
        $activityLog_251->setEntityType(null);
        $activityLog_251->setAffectedData(null);
        $activityLog_251->setDescription('User logged in');
        $activityLog_251->setCreatedAt(new \DateTimeImmutable('2025-12-17 09:37:16'));
        $manager->persist($activityLog_251);

        $activityLog_252 = new ActivityLog();
        $activityLog_252->setUserEmail('admin@gmail.com');
        $activityLog_252->setUserRole('ROLE_ADMIN');
        $activityLog_252->setAction('Login');
        $activityLog_252->setEntityType(null);
        $activityLog_252->setAffectedData(null);
        $activityLog_252->setDescription('User logged in');
        $activityLog_252->setCreatedAt(new \DateTimeImmutable('2026-03-10 04:42:06'));
        $manager->persist($activityLog_252);

        $activityLog_253 = new ActivityLog();
        $activityLog_253->setUserEmail('admin@gmail.com');
        $activityLog_253->setUserRole('ROLE_ADMIN');
        $activityLog_253->setAction('Logout');
        $activityLog_253->setEntityType(null);
        $activityLog_253->setAffectedData(null);
        $activityLog_253->setDescription('User logged out');
        $activityLog_253->setCreatedAt(new \DateTimeImmutable('2026-03-12 05:03:52'));
        $manager->persist($activityLog_253);

        $activityLog_254 = new ActivityLog();
        $activityLog_254->setUserEmail('admin@gmail.com');
        $activityLog_254->setUserRole('ROLE_ADMIN');
        $activityLog_254->setAction('Login');
        $activityLog_254->setEntityType(null);
        $activityLog_254->setAffectedData(null);
        $activityLog_254->setDescription('User logged in');
        $activityLog_254->setCreatedAt(new \DateTimeImmutable('2026-03-12 07:21:01'));
        $manager->persist($activityLog_254);

        $activityLog_255 = new ActivityLog();
        $activityLog_255->setUserEmail('admin@gmail.com');
        $activityLog_255->setUserRole('ROLE_ADMIN');
        $activityLog_255->setAction('Logout');
        $activityLog_255->setEntityType(null);
        $activityLog_255->setAffectedData(null);
        $activityLog_255->setDescription('User logged out');
        $activityLog_255->setCreatedAt(new \DateTimeImmutable('2026-03-12 07:38:12'));
        $manager->persist($activityLog_255);

        $activityLog_256 = new ActivityLog();
        $activityLog_256->setUserEmail('admin@gmail.com');
        $activityLog_256->setUserRole('ROLE_ADMIN');
        $activityLog_256->setAction('Login');
        $activityLog_256->setEntityType(null);
        $activityLog_256->setAffectedData(null);
        $activityLog_256->setDescription('User logged in');
        $activityLog_256->setCreatedAt(new \DateTimeImmutable('2026-03-20 11:26:08'));
        $manager->persist($activityLog_256);

        $activityLog_257 = new ActivityLog();
        $activityLog_257->setUserEmail('admin@gmail.com');
        $activityLog_257->setUserRole('ROLE_ADMIN');
        $activityLog_257->setAction('Logout');
        $activityLog_257->setEntityType(null);
        $activityLog_257->setAffectedData(null);
        $activityLog_257->setDescription('User logged out');
        $activityLog_257->setCreatedAt(new \DateTimeImmutable('2026-03-20 11:28:34'));
        $manager->persist($activityLog_257);

        $activityLog_258 = new ActivityLog();
        $activityLog_258->setUserEmail('luckydingal46@gmail.com');
        $activityLog_258->setUserRole('ROLE_USER');
        $activityLog_258->setAction('Login');
        $activityLog_258->setEntityType(null);
        $activityLog_258->setAffectedData(null);
        $activityLog_258->setDescription('User logged in');
        $activityLog_258->setCreatedAt(new \DateTimeImmutable('2026-03-20 11:37:19'));
        $manager->persist($activityLog_258);

        $activityLog_259 = new ActivityLog();
        $activityLog_259->setUserEmail('luckydingal46@gmail.com');
        $activityLog_259->setUserRole('ROLE_USER');
        $activityLog_259->setAction('Logout');
        $activityLog_259->setEntityType(null);
        $activityLog_259->setAffectedData(null);
        $activityLog_259->setDescription('User logged out');
        $activityLog_259->setCreatedAt(new \DateTimeImmutable('2026-03-20 11:42:04'));
        $manager->persist($activityLog_259);

        $activityLog_260 = new ActivityLog();
        $activityLog_260->setUserEmail('luckydingal46@gmail.com');
        $activityLog_260->setUserRole('ROLE_USER');
        $activityLog_260->setAction('Login');
        $activityLog_260->setEntityType(null);
        $activityLog_260->setAffectedData(null);
        $activityLog_260->setDescription('User logged in');
        $activityLog_260->setCreatedAt(new \DateTimeImmutable('2026-03-20 11:42:16'));
        $manager->persist($activityLog_260);

        $activityLog_261 = new ActivityLog();
        $activityLog_261->setUserEmail('luckydingal46@gmail.com');
        $activityLog_261->setUserRole('ROLE_USER');
        $activityLog_261->setAction('Logout');
        $activityLog_261->setEntityType(null);
        $activityLog_261->setAffectedData(null);
        $activityLog_261->setDescription('User logged out');
        $activityLog_261->setCreatedAt(new \DateTimeImmutable('2026-03-20 11:42:24'));
        $manager->persist($activityLog_261);

        $activityLog_262 = new ActivityLog();
        $activityLog_262->setUserEmail('luckydingal46@gmail.com');
        $activityLog_262->setUserRole('ROLE_USER');
        $activityLog_262->setAction('Login');
        $activityLog_262->setEntityType(null);
        $activityLog_262->setAffectedData(null);
        $activityLog_262->setDescription('User logged in');
        $activityLog_262->setCreatedAt(new \DateTimeImmutable('2026-03-20 11:44:21'));
        $manager->persist($activityLog_262);

        $activityLog_263 = new ActivityLog();
        $activityLog_263->setUserEmail('luckydingal46@gmail.com');
        $activityLog_263->setUserRole('ROLE_USER');
        $activityLog_263->setAction('Logout');
        $activityLog_263->setEntityType(null);
        $activityLog_263->setAffectedData(null);
        $activityLog_263->setDescription('User logged out');
        $activityLog_263->setCreatedAt(new \DateTimeImmutable('2026-03-20 11:44:27'));
        $manager->persist($activityLog_263);

        $activityLog_264 = new ActivityLog();
        $activityLog_264->setUserEmail('admin@gmail.com');
        $activityLog_264->setUserRole('ROLE_ADMIN');
        $activityLog_264->setAction('Login');
        $activityLog_264->setEntityType(null);
        $activityLog_264->setAffectedData(null);
        $activityLog_264->setDescription('User logged in');
        $activityLog_264->setCreatedAt(new \DateTimeImmutable('2026-03-20 11:54:09'));
        $manager->persist($activityLog_264);

        $activityLog_265 = new ActivityLog();
        $activityLog_265->setUserEmail('admin@gmail.com');
        $activityLog_265->setUserRole('ROLE_ADMIN');
        $activityLog_265->setAction('Logout');
        $activityLog_265->setEntityType(null);
        $activityLog_265->setAffectedData(null);
        $activityLog_265->setDescription('User logged out');
        $activityLog_265->setCreatedAt(new \DateTimeImmutable('2026-03-20 11:54:26'));
        $manager->persist($activityLog_265);

        $activityLog_266 = new ActivityLog();
        $activityLog_266->setUserEmail('admin@gmail.com');
        $activityLog_266->setUserRole('ROLE_ADMIN');
        $activityLog_266->setAction('Login');
        $activityLog_266->setEntityType(null);
        $activityLog_266->setAffectedData(null);
        $activityLog_266->setDescription('User logged in');
        $activityLog_266->setCreatedAt(new \DateTimeImmutable('2026-03-20 11:55:44'));
        $manager->persist($activityLog_266);

        $activityLog_267 = new ActivityLog();
        $activityLog_267->setUserEmail('staff@gmail.com');
        $activityLog_267->setUserRole('ROLE_STAFF');
        $activityLog_267->setAction('Login');
        $activityLog_267->setEntityType(null);
        $activityLog_267->setAffectedData(null);
        $activityLog_267->setDescription('User logged in');
        $activityLog_267->setCreatedAt(new \DateTimeImmutable('2026-04-07 08:35:02'));
        $manager->persist($activityLog_267);

        $activityLog_268 = new ActivityLog();
        $activityLog_268->setUserEmail('staff@gmail.com');
        $activityLog_268->setUserRole('ROLE_STAFF');
        $activityLog_268->setAction('Logout');
        $activityLog_268->setEntityType(null);
        $activityLog_268->setAffectedData(null);
        $activityLog_268->setDescription('User logged out');
        $activityLog_268->setCreatedAt(new \DateTimeImmutable('2026-04-07 08:35:20'));
        $manager->persist($activityLog_268);

        $activityLog_269 = new ActivityLog();
        $activityLog_269->setUserEmail('luckydingal46@gmail.com');
        $activityLog_269->setUserRole('ROLE_USER');
        $activityLog_269->setAction('Login');
        $activityLog_269->setEntityType(null);
        $activityLog_269->setAffectedData(null);
        $activityLog_269->setDescription('User logged in');
        $activityLog_269->setCreatedAt(new \DateTimeImmutable('2026-04-07 08:35:32'));
        $manager->persist($activityLog_269);

        $activityLog_270 = new ActivityLog();
        $activityLog_270->setUserEmail('luckydingal46@gmail.com');
        $activityLog_270->setUserRole('ROLE_USER');
        $activityLog_270->setAction('Logout');
        $activityLog_270->setEntityType(null);
        $activityLog_270->setAffectedData(null);
        $activityLog_270->setDescription('User logged out');
        $activityLog_270->setCreatedAt(new \DateTimeImmutable('2026-04-07 08:36:06'));
        $manager->persist($activityLog_270);

        $activityLog_271 = new ActivityLog();
        $activityLog_271->setUserEmail('luckydingal46@gmail.com');
        $activityLog_271->setUserRole('ROLE_USER');
        $activityLog_271->setAction('Login');
        $activityLog_271->setEntityType(null);
        $activityLog_271->setAffectedData(null);
        $activityLog_271->setDescription('User logged in');
        $activityLog_271->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:10:42'));
        $manager->persist($activityLog_271);

        $activityLog_272 = new ActivityLog();
        $activityLog_272->setUserEmail('luckydingal46@gmail.com');
        $activityLog_272->setUserRole('ROLE_USER');
        $activityLog_272->setAction('Logout');
        $activityLog_272->setEntityType(null);
        $activityLog_272->setAffectedData(null);
        $activityLog_272->setDescription('User logged out');
        $activityLog_272->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:14:39'));
        $manager->persist($activityLog_272);

        $activityLog_273 = new ActivityLog();
        $activityLog_273->setUserEmail('admin@gmail.com');
        $activityLog_273->setUserRole('ROLE_ADMIN');
        $activityLog_273->setAction('Login');
        $activityLog_273->setEntityType(null);
        $activityLog_273->setAffectedData(null);
        $activityLog_273->setDescription('User logged in');
        $activityLog_273->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:14:52'));
        $manager->persist($activityLog_273);

        $activityLog_274 = new ActivityLog();
        $activityLog_274->setUserEmail('admin@gmail.com');
        $activityLog_274->setUserRole('ROLE_ADMIN');
        $activityLog_274->setAction('Logout');
        $activityLog_274->setEntityType(null);
        $activityLog_274->setAffectedData(null);
        $activityLog_274->setDescription('User logged out');
        $activityLog_274->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:16:24'));
        $manager->persist($activityLog_274);

        $activityLog_275 = new ActivityLog();
        $activityLog_275->setUserEmail('staff@gmail.com');
        $activityLog_275->setUserRole('ROLE_STAFF');
        $activityLog_275->setAction('Login');
        $activityLog_275->setEntityType(null);
        $activityLog_275->setAffectedData(null);
        $activityLog_275->setDescription('User logged in');
        $activityLog_275->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:16:49'));
        $manager->persist($activityLog_275);

        $activityLog_276 = new ActivityLog();
        $activityLog_276->setUserEmail('staff@gmail.com');
        $activityLog_276->setUserRole('ROLE_STAFF');
        $activityLog_276->setAction('Logout');
        $activityLog_276->setEntityType(null);
        $activityLog_276->setAffectedData(null);
        $activityLog_276->setDescription('User logged out');
        $activityLog_276->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:16:56'));
        $manager->persist($activityLog_276);

        $activityLog_277 = new ActivityLog();
        $activityLog_277->setUserEmail('staff@gmail.com');
        $activityLog_277->setUserRole('ROLE_STAFF');
        $activityLog_277->setAction('Login');
        $activityLog_277->setEntityType(null);
        $activityLog_277->setAffectedData(null);
        $activityLog_277->setDescription('User logged in');
        $activityLog_277->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:17:14'));
        $manager->persist($activityLog_277);

        $activityLog_278 = new ActivityLog();
        $activityLog_278->setUserEmail('staff@gmail.com');
        $activityLog_278->setUserRole('ROLE_STAFF');
        $activityLog_278->setAction('Logout');
        $activityLog_278->setEntityType(null);
        $activityLog_278->setAffectedData(null);
        $activityLog_278->setDescription('User logged out');
        $activityLog_278->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:17:23'));
        $manager->persist($activityLog_278);

        $activityLog_279 = new ActivityLog();
        $activityLog_279->setUserEmail('admin@gmail.com');
        $activityLog_279->setUserRole('ROLE_ADMIN');
        $activityLog_279->setAction('Login');
        $activityLog_279->setEntityType(null);
        $activityLog_279->setAffectedData(null);
        $activityLog_279->setDescription('User logged in');
        $activityLog_279->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:29:26'));
        $manager->persist($activityLog_279);

        $activityLog_280 = new ActivityLog();
        $activityLog_280->setUserEmail('admin@gmail.com');
        $activityLog_280->setUserRole('ROLE_ADMIN');
        $activityLog_280->setAction('Logout');
        $activityLog_280->setEntityType(null);
        $activityLog_280->setAffectedData(null);
        $activityLog_280->setDescription('User logged out');
        $activityLog_280->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:31:12'));
        $manager->persist($activityLog_280);

        $activityLog_281 = new ActivityLog();
        $activityLog_281->setUserEmail('admin@gmail.com');
        $activityLog_281->setUserRole('ROLE_ADMIN');
        $activityLog_281->setAction('Login');
        $activityLog_281->setEntityType(null);
        $activityLog_281->setAffectedData(null);
        $activityLog_281->setDescription('User logged in');
        $activityLog_281->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:33:09'));
        $manager->persist($activityLog_281);

        $activityLog_282 = new ActivityLog();
        $activityLog_282->setUserEmail('admin@gmail.com');
        $activityLog_282->setUserRole('ROLE_ADMIN');
        $activityLog_282->setAction('Logout');
        $activityLog_282->setEntityType(null);
        $activityLog_282->setAffectedData(null);
        $activityLog_282->setDescription('User logged out');
        $activityLog_282->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:39:04'));
        $manager->persist($activityLog_282);

        $activityLog_283 = new ActivityLog();
        $activityLog_283->setUserEmail('admin@gmail.com');
        $activityLog_283->setUserRole('ROLE_ADMIN');
        $activityLog_283->setAction('Login');
        $activityLog_283->setEntityType(null);
        $activityLog_283->setAffectedData(null);
        $activityLog_283->setDescription('User logged in');
        $activityLog_283->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:53:31'));
        $manager->persist($activityLog_283);

        $activityLog_284 = new ActivityLog();
        $activityLog_284->setUserEmail('admin@gmail.com');
        $activityLog_284->setUserRole('ROLE_ADMIN');
        $activityLog_284->setAction('Delete');
        $activityLog_284->setEntityType('User');
        $activityLog_284->setEntityId($this->getReference('user_2', User::class));
        $activityLog_284->setAffectedData('{
    "email": "louise@gmail.com",
    "name": "Louise",
    "roles": [
        "ROLE_USER"
    ]
}');
        $activityLog_284->setDescription('Deleted user account: louise@gmail.com');
        $activityLog_284->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:54:07'));
        $manager->persist($activityLog_284);

        $activityLog_285 = new ActivityLog();
        $activityLog_285->setUserEmail('admin@gmail.com');
        $activityLog_285->setUserRole('ROLE_ADMIN');
        $activityLog_285->setAction('Update');
        $activityLog_285->setEntityType('User');
        $activityLog_285->setEntityId($this->getReference('user_1', User::class));
        $activityLog_285->setAffectedData('{
    "old": {
        "status": "disabled"
    },
    "new": {
        "status": "active"
    }
}');
        $activityLog_285->setDescription('Changed user status: admin@example.com from disabled to active');
        $activityLog_285->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:55:07'));
        $manager->persist($activityLog_285);

        $activityLog_286 = new ActivityLog();
        $activityLog_286->setUserEmail('admin@gmail.com');
        $activityLog_286->setUserRole('ROLE_ADMIN');
        $activityLog_286->setAction('Delete');
        $activityLog_286->setEntityType('User');
        $activityLog_286->setEntityId($this->getReference('user_1', User::class));
        $activityLog_286->setAffectedData('{
    "email": "admin@example.com",
    "name": null,
    "roles": [
        "ROLE_ADMIN",
        "ROLE_USER"
    ]
}');
        $activityLog_286->setDescription('Deleted user account: admin@example.com');
        $activityLog_286->setCreatedAt(new \DateTimeImmutable('2026-04-07 13:58:55'));
        $manager->persist($activityLog_286);

        $activityLog_287 = new ActivityLog();
        $activityLog_287->setUserEmail('admin@gmail.com');
        $activityLog_287->setUserRole('ROLE_ADMIN');
        $activityLog_287->setAction('Logout');
        $activityLog_287->setEntityType(null);
        $activityLog_287->setAffectedData(null);
        $activityLog_287->setDescription('User logged out');
        $activityLog_287->setCreatedAt(new \DateTimeImmutable('2026-04-07 14:02:25'));
        $manager->persist($activityLog_287);

        $activityLog_288 = new ActivityLog();
        $activityLog_288->setUserEmail('luckydingal46@gmail.com');
        $activityLog_288->setUserRole('ROLE_USER');
        $activityLog_288->setAction('Login');
        $activityLog_288->setEntityType(null);
        $activityLog_288->setAffectedData(null);
        $activityLog_288->setDescription('User logged in');
        $activityLog_288->setCreatedAt(new \DateTimeImmutable('2026-04-07 14:09:09'));
        $manager->persist($activityLog_288);

        $activityLog_289 = new ActivityLog();
        $activityLog_289->setUserEmail('luckydingal46@gmail.com');
        $activityLog_289->setUserRole('ROLE_USER');
        $activityLog_289->setAction('Logout');
        $activityLog_289->setEntityType(null);
        $activityLog_289->setAffectedData(null);
        $activityLog_289->setDescription('User logged out');
        $activityLog_289->setCreatedAt(new \DateTimeImmutable('2026-04-07 15:00:37'));
        $manager->persist($activityLog_289);

        $activityLog_290 = new ActivityLog();
        $activityLog_290->setUserEmail('luckydingal46@gmail.com');
        $activityLog_290->setUserRole('ROLE_USER');
        $activityLog_290->setAction('Login');
        $activityLog_290->setEntityType(null);
        $activityLog_290->setAffectedData(null);
        $activityLog_290->setDescription('User logged in');
        $activityLog_290->setCreatedAt(new \DateTimeImmutable('2026-04-07 15:04:24'));
        $manager->persist($activityLog_290);

        $activityLog_291 = new ActivityLog();
        $activityLog_291->setUserEmail('luckydingal46@gmail.com');
        $activityLog_291->setUserRole('ROLE_USER');
        $activityLog_291->setAction('Logout');
        $activityLog_291->setEntityType(null);
        $activityLog_291->setAffectedData(null);
        $activityLog_291->setDescription('User logged out');
        $activityLog_291->setCreatedAt(new \DateTimeImmutable('2026-04-07 15:13:12'));
        $manager->persist($activityLog_291);

        $activityLog_292 = new ActivityLog();
        $activityLog_292->setUserEmail('luckydingal46@gmail.com');
        $activityLog_292->setUserRole('ROLE_USER');
        $activityLog_292->setAction('Login');
        $activityLog_292->setEntityType(null);
        $activityLog_292->setAffectedData(null);
        $activityLog_292->setDescription('User logged in');
        $activityLog_292->setCreatedAt(new \DateTimeImmutable('2026-04-07 16:58:46'));
        $manager->persist($activityLog_292);

        $activityLog_293 = new ActivityLog();
        $activityLog_293->setUserEmail('luckydingal46@gmail.com');
        $activityLog_293->setUserRole('ROLE_USER');
        $activityLog_293->setAction('Logout');
        $activityLog_293->setEntityType(null);
        $activityLog_293->setAffectedData(null);
        $activityLog_293->setDescription('User logged out');
        $activityLog_293->setCreatedAt(new \DateTimeImmutable('2026-04-07 16:59:20'));
        $manager->persist($activityLog_293);

        $activityLog_294 = new ActivityLog();
        $activityLog_294->setUserEmail('admin@gmail.com');
        $activityLog_294->setUserRole('ROLE_ADMIN');
        $activityLog_294->setAction('Login');
        $activityLog_294->setEntityType(null);
        $activityLog_294->setAffectedData(null);
        $activityLog_294->setDescription('User logged in');
        $activityLog_294->setCreatedAt(new \DateTimeImmutable('2026-04-08 03:31:16'));
        $manager->persist($activityLog_294);

        $activityLog_295 = new ActivityLog();
        $activityLog_295->setUserEmail('admin@gmail.com');
        $activityLog_295->setUserRole('ROLE_ADMIN');
        $activityLog_295->setAction('Logout');
        $activityLog_295->setEntityType(null);
        $activityLog_295->setAffectedData(null);
        $activityLog_295->setDescription('User logged out');
        $activityLog_295->setCreatedAt(new \DateTimeImmutable('2026-04-08 03:48:13'));
        $manager->persist($activityLog_295);

        $activityLog_296 = new ActivityLog();
        $activityLog_296->setUserEmail('admin@gmail.com');
        $activityLog_296->setUserRole('ROLE_ADMIN');
        $activityLog_296->setAction('Login');
        $activityLog_296->setEntityType(null);
        $activityLog_296->setAffectedData(null);
        $activityLog_296->setDescription('User logged in');
        $activityLog_296->setCreatedAt(new \DateTimeImmutable('2026-04-08 03:57:14'));
        $manager->persist($activityLog_296);

        $activityLog_297 = new ActivityLog();
        $activityLog_297->setUserEmail('staff@gmail.com');
        $activityLog_297->setUserRole('ROLE_STAFF');
        $activityLog_297->setAction('Login');
        $activityLog_297->setEntityType(null);
        $activityLog_297->setAffectedData(null);
        $activityLog_297->setDescription('User logged in');
        $activityLog_297->setCreatedAt(new \DateTimeImmutable('2026-04-08 03:57:38'));
        $manager->persist($activityLog_297);

        $activityLog_298 = new ActivityLog();
        $activityLog_298->setUserEmail('staff@gmail.com');
        $activityLog_298->setUserRole('ROLE_STAFF');
        $activityLog_298->setAction('Logout');
        $activityLog_298->setEntityType(null);
        $activityLog_298->setAffectedData(null);
        $activityLog_298->setDescription('User logged out');
        $activityLog_298->setCreatedAt(new \DateTimeImmutable('2026-04-08 03:58:06'));
        $manager->persist($activityLog_298);

        $activityLog_299 = new ActivityLog();
        $activityLog_299->setUserEmail('admin@gmail.com');
        $activityLog_299->setUserRole('ROLE_ADMIN');
        $activityLog_299->setAction('Login');
        $activityLog_299->setEntityType(null);
        $activityLog_299->setAffectedData(null);
        $activityLog_299->setDescription('User logged in');
        $activityLog_299->setCreatedAt(new \DateTimeImmutable('2026-04-08 03:58:22'));
        $manager->persist($activityLog_299);

        $activityLog_300 = new ActivityLog();
        $activityLog_300->setUserEmail('admin@gmail.com');
        $activityLog_300->setUserRole('ROLE_ADMIN');
        $activityLog_300->setAction('Logout');
        $activityLog_300->setEntityType(null);
        $activityLog_300->setAffectedData(null);
        $activityLog_300->setDescription('User logged out');
        $activityLog_300->setCreatedAt(new \DateTimeImmutable('2026-04-08 03:59:04'));
        $manager->persist($activityLog_300);

        $activityLog_301 = new ActivityLog();
        $activityLog_301->setUserEmail('luckydingal46@gmail.com');
        $activityLog_301->setUserRole('ROLE_USER');
        $activityLog_301->setAction('Login');
        $activityLog_301->setEntityType(null);
        $activityLog_301->setAffectedData(null);
        $activityLog_301->setDescription('User logged in');
        $activityLog_301->setCreatedAt(new \DateTimeImmutable('2026-04-08 03:59:19'));
        $manager->persist($activityLog_301);

        $activityLog_302 = new ActivityLog();
        $activityLog_302->setUserEmail('luckydingal46@gmail.com');
        $activityLog_302->setUserRole('ROLE_USER');
        $activityLog_302->setAction('Login');
        $activityLog_302->setEntityType(null);
        $activityLog_302->setAffectedData(null);
        $activityLog_302->setDescription('User logged in');
        $activityLog_302->setCreatedAt(new \DateTimeImmutable('2026-04-08 03:59:34'));
        $manager->persist($activityLog_302);

        $activityLog_303 = new ActivityLog();
        $activityLog_303->setUserEmail('luckydingal46@gmail.com');
        $activityLog_303->setUserRole('ROLE_USER');
        $activityLog_303->setAction('Logout');
        $activityLog_303->setEntityType(null);
        $activityLog_303->setAffectedData(null);
        $activityLog_303->setDescription('User logged out');
        $activityLog_303->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:03:01'));
        $manager->persist($activityLog_303);

        $activityLog_304 = new ActivityLog();
        $activityLog_304->setUserEmail('admin@gmail.com');
        $activityLog_304->setUserRole('ROLE_ADMIN');
        $activityLog_304->setAction('Login');
        $activityLog_304->setEntityType(null);
        $activityLog_304->setAffectedData(null);
        $activityLog_304->setDescription('User logged in');
        $activityLog_304->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:03:11'));
        $manager->persist($activityLog_304);

        $activityLog_305 = new ActivityLog();
        $activityLog_305->setUserEmail('admin@gmail.com');
        $activityLog_305->setUserRole('ROLE_ADMIN');
        $activityLog_305->setAction('Logout');
        $activityLog_305->setEntityType(null);
        $activityLog_305->setAffectedData(null);
        $activityLog_305->setDescription('User logged out');
        $activityLog_305->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:05:48'));
        $manager->persist($activityLog_305);

        $activityLog_306 = new ActivityLog();
        $activityLog_306->setUserEmail('admin@gmail.com');
        $activityLog_306->setUserRole('ROLE_ADMIN');
        $activityLog_306->setAction('Login');
        $activityLog_306->setEntityType(null);
        $activityLog_306->setAffectedData(null);
        $activityLog_306->setDescription('User logged in');
        $activityLog_306->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:06:51'));
        $manager->persist($activityLog_306);

        $activityLog_307 = new ActivityLog();
        $activityLog_307->setUserEmail('admin@gmail.com');
        $activityLog_307->setUserRole('ROLE_ADMIN');
        $activityLog_307->setAction('Logout');
        $activityLog_307->setEntityType(null);
        $activityLog_307->setAffectedData(null);
        $activityLog_307->setDescription('User logged out');
        $activityLog_307->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:47:54'));
        $manager->persist($activityLog_307);

        $activityLog_308 = new ActivityLog();
        $activityLog_308->setUserEmail('admin@gmail.com');
        $activityLog_308->setUserRole('ROLE_ADMIN');
        $activityLog_308->setAction('Login');
        $activityLog_308->setEntityType(null);
        $activityLog_308->setAffectedData(null);
        $activityLog_308->setDescription('User logged in');
        $activityLog_308->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:51:32'));
        $manager->persist($activityLog_308);

        $activityLog_309 = new ActivityLog();
        $activityLog_309->setUserEmail('admin@gmail.com');
        $activityLog_309->setUserRole('ROLE_ADMIN');
        $activityLog_309->setAction('Create');
        $activityLog_309->setEntityType('User');
        $activityLog_309->setEntityId($this->getReference('user_12', User::class));
        $activityLog_309->setAffectedData('{
    "email": "Staff2@gmail.com",
    "role": "ROLE_STAFF",
    "status": "active"
}');
        $activityLog_309->setDescription('Created user account: Staff2@gmail.com (ROLE_STAFF)');
        $activityLog_309->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:52:24'));
        $manager->persist($activityLog_309);

        $activityLog_310 = new ActivityLog();
        $activityLog_310->setUserEmail('admin@gmail.com');
        $activityLog_310->setUserRole('ROLE_ADMIN');
        $activityLog_310->setAction('Logout');
        $activityLog_310->setEntityType(null);
        $activityLog_310->setAffectedData(null);
        $activityLog_310->setDescription('User logged out');
        $activityLog_310->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:52:39'));
        $manager->persist($activityLog_310);

        $activityLog_311 = new ActivityLog();
        $activityLog_311->setUserEmail('Staff2@gmail.com');
        $activityLog_311->setUserRole('ROLE_STAFF');
        $activityLog_311->setAction('Login');
        $activityLog_311->setEntityType(null);
        $activityLog_311->setAffectedData(null);
        $activityLog_311->setDescription('User logged in');
        $activityLog_311->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:53:11'));
        $manager->persist($activityLog_311);

        $activityLog_312 = new ActivityLog();
        $activityLog_312->setUserEmail('Staff2@gmail.com');
        $activityLog_312->setUserRole('ROLE_STAFF');
        $activityLog_312->setAction('Logout');
        $activityLog_312->setEntityType(null);
        $activityLog_312->setAffectedData(null);
        $activityLog_312->setDescription('User logged out');
        $activityLog_312->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:53:15'));
        $manager->persist($activityLog_312);

        $activityLog_313 = new ActivityLog();
        $activityLog_313->setUserEmail('Staff2@gmail.com');
        $activityLog_313->setUserRole('ROLE_STAFF');
        $activityLog_313->setAction('Login');
        $activityLog_313->setEntityType(null);
        $activityLog_313->setAffectedData(null);
        $activityLog_313->setDescription('User logged in');
        $activityLog_313->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:53:32'));
        $manager->persist($activityLog_313);

        $activityLog_314 = new ActivityLog();
        $activityLog_314->setUserEmail('Staff2@gmail.com');
        $activityLog_314->setUserRole('ROLE_STAFF');
        $activityLog_314->setAction('Logout');
        $activityLog_314->setEntityType(null);
        $activityLog_314->setAffectedData(null);
        $activityLog_314->setDescription('User logged out');
        $activityLog_314->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:53:53'));
        $manager->persist($activityLog_314);

        $activityLog_315 = new ActivityLog();
        $activityLog_315->setUserEmail('staff@gmail.com');
        $activityLog_315->setUserRole('ROLE_STAFF');
        $activityLog_315->setAction('Login');
        $activityLog_315->setEntityType(null);
        $activityLog_315->setAffectedData(null);
        $activityLog_315->setDescription('User logged in');
        $activityLog_315->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:54:03'));
        $manager->persist($activityLog_315);

        $activityLog_316 = new ActivityLog();
        $activityLog_316->setUserEmail('staff@gmail.com');
        $activityLog_316->setUserRole('ROLE_STAFF');
        $activityLog_316->setAction('Logout');
        $activityLog_316->setEntityType(null);
        $activityLog_316->setAffectedData(null);
        $activityLog_316->setDescription('User logged out');
        $activityLog_316->setCreatedAt(new \DateTimeImmutable('2026-04-08 04:54:16'));
        $manager->persist($activityLog_316);

        $activityLog_317 = new ActivityLog();
        $activityLog_317->setUserEmail('luckydingal46@gmail.com');
        $activityLog_317->setUserRole('ROLE_USER');
        $activityLog_317->setAction('Login');
        $activityLog_317->setEntityType(null);
        $activityLog_317->setAffectedData(null);
        $activityLog_317->setDescription('User logged in');
        $activityLog_317->setCreatedAt(new \DateTimeImmutable('2026-04-08 05:20:54'));
        $manager->persist($activityLog_317);

        $activityLog_318 = new ActivityLog();
        $activityLog_318->setUserEmail('luckydingal46@gmail.com');
        $activityLog_318->setUserRole('ROLE_USER');
        $activityLog_318->setAction('Logout');
        $activityLog_318->setEntityType(null);
        $activityLog_318->setAffectedData(null);
        $activityLog_318->setDescription('User logged out');
        $activityLog_318->setCreatedAt(new \DateTimeImmutable('2026-04-08 05:21:20'));
        $manager->persist($activityLog_318);

        $activityLog_319 = new ActivityLog();
        $activityLog_319->setUserEmail('admin@gmail.com');
        $activityLog_319->setUserRole('ROLE_ADMIN');
        $activityLog_319->setAction('Login');
        $activityLog_319->setEntityType(null);
        $activityLog_319->setAffectedData(null);
        $activityLog_319->setDescription('User logged in');
        $activityLog_319->setCreatedAt(new \DateTimeImmutable('2026-04-08 05:23:06'));
        $manager->persist($activityLog_319);

        $activityLog_320 = new ActivityLog();
        $activityLog_320->setUserEmail('admin@gmail.com');
        $activityLog_320->setUserRole('ROLE_ADMIN');
        $activityLog_320->setAction('Logout');
        $activityLog_320->setEntityType(null);
        $activityLog_320->setAffectedData(null);
        $activityLog_320->setDescription('User logged out');
        $activityLog_320->setCreatedAt(new \DateTimeImmutable('2026-04-08 05:26:27'));
        $manager->persist($activityLog_320);

        $activityLog_321 = new ActivityLog();
        $activityLog_321->setUserEmail('Staff2@gmail.com');
        $activityLog_321->setUserRole('ROLE_STAFF');
        $activityLog_321->setAction('Login');
        $activityLog_321->setEntityType(null);
        $activityLog_321->setAffectedData(null);
        $activityLog_321->setDescription('User logged in');
        $activityLog_321->setCreatedAt(new \DateTimeImmutable('2026-04-08 05:26:48'));
        $manager->persist($activityLog_321);

        $activityLog_322 = new ActivityLog();
        $activityLog_322->setUserEmail('Staff2@gmail.com');
        $activityLog_322->setUserRole('ROLE_STAFF');
        $activityLog_322->setAction('Logout');
        $activityLog_322->setEntityType(null);
        $activityLog_322->setAffectedData(null);
        $activityLog_322->setDescription('User logged out');
        $activityLog_322->setCreatedAt(new \DateTimeImmutable('2026-04-08 05:26:51'));
        $manager->persist($activityLog_322);

        $activityLog_323 = new ActivityLog();
        $activityLog_323->setUserEmail('luckydingal46@gmail.com');
        $activityLog_323->setUserRole('ROLE_USER');
        $activityLog_323->setAction('Login');
        $activityLog_323->setEntityType(null);
        $activityLog_323->setAffectedData(null);
        $activityLog_323->setDescription('User logged in');
        $activityLog_323->setCreatedAt(new \DateTimeImmutable('2026-04-08 05:37:55'));
        $manager->persist($activityLog_323);

        $activityLog_324 = new ActivityLog();
        $activityLog_324->setUserEmail('luckydingal46@gmail.com');
        $activityLog_324->setUserRole('ROLE_USER');
        $activityLog_324->setAction('Logout');
        $activityLog_324->setEntityType(null);
        $activityLog_324->setAffectedData(null);
        $activityLog_324->setDescription('User logged out');
        $activityLog_324->setCreatedAt(new \DateTimeImmutable('2026-04-08 05:47:00'));
        $manager->persist($activityLog_324);

        $activityLog_325 = new ActivityLog();
        $activityLog_325->setUserEmail('admin@gmail.com');
        $activityLog_325->setUserRole('ROLE_ADMIN');
        $activityLog_325->setAction('Login');
        $activityLog_325->setEntityType(null);
        $activityLog_325->setAffectedData(null);
        $activityLog_325->setDescription('User logged in');
        $activityLog_325->setCreatedAt(new \DateTimeImmutable('2026-04-08 05:47:39'));
        $manager->persist($activityLog_325);

        $activityLog_326 = new ActivityLog();
        $activityLog_326->setUserEmail('admin@gmail.com');
        $activityLog_326->setUserRole('ROLE_ADMIN');
        $activityLog_326->setAction('Logout');
        $activityLog_326->setEntityType(null);
        $activityLog_326->setAffectedData(null);
        $activityLog_326->setDescription('User logged out');
        $activityLog_326->setCreatedAt(new \DateTimeImmutable('2026-04-08 06:05:59'));
        $manager->persist($activityLog_326);

        $activityLog_327 = new ActivityLog();
        $activityLog_327->setUserEmail('admin@gmail.com');
        $activityLog_327->setUserRole('ROLE_ADMIN');
        $activityLog_327->setAction('Login');
        $activityLog_327->setEntityType(null);
        $activityLog_327->setAffectedData(null);
        $activityLog_327->setDescription('User logged in');
        $activityLog_327->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:34:23'));
        $manager->persist($activityLog_327);

        $activityLog_328 = new ActivityLog();
        $activityLog_328->setUserEmail('admin@gmail.com');
        $activityLog_328->setUserRole('ROLE_ADMIN');
        $activityLog_328->setAction('Update');
        $activityLog_328->setEntityType('User');
        $activityLog_328->setEntityId($this->getReference('user_11', User::class));
        $activityLog_328->setAffectedData('{
    "old": {
        "email": "luckydingal46@gmail.com",
        "name": "Louise",
        "roles": [
            "ROLE_USER"
        ],
        "status": "active"
    },
    "new": {
        "email": "luckydingal46@gmail.com",
        "name": "Louise",
        "role": "ROLE_STAFF",
        "status": "active"
    }
}');
        $activityLog_328->setDescription('Updated user account: luckydingal46@gmail.com');
        $activityLog_328->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:34:57'));
        $manager->persist($activityLog_328);

        $activityLog_329 = new ActivityLog();
        $activityLog_329->setUserEmail('admin@gmail.com');
        $activityLog_329->setUserRole('ROLE_ADMIN');
        $activityLog_329->setAction('Logout');
        $activityLog_329->setEntityType(null);
        $activityLog_329->setAffectedData(null);
        $activityLog_329->setDescription('User logged out');
        $activityLog_329->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:35:10'));
        $manager->persist($activityLog_329);

        $activityLog_330 = new ActivityLog();
        $activityLog_330->setUserEmail('luckydingal46@gmail.com');
        $activityLog_330->setUserRole('ROLE_STAFF');
        $activityLog_330->setAction('Login');
        $activityLog_330->setEntityType(null);
        $activityLog_330->setAffectedData(null);
        $activityLog_330->setDescription('User logged in');
        $activityLog_330->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:35:28'));
        $manager->persist($activityLog_330);

        $activityLog_331 = new ActivityLog();
        $activityLog_331->setUserEmail('luckydingal46@gmail.com');
        $activityLog_331->setUserRole('ROLE_STAFF');
        $activityLog_331->setAction('Logout');
        $activityLog_331->setEntityType(null);
        $activityLog_331->setAffectedData(null);
        $activityLog_331->setDescription('User logged out');
        $activityLog_331->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:36:07'));
        $manager->persist($activityLog_331);

        $activityLog_332 = new ActivityLog();
        $activityLog_332->setUserEmail('admin@gmail.com');
        $activityLog_332->setUserRole('ROLE_ADMIN');
        $activityLog_332->setAction('Login');
        $activityLog_332->setEntityType(null);
        $activityLog_332->setAffectedData(null);
        $activityLog_332->setDescription('User logged in');
        $activityLog_332->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:37:14'));
        $manager->persist($activityLog_332);

        $activityLog_333 = new ActivityLog();
        $activityLog_333->setUserEmail('admin@gmail.com');
        $activityLog_333->setUserRole('ROLE_ADMIN');
        $activityLog_333->setAction('Delete');
        $activityLog_333->setEntityType('User');
        $activityLog_333->setEntityId($this->getReference('user_11', User::class));
        $activityLog_333->setAffectedData('{
    "email": "luckydingal46@gmail.com",
    "name": "Louise",
    "roles": [
        "ROLE_STAFF",
        "ROLE_USER"
    ]
}');
        $activityLog_333->setDescription('Deleted user account: luckydingal46@gmail.com');
        $activityLog_333->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:37:32'));
        $manager->persist($activityLog_333);

        $activityLog_334 = new ActivityLog();
        $activityLog_334->setUserEmail('admin@gmail.com');
        $activityLog_334->setUserRole('ROLE_ADMIN');
        $activityLog_334->setAction('Logout');
        $activityLog_334->setEntityType(null);
        $activityLog_334->setAffectedData(null);
        $activityLog_334->setDescription('User logged out');
        $activityLog_334->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:38:02'));
        $manager->persist($activityLog_334);

        $activityLog_335 = new ActivityLog();
        $activityLog_335->setUserEmail('admin@gmail.com');
        $activityLog_335->setUserRole('ROLE_ADMIN');
        $activityLog_335->setAction('Login');
        $activityLog_335->setEntityType(null);
        $activityLog_335->setAffectedData(null);
        $activityLog_335->setDescription('User logged in');
        $activityLog_335->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:40:54'));
        $manager->persist($activityLog_335);

        $activityLog_336 = new ActivityLog();
        $activityLog_336->setUserEmail('admin@gmail.com');
        $activityLog_336->setUserRole('ROLE_ADMIN');
        $activityLog_336->setAction('Logout');
        $activityLog_336->setEntityType(null);
        $activityLog_336->setAffectedData(null);
        $activityLog_336->setDescription('User logged out');
        $activityLog_336->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:41:50'));
        $manager->persist($activityLog_336);

        $activityLog_337 = new ActivityLog();
        $activityLog_337->setUserEmail('luckydingal46@gmail.com');
        $activityLog_337->setUserRole('ROLE_USER');
        $activityLog_337->setAction('Login');
        $activityLog_337->setEntityType(null);
        $activityLog_337->setAffectedData(null);
        $activityLog_337->setDescription('User logged in');
        $activityLog_337->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:42:12'));
        $manager->persist($activityLog_337);

        $activityLog_338 = new ActivityLog();
        $activityLog_338->setUserEmail('luckydingal46@gmail.com');
        $activityLog_338->setUserRole('ROLE_USER');
        $activityLog_338->setAction('Logout');
        $activityLog_338->setEntityType(null);
        $activityLog_338->setAffectedData(null);
        $activityLog_338->setDescription('User logged out');
        $activityLog_338->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:42:19'));
        $manager->persist($activityLog_338);

        $activityLog_339 = new ActivityLog();
        $activityLog_339->setUserEmail('admin@gmail.com');
        $activityLog_339->setUserRole('ROLE_ADMIN');
        $activityLog_339->setAction('Login');
        $activityLog_339->setEntityType(null);
        $activityLog_339->setAffectedData(null);
        $activityLog_339->setDescription('User logged in');
        $activityLog_339->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:44:09'));
        $manager->persist($activityLog_339);

        $activityLog_340 = new ActivityLog();
        $activityLog_340->setUserEmail('admin@gmail.com');
        $activityLog_340->setUserRole('ROLE_ADMIN');
        $activityLog_340->setAction('Logout');
        $activityLog_340->setEntityType(null);
        $activityLog_340->setAffectedData(null);
        $activityLog_340->setDescription('User logged out');
        $activityLog_340->setCreatedAt(new \DateTimeImmutable('2026-04-08 07:44:26'));
        $manager->persist($activityLog_340);

        $activityLog_341 = new ActivityLog();
        $activityLog_341->setUserEmail('admin@gmail.com');
        $activityLog_341->setUserRole('ROLE_ADMIN');
        $activityLog_341->setAction('Login');
        $activityLog_341->setEntityType(null);
        $activityLog_341->setAffectedData(null);
        $activityLog_341->setDescription('User logged in');
        $activityLog_341->setCreatedAt(new \DateTimeImmutable('2026-04-08 08:05:23'));
        $manager->persist($activityLog_341);

        $activityLog_342 = new ActivityLog();
        $activityLog_342->setUserEmail('admin@gmail.com');
        $activityLog_342->setUserRole('ROLE_ADMIN');
        $activityLog_342->setAction('Logout');
        $activityLog_342->setEntityType(null);
        $activityLog_342->setAffectedData(null);
        $activityLog_342->setDescription('User logged out');
        $activityLog_342->setCreatedAt(new \DateTimeImmutable('2026-04-08 08:09:58'));
        $manager->persist($activityLog_342);

        $activityLog_343 = new ActivityLog();
        $activityLog_343->setUserEmail('edudingal17@gmail.com');
        $activityLog_343->setUserRole('ROLE_USER');
        $activityLog_343->setAction('Login');
        $activityLog_343->setEntityType(null);
        $activityLog_343->setAffectedData(null);
        $activityLog_343->setDescription('User logged in');
        $activityLog_343->setCreatedAt(new \DateTimeImmutable('2026-04-08 08:18:14'));
        $manager->persist($activityLog_343);

        $activityLog_344 = new ActivityLog();
        $activityLog_344->setUserEmail('edudingal17@gmail.com');
        $activityLog_344->setUserRole('ROLE_USER');
        $activityLog_344->setAction('Logout');
        $activityLog_344->setEntityType(null);
        $activityLog_344->setAffectedData(null);
        $activityLog_344->setDescription('User logged out');
        $activityLog_344->setCreatedAt(new \DateTimeImmutable('2026-04-08 08:18:35'));
        $manager->persist($activityLog_344);

        $activityLog_345 = new ActivityLog();
        $activityLog_345->setUserEmail('admin@gmail.com');
        $activityLog_345->setUserRole('ROLE_ADMIN');
        $activityLog_345->setAction('Login');
        $activityLog_345->setEntityType(null);
        $activityLog_345->setAffectedData(null);
        $activityLog_345->setDescription('User logged in');
        $activityLog_345->setCreatedAt(new \DateTimeImmutable('2026-04-08 08:42:40'));
        $manager->persist($activityLog_345);

        $activityLog_346 = new ActivityLog();
        $activityLog_346->setUserEmail('admin@gmail.com');
        $activityLog_346->setUserRole('ROLE_ADMIN');
        $activityLog_346->setAction('Logout');
        $activityLog_346->setEntityType(null);
        $activityLog_346->setAffectedData(null);
        $activityLog_346->setDescription('User logged out');
        $activityLog_346->setCreatedAt(new \DateTimeImmutable('2026-04-08 08:43:31'));
        $manager->persist($activityLog_346);

        $activityLog_347 = new ActivityLog();
        $activityLog_347->setUserEmail('edudingal17@gmail.com');
        $activityLog_347->setUserRole('ROLE_USER');
        $activityLog_347->setAction('Login');
        $activityLog_347->setEntityType(null);
        $activityLog_347->setAffectedData(null);
        $activityLog_347->setDescription('User logged in');
        $activityLog_347->setCreatedAt(new \DateTimeImmutable('2026-04-08 12:51:34'));
        $manager->persist($activityLog_347);

        $activityLog_348 = new ActivityLog();
        $activityLog_348->setUserEmail('edudingal17@gmail.com');
        $activityLog_348->setUserRole('ROLE_USER');
        $activityLog_348->setAction('Logout');
        $activityLog_348->setEntityType(null);
        $activityLog_348->setAffectedData(null);
        $activityLog_348->setDescription('User logged out');
        $activityLog_348->setCreatedAt(new \DateTimeImmutable('2026-04-08 12:57:54'));
        $manager->persist($activityLog_348);

        $activityLog_349 = new ActivityLog();
        $activityLog_349->setUserEmail('rhyzlmaechuaacaso@gmail.com');
        $activityLog_349->setUserRole('ROLE_USER');
        $activityLog_349->setAction('Login');
        $activityLog_349->setEntityType(null);
        $activityLog_349->setAffectedData(null);
        $activityLog_349->setDescription('User logged in');
        $activityLog_349->setCreatedAt(new \DateTimeImmutable('2026-04-09 03:13:49'));
        $manager->persist($activityLog_349);

        $activityLog_350 = new ActivityLog();
        $activityLog_350->setUserEmail('rhyzlmaechuaacaso@gmail.com');
        $activityLog_350->setUserRole('ROLE_USER');
        $activityLog_350->setAction('Logout');
        $activityLog_350->setEntityType(null);
        $activityLog_350->setAffectedData(null);
        $activityLog_350->setDescription('User logged out');
        $activityLog_350->setCreatedAt(new \DateTimeImmutable('2026-04-09 03:16:06'));
        $manager->persist($activityLog_350);

        $activityLog_351 = new ActivityLog();
        $activityLog_351->setUserEmail('admin@gmail.com');
        $activityLog_351->setUserRole('ROLE_ADMIN');
        $activityLog_351->setAction('Login');
        $activityLog_351->setEntityType(null);
        $activityLog_351->setAffectedData(null);
        $activityLog_351->setDescription('User logged in');
        $activityLog_351->setCreatedAt(new \DateTimeImmutable('2026-04-09 03:16:30'));
        $manager->persist($activityLog_351);

        $activityLog_352 = new ActivityLog();
        $activityLog_352->setUserEmail('admin@gmail.com');
        $activityLog_352->setUserRole('ROLE_ADMIN');
        $activityLog_352->setAction('Logout');
        $activityLog_352->setEntityType(null);
        $activityLog_352->setAffectedData(null);
        $activityLog_352->setDescription('User logged out');
        $activityLog_352->setCreatedAt(new \DateTimeImmutable('2026-04-09 03:37:36'));
        $manager->persist($activityLog_352);

        $activityLog_353 = new ActivityLog();
        $activityLog_353->setUserEmail('luckydingal46@gmail.com');
        $activityLog_353->setUserRole('ROLE_USER');
        $activityLog_353->setAction('Login');
        $activityLog_353->setEntityType(null);
        $activityLog_353->setAffectedData(null);
        $activityLog_353->setDescription('User logged in');
        $activityLog_353->setCreatedAt(new \DateTimeImmutable('2026-04-09 03:38:23'));
        $manager->persist($activityLog_353);

        $activityLog_354 = new ActivityLog();
        $activityLog_354->setUserEmail('luckydingal46@gmail.com');
        $activityLog_354->setUserRole('ROLE_USER');
        $activityLog_354->setAction('Logout');
        $activityLog_354->setEntityType(null);
        $activityLog_354->setAffectedData(null);
        $activityLog_354->setDescription('User logged out');
        $activityLog_354->setCreatedAt(new \DateTimeImmutable('2026-04-09 06:23:33'));
        $manager->persist($activityLog_354);

        $activityLog_355 = new ActivityLog();
        $activityLog_355->setUserEmail('luckydingal46@gmail.com');
        $activityLog_355->setUserRole('ROLE_USER');
        $activityLog_355->setAction('Login');
        $activityLog_355->setEntityType(null);
        $activityLog_355->setAffectedData(null);
        $activityLog_355->setDescription('User logged in');
        $activityLog_355->setCreatedAt(new \DateTimeImmutable('2026-04-09 06:28:31'));
        $manager->persist($activityLog_355);

        $activityLog_356 = new ActivityLog();
        $activityLog_356->setUserEmail('luckydingal46@gmail.com');
        $activityLog_356->setUserRole('ROLE_USER');
        $activityLog_356->setAction('Logout');
        $activityLog_356->setEntityType(null);
        $activityLog_356->setAffectedData(null);
        $activityLog_356->setDescription('User logged out');
        $activityLog_356->setCreatedAt(new \DateTimeImmutable('2026-04-09 06:52:47'));
        $manager->persist($activityLog_356);

        $activityLog_357 = new ActivityLog();
        $activityLog_357->setUserEmail('luckydingal46@gmail.com');
        $activityLog_357->setUserRole('ROLE_USER');
        $activityLog_357->setAction('Login');
        $activityLog_357->setEntityType(null);
        $activityLog_357->setAffectedData(null);
        $activityLog_357->setDescription('User logged in');
        $activityLog_357->setCreatedAt(new \DateTimeImmutable('2026-04-09 07:10:25'));
        $manager->persist($activityLog_357);

        $activityLog_358 = new ActivityLog();
        $activityLog_358->setUserEmail('luckydingal46@gmail.com');
        $activityLog_358->setUserRole('ROLE_USER');
        $activityLog_358->setAction('Logout');
        $activityLog_358->setEntityType(null);
        $activityLog_358->setAffectedData(null);
        $activityLog_358->setDescription('User logged out');
        $activityLog_358->setCreatedAt(new \DateTimeImmutable('2026-04-09 07:16:14'));
        $manager->persist($activityLog_358);

        $activityLog_359 = new ActivityLog();
        $activityLog_359->setUserEmail('admin@gmail.com');
        $activityLog_359->setUserRole('ROLE_ADMIN');
        $activityLog_359->setAction('Login');
        $activityLog_359->setEntityType(null);
        $activityLog_359->setAffectedData(null);
        $activityLog_359->setDescription('User logged in');
        $activityLog_359->setCreatedAt(new \DateTimeImmutable('2026-04-09 07:16:26'));
        $manager->persist($activityLog_359);

        $activityLog_360 = new ActivityLog();
        $activityLog_360->setUserEmail('admin@gmail.com');
        $activityLog_360->setUserRole('ROLE_ADMIN');
        $activityLog_360->setAction('Logout');
        $activityLog_360->setEntityType(null);
        $activityLog_360->setAffectedData(null);
        $activityLog_360->setDescription('User logged out');
        $activityLog_360->setCreatedAt(new \DateTimeImmutable('2026-04-09 10:50:09'));
        $manager->persist($activityLog_360);

        $activityLog_361 = new ActivityLog();
        $activityLog_361->setUserEmail('luckydingal46@gmail.com');
        $activityLog_361->setUserRole('ROLE_USER');
        $activityLog_361->setAction('Login');
        $activityLog_361->setEntityType(null);
        $activityLog_361->setAffectedData(null);
        $activityLog_361->setDescription('User logged in');
        $activityLog_361->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:29:38'));
        $manager->persist($activityLog_361);

        $activityLog_362 = new ActivityLog();
        $activityLog_362->setUserEmail('luckydingal46@gmail.com');
        $activityLog_362->setUserRole('ROLE_USER');
        $activityLog_362->setAction('Logout');
        $activityLog_362->setEntityType(null);
        $activityLog_362->setAffectedData(null);
        $activityLog_362->setDescription('User logged out');
        $activityLog_362->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:29:46'));
        $manager->persist($activityLog_362);

        $activityLog_363 = new ActivityLog();
        $activityLog_363->setUserEmail('luckydingal46@gmail.com');
        $activityLog_363->setUserRole('ROLE_USER');
        $activityLog_363->setAction('Login');
        $activityLog_363->setEntityType(null);
        $activityLog_363->setAffectedData(null);
        $activityLog_363->setDescription('User logged in');
        $activityLog_363->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:30:06'));
        $manager->persist($activityLog_363);

        $activityLog_364 = new ActivityLog();
        $activityLog_364->setUserEmail('luckydingal46@gmail.com');
        $activityLog_364->setUserRole('ROLE_USER');
        $activityLog_364->setAction('Logout');
        $activityLog_364->setEntityType(null);
        $activityLog_364->setAffectedData(null);
        $activityLog_364->setDescription('User logged out');
        $activityLog_364->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:30:19'));
        $manager->persist($activityLog_364);

        $activityLog_365 = new ActivityLog();
        $activityLog_365->setUserEmail('admin@gmail.com');
        $activityLog_365->setUserRole('ROLE_ADMIN');
        $activityLog_365->setAction('Login');
        $activityLog_365->setEntityType(null);
        $activityLog_365->setAffectedData(null);
        $activityLog_365->setDescription('User logged in');
        $activityLog_365->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:30:33'));
        $manager->persist($activityLog_365);

        $activityLog_366 = new ActivityLog();
        $activityLog_366->setUserEmail('admin@gmail.com');
        $activityLog_366->setUserRole('ROLE_ADMIN');
        $activityLog_366->setAction('Logout');
        $activityLog_366->setEntityType(null);
        $activityLog_366->setAffectedData(null);
        $activityLog_366->setDescription('User logged out');
        $activityLog_366->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:31:27'));
        $manager->persist($activityLog_366);

        $activityLog_367 = new ActivityLog();
        $activityLog_367->setUserEmail('luckydingal46@gmail.com');
        $activityLog_367->setUserRole('ROLE_USER');
        $activityLog_367->setAction('Login');
        $activityLog_367->setEntityType(null);
        $activityLog_367->setAffectedData(null);
        $activityLog_367->setDescription('User logged in');
        $activityLog_367->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:31:42'));
        $manager->persist($activityLog_367);

        $activityLog_368 = new ActivityLog();
        $activityLog_368->setUserEmail('luckydingal46@gmail.com');
        $activityLog_368->setUserRole('ROLE_USER');
        $activityLog_368->setAction('Logout');
        $activityLog_368->setEntityType(null);
        $activityLog_368->setAffectedData(null);
        $activityLog_368->setDescription('User logged out');
        $activityLog_368->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:31:46'));
        $manager->persist($activityLog_368);

        $activityLog_369 = new ActivityLog();
        $activityLog_369->setUserEmail('luckydingal46@gmail.com');
        $activityLog_369->setUserRole('ROLE_USER');
        $activityLog_369->setAction('Login');
        $activityLog_369->setEntityType(null);
        $activityLog_369->setAffectedData(null);
        $activityLog_369->setDescription('User logged in');
        $activityLog_369->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:32:09'));
        $manager->persist($activityLog_369);

        $activityLog_370 = new ActivityLog();
        $activityLog_370->setUserEmail('luckydingal46@gmail.com');
        $activityLog_370->setUserRole('ROLE_USER');
        $activityLog_370->setAction('Logout');
        $activityLog_370->setEntityType(null);
        $activityLog_370->setAffectedData(null);
        $activityLog_370->setDescription('User logged out');
        $activityLog_370->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:32:17'));
        $manager->persist($activityLog_370);

        $activityLog_371 = new ActivityLog();
        $activityLog_371->setUserEmail('admin@gmail.com');
        $activityLog_371->setUserRole('ROLE_ADMIN');
        $activityLog_371->setAction('Login');
        $activityLog_371->setEntityType(null);
        $activityLog_371->setAffectedData(null);
        $activityLog_371->setDescription('User logged in');
        $activityLog_371->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:32:28'));
        $manager->persist($activityLog_371);

        $activityLog_372 = new ActivityLog();
        $activityLog_372->setUserEmail('admin@gmail.com');
        $activityLog_372->setUserRole('ROLE_ADMIN');
        $activityLog_372->setAction('Delete');
        $activityLog_372->setEntityType('User');
        $activityLog_372->setEntityId($this->getReference('user_16', User::class));
        $activityLog_372->setAffectedData('{
    "email": "luckydingal46@gmail.com",
    "name": null,
    "roles": [
        "ROLE_USER"
    ]
}');
        $activityLog_372->setDescription('Deleted user account: luckydingal46@gmail.com');
        $activityLog_372->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:32:51'));
        $manager->persist($activityLog_372);

        $activityLog_373 = new ActivityLog();
        $activityLog_373->setUserEmail('admin@gmail.com');
        $activityLog_373->setUserRole('ROLE_ADMIN');
        $activityLog_373->setAction('Logout');
        $activityLog_373->setEntityType(null);
        $activityLog_373->setAffectedData(null);
        $activityLog_373->setDescription('User logged out');
        $activityLog_373->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:33:03'));
        $manager->persist($activityLog_373);

        $activityLog_374 = new ActivityLog();
        $activityLog_374->setUserEmail('luckydingal46@gmail.com');
        $activityLog_374->setUserRole('ROLE_USER');
        $activityLog_374->setAction('Login');
        $activityLog_374->setEntityType(null);
        $activityLog_374->setAffectedData(null);
        $activityLog_374->setDescription('User logged in');
        $activityLog_374->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:33:14'));
        $manager->persist($activityLog_374);

        $activityLog_375 = new ActivityLog();
        $activityLog_375->setUserEmail('luckydingal46@gmail.com');
        $activityLog_375->setUserRole('ROLE_USER');
        $activityLog_375->setAction('Logout');
        $activityLog_375->setEntityType(null);
        $activityLog_375->setAffectedData(null);
        $activityLog_375->setDescription('User logged out');
        $activityLog_375->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:33:19'));
        $manager->persist($activityLog_375);

        $activityLog_376 = new ActivityLog();
        $activityLog_376->setUserEmail('luckydingal46@gmail.com');
        $activityLog_376->setUserRole('ROLE_USER');
        $activityLog_376->setAction('Login');
        $activityLog_376->setEntityType(null);
        $activityLog_376->setAffectedData(null);
        $activityLog_376->setDescription('User logged in');
        $activityLog_376->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:34:13'));
        $manager->persist($activityLog_376);

        $activityLog_377 = new ActivityLog();
        $activityLog_377->setUserEmail('luckydingal46@gmail.com');
        $activityLog_377->setUserRole('ROLE_USER');
        $activityLog_377->setAction('Logout');
        $activityLog_377->setEntityType(null);
        $activityLog_377->setAffectedData(null);
        $activityLog_377->setDescription('User logged out');
        $activityLog_377->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:34:19'));
        $manager->persist($activityLog_377);

        $activityLog_378 = new ActivityLog();
        $activityLog_378->setUserEmail('luckydingal46@gmail.com');
        $activityLog_378->setUserRole('ROLE_USER');
        $activityLog_378->setAction('Login');
        $activityLog_378->setEntityType(null);
        $activityLog_378->setAffectedData(null);
        $activityLog_378->setDescription('User logged in');
        $activityLog_378->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:34:33'));
        $manager->persist($activityLog_378);

        $activityLog_379 = new ActivityLog();
        $activityLog_379->setUserEmail('luckydingal46@gmail.com');
        $activityLog_379->setUserRole('ROLE_USER');
        $activityLog_379->setAction('Logout');
        $activityLog_379->setEntityType(null);
        $activityLog_379->setAffectedData(null);
        $activityLog_379->setDescription('User logged out');
        $activityLog_379->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:34:44'));
        $manager->persist($activityLog_379);

        $activityLog_380 = new ActivityLog();
        $activityLog_380->setUserEmail('luckydingal46@gmail.com');
        $activityLog_380->setUserRole('ROLE_USER');
        $activityLog_380->setAction('Login');
        $activityLog_380->setEntityType(null);
        $activityLog_380->setAffectedData(null);
        $activityLog_380->setDescription('User logged in');
        $activityLog_380->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:35:00'));
        $manager->persist($activityLog_380);

        $activityLog_381 = new ActivityLog();
        $activityLog_381->setUserEmail('luckydingal46@gmail.com');
        $activityLog_381->setUserRole('ROLE_USER');
        $activityLog_381->setAction('Logout');
        $activityLog_381->setEntityType(null);
        $activityLog_381->setAffectedData(null);
        $activityLog_381->setDescription('User logged out');
        $activityLog_381->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:35:04'));
        $manager->persist($activityLog_381);

        $activityLog_382 = new ActivityLog();
        $activityLog_382->setUserEmail('admin@gmail.com');
        $activityLog_382->setUserRole('ROLE_ADMIN');
        $activityLog_382->setAction('Login');
        $activityLog_382->setEntityType(null);
        $activityLog_382->setAffectedData(null);
        $activityLog_382->setDescription('User logged in');
        $activityLog_382->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:35:15'));
        $manager->persist($activityLog_382);

        $activityLog_383 = new ActivityLog();
        $activityLog_383->setUserEmail('admin@gmail.com');
        $activityLog_383->setUserRole('ROLE_ADMIN');
        $activityLog_383->setAction('Delete');
        $activityLog_383->setEntityType('User');
        $activityLog_383->setEntityId($this->getReference('user_17', User::class));
        $activityLog_383->setAffectedData('{
    "email": "luckydingal46@gmail.com",
    "name": null,
    "roles": [
        "ROLE_USER"
    ]
}');
        $activityLog_383->setDescription('Deleted user account: luckydingal46@gmail.com');
        $activityLog_383->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:35:25'));
        $manager->persist($activityLog_383);

        $activityLog_384 = new ActivityLog();
        $activityLog_384->setUserEmail('admin@gmail.com');
        $activityLog_384->setUserRole('ROLE_ADMIN');
        $activityLog_384->setAction('Update');
        $activityLog_384->setEntityType('User');
        $activityLog_384->setEntityId($this->getReference('user_14', User::class));
        $activityLog_384->setAffectedData('{
    "old": {
        "email": "edudingal17@gmail.com",
        "name": null,
        "roles": [
            "ROLE_USER"
        ],
        "status": "active"
    },
    "new": {
        "email": "edudingal17@gmail.com",
        "name": null,
        "role": "ROLE_STAFF",
        "status": "active"
    }
}');
        $activityLog_384->setDescription('Updated user account: edudingal17@gmail.com');
        $activityLog_384->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:35:57'));
        $manager->persist($activityLog_384);

        $activityLog_385 = new ActivityLog();
        $activityLog_385->setUserEmail('admin@gmail.com');
        $activityLog_385->setUserRole('ROLE_ADMIN');
        $activityLog_385->setAction('Logout');
        $activityLog_385->setEntityType(null);
        $activityLog_385->setAffectedData(null);
        $activityLog_385->setDescription('User logged out');
        $activityLog_385->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:36:05'));
        $manager->persist($activityLog_385);

        $activityLog_386 = new ActivityLog();
        $activityLog_386->setUserEmail('admin@gmail.com');
        $activityLog_386->setUserRole('ROLE_ADMIN');
        $activityLog_386->setAction('Login');
        $activityLog_386->setEntityType(null);
        $activityLog_386->setAffectedData(null);
        $activityLog_386->setDescription('User logged in');
        $activityLog_386->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:53:41'));
        $manager->persist($activityLog_386);

        $activityLog_387 = new ActivityLog();
        $activityLog_387->setUserEmail('admin@gmail.com');
        $activityLog_387->setUserRole('ROLE_ADMIN');
        $activityLog_387->setAction('Delete');
        $activityLog_387->setEntityType('User');
        $activityLog_387->setEntityId($this->getReference('user_14', User::class));
        $activityLog_387->setAffectedData('{
    "email": "edudingal17@gmail.com",
    "name": null,
    "roles": [
        "ROLE_STAFF",
        "ROLE_USER"
    ]
}');
        $activityLog_387->setDescription('Deleted user account: edudingal17@gmail.com');
        $activityLog_387->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:54:02'));
        $manager->persist($activityLog_387);

        $activityLog_388 = new ActivityLog();
        $activityLog_388->setUserEmail('admin@gmail.com');
        $activityLog_388->setUserRole('ROLE_ADMIN');
        $activityLog_388->setAction('Delete');
        $activityLog_388->setEntityType('User');
        $activityLog_388->setEntityId($this->getReference('user_15', User::class));
        $activityLog_388->setAffectedData('{
    "email": "rhyzlmaechuaacaso@gmail.com",
    "name": null,
    "roles": [
        "ROLE_USER"
    ]
}');
        $activityLog_388->setDescription('Deleted user account: rhyzlmaechuaacaso@gmail.com');
        $activityLog_388->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:54:06'));
        $manager->persist($activityLog_388);

        $activityLog_389 = new ActivityLog();
        $activityLog_389->setUserEmail('admin@gmail.com');
        $activityLog_389->setUserRole('ROLE_ADMIN');
        $activityLog_389->setAction('Logout');
        $activityLog_389->setEntityType(null);
        $activityLog_389->setAffectedData(null);
        $activityLog_389->setDescription('User logged out');
        $activityLog_389->setCreatedAt(new \DateTimeImmutable('2026-04-14 11:54:24'));
        $manager->persist($activityLog_389);

        $activityLog_390 = new ActivityLog();
        $activityLog_390->setUserEmail('luckydingal46@gmail.com');
        $activityLog_390->setUserRole('ROLE_USER');
        $activityLog_390->setAction('Login');
        $activityLog_390->setEntityType(null);
        $activityLog_390->setAffectedData(null);
        $activityLog_390->setDescription('User logged in');
        $activityLog_390->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:31:12'));
        $manager->persist($activityLog_390);

        $activityLog_391 = new ActivityLog();
        $activityLog_391->setUserEmail('luckydingal46@gmail.com');
        $activityLog_391->setUserRole('ROLE_USER');
        $activityLog_391->setAction('Logout');
        $activityLog_391->setEntityType(null);
        $activityLog_391->setAffectedData(null);
        $activityLog_391->setDescription('User logged out');
        $activityLog_391->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:31:23'));
        $manager->persist($activityLog_391);

        $activityLog_392 = new ActivityLog();
        $activityLog_392->setUserEmail('admin@gmail.com');
        $activityLog_392->setUserRole('ROLE_ADMIN');
        $activityLog_392->setAction('Login');
        $activityLog_392->setEntityType(null);
        $activityLog_392->setAffectedData(null);
        $activityLog_392->setDescription('User logged in');
        $activityLog_392->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:31:38'));
        $manager->persist($activityLog_392);

        $activityLog_393 = new ActivityLog();
        $activityLog_393->setUserEmail('admin@gmail.com');
        $activityLog_393->setUserRole('ROLE_ADMIN');
        $activityLog_393->setAction('Update');
        $activityLog_393->setEntityType('User');
        $activityLog_393->setEntityId($this->getReference('user_18', User::class));
        $activityLog_393->setAffectedData('{
    "old": {
        "email": "luckydingal46@gmail.com",
        "name": null,
        "roles": [
            "ROLE_USER"
        ],
        "status": "active"
    },
    "new": {
        "email": "luckydingal46@gmail.com",
        "name": null,
        "role": "ROLE_USER",
        "status": "active"
    }
}');
        $activityLog_393->setDescription('Updated user account: luckydingal46@gmail.com');
        $activityLog_393->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:32:08'));
        $manager->persist($activityLog_393);

        $activityLog_394 = new ActivityLog();
        $activityLog_394->setUserEmail('admin@gmail.com');
        $activityLog_394->setUserRole('ROLE_ADMIN');
        $activityLog_394->setAction('Update');
        $activityLog_394->setEntityType('User');
        $activityLog_394->setEntityId($this->getReference('user_18', User::class));
        $activityLog_394->setAffectedData('{
    "old": {
        "email": "luckydingal46@gmail.com",
        "name": null,
        "roles": [
            "ROLE_USER"
        ],
        "status": "active"
    },
    "new": {
        "email": "luckydingal46@gmail.com",
        "name": null,
        "role": "ROLE_STAFF",
        "status": "active"
    }
}');
        $activityLog_394->setDescription('Updated user account: luckydingal46@gmail.com');
        $activityLog_394->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:32:18'));
        $manager->persist($activityLog_394);

        $activityLog_395 = new ActivityLog();
        $activityLog_395->setUserEmail('admin@gmail.com');
        $activityLog_395->setUserRole('ROLE_ADMIN');
        $activityLog_395->setAction('Delete');
        $activityLog_395->setEntityType('User');
        $activityLog_395->setEntityId($this->getReference('user_12', User::class));
        $activityLog_395->setAffectedData('{
    "email": "Staff2@gmail.com",
    "name": "Staff2",
    "roles": [
        "ROLE_STAFF",
        "ROLE_USER"
    ]
}');
        $activityLog_395->setDescription('Deleted user account: Staff2@gmail.com');
        $activityLog_395->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:32:32'));
        $manager->persist($activityLog_395);

        $activityLog_396 = new ActivityLog();
        $activityLog_396->setUserEmail('admin@gmail.com');
        $activityLog_396->setUserRole('ROLE_ADMIN');
        $activityLog_396->setAction('Logout');
        $activityLog_396->setEntityType(null);
        $activityLog_396->setAffectedData(null);
        $activityLog_396->setDescription('User logged out');
        $activityLog_396->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:32:40'));
        $manager->persist($activityLog_396);

        $activityLog_397 = new ActivityLog();
        $activityLog_397->setUserEmail('luckydingal46@gmail.com');
        $activityLog_397->setUserRole('ROLE_STAFF');
        $activityLog_397->setAction('Login');
        $activityLog_397->setEntityType(null);
        $activityLog_397->setAffectedData(null);
        $activityLog_397->setDescription('User logged in');
        $activityLog_397->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:33:13'));
        $manager->persist($activityLog_397);

        $activityLog_398 = new ActivityLog();
        $activityLog_398->setUserEmail('luckydingal46@gmail.com');
        $activityLog_398->setUserRole('ROLE_STAFF');
        $activityLog_398->setAction('Logout');
        $activityLog_398->setEntityType(null);
        $activityLog_398->setAffectedData(null);
        $activityLog_398->setDescription('User logged out');
        $activityLog_398->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:33:50'));
        $manager->persist($activityLog_398);

        $activityLog_399 = new ActivityLog();
        $activityLog_399->setUserEmail('admin@gmail.com');
        $activityLog_399->setUserRole('ROLE_ADMIN');
        $activityLog_399->setAction('Login');
        $activityLog_399->setEntityType(null);
        $activityLog_399->setAffectedData(null);
        $activityLog_399->setDescription('User logged in');
        $activityLog_399->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:38:00'));
        $manager->persist($activityLog_399);

        $activityLog_400 = new ActivityLog();
        $activityLog_400->setUserEmail('admin@gmail.com');
        $activityLog_400->setUserRole('ROLE_ADMIN');
        $activityLog_400->setAction('Login');
        $activityLog_400->setEntityType(null);
        $activityLog_400->setAffectedData(null);
        $activityLog_400->setDescription('User logged in');
        $activityLog_400->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:39:53'));
        $manager->persist($activityLog_400);

        $activityLog_401 = new ActivityLog();
        $activityLog_401->setUserEmail('admin@gmail.com');
        $activityLog_401->setUserRole('ROLE_ADMIN');
        $activityLog_401->setAction('Logout');
        $activityLog_401->setEntityType(null);
        $activityLog_401->setAffectedData(null);
        $activityLog_401->setDescription('User logged out');
        $activityLog_401->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:40:15'));
        $manager->persist($activityLog_401);

        $activityLog_402 = new ActivityLog();
        $activityLog_402->setUserEmail('admin@gmail.com');
        $activityLog_402->setUserRole('ROLE_ADMIN');
        $activityLog_402->setAction('Logout');
        $activityLog_402->setEntityType(null);
        $activityLog_402->setAffectedData(null);
        $activityLog_402->setDescription('User logged out');
        $activityLog_402->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:40:31'));
        $manager->persist($activityLog_402);

        $activityLog_403 = new ActivityLog();
        $activityLog_403->setUserEmail('luckydingal46@gmail.com');
        $activityLog_403->setUserRole('ROLE_STAFF');
        $activityLog_403->setAction('Login');
        $activityLog_403->setEntityType(null);
        $activityLog_403->setAffectedData(null);
        $activityLog_403->setDescription('User logged in');
        $activityLog_403->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:40:55'));
        $manager->persist($activityLog_403);

        $activityLog_404 = new ActivityLog();
        $activityLog_404->setUserEmail('luckydingal46@gmail.com');
        $activityLog_404->setUserRole('ROLE_STAFF');
        $activityLog_404->setAction('Logout');
        $activityLog_404->setEntityType(null);
        $activityLog_404->setAffectedData(null);
        $activityLog_404->setDescription('User logged out');
        $activityLog_404->setCreatedAt(new \DateTimeImmutable('2026-04-14 12:41:23'));
        $manager->persist($activityLog_404);

        $activityLog_405 = new ActivityLog();
        $activityLog_405->setUserEmail('luckydingal46@gmail.com');
        $activityLog_405->setUserRole('ROLE_STAFF');
        $activityLog_405->setAction('Login');
        $activityLog_405->setEntityType(null);
        $activityLog_405->setAffectedData(null);
        $activityLog_405->setDescription('User logged in');
        $activityLog_405->setCreatedAt(new \DateTimeImmutable('2026-04-30 04:16:24'));
        $manager->persist($activityLog_405);

        $activityLog_406 = new ActivityLog();
        $activityLog_406->setUserEmail('luckydingal46@gmail.com');
        $activityLog_406->setUserRole('ROLE_STAFF');
        $activityLog_406->setAction('Logout');
        $activityLog_406->setEntityType(null);
        $activityLog_406->setAffectedData(null);
        $activityLog_406->setDescription('User logged out');
        $activityLog_406->setCreatedAt(new \DateTimeImmutable('2026-04-30 04:16:46'));
        $manager->persist($activityLog_406);

        $activityLog_407 = new ActivityLog();
        $activityLog_407->setUserEmail('admin@gmail.com');
        $activityLog_407->setUserRole('ROLE_ADMIN');
        $activityLog_407->setAction('Login');
        $activityLog_407->setEntityType(null);
        $activityLog_407->setAffectedData(null);
        $activityLog_407->setDescription('User logged in');
        $activityLog_407->setCreatedAt(new \DateTimeImmutable('2026-04-30 04:18:41'));
        $manager->persist($activityLog_407);

        $activityLog_408 = new ActivityLog();
        $activityLog_408->setUserEmail('admin@gmail.com');
        $activityLog_408->setUserRole('ROLE_ADMIN');
        $activityLog_408->setAction('Logout');
        $activityLog_408->setEntityType(null);
        $activityLog_408->setAffectedData(null);
        $activityLog_408->setDescription('User logged out');
        $activityLog_408->setCreatedAt(new \DateTimeImmutable('2026-04-30 04:19:23'));
        $manager->persist($activityLog_408);

        $activityLog_409 = new ActivityLog();
        $activityLog_409->setUserEmail('luckydingal46@gmail.com');
        $activityLog_409->setUserRole('ROLE_STAFF');
        $activityLog_409->setAction('Login');
        $activityLog_409->setEntityType(null);
        $activityLog_409->setAffectedData(null);
        $activityLog_409->setDescription('User logged in');
        $activityLog_409->setCreatedAt(new \DateTimeImmutable('2026-04-30 04:21:49'));
        $manager->persist($activityLog_409);

        $activityLog_410 = new ActivityLog();
        $activityLog_410->setUserEmail('luckydingal46@gmail.com');
        $activityLog_410->setUserRole('ROLE_STAFF');
        $activityLog_410->setAction('Logout');
        $activityLog_410->setEntityType(null);
        $activityLog_410->setAffectedData(null);
        $activityLog_410->setDescription('User logged out');
        $activityLog_410->setCreatedAt(new \DateTimeImmutable('2026-04-30 04:25:30'));
        $manager->persist($activityLog_410);

        $activityLog_411 = new ActivityLog();
        $activityLog_411->setUserEmail('luckydingal46@gmail.com');
        $activityLog_411->setUserRole('ROLE_STAFF');
        $activityLog_411->setAction('Login');
        $activityLog_411->setEntityType(null);
        $activityLog_411->setAffectedData(null);
        $activityLog_411->setDescription('User logged in');
        $activityLog_411->setCreatedAt(new \DateTimeImmutable('2026-04-30 04:25:52'));
        $manager->persist($activityLog_411);

        $activityLog_412 = new ActivityLog();
        $activityLog_412->setUserEmail('luckydingal46@gmail.com');
        $activityLog_412->setUserRole('ROLE_STAFF');
        $activityLog_412->setAction('Logout');
        $activityLog_412->setEntityType(null);
        $activityLog_412->setAffectedData(null);
        $activityLog_412->setDescription('User logged out');
        $activityLog_412->setCreatedAt(new \DateTimeImmutable('2026-04-30 04:26:00'));
        $manager->persist($activityLog_412);

        $activityLog_413 = new ActivityLog();
        $activityLog_413->setUserEmail('admin@gmail.com');
        $activityLog_413->setUserRole('ROLE_ADMIN');
        $activityLog_413->setAction('Login');
        $activityLog_413->setEntityType(null);
        $activityLog_413->setAffectedData(null);
        $activityLog_413->setDescription('User logged in');
        $activityLog_413->setCreatedAt(new \DateTimeImmutable('2026-04-30 04:29:31'));
        $manager->persist($activityLog_413);

        $activityLog_414 = new ActivityLog();
        $activityLog_414->setUserEmail('admin@gmail.com');
        $activityLog_414->setUserRole('ROLE_ADMIN');
        $activityLog_414->setAction('Logout');
        $activityLog_414->setEntityType(null);
        $activityLog_414->setAffectedData(null);
        $activityLog_414->setDescription('User logged out');
        $activityLog_414->setCreatedAt(new \DateTimeImmutable('2026-04-30 04:37:20'));
        $manager->persist($activityLog_414);

        $activityLog_415 = new ActivityLog();
        $activityLog_415->setUserEmail('admin@gmail.com');
        $activityLog_415->setUserRole('ROLE_ADMIN');
        $activityLog_415->setAction('Login');
        $activityLog_415->setEntityType(null);
        $activityLog_415->setAffectedData(null);
        $activityLog_415->setDescription('User logged in');
        $activityLog_415->setCreatedAt(new \DateTimeImmutable('2026-04-30 04:37:33'));
        $manager->persist($activityLog_415);

        $activityLog_416 = new ActivityLog();
        $activityLog_416->setUserEmail('admin@gmail.com');
        $activityLog_416->setUserRole('ROLE_ADMIN');
        $activityLog_416->setAction('Login');
        $activityLog_416->setEntityType(null);
        $activityLog_416->setAffectedData(null);
        $activityLog_416->setDescription('User logged in');
        $activityLog_416->setCreatedAt(new \DateTimeImmutable('2026-05-05 09:36:16'));
        $manager->persist($activityLog_416);

        $activityLog_417 = new ActivityLog();
        $activityLog_417->setUserEmail('admin@gmail.com');
        $activityLog_417->setUserRole('ROLE_ADMIN');
        $activityLog_417->setAction('Logout');
        $activityLog_417->setEntityType(null);
        $activityLog_417->setAffectedData(null);
        $activityLog_417->setDescription('User logged out');
        $activityLog_417->setCreatedAt(new \DateTimeImmutable('2026-05-05 09:36:53'));
        $manager->persist($activityLog_417);

        $activityLog_418 = new ActivityLog();
        $activityLog_418->setUserEmail('luckydingal46@gmail.com');
        $activityLog_418->setUserRole('ROLE_STAFF');
        $activityLog_418->setAction('Login');
        $activityLog_418->setEntityType(null);
        $activityLog_418->setAffectedData(null);
        $activityLog_418->setDescription('User logged in');
        $activityLog_418->setCreatedAt(new \DateTimeImmutable('2026-05-05 09:39:09'));
        $manager->persist($activityLog_418);

        $activityLog_419 = new ActivityLog();
        $activityLog_419->setUserEmail('luckydingal46@gmail.com');
        $activityLog_419->setUserRole('ROLE_STAFF');
        $activityLog_419->setAction('Login');
        $activityLog_419->setEntityType(null);
        $activityLog_419->setAffectedData(null);
        $activityLog_419->setDescription('User logged in');
        $activityLog_419->setCreatedAt(new \DateTimeImmutable('2026-05-20 16:20:30'));
        $manager->persist($activityLog_419);

        $activityLog_420 = new ActivityLog();
        $activityLog_420->setUserEmail('luckydingal46@gmail.com');
        $activityLog_420->setUserRole('ROLE_STAFF');
        $activityLog_420->setAction('Login');
        $activityLog_420->setEntityType(null);
        $activityLog_420->setAffectedData(null);
        $activityLog_420->setDescription('User logged in');
        $activityLog_420->setCreatedAt(new \DateTimeImmutable('2026-05-20 16:20:43'));
        $manager->persist($activityLog_420);

        $activityLog_421 = new ActivityLog();
        $activityLog_421->setUserEmail('luckydingal46@gmail.com');
        $activityLog_421->setUserRole('ROLE_STAFF');
        $activityLog_421->setAction('Login');
        $activityLog_421->setEntityType(null);
        $activityLog_421->setAffectedData(null);
        $activityLog_421->setDescription('User logged in');
        $activityLog_421->setCreatedAt(new \DateTimeImmutable('2026-05-20 16:21:08'));
        $manager->persist($activityLog_421);

        $activityLog_422 = new ActivityLog();
        $activityLog_422->setUserEmail('luckydingal46@gmail.com');
        $activityLog_422->setUserRole('ROLE_STAFF');
        $activityLog_422->setAction('Login');
        $activityLog_422->setEntityType(null);
        $activityLog_422->setAffectedData(null);
        $activityLog_422->setDescription('User logged in');
        $activityLog_422->setCreatedAt(new \DateTimeImmutable('2026-05-20 16:42:42'));
        $manager->persist($activityLog_422);

        $activityLog_423 = new ActivityLog();
        $activityLog_423->setUserEmail('luckydingal46@gmail.com');
        $activityLog_423->setUserRole('ROLE_STAFF');
        $activityLog_423->setAction('Login');
        $activityLog_423->setEntityType(null);
        $activityLog_423->setAffectedData(null);
        $activityLog_423->setDescription('User logged in');
        $activityLog_423->setCreatedAt(new \DateTimeImmutable('2026-05-20 16:57:21'));
        $manager->persist($activityLog_423);

        $activityLog_424 = new ActivityLog();
        $activityLog_424->setUserEmail('luckydingal46@gmail.com');
        $activityLog_424->setUserRole('ROLE_STAFF');
        $activityLog_424->setAction('Login');
        $activityLog_424->setEntityType(null);
        $activityLog_424->setAffectedData(null);
        $activityLog_424->setDescription('User logged in');
        $activityLog_424->setCreatedAt(new \DateTimeImmutable('2026-05-20 17:33:35'));
        $manager->persist($activityLog_424);

        $activityLog_425 = new ActivityLog();
        $activityLog_425->setUserEmail('luckydingal46@gmail.com');
        $activityLog_425->setUserRole('ROLE_STAFF');
        $activityLog_425->setAction('Login');
        $activityLog_425->setEntityType(null);
        $activityLog_425->setAffectedData(null);
        $activityLog_425->setDescription('User logged in');
        $activityLog_425->setCreatedAt(new \DateTimeImmutable('2026-05-20 17:37:45'));
        $manager->persist($activityLog_425);

        $activityLog_426 = new ActivityLog();
        $activityLog_426->setUserEmail('edudingal17@gmail.com');
        $activityLog_426->setUserRole('ROLE_USER');
        $activityLog_426->setAction('Login');
        $activityLog_426->setEntityType(null);
        $activityLog_426->setAffectedData(null);
        $activityLog_426->setDescription('User logged in');
        $activityLog_426->setCreatedAt(new \DateTimeImmutable('2026-05-20 17:50:24'));
        $manager->persist($activityLog_426);

        $activityLog_427 = new ActivityLog();
        $activityLog_427->setUserEmail('admin@gmail.com');
        $activityLog_427->setUserRole('ROLE_ADMIN');
        $activityLog_427->setAction('Login');
        $activityLog_427->setEntityType(null);
        $activityLog_427->setAffectedData(null);
        $activityLog_427->setDescription('User logged in');
        $activityLog_427->setCreatedAt(new \DateTimeImmutable('2026-05-21 07:12:04'));
        $manager->persist($activityLog_427);

        $activityLog_428 = new ActivityLog();
        $activityLog_428->setUserEmail('edudingal17@gmail.com');
        $activityLog_428->setUserRole('ROLE_USER');
        $activityLog_428->setAction('Login');
        $activityLog_428->setEntityType(null);
        $activityLog_428->setAffectedData(null);
        $activityLog_428->setDescription('User logged in');
        $activityLog_428->setCreatedAt(new \DateTimeImmutable('2026-05-21 07:24:10'));
        $manager->persist($activityLog_428);

        $activityLog_429 = new ActivityLog();
        $activityLog_429->setUserEmail('edudingal17@gmail.com');
        $activityLog_429->setUserRole('ROLE_USER');
        $activityLog_429->setAction('Login');
        $activityLog_429->setEntityType(null);
        $activityLog_429->setAffectedData(null);
        $activityLog_429->setDescription('User logged in');
        $activityLog_429->setCreatedAt(new \DateTimeImmutable('2026-05-21 07:40:46'));
        $manager->persist($activityLog_429);

        $activityLog_430 = new ActivityLog();
        $activityLog_430->setUserEmail('edudingal17@gmail.com');
        $activityLog_430->setUserRole('ROLE_USER');
        $activityLog_430->setAction('Login');
        $activityLog_430->setEntityType(null);
        $activityLog_430->setAffectedData(null);
        $activityLog_430->setDescription('User logged in');
        $activityLog_430->setCreatedAt(new \DateTimeImmutable('2026-05-21 10:38:13'));
        $manager->persist($activityLog_430);

        $activityLog_431 = new ActivityLog();
        $activityLog_431->setUserEmail('edudingal17@gmail.com');
        $activityLog_431->setUserRole('ROLE_USER');
        $activityLog_431->setAction('Login');
        $activityLog_431->setEntityType(null);
        $activityLog_431->setAffectedData(null);
        $activityLog_431->setDescription('User logged in');
        $activityLog_431->setCreatedAt(new \DateTimeImmutable('2026-05-21 10:38:24'));
        $manager->persist($activityLog_431);

        $activityLog_432 = new ActivityLog();
        $activityLog_432->setUserEmail('edudingal17@gmail.com');
        $activityLog_432->setUserRole('ROLE_USER');
        $activityLog_432->setAction('Event Request');
        $activityLog_432->setEntityType('EventRequest');
        $activityLog_432->setEntityId($this->getReference('user_4', User::class));
        $activityLog_432->setAffectedData('{
    "eventType": "Service: lain sample",
    "source": "mobile_app",
    "status": "pending"
}');
        $activityLog_432->setDescription('New mobile app event request: Service: lain sample from edudingal17@gmail.com');
        $activityLog_432->setCreatedAt(new \DateTimeImmutable('2026-05-21 10:40:30'));
        $manager->persist($activityLog_432);

        $activityLog_433 = new ActivityLog();
        $activityLog_433->setUserEmail('edudingal17@gmail.com');
        $activityLog_433->setUserRole('ROLE_USER');
        $activityLog_433->setAction('Login');
        $activityLog_433->setEntityType(null);
        $activityLog_433->setAffectedData(null);
        $activityLog_433->setDescription('User logged in');
        $activityLog_433->setCreatedAt(new \DateTimeImmutable('2026-05-21 11:00:29'));
        $manager->persist($activityLog_433);

        $activityLog_434 = new ActivityLog();
        $activityLog_434->setUserEmail('admin@gmail.com');
        $activityLog_434->setUserRole('ROLE_ADMIN');
        $activityLog_434->setAction('Update');
        $activityLog_434->setEntityType('ServicePackage');
        $activityLog_434->setEntityId($this->getReference('user_2', User::class));
        $activityLog_434->setAffectedData('{
    "old": {
        "name": "lain sample",
        "price": 1500
    },
    "new": {
        "name": "Birthday",
        "price": 10000
    }
}');
        $activityLog_434->setDescription('Updated service package: Birthday');
        $activityLog_434->setCreatedAt(new \DateTimeImmutable('2026-05-21 12:45:49'));
        $manager->persist($activityLog_434);

        $activityLog_435 = new ActivityLog();
        $activityLog_435->setUserEmail('admin@gmail.com');
        $activityLog_435->setUserRole('ROLE_ADMIN');
        $activityLog_435->setAction('Update');
        $activityLog_435->setEntityType('ServicePackage');
        $activityLog_435->setEntityId($this->getReference('user_1', User::class));
        $activityLog_435->setAffectedData('{
    "old": {
        "name": "Sample package",
        "price": 5000
    },
    "new": {
        "name": "Sample package",
        "price": 5000
    }
}');
        $activityLog_435->setDescription('Updated service package: Sample package');
        $activityLog_435->setCreatedAt(new \DateTimeImmutable('2026-05-21 13:16:47'));
        $manager->persist($activityLog_435);

        $activityLog_436 = new ActivityLog();
        $activityLog_436->setUserEmail('admin@gmail.com');
        $activityLog_436->setUserRole('ROLE_ADMIN');
        $activityLog_436->setAction('Update');
        $activityLog_436->setEntityType('ServicePackage');
        $activityLog_436->setEntityId($this->getReference('user_1', User::class));
        $activityLog_436->setAffectedData('{
    "old": {
        "name": "Sample package",
        "price": 5000
    },
    "new": {
        "name": "Wedding",
        "price": 20000
    }
}');
        $activityLog_436->setDescription('Updated service package: Wedding');
        $activityLog_436->setCreatedAt(new \DateTimeImmutable('2026-05-21 13:17:19'));
        $manager->persist($activityLog_436);

        $activityLog_437 = new ActivityLog();
        $activityLog_437->setUserEmail('edudingal17@gmail.com');
        $activityLog_437->setUserRole('ROLE_USER');
        $activityLog_437->setAction('Login');
        $activityLog_437->setEntityType(null);
        $activityLog_437->setAffectedData(null);
        $activityLog_437->setDescription('User logged in');
        $activityLog_437->setCreatedAt(new \DateTimeImmutable('2026-05-21 13:40:18'));
        $manager->persist($activityLog_437);

        $activityLog_438 = new ActivityLog();
        $activityLog_438->setUserEmail('admin@gmail.com');
        $activityLog_438->setUserRole('ROLE_ADMIN');
        $activityLog_438->setAction('Logout');
        $activityLog_438->setEntityType(null);
        $activityLog_438->setAffectedData(null);
        $activityLog_438->setDescription('User logged out');
        $activityLog_438->setCreatedAt(new \DateTimeImmutable('2026-05-21 14:33:30'));
        $manager->persist($activityLog_438);

        $activityLog_439 = new ActivityLog();
        $activityLog_439->setUserEmail('edudingal17@gmail.com');
        $activityLog_439->setUserRole('ROLE_USER');
        $activityLog_439->setAction('Login');
        $activityLog_439->setEntityType(null);
        $activityLog_439->setAffectedData(null);
        $activityLog_439->setDescription('User logged in');
        $activityLog_439->setCreatedAt(new \DateTimeImmutable('2026-05-21 14:40:38'));
        $manager->persist($activityLog_439);

        $activityLog_440 = new ActivityLog();
        $activityLog_440->setUserEmail('edudingal17@gmail.com');
        $activityLog_440->setUserRole('ROLE_USER');
        $activityLog_440->setAction('Login');
        $activityLog_440->setEntityType(null);
        $activityLog_440->setAffectedData(null);
        $activityLog_440->setDescription('User logged in');
        $activityLog_440->setCreatedAt(new \DateTimeImmutable('2026-05-21 14:47:19'));
        $manager->persist($activityLog_440);

        $activityLog_441 = new ActivityLog();
        $activityLog_441->setUserEmail('edudingal17@gmail.com');
        $activityLog_441->setUserRole('ROLE_USER');
        $activityLog_441->setAction('Event Request');
        $activityLog_441->setEntityType('EventRequest');
        $activityLog_441->setEntityId($this->getReference('user_5', User::class));
        $activityLog_441->setAffectedData('{
    "eventType": "Wedding",
    "source": "mobile_app",
    "status": "pending"
}');
        $activityLog_441->setDescription('New mobile app event request: Wedding from edudingal17@gmail.com');
        $activityLog_441->setCreatedAt(new \DateTimeImmutable('2026-05-21 16:27:53'));
        $manager->persist($activityLog_441);

        $activityLog_442 = new ActivityLog();
        $activityLog_442->setUserEmail('admin@gmail.com');
        $activityLog_442->setUserRole('ROLE_ADMIN');
        $activityLog_442->setAction('Login');
        $activityLog_442->setEntityType(null);
        $activityLog_442->setAffectedData(null);
        $activityLog_442->setDescription('User logged in');
        $activityLog_442->setCreatedAt(new \DateTimeImmutable('2026-05-21 16:28:27'));
        $manager->persist($activityLog_442);

        $activityLog_443 = new ActivityLog();
        $activityLog_443->setUserEmail('edudingal17@gmail.com');
        $activityLog_443->setUserRole('ROLE_USER');
        $activityLog_443->setAction('Event Request');
        $activityLog_443->setEntityType('EventRequest');
        $activityLog_443->setEntityId($this->getReference('user_6', User::class));
        $activityLog_443->setAffectedData('{
    "eventType": "Wedding",
    "source": "mobile_app",
    "status": "pending"
}');
        $activityLog_443->setDescription('New mobile app event request: Wedding from edudingal17@gmail.com');
        $activityLog_443->setCreatedAt(new \DateTimeImmutable('2026-05-21 16:34:43'));
        $manager->persist($activityLog_443);

        $activityLog_444 = new ActivityLog();
        $activityLog_444->setUserEmail('admin@gmail.com');
        $activityLog_444->setUserRole('ROLE_ADMIN');
        $activityLog_444->setAction('Login');
        $activityLog_444->setEntityType(null);
        $activityLog_444->setAffectedData(null);
        $activityLog_444->setDescription('User logged in');
        $activityLog_444->setCreatedAt(new \DateTimeImmutable('2026-05-22 01:30:23'));
        $manager->persist($activityLog_444);

        $activityLog_445 = new ActivityLog();
        $activityLog_445->setUserEmail('admin@gmail.com');
        $activityLog_445->setUserRole('ROLE_ADMIN');
        $activityLog_445->setAction('Logout');
        $activityLog_445->setEntityType(null);
        $activityLog_445->setAffectedData(null);
        $activityLog_445->setDescription('User logged out');
        $activityLog_445->setCreatedAt(new \DateTimeImmutable('2026-05-22 01:30:32'));
        $manager->persist($activityLog_445);

        $activityLog_446 = new ActivityLog();
        $activityLog_446->setUserEmail('admin@gmail.com');
        $activityLog_446->setUserRole('ROLE_ADMIN');
        $activityLog_446->setAction('Login');
        $activityLog_446->setEntityType(null);
        $activityLog_446->setAffectedData(null);
        $activityLog_446->setDescription('User logged in');
        $activityLog_446->setCreatedAt(new \DateTimeImmutable('2026-05-22 01:32:52'));
        $manager->persist($activityLog_446);

        $activityLog_447 = new ActivityLog();
        $activityLog_447->setUserEmail('admin@gmail.com');
        $activityLog_447->setUserRole('ROLE_ADMIN');
        $activityLog_447->setAction('Logout');
        $activityLog_447->setEntityType(null);
        $activityLog_447->setAffectedData(null);
        $activityLog_447->setDescription('User logged out');
        $activityLog_447->setCreatedAt(new \DateTimeImmutable('2026-05-22 01:32:58'));
        $manager->persist($activityLog_447);

        $manager->flush();
    }
}
