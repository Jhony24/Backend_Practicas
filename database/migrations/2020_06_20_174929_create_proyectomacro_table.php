<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectomacroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectomacro', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('externalid_macro')->unique();

            $table->integer('idcarrera')->unsigned();
            $table->foreign('idcarrera')->references('id')->on('carreras')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idarea')->unsigned();
            $table->foreign('idarea')->references('id')->on('areas')
                ->onDelete('cascade')->onUpdate('cascade');

            /*$table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresas')
                ->onDelete('cascade')->onUpdate('cascade');*/

            $table->string('nombre_prmacro',100)->unique();
            $table->string('encargado',100);
            $table->string('descripcion',250);
            $table->integer('estadomacro')->default(0);
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
        Schema::dropIfExists('proyectomacro');
    }
}
