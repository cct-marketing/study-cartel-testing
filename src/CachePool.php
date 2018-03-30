<?php

namespace CCT\StudyCartel\UnitTesting;

use CCT\StudyCartel\Exception\ExistingServiceException;
use CCT\StudyCartel\Exception\NonExistingServiceException;

class CachePool
{
    /**
     * @var array
     */
    private $caches = [];

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register($identifier, CacheStorageInterface $cacheStorage): void
    {
        if ($this->has($identifier)) {
            throw new ExistingServiceException(sprintf('The service %s already exists.', $identifier));
        }

        if (!is_object($cacheStorage)) {
            throw new \InvalidArgumentException(sprintf(
                'The cache storage needs to be an object, %s given.',
                gettype($cacheStorage)
            ));
        }

        $this->caches[$identifier] = $cacheStorage;
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function unregister($identifier): void
    {
        if (!$this->has($identifier)) {
            throw new NonExistingServiceException(sprintf('The service %s could not be unregistered.', $identifier));
        }

        unset($this->caches[$identifier]);
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function has($identifier): bool
    {
        return isset($this->caches[$identifier]);
    }

    /**
     * {@inheritdoc}
     *
     * @return CacheStorageInterface
     */
    public function get($identifier)
    {
        if (!$this->has($identifier)) {
            throw new NonExistingServiceException('The service %s could not be unregistered.', $identifier);
        }

        return $this->caches[$identifier];
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function all()
    {
        return $this->caches;
    }
}
