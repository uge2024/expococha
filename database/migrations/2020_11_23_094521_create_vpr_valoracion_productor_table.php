<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVprValoracionProductorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpr_valoracion_productor', function (Blueprint $table) {
            $table->bigIncrements('vpr_id')->nullable(false);
            $table->integer('puntuacion')->nullable(false);
            $table->string('valoracion',500)->nullable(true);
            $table->dateTime('fecha')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('pro_id')->nullable(false);
            $table->integer('usr_id')->nullable(false);
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
            $table->foreign('pro_id')->references('pro_id')->on('pro_productor')->onDelete('cascade')
                ->dropForeign(['pro_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('vpr_valoracion_productor');
        Schema::enableForeignKeyConstraints();
    }
}
