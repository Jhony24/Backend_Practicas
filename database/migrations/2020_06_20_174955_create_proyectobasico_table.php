<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectobasicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectobasico', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('externalid_basico')->unique();

            $table->integer('idmacro')->unsigned();
            $table->foreign('idmacro')->references('id')->on('proyectomacro')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresas')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('nombre_prbasico', 100)->unique();
            $table->integer('estudianes_requeridos');
            $table->string('ciclo')->nullable();
            $table->string('modalidad', 10);
            $table->integer('horas_cumplir')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->string('actividades', 250)->nullable();
            $table->string('requerimientos', 250)->nullable();
            $table->integer('estadobasico')->default(0);
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
        Schema::dropIfExists('proyectobasico');
    }
}
