<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stat_titles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('s');
            $table->string('a');
            $table->string('b');
            $table->string('c');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stat_titles');
    }
}
