<?php
declare(strict_types = 1);

class A
{
    public function method(int $many, string $parameters, $here) : void
    {

    }
}
class B extends A
{
    public function method(...$everything) : void
    {
        var_dump($everything);
    }
}

$b = new B();
$b->method('i can be overwritten!');
