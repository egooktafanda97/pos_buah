<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konversisatuan extends Model
{
    use HasFactory;
    protected $table = 'konversisatuan';

    protected $fillable = [
        'toko_id',
        'produks_id',
        'satuan_id',
        'satuan_konversi_id',
        'nilai_konversi',
        'status_id'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function satuanBeli()
    {
        return $this->belongsTo(JenisSatuan::class, 'satuan_beli_id');
    }

    public function satuanKonversi()
    {
        return $this->belongsTo(JenisSatuan::class, 'satuan_konversi_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
