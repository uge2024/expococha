<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIfeImagenFeriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ife_imagen_feria', function (Blueprint $table) {
            $table->bigIncrements('ife_id')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->integer('alto')->nullable(false);
            $table->integer('ancho')->nullable(false);
            $table->integer('tipo')->nullable(true);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('fev_id')->nullable(false);
            $table->foreign('fev_id')->references('fev_id')->on('fev_feria_virtual')->onDelete('cascade')->dropForeign(['fev_id']);
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
        Schema::dropIfExists('ife_imagen_feria');
        Schema::enableForeignKeyConstraints();
    }
}
