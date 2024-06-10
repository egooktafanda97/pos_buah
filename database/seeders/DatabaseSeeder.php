<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(StatusSeeder::class);
        $this->call(PayTypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TokoSeeder::class);
        $this->call(KasirSeeder::class);
        $this->call(JenisProdukSeeder::class);
        $this->call(ProdukAsset::class);
        $this->call(SupplierSeed::class);
        $this->call(BarangMasukSeeder::class);
        $this->call(ConfigSeeder::class);
        $this->call(PelangganSeeder::class);
    }
}
