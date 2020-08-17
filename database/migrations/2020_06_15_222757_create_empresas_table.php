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
            $table->string('nombreempresa',100)->unique();
            $table->string('tipo_empresa',100);
            $table->string('nombrerepresentante',100);
            $table->integer('ruc')->unique();
            $table->string('direccion',100);
            $table->string('telefono',10)->unique();
            $table->string('correo',100)->unique();
            $table->string('actividades',300)->nullable();
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
