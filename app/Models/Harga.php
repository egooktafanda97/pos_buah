<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;
    protected $fillable = [
        'produk_id',
        'jenis_satuan_id',
        'harga_satuan'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function jenisSatuan()
    {
        return $this->belongsTo(JenisSatuan::class, 'jenis_satuan_id');
    }
}
