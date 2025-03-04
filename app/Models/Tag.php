<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'reading_goal_id',
        'name'
    ];
    // app/Models/Tag.php
    public function readingGoal()
    {
        return $this->belongsTo(ReadingGoal::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
