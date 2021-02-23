<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->BigInteger('documento')->unique()->unsigned();
            $table->string('password');
            $table->char('genero');
            $table->date('fecha_nacimiento');
            $table->BigInteger('telefono')->unsigned();
            $table->TinyInteger('eps_id')->unsigned();
            $table->foreign('eps_id')->references('id')->on('tb_eps'); // Pongo un constraint con Foreign Key
            $table->TinyInteger('rol_id')->unsigned();
            $table->foreign('rol_id')->references('id')->on('tb_roles'); // Pongo un constraint con Foreign Key
            $table->dateTime('create_at_datetime');

        });

        /*
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_usuarios');
    }
}
