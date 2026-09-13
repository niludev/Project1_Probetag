<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260913205007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__anfrage AS SELECT id, wohnflaeche, plz, selbstbeteiligung, fahrrad, glas, elementar, ergebnis, empfehlung, erstellt_am FROM anfrage');
        $this->addSql('DROP TABLE anfrage');
        $this->addSql('CREATE TABLE anfrage (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, wohnflaeche INTEGER NOT NULL, plz VARCHAR(255) NOT NULL, selbstbeteiligung INTEGER NOT NULL, fahrrad BOOLEAN NOT NULL, glas BOOLEAN NOT NULL, elementar BOOLEAN NOT NULL, ergebnis CLOB NOT NULL, empfehlung VARCHAR(255) NOT NULL, erstellt_am DATETIME NOT NULL)');
        $this->addSql('INSERT INTO anfrage (id, wohnflaeche, plz, selbstbeteiligung, fahrrad, glas, elementar, ergebnis, empfehlung, erstellt_am) SELECT id, wohnflaeche, plz, selbstbeteiligung, fahrrad, glas, elementar, ergebnis, empfehlung, erstellt_am FROM __temp__anfrage');
        $this->addSql('DROP TABLE __temp__anfrage');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__anfrage AS SELECT id, wohnflaeche, plz, selbstbeteiligung, fahrrad, glas, elementar, ergebnis, empfehlung, erstellt_am FROM anfrage');
        $this->addSql('DROP TABLE anfrage');
        $this->addSql('CREATE TABLE anfrage (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, wohnflaeche INTEGER NOT NULL, plz VARCHAR(255) NOT NULL, selbstbeteiligung INTEGER NOT NULL, fahrrad BOOLEAN NOT NULL, glas BOOLEAN NOT NULL, elementar BOOLEAN NOT NULL, ergebnis CLOB NOT NULL, empfehlung CLOB NOT NULL, erstellt_am DATETIME NOT NULL)');
        $this->addSql('INSERT INTO anfrage (id, wohnflaeche, plz, selbstbeteiligung, fahrrad, glas, elementar, ergebnis, empfehlung, erstellt_am) SELECT id, wohnflaeche, plz, selbstbeteiligung, fahrrad, glas, elementar, ergebnis, empfehlung, erstellt_am FROM __temp__anfrage');
        $this->addSql('DROP TABLE __temp__anfrage');
    }
}
