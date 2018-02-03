<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_titles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('A')->nullable();
            $table->string('B')->nullable();
            $table->string('C')->nullable();
            $table->string('D')->nullable();
            $table->string('E')->nullable();
            $table->string('F')->nullable();
            $table->string('G')->nullable();
            $table->string('H')->nullable();
            $table->string('I')->nullable();
            $table->string('J')->nullable();
            $table->string('K')->nullable();
            $table->string('L')->nullable();
            $table->string('M')->nullable();
            $table->string('N')->nullable();
            $table->string('O')->nullable();
            $table->string('P')->nullable();
            $table->string('Q')->nullable();
            $table->string('R')->nullable();
            $table->string('S')->nullable();
            $table->string('T')->nullable();
            $table->string('U')->nullable();
            $table->string('V')->nullable();
            $table->string('W')->nullable();
            $table->string('X')->nullable();
            $table->string('Y')->nullable();
            $table->string('Z')->nullable();
            $table->string('AA')->nullable();
            $table->string('AB')->nullable();
            $table->string('AC')->nullable();
            $table->string('AD')->nullable();
            $table->string('AE')->nullable();
            $table->string('AF')->nullable();
            $table->string('AG')->nullable();
            $table->string('AH')->nullable();
            $table->string('AI')->nullable();
            $table->string('AJ')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_titles');
    }
}
