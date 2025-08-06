<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('color');
            $table->datetime('start');
            $table->datetime('end')->nullable();

            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('obra_social_id')->references('id')->on('obrasociales')->onDelete('cascade');
            $table->foreignId('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreignId('medico_id')->references('id')->on('medicos')->onDelete('cascade');
            $table->foreignId('consultorio_id')->references('id')->on('consultorios')->onDelete('cascade');
            $table->foreignId('practica_id')->references('id')->on('practicas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
