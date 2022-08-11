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

use App\Service\Compiler\LocalRecipeCompiler;
use App\Service\Compiler\SystemStatusReportCompiler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FrontendController.
 *
 * @author moay <mv@moay.de>
 */
class FrontendController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route('/', name: 'frontend_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('dashboard.html.twig');
    }

    /**
     * @param SystemStatusReportCompiler $reportGenerator
     * @param LocalRecipeCompiler        $recipeCompiler
     *
     * @return JsonResponse
     */
    #[Route('/ui/data', name: 'frontend_dashboard_data')]
    public function dashboardData(SystemStatusReportCompiler $reportGenerator, LocalRecipeCompiler $recipeCompiler): JsonResponse
    {
        return $this->json([
            'status' => $reportGenerator->getReport(),
            'recipes' => $recipeCompiler->getLocalRecipes(),
        ]);
    }
}
