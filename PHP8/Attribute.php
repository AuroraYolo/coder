<?php
declare(strict_types = 1);
#[Attribute]
class ApplyMiddleware
{
    public array $middlware = [];

    public function __construct(...$middleware)
    {
        $this->middleware = $middleware;
    }

}

#[ApplyMiddleware('auth')]
class MyController
{
    public function index()
    {
    }
}

$reflectionClass = new ReflectionClass(MyController::class);

$attributes = $reflectionClass->getAttributes(ApplyMiddleware::class);

foreach ($attributes as $attribute) {
    $middlewareAttribute = $attribute->newInstance();
    var_dump($middlewareAttribute->middleware);
}
