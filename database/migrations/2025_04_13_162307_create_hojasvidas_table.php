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
        Schema::create('hojasvidas', function (Blueprint $table) {
            $table->increments('idHojaDeVida');  
            $table->string('claseLibretaMilitar', 45);
            $table->string('numeroLibretaMilitar', 45);
            $table->integer('usaurioNumDocumento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hojasvidas');
    }
};
