<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;
    // Table name
    protected $table = 'rak';

    // Primary key
    protected $primaryKey = 'id';

    // Fillable fields
    protected $fillable = [
        'toko_id',
        'nomor',
        'nama',
        'kapasitas',
    ];

    // Relations
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    public function produks()
    {
        return $this->hasMany(Produk::class, 'rak_id');
    }

    // Timestamps
    public $timestamps = true;
}
