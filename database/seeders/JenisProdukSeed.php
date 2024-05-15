<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisProduk;

class JenisProdukSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisProduk::create([
            'nama_jenis_produk' => 'Buah Segar',
          
        ]);
    }
}
