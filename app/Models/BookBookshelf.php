<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\BookUser;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookBookshelf extends Pivot
{
    protected $table = 'book_bookshelf';

    protected $fillable = [
        'book_id',
        'bookshelf_id',
        'position'
    ];
}
