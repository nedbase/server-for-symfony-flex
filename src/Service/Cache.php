<?php

/*
 * This file is part of the moay server-for-symfony-flex package.
 *
 * (c) moay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Class Cache.
 *
 * @author moay <mv@moay.de>
 */
class Cache
{
    const CACHE_DIR = '/var/cache/data';

    /**
     * @var FilesystemAdapter
     */
    private $cache;

    /**
     * Cache constructor.
     */
    public function __construct(string $projectDir)
    {
        $cachePath = $projectDir.self::CACHE_DIR;

        if (!is_dir($cachePath)) {
            mkdir($cachePath);
        }
        $this->cache = new FilesystemAdapter('flex-server', 0, $cachePath);
    }

    /**
     * @return FilesystemAdapter
     */
    public function __invoke()
    {
        return $this->cache;
    }
}
