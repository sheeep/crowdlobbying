<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914065708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaigns_colors DROP FOREIGN KEY FK_3DEECF297ADA1FB5');
        $this->addSql('ALTER TABLE campaigns_colors DROP FOREIGN KEY FK_3DEECF29F639F774');
        $this->addSql('ALTER TABLE campaigns_colors ADD CONSTRAINT FK_3DEECF297ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE campaigns_colors ADD CONSTRAINT FK_3DEECF29F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaigns_colors DROP FOREIGN KEY FK_3DEECF29F639F774');
        $this->addSql('ALTER TABLE campaigns_colors DROP FOREIGN KEY FK_3DEECF297ADA1FB5');
        $this->addSql('ALTER TABLE campaigns_colors ADD CONSTRAINT FK_3DEECF29F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('ALTER TABLE campaigns_colors ADD CONSTRAINT FK_3DEECF297ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
    }
}
