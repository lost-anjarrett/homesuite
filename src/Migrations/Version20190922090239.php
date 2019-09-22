<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190922090239 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, date DATETIME NOT NULL, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, date_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_E5A02990CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A02990CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9CCCD7E912');
        $this->addSql('DROP INDEX IDX_9EF68E9CCCD7E912 ON meal');
        $this->addSql('ALTER TABLE meal ADD day_id INT DEFAULT NULL, DROP menu_id, DROP date, CHANGE type type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C9C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('CREATE INDEX IDX_9EF68E9C9C24126 ON meal (day_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C9C24126');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP INDEX IDX_9EF68E9C9C24126 ON meal');
        $this->addSql('ALTER TABLE meal ADD menu_id INT NOT NULL, ADD date DATETIME NOT NULL, DROP day_id, CHANGE type type VARCHAR(15) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9CCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_9EF68E9CCCD7E912 ON meal (menu_id)');
    }
}
