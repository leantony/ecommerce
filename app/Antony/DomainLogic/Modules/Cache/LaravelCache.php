<?php namespace app\Antony\DomainLogic\Modules\Cache;

use app\Antony\DomainLogic\Contracts\Caching\CacheInterface;
use Illuminate\Cache\CacheManager;

class LaravelCache implements CacheInterface
{

    /**
     * Cache implementation
     *
     * @var CacheManager
     */
    protected $cache;

    /**
     * Defines how long the data should be cached
     *
     * @var integer
     */
    protected $minutes;


    /**
     * @param CacheManager $cache
     * @param int $minutes
     *
     */
    public function __construct(CacheManager $cache, $minutes = 60)
    {
        $this->cache = $cache;

        $this->minutes = $minutes;
    }

    /**
     * Retrieve an item from the cache
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->cache->get($key);
    }

    /**
     * Put a key value pair in the cache
     *
     * @param string $key
     * @param mixed $value
     * @param integer $minutes
     *
     * @return mixed
     */
    public function put($key, $value, $minutes = null)
    {
        if (is_null($minutes)) {
            $minutes = $this->minutes;
        }

        return $this->cache->put($key, $value, $minutes);
    }

    /**
     * Check if the cache has a key
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return $this->cache->has($key);
    }

    /**
     * @return int
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * @param int $minutes
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;
    }

}