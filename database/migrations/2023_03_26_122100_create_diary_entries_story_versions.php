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
        Schema::create('diary_entries_story_versions', function (Blueprint $table) {
            $table->string('story_version_code', 19);

            $table->foreign('story_version_code')
                ->references('storyversioncode')
                ->on('inducks.storyversion');

            $table->unsignedBigInteger('diary_entry_id');
            $table->char('diary_entry_related_entity_type', 1)
                ->default('s');

            $table->foreign(['diary_entry_id', 'diary_entry_related_entity_type'])
                ->references(['id', 'related_entity_type'])
                ->on('diary_entries');

            $table->primary(['story_version_code', 'diary_entry_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diary_entries_story_versions');
    }
};
