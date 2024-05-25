<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Toko;

class SupplierSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            "toko_id" => Toko::first()->id,
            'nama_supplier' => 'Yovi Ardiansyah',
            'alamat_supplier' => 'Pangean',
            'nomor_telepon_supplier' => '08632637626372',
        ]);
    }
}
