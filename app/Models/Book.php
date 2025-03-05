<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BookUser;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Book extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'book_bookshelf.position',
        'sort_when_creating' => true,
        'sort_on_has_many' => true,
    ];

    protected $fillable = [
        'title',
        'author',
        'additional_authors',
        'isbn',
        'isbn13',
        'my_rating',
        'average_rating',
        'publisher',
        'binding',
        'number_of_pages',
        'year_published',
        'original_publication_year',
    ];

    public function bookshelves()
    {
        return $this->belongsToMany(Bookshelf::class)
            ->withPivot('position');
    }

    // app/Models/Book.php
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->using(BookUser::class);
    }

    public function buildSortQuery()
    {
        return static::query()->where('bookshelf_id', $this->bookshelf_id);
    }
}
