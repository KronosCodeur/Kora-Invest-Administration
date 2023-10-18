<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018183851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__exchange AS SELECT id, basename, currency_name, value FROM exchange');
        $this->addSql('DROP TABLE exchange');
        $this->addSql('CREATE TABLE exchange (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, basename VARCHAR(255) NOT NULL, currency_name VARCHAR(255) NOT NULL, base_value DOUBLE PRECISION NOT NULL, currency_value DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO exchange (id, basename, currency_name, base_value) SELECT id, basename, currency_name, value FROM __temp__exchange');
        $this->addSql('DROP TABLE __temp__exchange');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__exchange AS SELECT id, basename, currency_name FROM exchange');
        $this->addSql('DROP TABLE exchange');
        $this->addSql('CREATE TABLE exchange (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, basename VARCHAR(255) NOT NULL, currency_name VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO exchange (id, basename, currency_name) SELECT id, basename, currency_name FROM __temp__exchange');
        $this->addSql('DROP TABLE __temp__exchange');
    }
}
