<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSatuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jenis_satuan'
    ];

    public function hargas()
    {
        return $this->hasMany(Harga::class, 'jenis_satuan_id');
    }
}
