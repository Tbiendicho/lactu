<?php

namespace App\Utils;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService {

    private $client;

    private $apiKey = "e06a30d91fdf4208a0a9bc02e37b9153";

    private $category = "health";

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getAllNews() {
        $response = $this->client->request(
            'GET',
            'https://newsapi.org/v2/everything?q=,&language=fr&pageSize=100&apiKey=' . $this->apiKey
        );

        return $response->toArray();
    }

    public function getDailyNews() {

    }

    public function getTopHeadlines() {
        $response = $this->client->request(
            'GET',
            'https://newsapi.org/v2/top-headlines?language=fr&apiKey=' . $this->apiKey
        );

        return $response->toArray();
    }

    public function getSearchedNews() {

    }

    public function getResultsByCategory() {
        $response = $this->client->request(
            'GET',
            'https://newsapi.org/v2/top-headlines?language=fr&category=' . $this->category . '&apiKey=' . $this->apiKey
        );

        return $response->toArray();
    }

    public function getSources() {
        $response = $this->client->request(
            'GET',
            'https://newsapi.org/v2/top-headlines/sources?apiKey=' . $this->apiKey
        );

        return $response->toArray();
    }
}