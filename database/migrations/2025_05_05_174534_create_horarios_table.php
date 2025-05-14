<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->string('dia', 20);
            $table->date('fecha');
            $table->string('hora_inicio', 5);
            $table->string('hora_fin', 5);
            $table->string('rango', 5);

            $table->unsignedBigInteger('practica_id');
            $table->foreign('practica_id')->references('id')->on('practicas')->onDelete('cascade');
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');
            $table->foreignId('consultorio_id')->constrained('consultorios')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
