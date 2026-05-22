<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251208084149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Add name column (nullable)
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) DEFAULT NULL');
        
        // Add status column with default value
        $this->addSql('ALTER TABLE user ADD status VARCHAR(20) DEFAULT \'active\' NOT NULL');
        
        // Add created_at column as nullable first
        $this->addSql('ALTER TABLE user ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        
        // Set default created_at for existing users
        $this->addSql('UPDATE user SET created_at = NOW() WHERE created_at IS NULL');
        
        // Now make created_at NOT NULL
        $this->addSql('ALTER TABLE user MODIFY created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP name, DROP status, DROP created_at');
    }
}
