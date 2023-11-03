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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_permintaan');
            $table->text('keterangan')->nullable();
            $table->dateTime('tgl_perubahan');

            $table->string('status');
            $table->foreign('id_permintaan')->on('permintaans')->onDelete('cascade')->onUpdate('cascade')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
