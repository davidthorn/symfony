<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210801155358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menus (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, parent INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE s_articles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE s_order (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, userID INT NOT NULL, ordernumber VARCHAR(255) DEFAULT NULL, ordertime DATETIME NOT NULL, INDEX IDX_8E3FCB6F5FD86D04 (userID), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE s_order_details (id INT AUTO_INCREMENT NOT NULL, orderID INT NOT NULL, articleID INT NOT NULL, taxID INT NOT NULL, tax_rate DOUBLE PRECISION NOT NULL, status INT NOT NULL, articleDetailID INT DEFAULT NULL, ordernumber VARCHAR(255) DEFAULT NULL, articleordernumber VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, name VARCHAR(255) NOT NULL, shipped INT NOT NULL, shippedgroup INT NOT NULL, modus INT NOT NULL, esdarticle INT NOT NULL, config LONGTEXT NOT NULL, ean VARCHAR(255) DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL, pack_unit VARCHAR(255) DEFAULT NULL, INDEX IDX_3A45281AC14D54FF (orderID), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE s_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(70) NOT NULL, salutation LONGTEXT NOT NULL, title LONGTEXT NOT NULL, firstname LONGTEXT NOT NULL, lastname LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE s_order ADD CONSTRAINT FK_8E3FCB6F5FD86D04 FOREIGN KEY (userID) REFERENCES s_user (id)');
        $this->addSql('ALTER TABLE s_order_details ADD CONSTRAINT FK_3A45281AC14D54FF FOREIGN KEY (orderID) REFERENCES s_order (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE s_order_details DROP FOREIGN KEY FK_3A45281AC14D54FF');
        $this->addSql('ALTER TABLE s_order DROP FOREIGN KEY FK_8E3FCB6F5FD86D04');
        $this->addSql('DROP TABLE menus');
        $this->addSql('DROP TABLE s_articles');
        $this->addSql('DROP TABLE s_order');
        $this->addSql('DROP TABLE s_order_details');
        $this->addSql('DROP TABLE s_user');
        $this->addSql('DROP TABLE user');
    }
}
