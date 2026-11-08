<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('peminjamans', 'status')) {
            Schema::table('peminjamans', function (Blueprint $table) {
                $table->string('status')->default('disetujui')
                    ->after('tanggal_kembali');
            });
        }

        DB::table('peminjamans')
            ->whereNotNull('tanggal_kembali')
            ->update(['status' => 'dikembalikan']);
    }

    public function down(): void
    {
        // Kolom status tidak dihapus karena sudah ada sebelumnya.
    }
};