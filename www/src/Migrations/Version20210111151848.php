<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210111151848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE person_argument (id INT AUTO_INCREMENT NOT NULL, campaign_id INT NOT NULL, person_id INT NOT NULL, argument LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_99579E3DF639F774 (campaign_id), INDEX IDX_99579E3D217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE person_argument ADD CONSTRAINT FK_99579E3DF639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('ALTER TABLE person_argument ADD CONSTRAINT FK_99579E3D217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE campaign_entry ADD person_argument_id INT DEFAULT NULL, CHANGE argument_id argument_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE campaign_entry ADD CONSTRAINT FK_6524F91F503FD0A9 FOREIGN KEY (person_argument_id) REFERENCES person_argument (id)');
        $this->addSql('CREATE INDEX IDX_6524F91F503FD0A9 ON campaign_entry (person_argument_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaign_entry DROP FOREIGN KEY FK_6524F91F503FD0A9');
        $this->addSql('DROP TABLE person_argument');
        $this->addSql('DROP INDEX IDX_6524F91F503FD0A9 ON campaign_entry');
        $this->addSql('ALTER TABLE campaign_entry DROP person_argument_id, CHANGE argument_id argument_id INT NOT NULL');
    }
}
