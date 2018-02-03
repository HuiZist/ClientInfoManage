<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatdefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statdefs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('btime');
            $table->date('etime');
            $table->integer('scount');
            $table->integer('stcount');
            $table->integer('acount');
            $table->integer('atcount');
            $table->integer('bcount');
            $table->integer('btcount');
            $table->integer('ccount');
            $table->integer('ctcount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statdefs');
    }
}
