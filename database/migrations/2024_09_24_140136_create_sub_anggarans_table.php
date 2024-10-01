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
        Schema::create('sub_anggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggaran_id')->constrained('anggarans')->onDelete('cascade');
            $table->foreignId('kel_anggaran_id')->constrained('kel_anggarans')->onDelete('cascade');
            $table->string('no_detail', 4)->unique();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->bigInteger('kuantitas_anggaran');
            $table->bigInteger('harga_anggaran');
            $table->bigInteger('total_anggaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_anggarans');
    }
};
