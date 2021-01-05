<?php


namespace  Entity;


class PointDataArray implements \Iterator
{
    /**
     * @var PointData[]
     */
    private $dataArray;
    private $key = 0;

    /**
     * PointDataArray constructor.
     * @param PointData ... $dataArray
     */
    public function __construct(PointData ... $dataArray)
    {
        $this->dataArray = $dataArray;
    }


    public function current(): PointData
    {
        return $this->dataArray[$this->key()];
    }

    public function next()
    {
        ++$this->key;
    }

    public function key(): int
    {
        return $this->key;
    }

    public function valid()
    {
        return isset($this->dataArray[$this->key()]);
    }

    public function rewind()
    {
        $this->key = 0;
    }

    public function addData(PointData $data)
    {
        $this->dataArray[] = $data;
        $this->key++;
    }
}