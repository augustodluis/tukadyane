<?php

namespace Tukadyane\Contracts;

interface CacheInterface
{
    public function get($key, $default = null);
    public function set($key, $value, $ttl = null): bool;
    public function delete($key): bool;
    public function clear(): bool;
    public function has($key): bool;
} 