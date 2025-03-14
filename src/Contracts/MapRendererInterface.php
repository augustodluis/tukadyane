<?php

namespace Tukadyane\Contracts;

interface MapRendererInterface
{
    public function render(float $latitude, float $longitude, array $options = []): string;
} 