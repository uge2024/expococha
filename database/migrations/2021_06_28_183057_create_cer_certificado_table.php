<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCerCertificadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cer_certificado', function (Blueprint $table) {
            $table->bigIncrements('cer_id');
            $table->text('ip');
            $table->text('usuario');
            $table->dateTime('fecha');
            $table->text('codigo');
            $table->text('nombre');
            $table->text('feria');
            $table->text('version');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->string('estado',2);
            $table->unsignedBigInteger('pro_id');
            $table->unsignedBigInteger('fev_id');
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
        Schema::dropIfExists('cer_certificado');
        Schema::enableForeignKeyConstraints();
    }
}
