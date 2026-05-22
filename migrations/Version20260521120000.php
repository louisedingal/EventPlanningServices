<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260521120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add source column to event_request (mobile_app vs web)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE event_request ADD source VARCHAR(32) DEFAULT 'web' NOT NULL");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_request DROP source');
    }
}
