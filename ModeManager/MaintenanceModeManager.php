<?php
/*
 * Copyright (C) 2019 Simen Thorsrud
 * @author Simen Thorsrud <simen.thorsrud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siment\MaintenanceBundle\ModeManager;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\Cache\ItemInterface;

class MaintenanceModeManager implements MaintenanceModeManagerInterface
{
    /** @var CacheItemPoolInterface Cache pool */
    private $cache;

    /** @var string Cache key identifier that sets application in maintenance mode */
    public static $modeIdentifier = 'maintenance';

    /**
     * MaintenanceModeManager constructor.
     *
     * @param CacheItemPoolInterface $cache Cache Pool
     */
    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /** {@inheritdoc} */
    public function enable(): bool
    {
        /** @var ItemInterface $cacheItem */
        $cacheItem = $this->cache->getItem(self::$modeIdentifier);
        $cacheItem->set(true);
        $this->cache->save($cacheItem);

        return true;
    }

    /** {@inheritdoc} */
    public function disable(): bool
    {
        $this->cache->deleteItem(self::$modeIdentifier);

        return true;
    }

    /** {@inheritdoc} */
    public function isEnabled(): bool
    {
        /** @var ItemInterface $cacheItem */
        $cacheItem = $this->cache->getItem(self::$modeIdentifier);

        return $cacheItem->isHit() ? true : false;
    }
}
