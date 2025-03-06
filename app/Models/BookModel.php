<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;
use App\Services\GoogleBooksApi;

class BookModel extends Model
{
    use Sushi;

    protected $rows = [];

    public function getRows(?string $searchTerm = null)
    {
        if (empty($this->rows)) {
            $googleBooksApi = new GoogleBooksApi();
            $results = $googleBooksApi->search($searchTerm ?? 'The Lord of the Rings'); // Replace with your desired search term

            $this->rows = collect($results)->map(function ($result) {
                return [
                    'title' => $result->getVolumeInfo()->getTitle(),
                    'authors' => implode(', ', $result->getVolumeInfo()->getAuthors() ?? []),
                    'cover_image' => $result->getVolumeInfo()->getImageLinks()?->getThumbnail()
                ];
            })->toArray();
        }

        return $this->rows;
    }
}
