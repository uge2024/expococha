<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpdValoracionProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpd_valoracion_producto', function (Blueprint $table) {
            $table->bigIncrements('vpd_id')->nullable(false);
            $table->integer('puntuacion')->nullable(false);
            $table->string('valoracion',500)->nullable(true);
            $table->dateTime('fecha')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('prd_id')->nullable(false);
            $table->integer('usr_id')->nullable(false);
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
            $table->foreign('prd_id')->references('prd_id')->on('prd_producto')->onDelete('cascade')
                ->dropForeign(['prd_id']);
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
        Schema::dropIfExists('vpd_valoracion_producto');
        Schema::enableForeignKeyConstraints();
    }
}
