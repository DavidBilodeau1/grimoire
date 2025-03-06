<?php

namespace App\Console\Commands;

use App\Models\Book;
use Google\Client;
use Google\Service\Books;
use Illuminate\Console\Command;

class FetchBookCoverImage extends Command
{
    protected $signature = 'fetch:book-cover-image';
    protected $description = 'Fetch book cover images from Google Books API';

    public function handle()
    {
        $books = Book::whereNull('cover_image')->limit(100)->get();

        foreach ($books as $book) {
            $this->info("Fetching cover for: " . $book->title);
            $coverImageLink = $this->fetchCoverImage($book);

            if ($coverImageLink) {
                $book->cover_image = $coverImageLink;
                $book->save();
                $this->info("Cover image updated for: " . $book->title);
            } else {
                $book->cover_image = '/images/placeholder.gif';
                $book->save();
                $this->warn("Cover image not found for: " . $book->title);
            }
        }
    }

    private function fetchCoverImage(Book $book)
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
                return $volumeInfo->getImageLinks()?->getThumbnail();
            }
        } catch (\Exception $e) {
            $this->error("Error fetching cover for " . $book->title . ": " . $e->getMessage());
        }

        return null;
    }
}
