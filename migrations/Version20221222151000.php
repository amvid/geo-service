<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221222151000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', sub_region_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', currency_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(150) NOT NULL, native_title VARCHAR(150) NOT NULL, iso2 VARCHAR(2) NOT NULL, iso3 VARCHAR(3) NOT NULL, numeric_code VARCHAR(3) NOT NULL, phone_code VARCHAR(20) NOT NULL, flag VARCHAR(100) NOT NULL, tld VARCHAR(20) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, altitude INT DEFAULT NULL, UNIQUE INDEX UNIQ_5373C9662B36786B (title), UNIQUE INDEX UNIQ_5373C96687F3EC9D (native_title), UNIQUE INDEX UNIQ_5373C9661B6F9774 (iso2), UNIQUE INDEX UNIQ_5373C9666C68A7E2 (iso3), UNIQUE INDEX UNIQ_5373C96695079952 (numeric_code), UNIQUE INDEX UNIQ_5373C9669411628A (phone_code), UNIQUE INDEX UNIQ_5373C966D1F4EB9A (flag), INDEX IDX_5373C9668A2B47EB (sub_region_id), INDEX IDX_5373C96638248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_timezone (country_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', timezone_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_4CBE32AF92F3E70 (country_id), INDEX IDX_4CBE32A3FE997DE (timezone_id), PRIMARY KEY(country_id, timezone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C9668A2B47EB FOREIGN KEY (sub_region_id) REFERENCES sub_region (id)');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C96638248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE country_timezone ADD CONSTRAINT FK_4CBE32AF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE country_timezone ADD CONSTRAINT FK_4CBE32A3FE997DE FOREIGN KEY (timezone_id) REFERENCES timezone (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C9668A2B47EB');
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C96638248176');
        $this->addSql('ALTER TABLE country_timezone DROP FOREIGN KEY FK_4CBE32AF92F3E70');
        $this->addSql('ALTER TABLE country_timezone DROP FOREIGN KEY FK_4CBE32A3FE997DE');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE country_timezone');
    }
}
