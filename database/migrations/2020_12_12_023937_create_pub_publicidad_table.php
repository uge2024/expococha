<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePubPublicidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pub_publicidad', function (Blueprint $table) {
            $table->bigIncrements('pub_id')->nullable(false);
            $table->date('fecha_desde')->nullable(false);
            $table->date('fecha_hasta')->nullable(false);
            $table->string('solicitante',200)->nullable(false);
            $table->string('documento',200)->nullable(false);
            $table->text('doc_pago')->nullable(true);
            $table->date('fecha_pago')->nullable(true);
            $table->decimal('monto',10,2)->nullable(true);
            $table->text('link_destino')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('tpu_id')->nullable(false);
            $table->foreign('tpu_id')->references('tpu_id')->on('tpu_tipo_publicidad')->onDelete('cascade')
                ->dropForeign(['tpu_id']);
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
        Schema::dropIfExists('pub_publicidad');
        Schema::enableForeignKeyConstraints();
    }
}
