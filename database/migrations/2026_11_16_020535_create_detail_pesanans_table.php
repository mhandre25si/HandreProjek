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
        Schema::create('detail_pesanan', function (Blueprint $t) {
    $t->id();
    $t->foreignId('pesanan_id')->constrained('pesanan')->cascadeOnDelete();
    $t->foreignId('menu_id')->constrained('menu');
    $t->unsignedInteger('jumlah');
    $t->unsignedInteger('subtotal');
    $t->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};
