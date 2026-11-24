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
        Schema::create('menu', function (Blueprint $t) {
    $t->id();
    $t->foreignId('kategori_id')->constrained('kategori_menu');
    $t->string('nama_menu');
    $t->text('deskripsi')->nullable();
    $t->unsignedInteger('harga');
    $t->string('foto')->nullable();
    $t->boolean('status')->default(true);
    $t->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
