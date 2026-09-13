<?php

namespace App\Service;

use App\Entity\Enum\Selbstbeteiligung;
use App\Entity\Tarif;

class Beitragsrechner
{
    public function jahresbeitragsRechner(
        Tarif             $tarif,
        int               $wohnflaeche,
        bool              $fahrrad,
        bool              $glas,
        bool              $elementar,
        Selbstbeteiligung $selbstbeteiligung
    ): float

    {
        $mindestbeitrag = 40.0;
        $grundbeitrag = $wohnflaeche * $tarif->getPreisProQm();

        if ($fahrrad) {
            $grundbeitrag += 25;
        }

        if ($elementar) {
            $grundbeitrag += 30;
        }

        if ($glas && !$tarif->isGlasInklusive()) {
            $grundbeitrag += 18;
        }

        if ($selbstbeteiligung ===  Selbstbeteiligung::Mittel) {
            $grundbeitrag = $grundbeitrag * 0.90;
        } elseif ($selbstbeteiligung ===  Selbstbeteiligung::Hoch) {
            $grundbeitrag = $grundbeitrag *0.85;
        }

        if ($grundbeitrag < $mindestbeitrag) {
          $grundbeitrag = $mindestbeitrag;
        }

        return round($grundbeitrag, 2);
    }
}
