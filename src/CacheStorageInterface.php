<?php

namespace CCT\StudyCartel\UnitTesting;

interface CacheStorageInterface
{
    public function set($key, $value);

    public function get($key);

    public function has($key);

    public function remove($key);
}
