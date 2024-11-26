<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFprFeriaProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fpr_feria_producto', function (Blueprint $table) {
            $table->bigIncrements('fpr_id')->nullable(false);
            $table->string('nombre_producto',255)->nullable(false);
            $table->integer('existencia')->nullable(false);
            $table->integer('puntuacion')->nullable(false);
            $table->string('descripcion1',200)->nullable(false);
            $table->text('descripcion2')->nullable(false);
            $table->decimal('precio',10,2)->nullable(false);
            $table->decimal('precio_oferta',10,2)->nullable(true);
            $table->integer('descuento')->nullable(true);
            $table->integer('existencia_minima')->nullable(false);
            $table->date('fecha_registro')->nullable(false);
            $table->date('fecha_modificacion')->nullable(true);
            $table->text('codigo_qr_venta')->nullable(true);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('cat_id')->nullable(false);
            $table->bigInteger('pro_id')->nullable(false);
            $table->bigInteger('prd_id')->nullable(true);//cuando es nuevo
            $table->bigInteger('fpd_id')->nullable(false);
            $table->date('fecha_inicio_oferta')->nullable(true);
            $table->date('fecha_fin_oferta')->nullable(true);
            $table->foreign('cat_id')->references('cat_id')->on('cat_categoria_rubro')->onDelete('cascade')
                ->dropForeign(['cat_id']);
            $table->foreign('pro_id')->references('pro_id')->on('pro_productor')->onDelete('cascade')
                ->dropForeign(['pro_id']);
            $table->foreign('prd_id')->references('prd_id')->on('prd_producto')->onDelete('cascade')
                ->dropForeign(['prd_id']);
            $table->foreign('fpd_id')->references('fpd_id')->on('fpd_feria_productor')->onDelete('cascade')
                ->dropForeign(['fpd_id']);
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
        Schema::dropIfExists('fpr_feria_producto');
        Schema::enableForeignKeyConstraints();
    }
}
