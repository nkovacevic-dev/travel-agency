<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rezervacijes', function (Blueprint $table) {
            $table->dropColumn('termin');
            $table->foreignId('id_termina')->nullable()->after('id_putovanja')->constrained('terminis')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('rezervacijes', function (Blueprint $table) {
            $table->dropForeign(['id_termina']);
            $table->dropColumn('id_termina');
            $table->string('termin')->nullable();
        });
    }
};
