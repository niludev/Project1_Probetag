<?php

namespace App\Entity\Enum;

enum Selbstbeteiligung: int
{
    case Keine = 0;
    case Mittel = 150;
    case Hoch = 300;
}
