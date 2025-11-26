<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sexual_orientations_pairing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_orientation_id')
                  ->constrained('sexual_orientations')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->foreignId('pair_orientation_id')
                  ->constrained('sexual_orientations')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->unique(['base_orientation_id', 'pair_orientation_id'], 'orientation_pair_unique');
        });

        DB::table('sexual_orientations_pairing')->insert([
            // hetero
            ['base_orientation_id' => 1, 'pair_orientation_id' => 1],
            ['base_orientation_id' => 1, 'pair_orientation_id' => 3],
            ['base_orientation_id' => 1, 'pair_orientation_id' => 4],

            // homo
            ['base_orientation_id' => 2, 'pair_orientation_id' => 2],
            ['base_orientation_id' => 2, 'pair_orientation_id' => 3],
            ['base_orientation_id' => 2, 'pair_orientation_id' => 4],

            // bi
            ['base_orientation_id' => 3, 'pair_orientation_id' => 1],
            ['base_orientation_id' => 3, 'pair_orientation_id' => 2],
            ['base_orientation_id' => 3, 'pair_orientation_id' => 3],
            ['base_orientation_id' => 3, 'pair_orientation_id' => 4],

            // pan
            ['base_orientation_id' => 4, 'pair_orientation_id' => 1],
            ['base_orientation_id' => 4, 'pair_orientation_id' => 2],
            ['base_orientation_id' => 4, 'pair_orientation_id' => 3],
            ['base_orientation_id' => 4, 'pair_orientation_id' => 4],
            ['base_orientation_id' => 4, 'pair_orientation_id' => 5],

            // ace
            ['base_orientation_id' => 5, 'pair_orientation_id' => 5],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('sexual_orientations_pairing');
    }
};
