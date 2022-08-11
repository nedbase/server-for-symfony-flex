<?php

/*
 * This file is part of the moay server-for-symfony-flex package.
 *
 * (c) moay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Service\Provider\AliasesProvider;
use App\Service\Provider\PackagesProvider;
use App\Service\Provider\UlidProvider;
use App\Service\Provider\VersionsProvider;
use App\Traits\ProvidesUnescapedJsonResponsesTrait;
use Http\Client\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EndpointController.
 *
 * @author moay <mv@moay.de>
 */
class EndpointController extends AbstractController
{
    use ProvidesUnescapedJsonResponsesTrait;

    /**
     * @param AliasesProvider $provider
     *
     * @return JsonResponse
     */
    #[Route('/aliases.json', name: 'endpoint_aliases')]
    public function aliases(AliasesProvider $provider): JsonResponse
    {
        return $this->unescapedSlashesJson($provider->provideAliases());
    }

    /**
     * @param VersionsProvider $provider
     *
     * @return JsonResponse
     */
    #[Route('/versions.json', name: 'endpoint_versions')]
    public function versions(VersionsProvider $provider): JsonResponse
    {
        return $this->unescapedSlashesJson($provider->provideVersions());
    }

    /**
     * @param UlidProvider $provider
     *
     * @return JsonResponse
     */
    #[Route('/ulid', name: 'endpoint_ulid')]
    public function ulid(UlidProvider $provider): JsonResponse
    {
        return $this->unescapedSlashesJson(['ulid' => $provider->provideUlid()]);
    }

    /**
     * @param string           $packages
     * @param PackagesProvider $provider
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    #[Route('/p/{packages}', name: 'endpoint_packages')]
    public function packages(string $packages, PackagesProvider $provider): JsonResponse
    {
        return $this->unescapedSlashesJson($provider->providePackages($packages));
    }
}
