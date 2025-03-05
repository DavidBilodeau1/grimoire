<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::rename('book_book_list', 'book_bookshelves');
    }

    public function down()
    {
        Schema::rename('book_bookshelves', 'book_book_list');
    }
};
