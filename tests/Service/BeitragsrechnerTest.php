<?php

namespace App\Tests\Service;

use App\Entity\Enum\Selbstbeteiligung;
use App\Entity\Tarif;
use App\Service\Beitragsrechner;
use PHPUnit\Framework\TestCase;

class BeitragsrechnerTest extends TestCase
{
    public function testKomfortMitFahrradUnd150EuroSelbstbeteiligung(): void
    {
        $tarif = new Tarif();
        $tarif->setName('Komfort');
        $tarif->setPreisProQm(1.30);
        $tarif->setGlasInklusive(false);

        $rechner = new Beitragsrechner();
        $result = $rechner->jahresbeitragsRechner($tarif, 30, true, false, false, Selbstbeteiligung::Mittel);

        $this->assertSame(57.6, $result);
    }

    public function testGlasbruchIstImPremiumTarifInklusive(): void
    {
        $tarif = new Tarif();
        $tarif->setName('Premium');
        $tarif->setPreisProQm(1.80);
        $tarif->setGlasInklusive(true);

        $rechner = new Beitragsrechner();
        $result = $rechner->jahresbeitragsRechner($tarif, 30, false, true, false, Selbstbeteiligung::Keine);

        $this->assertSame(54.0, $result);
    }

    public function testMindestbeitragGiltBeiKleinerWohnung(): void
    {
        $tarif = new Tarif();
        $tarif->setName('Basic');
        $tarif->setPreisProQm(0.90);
        $tarif->setGlasInklusive(false);

        $rechner = new Beitragsrechner();
        $result = $rechner->jahresbeitragsRechner($tarif, 10, false, false, false, Selbstbeteiligung::Keine);

        $this->assertSame(40.0, $result);
    }
}
