<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tukadyane\Geocoder;
use Tukadyane\MapRenderer;

$geocoder = new Geocoder();
$result = $geocoder->geocode('Maputo, Moçambique');

if (!empty($result)) {
    $latitude = $result->first()->getCoordinates()->getLatitude();
    $longitude = $result->first()->getCoordinates()->getLongitude();
    echo MapRenderer::renderMap($latitude, $longitude);
} else {
    echo "Endereço não encontrado.";
}