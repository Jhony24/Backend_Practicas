<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFicticioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ficticio', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('externalid_ficticio')->unique();
            $table->integer('idcarrera')->unsigned();
            $table->foreign('idcarrera')->references('id')->on('carreras')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string("nombreempresa", 200);
            $table->string("nombrearea", 100);
            $table->string('nombre_prficticio', 100)->unique();
            $table->integer('estudianes_requeridos');
            $table->integer('horas_cumplir')->nullable();
            $table->date('fecha_inicio');
            $table->string('actividades', 200)->nullable();
            $table->string('requerimientos', 200)->nullable();
            $table->integer('estadoficticio')->default(0);
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
        Schema::dropIfExists('ficticio');
    }
}
