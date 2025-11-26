<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sexual_orientations', function (Blueprint $table) {
            $table->id();
            $table->string('label', 50);
            $table->string('code', 20)->unique();
        });

        DB::table('sexual_orientations')->insert([
            ['label' => 'heterosexual', 'code' => 'HETERO'],
            ['label' => 'homosexual',   'code' => 'HOMO'],
            ['label' => 'bisexual',     'code' => 'BI'],
            ['label' => 'pansexual',    'code' => 'PAN'],
            ['label' => 'asexual',      'code' => 'ACE'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('sexual_orientations');
    }
};
