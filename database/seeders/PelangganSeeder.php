<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::insert([
            [
                'toko_id' => 1,
                'nama_pelanggan' => 'Pelanggan 1',
                'alamat_pelanggan' => 'Alamat Pelanggan 1',
                'nomor_telepon_pelanggan' => '08123456789'
            ],
            [
                'toko_id' => 1,
                'nama_pelanggan' => 'Pelanggan 2',
                'alamat_pelanggan' => 'Alamat Pelanggan 2',
                'nomor_telepon_pelanggan' => '08123456789'
            ],
            [
                'toko_id' => 1,
                'nama_pelanggan' => 'Pelanggan 3',
                'alamat_pelanggan' => 'Alamat Pelanggan 3',
                'nomor_telepon_pelanggan' => '08123456789'
            ],
            [
                'toko_id' => 1,
                'nama_pelanggan' => 'Pelanggan 4',
                'alamat_pelanggan' => 'Alamat Pelanggan 4',
                'nomor_telepon_pelanggan' => '08123456789'
            ],
            [
                'toko_id' => 1,
                'nama_pelanggan' => 'Pelanggan 5',
                'alamat_pelanggan' => 'Alamat Pelanggan 5',
                'nomor_telepon_pelanggan' => '08123456789'
            ],
        ]);
    }
}
