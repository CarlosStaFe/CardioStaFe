<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ✅ ESTRATEGIA 1: Verificar si existe antes de crear
        if (!Schema::hasTable('agenda')) {
            Schema::create('agenda', function (Blueprint $table) {
                $table->id();
                $table->date('fecha');
                $table->unsignedBigInteger('medico_id');
                $table->unsignedBigInteger('practica_id');
                $table->unsignedBigInteger('consultorio_id');
                $table->time('hora_inicio');
                $table->time('hora_fin');
                $table->timestamps();
                
                // Foreign keys
                $table->foreign('medico_id')->references('id')->on('medicos');
                $table->foreign('practica_id')->references('id')->on('practicas');
                $table->foreign('consultorio_id')->references('id')->on('consultorios');
                
                // Index for better performance
                $table->index(['fecha', 'medico_id', 'consultorio_id']);
            });
        } else {
            // Opcional: Log que la tabla ya existe
            \Log::info('Tabla agenda ya existe, migración omitida');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ✅ ESTRATEGIA 2: Verificar si existe antes de eliminar
        if (Schema::hasTable('agenda')) {
            Schema::dropIfExists('agenda');
        }
    }
};
