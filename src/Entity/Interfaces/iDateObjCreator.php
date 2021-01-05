<?php


namespace  Entity\Interfaces;


interface iDateObjCreator
{
    static public function getDateObjWithValidate(string $date, string $format): \DateTimeInterface;
}