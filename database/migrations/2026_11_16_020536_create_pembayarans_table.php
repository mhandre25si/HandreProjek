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
        Schema::create('pembayaran', function (Blueprint $t) {
    $t->id();
    $t->foreignId('pesanan_id')->unique()->constrained('pesanan')->cascadeOnDelete();
    $t->string('metode')->default('transfer');
    $t->string('bukti_bayar')->nullable();
    $t->enum('status_verifikasi', ['belum','menunggu','terverifikasi','ditolak'])->default('belum');
    $t->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
