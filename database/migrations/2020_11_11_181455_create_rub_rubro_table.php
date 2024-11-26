<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubRubroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rub_rubro', function (Blueprint $table) {
            $table->bigIncrements('rub_id')->nullable(false);
            $table->string('nombre',200)->nullable(false);
            $table->text('descripcion')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->text('imagen_banner')->nullable(true);
            $table->text('imagen_icono')->nullable(true);
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
        Schema::dropIfExists('rub_rubro');
        Schema::enableForeignKeyConstraints();
    }
}
