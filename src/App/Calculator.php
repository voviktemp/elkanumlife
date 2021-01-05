<?php


namespace App;


use Entity\Interfaces\iCalculator;

class Calculator implements iCalculator
{

    /**
     * Calculator constructor.
     */
    public function __construct()
    {
    }


    public function calcArcanYearReductialy(int $year): int
    {
        $temp = $this->digitsSum($year);
        return $temp <= 22 ? $temp : $this->digitsSum($temp);
    }

    private function digitsSum(int $digits)
    {
        return array_sum(str_split($digits));
    }

    public function calcSecondNameArkan(string $second_name): int
    {
        $to_digits = self::calcSecondNameInDigitsString($second_name);
        $val = array_sum(str_split($to_digits));
        $val = $this->calcArcan22Summ($val);

        return $val;
    }

    public function calcSecondNameInDigitsString(string $second_name)
    {
        $cirilic_alphabet_nums = [

            # cirilic
            'а' => 1,
            'б' => 2,
            'в' => 3,
            'г' => 4,
            'д' => 5,
            'е' => 6,
            'ё' => 7,
            'ж' => 8,
            'з' => 9,

            'и' => 1,
            'й' => 2,
            'к' => 3,
            'л' => 4,
            'м' => 5,
            'н' => 6,
            'о' => 7,
            'п' => 8,
            'р' => 9,

            'с' => 1,
            'т' => 2,
            'у' => 3,
            'ф' => 4,
            'х' => 5,
            'ц' => 6,
            'ч' => 7,
            'ш' => 8,
            'щ' => 9,

            'ъ' => 1,
            'ы' => 2,
            'ь' => 3,
            'э' => 4,
            'ю' => 5,
            'я' => 6,


            # latin_alplabet_num
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => 4,
            'e' => 5,
            'f' => 6,
            'g' => 7,
            'h' => 8,
            'i' => 9,

            'j' => 1,
            'l' => 2,
            'k' => 3,
            'm' => 4,
            'n' => 5,
            'o' => 6,
            'p' => 7,
            'q' => 8,
            'r' => 9,

            's' => 1,
            't' => 2,
            'u' => 3,
            'v' => 4,
            'w' => 5,
            'x' => 6,
            'y' => 7,
            'z' => 8,
        ];

        $second_name = mb_strtolower($second_name);
        $second_name = preg_replace("/[^a-zA-Zа-яА-Я]+/u", "", $second_name);
        $second_name = str_ireplace(array_keys($cirilic_alphabet_nums), $cirilic_alphabet_nums, $second_name);

        return $second_name;
    }

    public function calcArcan22Minus(int $a, int $b): int
    {
        {
            $temp = abs($a - $b);
            return $temp;
        }
    }

    public function calcArcan22Summ(int ...$arrForSumm): int
    {
        $temp = array_sum($arrForSumm);

        while ($temp > 22) {
            $temp -= 22;
        }

        return $temp;
    }
}