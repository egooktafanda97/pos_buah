<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    // Define the table name if it's not the plural form of the model name
    protected $table = 'transaksi';

    // Define the fillable properties
    protected $fillable = [
        'toko_id',
        'kasir_id',
        'user_id',
        'invoice',
        'tanggal',
        'pelanggan_id',
        'diskon',
        'total_belanja',
        'total_bayar',
        'kembalian',
        'payment_type_id',
        'status_id'
    ];

    // Define relationships

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    public function kasir()
    {
        return $this->belongsTo(Kasir::class, 'kasir_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function troli()
    {
        return $this->hasMany(DetailTransaksi::class, 'id', 'transaksi_id');
    }
}
