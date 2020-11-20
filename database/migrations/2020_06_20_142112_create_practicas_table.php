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
            $table->integer('horas_cumplir');
            $table->string('ciclo_necesario')->nullable();
            $table->date('fecha_inicio');
            $table->text('hora_entrada')->nullable();
            $table->text('hora_salida')->nullable();
            $table->text('salario')->nullable()->default(0.0);
            $table->string('actividades')->nullable();
            $table->string('requerimientos')->nullable();
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
