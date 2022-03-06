<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220306154800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add international manufacturers support.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE manufacturer CHANGE country country VARCHAR(2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE manufacturer CHANGE country country VARCHAR(2) NOT NULL');
    }
}
