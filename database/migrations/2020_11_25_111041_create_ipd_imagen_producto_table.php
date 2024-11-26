<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpdImagenProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipd_imagen_producto', function (Blueprint $table) {
            $table->bigIncrements('ipd_id')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->integer('alto')->nullable(false);
            $table->integer('ancho')->nullable(false);
            $table->integer('tipo')->nullable(true);
            $table->string('estado',2)->nullable(false);
            $table->string('numero_imagen',250)->nullable(false);
            $table->bigInteger('prd_id')->nullable(false);
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
        Schema::dropIfExists('ipd_imagen_producto');
        Schema::enableForeignKeyConstraints();
    }
}
