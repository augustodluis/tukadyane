<?php

namespace Tukadyane\Services;

use Geocoder\Provider\Nominatim\Nominatim;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;
use Geocoder\StatefulGeocoder;
use GuzzleHttp\Client as GuzzleClient;
use Nyholm\Psr7\Factory\Psr17Factory;

class NominatimService
{
    private $geocoder;

    public function __construct()
    {
        // Configura o cliente HTTP e o provedor Nominatim
        $httpClient = new GuzzleClient(); // Cliente HTTP Guzzle
        $factory = new Psr17Factory();

        $provider = new Nominatim(
            $httpClient,
            'https://nominatim.openstreetmap.org',
            'Tukadyane' // User-Agent string
        );

        // Inicializa o geocoder
        $this->geocoder = new StatefulGeocoder($provider, 'en');
    }

    /**
     * Converte um endereço em coordenadas (latitude e longitude).
     *
     * @param string $address Endereço a ser geocodificado.
     * @return \Geocoder\Collection
     */
    public function geocode($address)
    {
        return $this->geocoder->geocodeQuery(GeocodeQuery::create($address));
    }

    /**
     * Converte coordenadas (latitude e longitude) em um endereço.
     *
     * @param float $latitude Latitude do local.
     * @param float $longitude Longitude do local.
     * @return \Geocoder\Collection
     */
    public function reverse($latitude, $longitude)
    {
        return $this->geocoder->reverseQuery(ReverseQuery::fromCoordinates($latitude, $longitude));
    }
}