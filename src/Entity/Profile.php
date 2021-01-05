<?php


namespace Entity;


use DateTimeInterface;

class Profile
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var DateTimeInterface
     */
    private $date;
    /**
     * @var PointDataArray[]
     */
    private $dataArrays;

    /**
     * @var int
     */
    private $taroCardNo = 0;
    /**
     * @var DateTimeInterface|null
     */
    private $sovmestimost_date;

    /**
     * Profile constructor.
     * @param string $name
     * @param DateTimeInterface $date
     * @param PointDataArray ...$dataArrays
     */
    public function __construct(
        string $name,
        DateTimeInterface $date,
        ?DateTimeInterface $sovmestimost_date,
        PointDataArray $dataArrays
    ) {
        $this->name = $name;
        $this->date = $date;
        $this->dataArrays = $dataArrays;
        $this->sovmestimost_date = $sovmestimost_date;
    }

    public function &getPointDataArrayLink()
    {
        return $this->dataArrays;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDate(): string
    {
        return $this->date->format("Y-m-d");
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getSovmestimostDate(): string
    {
        return $this->sovmestimost_date ? $this->sovmestimost_date->format("Y-m-d") : '';
    }
}