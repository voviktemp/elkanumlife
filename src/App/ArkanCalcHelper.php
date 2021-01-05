<?php

namespace App;

use Entity\Interfaces\iArkanCalcHelper;

class ArkanCalcHelper implements iArkanCalcHelper
{
    static public function calcNumerologyArkanNumber(int $arkan_num): int
    {
        if(11 == $arkan_num) return 8;
        if(8 == $arkan_num) return 11;
        if(22 ==$arkan_num) return 0;
        return $arkan_num;
    }

}