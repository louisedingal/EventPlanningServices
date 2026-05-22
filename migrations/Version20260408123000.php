<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260408123000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Set event_request.requested_by_id foreign key to ON DELETE SET NULL';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable('event_request')) {
            return;
        }

        $this->addSql('ALTER TABLE event_request CHANGE requested_by_id requested_by_id INT DEFAULT NULL');

        $fkName = $this->connection->fetchOne(
            "SELECT CONSTRAINT_NAME
             FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = 'event_request'
               AND COLUMN_NAME = 'requested_by_id'
               AND REFERENCED_TABLE_NAME IS NOT NULL
             LIMIT 1"
        );

        if (is_string($fkName) && $fkName !== '') {
            $this->addSql(sprintf(
                'ALTER TABLE event_request DROP FOREIGN KEY `%s`',
                str_replace('`', '``', $fkName)
            ));
        }

        $this->addSql(
            'ALTER TABLE event_request ADD CONSTRAINT FK_EVENT_REQUEST_REQUESTED_BY FOREIGN KEY (requested_by_id) REFERENCES user (id) ON DELETE SET NULL'
        );
    }

    public function down(Schema $schema): void
    {
        if (!$schema->hasTable('event_request')) {
            return;
        }

        $this->addSql('ALTER TABLE event_request DROP FOREIGN KEY FK_EVENT_REQUEST_REQUESTED_BY');
        $this->addSql(
            'ALTER TABLE event_request ADD CONSTRAINT FK_BEC026304DA1E751 FOREIGN KEY (requested_by_id) REFERENCES user (id)'
        );
        $this->addSql('ALTER TABLE event_request CHANGE requested_by_id requested_by_id INT NOT NULL');
    }
}
