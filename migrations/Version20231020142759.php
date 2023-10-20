<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231020142759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, type_id INT DEFAULT NULL, number VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, created_at VARCHAR(255) NOT NULL, solde DOUBLE PRECISION NOT NULL, INDEX IDX_7D3656A47E3C61F9 (owner_id), INDEX IDX_7D3656A4C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B0234F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contribution (id INT AUTO_INCREMENT NOT NULL, contributor_id INT NOT NULL, amount INT NOT NULL, maked_at VARCHAR(255) NOT NULL, INDEX IDX_EA351E157A19A357 (contributor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, currency_id INT NOT NULL, name VARCHAR(255) NOT NULL, flag VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, INDEX IDX_5373C96638248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, base TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exchange (id INT AUTO_INCREMENT NOT NULL, basename VARCHAR(255) NOT NULL, currency_name VARCHAR(255) NOT NULL, base_value DOUBLE PRECISION NOT NULL, currency_value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fees (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE income (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, maked_at VARCHAR(255) NOT NULL, INDEX IDX_3FA862D0C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE investment (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, owner_id INT NOT NULL, number VARCHAR(255) NOT NULL, solde INT NOT NULL, blocked TINYINT(1) NOT NULL, maked_at VARCHAR(255) NOT NULL, available_at VARCHAR(255) NOT NULL, `return` INT NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_43CA0AD6C54C8C93 (type_id), INDEX IDX_43CA0AD67E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE investment_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, file_link VARCHAR(255) NOT NULL, maked_at VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `transaction` (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, type VARCHAR(255) NOT NULL, amount INT NOT NULL, fees DOUBLE PRECISION NOT NULL, maked_at VARCHAR(255) NOT NULL, INDEX IDX_723705D19B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, city_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, birthday VARCHAR(10) NOT NULL, address VARCHAR(255) NOT NULL, initial_code INT NOT NULL, registered_at VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649F92F3E70 (country_id), INDEX IDX_8D93D6498BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A47E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4C54C8C93 FOREIGN KEY (type_id) REFERENCES account_type (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E157A19A357 FOREIGN KEY (contributor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C96638248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D0C54C8C93 FOREIGN KEY (type_id) REFERENCES fees (id)');
        $this->addSql('ALTER TABLE investment ADD CONSTRAINT FK_43CA0AD6C54C8C93 FOREIGN KEY (type_id) REFERENCES investment_type (id)');
        $this->addSql('ALTER TABLE investment ADD CONSTRAINT FK_43CA0AD67E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `transaction` ADD CONSTRAINT FK_723705D19B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A47E3C61F9');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A4C54C8C93');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE contribution DROP FOREIGN KEY FK_EA351E157A19A357');
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C96638248176');
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_3FA862D0C54C8C93');
        $this->addSql('ALTER TABLE investment DROP FOREIGN KEY FK_43CA0AD6C54C8C93');
        $this->addSql('ALTER TABLE investment DROP FOREIGN KEY FK_43CA0AD67E3C61F9');
        $this->addSql('ALTER TABLE `transaction` DROP FOREIGN KEY FK_723705D19B6B5FBA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F92F3E70');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498BAC62AF');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE account_type');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE contribution');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE exchange');
        $this->addSql('DROP TABLE fees');
        $this->addSql('DROP TABLE income');
        $this->addSql('DROP TABLE investment');
        $this->addSql('DROP TABLE investment_type');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE `transaction`');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
