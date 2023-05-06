<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieVotesTable extends Migration
{
    public function up()
    {
        Schema::create('movie_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('movie_id');
            $table->boolean('liked');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'movie_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });
    }
}
