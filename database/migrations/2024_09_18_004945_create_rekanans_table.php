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
        Schema::create('rekanans', function (Blueprint $table) {
            $table->id();
            $table->string("kode_rekanan", 6)->unique();
            $table->string("nama_rekanan");
            $table->string("alamat_rekanan");
            $table->string("telepon_rekanan");
            $table->string("email_rekanan");
            $table->string("status_rekanan");
            $table->date("tgl_bergabung");
            $table->date("tgl_akhir");
            $table->foreignId("project_id")->nullable()->constrained("projects")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekanans');
    }
};
