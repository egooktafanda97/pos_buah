<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisProduk extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jenis_produk'
    ];

    public function produks()
    {
        return $this->hasMany(ProdukBuah::class, 'jenis_produk_id');
    }
}
