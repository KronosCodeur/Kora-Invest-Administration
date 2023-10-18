<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018182213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__investment AS SELECT id, type_id, number, solde, blocked, maked_at, available_at, return, status FROM investment');
        $this->addSql('DROP TABLE investment');
        $this->addSql('CREATE TABLE investment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_id INTEGER NOT NULL, owner_id INTEGER NOT NULL, number VARCHAR(255) NOT NULL, solde INTEGER NOT NULL, blocked BOOLEAN NOT NULL, maked_at VARCHAR(255) NOT NULL, available_at VARCHAR(255) NOT NULL, return INTEGER NOT NULL, status BOOLEAN NOT NULL, CONSTRAINT FK_43CA0AD6C54C8C93 FOREIGN KEY (type_id) REFERENCES investment_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_43CA0AD67E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO investment (id, type_id, number, solde, blocked, maked_at, available_at, return, status) SELECT id, type_id, number, solde, blocked, maked_at, available_at, return, status FROM __temp__investment');
        $this->addSql('DROP TABLE __temp__investment');
        $this->addSql('CREATE INDEX IDX_43CA0AD6C54C8C93 ON investment (type_id)');
        $this->addSql('CREATE INDEX IDX_43CA0AD67E3C61F9 ON investment (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__investment AS SELECT id, type_id, number, solde, blocked, maked_at, available_at, return, status FROM investment');
        $this->addSql('DROP TABLE investment');
        $this->addSql('CREATE TABLE investment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_id INTEGER NOT NULL, number VARCHAR(255) NOT NULL, solde INTEGER NOT NULL, blocked BOOLEAN NOT NULL, maked_at VARCHAR(255) NOT NULL, available_at VARCHAR(255) NOT NULL, return INTEGER NOT NULL, status BOOLEAN NOT NULL, CONSTRAINT FK_43CA0AD6C54C8C93 FOREIGN KEY (type_id) REFERENCES investment_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO investment (id, type_id, number, solde, blocked, maked_at, available_at, return, status) SELECT id, type_id, number, solde, blocked, maked_at, available_at, return, status FROM __temp__investment');
        $this->addSql('DROP TABLE __temp__investment');
        $this->addSql('CREATE INDEX IDX_43CA0AD6C54C8C93 ON investment (type_id)');
    }
}
