<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rezervacija', function (Blueprint $table) {
            if (!Schema::hasColumn('rezervacija', 'token_otkazivanja')) {
                $table->uuid('token_otkazivanja')->nullable()->unique()->after('status');
            }
        });

        // Ažuriranje tokena za postojeće rezervacije
        DB::table('rezervacija')->whereNull('token_otkazivanja')->orderBy('id')->each(function ($row) {
            DB::table('rezervacija')->where('id', $row->id)->update(['token_otkazivanja' => Str::uuid()]);
        });
    }

    public function down(): void
    {
        Schema::table('rezervacija', function (Blueprint $table) {
            $table->dropColumn('token_otkazivanja');
        });
    }
};
