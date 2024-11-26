<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCeeCertificadoEmitidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cee_certificado_emitido', function (Blueprint $table) {
            $table->bigIncrements('cee_id')->nullable(false);
            $table->date('fecha_emitido')->nullable(false);
            $table->date('fecha_reimpresion')->nullable(false);
            $table->text('codigo_qr')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('fec_id')->nullable(false);
            $table->integer('usr_id')->nullable(false);
            $table->foreign('fec_id')->references('fec_id')->on('fec_feria_certificado')->onDelete('cascade')->dropForeign(['fec_id']);
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')->dropForeign(['id']);
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
        Schema::dropIfExists('cee_certificado_emitido');
        Schema::enableForeignKeyConstraints();
    }
}
