<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260521140000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Link event requests to service packages and store preferred time';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_request ADD service_package_id INT DEFAULT NULL, ADD preferred_time VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE event_request ADD CONSTRAINT FK_EVENT_REQUEST_SERVICE_PACKAGE FOREIGN KEY (service_package_id) REFERENCES service_package (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_EVENT_REQUEST_SERVICE_PACKAGE ON event_request (service_package_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_request DROP FOREIGN KEY FK_EVENT_REQUEST_SERVICE_PACKAGE');
        $this->addSql('DROP INDEX IDX_EVENT_REQUEST_SERVICE_PACKAGE ON event_request');
        $this->addSql('ALTER TABLE event_request DROP service_package_id, DROP preferred_time');
    }
}
