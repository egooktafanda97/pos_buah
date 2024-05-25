<?php

namespace Database\Seeders;

use App\Services\TokoService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TokoSeeder extends Seeder
{
    public function __construct(
        public TokoService $tokoService
    ) {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            'username' => 'sampleuser',
            'password' => bcrypt('password'),  // Jangan lupa untuk meng-hash password
            'role' => 'toko',
            'nama' => 'Sample Toko',
            'alamat' => 'Sample Address',
            'telepon' => '1234567890',
            'email' => 'sampletoko@example.com',
            'deskripsi' => 'Ini adalah deskripsi sample untuk toko.',
        ];
        $this->tokoService->create($data);
    }
}
