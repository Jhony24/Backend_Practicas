<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practicas', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('externalid_practicas')->unique();
            $table->integer('tipo_practica')->default(0);
            $table->integer('cupos');
            $table->integer('horas_cumplir')->nullable();
            $table->integer('ciclo');
            $table->date('fecha_inicio');
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->double('salario')->nullable();
            $table->integer("ppestado")->default(0);

            $table->integer('idcarrera')->unsigned();
            $table->foreign('idcarrera')->references('id')->on('carreras')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idarea')->unsigned();
            $table->foreign('idarea')->references('id')->on('areas')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresas')
                ->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('practicas');
    }
}
