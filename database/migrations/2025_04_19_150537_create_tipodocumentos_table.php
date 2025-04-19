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
        Schema::create('tipodocumento', function (Blueprint $table) {
            $table->id('idTipoDocumento');
            $table->string('nombreTipoDocumento', 50);
            $table->string('abreviacionTipoDocumento', 5);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipodocumentos');
    }
};
