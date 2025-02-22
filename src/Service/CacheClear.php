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

use App\Service\Compiler\SystemStatusReportCompiler;
use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Class CacheClear.
 *
 * @author moay <mv@moay.de>
 */
class CacheClear implements CacheClearerInterface
{
    /** @var CacheInterface */
    private $cache;

    /** @var SystemStatusReportCompiler */
    private $systemStatusReportCompiler;

    /**
     * CacheClear constructor.
     */
    public function __construct(Cache $cache, SystemStatusReportCompiler $systemStatusReportCompiler)
    {
        $this->cache = $cache();
        $this->systemStatusReportCompiler = $systemStatusReportCompiler;
    }

    /**
     * Clears flex server caches.
     *
     * @param string $cacheDir The cache directory
     */
    public function clear($cacheDir)
    {
        $this->cache->clear();
        $this->systemStatusReportCompiler->removeReport();
    }
}
