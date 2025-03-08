<?php

namespace App\Console\Commands;

use App\Models\Book;
use Google\Client;
use Google\Service\Books;
use Illuminate\Console\Command;

class FetchBookDescription extends Command
{
    protected $signature = 'fetch:book-description';
    protected $description = 'Fetch book description from Google Books API';

    public function handle()
    {
        $books = Book::whereNull('description')->limit(100)->get();

        foreach ($books as $book) {
            $this->info("Fetching synopsis for: " . $book->title);
            $synopsis = $this->fetchDescription($book);

            if ($synopsis) {
                $book->description = $synopsis;
                $book->save();
                $this->info("Description updated for: " . $book->title);
            } else {
                $book->description = 'No description available.';
                $book->save();
                $this->warn("Description not found for: " . $book->title);
            }
        }
    }

    private function fetchDescription(Book $book)
    {
        $client = new Client();
        $client->setApplicationName(config('services.google.application_name')); // Replace with your app name
        $client->setScopes([Books::BOOKS]);
        $client->setDeveloperKey(config('services.google.api_key')); // Replace with your Google Books API key

        $service = new Books($client);
        try {
            $query = $book->title . ' ' . $book->author; // Use title and author for the query
            $results = $service->volumes->listVolumes($query);
            $items = $results->getItems();

            if (!empty($items)) {
                $volumeInfo = $items[0]->getVolumeInfo();
                return $volumeInfo->getDescription();
            }
        } catch (\Exception $e) {
            $this->error("Error fetching cover for " . $book->title . ": " . $e->getMessage());
        }

        return null;
    }
}
