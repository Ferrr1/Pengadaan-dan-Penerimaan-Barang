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
        Schema::create('sub_order_pembelians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orderpembelian_id')->constrained('order_pembelians')->onDelete('cascade');
            $table->foreignId('sub_permintaanpembelian_id')->constrained('sub_permintaan_pembelian')->onDelete('cascade');
            $table->bigInteger('ppn_sub_order_pembelian');
            $table->bigInteger('kuantitas_sub_order_pembelian');
            $table->bigInteger('total_sub_order_pembelian');
            $table->string('catatan_sub_order_pembelian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_order_pembelians');
    }
};
