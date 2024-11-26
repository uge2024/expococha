<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('del_delivery', function (Blueprint $table) {
            $table->bigIncrements('del_id')->nullable(false);
            $table->string('razon_social',100)->nullable(false);
            $table->string('propietario',200)->nullable(true);
            $table->string('tipo_transporte',100)->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->integer('disponible')->nullable(false);
            $table->decimal('costo_minimo',10,2)->nullable(true);
            $table->decimal('costo_maximo',10,2)->nullable(true);
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
        Schema::dropIfExists('del_delivery');
        Schema::enableForeignKeyConstraints();
    }
}
