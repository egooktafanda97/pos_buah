<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_pelanggan',
        'alamat_pelanggan',
        'nomor_telepon_pelanggan'
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id');
    }
}
