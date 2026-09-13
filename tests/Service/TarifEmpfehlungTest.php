<?php

namespace App\Tests\Service;

use App\Service\TarifEmpfehlung;
use PHPUnit\Framework\TestCase;

class TarifEmpfehlungTest extends TestCase
{
    public function testGrosseWohnungBekommtPremium(): void
    {
        $empfehlung = new TarifEmpfehlung();
        $result = $empfehlung->empfehlung(120, false, false, false);

        $this->assertEquals('Premium', $result['tarif']);
    }

    public function testEinZusatzbausteinBekommtKomfort(): void
    {
        $empfehlung = new TarifEmpfehlung();
        $result = $empfehlung->empfehlung(60, false, true, false);

        $this->assertEquals('Komfort', $result['tarif']);
    }

    public function testOhneBausteineBekommtBasis(): void
    {
        $empfehlung = new TarifEmpfehlung();
        $result = $empfehlung->empfehlung(45, false, false, false);

        $this->assertEquals('Basis', $result['tarif']);
    }
}
