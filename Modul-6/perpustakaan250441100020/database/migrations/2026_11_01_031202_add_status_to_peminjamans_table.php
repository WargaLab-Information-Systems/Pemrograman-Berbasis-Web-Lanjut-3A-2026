
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
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
                'dikembalikan'
            ])->default('menunggu');

            $table->foreignId('disetujui_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('tanggal_disetujui')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropForeign(['disetujui_oleh']);
            $table->dropColumn([
                'status',
                'disetujui_oleh',
                'tanggal_disetujui'
            ]);
        });
    }
};
