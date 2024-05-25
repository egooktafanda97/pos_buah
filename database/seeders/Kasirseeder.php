<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\KasirService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Kasirseeder extends Seeder
{
    public function __construct(
        public KasirService $kasirService
    ) {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        auth()->login(User::whereId(2)->first());
        $this->kasirService->create([
            'username' => 'kasirtoko',
            'password' => bcrypt('password'),  // Jangan lupa untuk meng-hash password
            'role' => 'kasir',
            'nama' => 'Sample kasir',
            'alamat' => 'Sample Address',
            'telepon' => '1234567890',
            'deskripsi' => 'Ini adalah deskripsi sample untuk kasir.',
        ]);
    }
}
