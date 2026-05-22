<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Legacy accounts created before email verification: no pending token means verification was never required.
 * Mark them verified so Web and API both use the same is_verified flag.
 */
final class Version20260408120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Mark legacy users (no verification_token) as email-verified for unified Web/API checks';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('UPDATE user SET is_verified = 1 WHERE verification_token IS NULL AND is_verified = 0');
    }

    public function down(Schema $schema): void
    {
        // Data migration; reversing would incorrectly un-verify accounts.
    }
}
