<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rezervacijes', function (Blueprint $table) {
            $table->dropColumn('drzava');
            $table->foreignId('id_drzave')->nullable()->after('puno_ime')->constrained('drzavas')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('rezervacijes', function (Blueprint $table) {
            $table->dropForeign(['id_drzave']);
            $table->dropColumn('id_drzave');
            $table->string('drzava')->nullable();
        });
    }
};
