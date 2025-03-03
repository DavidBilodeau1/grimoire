<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\BookUser;

class BookList extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'is_main'
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class)->using(BookUser::class);
    }
}
