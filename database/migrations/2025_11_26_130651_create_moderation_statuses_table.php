<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moderation_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('label', 50);
            $table->string('code', 20)->unique();
        });

        DB::table('moderation_statuses')->insert([
            ['label' => 'moderation.status.active',  'code' => 'ACTIVE'],
            ['label' => 'moderation.status.revoked', 'code' => 'REVOKED'],
            ['label' => 'moderation.status.expired', 'code' => 'EXPIRED'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('moderation_statuses');
    }
};
