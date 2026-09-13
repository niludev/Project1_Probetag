<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260913112154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE anfrage (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, wohnflaeche INTEGER NOT NULL, plz VARCHAR(255) NOT NULL, selbstbeteiligung INTEGER NOT NULL, fahrrad BOOLEAN NOT NULL, glas BOOLEAN NOT NULL, elementar BOOLEAN NOT NULL, ergebnis CLOB NOT NULL, empfehlung VARCHAR(255) NOT NULL, erstellt_am DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE tarif (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, preis_pro_qm DOUBLE PRECISION NOT NULL, glas_inklusive BOOLEAN NOT NULL, leistungen CLOB NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE anfrage');
        $this->addSql('DROP TABLE tarif');
    }
}
