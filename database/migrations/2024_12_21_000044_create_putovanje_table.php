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
        Schema::create('putovanje', function (Blueprint $table) {
            $table->id();
            $table->string('naziv');
            $table->foreignId('id_drzave')->constrained('drzava')->onDelete('restrict');
            $table->string('grad');
            $table->integer('broj_dana');
            $table->integer('broj_nocenja');
            $table->integer('broj_rezervacija')->default(0);
            $table->decimal('cena', 10, 2);
            $table->foreignId('id_hotela')->nullable()->constrained('hotel')->onDelete('restrict');
            $table->foreignId('id_tip_prevoza')->constrained('tip_prevoza')->onDelete('restrict');
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
        Schema::dropIfExists('putovanje');
    }
};
