<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->dateTime('post_time')->nullable();
            $table->string('post_name')->nullable();
            $table->string('post_account')->nullable();
            $table->string('btype')->nullable();
            $table->string('stype')->nullable();
            $table->text('content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedures');
    }
}
