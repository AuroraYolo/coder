<?php
declare(strict_types = 1);

class Nullsafe
{
    public function getAddress()
    {
    }
}

$user = new Nullsafe();

$country = $user?->getAddress()?->country?->iso_code;

 var_dump($country);
