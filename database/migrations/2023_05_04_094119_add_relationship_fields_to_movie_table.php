<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMovieTable extends Migration
{
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->foreign('user_id', 'user_fk_8426189')->references('id')->on('users');
        });
    }
}
