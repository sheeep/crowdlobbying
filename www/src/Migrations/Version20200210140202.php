<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200210140202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE campaigns_commissions (campaign_id INT NOT NULL, commission_id INT NOT NULL, INDEX IDX_546BE202F639F774 (campaign_id), UNIQUE INDEX UNIQ_546BE202202D1EB2 (commission_id), PRIMARY KEY(campaign_id, commission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commission (id INT AUTO_INCREMENT NOT NULL, politician_type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1C650158C1694E4F (politician_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commissions_politicians (commission_id INT NOT NULL, politician_id INT NOT NULL, INDEX IDX_EDA27CF2202D1EB2 (commission_id), INDEX IDX_EDA27CF2899F0176 (politician_id), PRIMARY KEY(commission_id, politician_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campaigns_commissions ADD CONSTRAINT FK_546BE202F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('ALTER TABLE campaigns_commissions ADD CONSTRAINT FK_546BE202202D1EB2 FOREIGN KEY (commission_id) REFERENCES commission (id)');
        $this->addSql('ALTER TABLE commission ADD CONSTRAINT FK_1C650158C1694E4F FOREIGN KEY (politician_type_id) REFERENCES politician_type (id)');
        $this->addSql('ALTER TABLE commissions_politicians ADD CONSTRAINT FK_EDA27CF2202D1EB2 FOREIGN KEY (commission_id) REFERENCES commission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commissions_politicians ADD CONSTRAINT FK_EDA27CF2899F0176 FOREIGN KEY (politician_id) REFERENCES politician (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE politician ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ext_translations CHANGE object_class object_class VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaigns_commissions DROP FOREIGN KEY FK_546BE202202D1EB2');
        $this->addSql('ALTER TABLE commissions_politicians DROP FOREIGN KEY FK_EDA27CF2202D1EB2');
        $this->addSql('DROP TABLE campaigns_commissions');
        $this->addSql('DROP TABLE commission');
        $this->addSql('DROP TABLE commissions_politicians');
        $this->addSql('ALTER TABLE ext_translations CHANGE object_class object_class VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE politician DROP image');
    }
}
