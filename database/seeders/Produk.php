<?php

namespace Database\Seeders;

use App\Models\ProdukBuah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class Produk extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Jika Anda ingin menggunakan data palsu bahasa Indonesia

        for ($i = 0; $i < 10; $i++) { // Ganti 10 dengan jumlah data yang Anda inginkan
            ProdukBuah::create([
                'nama_produk' => $faker->unique()->word,
                'deskripsi' => $faker->sentence,
                'gambar' => $faker->imageUrl(), // Ini akan menghasilkan URL gambar palsu
                'jenis_produk_id' => $faker->numberBetween(1, 5), // Ganti 5 dengan jumlah jenis produk yang Anda miliki
                'supplier_id' => $faker->numberBetween(1, 10), // Ganti 10 dengan jumlah supplier yang Anda miliki
                'stok' => $faker->numberBetween(0, 100), // Ganti 100 dengan jumlah maksimal stok yang Anda inginkan
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
