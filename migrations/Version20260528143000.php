<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260528143000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add payment receipt fields to event requests';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_request ADD payment_amount NUMERIC(12, 2) DEFAULT NULL, ADD payment_approved_at DATETIME DEFAULT NULL, ADD receipt_number VARCHAR(40) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_request DROP payment_amount, DROP payment_approved_at, DROP receipt_number');
    }
}
