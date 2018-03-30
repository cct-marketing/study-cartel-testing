<?php

declare(strict_types=1);

namespace CCT\StudyCartel\UnitTesting\Adapter;

class FileSystemCacheAdapter extends AbstractCacheAdapter
{
    public function set($key, $value)
    {
        $cache = sprintf('%s:%s', $key, $value);
        file_put_contents($this->config['dir'], $cache . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    public function get($key)
    {
        $handle = fopen($this->config['dir'], "r");

        while (($line = fgets($handle)) !== false) {
            $data = explode(':', $line);
            $currentKey = $data;

            if ($key === $currentKey) {
                return $data;
            }
        }

        fclose($handle);

        return null;
    }

    public function remove($key)
    {
        $newData = '';
        $handle = fopen($this->config['dir'], "r");

        while (($line = fgets($handle)) !== false) {
            $data = explode(':', $line);
            $currentKey = $data[0];

            if ($key !== $currentKey) {
                $newData .= $line . PHP_EOL;
            }
        }

        fclose($handle);
        file_put_contents($this->config['dir'], $newData . PHP_EOL, LOCK_EX);
    }

    public function has($key)
    {
        $handle = fopen($this->config['dir'], "r");

        $output = false;
        while (($line = fgets($handle)) !== false) {
            $data = explode(':', $line);
            $currentKey = $data[0];

            if ($key === $currentKey) {
                $output = true;
            }
        }

        fclose($handle);

        return $output;
    }
}
