<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id')
                  ->constrained('permissions')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->foreignId('role_id')
                  ->constrained('roles')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->boolean('granted')->default(false);
            $table->timestamps();

            $table->unique(['permission_id', 'role_id'], 'role_permission_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles_permissions');
    }
};
