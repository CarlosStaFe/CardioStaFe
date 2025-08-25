<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obrasociales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 70);

            $table->unsignedBigInteger('practica_id')->nullable();
            $table->foreign('practica_id')->references('id')->on('practicas')->nullable();

            $table->string('telefono', 20)->nullable();
            $table->string('contacto', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->boolean('activo')->default(true);
            $table->string('documentacion', 100)->nullable();
            $table->string('observacion', 100)->nullable();            
            $table->timestamps();
        });
        
        // Schema::rename('obrasociales', 'obrasociales');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obrasociales');
    }
};
