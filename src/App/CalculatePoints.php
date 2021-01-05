<?php


namespace App;


use Entity\Interfaces\iCalculatePoints;
use Entity\Interfaces\iCalculator;
use Entity\PointData;
use Entity\PointDataArray;
use Entity\Profile;

class CalculatePoints implements iCalculatePoints
{
    /**
     * @var \DateTimeInterface
     */
    private $date;
    /**
     * @var string
     */
    private $name;
    /**
     * @var iCalculator
     */
    private $calculator;
    /**
     * @var array
     */
    private $second_name;
    /**
     * @var \DateTimeInterface|null
     */
    private $sovmestimist_date;

    /**
     * CalculatePoints constructor.
     * @param \DateTimeInterface $date
     * @param string $name
     * @param iCalculator $calculator
     */
    public function __construct(
        \DateTimeInterface $date,
        ?\DateTimeInterface $sovmestimist_date,
        string $name,
        array $second_name,
        iCalculator $calculator
    ) {
        $this->date = $date;
        $this->name = $name;
        $this->calculator = $calculator;
        $this->second_name = $second_name;
        $this->sovmestimist_date = $sovmestimist_date;
    }

    public function getProfile(): Profile
    {
        $birthDay = $this->date->format('d');
        $birthMonth = $this->date->format('m');
        $birthYear = $this->date->format('Y');


        # пункт 1. Базовая энергия. Предназначение = Дата рождения
        $arr['P1_bazovayaEnergiya_plus'] = new PointData();
        $arr['P1_bazovayaEnergiya_plus']->setInternalName('P1_bazovayaEnergiya_plus');
        $arr['P1_bazovayaEnergiya_plus']->setCalculatedValue($this->calculator->calcArcan22Summ($birthDay));

        # пункт 1.1

        $arr['P1_bazovayaEnergiya_minus'] = new PointData();
        $arr['P1_bazovayaEnergiya_minus']->setInternalName('P1_bazovayaEnergiya_minus');
        $arr['P1_bazovayaEnergiya_minus']->setCalculatedValue($this->calculator->calcArcan22Summ($birthDay));

        # пункт 1.3
        $arr['P1_to4kaVhodaVDenejniyPotok'] = new PointData();
        $arr['P1_to4kaVhodaVDenejniyPotok']->setInternalName('P1_to4kaVhodaVDenejniyPotok');
        $arr['P1_to4kaVhodaVDenejniyPotok']->setCalculatedValue($this->calculator->calcArcanYearReductialy($birthYear));

        # punkt 1.4 ресурсные действия
        $arr['P1_resursnieDeystviya'] = new PointData();
        $arr['P1_resursnieDeystviya']->setInternalName('P1_resursnieDeystviya');
        $arr['P1_resursnieDeystviya']->setCalculatedValue($this->calculator->calcArcan22Summ($birthDay));

        # punkt 1.4 ресурсные действия
        $arr['P1_molitviNaProrabotku'] = new PointData();
        $arr['P1_molitviNaProrabotku']->setInternalName('P1_molitviNaProrabotku');
        $arr['P1_molitviNaProrabotku']->setCalculatedValue($this->calculator->calcArcan22Summ($birthDay));

        # punkt 1.5 Предназначение
        $arr['P1_prednazna4eniye'] = new PointData();
        $arr['P1_prednazna4eniye']->setInternalName('P1_prednazna4eniye');
        $arr['P1_prednazna4eniye']->setCalculatedValue($this->calculator->calcArcan22Summ($birthDay));

        # punkt 1.6 Профессии и сферы деятельности
        $arr['P1_professiiSferiDeyatelnosti'] = new PointData();
        $arr['P1_professiiSferiDeyatelnosti']->setInternalName('P1_professiiSferiDeyatelnosti');
        $arr['P1_professiiSferiDeyatelnosti']->setCalculatedValue($this->calculator->calcArcan22Summ($birthDay));


        #########
        # пункт 2 Урок жизни, карма рода = Месяц рождения
        $arr['P2_urokJizni'] = new PointData();
        $arr['P2_urokJizni']->setInternalName('P2_urokJizni');
        $arr['P2_urokJizni']->setCalculatedValue($birthMonth);
        # пункт 2.1
        $arr['P2_KarmaRoda'] = new PointData();
        $arr['P2_KarmaRoda']->setInternalName('P2_KarmaRoda');
        $arr['P2_KarmaRoda']->setCalculatedValue($birthMonth);

        #########
        # пункт 3 Энергия экзаменатор = Год рождения (сумма всех цифр)
        $arr['P3_energiyaEkzamenator'] = new PointData();
        $arr['P3_energiyaEkzamenator']->setInternalName('P3_energiyaEkzamenator');
        $arr['P3_energiyaEkzamenator']->setCalculatedValue($this->calculator->calcArcanYearReductialy($birthYear));

        #########
        # пункт 4 Страхи, комплексы, ТЕНЬ = п. 1 + п. 2 (смотрим негативное проявление аркана – минусы).
        $arr['P4_strahiKompleksiTen'] = new PointData();
        $arr['P4_strahiKompleksiTen']->setInternalName('P4_strahiKompleksiTen');
        $arr['P4_strahiKompleksiTen']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P1_bazovayaEnergiya_minus']->getCalculatedValue(),
                $arr['P2_urokJizni']->getCalculatedValue()
            )
        );

        #########
        # пункт 5 Социальная роль, восприятие себя, маска и лучшее платье/костюм = п. 2 + п. 3
        $arr['P5_socialnayaRol'] = new PointData();
        $arr['P5_socialnayaRol']->setInternalName('P5_socialnayaRol');
        $arr['P5_socialnayaRol']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P2_urokJizni']->getCalculatedValue(),
                $arr['P3_energiyaEkzamenator']->getCalculatedValue()
            )
        );

        #########
        # пункт 6 Таланты, дарования = п. 4 + п. 5
        $arr['P6_talantiDarovaniya'] = new PointData();
        $arr['P6_talantiDarovaniya']->setInternalName('P6_talantiDarovaniya');
        $arr['P6_talantiDarovaniya']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P4_strahiKompleksiTen']->getCalculatedValue(),
                $arr['P5_socialnayaRol']->getCalculatedValue()
            )
        );

        #########
        # пункт 7 Миссия = п. 1 + п. 5
        $arr['P7_missiya'] = new PointData();
        $arr['P7_missiya']->setInternalName('P7_missiya');
        $arr['P7_missiya']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P1_bazovayaEnergiya_minus']->getCalculatedValue(),
                $arr['P5_socialnayaRol']->getCalculatedValue()
            )
        );

        #########
        # пункт 8 Ангельская помощь = п. 2 + п. 6
        $arr['P8_angelskayaPomosh'] = new PointData();
        $arr['P8_angelskayaPomosh']->setInternalName('P8_angelskayaPomosh');
        $arr['P8_angelskayaPomosh']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P2_urokJizni']->getCalculatedValue(),
                $arr['P6_talantiDarovaniya']->getCalculatedValue()
            )
        );


        #########
        # пункт 8 Ангельская помощь = п. 2 + п. 6
        $arr['P8_angelskayaPomosh'] = new PointData();
        $arr['P8_angelskayaPomosh']->setInternalName('P8_angelskayaPomosh');
        $arr['P8_angelskayaPomosh']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P2_urokJizni']->getCalculatedValue(),
                $arr['P6_talantiDarovaniya']->getCalculatedValue()
            )
        );

        ######### кармический портрет
        # пункт 9 Кем был. п1-п2
        $arr['P9_kemBil'] = new PointData();
        $arr['P9_kemBil']->setInternalName('P9_kemBil');
        $arr['P9_kemBil']->setCalculatedValue(
            $this->calculator->calcArcan22Minus(
                $arr['P1_bazovayaEnergiya_plus']->getCalculatedValue(),
                $arr['P2_urokJizni']->getCalculatedValue()
            )
        );

        # пункт 10 что делал П2 – П3
        $arr['P10_4toDelal'] = new PointData();
        $arr['P10_4toDelal']->setInternalName('P10_4toDelal');
        $arr['P10_4toDelal']->setCalculatedValue(
            $this->calculator->calcArcan22Minus(
                $arr['P2_urokJizni']->getCalculatedValue(),
                $arr['P3_energiyaEkzamenator']->getCalculatedValue()
            )
        );

        # пункт 11 Кармическая задача 1, П9 – П10
        $arr['P11_kz1'] = new PointData();
        $arr['P11_kz1']->setInternalName('P11_kz1');
        $arr['P11_kz1']->setCalculatedValue(
            $this->calculator->calcArcan22Minus(
                $arr['P9_kemBil']->getCalculatedValue(),
                $arr['P10_4toDelal']->getCalculatedValue()
            )
        );

        # пункт 12 Кармическая задача 2. П9 + П10 + П11
        $arr['P12_kz2'] = new PointData();
        $arr['P12_kz2']->setInternalName('P12_kz2');
        $arr['P12_kz2']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P9_kemBil']->getCalculatedValue(),
                $arr['P10_4toDelal']->getCalculatedValue(),
                $arr['P11_kz1']->getCalculatedValue()
            )
        );

        # пункт 13 Кармическая задача 3. (П9 + П10 + П11) – П7
        $arr['P13_kz3'] = new PointData();
        $arr['P13_kz3']->setInternalName('P13_kz3');
        $arr['P13_kz3']->setCalculatedValue(
            $this->calculator->calcArcan22Minus(
                $arr['P12_kz2']->getCalculatedValue(),
                $arr['P7_missiya']->getCalculatedValue()
            )
        );

        # пункт 14 Позиция H. (П1 + П4 - 22 если надо) + (П4 + П6 - 22 если надо), смотрим минус базовой эрергии
        $arr['P14_poziciyaH'] = new PointData();
        $arr['P14_poziciyaH']->setInternalName('P14_poziciyaH');
        $arr['P14_poziciyaH']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P1_bazovayaEnergiya_plus']->getCalculatedValue(),
                $arr['P4_strahiKompleksiTen']->getCalculatedValue(),
                $arr['P4_strahiKompleksiTen']->getCalculatedValue(),
                $arr['P6_talantiDarovaniya']->getCalculatedValue()
            )
        );

        # пункт 14.1 Позиция H. Смотрим пункт 10  по рассчитанному в этом пункте аркану из файла кармы.
        $arr['P14_poziciyaH10'] = new PointData();
        $arr['P14_poziciyaH10']->setInternalName('P14_poziciyaH10');
        $arr['P14_poziciyaH10']->setCalculatedValue(
            $arr['P14_poziciyaH']->getCalculatedValue()
        );

        #########
        # пункт 90 Зона комфорта/дискомфорта = п. 7 + п. 8, четное число
        $arr['P90_zonaKomforta'] = new PointData();
        $arr['P90_zonaKomforta']->setInternalName('P90_zonaKomforta');
        $arr['P90_zonaKomforta']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P7_missiya']->getCalculatedValue(),
                $arr['P8_angelskayaPomosh']->getCalculatedValue()
            )
        );

        # пункт 90.1 зона дискомфорта
        $arr['P90_zonaDiskomforta'] = new PointData();
        $arr['P90_zonaDiskomforta']->setInternalName('P90_zonaDiskomforta');
        $arr['P90_zonaDiskomforta']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P7_missiya']->getCalculatedValue(),
                $arr['P8_angelskayaPomosh']->getCalculatedValue()
            )
        );

        #########
        # пункт 100 Родовая принадлежность
        # перебираем от 0 до 2 фамилии, т.е. 3 максимум, P100_rodovayaPrinadlejnost_1, P100_rodovayaPrinadlejnost_2 и P100_rodovayaPrinadlejnost_3
        for ($i = 0; $i < 3; $i++) {
            $key_name_numered = "P100_rodovayaPrinadlejnost_$i";
            $key_name = "P100_rodovayaPrinadlejnost";
            $arr[$key_name_numered] = new PointData();
            $arr[$key_name_numered]->setInternalName($key_name);
            $arr[$key_name_numered]->setMetkaName($key_name_numered);

            # если фамилия передана, то рассчитываем, если нет, ставим флаг, что нужно спрятать
            if ($second_name = $this->second_name[$i] ?? null) {
                $arr[$key_name_numered]->setCalculatedValue(
                    $this->calculator->calcSecondNameArkan($second_name)
                );
                $arr[$key_name_numered]->setSecondName(
                    $second_name
                );
                $arr[$key_name_numered]->setSecondNameInDigitsString(
                    $this->calculator->calcSecondNameInDigitsString($second_name)
                );
            } else {
                $arr[$key_name_numered]->setHide();
            }
        }

        #########
        # пункт 110.1 выбор партнера, для женщины
        $arr['P110_viborpartnera_jenshina'] = new PointData();
        $arr['P110_viborpartnera_jenshina']->setInternalName('P110_viborpartnera_jenshina');
        $arr['P110_viborpartnera_jenshina']->setCalculatedValue(
            $this->calculator->calcArcan22Minus(
                22,
                $arr['P5_socialnayaRol']->getCalculatedValue()
            )
        );

        # пункт 110.2 выбор партнера, для мужчины
        $arr['P110_viborpartnera_muj4ina'] = new PointData();
        $arr['P110_viborpartnera_muj4ina']->setInternalName('P110_viborpartnera_muj4ina');
        $arr['P110_viborpartnera_muj4ina']->setCalculatedValue(
            $this->calculator->calcArcan22Minus(
                22,
                $arr['P4_strahiKompleksiTen']->getCalculatedValue()
            )
        );

        #########
        # пункт 120.1  теневой портрет.
        # проявление матери
        $arr['P120_ten_proyavlenieMateri'] = new PointData();
        $arr['P120_ten_proyavlenieMateri']->setInternalName('P120_ten_proyavlenieMateri');
        $arr['P120_ten_proyavlenieMateri']->setCalculatedValue(
            $birthMonth
        );

        # пункт 120.2  теневой портрет.
        # Позиция A – энергия, которая очень мощно влияет на человека и идет из подсознания (не
        # обусловленное сознательно желание делать что-либо), здесь п. 4 будет иметь сильное влияние.
        # A = п. 1 + п.4
        $arr['P120_ten_A'] = new PointData();
        $arr['P120_ten_A']->setInternalName('P120_ten_A');
        $arr['P120_ten_A']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P1_bazovayaEnergiya_plus']->getCalculatedValue(),
                $arr['P4_strahiKompleksiTen']->getCalculatedValue()
            )
        );

        # пункт 120.3  теневой портрет.
        # Позиция В – энергия, которая будет создавать определенные ситуации, эти ситуации будут сопровождать человека на протяжении всей жизни, только на разных уровнях, идеальный
        # сценарный шаблон для работы над собой (п. 4 имеет ключевое значение и уточняет, почему мы проходим одни и те же ситуации).
        # B = п. 2 + п. 4
        $arr['P120_ten_B'] = new PointData();
        $arr['P120_ten_B']->setInternalName('P120_ten_B');
        $arr['P120_ten_B']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P2_urokJizni']->getCalculatedValue(),
                $arr['P4_strahiKompleksiTen']->getCalculatedValue()
            )
        );

        # пункт 120.4  теневой портрет.
        # Позиция С – энергия очень важная для человека, приоритет, хотя и неосознанный.
        # C = п. 2 + п. 5
        $arr['P120_ten_C'] = new PointData();
        $arr['P120_ten_C']->setInternalName('P120_ten_C');
        $arr['P120_ten_C']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P2_urokJizni']->getCalculatedValue(),
                $arr['P5_socialnayaRol']->getCalculatedValue()
            )
        );

        # пункт 120.5  теневой портрет.
        # Позиция D – энергия, которая мощно влияет на сознание человека из внешнего мира, социума,
        # через что вы добиваетесь внимания, признания и уважения окружающих. Как вас воспринимают и видят окружающие люди.
        # D = п. 3 + п. 5
        $arr['P120_ten_D'] = new PointData();
        $arr['P120_ten_D']->setInternalName('P120_ten_D');
        $arr['P120_ten_D']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P3_energiyaEkzamenator']->getCalculatedValue(),
                $arr['P5_socialnayaRol']->getCalculatedValue()
            )
        );
        # психосоматика, считается так же
        $arr['P120_ten_D_psihosomatika'] = new PointData();
        $arr['P120_ten_D_psihosomatika']->setInternalName('P120_ten_D_psihosomatika');
        $arr['P120_ten_D_psihosomatika']->setCalculatedValue(
            $arr['P120_ten_D']->getCalculatedValue()
        );

        # пункт 120.6  теневой портрет.
        # Позиция Е – талант, что человек делает отлично, но не осознает этого. Профессия, наработанная в прошлых воплощениях (п. 4 имеет + значение).
        # E = п. 4 + п. 6
        $arr['P120_ten_E'] = new PointData();
        $arr['P120_ten_E']->setInternalName('P120_ten_E');
        $arr['P120_ten_E']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P4_strahiKompleksiTen']->getCalculatedValue(),
                $arr['P6_talantiDarovaniya']->getCalculatedValue()
            )
        );

        # пункт 120.7  теневой портрет.
        # Позиция F – чистый теневой аспект, энергия, которую человек отвергает, отрицает, избегает, отталкивает. Эта энергия будет проявляться в жизни человека по +, но человек ее отрицает и даже не замечает этого. Трансперсональная позиция.
        # F = п. 5 + п. 6
        $arr['P120_ten_F'] = new PointData();
        $arr['P120_ten_F']->setInternalName('P120_ten_F');
        $arr['P120_ten_F']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P5_socialnayaRol']->getCalculatedValue(),
                $arr['P6_talantiDarovaniya']->getCalculatedValue()
            )
        );

        # пункт 120.8  теневой портрет.
        # Позиция Н – деструктивная энергия, то, в чем мы проявляем свой разрушительный аспект, ошибаемся, создаем внутренние и внешние конфликты. Здесь учитываются п. 4 и п. 12.
        # H = A + E
        $arr['P120_ten_H'] = new PointData();
        $arr['P120_ten_H']->setInternalName('P120_ten_H');
        $arr['P120_ten_H']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P120_ten_A']->getCalculatedValue(),
                $arr['P120_ten_E']->getCalculatedValue()
            )
        );

        # пункт 120.9  теневой портрет.
        # Позиция G1 – максимум, который человек может достичь, используя потенциал сознания D и приоритеты С.
        # G1 = C + D
        $arr['P120_ten_G1'] = new PointData();
        $arr['P120_ten_G1']->setInternalName('P120_ten_G1');
        $arr['P120_ten_G1']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P120_ten_C']->getCalculatedValue(),
                $arr['P120_ten_D']->getCalculatedValue()
            )
        );


        # пункт 120.10  теневой портрет.
        # Позиция G2 – что поможет достичь этого максимума, эта позиция всегда совпадает с Пр. II, т.е. в период с 20 до 40 лет мы можем при условии проработки этой энергии по + достичь максимума.
        # G2 = B + F
        $arr['P120_ten_G2'] = new PointData();
        $arr['P120_ten_G2']->setInternalName('P120_ten_G2');
        $arr['P120_ten_G2']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P120_ten_B']->getCalculatedValue(),
                $arr['P120_ten_F']->getCalculatedValue()
            )
        );


        # Позиция I – энергия-стимул, мотивация к самореализации, «волшебный пендель», используем как совет.
        # I = G1 + G2
        $arr['P120_ten_I'] = new PointData();
        $arr['P120_ten_I']->setInternalName('P120_ten_I');
        $arr['P120_ten_I']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P120_ten_G1']->getCalculatedValue(),
                $arr['P120_ten_G2']->getCalculatedValue()
            )
        );


        // проработка осуществляется через ресурсные действия, через молитву, девиз
        // показывает, какие способности хочет развивать душа
        # пункт 120.12  теневой портрет.
        #  Пр.1 = п.1 + п.4 + п.6 = (До 35 лет)
        $arr['P120_ten_PR1'] = new PointData();
        $arr['P120_ten_PR1']->setInternalName('P120_ten_PR1');
        $arr['P120_ten_PR1']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P1_bazovayaEnergiya_plus']->getCalculatedValue(),
                $arr['P4_strahiKompleksiTen']->getCalculatedValue(),
                $arr['P6_talantiDarovaniya']->getCalculatedValue()
            )
        );

        # пункт 120.13  теневой портрет.
        #  Пр.2 = п.6 + п.8  =  (Средний возраст – от 35 до 60 лет)
        $arr['P120_ten_PR2'] = new PointData();
        $arr['P120_ten_PR2']->setInternalName('P120_ten_PR2');
        $arr['P120_ten_PR2']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P6_talantiDarovaniya']->getCalculatedValue(),
                $arr['P8_angelskayaPomosh']->getCalculatedValue()
            )
        );

        # пункт 120.14  теневой портрет.
        #  Пр.3 = п.3 + п.5 + п.6 = (чему нужно учиться)
        $arr['P120_ten_PR3'] = new PointData();
        $arr['P120_ten_PR3']->setInternalName('P120_ten_PR3');
        $arr['P120_ten_PR3']->setCalculatedValue(
            $this->calculator->calcArcan22Summ(
                $arr['P3_energiyaEkzamenator']->getCalculatedValue(),
                $arr['P5_socialnayaRol']->getCalculatedValue(),
                $arr['P6_talantiDarovaniya']->getCalculatedValue()
            )
        );


        ######### совместимость
        ###### пункт 130.1  совместимость объект который отвечает за скрыть/показать
        $arr['P130_sovmestimost_show'] = new PointData();
        $arr['P130_sovmestimost_show']->setInternalName('P130_sovmestimost_show');

        # если дата партнера не задано, то прячем этот блок
        if (null === $this->sovmestimist_date) {
            $arr['P130_sovmestimost_show']->setHide();
        } else {
            # дата партнера есть, начинаем расчет
            # задачем удобно параметры дат для расчета
            $Y1 = $this->calculator->calcArcanYearReductialy($birthYear);
            $M1 = $birthMonth;
            $D1 = $birthDay;

            $Y2 = $this->calculator->calcArcanYearReductialy($this->sovmestimist_date->format('Y'));
            $M2 = $this->sovmestimist_date->format('m');
            $D2 = $this->sovmestimist_date->format('d');

            ## Социальные задачи
            # социальная задача 1
            # С1 = Г1 + Д2
            $arr['P130_sovmestimost_C1'] = new PointData();
            $arr['P130_sovmestimost_C1']->setInternalName('P130_sovmestimost_C');
            $arr['P130_sovmestimost_C1']->setMetkaName('P130_sovmestimost_C1');
            $arr['P130_sovmestimost_C1']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $Y1,
                    $D2
                )
            );

            # социальная задача 2
            # C2 = Г1 + Г2
            $arr['P130_sovmestimost_C2'] = new PointData();
            $arr['P130_sovmestimost_C2']->setInternalName('P130_sovmestimost_C');
            $arr['P130_sovmestimost_C2']->setMetkaName('P130_sovmestimost_C2');
            $arr['P130_sovmestimost_C2']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $Y1,
                    $Y2
                )
            );

            # социальная задача 3
            # C3 = Д1 + Г2
            $arr['P130_sovmestimost_C3'] = new PointData();
            $arr['P130_sovmestimost_C3']->setInternalName('P130_sovmestimost_C');
            $arr['P130_sovmestimost_C3']->setMetkaName('P130_sovmestimost_C3');
            $arr['P130_sovmestimost_C3']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $D1,
                    $Y2
                )
            );

            # социальная задача 4
            # C4 = Д1 + М2
            $arr['P130_sovmestimost_C4'] = new PointData();
            $arr['P130_sovmestimost_C4']->setInternalName('P130_sovmestimost_C');
            $arr['P130_sovmestimost_C4']->setMetkaName('P130_sovmestimost_C4');
            $arr['P130_sovmestimost_C4']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $D1,
                    $M2
                )
            );

            # социальная задача 5
            # C5 = M1 + М2
            $arr['P130_sovmestimost_C5'] = new PointData();
            $arr['P130_sovmestimost_C5']->setInternalName('P130_sovmestimost_C');
            $arr['P130_sovmestimost_C5']->setMetkaName('P130_sovmestimost_C5');
            $arr['P130_sovmestimost_C5']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $M1,
                    $M2
                )
            );

            # социальная задача 6
            # C6 = М1 + Д2
            $arr['P130_sovmestimost_C6'] = new PointData();
            $arr['P130_sovmestimost_C6']->setInternalName('P130_sovmestimost_C');
            $arr['P130_sovmestimost_C6']->setMetkaName('P130_sovmestimost_C6');
            $arr['P130_sovmestimost_C6']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $M1,
                    $D2
                )
            );

            # социальная задача общая
            # Cобщ = С(1 + 2 +3 +4 +5 +6)
            $arr['P130_sovmestimost_C_obshaya'] = new PointData();
            $arr['P130_sovmestimost_C_obshaya']->setInternalName('P130_sovmestimost_C');
            $arr['P130_sovmestimost_C_obshaya']->setMetkaName('P130_sovmestimost_C_obshaya');
            $arr['P130_sovmestimost_C_obshaya']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $arr['P130_sovmestimost_C1']->getCalculatedValue(),
                    $arr['P130_sovmestimost_C2']->getCalculatedValue(),
                    $arr['P130_sovmestimost_C3']->getCalculatedValue(),
                    $arr['P130_sovmestimost_C4']->getCalculatedValue(),
                    $arr['P130_sovmestimost_C5']->getCalculatedValue(),
                    $arr['P130_sovmestimost_C6']->getCalculatedValue()
                )
            );

            ## Конфликты
            # конфликты 1
            # K1 = C6 + D2 + C1
            $arr['P130_sovmestimost_K1'] = new PointData();
            $arr['P130_sovmestimost_K1']->setInternalName('P130_sovmestimost_K');
            $arr['P130_sovmestimost_K1']->setMetkaName('P130_sovmestimost_K1');
            $arr['P130_sovmestimost_K1']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $D2,
                    $arr['P130_sovmestimost_C1']->getCalculatedValue(),
                    $arr['P130_sovmestimost_C6']->getCalculatedValue()
                )
            );

            # K2 = C1 + Y1 + C2
            $arr['P130_sovmestimost_K2'] = new PointData();
            $arr['P130_sovmestimost_K2']->setInternalName('P130_sovmestimost_K');
            $arr['P130_sovmestimost_K2']->setMetkaName('P130_sovmestimost_K2');
            $arr['P130_sovmestimost_K2']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $Y1,
                    $arr['P130_sovmestimost_C1']->getCalculatedValue(),
                    $arr['P130_sovmestimost_C2']->getCalculatedValue()
                )
            );

            # K3 = C2 + Y2 + C3
            $arr['P130_sovmestimost_K3'] = new PointData();
            $arr['P130_sovmestimost_K3']->setInternalName('P130_sovmestimost_K');
            $arr['P130_sovmestimost_K3']->setMetkaName('P130_sovmestimost_K3');
            $arr['P130_sovmestimost_K3']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $Y2,
                    $arr['P130_sovmestimost_C2']->getCalculatedValue(),
                    $arr['P130_sovmestimost_C3']->getCalculatedValue()
                )
            );

            # K4 = C3 + D1 + C4
            $arr['P130_sovmestimost_K4'] = new PointData();
            $arr['P130_sovmestimost_K4']->setInternalName('P130_sovmestimost_K');
            $arr['P130_sovmestimost_K4']->setMetkaName('P130_sovmestimost_K4');
            $arr['P130_sovmestimost_K4']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $D1,
                    $arr['P130_sovmestimost_C3']->getCalculatedValue(),
                    $arr['P130_sovmestimost_C4']->getCalculatedValue()
                )
            );

            # K5 = C4 + M2 + C5
            $arr['P130_sovmestimost_K5'] = new PointData();
            $arr['P130_sovmestimost_K5']->setInternalName('P130_sovmestimost_K');
            $arr['P130_sovmestimost_K5']->setMetkaName('P130_sovmestimost_K5');
            $arr['P130_sovmestimost_K5']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $M2,
                    $arr['P130_sovmestimost_C4']->getCalculatedValue(),
                    $arr['P130_sovmestimost_C5']->getCalculatedValue()
                )
            );

            # K6 = C5 + M1 + C6
            $arr['P130_sovmestimost_K6'] = new PointData();
            $arr['P130_sovmestimost_K6']->setInternalName('P130_sovmestimost_K');
            $arr['P130_sovmestimost_K6']->setMetkaName('P130_sovmestimost_K6');
            $arr['P130_sovmestimost_K6']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $M1,
                    $arr['P130_sovmestimost_C5']->getCalculatedValue(),
                    $arr['P130_sovmestimost_C6']->getCalculatedValue()
                )
            );

            # конфликты общее
            # Kобщ = K(1 + 2 +3 +4 +5 +6)
            $arr['P130_sovmestimost_K_obshaya'] = new PointData();
            $arr['P130_sovmestimost_K_obshaya']->setInternalName('P130_sovmestimost_K');
            $arr['P130_sovmestimost_K_obshaya']->setMetkaName('P130_sovmestimost_K_obshaya');
            $arr['P130_sovmestimost_K_obshaya']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $arr['P130_sovmestimost_K1']->getCalculatedValue(),
                    $arr['P130_sovmestimost_K2']->getCalculatedValue(),
                    $arr['P130_sovmestimost_K3']->getCalculatedValue(),
                    $arr['P130_sovmestimost_K4']->getCalculatedValue(),
                    $arr['P130_sovmestimost_K5']->getCalculatedValue(),
                    $arr['P130_sovmestimost_K6']->getCalculatedValue()
                )
            );


            ## ресурсные действия
            # R1 = D2 + C1 + Y1
            $arr['P130_sovmestimost_R1'] = new PointData();
            $arr['P130_sovmestimost_R1']->setInternalName('P130_sovmestimost_R');
            $arr['P130_sovmestimost_R1']->setMetkaName('P130_sovmestimost_R1');
            $arr['P130_sovmestimost_R1']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $D2,
                    $Y1,
                    $arr['P130_sovmestimost_C1']->getCalculatedValue()
                )
            );

            # R2 = Y1 + C2 + Y2
            $arr['P130_sovmestimost_R2'] = new PointData();
            $arr['P130_sovmestimost_R2']->setInternalName('P130_sovmestimost_R');
            $arr['P130_sovmestimost_R2']->setMetkaName('P130_sovmestimost_R2');
            $arr['P130_sovmestimost_R2']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $Y1,
                    $Y2,
                    $arr['P130_sovmestimost_C2']->getCalculatedValue()
                )
            );

            # R3 = Y2 + C3 + D1
            $arr['P130_sovmestimost_R3'] = new PointData();
            $arr['P130_sovmestimost_R3']->setInternalName('P130_sovmestimost_R');
            $arr['P130_sovmestimost_R3']->setMetkaName('P130_sovmestimost_R3');
            $arr['P130_sovmestimost_R3']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $Y2,
                    $D1,
                    $arr['P130_sovmestimost_C3']->getCalculatedValue()
                )
            );

            # R4 = D1 + C4 + M2
            $arr['P130_sovmestimost_R4'] = new PointData();
            $arr['P130_sovmestimost_R4']->setInternalName('P130_sovmestimost_R');
            $arr['P130_sovmestimost_R4']->setMetkaName('P130_sovmestimost_R4');
            $arr['P130_sovmestimost_R4']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $D1,
                    $M2,
                    $arr['P130_sovmestimost_C4']->getCalculatedValue()
                )
            );

            # R5 = M2 + C5 + M1
            $arr['P130_sovmestimost_R5'] = new PointData();
            $arr['P130_sovmestimost_R5']->setInternalName('P130_sovmestimost_R');
            $arr['P130_sovmestimost_R5']->setMetkaName('P130_sovmestimost_R5');
            $arr['P130_sovmestimost_R5']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $M2,
                    $M1,
                    $arr['P130_sovmestimost_C5']->getCalculatedValue()
                )
            );

            # R6 = M1 + C6 + D2
            $arr['P130_sovmestimost_R6'] = new PointData();
            $arr['P130_sovmestimost_R6']->setInternalName('P130_sovmestimost_R');
            $arr['P130_sovmestimost_R6']->setMetkaName('P130_sovmestimost_R6');
            $arr['P130_sovmestimost_R6']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $M1,
                    $D2,
                    $arr['P130_sovmestimost_C6']->getCalculatedValue()
                )
            );

            # ресурсные действия общее
            # Rобщ = R(1 + 2 +3 +4 +5 +6)
            $arr['P130_sovmestimost_R_obshaya'] = new PointData();
            $arr['P130_sovmestimost_R_obshaya']->setInternalName('P130_sovmestimost_R');
            $arr['P130_sovmestimost_R_obshaya']->setMetkaName('P130_sovmestimost_R_obshaya');
            $arr['P130_sovmestimost_R_obshaya']->setCalculatedValue(
                $this->calculator->calcArcan22Summ(
                    $arr['P130_sovmestimost_R1']->getCalculatedValue(),
                    $arr['P130_sovmestimost_R2']->getCalculatedValue(),
                    $arr['P130_sovmestimost_R3']->getCalculatedValue(),
                    $arr['P130_sovmestimost_R4']->getCalculatedValue(),
                    $arr['P130_sovmestimost_R5']->getCalculatedValue(),
                    $arr['P130_sovmestimost_R6']->getCalculatedValue()
                )
            );
        }


//        die;
//        print_r($arr);
//        die;

        # создаем профайл
        $profile = new Profile(
            $this->name,
            $this->date,
            $this->sovmestimist_date,
            new PointDataArray(... array_values($arr))
        );
        return $profile;
    }
}