<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'toko';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'telepon',
        'email',
        'logo',
        'deskripsi',
    ];

    /**
     * Get the user that owns the toko.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
