<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231016210635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, roles, password, first_name, last_name, phone, gender, picture, active, birthday, address, initial_code, registered_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, birthday VARCHAR(10) NOT NULL, address VARCHAR(255) NOT NULL, initial_code INTEGER NOT NULL, registered_at VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, username, roles, password, first_name, last_name, phone, gender, picture, active, birthday, address, initial_code, registered_at) SELECT id, username, roles, password, first_name, last_name, phone, gender, picture, active, birthday, address, initial_code, registered_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, roles, password, first_name, last_name, phone, gender, picture, active, birthday, address, initial_code, registered_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, birthday VARCHAR(10) NOT NULL, address VARCHAR(255) NOT NULL, initial_code INTEGER NOT NULL, registered_at VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, username, roles, password, first_name, last_name, phone, gender, picture, active, birthday, address, initial_code, registered_at) SELECT id, username, roles, password, first_name, last_name, phone, gender, picture, active, birthday, address, initial_code, registered_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }
}
