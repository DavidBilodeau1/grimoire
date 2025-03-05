<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::rename('book_bookshelves', 'book_bookshelf');
    }

    public function down()
    {
        Schema::rename('book_bookshelf', 'book_bookshelves');
    }
};
