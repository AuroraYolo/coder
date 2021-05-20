<?php
declare(strict_types = 1);

class UnionTypes
{
    private int|float $number;

    public function setNumber(int|float $number) : void
    {
        $this->number = $number;
    }

    public function getNumber() : int|float
    {
        return $this->number;
    }
}
$number = new UnionTypes();
$number->setNumber(5);

var_dump($number->getNumber());

$number->setNumber(11.54);

var_dump($number->getNumber());
