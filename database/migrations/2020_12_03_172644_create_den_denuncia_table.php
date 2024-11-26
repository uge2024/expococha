<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenDenunciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('den_denuncia', function (Blueprint $table) {
            $table->bigIncrements('den_id')->nullable(false);
            $table->text('denuncia')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->integer('estado_visto')->nullable(false);
            $table->dateTime('fecha')->nullable(false);
            $table->bigInteger('pro_id')->nullable(true);
            $table->bigInteger('prd_id')->nullable(true);
            $table->integer('usr_id')->nullable(false);
           // $table->bigInteger('fpr_id')->nullable(true);

            $table->foreign('pro_id')->references('pro_id')->on('pro_productor')->onDelete('cascade')->dropForeign(['pro_id']);
            $table->foreign('prd_id')->references('prd_id')->on('prd_producto')->onDelete('cascade')->dropForeign(['prd_id']);
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')->dropForeign(['id']);
            //$table->foreign('fpr_id')->references('fpr_id')->on('pro_productor')->onDelete('cascade')->dropForeign(['fpr_id']);
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
        Schema::dropIfExists('den_denuncia');
        Schema::enableForeignKeyConstraints();
    }
}
