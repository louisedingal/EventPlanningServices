<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251014072923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_package (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE venue (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, capacity INT DEFAULT NULL, contact_info VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD venue_ref_id INT DEFAULT NULL, ADD package_id INT DEFAULT NULL, CHANGE event_date event_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA739D8BDD3 FOREIGN KEY (venue_ref_id) REFERENCES venue (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7F44CABFF FOREIGN KEY (package_id) REFERENCES service_package (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA739D8BDD3 ON event (venue_ref_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7F44CABFF ON event (package_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7F44CABFF');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA739D8BDD3');
        $this->addSql('DROP TABLE service_package');
        $this->addSql('DROP TABLE venue');
        $this->addSql('DROP INDEX IDX_3BAE0AA739D8BDD3 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA7F44CABFF ON event');
        $this->addSql('ALTER TABLE event DROP venue_ref_id, DROP package_id, CHANGE event_date event_date DATETIME NOT NULL');
    }
}
