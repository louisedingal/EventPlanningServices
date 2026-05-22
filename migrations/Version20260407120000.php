<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260407120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Allow event_request.requested_by_id to be NULL when the requesting user is deleted';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_request CHANGE requested_by_id requested_by_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_request CHANGE requested_by_id requested_by_id INT NOT NULL');
    }
}
