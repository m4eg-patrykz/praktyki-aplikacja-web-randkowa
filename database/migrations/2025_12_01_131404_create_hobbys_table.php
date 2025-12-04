<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hobbys', function (Blueprint $table) {
            $table->id();
            $table->string('label', 100);
            $table->string('code')->unique();
        });

        DB::table('hobbys')->insert([
               ['label' => 'hobby.sport', 'code' => 'SPORT'],
               ['label' => 'hobby.football', 'code' => 'FOOTBALL'],
               ['label' => 'hobby.basketball', 'code' => 'BASKETBALL'],
               ['label' => 'hobby.volleyball', 'code' => 'VOLLEYBALL'],
               ['label' => 'hobby.tennis', 'code' => 'TENNIS'],
               ['label' => 'hobby.gym', 'code' => 'GYM'],
               ['label' => 'hobby.yoga', 'code' => 'YOGA'],

               ['label' => 'hobby.music', 'code' => 'MUSIC'],
               ['label' => 'hobby.singing', 'code' => 'SINGING'],

               ['label' => 'hobby.movies', 'code' => 'MOVIES'],
               ['label' => 'hobby.anime', 'code' => 'ANIME'],
               ['label' => 'hobby.theatre', 'code' => 'THEATRE'],

               ['label' => 'hobby.reading', 'code' => 'READING'],

               ['label' => 'hobby.programming', 'code' => 'PROGRAMMING'],

               ['label' => 'hobby.gaming', 'code' => 'GAMING'],

               ['label' => 'hobby.travel', 'code' => 'TRAVEL'],
               ['label' => 'hobby.mountains', 'code' => 'MOUNTAINS'],
               ['label' => 'hobby.camping', 'code' => 'CAMPING'],

               ['label' => 'hobby.photography', 'code' => 'PHOTOGRAPHY'],
               ['label' => 'hobby.graphics', 'code' => 'GRAPHICS'],

               ['label' => 'hobby.cooking', 'code' => 'COOKING'],
               ['label' => 'hobby.baking', 'code' => 'BAKING'],

               ['label' => 'hobby.automotive', 'code' => 'AUTOMOTIVE'],
               ['label' => 'hobby.motorcycles', 'code' => 'MOTORCYCLES'],

               ['label' => 'hobby.fashion', 'code' => 'FASHION'],

               ['label' => 'hobby.meditation', 'code' => 'MEDITATION'],
               ['label' => 'hobby.psychology', 'code' => 'PSYCHOLOGY'],

               ['label' => 'hobby.business', 'code' => 'BUSINESS'],
               ['label' => 'hobby.marketing', 'code' => 'MARKETING'],
           ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('hobbys');
    }
};
