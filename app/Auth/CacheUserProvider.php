<?php
declare(strict_types=1);

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Hashing\Hasher;

class CacheUserProvider extends EloquentUserProvider
{
    protected $cache;
    protected $cacheKey = "authentiation:user:%s";
    protected $lifetime;

    public function __construct(
        Hasher $hasher,
        string $model,
        CacheRepository $cache,
        int $lifetime = 120
    ) {
        parent::__construct($hasher, $model);
        $this->cache = $cache;
        $this->lifetime = $lifetime;
    }

    public function retrieveById($identifier)
    {
        $chachKey = sprintf($this->cacheKey, $identifier);
        if ($this->cache->has($chachKey)) {
            return $this->cache->get($chachKey);
        }
        $result = parent::retrieveById($identifier);
        if (is_null($result)) {
            return null;
        }
        $this->cache->add($chachKey, $result, $this->lifetime);
        return $result;
    }

    public function retrieveByToken($identifier, $token)
    {
        $model = $this->retrieveById($identifier);
        if (!$model) {
            return null;
        }
        $rememberToken = $model->getRememberToken();
        return $rememberToken && hash_equals($rememberToken, $token) ? $model : null;
    }
}