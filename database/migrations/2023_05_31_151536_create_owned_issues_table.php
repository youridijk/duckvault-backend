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
        Schema::create('owned_issues', function (Blueprint $table) {
            $table->string('issue_code', 17);

            $table->foreign('issue_code')
                ->references('issuecode')
                ->on('inducks.issue')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->primary(['issue_code', 'user_id']);
            $table->index('user_id', 'fk_index_owned_issues_user_id');
            $table->index('issue_code', 'fk_index_owned_issues_issue_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_collections');
    }
};
