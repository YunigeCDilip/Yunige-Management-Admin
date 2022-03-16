<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;
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
        if (Cache::has($key)) {
            $this->forgetCache($key);
        }

        return Cache::put($key, $items);
    }

    /**
     * Set cache collection data by key
     *
     * @param string $key
     * @param $models
     *
     * @return mixed
     */
    public function setCollectionCache(string $key, $items)
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
            $this->forgetCache($key);
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
        return Cache::get($key)->where($attribute, 'LIKE', '%' . $value . '%');
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
        $collections = json_decode(Cache::get($key), true);
        $collections = collect($collections)->filter(function($item) use ($primaryKey) {
            return $item['id'] != $primaryKey;
        });
        Cache::put($key, json_encode($collections->toArray()));

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
        if (Redis::exists($key)) {
            return Redis::del($key);
        }
        return true;
    }

    /**
     * Push cache data by key
     *
     * @param string $key
     * @param $models
     *
     * @return mixed
     */
    public function pushItem(string $key, $item)
    {
        return Cache::forget($key);
    }
}