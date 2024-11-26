<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCefCertificadoFeriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cef_certificado_feria', function (Blueprint $table) {
            $table->bigIncrements('cef_id');
            $table->text('ip');
            $table->text('usuario');
            $table->dateTime('fecha');
            $table->string('estado',2)->nullable(false);
            $table->text('fondo')->nullable(false);
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
        Schema::dropIfExists('cef_certificado_feria');
        Schema::enableForeignKeyConstraints();
    }
}
