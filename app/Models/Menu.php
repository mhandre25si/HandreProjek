<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriMenu::class, 'kategori_id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
