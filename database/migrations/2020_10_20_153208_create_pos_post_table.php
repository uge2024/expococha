<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_post', function (Blueprint $table) {
            $table->bigIncrements('pos_id');
            $table->string('titulo',100)->comment('nombre de esto')->nullable(true);
            $table->text('descripcion')->nullable(false);
            $table->date('fecha');
            $table->boolean('bandera')->default(true);
            $table->decimal('valor_a',10,2);
            $table->double('valor_b',10,2);
            $table->float('valor_c',10,2);
            $table->integer('valor_d',false,true)->default(1);
            $table->timestamp('fecha_hora',0)->useCurrent();


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
        Schema::dropIfExists('pos_post');
        Schema::enableForeignKeyConstraints();
    }
}
