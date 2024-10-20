<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241020174959 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, house_id INT NOT NULL, details LONGTEXT DEFAULT NULL, title VARCHAR(255) NOT NULL, url LONGTEXT DEFAULT NULL, comments LONGTEXT DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DA88B137C54C8C93 (type_id), INDEX IDX_DA88B1376BB74515 (house_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_recipe_tag (recipe_id INT NOT NULL, recipe_tag_id INT NOT NULL, INDEX IDX_3BA055AC59D8A214 (recipe_id), INDEX IDX_3BA055AC37CC7D30 (recipe_tag_id), PRIMARY KEY(recipe_id, recipe_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_name VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_F3C50DF65E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_72DED3CF5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137C54C8C93 FOREIGN KEY (type_id) REFERENCES recipe_type (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1376BB74515 FOREIGN KEY (house_id) REFERENCES house (id)');
        $this->addSql('ALTER TABLE recipe_recipe_tag ADD CONSTRAINT FK_3BA055AC59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_recipe_tag ADD CONSTRAINT FK_3BA055AC37CC7D30 FOREIGN KEY (recipe_tag_id) REFERENCES recipe_tag (id) ON DELETE CASCADE');
        $this->addSql('INSERT INTO recipe_type (id, name, image_name) 
VALUES (1, "starter", "gyoza.png"), 
       (2, "main", "spaghetti.png"), 
       (3, "dessert", "cake.png"), 
       (4, "salad", "salad.png"), 
       (5, "appetizers", "canape.png"), 
       (6, "soup", "soup.png");'
        );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recipe_recipe_tag DROP FOREIGN KEY FK_3BA055AC59D8A214');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137C54C8C93');
        $this->addSql('ALTER TABLE recipe_recipe_tag DROP FOREIGN KEY FK_3BA055AC37CC7D30');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_recipe_tag');
        $this->addSql('DROP TABLE recipe_type');
        $this->addSql('DROP TABLE recipe_tag');
    }
}
