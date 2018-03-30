<?php

require_once __DIR__ . '/vendor/autoload.php';

use CCT\StudyCartel\UnitTesting\Adapter\FileSystemCacheAdapter;
use CCT\StudyCartel\UnitTesting\CachePool;

$fileSystem = new FileSystemCacheAdapter([
    'dir' => __DIR__ . '/cache.txt'
]);

$pool = new CachePool();
$pool->register('filesystem', $fileSystem);

// $pool->get('filesystem')->set('my_key', 'my_value');
// $pool->get('filesystem')->has('my_key');
// $pool->get('filesystem')->remove('my_key');