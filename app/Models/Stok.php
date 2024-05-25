<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $table = 'stoks';

    protected $fillable = [
        'toko_id',
        'produks_id',
        'jumlah',
        'jumlah_sebelumnya',
        'satuan_id',
        'keterangan',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function satuan()
    {
        return $this->belongsTo(JenisSatuan::class, 'satuan_id');
    }

    public function stok_detail()
    {
        return $this->belongsTo(StokDetail::class, 'id', 'stok_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
