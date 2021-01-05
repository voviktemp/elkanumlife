<?php


namespace Entity\Interfaces;


interface iCalculator
{
    public function calcArcan22Summ(int ...$arrForSumm): int;

    public function calcArcanYearReductialy(int $year): int;

    public function calcSecondNameArkan(string $second_name): int;

    public function calcSecondNameInDigitsString(string $second_name);

    public function calcArcan22Minus(int $a, int $b): int;
}