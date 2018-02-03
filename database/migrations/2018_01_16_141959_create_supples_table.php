<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supples', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('content')->nullable();
            $table->string('pro_id')->nullable();
            $table->string('post_name')->nullable();
            $table->string('post_account')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supples');
    }
}
