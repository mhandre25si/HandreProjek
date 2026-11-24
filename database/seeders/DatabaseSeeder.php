<?php

namespace Database\Seeders;

use App\Models\BahanBaku;
use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name' => 'Admin', 'email' => 'admin@catering.test', 'password' => 'password', 'role' => 'admin']);
        User::create(['name' => 'Staf Dapur', 'email' => 'staf@catering.test', 'password' => 'password', 'role' => 'staf']);

        $nasi  = KategoriMenu::create(['nama_kategori' => 'Nasi box']);
        $snack = KategoriMenu::create(['nama_kategori' => 'Snack']);

        Menu::create(['kategori_id' => $nasi->id, 'nama_menu' => 'Nasi Box Ayam Bakar', 'harga' => 28000]);
        Menu::create(['kategori_id' => $nasi->id, 'nama_menu' => 'Nasi Kuning Komplit', 'harga' => 25000]);
        Menu::create(['kategori_id' => $snack->id, 'nama_menu' => 'Snack Box Pisang Goreng', 'harga' => 12000]);

        BahanBaku::create(['nama_bahan' => 'Beras', 'satuan' => 'kg', 'stok' => 42, 'stok_minimum' => 30]);
        BahanBaku::create(['nama_bahan' => 'Ayam', 'satuan' => 'kg', 'stok' => 12, 'stok_minimum' => 15]);
    }
}