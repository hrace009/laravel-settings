<?php
/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://www.hrace009.com
 * @copyright Copyright (c) 2021.
 */

namespace hrace009\LaravelSettings;

/**
 * Class Cache
 * @package hrace009\LaravelSettings
 */
class Cache
{

    /**
     * Path to cache file
     *
     * @var string
     */
    protected $cacheFile;

    /**
     * Cached Settings
     *
     * @var array
     */
    protected $settings;


    /**
     * Constructor
     *
     * @param string $cacheFile
     */
    public function __construct($cacheFile)
    {
        $this->cacheFile = $cacheFile;
        $this->checkCacheFile();

        $this->settings = $this->getAll();
    }

    /**
     * Checks if the cache file exists and creates it if not
     *
     * @return void
     */
    private function checkCacheFile()
    {
        if (!file_exists($this->cacheFile)) {
            $this->flush();
        }
    }

    /**
     * Removes all values
     *
     * @return void
     */
    public function flush()
    {
        file_put_contents($this->cacheFile, json_encode([]));
        // fixed the set after immediately the flush, should be returned empty
        $this->settings = [];
    }

    /**
     * Gets all cached settings
     *
     * @return array
     */
    public function getAll()
    {
        $values = json_decode(file_get_contents($this->cacheFile), true);
        foreach ($values as $key => $value) {
            $values[$key] = unserialize($value);
        }
        return $values;
    }

    /**
     * Sets a value
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function set($key, $value)
    {
        $this->settings[$key] = $value;
        $this->store();

        return $value;
    }

    /**
     * Stores all settings to the cache file
     *
     * @return void
     */
    private function store()
    {
        $settings = [];
        foreach ($this->settings as $key => $value) {
            $settings[$key] = serialize($value);
        }
        file_put_contents($this->cacheFile, json_encode($settings));
    }

    /**
     * Gets a value
     *
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return (array_key_exists($key, $this->settings) ? $this->settings[$key] : $default);
    }

    /**
     * Checks if $key is cached
     *
     * @param $key
     *
     * @return bool
     */
    public function hasKey($key)
    {
        return array_key_exists($key, $this->settings);
    }

    /**
     * Removes a value
     *
     * @return void
     */
    public function forget($key)
    {
        if (array_key_exists($key, $this->settings)) {
            unset($this->settings[$key]);
        }
        $this->store();
    }
}
