<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220217084458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add pictures description.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE picture ADD (
                description VARCHAR(255) DEFAULT NULL
            )'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE picture DROP description');
    }
}
