<?php

namespace App\Livewire;

use App\Services\GoogleBooksApi;
use Livewire\Component;

class BookSearch extends Component
{
    public $query = '';
    public $results = [];

    public function updateQuery(string $query)
    {
        $this->query = $query;
        $googleBooksApi = new GoogleBooksApi();
        $apiResults = $googleBooksApi->search($this->query);

        $this->results = collect($apiResults)->map(function ($result) {
            return [
                'id' => $result->getId(),
                'title' => $result->getVolumeInfo()->getTitle(),
                'authors' => $result->getVolumeInfo()->getAuthors() ? implode(', ', $result->getVolumeInfo()->getAuthors()) : '',
                'cover_image' => $result->getVolumeInfo()->getImageLinks() ? $result->getVolumeInfo()->getImageLinks()->getThumbnail() : null,
                'description' => str_replace('"', '\"', $result->getVolumeInfo()->getDescription()),
                'isbn' => $result->getVolumeInfo()->getIndustryIdentifiers() ? $result->getVolumeInfo()->getIndustryIdentifiers()[0]->getIdentifier() : null,
                'publisher' => $result->getVolumeInfo()->getPublisher(),
                'published_date' => $result->getVolumeInfo()->getPublishedDate(),
                'page_count' => $result->getVolumeInfo()->getPageCount(),
            ];
        })->toArray();
    }

    public function selectBook($bookJson)
    {

        $book = json_decode($bookJson);

        // Store the book data in a session variable
        session()->flash('selectedBook', $book);

        return redirect()->route('books.api-show');
    }

    public function render()
    {
        return view('livewire.book-search');
    }
}
