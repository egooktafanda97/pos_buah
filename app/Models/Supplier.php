<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'toko_id',
        'nama_supplier',
        'alamat_supplier',
        'nomor_telepon_supplier'
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'supplier_id');
    }
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
}
