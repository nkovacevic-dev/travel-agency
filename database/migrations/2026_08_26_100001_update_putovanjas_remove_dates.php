<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('putovanjas', function (Blueprint $table) {
            $table->dropColumn(['datum_od', 'datum_do', 'broj_dostupnih_mesta']);
        });
    }

    public function down(): void
    {
        Schema::table('putovanjas', function (Blueprint $table) {
            $table->date('datum_od')->nullable();
            $table->date('datum_do')->nullable();
            $table->integer('broj_dostupnih_mesta')->nullable();
        });
    }
};
