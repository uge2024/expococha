<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatCategoriaRubroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_categoria_rubro', function (Blueprint $table) {
            $table->bigIncrements('cat_id')->nullable(false);
            $table->bigInteger('rub_id')->nullable(false);
            $table->string('nombre',200)->nullable(false);
            $table->text('descripcion')->nullable(false);
            $table->integer('nivel')->nullable(false);
            $table->bigInteger('padre_id')->nullable(true);
            $table->string('estado',2)->nullable(false);

            $table->foreign('rub_id')->references('rub_id')->on('rub_rubro')->onDelete('cascade')
                ->dropForeign(['rub_id']);

            $table->foreign('padre_id')->references('cat_id')->on('cat_categoria_rubro')->onDelete('cascade')
                ->dropForeign(['cat_id']);

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
        Schema::dropIfExists('cat_categoria_rubro');
        Schema::enableForeignKeyConstraints();
    }
}
