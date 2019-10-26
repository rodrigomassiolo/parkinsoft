<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacienteEjercicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacienteEjercicio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('ejercicio_id')->references('id')->on('ejercicio');
            $table->string('audio_path')->nullable();
            $table->string('audio_name')->nullable();
            $table->string('audio_ext')->nullable();
            $table->string('ultimaMedicacion')->nullable();
            $table->boolean('es_levodopa')->nullable();
            $table->string('modo_levodopa')->nullable();
            $table->string('origen_audio')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('pacienteEjercicio');
    }
}
