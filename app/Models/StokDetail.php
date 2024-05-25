<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokDetail extends Model
{
    use HasFactory;
    // Define the table name if it's not the plural form of the model name
    protected $table = 'stok_detail';

    // Define the fillable properties
    protected $fillable = [
        'stok_id',
        'toko_id',
        'produks_id',
        'jumlah',
        'jumlah_sebelumnya',
        'satuan_id',
        'tipe'
    ];

    // Define relationships

    // Relation to Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produks_id');
    }

    // Relation to Toko
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    // Relation to Satuan
    public function satuan()
    {
        return $this->belongsTo(JenisSatuan::class, 'satuan_id');
    }
}
