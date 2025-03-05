<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BookUser;

class Book extends Model
{
    use HasFactory;

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
        'date_read',
        'date_added',
        'bookshelves',
        'bookshelves_with_positions',
        'exclusive_shelf',
        'my_review',
        'spoiler',
        'private_notes',
        'read_count',
        'owned_copies',
    ];

    public function bookshelves()
    {
        return $this->belongsToMany(Bookshelf::class, 'book_bookshelf')->withPivot('position');
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
}
