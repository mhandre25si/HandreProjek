<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $table = 'bahan_baku';
    protected $guarded = [];

    public function pembelian()
    {
        return $this->hasMany(PembelianBahan::class, 'bahan_id');
    }

    // Dipakai untuk notifikasi stok menipis (F-17)
    public function scopeMenipis($query)
    {
        return $query->whereColumn('stok', '<', 'stok_minimum');
    }
}
