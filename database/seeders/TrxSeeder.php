<?php

namespace Database\Seeders;

use App\Http\Controllers\TrxController;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class TrxSeeder extends Seeder
{
    public function __construct(
        public TrxController $trxController
    ) {
    }

    public function randomGetProd()
    {
        return Produk::with([
            'harga',
            'toko',
            'jenisProduk',
            'supplier',
            'rak',
            'status',
        ])->inRandomOrder()->first();
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        auth()->login(User::whereUsername('kasirtoko')->first());
        $data = [];
        for ($i = 0; $i < 5; $i++) {
            $prod = $this->randomGetProd();
            $data[] = [
                "id" => $prod->id, // id produk
                "qty" => rand(1, 10), // jumlah beli
                "satuan" => $prod->harga->first()->jenis_satuan_id // satuan beli
            ];
        }
        $controller = $this->trxController
            ->trxProcessing(new Request([
                "items" => $data,
                "bayar" => 1000000
            ]));
    }
}
