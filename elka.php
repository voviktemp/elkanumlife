<?php

require_once 'autoload.php';

use App\CalculatePoints;
use App\Calculator;
use App\DateObjCreator;
use App\FillData;
use App\RenderProfile;


$dates = require 'config.php';


$format = 'Y-m-d';

clearstatcache();

foreach ($dates as $item) {
    $date = $item['date'];
    $name = $item['name'];
    $second_name = $item['second_name'] ?? [];
    $sovmestimost_date = $item['sovmestimost_date'] ?? '';

    $file_name = "$name ($date)";

    // получаем дату рождения исследуемого клиента
    // это основа расчета, если даты нет, то останавливаем расчет
    try {
        $date = DateObjCreator::getDateObjWithValidate($date, $format);
    } catch (Exception $e) {
        echo $e->getMessage() . "\n";
        continue;
    }

    // дата для расчета совместимости, если не задано, то не страшно.
    try {
        $sovmestimost_date = DateObjCreator::getDateObjWithValidate($sovmestimost_date, $format);
    } catch (Exception $e) {
        $sovmestimost_date = null;
    }

    $calculate = new CalculatePoints($date, $sovmestimost_date, $name, $second_name, new Calculator());

    $profile = $calculate->getProfile();

    FillData::fillData($profile->getPointDataArrayLink());


//    print_r($profile);

    RenderProfile::renderProfile($profile, $file_name);
}


echo "DONE\n";
