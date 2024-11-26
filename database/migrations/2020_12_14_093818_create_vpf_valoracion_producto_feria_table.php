<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpfValoracionProductoFeriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpf_valoracion_producto_feria', function (Blueprint $table) {
            $table->bigIncrements('vpf_id')->nullable(false);
            $table->integer('puntuacion')->nullable(false);
            $table->string('valoracion',500)->nullable(true);
            $table->dateTime('fecha')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->integer('usr_id')->nullable(false);
            $table->bigInteger('fpr_id')->nullable(false);
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('vpf_valoracion_producto_feria');
        Schema::enableForeignKeyConstraints();

    }
}
