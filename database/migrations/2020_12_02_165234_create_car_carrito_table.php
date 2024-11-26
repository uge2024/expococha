<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarCarritoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_carrito', function (Blueprint $table) {
            $table->bigIncrements('car_id')->nullable(false);
            $table->integer('cantidad')->nullable(false);
            $table->decimal('precio_venta',10,2)->nullable(true);
            $table->dateTime('fecha')->nullable(false);
            $table->decimal('precio_base_delivery',10,2)->nullable(true);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('prd_id')->nullable(false);
            $table->integer('usr_id')->nullable(false);

            $table->foreign('prd_id')->references('prd_id')->on('prd_producto')->onDelete('cascade')
                ->dropForeign(['prd_id']);
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
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
        Schema::dropIfExists('car_carrito');
        Schema::enableForeignKeyConstraints();

    }
}
