<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190907184838 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE freezer_item CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE freezer_item_category CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE freezer CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('DROP INDEX uq_meal_date_type ON meal');
        $this->addSql('ALTER TABLE meal CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE house CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE menu ADD date_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE freezer CHANGE date_creation date_creation DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
        $this->addSql('ALTER TABLE freezer_item CHANGE date_creation date_creation DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
        $this->addSql('ALTER TABLE freezer_item_category CHANGE date_creation date_creation DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
        $this->addSql('ALTER TABLE house CHANGE date_creation date_creation DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
        $this->addSql('ALTER TABLE meal CHANGE date_creation date_creation DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uq_meal_date_type ON meal (date, type)');
        $this->addSql('ALTER TABLE menu DROP date_update, CHANGE date_creation date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE date_creation date_creation DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
    }
}
