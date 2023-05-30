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
            $table->string('estado',30);
            $table->integer('dni');
            $table->string('correo',80);
            $table->integer('telefono');
            $table->string('area',30);
            $table->integer('sala');
            $table->string('cargo',30);
            $table->string('jefe_directo',30);
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
