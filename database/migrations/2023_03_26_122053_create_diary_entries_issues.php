<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('diary_entries_issues', function (Blueprint $table) {
            $table->string('issue_code', 17);

            $table->foreign('issue_code')
                ->references('issuecode')
                ->on('inducks.issue');

            $table->unsignedBigInteger('diary_entry_id');
            $table->char('diary_entry_related_entity_type', 1)
                ->default('i');

            $table->foreign(['diary_entry_id', 'diary_entry_related_entity_type'])
                ->references(['id', 'related_entity_type'])
                ->on('diary_entries');

            $table->primary(['issue_code', 'diary_entry_id']);


//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diary_entries_issues');
    }
};
