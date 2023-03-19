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
        Schema::create('user_list_stories', function (Blueprint $table) {
            $table->bigInteger('user_list_id')->unsigned();
            $table->foreign('user_list_id')
                ->references('id')
                ->on('user_lists')
                ->onDelete('cascade');

            $table->string('story_code');
            $table->foreign('story_code')
                ->references('storycode')
                ->on('inducks.story')
                ->onDelete('cascade');

            $table->primary(['user_list_id', 'story_code']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_list_stories');
    }
};
