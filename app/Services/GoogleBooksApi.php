<?php

namespace App\Services;

use Google\Client;
use Google\Service\Books;

class GoogleBooksApi
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName(config('services.google.application_name'));
        $this->client->setScopes([Books::BOOKS]);
        // Set your API key here or load it from environment variables
        $this->client->setDeveloperKey(config('services.google.api_key'));

        $this->service = new Books($this->client);
    }

    public function search(string $query, int $maxResults = 10): array
    {
        $optParams = [
            'q' => $query,
            'maxResults' => $maxResults,
        ];
        $results = $this->service->volumes->listVolumes($query, $optParams);

        return $results->getItems() ?? [];
    }
}
