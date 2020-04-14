<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414102748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaign_entry ADD confirmed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE person ADD confirmed TINYINT(1) NOT NULL, ADD confirmation_token VARCHAR(255) DEFAULT NULL, ADD confirmation_expires DATETIME DEFAULT NULL');
        $this->addSql('UPDATE campaign_entry SET confirmed = 1');
        $this->addSql('UPDATE person SET confirmed = 1');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaign_entry DROP confirmed');
        $this->addSql('ALTER TABLE person DROP confirmed, DROP confirmation_token, DROP confirmation_expires');
    }
}
