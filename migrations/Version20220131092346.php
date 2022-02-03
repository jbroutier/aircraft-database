<?php
/**
 * @noinspection SpellCheckingInspection
 */

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220131092346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the database schema.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE aircraft_model (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', aircraft_type BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', manufacturer BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', updated_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_13208ADC989D9B62 (slug), INDEX IDX_13208ADC586CEAD0 (aircraft_type), INDEX IDX_13208ADC3D0AE6DC (manufacturer), INDEX IDX_13208ADCDE12AB56 (created_by), INDEX IDX_13208ADC16FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aircraft_model_engine_model (aircraft_model BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', engine_model BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_53095D1B13208ADC (aircraft_model), INDEX IDX_53095D1BFAFDA692 (engine_model), PRIMARY KEY(aircraft_model, engine_model)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aircraft_model_picture (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', picture BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_3FAB907FE284468 (entity), UNIQUE INDEX UNIQ_3FAB907F16DB4F89 (picture), PRIMARY KEY(entity, picture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aircraft_model_property_value (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', property_value BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_1B4A385BE284468 (entity), UNIQUE INDEX UNIQ_1B4A385BDB649939 (property_value), PRIMARY KEY(entity, property_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aircraft_model_tag (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', tag BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_DFF85372E284468 (entity), INDEX IDX_DFF85372389B783 (tag), PRIMARY KEY(entity, tag)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aircraft_type (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', manufacturer BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', updated_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', iata_code VARCHAR(255) DEFAULT NULL, icao_code VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_586CEAD0989D9B62 (slug), INDEX IDX_586CEAD03D0AE6DC (manufacturer), INDEX IDX_586CEAD0DE12AB56 (created_by), INDEX IDX_586CEAD016FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aircraft_type_engine_model (aircraft_type BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', engine_model BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_5BE9FF97586CEAD0 (aircraft_type), INDEX IDX_5BE9FF97FAFDA692 (engine_model), PRIMARY KEY(aircraft_type, engine_model)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aircraft_type_picture (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', picture BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_B40B6A9AE284468 (entity), UNIQUE INDEX UNIQ_B40B6A9A16DB4F89 (picture), PRIMARY KEY(entity, picture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aircraft_type_property_value (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', property_value BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_B4A42538E284468 (entity), UNIQUE INDEX UNIQ_B4A42538DB649939 (property_value), PRIMARY KEY(entity, property_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aircraft_type_tag (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', tag BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_603BBFFBE284468 (entity), INDEX IDX_603BBFFB389B783 (tag), PRIMARY KEY(entity, tag)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE engine_model (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', manufacturer BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', updated_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_FAFDA692989D9B62 (slug), INDEX IDX_FAFDA6923D0AE6DC (manufacturer), INDEX IDX_FAFDA692DE12AB56 (created_by), INDEX IDX_FAFDA69216FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE engine_model_picture (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', picture BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_80C5B917E284468 (entity), UNIQUE INDEX UNIQ_80C5B91716DB4F89 (picture), PRIMARY KEY(entity, picture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE engine_model_property_value (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', property_value BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_E0A3F9C7E284468 (entity), UNIQUE INDEX UNIQ_E0A3F9C7DB649939 (property_value), PRIMARY KEY(entity, property_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE engine_model_tag (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', tag BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_78242276E284468 (entity), INDEX IDX_78242276389B783 (tag), PRIMARY KEY(entity, tag)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacturer (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', updated_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', country VARCHAR(2) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_3D0AE6DC989D9B62 (slug), INDEX IDX_3D0AE6DCDE12AB56 (created_by), INDEX IDX_3D0AE6DC16FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacturer_picture (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', picture BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_AB7B01DBE284468 (entity), UNIQUE INDEX UNIQ_AB7B01DB16DB4F89 (picture), PRIMARY KEY(entity, picture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacturer_property_value (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', property_value BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_C543036AE284468 (entity), UNIQUE INDEX UNIQ_C543036ADB649939 (property_value), PRIMARY KEY(entity, property_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacturer_tag (entity BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', tag BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_2D88A0D1E284468 (entity), INDEX IDX_2D88A0D1389B783 (tag), PRIMARY KEY(entity, tag)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', author_name VARCHAR(255) NOT NULL, author_profile VARCHAR(255) DEFAULT NULL, dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', fileName VARCHAR(255) DEFAULT NULL, license VARCHAR(255) NOT NULL, original_name VARCHAR(255) DEFAULT NULL, mime_type VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, source VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', property_group BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', updated_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', type VARCHAR(255) NOT NULL, unit VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8BF21CDE989D9B62 (slug), INDEX IDX_8BF21CDEABD385C8 (property_group), INDEX IDX_8BF21CDEDE12AB56 (created_by), INDEX IDX_8BF21CDE16FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', updated_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_ABD385C8DE12AB56 (created_by), INDEX IDX_ABD385C816FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_value (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', property BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DB6499398BF21CDE (property), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', updated_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', color VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_389B783989D9B62 (slug), INDEX IDX_389B783DE12AB56 (created_by), INDEX IDX_389B78316FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aircraft_model ADD CONSTRAINT FK_13208ADC586CEAD0 FOREIGN KEY (aircraft_type) REFERENCES aircraft_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE aircraft_model ADD CONSTRAINT FK_13208ADC3D0AE6DC FOREIGN KEY (manufacturer) REFERENCES manufacturer (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE aircraft_model ADD CONSTRAINT FK_13208ADCDE12AB56 FOREIGN KEY (created_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE aircraft_model ADD CONSTRAINT FK_13208ADC16FE72E1 FOREIGN KEY (updated_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE aircraft_model_engine_model ADD CONSTRAINT FK_53095D1B13208ADC FOREIGN KEY (aircraft_model) REFERENCES aircraft_model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_model_engine_model ADD CONSTRAINT FK_53095D1BFAFDA692 FOREIGN KEY (engine_model) REFERENCES engine_model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_model_picture ADD CONSTRAINT FK_3FAB907FE284468 FOREIGN KEY (entity) REFERENCES aircraft_model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_model_picture ADD CONSTRAINT FK_3FAB907F16DB4F89 FOREIGN KEY (picture) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_model_property_value ADD CONSTRAINT FK_1B4A385BE284468 FOREIGN KEY (entity) REFERENCES aircraft_model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_model_property_value ADD CONSTRAINT FK_1B4A385BDB649939 FOREIGN KEY (property_value) REFERENCES property_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_model_tag ADD CONSTRAINT FK_DFF85372E284468 FOREIGN KEY (entity) REFERENCES aircraft_model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_model_tag ADD CONSTRAINT FK_DFF85372389B783 FOREIGN KEY (tag) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_type ADD CONSTRAINT FK_586CEAD03D0AE6DC FOREIGN KEY (manufacturer) REFERENCES manufacturer (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE aircraft_type ADD CONSTRAINT FK_586CEAD0DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE aircraft_type ADD CONSTRAINT FK_586CEAD016FE72E1 FOREIGN KEY (updated_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE aircraft_type_engine_model ADD CONSTRAINT FK_5BE9FF97586CEAD0 FOREIGN KEY (aircraft_type) REFERENCES aircraft_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_type_engine_model ADD CONSTRAINT FK_5BE9FF97FAFDA692 FOREIGN KEY (engine_model) REFERENCES engine_model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_type_picture ADD CONSTRAINT FK_B40B6A9AE284468 FOREIGN KEY (entity) REFERENCES aircraft_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_type_picture ADD CONSTRAINT FK_B40B6A9A16DB4F89 FOREIGN KEY (picture) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_type_property_value ADD CONSTRAINT FK_B4A42538E284468 FOREIGN KEY (entity) REFERENCES aircraft_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_type_property_value ADD CONSTRAINT FK_B4A42538DB649939 FOREIGN KEY (property_value) REFERENCES property_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_type_tag ADD CONSTRAINT FK_603BBFFBE284468 FOREIGN KEY (entity) REFERENCES aircraft_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aircraft_type_tag ADD CONSTRAINT FK_603BBFFB389B783 FOREIGN KEY (tag) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE engine_model ADD CONSTRAINT FK_FAFDA6923D0AE6DC FOREIGN KEY (manufacturer) REFERENCES manufacturer (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE engine_model ADD CONSTRAINT FK_FAFDA692DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE engine_model ADD CONSTRAINT FK_FAFDA69216FE72E1 FOREIGN KEY (updated_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE engine_model_picture ADD CONSTRAINT FK_80C5B917E284468 FOREIGN KEY (entity) REFERENCES engine_model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE engine_model_picture ADD CONSTRAINT FK_80C5B91716DB4F89 FOREIGN KEY (picture) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE engine_model_property_value ADD CONSTRAINT FK_E0A3F9C7E284468 FOREIGN KEY (entity) REFERENCES engine_model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE engine_model_property_value ADD CONSTRAINT FK_E0A3F9C7DB649939 FOREIGN KEY (property_value) REFERENCES property_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE engine_model_tag ADD CONSTRAINT FK_78242276E284468 FOREIGN KEY (entity) REFERENCES engine_model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE engine_model_tag ADD CONSTRAINT FK_78242276389B783 FOREIGN KEY (tag) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manufacturer ADD CONSTRAINT FK_3D0AE6DCDE12AB56 FOREIGN KEY (created_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE manufacturer ADD CONSTRAINT FK_3D0AE6DC16FE72E1 FOREIGN KEY (updated_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE manufacturer_picture ADD CONSTRAINT FK_AB7B01DBE284468 FOREIGN KEY (entity) REFERENCES manufacturer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manufacturer_picture ADD CONSTRAINT FK_AB7B01DB16DB4F89 FOREIGN KEY (picture) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manufacturer_property_value ADD CONSTRAINT FK_C543036AE284468 FOREIGN KEY (entity) REFERENCES manufacturer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manufacturer_property_value ADD CONSTRAINT FK_C543036ADB649939 FOREIGN KEY (property_value) REFERENCES property_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manufacturer_tag ADD CONSTRAINT FK_2D88A0D1E284468 FOREIGN KEY (entity) REFERENCES manufacturer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manufacturer_tag ADD CONSTRAINT FK_2D88A0D1389B783 FOREIGN KEY (tag) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEABD385C8 FOREIGN KEY (property_group) REFERENCES property_group (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEDE12AB56 FOREIGN KEY (created_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE16FE72E1 FOREIGN KEY (updated_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE property_group ADD CONSTRAINT FK_ABD385C8DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE property_group ADD CONSTRAINT FK_ABD385C816FE72E1 FOREIGN KEY (updated_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE property_value ADD CONSTRAINT FK_DB6499398BF21CDE FOREIGN KEY (property) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B78316FE72E1 FOREIGN KEY (updated_by) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aircraft_model_engine_model DROP FOREIGN KEY FK_53095D1B13208ADC');
        $this->addSql('ALTER TABLE aircraft_model_picture DROP FOREIGN KEY FK_3FAB907FE284468');
        $this->addSql('ALTER TABLE aircraft_model_property_value DROP FOREIGN KEY FK_1B4A385BE284468');
        $this->addSql('ALTER TABLE aircraft_model_tag DROP FOREIGN KEY FK_DFF85372E284468');
        $this->addSql('ALTER TABLE aircraft_model DROP FOREIGN KEY FK_13208ADC586CEAD0');
        $this->addSql('ALTER TABLE aircraft_type_engine_model DROP FOREIGN KEY FK_5BE9FF97586CEAD0');
        $this->addSql('ALTER TABLE aircraft_type_picture DROP FOREIGN KEY FK_B40B6A9AE284468');
        $this->addSql('ALTER TABLE aircraft_type_property_value DROP FOREIGN KEY FK_B4A42538E284468');
        $this->addSql('ALTER TABLE aircraft_type_tag DROP FOREIGN KEY FK_603BBFFBE284468');
        $this->addSql('ALTER TABLE aircraft_model_engine_model DROP FOREIGN KEY FK_53095D1BFAFDA692');
        $this->addSql('ALTER TABLE aircraft_type_engine_model DROP FOREIGN KEY FK_5BE9FF97FAFDA692');
        $this->addSql('ALTER TABLE engine_model_picture DROP FOREIGN KEY FK_80C5B917E284468');
        $this->addSql('ALTER TABLE engine_model_property_value DROP FOREIGN KEY FK_E0A3F9C7E284468');
        $this->addSql('ALTER TABLE engine_model_tag DROP FOREIGN KEY FK_78242276E284468');
        $this->addSql('ALTER TABLE aircraft_model DROP FOREIGN KEY FK_13208ADC3D0AE6DC');
        $this->addSql('ALTER TABLE aircraft_type DROP FOREIGN KEY FK_586CEAD03D0AE6DC');
        $this->addSql('ALTER TABLE engine_model DROP FOREIGN KEY FK_FAFDA6923D0AE6DC');
        $this->addSql('ALTER TABLE manufacturer_picture DROP FOREIGN KEY FK_AB7B01DBE284468');
        $this->addSql('ALTER TABLE manufacturer_property_value DROP FOREIGN KEY FK_C543036AE284468');
        $this->addSql('ALTER TABLE manufacturer_tag DROP FOREIGN KEY FK_2D88A0D1E284468');
        $this->addSql('ALTER TABLE aircraft_model_picture DROP FOREIGN KEY FK_3FAB907F16DB4F89');
        $this->addSql('ALTER TABLE aircraft_type_picture DROP FOREIGN KEY FK_B40B6A9A16DB4F89');
        $this->addSql('ALTER TABLE engine_model_picture DROP FOREIGN KEY FK_80C5B91716DB4F89');
        $this->addSql('ALTER TABLE manufacturer_picture DROP FOREIGN KEY FK_AB7B01DB16DB4F89');
        $this->addSql('ALTER TABLE property_value DROP FOREIGN KEY FK_DB6499398BF21CDE');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEABD385C8');
        $this->addSql('ALTER TABLE aircraft_model_property_value DROP FOREIGN KEY FK_1B4A385BDB649939');
        $this->addSql('ALTER TABLE aircraft_type_property_value DROP FOREIGN KEY FK_B4A42538DB649939');
        $this->addSql('ALTER TABLE engine_model_property_value DROP FOREIGN KEY FK_E0A3F9C7DB649939');
        $this->addSql('ALTER TABLE manufacturer_property_value DROP FOREIGN KEY FK_C543036ADB649939');
        $this->addSql('ALTER TABLE aircraft_model_tag DROP FOREIGN KEY FK_DFF85372389B783');
        $this->addSql('ALTER TABLE aircraft_type_tag DROP FOREIGN KEY FK_603BBFFB389B783');
        $this->addSql('ALTER TABLE engine_model_tag DROP FOREIGN KEY FK_78242276389B783');
        $this->addSql('ALTER TABLE manufacturer_tag DROP FOREIGN KEY FK_2D88A0D1389B783');
        $this->addSql('ALTER TABLE aircraft_model DROP FOREIGN KEY FK_13208ADCDE12AB56');
        $this->addSql('ALTER TABLE aircraft_model DROP FOREIGN KEY FK_13208ADC16FE72E1');
        $this->addSql('ALTER TABLE aircraft_type DROP FOREIGN KEY FK_586CEAD0DE12AB56');
        $this->addSql('ALTER TABLE aircraft_type DROP FOREIGN KEY FK_586CEAD016FE72E1');
        $this->addSql('ALTER TABLE engine_model DROP FOREIGN KEY FK_FAFDA692DE12AB56');
        $this->addSql('ALTER TABLE engine_model DROP FOREIGN KEY FK_FAFDA69216FE72E1');
        $this->addSql('ALTER TABLE manufacturer DROP FOREIGN KEY FK_3D0AE6DCDE12AB56');
        $this->addSql('ALTER TABLE manufacturer DROP FOREIGN KEY FK_3D0AE6DC16FE72E1');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEDE12AB56');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE16FE72E1');
        $this->addSql('ALTER TABLE property_group DROP FOREIGN KEY FK_ABD385C8DE12AB56');
        $this->addSql('ALTER TABLE property_group DROP FOREIGN KEY FK_ABD385C816FE72E1');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783DE12AB56');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B78316FE72E1');
        $this->addSql('DROP TABLE aircraft_model');
        $this->addSql('DROP TABLE aircraft_model_engine_model');
        $this->addSql('DROP TABLE aircraft_model_picture');
        $this->addSql('DROP TABLE aircraft_model_property_value');
        $this->addSql('DROP TABLE aircraft_model_tag');
        $this->addSql('DROP TABLE aircraft_type');
        $this->addSql('DROP TABLE aircraft_type_engine_model');
        $this->addSql('DROP TABLE aircraft_type_picture');
        $this->addSql('DROP TABLE aircraft_type_property_value');
        $this->addSql('DROP TABLE aircraft_type_tag');
        $this->addSql('DROP TABLE engine_model');
        $this->addSql('DROP TABLE engine_model_picture');
        $this->addSql('DROP TABLE engine_model_property_value');
        $this->addSql('DROP TABLE engine_model_tag');
        $this->addSql('DROP TABLE manufacturer');
        $this->addSql('DROP TABLE manufacturer_picture');
        $this->addSql('DROP TABLE manufacturer_property_value');
        $this->addSql('DROP TABLE manufacturer_tag');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_group');
        $this->addSql('DROP TABLE property_value');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
