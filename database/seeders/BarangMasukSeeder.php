<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\Toko;
use App\Services\BarangMasukService;
use App\Services\ProdukService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BarangMasukSeeder extends Seeder
{
    public function __construct(
        public ProdukService $produkService,
        public BarangMasukService $barangMasukService,
    ) {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach ($this->produkService->produkRepository->all() as  $value) {
            $this->barangMasukService->initialize([
                'toko_id' => Toko::first()->id,
                'user_id' => 1,
                'produks_id' => $value->id,
                'supplier_id' => Supplier::first()->id,
                'harga_beli' => (int)$faker->randomFloat(0, 1000, 100000), // harnga satuan
                'satuan_beli_id' => rand(1, 2),
                'jumlah_barang_masuk' => 1,
                'jumlah_barang_keluar' => 0
            ])->store();
        }
    }
}
