<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBacBackupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bac_backup', function (Blueprint $table) {
            $table->bigIncrements('bac_id');
            $table->text('ip');
            $table->text('usuario');
            $table->dateTime('fecha');
            $table->text('archivo');
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
        Schema::dropIfExists('bac_backup');
        Schema::enableForeignKeyConstraints();
    }
}
