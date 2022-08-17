<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuadros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_procedencia_id')->constrained('paises');
            $table->foreignId('sala_id')->constrained('salas');
            $table->string('nombre');
            $table->string('autor');
            $table->decimal('precio',12,2)->nullable();
            $table->date('anio_creacion')->format('Y');
            $table->integer('alto')->description('En centimetros');
            $table->integer('ancho')->description('En centimetros');
            $table->string('img_url');
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
        Schema::dropIfExists('cuadros');
    }
};
