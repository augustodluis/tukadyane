<?php

namespace Tukadyane\Contracts;

interface GeocoderInterface
{
    public function geocode(string $address): GeocodingResult;
    public function reverse(float $latitude, float $longitude): GeocodingResult;
} 