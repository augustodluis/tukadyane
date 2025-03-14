<?php

namespace Tukadyane\Models;

use Geocoder\Location;
use Tukadyane\Contracts\GeocodingResult;

class GeocodingResultAdapter implements GeocodingResult
{
    private Location $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function getLatitude(): float
    {
        return $this->location->getCoordinates()->getLatitude();
    }

    public function getLongitude(): float
    {
        return $this->location->getCoordinates()->getLongitude();
    }

    public function getAddress(): string
    {
        return implode(', ', array_filter([
            $this->location->getStreetName(),
            $this->location->getLocality(),
            $this->location->getCountry()
        ]));
    }
} 