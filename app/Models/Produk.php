<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    // Table name
    protected $table = 'produks';

    // Primary key
    protected $primaryKey = 'id';

    // Fillable fields
    protected $fillable = [
        'toko_id',
        'user_id',
        'nama_produk',
        'deskripsi',
        'gambar',
        'jenis_produk_id',
        'supplier_id',
        'barcode',
        'diskon',
        'rak_id',
        'satuan_jual_terkecil_id',
        'status_id',
    ];

    // Relations
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenisProduk()
    {
        return $this->belongsTo(JenisProduk::class, 'jenis_produk_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function harga()
    {
        return $this->hasMany(Harga::class, 'produks_id');
    }

    public function hargaSatuanTerkecil()
    {
        return $this->harga()->where('jenis_satuan_id', $this->satuan_jual_terkecil_id)->first();
    }




    public function stok()
    {
        return $this->belongsTo(Stok::class, 'id', 'produks_id');
    }
}
