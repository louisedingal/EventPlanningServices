<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260521180000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Seed Luxury & Glamour wedding theme with three style preview images for mobile booking';
    }

    public function up(Schema $schema): void
    {
        $paths = json_encode([
            'uploads/theme-samples/luxury-glamour-chandelier-reception.png',
            'uploads/theme-samples/luxury-glamour-magenta-ballroom.png',
            'uploads/theme-samples/luxury-glamour-sunset-ceremony.png',
        ], JSON_THROW_ON_ERROR);

        $pathsSql = str_replace("'", "''", $paths);
        $description = 'Opulent chandeliers, mirrored aisles, and dramatic floral staging for an unforgettable celebration.';
        $descriptionSql = str_replace("'", "''", $description);

        $this->addSql(
            "UPDATE theme SET sample_image_paths = '".$pathsSql."', description = COALESCE(NULLIF(description, ''), '".$descriptionSql."') WHERE name = 'Luxury & Glamour' AND event_type = 'Wedding'"
        );

        $this->addSql(
            "INSERT INTO theme (name, description, event_type, sample_image_paths) "
            ."SELECT 'Luxury & Glamour', '".$descriptionSql."', 'Wedding', '".$pathsSql."' "
            ."WHERE NOT EXISTS (SELECT 1 FROM theme WHERE name = 'Luxury & Glamour' AND event_type = 'Wedding')"
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            "UPDATE theme SET sample_image_paths = NULL WHERE name = 'Luxury & Glamour' AND event_type = 'Wedding'"
        );
    }
}
