<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214133841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE politician ADD last_name VARCHAR(255) NOT NULL');
    }

    public function postUp(Schema $schema): void
    {
        parent::postUp($schema);

        $statement = $this->connection->prepare('SELECT * FROM politician');
        $statement->execute();
        $politicians = $statement->fetchAll();

        foreach ($politicians as $politician) {
            $nameFragments = explode(' ', $politician['name']);

            $politician['name'] = array_shift($nameFragments);
            $politician['last_name'] = implode(' ', $nameFragments);

            $this->connection->update('politician', $politician, ['id' => $politician['id']]);
        }
    }

    public function preDown(Schema $schema): void
    {
        parent::preDown($schema);

        $statement = $this->connection->prepare('SELECT * FROM politician');
        $statement->execute();
        $politicians = $statement->fetchAll();

        foreach ($politicians as $politician) {
            $politician['name'] = sprintf('%s %s', $politician['name'], $politician['last_name']);

            $this->connection->update('politician', $politician, ['id' => $politician['id']]);
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE politician DROP last_name');
    }
}
