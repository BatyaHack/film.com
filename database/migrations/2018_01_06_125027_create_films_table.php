<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('year');
            // $table->unique(['title', 'year'], 'id_film'); ???
            $table->string('rated')->nullable();
            $table->date('released')->nullable();
            $table->integer('runtime')->nullable();
            // Сделать возможность жанров. Только через связные таблицы. Как то потом
            // Так же возможность актоеров через связные списки
            $table->string('director')->nullable();
            $table->string('awards')->nullable();
            $table->string('path_to_poster')->nullable();
            $table->double('imdb_rating', 4, 2)->nullable(); // всего 4 цифры, 2-ве после
            $table->json('other_rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('films');
    }
}
