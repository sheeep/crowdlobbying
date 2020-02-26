<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200226160345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaign ADD campaign_title VARCHAR(255) NOT NULL, ADD campaign_description LONGTEXT NOT NULL, ADD og_campaign_description LONGTEXT NOT NULL, ADD og_image_de VARCHAR(255) NOT NULL, ADD og_image_fr VARCHAR(255) NOT NULL, ADD hero VARCHAR(255) NOT NULL, ADD campaign_info_lead LONGTEXT NOT NULL, ADD campaign_info LONGTEXT NOT NULL, ADD donor_box LONGTEXT NOT NULL, ADD share_text_box LONGTEXT NOT NULL, ADD faq_title VARCHAR(255) NOT NULL, ADD faq_text LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaign DROP campaign_title, DROP campaign_description, DROP og_campaign_description, DROP og_image_de, DROP og_image_fr, DROP hero, DROP campaign_info_lead, DROP campaign_info, DROP donor_box, DROP share_text_box, DROP faq_title, DROP faq_text');
    }
}
