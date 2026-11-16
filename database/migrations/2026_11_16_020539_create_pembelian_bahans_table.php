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
        Schema::create('pembelian_bahan', function (Blueprint $t) {
    $t->id();
    $t->foreignId('pemasok_id')->constrained('pemasok');
    $t->foreignId('bahan_id')->constrained('bahan_baku');
    $t->decimal('jumlah', 10, 2);
    $t->unsignedInteger('harga');
    $t->date('tanggal');
    $t->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_bahans');
    }
};
