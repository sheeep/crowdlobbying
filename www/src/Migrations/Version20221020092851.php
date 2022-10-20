<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221020092851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_campaign (user_id INT NOT NULL, campaign_id INT NOT NULL, INDEX IDX_FF98F6DDA76ED395 (user_id), INDEX IDX_FF98F6DDF639F774 (campaign_id), PRIMARY KEY(user_id, campaign_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_campaign ADD CONSTRAINT FK_FF98F6DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_campaign ADD CONSTRAINT FK_FF98F6DDF639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE campaign CHANGE campaign_title campaign_title VARCHAR(255) DEFAULT NULL, CHANGE hero hero VARCHAR(255) DEFAULT NULL, CHANGE faq_title faq_title VARCHAR(255) DEFAULT NULL, CHANGE how_it_works_step1 how_it_works_step1 VARCHAR(255) DEFAULT NULL, CHANGE how_it_works_step2 how_it_works_step2 VARCHAR(255) DEFAULT NULL, CHANGE how_it_works_step3 how_it_works_step3 VARCHAR(255) DEFAULT NULL, CHANGE how_it_works_finish how_it_works_finish VARCHAR(255) DEFAULT NULL, CHANGE total total VARCHAR(255) DEFAULT NULL, CHANGE hero_subline hero_subline VARCHAR(255) DEFAULT NULL, CHANGE campaign_subject campaign_subject VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE campaign_entry CHANGE argument_id argument_id INT DEFAULT NULL, CHANGE person_argument_id person_argument_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commission CHANGE politician_type_id politician_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party CHANGE logo_id logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person CHANGE language language VARCHAR(2) DEFAULT NULL, CHANGE confirmation_token confirmation_token VARCHAR(255) DEFAULT NULL, CHANGE confirmation_expires confirmation_expires DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE politician CHANGE region_id region_id INT DEFAULT NULL, CHANGE twitter twitter VARCHAR(255) DEFAULT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE politician_contact CHANGE salutation salutation VARCHAR(255) DEFAULT NULL, CHANGE post_salutation post_salutation VARCHAR(255) DEFAULT NULL, CHANGE company company VARCHAR(255) DEFAULT NULL, CHANGE address1 address1 VARCHAR(255) DEFAULT NULL, CHANGE address2 address2 VARCHAR(255) DEFAULT NULL, CHANGE zip zip INT DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE fax fax VARCHAR(255) DEFAULT NULL, CHANGE website website VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE wip_count CHANGE voted voted INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_campaign');
        $this->addSql('ALTER TABLE campaign CHANGE campaign_subject campaign_subject VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE campaign_title campaign_title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE hero hero VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE total total VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE how_it_works_step1 how_it_works_step1 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE how_it_works_step2 how_it_works_step2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE how_it_works_step3 how_it_works_step3 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE how_it_works_finish how_it_works_finish VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE faq_title faq_title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE hero_subline hero_subline VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE campaign_entry CHANGE argument_id argument_id INT DEFAULT NULL, CHANGE person_argument_id person_argument_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commission CHANGE politician_type_id politician_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party CHANGE logo_id logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person CHANGE language language VARCHAR(2) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE confirmation_token confirmation_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE confirmation_expires confirmation_expires DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE politician CHANGE region_id region_id INT DEFAULT NULL, CHANGE twitter twitter VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE deleted_at deleted_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE politician_contact CHANGE salutation salutation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE post_salutation post_salutation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE company company VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE address1 address1 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE address2 address2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE zip zip INT DEFAULT NULL, CHANGE city city VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE mobile mobile VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE fax fax VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE website website VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE wip_count CHANGE voted voted INT DEFAULT NULL');
    }
}
