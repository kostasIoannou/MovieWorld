<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('movie_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_8430449')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('movie_id');
            $table->foreign('movie_id', 'movie_id_fk_8430449')->references('id')->on('movies')->onDelete('cascade');
        });
    }
}
