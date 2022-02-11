<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220211090153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add manufacturer logos.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE logo (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', file_name VARCHAR(255) DEFAULT NULL, mime_type VARCHAR(255) DEFAULT NULL, original_name VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE manufacturer ADD logo BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE manufacturer ADD CONSTRAINT FK_3D0AE6DCE48E9A13 FOREIGN KEY (logo) REFERENCES logo (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D0AE6DCE48E9A13 ON manufacturer (logo)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE manufacturer DROP FOREIGN KEY FK_3D0AE6DCE48E9A13');
        $this->addSql('DROP TABLE logo');
        $this->addSql('DROP INDEX UNIQ_3D0AE6DCE48E9A13 ON manufacturer');
        $this->addSql('ALTER TABLE manufacturer DROP logo');
    }
}
