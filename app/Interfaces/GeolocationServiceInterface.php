<?php
namespace App\Interfaces;

interface GeolocationServiceInterface
{
    public function getGeolocation(string $ip);
}
