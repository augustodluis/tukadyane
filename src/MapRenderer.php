<?php

namespace Tukadyane;

use Tukadyane\Contracts\MapRendererInterface;
use Tukadyane\Exceptions\MapRenderException;

class MapRenderer implements MapRendererInterface
{
    private const DEFAULT_CONFIG = [
        'zoom' => 12,
        'height' => '500px',
        'tileLayer' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        'attribution' => '&copy; OpenStreetMap contributors'
    ];

    private array $config;

    public function __construct(array $config = [])
    {
        $this->config = array_merge(self::DEFAULT_CONFIG, $config);
    }

    public function render(
        float $latitude,
        float $longitude,
        array $options = []
    ): string {
        try {
            $config = array_merge($this->config, $options);
            
            return $this->generateHtml($latitude, $longitude, $config);
        } catch (\Exception $e) {
            throw new MapRenderException("Erro ao renderizar mapa: {$e->getMessage()}");
        }
    }

    private function generateHtml(float $latitude, float $longitude, array $config): string
    {
        $mapId = uniqid('map_');
        
        return <<<HTML
            <div id='{$mapId}' style='width: 100%; height: {$config['height']};'></div>
            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <script src='https://unpkg.com/leaflet/dist/leaflet.js'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const map = L.map('{$mapId}').setView([{$latitude}, {$longitude}], {$config['zoom']});
                    
                    L.tileLayer('{$config['tileLayer']}', {
                        attribution: '{$config['attribution']}'
                    }).addTo(map);
                    
                    L.marker([{$latitude}, {$longitude}])
                        .addTo(map)
                        .bindPopup('Localização selecionada')
                        .openPopup();
                });
            </script>
        HTML;
    }
}