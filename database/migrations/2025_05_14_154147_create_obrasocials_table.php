<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obrasocials', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 70);
            $table->string('telefono', 20)->nullable();
            $table->string('contacto', 50)->nullable();
            $table->string('documentacion', 100)->nullable();
            $table->string('observacion', 100)->nullable();            
            $table->timestamps();
        });
        
        Schema::rename('obrasocials', 'obrasociales');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obrasocials');
    }
};
