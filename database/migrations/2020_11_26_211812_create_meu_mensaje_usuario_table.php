<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeuMensajeUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meu_mensaje_usuario', function (Blueprint $table) {
            $table->bigIncrements('meu_id')->nullable(false);
            $table->text('mensaje')->nullable(false);
            $table->dateTime('fecha')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->integer('visto')->nullable(false);
            $table->integer('usr_id_r')->nullable(false);
            $table->integer('usr_id_e')->nullable(false);

            $table->foreign('usr_id_r')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
            $table->foreign('usr_id_e')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
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
        Schema::dropIfExists('meu_mensaje_usuario');
        Schema::enableForeignKeyConstraints();
    }
}
