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

        $response = $this->render('api/everything.html.twig', [
            'allNews' => $allNews,
            'categories' => $this->categoriesArray
        ]);

        $response->setSharedMaxAge(3600);

        return $response;

    }

    /**
     * @Route("/", name="top")
     */
    public function topHeadlines(ApiService $api): Response
    {
        $headlines = $api->getTopHeadlines();

        $response = $this->render('api/headlines.html.twig', [
            'headlines' => $headlines,
            'categories' => $this->categoriesArray
        ]);

        $response->setSharedMaxAge(3600);

        return $response;
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


        $response = $this->render('api/resultsByCategory.html.twig', [
            'resultsByCategory' => $resultsByCategory,
            'categories' => $this->categoriesArray,
            'frenchCategory' => $frenchCategory
        ]);

        $response->setSharedMaxAge(3600);

        return $response;
    }

    /**
     * @Route("/rss", name="rss")
     */
    public function rss(Request $request): Response
    {
        
        if($request->query->get("category") == "environment") {
            $rss = simplexml_load_file("https://www.france24.com/fr/planète/rss");
            $theme = "Environnement";
        } else {
            $rss = simplexml_load_file("https://www.francetvinfo.fr/politique.rss");
            $theme = "Politique";
        }

        $response = $this->render('rss.html.twig', [
            'rss' => $rss->channel->item,
            'theme' => $theme,
            'categories' => $this->categoriesArray
        ]);

        $response->setSharedMaxAge(3600);

        return $response;
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(ApiService $api, Request $request): Response
    {
        $currentSearch = $request->query->get("search");

        $searchResults = $api->getSearchedNews($currentSearch);

        $response = $this->render('api/search.html.twig', [
            'searchResults' => $searchResults,
            'categories' => $this->categoriesArray,
            'currentSearch' => $currentSearch
        ]);

        $response->setSharedMaxAge(3600);

        return $response;
    }
}
