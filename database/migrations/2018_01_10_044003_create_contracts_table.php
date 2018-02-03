<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('operator_account')->nullable();
            $table->string('operator_name')->nullable();
            $table->string('A')->nullable();
            $table->string('B')->nullable();
            $table->dateTime('C')->nullable();
            $table->string('D')->nullable();
            $table->text('E')->nullable();
            $table->text('F')->nullable();
            $table->text('G')->nullable();
            $table->text('H')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
