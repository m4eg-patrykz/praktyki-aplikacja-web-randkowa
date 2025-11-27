<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('genders_pairing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_gender_id')
                  ->nullable()
                  ->constrained('genders')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->foreignId('pair_gender_id')
                  ->nullable()
                  ->constrained('genders')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->foreignId('sexual_orientation_id')
                  ->nullable()
                  ->constrained('sexual_orientations')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->unique(
                ['base_gender_id', 'pair_gender_id', 'sexual_orientation_id'],
                'gender_pair_unique'
            );
        });

        DB::table('genders_pairing')->insert([
            // hetero
            ['base_gender_id' => 2, 'pair_gender_id' => 3, 'sexual_orientation_id' => 1],
            ['base_gender_id' => 3, 'pair_gender_id' => 2, 'sexual_orientation_id' => 1],

            // homo
            ['base_gender_id' => 2, 'pair_gender_id' => 2, 'sexual_orientation_id' => 2],
            ['base_gender_id' => 3, 'pair_gender_id' => 3, 'sexual_orientation_id' => 2],
            ['base_gender_id' => 4, 'pair_gender_id' => 4, 'sexual_orientation_id' => 2],

            // bi
            ['base_gender_id' => 2, 'pair_gender_id' => 2, 'sexual_orientation_id' => 3],
            ['base_gender_id' => 2, 'pair_gender_id' => 3, 'sexual_orientation_id' => 3],
            ['base_gender_id' => 3, 'pair_gender_id' => 2, 'sexual_orientation_id' => 3],
            ['base_gender_id' => 3, 'pair_gender_id' => 3, 'sexual_orientation_id' => 3],
            ['base_gender_id' => 4, 'pair_gender_id' => 2, 'sexual_orientation_id' => 3],
            ['base_gender_id' => 4, 'pair_gender_id' => 3, 'sexual_orientation_id' => 3],
            ['base_gender_id' => 4, 'pair_gender_id' => 4, 'sexual_orientation_id' => 3],

            // pan
            ['base_gender_id' => 2, 'pair_gender_id' => 2, 'sexual_orientation_id' => 4],
            ['base_gender_id' => 2, 'pair_gender_id' => 3, 'sexual_orientation_id' => 4],
            ['base_gender_id' => 2, 'pair_gender_id' => 4, 'sexual_orientation_id' => 4],
            ['base_gender_id' => 3, 'pair_gender_id' => 2, 'sexual_orientation_id' => 4],
            ['base_gender_id' => 3, 'pair_gender_id' => 3, 'sexual_orientation_id' => 4],
            ['base_gender_id' => 3, 'pair_gender_id' => 4, 'sexual_orientation_id' => 4],
            ['base_gender_id' => 4, 'pair_gender_id' => 2, 'sexual_orientation_id' => 4],
            ['base_gender_id' => 4, 'pair_gender_id' => 3, 'sexual_orientation_id' => 4],
            ['base_gender_id' => 4, 'pair_gender_id' => 4, 'sexual_orientation_id' => 4],

            // ace
            ['base_gender_id' => 2, 'pair_gender_id' => 2, 'sexual_orientation_id' => 5],
            ['base_gender_id' => 3, 'pair_gender_id' => 3, 'sexual_orientation_id' => 5],
            ['base_gender_id' => 4, 'pair_gender_id' => 4, 'sexual_orientation_id' => 5],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('genders_pairing');
    }
};
