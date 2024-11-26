<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudAuditoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aud_auditoria', function (Blueprint $table) {
            $table->bigIncrements('aud_id');
            $table->text('ip');
            $table->text('tabla');
            $table->text('usuario');
            $table->dateTime('fecha');
            $table->text('accion');
            $table->text('datos');
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
        Schema::dropIfExists('aud_auditoria');
        Schema::enableForeignKeyConstraints();
    }
}
