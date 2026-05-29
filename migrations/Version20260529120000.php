<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260529120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create payment table and migrate existing event request payment records';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE payment (
            id INT AUTO_INCREMENT NOT NULL,
            user_id INT NOT NULL,
            event_request_id INT NOT NULL,
            amount NUMERIC(12, 2) NOT NULL,
            currency VARCHAR(3) DEFAULT \'PHP\' NOT NULL,
            receipt_number VARCHAR(40) NOT NULL,
            source VARCHAR(32) DEFAULT \'mobile_app\' NOT NULL,
            status VARCHAR(20) DEFAULT \'approved\' NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            INDEX idx_payment_user (user_id),
            INDEX idx_payment_created_at (created_at),
            UNIQUE INDEX UNIQ_PAYMENT_RECEIPT (receipt_number),
            UNIQUE INDEX UNIQ_PAYMENT_EVENT_REQUEST (event_request_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D4FCCCDBF FOREIGN KEY (event_request_id) REFERENCES event_request (id) ON DELETE CASCADE');

        $this->addSql(<<<'SQL'
            INSERT INTO payment (user_id, event_request_id, amount, currency, receipt_number, source, status, created_at)
            SELECT
                er.requested_by_id,
                er.id,
                er.payment_amount,
                'PHP',
                COALESCE(er.receipt_number, CONCAT('REC-MIG-', er.id)),
                COALESCE(er.source, 'mobile_app'),
                'approved',
                er.payment_approved_at
            FROM event_request er
            WHERE er.payment_approved_at IS NOT NULL
              AND er.payment_amount IS NOT NULL
              AND er.requested_by_id IS NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA76ED395');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D4FCCCDBF');
        $this->addSql('DROP TABLE payment');
    }
}
