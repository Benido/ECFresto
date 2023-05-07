<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507190254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE admin (
    id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\',
    email VARCHAR(180) NOT NULL,
    password VARCHAR(255) NOT NULL,
    roles LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\',
    UNIQUE INDEX UNIQ_880E0D76E7927C74 (email),
    PRIMARY KEY(id))
    DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;");
        $this->addSql("CREATE TABLE business_hours (
    id INT AUTO_INCREMENT NOT NULL,
    restaurant_id INT DEFAULT NULL,
    weekday VARCHAR(255) NOT NULL,
    opening_hour TIME DEFAULT NULL,
    closing_hour TIME DEFAULT NULL,
    INDEX IDX_F4FB5A32B1E7706E (restaurant_id),
    PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;");
        $this->addSql("CREATE TABLE client (
    id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\',
    email VARCHAR(180) NOT NULL,
    password VARCHAR(255) NOT NULL,
    default_seats_number SMALLINT DEFAULT NULL,
    allergens LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
    roles LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\',
    UNIQUE INDEX UNIQ_C7440455E7927C74 (email),
    PRIMARY KEY(id))
    DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;");
        $this->addSql("CREATE TABLE reservation (
    id INT AUTO_INCREMENT NOT NULL,
    restaurant_id INT NOT NULL,
    client_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\',
    date DATETIME NOT NULL,
    email VARCHAR(255) NOT NULL,
    seats_number SMALLINT NOT NULL,
    allergens LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
    comment VARCHAR(500) DEFAULT NULL,
    INDEX IDX_42C84955B1E7706E (restaurant_id),
    INDEX IDX_42C8495519EB6921 (client_id),
    PRIMARY KEY(id)) 
    DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;");
        $this->addSql("CREATE TABLE restaurant (
    id INT AUTO_INCREMENT NOT NULL,
    max_capacity SMALLINT NOT NULL,
    PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;");
        $this->addSql("ALTER TABLE business_hours ADD CONSTRAINT FK_F4FB5A32B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id);");
        $this->addSql("ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id);");
        $this->addSql("ALTER TABLE reservation ADD CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id);");


    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
