<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsoAsociacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aso_asociacion', function (Blueprint $table) {
            $table->bigIncrements('aso_id')->nullable(false);
            $table->string('sigla',50)->nullable(false);
            $table->string('nombre',500)->nullable(false);
            $table->text('actividad')->nullable(false);
            $table->string('direccion',200)->nullable(false);
            $table->integer('telefono')->nullable(true);
            $table->integer('celular')->nullable(true);
            $table->string('estado',2)->nullable(false);
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
        Schema::dropIfExists('aso_asociacion');
        Schema::enableForeignKeyConstraints();
    }
}
