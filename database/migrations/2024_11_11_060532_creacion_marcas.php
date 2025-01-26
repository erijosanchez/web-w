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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nombre de la marca
            $table->string('slug')->unique(); // URL amigable de la marca
            $table->text('description')->nullable(); // Descripción de la marca
            $table->string('logo')->nullable(); // Ruta del logo de la marca
            $table->boolean('status')->default(1); // Estado de la marca (1 = Publicada, 0 = Despublicada)
            $table->timestamps(); // created_at y updated_at
            $table->softDeletes(); // deleted_at para soporte de eliminación suave
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
