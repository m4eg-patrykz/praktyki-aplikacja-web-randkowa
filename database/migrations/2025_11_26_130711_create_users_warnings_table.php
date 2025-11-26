<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_warnings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')
                  ->unique()
                  ->default(DB::raw('(UUID())'));

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignId('status_id')
                  ->constrained('moderation_statuses')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->text('reason')->nullable();
            $table->text('moderator_note')->nullable();

            $table->timestamps(); // created_at, updated_at
            $table->dateTime('revoked_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_warnings');
    }
};
