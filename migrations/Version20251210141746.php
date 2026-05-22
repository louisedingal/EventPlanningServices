<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251210141746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_request (id INT AUTO_INCREMENT NOT NULL, requested_by_id INT NOT NULL, event_type VARCHAR(255) NOT NULL, preferred_date DATE DEFAULT NULL, estimated_guest_count INT DEFAULT NULL, preferred_venue LONGTEXT DEFAULT NULL, theme LONGTEXT DEFAULT NULL, special_requests LONGTEXT DEFAULT NULL, budget LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, status VARCHAR(50) DEFAULT \'pending\' NOT NULL, admin_notes LONGTEXT DEFAULT NULL, INDEX IDX_BEC026304DA1E751 (requested_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_request ADD CONSTRAINT FK_BEC026304DA1E751 FOREIGN KEY (requested_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_request DROP FOREIGN KEY FK_BEC026304DA1E751');
        $this->addSql('DROP TABLE event_request');
    }
}
