<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rezervacijes', function (Blueprint $table) {
            if (!Schema::hasColumn('rezervacijes', 'broj_pasosa')) {
                $table->string('broj_pasosa')->after('telefon');
            }
            if (!Schema::hasColumn('rezervacijes', 'adresa')) {
                $table->string('adresa')->after('broj_pasosa');
            }
            if (!Schema::hasColumn('rezervacijes', 'mesto')) {
                $table->string('mesto')->after('adresa');
            }
            if (!Schema::hasColumn('rezervacijes', 'drzava')) {
                $table->string('drzava')->after('mesto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rezervacijes', function (Blueprint $table) {
            $table->dropColumn(['drzava', 'mesto', 'adresa', 'broj_pasosa']);
        });
    }
};
