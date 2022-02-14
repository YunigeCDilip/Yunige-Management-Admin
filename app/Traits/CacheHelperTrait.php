<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheHelperTrait
{
    protected $primaryKey = 'id';

    /**
     * Get cache data by key
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getCache(string $key)
    {
        return Cache::get($key);
    }

    /**
     * Set cache data by key
     *
     * @param string $key
     * @param $models
     *
     * @return mixed
     */
    public function setCache(string $key, $items)
    {
        return Cache::put($key, $items);
    }

    /**
     * Add item to cached data
     *
     * @param $key
     * @param $item
     *
     * @return bool
     */
    public function addItem($key, $item)
    {
        if (Cache::has($key)) {
            Cache::forget($key);
        }
        $this->setCache($key, $item);
        
        return true;
    }

    /**
     * Get cached items by attributes
     *
     * @param $key
     * @param $attribute
     * @param $value
     *
     * @return mixed
     */
    public function getItemsByAttribute(string $key, string $attribute, $value)
    {
        return Cache::get($key)->where($attribute, $value);
    }

    /**
     * Get cached items
     *
     * @param $key
     * @param $value
     * @param null $primaryKey
     *
     * @return mixed
     */
    public function getItem($key, $value, $primaryKey = null)
    {
        return Cache::get($key)->where($primaryKey ?? $this->primaryKey, $value);
    }

    /**
     * Delete cached items
     *
     * @param $key
     * @param $value
     * @param null $primaryKey
     *
     * @return bool
     */
    public function deleteItem($key, $value, $primaryKey = null)
    {
        $collections = Cache::get($key);
        $collections = $collections->where(($primaryKey) ?? $this->primaryKey, '!=', $value);
        Cache::put($key, $collections);

        return true;
    }

    /**
     * Forget cache data by key
     *
     * @param string $key
     * @param $models
     *
     * @return mixed
     */
    public function forgetCache(string $key)
    {
        return Cache::forget($key);
    }
}
