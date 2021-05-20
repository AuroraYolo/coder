<?php
declare(strict_types = 1);


class Foo {
    public function __toString() {
        return 'I am a class';
    }
}

$obj = new Foo;
var_dump($obj instanceof Stringable);
echo $obj;
