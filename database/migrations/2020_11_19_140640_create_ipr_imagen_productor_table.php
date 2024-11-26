<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIprImagenProductorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipr_imagen_productor', function (Blueprint $table) {
            $table->bigIncrements('ipd_id')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->integer('alto')->nullable(false);
            $table->integer('ancho')->nullable(false);
            $table->integer('tipo')->nullable(true);
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
        Schema::dropIfExists('ipr_imagen_productor');
        Schema::enableForeignKeyConstraints();
    }
}
