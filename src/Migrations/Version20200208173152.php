<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200208173152 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("INSERT INTO homesuite.freezer_item_category (id, name, default_validity) VALUES(1, 'bread', 30);");
        $this->addSql("INSERT INTO homesuite.freezer_item_category (id, name, default_validity) VALUES(2, 'cooked meal', 100);");
        $this->addSql("INSERT INTO homesuite.freezer_item_category (id, name, default_validity) VALUES(3, 'fruit / veg.', 365);");
        $this->addSql("INSERT INTO homesuite.freezer_item_category (id, name, default_validity) VALUES(4, 'meat (chicken)', 180);");
        $this->addSql("INSERT INTO homesuite.freezer_item_category (id, name, default_validity) VALUES(5, 'meat (pork,lamb,veal)', 200);");
        $this->addSql("INSERT INTO homesuite.freezer_item_category (id, name, default_validity) VALUES(6, 'meat (beef,poultry)', 240);");
        $this->addSql("INSERT INTO homesuite.freezer_item_category (id, name, default_validity) VALUES(7, 'ground meat', 75);");
        $this->addSql("INSERT INTO homesuite.freezer_item_category (id, name, default_validity) VALUES(8, 'fish, crustacean', 90);");
        $this->addSql("INSERT INTO homesuite.freezer_item_category (id, name, default_validity) VALUES(9, 'pastry', 60);");
        $this->addSql("INSERT INTO homesuite.freezer_item_category (id, name, default_validity) VALUES(10, 'cake', 90);");
        $this->addSql("INSERT INTO homesuite.freezer_item_category (id, name, default_validity) VALUES(11, 'cheese, butter', 90);");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM homesuite.freezer_item_category where id BETWEEN 1 and 11;');
    }
}
