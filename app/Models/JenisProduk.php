<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisProduk extends Model
{
    use HasFactory;
    protected $fillable = [
        'toko_id',
        'nama_jenis_produk'
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'jenis_produk_id');
    }
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
}
