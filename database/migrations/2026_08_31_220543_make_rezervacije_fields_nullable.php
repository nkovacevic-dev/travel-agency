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
        Schema::table('rezervacijes', function (Blueprint $table) {
            $table->string('broj_pasosa', 50)->nullable()->change();
            $table->string('adresa', 255)->nullable()->change();
            $table->string('mesto', 100)->nullable()->change();
            $table->unsignedBigInteger('id_drzave')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('rezervacijes', function (Blueprint $table) {
            $table->string('broj_pasosa', 50)->nullable(false)->change();
            $table->string('adresa', 255)->nullable(false)->change();
            $table->string('mesto', 100)->nullable(false)->change();
            $table->unsignedBigInteger('id_drzave')->nullable(false)->change();
        });
    }
};
