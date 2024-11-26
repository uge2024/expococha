<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFevFeriaVirtualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fev_feria_virtual', function (Blueprint $table) {
            $table->bigIncrements('fev_id')->nullable(false);
            $table->string('version',255)->nullable(false);
            $table->string('nombre',350)->nullable(false);
            $table->text('descripcion')->nullable(false);
            $table->date('fecha_inicio')->nullable(false);
            $table->date('fecha_final')->nullable(true);
            $table->string('lugar',350)->nullable(false);
            $table->text('direccion')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->decimal('longitud',20,10)->nullable(true);
            $table->decimal('latitud',20,10)->nullable(true);
            $table->bigInteger('rub_id')->nullable(false);
            $table->foreign('rub_id')->references('rub_id')->on('rub_rubro')->onDelete('cascade')
                ->dropForeign(['rub_id']);
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
        Schema::dropIfExists('fev_feria_virtual');
        Schema::enableForeignKeyConstraints();
    }
}
