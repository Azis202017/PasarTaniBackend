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
        Schema::create('permintaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_petani');
            $table->unsignedBigInteger('id_koperasi');
           


            $table->string('kategori');
            $table->integer('harga');
            $table->integer('berat');
            $table->integer('jumlah');
            $table->string('durasi_tahan');
            $table->string('foto');
            $table->foreign('id_petani')->on('users')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_koperasi')->on('users')->references('id')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaans');
    }
};
