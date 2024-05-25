<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kasir';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'toko_id',
        'nama',
        'alamat',
        'telepon',
        'deskripsi',
    ];

    /**
     * Get the user that owns the kasir.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the toko that owns the kasir.
     */
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
}
