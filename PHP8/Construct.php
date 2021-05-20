<?php
declare(strict_types = 1);

class Construct
{
    public function __construct(
        public int $a,
        public int $b,
    ) {

    }
}
$user = new Construct(1, 2);

var_dump($user->a);
var_dump($user->b);
