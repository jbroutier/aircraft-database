<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220323110010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create full-text search indexes.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE FULLTEXT INDEX IDX_13208ADCFEC530A95E237E06 ON aircraft_model (content, name)');
        $this->addSql('CREATE FULLTEXT INDEX IDX_586CEAD0FEC530A95E237E06 ON aircraft_type (content, name)');
        $this->addSql('CREATE FULLTEXT INDEX IDX_FAFDA692FEC530A95E237E06 ON engine_model (content, name)');
        $this->addSql('CREATE FULLTEXT INDEX IDX_3D0AE6DCFEC530A95E237E06 ON manufacturer (content, name)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX IDX_13208ADCFEC530A95E237E06 ON aircraft_model');
        $this->addSql('DROP INDEX IDX_586CEAD0FEC530A95E237E06 ON aircraft_type');
        $this->addSql('DROP INDEX IDX_FAFDA692FEC530A95E237E06 ON engine_model');
        $this->addSql('DROP INDEX IDX_3D0AE6DCFEC530A95E237E06 ON manufacturer');
    }
}
