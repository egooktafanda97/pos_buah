<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal_transaksi',
        'pelanggan_id',
        'total_pembayaran'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function produks()
    {
        return $this->belongsToMany(ProdukBuah::class, 'detail_transaksis', 'transaksi_id', 'produk_id')->withPivot('jumlah', 'harga_satuan')->withTimestamps();
    }
}
