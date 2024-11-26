<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFpdFeriaProductorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fpd_feria_productor', function (Blueprint $table) {
            $table->bigIncrements('fpd_id')->nullable(false);
            $table->date('fecha_inscripcion')->nullable(false);
            $table->integer('comprobante')->nullable(true);
            $table->decimal('monto',10,2)->nullable(true);
            $table->date('fecha_pago')->nullable(true);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('pro_id')->nullable(false);
            $table->bigInteger('fev_id')->nullable(false);
            $table->integer('usr_id')->nullable(false);
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
            $table->foreign('fev_id')->references('fev_id')->on('fev_feria_virtual')->onDelete('cascade')->dropForeign(['fev_id']);
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
        Schema::dropIfExists('fpd_feria_productor');
        Schema::enableForeignKeyConstraints();
    }
}
