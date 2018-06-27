<?php
namespace DTO;

class Data
{
    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $a;

    /**
     * @var string
     */
    private $b;

    /**
     * @var string
     */
    private $c;

    /**
     * Data constructor.
     * @param string $date
     * @param string $a
     * @param string $b
     * @param string $c
     */
    public function __construct(string $date, string $a, string $b, string $c)
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
     * @return string
     */
    public function getA(): string
    {
        return $this->a;
    }

    /**
     * @return string
     */
    public function getB(): string
    {
        return $this->b;
    }

    /**
     * @return string
     */
    public function getC(): string
    {
        return $this->c;
    }
}