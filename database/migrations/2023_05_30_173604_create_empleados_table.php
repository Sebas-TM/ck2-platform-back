<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',30);
            $table->string('apellido_paterno',30);
            $table->string('apellido_materno',30);
            $table->string('imagen',255);
            $table->string('estado',30);
            $table->integer('dni')->unique();
            $table->string('correo',80);
            $table->integer('celular');
            $table->string('nombre_contacto',80)->nullable();
            $table->integer('numero_contacto')->nullable();
            $table->string('relacion_contacto',30)->nullable();
            $table->string('area',30);
            $table->string('puesto',30);
            $table->string('jefe_inmediato',30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
