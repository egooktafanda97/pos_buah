<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'nama_sipplier' => 'Yovi Ardiansyah',
            'alamat_sipplier' => 'Pangean',
            'nomor_telepon_sipplier' => '08632637626372',
          
        ]);
    }
}
