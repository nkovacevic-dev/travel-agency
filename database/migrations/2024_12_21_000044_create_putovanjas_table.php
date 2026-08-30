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
        Schema::create('putovanjas', function (Blueprint $table) {
            $table->id();
            $table->string('naziv');
            $table->foreignId('id_drzave')->constrained('drzavas')->onDelete('restrict');
            $table->string('grad');
            $table->date('datum_od');
            $table->date('datum_do');
            $table->integer('broj_dana');
            $table->integer('broj_nocenja');
            $table->integer('broj_dostupnih_mesta');
            $table->integer('broj_rezervacija')->default(0);
            $table->decimal('cena', 10, 2);
            $table->foreignId('id_hotela')->nullable()->constrained('hotels')->onDelete('restrict');
            $table->foreignId('id_tip_prevoza')->constrained('tip_prevozas')->onDelete('restrict');
            $table->string('prevoznik')->nullable();
            $table->text('program_putovanja');
            $table->text('fakultativni_izleti')->nullable();
            $table->text('pravila_otkazivanja')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('putovanjas');
    }
};
