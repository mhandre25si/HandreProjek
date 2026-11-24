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
       Schema::create('pesanan', function (Blueprint $t) {
    $t->id();
    $t->foreignId('pelanggan_id')->constrained('pelanggan');
    $t->date('tanggal_pesan');
    $t->date('tanggal_kirim');
    $t->text('alamat_kirim');
    $t->unsignedInteger('total')->default(0);
    $t->enum('status', ['baru','diproses','dikirim','selesai','batal'])->default('baru');
    $t->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
