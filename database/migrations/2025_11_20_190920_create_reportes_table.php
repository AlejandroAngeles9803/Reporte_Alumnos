<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['credencial', 'uniforme', 'cabello', 'otro']);
            $table->text('descripcion')->nullable();
            $table->integer('horas_sentencia')->default(0);
            $table->date('fecha_reporte');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reportes');
    }
};