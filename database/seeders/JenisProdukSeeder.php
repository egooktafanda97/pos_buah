<?php

namespace Database\Seeders;

use App\Models\JenisProduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class JenisProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            JenisProduk::create([
                'nama_jenis_produk' => $faker->unique()->word,
            ]);
        }
    }
}
