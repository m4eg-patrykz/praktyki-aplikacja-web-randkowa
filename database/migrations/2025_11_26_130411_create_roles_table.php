<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('label', 50);
            $table->string('code', 10)->unique();
            $table->timestamps();
        });

        DB::table('roles')->insert([
            ['label' => 'Użytkownik',    'code' => 'USER',  'created_at' => now(), 'updated_at' => now()],
            ['label' => 'Moderator',     'code' => 'MOD',   'created_at' => now(), 'updated_at' => now()],
            ['label' => 'Administrator', 'code' => 'ADMIN', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
