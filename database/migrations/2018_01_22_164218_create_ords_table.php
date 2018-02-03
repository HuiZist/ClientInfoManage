<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ords', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('conStr');
            $table->string('conOrd');
            $table->string('cliStr');
            $table->string('cliOrd');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ords');
    }
}
