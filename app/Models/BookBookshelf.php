<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BookUser;
use Spatie\EloquentSortable\SortableTrait;

class BookBookshelf extends Model
{
    use SortableTrait;

    protected $table = 'book_bookshelf';

    protected $fillable = [
        'book_id',
        'bookshelf_id',
        'position'
    ];

    public $sortable = [
        'order_column_name' => 'position',
        'sort_when_creating' => true,
    ];
}
