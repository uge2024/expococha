<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProProductorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_productor', function (Blueprint $table) {
            $table->bigIncrements('pro_id')->nullable(false);
            $table->string('nombre_propietario',255)->nullable(false);
            $table->date('fecha_registro')->nullable(false);
            $table->text('direccion')->nullable(false);
            $table->integer('telefono_1')->nullable(true);
            $table->integer('telefono_2')->nullable(true);
            $table->integer('celular')->nullable(false);
            $table->integer('celular_wp')->nullable(false);
            $table->string('nombre_tienda',255)->nullable(false);
            $table->string('actividad',500)->nullable(false);
            $table->string('email',255)->nullable(false);
            $table->decimal('longitud',20,10)->nullable(true);
            $table->decimal('latitud',20,10)->nullable(true);
            $table->text('link_facebook')->nullable(true);
            $table->text('link_twiter')->nullable(true);
            $table->text('link_instagram')->nullable(true);
            $table->text('link_youtube')->nullable(true);
            $table->string('estado',2)->nullable(false);
            $table->string('estado_tienda',2)->nullable(false);
            $table->integer('puntuacion')->nullable(false);
            $table->string('entidad_financiera',500)->nullable(true);
            $table->string('cuenta',100)->nullable(true);
            $table->string('titular_cuenta',200)->nullable(true);
            $table->integer('usr_id')->nullable(false)->unique(true);
            $table->bigInteger('rub_id')->nullable(false);
            $table->bigInteger('aso_id')->nullable(false);
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
            $table->foreign('rub_id')->references('rub_id')->on('rub_rubro')->onDelete('cascade')
                ->dropForeign(['rub_id']);
            $table->foreign('aso_id')->references('aso_id')->on('aso_asociacion')->onDelete('cascade')
                ->dropForeign(['aso_id']);

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
        Schema::dropIfExists('pro_productor');
        Schema::enableForeignKeyConstraints();
    }
}
