<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('externalid_empresas')->unique();
            $table->string('nombreempresa',200);
            $table->string('tipo_empresa',100);
            $table->string('nombrerepresentante',100);
            $table->string('ruc',13);
            $table->string('direccion',150);
            $table->string('telefono');
            $table->string('correo');
            $table->string('actividades',200)->nullable();
            $table->integer('idcarrera')->unsigned();
            $table->foreign('idcarrera')->references('id')->on('carreras')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('estadoempresa')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
