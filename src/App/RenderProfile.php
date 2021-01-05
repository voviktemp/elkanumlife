<?php


namespace App;


use Entity\Profile;

class RenderProfile implements \Entity\Interfaces\RenderProfile
{

    const rect_colors = [
        '#17a2b8',
        '#20c997',
        '#28a745',
        '#ffc107',
        '#fd7e14',
        '#dc3545',
        '#e83e8c',
        '#6f42c1',
        '#6610f2',
        '#007bff',
    ];

    static public function renderProfile(Profile $profile, string $file_name)
    {
        $tpl = self::fillVariables($profile);

        self::fillHtmlIcludes($tpl);


        $template_content = file_get_contents(__DIR__ . "/../../web/index.html");

        foreach ($tpl as $name => $content) {
            $template_content = str_replace("@$name@", $content, $template_content);
        }

        # заполняем цветные квадратики разными цветами
        $template_content = preg_replace_callback("|@rect_color@|",
            function ($matches) {
                return self::getRandRectColor();
            }
            , $template_content);

        file_put_contents(__DIR__ . "/../../result/$file_name.html", $template_content);
        echo "file://" . __DIR__ . "/../../result/$file_name.html\n";
    }

    /**
     * @param Profile $profile
     * @param $tpl
     */
    static private function fillVariables(Profile $profile): array
    {
        $tpl = [];
        $tpl['date'] = $profile->getDate();
        $tpl['sovmestimost_date'] = $profile->getSovmestimostDate();
        $tpl['name'] = $profile->getName();

        # код который юзается один раз, чтоб закодировать изображение
//        $path = __DIR__ . "/../../web/bootstrap-logo-white.png";
//        $type = pathinfo($path, PATHINFO_EXTENSION);
//        $data = file_get_contents($path);
//        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $tpl['logo'] = file_get_contents(__DIR__ . "/../../web/logo.base64");

        $points = $profile->getPointDataArrayLink();
        foreach ($points as $one) {
            $calculatedValue = $one->getCalculatedValue();
            $metkaName = $one->getMetkaName();

            $tpl[$metkaName] = $one->getData();
            $tpl[$metkaName . '_num_value'] = $calculatedValue;
            # конвертим изображение в base64
            $tpl[$metkaName . '_img'] = self::convertImgToBase64(ArkanCalcHelper::calcNumerologyArkanNumber($calculatedValue));

            # скрываем блок
            if($one->isHide()){
                $tpl[$metkaName . '_hide_start'] = "<!--";
                $tpl[$metkaName . '_hide_end'] = "-->";
            }else{
                $tpl[$metkaName . '_hide_start'] = "";
                $tpl[$metkaName . '_hide_end'] = "";
            }

            # родовая принадлежность
            $tpl[$metkaName . '_secondName'] = $one->getSecondName();
            $tpl[$metkaName . '_secondNameDigits'] = $one->getSecondNameInDigitsString();
        }
        return $tpl;
    }

    /**
     * @param array $tpl
     */
    private static function fillHtmlIcludes(array &$tpl): void
    {
        $css = file_get_contents(
            __DIR__ . "/../../web/bootstrap-5.0.0-beta1-examples/assets/dist/css/bootstrap.min.css"
        );
        $tpl['bootstrap.min.css'] = "<style>$css</style>";

        $css = file_get_contents(__DIR__ . "/../../web/offcanvas.css");
        $tpl['offcanvas.css'] = "<style>$css</style>";

        $js = file_get_contents(
            __DIR__ . "/../../web/bootstrap-5.0.0-beta1-examples/assets/dist/js/bootstrap.bundle.min.js"
        );
        $tpl['bootstrap.bundle.min.js'] = "<script>$js</script>";

        $js = file_get_contents(__DIR__ . "/../../web/offcanvas.js");
        $tpl['offcanvas.js'] = "<script>$js</script>";
    }

    /**
     * @param $calculatedValue
     * @return string
     */
    private static function convertImgToBase64($calculatedValue): string
    {
        $path = __DIR__ . "/../../data/taro_img/$calculatedValue.jpg";
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    private static function getRandRectColor(): string
    {
        $color = self::rect_colors[array_rand(self::rect_colors)];
        return $color;
    }
}