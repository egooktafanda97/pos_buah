<?php

namespace App\Services;

use App\Models\Konversisatuan;
use App\Models\Produk;
use App\Repositories\KonversiSatuanRepository;

class KonversiSatuanService
{
    public function __construct(
        public KonversiSatuanRepository $konversiSatuanRepository
    ) {
    }

    public function create(array $data)
    {
        try {
            return $this->konversiSatuanRepository->validate($data)->create();
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    // konversi
    public static function konversi($produkId, $satuanBeli, $jumlah)
    {
        try {
            $satuanJualProduk = Produk::find($produkId)->satuan_jual_terkecil_id;
            $konversi = Konversisatuan::where(function ($query) use ($produkId, $satuanBeli, $satuanJualProduk) {
                return $query->where('produks_id', $produkId)
                    ->where("satuan_id", $satuanBeli)
                    ->where("satuan_konversi_id", $satuanJualProduk);
            })->first();
            if ($konversi) {
                return $jumlah * $konversi->nilai_konversi;
            }
            throw new \Exception("Konversi Satuan Tidak Ditemukan");
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
