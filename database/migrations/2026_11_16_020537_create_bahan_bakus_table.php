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
        Schema::create('bahan_baku', function (Blueprint $t) {
    $t->id();
    $t->string('nama_bahan');
    $t->string('satuan', 20);
    $t->decimal('stok', 10, 2)->default(0);
    $t->decimal('stok_minimum', 10, 2)->default(0);
    $t->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_bakus');
    }
};
