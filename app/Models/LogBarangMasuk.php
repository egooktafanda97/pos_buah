<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBarangMasuk extends Model
{
    use HasFactory;
    // Define the table name if it's not the plural form of the model name
    protected $table = 'log_barang_masuk';

    // Define the fillable properties
    protected $fillable = [
        'toko_id',
        'user_id',
        'produks_id',
        'supplier_id',
        'harga_beli',
        'satuan_beli_id',
        'jumlah_barang_masuk',
        'jumlah_barang_keluar',
        'stok_sisa',
        'satuan_stok_id',
        'status_id'
    ];

    // Define relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produks_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function satuanBeli()
    {
        return $this->belongsTo(JenisSatuan::class, 'satuan_beli_id');
    }

    public function satuanStok()
    {
        return $this->belongsTo(JenisSatuan::class, 'satuan_stok_id');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
