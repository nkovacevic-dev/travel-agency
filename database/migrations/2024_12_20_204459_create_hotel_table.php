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
        Schema::create('hotel', function (Blueprint $table) {
            $table->id();
            $table->string('naziv');
            $table->unsignedTinyInteger('broj_zvezdica');
            $table->string('adresa');
            $table->string('grad');
            $table->foreignId('id_drzave')->constrained('drzava')->onDelete('restrict');
            $table->string('telefon');
            $table->string('email')->nullable();
            $table->text('opis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel');
    }
};
