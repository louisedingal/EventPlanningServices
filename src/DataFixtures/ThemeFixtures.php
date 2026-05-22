<?php

namespace App\DataFixtures;

use App\Entity\Theme;
use App\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture data exported from local `theme` table on 2026-05-22 04:30:37.
 * Regenerate: php scripts/generate-fixtures-from-db.php
 */
class ThemeFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $theme_6 = new Theme();
        $theme_6->setName('DESTINATION & ESCAPE');
        $theme_6->setDescription('For couples who dream of turning their “I do” into an unforgettable getaway. These weddings blend breathtaking scenery with luxurious relaxation from sun-soaked beaches and vineyard sunsets to serene island hideaways. Perfect for those who want their celebration to feel like an exclusive vacation filled with romance, adventure, and timeless beauty.');
        $theme_6->setEventType('Birthday');
        $theme_6->setSampleImagePaths(null);
        $manager->persist($theme_6);
        $this->addReference('theme_6', $theme_6);

        $theme_7 = new Theme();
        $theme_7->setName('TRENDY & SOCIAL-MEDIA READY');
        $theme_7->setDescription('Designed for the modern celebrant who loves to make a statement, these birthday themes are bold, stylish, and made to go viral. Every element from décor to lighting and photo zones is curated for aesthetic perfection and share-worthy moments that stand out on every feed. Perfect for trendsetters who want their celebration to be as unforgettable as their posts.');
        $theme_7->setEventType('Birthday');
        $theme_7->setSampleImagePaths(null);
        $manager->persist($theme_7);
        $this->addReference('theme_7', $theme_7);

        $theme_8 = new Theme();
        $theme_8->setName('LUXURY & GLAMOUR');
        $theme_8->setDescription('Step into a world of sophistication and opulence where every detail shines. This collection features elegant, high-end birthday experiences designed for those who appreciate fine taste from champagne towers and crystal chandeliers to red carpet entrances and designer décor. Perfect for guests who want to celebrate in style and make a lasting impression.');
        $theme_8->setEventType('Wedding');
        $theme_8->setSampleImagePaths(['uploads/theme-samples/luxury-glamour-chandelier-reception.png', 'uploads/theme-samples/luxury-glamour-magenta-ballroom.png', 'uploads/theme-samples/luxury-glamour-sunset-ceremony.png']);
        $manager->persist($theme_8);
        $this->addReference('theme_8', $theme_8);

        $theme_9 = new Theme();
        $theme_9->setName('DESTINATION & ESCAPE');
        $theme_9->setDescription('A birthday celebration that feels like a luxurious getaway. These themes transport guests to breathtaking locations from tropical beaches and Mediterranean coasts to exotic desert retreats. Perfect for celebrants who want a relaxed, scenic, and unforgettable celebration inspired by travel, adventure, and beautiful destinations.');
        $theme_9->setEventType('Wedding');
        $theme_9->setSampleImagePaths(null);
        $manager->persist($theme_9);
        $this->addReference('theme_9', $theme_9);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
