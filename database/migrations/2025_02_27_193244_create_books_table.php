<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('additional_authors')->nullable();
            $table->string('isbn')->nullable();
            $table->string('isbn13')->nullable();
            $table->decimal('my_rating')->nullable();
            $table->decimal('average_rating', 3, 2)->nullable();
            $table->string('publisher')->nullable();
            $table->string('binding')->nullable();
            $table->integer('number_of_pages')->nullable();
            $table->year('year_published')->nullable();
            $table->year('original_publication_year')->nullable();
            $table->date('date_read')->nullable();
            $table->date('date_added')->nullable();
            $table->string('bookshelves')->nullable();
            $table->string('bookshelves_with_positions')->nullable();
            $table->string('exclusive_shelf')->nullable();
            $table->text('my_review')->nullable();
            $table->boolean('spoiler')->default(false);
            $table->text('private_notes')->nullable();
            $table->integer('read_count')->default(0);
            $table->integer('owned_copies')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
};
