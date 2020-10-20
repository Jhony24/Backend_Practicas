<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvenioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convenio', function (Blueprint $table) {
            $table->increments("id");
            $table->uuid('externalid_convenio')->unique();

            $table->string('tipo_convenio',100);
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresas')
                ->onDelete('cascade');
            $table->date('fecha_inicio');
            $table->string('fecha_culminacion',100);
            $table->string('objeto',100);
            $table->integer('idcarrera')->unsigned();
            $table->foreign('idcarrera')->references('id')->on('carreras')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer("estado_convenio")->default(0);
            $table->string("archivo_convenio");
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
        Schema::dropIfExists('convenio');
    }
}
