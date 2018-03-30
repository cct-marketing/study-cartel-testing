<?php

namespace CCT\StudyCartel\UnitTesting\Adapter;

use CCT\StudyCartel\UnitTesting\CacheStorageInterface;

abstract class AbstractCacheAdapter implements CacheStorageInterface
{
    protected $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }
}
