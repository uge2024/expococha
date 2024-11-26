<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpuTipoPublicidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpu_tipo_publicidad', function (Blueprint $table) {
            $table->bigIncrements('tpu_id')->nullable(false);
            $table->integer('tipo')->nullable(false);
            $table->text('nombre')->nullable(false);
            $table->integer('alto')->nullable(false);
            $table->integer('ancho')->nullable(false);
            $table->decimal('costo_pedido',10,2)->nullable(true);
            $table->integer('disponible')->nullable(false);
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
        Schema::dropIfExists('tpu_tipo_publicidad');
        Schema::enableForeignKeyConstraints();
    }
}
