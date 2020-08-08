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
            
            $table->string('nombre_prbasico',100)->unique();
            $table->string('actividades',200);
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
