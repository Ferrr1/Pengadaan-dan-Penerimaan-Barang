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
        Schema::create('order_pembelians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permintaanpembelian_id')->constrained('permintaan_pembelians')->onDelete('cascade');
            $table->foreignId('rekanan_id')->constrained('rekanans')->onDelete('cascade');
            $table->string('nomor_op')->unique();
            $table->date('tgl_op');
            $table->json('tandatangan_op');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_pembelians');
    }
};
