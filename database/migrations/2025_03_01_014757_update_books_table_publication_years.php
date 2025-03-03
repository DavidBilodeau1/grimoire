<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->smallInteger('year_published')->nullable()->change();
            $table->smallInteger('original_publication_year')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->year('year_published')->nullable()->change();
            $table->year('original_publication_year')->nullable()->change();
        });
    }
};
