<?php

namespace Database\Seeders;

use App\Models\JenisSatuan;
use App\Models\Konversisatuan;
use App\Models\Produk;
use App\Services\StatusService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NilaiKonversi extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::all()->each(function ($produk) {
            $PCSTOBOX = [
                'PCS' => 1,
                'BOX' => 12
            ];
            Konversisatuan::create([
                'toko_id' => 1,
                'produks_id' => $produk->id,
                'satuan_id' =>  $produk->satuan_jual_terkecil_id,
                'satuan_konversi_id' => $produk->satuan_jual_terkecil_id,
                'nilai_konversi' => 1,
                'status_id' => StatusService::Active
            ]);

            Konversisatuan::create([
                'toko_id' => 1,
                'produks_id' => $produk->id,
                'satuan_id' =>   JenisSatuan::where('nama', "Box")->first()->id,
                'satuan_konversi_id' => $produk->satuan_jual_terkecil_id,
                'nilai_konversi' => 10,
                'status_id' => StatusService::Active
            ]);

            Konversisatuan::create([
                'toko_id' => 1,
                'produks_id' => $produk->id,
                'satuan_id' =>  JenisSatuan::where('nama', "LUSIN")->first()->id,
                'satuan_konversi_id' => $produk->satuan_jual_terkecil_id,
                'nilai_konversi' => 12,
                'status_id' => StatusService::Active
            ]);
        });
    }
}
