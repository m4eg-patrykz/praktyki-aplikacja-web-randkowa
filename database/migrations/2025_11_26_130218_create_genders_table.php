<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->string('label', 20);
            $table->string('code', 5)->unique();
        });

        DB::table('genders')->insert([
            ['label' => 'gender.unknown',   'code' => 'U'],
            ['label' => 'gender.male',      'code' => 'M'],
            ['label' => 'gender.female',    'code' => 'F'],
            ['label' => 'gender.nonbinary', 'code' => 'NB'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('genders');
    }
};
