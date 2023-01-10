<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110185144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE airport (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', city_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', timezone_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', iata VARCHAR(3) NOT NULL, icao VARCHAR(4) NOT NULL, title VARCHAR(150) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, altitude INT DEFAULT NULL, UNIQUE INDEX UNIQ_7E91F7C25F992BBE (iata), UNIQUE INDEX UNIQ_7E91F7C28C1034C3 (icao), INDEX IDX_7E91F7C28BAC62AF (city_id), INDEX IDX_7E91F7C23FE997DE (timezone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT FK_7E91F7C28BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT FK_7E91F7C23FE997DE FOREIGN KEY (timezone_id) REFERENCES timezone (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE airport DROP FOREIGN KEY FK_7E91F7C28BAC62AF');
        $this->addSql('ALTER TABLE airport DROP FOREIGN KEY FK_7E91F7C23FE997DE');
        $this->addSql('DROP TABLE airport');
    }
}
