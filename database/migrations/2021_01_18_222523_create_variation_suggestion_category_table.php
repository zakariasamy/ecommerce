<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationSuggestionCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_varsuggestion', function (Blueprint $table) {
            $table->foreignId('varsuggestion_id');
            $table->foreignId('category_id');
            $table->unique(['varsuggestion_id', 'category_id']);
            $table->foreign('varsuggestion_id')->references('id')->on('varsuggestions')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variation_suggestion_category');
    }
}
