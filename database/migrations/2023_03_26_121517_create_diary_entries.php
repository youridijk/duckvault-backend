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
        Schema::create('diary_entries', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

//            $table->unsignedBigInteger('review_id'); // review stuff will be added later

            $table->boolean('reread');
            $table->boolean('spoilers');
            $table->boolean('liked');
            $table->date('read_on');

            $table->enum('related_entity_type', ['i', 's']);
            $table->unique(['id', 'related_entity_type']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diary_entries');
    }
};
