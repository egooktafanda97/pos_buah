<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk';

    protected $fillable = [
        'toko_id',
        'user_id',
        'produks_id',
        'supplier_id',
        'harga_beli',
        'satuan_beli_id',
        'jumlah_barang_masuk',
        'jumlah_barang_keluar',
        'status_id'
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produks_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function satuanBeli()
    {
        return $this->belongsTo(JenisSatuan::class, 'satuan_beli_id');
    }

    public function satuanStok()
    {
        return $this->belongsTo(JenisSatuan::class, 'satuan_stok_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
