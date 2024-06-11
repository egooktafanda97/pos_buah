<?php

namespace Database\Seeders;

use App\Models\Harga;
use App\Models\JenisProduk;
use App\Models\JenisSatuan;
use App\Models\Konversisatuan;
use App\Models\Produk as ModelsProduk;
use App\Models\Toko;
use App\Repositories\AssetBarang;
use App\Services\HargaService;
use App\Services\KonversiSatuanService;
use App\Services\ProdukService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProdukAsset extends Seeder
{
    public function __construct(
        public ProdukService $produkService,
        public HargaService $hargaService,
        public KonversiSatuanService $konversiSatuanService
    ) {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $asset = new AssetBarang();
            $getData = $asset->slice(10);



            JenisSatuan::create(['toko_id' => Toko::first()->id, 'nama' => "Box"]);
            JenisSatuan::create(['toko_id' => Toko::first()->id, 'nama' => "LUSIN"]);

            // satuan
            $satuan = collect($getData)->groupBy('Satuan');
            JenisSatuan::insert($satuan->keys()->map(function ($x) {
                return ['toko_id' => Toko::first()->id, 'nama' => $x];
            })->toArray());

            // jenis produk
            $jenisProd = collect($getData)->groupBy('Jenis');
            JenisProduk::insert($jenisProd->keys()->map(function ($x) {
                return ['toko_id' => Toko::first()->id, 'nama_jenis_produk' => $x];
            })->toArray());

            $barang = collect($getData)->map(function ($x) {
                return [
                    'toko_id' => Toko::first()->id,
                    'user_id' => 1,
                    'nama_produk' => $x['Nama Item'],
                    'deskripsi' => null,
                    'gambar' => 'default.jpg',
                    'jenis_produk_id' => JenisProduk::whereTokoId(1)->where('nama_jenis_produk', $x['Jenis'])->first()->id,
                    'supplier_id' => null,
                    'barcode' => $x['Barcode'],
                    'rak_id' => null,
                    'status_id' => 1,
                    'satuan_jual_terkecil_id' => JenisSatuan::whereTokoId(1)->where('nama', $x['Satuan'])->first()->id,
                    'harga' =>  $x['Harga Jual'],
                    'satuan' =>  JenisSatuan::whereTokoId(1)->where('nama', $x['Satuan'])->first()->id
                ];
            })->groupBy('nama_produk')->toArray();
            foreach ($barang as $key => $value) {
                $data = $value;
                unset($data[0]['satuan']);
                unset($data[0]['harga']);
                $produk = $this->produkService->create($data[0]);

                $this->hargaService->crete([
                    'user_id' => 1,
                    'toko_id' => Toko::first()->id,
                    'produks_id' => $produk->id,
                    'jenis_satuan_id' => $value[0]['satuan'],
                    'harga' => $value[0]['harga']
                ]);

                $this->hargaService->crete([
                    'user_id' => 1,
                    'toko_id' => Toko::first()->id,
                    'produks_id' => $produk->id,
                    'jenis_satuan_id' => JenisSatuan::where('nama', "Box")->first()->id,
                    'harga' => $value[0]['harga'] * 10
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}


// $this->konversiSatuanService->create([
//     'toko_id' => Toko::first()->id,
//     'produks_id' => $produk->id,
//     'satuan_id' => $value[0]['satuan'],
//     'satuan_konversi_id' => $value[0]['satuan'],
//     'nilai_konversi' => 1,
//     'status_id' => 1
// ]);