<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationSuggestionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('varsuggestion_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('varsuggestion_id');
            $table->string('locale');
            $table->json('name');
            $table->unique(['varsuggestion_id','locale']);
            $table->foreign('varsuggestion_id')->references('id')->on('varsuggestions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variation_suggestion_translations');
    }
}
