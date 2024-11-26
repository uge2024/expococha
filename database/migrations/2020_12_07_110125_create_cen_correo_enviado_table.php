<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCenCorreoEnviadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cen_correo_enviado', function (Blueprint $table) {
            $table->bigIncrements('cen_id')->nullable(false);
            $table->text('enviado_por')->nullable(false);
            $table->text('enviado_a')->nullable(false);
            $table->text('asunto')->nullable(false);
            $table->text('descripcion')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('pro_id')->nullable(false);
            $table->foreign('pro_id')->references('pro_id')->on('pro_productor')->onDelete('cascade')
                ->dropForeign(['pro_id']);
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
        Schema::dropIfExists('cen_correo_enviado');
        Schema::enableForeignKeyConstraints();
    }
}
