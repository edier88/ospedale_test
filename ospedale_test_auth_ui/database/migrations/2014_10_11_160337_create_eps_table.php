<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_eps', function (Blueprint $table) {
            //$table->id();
            $table->tinyIncrements('id'); // Porque si se crea por como está configurada por defecto la linea de arriba, este campo será "Bigint"
            $table->string('nombre');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_eps');
    }
}
