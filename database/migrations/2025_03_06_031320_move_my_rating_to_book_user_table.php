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
        Schema::table('book_user', function (Blueprint $table) {
            $table->decimal('my_rating', 3, 1)->nullable(); // Add the my_rating column to book_user
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('my_rating'); // Remove the my_rating column from books
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->decimal('my_rating', 3, 1)->nullable(); // Restore the my_rating column to books
        });

        Schema::table('book_user', function (Blueprint $table) {
            $table->dropColumn('my_rating'); // Remove the my_rating column from book_user
        });
    }
};
