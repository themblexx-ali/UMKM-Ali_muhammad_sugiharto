<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('invoice_code')->nullable()->after('id');
            $table->date('tanggal_beli')->nullable()->after('jumlah');
            $table->string('metode_pembayaran')->nullable()->after('status');
            $table->string('metode_pengiriman')->nullable()->after('metode_pembayaran');
            $table->text('alamat_pengiriman')->nullable()->after('metode_pengiriman');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_code',
                'tanggal_beli',
                'metode_pembayaran',
                'metode_pengiriman',
                'alamat_pengiriman',
            ]);
        });
    }
};
