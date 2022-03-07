<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

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
        return Redis::get($key);
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
        if (Redis::exists($key)) {
            $this->forgetCache($key);
        }

        return Redis::set($key, $items);
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
        return Redis::set($key, $items);
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
        if (Redis::exists($key)) {
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
        return Redis::get($key)->where($attribute, 'LIKE', '%' . $value . '%');
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
        return Redis::get($key)->where($primaryKey ?? $this->primaryKey, $value);
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
        $collections = json_decode(Redis::get($key), true);
        $collections = collect($collections)->filter(function($item) use ($primaryKey) {
            return $item['id'] != $primaryKey;
        });
        Redis::set($key, json_encode($collections->toArray()));

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
        return Redis::del($key);
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
        return Redis::del($key);
    }
}
