<?php

namespace Tukadyane\Services;

use Tukadyane\Contracts\CacheInterface;

class CacheService implements CacheInterface
{
    private $storage = [];
    private $ttls = [];

    public function get($key, $default = null)
    {
        if (!$this->has($key)) {
            return $default;
        }
        return $this->storage[$key];
    }

    public function set($key, $value, $ttl = null): bool
    {
        $this->storage[$key] = $value;
        if ($ttl) {
            $this->ttls[$key] = time() + $ttl;
        }
        return true;
    }

    public function delete($key): bool
    {
        unset($this->storage[$key], $this->ttls[$key]);
        return true;
    }

    public function clear(): bool
    {
        $this->storage = [];
        $this->ttls = [];
        return true;
    }

    public function getMultiple($keys, $default = null): iterable
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->get($key, $default);
        }
        return $result;
    }

    public function setMultiple($values, $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
        return true;
    }

    public function deleteMultiple($keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
        return true;
    }

    public function has($key): bool
    {
        if (!isset($this->storage[$key])) {
            return false;
        }
        if (isset($this->ttls[$key]) && time() > $this->ttls[$key]) {
            unset($this->storage[$key], $this->ttls[$key]);
            return false;
        }
        return true;
    }
} 