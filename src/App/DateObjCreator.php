<?php


namespace  App;


class DateObjCreator implements   \Entity\Interfaces\iDateObjCreator
{

    static public function getDateObjWithValidate(string $date, string $format): \DateTimeInterface
    {
        $d = \DateTime::createFromFormat($format, $date);
        if (false === ($d && $d->format($format) == $date)) {
            throw new \Exception('Неправильный форматы даты, дата должна быть в формата YYYY-MM-DD, ввели ' . $date);
        }
        return $d;
    }
}