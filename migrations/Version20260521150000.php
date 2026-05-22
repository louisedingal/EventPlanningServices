<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260521150000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add sample_image_paths JSON column to theme for customer style previews';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE theme ADD sample_image_paths JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE theme DROP sample_image_paths');
    }
}
