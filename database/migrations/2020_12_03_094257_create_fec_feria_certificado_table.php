<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFecFeriaCertificadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fec_feria_certificado', function (Blueprint $table) {
            $table->bigIncrements('fec_id')->nullable(false);
            $table->date('fecha')->nullable(false);
            $table->text('firma1')->nullable(false);
            $table->text('firma2')->nullable(true);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('fev_id')->nullable(false);
            $table->integer('usr_id')->nullable(false);
            $table->foreign('fev_id')->references('fev_id')->on('fev_feria_virtual')->onDelete('cascade')->dropForeign(['fev_id']);
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
        Schema::dropIfExists('fec_feria_certificado');
        Schema::enableForeignKeyConstraints();
    }
}
