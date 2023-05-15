<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515082609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C53D045F989D9B62 ON image');
        $this->addSql('ALTER TABLE image ADD image_name VARCHAR(255) DEFAULT NULL, ADD image_size INT DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP filename, DROP slug, DROP width, DROP height');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD filename VARCHAR(255) NOT NULL, ADD slug VARCHAR(255) NOT NULL, ADD width INT NOT NULL, ADD height INT NOT NULL, DROP image_name, DROP image_size, DROP updated_at');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045F989D9B62 ON image (slug)');
    }
}
