<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190907174423 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE freezer_item ADD creator_id INT NOT NULL, CHANGE freezer_id freezer_id INT DEFAULT NULL, CHANGE unit unit VARCHAR(11) NOT NULL');
        $this->addSql('ALTER TABLE freezer_item ADD CONSTRAINT FK_1D260FA261220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1D260FA261220EA6 ON freezer_item (creator_id)');
        $this->addSql('ALTER TABLE meal ADD creator_id INT NOT NULL');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C61220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9EF68E9C61220EA6 ON meal (creator_id)');
        $this->addSql('CREATE UNIQUE INDEX uq_meal_date_type ON meal (`date`, `type`)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE freezer_item DROP FOREIGN KEY FK_1D260FA261220EA6');
        $this->addSql('DROP INDEX IDX_1D260FA261220EA6 ON freezer_item');
        $this->addSql('ALTER TABLE freezer_item DROP creator_id, CHANGE freezer_id freezer_id INT NOT NULL, CHANGE unit unit VARCHAR(2) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C61220EA6');
        $this->addSql('DROP INDEX IDX_9EF68E9C61220EA6 ON meal');
        $this->addSql('DROP INDEX uq_meal_date_type ON meal');
        $this->addSql('ALTER TABLE meal DROP creator_id');
    }
}
