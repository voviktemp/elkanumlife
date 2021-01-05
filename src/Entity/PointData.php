<?php


namespace  Entity;


class PointData
{

    private $showName = '';
    private $internalName = '';
    private $data = '';
    private $calculatedValue = 0;
    private $secondNameInDigitsString = '';
    private $secondName = '';
    private $hide = false;
    private $metkaName = null;

    /**
     * @return string
     */
    public function getSecondNameInDigitsString(): string
    {
        return $this->secondNameInDigitsString;
    }

    /**
     * @param string $secondNameInDigitsString
     */
    public function setSecondNameInDigitsString(string $secondNameInDigitsString): void
    {
        $this->secondNameInDigitsString = $secondNameInDigitsString;
    }

    /**
     * @return string
     */
    public function getSecondName(): string
    {
        return $this->secondName;
    }

    /**
     * @param string $secondName
     */
    public function setSecondName(string $secondName): void
    {
        $this->secondName = $secondName;
    }


    /**
     * @return string
     */
    public function getShowName(): string
    {
        return $this->showName;
    }

    /**
     * @param string $showName
     */
    public function setShowName(string $showName): void
    {
        $this->showName = $showName;
    }

    /**
     * @return string
     */
    public function getInternalName(): string
    {
        return $this->internalName;
    }

    /**
     * @param string $internalName
     */
    public function setInternalName(string $internalName): void
    {
        $this->internalName = $internalName;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getCalculatedValue(): int
    {
        return $this->calculatedValue;
    }

    /**
     * @param int $calculatedValue
     */
    public function setCalculatedValue(int $calculatedValue): void
    {
        $this->calculatedValue = $calculatedValue;
    }

    /**
     * @return bool
     */
    public function isHide(): bool
    {
        return $this->hide;
    }

    /**
     * @param bool $hide
     */
    public function setHide(): void
    {
        $this->hide = true;
    }

    /**
     * @return string
     */
    public function getMetkaName(): string
    {
        return $this->metkaName ?? $this->getInternalName();
    }

    /**
     * @param string $metkaName
     */
    public function setMetkaName(string $metkaName): void
    {
        $this->metkaName = $metkaName;
    }

}