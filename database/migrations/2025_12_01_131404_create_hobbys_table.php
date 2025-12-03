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
               ['label' => 'hobby.running', 'code' => 'RUNNING'],
               ['label' => 'hobby.fitness', 'code' => 'FITNESS'],
               ['label' => 'hobby.gym', 'code' => 'GYM'],
               ['label' => 'hobby.yoga', 'code' => 'YOGA'],
               ['label' => 'hobby.climbing', 'code' => 'CLIMBING'],

               ['label' => 'hobby.music', 'code' => 'MUSIC'],
               ['label' => 'hobby.guitar', 'code' => 'GUITAR'],
               ['label' => 'hobby.piano', 'code' => 'PIANO'],
               ['label' => 'hobby.singing', 'code' => 'SINGING'],
               ['label' => 'hobby.music_production', 'code' => 'MUSIC_PROD'],
               ['label' => 'hobby.dj', 'code' => 'DJ'],

               ['label' => 'hobby.movies', 'code' => 'MOVIES'],
               ['label' => 'hobby.series', 'code' => 'SERIES'],
               ['label' => 'hobby.cinema', 'code' => 'CINEMA'],
               ['label' => 'hobby.anime', 'code' => 'ANIME'],
               ['label' => 'hobby.theatre', 'code' => 'THEATRE'],

               ['label' => 'hobby.reading', 'code' => 'READING'],
               ['label' => 'hobby.fantasy', 'code' => 'FANTASY'],
               ['label' => 'hobby.scifi', 'code' => 'SCIFI'],
               ['label' => 'hobby.crime', 'code' => 'CRIME'],
               ['label' => 'hobby.biography', 'code' => 'BIOGRAPHY'],

               ['label' => 'hobby.programming', 'code' => 'PROGRAMMING'],
               ['label' => 'hobby.frontend', 'code' => 'FRONTEND'],
               ['label' => 'hobby.backend', 'code' => 'BACKEND'],
               ['label' => 'hobby.devops', 'code' => 'DEVOPS'],
               ['label' => 'hobby.ai', 'code' => 'AI'],
               ['label' => 'hobby.security', 'code' => 'SECURITY'],

               ['label' => 'hobby.gaming', 'code' => 'GAMING'],
               ['label' => 'hobby.esport', 'code' => 'ESPORT'],
               ['label' => 'hobby.board_games', 'code' => 'BOARD_GAMES'],
               ['label' => 'hobby.rpg', 'code' => 'RPG'],

               ['label' => 'hobby.travel', 'code' => 'TRAVEL'],
               ['label' => 'hobby.mountains', 'code' => 'MOUNTAINS'],
               ['label' => 'hobby.camping', 'code' => 'CAMPING'],
               ['label' => 'hobby.citybreak', 'code' => 'CITYBREAK'],

               ['label' => 'hobby.photography', 'code' => 'PHOTOGRAPHY'],
               ['label' => 'hobby.video', 'code' => 'VIDEO'],
               ['label' => 'hobby.graphics', 'code' => 'GRAPHICS'],
               ['label' => 'hobby.print3d', 'code' => 'PRINT3D'],

               ['label' => 'hobby.cooking', 'code' => 'COOKING'],
               ['label' => 'hobby.baking', 'code' => 'BAKING'],
               ['label' => 'hobby.vegan', 'code' => 'VEGAN'],
               ['label' => 'hobby.asianfood', 'code' => 'ASIANFOOD'],

               ['label' => 'hobby.automotive', 'code' => 'AUTOMOTIVE'],
               ['label' => 'hobby.motorcycles', 'code' => 'MOTORCYCLES'],
               ['label' => 'hobby.detailing', 'code' => 'DETAILING'],

               ['label' => 'hobby.fashion', 'code' => 'FASHION'],
               ['label' => 'hobby.streetwear', 'code' => 'STREETWEAR'],

               ['label' => 'hobby.selfdev', 'code' => 'SELFDEV'],
               ['label' => 'hobby.meditation', 'code' => 'MEDITATION'],
               ['label' => 'hobby.psychology', 'code' => 'PSYCHOLOGY'],

               ['label' => 'hobby.business', 'code' => 'BUSINESS'],
               ['label' => 'hobby.investing', 'code' => 'INVESTING'],
               ['label' => 'hobby.marketing', 'code' => 'MARKETING'],
               ['label' => 'hobby.ecommerce', 'code' => 'ECOMMERCE'],
           ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('hobbys');
    }
};
