<?php

namespace App\Controller;

use App\Utils\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{

    private $categoriesArray = [
        "Santé" => "health",
        "Science" => "science",
        "Business" => "business",
        "Sport" => "sport",
        "Technologie" => "technology",
        "Divertissement" => "entertainment"
    ];

    /**
     * @Route("/all", name="all")
     */
    public function everything(ApiService $api): Response
    {
        $allNews = $api->getAllNews();

        return $this->render('api/everything.html.twig', [
            'allNews' => $allNews,
            'categories' => $this->categoriesArray
        ]);
    }

    /**
     * @Route("/", name="top")
     */
    public function topHeadlines(ApiService $api): Response
    {
        $headlines = $api->getTopHeadlines();

        return $this->render('api/headlines.html.twig', [
            'headlines' => $headlines,
            'categories' => $this->categoriesArray
        ]);
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function categories(ApiService $api, Request $request): Response
    {
        $currentCategory = $request->query->get("category");
        
        foreach ($this->categoriesArray as $key => $value) {
            if ($value === $currentCategory) {
                $frenchCategory = $key;
            };
        }

        $resultsByCategory = $api->getResultsByCategory($currentCategory);


        return $this->render('api/resultsByCategory.html.twig', [
            'resultsByCategory' => $resultsByCategory,
            'categories' => $this->categoriesArray,
            'frenchCategory' => $frenchCategory
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
            'categories' => $this->categoriesArray
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(ApiService $api, Request $request): Response
    {
        $currentSearch = $request->query->get("search");

        $searchResults = $api->getSearchedNews($currentSearch);

        return $this->render('api/search.html.twig', [
            'searchResults' => $searchResults,
            'categories' => $this->categoriesArray,
            'currentSearch' => $currentSearch
        ]);
    }
}
