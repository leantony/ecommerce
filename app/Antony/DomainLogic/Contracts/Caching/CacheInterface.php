<?php namespace app\Antony\DomainLogic\Contracts\Caching;

interface CacheInterface
{

    /**
     * Retrieve a value from a cache using its key
     *
     * @param $key
     *
     * @return mixed
     */
    public function get($key);


    /**
     * Store an item in the cache
     *
     * @param $key
     * @param $value
     * @param null $minutes
     *
     * @return mixed
     */
    public function put($key, $value, $minutes = null);


    /**
     * Check if a cache has an item
     *
     * @param $key
     *
     * @return mixed
     */
    public function has($key);
}