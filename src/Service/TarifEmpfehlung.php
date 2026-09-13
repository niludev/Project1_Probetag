<?php

namespace App\Service;

class TarifEmpfehlung
{
    public function empfehlung(
        int $wohnflaeche,
        bool $glas,
        bool $elementar,
        bool $fahrrad,
    ): array
    {
        if ($wohnflaeche >= 100 || ($glas === true && $fahrrad === true)) {
            return ['tarif' => 'Premium', 'grund' => 'Wohnfläche ist sehr groß und Glasbruch und Fahrraddiebstahl gewählt sind.'];
        }

        if ($glas === true || $fahrrad === true || $elementar === true) {
            return ['tarif' => 'Komfort', 'grund' => 'Mindestens ein Zusatzbaustein ist gewählt.'];

        }

        return ['tarif' => 'Basis', 'grund' => 'Sie haben das Basistarif gewählt.'];
    }
}
