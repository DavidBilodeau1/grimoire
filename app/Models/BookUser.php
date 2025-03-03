<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BookUser extends Pivot
{
    protected $table = 'book_user'; // Specify the table name

    // Add fillable fields if you want to use create() or update() methods
    protected $fillable = [
        'user_id',
        'book_id',
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
}
