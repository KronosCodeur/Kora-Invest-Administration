<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018184116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__contribution AS SELECT id, contributor_id, amount, maked_at FROM contribution');
        $this->addSql('DROP TABLE contribution');
        $this->addSql('CREATE TABLE contribution (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contributor_id INTEGER NOT NULL, amount INTEGER NOT NULL, maked_at VARCHAR(255) NOT NULL, CONSTRAINT FK_EA351E157A19A357 FOREIGN KEY (contributor_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO contribution (id, contributor_id, amount, maked_at) SELECT id, contributor_id, amount, maked_at FROM __temp__contribution');
        $this->addSql('DROP TABLE __temp__contribution');
        $this->addSql('CREATE INDEX IDX_EA351E157A19A357 ON contribution (contributor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__contribution AS SELECT id, contributor_id, amount, maked_at FROM contribution');
        $this->addSql('DROP TABLE contribution');
        $this->addSql('CREATE TABLE contribution (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contributor_id INTEGER NOT NULL, amount INTEGER NOT NULL, maked_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_EA351E157A19A357 FOREIGN KEY (contributor_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO contribution (id, contributor_id, amount, maked_at) SELECT id, contributor_id, amount, maked_at FROM __temp__contribution');
        $this->addSql('DROP TABLE __temp__contribution');
        $this->addSql('CREATE INDEX IDX_EA351E157A19A357 ON contribution (contributor_id)');
    }
}
