<?php

namespace Tests;

use Tukadyane\Geocoder;
use PHPUnit\Framework\TestCase;

class GeocoderTest extends TestCase
{
    public function testSimple()
    {
        $this->assertTrue(true);
    }

    public function testGeocode()
    {
        $geocoder = new Geocoder();
        try {
            $result = $geocoder->geocode('Maputo, Moçambique');
            
            // Verifica se o resultado não é nulo
            $this->assertNotNull($result, 'O resultado não deveria ser nulo');
            $this->assertNotEmpty($result, 'O resultado não deveria estar vazio');
            
            // Pega o primeiro resultado
            $address = $result->first();
            $this->assertNotNull($address, 'O primeiro endereço não deveria ser nulo');
            
            // Verifica as coordenadas
            $coordinates = $address->getCoordinates();
            $this->assertNotNull($coordinates, 'As coordenadas não deveriam ser nulas');
            
            // Verifica latitude e longitude específicas para Maputo
            $latitude = $coordinates->getLatitude();
            $longitude = $coordinates->getLongitude();
            
            $this->assertIsFloat($latitude, 'Latitude deveria ser um número float');
            $this->assertIsFloat($longitude, 'Longitude deveria ser um número float');
            
            // Verifica se as coordenadas estão próximas de Maputo
            $this->assertGreaterThan(-26, $latitude, 'Latitude está muito ao sul');
            $this->assertLessThan(-25, $latitude, 'Latitude está muito ao norte');
            $this->assertGreaterThan(32, $longitude, 'Longitude está muito a oeste');
            $this->assertLessThan(33, $longitude, 'Longitude está muito a leste');
            
        } catch (\Exception $e) {
            $this->fail('Exceção não esperada: ' . $e->getMessage());
        }
    }

    public function testReverse()
    {
        $geocoder = new Geocoder();
        $result = $geocoder->reverse(-25.9659, 32.5837);

        $this->assertNotEmpty($result);
        
        $address = $result->first();
        $this->assertNotNull($address->getStreetName());
        $this->assertIsString($address->getLocality());
    }
}