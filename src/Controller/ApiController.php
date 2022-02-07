<?php

namespace App\Controller;

use App\Utils\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/", name="all")
     */
    public function index(ApiService $api): Response
    {
        $allNews = $api->getAllNews();

        return $this->render('api/index.html.twig', [
            'allNews' => $allNews,
        ]);
    }

    /**
     * @Route("/top", name="top")
     */
    public function topHeadlines(ApiService $api): Response
    {
        $headlines = $api->getTopHeadlines();

        return $this->render('api/headlines.html.twig', [
            'headlines' => $headlines,
        ]);
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function categories(ApiService $api): Response
    {
        $resultsByCategory = $api->getResultsByCategory();

        return $this->render('api/resultsByCategory.html.twig', [
            'resultsByCategory' => $resultsByCategory,
        ]);
    }

    /**
     * @Route("/sources", name="sources")
     */
    public function sources(ApiService $api): Response
    {
        $sources = $api->getSources();

        return $this->render('api/sources.html.twig', [
            'sources' => $sources,
        ]);
    }
}
