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
    Schema::create('peminjamans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
        $table->date('tanggal_pinjam');
        $table->date('tanggal_kembali'); // Tanggal rencana kembali yang diinput siswa
        $table->date('tanggal_dikembalikan')->nullable(); // Tanggal aktual saat divalidasi petugas
        $table->enum('status', ['diajukan', 'dipinjam', 'menunggu_kembali', 'dikembalikan', 'ditolak'])->default('diajukan');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
