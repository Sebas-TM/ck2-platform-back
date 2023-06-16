<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',30);
            $table->string('apellido_paterno',30);
            $table->string('apellido_materno',30);
            $table->integer('dni')->unique();
            $table->string('imagen',255)->nullable();
            $table->string('username',30)->unique();
            $table->string('password',80);
            $table->integer('isAdmin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
