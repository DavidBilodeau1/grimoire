<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('user_id');
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

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_user');
    }
};
