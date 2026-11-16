<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'pemasok';
    protected $guarded = [];

    public function pembelian()
    {
        return $this->hasMany(PembelianBahan::class);
    }
}
