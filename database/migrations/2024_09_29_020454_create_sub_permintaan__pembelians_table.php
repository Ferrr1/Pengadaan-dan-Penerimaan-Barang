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
        Schema::create('sub_permintaan_pembelian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permintaanpembelian_id')->constrained('permintaan_pembelians')->onDelete('cascade');
            $table->foreignId('sub_anggaran_id')->constrained('sub_anggarans')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->string('spesifikasi_sub_permintaan_pembelian');
            $table->bigInteger('kuantitas_sub_permintaan_pembelian');
            $table->bigInteger('harga_sub_permintaan_pembelian');
            $table->bigInteger('total_sub_permintaan_pembelian');
            $table->string('keterangan_sub_permintaan_pembelian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_permintaan_pembelian');
    }
};
