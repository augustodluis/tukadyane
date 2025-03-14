<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tukadyane\MapRenderer;

class MapRendererTest extends TestCase
{
    public function testRenderMap()
    {
        $latitude = -25.9659;
        $longitude = 32.5837;
        $map = MapRenderer::renderMap($latitude, $longitude);

        $this->assertStringContainsString('<div id=\'map\'', $map);
        $this->assertStringContainsString('var map = L.map(\'map\').setView([-25.9659, 32.5837]', $map);
    }
}