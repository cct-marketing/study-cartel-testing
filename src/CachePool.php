<?php

declare(strict_types=1);

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
     */
    public function has($identifier): bool
    {
        return isset($this->caches[$identifier]);
    }

    /**
     * {@inheritdoc}
     */
    public function get($identifier): CacheStorageInterface
    {
        if (!$this->has($identifier)) {
            throw new NonExistingServiceException('The service %s could not be unregistered.', $identifier);
        }

        return $this->caches[$identifier];
    }

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $this->caches;
    }
}
