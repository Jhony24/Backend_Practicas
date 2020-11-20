<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostulacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulacion', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('externalid_postulacion');
            $table->integer('id_estudiante');
            $table->integer('id_practica')->nullable();
            $table->integer('id_proyecto')->nullable();
            $table->string('estado_postulacion');
            $table->date('fecha_postulacion');
            $table->string('observacion', 300)->nullable();
            $table->integer('tipo_practica');
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
        Schema::dropIfExists('postulacion');
    }
}
