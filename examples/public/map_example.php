<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Tukadyane\Geocoder;
use Tukadyane\MapRenderer;
use Tukadyane\Services\CacheService;

// Configuração
$cache = new CacheService();
$geocoder = new Geocoder(null, $cache);
$mapRenderer = new MapRenderer([
    'zoom' => 14,
    'height' => '600px'
]);

try {
    // Geocodificação
    $result = $geocoder->geocode('Maputo, Moçambique');
    
    // Renderização do mapa
    $map = $mapRenderer->render(
        $result->getLatitude(),
        $result->getLongitude(),
        ['zoom' => 15]
    );
    
    // Template
    include __DIR__ . '/../templates/map.php';
    
} catch (\Exception $e) {
    error_log($e->getMessage());
    include __DIR__ . '/../templates/error.php';
} 