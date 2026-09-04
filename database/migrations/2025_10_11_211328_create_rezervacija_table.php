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
        Schema::create('rezervacija', function (Blueprint $table) {
            $table->id();
            $table->string('puno_ime');
            $table->string('telefon');
            $table->string('email');
            $table->string('broj_pasosa')->nullable();
            $table->string('adresa')->nullable();
            $table->string('mesto')->nullable();
            $table->foreignId('id_drzave')->nullable()->constrained('drzava')->onDelete('restrict');
            $table->text('napomena')->nullable();
            $table->foreignId('id_putovanja')->nullable()->constrained('putovanje')->onDelete('restrict');
            $table->foreignId('id_termina')->nullable()->constrained('termini')->onDelete('set null');
            $table->foreignId('id_hotela')->nullable()->constrained('hotel')->onDelete('restrict');
            $table->foreignId('id_tip_sobe')->nullable()->constrained('tip_sobe')->onDelete('restrict');
            $table->unsignedInteger('broj_odraslih');
            $table->unsignedInteger('broj_dece')->default(0);
            $table->string('status')->default('nova');
            $table->decimal('ukupna_cena', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rezervacija');
    }
};
