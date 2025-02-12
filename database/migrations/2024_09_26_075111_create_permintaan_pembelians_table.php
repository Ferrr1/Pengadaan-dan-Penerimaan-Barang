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
        Schema::create('permintaan_pembelians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggaran_id')->constrained('anggarans')->onDelete('cascade');
            $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
            $table->string('nomor_pp')->unique();
            $table->date('tgl_pp');
            $table->json('tandatangan_pp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_pembelians');
    }
};
