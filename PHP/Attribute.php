<?php
declare(strict_types = 1);

#[Attribute(Attribute::TARGET_ALL)]
class Route
{

    public function __construct(public string $path = '', public string $method = '')
    {
    }
}

class IndexController
{
    #[Route('/index', 'GET')]
    public function index()
    {

    }
}
