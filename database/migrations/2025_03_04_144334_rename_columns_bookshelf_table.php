<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('book_bookshelf', function(Blueprint $table) {
            $table->renameColumn('book_list_id', 'bookshelf_id');
        });
    }

    public function down()
    {
        Schema::table('book_bookshelf', function(Blueprint $table) {
            $table->renameColumn('bookshelf_id', 'book_list_id');
        });
    }
};
