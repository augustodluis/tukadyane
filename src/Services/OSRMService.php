<?php

namespace Tukadyane\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class OSRMService
{
    private const BASE_URL = 'http://router.project-osrm.org/route/v1/driving/';
    private Client $client;
    private $logger;

    public function __construct(Client $client = null, $logger = null)
    {
        $this->client = $client ?? new Client();
        $this->logger = $logger ?? new class {
            public function info($message, $context = []) {}
            public function error($message, $context = []) {}
        };
    }

    /**
     * Calcula a rota entre dois pontos (coordenadas).
     *
     * @param float $startLat Latitude do ponto de partida.
     * @param float $startLon Longitude do ponto de partida.
     * @param float $endLat Latitude do ponto de destino.
     * @param float $endLon Longitude do ponto de destino.
     * @return array|null Retorna os dados da rota ou null em caso de erro.
     * @throws InvalidArgumentException Se as coordenadas forem inválidas
     */
    public function getRoute(float $startLat, float $startLon, float $endLat, float $endLon): ?array
    {
        $this->validateCoordinates($startLat, $startLon, $endLat, $endLon);

        try {
            $url = $this->buildUrl($startLon, $startLat, $endLon, $endLat);
            $response = $this->client->request('GET', $url);
            $data = json_decode($response->getBody(), true);

            return $data['routes'][0] ?? null;
        } catch (GuzzleException $e) {
            $this->logger->error('Erro ao obter rota do OSRM', [
                'error' => $e->getMessage(),
                'coordinates' => [
                    'start' => ['lat' => $startLat, 'lon' => $startLon],
                    'end' => ['lat' => $endLat, 'lon' => $endLon]
                ]
            ]);
            return null;
        }
    }

    private function validateCoordinates(float $startLat, float $startLon, float $endLat, float $endLon): void
    {
        if (!$this->isValidLatitude($startLat) || !$this->isValidLatitude($endLat)) {
            throw new InvalidArgumentException('Latitude deve estar entre -90 e 90 graus');
        }

        if (!$this->isValidLongitude($startLon) || !$this->isValidLongitude($endLon)) {
            throw new InvalidArgumentException('Longitude deve estar entre -180 e 180 graus');
        }
    }

    private function isValidLatitude(float $latitude): bool
    {
        return $latitude >= -90 && $latitude <= 90;
    }

    private function isValidLongitude(float $longitude): bool
    {
        return $longitude >= -180 && $longitude <= 180;
    }

    private function buildUrl(float $startLon, float $startLat, float $endLon, float $endLat): string
    {
        return self::BASE_URL . "$startLon,$startLat;$endLon,$endLat";
    }
}