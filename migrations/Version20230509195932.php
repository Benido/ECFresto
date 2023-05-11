<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509195932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allergen (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_allergen (client_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', allergen_id INT NOT NULL, INDEX IDX_B59380B19EB6921 (client_id), INDEX IDX_B59380B6E775A4A (allergen_id), PRIMARY KEY(client_id, allergen_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dish (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_957D8CB812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dish_allergen (dish_id INT NOT NULL, allergen_id INT NOT NULL, INDEX IDX_3C4389A5148EB0CB (dish_id), INDEX IDX_3C4389A56E775A4A (allergen_id), PRIMARY KEY(dish_id, allergen_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dish_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formula (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, temporality VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_formula (menu_id INT NOT NULL, formula_id INT NOT NULL, INDEX IDX_EFEA453FCCD7E912 (menu_id), INDEX IDX_EFEA453FA50A6386 (formula_id), PRIMARY KEY(menu_id, formula_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_dish (menu_id INT NOT NULL, dish_id INT NOT NULL, INDEX IDX_5D327CF6CCD7E912 (menu_id), INDEX IDX_5D327CF6148EB0CB (dish_id), PRIMARY KEY(menu_id, dish_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_allergen (reservation_id INT NOT NULL, allergen_id INT NOT NULL, INDEX IDX_B80AEADAB83297E7 (reservation_id), INDEX IDX_B80AEADA6E775A4A (allergen_id), PRIMARY KEY(reservation_id, allergen_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_allergen ADD CONSTRAINT FK_B59380B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_allergen ADD CONSTRAINT FK_B59380B6E775A4A FOREIGN KEY (allergen_id) REFERENCES allergen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB812469DE2 FOREIGN KEY (category_id) REFERENCES dish_category (id)');
        $this->addSql('ALTER TABLE dish_allergen ADD CONSTRAINT FK_3C4389A5148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dish_allergen ADD CONSTRAINT FK_3C4389A56E775A4A FOREIGN KEY (allergen_id) REFERENCES allergen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_formula ADD CONSTRAINT FK_EFEA453FCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_formula ADD CONSTRAINT FK_EFEA453FA50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_dish ADD CONSTRAINT FK_5D327CF6CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_dish ADD CONSTRAINT FK_5D327CF6148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_allergen ADD CONSTRAINT FK_B80AEADAB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_allergen ADD CONSTRAINT FK_B80AEADA6E775A4A FOREIGN KEY (allergen_id) REFERENCES allergen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client DROP allergens');
        $this->addSql('ALTER TABLE reservation DROP allergens');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_allergen DROP FOREIGN KEY FK_B59380B19EB6921');
        $this->addSql('ALTER TABLE client_allergen DROP FOREIGN KEY FK_B59380B6E775A4A');
        $this->addSql('ALTER TABLE dish DROP FOREIGN KEY FK_957D8CB812469DE2');
        $this->addSql('ALTER TABLE dish_allergen DROP FOREIGN KEY FK_3C4389A5148EB0CB');
        $this->addSql('ALTER TABLE dish_allergen DROP FOREIGN KEY FK_3C4389A56E775A4A');
        $this->addSql('ALTER TABLE menu_formula DROP FOREIGN KEY FK_EFEA453FCCD7E912');
        $this->addSql('ALTER TABLE menu_formula DROP FOREIGN KEY FK_EFEA453FA50A6386');
        $this->addSql('ALTER TABLE menu_dish DROP FOREIGN KEY FK_5D327CF6CCD7E912');
        $this->addSql('ALTER TABLE menu_dish DROP FOREIGN KEY FK_5D327CF6148EB0CB');
        $this->addSql('ALTER TABLE reservation_allergen DROP FOREIGN KEY FK_B80AEADAB83297E7');
        $this->addSql('ALTER TABLE reservation_allergen DROP FOREIGN KEY FK_B80AEADA6E775A4A');
        $this->addSql('DROP TABLE allergen');
        $this->addSql('DROP TABLE client_allergen');
        $this->addSql('DROP TABLE dish');
        $this->addSql('DROP TABLE dish_allergen');
        $this->addSql('DROP TABLE dish_category');
        $this->addSql('DROP TABLE formula');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_formula');
        $this->addSql('DROP TABLE menu_dish');
        $this->addSql('DROP TABLE reservation_allergen');
        $this->addSql('ALTER TABLE client ADD allergens LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE reservation ADD allergens LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }
}
