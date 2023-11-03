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
        Schema::create('uangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_petani');
            $table->integer('saldo');
            $table->foreign('id_petani')->on('users')->onDelete('cascade')->onUpdate('cascade')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uangs');
    }
};
