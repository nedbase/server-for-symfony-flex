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

use App\Service\RecipeRepoManager;
use Cz\Git\GitException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WebhookController.
 *
 * @author moay <mv@moay.de>
 */
class WebhookController extends AbstractController
{
    /**
     * @param RecipeRepoManager $repoManager
     *
     * @return JsonResponse
     *
     * @throws GitException
     */
    #[Route('/webhook/update', name: 'webhook_update', methods: ['POST'])]
    public function update(RecipeRepoManager $repoManager): JsonResponse
    {
        foreach ($repoManager->getConfiguredRepos() as $repo) {
            $repo->update();
        }

        return $this->json(['success' => true]);
    }
}
