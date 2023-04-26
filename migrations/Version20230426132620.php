<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426132620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT NOT NULL, client_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', date DATETIME NOT NULL, email VARCHAR(255) NOT NULL, seats_number SMALLINT NOT NULL, allergens LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', comment VARCHAR(500) DEFAULT NULL, INDEX IDX_42C84955B1E7706E (restaurant_id), INDEX IDX_42C8495519EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, max_capacity SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE business_hours ADD restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE business_hours ADD CONSTRAINT FK_F4FB5A32B1E7706E FOREIGN KEY (restaurant_id) REFERENCES quai_antique.restaurant (id)');
        $this->addSql('CREATE INDEX IDX_F4FB5A32B1E7706E ON business_hours (restaurant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE business_hours DROP FOREIGN KEY FK_F4FB5A32B1E7706E');
        $this->addSql('ALTER TABLE quai_antique.reservation DROP FOREIGN KEY FK_42C84955B1E7706E');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495519EB6921');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP INDEX IDX_F4FB5A32B1E7706E ON business_hours');
        $this->addSql('ALTER TABLE business_hours DROP restaurant_id');
    }
}
