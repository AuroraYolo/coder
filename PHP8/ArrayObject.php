<?php

class Test{
    protected $context;
    public function __construct(){
        $this->context = new ArrayObject();
    }
    public function getContext(){
        return $this->context;
    }
}
$class = new Test();
var_dump($class->getContext());
$context = $class->getContext();
$context['class'] = $class::class;
$context->id = 1;

var_dump($class);
var_dump($context->id);
var_dump($context['class']);

/**
 object(ArrayObject)#2 (1) {
  ["storage":"ArrayObject":private]=>
  array(0) {
  }
}
object(Test)#1 (1) {
  ["context":protected]=>
  object(ArrayObject)#2 (2) {
    ["id"]=>
    int(1)
    ["storage":"ArrayObject":private]=>
    array(1) {
      ["class"]=>
      string(4) "Test"
    }
  }
}
int(1)
string(4) "Test"
 */