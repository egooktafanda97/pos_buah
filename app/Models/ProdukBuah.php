<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukBuah extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'gambar',
        'jenis_produk_id',
        'supplier_id',
        'harga_id',
        'stok'
    ];

    public function jenisProduk()
    {
        return $this->belongsTo(JenisProduk::class, 'jenis_produk_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function harga()
    {
        return $this->belongsTo(Harga::class, 'harga_id');
    }

    public function transaksi()
    {
        return $this->belongsToMany(Transaksi::class, 'detail_transaksi', 'produk_id', 'transaksi_id')->withPivot('jumlah', 'harga_satuan')->withTimestamps();
    }
}
