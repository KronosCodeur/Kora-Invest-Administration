<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231014201131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contribution (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contributor_id INTEGER NOT NULL, amount INTEGER NOT NULL, maked_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_EA351E157A19A357 FOREIGN KEY (contributor_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EA351E157A19A357 ON contribution (contributor_id)');
        $this->addSql('CREATE TABLE investment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, number VARCHAR(255) NOT NULL, solde INTEGER NOT NULL, blocked BOOLEAN NOT NULL, type VARCHAR(255) NOT NULL, maked_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , return INTEGER NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contribution');
        $this->addSql('DROP TABLE investment');
    }
}
