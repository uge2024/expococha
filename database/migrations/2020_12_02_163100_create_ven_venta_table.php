<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ven_venta', function (Blueprint $table) {
            $table->bigIncrements('ven_id')->nullable(false);
            $table->integer('tipo_pago')->nullable(false);
            $table->integer('estado_venta')->nullable(false);
            $table->integer('estado_delivery')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->integer('cantidad')->nullable(false);
            $table->decimal('precio_venta',10,2)->nullable(false);
            $table->decimal('subtotal',10,2)->nullable(false);
            $table->decimal('precio_base_delivery',10,2)->nullable(true);
            $table->dateTime('fecha')->nullable(false);
            $table->text('comprobante')->nullable(true);
            $table->bigInteger('prd_id')->nullable(true);
            $table->integer('usr_id')->nullable(false);
            $table->bigInteger('del_id')->nullable(false);
            $table->bigInteger('fpr_id')->nullable(true);
            $table->foreign('prd_id')->references('prd_id')->on('prd_producto')->onDelete('cascade')
                ->dropForeign(['prd_id']);
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
            $table->foreign('del_id')->references('del_id')->on('del_delivery')->onDelete('cascade')
                ->dropForeign(['del_id']);
            $table->foreign('fpr_id')->references('fpr_id')->on('fpr_feria_producto')->onDelete('cascade')
                ->dropForeign(['fpr_id']);
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
        Schema::dropIfExists('ven_venta');
        Schema::enableForeignKeyConstraints();
    }
}
