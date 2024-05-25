<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;
    protected $table = 'harga';

    protected $fillable = [
        'user_id',
        'toko_id',
        'produks_id',
        'harga',
        'jenis_satuan_id',
        'user_update_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userUpdate()
    {
        return $this->belongsTo(User::class, 'user_update_id');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produks_id');
    }

    public function jenisSatuan()
    {
        return $this->belongsTo(JenisSatuan::class, 'jenis_satuan_id');
    }
}
