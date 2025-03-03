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
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'date_read',
                'date_added',
                'bookshelves',
                'bookshelves_with_positions',
                'exclusive_shelf',
                'my_review',
                'spoiler',
                'private_notes',
                'read_count',
                'owned_copies'
            ]);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
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
};
