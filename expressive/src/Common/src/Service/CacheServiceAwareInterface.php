<?php

declare(strict_types=1);

namespace Common\Service;

interface CacheServiceAwareInterface
{
    public function setCacheService($cacheService);
    public function getCacheService();
}