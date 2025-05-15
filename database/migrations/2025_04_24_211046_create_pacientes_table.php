<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('apel_nombres', 50);
            $table->date('nacimiento');
            $table->enum('sexo', ['M', 'F']);
            $table->string('tipo_documento', 5)->nullable();
            $table->integer('num_documento')->unique();
            $table->string('domicilio', 50)->nullable();

            $table->unsignedBigInteger('cod_postal_id');            
            $table->foreign('cod_postal_id')->references('id')->on('localidades')->nullable();

            $table->string('telefono', 30)->nullable();
            $table->string('email', 80)->nullable();
            $table->string('obra_social', 100)->nullable();
            $table->string('num_afiliado', 50)->nullable();
            $table->string('observacion', 255)->nullable();
            $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
