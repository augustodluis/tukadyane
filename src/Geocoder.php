<?php

namespace Tukadyane;

use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;
use GuzzleHttp\Client as GuzzleClient;
use Geocoder\Provider\Nominatim\Nominatim;
use Geocoder\StatefulGeocoder;
use Geocoder\Provider\Provider;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Tukadyane\Contracts\GeocoderInterface;
use Tukadyane\Contracts\GeocodingResult;
use Tukadyane\Exceptions\GeocodingException;
use Tukadyane\Services\CacheService;
use Tukadyane\Services\NominatimService;
use InvalidArgumentException;
use Tukadyane\Models\GeocodingResultAdapter;

class Geocoder implements GeocoderInterface
{
    private NominatimService $nominatimService;
    private CacheService $cache;
    private LoggerInterface $logger;

    public function __construct(
        ?NominatimService $nominatimService = null,
        ?CacheService $cache = null,
        ?LoggerInterface $logger = null
    ) {
        $this->nominatimService = $nominatimService ?? new NominatimService();
        $this->cache = $cache ?? new CacheService();
        $this->logger = $logger ?? new NullLogger();
    }

    public function geocode(string $address): GeocodingResult
    {
        $cacheKey = "geocode_" . md5($address);

        try {
            // Tenta buscar do cache primeiro
            if ($cached = $this->cache->get($cacheKey)) {
                $this->logger->info('Cache hit for address', ['address' => $address]);
                return $cached;
            }

            $result = $this->nominatimService->geocode($address);
            
            // Salva no cache
            $this->cache->set($cacheKey, $result, 3600); // 1 hora

            return new GeocodingResultAdapter($result->first());
        } catch (\Exception $e) {
            $this->logger->error('Geocoding failed', [
                'address' => $address,
                'error' => $e->getMessage()
            ]);
            throw new GeocodingException("Falha ao geocodificar endereço: {$e->getMessage()}");
        }
    }

    public function reverse(float $latitude, float $longitude): GeocodingResult
    {
        $this->validateCoordinates($latitude, $longitude);
        
        $cacheKey = "reverse_" . md5("$latitude,$longitude");

        try {
            if ($cached = $this->cache->get($cacheKey)) {
                return $cached;
            }

            $result = $this->nominatimService->reverse($latitude, $longitude);
            $adapted = new GeocodingResultAdapter($result->first());
            $this->cache->set($cacheKey, $adapted, 3600);

            return $adapted;
        } catch (\Exception $e) {
            throw new GeocodingException("Falha na geocodificação reversa: {$e->getMessage()}");
        }
    }

    private function validateCoordinates(float $latitude, float $longitude): void
    {
        if ($latitude < -90 || $latitude > 90) {
            throw new InvalidArgumentException('Latitude deve estar entre -90 e 90');
        }
        if ($longitude < -180 || $longitude > 180) {
            throw new InvalidArgumentException('Longitude deve estar entre -180 e 180');
        }
    }
}
