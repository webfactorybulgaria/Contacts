<?php

namespace TypiCMS\Modules\Contacts\Repositories;

use TypiCMS\Modules\Core\Custom\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Custom\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements ContactInterface
{
    public function __construct(ContactInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }
}
