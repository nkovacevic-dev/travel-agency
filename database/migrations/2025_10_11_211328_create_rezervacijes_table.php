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
        Schema::create('rezervacijes', function (Blueprint $table) {
            $table->id();
            $table->string('puno_ime');
            $table->string('telefon');
            $table->string('termin');
            $table->unsignedInteger('broj_odraslih');
            $table->unsignedInteger('broj_dece')->default(0);
            $table->string('email');
            $table->text('napomena')->nullable();
            $table->foreignId('id_putovanja')->nullable()->constrained('putovanjas')->onDelete('restrict');
            $table->foreignId('id_hotela')->nullable()->constrained('hotels')->onDelete('restrict');
            $table->foreignId('id_tip_sobe')->nullable()->constrained('tip_sobes')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rezervacijes');
    }
};
