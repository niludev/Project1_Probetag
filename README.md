# Hausrat-Tarifrechner

Ein kleiner Rechner, mit dem Kundinnen und Kunden online einen passenden Hausrat-Tarif finden können. Auf Basis von Wohnfläche, Postleitzahl, Selbstbeteiligung und optionalen Zusatzbausteinen werden die Jahres- und Monatsbeiträge für drei Tarife (Basis, Komfort, Premium) berechnet und ein Tarif automatisch empfohlen.

## Tech-Stack

| Bereich | Technologie |
|---|---|
| Sprache | PHP 8.2 |
| Framework | Symfony (webapp-pack, ORM, MakerBundle, Test-Pack) |
| Datenbank | SQLite |
| Server | Eingebauter PHP-Server (kein Nginx) |
| Umgebung | Docker / Docker Compose |
| Tests | PHPUnit |

## Installation

Voraussetzung: Docker und Docker Compose sind installiert.

```bash
# 1. Image bauen
docker compose build

# 2. Abhängigkeiten installieren
docker compose run --rm app composer install

# 3. Datenbankschema anlegen
docker compose run --rm app php bin/console doctrine:migrations:migrate
```

Anschließend müssen die drei Tarife einmalig in die Datenbank eingetragen werden:

```bash
docker compose run --rm app php bin/console dbal:run-sql "INSERT INTO tarif (name, preis_pro_qm, glas_inklusive, leistungen) VALUES ('Basis', 0.90, 0, 'Feuer, Leitungswasser, Einbruchdiebstahl, Sturm/Hagel')"
docker compose run --rm app php bin/console dbal:run-sql "INSERT INTO tarif (name, preis_pro_qm, glas_inklusive, leistungen) VALUES ('Komfort', 1.30, 0, 'wie Basis + grobe Fahrlaessigkeit + Ueberspannung')"
docker compose run --rm app php bin/console dbal:run-sql "INSERT INTO tarif (name, preis_pro_qm, glas_inklusive, leistungen) VALUES ('Premium', 1.80, 1, 'wie Komfort + Diebstahl aus dem Auto + Neuwertersatz ohne Abzug')"
```

## Start

```bash
docker compose up
```

Die Anwendung ist danach unter [http://localhost:8000](http://localhost:8000) erreichbar.

## Verwendung

1. Formular unter `/` ausfüllen (Wohnfläche, PLZ, Selbstbeteiligung, Zusatzbausteine).
2. Nach dem Absenden wird die Anfrage gespeichert und man landet auf einer eigenen Ergebnis-Seite (`/anfrage/{id}`), die auch später wieder aufgerufen werden kann.

### Routen

| Methode | Pfad | Beschreibung |
|---|---|---|
| GET/POST | `/` | Eingabeformular / Verarbeitung |
| GET | `/anfrage/{id}` | Ergebnisseite einer gespeicherten Anfrage |
| GET | `/api/tarife` | Alle Tarife als JSON |
| GET | `/api/anfragen/{id}` | Eine einzelne Anfrage als JSON (404, falls nicht vorhanden) |

## Tests

```bash
docker compose run --rm app php bin/phpunit
```

Getestet werden:

- **`Beitragsrechner`** – Beitragsberechnung inkl. Zusatzbausteinen, Rabatt und Mindestbeitrag (u. a. ein Fall, der explizit den Mindestbeitrag greift)
- **`TarifEmpfehlung`** – jede der drei Empfehlungsregeln einzeln

## Projektstruktur (Auszug)

```
src/
├── Controller/
│   ├── HausratController.php   # Formular + Ergebnisseite
│   └── ApiController.php       # JSON-Endpunkte
├── Entity/
│   ├── Tarif.php
│   └── Anfrage.php
├── Enum/
│   └── Selbstbeteiligung.php
├── Service/
│   ├── Beitragsrechner.php      # reine Berechnungslogik, kennt keine Datenbank
│   └── TarifEmpfehlung.php      # reine Empfehlungslogik
tests/
└── Service/
    ├── BeitragsrechnerTest.php
    └── TarifEmpfehlungTest.php
```

## Offene Punkte

- Die Mobil-Ansicht (375 px) wurde noch nicht systematisch überprüft.
- Es gibt bisher keine strukturierte, kleinteilige Commit-Historie.
- Für die API-Endpunkte existieren noch keine automatisierten Tests.
