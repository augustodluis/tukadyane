<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tukadyane\Geocoder;
use Tukadyane\Services\CacheService;
use Tukadyane\Exceptions\GeocodingException;

class GeocoderTest extends TestCase
{
    private Geocoder $geocoder;
    private CacheService $cache;

    protected function setUp(): void
    {
        $this->cache = new CacheService();
        $this->geocoder = new Geocoder(null, $this->cache);
    }

    public function testGeocodeWithValidAddress()
    {
        $result = $this->geocoder->geocode('Maputo, Moçambique');
        
        $this->assertNotNull($result);
        $this->assertIsFloat($result->getLatitude());
        $this->assertIsFloat($result->getLongitude());
    }

    public function testGeocodeWithCache()
    {
        // Primeira chamada
        $result1 = $this->geocoder->geocode('Maputo, Moçambique');
        
        // Segunda chamada (deve vir do cache)
        $result2 = $this->geocoder->geocode('Maputo, Moçambique');
        
        $this->assertEquals($result1, $result2);
    }
} 