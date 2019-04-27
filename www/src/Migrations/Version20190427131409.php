<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190427131409 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campaign (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, politician_type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campaign_region (campaign_id INT NOT NULL, region_id INT NOT NULL, INDEX IDX_D22188DBF639F774 (campaign_id), INDEX IDX_D22188DB98260155 (region_id), PRIMARY KEY(campaign_id, region_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_file (page_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_B5B2ACAC4663E4 (page_id), INDEX IDX_B5B2ACA93CB796C (file_id), PRIMARY KEY(page_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE politician_contact (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, number INT NOT NULL, zip INT NOT NULL, city VARCHAR(255) NOT NULL, phone INT NOT NULL, mobile INT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE politician (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, contact_id INT NOT NULL, party_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, type INT NOT NULL, since DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_B39BFB4998260155 (region_id), UNIQUE INDEX UNIQ_B39BFB49E7A1254A (contact_id), INDEX IDX_B39BFB49213C1059 (party_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE party (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_89954EE0F98F144A (logo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campaign_entry (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, campaign_id INT NOT NULL, prepared_argument_id INT DEFAULT NULL, argument LONGTEXT DEFAULT NULL, opt_in_information TINYINT(1) NOT NULL, INDEX IDX_6524F91F217BBB47 (person_id), INDEX IDX_6524F91FF639F774 (campaign_id), INDEX IDX_6524F91F4C93DDA1 (prepared_argument_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wip_count (id INT AUTO_INCREMENT NOT NULL, campaign_id INT NOT NULL, politician_id INT NOT NULL, status INT NOT NULL, voted INT DEFAULT NULL, INDEX IDX_EF24D854F639F774 (campaign_id), INDEX IDX_EF24D854899F0176 (politician_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE argument (id INT AUTO_INCREMENT NOT NULL, campaign_id INT NOT NULL, argument LONGTEXT NOT NULL, INDEX IDX_D113B0AF639F774 (campaign_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campaign_region ADD CONSTRAINT FK_D22188DBF639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE campaign_region ADD CONSTRAINT FK_D22188DB98260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_file ADD CONSTRAINT FK_B5B2ACAC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_file ADD CONSTRAINT FK_B5B2ACA93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE politician ADD CONSTRAINT FK_B39BFB4998260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE politician ADD CONSTRAINT FK_B39BFB49E7A1254A FOREIGN KEY (contact_id) REFERENCES politician_contact (id)');
        $this->addSql('ALTER TABLE politician ADD CONSTRAINT FK_B39BFB49213C1059 FOREIGN KEY (party_id) REFERENCES party (id)');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE0F98F144A FOREIGN KEY (logo_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE campaign_entry ADD CONSTRAINT FK_6524F91F217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE campaign_entry ADD CONSTRAINT FK_6524F91FF639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('ALTER TABLE campaign_entry ADD CONSTRAINT FK_6524F91F4C93DDA1 FOREIGN KEY (prepared_argument_id) REFERENCES argument (id)');
        $this->addSql('ALTER TABLE wip_count ADD CONSTRAINT FK_EF24D854F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('ALTER TABLE wip_count ADD CONSTRAINT FK_EF24D854899F0176 FOREIGN KEY (politician_id) REFERENCES politician (id)');
        $this->addSql('ALTER TABLE argument ADD CONSTRAINT FK_D113B0AF639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaign_region DROP FOREIGN KEY FK_D22188DB98260155');
        $this->addSql('ALTER TABLE politician DROP FOREIGN KEY FK_B39BFB4998260155');
        $this->addSql('ALTER TABLE campaign_region DROP FOREIGN KEY FK_D22188DBF639F774');
        $this->addSql('ALTER TABLE campaign_entry DROP FOREIGN KEY FK_6524F91FF639F774');
        $this->addSql('ALTER TABLE wip_count DROP FOREIGN KEY FK_EF24D854F639F774');
        $this->addSql('ALTER TABLE argument DROP FOREIGN KEY FK_D113B0AF639F774');
        $this->addSql('ALTER TABLE page_file DROP FOREIGN KEY FK_B5B2ACAC4663E4');
        $this->addSql('ALTER TABLE politician DROP FOREIGN KEY FK_B39BFB49E7A1254A');
        $this->addSql('ALTER TABLE wip_count DROP FOREIGN KEY FK_EF24D854899F0176');
        $this->addSql('ALTER TABLE politician DROP FOREIGN KEY FK_B39BFB49213C1059');
        $this->addSql('ALTER TABLE page_file DROP FOREIGN KEY FK_B5B2ACA93CB796C');
        $this->addSql('ALTER TABLE party DROP FOREIGN KEY FK_89954EE0F98F144A');
        $this->addSql('ALTER TABLE campaign_entry DROP FOREIGN KEY FK_6524F91F217BBB47');
        $this->addSql('ALTER TABLE campaign_entry DROP FOREIGN KEY FK_6524F91F4C93DDA1');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE campaign');
        $this->addSql('DROP TABLE campaign_region');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_file');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE politician_contact');
        $this->addSql('DROP TABLE politician');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE campaign_entry');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE wip_count');
        $this->addSql('DROP TABLE argument');
    }
}
