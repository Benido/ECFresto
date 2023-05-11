<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230511173810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_formula DROP FOREIGN KEY FK_EFEA453FA50A6386');
        $this->addSql('ALTER TABLE menu_formula DROP FOREIGN KEY FK_EFEA453FCCD7E912');
        $this->addSql('DROP TABLE menu_formula');
        $this->addSql('ALTER TABLE formula ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formula ADD CONSTRAINT FK_67315881CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_67315881CCD7E912 ON formula (menu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_formula (menu_id INT NOT NULL, formula_id INT NOT NULL, INDEX IDX_EFEA453FCCD7E912 (menu_id), INDEX IDX_EFEA453FA50A6386 (formula_id), PRIMARY KEY(menu_id, formula_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE menu_formula ADD CONSTRAINT FK_EFEA453FA50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_formula ADD CONSTRAINT FK_EFEA453FCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE formula DROP FOREIGN KEY FK_67315881CCD7E912');
        $this->addSql('DROP INDEX IDX_67315881CCD7E912 ON formula');
        $this->addSql('ALTER TABLE formula DROP menu_id');
    }
}
