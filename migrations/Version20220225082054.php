<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220225082054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add markdown content.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aircraft_model ADD content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE aircraft_type ADD content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE engine_model ADD content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE manufacturer ADD content LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aircraft_model DROP content');
        $this->addSql('ALTER TABLE aircraft_type DROP content');
        $this->addSql('ALTER TABLE engine_model DROP content');
        $this->addSql('ALTER TABLE manufacturer DROP content');
    }
}
