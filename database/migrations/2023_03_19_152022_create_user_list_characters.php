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
        Schema::create('character_user_list', function (Blueprint $table) {
            $table->bigInteger('user_list_id')->unsigned();
            $table->foreign('user_list_id')
                ->references('id')
                ->on('user_lists')
                ->onDelete('cascade');

            $table->string('character_code');
            $table->foreign('character_code')
                ->references('charactercode')
                ->on('inducks.character')
                ->onDelete('cascade');

            $table->primary(['user_list_id', 'character_code']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_user_list');
    }
};
