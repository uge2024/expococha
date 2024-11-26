<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsInstitucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ins_institucion', function (Blueprint $table) {
            $table->integer('ins_id')->nullable(false)->unique();
            $table->string('sigla',50)->nullable(false);
            $table->string('nombre',200)->nullable(false);
            $table->text('descripcion')->nullable(false);
            $table->string('direccion',100)->nullable(false);
            $table->text('imagen_icono')->nullable(false);
            $table->text('imagen_reporte')->nullable(true);
            $table->text('imagen_banner')->nullable(true);
            $table->text('link_facebook')->nullable(true);
            $table->text('link_twiter')->nullable(true);
            $table->text('link_instagram')->nullable(true);
            $table->text('link_youtube')->nullable(true);
            $table->integer('celular')->nullable(false);
            $table->integer('celular_wp')->nullable(false);
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
        Schema::dropIfExists('ins_institucion');
        Schema::enableForeignKeyConstraints();
    }
}
