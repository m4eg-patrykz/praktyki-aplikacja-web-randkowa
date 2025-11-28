<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')
                ->unique()
                ->default(DB::raw('(UUID())'));

            $table->string('email', 255);
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password', 255);

            $table->string('phone_code', 3)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->dateTime('phone_verified_at')->nullable();

            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->date('date_of_birth')->nullable();

            $table->foreignId('gender_id')
                ->nullable()
                ->constrained('genders')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->boolean('transgender')->default(false);

            $table->foreignId('sexual_orientation_id')
                ->nullable()
                ->constrained('sexual_orientations')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('role_id')
                ->nullable()
                ->default(1)
                ->constrained('roles')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();

            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
