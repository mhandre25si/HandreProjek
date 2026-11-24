<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianBahan extends Model
{
    protected $table = 'pembelian_bahan';
    protected $guarded = [];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class);
    }

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_id');
    }
}
