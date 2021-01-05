<?php


namespace  Entity\Interfaces;


use Entity\Profile;

interface iCalculatePoints
{
    public function __construct(\DateTimeInterface $date, ?\DateTimeInterface $sovmestimist_date, string $name, array $second_name, iCalculator $calculator);

    public function getProfile(): Profile;
}