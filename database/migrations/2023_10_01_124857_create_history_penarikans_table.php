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
        Schema::create('history_penarikans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_uang');

            $table->integer('nominal_penarikan');
            $table->dateTime('waktu_penarikan');
            $table->foreign('id_uang')->on('uangs')->onDelete('cascade')->onUpdate('cascade')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_penarikans');
    }
};
