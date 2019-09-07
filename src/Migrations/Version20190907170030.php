<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190907170030 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE freezer_item (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, freezer_id INT NOT NULL, description VARCHAR(255) NOT NULL, quantity INT NOT NULL, unit VARCHAR(2) NOT NULL, date_expiry DATETIME NOT NULL, date_removal DATETIME DEFAULT NULL, date_creation DATETIME NOT NULL, date_update DATETIME NOT NULL, INDEX IDX_1D260FA212469DE2 (category_id), INDEX IDX_1D260FA23FE9820 (freezer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE freezer_item_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, default_validity INT NOT NULL, date_creation DATETIME NOT NULL, date_update DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, date_creation DATETIME NOT NULL, date_update DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE freezer (id INT AUTO_INCREMENT NOT NULL, house_id INT NOT NULL, name VARCHAR(100) NOT NULL, date_creation DATETIME NOT NULL, date_update DATETIME NOT NULL, INDEX IDX_912D97136BB74515 (house_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, menu_id INT NOT NULL, date DATETIME NOT NULL, type VARCHAR(15) NOT NULL, description VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, date_update DATETIME NOT NULL, INDEX IDX_9EF68E9CCCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE house (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, date_creation DATETIME NOT NULL, date_update DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, house_id INT NOT NULL, date_creation DATETIME NOT NULL, UNIQUE INDEX UNIQ_7D053A936BB74515 (house_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE freezer_item ADD CONSTRAINT FK_1D260FA212469DE2 FOREIGN KEY (category_id) REFERENCES freezer_item_category (id)');
        $this->addSql('ALTER TABLE freezer_item ADD CONSTRAINT FK_1D260FA23FE9820 FOREIGN KEY (freezer_id) REFERENCES freezer (id)');
        $this->addSql('ALTER TABLE freezer ADD CONSTRAINT FK_912D97136BB74515 FOREIGN KEY (house_id) REFERENCES house (id)');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9CCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A936BB74515 FOREIGN KEY (house_id) REFERENCES house (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE freezer_item DROP FOREIGN KEY FK_1D260FA212469DE2');
        $this->addSql('ALTER TABLE freezer_item DROP FOREIGN KEY FK_1D260FA23FE9820');
        $this->addSql('ALTER TABLE freezer DROP FOREIGN KEY FK_912D97136BB74515');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A936BB74515');
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9CCCD7E912');
        $this->addSql('DROP TABLE freezer_item');
        $this->addSql('DROP TABLE freezer_item_category');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE freezer');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE house');
        $this->addSql('DROP TABLE menu');
    }
}
