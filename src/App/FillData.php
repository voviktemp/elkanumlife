<?php


namespace App;


use Entity\PointDataArray;

class FillData implements \Entity\Interfaces\iFillData
{

    static public function fillData(PointDataArray &$pointDataArray)
    {
        foreach ($pointDataArray as $item) {

            if($item->isHide()) continue;

            $dir_name = $item->getInternalName();
            $num = $item->getCalculatedValue();

            # проверяем наличие файла с данными
            $txt_path = __DIR__ . "/../../data/txt/$dir_name/$num.html";

//            echo $txt_path . "\n";
//            die;

            $txt = null;
            if (false == file_exists($txt_path)) {
                $txt = "!!!ФАЙЛ С ДАННЫМИ не нАЙДеН!!!";
            }

            # получаем содержание файла, записываем полученное в объект
            $item->setData($txt ?? file_get_contents($txt_path));

        }
    }
}