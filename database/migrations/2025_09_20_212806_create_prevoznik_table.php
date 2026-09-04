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
        Schema::create('prevoznik', function (Blueprint $table) {
            $table->id();
            $table->string('naziv');
            $table->string('adresa')->nullable();
            $table->string('grad')->nullable();
            $table->unsignedBigInteger('id_tip_prevoza');
            $table->string('kontakt')->nullable();
            $table->timestamps();

            $table->foreign('id_tip_prevoza')
                ->references('id')
                ->on('tip_prevoza')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prevoznik');
    }
};
