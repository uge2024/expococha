<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpfImagenProductoFeriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipf_imagen_producto_feria', function (Blueprint $table) {
            $table->bigIncrements('ipf_id')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->integer('alto')->nullable(false);
            $table->integer('ancho')->nullable(false);
            $table->integer('tipo')->nullable(true);
            $table->string('estado',2)->nullable(false);
            $table->string('numero_imagen',250)->nullable(false);
            $table->bigInteger('fpr_id')->nullable(false);
            $table->foreign('fpr_id')->references('fpr_id')->on('fpr_feria_producto')->onDelete('cascade')
                ->dropForeign(['fpr_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ipf_imagen_producto_feria');
    }
}
