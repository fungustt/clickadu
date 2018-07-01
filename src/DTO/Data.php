<?php
namespace DTO;

class Data
{
    /**
     * @var string
     */
    private $date;

    /**
     * @var float
     */
    private $a;

    /**
     * @var float
     */
    private $b;

    /**
     * @var float
     */
    private $c;

    /**
     * Data constructor.
     * @param string $date
     * @param float $a
     * @param float $b
     * @param float $c
     */
    public function __construct(string $date, float $a, float $b, float $c)
    {
        $this->date = $date;
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return float
     */
    public function getA(): float
    {
        return $this->a;
    }

    /**
     * @return float
     */
    public function getB(): float
    {
        return $this->b;
    }

    /**
     * @return float
     */
    public function getC(): float
    {
        return $this->c;
    }
}