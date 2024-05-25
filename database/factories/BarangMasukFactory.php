<?php

namespace Database\Factories;

use App\Models\Toko;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BarangMasuk>
 */
class BarangMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'toko_id' => Toko::first()->id,
            'user_id' => 1,
            'produks_id' => '',
            'supplier_id' => '',
            'harga_beli' => '',
            'satuan_beli_id' => '',
            'jumlah_barang_masuk' => '',
            'jumlah_barang_keluar' => '',
            'stok' => '',
            'satuan_stok_id' => '',
            'status_id' => '',
        ];
    }
}
