<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi';

    protected $fillable = [
        'toko_id',
        'kasir_id',
        'user_id',
        'invoice',
        'transaksi_id',
        'produks_id',
        'harga_id',
        'satuan_id',
        'jumlah',
        'total',
        'diskon',
        'status_id'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produks_id');
    }

    public function satuan()
    {
        return $this->belongsTo(JenisSatuan::class, 'satuan_id');
    }

    public function harga()
    {
        return $this->belongsTo(Harga::class, 'harga_id');
    }

    public function kasir()
    {
        return $this->belongsTo(Kasir::class, 'kasir_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
