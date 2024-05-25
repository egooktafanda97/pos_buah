<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSatuan extends Model
{
    use HasFactory;
    protected $table = "jenis_satuans";
    protected $fillable = [
        'toko_id',
        'nama'
    ];

    public function hargas()
    {
        return $this->hasMany(Harga::class, 'jenis_satuan_id');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
}
