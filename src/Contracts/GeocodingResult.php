<?php

namespace Tukadyane\Contracts;

interface GeocodingResult
{
    public function getLatitude(): float;
    public function getLongitude(): float;
    public function getAddress(): string;
} 