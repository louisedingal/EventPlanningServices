<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260521200000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Store customer preferred theme style look (label + image) on event requests';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_request ADD preferred_style_label VARCHAR(120) DEFAULT NULL, ADD preferred_style_image_path VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_request DROP preferred_style_label, DROP preferred_style_image_path');
    }
}
