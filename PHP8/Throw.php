<?php
declare(strict_types = 1);


// 下面代码在PHP7中不合法，在PHP8中合法了
$callable = static fn() => throw new Exception();

$nullableValue = null;

// $value is non-nullable.
try {
    $value = $nullableValue ?? throw new \InvalidArgumentException('111111');
}catch (\Exception $e) {
    var_dump($e->getMessage());
}

